<?php

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
