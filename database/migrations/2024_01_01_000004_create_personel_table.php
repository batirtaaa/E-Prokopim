<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nip', 30)->nullable();
            $table->string('jabatan');
            $table->enum('bidang', ['protokol', 'mc', 'fotografer', 'videografer', 'notulis', 'dokumentasi', 'lainnya'])->default('protokol');
            $table->string('phone', 20)->nullable();
            $table->string('photo')->nullable();
            $table->enum('status_ketersediaan', ['standby', 'bertugas', 'cuti', 'tidak_aktif'])->default('standby');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personel');
    }
};
