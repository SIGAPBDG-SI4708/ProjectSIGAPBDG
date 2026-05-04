<?php

namespace App\Services;

use App\Models\AnalisisAi;

class LayananSimulasiAi
{
    public static function prosesAnalisis($idLaporan)
    {
        $angkaAcak  = rand(1, 10);
        $adaSpam    = $angkaAcak === 1;

        if ($adaSpam) {
            AnalisisAi::create([
                'id_laporan' => $idLaporan,
                'is_spam'    => true,
            ]);

            return;
        }

        $daftarJenisKerusakan = ['Berlubang', 'Retak', 'Aspal Mengelupas'];
        $daftarKeparahan      = ['Ringan', 'Sedang', 'Berat'];

        $kerusakanAcak  = $daftarJenisKerusakan[array_rand($daftarJenisKerusakan)];
        $keparahanAcak  = $daftarKeparahan[array_rand($daftarKeparahan)];

        if ($keparahanAcak === 'Ringan') {
            $estimasiBiaya = 500000;
        } elseif ($keparahanAcak === 'Sedang') {
            $estimasiBiaya = 1500000;
        } else {
            $estimasiBiaya = 5000000;
        }

        AnalisisAi::create([
            'id_laporan'       => $idLaporan,
            'is_spam'          => false,
            'jenis_kerusakan'  => $kerusakanAcak,
            'tingkat_keparahan' => $keparahanAcak,
            'estimasi_biaya'   => $estimasiBiaya,
        ]);
    }
}