<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('pemerintah_daerah');
            $table->text('alamat_lengkap')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
