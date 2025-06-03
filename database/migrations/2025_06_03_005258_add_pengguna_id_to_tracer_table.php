<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tracer', function (Blueprint $table) {
            $table->foreignId('pengguna_id')->nullable()->constrained('pengguna_lulusan');
        });
    }

    public function down()
    {
        Schema::table('tracer', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
        });
    }
};
