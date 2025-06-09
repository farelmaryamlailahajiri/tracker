<?php

namespace App\Exports;

use App\Models\KepuasanPengguna;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveyPenggunaExport implements FromQuery, WithHeadings, WithMapping
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
        return KepuasanPengguna::query()
            ->select(
                'kepuasan_pengguna.*',
                'alumni.nama as nama_alumni',
                'program_studi.nama as nama_program_studi'
            )
            ->join('tracer', 'kepuasan_pengguna.tracer_id', '=', 'tracer.id')
            ->join('pengguna_lulusan', 'kepuasan_pengguna.pengguna_id', '=', 'pengguna_lulusan.id')
            ->join('alumni', 'tracer.alumni_id', '=', 'alumni.id')
            ->join('program_studi', 'alumni.program_studi_id', '=', 'program_studi.id')
            ->join('instansi', 'tracer.instansi_id', '=', 'instansi.id')
            ->where('alumni.program_studi_id', $this->program_studi_id)
            ->whereNotNull('alumni.tanggal_lulus')
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir]);
    }


    public function headings(): array
    {
        return [
            'Nama Pengguna',
            'Instansi',
            'Jabatan',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Kerjasama Tim',
            'Keahlian di Bidang TI',
            'Kemampuan Bahasa Asing',
            'Kemampuan Komunikasi',
            'Pengembangan Diri',
            'Kepemimpinan',
            'Etos Kerja',
            'Kompetensi yang Belum Dipenuhi',
            'Saran untuk Kurikulum'
        ];
    }

    public function map($kepuasan): array
    {
        $pengguna = $kepuasan->penggunaLulusan;

        return [
            $pengguna?->nama ?? '',
            $pengguna?->instansi?->nama_instansi ?? '',
            $pengguna?->jabatan ?? '',
            $pengguna?->email ?? '',
            $kepuasan->nama_alumni ?? '', // ambil dari hasil join
            $kepuasan->nama_program_studi ?? '', // ambil dari hasil join
            $kepuasan->kerjasama_tim,
            $kepuasan->keahlian_ti,
            $kepuasan->bahasa_asing,
            $kepuasan->komunikasi,
            $kepuasan->pengembangan_diri,
            $kepuasan->kepemimpinan,
            $kepuasan->etos_kerja,
            $kepuasan->kompetensi_yang_belum_dipenuhi,
            $kepuasan->saran
        ];
    }
}
