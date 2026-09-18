<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->index();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('cover_image_path', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->string('external_url', 255)->nullable();
            $table->string('location', 180)->nullable();
            $table->string('organizer', 150)->nullable();
            $table->string('cta_label', 100)->nullable();
            $table->string('cta_url', 255)->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
