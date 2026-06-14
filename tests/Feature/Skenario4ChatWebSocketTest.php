<?php

/**
 * ============================================================
 * Skenario 4: Chat & WebSockets (Internal Admin)
 * ============================================================
 *
 * Test suite ini mencakup fitur chat antar admin, meliputi:
 * - Fetch daftar kontak chat (dengan pesan terakhir & unread count)
 * - Mengirim pesan chat dan tersimpan ke database
 * - Menandai semua pesan dari pengirim tertentu sebagai sudah dibaca
 *
 * Catatan WebSocket:
 * - Event broadcast (ChatMessageSent, ChatMessagesRead) di-fake
 *   menggunakan Event::fake() — tidak perlu server Reverb aktif.
 * - Notifikasi ChatMasukNotification juga di-fake dengan Notification::fake().
 *
 * Semua rute chat ada di bawah prefix /admin yang dilindungi
 * middleware 'auth', sehingga kita gunakan actingAs().
 */

use App\Events\ChatMessageSent;
use App\Events\ChatMessagesRead;
use App\Models\ChatMessage;
use App\Models\Daerah;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

// ─────────────────────────────────────────────────────────────
// SETUP: Fake events & notifications agar Reverb tidak disentuh
// ─────────────────────────────────────────────────────────────
beforeEach(function () {
    Event::fake();
    Notification::fake();
});

