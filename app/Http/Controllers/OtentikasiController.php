<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtentikasiController extends Controller
{
    public function tampilkanSambutan()
    {
        if (Auth::check()) {
            return redirect()->route('admin.beranda');
        }
        return view('otentikasi.sambutan');
    }

    public function tampilkanMasuk()
    {
        if (Auth::check()) {
            return redirect()->route('admin.beranda');
        }
        return view('otentikasi.masuk');
    }

    public function prosesMasuk(Request $request)
    {
        $kredensial = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($kredensial)) {
            $pengguna = Auth::user();
            if ($pengguna->status_akun !== 'aktif') {
                $status = $pengguna->status_akun;
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                $pesanError = 'Akun Anda belum disetujui Super Admin!';
                if ($status === 'ditolak') {
                    $pesanError = 'Pendaftaran akun Anda ditolak oleh Super Admin.';
                } elseif ($status === 'nonaktif') {
                    $pesanError = 'Akun Anda telah dinonaktifkan.';
                }

                return back()->withErrors([
                    'email' => $pesanError,
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.beranda'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    public function tampilkanDaftar()
    {
        if (Auth::check()) {
            return redirect()->route('admin.beranda');
        }
        return view('otentikasi.daftar');
    }

    public function prosesDaftar(Request $request)
    {
        $dataValidasi = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nama_kecamatan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $klienHttp = new \GuzzleHttp\Client([
            'headers' => ['User-Agent' => 'SIGAP-BDG-App/1.0']
        ]);
        
        try {
            $respon = $klienHttp->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $dataValidasi['nama_kecamatan'] . ', Bandung',
                    'format' => 'json',
                    'limit' => 1
                ]
            ]);
            $hasilLokasi = json_decode($respon->getBody(), true);
            
            if (empty($hasilLokasi)) {
                return back()->withErrors(['nama_kecamatan' => 'Kecamatan tidak valid.'])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['nama_kecamatan' => 'Gagal memverifikasi lokasi.'])->withInput();
        }

        $daerah = \App\Models\Daerah::firstOrCreate(
            ['nama_daerah' => $dataValidasi['nama_kecamatan']],
            [
                'tingkat' => 'Kecamatan'
            ]
        );

        User::create([
            'nama' => $dataValidasi['nama'],
            'email' => $dataValidasi['email'],
            'password' => bcrypt($dataValidasi['password']),
            'role' => 'Admin Daerah',
            'id_daerah' => $daerah->id,
            'status_akun' => 'menunggu',
        ]);

        return redirect()->route('masuk')->with('warning', 'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan Super Admin.');
    }

    public function keluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }
}
