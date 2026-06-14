<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinKontribusiDaerah extends Model
{
    protected $table = 'poin_kontribusi_daerah';

    protected $guarded = [];

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'id_daerah');
    }

    public function laporanInfrastruktur()
    {
        return $this->belongsTo(LaporanInfrastruktur::class, 'laporan_infrastruktur_id');
    }
}

