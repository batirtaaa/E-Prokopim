<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            // Modify existing columns to be nullable for flexibility
            $table->string('no_bukti')->nullable()->change();
            $table->date('tanggal')->nullable()->change();
            $table->string('uraian')->nullable()->change();
            $table->string('kategori')->nullable()->change();
            $table->decimal('nominal', 15, 2)->nullable()->default(0)->change();
            $table->string('jenis')->nullable()->change();
            $table->string('status')->nullable()->change();

            // Add Surat Masuk specific columns
            if (!Schema::hasColumn('keuangan', 'tanggal_diterima')) {
                $table->date('tanggal_diterima')->nullable()->after('id');
            }
            if (!Schema::hasColumn('keuangan', 'nomor_surat')) {
                $table->string('nomor_surat')->nullable()->after('tanggal_diterima');
            }
            if (!Schema::hasColumn('keuangan', 'pengirim')) {
                $table->string('pengirim')->nullable()->after('nomor_surat');
            }
            if (!Schema::hasColumn('keuangan', 'perihal')) {
                $table->text('perihal')->nullable()->after('pengirim');
            }
            if (!Schema::hasColumn('keuangan', 'disposisi')) {
                $table->string('disposisi')->nullable()->after('perihal');
            }
            if (!Schema::hasColumn('keuangan', 'file_dokumen')) {
                $table->string('file_dokumen')->nullable()->after('disposisi');
            }
            if (!Schema::hasColumn('keuangan', 'link_dokumen')) {
                $table->text('link_dokumen')->nullable()->after('file_dokumen');
            }
            if (!Schema::hasColumn('keuangan', 'is_printed')) {
                $table->boolean('is_printed')->default(false)->after('link_dokumen');
            }
            if (!Schema::hasColumn('keuangan', 'printed_at')) {
                $table->timestamp('printed_at')->nullable()->after('is_printed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_diterima',
                'nomor_surat',
                'pengirim',
                'perihal',
                'disposisi',
                'file_dokumen',
                'link_dokumen',
                'is_printed',
                'printed_at',
            ]);
        });
    }
};
