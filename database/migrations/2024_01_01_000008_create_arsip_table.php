<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_arsip')->nullable();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['surat_masuk', 'surat_keluar', 'sk', 'peraturan', 'laporan', 'foto', 'video', 'lainnya'])->default('lainnya');
            $table->string('file_path');
            $table->string('file_name');
            $table->bigInteger('file_size')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('tahun')->nullable();
            $table->enum('status', ['aktif', 'inaktif', 'arsip_permanen'])->default('aktif');
            $table->boolean('is_rahasia')->default(false);
            $table->integer('views')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users');
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
