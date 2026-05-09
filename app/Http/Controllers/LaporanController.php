<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

        $fotoAwal         = $request->file('foto')->store('laporan', 'public');
        $trackingId       = 'SIGAP-' . Str::upper(Str::random(6));
        $idDaerahTerpilih = 1;

        try {
            $nilaiLatitude  = $request->input('latitude');
            $nilaiLongitude = $request->input('longitude');

            $responsApi = Http::withHeaders(['User-Agent' => 'SigapBdgApp/1.0 (student project)'])
                ->get("https://nominatim.openstreetmap.org/reverse?format=json&lat={$nilaiLatitude}&lon={$nilaiLongitude}");

            $dataPeta   = $responsApi->json();
            $alamatPeta = $dataPeta['address'] ?? [];

            $namaKecamatanApi = $alamatPeta['subdistrict']
                ?? $alamatPeta['town']
                ?? $alamatPeta['city_district']
                ?? $alamatPeta['suburb']
                ?? $alamatPeta['village']
                ?? null;

            if ($namaKecamatanApi) {
                $namaKecamatanApi = str_replace('Kecamatan ', '', $namaKecamatanApi);
                $namaKecamatanApi = str_replace('Kelurahan ', '', $namaKecamatanApi);
                $namaKecamatanApi = str_replace(' ', '', $namaKecamatanApi);

                $kecamatanDitemukan = Daerah::whereRaw("REPLACE(nama_daerah, ' ', '') LIKE ?", ['%' . $namaKecamatanApi . '%'])->first();

                if ($kecamatanDitemukan) {
                    $idDaerahTerpilih = $kecamatanDitemukan->id;
                }
            }
        } catch (\Exception $e) {
            $idDaerahTerpilih = 1;
        }

        $laporanBaru = LaporanInfrastruktur::create([
            'id_daerah'   => $idDaerahTerpilih,
            'tracking_id' => $trackingId,
            'latitude'    => $request->input('latitude'),
            'longitude'   => $request->input('longitude'),
            'foto_awal'   => $fotoAwal,
            'status'      => 'Menunggu',
        ]);

        \App\Services\LayananSimulasiAi::prosesAnalisis($laporanBaru->id, $fotoAwal);

        return back()->with('trackingBerhasil', $trackingId);
    }

    public function simpanKejahatan(Request $request)
    {
        $request->validate([
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        LaporanKejahatan::create([
            'id_daerah' => 1,
            'latitude'  => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        return response()->json(['sukses' => true]);
    }

    public function tampilkanFormLacak()
    {
        return view('laporan.lacak');
    }

    public function prosesCariLaporan(Request $request)
    {
        $request->validate([
            'tracking_id' => ['required', 'string'],
        ]);

        $kodeLacak   = Str::upper(trim($request->input('tracking_id')));
        $dataLaporan = LaporanInfrastruktur::where('tracking_id', $kodeLacak)->first();

        return view('laporan.lacak', compact('dataLaporan', 'kodeLacak'));
    }
}
