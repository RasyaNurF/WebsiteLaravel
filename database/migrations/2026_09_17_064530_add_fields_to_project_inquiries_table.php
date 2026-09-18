<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_inquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('project_inquiries', 'phone')) {
                $table->string('phone', 30)->nullable()->after('company');
            }

            if (! Schema::hasColumn('project_inquiries', 'status')) {
                $table->string('status', 20)->default('baru')->after('project_detail')->index();
            }

            if (! Schema::hasColumn('project_inquiries', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }

            if (! Schema::hasColumn('project_inquiries', 'handled_by')) {
                $table->foreignId('handled_by')->nullable()->after('admin_note')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('project_inquiries', 'handled_at')) {
                $table->timestamp('handled_at')->nullable()->after('handled_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('project_inquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('handled_by');
            $table->dropColumn(['phone', 'status', 'admin_note', 'handled_at']);
        });
    }
};
