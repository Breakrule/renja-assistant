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
        Schema::create('planning_documents', function (Blueprint $table) {
    $table->id();
    $table->enum('jenis', ['RPJPD', 'RPJMD', 'RKPD']);
    $table->year('tahun_awal');
    $table->year('tahun_akhir')->nullable(); // RKPD tahunan
    $table->string('nama_dokumen');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_documents');
    }
};
