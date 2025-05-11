<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class prodiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
        $data = [
            [

                'nama' => 'D4 Teknik Informatika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'D4 Sistem Informasi Bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'D2 PPLS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'S2 MRTI',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('program_studi')->insert($data);
    }
    }
}
