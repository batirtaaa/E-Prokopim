<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daftar_hadir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->foreignId('personel_id')->nullable()->constrained('personel')->onDelete('set null');
            $table->string('nama_peserta');
            $table->string('jabatan')->nullable();
            $table->string('instansi')->nullable();
            $table->enum('status_hadir', ['hadir', 'tidak_hadir', 'izin'])->default('hadir');
            $table->time('jam_hadir')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_hadir');
    }
};
