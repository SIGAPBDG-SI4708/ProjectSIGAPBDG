<!DOCTYPE html>
<html lang="id" x-data="{ gelap: localStorage.getItem('gelap') === 'true' }"
    x-init="$watch('gelap', v => localStorage.setItem('gelap', v))" :class="{ 'dark': gelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Internal — SIGAP BDG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74',
                            400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .bg-halaman {
            background-color: #f8fafc;
            background-image:
                linear-gradient(rgba(249, 115, 22, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249, 115, 22, 0.035) 1px, transparent 1px);
            background-size: 52px 52px;
        }

        .dark .bg-halaman {
            background-color: #020617;
            background-image:
                linear-gradient(rgba(249, 115, 22, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249, 115, 22, 0.06) 1px, transparent 1px);
            background-size: 52px 52px;
        }

        @keyframes naik {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .n1 {
            animation: naik .5s ease .05s both;
        }

        .n2 {
            animation: naik .5s ease .15s both;
        }

        .n3 {
            animation: naik .5s ease .25s both;
        }

        .n4 {
            animation: naik .5s ease .35s both;
        }

        .n5 {
            animation: naik .5s ease .45s both;
        }

        .n6 {
            animation: naik .5s ease .55s both;
        }

        .kartu-fitur {
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .kartu-fitur:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        }

        .kartu-fitur:hover {
            border-color: rgba(203, 213, 225, 0.8);
        }

        .dark .kartu-fitur:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            border-color: rgba(51, 65, 85, 0.9);
        }

        .kartu-fitur-utama:hover {
            border-color: rgba(249, 115, 22, 0.3) !important;
        }

        .dark .kartu-fitur-utama:hover {
            border-color: rgba(249, 115, 22, 0.25) !important;
        }

        .btn-masuk {
            background: #f97316;
            transition: background .18s, transform .13s, box-shadow .18s;
        }

        .btn-masuk:hover {
            background: #ea580c;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.3);
        }

        .btn-masuk:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .btn-daftar {
            transition: border-color .18s, color .18s, background .18s, transform .13s;
        }

        .btn-daftar:hover {
            border-color: #f97316;
            color: #ea580c;
            background: rgba(249, 115, 22, 0.05);
            transform: translateY(-1px);
        }

        .btn-daftar:active {
            transform: translateY(0);
        }

        .hero-img {
            animation: naik .7s ease .3s both;
        }

        .hero-img img {
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.12));
            transition: transform .4s ease;
        }

        .hero-img:hover img {
            transform: translateY(-4px);
        }

        .dark .hero-img img {
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.4)) brightness(0.92);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="bg-halaman antialiased min-h-screen flex flex-col transition-colors duration-300">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="{{ asset('images/portal/section-background-texture.png') }}" alt=""
            class="w-full h-full object-cover opacity-50 dark:invert dark:hue-rotate-180 dark:opacity-50"
            aria-hidden="true">
    </div>

    <header
        class="n1 sticky top-0 z-30 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-200/70 dark:border-slate-800/70">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 bg-brand-500 rounded-xl flex items-center justify-center shadow shadow-brand-500/25 flex-shrink-0">
                    <svg style="width:18px;height:18px" class="text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <span class="font-black text-slate-900 dark:text-white text-base tracking-tight">SIGAP<span
                            class="text-brand-500">BDG</span></span>
                    <span class="hidden sm:inline text-slate-400 dark:text-slate-500 text-xs font-medium ml-2">Portal
                        Internal</span>
                </div>
            </div>

            <button @click="gelap = !gelap"
                class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-brand-500 transition-all">
                <span x-show="!gelap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </span>
                <span x-show="gelap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </span>
            </button>
        </div>
    </header>

    <main class="relative z-10 flex-1 flex flex-col">

        <section class="relative z-10 max-w-6xl mx-auto px-6 pt-14 pb-10 w-full">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                <div>
                    <h1 class="n2 text-slate-900 dark:text-white font-black leading-tight tracking-tight mb-5"
                        style="font-size:clamp(2rem,3.5vw,3rem);">
                        Portal Komando<br>
                        <span class="text-brand-500">Infrastruktur</span><br>
                        Kota Bandung
                    </h1>

                    <p class="n3 text-slate-500 dark:text-slate-400 text-base leading-relaxed mb-8 max-w-lg">
                        Platform terpadu untuk manajemen laporan infrastruktur, pemantauan wilayah, dan koordinasi
                        respons cepat antar dinas Pemerintah Kota Bandung.
                    </p>

                    <div class="n4 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('masuk') }}"
                            class="btn-masuk text-white font-bold py-3.5 px-7 rounded-xl flex items-center justify-center gap-2 text-sm shadow-md shadow-brand-500/15">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk ke Portal
                        </a>
                        <a href="{{ route('daftar') }}"
                            class="btn-daftar border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-3.5 px-7 rounded-xl flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Ajukan Pendaftaran
                        </a>
                    </div>

                    <p class="n4 text-xs text-slate-400 dark:text-slate-600 mt-4">
                        Pendaftaran membutuhkan persetujuan Super Administrator sebelum akun aktif.
                    </p>
                </div>

                <div class="hero-img hidden lg:flex items-center justify-center">
                    <img src="{{ asset('images/portal/hero-ilustrator.png') }}" alt="Dashboard Infrastruktur SIGAP BDG"
                        class="w-full max-w-xl object-contain rounded-2xl
               animate-[float_4s_ease-in-out_infinite]
               transition-all duration-500
               hover:scale-105 hover:-translate-y-2 hover:rotate-1" loading="eager">
                </div>

            </div>
        </section>

        <section class="relative z-10 max-w-6xl mx-auto px-6 pb-16 w-full">

            <div class="n5 border-t border-slate-200/50 dark:border-slate-800/70 pt-10 mb-8"></div>

            <p class="n5 text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest mb-5">Fitur
                &amp; Akses</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 n6">

                <div
                    class="kartu-fitur kartu-fitur-utama bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm cursor-default">
                    <div
                        class="w-9 h-9 bg-brand-50 dark:bg-brand-500/10 rounded-xl flex items-center justify-center mb-3">
                        <svg style="width:18px;height:18px" class="text-brand-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Laporan Masuk</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 leading-snug">Kelola laporan infrastruktur
                        dari warga secara real-time</div>
                </div>

                <div
                    class="kartu-fitur bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm cursor-default">
                    <div
                        class="w-9 h-9 bg-brand-50 dark:bg-brand-500/10 rounded-xl flex items-center justify-center mb-3">
                        <svg style="width:18px;height:18px" class="text-brand-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Peta Wilayah</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 leading-snug">Pemantauan sebaran laporan
                        berdasarkan lokasi geografis</div>
                </div>

                <div
                    class="kartu-fitur bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm cursor-default">
                    <div
                        class="w-9 h-9 bg-brand-50 dark:bg-brand-500/10 rounded-xl flex items-center justify-center mb-3">
                        <svg style="width:18px;height:18px" class="text-brand-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Pengajuan Dana</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 leading-snug">Proses persetujuan alokasi
                        anggaran perbaikan infrastruktur</div>
                </div>

                <div
                    class="kartu-fitur bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm cursor-default">
                    <div
                        class="w-9 h-9 bg-brand-50 dark:bg-brand-500/10 rounded-xl flex items-center justify-center mb-3">
                        <svg style="width:18px;height:18px" class="text-brand-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Manajemen Pegawai</div>
                    <div class="text-xs text-slate-400 dark:text-slate-500 leading-snug">Kelola akun dan akses pegawai
                        tiap daerah</div>
                </div>

            </div>
        </section>

    </main>

    <footer
        class="relative z-10 border-t border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <p class="text-xs text-slate-400 dark:text-slate-600">© 2026 SIGAP BDG · Pemerintah Kota Bandung</p>
            <a href="{{ route('beranda') }}"
                class="text-xs text-slate-400 hover:text-brand-500 dark:hover:text-brand-400 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda Publik
            </a>
        </div>
    </footer>

</body>

</html>