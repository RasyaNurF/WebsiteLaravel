<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 150)->unique();
            $table->string('position', 120)->nullable();
            $table->string('photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('github_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
