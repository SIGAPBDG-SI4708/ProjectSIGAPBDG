@extends('admin.layout')

@section('judulHalaman', 'Persetujuan Dana')
@section('subjudulHalaman', 'Kelola semua pengajuan dana perbaikan infrastruktur')

@section('konten')
<div class="space-y-5">

    <div class="grid grid-cols-3 gap-4">
        @php
            $totalPengajuan  = $daftarPengajuan->total();
            $totalMenunggu   = $daftarPengajuan->getCollection()->where('status_approval', 'Menunggu')->count();
            $totalDisetujui  = $daftarPengajuan->getCollection()->where('status_approval', 'Disetujui')->count();
            $totalDitolak    = $daftarPengajuan->getCollection()->where('status_approval', 'Ditolak')->count();
        @endphp

        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-2">Total Pengajuan</div>
            <div class="text-3xl font-black text-white">{{ $totalPengajuan }}</div>
        </div>
        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-2">Menunggu Review</div>
            <div class="text-3xl font-black text-yellow-400">{{ $totalMenunggu }}</div>
        </div>
        <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-2">Disetujui</div>
            <div class="text-3xl font-black text-green-400">{{ $totalDisetujui }}</div>
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-white">Daftar Pengajuan Dana</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $daftarPengajuan->total() }} pengajuan masuk dari Admin Daerah</div>
            </div>
        </div>

        @if($daftarPengajuan->isEmpty())
        <div class="py-16 text-center">
            <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-gray-400 font-semibold text-sm mb-1">Belum Ada Pengajuan Dana</div>
            <div class="text-gray-600 text-xs">Pengajuan dari Admin Daerah akan muncul di sini</div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5 bg-gray-900/50">
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Laporan</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Daerah</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Diajukan Oleh</th>
                        <th class="text-right text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Nominal</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                        <th class="text-left text-xs text-gray-500 font-semibold uppercase tracking-wider px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5 text-xs text-gray-500 font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($daftarPengajuan as $pengajuan)
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.laporan.detail', $pengajuan->laporanInfrastruktur->id ?? '#') }}"
                               class="font-mono text-xs text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded-lg hover:bg-indigo-500/20 transition">
                                {{ $pengajuan->laporanInfrastruktur->tracking_id ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm text-gray-300 font-medium">{{ $pengajuan->laporanInfrastruktur->daerah->nama_daerah ?? '-' }}</div>
                            <div class="text-xs text-gray-600">{{ $pengajuan->laporanInfrastruktur->daerah->tingkat ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm text-gray-300">{{ $pengajuan->pengguna->nama ?? '-' }}</div>
                            <div class="text-xs text-gray-600">{{ $pengajuan->pengguna->role ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="text-sm font-bold text-white">
                                Rp {{ number_format($pengajuan->nominal_diajukan, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($pengajuan->status_approval === 'Menunggu')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                                    Menunggu
                                </span>
                            @elseif($pengajuan->status_approval === 'Disetujui')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                    Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">
                            <div>{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('d M Y') : '-' }}</div>
                            <div class="text-gray-600">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('H:i') . ' WIB' : '' }}</div>
                        </td>
                        <td class="px-5 py-4">
                            @if($pengajuan->status_approval === 'Menunggu')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="keputusan" value="Disetujui">
                                    <button type="submit"
                                        class="text-xs font-bold text-green-400 bg-green-500/10 hover:bg-green-500/20 border border-green-500/20 px-3 py-1.5 rounded-lg transition whitespace-nowrap">
                                        ✓ Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.pengajuan.proses', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="keputusan" value="Ditolak">
                                    <button type="submit"
                                        class="text-xs font-bold text-red-400 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 px-3 py-1.5 rounded-lg transition whitespace-nowrap">
                                        ✗ Tolak
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs text-gray-600 italic">Selesai diproses</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($daftarPengajuan->hasPages())
        <div class="px-5 py-4 border-t border-white/5 flex items-center justify-between">
            <div class="text-xs text-gray-500">
                Menampilkan {{ $daftarPengajuan->firstItem() }}–{{ $daftarPengajuan->lastItem() }} dari {{ $daftarPengajuan->total() }} pengajuan
            </div>
            <div class="flex items-center gap-1">
                @if($daftarPengajuan->onFirstPage())
                    <span class="px-3 py-1.5 text-xs text-gray-600 bg-gray-800/50 rounded-lg cursor-not-allowed">← Prev</span>
                @else
                    <a href="{{ $daftarPengajuan->previousPageUrl() }}" class="px-3 py-1.5 text-xs text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition">← Prev</a>
                @endif
                @if($daftarPengajuan->hasMorePages())
                    <a href="{{ $daftarPengajuan->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition">Next →</a>
                @else
                    <span class="px-3 py-1.5 text-xs text-gray-600 bg-gray-800/50 rounded-lg cursor-not-allowed">Next →</span>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection