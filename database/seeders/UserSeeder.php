<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_daerah' => 1,
            'nama' => 'Admin Cicendo',
            'email' => 'admin.cicendo@sigapbdg.id',
            'password' => bcrypt('password123'),
            'role' => 'Admin Daerah',
        ]);

        User::create([
            'id_daerah' => null,
            'nama' => 'Super Admin SIGAP',
            'email' => 'superadmin@sigapbdg.id',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
        ]);
    }
}
