<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
