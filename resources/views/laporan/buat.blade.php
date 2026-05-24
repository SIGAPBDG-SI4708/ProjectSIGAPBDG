<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true', sedangMemproses: false }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - SIGAP BDG</title>
    <meta name="description"
        content="Laporkan kerusakan infrastruktur di Kota Bandung secara mudah dan gratis tanpa perlu login.">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
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
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-white min-h-screen transition-colors duration-200">

    <div x-show="sedangMemproses" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-950/90 backdrop-blur-md"
        style="display: none;">
        <div class="flex flex-col items-center gap-5">
            <div class="relative w-20 h-20">
                <div
                    class="absolute inset-0 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 opacity-20 animate-pulse">
                </div>
                <div
                    class="relative w-20 h-20 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 shadow-2xl flex items-center justify-center">
                    <svg class="w-9 h-9 text-brand-500 animate-spin" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>
            <div class="text-center">
                <div class="text-slate-800 dark:text-white font-bold text-lg">Memproses Laporan...</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm mt-1">AI sedang menganalisis foto kerusakan
                    Anda.<br>Harap tunggu sebentar.</div>
            </div>
        </div>
    </div>

    <nav
        class="fixed top-0 left-0 right-0 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl border-b border-slate-200 dark:border-white/5">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight text-slate-800 dark:text-white">SIGAP <span
                        class="text-brand-500">BDG</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('lacak') }}"
                    class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Lacak
                </a>
                <button @click="temaGelap = !temaGelap"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-white/5 transition">
                    <span x-show="!temaGelap"><svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg></span>
                    <span x-show="temaGelap"><svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg></span>
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 sm:px-6 pt-28 pb-16">

        @if(session('trackingBerhasil'))
            <div
                class="mb-8 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/50 dark:to-teal-950/50 border border-emerald-200 dark:border-emerald-700/40 rounded-2xl p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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
                        class="bg-white dark:bg-slate-900 border border-emerald-200 dark:border-emerald-700/40 rounded-xl p-4 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs text-slate-400 dark:text-slate-500 mb-0.5">Tracking ID Anda</div>
                            <div id="kodeTracking"
                                class="text-2xl font-black tracking-widest text-slate-800 dark:text-white">
                                {{ session('trackingBerhasil') }}</div>
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

        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-700/40 rounded-2xl p-4">
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

        <div class="mb-10">
            <div
                class="inline-flex items-center gap-2 bg-orange-100 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20 text-orange-600 dark:text-orange-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Laporan Infrastruktur
            </div>
            <h1 class="text-3xl sm:text-4xl font-black mb-3 text-slate-800 dark:text-white">Laporkan <span
                    class="gradient-text">Kerusakan</span></h1>
            <p class="text-slate-500 dark:text-slate-400 text-base">Foto kerusakan infrastruktur di sekitar Anda. Lokasi
                GPS akan terdeteksi otomatis. Tidak perlu login, gratis.</p>
        </div>

        <form id="formLaporan" action="{{ route('proses.laporan') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            <input type="hidden" id="inputLatitude" name="latitude" value="{{ old('latitude') }}">
            <input type="hidden" id="inputLongitude" name="longitude" value="{{ old('longitude') }}">

            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-2xl p-5 sm:p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-800 dark:text-white mb-0.5">Lokasi GPS</div>
                        <div class="text-xs text-slate-400 dark:text-slate-500">Koordinat dideteksi otomatis dari
                            perangkat Anda</div>
                    </div>
                    <div id="ikonLokasi"
                        class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 animate-spin" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div id="statusLokasi"
                    class="status-lokasi bg-slate-100 dark:bg-slate-800 rounded-xl px-4 py-3 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse flex-shrink-0"></span>
                    Mendeteksi lokasi... Izinkan akses GPS jika diminta.
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-2xl p-5 sm:p-6 shadow-sm">
                <div class="text-sm font-semibold text-slate-800 dark:text-white mb-1">Foto Kerusakan</div>
                <div class="text-xs text-slate-400 dark:text-slate-500 mb-4">Upload foto jalan berlubang atau kerusakan
                    infrastruktur (maks. 5MB)</div>
                <label for="inputFoto"
                    class="upload-area border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-brand-400 dark:hover:border-brand-500 rounded-2xl p-8 flex flex-col items-center justify-center cursor-pointer gap-3 relative group bg-slate-50 dark:bg-slate-800/50 hover:bg-brand-50/50 dark:hover:bg-brand-500/5 transition-all">
                    <div id="ikonUpload" class="text-center">
                        <div
                            class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-brand-100 dark:group-hover:bg-brand-500/20 transition">
                            <svg class="w-7 h-7 text-slate-400 dark:text-slate-500 group-hover:text-brand-500 dark:group-hover:text-brand-400 transition"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-slate-600 dark:text-slate-300">Klik untuk pilih foto</div>
                        <div class="text-xs text-slate-400 dark:text-slate-500 mt-1">atau seret dan lepas file di sini
                        </div>
                    </div>
                    <img id="pratinjauFoto" src="" alt="Pratinjau"
                        class="hidden max-h-60 rounded-xl object-cover w-full opacity-0">
                    <input type="file" id="inputFoto" name="foto" accept="image/*" class="hidden">
                </label>
            </div>

            <button type="button" id="tombolKirim" @click.prevent="munculkanLoadingSwal()"
                class="w-full bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-400 hover:to-brand-500 text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-brand-500/20 flex items-center justify-center gap-2 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kirim Laporan Sekarang
            </button>

            <p class="text-center text-xs text-slate-400 dark:text-slate-500">Dengan mengirim laporan, Anda menyetujui
                bahwa data ini akan diproses oleh sistem SIGAP BDG.</p>
        </form>
    </main>

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
                    statusEl.classList.remove('text-slate-500', 'text-slate-400');
                    statusEl.classList.add('text-emerald-600', 'dark:text-emerald-400');
                    ikonEl.innerHTML = '<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                    ikonEl.classList.add('bg-emerald-50', 'dark:bg-emerald-900/30');
                    ikonEl.classList.remove('bg-slate-100', 'dark:bg-slate-800');
                }

                function gagal() {
                    statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-400 flex-shrink-0"></span> Gagal mendeteksi lokasi. Pastikan GPS aktif dan izin diberikan.';
                    statusEl.classList.remove('text-slate-500', 'text-slate-400');
                    statusEl.classList.add('text-red-500', 'dark:text-red-400');
                    ikonEl.innerHTML = '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    ikonEl.classList.add('bg-red-50', 'dark:bg-red-900/30');
                    ikonEl.classList.remove('bg-slate-100', 'dark:bg-slate-800');
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

        function munculkanLoadingSwal() {
            var gelap = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'Memproses Laporan...',
                html: '<span style="color:' + (gelap ? '#94a3b8' : '#64748b') + ';font-size:14px">AI sedang menganalisis foto kerusakan Anda.<br>Harap tunggu sebentar.</span>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-kustom-popup',
                },
                background: gelap ? '#1e293b' : '#ffffff',
                color: gelap ? '#f1f5f9' : '#1e293b',
                didOpen: function () {
                    Swal.showLoading();
                }
            });
            document.getElementById('formLaporan').submit();
        }

        @if(session('trackingBerhasil'))
            (function () {
                var gelap = localStorage.getItem('temaGelap') === 'true';
                Swal.fire({
                    icon: 'success',
                    title: 'Laporan Terkirim!',
                    html: '<div style="font-size:13px;color:' + (gelap ? '#94a3b8' : '#64748b') + ';line-height:1.6">Laporan Anda berhasil diterima sistem.<br>Tracking ID: <strong style="font-family:monospace;font-size:16px;color:' + (gelap ? '#f1f5f9' : '#1e293b') + ';letter-spacing:0.1em">{{ session('trackingBerhasil') }}</strong></div>',
                    confirmButtonText: 'Lihat Status',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup',
                    customClass: {
                        popup: 'swal-kustom-popup',
                        confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-semibold',
                        cancelButton: 'rounded-xl px-5 py-2.5 text-sm font-semibold',
                    },
                    background: gelap ? '#1e293b' : '#ffffff',
                    color: gelap ? '#f1f5f9' : '#1e293b',
                    confirmButtonColor: '#f97316',
                    cancelButtonColor: gelap ? '#334155' : '#e2e8f0',
                }).then(function (hasil) {
                    if (hasil.isConfirmed) {
                        window.location.href = '{{ route("lacak") }}';
                    }
                });
            })();
        @endif
    </script>

</body>

</html>