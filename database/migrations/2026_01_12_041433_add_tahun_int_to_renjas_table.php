<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('renjas', function (Blueprint $table) {
            $table->unsignedSmallInteger('tahun_int')
                ->nullable()
                ->after('tahun');
        });

        // Migrasi data: YEAR(21) → 2021
        DB::statement("
            UPDATE renjas
            SET tahun_int = IF(tahun < 100, tahun + 2000, tahun)
        ");
    }

    public function down(): void
    {
        Schema::table('renjas', function (Blueprint $table) {
            $table->dropColumn('tahun_int');
        });
    }
};
