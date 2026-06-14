<p align="center">
  <img src="public/images/ikon chat ai.jpeg" alt="SIGAP BDG Logo" width="120" height="120" style="border-radius: 20px;">
</p>

<h1 align="center">SIGAP BDG</h1>
<p align="center"><strong>Sistem Informasi Pelaporan Publik Kota Bandung</strong></p>
<p align="center">
  <em>Lapor Cepat & Tanggap — Mewujudkan kota yang aman, nyaman, dan responsif terhadap kebutuhan warga.</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/OpenAI-GPT--4o-412991?style=for-the-badge&logo=openai&logoColor=white" alt="OpenAI">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## 👥 Tim Pengembang

| No | Nama | NIM | Peran |
|----|------|-----|-------|
| 1 | Muhammad Rayhan Ramadhan | 102022330145 | Project Manager |
| 2 | Alexander Christopher Togelang | 102022300040 | Developer |
| 3 | Darvesh Gladwin Musyaffa | 102022300082 | Developer |
| 4 | Feriangga Arkaan Prayetno | 102022330238 | Developer |
| 5 | Jehezkiel Agna Saputra | 102022300416 | Developer |
| 6 | Muhammad Caesar Rivaldo | 102022300289 | Developer |
| 7 | Rahmania Anggraini | 102022300034  | Developer |

---

## 🏗️ System Architecture

SIGAP BDG dibangun menggunakan arsitektur **monolitik berbasis Laravel** dengan integrasi AI melalui OpenAI API dan real-time broadcasting via Laravel Reverb (WebSocket).

```
┌─────────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                                │
│  ┌───────────────┐  ┌───────────────┐  ┌──────────────────────┐    │
│  │  Landing Page │  │ Lapor & Lacak │  │  Admin Dashboard     │    │
│  │  (welcome)    │  │ (publik)      │  │  (portal-internal)   │    │
│  └───────┬───────┘  └───────┬───────┘  └──────────┬───────────┘    │
│          │  Blade + Tailwind CSS CDN + Alpine.js   │               │
│          │          Laravel Echo + Pusher.js        │               │
└──────────┼──────────────────┼──────────────────────┼───────────────┘
           │                  │                      │
           ▼                  ▼                      ▼
┌─────────────────────────────────────────────────────────────────────┐
│                       APPLICATION LAYER (Laravel 13)                │
│                                                                     │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │                      CONTROLLERS                             │   │
│  │  BerandaController    │ LaporanController   │ AdminController│   │
│  │  LeaderboardController│ PengajuanDana       │ AuditDana/Fisik│   │
│  │  ChatController       │ OtentikasiController│ EksporController│  │
│  │  MinGapChatbotCtrl    │ AdminChatbotCtrl    │ NotificationCtrl│  │
│  └──────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ┌────────────────────────────────────────────┐                    │
│  │              AI SERVICES                    │                    │
│  │  LayananSimulasiAi ──► GPT-4o Vision       │                    │
│  │    (Spam Detection + Damage Analysis)       │                    │
│  │  MinGapAiService ──► GPT-4o-mini           │                    │
│  │    (Public Chatbot + Tracking ID Lookup)    │                    │
│  │  AdminDecisionService ──► GPT-4o-mini      │                    │
│  │    (Budget Audit + Priority Assessment)     │                    │
│  └────────────────────────────────────────────┘                    │
│                                                                     │
│  ┌────────────────────────────────────────────┐                    │
│  │          REAL-TIME BROADCASTING             │                    │
│  │  Laravel Reverb (WebSocket Server)          │                    │
│  │  ├─ LaporanMasukEvent → Admin Notification  │                    │
│  │  ├─ ChatMessageSent → Private Messaging     │                    │
│  │  └─ ChatMessagesRead → Read Receipts        │                    │
│  └────────────────────────────────────────────┘                    │
│                                                                     │
│  ┌────────────────────────────────────────────┐                    │
│  │              QUEUE SYSTEM                   │                    │
│  │  Database Queue Driver                      │                    │
│  │  └─ AI Analysis Jobs (async processing)     │                    │
│  └────────────────────────────────────────────┘                    │
└─────────────────────────────────────────────────────────────────────┘
           │                                       │
           ▼                                       ▼
┌──────────────────────┐              ┌───────────────────────────┐
│    DATA LAYER        │              │    EXTERNAL SERVICES      │
│  ┌────────────────┐  │              │  ┌─────────────────────┐  │
│  │  MySQL DB      │  │              │  │  OpenAI API         │  │
│  │  (sigap_bdg)   │  │              │  │  (GPT-4o / 4o-mini) │  │
│  ├────────────────┤  │              │  ├─────────────────────┤  │
│  │  10 Tables:    │  │              │  │  Nominatim OSM API  │  │
│  │  - users       │  │              │  │  (Reverse Geocoding)│  │
│  │  - daerah      │  │              │  └─────────────────────┘  │
│  │  - laporan_    │  │              └───────────────────────────┘
│  │    infrastruktur│  │
│  │  - laporan_    │  │
│  │    kejahatan   │  │
│  │  - analisis_ai │  │
│  │  - pengajuan_  │  │
│  │    dana        │  │
│  │  - ulasan_     │  │
│  │    laporan     │  │
│  │  - chat_       │  │
│  │    messages    │  │
│  │  - laporan_    │  │
│  │    timeline    │  │
│  │  - poin_       │  │
│  │    kontribusi  │  │
│  └────────────────┘  │
│  ┌────────────────┐  │
│  │  File Storage  │  │
│  │  (public disk) │  │
│  │  └─ laporan/   │  │
│  │    (foto bukti)│  │
│  └────────────────┘  │
└──────────────────────┘
```

