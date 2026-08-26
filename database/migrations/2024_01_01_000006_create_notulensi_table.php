<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notulensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan')->onDelete('set null');
            $table->string('judul');
            $table->dateTime('tanggal_rapat');
            $table->string('tempat');
            $table->text('peserta')->nullable(); // JSON list of participants
            $table->text('agenda')->nullable();
            $table->text('isi_notulensi');
            $table->text('kesimpulan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('file_notulensi')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->foreignId('notulis_id')->nullable()->constrained('users');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notulensi');
    }
};
