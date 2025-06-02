<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    AlumniBelumIsiTSExport,
    PenggunaBelumIsiSurveyExport,
    SurveyPenggunaExport,
    TracerAlumniExport
};
use App\Models\{
    Alumni,
    ProgramStudi,
    Tracer,
    PenggunaLulusan,
    KepuasanPengguna
};

class LaporanController extends Controller
{
    // Menampilkan halaman laporan
    public function index(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));
        
        return view('dashboard.laporan', compact('prodi', 'tahunAwal', 'tahunAkhir'));
    }

    // Export untuk Alumni Belum Isi Tracer Study
    public function exportAlumniBelumTS(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));
        
        return Excel::download(
            new AlumniBelumIsiTSExport($prodi, $tahunAwal, $tahunAkhir), 
            "rekap_alumni_belum_isi_ts_{$prodi}_{$tahunAwal}_{$tahunAkhir}.xlsx"
        );
    }

    // Export untuk Pengguna Belum Isi Survey
    public function exportPenggunaBelumSurvey(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));
        
        return Excel::download(
            new PenggunaBelumIsiSurveyExport($prodi, $tahunAwal, $tahunAkhir), 
            "rekap_pengguna_belum_isi_survey_{$prodi}_{$tahunAwal}_{$tahunAkhir}.xlsx"
        );
    }

    // Export untuk Survey Pengguna
    public function exportSurveyPengguna(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));
        
        return Excel::download(
            new SurveyPenggunaExport($prodi, $tahunAwal, $tahunAkhir), 
            "rekap_survey_pengguna_{$prodi}_{$tahunAwal}_{$tahunAkhir}.xlsx"
        );
    }

    // Export untuk Tracer Alumni
    public function exportTracerAlumni(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));
        
        return Excel::download(
            new TracerAlumniExport($prodi, $tahunAwal, $tahunAkhir), 
            "rekap_tracer_alumni_{$prodi}_{$tahunAwal}_{$tahunAkhir}.xlsx"
        );
    }
}