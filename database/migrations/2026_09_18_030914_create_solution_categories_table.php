<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solution_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 140)->unique();
            $table->string('tagline', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solution_categories');
    }
};
