<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nim' => '2147436713',
                'nama' => 'Julia Aryani',
                'program_studi_id' => 1,  // Sesuaikan dengan program studi yang valid
                'tanggal_lulus' => '2025-07-15',
                'token' => 'Ux9BF5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nim' => '2147436714',
                'nama' => 'Edi Simbolon',
                'program_studi_id' => 2,
                'tanggal_lulus' => '2025-07-15',
                'token' => '4ejzwB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data alumni lainnya
        ];

        foreach ($data as $alumni) {
            // Cek apakah NIM sudah ada di tabel alumni
            $existingAlumni = DB::table('alumni')->where('nim', $alumni['nim'])->first();
            if ($existingAlumni) {
                echo "ℹ️ Alumni dengan NIM {$alumni['nim']} sudah ada. Lewati.\n";
                continue;
            }

            // Insert data alumni
            DB::table('alumni')->insert($alumni);
            echo "✅ Berhasil impor alumni dengan NIM {$alumni['nim']}.\n";
        }
    }
}
