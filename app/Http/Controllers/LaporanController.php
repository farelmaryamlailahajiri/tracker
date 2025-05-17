<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TracerExport;
use App\Exports\KepuasanExport;
use App\Exports\TracerBelumExport;
use App\Exports\KepuasanBelumExport;

class LaporanController extends Controller
{
    public function index()
    {
        return view('dashboard.laporan');
    }

    public function exportTracer()
    {
        return Excel::download(new TracerExport, 'rekap_tracer_study.xlsx');
    }

    public function exportKepuasan()
    {
        return Excel::download(new KepuasanExport, 'rekap_kepuasan_pengguna.xlsx');
    }

    public function exportTracerBelum()
    {
        return Excel::download(new TracerBelumExport, 'lulusan_belum_isi_tracer.xlsx');
    }

    public function exportKepuasanBelum()
    {
        return Excel::download(new KepuasanBelumExport, 'pengguna_belum_isi_kepuasan.xlsx');
    }
}
