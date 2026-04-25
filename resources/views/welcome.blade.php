<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP BDG - Sistem Informasi Pelaporan Publik Kota Bandung</title>
    <meta name="description" content="Laporkan infrastruktur rusak dan kejahatan di Kota Bandung secara mudah, cepat, dan transparan. Bersama kita jaga Bandung.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-glow {
            background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(99,102,241,0.35) 0%, transparent 70%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }
        .btn-primary {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99,102,241,0.5);
        }
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .dot-pattern {
            background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .step-line::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #4f46e5, transparent);
        }
    </style>
</head>
<body class="bg-gray-950 text-white overflow-x-hidden">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-950/80 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <span class="font-bold text-white text-lg tracking-tight">SIGAP <span class="text-indigo-400">BDG</span></span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm text-gray-400">
                <a href="#fitur" class="hover:text-white transition">Fitur</a>
                <a href="#cara-kerja" class="hover:text-white transition">Cara Kerja</a>
                <a href="{{ route('lapor') }}" class="hover:text-white transition text-orange-400">Lapor Sekarang</a>
                <a href="{{ route('lacak') }}" class="hover:text-white transition">Lacak Laporan</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('masuk') }}" class="text-sm text-gray-300 hover:text-white transition font-medium px-3 py-1.5">
                    Masuk Admin
                </a>
                <a href="{{ route('masuk') }}" class="text-sm bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-4 py-2 rounded-lg transition btn-primary">
                    Portal Admin →
                </a>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center pt-16 dot-pattern hero-glow">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></span>
                    Sistem Aktif — Kota Bandung
                </div>
                <h1 class="text-5xl sm:text-6xl font-black leading-tight tracking-tight mb-6">
                    Bandung Lebih
                    <br>
                    <span class="gradient-text">Sigap</span> dengan
                    <br>
                    Laporan Warga
                </h1>
                <p class="text-gray-400 text-lg leading-relaxed mb-8 max-w-lg">
                    Laporkan jalan berlubang, infrastruktur rusak, atau kejahatan di sekitar Anda. Tanpa akun, cukup foto dan lokasi — laporan Anda langsung masuk ke sistem.
                </p>
                <div class="flex flex-wrap gap-3" id="lapor">
                    <a href="{{ route('lapor') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3.5 rounded-xl transition btn-primary shadow-xl shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Buat Laporan
                    </a>
                    <a href="{{ route('lacak') }}" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-semibold px-6 py-3.5 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Lacak Laporan
                    </a>
                    <button
                        id="tombolPanik"
                        type="button"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-500 active:scale-95 text-white font-black px-6 py-3.5 rounded-xl transition shadow-xl shadow-red-500/30 animate-pulse hover:animate-none border-2 border-red-400/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        🚨 Panic Button
                    </button>
                </div>

                <div class="flex items-center gap-6 mt-10 pt-10 border-t border-white/5">
                    <div>
                        <div class="text-2xl font-bold text-white">24 Kecamatan</div>
                        <div class="text-xs text-gray-500 mt-0.5">Tercakup di Kota Bandung</div>
                    </div>
                    <div class="h-8 w-px bg-white/10"></div>
                    <div>
                        <div class="text-2xl font-bold text-white">Real-time</div>
                        <div class="text-xs text-gray-500 mt-0.5">Update status laporan</div>
                    </div>
                    <div class="h-8 w-px bg-white/10"></div>
                    <div>
                        <div class="text-2xl font-bold text-white">AI-Powered</div>
                        <div class="text-xs text-gray-500 mt-0.5">Analisis otomatis kerusakan</div>
                    </div>
                </div>
            </div>

            <div class="relative hidden lg:flex justify-center items-center">
                <div class="floating relative w-80 h-80">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/30 to-blue-600/20 rounded-3xl blur-xl"></div>
                    <div class="relative bg-gray-900 border border-white/10 rounded-3xl p-6 shadow-2xl">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <span class="ml-2 text-xs text-gray-500">Laporan #TRK-8821</span>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-gray-800 rounded-xl p-3 flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-gray-200">Jalan Berlubang</div>
                                    <div class="text-xs text-gray-500">Jl. Sukajadi, Cicendo</div>
                                </div>
                            </div>
                            <div class="bg-gray-800/50 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-2">Status Laporan</div>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 flex-1 bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full w-2/3 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
                                    </div>
                                    <span class="text-xs text-indigo-400 font-semibold">Proses</span>
                                </div>
                            </div>
                            <div class="bg-gray-800/50 rounded-xl p-3">
                                <div class="text-xs text-gray-500 mb-1">Analisis AI</div>
                                <div class="text-xs text-gray-300">Kerusakan <span class="text-yellow-400 font-semibold">Sedang</span> · Est. Rp 12.500.000</div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex-1 bg-indigo-600/30 border border-indigo-500/30 rounded-lg p-2 text-center">
                                    <div class="text-xs font-semibold text-indigo-300">Pengajuan Dana</div>
                                    <div class="text-xs text-indigo-400">Menunggu Approval</div>
                                </div>
                                <div class="flex-1 bg-green-600/20 border border-green-500/20 rounded-lg p-2 text-center">
                                    <div class="text-xs font-semibold text-green-300">Tracking</div>
                                    <div class="text-xs text-green-400">Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                    Fitur Utama
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Semua yang Kamu Butuhkan</h2>
                <p class="text-gray-400 max-w-xl mx-auto">Satu platform untuk melaporkan, memantau, dan mengelola seluruh masalah infrastruktur dan keamanan di Kota Bandung.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="card-hover bg-gray-900 border border-white/5 rounded-2xl p-7 group">
                    <div class="w-12 h-12 bg-orange-500/15 rounded-xl flex items-center justify-center mb-5 group-hover:bg-orange-500/25 transition">
                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Lapor Infrastruktur</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Foto jalan berlubang atau kerusakan infrastruktur, sistem otomatis mendeteksi lokasi dan menganalisis tingkat kerusakan menggunakan AI.</p>
                    <div class="mt-5 pt-5 border-t border-white/5 flex items-center gap-2 text-xs text-orange-400 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        Tanpa login · Gratis
                    </div>
                </div>

                <div class="card-hover bg-gray-900 border border-white/5 rounded-2xl p-7 group">
                    <div class="w-12 h-12 bg-red-500/15 rounded-xl flex items-center justify-center mb-5 group-hover:bg-red-500/25 transition">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Lapor Kejahatan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Tandai titik kejahatan di peta secara anonim. Data dikumpulkan untuk membantu kepolisian mengidentifikasi daerah rawan.</p>
                    <div class="mt-5 pt-5 border-t border-white/5 flex items-center gap-2 text-xs text-red-400 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        Anonim · Langsung ke sistem
                    </div>
                </div>

                <div class="card-hover bg-gray-900 border border-white/5 rounded-2xl p-7 group">
                    <div class="w-12 h-12 bg-green-500/15 rounded-xl flex items-center justify-center mb-5 group-hover:bg-green-500/25 transition">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Tracking Status</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pantau perkembangan laporan Anda secara real-time menggunakan Tracking ID unik yang diberikan saat laporan dibuat.</p>
                    <div class="mt-5 pt-5 border-t border-white/5 flex items-center gap-2 text-xs text-green-400 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                        Cukup masukkan Tracking ID
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-24 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                    Cara Kerja
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">3 Langkah Mudah Melapor</h2>
                <p class="text-gray-400 max-w-lg mx-auto">Proses pelaporan dirancang sesederhana mungkin agar semua warga bisa melakukannya.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-xl shadow-indigo-500/20">
                        <span class="text-2xl font-black text-white">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Foto Masalah</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Ambil foto jalan rusak atau tandai lokasi kejahatan. Sistem akan mendeteksi koordinat GPS secara otomatis.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-xl shadow-indigo-500/20">
                        <span class="text-2xl font-black text-white">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Kirim Laporan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Isi form singkat dan kirim. Anda akan mendapat <span class="text-indigo-400 font-semibold">Tracking ID</span> unik sebagai bukti laporan.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-xl shadow-indigo-500/20">
                        <span class="text-2xl font-black text-white">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Pantau Progress</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Gunakan Tracking ID untuk memantau status laporan Anda dari <span class="text-green-400 font-semibold">Menunggu → Proses → Selesai</span>.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-indigo-900/80 to-blue-900/60 border border-indigo-500/20 rounded-3xl p-12 text-center relative overflow-hidden">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-600/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-600/15 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative">
                    <span class="inline-flex items-center gap-2 bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                        Portal Admin
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Anda Admin Kecamatan?</h2>
                    <p class="text-gray-300 mb-8 max-w-lg mx-auto">Akses dashboard untuk mengelola laporan, memperbarui status, dan mengajukan anggaran perbaikan infrastruktur di wilayah Anda.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('masuk') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3.5 rounded-xl transition btn-primary shadow-xl shadow-indigo-500/25">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                            Masuk Sekarang
                        </a>
                        <a href="{{ route('daftar') }}" class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/15 border border-white/15 text-white font-semibold px-8 py-3.5 rounded-xl transition">
                            Daftar Akun Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-md flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <span class="font-bold text-white text-sm">SIGAP BDG</span>
            </div>
            <p class="text-xs text-gray-600 text-center">
                © 2026 SIGAP BDG · Sistem Informasi Pelaporan Publik Kota Bandung. Hak cipta dilindungi.
            </p>
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <a href="{{ route('lapor') }}" class="hover:text-gray-300 transition">Lapor</a>
                <a href="{{ route('lacak') }}" class="hover:text-gray-300 transition">Lacak</a>
                <a href="{{ route('masuk') }}" class="hover:text-gray-300 transition">Portal Admin</a>
            </div>
        </div>
    </footer>

<script>
(function() {
    var tombolPanik = document.getElementById('tombolPanik');
    var tokenCsrf   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var urlLaporan  = '{{ route("lapor.kejahatan") }}';

    tombolPanik.addEventListener('click', function() {
        tombolPanik.disabled = true;
        tombolPanik.textContent = 'Mendeteksi lokasi...';

        if (!navigator.geolocation) {
            window.location.href = 'tel:110';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(posisi) {
                var latitudeDapatkan  = posisi.coords.latitude;
                var longitudeDapatkan = posisi.coords.longitude;

                fetch(urlLaporan, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': tokenCsrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        latitude:  latitudeDapatkan,
                        longitude: longitudeDapatkan
                    })
                })
                .then(function() {
                    window.location.href = 'tel:110';
                })
                .catch(function() {
                    window.location.href = 'tel:110';
                });
            },
            function() {
                window.location.href = 'tel:110';
            },
            { timeout: 8000 }
        );
    });
})();
</script>

</body>
</html>
