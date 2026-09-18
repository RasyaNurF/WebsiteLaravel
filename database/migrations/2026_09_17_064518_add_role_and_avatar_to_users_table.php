<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('admin')->after('email');
            $table->string('job_title', 100)->nullable()->after('role');
            $table->string('avatar_path')->nullable()->after('job_title');
            $table->boolean('is_active')->default(true)->after('avatar_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'job_title', 'avatar_path', 'is_active']);
        });
    }
};
