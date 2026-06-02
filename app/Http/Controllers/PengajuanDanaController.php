<?php

namespace App\Http\Controllers;

use App\Models\LaporanInfrastruktur;
use App\Models\PengajuanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanDanaController extends Controller
{
    public function simpanPengajuan(Request $request)
    {
        $request->validate([
            'id_laporan'       => ['required', 'integer', 'exists:laporan_infrastruktur,id'],
            'nominal_diajukan' => ['required', 'numeric', 'min:1'],
        ]);

        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role !== 'Admin Daerah') {
            abort(403);
        }

        PengajuanDana::create([
            'id_laporan'       => $request->input('id_laporan'),
            'id_user'          => $penggunaAktif->id,
            'nominal_diajukan' => $request->input('nominal_diajukan'),
            'status_approval'  => 'Menunggu',
            'waktu_pengajuan'  => now(),
        ]);

        $dataLaporan      = LaporanInfrastruktur::with('analisisAi')->find($request->input('id_laporan'));
        $nominalDiajukan  = (float) $request->input('nominal_diajukan');
        $estimasiBiayaAi  = $dataLaporan->analisisAi ? (float) $dataLaporan->analisisAi->estimasi_biaya : 0;

        if ($nominalDiajukan > $estimasiBiayaAi) {
            return back()->with('warning', 'Pengajuan masuk antrean khusus! Nominal melebihi estimasi AI dan butuh tinjauan ketat Super Admin.');
        }

        return back()->with('success', 'Pengajuan dana berhasil dikirim.');
    }

    public function tampilkanDaftarPengajuan()
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403);
        }

        $daftarPengajuan = PengajuanDana::with(['laporanInfrastruktur.daerah', 'pengguna'])
            ->latest()
            ->paginate(20);

        $danaDisetujui = PengajuanDana::where('status_approval', 'Disetujui')->sum('nominal_diajukan');
        $danaDitolak = PengajuanDana::where('status_approval', 'Ditolak')->sum('nominal_diajukan');
        $danaMenunggu = PengajuanDana::where('status_approval', 'Menunggu')->sum('nominal_diajukan');

        return view('admin.keuangan.indeks', compact('daftarPengajuan', 'danaDisetujui', 'danaDitolak', 'danaMenunggu'));
    }

    public function prosesPersetujuan(Request $request, $id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403);
        }

        $request->validate([
            'keputusan' => ['required', 'in:Disetujui,Ditolak'],
        ]);

        $dataPengajuan = PengajuanDana::findOrFail($id);
        $keputusanBaru = $request->input('keputusan');

        $dataPengajuan->update(['status_approval' => $keputusanBaru]);

        $pesanHasil = $keputusanBaru === 'Disetujui'
            ? 'Pengajuan dana berhasil disetujui.'
            : 'Pengajuan dana telah ditolak.';

        return redirect()
            ->route('admin.keuangan.indeks')
            ->with('sukses', $pesanHasil);
    }
    public function ajukanUlang(Request $request, $id)
    {
        $request->validate([
            'nominal_diajukan' => ['required', 'numeric', 'min:1'],
        ]);

        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role !== 'Admin Daerah') {
            abort(403);
        }

        $dataPengajuan = PengajuanDana::findOrFail($id);

        $dataPengajuan->update([
            'nominal_diajukan' => $request->input('nominal_diajukan'),
            'status_approval'  => 'Menunggu',
            'waktu_pengajuan'  => now(),
        ]);

        $dataLaporan     = LaporanInfrastruktur::with('analisisAi')->find($dataPengajuan->id_laporan);
        $nominalDiajukan = (float) $request->input('nominal_diajukan');
        $estimasiBiayaAi = $dataLaporan->analisisAi ? (float) $dataLaporan->analisisAi->estimasi_biaya : 0;

        if ($nominalDiajukan > $estimasiBiayaAi) {
            return back()->with('warning', 'Pengajuan ulang masuk antrean khusus! Nominal melebihi estimasi AI.');
        }

        return back()->with('success', 'Pengajuan ulang berhasil dikirim.');
    }
}
