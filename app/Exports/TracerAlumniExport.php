<?php

namespace App\Exports;

use App\Models\Tracer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TracerAlumniExport implements FromQuery, WithHeadings, WithMapping
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
        return Tracer::query()
            ->whereHas('alumni', function ($query) {
                $query->where('program_studi_id', $this->program_studi_id)
                      ->whereNotNull('tanggal_lulus')
                      ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir]);
            })
            ->with(['alumni.programStudi', 'instansi', 'profesi', 'pengguna']);
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'NIM',
            'Nama',
            'No HP',
            'Email',
            'Tanggal Lulus',
            'Tahun Lulus',
            'Tanggal Pertama Kerja',
            'Masa Tunggu (bulan)',
            'Tanggal Mulai Kerja Saat Ini',
            'Jenis Instansi',
            'Nama Instansi',
            'Skala Instansi',
            'Lokasi Instansi',
            'Kategori Profesi',
            'Profesi',
            'Nama Atasan Langsung',
            'Jabatan Atasan',
            'No HP Atasan',
            'Email Atasan'
        ];
    }

    public function map($tracer): array
    {
        $alumni = $tracer->alumni;
        $programStudi = $alumni?->programStudi;
        $instansi = $tracer->instansi;
        $profesi = $tracer->profesi;
        $pengguna = $tracer->pengguna;

        return [
            $programStudi?->nama ?? '',
            $alumni?->nim ?? '',
            $alumni?->nama ?? '',
            $tracer->no_hp ?? '',
            $tracer->email ?? '',
            $alumni?->tanggal_lulus ?? '',
            $alumni?->tanggal_lulus ? date('Y', strtotime($alumni->tanggal_lulus)) : '',
            $tracer->tanggal_pertama_kerja ?? '',
            $tracer->waktu_tunggu ?? '',
            $tracer->tanggal_mulai_kerja_saat_ini ?? '',
            $instansi?->jenis_instansi ?? '',
            $instansi?->nama_instansi ?? '',
            $instansi?->skala ?? '',
            $instansi?->lokasi ?? '',
            $profesi?->kategori ?? '',
            $profesi?->nama_profesi ?? '',
            $pengguna?->nama ?? '',
            $pengguna?->jabatan ?? '',
            $pengguna?->telepon ?? '',
            $pengguna?->email ?? ''
        ];
    }
}
