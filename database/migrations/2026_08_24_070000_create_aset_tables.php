<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Aset Barang (Inventaris)
        Schema::create('aset_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique(); // e.g. INV-2023-001
            $table->string('nama_barang');        // e.g. Laptop Dell Latitude 5420
            $table->string('kategori');           // Elektronik, Furnitur, Peralatan Kantor, Kendaraan, dll
            $table->date('tanggal_perolehan')->nullable();
            $table->string('lokasi')->nullable(); // e.g. Ruang Rapat Utama
            $table->string('penanggung_jawab')->nullable(); // e.g. Budi Santoso
            $table->string('kondisi')->default('baik');     // baik, rusak_ringan, rusak_berat
            $table->string('status')->default('tersedia');  // tersedia, digunakan, dipinjam, dalam_perbaikan, dihapuskan
            $table->string('foto_barang')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // 2. Tabel Aset Kendaraan Operasional
        Schema::create('aset_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique(); // e.g. D 1234 ABC
            $table->string('nama_kendaraan');       // e.g. Toyota Innova Zenix
            $table->string('jenis');                // Minibus, Microbus, SUV, Sedan, Motor
            $table->string('pemegang_pengguna')->nullable(); // e.g. Kabag Protokol, Tim Dokumentasi
            $table->string('tahun', 10)->nullable();         // e.g. 2023
            $table->string('status')->default('tersedia');  // sedang_digunakan, tersedia, perbaikan
            $table->string('foto')->nullable();
            $table->string('dokumen')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_kendaraan');
        Schema::dropIfExists('aset_barang');
    }
};
