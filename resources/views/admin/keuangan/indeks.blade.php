@extends('admin.layout')

@section('judulHalaman', 'Persetujuan Dana')
@section('subjudulHalaman', 'Kelola semua pengajuan dana perbaikan infrastruktur')

@section('konten')
<div class="space-y-5">

    @php
        $totalPengajuan  = $daftarPengajuan->total();
        $totalMenunggu   = $daftarPengajuan->getCollection()->where('status_approval', 'Menunggu')->count();
        $totalDisetujui  = $daftarPengajuan->getCollection()->where('status_approval', 'Disetujui')->count();
        $totalDitolak    = $daftarPengajuan->getCollection()->where('status_approval', 'Ditolak')->count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalPengajuan }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Total Pengajuan</div>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-2xl font-extrabold text-amber-500">{{ $totalMenunggu }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Menunggu Review</div>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="text-2xl font-extrabold text-emerald-500">{{ $totalDisetujui }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Disetujui</div>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <div class="text-2xl font-extrabold text-red-500">{{ $totalDitolak }}</div>
            <div class="text-xs text-slate-400 mt-0.5">Ditolak</div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-slate-800 dark:text-white">Daftar Pengajuan Dana</div>
                <div class="text-xs text-slate-400 mt-0.5">{{ $daftarPengajuan->total() }} pengajuan dari Admin Daerah</div>
            </div>
        </div>

        @if($daftarPengajuan->isEmpty())
        <div class="py-16 text-center">
            <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/></svg>
            </div>
            <div class="text-slate-600 dark:text-slate-400 font-semibold text-sm mb-1">Belum Ada Pengajuan Dana</div>
            <div class="text-slate-400 dark:text-slate-600 text-xs">Pengajuan dari Admin Daerah akan muncul di sini</div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                        <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Laporan</th>
                        <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden md:table-cell">Daerah</th>
                        <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden lg:table-cell">Diajukan Oleh</th>
                        <th class="text-right text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Nominal</th>
                        <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                        <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden sm:table-cell">Waktu</th>
                        <th class="px-5 py-3.5 text-xs text-slate-400 font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($daftarPengajuan as $pengajuan)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.laporan.detail', $pengajuan->laporanInfrastruktur->id ?? '#') }}"
                               class="font-mono text-xs text-indigo-600 dark:text-indigo-400 font-bold bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                {{ $pengajuan->laporanInfrastruktur->tracking_id ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <div class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $pengajuan->laporanInfrastruktur->daerah->nama_daerah ?? '-' }}</div>
                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->laporanInfrastruktur->daerah->tingkat ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell">
                            <div class="text-sm text-slate-700 dark:text-slate-300">{{ $pengajuan->pengguna->nama ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $pengajuan->pengguna->role ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="text-sm font-bold text-slate-800 dark:text-white">Rp {{ number_format($pengajuan->nominal_diajukan, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-5 py-4">
                            @if($pengajuan->status_approval === 'Menunggu')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>Menunggu
                                </span>
                            @elseif($pengajuan->status_approval === 'Disetujui')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 hidden sm:table-cell">
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('d M Y') : '-' }}</div>
                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('H:i') . ' WIB' : '' }}</div>
                        </td>
                        <td class="px-5 py-4">
                            @if($pengajuan->status_approval === 'Menunggu')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="keputusan" value="Disetujui">
                                    <button type="submit" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✓ Setujui</button>
                                </form>
                                <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="keputusan" value="Ditolak">
                                    <button type="submit" class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-200 dark:border-red-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✗ Tolak</button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-slate-400 dark:text-slate-600 italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($daftarPengajuan->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="text-xs text-slate-400">Menampilkan {{ $daftarPengajuan->firstItem() }}–{{ $daftarPengajuan->lastItem() }} dari {{ $daftarPengajuan->total() }}</div>
            <div class="flex items-center gap-1.5">
                @if($daftarPengajuan->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $daftarPengajuan->previousPageUrl() }}" class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">← Prev</a>
                @endif
                @if($daftarPengajuan->hasMorePages())
                    <a href="{{ $daftarPengajuan->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next →</a>
                @else
                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next →</span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection