<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solution_category_id')->constrained()->cascadeOnDelete();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('subtitle', 255)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->string('cover_image_path', 255)->nullable();
            $table->string('partner_name', 150)->nullable();
            $table->string('cta_label', 100)->nullable();
            $table->string('cta_url', 255)->nullable();
            $table->json('features')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solutions');
    }
};
