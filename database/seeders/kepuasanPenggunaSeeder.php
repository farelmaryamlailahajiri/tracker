<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class kepuasanPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tracer_id' => 1,
                'pengguna_id' => 1,
                'kerjasama_tim' => 'Sangat Baik',
                'keahlian_ti' => 'Cukup',
                'bahasa_asing' => 'Baik',
                'komunikasi' => 'Cukup',
                'pengembangan_diri' => 'Baik',
                'kepemimpinan' => 'Sangat Baik',
                'etos_kerja' => 'Sangat Baik',
                'kompetensi_yang_belum_dipenuhi' => 'Keahlian di bidang TI',
                'saran' => 'Perbarui mata kuliah TI terkini',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tracer_id' => 2,
                'pengguna_id' => 2,
                'kerjasama_tim' => 'Baik',
                'keahlian_ti' => 'Sangat Baik',
                'bahasa_asing' => 'Cukup',
                'komunikasi' => 'Sangat Baik',
                'pengembangan_diri' => 'Cukup',
                'kepemimpinan' => 'Cukup',
                'etos_kerja' => 'Kurang',
                'kompetensi_yang_belum_dipenuhi' => 'Etos Kerja',
                'saran' => 'Integrasikan pelatihan praktis dengan sertifikasi TI',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ];
        DB::table('tracer')->insert($data);
    }
}
