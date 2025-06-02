<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaLulusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'alumni_id' => 1, // Pastikan ID alumni ini sesuai dengan yang ada di tabel alumni
                'nama' => 'Budi Santoso',
                'jabatan' => 'Kepala Departemen',
                'email' => 'budi.santoso@gmail.com',
                'telepon' => '081234567003',
                'instansi_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('pengguna_lulusan')->insert($data);
    }
}
