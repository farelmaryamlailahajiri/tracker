<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class penggunaLulusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Dr. Andi Rahman',
                'jabatan' => 'Kepala Departemen',
                'email' => 'AndiRahman@gmail.com',
                'telepon' => '081210001001',
                'instansi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Marlina',
                'jabatan' => 'Kepala Departemen',
                'email' => 'sitimarlina@gmail.com',
                'telepon' => '081210001002',
                'instansi_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('pengguna_lulusan')->insert($data);
    }
}
