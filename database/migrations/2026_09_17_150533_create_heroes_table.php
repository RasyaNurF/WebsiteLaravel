<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('highlight', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('cta_label', 100)->nullable();
            $table->string('cta_url', 255)->nullable();
            $table->string('secondary_cta_label', 100)->nullable();
            $table->string('secondary_cta_url', 255)->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('status', 20)->default('draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
