<?php

namespace Database\Seeders;

use App\Models\Daerah;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKecamatan = [
            'Andir',
            'Antapani',
            'Arcamanik',
            'Astanaanyar',
            'Babakan Ciparay',
            'Bandung Kidul',
            'Bandung Kulon',
            'Bandung Wetan',
            'Batununggal',
            'Bojongloa Kaler',
            'Bojongloa Kidul',
            'Buahbatu',
            'Cibeunying Kaler',
            'Cibeunying Kidul',
            'Cibiru',
            'Cicendo',
            'Cidadap',
            'Cinambo',
            'Coblong',
            'Gedebage',
            'Kiaracondong',
            'Lengkong',
            'Mandalajati',
            'Panyileukan',
            'Rancasari',
            'Regol',
            'Sukajadi',
            'Sukasari',
            'Sumur Bandung',
            'Ujungberung',
            'Bojongsoang',
            'Dayeuhkolot',
            'Baleendah',
            'Margahayu',
            'Margaasih',
            'Cileunyi',
            'Cimenyan',
            'Cilengkrang',
            'Cimahi Selatan',
            'Cimahi Tengah',
            'Cimahi Utara'
        ];

        foreach ($daftarKecamatan as $namaKecamatan) {
            Daerah::create([
                'nama_daerah' => $namaKecamatan,
                'tingkat' => 'Kecamatan',
            ]);
        }
    }
}
