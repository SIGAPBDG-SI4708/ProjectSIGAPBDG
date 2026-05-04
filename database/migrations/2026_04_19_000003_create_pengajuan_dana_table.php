<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_dana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan')->constrained('laporan_infrastruktur');
            $table->foreignId('id_user')->constrained('users');
            $table->decimal('nominal_diajukan', 15, 2);
            $table->string('status_approval')->default('Menunggu');
            $table->timestamp('waktu_pengajuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_dana');
    }
};
