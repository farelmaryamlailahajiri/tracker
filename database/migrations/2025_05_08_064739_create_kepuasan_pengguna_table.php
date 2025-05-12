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
        Schema::create('kepuasan_pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_id')->constrained('tracer');
            $table->foreignId('pengguna_id')->constrained('pengguna_lulusan');
            $table->string('kerjasama_tim');
            $table->string('keahlian_ti');
            $table->string('bahasa_asing');
            $table->string('komunikasi');
            $table->string('pengembangan_diri');
            $table->string('kepemimpinan');
            $table->string('etos_kerja');
            $table->string('kompetensi_yang_belum_dipenuhi');
            $table->string('saran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepuasan_pengguna');
    }
};
