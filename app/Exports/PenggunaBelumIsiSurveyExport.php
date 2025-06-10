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
        return DB::table('tracer')
        ->join('alumni as a', 'tracer.alumni_id', '=', 'a.id')
        ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
        ->join('instansi as i', 'tracer.instansi_id', '=', 'i.id')
        ->join('pengguna_lulusan as pl', 'tracer.pengguna_id', '=', 'pl.id')
        ->leftJoin('profesi as p', 'tracer.profesi_id', '=', 'p.id')
        ->where('a.program_studi_id', $this->program_studi_id)
        ->whereNotNull('a.tanggal_lulus')
        ->whereBetween(DB::raw('YEAR(a.tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir])
        ->select([
            'pl.nama as nama_pengguna',
            'i.nama_instansi',
            'pl.jabatan',
            'pl.telepon',
            'pl.email',
            'a.nama as nama_alumni',
            'ps.nama as nama_program_studi',
            'a.tanggal_lulus',
            'pl.link_form'
        ])
        ->orderBy('tracer.id');
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
            'Tahun Lulus',
            'Link Form'
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama_pengguna,
            $row->nama_instansi,
            $row->jabatan,
            $row->telepon,
            $row->email,
            $row->nama_alumni,
            $row->nama_program_studi,
            $row->tanggal_lulus ? date('Y', strtotime($row->tanggal_lulus)) : '',
            $row->link_form,
        ];
    }
}
