<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as str;


class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Julia Aryani',
                'nim' => '2147436713',
                'program_studi_id' => 1,
                'tanggal_lulus' => '2025-07-15',
                'token' => str::random(6),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Edi Simbolon',
                'nim' => '2147436714',
                'program_studi_id' => 2,
                'tanggal_lulus' => '2025-07-15',
                'token' => str::random(6),
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('alumni')->insert($data);
    }
}
