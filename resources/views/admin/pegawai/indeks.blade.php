@extends('admin.layout')

@section('judulHalaman', 'Manajemen Pegawai')
@section('subjudulHalaman', 'Kelola pendaftaran dan akses Admin Daerah')

@section('konten')
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">

    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="text-sm font-bold text-slate-800 dark:text-white">Daftar Admin Daerah</div>
            <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Total {{ $daftarPegawai->total() }} admin daerah</div>
        </div>
        <div class="inline-flex items-center gap-1.5 text-xs text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/></svg>
            Diurutkan: Terbaru
        </div>
    </div>

    @if($daftarPegawai->isEmpty())
    <div class="py-16 text-center">
        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div class="text-slate-600 dark:text-slate-400 font-semibold text-sm mb-1">Belum Ada Admin Daerah</div>
        <div class="text-slate-400 dark:text-slate-600 text-xs">Pendaftaran admin baru akan muncul di sini</div>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                    <th class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">Pegawai</th>
                    <th class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">Daerah Tugas</th>
                    <th class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5 hidden md:table-cell">Waktu Daftar</th>
                    <th class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">Status Akun</th>
                    <th class="text-left text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider px-5 py-3.5">Aksi Persetujuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($daftarPegawai as $pegawai)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                    <td class="px-5 py-4">
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $pegawai->nama }}</div>
                        <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $pegawai->email }}</div>
                    </td>
                    <td class="px-5 py-4">
                        <div class="inline-flex items-center gap-1.5 bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 px-2.5 py-1 rounded-lg border border-brand-100 dark:border-brand-800/50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-semibold text-xs">{{ $pegawai->daerah->nama_daerah ?? 'Kecamatan Tidak Diketahui' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ $pegawai->created_at->translatedFormat('d M Y') }}</div>
                        <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pegawai->created_at->translatedFormat('H:i') }} WIB</div>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $pegawai->status_akun === 'menunggu' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50' : '' }}
                            {{ $pegawai->status_akun === 'aktif'    ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50' : '' }}
                            {{ in_array($pegawai->status_akun, ['ditolak', 'nonaktif']) ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50' : '' }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $pegawai->status_akun === 'menunggu' ? 'bg-amber-400 animate-pulse' : '' }}
                                {{ $pegawai->status_akun === 'aktif'    ? 'bg-emerald-400' : '' }}
                                {{ in_array($pegawai->status_akun, ['ditolak', 'nonaktif']) ? 'bg-red-400' : '' }}">
                            </span>
                            {{ ucfirst($pegawai->status_akun) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <form action="{{ route('admin.pegawai.perbarui', $pegawai->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status_akun" onchange="this.form.submit()" class="text-xs font-medium px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer shadow-sm">
                                @if($pegawai->status_akun === 'menunggu')
                                <option value="menunggu" selected disabled>Pilih Tindakan...</option>
                                <option value="aktif">Terima (Aktifkan)</option>
                                <option value="ditolak">Tolak Pendaftaran</option>
                                @else
                                <option value="aktif" {{ $pegawai->status_akun === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $pegawai->status_akun === 'nonaktif' ? 'selected' : '' }}>Nonaktifkan</option>
                                <option value="ditolak" {{ $pegawai->status_akun === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                @endif
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($daftarPegawai->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <div class="text-xs text-slate-400 dark:text-slate-500">
            Menampilkan {{ $daftarPegawai->firstItem() }}–{{ $daftarPegawai->lastItem() }} dari {{ $daftarPegawai->total() }} admin
        </div>
        <div class="flex items-center gap-1.5">
            @if($daftarPegawai->onFirstPage())
                <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">← Prev</span>
            @else
                <a href="{{ $daftarPegawai->previousPageUrl() }}" class="px-3 py-1.5 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">← Prev</a>
            @endif
            @if($daftarPegawai->hasMorePages())
                <a href="{{ $daftarPegawai->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next →</a>
            @else
                <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next →</span>
            @endif
        </div>
    </div>
    @endif
    @endif

</div>
@endsection
