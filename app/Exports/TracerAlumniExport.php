<?php

namespace App\Exports;

use App\Models\Tracer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TracerAlumniExport implements FromQuery, WithHeadings, WithMapping
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
        return Tracer::query()
            ->whereHas('alumni.programStudi', function($query) {
                $query->where('nama', $this->prodi); // Pastikan ini sesuai dengan nama kolom di database
            })
            ->whereHas('alumni', function($query) {
                $query->whereBetween('tahun_lulus', [$this->tahunAwal, $this->tahunAkhir]);
            })
            ->with(['alumni.programStudi', 'instansi', 'profesi']);
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
        return [
            $tracer->alumni->programStudi->nama ?? '',
            $tracer->alumni->nim ?? '',
            $tracer->alumni->nama ?? '',
            $tracer->no_hp ?? '',
            $tracer->email ?? '',
            $tracer->alumni->tanggal_lulus ?? '',
            $tracer->alumni->tahun_lulus ?? '',
            $tracer->tanggal_pertama_kerja ?? '',
            $tracer->waktu_tunggu ?? '',
            $tracer->tanggal_mulai_kerja_saat_ini ?? '',
            $tracer->instansi->jenis_instansi ?? '',
            $tracer->instansi->nama_instansi ?? '',
            $tracer->instansi->skala ?? '',
            $tracer->instansi->lokasi ?? '',
            $tracer->profesi->kategori ?? '',
            $tracer->profesi->nama_profesi ?? '',
            $tracer->nama_atasan_langsung ?? '',
            $tracer->jabatan_atasan ?? '',
            $tracer->no_hp_atasan ?? '',
            $tracer->email_atasan ?? ''
        ];
    }
}