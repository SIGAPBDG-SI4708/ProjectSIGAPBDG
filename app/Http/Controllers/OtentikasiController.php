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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $penggunaBaru = User::create([
            'nama' => $dataValidasi['nama'],
            'email' => $dataValidasi['email'],
            'password' => bcrypt($dataValidasi['password']),
            'role' => 'Admin Daerah',
        ]);

        Auth::login($penggunaBaru);

        return redirect()->route('admin.beranda');
    }

    public function keluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }
}
