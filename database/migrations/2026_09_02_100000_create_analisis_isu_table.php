<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis_isu', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->string('jenis_media'); // Sosial, Online, Cetak
            $table->string('sumber_isu');
            $table->longText('analisis');
            $table->longText('rekomendasi_kebijakan');
            $table->longText('rekomendasi_publikasi');
            $table->string('leading_sector');
            $table->enum('sentimen', ['Positif', 'Negatif', 'Netral'])->default('Netral');
            $table->string('link_sumber')->nullable();
            $table->string('file_lampiran')->nullable();
            $table->string('file_name')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_isu');
    }
};
