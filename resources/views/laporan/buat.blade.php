<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true', sedangMemproses: false }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Buat Laporan - SIGAP BDG</title>
    <meta name="description"
        content="Laporkan kerusakan infrastruktur di Kota Bandung secara mudah dan gratis tanpa perlu login.">

    <meta name="theme-color" content="#f97316">
    <link rel="apple-touch-icon" href="https://ui-avatars.com/api/?name=SIGAP+BDG&background=f97316&color=fff&size=180">
    <link rel="shortcut icon" href="https://ui-avatars.com/api/?name=SB&background=f97316&color=fff&size=32">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        .gradient-text {
            background: linear-gradient(135deg, #fb923c, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        #pratinjauFoto {
            transition: opacity 0.3s ease;
        }

        .upload-area {
            transition: border-color 0.2s, background-color 0.2s;
        }

        .status-lokasi {
            transition: all 0.3s ease;
        }

        .swal-kustom-popup {
            border-radius: 1.5rem !important;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.7);
        }

        /* ── Print-Out Receipt Animation ── */
        #struk-overlay {
            display: none;
        }
        #struk-overlay.aktif {
            display: flex;
        }

        .struk-kertas {
            font-family: 'Courier New', Courier, monospace;
            transform: translateY(-120%);
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s ease;
        }
        .struk-kertas.masuk {
            transform: translateY(0);
            opacity: 1;
        }

        /* Garis perforasi atas/bawah struk */
        .perforasi {
            background-image: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 6px,
                currentColor 6px,
                currentColor 12px
            );
            height: 2px;
        }

        /* Animasi garis printer */
        @keyframes scanLine {
            0%   { top: 0; opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .scan-line {
            animation: scanLine 0.8s ease-out forwards;
        }

        /* Efek ketik teks kode */
        @keyframes ketik {
            from { width: 0; }
            to   { width: 100%; }
        }
        .efek-ketik {
            overflow: hidden;
            white-space: nowrap;
            animation: ketik 0.8s steps(12, end) 0.7s forwards;
            width: 0;
        }

        /* Salin berhasil */
        .salin-ok {
            transition: all 0.2s;
        }
    </style>
</head>

<body
    class="bg-stone-50 dark:bg-slate-950 text-stone-800 dark:text-slate-100 transition-colors duration-300 min-h-screen">

    <!-- ══════════════════════════════════════════
         PRINT-OUT RECEIPT OVERLAY
         Muncul setelah laporan berhasil terkirim
         ════════════════════════════════════════ -->
    <div id="struk-overlay"
        class="fixed inset-0 z-50 flex items-start justify-center bg-stone-950/70 dark:bg-slate-950/80 backdrop-blur-sm pt-12 pb-6 overflow-y-auto">

        <!-- Printer visual atas -->
        <div class="w-full max-w-sm">
            <!-- Badan printer -->
            <div class="mx-auto w-56 h-10 bg-stone-700 dark:bg-slate-700 rounded-xl flex items-center justify-center shadow-xl relative">
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></div>
                    <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
                </div>
                <!-- slot keluar kertas -->
                <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-32 h-3 bg-stone-600 dark:bg-slate-600 rounded-b-lg"></div>
            </div>

            <!-- Struk Kertas -->
            <div class="struk-kertas mx-auto w-full max-w-sm" id="struk-kertas">
                <!-- Kertas struk utama -->
                <div class="bg-white dark:bg-slate-50 shadow-2xl relative overflow-hidden" style="border-radius: 0 0 4px 4px;">

                    <!-- Garis scan printer (animasi) -->
                    <div id="garisScanner"
                        class="absolute left-0 right-0 h-1 bg-gradient-to-b from-brand-400/60 to-transparent z-10 pointer-events-none"
                        style="top:0;"></div>

                    <!-- Perforasi atas -->
                    <div class="perforasi text-stone-300 mx-4 mt-4 mb-3"></div>

                    <!-- Header struk -->
                    <div class="px-6 py-2 text-center">
                        <div class="text-xs font-bold text-stone-400 tracking-widest uppercase mb-1">SIGAP BDG</div>
                        <div class="text-[10px] text-stone-400">Sistem Informasi Gerak Akselerasi Pelayanan</div>
                        <div class="text-[10px] text-stone-400">Kota Bandung</div>
                    </div>

                    <!-- Garis tengah -->
                    <div class="border-t border-dashed border-stone-200 mx-4"></div>

                    <!-- Body struk -->
                    <div class="px-6 py-4 space-y-3">
                        <div class="flex justify-between text-[11px] text-stone-500">
                            <span>Jenis</span>
                            <span class="font-semibold text-stone-700">Infrastruktur</span>
                        </div>
                        <div class="flex justify-between text-[11px] text-stone-500">
                            <span>Status</span>
                            <span class="font-semibold text-amber-600">Menunggu</span>
                        </div>
                        <div class="flex justify-between text-[11px] text-stone-500">
                            <span>Tanggal</span>
                            <span id="struk-tanggal" class="font-semibold text-stone-700"></span>
                        </div>
                        <div class="flex justify-between text-[11px] text-stone-500">
                            <span>Waktu</span>
                            <span id="struk-waktu" class="font-semibold text-stone-700"></span>
                        </div>
                    </div>

                    <!-- Garis tengah -->
                    <div class="border-t border-dashed border-stone-200 mx-4"></div>

                    <!-- Tracking ID besar -->
                    <div class="px-6 py-5 text-center">
                        <div class="text-[10px] text-stone-400 uppercase tracking-widest mb-2">Tracking ID Anda</div>
                        <!-- Kode bisa diseleksi & dicopy -->
                        <div id="struk-kode"
                            class="efek-ketik inline-block text-2xl font-black tracking-widest text-stone-900 font-mono select-all cursor-text"
                            style="letter-spacing: 0.15em;"></div>
                        <!-- Barcode visual dekoratif -->
                        <div class="mt-3 flex justify-center gap-0.5 items-end h-8">
                            @foreach(range(1,28) as $b)
                            <div class="bg-stone-800" style="width: {{ rand(1,3) }}px; height: {{ rand(12,32) }}px;"></div>
                            @endforeach
                        </div>
                        <div class="text-[9px] text-stone-400 mt-1 font-mono" id="struk-kode-kecil"></div>
                    </div>

                    <!-- Perforasi bawah -->
                    <div class="border-t border-dashed border-stone-200 mx-4"></div>
                    <div class="px-6 py-3 text-center">
                        <div class="text-[10px] text-stone-400">Simpan kode ini untuk melacak laporan Anda</div>
                        <div class="text-[10px] text-stone-400">sigapbdg.go.id/lacak</div>
                    </div>

                    <!-- Perforasi robek bawah -->
                    <div class="perforasi text-stone-300 mx-4 mb-4"></div>

                    <!-- Tombol aksi -->
                    <div class="px-6 pb-6 flex flex-col gap-2">
                        <button id="tombolSalinStruk" onclick="salinKodeStruk()"
                            class="salin-ok w-full bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            Salin Kode
                        </button>
                        <a id="tombolLacakStruk" href="#"
                            class="w-full bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-brand-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Lacak Laporan
                        </a>
                        <button onclick="tutupStruk()"
                            class="w-full text-stone-400 hover:text-stone-600 text-xs py-2 transition">
                            Kembali ke Form
                        </button>
                    </div>
                </div>

                <!-- Ujung kertas robek -->
                <div class="h-3 bg-white dark:bg-slate-50" style="clip-path: polygon(0 0, 5% 100%, 10% 0, 15% 100%, 20% 0, 25% 100%, 30% 0, 35% 100%, 40% 0, 45% 100%, 50% 0, 55% 100%, 60% 0, 65% 100%, 70% 0, 75% 100%, 80% 0, 85% 100%, 90% 0, 95% 100%, 100% 0);"></div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav
        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 shadow-sm border-b border-stone-100 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand -->
                <a href="{{ route('beranda') }}" class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-md shadow-brand-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-stone-900 dark:text-white">SIGAP<span
                            class="text-brand-500">BDG</span></span>
                </a>

                <!-- Nav Links -->
                <!-- <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('beranda') }}"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Beranda</a>
                    <a href="{{ route('lacak') }}"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Lacak Laporan
                    </a>
                </div> -->

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    <!-- Dark mode toggle -->
                    <button @click="temaGelap = !temaGelap"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-stone-100 dark:bg-slate-800 text-stone-500 dark:text-slate-400 hover:text-brand-500 transition">
                        <span x-show="!temaGelap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </span>
                        <span x-show="temaGelap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                        </span>
                    </button>
                    <!-- Buat Laporan CTA -->
                    <a href="{{ route('lacak') }}"
                        class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-md shadow-brand-500/20 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Lacak Laporan
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-12 pb-20">

        <!-- Success tracking alert -->
        @if(session('trackingBerhasil'))
            <div
                class="mb-8 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-700/40 rounded-3xl p-6 relative overflow-hidden shadow-sm">
                <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-11 h-11 bg-emerald-100 dark:bg-emerald-900/50 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-emerald-700 dark:text-emerald-300 font-bold text-base">Laporan Berhasil
                                Dikirim!</div>
                            <div class="text-emerald-600/70 dark:text-emerald-500 text-xs">Simpan kode tracking berikut
                                untuk memantau status laporan Anda</div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-slate-900 border border-emerald-200 dark:border-emerald-700/40 rounded-2xl p-4 flex items-center justify-between gap-3 shadow-sm">
                        <div>
                            <div class="text-xs text-stone-400 dark:text-slate-500 mb-0.5">Tracking ID Anda</div>
                            <div id="kodeTracking"
                                class="text-2xl font-black tracking-widest text-stone-800 dark:text-white font-mono">
                                {{ session('trackingBerhasil') }}
                            </div>
                        </div>
                        <button onclick="salinKode()"
                            class="flex-shrink-0 bg-emerald-100 dark:bg-emerald-900/50 hover:bg-emerald-200 dark:hover:bg-emerald-900 border border-emerald-200 dark:border-emerald-700/40 text-emerald-700 dark:text-emerald-400 text-xs font-semibold px-4 py-2 rounded-xl transition">Salin</button>
                    </div>
                    <a href="{{ route('lacak') }}"
                        class="mt-3 inline-flex text-xs text-brand-500 hover:text-brand-600 dark:text-brand-400 transition font-medium items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Lacak laporan ini sekarang
                    </a>
                </div>
            </div>
        @endif

        <!-- Errors -->
        @if($errors->any())
            <div
                class="mb-6 bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-700/40 rounded-2xl p-4 shadow-sm">
                <ul class="space-y-1.5">
                    @foreach($errors->all() as $pesan)
                        <li class="text-red-600 dark:text-red-400 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $pesan }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Header -->
        <div class="mb-10">
            <div
                class="inline-flex items-center gap-2 bg-brand-100 dark:bg-brand-500/10 border border-brand-200 dark:border-brand-500/20 text-brand-600 dark:text-brand-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Laporan Infrastruktur
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-stone-900 dark:text-white leading-tight mb-3">
                Laporkan <span class="gradient-text">Kerusakan</span>
            </h1>
            <p class="text-stone-500 dark:text-slate-400 text-base leading-relaxed">
                Foto kerusakan infrastruktur di sekitar Anda. Lokasi GPS akan terdeteksi otomatis. Tidak perlu login,
                gratis.
            </p>
        </div>

        <!-- Form -->
        <form id="formLaporan" action="{{ route('proses.laporan') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            <input type="hidden" id="inputLatitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="inputLongitude" name="longitude" value="{{ old('longitude') }}">

            <!-- GPS Card -->
            <div
                class="glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-white/40 dark:border-slate-700/50 rounded-3xl p-5 sm:p-6 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-sm font-semibold text-stone-800 dark:text-white mb-0.5">Lokasi GPS</div>
                        <div class="text-xs text-stone-400 dark:text-slate-500">Koordinat dideteksi otomatis dari
                            perangkat Anda</div>
                    </div>
                    <div id="ikonLokasi"
                        class="w-11 h-11 bg-stone-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center transition-all">
                        <svg class="w-5 h-5 text-stone-400 dark:text-slate-500 animate-spin" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div id="statusLokasi"
                    class="status-lokasi bg-stone-100 dark:bg-slate-700/60 rounded-2xl px-4 py-3 text-xs text-stone-500 dark:text-slate-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse flex-shrink-0"></span>
                    Mendeteksi lokasi... Izinkan akses GPS jika diminta.
                </div>
            </div>

            <!-- Photo Upload Card -->
            <div
                class="glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-white/40 dark:border-slate-700/50 rounded-3xl p-5 sm:p-6 shadow-xl">
                <div class="text-sm font-semibold text-stone-800 dark:text-white mb-1">Foto Kerusakan</div>
                <div class="text-xs text-stone-400 dark:text-slate-500 mb-4">Upload foto jalan berlubang atau kerusakan
                    infrastruktur (maks. 5MB)</div>
                <label for="inputFoto"
                    class="upload-area border-2 border-dashed border-stone-200 dark:border-slate-600 hover:border-brand-400 dark:hover:border-brand-500 rounded-2xl p-8 flex flex-col items-center justify-center cursor-pointer gap-3 relative group bg-stone-50/80 dark:bg-slate-900/50 hover:bg-brand-50/50 dark:hover:bg-brand-500/5 transition-all">
                    <div id="ikonUpload" class="text-center">
                        <div
                            class="w-14 h-14 bg-stone-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-brand-100 dark:group-hover:bg-brand-500/20 transition">
                            <svg class="w-7 h-7 text-stone-400 dark:text-slate-500 group-hover:text-brand-500 dark:group-hover:text-brand-400 transition"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-stone-600 dark:text-slate-300">Klik untuk pilih foto</div>
                        <div class="text-xs text-stone-400 dark:text-slate-500 mt-1">atau seret dan lepas file di sini
                        </div>
                    </div>
                    <img id="pratinjauFoto" src="" alt="Pratinjau"
                        class="hidden max-h-60 rounded-2xl object-cover w-full opacity-0">
                    <input type="file" id="inputFoto" name="foto" accept="image/*" class="hidden">
                </label>
            </div>

            <!-- Submit Button -->
            <button type="button" id="tombolKirim" @click.prevent="munculkanLoadingSwal()"
                class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-4 px-6 rounded-full shadow-lg shadow-brand-500/30 flex items-center justify-center gap-2 transition-all duration-300 hover:-translate-y-1 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kirim Laporan Sekarang
            </button>

            <p class="text-center text-xs text-stone-400 dark:text-slate-500">Dengan mengirim laporan, Anda menyetujui
                bahwa data ini akan diproses oleh sistem SIGAP BDG.</p>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-600 dark:bg-slate-900 pt-10 pb-6 text-white transition-colors duration-300 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight">SIGAP BDG</span>
                </div>
                <p class="text-sm text-brand-200 dark:text-slate-500">© 2026 SIGAP BDG. Hak Cipta Dilindungi.</p>
                <div class="flex gap-5 text-sm text-brand-200 dark:text-slate-400">
                    <a href="{{ route('beranda') }}" class="hover:text-white transition">Beranda</a>
                    <a href="{{ route('lacak') }}" class="hover:text-white transition">Lacak</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
            (function () {
                var inputLat = document.getElementById('inputLatitude');
                var inputLng = document.getElementById('inputLongitude');
                var statusEl = document.getElementById('statusLokasi');
                var ikonEl = document.getElementById('ikonLokasi');

                function berhasil(posisi) {
                    var lat = posisi.coords.latitude.toFixed(8);
                    var lng = posisi.coords.longitude.toFixed(8);
                    inputLat.value = lat;
                    inputLng.value = lng;
                    statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></span> Lokasi terdeteksi: ' + lat + ', ' + lng;
                    statusEl.classList.remove('text-stone-500', 'text-slate-400');
                    statusEl.classList.add('text-emerald-600', 'dark:text-emerald-400');
                    ikonEl.innerHTML = '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                    ikonEl.classList.add('bg-emerald-50', 'dark:bg-emerald-900/30');
                    ikonEl.classList.remove('bg-stone-100', 'dark:bg-slate-700');
                }

                function gagal() {
                    statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-400 flex-shrink-0"></span> Gagal mendeteksi lokasi. Pastikan GPS aktif dan izin diberikan.';
                    statusEl.classList.remove('text-stone-500', 'text-slate-400');
                    statusEl.classList.add('text-red-500', 'dark:text-red-400');
                    ikonEl.innerHTML = '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    ikonEl.classList.add('bg-red-50', 'dark:bg-red-900/30');
                    ikonEl.classList.remove('bg-stone-100', 'dark:bg-slate-700');
                }

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(berhasil, gagal, { timeout: 10000 });
                } else {
                    gagal();
                }

                var inputFoto = document.getElementById('inputFoto');
                var pratinjau = document.getElementById('pratinjauFoto');
                var ikonUpload = document.getElementById('ikonUpload');

                inputFoto.addEventListener('change', function () {
                    var berkas = this.files[0];
                    if (!berkas) return;
                    var pembaca = new FileReader();
                    pembaca.onload = function (e) {
                        pratinjau.src = e.target.result;
                        pratinjau.classList.remove('hidden');
                        pratinjau.style.opacity = '1';
                        ikonUpload.classList.add('hidden');
                    };
                    pembaca.readAsDataURL(berkas);
                });

                function salinKode() {
                    var kode = document.getElementById('kodeTracking').innerText;
                    navigator.clipboard.writeText(kode);
                }
                window.salinKode = salinKode;
            })();

        // ── Submit → Animasi Proses + Print Struk ──
        function munculkanLoadingSwal() {
            var foto = document.getElementById('inputFoto');
            if (!foto || !foto.files || !foto.files[0]) {
                alert('Harap pilih foto kerusakan terlebih dahulu.');
                return;
            }

            // Tampilkan overlay loading ringan sementara form submit
            var tombol = document.getElementById('tombolKirim');
            tombol.disabled = true;
            tombol.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Memproses...';

            document.getElementById('formLaporan').submit();
        }

        // ── Animasi Print-Out Struk setelah laporan berhasil ──
        @if(session('trackingBerhasil'))
        (function () {
            var kode = '{{ session("trackingBerhasil") }}';
            var lacakUrl = '{{ route("lacak") }}?tracking_id=' + kode;
            var overlay   = document.getElementById('struk-overlay');
            var kertas    = document.getElementById('struk-kertas');
            var elKode    = document.getElementById('struk-kode');
            var elKodeKecil = document.getElementById('struk-kode-kecil');
            var elTanggal = document.getElementById('struk-tanggal');
            var elWaktu   = document.getElementById('struk-waktu');
            var scanner   = document.getElementById('garisScanner');

            // Isi data dinamis
            var now = new Date();
            var tgl = now.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
            var jam = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' }) + ' WIB';
            elTanggal.textContent = tgl;
            elWaktu.textContent   = jam;
            elKode.textContent    = kode;
            elKodeKecil.textContent = kode;

            // Set link lacak
            document.getElementById('tombolLacakStruk').href = lacakUrl;

            // Tampilkan overlay
            overlay.classList.add('aktif');
            document.body.style.overflow = 'hidden';

            // Animasi scan printer
            setTimeout(function () {
                kertas.classList.add('masuk');

                // Animasi scanner line
                if (scanner) {
                    scanner.classList.add('scan-line');
                }
            }, 100);
        })();
        @endif

        // Salin kode tracking dari struk
        function salinKodeStruk() {
            var kode = document.getElementById('struk-kode').textContent.trim();
            navigator.clipboard.writeText(kode).then(function () {
                var tombol = document.getElementById('tombolSalinStruk');
                tombol.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin!';
                tombol.classList.add('bg-emerald-100', 'text-emerald-700');
                setTimeout(function () {
                    tombol.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg> Salin Kode';
                    tombol.classList.remove('bg-emerald-100', 'text-emerald-700');
                }, 2000);
            });
        }

        // Tutup struk dan kembali ke form
        function tutupStruk() {
            var overlay = document.getElementById('struk-overlay');
            var kertas  = document.getElementById('struk-kertas');
            kertas.classList.remove('masuk');
            setTimeout(function () {
                overlay.classList.remove('aktif');
                document.body.style.overflow = '';
            }, 400);
        }
    </script>

</body>

</html>