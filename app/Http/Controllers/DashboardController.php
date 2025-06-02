<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Tracer;
use App\Models\Profesi;
use App\Models\Instansi;
use App\Models\KepuasanPengguna;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default values
        $selectedProdi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));

        // Total lulusan
        $totalLulusan = Alumni::where('program_studi_id', $selectedProdi)
            ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
            ->count();

        // Total terlacak (menggunakan tracer dan alumni)
        $totalTerlacak = Tracer::whereHas('alumni', function($query) use ($selectedProdi, $tahunAwal, $tahunAkhir) {
            $query->where('program_studi_id', $selectedProdi)
                  ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$tahunAwal, $tahunAkhir]);
        })
            ->whereNotNull('tanggal_pertama_kerja')
            ->count();

        // PERBAIKAN: Query tabel lingkup kerja
        $tabelLingkupKerja = Alumni::select(
            DB::raw('YEAR(alumni.tanggal_lulus) as tahun'),
            DB::raw('COUNT(DISTINCT alumni.id) as total_lulusan'), // Hitung semua alumni per tahun
            DB::raw('COUNT(tracer.id) as total_terlacak'), // Hitung yang ada data tracer
            DB::raw('SUM(CASE WHEN profesi.kategori = "Infokom" THEN 1 ELSE 0 END) as infokom'),
            DB::raw('SUM(CASE WHEN profesi.kategori = "Non-Infokom" THEN 1 ELSE 0 END) as non_infokom'),
            DB::raw('SUM(CASE WHEN instansi.skala = "Multinasional" THEN 1 ELSE 0 END) as internasional'),
            DB::raw('SUM(CASE WHEN LOWER(instansi.skala) = "nasional" THEN 1 ELSE 0 END) as nasional'),
            DB::raw('SUM(CASE WHEN LOWER(profesi.nama_profesi) LIKE "%wirausaha%" OR LOWER(profesi.nama_profesi) LIKE "%usaha%" THEN 1 ELSE 0 END) as wirausaha')
        )
        ->leftJoin('tracer', 'alumni.id', '=', 'tracer.alumni_id')
        ->leftJoin('profesi', 'profesi.id', '=', 'tracer.profesi_id')
        ->leftJoin('instansi', 'instansi.id', '=', 'tracer.instansi_id')
        ->where('alumni.program_studi_id', $selectedProdi)
        ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
        ->groupBy(DB::raw('YEAR(alumni.tanggal_lulus)'))
        ->orderBy('tahun')
        ->get();

        // Data untuk chart Profesi
        $profesiData = Profesi::select('nama_profesi', DB::raw('COUNT(tracer.id) as total'))
            ->join('tracer', 'tracer.profesi_id', '=', 'profesi.id')
            ->join('alumni', 'alumni.id', '=', 'tracer.alumni_id')
            ->where('alumni.program_studi_id', $selectedProdi)
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
            ->groupBy('nama_profesi')
            ->orderBy('total', 'desc')
            ->get();

        // Data untuk chart Institusi
        $institusiData = Instansi::select('jenis_instansi', DB::raw('COUNT(tracer.id) as total'))
            ->join('tracer', 'tracer.instansi_id', '=', 'instansi.id')
            ->join('alumni', 'alumni.id', '=', 'tracer.alumni_id')
            ->where('alumni.program_studi_id', $selectedProdi)
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
            ->groupBy('jenis_instansi')
            ->orderBy('total', 'desc')
            ->get();

        // PERBAIKAN: Data untuk rata-rata waktu tunggu
        $waktuTungguData = Alumni::select(
            DB::raw('YEAR(alumni.tanggal_lulus) as tahun'),
            DB::raw('COUNT(DISTINCT alumni.id) as total_lulusan'), // Pastikan unique alumni
            DB::raw('COUNT(tracer.id) as total_terlacak'),
            DB::raw('AVG(tracer.waktu_tunggu) as rata_waktu_tunggu')
        )
        ->leftJoin('tracer', 'alumni.id', '=', 'tracer.alumni_id')
        ->where('alumni.program_studi_id', $selectedProdi)
        ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
        ->groupBy(DB::raw('YEAR(alumni.tanggal_lulus)'))
        ->orderBy('tahun')
        ->get();

        // Konsistensi totalLulusan: gunakan sum dari $waktuTungguData agar sama dengan tabel
        $totalLulusan = $waktuTungguData->sum('total_lulusan');

        // Konsistensi totalTerlacak: gunakan sum dari $waktuTungguData agar sama dengan tabel
        $totalTerlacak = $waktuTungguData->sum('total_terlacak');

        // Hitung rata-rata waktu tunggu keseluruhan
        $rataWaktuTunggu = Tracer::whereHas('alumni', function($query) use ($selectedProdi, $tahunAwal, $tahunAkhir) {
            $query->where('program_studi_id', $selectedProdi)
                  ->whereBetween(DB::raw('YEAR(tanggal_lulus)'), [$tahunAwal, $tahunAkhir]);
        })
        ->avg('waktu_tunggu') ?? 0;

        // Data untuk kepuasan (rata-rata) - untuk keperluan lain jika dibutuhkan
        $kepuasanData = KepuasanPengguna::select(
            DB::raw('AVG(CASE WHEN kerjasama_tim = "Sangat Baik" THEN 4 WHEN kerjasama_tim = "Baik" THEN 3 WHEN kerjasama_tim = "Cukup" THEN 2 ELSE 1 END) as kerjasama_tim'),
            DB::raw('AVG(CASE WHEN keahlian_ti = "Sangat Baik" THEN 4 WHEN keahlian_ti = "Baik" THEN 3 WHEN keahlian_ti = "Cukup" THEN 2 ELSE 1 END) as keahlian_ti'),
            DB::raw('AVG(CASE WHEN bahasa_asing = "Sangat Baik" THEN 4 WHEN bahasa_asing = "Baik" THEN 3 WHEN bahasa_asing = "Cukup" THEN 2 ELSE 1 END) as bahasa_asing'),
            DB::raw('AVG(CASE WHEN komunikasi = "Sangat Baik" THEN 4 WHEN komunikasi = "Baik" THEN 3 WHEN komunikasi = "Cukup" THEN 2 ELSE 1 END) as komunikasi'),
            DB::raw('AVG(CASE WHEN pengembangan_diri = "Sangat Baik" THEN 4 WHEN pengembangan_diri = "Baik" THEN 3 WHEN pengembangan_diri = "Cukup" THEN 2 ELSE 1 END) as pengembangan_diri'),
            DB::raw('AVG(CASE WHEN kepemimpinan = "Sangat Baik" THEN 4 WHEN kepemimpinan = "Baik" THEN 3 WHEN kepemimpinan = "Cukup" THEN 2 ELSE 1 END) as kepemimpinan'),
            DB::raw('AVG(CASE WHEN etos_kerja = "Sangat Baik" THEN 4 WHEN etos_kerja = "Baik" THEN 3 WHEN etos_kerja = "Cukup" THEN 2 ELSE 1 END) as etos_kerja')
        )
        ->join('tracer', 'tracer.id', '=', 'kepuasan_pengguna.tracer_id')
        ->join('alumni', 'alumni.id', '=', 'tracer.alumni_id')
        ->where('alumni.program_studi_id', $selectedProdi)
        ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
        ->first();

        // Data kepuasan pengguna untuk tabel dan chart (data mentah)
        $kepuasanGroupData = KepuasanPengguna::select(
            'kerjasama_tim', 
            'keahlian_ti', 
            'bahasa_asing', 
            'komunikasi', 
            'pengembangan_diri', 
            'kepemimpinan', 
            'etos_kerja'
        )
        ->join('tracer', 'tracer.id', '=', 'kepuasan_pengguna.tracer_id')
        ->join('alumni', 'alumni.id', '=', 'tracer.alumni_id')
        ->where('alumni.program_studi_id', $selectedProdi)
        ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
        ->get();

        // Data statistik kepuasan untuk keperluan chart dan perhitungan
        $kepuasanStats = [];
        $fields = ['kerjasama_tim', 'keahlian_ti', 'bahasa_asing', 'komunikasi', 'pengembangan_diri', 'kepemimpinan', 'etos_kerja'];
        
        foreach ($fields as $field) {
            $kepuasanStats[$field] = KepuasanPengguna::select(
                DB::raw('COUNT(CASE WHEN ' . $field . ' = "Sangat Baik" THEN 1 END) as sangat_baik'),
                DB::raw('COUNT(CASE WHEN ' . $field . ' = "Baik" THEN 1 END) as baik'),
                DB::raw('COUNT(CASE WHEN ' . $field . ' = "Cukup" THEN 1 END) as cukup'),
                DB::raw('COUNT(CASE WHEN ' . $field . ' = "Kurang" THEN 1 END) as kurang'),
                DB::raw('COUNT(*) as total')
            )
            ->join('tracer', 'tracer.id', '=', 'kepuasan_pengguna.tracer_id')
            ->join('alumni', 'alumni.id', '=', 'tracer.alumni_id')
            ->where('alumni.program_studi_id', $selectedProdi)
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$tahunAwal, $tahunAkhir])
            ->first();
        }

        return view('dashboard.index', compact(
            'selectedProdi',
            'tahunAwal',
            'tahunAkhir',
            'totalLulusan',
            'totalTerlacak',
            'rataWaktuTunggu',
            'tabelLingkupKerja',
            'profesiData',
            'institusiData',
            'waktuTungguData',
            'kepuasanData',
            'kepuasanGroupData',
            'kepuasanStats'
        ));
    }
}