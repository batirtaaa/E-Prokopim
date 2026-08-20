<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sambutan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('asal_instansi');
            $table->string('perihal');
            $table->text('deskripsi_singkat')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->date('tenggat_waktu')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->enum('status_urgensi', ['biasa', 'segera', 'penting'])->default('biasa');
            $table->text('instruksi_disposisi')->nullable();
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->enum('jenis', ['permohonan', 'hasil'])->default('permohonan');
            $table->enum('status', ['draft', 'diproses', 'selesai'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sambutan');
    }
};
