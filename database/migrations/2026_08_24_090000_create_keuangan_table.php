<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('no_bukti')->unique(); // e.g. TRX-2023-001 / BKT-2023-015
            $table->date('tanggal');
            $table->string('uraian');              // e.g. Konsumsi Jamuan Rapat Koordinasi Pimpinan
            $table->string('kategori');            // Operasional, Perjalanan Dinas, Honorarium, Jamuan Tamu, Pemeliharaan, Publikasi
            $table->enum('jenis', ['pengeluaran', 'pemasukan', 'realisasi'])->default('pengeluaran');
            $table->decimal('nominal', 15, 2);    // e.g. 15000000.00
            $table->string('penanggung_jawab')->nullable(); // e.g. Budi Santoso / Siti Rahmawati
            $table->enum('status', ['selesai', 'pending', 'proses', 'draft'])->default('selesai');
            $table->string('file_bukti')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
