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
        Schema::create('analisis_ai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan')->constrained('laporan_infrastruktur');
            $table->string('jenis_kerusakan')->nullable();
            $table->string('tingkat_keparahan')->nullable();
            $table->decimal('estimasi_biaya', 15, 2)->nullable();
            $table->boolean('is_spam')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_ai');
    }
};
