<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_sosial', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('kategori', ['infografis', 'videografis', 'media_luar_ruang'])->default('infografis');
            $table->string('platform')->default('instagram'); // instagram, facebook, website, tiktok, youtube, billboard, videotron, dll
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->enum('status', ['dipublikasi', 'draft', 'dijadwalkan'])->default('dipublikasi');
            $table->string('link_post')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_sosial');
    }
};
