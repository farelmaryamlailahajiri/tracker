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
            ->whereHas('penggunaLulusan.alumni', function($query) {
                $query->where('program_studi_id', $this->program_studi_id)
                    ->whereNotNull('tanggal_lulus')
                    ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$this->tahunAwal, $this->tahunAkhir]);
            })
            ->with(['penggunaLulusan.alumni.programStudi', 'penggunaLulusan.instansi']);
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
            $pengguna?->alumni?->nama ?? '',
            $pengguna?->alumni?->programStudi?->nama ?? '',
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
