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
        if (!Schema::hasTable('notifikasi')) {
            Schema::create('notifikasi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('judul');
                $table->text('pesan');
                $table->string('tipe')->default('info');
                $table->string('link')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
                $table->index(['user_id', 'is_read']);
                $table->index('created_at');
            });
        } else {
            // Table exists — ensure all columns are present
            Schema::table('notifikasi', function (Blueprint $table) {
                if (!Schema::hasColumn('notifikasi', 'user_id')) {
                    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('notifikasi', 'judul')) {
                    $table->string('judul');
                }
                if (!Schema::hasColumn('notifikasi', 'pesan')) {
                    $table->text('pesan');
                }
                if (!Schema::hasColumn('notifikasi', 'tipe')) {
                    $table->string('tipe')->default('info');
                }
                if (!Schema::hasColumn('notifikasi', 'link')) {
                    $table->string('link')->nullable();
                }
                if (!Schema::hasColumn('notifikasi', 'is_read')) {
                    $table->boolean('is_read')->default(false);
                }
                if (!Schema::hasColumn('notifikasi', 'read_at')) {
                    $table->timestamp('read_at')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
