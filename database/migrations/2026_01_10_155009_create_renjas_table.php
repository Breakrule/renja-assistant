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
            $table->foreignId('opd_id')->constrained();
            $table->year('tahun');
            $table->integer('versi')->default(1);

            $table->enum('status', ['draft', 'review', 'final'])
                ->default('draft');

            $table->foreignId('created_by'); // user_id
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
