<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daerah extends Model
{
    use HasFactory;

    protected $table = 'daerah';

    protected $guarded = [];

    public function pengguna()
    {
        return $this->hasMany(User::class, 'id_daerah');
    }

    public function laporanInfrastruktur()
    {
        return $this->hasMany(LaporanInfrastruktur::class, 'id_daerah');
    }

    public function laporanKejahatan()
    {
        return $this->hasMany(LaporanKejahatan::class, 'id_daerah');
    }
        public function poinKontribusi()
    {
        return $this->hasMany(PoinKontribusiDaerah::class, 'id_daerah');
    }
}