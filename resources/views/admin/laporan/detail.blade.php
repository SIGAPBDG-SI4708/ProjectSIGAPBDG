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

            <!-- ========================================================= -->
            <!-- SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5] -->
            <!-- ========================================================= -->
            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5" x-data="{ statusPilihan: '{{ $dataLaporan->status }}', namaFile: '' }">
                <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
                <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
                
                <div class="text-sm font-bold text-white mb-1">Perbarui Status</div>
                <div class="text-xs text-gray-500 mb-4">Ubah status penanganan laporan ini</div>

                <form action="{{ route('admin.laporan.perbarui', $dataLaporan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label class="block text-xs text-gray-400 font-medium mb-3">Pilih Status Baru</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="status" value="Menunggu" x-model="statusPilihan"
                                    class="peer sr-only">
                                <div
                                    class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-yellow-500/20 peer-checked:text-yellow-400 peer-checked:border-yellow-500/30 bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700">
                                    Menunggu
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="status" value="Proses" x-model="statusPilihan"
                                    class="peer sr-only">
                                <div
                                    class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-blue-500/20 peer-checked:text-blue-400 peer-checked:border-blue-500/30 bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700">
                                    Proses
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="status" value="Selesai" x-model="statusPilihan"
                                    class="peer sr-only">
                                <div
                                    class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-green-500/20 peer-checked:text-green-400 peer-checked:border-green-500/30 bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700">
                                    Selesai
                                </div>
                            </label>
                        </div>
                    </div>

                    <div x-show="statusPilihan === 'Selesai'" x-collapse class="mb-5">
                        <label class="block text-xs text-gray-400 font-medium mb-2">Unggah Foto Perbaikan (Wajib)</label>
                        <div class="relative group" x-data="{ isDragging: false }" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="isDragging = false; const dt = $event.dataTransfer; if(dt.files.length) { $refs.fileInput.files = dt.files; namaFile = dt.files[0].name; }">
                            <input type="file" name="foto_selesai" id="foto_selesai" accept="image/*" x-ref="fileInput"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                @change="namaFile = $event.target.files.length > 0 ? $event.target.files[0].name : ''"
                                :required="statusPilihan === 'Selesai'">
                            <div :class="{'border-blue-500 bg-blue-500/10': isDragging, 'border-gray-700 bg-gray-800': !isDragging}"
                                class="flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl transition-colors duration-200 group-hover:border-blue-400">
                                <svg class="w-8 h-8 text-gray-500 mb-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <div class="text-sm font-medium text-gray-300">
                                    <span x-text="namaFile ? namaFile : 'Drag and drop foto ke sini'"></span>
                                </div>
                                <div x-show="!namaFile" class="text-xs text-gray-500 mt-1">atau klik untuk menelusuri</div>
                            </div>
                        </div>
                        @error('foto_selesai')
                            <div class="mt-1.5 text-xs text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('status')
                        <div class="mb-3 text-xs text-red-400">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
            <!-- ========================================================= -->

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

            <!-- ========================================================= -->
            <!-- SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5] -->
            <!-- ========================================================= -->
            @if($dataLaporan->ulasanLaporan->count() > 0)
            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5">
                <div class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Ulasan dari Warga ({{ $dataLaporan->ulasanLaporan->count() }})
                </div>
                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                    @foreach($dataLaporan->ulasanLaporan as $ulasanData)
                        <div class="bg-gray-800/50 p-4 rounded-xl border border-white/5">
                            <div class="flex items-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $ulasanData->rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-600' }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                @endfor
                                <span class="text-xs text-gray-500 ml-auto">{{ $ulasanData->created_at->diffForHumans() }}</span>
                            </div>
                            @if($ulasanData->ulasan)
                                <p class="text-sm text-gray-300 italic">"{{ $ulasanData->ulasan }}"</p>
                            @else
                                <p class="text-sm text-gray-500 italic">(Tidak ada ulasan tertulis)</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- ========================================================= -->

        </div>
    </div>
</div>
@endsection