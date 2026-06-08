<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanTimeline extends Model
{
    protected $table = 'laporan_timeline';

    protected $guarded = [];

    public function laporanInfrastruktur()
    {
        return $this->belongsTo(LaporanInfrastruktur::class, 'laporan_infrastruktur_id');
    }
}
