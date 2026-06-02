@extends('admin.layout')

@section('judulHalaman', 'Laporan Masuk')
@section('subjudulHalaman', 'Semua laporan infrastruktur di wilayah Anda')

@section('konten')
    <div
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">

        <div
            class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="text-sm font-bold text-slate-800 dark:text-white">Laporan Infrastruktur</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Total {{ $daftarLaporan->total() }} laporan
                    ditemukan</div>
            </div>
            <div
                class="inline-flex items-center gap-1.5 text-xs text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                </svg>
                Diurutkan: Terbaru
            </div>
        </div>

        @if($daftarLaporan->isEmpty())
            <div class="py-16 text-center">
                <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="text-slate-600 dark:text-slate-400 font-semibold text-sm mb-1">Belum Ada Laporan</div>
                <div class="text-slate-400 dark:text-slate-600 text-xs">Laporan baru dari warga akan muncul di sini</div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                            <th
                                class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">
                                Tracking ID</th>
                            <th
                                class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">
                                Daerah</th>
                            <th
                                class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5 hidden md:table-cell">
                                Koordinat</th>
                            <th
                                class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">
                                Status</th>
                            <th
                                class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5 hidden sm:table-cell">
                                Dilaporkan</th>
                            <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($daftarLaporan as $laporan)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4">
                                    <span
                                        class="font-mono text-xs text-brand-600 dark:text-brand-400 font-bold bg-brand-50 dark:bg-brand-900/30 px-2 py-1 rounded-lg">{{ $laporan->tracking_id }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                        {{ $laporan->daerah->nama_daerah ?? 'Tidak diketahui' }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-600">{{ $laporan->daerah->tingkat ?? '' }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <div class="font-mono text-xs text-slate-500 dark:text-slate-400">
                                        {{ number_format($laporan->latitude, 5) }}</div>
                                    <div class="font-mono text-xs text-slate-400 dark:text-slate-600">
                                        {{ number_format($laporan->longitude, 5) }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                        {{ $laporan->status === 'Menunggu' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50' : '' }}
                                        {{ $laporan->status === 'Proses' ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 border border-brand-100 dark:border-brand-800/50' : '' }}
                                        {{ $laporan->status === 'Selesai' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50' : '' }}
                                        {{ $laporan->status === 'Ditolak' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full
                                            {{ $laporan->status === 'Menunggu' ? 'bg-amber-400 animate-pulse' : '' }}
                                            {{ $laporan->status === 'Proses' ? 'bg-brand-400' : '' }}
                                            {{ $laporan->status === 'Selesai' ? 'bg-emerald-400' : '' }}
                                            {{ $laporan->status === 'Ditolak' ? 'bg-red-400' : '' }}">
                                        </span>
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <div class="text-xs text-slate-600 dark:text-slate-400">
                                        {{ $laporan->created_at->translatedFormat('d M Y') }}</div>
                                    <div class="text-xs text-slate-400 dark:text-slate-600">
                                        {{ $laporan->created_at->translatedFormat('H:i') }} WIB</div>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.laporan.detail', $laporan->id) }}"
                                        class="inline-flex items-center gap-1.5 text-xs text-brand-600 dark:text-brand-400 hover:text-white hover:bg-brand-600 bg-brand-50 dark:bg-brand-900/30 font-semibold px-3 py-1.5 rounded-xl transition">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($daftarLaporan->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="text-xs text-slate-400 dark:text-slate-500">
                        Menampilkan {{ $daftarLaporan->firstItem() }}–{{ $daftarLaporan->lastItem() }} dari
                        {{ $daftarLaporan->total() }} laporan
                    </div>
                    <div class="flex items-center gap-1.5">
                        @if($daftarLaporan->onFirstPage())
                            <span
                                class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">←
                                Prev</span>
                        @else
                            <a href="{{ $daftarLaporan->previousPageUrl() }}"
                                class="px-3 py-1.5 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">←
                                Prev</a>
                        @endif
                        @if($daftarLaporan->hasMorePages())
                            <a href="{{ $daftarLaporan->nextPageUrl() }}"
                                class="px-3 py-1.5 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next
                                →</a>
                        @else
                            <span
                                class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next
                                →</span>
                        @endif
                    </div>
                </div>
            @endif
        @endif

    </div>
@endsection