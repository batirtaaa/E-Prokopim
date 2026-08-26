<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // laporan table
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['kegiatan', 'penugasan', 'arsip', 'dokumentasi', 'custom'])->default('kegiatan');
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->string('file_laporan')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // notifikasi table
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->text('pesan');
            $table->enum('tipe', ['info', 'warning', 'success', 'error'])->default('info');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // login_history table
        Schema::create('login_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('perangkat')->nullable();
            $table->enum('status', ['berhasil', 'gagal'])->default('berhasil');
            $table->timestamp('login_at');
            $table->timestamps();
        });

        // NOTE: cache, cache_locks, sessions are created by Laravel's default migrations
        // 0001_01_01_000001_create_cache_table and 0001_01_01_000000_create_users_table
    }

    public function down(): void
    {
        Schema::dropIfExists('login_history');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('laporan');
    }
};
