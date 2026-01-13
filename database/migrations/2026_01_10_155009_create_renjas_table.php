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
        Schema::create('renjas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('opd_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('tahun'); // ❗ BUKAN year()
            $table->unsignedInteger('versi')->default(1);
            $table->string('status')->default('draft');
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['opd_id', 'tahun', 'versi']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renjas');
    }
};
