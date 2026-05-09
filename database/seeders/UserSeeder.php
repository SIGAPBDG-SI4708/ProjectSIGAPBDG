<?php

namespace Database\Seeders;

use App\Models\Daerah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_daerah' => null,
            'nama'      => 'Super Admin SIGAP',
            'email'     => 'superadmin@sigapbdg.id',
            'password'  => bcrypt('password123'),
            'role'      => 'Super Admin',
        ]);

        $semuaDaerah = Daerah::all();

        foreach ($semuaDaerah as $daerah) {
            $slugNama = Str::slug($daerah->nama_daerah, '.');
            $emailAdmin = 'admin.' . $slugNama . '@sigapbdg.id';
            $namaAdmin = 'Admin ' . $daerah->nama_daerah;

            User::create([
                'id_daerah' => $daerah->id,
                'nama'      => $namaAdmin,
                'email'     => $emailAdmin,
                'password'  => bcrypt('password123'),
                'role'      => 'Admin Daerah',
            ]);
        }
    }
}
