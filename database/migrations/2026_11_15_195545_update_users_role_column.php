<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe kolom role menjadi string(30) dengan default 'user'
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(30) NOT NULL DEFAULT 'user'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 30)->default('user')->change();
            });
        }

        // Normalisasi data: semua selain super_admin diubah menjadi 'user'
        DB::table('users')
            ->where('role', '!=', 'super_admin')
            ->update(['role' => 'user']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'operator', 'personel') NOT NULL DEFAULT 'operator'");
        }
    }
};
