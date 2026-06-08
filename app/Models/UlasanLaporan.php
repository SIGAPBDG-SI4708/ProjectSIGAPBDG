<?php

// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanLaporan extends Model
{
    protected $table = 'ulasan_laporan';

    protected $guarded = [];

    public function laporanInfrastruktur()
    {
        return $this->belongsTo(LaporanInfrastruktur::class, 'laporan_infrastruktur_id');
    }
}

// =========================================================
