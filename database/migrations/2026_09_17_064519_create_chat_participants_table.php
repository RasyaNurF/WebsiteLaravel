<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_participants', function (Blueprint $table) {
            $table->id();
            $table->string('guest_token', 64)->unique();
            $table->string('name', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('subject', 150)->nullable();
            $table->string('status', 20)->default('unread')->index();
            $table->timestamp('last_message_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_participants');
    }
};
