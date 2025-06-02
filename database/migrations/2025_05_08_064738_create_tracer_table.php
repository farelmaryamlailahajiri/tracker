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
            $table->foreignId('alumni_id')->constrained('alumni'); // Mengarah ke tabel alumni
            $table->foreignId('profesi_id')->constrained('profesi'); // Mengarah ke tabel profesi
            $table->foreignId('instansi_id')->constrained('instansi'); // Mengarah ke tabel instansi
            $table->string('email');
            $table->string('no_hp');
            $table->integer('tahun_lulus')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->date('tanggal_pertama_kerja')->nullable();
            $table->date('tanggal_mulai_kerja_saat_ini')->nullable();
            $table->integer('waktu_tunggu')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->string('kategori_profesi')->nullable();
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
