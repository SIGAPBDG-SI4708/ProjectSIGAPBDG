<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_infrastruktur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daerah')->constrained('daerah');
            $table->string('tracking_id')->unique();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto_awal');
            $table->string('status')->default('Menunggu');
            $table->string('foto_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_infrastruktur');
    }
};