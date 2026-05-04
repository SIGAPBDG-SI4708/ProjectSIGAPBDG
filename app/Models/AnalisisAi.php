<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisAi extends Model
{
    protected $table = 'analisis_ai';

    protected $guarded = [];

    public function laporanInfrastruktur()
    {
        return $this->belongsTo(LaporanInfrastruktur::class, 'id_laporan');
    }
}
