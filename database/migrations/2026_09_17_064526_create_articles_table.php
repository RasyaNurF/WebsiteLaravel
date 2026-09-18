<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('featured_image_path')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('tags')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('seo_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
