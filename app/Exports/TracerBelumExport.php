<?php

namespace App\Exports;

use App\Models\Lulusan;
use Maatwebsite\Excel\Concerns\FromCollection;

class TracerBelumExport implements FromCollection
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Lulusan::whereYear('tahun_kelulusan', $this->tahun)
            ->whereNull('isian_tracer') // Asumsinya ini kolom yang menunjukkan sudah mengisi atau belum
            ->get();
    }
}
