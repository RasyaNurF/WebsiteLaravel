<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained()->cascadeOnDelete();
            $table->string('name', 120);
            $table->string('email', 255);
            $table->string('phone', 50)->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('status', 20)->default('new')->index();
            $table->timestamps();

            $table->index(['career_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
