<?php

/**
 * ============================================================
 * Skenario 3: Manajemen Laporan & Dana (Admin)
 * ============================================================
 *
 * Test suite ini mencakup alur kerja admin, meliputi:
 * - Admin Daerah mengubah status laporan ke 'Diproses'
 * - Admin Daerah mengirim pengajuan dana untuk laporan
 * - Super Admin menyetujui pengajuan dana
 * - Super Admin menolak pengajuan dana
 *
 * Catatan: Semua rute admin dilindungi middleware 'auth'.
 * Kita gunakan actingAs() untuk berpura-pura sudah login.
 */

use App\Models\AnalisisAi;
use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanTimeline;
use App\Models\PengajuanDana;
use App\Models\PoinKontribusiDaerah;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// ─────────────────────────────────────────────────────────────
// SETUP: Siapkan fake disk untuk upload foto selesai
// ─────────────────────────────────────────────────────────────
beforeEach(function () {
    Storage::fake('public');
});

// ─────────────────────────────────────────────────────────────
// HELPERS: Membuat data fixture yang reusable
// ─────────────────────────────────────────────────────────────

/** Buat Admin Daerah dengan daerah spesifik */
function buatAdminDaerah(Daerah $daerah): User
{
    return User::create([
        'nama'        => 'Admin Daerah Test',
        'email'       => 'admin-daerah-' . uniqid() . '@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Admin Daerah',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);
}

/** Buat Super Admin */
function buatSuperAdmin(Daerah $daerah): User
{
    return User::create([
        'nama'        => 'Super Admin Test',
        'email'       => 'super-admin-' . uniqid() . '@sigap.test',
        'password'    => Hash::make('password123'),
        'role'        => 'Super Admin',
        'id_daerah'   => $daerah->id,
        'status_akun' => 'aktif',
    ]);
}

/** Buat laporan dengan status Menunggu */
function buatLaporan(Daerah $daerah): LaporanInfrastruktur
{
    return LaporanInfrastruktur::create([
        'id_daerah'   => $daerah->id,
        'tracking_id' => 'SIGAP-' . strtoupper(uniqid()),
        'latitude'    => -6.9,
        'longitude'   => 107.6,
        'foto_awal'   => 'laporan/dummy.jpg',
        'hash_foto'   => md5(uniqid()),
        'status'      => 'Menunggu',
    ]);
}

// ─────────────────────────────────────────────────────────────
// TEST 1: Admin Daerah dapat mengubah status laporan ke 'Proses'
// ─────────────────────────────────────────────────────────────
it('allows admin daerah to change laporan status to diproses', function () {
    $daerah      = Daerah::factory()->create();
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    $response = $this->actingAs($adminDaerah)
        ->patch(route('admin.laporan.perbarui', $laporan->id), [
            'status' => 'Proses',
        ]);

    // Harus redirect ke detail laporan dengan session sukses
    $response->assertRedirect(route('admin.laporan.detail', $laporan->id));
    $response->assertSessionHas('sukses');

    // Status laporan harus berubah di database
    $this->assertDatabaseHas('laporan_infrastruktur', [
        'id'     => $laporan->id,
        'status' => 'Proses',
    ]);

    // Timeline harus tercatat
    $this->assertDatabaseHas('laporan_timeline', [
        'laporan_infrastruktur_id' => $laporan->id,
        'status'                   => 'Proses',
    ]);

    // Poin 'Respon Cepat' harus diberikan
    $this->assertDatabaseHas('poin_kontribusi_daerah', [
        'id_daerah'                => $daerah->id,
        'laporan_infrastruktur_id' => $laporan->id,
        'poin'                     => 20,
        'kategori'                 => 'Respon Cepat',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 2: Admin Daerah dapat mengubah status laporan ke 'Selesai'
//         dengan upload foto bukti pengerjaan
// ─────────────────────────────────────────────────────────────
it('allows admin daerah to change laporan status to selesai with photo', function () {
    $daerah      = Daerah::factory()->create();
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);
    $laporan->update(['status' => 'Proses']); // Set ke Proses dulu

    $fotoBukti = UploadedFile::fake()->image('bukti-selesai.jpg');

    $response = $this->actingAs($adminDaerah)
        ->patch(route('admin.laporan.perbarui', $laporan->id), [
            'status'      => 'Selesai',
            'foto_selesai' => $fotoBukti,
        ]);

    $response->assertRedirect(route('admin.laporan.detail', $laporan->id));
    $response->assertSessionHas('sukses');

    // Status harus Selesai dan foto_selesai terisi
    $laporanDiperbarui = $laporan->fresh();
    expect($laporanDiperbarui->status)->toBe('Selesai');
    expect($laporanDiperbarui->foto_selesai)->not->toBeNull();

    // Poin 'Penyelesaian' harus diberikan
    $this->assertDatabaseHas('poin_kontribusi_daerah', [
        'laporan_infrastruktur_id' => $laporan->id,
        'poin'                     => 50,
        'kategori'                 => 'Penyelesaian',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 3: Admin Daerah tidak bisa mengubah laporan milik daerah lain
// ─────────────────────────────────────────────────────────────
it('prevents admin daerah from updating laporan of another daerah', function () {
    $daerahA     = Daerah::factory()->create(['nama_daerah' => 'Daerah A']);
    $daerahB     = Daerah::factory()->create(['nama_daerah' => 'Daerah B']);
    $adminDaerahA = buatAdminDaerah($daerahA);
    $laporanDaerahB = buatLaporan($daerahB); // Laporan milik Daerah B

    // Admin Daerah A mencoba mengubah laporan Daerah B → harus 404
    $response = $this->actingAs($adminDaerahA)
        ->patch(route('admin.laporan.perbarui', $laporanDaerahB->id), [
            'status' => 'Proses',
        ]);

    $response->assertStatus(404);

    // Status laporan harus tetap 'Menunggu'
    $this->assertDatabaseHas('laporan_infrastruktur', [
        'id'     => $laporanDaerahB->id,
        'status' => 'Menunggu',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 4: Admin Daerah dapat mengirim pengajuan dana
// ─────────────────────────────────────────────────────────────
it('allows admin daerah to submit pengajuan dana', function () {
    $daerah      = Daerah::factory()->create();
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    // Buat analisis AI agar estimasi_biaya tersedia
    AnalisisAi::create([
        'id_laporan'        => $laporan->id,
        'is_spam'           => false,
        'jenis_kerusakan'   => 'Jalan Berlubang',
        'tingkat_keparahan' => 'Sedang',
        'estimasi_biaya'    => 5000000,
    ]);

    $response = $this->actingAs($adminDaerah)
        ->post(route('admin.pengajuan.simpan'), [
            'id_laporan'       => $laporan->id,
            'nominal_diajukan' => 4000000, // Di bawah estimasi AI → status normal
        ]);

    // Harus redirect back dengan flash success
    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Pengajuan harus tersimpan di database
    $this->assertDatabaseHas('pengajuan_dana', [
        'id_laporan'      => $laporan->id,
        'id_user'         => $adminDaerah->id,
        'nominal_diajukan' => 4000000,
        'status_approval' => 'Menunggu',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 5: Pengajuan dana melebihi estimasi AI masuk 'antrean khusus'
// ─────────────────────────────────────────────────────────────
it('flags pengajuan dana that exceeds ai estimate as special queue', function () {
    $daerah      = Daerah::factory()->create();
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    AnalisisAi::create([
        'id_laporan'        => $laporan->id,
        'is_spam'           => false,
        'jenis_kerusakan'   => 'Jembatan Rusak',
        'tingkat_keparahan' => 'Berat',
        'estimasi_biaya'    => 5000000,
    ]);

    $response = $this->actingAs($adminDaerah)
        ->post(route('admin.pengajuan.simpan'), [
            'id_laporan'       => $laporan->id,
            'nominal_diajukan' => 9000000, // MELEBIHI estimasi AI → warning
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('warning');

    // Pengajuan tetap tersimpan walau melebihi estimasi
    $this->assertDatabaseHas('pengajuan_dana', [
        'id_laporan'       => $laporan->id,
        'nominal_diajukan' => 9000000,
        'status_approval'  => 'Menunggu',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 6: Super Admin dapat menyetujui pengajuan dana
// ─────────────────────────────────────────────────────────────
it('allows super admin to approve pengajuan dana', function () {
    $daerah      = Daerah::factory()->create();
    $superAdmin  = buatSuperAdmin($daerah);
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    $pengajuan = PengajuanDana::create([
        'id_laporan'       => $laporan->id,
        'id_user'          => $adminDaerah->id,
        'nominal_diajukan' => 3000000,
        'status_approval'  => 'Menunggu',
        'waktu_pengajuan'  => now(),
    ]);

    $response = $this->actingAs($superAdmin)
        ->post(route('admin.pengajuan.proses-audit', $pengajuan->id), [
            'keputusan'        => 'Disetujui',
            'catatan_approval' => 'Dana disetujui setelah verifikasi lapangan.',
        ]);

    // Harus redirect ke halaman keuangan dengan pesan sukses
    $response->assertRedirect(route('admin.keuangan.indeks'));
    $response->assertSessionHas('sukses');

    // Status pengajuan harus berubah ke Disetujui
    $this->assertDatabaseHas('pengajuan_dana', [
        'id'               => $pengajuan->id,
        'status_approval'  => 'Disetujui',
        'catatan_approval' => 'Dana disetujui setelah verifikasi lapangan.',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 7: Super Admin dapat menolak pengajuan dana
// ─────────────────────────────────────────────────────────────
it('allows super admin to reject pengajuan dana', function () {
    $daerah      = Daerah::factory()->create();
    $superAdmin  = buatSuperAdmin($daerah);
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    $pengajuan = PengajuanDana::create([
        'id_laporan'       => $laporan->id,
        'id_user'          => $adminDaerah->id,
        'nominal_diajukan' => 15000000,
        'status_approval'  => 'Menunggu',
        'waktu_pengajuan'  => now(),
    ]);

    $response = $this->actingAs($superAdmin)
        ->post(route('admin.pengajuan.proses-audit', $pengajuan->id), [
            'keputusan'        => 'Ditolak',
            'catatan_approval' => 'Nominal terlalu besar, tidak sesuai dengan kondisi lapangan.',
        ]);

    $response->assertRedirect(route('admin.keuangan.indeks'));
    $response->assertSessionHas('sukses');

    // Status pengajuan harus berubah ke Ditolak
    $this->assertDatabaseHas('pengajuan_dana', [
        'id'               => $pengajuan->id,
        'status_approval'  => 'Ditolak',
        'catatan_approval' => 'Nominal terlalu besar, tidak sesuai dengan kondisi lapangan.',
    ]);
});

// ─────────────────────────────────────────────────────────────
// TEST 8: Admin Daerah tidak bisa mengakses endpoint persetujuan
//         (hanya Super Admin yang boleh)
// ─────────────────────────────────────────────────────────────
it('forbids admin daerah from approving pengajuan dana', function () {
    $daerah      = Daerah::factory()->create();
    $adminDaerah = buatAdminDaerah($daerah);
    $laporan     = buatLaporan($daerah);

    $pengajuan = PengajuanDana::create([
        'id_laporan'       => $laporan->id,
        'id_user'          => $adminDaerah->id,
        'nominal_diajukan' => 5000000,
        'status_approval'  => 'Menunggu',
        'waktu_pengajuan'  => now(),
    ]);

    // Admin Daerah mencoba menyetujui → harus 403
    $response = $this->actingAs($adminDaerah)
        ->post(route('admin.pengajuan.proses-audit', $pengajuan->id), [
            'keputusan' => 'Disetujui',
        ]);

    $response->assertStatus(403);

    // Status pengajuan harus tetap Menunggu
    $this->assertDatabaseHas('pengajuan_dana', [
        'id'              => $pengajuan->id,
        'status_approval' => 'Menunggu',
    ]);
});
