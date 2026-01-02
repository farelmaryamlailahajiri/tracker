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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable();
            }
        });
        Schema::table('profesi', function (Blueprint $table) {
            if (!Schema::hasColumn('profesi', 'nama')) {
                $table->string('nama')->nullable();
            }
            if (!Schema::hasColumn('profesi', 'kategori')) {
                $table->string('kategori')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
        Schema::table('profesi', function (Blueprint $table) {
            if (Schema::hasColumn('profesi', 'nama')) {
                $table->dropColumn('nama');
            }
            if (Schema::hasColumn('profesi', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }
};
