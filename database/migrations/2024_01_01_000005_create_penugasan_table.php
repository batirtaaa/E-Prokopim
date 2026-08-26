<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->foreignId('personel_id')->constrained('personel')->onDelete('cascade');
            $table->string('peran'); // Protokol, Fotografer, MC, dll
            $table->enum('status', ['ditugaskan', 'dikonfirmasi', 'berlangsung', 'selesai', 'tidak_hadir'])->default('ditugaskan');
            $table->text('catatan')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('penugasan_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->constrained('penugasan')->onDelete('cascade');
            $table->string('aksi');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_log');
        Schema::dropIfExists('penugasan');
    }
};
