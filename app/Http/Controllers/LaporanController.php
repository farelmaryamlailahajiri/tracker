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
use App\Models\ProgramStudi;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $prodi = $request->input('program_studi', 'D4 TI');
        $tahunAwal = $request->input('tahun_awal', date('Y') - 3);
        $tahunAkhir = $request->input('tahun_akhir', date('Y'));

        return view('dashboard.laporan', compact('prodi', 'tahunAwal', 'tahunAkhir'));
    }

    public function exportAlumniBelumTS(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|integer',
            'tahun_awal' => 'required|integer',
            'tahun_akhir' => 'required|integer'
        ]);

        $prodi = ProgramStudi::findOrFail($request->program_studi);

        return Excel::download(
            new AlumniBelumIsiTSExport($request->program_studi, $request->tahun_awal, $request->tahun_akhir),
            "rekap_alumni_belum_isi_ts_{$prodi->nama}_{$request->tahun_awal}_{$request->tahun_akhir}.xlsx"
        );
    }

    public function exportPenggunaBelumSurvey(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|integer',
            'tahun_awal' => 'required|integer',
            'tahun_akhir' => 'required|integer'
        ]);

        $prodi = ProgramStudi::findOrFail($request->program_studi);

        return Excel::download(
            new PenggunaBelumIsiSurveyExport($request->program_studi, $request->tahun_awal, $request->tahun_akhir),
            "rekap_pengguna_belum_isi_survey_{$prodi->nama}_{$request->tahun_awal}_{$request->tahun_akhir}.xlsx"
        );
    }

    public function exportSurveyPengguna(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|integer',
            'tahun_awal' => 'required|integer',
            'tahun_akhir' => 'required|integer'
        ]);

        $prodi = ProgramStudi::findOrFail($request->program_studi);

        return Excel::download(
            new SurveyPenggunaExport($request->program_studi, $request->tahun_awal, $request->tahun_akhir),
            "rekap_survey_pengguna_{$prodi->nama}_{$request->tahun_awal}_{$request->tahun_akhir}.xlsx"
        );
    }

    public function exportTracerAlumni(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|integer',
            'tahun_awal' => 'required|integer',
            'tahun_akhir' => 'required|integer'
        ]);

        $prodi = ProgramStudi::findOrFail($request->program_studi);

        return Excel::download(
            new TracerAlumniExport($request->program_studi, $request->tahun_awal, $request->tahun_akhir),
            "Rekap_hasil_tracer_study_lulusan_{$prodi->nama}_{$request->tahun_awal}_{$request->tahun_akhir}.xlsx"
        );
    }
}
