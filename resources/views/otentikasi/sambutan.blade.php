<!DOCTYPE html>
<html lang="id"
    x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true', bukaModalMasuk: {{ $errors->any() ? 'true' : 'false' }}, lihatSandi: false }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pegawai — SIGAP BDG</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .dot-grid-pattern {
            background-image: radial-gradient(rgba(249, 115, 22, 0.12) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-gradient-orange {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .bg-gradient-orange:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        }

        .mesh-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            z-index: 0;
            opacity: 0.18;
            animation: blobFloat 18s infinite ease-in-out alternate;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }

            40% {
                transform: translate(25px, -45px) scale(1.08);
            }

            100% {
                transform: translate(-15px, 25px) scale(0.92);
            }
        }

        .float-shape {
            animation: shapeFloat 7s ease-in-out infinite;
        }

        @keyframes shapeFloat {

            0%,
            100% {
                transform: translateY(0) rotate(12deg);
            }

            50% {
                transform: translateY(-14px) rotate(18deg);
            }
        }

        .float-shape-2 {
            animation: shapeFloat2 5.5s ease-in-out infinite;
        }

        @keyframes shapeFloat2 {

            0%,
            100% {
                transform: translateY(0) rotate(-12deg);
            }

            50% {
                transform: translateY(-10px) rotate(-18deg);
            }
        }

        .float-shape-3 {
            animation: shapeFloat3 9s ease-in-out infinite;
        }

        @keyframes shapeFloat3 {

            0%,
            100% {
                transform: translateY(0) rotate(45deg);
            }

            50% {
                transform: translateY(-8px) rotate(52deg);
            }
        }

        .pulse-dot {
            animation: pulseRing 2.2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulseRing {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.6);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .wave-underline {
            text-decoration: underline wavy #f97316;
            text-underline-offset: 10px;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-1 {
            animation: fadeSlideUp 0.5s ease 0.05s both;
        }

        .anim-2 {
            animation: fadeSlideUp 0.5s ease 0.15s both;
        }

        .anim-3 {
            animation: fadeSlideUp 0.5s ease 0.25s both;
        }

        .anim-4 {
            animation: fadeSlideUp 0.5s ease 0.35s both;
        }

        .anim-5 {
            animation: fadeSlideUp 0.5s ease 0.45s both;
        }

        .anim-6 {
            animation: fadeSlideUp 0.5s ease 0.55s both;
        }

        .anim-7 {
            animation: fadeSlideUp 0.5s ease 0.65s both;
        }

        .input-orange:focus {
            outline: none;
            border-color: #f97316 !important;
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.15);
        }

        .dark .input-orange:focus {
            background-color: #1e293b !important;
        }

        .swal-kustom-popup {
            border-radius: 1.5rem !important;
        }
    </style>
</head>

<body
    class="bg-slate-50 dark:bg-slate-950 antialiased overflow-x-hidden min-h-screen flex transition-colors duration-300">

    <!-- ════════════�    <div class="flex w-full min-h-screen">

        <div
            class="hidden lg:flex w-[60%] bg-[#0f172a] dark:bg-[#080d18] relative overflow-hidden flex-col justify-between p-12 xl:p-16 transition-colors duration-300">

            <div class="absolute inset-0 dot-grid-pattern z-0 opacity-60 pointer-events-none"></div>
            <div class="mesh-blob w-[500px] h-[500px] bg-orange-600 top-[-15%] left-[-15%]"></div>
            <div class="mesh-blob w-[600px] h-[600px] bg-orange-500 bottom-[-20%] right-[-15%]"
                style="animation-delay:-7s"></div>
            <div class="mesh-blob w-72 h-72 bg-amber-500 top-[40%] left-[40%]"
                style="animation-delay:-12s; opacity:0.08"></div>

            <div
                class="float-shape absolute top-[28%] right-[14%] w-16 h-16 rounded-2xl border border-orange-500/30 bg-orange-500/10 backdrop-blur-sm z-10 shadow-[0_0_35px_rgba(249,115,22,0.2)]">
            </div>
            <div
                class="float-shape-2 absolute top-[62%] left-[8%] w-11 h-11 rounded-xl border border-orange-400/25 bg-orange-400/10 backdrop-blur-sm z-10 shadow-[0_0_20px_rgba(234,88,12,0.2)]">
            </div>
            <div
                class="float-shape-3 absolute bottom-[22%] right-[26%] w-9 h-9 rounded-lg border border-orange-400/20 bg-orange-400/5 backdrop-blur-sm z-10 shadow-[0_0_15px_rgba(249,115,22,0.1)]">
            </div>

            <div class="relative z-10 h-full flex flex-col">

                <div class="flex justify-between items-start mb-auto anim-1">
                    <div class="flex items-center gap-3.5">
                        <div
                            class="w-11 h-11 rounded-2xl bg-gradient-orange flex items-center justify-center shadow-lg shadow-orange-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-white font-black text-xl tracking-tight leading-none">SIGAP<span
                                    class="font-light opacity-80">BDG</span></div>
                            <div class="text-orange-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">Portal
                                Internal</div>
                        </div>
                    </div>
                    <div class="glass-panel px-4 py-2 rounded-full flex items-center gap-2 border-green-500/30 border">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500 pulse-dot"></div>
                        <span class="text-green-400 text-xs font-bold uppercase tracking-wide">Sistem Aktif</span>
                    </div>
                </div>

                <div class="my-auto max-w-2xl">
                    <div class="anim-2 mb-2">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-300 text-[10px] font-bold uppercase tracking-widest mb-6">
                            Akses Terkontrol
                        </span>
                    </div>

                    <h2 class="anim-3 text-white font-black leading-[1.02] tracking-tight mb-5"
                        style="font-size: clamp(3rem, 5vw, 4.5rem);">
                        Portal<br>
                        <span class="text-gradient-orange wave-underline">Komando</span>
                    </h2>

                    <p class="anim-4 text-slate-400 text-lg leading-relaxed mb-10 max-w-lg">
                        Sistem Informasi Gerak Akselerasi Pelayanan. Manajemen data, analitik prediktif, dan operasional
                        real-time Kota Bandung.
                    </p>

                    <div class="anim-5 flex flex-wrap gap-3">
                        <div
                            class="glass-panel rounded-full px-4 py-2.5 flex items-center gap-2 hover:bg-white/10 transition-colors cursor-default">
                            <svg class="w-4 h-4 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span class="text-white text-xs font-semibold">Peta Wilayah</span>
                        </div>
                        <div
                            class="glass-panel rounded-full px-4 py-2.5 flex items-center gap-2 hover:bg-white/10 transition-colors cursor-default">
                            <svg class="w-4 h-4 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white text-xs font-semibold">Analisis AI</span>
                        </div>
                        <div
                            class="glass-panel rounded-full px-4 py-2.5 flex items-center gap-2 hover:bg-white/10 transition-colors cursor-default">
                            <svg class="w-4 h-4 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-xs font-semibold">Verifikasi</span>
                        </div>
                        <div
                            class="glass-panel rounded-full px-4 py-2.5 flex items-center gap-2 hover:bg-white/10 transition-colors cursor-default">
                            <svg class="w-4 h-4 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white text-xs font-semibold">Pengajuan Dana</span>
                        </div>
                    </div>
                </div>

                <div class="mt-auto anim-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div
                            class="glass-panel rounded-2xl p-4 hover:-translate-y-1 transition-transform duration-300 cursor-default">
                            <div class="w-8 h-8 rounded-xl bg-orange-500/20 flex items-center justify-center mb-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="text-white font-black text-base mb-0.5">24/7</div>
                            <div class="text-slate-500 text-xs">Pemantauan</div>
                        </div>
                        <div
                            class="glass-panel rounded-2xl p-4 hover:-translate-y-1 transition-transform duration-300 cursor-default">
                            <div class="w-8 h-8 rounded-xl bg-orange-500/20 flex items-center justify-center mb-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="text-white font-black text-base mb-0.5">AI</div>
                            <div class="text-slate-500 text-xs">Bertenaga</div>
                        </div>
                        <div
                            class="glass-panel rounded-2xl p-4 hover:-translate-y-1 transition-transform duration-300 cursor-default">
                            <div class="w-8 h-8 rounded-xl bg-orange-500/20 flex items-center justify-center mb-3">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <div class="text-white font-black text-base mb-0.5">BDG</div>
                            <div class="text-slate-500 text-xs">Bandung</div>
                        </div>
                    </div>

                    <div
                        class="mt-8 pt-6 border-t border-white/8 flex justify-between items-center text-slate-600 text-xs">
                        <span>© 2026 SIGAP BDG · Pemerintah Kota Bandung</span>
                        <span>v4.2.1</span>
                    </div>
                </div>

            </div>
        </div>

        <div
            class="w-full lg:w-[40%] bg-white dark:bg-slate-900 relative flex flex-col justify-center px-8 md:px-14 lg:px-16 xl:px-20 py-12 shadow-[-24px_0_48px_rgba(0,0,0,0.06)] z-20 transition-colors duration-300">

            <div class="flex lg:hidden items-center gap-3 mb-10 anim-1">tive flex flex-col justify-center px-8 md:px-14 lg:px-16 xl:px-20 py-12 shadow-[-24px_0_48px_rgba(0,0,0,0.06)] z-20 transition-colors duration-300">

            <!-- Mobile: Brand header -->
            <div class="flex lg:hidden items-center gap-3 mb-10 anim-1">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-orange flex items-center justify-center shadow-lg shadow-orange-500/25">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="font-black text-xl tracking-tight text-slate-900 dark:text-white">SIGAP<span
                        class="font-light text-slate-400">BDG</span></div>
            </div>

            <div class="max-w-md w-full mx-auto">

                <div class="mb-8 anim-2">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 mb-5">
                        <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div>
                        <span
                            class="text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-widest">Masuk
                            ke Sistem</span>
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white leading-tight mb-2 tracking-tight">
                        Selamat Datang<span class="text-orange-500">.</span>
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed">
                        Silakan masuk menggunakan kredensial instansi Anda untuk mengakses portal komando.
                    </p>
                </div>

                @if($errors->any())
                    <div
                        class="anim-3 mb-6 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-500/20 rounded-2xl px-4 py-3.5 flex items-start gap-3">
                        <div
                            class="w-7 h-7 bg-red-100 dark:bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm text-red-600 dark:text-red-400 leading-relaxed">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('proses.masuk') }}" class="space-y-5">
                    @csrf

                    <div class="anim-4">
                        <label for="email"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email
                            Kedinasan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4.5 h-4.5 text-slate-400" style="width:18px;height:18px" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="input-orange block w-full pl-11 pr-4 py-3.5 bg-slate-100 dark:bg-slate-800/70 border border-transparent dark:border-slate-700/50 rounded-2xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-600 text-sm transition-all duration-200"
                                placeholder="pegawai@bandung.go.id">
                        </div>
                    </div>

                    <div class="anim-5">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Kata
                                Sandi</label>
                        </div>
                        <div class="relative" x-data="{ lihat: false }">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg style="width:18px;height:18px" class="text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input :type="lihat ? 'text' : 'password'" id="password" name="password" required
                                class="input-orange block w-full pl-11 pr-12 py-3.5 bg-slate-100 dark:bg-slate-800/70 border border-transparent dark:border-slate-700/50 rounded-2xl text-slate-900 dark:text-slate-100 placeholder-slate-400 text-sm transition-all duration-200"
                                placeholder="••••••••">
                            <button type="button" @click="lihat = !lihat"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!lihat" style="width:18px;height:18px" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="lihat" style="width:18px;height:18px;display:none" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="anim-6 pt-2">
                        <button type="submit"
                            class="group w-full bg-gradient-orange text-white font-bold py-4 px-6 rounded-2xl flex items-center justify-center gap-2 shadow-xl shadow-orange-500/20 hover:shadow-orange-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 text-base">
                            Masuk ke Portal
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="relative my-7 anim-7">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200 dark:border-slate-700/60"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="px-4 bg-white dark:bg-slate-900 text-slate-400 text-sm font-medium transition-colors duration-300">atau</span>
                    </div>
                </div>

                <div class="anim-7">
                    <a href="{{ route('daftar') }}"
                        class="group w-full border-2 border-slate-200 dark:border-slate-700/60 text-slate-700 dark:text-slate-300 font-bold py-3.5 px-6 rounded-2xl flex items-center justify-center gap-2 hover:border-orange-400 dark:hover:border-orange-500 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-500/5 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Daftar Akun Baru
                    </a>
                </div>

                <div
                    class="mt-6 flex items-start gap-3 p-4 bg-orange-50 dark:bg-orange-500/5 rounded-2xl border border-orange-100 dark:border-orange-500/15">
                    <svg class="w-4 h-4 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">
                        Pendaftaran memerlukan persetujuan <span
                            class="font-semibold text-slate-700 dark:text-slate-300">Super Administrator</span> sebelum
                        akun diaktifkan.
                    </p>
                </div>

            </div>

            <div class="absolute bottom-6 right-6">
                <button @click="temaGelap = !temaGelap"
                    class="w-10 h-10 flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 hover:scale-110 transition-all shadow-sm">
                    <span x-show="!temaGelap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="temaGelap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </span>
                </button>
            </div>

        </div>
    </div>

    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var gelap = localStorage.getItem('temaGelap') === 'true';
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('warning') }}',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'swal-kustom-popup',
                        confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-semibold',
                    },
                    background: gelap ? '#0f172a' : '#ffffff',
                    color: gelap ? '#f1f5f9' : '#1e293b',
                    confirmButtonColor: '#ea580c',
                });
            });
        </script>
    @endif

</body>

</html>