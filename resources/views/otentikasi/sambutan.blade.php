<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true' }" x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pegawai — SIGAP BDG</title>
    <meta name="description" content="Portal internal pegawai dan administrator SIGAP BDG Kota Bandung.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c',
                            500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen transition-colors duration-200">

    <div class="min-h-screen flex">
        <div class="hidden lg:flex flex-col justify-between w-[420px] flex-shrink-0 bg-brand-600 p-10 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-32 -right-32 w-64 h-64 bg-white/5 rounded-full"></div>
                <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-brand-700/60 rounded-full"></div>
            </div>

            <div class="relative">
                <div class="flex items-center gap-2.5 mb-12">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="font-bold text-white text-base">SIGAP BDG</span>
                </div>

                <h2 class="text-3xl font-extrabold text-white leading-snug mb-4">
                    Sistem Informasi<br>Pelaporan Publik<br>Kota Bandung
                </h2>
                <p class="text-brand-200 text-sm leading-relaxed">
                    Panel manajemen laporan infrastruktur, analisis AI, dan persetujuan dana perbaikan wilayah.
                </p>
            </div>

            <div class="relative space-y-4">
                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-7 h-7 bg-green-400/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-white text-xs font-semibold">Analisis AI Otomatis</span>
                    </div>
                    <p class="text-brand-200 text-xs pl-10">Foto laporan dianalisis GPT-4o untuk menentukan tingkat kerusakan dan estimasi biaya.</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-7 h-7 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/></svg>
                        </div>
                        <span class="text-white text-xs font-semibold">Pengajuan Dana Terstruktur</span>
                    </div>
                    <p class="text-brand-200 text-xs pl-10">Admin daerah mengajukan dana, Super Admin menyetujui atau menolak dengan validasi anggaran.</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-7 h-7 bg-brand-400/20 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276"/></svg>
                        </div>
                        <span class="text-white text-xs font-semibold">Peta Kerawanan Real-time</span>
                    </div>
                    <p class="text-brand-200 text-xs pl-10">Visualisasi heatmap titik kejahatan seluruh Kota Bandung untuk analisis keamanan.</p>
                </div>

                <p class="text-brand-300 text-xs pt-2">© 2026 SIGAP BDG — Kota Bandung</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12">
            <div class="w-full max-w-sm">
                <div class="flex items-center gap-2 mb-8 lg:hidden">
                    <div class="w-7 h-7 bg-brand-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="font-bold text-slate-800 dark:text-white">SIGAP BDG</span>
                </div>

                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 bg-brand-50 dark:bg-brand-900/30 border border-brand-100 dark:border-brand-700/40 text-brand-600 dark:text-brand-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                        <span class="w-1.5 h-1.5 bg-brand-500 rounded-full animate-pulse"></span>
                        Portal Pegawai Internal
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-1.5">Selamat Datang</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Masuk untuk mengakses dashboard pengelolaan laporan dan keuangan daerah.</p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('masuk') }}" class="flex items-center justify-center gap-2.5 w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-brand-200 dark:shadow-brand-900/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk ke Dashboard
                    </a>
                    <a href="{{ route('daftar') }}" class="flex items-center justify-center gap-2 w-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-medium py-3 rounded-xl transition text-sm">
                        Daftar Akun Pegawai Baru
                    </a>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke Beranda
                    </a>
                    <button @click="temaGelap = !temaGelap" class="flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition">
                        <span x-show="!temaGelap"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg></span>
                        <span x-show="temaGelap"><svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg></span>
                        <span x-text="temaGelap ? 'Mode Terang' : 'Mode Gelap'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
