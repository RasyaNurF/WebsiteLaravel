<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('department', 100)->nullable();
            $table->string('location', 120)->nullable();
            $table->string('employment_type', 50)->nullable();
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->string('salary_range', 120)->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
