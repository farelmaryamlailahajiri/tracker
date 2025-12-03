<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class AlumniBelumIsiTSExport implements FromQuery, WithHeadings, WithMapping
{
    protected $program_studi_id;
    protected $tahunAwal;
    protected $tahunAkhir;

    public function __construct($program_studi_id, $tahunAwal, $tahunAkhir)
    {
        $this->program_studi_id = $program_studi_id;
        $this->tahunAwal = $tahunAwal;
        $this->tahunAkhir = $tahunAkhir;
    }

    public function query()
    {
        return Alumni::query()
            ->whereDoesntHave('tracer')
            ->where('program_studi_id', $this->program_studi_id)
            ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir])
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
            $alumni->programStudi->nama ?? '',
            $alumni->nim,
            $alumni->nama,
            $alumni->tanggal_lulus
        ];
    }
}