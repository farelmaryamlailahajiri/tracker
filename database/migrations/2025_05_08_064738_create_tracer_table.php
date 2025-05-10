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
        Schema::create('tracer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni');
            $table->foreignId('profesi_id')->constrained('profesi');
            $table->foreignId('instansi_id')->constrained('instansi');
            $table->date('tanggal_pertama_kerja');
            $table->date('tanggal_mulai_kerja_saat_ini');
            $table->string('lokasi_kerja');
            $table->float('waktu_tunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer');
    }
};
