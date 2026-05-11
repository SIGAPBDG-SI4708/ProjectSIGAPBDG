<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP BDG — Laporkan Masalah di Kota Bandung</title>
    <meta name="description" content="Platform pelaporan infrastruktur rusak dan kejahatan Kota Bandung. Mudah, cepat, tanpa akun.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #3b82f6, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="font-bold text-slate-800 tracking-tight">SIGAP <span class="text-indigo-600">BDG</span></span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('lacak') }}" class="text-sm text-slate-500 hover:text-slate-700 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Lacak Laporan</a>
                <a href="{{ route('lapor') }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-1.5 rounded-lg transition shadow-sm">Buat Laporan</a>
            </div>
        </div>
    </nav>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 pt-20 pb-16">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse"></span>
                Sistem Aktif — Kota Bandung
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight tracking-tight mb-5 text-slate-900">
                Laporkan masalah<br>di sekitar Anda.<br>
                <span class="gradient-text">Gratis & tanpa akun.</span>
            </h1>
            <p class="text-slate-500 text-lg leading-relaxed mb-8 max-w-xl">
                Foto jalan rusak atau tandai lokasi kejahatan. Laporan langsung masuk ke sistem dinas terkait dan dapat dipantau kapan saja.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('lapor') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Laporan
                </a>
                <a href="{{ route('lacak') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Lacak Laporan
                </a>
                <button id="tombolPanik" type="button" class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 font-bold px-6 py-3 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    🚨 Panic Button
                </button>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 border-t border-b border-slate-100 py-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-wrap items-center gap-8">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-400">Jangkauan</div>
                    <div class="text-sm font-bold text-slate-800">30 Kecamatan</div>
                </div>
            </div>
            <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-400">Pemrosesan</div>
                    <div class="text-sm font-bold text-slate-800">Real-time</div>
                </div>
            </div>
            <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-400">Analisis</div>
                    <div class="text-sm font-bold text-slate-800">AI-Powered</div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">Apa yang bisa kamu laporkan?</h2>
            <p class="text-slate-500 max-w-md mx-auto text-sm">Dua jenis laporan tersedia, semua diproses otomatis oleh sistem.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="card-hover bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <div class="w-11 h-11 bg-orange-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 mb-1.5">Infrastruktur Rusak</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Jalan berlubang, jembatan rusak, fasilitas umum tidak berfungsi — foto dan kirim, AI akan menganalisis otomatis.</p>
            </div>
            <div class="card-hover bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 mb-1.5">Kejahatan & Darurat</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Tandai lokasi kejahatan secara anonim atau tekan Panic Button untuk memanggil bantuan dan mencatat koordinat GPS.</p>
            </div>
            <div class="card-hover bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 mb-1.5">Pantau Status</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Gunakan Tracking ID yang diberikan saat laporan dibuat untuk memantau perkembangan dari Menunggu hingga Selesai.</p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50 border-t border-slate-100 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Cara melapor dalam 3 langkah</h2>
                <p class="text-slate-500 text-sm">Semua bisa dilakukan dari ponsel dalam kurang dari 2 menit.</p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-black mx-auto mb-4 shadow-lg shadow-indigo-200">1</div>
                    <h3 class="font-semibold text-slate-800 mb-1.5 text-sm">Foto Masalah</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Ambil foto kerusakan. GPS otomatis mendeteksi koordinat lokasi Anda.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-black mx-auto mb-4 shadow-lg shadow-indigo-200">2</div>
                    <h3 class="font-semibold text-slate-800 mb-1.5 text-sm">Kirim Laporan</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Upload foto dan kirim. Sistem memberi Tracking ID unik sebagai bukti laporan.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl font-black mx-auto mb-4 shadow-lg shadow-indigo-200">3</div>
                    <h3 class="font-semibold text-slate-800 mb-1.5 text-sm">Pantau Progress</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">Masukkan Tracking ID kapan saja untuk cek status: Menunggu → Proses → Selesai.</p>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('lapor') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                    Mulai Melapor Sekarang →
                </a>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-100 py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-indigo-600 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="text-sm font-semibold text-slate-700">SIGAP BDG</span>
            </div>
            <p class="text-xs text-slate-400">© 2026 Sistem Informasi Pelaporan Publik Kota Bandung</p>
            <div class="flex items-center gap-4 text-xs text-slate-400">
                <a href="{{ route('lapor') }}" class="hover:text-slate-600 transition">Lapor</a>
                <a href="{{ route('lacak') }}" class="hover:text-slate-600 transition">Lacak</a>
            </div>
        </div>
    </footer>

<script>
(function() {
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ addslashes(session('success')) }}', confirmButtonColor: '#4f46e5', customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-5 py-2 text-sm' }, timer: 5000, timerProgressBar: true });
    @elseif(session('warning'))
        Swal.fire({ icon: 'warning', title: 'Perhatian!', text: '{{ addslashes(session('warning')) }}', confirmButtonColor: '#d97706', customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-5 py-2 text-sm' } });
    @elseif($errors->any())
        Swal.fire({ icon: 'error', title: 'Kesalahan!', text: '{{ addslashes($errors->first()) }}', confirmButtonColor: '#dc2626', customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-5 py-2 text-sm' } });
    @endif
})();

(function() {
    var tombolPanik = document.getElementById('tombolPanik');
    var tokenCsrf   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var urlLaporan  = '{{ route("lapor.kejahatan") }}';

    tombolPanik.addEventListener('click', function() {
        tombolPanik.disabled = true;
        tombolPanik.textContent = 'Mendeteksi lokasi...';

        if (!navigator.geolocation) { window.location.href = 'tel:110'; return; }

        navigator.geolocation.getCurrentPosition(
            function(posisi) {
                var latitudeDapatkan  = posisi.coords.latitude;
                var longitudeDapatkan = posisi.coords.longitude;
                fetch(urlLaporan, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': tokenCsrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ latitude: latitudeDapatkan, longitude: longitudeDapatkan })
                }).then(function() { window.location.href = 'tel:110'; }).catch(function() { window.location.href = 'tel:110'; });
            },
            function() { window.location.href = 'tel:110'; },
            { timeout: 8000 }
        );
    });
})();
</script>

</body>
</html>
