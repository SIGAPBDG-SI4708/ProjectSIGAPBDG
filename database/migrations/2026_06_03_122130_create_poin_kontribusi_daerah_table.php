<?php

// =========================================================
// SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
// =========================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('poin_kontribusi_daerah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daerah')->constrained('daerah')->onDelete('cascade');
            $table->foreignId('laporan_infrastruktur_id')->nullable()->constrained('laporan_infrastruktur')->onDelete('cascade');
            $table->integer('poin');
            $table->string('kategori');
            $table->string('deskripsi');
            $table->timestamps();
        });

        $laporans = \DB::table('laporan_infrastruktur')->get();
        foreach ($laporans as $laporan) {
            \DB::table('poin_kontribusi_daerah')->insert([
                'id_daerah' => $laporan->id_daerah,
                'laporan_infrastruktur_id' => $laporan->id,
                'poin' => 10,
                'kategori' => 'Laporan Baru',
                'deskripsi' => 'Apresiasi partisipasi warga melaporkan infrastruktur rusak dengan ID: ' . $laporan->tracking_id,
                'created_at' => $laporan->created_at,
                'updated_at' => $laporan->created_at,
            ]);

            if (in_array($laporan->status, ['Proses', 'Selesai'])) {
                $waktuProses = \Carbon\Carbon::parse($laporan->created_at)->addMinutes(15);
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => 20,
                    'kategori' => 'Respon Cepat',
                    'deskripsi' => 'Respon cepat pembaruan status laporan menjadi Proses oleh Admin Daerah.',
                    'created_at' => $waktuProses,
                    'updated_at' => $waktuProses,
                ]);
            }

            if ($laporan->status === 'Selesai') {
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => 50,
                    'kategori' => 'Penyelesaian',
                    'deskripsi' => 'Penyelesaian perbaikan infrastruktur secara fisik di lapangan.',
                    'created_at' => $laporan->updated_at,
                    'updated_at' => $laporan->updated_at,
                ]);
            }
        }

        $ulasans = \DB::table('ulasan_laporan')->get();
        foreach ($ulasans as $ulasan) {
            $laporan = \DB::table('laporan_infrastruktur')->find($ulasan->laporan_infrastruktur_id);
            if ($laporan) {
                $poinUlasan = $ulasan->rating * 10;
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => $poinUlasan,
                    'kategori' => 'Ulasan Warga',
                    'deskripsi' => 'Apresiasi ulasan warga dengan rating ' . $ulasan->rating . ' bintang.',
                    'created_at' => $ulasan->created_at,
                    'updated_at' => $ulasan->created_at,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('poin_kontribusi_daerah');
    }
};


