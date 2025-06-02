<?php

namespace App\Exports;

use App\Models\KepuasanPengguna;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveyPenggunaExport implements FromQuery, WithHeadings, WithMapping
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
        return KepuasanPengguna::query()
            ->whereHas('penggunaLulusan.alumni.programStudi', function($query) {
                $query->where('nama', $this->prodi);
            })
            ->whereHas('penggunaLulusan.alumni', function($query) {
                $query->whereBetween('tahun_lulus', [$this->tahunAwal, $this->tahunAkhir]);
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
            'Kompetensi yang Dibutuhkan tapi Belum Dapat Dipenuhi',
            'Saran untuk Kurikulum Program Studi'
        ];
    }

    public function map($kepuasan): array
    {
        return [
            $kepuasan->penggunaLulusan->nama,
            $kepuasan->penggunaLulusan->instansi->nama_instansi,
            $kepuasan->penggunaLulusan->jabatan,
            $kepuasan->penggunaLulusan->email,
            $kepuasan->penggunaLulusan->alumni->nama,
            $kepuasan->penggunaLulusan->alumni->programStudi->nama,
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