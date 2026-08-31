<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->date('tanggal_acara')->nullable()->after('tanggal_surat');
            $table->string('tujuan')->nullable()->after('asal_instansi');
            $table->dateTime('deadline_at')->nullable()->after('tenggat_waktu');
        });
    }

    public function down(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->dropColumn(['tanggal_acara', 'tujuan', 'deadline_at']);
        });
    }
};
