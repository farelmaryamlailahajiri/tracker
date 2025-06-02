<?php

namespace App\Exports;

use App\Models\PenggunaLulusan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenggunaBelumIsiSurveyExport implements FromQuery, WithHeadings, WithMapping
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
        return PenggunaLulusan::query()
            ->whereDoesntHave('kepuasanPengguna')
            ->whereHas('alumni.programStudi', function($query) {
                $query->where('nama', $this->prodi);
            })
            ->whereHas('alumni', function($query) {
                $query->whereBetween('tahun_lulus', [$this->tahunAwal, $this->tahunAkhir]);
            })
            ->with(['alumni.programStudi', 'instansi']);
    }

    public function headings(): array
    {
        return [
            'Nama Pengguna',
            'Instansi',
            'Jabatan',
            'No HP',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus'
        ];
    }

    public function map($pengguna): array
    {
        return [
            $pengguna->nama,
            $pengguna->instansi->nama_instansi,
            $pengguna->jabatan,
            $pengguna->telepon,
            $pengguna->email,
            $pengguna->alumni->nama,
            $pengguna->alumni->programStudi->nama,
            $pengguna->alumni->tahun_lulus
        ];
    }
}