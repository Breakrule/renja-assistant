<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('renjas', function (Blueprint $table) {
            $table->index('status');
            $table->index('tahun');
            $table->index(['opd_id', 'tahun']);
        });

        Schema::table('renja_subsections', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('content_blocks', function (Blueprint $table) {
            $table->index('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renjas', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tahun']);
            $table->dropIndex(['opd_id', 'tahun']);
        });

        Schema::table('renja_subsections', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropIndex(['source']);
        });
    }
};
