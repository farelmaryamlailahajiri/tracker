<?php

namespace App\Exports;

use App\Models\Lulusan; // Ganti jika kamu menggunakan model lain
use Maatwebsite\Excel\Concerns\FromCollection;

class KepuasanExport implements FromCollection
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Lulusan::whereYear('tahun_kelulusan', $this->tahun)
            ->whereNotNull('kepuasan_pengguna') // Mengambil data yang sudah mengisi survei kepuasan
            ->get();
    }
}

