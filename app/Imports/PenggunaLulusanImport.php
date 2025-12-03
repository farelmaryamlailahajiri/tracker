<?php

namespace App\Imports;

use App\Models\PenggunaLulusan;
use App\Models\Alumni;
use App\Models\Instansi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenggunaLulusanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $nim = trim($row['nim']); // Ambil NIM dari file Excel
            $alumni = Alumni::where('nim', $nim)->first(); // Cari data alumni berdasarkan NIM

            // Cek apakah alumni ditemukan
            if (!$alumni) {
                echo "❌ Alumni dengan NIM {$nim} tidak ditemukan. Lewati.\n";
                continue;
            }

            // Cek instansi berdasarkan nama instansi yang ada di file
            $instansi = Instansi::where('nama_instansi', trim($row['nama_instansi']))->first();
            if (!$instansi) {
                echo "❌ Instansi '{$row['nama_instansi']}' tidak ditemukan. Lewati NIM: {$nim}.\n";
                continue;
            }

            // Insert data ke dalam tabel pengguna_lulusan
            PenggunaLulusan::create([
                'alumni_id' => $alumni->id, // Menyertakan alumni_id yang ditemukan
                'instansi_id' => $instansi->id, // Menggunakan instansi_id yang ditemukan
                'nama' => trim($row['nama']),
                'jabatan' => trim($row['jabatan_atasan_langsung']),
                'email' => trim($row['email']),
                'telepon' => trim($row['nohp']),
                'link_form' => null, // Ganti jika ada data di file
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            echo "✅ Berhasil impor pengguna lulusan untuk alumni {$nim}.\n";
        }
    }
}
