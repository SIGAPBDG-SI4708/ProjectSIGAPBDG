<!DOCTYPE html>
<html lang="id"
    x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true', tampilNotifikasi: false, jenisNotifikasi: '', pesanNotifikasi: '', judulNotifikasi: '', linkNotifikasi: '' }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val)); @if(session('success')) jenisNotifikasi = 'success'; judulNotifikasi = 'Berhasil!'; pesanNotifikasi = '{{ addslashes(session('success')) }}'; tampilNotifikasi = true; @elseif(session('warning')) jenisNotifikasi = 'warning'; judulNotifikasi = 'Perhatian!'; pesanNotifikasi = '{{ addslashes(session('warning')) }}'; tampilNotifikasi = true; @elseif(session('sukses')) jenisNotifikasi = 'success'; judulNotifikasi = 'Berhasil!'; pesanNotifikasi = '{{ addslashes(session('sukses')) }}'; tampilNotifikasi = true; @elseif($errors->any()) jenisNotifikasi = 'error'; judulNotifikasi = 'Terjadi Kesalahan!'; pesanNotifikasi = '{{ addslashes($errors->first()) }}'; tampilNotifikasi = true; @endif"
    @tampilkan-notif.window="jenisNotifikasi = $event.detail.jenis; judulNotifikasi = $event.detail.judul; pesanNotifikasi = $event.detail.pesan; linkNotifikasi = $event.detail.link; tampilNotifikasi = true; setTimeout(() => { tampilNotifikasi = false }, 5000);"
    :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judulHalaman', 'Dashboard') - SIGAP BDG Admin</title>

    @vite(['resources/js/app.js'])

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .nav-aktif {
            background: #fff7ed;
            color: #ea580c;
            border-left: 3px solid #f97316;
            padding-left: calc(0.75rem - 3px);
            font-weight: 600;
        }

        .dark .nav-aktif {
            background: rgba(249, 115, 22, 0.15);
            color: #fdba74;
        }

        .nav-item {
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .nav-item:hover:not(.nav-aktif) {
            background: rgba(0, 0, 0, 0.03);
            padding-left: calc(0.75rem + 2px);
        }

        .dark .nav-item:hover:not(.nav-aktif) {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }

        .badge-status-menunggu {
            background: rgba(234, 179, 8, 0.1);
            color: #d97706;
            border: 1px solid rgba(234, 179, 8, 0.25);
        }

        .dark .badge-status-menunggu {
            color: #facc15;
        }

        .badge-status-proses {
            background: rgba(249, 115, 22, 0.1);
            color: #ea580c;
            border: 1px solid rgba(249, 115, 22, 0.25);
        }

        .dark .badge-status-proses {
            color: #fb923c;
        }

        .badge-status-selesai {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            border: 1px solid rgba(34, 197, 94, 0.25);
        }

        .dark .badge-status-selesai {
            color: #4ade80;
        }
    </style>
    @stack('styles')
</head>

<body
    class="bg-stone-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen flex transition-colors duration-200">

    <div x-show="tampilNotifikasi" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-4"
        class="fixed top-5 right-5 z-[998] max-w-xs w-full cursor-pointer hover:scale-[1.02] transition-transform"
        style="display: none;">
        <a :href="linkNotifikasi ? linkNotifikasi : '#'"
            :class="{ 'bg-emerald-50 dark:bg-emerald-950/90 border-emerald-200 dark:border-emerald-700/40 text-emerald-700 dark:text-emerald-300': jenisNotifikasi === 'success', 'bg-amber-50 dark:bg-amber-950/90 border-amber-200 dark:border-amber-700/40 text-amber-700 dark:text-amber-300': jenisNotifikasi === 'warning', 'bg-red-50 dark:bg-red-950/90 border-red-200 dark:border-red-700/40 text-red-700 dark:text-red-300': jenisNotifikasi === 'error', 'bg-blue-50 dark:bg-blue-950/90 border-blue-200 dark:border-blue-700/40 text-blue-700 dark:text-blue-300': jenisNotifikasi === 'info' }"
            class="border rounded-2xl px-4 py-3.5 flex items-start gap-3 shadow-xl backdrop-blur-sm block">
            <div class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center"
                :class="{ 'bg-emerald-100 dark:bg-emerald-900/50': jenisNotifikasi === 'success', 'bg-amber-100 dark:bg-amber-900/50': jenisNotifikasi === 'warning', 'bg-red-100 dark:bg-red-900/50': jenisNotifikasi === 'error', 'bg-blue-100 dark:bg-blue-900/50': jenisNotifikasi === 'info' }">
                <svg x-show="jenisNotifikasi === 'success'" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                <svg x-show="jenisNotifikasi === 'warning'" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <svg x-show="jenisNotifikasi === 'error'" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <svg x-show="jenisNotifikasi === 'info'" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-xs" x-text="judulNotifikasi"></div>
                <div class="text-xs mt-0.5 opacity-75 leading-relaxed" x-text="pesanNotifikasi"></div>
                <div x-show="linkNotifikasi" class="text-[10px] font-medium mt-1 text-blue-600 dark:text-blue-400">Klik
                    untuk melihat detail &rarr;</div>
            </div>
            <button @click.prevent="tampilNotifikasi = false"
                class="flex-shrink-0 opacity-40 hover:opacity-100 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </a>
    </div>

    <aside
        class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-stone-200 dark:border-slate-800 flex flex-col fixed inset-y-0 left-0 z-30 shadow-sm">
        <div class="px-6 py-6 border-b border-stone-100 dark:border-slate-800 flex items-center justify-center">
            <a href="{{ route('admin.beranda') }}" class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-500/40 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <div class="font-extrabold text-slate-800 dark:text-white text-lg tracking-tight leading-none">
                        SIGAP<span class="text-brand-500">BDG</span></div>
                    <div class="text-brand-600 dark:text-brand-400 font-medium text-xs mt-1">Administrator</div>
                </div>
            </a>
        </div>

        <div class="px-4 py-5 border-b border-stone-100 dark:border-slate-800">
            <div
                class="flex items-center gap-3 px-3 py-3 rounded-2xl bg-stone-50 dark:bg-slate-800 border border-stone-200/60 dark:border-slate-700">
                <div
                    class="w-10 h-10 bg-brand-100 dark:bg-brand-900/30 rounded-xl flex items-center justify-center flex-shrink-0 border border-brand-200 dark:border-brand-800/50">
                    <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->nama }}
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->role }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider px-3 mb-4">
                Navigasi Utama</p>
            <a href="{{ route('admin.beranda') }}"
                class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-medium {{ request()->routeIs('admin.beranda') ? 'nav-aktif' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <a href="{{ route('admin.laporan.indeks') }}"
                class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-medium {{ request()->routeIs('admin.laporan.*') ? 'nav-aktif' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Laporan Masuk
            </a>
            @if(Auth::user()->role === 'Super Admin')
                <a href="{{ route('admin.pegawai.indeks') }}"
                    class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-medium {{ request()->routeIs('admin.pegawai.*') ? 'nav-aktif' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manajemen Pegawai
                </a>
                <a href="{{ route('admin.keuangan.indeks') }}"
                    class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-medium {{ request()->routeIs('admin.keuangan.*') ? 'nav-aktif' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Persetujuan Dana
                </a>
                <a href="{{ route('admin.peta.indeks') }}"
                    class="nav-item flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-medium {{ request()->routeIs('admin.peta.*') ? 'nav-aktif' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Peta Kerawanan
                </a>
            @endif
        </nav>

        <div class="px-4 py-5 border-t border-stone-100 dark:border-slate-800">
            <form method="POST" action="{{ route('keluar') }}">
                @csrf
                <button type="submit"
                    class="nav-item w-full flex items-center gap-3 px-3 py-3 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 text-left transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Sesi
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <header
            class="bg-white/90 dark:bg-slate-900/90 border-b border-stone-200 dark:border-slate-800 px-8 py-5 flex items-center justify-between backdrop-blur-lg sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 dark:text-white">@yield('judulHalaman', 'Dashboard')
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    @yield('subjudulHalaman', 'SIGAP BDG Admin Panel')</p>
            </div>
            <div class="flex items-center gap-4">
                <button @click="temaGelap = !temaGelap"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-stone-100 dark:bg-slate-800 hover:bg-stone-200 dark:hover:bg-slate-700 text-stone-500 dark:text-slate-400 hover:text-brand-500 transition shadow-inner">
                    <span x-show="!temaGelap"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg></span>
                    <span x-show="temaGelap"><svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg></span>
                </button>
                <div
                    class="hidden sm:flex items-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 px-4 py-2.5 rounded-full border border-stone-200 dark:border-slate-700 shadow-sm">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        <main class="flex-1 p-8 bg-stone-50/50 dark:bg-slate-950">
            @yield('konten')
        </main>
    </div>

    @stack('scripts')

    @auth
        <script type="module">
            document.addEventListener('DOMContentLoaded', () => {
                if (window.Echo) {
                    const role = '{{ Auth::user()->role }}';
                    const idDaerah = '{{ Auth::user()->id_daerah }}';

                    const channelName = role === 'Super Admin'
                        ? 'laporan.masuk.semua'
                        : 'laporan.masuk.' + idDaerah;

                    window.Echo.private(channelName)
                        .listen('LaporanMasukEvent', (e) => {
                            let audio = new Audio('{{ asset("sounds/notif-laporan.mp3") }}');
                            audio.play().catch(err => console.log('Autoplay audio blocked:', err));

                            window.dispatchEvent(new CustomEvent('tampilkan-notif', {
                                detail: {
                                    jenis: 'info',
                                    judul: 'Laporan Baru Masuk!',
                                    pesan: e.pesan + ' dari ' + e.daerah,
                                    link: '/admin/laporan/' + e.id
                                }
                            }));

                            if (window.location.pathname.includes('/admin/laporan') || window.location.pathname.endsWith('/admin')) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 5000);
                            }
                        });
                }
            });
        </script>
    @endauth
</body>

</html>