<?php

use App\Http\Controllers\OtentikasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengajuanDanaController;

// [SIGAP-17] Routing Awal - Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('beranda');

// SIGAP-23 Routing Pelaporan Kejahatan dan Lacak
Route::get('/lapor', [LaporanController::class, 'tampilkanFormLapor'])->name('lapor');
Route::post('/lapor', [LaporanController::class, 'prosesSimpanLaporan'])->name('proses.laporan');

Route::get('/lacak', [LaporanController::class, 'tampilkanFormLacak'])->name('lacak');
Route::post('/lacak', [LaporanController::class, 'prosesCariLaporan'])->name('proses.lacak');
// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================
Route::post('/lacak/{id}/ulasan', [LaporanController::class, 'simpanUlasan'])->name('lacak.ulasan');
// =========================================================

Route::post('/lapor-kejahatan', [LaporanController::class, 'simpanKejahatan'])->name('lapor.kejahatan');

// [SIGAP-17] Routing Autentikasi (Login & Register)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/masuk', [OtentikasiController::class, 'tampilkanMasuk'])->name('masuk');
    Route::post('/masuk', [OtentikasiController::class, 'prosesMasuk'])->name('proses.masuk');
    
    // Register (Daftar)
    Route::get('/daftar', [OtentikasiController::class, 'tampilkanDaftar'])->name('daftar');
    Route::post('/daftar', [OtentikasiController::class, 'prosesDaftar'])->name('proses.daftar');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'tampilkanBeranda'])->name('beranda');
    Route::get('/laporan', [AdminController::class, 'tampilkanDaftarLaporan'])->name('laporan.indeks');
    Route::get('/laporan/{id}', [AdminController::class, 'tampilkanDetailLaporan'])->name('laporan.detail');
    // =========================================================
    // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
    // =========================================================
    Route::patch('/laporan/{id}', [\App\Http\Controllers\AuditFisikController::class, 'perbaruiStatusLaporan'])->name('laporan.perbarui');
    // =========================================================
    Route::get('/keuangan', [PengajuanDanaController::class, 'tampilkanDaftarPengajuan'])->name('keuangan.indeks');
    Route::post('/pengajuan', [PengajuanDanaController::class, 'simpanPengajuan'])->name('pengajuan.simpan');
    Route::post('/pengajuan/{id}/proses', [PengajuanDanaController::class, 'prosesPersetujuan'])->name('pengajuan.proses');
    Route::get('/peta', [AdminController::class, 'tampilkanPeta'])->name('peta.indeks');
    Route::get('/api/titik-kejahatan', [AdminController::class, 'ambilDataTitikKejahatan'])->name('api.titik-kejahatan');
    Route::post('/keluar', [OtentikasiController::class, 'keluar'])->name('keluar');
});

Route::post('/keluar', [OtentikasiController::class, 'keluar'])->name('keluar')->middleware('auth');