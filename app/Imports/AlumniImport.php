<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $nim = trim($row['nim']);

            // Lewati jika alumni sudah ada
            if (Alumni::where('nim', $nim)->exists()) {
                echo "ℹ️ Alumni dengan NIM {$nim} sudah ada. Lewati.\n";
                continue;
            }

            $programStudi = ProgramStudi::where('nama', trim($row['program_studi']))->first();

            if (!$programStudi) {
                echo "❌ Program Studi '{$row['program_studi']}' tidak ditemukan. Lewati NIM: {$nim}.\n";
                continue;
            }

            Alumni::create([
                'nama' => trim($row['nama']),
                'nim' => $nim,
                'program_studi_id' => $programStudi->id,
                'tanggal_lulus' => $row['tanggal_lulus'],
                'token' => $row['token'],
            ]);

            echo "✅ Berhasil impor alumni NIM {$nim}.\n";
        }
    }
}
