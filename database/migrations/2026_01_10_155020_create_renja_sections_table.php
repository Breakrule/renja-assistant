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
        Schema::create('renja_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renja_id')->constrained()->cascadeOnDelete();
            $table->string('kode_bab'); // I, II, III
            $table->string('judul');
            $table->integer('urutan');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renja_sections');
    }
};
