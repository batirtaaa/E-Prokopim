<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mengubah kolom tipe di tabel notifikasi dari ENUM terbatas
     * ('info','warning','success','error') menjadi string biasa,
     * agar dapat menerima semua nilai tipe notifikasi aplikasi:
     * 'kegiatan', 'penugasan', 'arahan', 'info', dll.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `notifikasi` MODIFY COLUMN `tipe` VARCHAR(50) NOT NULL DEFAULT 'info'");
        } else {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->string('tipe', 50)->default('info')->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE `notifikasi` SET `tipe` = 'info' WHERE `tipe` NOT IN ('info','warning','success','error')");
            DB::statement("ALTER TABLE `notifikasi` MODIFY COLUMN `tipe` ENUM('info','warning','success','error') NOT NULL DEFAULT 'info'");
        }
    }
};

