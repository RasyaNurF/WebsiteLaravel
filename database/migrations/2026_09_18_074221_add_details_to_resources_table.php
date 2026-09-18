<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('industry', 120)->nullable()->after('organizer');
            $table->string('register_url', 255)->nullable()->after('external_url');
            $table->string('recording_url', 255)->nullable()->after('register_url');
            $table->unsignedInteger('page_count')->nullable()->after('recording_url');
            $table->json('agenda')->nullable()->after('page_count');
            $table->json('speakers')->nullable()->after('agenda');
            $table->json('gallery')->nullable()->after('speakers');
            $table->json('metrics')->nullable()->after('gallery');
            $table->json('toc')->nullable()->after('metrics');
            $table->json('chapters')->nullable()->after('toc');
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['industry', 'register_url', 'recording_url', 'page_count', 'agenda', 'speakers', 'gallery', 'metrics', 'toc', 'chapters']);
        });
    }
};