### Alur Kerja Utama

```
Warga Upload Foto ──► Reverse Geocoding (OSM) ──► Simpan ke DB
                                                        │
                                                        ▼
                                              GPT-4o Vision Analysis
                                              (Spam? Jenis? Biaya?)
                                                        │
                                          ┌─────────────┼─────────────┐
                                          ▼                           ▼
                                    Spam → Ditolak            Valid → Menunggu
                                                                      │
                                                        Broadcast ke Admin
                                                        (Real-time Notif)
                                                                      │
                                                              Admin Review
                                                     ┌────────┼────────┐
                                                     ▼        ▼        ▼
                                               Diproses  Pengajuan   Selesai
                                                          Dana        │
                                                           │     Warga Ulasan
                                                    Audit Anggaran   (⭐ 1-5)
                                                    (AI Decision)
```

---

## ✨ Key Features

### 🌐 Sisi Publik (Tanpa Login)

| Fitur | Deskripsi |
|-------|-----------|
| **📝 Lapor Infrastruktur** | Upload foto kerusakan infrastruktur, GPS otomatis mendeteksi lokasi dan kecamatan via Nominatim API. Mendapatkan Tracking ID unik (format `SIGAP-XXXXXX`). |
| **🤖 AI Spam Detection** | GPT-4o Vision menganalisis foto: mendeteksi spam (selfie, hewan, pemandangan), mengidentifikasi jenis kerusakan, tingkat keparahan (Ringan/Sedang/Berat), dan estimasi biaya perbaikan. |
| **🔍 Lacak Laporan** | Cek progres laporan menggunakan Tracking ID. Menampilkan timeline status lengkap dari "Menunggu" hingga "Selesai". |
| **⭐ Ulasan & Rating** | Warga memberikan ulasan (1–5 bintang) untuk laporan yang sudah selesai. Rating berkontribusi ke sistem poin kecamatan. |
| **🚨 Lapor Kejahatan** | Laporan kerawanan/kriminal berbasis lokasi GPS. Data ditampilkan sebagai titik panas (heatmap) pada peta admin. |
| **🏆 Leaderboard Kecamatan** | Papan peringkat kecamatan ter-SIGAP berdasarkan akumulasi poin kontribusi, rasio penyelesaian, dan rata-rata rating warga. |
| **💬 MinGAP Chatbot** | Asisten AI floating widget (GPT-4o-mini) yang membantu warga: tanya alur laporan, lacak status via Tracking ID langsung dari chat, info darurat 112, dan lainnya. Welcome page ala Gemini/ChatGPT. |
| **🌙 Dark Mode** | Toggle tema gelap/terang yang konsisten di seluruh halaman termasuk chatbot widget. |

### 🔐 Sisi Admin (Portal Internal)

| Fitur | Deskripsi |
|-------|-----------|
| **📊 Dashboard** | Ringkasan statistik: total laporan, status terkini, laporan terbaru, dan notifikasi real-time. |
| **📋 Manajemen Laporan** | Daftar laporan infrastruktur dengan filter status. Perubahan status (Menunggu → Diproses → Selesai/Ditolak) dicatat di timeline. |
| **💰 Audit Keuangan** | Admin Daerah mengajukan dana perbaikan. Super Admin melakukan audit persetujuan anggaran dengan bantuan AI Decision Assistant. |
| **🤖 AI Decision Assistant** | Asisten AI internal (GPT-4o-mini) yang menganalisis kewajaran anggaran, menentukan prioritas perbaikan, dan memberikan rekomendasi keputusan (Setuju/Tolak/Negosiasi). |
| **🗺️ Peta Kejahatan** | Visualisasi titik-titik kerawanan kejahatan pada peta interaktif per kecamatan. |
| **💬 Real-time Chat** | Sistem pesan internal antar admin (Super Admin ↔ Admin Daerah) via Laravel Reverb WebSocket dengan indikator read receipt. |
| **🔔 Notifikasi Real-time** | Push notification saat laporan baru masuk, di-broadcast ke admin terkait berdasarkan kecamatan. |
| **📥 Ekspor Data** | Ekspor laporan ke format CSV dan PDF dengan filter tanggal, kategori, status, dan daerah. |
| **👥 Manajemen Pegawai** | Super Admin mengelola akun admin daerah: aktivasi, suspensi, dan pengaturan akses. |
| **🏆 Leaderboard Admin** | Kelola poin kontribusi kecamatan dan berikan bonus poin spesial. |

