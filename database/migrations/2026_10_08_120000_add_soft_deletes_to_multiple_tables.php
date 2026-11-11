<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'galeri_arsip',
            'media_sosial',
            'keuangan',
            'surat_keluar',
            'aset_barang',
            'aset_kendaraan',
            'personel',
            'penugasan',
            'laporan',
            'daftar_hadir',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->softDeletes();
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'galeri_arsip',
            'media_sosial',
            'keuangan',
            'surat_keluar',
            'aset_barang',
            'aset_kendaraan',
            'personel',
            'penugasan',
            'laporan',
            'daftar_hadir',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'deleted_at')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }
        }
    }
};
