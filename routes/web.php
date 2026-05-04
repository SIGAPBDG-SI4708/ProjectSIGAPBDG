<?php

use App\Http\Controllers\OtentikasiController;
use Illuminate\Support\Facades\Route;

// [SIGAP-17] Routing Awal - Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('beranda');

// SIGAP-23 Routing Pelaporan Kejahatan dan Lacak
Route::get('/lapor', [LaporanController::class, 'tampilkanFormLapor'])->name('lapor');
Route::post('/lapor', [LaporanController::class, 'prosesSimpanLaporan'])->name('proses.laporan');

Route::get('/lacak', [LaporanController::class, 'tampilkanFormLacak'])->name('lacak');
Route::post('/lacak', [LaporanController::class, 'prosesCariLaporan'])->name('proses.lacak');

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