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

        // =========================================================
        // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
        // =========================================================
        \App\Models\LaporanTimeline::create([
            'laporan_infrastruktur_id' => $laporanBaru->id,
            'status' => 'Menunggu',
            'deskripsi' => 'Laporan berhasil dibuat oleh warga dengan nomor tracking ID: ' . $trackingId . ' dan sedang menunggu verifikasi oleh Admin.',
        ]);
        // =========================================================

        // =========================================================
        // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
        // =========================================================
        \App\Models\PoinKontribusiDaerah::create([
            'id_daerah' => $laporanBaru->id_daerah,
            'laporan_infrastruktur_id' => $laporanBaru->id,
            'poin' => 10,
            'kategori' => 'Laporan Baru',
            'deskripsi' => 'Apresiasi partisipasi warga melaporkan infrastruktur rusak dengan ID: ' . $trackingId,
        ]);
        // =========================================================

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

    public function prosesCariLaporan(Request $request)
    {
        $request->validate([
            'tracking_id' => ['required', 'string'],
        ]);

        $kodeLacak    = Str::upper(trim($request->input('tracking_id')));
        $dataLaporan  = LaporanInfrastruktur::where('tracking_id', $kodeLacak)->first();

        return view('laporan.lacak', compact('dataLaporan', 'kodeLacak'));
    }

    // =========================================================
    // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
    // =========================================================
    public function simpanUlasan(Request $request, $id)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'ulasan' => ['nullable', 'string', 'max:500'],
        ]);

        $dataLaporan = LaporanInfrastruktur::findOrFail($id);

        if ($dataLaporan->status !== 'Selesai') {
            return back()->with('error', 'Laporan belum selesai.');
        }

        $ratingInput = (int) $request->input('rating');
        $poinUlasan = $ratingInput * 10;

        \App\Models\UlasanLaporan::create([
            'laporan_infrastruktur_id' => $id,
            'rating'     => $ratingInput,
            'ulasan'     => $request->input('ulasan'),
        ]);

        // =========================================================
        // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
        // =========================================================
        \App\Models\PoinKontribusiDaerah::create([
            'id_daerah' => $dataLaporan->id_daerah,
            'laporan_infrastruktur_id' => $dataLaporan->id,
            'poin' => $poinUlasan,
            'kategori' => 'Ulasan Warga',
            'deskripsi' => 'Apresiasi ulasan warga dengan rating ' . $ratingInput . ' bintang.',
        ]);
        // =========================================================

        return redirect()->route('lacak')
            ->with('sukses_ulasan_tracking_id', $dataLaporan->tracking_id)
            ->with('sukses_ulasan', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
    // =========================================================
}
