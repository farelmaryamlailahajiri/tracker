<?php

namespace App\Imports;

use App\Models\KepuasanPengguna;
use App\Models\Tracer;
use App\Models\PenggunaLulusan;
use App\Models\Instansi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class KepuasanPenggunaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Cek pengguna_id berdasarkan nama alumni
            $pengguna = PenggunaLulusan::where('nama', trim($row['nama_alumni']))->first();
            if (!$pengguna) {
                echo "❌ Pengguna dengan nama '{$row['nama_alumni']}' tidak ditemukan. Lewati.\n";
                continue;
            }

            // Cek tracer_id berdasarkan alumni_id yang ditemukan
            $tracer = Tracer::where('alumni_id', $pengguna->alumni_id)->first();
            if (!$tracer) {
                echo "❌ Tracer untuk alumni '{$row['nama_alumni']}' tidak ditemukan. Lewati.\n";
                continue;
            }

            // Cek instansi berdasarkan nama instansi yang ada di file
            $instansi = Instansi::where('nama_instansi', trim($row['instansi']))->first();
            if (!$instansi) {
                echo "❌ Instansi '{$row['instansi']}' tidak ditemukan. Lewati NIM: {$row['nama_alumni']}.\n";
                continue;
            }

            // Insert data ke dalam tabel kepuasan_pengguna
            KepuasanPengguna::create([
                'tracer_id' => $tracer->id,  // Menghubungkan tracer_id
                'pengguna_id' => $pengguna->id,  // Menghubungkan pengguna_id
                'kerjasama_tim' => $row['kerjasama_tim'],
                'keahlian_ti' => $row['keahlian_di_bidang_ti'],
                'bahasa_asing' => $row['kemampuan_berbahasa_asing'],
                'komunikasi' => $row['kemampuan_berkomunikasi'],
                'pengembangan_diri' => $row['pengembangan_diri'],
                'kepemimpinan' => $row['kepemimpinan'],
                'etos_kerja' => $row['etos_kerja'],
                'kompetensi_yang_belum_dipenuhi' => $row['kompetensi_yang_dibutuhkan_tapi_belum_dapat_dipenuhi'],
                'saran' => $row['saran_untuk_kurikulum_program_studi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            echo "✅ Berhasil impor kepuasan pengguna untuk alumni '{$row['nama_alumni']}'.\n";
        }
    }
}
