<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 180)->unique();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('technologies')->nullable();
            $table->text('case_study')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('published')->index();
            $table->timestamps();
        });

        Schema::create('industry_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->unique(['industry_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industry_service');
        Schema::dropIfExists('industries');
    }
};
