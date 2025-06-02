<?php

namespace App\Imports;

use App\Models\Profesi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProfesiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $profesi = trim($row['profesi'] ?? '');
            $kategoriRaw = strtolower(trim($row['kategori_profesi'] ?? ''));

            // Normalisasi kategori
            if (str_contains($kategoriRaw, 'infokom') && str_contains($kategoriRaw, 'non')) {
                $kategori = 'Non-Infokom';
            } elseif (str_contains($kategoriRaw, 'infokom')) {
                $kategori = 'Infokom';
            } elseif (str_contains($kategoriRaw, 'tidak')) {
                $kategori = 'Tidak Bekerja';
            } else {
                $kategori = 'Lainnya';
            }

            if (!$profesi) continue; // Lewati jika kosong

            // Update jika sudah ada
            $existingProfesi = Profesi::where('nama_profesi', $profesi)->first();
            if ($existingProfesi) {
                $existingProfesi->update(['kategori' => $kategori]);
                echo "🔄 Update: '{$profesi}' dikategorikan sebagai '{$kategori}'.\n";
            } else {
                Profesi::create([
                    'nama_profesi' => $profesi,
                    'kategori' => $kategori
                ]);
                echo "✅ Tambah: '{$profesi}' ditambahkan sebagai '{$kategori}'.\n";
            }
        }
    }
}
