<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlumniBelumIsiTSExport implements FromQuery, WithHeadings, WithMapping
{
    protected $prodi;
    protected $tahunAwal;
    protected $tahunAkhir;

    public function __construct($prodi, $tahunAwal, $tahunAkhir)
    {
        $this->prodi = $prodi;
        $this->tahunAwal = $tahunAwal;
        $this->tahunAkhir = $tahunAkhir;
    }

    public function query()
    {
        return Alumni::query()
            ->whereDoesntHave('tracer')
            ->whereHas('programStudi', function($query) {
                $query->where('nama', $this->prodi);
            })
            ->whereBetween('tahun_lulus', [$this->tahunAwal, $this->tahunAkhir])
            ->with('programStudi');
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'NIM',
            'Nama',
            'Tanggal Lulus'
        ];
    }

    public function map($alumni): array
    {
        return [
            $alumni->programStudi->nama,
            $alumni->nim,
            $alumni->nama,
            $alumni->tanggal_lulus
        ];
    }
}