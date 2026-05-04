<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - SIGAP BDG</title>
    <meta name="description" content="Laporkan kerusakan infrastruktur di Kota Bandung secara mudah dan gratis tanpa perlu login.">
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
        #pratinjauFoto { transition: opacity 0.3s ease; }
        .upload-area { transition: border-color 0.2s, background-color 0.2s; }
        .upload-area:hover { border-color: #6366f1; background-color: rgba(99,102,241,0.05); }
        .btn-submit { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(99,102,241,0.4); }
        .status-lokasi { transition: all 0.3s ease; }
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
            <a href="{{ route('lacak') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Lacak Laporan
            </a>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">

        @if(session('trackingBerhasil'))
        <div id="notifBerhasil" class="mb-8 bg-green-950 border border-green-500/30 rounded-2xl p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-transparent pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="text-green-400 font-bold text-base">Laporan Berhasil Dikirim!</div>
                        <div class="text-green-500/70 text-xs">Simpan kode tracking berikut untuk memantau status laporan Anda</div>
                    </div>
                </div>
                <div class="bg-gray-900 border border-green-500/20 rounded-xl p-4 flex items-center justify-between gap-3">
                    <div>
                        <div class="text-xs text-gray-500 mb-0.5">Tracking ID Anda</div>
                        <div id="kodeTracking" class="text-2xl font-black tracking-widest text-white">{{ session('trackingBerhasil') }}</div>
                    </div>
                    <button onclick="salinKode()" class="flex-shrink-0 bg-green-600/20 hover:bg-green-600/30 border border-green-500/30 text-green-400 text-xs font-semibold px-4 py-2 rounded-lg transition">
                        Salin
                    </button>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <a href="{{ route('lacak') }}" class="text-xs text-indigo-400 hover:text-indigo-300 transition font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lacak laporan ini sekarang
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-950 border border-red-500/30 rounded-xl p-4">
            <ul class="space-y-1">
                @foreach($errors->all() as $pesan)
                    <li class="text-red-400 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $pesan }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-10">
            <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/20 text-orange-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                Laporan Infrastruktur
            </div>
            <h1 class="text-3xl sm:text-4xl font-black mb-3">Laporkan <span class="gradient-text">Kerusakan</span></h1>
            <p class="text-gray-400 text-base">Foto kerusakan infrastruktur di sekitar Anda. Lokasi GPS akan terdeteksi otomatis. Tidak perlu login, gratis.</p>
        </div>

        <form action="{{ route('proses.laporan') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <input type="hidden" id="inputLatitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="inputLongitude" name="longitude" value="{{ old('longitude') }}">

            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-sm font-semibold text-white mb-0.5">Lokasi GPS</div>
                        <div class="text-xs text-gray-500">Koordinat dideteksi otomatis dari perangkat Anda</div>
                    </div>
                    <div id="ikonLokasi" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                </div>
                <div id="statusLokasi" class="status-lokasi bg-gray-800 rounded-xl px-4 py-3 text-xs text-gray-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse flex-shrink-0"></span>
                    Mendeteksi lokasi... Izinkan akses GPS jika diminta.
                </div>
            </div>

            <div class="bg-gray-900 border border-white/5 rounded-2xl p-5 sm:p-6">
                <div class="text-sm font-semibold text-white mb-1">Foto Kerusakan</div>
                <div class="text-xs text-gray-500 mb-4">Upload foto jalan berlubang atau kerusakan infrastruktur (maks. 5MB)</div>
                <label for="inputFoto" class="upload-area border-2 border-dashed border-gray-700 rounded-xl p-8 flex flex-col items-center justify-center cursor-pointer gap-3 relative group">
                    <div id="ikonUpload" class="text-center">
                        <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-500/10 transition">
                            <svg class="w-7 h-7 text-gray-500 group-hover:text-indigo-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="text-sm font-medium text-gray-300">Klik untuk pilih foto</div>
                        <div class="text-xs text-gray-600 mt-1">atau seret dan lepas file di sini</div>
                    </div>
                    <img id="pratinjauFoto" src="" alt="Pratinjau" class="hidden max-h-60 rounded-xl object-cover w-full opacity-0">
                    <input type="file" id="inputFoto" name="foto" accept="image/*" class="hidden">
                </label>
            </div>

            <button type="submit" id="tombolKirim" class="btn-submit w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-4 px-6 rounded-xl shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Kirim Laporan
            </button>

            <p class="text-center text-xs text-gray-600">Dengan mengirim laporan, Anda menyetujui bahwa data ini akan diproses oleh sistem SIGAP BDG.</p>
        </form>
    </main>

    <script>
        (function() {
            var inputLat = document.getElementById('inputLatitude');
            var inputLng = document.getElementById('inputLongitude');
            var statusEl = document.getElementById('statusLokasi');
            var ikonEl   = document.getElementById('ikonLokasi');

            function berhasil(posisi) {
                var lat = posisi.coords.latitude.toFixed(8);
                var lng = posisi.coords.longitude.toFixed(8);
                inputLat.value = lat;
                inputLng.value = lng;
                statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0"></span> Lokasi terdeteksi: ' + lat + ', ' + lng;
                statusEl.classList.remove('text-gray-400');
                statusEl.classList.add('text-green-400');
                ikonEl.innerHTML = '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                ikonEl.classList.add('bg-green-500/10');
                ikonEl.classList.remove('bg-gray-800');
            }

            function gagal() {
                statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-400 flex-shrink-0"></span> Gagal mendeteksi lokasi. Pastikan GPS aktif dan izin diberikan.';
                statusEl.classList.remove('text-gray-400');
                statusEl.classList.add('text-red-400');
                ikonEl.innerHTML = '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                ikonEl.classList.add('bg-red-500/10');
                ikonEl.classList.remove('bg-gray-800');
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(berhasil, gagal, { timeout: 10000 });
            } else {
                gagal();    
            }

            var inputFoto = document.getElementById('inputFoto');
            var pratinjau = document.getElementById('pratinjauFoto');
            var ikonUpload = document.getElementById('ikonUpload');

            inputFoto.addEventListener('change', function() {
                var berkas = this.files[0];
                if (!berkas) return;
                var pembaca = new FileReader();
                pembaca.onload = function(e) {
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
    </script>

</body>
</html>
