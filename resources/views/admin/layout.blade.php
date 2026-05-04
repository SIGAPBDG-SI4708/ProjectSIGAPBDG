<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judulHalaman', 'Dashboard') - SIGAP BDG Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .nav-aktif { background: rgba(99,102,241,0.15); color: #a5b4fc; border-left: 3px solid #6366f1; }
        .nav-item { border-left: 3px solid transparent; transition: all 0.2s ease; }
        .nav-item:hover { background: rgba(255,255,255,0.05); color: #e2e8f0; }
        .badge-status-menunggu { background: rgba(234,179,8,0.1); color: #facc15; border: 1px solid rgba(234,179,8,0.2); }
        .badge-status-proses   { background: rgba(59,130,246,0.1); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2); }
        .badge-status-selesai  { background: rgba(34,197,94,0.1);  color: #4ade80; border: 1px solid rgba(34,197,94,0.2); }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex">

    <aside class="w-64 flex-shrink-0 bg-gray-900 border-r border-white/5 flex flex-col fixed inset-y-0 left-0 z-30">
        <div class="px-5 py-5 border-b border-white/5">
            <a href="{{ route('admin.beranda') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-white text-sm leading-none">SIGAP BDG</div>
                    <div class="text-gray-500 text-xs mt-0.5">Panel Admin</div>
                </div>
            </a>
        </div>

        <div class="px-3 py-4 border-b border-white/5">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                <div class="w-8 h-8 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-xs font-semibold text-white truncate">{{ Auth::user()->nama }}</div>
                    <div class="text-xs text-indigo-300 truncate">{{ Auth::user()->role }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-xs text-gray-600 font-semibold uppercase tracking-wider px-3 mb-2">Menu Utama</p>

            <a href="{{ route('admin.beranda') }}"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 text-sm font-medium {{ request()->routeIs('admin.beranda') ? 'nav-aktif' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>

            <a href="{{ route('admin.laporan.indeks') }}"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 text-sm font-medium {{ request()->routeIs('admin.laporan.*') ? 'nav-aktif' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Laporan Masuk
            </a>

            @if(Auth::user()->role === 'Super Admin')
            <a href="{{ route('admin.keuangan.indeks') }}"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 text-sm font-medium {{ request()->routeIs('admin.keuangan.*') ? 'nav-aktif' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Persetujuan Dana
            </a>

            <a href="{{ route('admin.peta.indeks') }}"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 text-sm font-medium {{ request()->routeIs('admin.peta.*') ? 'nav-aktif' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Peta Kerawanan
            </a>
            @endif
        </nav>

        <div class="px-3 py-4 border-t border-white/5">
            <form method="POST" action="{{ route('keluar') }}">
                @csrf
                <button type="submit" class="nav-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 text-sm font-medium hover:text-red-400 text-left">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <header class="bg-gray-900/50 border-b border-white/5 px-6 py-4 flex items-center justify-between backdrop-blur-sm sticky top-0 z-20">
            <div>
                <h1 class="text-base font-bold text-white">@yield('judulHalaman', 'Dashboard')</h1>
                <p class="text-xs text-gray-500 mt-0.5">@yield('subjudulHalaman', 'SIGAP BDG Admin Panel')</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <main class="flex-1 p-6">
            @if(session('sukses'))
            <div class="mb-5 bg-green-950 border border-green-500/30 rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-green-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('sukses') }}
            </div>
            @endif

            @if(session('gagal'))
            <div class="mb-5 bg-red-950 border border-red-500/30 rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-red-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ session('gagal') }}
            </div>
            @endif

            @yield('konten')
        </main>
    </div>

</body>
</html>
