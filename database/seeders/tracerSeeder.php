<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tracerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'alumni_id' => 1,
                'profesi_id' => 1,
                'instansi_id' => 1,
                'tanggal_pertama_kerja' => '2025-11-12',
                'tanggal_mulai_kerja_saat_ini' => '2025-11-12',
                'lokasi_kerja' => 'Jakarta',
                'waktu_tunggu' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'alumni_id' => 2,
                'profesi_id' => 2,
                'instansi_id' => 2,
                'tanggal_pertama_kerja' => '2025-12-05',
                'tanggal_mulai_kerja_saat_ini' => '2025-07-05',
                'lokasi_kerja' => 'Bekasi',
                'waktu_tunggu' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('tracer')->insert($data);
    }
}
