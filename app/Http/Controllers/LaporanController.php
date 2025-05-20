<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TracerExport;
use App\Exports\KepuasanExport;
use App\Exports\TracerBelumExport;
use App\Exports\KepuasanBelumExport;
use App\Models\Lulusan; // Ganti dengan model yang sesuai jika perlu

class LaporanController extends Controller
{
    // Menampilkan halaman laporan
    public function index()
    {
        return view('dashboard.laporan');
    }

    // Export untuk Tracer Study, dengan filter tahun
    public function exportTracer(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Ambil tahun dari filter (default ke tahun sekarang)
        return Excel::download(new TracerExport($tahun), "rekap_tracer_study_{$tahun}.xlsx");
    }

    // Export untuk Kepuasan Pengguna, dengan filter tahun
    public function exportKepuasan(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Ambil tahun dari filter (default ke tahun sekarang)
        return Excel::download(new KepuasanExport($tahun), "rekap_kepuasan_pengguna_{$tahun}.xlsx");
    }

    // Export untuk Lulusan yang belum isi Tracer Study, dengan filter tahun
    public function exportTracerBelum(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Ambil tahun dari filter (default ke tahun sekarang)
        return Excel::download(new TracerBelumExport($tahun), "lulusan_belum_isi_tracer_{$tahun}.xlsx");
    }

    // Export untuk Pengguna yang belum isi Survei Kepuasan, dengan filter tahun
    public function exportKepuasanBelum(Request $request)
    {
        $tahun = $request->input('tahun', date('Y')); // Ambil tahun dari filter (default ke tahun sekarang)
        return Excel::download(new KepuasanBelumExport($tahun), "pengguna_belum_isi_kepuasan_{$tahun}.xlsx");
    }
}
