<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('tagline', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('about')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->json('values')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->unsignedSmallInteger('founded_year')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
