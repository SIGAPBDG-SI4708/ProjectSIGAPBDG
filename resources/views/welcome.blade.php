<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP BANDUNG - Platform Pengaduan Masyarakat Terintegrasi</title>
    <!-- Tailwind CSS & Lucide Icons via FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        .hero-bg { background-color: #0A0A0B; background-image: radial-gradient(circle at 50% 0%, #1E3A8A 0%, transparent 70%); }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .nav-scrolled { background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(24px); border-bottom: 1px solid #f1f5f9; padding: 12px 0 !important; color: #111 !important; }
    </style>
</head>
<body class="bg-white text-gray-900">

<!-- Header -->
<header id="navbar" class="fixed top-0 w-full z-50 transition-all duration-500 py-8 text-white">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 p-2 rounded-xl text-white"><i class="fas fa-shield-halved fa-lg"></i></div>
            <div class="flex flex-col leading-none">
                <span class="text-xl font-black tracking-tighter">SIGAP</span>
                <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Bandung</span>
            </div>
        </div>
        <nav class="hidden lg:flex gap-10 text-xs font-black uppercase tracking-widest opacity-80">
            <a href="#fitur" class="hover:text-blue-500">Fitur</a>
            <a href="#alur" class="hover:text-blue-500">Alur</a>
            <a href="#kategori" class="hover:text-blue-500">Kategori</a>
        </nav>
        <div class="flex gap-4">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-black text-xs uppercase shadow-xl transition-all active:scale-95">Bergabung</button>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="relative hero-bg pt-48 pb-32 overflow-hidden min-h-screen flex items-center">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <div class="glass px-4 py-2 rounded-full inline-flex items-center gap-3 mb-8">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-[0_0_10px_#3b82f6]"></div>
                <span class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em]">Live Smart Monitor Active</span>
            </div>
            <h1 class="text-7xl md:text-[140px] font-black text-white leading-[0.85] tracking-tighter mb-10 select-none">
                SIGAP <br> <span class="text-blue-500">BANDUNG</span>
            </h1>
            <p class="text-xl text-gray-400 max-w-xl mb-12 font-medium leading-relaxed">
                Platform integrasi respon cepat Kota Bandung. Laporkan masalah Anda secara real-time dan pantau solusi di genggaman tangan.
            </p>
            <div class="flex flex-wrap gap-6 mb-20">
                <button class="bg-white text-black px-12 h-20 rounded-2xl font-black text-xl shadow-2xl hover:bg-gray-100 transition-all active:scale-95">
                    Buat Laporan <i class="fas fa-arrow-right ml-4"></i>
                </button>
                <button class="glass text-white px-10 h-20 rounded-2xl font-bold flex items-center gap-4 hover:bg-white/10 transition-all">
                    <i class="fas fa-headphones text-blue-500"></i> Support Hub
                </button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 border-t border-white/10 pt-12">
                <div><h3 class="text-3xl font-black text-white">12K+</h3><p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Tertangani</p></div>
                <div><h3 class="text-3xl font-black text-white">08m</h3><p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Respon Rata2</p></div>
                <div><h3 class="text-3xl font-black text-white">100%</h3><p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Transparan</p></div>
                <div><h3 class="text-3xl font-black text-white">24h</h3><p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Aktif</p></div>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Section -->
<section id="fitur" class="py-32 bg-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-black mb-20 text-gray-900 leading-tight">SOLUSI LENGKAP <br> <span class="text-blue-600">UNTUK WARGA</span></h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-10 rounded-[3rem] border border-gray-100 hover:shadow-2xl transition-all">
                <i class="fas fa-camera fa-3x text-blue-600 mb-8"></i>
                <h4 class="text-xl font-black mb-4 uppercase">Upload Bukti</h4>
                <p class="text-gray-500 text-sm">Lampirkan foto dan video masalah real-time untuk verifikasi cepat instansi.</p>
            </div>
            <div class="p-10 rounded-[3rem] border border-gray-100 hover:shadow-2xl transition-all">
                <i class="fas fa-location-dot fa-3x text-red-600 mb-8"></i>
                <h4 class="text-xl font-black mb-4 uppercase">Geotagging</h4>
                <p class="text-gray-500 text-sm">Lokasi kejadian terdeteksi otomatis menggunakan GPS untuk akurasi tim lapangan.</p>
            </div>
            <div class="p-10 rounded-[3rem] border border-gray-100 hover:shadow-2xl transition-all">
                <i class="fas fa-bell fa-3x text-yellow-600 mb-8"></i>
                <h4 class="text-xl font-black mb-4 uppercase">Tracking Status</h4>
                <p class="text-gray-500 text-sm">Terima notifikasi instan saat laporan Anda diproses hingga dinyatakan selesai.</p>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Section -->
