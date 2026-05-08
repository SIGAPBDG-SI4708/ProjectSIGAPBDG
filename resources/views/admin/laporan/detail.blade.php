@extends('admin.layout')

@section('judulHalaman', 'Detail Laporan')
@section('subjudulHalaman', 'Informasi lengkap dan pengelolaan status laporan')

@section('konten')
<div class="space-y-5">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.laporan.indeks') }}" class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>
        <span class="text-gray-700">/</span>
        <span class="text-xs text-gray-500 font-mono">{{ $dataLaporan->tracking_id }}</span>
    </div>

    <div class="grid lg:grid-cols-3 gap-5">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5">
                    <div class="text-sm font-bold text-white mb-0.5">Foto Laporan</div>
                    <div class="text-xs text-gray-500">Foto yang diunggah oleh pelapor</div>
                </div>
                <div class="p-5">
                    <div class="rounded-xl overflow-hidden bg-gray-800 aspect-video flex items-center justify-center">
                        <img
                            src="{{ asset('storage/' . $dataLaporan->foto_awal) }}"
                            alt="Foto kerusakan infrastruktur"
                            class="w-full h-full object-cover"
                            onerror="this.parentElement.innerHTML='<div class=\'flex flex-col items-center gap-2 text-gray-600\'><svg class=\'w-10 h-10\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><span class=\'text-sm\'>Foto tidak tersedia</span></div>'"
                        >
                    </div>
                </div>
            </div>

            @if($dataLaporan->foto_selesai)
            <div class="bg-gray-900 border border-green-500/20 rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-green-500/10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <div class="text-sm font-bold text-green-400">Foto Setelah Perbaikan</div>
                </div>
                <div class="p-5">
                    <div class="rounded-xl overflow-hidden bg-gray-800 aspect-video">
                        <img src="{{ asset('storage/' . $dataLaporan->foto_selesai) }}" alt="Foto selesai" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            @endif

            @if($dataLaporan->analisisAi)
                @if($dataLaporan->analisisAi->is_spam)
                <div class="bg-red-950 border-2 border-red-500/50 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <div class="text-red-400 font-black text-sm uppercase tracking-widest mb-1">⚠ Laporan Terdeteksi Spam oleh AI</div>
                            <div class="text-red-300/70 text-xs leading-relaxed">Sistem analisis AI mendeteksi laporan ini sebagai tidak valid atau duplikat. Laporan ini tidak dapat diajukan untuk pendanaan.</div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gray-900 border border-purple-500/20 rounded-2xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-purple-500/10 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        <div class="text-sm font-bold text-purple-300">Hasil Analisis AI</div>
                        <span class="ml-auto text-xs bg-purple-500/10 text-purple-400 border border-purple-500/20 px-2 py-0.5 rounded-full font-semibold">Valid</span>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-800 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-1">Jenis Kerusakan</div>
                                <div class="text-sm font-bold text-white">{{ $dataLaporan->analisisAi->jenis_kerusakan }}</div>
                            </div>
                            <div class="bg-gray-800 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-1">Tingkat Keparahan</div>
                                <div class="text-sm font-bold
                                    {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Berat'  ? 'text-red-400' : '' }}
                                    {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Sedang' ? 'text-yellow-400' : '' }}
                                    {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Ringan' ? 'text-green-400' : '' }}">
                                    {{ $dataLaporan->analisisAi->tingkat_keparahan }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-800 rounded-xl p-3">
                            <div class="text-xs text-gray-500 mb-1">Estimasi Biaya Perbaikan</div>
                            <div class="text-lg font-black text-white">Rp {{ number_format($dataLaporan->analisisAi->estimasi_biaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                @endif
            @endif

            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
                <div class="text-sm font-bold text-white mb-4">Koordinat Lokasi</div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Latitude
                        </div>
                        <div class="font-mono text-indigo-400 font-bold text-lg">{{ $dataLaporan->latitude }}</div>
                    </div>
                    <div class="bg-gray-800 rounded-xl p-4">
                        <div class="text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Longitude
                        </div>
                        <div class="font-mono text-indigo-400 font-bold text-lg">{{ $dataLaporan->longitude }}</div>
                    </div>
                </div>
                <a href="https://maps.google.com/?q={{ $dataLaporan->latitude }},{{ $dataLaporan->longitude }}"
                   target="_blank"
                   class="mt-3 inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 px-3 py-2 rounded-lg transition w-full justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka di Google Maps
                </a>
            </div>
        </div>

        <div class="space-y-5">

            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
                <div class="text-sm font-bold text-white mb-4">Informasi Laporan</div>
                <div class="space-y-3.5">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Tracking ID</div>
                        <div class="font-mono text-indigo-400 font-bold text-sm bg-indigo-500/10 px-3 py-2 rounded-lg">{{ $dataLaporan->tracking_id }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Daerah</div>
                        <div class="text-sm text-white font-medium">{{ $dataLaporan->daerah->nama_daerah ?? 'Tidak diketahui' }}</div>
                        <div class="text-xs text-gray-500">{{ $dataLaporan->daerah->tingkat ?? '' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Tanggal Laporan</div>
                        <div class="text-sm text-white">{{ $dataLaporan->created_at->translatedFormat('d F Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $dataLaporan->created_at->translatedFormat('H:i') }} WIB · {{ $dataLaporan->created_at->diffForHumans() }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1.5">Status Saat Ini</div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1.5 rounded-lg
                            {{ $dataLaporan->status === 'Menunggu' ? 'badge-status-menunggu' : '' }}
                            {{ $dataLaporan->status === 'Proses'   ? 'badge-status-proses' : '' }}
                            {{ $dataLaporan->status === 'Selesai'  ? 'badge-status-selesai' : '' }}">
                            <span class="w-2 h-2 rounded-full
                                {{ $dataLaporan->status === 'Menunggu' ? 'bg-yellow-400 animate-pulse' : '' }}
                                {{ $dataLaporan->status === 'Proses'   ? 'bg-blue-400' : '' }}
                                {{ $dataLaporan->status === 'Selesai'  ? 'bg-green-400' : '' }}">
                            </span>
                            {{ $dataLaporan->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 border border-indigo-500/20 rounded-2xl p-5">
                <div class="text-sm font-bold text-white mb-1">Perbarui Status</div>
                <div class="text-xs text-gray-500 mb-4">Ubah status penanganan laporan ini</div>

                <form action="{{ route('admin.laporan.perbarui', $dataLaporan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="statusBaru" class="block text-xs text-gray-400 font-medium mb-2">Pilih Status Baru</label>
                        <select name="status" id="statusBaru"
                            class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent appearance-none cursor-pointer">
                            <option value="Menunggu" {{ $dataLaporan->status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses"   {{ $dataLaporan->status === 'Proses'   ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai"  {{ $dataLaporan->status === 'Selesai'  ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    @error('status')
                    <div class="mb-3 text-xs text-red-400">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </form>

                <div class="mt-4 pt-4 border-t border-white/5">
                    <div class="text-xs text-gray-600 text-center">Alur: Menunggu → Proses → Selesai</div>
                </div>
            </div>

            @if(Auth::user()->role === 'Admin Daerah' && $dataLaporan->analisisAi && !$dataLaporan->analisisAi->is_spam)
            <div class="bg-gray-900 border border-orange-500/20 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm font-bold text-white">Ajukan Dana Perbaikan</div>
                </div>
                <div class="text-xs text-gray-500 mb-4">Masukkan estimasi nominal dana yang dibutuhkan untuk perbaikan</div>

                <form action="{{ route('admin.pengajuan.simpan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_laporan" value="{{ $dataLaporan->id }}">

                    <div class="mb-4">
                        <label for="nominalDiajukan" class="block text-xs text-gray-400 font-medium mb-2">Nominal Dana (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 font-semibold">Rp</span>
                            <input
                                type="number"
                                id="nominalDiajukan"
                                name="nominal_diajukan"
                                min="1"
                                step="1000"
                                placeholder="0"
                                class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            >
                        </div>
                        @error('nominal_diajukan')
                        <div class="mt-1.5 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Pengajuan Dana
                    </button>
                </form>

                <div class="mt-4 pt-4 border-t border-white/5">
                    <div class="text-xs text-gray-600 text-center">Pengajuan akan diteruskan ke Super Admin untuk disetujui</div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection