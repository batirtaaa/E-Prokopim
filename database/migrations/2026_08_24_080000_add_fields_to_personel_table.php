<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            if (!Schema::hasColumn('personel', 'email')) {
                $table->string('email')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('personel', 'status_kepegawaian')) {
                $table->string('status_kepegawaian')->default('PNS')->after('jabatan'); // PNS, PPPK Penuh Waktu, PPPK Paruh Waktu, Outsourcing
            }
        });
    }

    public function down(): void
    {
        Schema::table('personel', function (Blueprint $table) {
            if (Schema::hasColumn('personel', 'status_kepegawaian')) {
                $table->dropColumn('status_kepegawaian');
            }
            if (Schema::hasColumn('personel', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
