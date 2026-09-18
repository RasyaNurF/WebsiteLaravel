<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->text('challenge')->nullable()->after('description');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('result')->nullable()->after('solution');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['challenge', 'solution', 'result']);
        });
    }
};
