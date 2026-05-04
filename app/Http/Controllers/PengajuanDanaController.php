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

        return redirect()
            ->route('admin.laporan.detail', $request->input('id_laporan'))
            ->with('sukses', 'Pengajuan dana berhasil dikirim dan sedang menunggu persetujuan Super Admin.');
    }

    public function tampilkanDaftarPengajuan()
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403);
        }

        $daftarPengajuan = PengajuanDana::with(['laporanInfrastruktur.daerah', 'pengguna'])
            ->latest()
            ->paginate(20);

        return view('admin.keuangan.indeks', compact('daftarPengajuan'));
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
}
