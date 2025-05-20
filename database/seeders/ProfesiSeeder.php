<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_profesi' => 'Developer/Programmer/Software Engineer',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Support/IT Administrator',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Infrastructure Enggineer',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Digital Marketing Specialist',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Graphic Designer/Multimedia Designer',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Business Analyst',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'QA Engineer/Tester',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'QA Engineer/Tester',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Enterpreneur',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer/Guru/Dosen (IT)',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Lainnya: ...',
                'kategori' => 'Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Procurement & Operational Team',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Wirausahawan (Non-IT)',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer/Guru/Dosen (Non-IT)',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Mahasiswa',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Lainnya: ...',
                'kategori' => 'Non-Infokom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => '-Tidak Bekerja-',
                'kategori' => 'Tidak Bekerja',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('profesi')->insert($data);
    }
}
