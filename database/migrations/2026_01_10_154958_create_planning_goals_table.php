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
        Schema::create('planning_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_document_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('level', ['visi', 'misi', 'tujuan', 'sasaran']);
            $table->foreignId('parent_id')->nullable()
                ->constrained('planning_goals')
                ->nullOnDelete();

            $table->string('kode');
            $table->text('uraian');

            $table->timestamps();

            $table->index(['planning_document_id', 'level']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_goals');
    }
};
