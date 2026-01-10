<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('renja_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renja_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('renja_subsection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', ['kosong', 'draft', 'reviewed', 'final']);
            $table->timestamps();

            $table->unique(['renja_id', 'renja_subsection_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renja_progress');
    }
};
