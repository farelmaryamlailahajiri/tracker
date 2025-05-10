<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class instansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_instansi' => 'Universitas Negeri Jakarta',
                'jenis_instansi' => 'Pendidikan Tinggi',
                'skala' => 'Nasional',
                'lokasi' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_instansi' => 'Kementerian Pendidikan dan Kebudayaan',
                'jenis_instansi' => 'Pemerintahan',
                'skala' => 'Nasional',
                'lokasi' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('instansi')->insert($data);
    }
}
