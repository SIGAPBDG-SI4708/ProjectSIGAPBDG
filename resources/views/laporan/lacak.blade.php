<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Laporan - SIGAP BDG</title>
    <meta name="description" content="Lacak status laporan infrastruktur Anda menggunakan Tracking ID yang diberikan saat laporan dibuat.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-cari { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .btn-cari:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(99,102,241,0.4); }
        .hasil-masuk { animation: masuk 0.4s ease forwards; }
        @keyframes masuk {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight">SIGAP <span class="text-indigo-400">BDG</span></span>
            </a>
            <a href="{{ route('lapor') }}" class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Buat Laporan
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">

        <div class="mb-10">
            <div class="inline-flex items-center gap-2 bg-green-500/10 border border-green-500/20 text-green-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Lacak Status
            </div>
            <h1 class="text-3xl sm:text-4xl font-black mb-3">Cek Status <span class="gradient-text">Laporan</span></h1>
            <p class="text-gray-400 text-base">Masukkan Tracking ID yang kamu terima saat laporan dikirim untuk melihat perkembangan terbaru.</p>
        </div>

        <form action="{{ route('proses.lacak') }}" method="POST" class="bg-gray-900 border border-white/5 rounded-2xl p-5 sm:p-6 mb-8">
            @csrf
            <label for="inputTrackingId" class="block text-sm font-semibold text-white mb-2">Tracking ID</label>
            <p class="text-xs text-gray-500 mb-4">Contoh format: <span class="text-indigo-400 font-mono font-semibold">SIGAP-A1B2C3</span></p>
            <div class="flex gap-3">
                <input
                    type="text"
                    id="inputTrackingId"
                    name="tracking_id"
                    value="{{ $kodeLacak ?? old('tracking_id') }}"
                    placeholder="SIGAP-XXXXXX"
                    class="flex-1 bg-gray-800 border border-gray-700 text-white placeholder-gray-600 rounded-xl px-4 py-3 text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    autocomplete="off"
                    spellcheck="false"
                >
                <button type="submit" class="btn-cari bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-500/20 flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
            </div>
            @error('tracking_id')
                <div class="mt-3 text-red-400 text-xs flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </div>
            @enderror
        </form>

        @isset($kodeLacak)
            @if($dataLaporan)
            <div class="hasil-masuk space-y-5">

                <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
                    <div class="px-5 sm:px-6 pt-5 pb-4 border-b border-white/5 flex items-center justify-between">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">Nomor Laporan</div>
                            <div class="text-xl font-black tracking-widest text-white font-mono">{{ $dataLaporan->tracking_id }}</div>
                        </div>
                        @php
                            $warnaStatus = match($dataLaporan->status) {
                                'Menunggu' => ['bg' => 'bg-yellow-500/10', 'border' => 'border-yellow-500/20', 'text' => 'text-yellow-400', 'dot' => 'bg-yellow-400'],
                                'Proses'   => ['bg' => 'bg-blue-500/10',   'border' => 'border-blue-500/20',   'text' => 'text-blue-400',   'dot' => 'bg-blue-400'],
                                'Selesai'  => ['bg' => 'bg-green-500/10',  'border' => 'border-green-500/20',  'text' => 'text-green-400',  'dot' => 'bg-green-400'],
                                default    => ['bg' => 'bg-gray-700',      'border' => 'border-gray-600',      'text' => 'text-gray-400',   'dot' => 'bg-gray-400'],
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 {{ $warnaStatus['bg'] }} border {{ $warnaStatus['border'] }} {{ $warnaStatus['text'] }} text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full {{ $warnaStatus['dot'] }} {{ $dataLaporan->status === 'Menunggu' ? 'animate-pulse' : '' }}"></span>
                            {{ $dataLaporan->status }}
                        </span>
                    </div>

                    <div class="px-5 sm:px-6 py-5">
                        <div class="flex gap-2 mb-6">
                            @php
                                $tahapan = ['Menunggu', 'Proses', 'Selesai'];
                                $indeksAktif = array_search($dataLaporan->status, $tahapan);
                            @endphp
                            @foreach($tahapan as $i => $tahap)
                            <div class="flex-1">
                                <div class="h-1.5 rounded-full {{ $i <= $indeksAktif ? 'bg-gradient-to-r from-indigo-500 to-blue-500' : 'bg-gray-800' }} mb-2 transition-all"></div>
                                <div class="text-xs {{ $i <= $indeksAktif ? 'text-gray-300' : 'text-gray-600' }} font-medium text-center">{{ $tahap }}</div>
                            </div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-5">
                            <div class="bg-gray-800/50 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-1">Dilaporkan pada</div>
                                <div class="text-sm font-semibold text-white">{{ $dataLaporan->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $dataLaporan->created_at->translatedFormat('H:i') }} WIB</div>
                            </div>
                            <div class="bg-gray-800/50 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-1">Koordinat GPS</div>
                                <div class="text-xs font-mono text-indigo-400">{{ $dataLaporan->latitude }}</div>
                                <div class="text-xs font-mono text-indigo-400">{{ $dataLaporan->longitude }}</div>
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500 mb-2 font-medium">Foto Laporan Awal</div>
                            <div class="rounded-xl overflow-hidden bg-gray-800 aspect-video flex items-center justify-center">
                                <img
                                    src="{{ asset('storage/' . $dataLaporan->foto_awal) }}"
                                    alt="Foto kerusakan"
                                    class="w-full h-full object-cover"
                                    onerror="this.parentElement.innerHTML='<div class=\'text-gray-600 text-sm flex flex-col items-center gap-2\'><svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg>Foto tidak tersedia</div>'"
                                >
                            </div>
                        </div>

                        @if($dataLaporan->foto_selesai)
                        <div class="mt-4">
                            <div class="text-xs text-gray-500 mb-2 font-medium flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Foto Setelah Perbaikan
                            </div>
                            <div class="rounded-xl overflow-hidden bg-gray-800 aspect-video">
                                <img src="{{ asset('storage/' . $dataLaporan->foto_selesai) }}" alt="Foto selesai" class="w-full h-full object-cover">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-900/50 border border-white/5 rounded-2xl px-5 py-4 flex items-center justify-between text-sm">
                    <span class="text-gray-500">Ingin melaporkan masalah lain?</span>
                    <a href="{{ route('lapor') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition flex items-center gap-1.5">
                        Buat laporan baru
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            @else

            <div class="hasil-masuk bg-red-950/50 border border-red-500/20 rounded-2xl p-8 text-center">
                <div class="w-14 h-14 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-lg font-bold text-white mb-2">Laporan Tidak Ditemukan</div>
                <div class="text-gray-400 text-sm mb-1">Tidak ada laporan dengan Tracking ID:</div>
                <div class="font-mono text-red-400 font-bold text-lg mb-5">{{ $kodeLacak }}</div>
                <p class="text-gray-500 text-xs mb-6">Pastikan kamu memasukkan kode dengan benar, termasuk awalan <span class="text-indigo-400 font-semibold">SIGAP-</span> dan 6 karakter setelahnya.</p>
                <a href="{{ route('lapor') }}" class="inline-flex items-center gap-2 bg-indigo-600/80 hover:bg-indigo-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                    Buat Laporan Baru
                </a>
            </div>

            @endif
        @endisset

    </main>

</body>
</html>