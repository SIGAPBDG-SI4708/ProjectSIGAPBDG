<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use App\Models\AnalisisAi;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function tampilkanBeranda()
    {
        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $totalLaporan   = LaporanInfrastruktur::count();
            $totalMenunggu  = LaporanInfrastruktur::where('status', 'Menunggu')->count();
            $totalProses    = LaporanInfrastruktur::where('status', 'Proses')->count();
            $totalSelesai   = LaporanInfrastruktur::where('status', 'Selesai')->count();
            $laporanTerbaru = LaporanInfrastruktur::with('daerah')->latest()->take(5)->get();
        } else {
            $idDaerahPengguna = $penggunaAktif->id_daerah;
            $totalLaporan     = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->count();
            $totalMenunggu    = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Menunggu')->count();
            $totalProses      = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Proses')->count();
            $totalSelesai     = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Selesai')->count();
            $laporanTerbaru   = LaporanInfrastruktur::with('daerah')->where('id_daerah', $idDaerahPengguna)->latest()->take(5)->get();
        }

        return view('admin.beranda', compact(
            'totalLaporan',
            'totalMenunggu',
            'totalProses',
            'totalSelesai',
            'laporanTerbaru'
        ));
    }

    public function tampilkanDaftarLaporan()
    {
        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $daftarLaporan = LaporanInfrastruktur::with('daerah')->latest()->paginate(15);
        } else {
            $daftarLaporan = LaporanInfrastruktur::with('daerah')
                ->where('id_daerah', $penggunaAktif->id_daerah)
                ->latest()
                ->paginate(15);
        }

        return view('admin.laporan.indeks', compact('daftarLaporan'));
    }

    public function tampilkanDetailLaporan($id)
    {
        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $dataLaporan = LaporanInfrastruktur::with('daerah', 'analisisAi', 'pengajuanDana')->findOrFail($id);
        } else {
            $dataLaporan = LaporanInfrastruktur::with('daerah', 'analisisAi', 'pengajuanDana')
                ->where('id_daerah', $penggunaAktif->id_daerah)
                ->findOrFail($id);
        }

        return view('admin.laporan.detail', compact('dataLaporan'));
    }

    public function perbaruiStatusLaporan(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:Menunggu,Proses,Selesai'],
        ]);

        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $dataLaporan = LaporanInfrastruktur::findOrFail($id);
        } else {
            $dataLaporan = LaporanInfrastruktur::where('id_daerah', $penggunaAktif->id_daerah)->findOrFail($id);
        }

        $statusBaru = $request->input('status');
        $dataLaporan->update(['status' => $statusBaru]);

        return redirect()->route('admin.laporan.detail', $id)->with('sukses', 'Status laporan berhasil diperbarui menjadi "' . $statusBaru . '".');
    }
    public function tampilkanPeta()
    {
        return view('admin.peta.indeks');
    }

    public function ambilDataTitikKejahatan()
    {
        $daftarTitikKejahatan = LaporanKejahatan::select('latitude', 'longitude')->get();
        return response()->json($daftarTitikKejahatan);
    }
}
