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
        Schema::table('arsip', function (Blueprint $table) {
            $table->string('kategori', 100)->default('lainnya')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->enum('kategori', ['surat_masuk', 'surat_keluar', 'sk', 'peraturan', 'laporan', 'foto', 'video', 'lainnya'])->default('lainnya')->change();
        });
    }
};
