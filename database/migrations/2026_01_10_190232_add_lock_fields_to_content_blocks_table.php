<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            if (!Schema::hasColumn('content_blocks', 'manual_locked')) {
                $table->boolean('manual_locked')->default(false)->after('content');
            }
            if (!Schema::hasColumn('content_blocks', 'source')) {
                $table->string('source')->default('generated')->after('content');
            }
            if (!Schema::hasColumn('content_blocks', 'last_generated_at')) {
                $table->timestamp('last_generated_at')->nullable()->after('source');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            //
        });
    }
};
