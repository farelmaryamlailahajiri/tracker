<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaLulusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna_lulusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni');
            $table->foreignId('instansi_id')->constrained('instansi');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('link_form')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna_lulusan');
    }
}
