<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKejahatan extends Model
{
    protected $table = 'laporan_kejahatan';

    protected $guarded = [];

    public function daerah()
    {
        return $this->belongsTo(Daerah::class, 'id_daerah');
    }
}