### 🔑 Role-Based Access

| Role | Akses |
|------|-------|
| **Super Admin** | Full access: semua laporan, audit keuangan, peta kejahatan, manajemen pegawai, leaderboard, ekspor data |
| **Admin Daerah** | Laporan kecamatan sendiri, pengajuan dana, chat internal, leaderboard daerah sendiri |
| **Publik (Tanpa Login)** | Lapor, lacak, leaderboard publik, chatbot MinGAP |

---

## 🚀 Installation & Run Guide

### Prerequisites

Pastikan sistem Anda sudah terinstal:

- **PHP** ≥ 8.3
- **Composer** ≥ 2.x
- **Node.js** ≥ 18.x & **npm**
- **MySQL** ≥ 8.0
- **Git**

### Langkah Instalasi

#### 1. Clone Repository

```bash
git clone https://github.com/username/ProjectSIGAPBDG.git
cd ProjectSIGAPBDG
```

#### 2. Install Dependencies

```bash
composer install
npm install
```

#### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi berikut:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigap_bdg
DB_USERNAME=root
DB_PASSWORD=

# Queue & Broadcasting
QUEUE_CONNECTION=database
BROADCAST_CONNECTION=reverb

# OpenAI API Key (wajib untuk fitur AI)
OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxxxxxxxxx

# Laravel Reverb (WebSocket)
REVERB_APP_ID=751061
REVERB_APP_KEY=your_reverb_app_key
REVERB_APP_SECRET=your_reverb_app_secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

#### 4. Setup Database

Buat database MySQL terlebih dahulu:

```sql
CREATE DATABASE sigap_bdg;
```

Jalankan migrasi dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

#### 5. Link Storage

```bash
php artisan storage:link
```

### Menjalankan Aplikasi

Buka **4 terminal terpisah** dan jalankan masing-masing:

```bash
# Terminal 1 — Web Server
php artisan serve

# Terminal 2 — Vite Dev Server (frontend asset)
npm run dev

# Terminal 3 — WebSocket Server (real-time features)
php artisan reverb:start

# Terminal 4 — Queue Worker (AI processing)
php artisan queue:listen
```

Atau jalankan semuanya sekaligus dengan satu perintah:

```bash
composer dev
```

Aplikasi dapat diakses di: **http://127.0.0.1:8000**

### Akun Default (dari Seeder)

| Role | Email | Password |
|------|-------|----------|
| Super Admin | Cek `database/seeders/UserSeeder.php` | Cek seeder |
| Admin Daerah | Cek `database/seeders/UserSeeder.php` | Cek seeder |

> **Catatan:** Portal admin diakses melalui route `/portal-internal`.

---

## 📁 Project Structure

