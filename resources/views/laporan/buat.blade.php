<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - SIGAP BDG</title>
    <meta name="description" content="Form pelaporan infrastruktur dan keamanan warga Kota Bandung secara anonim dengan SIGAP BDG.">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gps-pulse {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .preview-img {
            transition: opacity 0.3s ease;
        }
        .drag-over {
            border-color: #3b82f6 !important;
            background-color: #eff6ff !important;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 py-10 px-4">

    {{-- Header --}}
    <div class="max-w-2xl mx-auto mb-8 text-center">
        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 text-blue-200 hover:text-white text-sm mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Beranda
        </a>
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white">Buat Laporan</h1>
        <p class="text-blue-200 text-sm mt-2">Laporkan masalah infrastruktur atau kejahatan di sekitarmu secara anonim.</p>
    </div>

    {{-- Card Form --}}
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">

        {{-- Progress Bar --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-1.5">
            <div id="progress-bar" class="bg-yellow-400 h-full transition-all duration-500" style="width: 0%"></div>
        </div>

        <div class="px-8 py-8">

            {{-- Flash Message --}}
            @if (session('sukses'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('sukses') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-laporan" method="POST" action="{{ route('laporan.simpan') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Jenis Laporan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Jenis Laporan <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label for="jenis-infrastruktur"
                            class="jenis-card flex flex-col items-center gap-2 border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" id="jenis-infrastruktur" name="jenis_laporan" value="infrastruktur"
                                class="sr-only" {{ old('jenis_laporan') == 'infrastruktur' ? 'checked' : '' }} required>
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Infrastruktur</span>
                            <span class="text-xs text-gray-400 text-center">Jalan rusak, lampu mati, drainase, dll.</span>
                        </label>

                        <label for="jenis-kejahatan"
                            class="jenis-card flex flex-col items-center gap-2 border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-red-400 hover:bg-red-50 transition-all duration-200 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" id="jenis-kejahatan" name="jenis_laporan" value="kejahatan"
                                class="sr-only" {{ old('jenis_laporan') == 'kejahatan' ? 'checked' : '' }}>
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Kejahatan</span>
                            <span class="text-xs text-gray-400 text-center">Kriminal, pencurian, vandalisme, dll.</span>
                        </label>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Deskripsi Laporan <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        required
                        maxlength="1000"
                        placeholder="Ceritakan detail kejadian atau masalah yang kamu temukan..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                    >{{ old('deskripsi') }}</textarea>
                    <div class="flex justify-end mt-1">
                        <span id="char-count" class="text-xs text-gray-400">0 / 1000</span>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Foto Bukti <span class="text-gray-400 font-normal">(opsional, maks. 5MB)</span>
                    </label>
                    <div id="drop-zone"
                        class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-200"
                        onclick="document.getElementById('foto').click()">
                        <div id="drop-placeholder">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500">Klik atau seret foto ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG — maks. 5MB</p>
                        </div>
                        <div id="preview-container" class="hidden">
                            <img id="preview-img" src="#" alt="Preview foto" class="preview-img max-h-48 mx-auto rounded-lg object-cover shadow">
                            <p id="preview-name" class="text-xs text-gray-500 mt-2"></p>
                            <button type="button" id="hapus-foto"
                                class="mt-2 text-xs text-red-500 hover:text-red-700 underline"
                                onclick="event.stopPropagation(); hapusFoto()">Hapus foto</button>
                        </div>
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/*" capture="environment" class="hidden">
                </div>

                {{-- Lokasi GPS --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Lokasi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1">
                                <p id="gps-status" class="text-sm text-gray-500">Lokasi belum terdeteksi.</p>
                                <p id="gps-coords" class="text-xs text-gray-400 mt-0.5 font-mono hidden"></p>
                            </div>
                            <button type="button" id="btn-gps"
                                onclick="deteksiLokasi()"
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition shrink-0">
                                <svg id="gps-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span id="btn-gps-text">Deteksi Lokasi</span>
                            </button>
                        </div>

                        {{-- Alamat Manual --}}
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <label for="alamat" class="block text-xs font-medium text-gray-600 mb-1">
                                Alamat / Keterangan Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="alamat"
                                name="alamat"
                                value="{{ old('alamat') }}"
                                required
                                placeholder="Contoh: Jl. Braga No. 10, depan toko buku"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            >
                        </div>
                    </div>

                    {{-- Hidden fields koordinat --}}
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                </div>

                {{-- Nama Pelapor (Opsional) --}}
                <div>
                    <label for="nama_pelapor" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Pelapor <span class="text-gray-400 font-normal">(opsional, bisa anonim)</span>
                    </label>
                    <input
                        type="text"
                        id="nama_pelapor"
                        name="nama_pelapor"
                        value="{{ old('nama_pelapor') }}"
                        placeholder="Kosongkan jika ingin anonim"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    >
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        id="btn-submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Laporan
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">
                        Laporan kamu akan mendapat <strong>Tracking ID</strong> untuk memantau status.
                    </p>
                </div>

            </form>
        </div>
    </div>

    {{-- Link ke halaman lacak --}}
    <div class="max-w-2xl mx-auto mt-6 text-center">
        <p class="text-blue-200 text-sm">
            Sudah punya laporan?
            <a href="{{ route('laporan.lacak') }}" class="text-white font-semibold hover:underline">Lacak statusnya →</a>
        </p>
    </div>

    {{-- JavaScript: GPS & Preview Foto --}}
    <script>
        // =============================================
        // [SIGAP-11] GPS Geolocation Detection
        // =============================================
        function deteksiLokasi() {
            const btnText    = document.getElementById('btn-gps-text');
            const gpsIcon    = document.getElementById('gps-icon');
            const gpsStatus  = document.getElementById('gps-status');
            const gpsCoords  = document.getElementById('gps-coords');
            const latInput   = document.getElementById('latitude');
            const lngInput   = document.getElementById('longitude');

            if (!navigator.geolocation) {
                gpsStatus.textContent = '⚠️ Browser tidak mendukung GPS.';
                gpsStatus.classList.add('text-red-500');
                return;
            }

            // Loading state
            btnText.textContent = 'Mendeteksi...';
            gpsIcon.classList.add('gps-pulse');
            gpsStatus.textContent = 'Sedang mendeteksi lokasi kamu...';
            gpsStatus.classList.remove('text-green-600', 'text-red-500');
            gpsStatus.classList.add('text-blue-500');

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude.toFixed(6);
                    const lng = position.coords.longitude.toFixed(6);
                    const acc = Math.round(position.coords.accuracy);

                    // Isi hidden field
                    latInput.value = lat;
                    lngInput.value = lng;

                    // Update UI
                    gpsStatus.textContent = '✅ Lokasi berhasil terdeteksi!';
                    gpsStatus.classList.remove('text-blue-500', 'text-red-500');
                    gpsStatus.classList.add('text-green-600');

                    gpsCoords.textContent = `Lat: ${lat}, Lng: ${lng} (akurasi ±${acc}m)`;
                    gpsCoords.classList.remove('hidden');

                    btnText.textContent = 'Perbarui Lokasi';
                    gpsIcon.classList.remove('gps-pulse');

                    updateProgress();
                },
                function (error) {
                    let pesan = 'Gagal mendeteksi lokasi.';
                    if (error.code === error.PERMISSION_DENIED)
                        pesan = '⚠️ Izin lokasi ditolak. Aktifkan di pengaturan browser.';
                    else if (error.code === error.POSITION_UNAVAILABLE)
                        pesan = '⚠️ Informasi lokasi tidak tersedia.';
                    else if (error.code === error.TIMEOUT)
                        pesan = '⚠️ Waktu deteksi habis. Coba lagi.';

                    gpsStatus.textContent = pesan;
                    gpsStatus.classList.remove('text-blue-500', 'text-green-600');
                    gpsStatus.classList.add('text-red-500');

                    btnText.textContent = 'Coba Lagi';
                    gpsIcon.classList.remove('gps-pulse');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        }

        // =============================================
        // Preview & Upload Foto
        // =============================================
        const fotoInput      = document.getElementById('foto');
        const dropZone       = document.getElementById('drop-zone');
        const placeholder    = document.getElementById('drop-placeholder');
        const previewCont    = document.getElementById('preview-container');
        const previewImg     = document.getElementById('preview-img');
        const previewName    = document.getElementById('preview-name');

        fotoInput.addEventListener('change', function () {
            tampilkanPreview(this.files[0]);
        });

        // Drag & Drop
        dropZone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', function () {
            this.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fotoInput.files = dataTransfer.files;
                tampilkanPreview(file);
            }
        });

        function tampilkanPreview(file) {
            if (!file) return;
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                placeholder.classList.add('hidden');
                previewCont.classList.remove('hidden');
                updateProgress();
            };
            reader.readAsDataURL(file);
        }

        function hapusFoto() {
            fotoInput.value = '';
            previewImg.src = '#';
            previewName.textContent = '';
            placeholder.classList.remove('hidden');
            previewCont.classList.add('hidden');
            updateProgress();
        }

        // =============================================
        // Progress Bar & Char Counter
        // =============================================
        const deskripsiInput = document.getElementById('deskripsi');
        const charCount      = document.getElementById('char-count');

        deskripsiInput.addEventListener('input', function () {
            charCount.textContent = this.value.length + ' / 1000';
            updateProgress();
        });

        document.querySelectorAll('input[name="jenis_laporan"]').forEach(el => {
            el.addEventListener('change', updateProgress);
        });

        document.getElementById('alamat').addEventListener('input', updateProgress);

        function updateProgress() {
            let score = 0;
            if (document.querySelector('input[name="jenis_laporan"]:checked')) score += 25;
            if (deskripsiInput.value.trim().length > 10) score += 25;
            if (document.getElementById('latitude').value) score += 25;
            if (document.getElementById('alamat').value.trim().length > 3) score += 25;
            document.getElementById('progress-bar').style.width = score + '%';
        }

        // Submit loading state
        document.getElementById('form-laporan').addEventListener('submit', function () {
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Mengirim Laporan...
            `;
        });
    </script>
</body>
</html>
