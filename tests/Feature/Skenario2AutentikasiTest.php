<?php

/**
 * ============================================================
 * Skenario 2: Autentikasi & Otorisasi
 * ============================================================
 *
 * Test suite ini mencakup alur login admin, termasuk:
 * - Login berhasil dengan kredensial valid + status akun aktif
 * - Login ditolak jika status_akun = 'menunggu' (pending approval)
 * - Login ditolak jika status_akun = 'ditolak'
 * - Login ditolak jika kredensial salah
 * - Rute admin tidak bisa diakses tanpa login (guest redirect)
 */

use App\Models\Daerah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ─────────────────────────────────────────────────────────────
// TEST 1: Admin dengan kredensial valid dan status aktif berhasil login
// ─────────────────────────────────────────────────────────────
it('allows admin to login with valid credentials', function () {
    $daerah = Daerah::factory()->create();

    $admin = User::create([
        'nama'        => 'Admin Test',
        'email'       => 'admin@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Super Admin',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);

    $response = $this->post(route('proses.masuk'), [
        'email'    => 'admin@sigap.test',
        'password' => 'password123',
    ]);

    // Harus redirect ke dashboard admin
    $response->assertRedirect(route('admin.beranda'));

    // Harus benar-benar terauthentikasi sebagai admin tersebut
    $this->assertAuthenticatedAs($admin);
});

// ─────────────────────────────────────────────────────────────
// TEST 2: Login ditolak jika status_akun = 'menunggu'
// Logika blokir ada di OtentikasiController::prosesMasuk()
// ─────────────────────────────────────────────────────────────
it('blocks login if user status is menunggu', function () {
    $daerah = Daerah::factory()->create();

    User::create([
        'nama'        => 'Admin Pending',
        'email'       => 'pending@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Admin Daerah',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'menunggu',
    ]);

    $response = $this->post(route('proses.masuk'), [
        'email'    => 'pending@sigap.test',
        'password' => 'password123',
    ]);

    // Harus redirect kembali ke form login dengan pesan error
    $response->assertRedirect();
    $response->assertSessionHasErrors('email');

    // Pesan error harus menyebutkan "belum disetujui"
    $errors = session('errors');
    expect($errors->first('email'))->toContain('belum disetujui');

    // User harus tetap dalam kondisi guest (tidak terlogin)
    $this->assertGuest();
});

// ─────────────────────────────────────────────────────────────
// TEST 3: Login ditolak jika status_akun = 'ditolak'
// ─────────────────────────────────────────────────────────────
it('blocks login if user status is ditolak', function () {
    $daerah = Daerah::factory()->create();

    User::create([
        'nama'        => 'Admin Ditolak',
        'email'       => 'ditolak@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Admin Daerah',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'ditolak',
    ]);

    $response = $this->post(route('proses.masuk'), [
        'email'    => 'ditolak@sigap.test',
        'password' => 'password123',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('email');

    $errors = session('errors');
    expect($errors->first('email'))->toContain('ditolak');

    $this->assertGuest();
});

// ─────────────────────────────────────────────────────────────
// TEST 4: Login ditolak jika password salah
// ─────────────────────────────────────────────────────────────
it('rejects login with wrong password', function () {
    $daerah = Daerah::factory()->create();

    User::create([
        'nama'        => 'Admin Valid',
        'email'       => 'valid@sigap.test',
        'password'    => Hash::make('password-benar'),
        'role'        => 'Super Admin',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);

    $response = $this->post(route('proses.masuk'), [
        'email'    => 'valid@sigap.test',
        'password' => 'password-salah',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('email');

    $this->assertGuest();
});

// ─────────────────────────────────────────────────────────────
// TEST 5: Rute admin tidak bisa diakses oleh guest (belum login)
// ─────────────────────────────────────────────────────────────
it('redirects guest away from protected admin routes', function () {
    $response = $this->get(route('admin.beranda'));

    // Harus return 302 redirect (bukan 200) karena middleware auth aktif
    $response->assertStatus(302);

    // User harus tetap dalam kondisi guest
    $this->assertGuest();
});

// ─────────────────────────────────────────────────────────────
// TEST 6: Admin yang sudah login bisa mengakses dashboard
// ─────────────────────────────────────────────────────────────
it('allows authenticated admin to access dashboard', function () {
    $daerah = Daerah::factory()->create();

    $admin = User::create([
        'nama'        => 'Admin Dashboard',
        'email'       => 'dashboard@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Super Admin',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.beranda'));

    $response->assertStatus(200);
});
