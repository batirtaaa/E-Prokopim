<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->string('waktu_acara')->nullable()->after('tanggal_acara');
        });
    }

    public function down(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->dropColumn('waktu_acara');
        });
    }
};
