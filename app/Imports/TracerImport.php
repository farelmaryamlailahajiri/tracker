<?php

namespace App\Imports;

use App\Models\Tracer;
use App\Models\Alumni;
use App\Models\Profesi;
use App\Models\Instansi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TracerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Trim untuk menghindari masalah spasi ekstra
            $nim = trim($row['nim']); // Menggunakan 'NIM' sesuai dengan kolom di Excel
            $alumni = Alumni::where('nim', $nim)->first();

            // Cek apakah alumni ditemukan berdasarkan NIM
            if (!$alumni) {
                echo "❌ Alumni dengan NIM {$nim} tidak ditemukan. Lewati.\n";
                continue;
            }

            // Cek profesi berdasarkan nama profesi yang ada di file
            $profesi = Profesi::where('nama_profesi', trim($row['profesi']))->first();
            if (!$profesi) {
                echo "❌ Profesi '{$row['profesi']}' tidak ditemukan. Lewati NIM: {$nim}.\n";
                continue;
            }

            // Cek instansi berdasarkan nama instansi yang ada di file
            $instansi = Instansi::where('nama_instansi', trim($row['nama_instansi']))->first();
            if (!$instansi) {
                echo "❌ Instansi '{$row['nama_instansi']}' tidak ditemukan. Lewati NIM: {$nim}.\n";
                continue;
            }

            // Cek jika tracer sudah ada untuk alumni ini
            $existingTracer = Tracer::where('alumni_id', $alumni->id)->first();
            if ($existingTracer) {
                echo "ℹ️ Tracer untuk NIM {$nim} sudah ada. Lewati.\n";
                continue;
            }

            // Masukkan data tracer
            Tracer::create([
                'alumni_id' => $alumni->id, // Relasi alumni_id
                'instansi_id' => $instansi->id, // Relasi instansi_id
                'profesi_id' => $profesi->id, // Relasi profesi_id
                'email' => trim($row['email']), // Perhatikan spasi di akhir email
                'no_hp' => trim($row['nohp']),
                'tahun_lulus' => $row['tahun_lulus'],
                'tanggal_pertama_kerja' => $this->parseDate($row['tanggal_pertama_kerja']),
                'tanggal_mulai_kerja_saat_ini' => $this->parseDate($row['tgl_mulai_kerja_instansi_saat_ini']),
                'waktu_tunggu' => floatval($row['masa_tunggu']),
            ]);

            echo "✅ Berhasil impor tracer untuk NIM {$nim}.\n";
        }
    }

    // Fungsi untuk mengonversi tanggal excel ke format PHP DateTime
    private function parseDate($excelDate)
    {
        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate);
        } catch (\Throwable $th) {
            return null; // Jika gagal, kembalikan null
        }
    }
}