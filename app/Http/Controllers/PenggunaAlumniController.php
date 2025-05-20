<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumni;
use App\Models\Tracer;
use App\Models\Instansi;
use App\Models\PenggunaLulusan;
use App\Models\Profesi;
use App\Models\ProgramStudi;

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

    public function searchNamaPengguna(Request $request)
    {
        $search = $request->q;

        if (!$search) {
            return response()->json();
        }

        $pengguna = DB::table('pengguna_lulusan')
            ->select('id', 'nama')
            ->where('nama', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();

        $results = [];

        foreach ($pengguna as $a) {
            $results[] = [
                'id' => $a->id,
                'text' => $a->nama
            ];
        }
        

        return response()->json($results);
    }

    public function searchNama(Request $request)
    {
        $search = $request->q;

        if (!$search) {
            return response()->json();
        }

        $alumni = DB::table('alumni')
            ->join('program_studi', 'alumni.program_studi_id', '=', 'program_studi.id')
            ->select('alumni.id', 'alumni.nama', 'alumni.nim', 'program_studi.nama as program_studi')
            ->where('alumni.nama', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();

        $results = [];

        foreach ($alumni as $a) {
            $results[] = [
                'id' => $a->id,
                'text' => $a->program_studi . ' - ' . $a->nama . ' - ' . $a->nim
            ];
        }
        

        return response()->json($results);
    }
}
