<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanInfrastruktur extends Model
{
    protected $table = 'laporan_infrastruktur';

    protected $guarded = [];

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'id_daerah');
    }

    public function analisisAi()
    {
        return $this->hasOne(AnalisisAi::class, 'id_laporan');
    }

    public function pengajuanDana()
    {
        return $this->hasMany(PengajuanDana::class, 'id_laporan');
    }

    public function ulasanLaporan()
    {
        return $this->hasMany(UlasanLaporan::class, 'laporan_infrastruktur_id');
    }
}
