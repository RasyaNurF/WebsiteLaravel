<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('slug', 200)->unique();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('technologies')->nullable();
            $table->date('started_at')->nullable();
            $table->date('finished_at')->nullable();
            $table->string('status', 20)->default('planning')->index();
            $table->string('image_path')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
