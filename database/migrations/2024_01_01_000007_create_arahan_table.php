<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arahan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_arahan')->nullable();
            $table->string('judul');
            $table->text('isi_arahan');
            $table->enum('pimpinan', ['wali_kota', 'wakil_wali_kota', 'sekda', 'asisten'])->default('wali_kota');
            $table->string('ditujukan_kepada')->nullable();
            $table->date('tanggal_arahan');
            $table->date('deadline')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'urgent'])->default('sedang');
            $table->enum('status', ['belum_selesai', 'sedang_berjalan', 'selesai', 'melewati_deadline'])->default('belum_selesai');
            $table->string('file_arahan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arahan');
    }
};
