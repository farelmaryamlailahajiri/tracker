<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaAlumni;

class PenggunaAlumniController extends Controller
{
    public function create()
    {
        return view('landingpage.penggunaAlumni');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email',
            'alumni_info' => 'required',
            'kerjasama_tim' => 'required',
            'keahlian_ti' => 'required',
            'bahasa_asing' => 'required',
            'komunikasi' => 'required',
            'pengembangan_diri' => 'required',
            'kepemimpinan' => 'required',
            'etos_kerja' => 'required',
            'kompetensi_kurang' => 'nullable',
            'saran_kurikulum' => 'nullable',
        ]);

        // PenggunaAlumni::create($validated);
        return redirect()->back()->with('success', 'Data berhasil dikirim!');
    }
}
