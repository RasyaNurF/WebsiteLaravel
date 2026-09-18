<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('chat_messages', 'chat_participant_id')) {
                $table->foreignId('chat_participant_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('chat_messages', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('is_auto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('chat_participant_id');
            $table->dropColumn('is_read');
        });
    }
};
