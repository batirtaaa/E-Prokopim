<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asisten_ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->enum('role', ['user', 'assistant'])->default('assistant');
            $table->text('content');
            $table->json('structured_data')->nullable(); // For schedule cards, speech drafts, summary cards
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asisten_ai_messages');
    }
};
