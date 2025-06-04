<?php

namespace App\Exports;

use App\Models\PenggunaLulusan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenggunaBelumIsiSurveyExport implements FromQuery, WithHeadings, WithMapping
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
        return PenggunaLulusan::query()
        ->join('instansi as i', 'pengguna_lulusan.instansi_id', '=', 'i.id')
        ->join('tracer as t', 't.instansi_id', '=', 'i.id')
        ->join('alumni as a', 't.alumni_id', '=', 'a.id')
        ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
        ->whereNotIn('t.id', function ($query) {
            $query->select('tracer_id')->from('kepuasan_pengguna');
        })
        ->where('a.program_studi_id', $this->program_studi_id)
        ->whereNotNull('a.tanggal_lulus')
        ->whereBetween(DB::raw('YEAR(a.tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir])
        ->select('pengguna_lulusan.*')
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
        $alumni = $pengguna->alumni;
        $programStudi = $alumni?->programStudi;

        return [
            $pengguna->nama,
            $pengguna->instansi?->nama_instansi ?? '',
            $pengguna->jabatan,
            $pengguna->telepon,
            $pengguna->email,
            $alumni?->nama ?? '',
            $programStudi?->nama ?? '',
            $alumni?->tanggal_lulus ? date('Y', strtotime($alumni->tanggal_lulus)) : ''
        ];
    }
}
