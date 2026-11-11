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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_surat');              // Manual date, bisa mundur
            $table->string('nomor_surat', 255);         // Nomor manual (tidak auto-generate)
            $table->string('tujuan', 255);              // Instansi tujuan surat
            $table->text('perihal');                    // Perihal surat
            $table->text('keterangan')->nullable();     // Catatan/keterangan tambahan
            $table->string('file_dokumen')->nullable(); // Path file upload
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
