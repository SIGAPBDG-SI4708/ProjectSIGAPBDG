@extends('admin.layout')

@section('judulHalaman', 'Daftar Laporan Masuk')
@section('subjudulHalaman', 'Semua laporan infrastruktur di wilayah Anda')

@section('konten')
<div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">

    <div class="px-5 py-4 border-b border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="text-sm font-bold text-white">Laporan Infrastruktur</div>
            <div class="text-xs text-gray-500 mt-0.5">Total {{ $daftarLaporan->total() }} laporan ditemukan</div>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 text-xs text-gray-500 bg-gray-800 px-3 py-1.5 rounded-lg border border-white/5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/></svg>
                Diurutkan: Terbaru
            </span>
        </div>
    </div>

    @if($daftarLaporan->isEmpty())
    <div class="py-16 text-center">
        <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="text-gray-400 font-semibold text-sm mb-1">Belum Ada Laporan</div>
        <div class="text-gray-600 text-xs">Laporan baru dari warga akan muncul di sini</div>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 bg-gray-900/50">
                    <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Tracking ID</th>
                    <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Daerah</th>
                    <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Lokasi GPS</th>
                    <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                    <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Dilaporkan</th>
                    <th class="px-5 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($daftarLaporan as $laporan)
                <tr class="hover:bg-white/[0.02] transition group">
                    <td class="px-5 py-4">
                        <span class="font-mono text-xs text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded-lg">{{ $laporan->tracking_id }}</span>
                    </td>
                    <td class="px-5 py-4 text-gray-300 text-xs">
                        <div class="font-medium">{{ $laporan->daerah->nama_daerah ?? 'Tidak diketahui' }}</div>
                        <div class="text-gray-600">{{ $laporan->daerah->tingkat ?? '' }}</div>
                    </td>
                    <td class="px-5 py-4">
                        <div class="font-mono text-xs text-gray-400">{{ number_format($laporan->latitude, 5) }}</div>
                        <div class="font-mono text-xs text-gray-600">{{ number_format($laporan->longitude, 5) }}</div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $laporan->status === 'Menunggu' ? 'badge-status-menunggu' : '' }}
                            {{ $laporan->status === 'Proses'   ? 'badge-status-proses' : '' }}
                            {{ $laporan->status === 'Selesai'  ? 'badge-status-selesai' : '' }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $laporan->status === 'Menunggu' ? 'bg-yellow-400 animate-pulse' : '' }}
                                {{ $laporan->status === 'Proses'   ? 'bg-blue-400' : '' }}
                                {{ $laporan->status === 'Selesai'  ? 'bg-green-400' : '' }}">
                            </span>
                            {{ $laporan->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        <div>{{ $laporan->created_at->translatedFormat('d M Y') }}</div>
                        <div class="text-gray-600">{{ $laporan->created_at->translatedFormat('H:i') }} WIB</div>
                    </td>
                    <td class="px-5 py-4">
                        <a href="{{ route('admin.laporan.detail', $laporan->id) }}"
                           class="inline-flex items-center gap-1.5 text-xs text-indigo-400 hover:text-white bg-indigo-500/10 hover:bg-indigo-600 font-semibold px-3 py-1.5 rounded-lg transition">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($daftarLaporan->hasPages())
    <div class="px-5 py-4 border-t border-white/5 flex items-center justify-between">
        <div class="text-xs text-gray-500">
            Menampilkan {{ $daftarLaporan->firstItem() }}–{{ $daftarLaporan->lastItem() }} dari {{ $daftarLaporan->total() }} laporan
        </div>
        <div class="flex items-center gap-1">
            @if($daftarLaporan->onFirstPage())
                <span class="px-3 py-1.5 text-xs text-gray-600 bg-gray-800/50 rounded-lg cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $daftarLaporan->previousPageUrl() }}" class="px-3 py-1.5 text-xs text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition">← Prev</a>
            @endif

            @if($daftarLaporan->hasMorePages())
                <a href="{{ $daftarLaporan->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition">Next →</a>
            @else
                <span class="px-3 py-1.5 text-xs text-gray-600 bg-gray-800/50 rounded-lg cursor-not-allowed">Next →</span>
            @endif
        </div>
    </div>
    @endif
    @endif

</div>
@endsection