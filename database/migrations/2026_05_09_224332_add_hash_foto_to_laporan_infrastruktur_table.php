<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_infrastruktur', function (Blueprint $table) {
            $table->string('hash_foto')->nullable()->index()->after('foto_awal');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_infrastruktur', function (Blueprint $table) {
            $table->dropIndex(['hash_foto']);
            $table->dropColumn('hash_foto');
        });
    }
};
