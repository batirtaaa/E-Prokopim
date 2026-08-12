<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan')->onDelete('set null');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['foto', 'video', 'dokumen'])->default('foto');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('thumbnail')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->date('tanggal_dokumentasi');
            $table->string('fotografer')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi');
    }
};
