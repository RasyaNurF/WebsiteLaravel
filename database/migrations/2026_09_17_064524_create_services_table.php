<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 180)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('technologies')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
