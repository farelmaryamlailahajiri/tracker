<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class profesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_profesi' => 'Dosen',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Pegawai Negeri Sipil',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('profesi')->insert($data);
    }
}
