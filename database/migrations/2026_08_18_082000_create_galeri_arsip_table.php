<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri_arsip', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // #KG-231005
            $table->string('judul');
            $table->enum('tipe', ['foto', 'video', 'notulensi'])->default('foto');
            $table->string('akses', 20)->default('publik'); // publik, internal
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('durasi_detik')->nullable(); // for video
            $table->integer('jumlah_foto')->default(1); // album count
            $table->text('keterangan')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_arsip');
    }
};