// ─────────────────────────────────────────────────────────────
// HELPER: Buat user admin dengan role tertentu
// ─────────────────────────────────────────────────────────────
function buatUserAdmin(Daerah $daerah, string $role = 'Super Admin'): User
{
    return User::create([
        'nama'        => fake()->name(),
        'email'       => fake()->unique()->safeEmail(),
        'password'    => Hash::make('password123'),
        'role'        => $role,
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);
}

// ─────────────────────────────────────────────────────────────
// TEST 1: Admin dapat fetch daftar kontak chat (JSON response)
// ─────────────────────────────────────────────────────────────
it('can fetch chat contacts', function () {
    $daerah = Daerah::factory()->create();
    $userA  = buatUserAdmin($daerah, 'Super Admin');
    $userB  = buatUserAdmin($daerah, 'Admin Daerah');

    // Buat satu pesan antara userA dan userB agar userB muncul sebagai kontak
    ChatMessage::create([
        'sender_id'   => $userA->id,
        'receiver_id' => $userB->id,
        'message'     => 'Halo, ada update laporan baru?',
        'is_read'     => false,
    ]);

    $response = $this->actingAs($userA)
        ->getJson('/admin/chat/contacts');

    $response->assertStatus(200);
    $response->assertJsonIsArray();

    // userB harus muncul dalam daftar kontak
    $response->assertJsonFragment([
        'id' => $userB->id,
    ]);

    // Response harus berupa array dengan setidaknya 1 kontak
    $contacts = $response->json();
    expect($contacts)->toHaveCount(1);
    expect($contacts[0]['id'])->toBe($userB->id);
});

// ─────────────────────────────────────────────────────────────
// TEST 2: Kontak yang belum ada riwayat chat tidak muncul
// ─────────────────────────────────────────────────────────────
it('returns empty contacts when no chat history exists', function () {
    $daerah = Daerah::factory()->create();
    $userA  = buatUserAdmin($daerah, 'Super Admin');
    buatUserAdmin($daerah, 'Admin Daerah'); // Tidak ada pesan apapun

    $response = $this->actingAs($userA)
        ->getJson('/admin/chat/contacts');

    $response->assertStatus(200);
    $response->assertExactJson([]); // Harus array kosong
});

// ─────────────────────────────────────────────────────────────
// TEST 3: Admin dapat mengirim pesan chat dan tersimpan ke DB
// ─────────────────────────────────────────────────────────────
it('can send chat message and save to database', function () {
    $daerah = Daerah::factory()->create();
    $pengirim  = buatUserAdmin($daerah, 'Super Admin');
    $penerima  = buatUserAdmin($daerah, 'Admin Daerah');

    $response = $this->actingAs($pengirim)
        ->postJson("/admin/chat/messages/{$penerima->id}", [
            'message' => 'Mohon segera proses laporan ID SIGAP-ABC123.',
        ]);

    $response->assertStatus(200);

    // Response harus mengandung data pesan yang baru dibuat
    $response->assertJsonFragment([
        'sender_id'   => $pengirim->id,
        'receiver_id' => $penerima->id,
        'message'     => 'Mohon segera proses laporan ID SIGAP-ABC123.',
        'is_read'     => false,
    ]);

    // Pesan harus tersimpan di database
    $this->assertDatabaseHas('chat_messages', [
        'sender_id'   => $pengirim->id,
        'receiver_id' => $penerima->id,
        'message'     => 'Mohon segera proses laporan ID SIGAP-ABC123.',
        'is_read'     => false,
    ]);

    // Event ChatMessageSent harus ter-dispatch (WebSocket broadcast)
    Event::assertDispatched(ChatMessageSent::class, function ($event) use ($pengirim, $penerima) {
        return $event->message->sender_id === $pengirim->id
            && $event->message->receiver_id === $penerima->id;
    });

    // Notifikasi harus terkirim ke penerima
    Notification::assertSentTo($penerima, \App\Notifications\ChatMasukNotification::class);
});

// ─────────────────────────────────────────────────────────────
// TEST 4: Pesan dengan konten kosong ditolak (validasi)
// ─────────────────────────────────────────────────────────────
it('rejects empty chat message', function () {
    $daerah   = Daerah::factory()->create();
    $pengirim = buatUserAdmin($daerah, 'Super Admin');
    $penerima = buatUserAdmin($daerah, 'Admin Daerah');

    $response = $this->actingAs($pengirim)
        ->postJson("/admin/chat/messages/{$penerima->id}", [
            'message' => '',
        ]);

    $response->assertStatus(422); // Unprocessable Entity
    $response->assertJsonValidationErrors(['message']);

    // Tidak ada pesan yang tersimpan
    $this->assertDatabaseEmpty('chat_messages');

    // Tidak ada event yang di-dispatch
    Event::assertNotDispatched(ChatMessageSent::class);
});

// ─────────────────────────────────────────────────────────────
// TEST 5: Admin dapat mengambil riwayat pesan dengan user lain
// ─────────────────────────────────────────────────────────────
it('can fetch message history between two users', function () {
    $daerah   = Daerah::factory()->create();
    $userA    = buatUserAdmin($daerah, 'Super Admin');
    $userB    = buatUserAdmin($daerah, 'Admin Daerah');
    $userC    = buatUserAdmin($daerah, 'Admin Daerah'); // Noise: percakapan tak terkait

    // Pesan antara A ↔ B
    ChatMessage::create([
        'sender_id'   => $userA->id,
        'receiver_id' => $userB->id,
        'message'     => 'Pesan dari A ke B',
        'is_read'     => true,
    ]);
    ChatMessage::create([
        'sender_id'   => $userB->id,
        'receiver_id' => $userA->id,
        'message'     => 'Balasan dari B ke A',
        'is_read'     => false,
    ]);

    // Pesan noise: A ↔ C (tidak boleh muncul di percakapan A ↔ B)
    ChatMessage::create([
        'sender_id'   => $userA->id,
        'receiver_id' => $userC->id,
        'message'     => 'Pesan A ke C (jangan muncul)',
        'is_read'     => false,
    ]);

    $response = $this->actingAs($userA)
        ->getJson("/admin/chat/messages/{$userB->id}");

    $response->assertStatus(200);

    $messages = $response->json();

    // Harus ada tepat 2 pesan (antara A dan B saja)
    expect($messages)->toHaveCount(2);

    // Pesan dari C tidak boleh muncul
    $allMessages = collect($messages)->pluck('message')->all();
    expect($allMessages)->not->toContain('Pesan A ke C (jangan muncul)');
});

// ─────────────────────────────────────────────────────────────
// TEST 6: Admin dapat menandai pesan sebagai sudah dibaca
// ─────────────────────────────────────────────────────────────
it('can mark messages as read', function () {
    $daerah   = Daerah::factory()->create();
    $pembaca  = buatUserAdmin($daerah, 'Super Admin');
    $pengirim = buatUserAdmin($daerah, 'Admin Daerah');

    // Buat 3 pesan yang belum dibaca dari pengirim ke pembaca
    ChatMessage::create([
        'sender_id'   => $pengirim->id,
        'receiver_id' => $pembaca->id,
        'message'     => 'Pesan unread 1',
        'is_read'     => false,
    ]);
    ChatMessage::create([
        'sender_id'   => $pengirim->id,
        'receiver_id' => $pembaca->id,
        'message'     => 'Pesan unread 2',
        'is_read'     => false,
    ]);
    ChatMessage::create([
        'sender_id'   => $pengirim->id,
        'receiver_id' => $pembaca->id,
        'message'     => 'Pesan unread 3',
        'is_read'     => false,
    ]);

    $response = $this->actingAs($pembaca)
        ->patchJson("/admin/chat/messages/{$pengirim->id}/read");

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    // Semua 3 pesan harus berubah menjadi is_read = true
    $unreadCount = ChatMessage::where('sender_id', $pengirim->id)
        ->where('receiver_id', $pembaca->id)
        ->where('is_read', false)
        ->count();

    expect($unreadCount)->toBe(0);

    // Semua pesan harus sudah dibaca di database
    $this->assertDatabaseMissing('chat_messages', [
        'sender_id'   => $pengirim->id,
        'receiver_id' => $pembaca->id,
        'is_read'     => false,
    ]);

    // Event ChatMessagesRead harus ter-dispatch
    Event::assertDispatched(ChatMessagesRead::class);
});

// ─────────────────────────────────────────────────────────────
// TEST 7: markAsRead tidak dispatch event jika tidak ada pesan unread
// ─────────────────────────────────────────────────────────────
it('does not dispatch read event when no unread messages exist', function () {
    $daerah   = Daerah::factory()->create();
    $pembaca  = buatUserAdmin($daerah, 'Super Admin');
    $pengirim = buatUserAdmin($daerah, 'Admin Daerah');

    // Semua pesan sudah dalam kondisi is_read = true
    ChatMessage::create([
        'sender_id'   => $pengirim->id,
        'receiver_id' => $pembaca->id,
        'message'     => 'Pesan yang sudah dibaca',
        'is_read'     => true,
    ]);

    $response = $this->actingAs($pembaca)
        ->patchJson("/admin/chat/messages/{$pengirim->id}/read");

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);

    // Event TIDAK boleh di-dispatch karena tidak ada yang diupdate
    Event::assertNotDispatched(ChatMessagesRead::class);
});

// ─────────────────────────────────────────────────────────────
// TEST 8: Endpoint chat tidak bisa diakses tanpa login (guest)
// ─────────────────────────────────────────────────────────────
it('blocks guest from accessing chat endpoints', function () {
    // GET contacts tanpa auth
    $this->getJson('/admin/chat/contacts')
        ->assertStatus(401);
});
