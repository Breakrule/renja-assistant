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
        Schema::create('renja_subsections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renja_section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('kode_subbab'); // 1.1, 2.3
            $table->string('judul');
            $table->string('status')->default('draft');
            $table->enum('tipe', ['narrative', 'table', 'mixed']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renja_subsections');
    }
};
