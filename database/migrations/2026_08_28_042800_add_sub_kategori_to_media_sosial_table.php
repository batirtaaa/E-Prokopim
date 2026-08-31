<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_sosial', function (Blueprint $table) {
            // sub_kategori hanya relevan untuk kategori = 'infografis'
            // contoh nilai: 'hari_besar', 'obituary', 'kamis_nyunda', 'giat_pimpinan', atau teks bebas untuk 'Lainnya'
            $table->string('sub_kategori')->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('media_sosial', function (Blueprint $table) {
            $table->dropColumn('sub_kategori');
        });
    }
};
