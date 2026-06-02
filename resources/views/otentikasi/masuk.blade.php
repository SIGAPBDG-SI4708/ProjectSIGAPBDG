<!DOCTYPE html>
<html lang="id" x-data="{ gelap: localStorage.getItem('gelap') === 'true', tampak: false }"
    x-init="$watch('gelap', v => localStorage.setItem('gelap', v))" :class="{ 'dark': gelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SIGAP BDG</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

        .bg-pattern {
            background-image:
                linear-gradient(rgba(249, 115, 22, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249, 115, 22, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .dark .bg-pattern {
            background-image:
                linear-gradient(rgba(249, 115, 22, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249, 115, 22, 0.07) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        @keyframes masukAtas {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .a1 {
            animation: masukAtas .4s ease .05s both;
        }

        .a2 {
            animation: masukAtas .4s ease .12s both;
        }

        .a3 {
            animation: masukAtas .4s ease .20s both;
        }

        .a4 {
            animation: masukAtas .4s ease .28s both;
        }

        .a5 {
            animation: masukAtas .4s ease .36s both;
        }

        .a6 {
            animation: masukAtas .4s ease .44s both;
        }

        .inp {
            transition: border-color .18s, box-shadow .18s, background .18s;
        }

        .inp:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.13);
            background-color: #ffffff;
        }

        .dark .inp:focus {
            background-color: #1e293b;
        }

        .btn-utama {
            background: #f97316;
            transition: background .18s, transform .13s, box-shadow .18s;
        }

        .btn-utama:hover {
            background: #ea580c;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.25);
        }

        .btn-utama:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .btn-sekunder {
            transition: border-color .18s, color .18s, background .18s, transform .13s;
        }

        .btn-sekunder:hover {
            border-color: #f97316;
            color: #ea580c;
            background: rgba(249, 115, 22, 0.04);
            transform: translateY(-1px);
        }

        .btn-sekunder:active {
            transform: translateY(0);
        }

        .swal-popup {
            border-radius: 1rem !important;
        }
    </style>
</head>

<body
    class="bg-pattern bg-slate-50 dark:bg-slate-950 antialiased min-h-screen flex items-center justify-center px-4 py-10 transition-colors duration-300">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="{{ asset('images/portal/section-background-texture.png') }}" alt=""
            class="w-full h-full object-cover opacity-50 dark:invert dark:hue-rotate-180 dark:opacity-50"
            aria-hidden="true">
    </div>

    <div class="relative z-10 w-full max-w-md">

        <div class="a1 text-center mb-8">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-3 mb-5 group">
                <div
                    class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/25 group-hover:shadow-brand-500/40 transition-shadow flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-black text-xl text-slate-900 dark:text-white tracking-tight leading-none">
                        SIGAP<span class="text-brand-500">BDG</span></div>
                    <div class="text-slate-400 dark:text-slate-500 text-xs font-medium mt-0.5">Sistem Pelaporan
                        Infrastruktur</div>
                </div>
            </a>

            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-1.5">Masuk ke Akun</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Khusus pegawai dan administrator yang telah terdaftar.
            </p>
        </div>

        <div
            class="a2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-6">

                @if($errors->any())
                    <div
                        class="mb-5 flex items-start gap-2.5 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-500/20 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('proses.masuk') }}" class="space-y-4">
                    @csrf

                    <div class="a3">
                        <label for="email"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="text-slate-400" style="width:15px;height:15px" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="email"
                                class="inp w-full pl-9 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 text-sm"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div class="a4">
                        <label for="password"
                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kata
                            Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="text-slate-400" style="width:15px;height:15px" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input :type="tampak ? 'text' : 'password'" id="password" name="password" required
                                class="inp w-full pl-9 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-slate-100 placeholder-slate-400 text-sm"
                                placeholder="••••••••">
                            <button type="button" @click="tampak = !tampak"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                <svg x-show="!tampak" style="width:15px;height:15px" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="tampak" style="width:15px;height:15px;display:none" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="a5 pt-1">
                        <button type="submit"
                            class="btn-utama w-full text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="a5 flex items-center gap-3 my-5">
                    <div class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                    <span class="text-slate-400 text-xs">atau</span>
                    <div class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                </div>

                <a href="{{ route('daftar') }}"
                    class="a6 btn-sekunder w-full border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-semibold py-3 px-6 rounded-xl flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Ajukan Pendaftaran Akun
                </a>

            </div>
            <div class="px-6 pb-5">
                <div
                    class="flex items-start gap-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 rounded-xl px-3.5 py-3">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs text-slate-400 dark:text-slate-500 leading-relaxed">
                        Pendaftaran membutuhkan verifikasi dari <span
                            class="font-semibold text-slate-500 dark:text-slate-400">Super Administrator</span> sebelum
                        akun aktif.
                    </p>
                </div>
            </div>

        </div>

        <div class="a6 mt-5 flex items-center justify-between px-1">
            <a href="{{ route('sambutan') }}"
                class="text-xs text-slate-400 hover:text-brand-500 dark:hover:text-brand-400 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <button @click="gelap = !gelap"
                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-brand-500 hover:border-brand-300 dark:hover:border-brand-600 transition-all shadow-sm">
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

    </div>

    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var g = localStorage.getItem('gelap') === 'true';
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('warning') }}',
                    confirmButtonText: 'Mengerti',
                    customClass: { popup: 'swal-popup', confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-semibold' },
                    background: g ? '#0f172a' : '#ffffff',
                    color: g ? '#f1f5f9' : '#1e293b',
                    confirmButtonColor: '#ea580c',
                });
            });
        </script>
    @endif

</body>

</html>