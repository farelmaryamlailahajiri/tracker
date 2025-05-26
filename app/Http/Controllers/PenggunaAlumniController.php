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
use App\Models\KepuasanPengguna;

class PenggunaAlumniController extends Controller
{
    public function create(Request $request)
    {
        $penggunaId = $request->query('pengguna_id');
        $tracerId = $request->query('tracer_id');

        // Validasi opsional: pastikan ID yang dimaksud valid
        if (!PenggunaLulusan::find($penggunaId) || !Tracer::find($tracerId)) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('landingpage.penggunaAlumni', compact('penggunaId', 'tracerId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tracer_id' => 'required|exists:tracer,id',
            'pengguna_id' => 'required|exists:alumni,id',
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
        DB::beginTransaction();

        try {
            if (KepuasanPengguna::where('pengguna_id', $validated['pengguna_id'])->exists()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data untuk alumni ini sudah pernah diinput.');
            }

            KepuasanPengguna::create([
                'pengguna_id' => $validated['pengguna_id'],
                'tracer_id' => $validated['tracer_id'],
                'kerjasama_tim' => $validated['kerjasama_tim'],
                'keahlian_ti' => $validated['keahlian_ti'],
                'bahasa_asing' => $validated['bahasa_asing'],
                'komunikasi' => $validated['komunikasi'],
                'pengembangan_diri' => $validated['pengembangan_diri'],
                'kepemimpinan' => $validated['kepemimpinan'],
                'etos_kerja' => $validated['etos_kerja'],
                'kompetensi_yang_belum_dipenuhi' => $validated['kompetensi_kurang'] ?? null,
                'saran' => $validated['saran_kurikulum'] ?? null,
            ]);
            DB::commit();

            return redirect()->route('pengguna-alumni.create', [
                'pengguna_id' => $validated['pengguna_id'],
                'tracer_id' => $validated['tracer_id'],
            ])
                ->with('success', 'Data pengguna alumni berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
