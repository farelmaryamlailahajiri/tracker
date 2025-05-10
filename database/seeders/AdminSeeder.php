<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [

                'username' => 'admin1',
                'password' => Hash::make('admin1'),
                'nama_lengkap' => 'Farel Maryam Laila H.',
                'email' => 'admin1@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin2',
                'password' => Hash::make('admin2'),
                'nama_lengkap' => 'Dwi Septa Satria Agung',
                'email' => 'admin2@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('admin')->insert($data);
    }
}
