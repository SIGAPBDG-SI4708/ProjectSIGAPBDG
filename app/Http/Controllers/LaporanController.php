<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    public function tampilkanFormLapor()
    {
        return view('laporan.buat');
    }

    public function prosesSimpanLaporan(Request $request)
    {
        $request->validate([
            'foto'      => ['required', 'file', 'image', 'max:5120'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $fotoAwal  = $request->file('foto')->store('laporan', 'public');
        $trackingId = 'SIGAP-' . Str::upper(Str::random(6));
        $idDaerahAcak = Daerah::inRandomOrder()->value('id');

        $laporanBaru = LaporanInfrastruktur::create([
            'id_daerah'   => $idDaerahAcak,
            'tracking_id' => $trackingId,
            'latitude'    => $request->input('latitude'),
            'longitude'   => $request->input('longitude'),
            'foto_awal'   => $fotoAwal,
            'status'      => 'Menunggu',
        ]);

        \App\Services\LayananSimulasiAi::prosesAnalisis($laporanBaru->id);

        return back()->with('trackingBerhasil', $trackingId);
    }

    public function simpanKejahatan(Request $request)
    {
        $request->validate([
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $idDaerahAcak = Daerah::inRandomOrder()->value('id');

        LaporanKejahatan::create([
            'id_daerah' => $idDaerahAcak,
            'latitude'  => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        return response()->json(['sukses' => true]);
    }

    public function tampilkanFormLacak()
    {
        return view('laporan.lacak');
    }

}
