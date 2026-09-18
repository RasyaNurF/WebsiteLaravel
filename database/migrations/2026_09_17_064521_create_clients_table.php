<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('slug', 180)->unique();
            $table->string('industry', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('status', 20)->default('active')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
