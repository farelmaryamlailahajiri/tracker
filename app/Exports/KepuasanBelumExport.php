<?php

namespace App\Exports;

use App\Models\Lulusan;
use Maatwebsite\Excel\Concerns\FromCollection;

class KepuasanBelumExport implements FromCollection
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Lulusan::whereYear('tahun_kelulusan', $this->tahun)
            ->whereNull('kepuasan_pengguna') // Asumsinya ini kolomnya
            ->get();
    }
}

