<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function create()
    {
        return view('landingpage.alumni');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_studi' => 'required',
            'tahun_lulus' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'tanggal_kerja_pertama' => 'required|date',
            'tanggal_mulai_instansi' => 'required|date',
            'jenis_instansi' => 'required',
            'nama_instansi' => 'required',
            'skala' => 'required',
            'lokasi_instansi' => 'required',
            'kategori_profesi' => 'required',
            'profesi' => 'required',
            'nama_atasan' => 'required',
            'jabatan_atasan' => 'required',
            'no_hp_atasan' => 'required',
            'email_atasan' => 'required|email',
        ]);

        // Simpan ke database, logika tergantung model tabel yang kamu pakai
        // Contoh:
        // Alumni::create($validated);

        return redirect()->back()->with('success', 'Data alumni berhasil dikirim!');
    }
}