<?php

namespace App\Imports;

use App\Models\Instansi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class InstansiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $instansi = trim($row['nama_instansi']);
            $jenisInstansi = trim($row['jenis_instansi']);
            $skala = trim($row['skala']);
            $lokasi = trim($row['lokasi_instansi']);

            // Debugging output untuk memverifikasi data
            echo "📌 Instansi: '{$instansi}' | Jenis: '{$jenisInstansi}' | Skala: '{$skala}' | Lokasi: '{$lokasi}'\n";

            // Menggunakan updateOrInsert untuk menambahkan atau memperbarui data
            Instansi::updateOrInsert(
                ['nama_instansi' => $instansi],  // Cek berdasarkan nama_instansi
                [
                    'jenis_instansi' => $jenisInstansi ?: 'Lainnya', // Jika kosong, set default
                    'skala' => $skala ?: 'Lokal',  // Jika kosong, set default
                    'lokasi' => $lokasi ?: 'Indonesia',  // Jika kosong, set default
                ]
            );

            echo "✅ Berhasil impor instansi '{$instansi}'.\n";
        }
    }
}
