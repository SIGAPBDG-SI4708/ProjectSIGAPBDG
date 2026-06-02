<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use App\Models\AnalisisAi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function tampilkanBeranda()
    {
        $penggunaAktif = Auth::user();

        $chartTrendLabels = [];
        $chartTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $chartTrendLabels[] = $date->format('d M');
            $query = \App\Models\LaporanInfrastruktur::whereDate('created_at', $date);
            if ($penggunaAktif->role !== 'Super Admin') {
                $query->where('id_daerah', $penggunaAktif->id_daerah);
            }
            $chartTrendData[] = $query->count();
        }

        $danaQuery = \App\Models\PengajuanDana::query();
        if ($penggunaAktif->role !== 'Super Admin') {
            $danaQuery->whereHas('laporanInfrastruktur', function ($q) use ($penggunaAktif) {
                $q->where('id_daerah', $penggunaAktif->id_daerah);
            });
        }
        $danaDisetujui = (clone $danaQuery)->where('status_approval', 'Disetujui')->sum('nominal_diajukan');
        $danaDitolak = (clone $danaQuery)->where('status_approval', 'Ditolak')->sum('nominal_diajukan');
        $danaMenunggu = (clone $danaQuery)->where('status_approval', 'Menunggu')->sum('nominal_diajukan');

        $chartRatingLabels = ['Bintang 1', 'Bintang 2', 'Bintang 3', 'Bintang 4', 'Bintang 5'];
        $chartRatingData = [0, 0, 0, 0, 0];

        $ratingQuery = \App\Models\UlasanLaporan::query();
        if ($penggunaAktif->role !== 'Super Admin') {
            $ratingQuery->whereHas('laporanInfrastruktur', function ($q) use ($penggunaAktif) {
                $q->where('id_daerah', $penggunaAktif->id_daerah);
            });
        }
        $ratings = $ratingQuery->selectRaw('rating, COUNT(*) as count')->groupBy('rating')->pluck('count', 'rating')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            $chartRatingData[$i - 1] = $ratings[$i] ?? 0;
        }

        if ($penggunaAktif->role === 'Super Admin') {
            $totalLaporan = LaporanInfrastruktur::count();
            $totalMenunggu = LaporanInfrastruktur::where('status', 'Menunggu')->count();
            $totalProses = LaporanInfrastruktur::where('status', 'Proses')->count();
            $totalSelesai = LaporanInfrastruktur::where('status', 'Selesai')->count();
            $totalDitolak = LaporanInfrastruktur::where('status', 'Ditolak')->count();
            $laporanTerbaru = LaporanInfrastruktur::with('daerah')->latest()->take(5)->get();
        } else {
            $idDaerahPengguna = $penggunaAktif->id_daerah;
            $totalLaporan = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->count();
            $totalMenunggu = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Menunggu')->count();
            $totalProses = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Proses')->count();
            $totalSelesai = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Selesai')->count();
            $totalDitolak = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Ditolak')->count();
            $laporanTerbaru = LaporanInfrastruktur::with('daerah')->where('id_daerah', $idDaerahPengguna)->latest()->take(5)->get();
        }

        return view('admin.beranda', compact(
            'totalLaporan',
            'totalMenunggu',
            'totalProses',
            'totalSelesai',
            'totalDitolak',
            'laporanTerbaru',
            'chartTrendLabels',
            'chartTrendData',
            'danaDisetujui',
            'danaDitolak',
            'danaMenunggu',
            'chartRatingLabels',
            'chartRatingData'
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
            'foto_selesai' => ['nullable', 'required_if:status,Selesai', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $dataLaporan = LaporanInfrastruktur::findOrFail($id);
        } else {
            $dataLaporan = LaporanInfrastruktur::where('id_daerah', $penggunaAktif->id_daerah)->findOrFail($id);
        }

        $statusBaru = $request->input('status');
        $dataUpdate = ['status' => $statusBaru];

        if ($statusBaru === 'Selesai' && $request->hasFile('foto_selesai')) {
            $pathFotoSelesai = $request->file('foto_selesai')->store('laporan/selesai', 'public');
            $dataUpdate['foto_selesai'] = $pathFotoSelesai;
        }

        $dataLaporan->update($dataUpdate);

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

    public function tampilkanDaftarPegawai()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return abort(403, 'Akses khusus Super Admin.');
        }

        $daftarPegawai = User::where('role', 'Admin Daerah')->with('daerah')->latest()->paginate(15);

        return view('admin.pegawai.indeks', compact('daftarPegawai'));
    }

    public function perbaruiStatusPegawai(Request $request, $id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return abort(403, 'Akses khusus Super Admin.');
        }

        $request->validate([
            'status_akun' => ['required', 'in:aktif,nonaktif,ditolak'],
        ]);

        $pegawai = User::findOrFail($id);
        $pegawai->update(['status_akun' => $request->status_akun]);

        $pesan = $request->status_akun === 'aktif' ? 'Akun pegawai berhasil disetujui/diaktifkan.' : 'Akun pegawai telah ditolak/dinonaktifkan.';

        return back()->with('sukses', $pesan);
    }
}
