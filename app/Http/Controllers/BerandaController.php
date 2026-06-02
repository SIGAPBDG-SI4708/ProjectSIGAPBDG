<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $ulasanBintang5 = \App\Models\UlasanLaporan::with('laporanInfrastruktur.daerah')
            ->where('rating', 5)
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('ulasanBintang5'));
    }
}