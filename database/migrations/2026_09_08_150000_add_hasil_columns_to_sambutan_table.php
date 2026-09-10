<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->string('file_hasil_path')->nullable()->after('file_name');
            $table->string('file_hasil_name')->nullable()->after('file_hasil_path');
            $table->dateTime('tgl_upload_hasil')->nullable()->after('file_hasil_name');
            $table->text('catatan_hasil')->nullable()->after('tgl_upload_hasil');
        });
    }

    public function down(): void
    {
        Schema::table('sambutan', function (Blueprint $table) {
            $table->dropColumn([
                'file_hasil_path',
                'file_hasil_name',
                'tgl_upload_hasil',
                'catatan_hasil',
            ]);
        });
    }
};
