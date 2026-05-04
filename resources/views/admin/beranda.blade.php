@extends('admin.layout')

@section('judulHalaman', 'Beranda')
@section('subjudulHalaman', 'Ringkasan aktivitas laporan wilayah Anda')

@section('konten')
<div class="space-y-6">

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Total Laporan</div>
                <div class="w-8 h-8 bg-indigo-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white">{{ $totalLaporan }}</div>
        </div>

        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Menunggu</div>
                <div class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-yellow-400">{{ $totalMenunggu }}</div>
        </div>

        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Proses</div>
                <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-blue-400">{{ $totalProses }}</div>
        </div>

        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wider">Selesai</div>
                <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-green-400">{{ $totalSelesai }}</div>
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-white">Laporan Terbaru</div>
                <div class="text-xs text-gray-500 mt-0.5">5 laporan infrastruktur terkini</div>
            </div>
            <a href="{{ route('admin.laporan.indeks') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition flex items-center gap-1">
                Lihat semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($laporanTerbaru->isEmpty())
        <div class="py-12 text-center">
            <div class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="text-gray-500 text-sm">Belum ada laporan masuk</div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3">Tracking ID</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3">Daerah</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3">Status</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3">Waktu</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($laporanTerbaru as $laporan)
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="px-5 py-3.5 font-mono text-xs text-indigo-400 font-semibold">{{ $laporan->tracking_id }}</td>
                        <td class="px-5 py-3.5 text-gray-300 text-xs">{{ $laporan->daerah->nama_daerah ?? '-' }}</td>
                        <td class="px-5 py-3.5">
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
                        <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $laporan->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.laporan.detail', $laporan->id) }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium transition">Detail →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
