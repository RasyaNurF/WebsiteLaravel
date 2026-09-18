<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('technologies')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->json('gallery')->nullable();
            $table->string('url')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status', 20)->default('draft')->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