<section id="kategori" class="py-32 bg-gray-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-black mb-20 uppercase tracking-tighter">APA YANG ANDA <span class="text-blue-600">ADUKAN?</span></h2>
        <div class="grid md:grid-cols-4 gap-6">
            <?php 
            $cats = [
                ['Keamanan', 'fa-shield-halved', 'red'],
                ['Infrastruktur', 'fa-road', 'blue'],
                ['Sampah', 'fa-trash', 'green'],
                ['Bencana', 'fa-fire', 'orange']
            ];
            foreach($cats as $c): ?>
            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 group hover:bg-blue-600 transition-all cursor-pointer">
                <div class="w-20 h-20 bg-<?php echo $c[2]; ?>-50 text-<?php echo $c[2]; ?>-600 rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:bg-white group-hover:scale-110 transition-all">
                    <i class="fas <?php echo $c[1]; ?> fa-2xl"></i>
                </div>
                <h4 class="text-xl font-black group-hover:text-white"><?php echo $c[0]; ?></h4>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="py-32 bg-[#0A0A0B] text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-black mb-24 leading-none">WARGA YANG <br> <span class="text-blue-500">MENGINSPIRASI</span></h2>
        <div class="grid md:grid-cols-3 gap-12">
            <div class="glass p-12 rounded-[3.5rem] text-left">
                <p class="text-xl text-gray-300 italic mb-12">"Responnya luar biasa cepat. Jalan berlubang di Pasteur langsung diperbaiki dalam 48 jam!"</p>
                <div class="flex items-center gap-6">
                    <img src="https://i.pravatar.cc/100?u=1" class="w-14 h-14 rounded-2xl border-2 border-white/20" alt="user">
                    <div><h5 class="font-black uppercase">Andi Wijaya</h5><p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Warga Cicadas</p></div>
                </div>
            </div>
            <div class="glass p-12 rounded-[3.5rem] text-left">
                <p class="text-xl text-gray-300 italic mb-12">"Sangat transparan. Saya bisa melihat posisi tim teknis secara real-time di aplikasi."</p>
                <div class="flex items-center gap-6">
                    <img src="https://i.pravatar.cc/100?u=2" class="w-14 h-14 rounded-2xl border-2 border-white/20" alt="user">
                    <div><h5 class="font-black uppercase">Siti Aisyah</h5><p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Warga Dago</p></div>
                </div>
            </div>
            <div class="glass p-12 rounded-[3.5rem] text-left">
                <p class="text-xl text-gray-300 italic mb-12">"Panic button benar-benar membantu saat ada kejadian darurat. Tim keamanan langsung siaga."</p>
                <div class="flex items-center gap-6">
                    <img src="https://i.pravatar.cc/100?u=3" class="w-14 h-14 rounded-2xl border-2 border-white/20" alt="user">
                    <div><h5 class="font-black uppercase">Budi Santoso</h5><p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Warga Antapani</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-[#1E3A8A] text-white py-20">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-12 mb-20 pb-20 border-b border-white/10">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-8">
                    <i class="fas fa-shield-halved fa-2x"></i>
                    <span class="text-3xl font-black tracking-tighter">SIGAPBANDUNG</span>
                </div>
                <p class="text-blue-100 max-w-sm">Pusat kendali pengaduan pemerintah kota untuk pelayanan publik yang lebih tanggap dan berkelanjutan.</p>
            </div>
            <div>
                <h5 class="font-black uppercase mb-8 tracking-widest">Link Cepat</h5>
                <ul class="space-y-4 text-blue-200 text-sm">
                    <li><a href="#" class="hover:text-white">Cara Lapor</a></li>
                    <li><a href="#" class="hover:text-white">Daftar Instansi</a></li>
                    <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-black uppercase mb-8 tracking-widest">Kontak</h5>
                <ul class="space-y-4 text-blue-200 text-sm">
                    <li><i class="fas fa-phone mr-3"></i> 112 (Bebas Pulsa)</li>
                    <li><i class="fas fa-envelope mr-3"></i> halo@bandung.go.id</li>
                </ul>
            </div>
        </div>
        <p class="text-center text-[10px] font-bold text-blue-300 uppercase tracking-[0.3em]">&copy; <?php echo date("Y"); ?> PEMERINTAH KOTA BANDUNG. HUBUNGI KAMI UNTUK DARURAT.</p>
    </div>
</footer>

<script>
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 40) { nav.classList.add('nav-scrolled'); } 
        else { nav.classList.remove('nav-scrolled'); }
    });
</script>
</body>
/html>