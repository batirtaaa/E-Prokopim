<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->enum('pimpinan', ['wali_kota', 'wakil_wali_kota', 'sekda', 'asisten'])->default('wali_kota');
            $table->enum('status', ['draft', 'terjadwal', 'berlangsung', 'selesai', 'dibatalkan'])->default('terjadwal');
            $table->enum('kategori', ['rapat', 'kunjungan', 'acara', 'audiensi', 'peresmian', 'lainnya'])->default('rapat');
            $table->string('foto_kegiatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