```
ProjectSIGAPBDG/
├── app/
│   ├── Events/
│   │   ├── ChatMessageSent.php          # Broadcast pesan chat (real-time)
│   │   ├── ChatMessagesRead.php         # Broadcast read receipt
│   │   └── LaporanMasukEvent.php        # Broadcast notifikasi laporan baru
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminChatbotController.php    # AI Decision Assistant (admin)
│   │       ├── AdminController.php          # Dashboard, peta, pegawai
│   │       ├── AuditDanaController.php      # Audit persetujuan anggaran
│   │       ├── AuditFisikController.php     # Update status laporan
│   │       ├── BerandaController.php        # Landing page publik
│   │       ├── ChatController.php           # Real-time chat antar admin
│   │       ├── LaporanController.php        # Lapor, lacak, ulasan, kejahatan
│   │       ├── LaporanEksporController.php  # Ekspor CSV & PDF
│   │       ├── LeaderboardController.php    # Leaderboard publik & admin
│   │       ├── MinGapChatbotController.php  # Chatbot publik MinGAP
│   │       ├── NotificationController.php   # Mark notification as read
│   │       ├── OtentikasiController.php     # Login, register, logout
│   │       └── PengajuanDanaController.php  # Pengajuan & proses dana
│   ├── Models/
│   │   ├── AnalisisAi.php               # Hasil analisis GPT-4o Vision
│   │   ├── ChatMessage.php              # Pesan chat internal
│   │   ├── Daerah.php                   # Kecamatan Kota Bandung (41 daerah)
│   │   ├── LaporanInfrastruktur.php     # Laporan kerusakan infrastruktur
│   │   ├── LaporanKejahatan.php         # Laporan kerawanan kejahatan
│   │   ├── LaporanTimeline.php          # Riwayat perubahan status laporan
│   │   ├── PengajuanDana.php            # Pengajuan anggaran perbaikan
│   │   ├── PoinKontribusiDaerah.php     # Poin kontribusi untuk leaderboard
│   │   ├── UlasanLaporan.php            # Ulasan & rating dari warga
│   │   └── User.php                     # Admin (Super Admin / Admin Daerah)
│   ├── Notifications/
│   │   ├── ChatMasukNotification.php    # Notifikasi chat masuk
│   │   └── LaporanMasukNotification.php # Notifikasi laporan baru
│   ├── Providers/
│   └── Services/
│       ├── AdminDecisionService.php     # AI: Audit anggaran & rekomendasi
│       ├── LayananSimulasiAi.php        # AI: Analisis foto (GPT-4o Vision)
│       └── MinGapAiService.php          # AI: Chatbot publik + tracking lookup
├── database/
│   ├── migrations/                      # 15 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── DaerahSeeder.php             # Seed 41 kecamatan Bandung & sekitar
│       └── UserSeeder.php              # Seed akun admin default
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── admin/
│       │   ├── asisten-ai/              # Halaman AI Decision Assistant
│       │   ├── ekspor/                  # Halaman ekspor CSV/PDF
│       │   ├── keuangan/               # Halaman audit keuangan
│       │   ├── laporan/                # Halaman manajemen laporan
│       │   ├── leaderboard/            # Halaman leaderboard admin
│       │   ├── pegawai/                # Halaman manajemen pegawai
│       │   ├── peta/                   # Halaman peta kejahatan
│       │   ├── beranda.blade.php       # Dashboard admin
│       │   ├── chat-widget.blade.php   # Chat real-time widget
│       │   └── layout.blade.php        # Layout admin (sidebar, navbar)
│       ├── components/
│       │   └── chatbot-widget.blade.php # MinGAP floating chatbot widget
│       ├── laporan/
│       │   ├── buat.blade.php          # Form lapor infrastruktur
│       │   └── lacak.blade.php         # Form lacak & detail laporan
│       ├── leaderboard/                # Halaman leaderboard publik
│       ├── otentikasi/                 # Login & register pages
│       └── welcome.blade.php          # Landing page utama
├── routes/
│   ├── web.php                         # Semua route (publik + admin)
│   └── channels.php                    # Broadcast channel authorization
├── public/
│   └── images/                         # Asset gambar (hero, ikon, logo)
├── composer.json                       # PHP dependencies
├── package.json                        # Node.js dependencies
└── vite.config.js                      # Vite + Tailwind + Laravel plugin
```

---

## 📝 Conclusion

**SIGAP BDG** adalah sistem informasi pelaporan publik berbasis web yang dirancang untuk mempermudah warga Kota Bandung dalam melaporkan kerusakan infrastruktur dan kerawanan kejahatan secara digital. Sistem ini mengedepankan tiga pilar utama:

1. **Aksesibilitas** — Warga dapat melapor tanpa perlu membuat akun. Cukup unggah foto, lokasi terdeteksi otomatis, dan langsung mendapatkan Tracking ID untuk memantau progres laporan.

2. **Kecerdasan Buatan (AI)** — Tiga layer AI terintegrasi dalam sistem:
   - *GPT-4o Vision* untuk deteksi spam otomatis dan analisis kerusakan dari foto.
   - *MinGAP Chatbot* sebagai asisten publik yang mampu melacak status laporan langsung dari percakapan.
   - *AI Decision Assistant* yang membantu admin mengaudit kewajaran anggaran dan menentukan prioritas perbaikan.

3. **Transparansi & Real-time** — Setiap perubahan status laporan tercatat dalam timeline yang dapat diakses publik. Notifikasi real-time via WebSocket memastikan admin langsung mengetahui laporan masuk. Leaderboard kecamatan mendorong kompetisi sehat antar daerah dalam merespons laporan warga.

Dibangun dengan stack modern (**Laravel 13, Tailwind CSS 4, Alpine.js 3, Laravel Reverb, OpenAI GPT-4o**), SIGAP BDG menunjukkan bagaimana teknologi web dan kecerdasan buatan dapat bersinergi untuk meningkatkan kualitas pelayanan publik di tingkat kota.

---

<p align="center">
  <strong>© 2026 SIGAP BDG — Pemerintah Kota Bandung</strong><br>
  <em>Lapor Cepat & Tanggap 🚀</em>
</p>
