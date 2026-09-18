<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();
            $table->string('path', 200)->unique();
            $table->string('label', 100);
            $table->string('title', 200)->nullable();
            $table->string('description', 300)->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('is_indexable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_meta');
    }
};
