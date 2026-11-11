<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeri_arsip', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('keterangan');
            $table->string('file_paparan_path')->nullable()->after('file_name');
            $table->string('file_paparan_name')->nullable()->after('file_paparan_path');
        });

        // Juga tambahkan kolom keywords dan file_paparan di tabel notulensi (jika tabel ada)
        if (Schema::hasTable('notulensi')) {
            Schema::table('notulensi', function (Blueprint $table) {
                if (!Schema::hasColumn('notulensi', 'keywords')) {
                    $table->text('keywords')->nullable()->after('kesimpulan');
                }
                if (!Schema::hasColumn('notulensi', 'file_paparan')) {
                    $table->string('file_paparan')->nullable()->after('file_notulensi');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('galeri_arsip', function (Blueprint $table) {
            $table->dropColumn(['keywords', 'file_paparan_path', 'file_paparan_name']);
        });

        if (Schema::hasTable('notulensi')) {
            Schema::table('notulensi', function (Blueprint $table) {
                $table->dropColumn(['keywords', 'file_paparan']);
            });
        }
    }
};
