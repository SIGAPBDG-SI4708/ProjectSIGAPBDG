<?php

namespace Database\Seeders;

use App\Models\Daerah;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
{
    public function run(): void
    {
        Daerah::create([
            'nama_daerah' => 'Cicendo',
            'tingkat' => 'Kecamatan',
        ]);

        Daerah::create([
            'nama_daerah' => 'Coblong',
            'tingkat' => 'Kecamatan',
        ]);
    }
}
