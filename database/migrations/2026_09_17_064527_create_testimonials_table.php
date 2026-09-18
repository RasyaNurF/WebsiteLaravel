<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('position', 120)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('photo_path')->nullable();
            $table->text('quote');
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
