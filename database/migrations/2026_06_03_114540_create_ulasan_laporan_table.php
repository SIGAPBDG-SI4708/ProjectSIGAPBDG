<?php

// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================

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
        Schema::create('ulasan_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_infrastruktur_id')->constrained('laporan_infrastruktur')->onDelete('cascade');
            $table->integer('rating');
            $table->text('ulasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan_laporan');
    }
};

// =========================================================
