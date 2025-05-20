<?php

namespace App\Exports;

use App\Models\Lulusan;
use Maatwebsite\Excel\Concerns\FromCollection;

class TracerExport implements FromCollection
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Lulusan::whereYear('tahun_kelulusan', $this->tahun)
            ->whereNotNull('isian_tracer') // Ganti kolom sesuai struktur tabel
            ->get();
    }
}

