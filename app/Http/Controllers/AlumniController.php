<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alumni;
use App\Models\Tracer;
use App\Models\Instansi;
use App\Models\PenggunaLulusan;
use App\Models\Profesi;

class AlumniController extends Controller
{
    public function create()
    {
        return view('landingpage.alumni');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'no_hp' => 'required',
            'email' => 'required|email',
            'tgl_pertama_kerja' => 'nullable|date',
            'tgl_mulai_instansi' => 'nullable|date',
            'jenis_instansi' => 'required',
            'nama_instansi' => 'nullable|required_if:kategori_profesi,!=,Tidak Bekerja',
            'skala_instansi' => 'nullable',
            'lokasi_instansi' => 'nullable',
            'kategori_profesi' => 'required',
            'profesi' => 'nullable|required_if:kategori_profesi,!=,Tidak Bekerja',
            'nama_atasan' => 'nullable',
            'jabatan_atasan' => 'nullable',
            'no_hp_atasan' => 'nullable',
            'email_atasan' => 'nullable|email',
        ]);

        // Start transaction to ensure data consistency
        \DB::beginTransaction();

        try {
            // Update alumni contact info
            $alumni = Alumni::findOrFail($request->alumni_id);
            $alumni->update([
                'no_hp' => $request->no_hp,
                'email' => $request->email,
            ]);

            // Handle instansi data if not "Tidak Bekerja"
            $instansi = null;
            $profesi = null;
            $penggunaLulusan = null;

            if ($request->kategori_profesi !== 'Tidak Bekerja') {
                // Create or update instansi
                $instansi = Instansi::updateOrCreate(
                    ['nama_instansi' => $request->nama_instansi],
                    [
                        'jenis_instansi' => $request->jenis_instansi,
                        'skala' => $request->skala_instansi,
                        'lokasi' => $request->lokasi_instansi,
                    ]
                );

                // Create or update profesi
                $profesi = Profesi::updateOrCreate(
                    ['nama_profesi' => $request->profesi],
                    ['kategori' => $request->kategori_profesi]
                );

                // Create pengguna lulusan if atasan data is provided
                if ($request->nama_atasan) {
                    $penggunaLulusan = PenggunaLulusan::create([
                        'nama' => $request->nama_atasan,
                        'jabatan' => $request->jabatan_atasan,
                        'email' => $request->email_atasan,
                        'telepon' => $request->no_hp_atasan,
                        'instansi_id' => $instansi->id,
                    ]);
                }
            }

            // Create tracer record
            $tracer = Tracer::create([
                'alumni_id' => $alumni->id,
                'profesi_id' => $profesi ? $profesi->id : null,
                'instansi_id' => $instansi ? $instansi->id : null,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'tahun_lulus' => date('Y', strtotime($alumni->tanggal_lulus)),
                'tanggal_pertama_kerja' => $request->tgl_pertama_kerja,
                'tanggal_mulai_kerja_saat_ini' => $request->tgl_mulai_instansi,
                'lokasi_kerja' => $request->lokasi_instansi,
                'waktu_tunggu' => $this->calculateWaitingTime($alumni->tanggal_lulus, $request->tgl_pertama_kerja),
            ]);

            \DB::commit();

            return redirect()->route('alumni.create')->with([
                'success' => 'Data berhasil disimpan!',
                'alumni_id' => $alumni->id // Untuk prepopulate form jika perlu
            ]);
        } catch (\Exception $e) {
                return redirect()->back()->withInput()->with([
                'error' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function searchNama(Request $request)
    {
        $search = $request->q;

        $alumni = DB::table('alumni')
            ->select('id', 'nama', 'nim')
            ->where('nama', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();

        $results = [];

        foreach ($alumni as $a) {
            $results[] = [
                'id' => $a->id,
                'text' => $a->nama . ' - ' . $a->nim
            ];
        }
        

        return response()->json($results);
    }

    public function detail($id)
    {
        $alumni = Alumni::with('programStudi:id,nama')
            ->select('id','program_studi_id','tanggal_lulus')
            ->findOrFail($id);

        return response()->json([
            'prodi'       => optional($alumni->programStudi)->nama,
            'tahun_lulus' => $alumni->tanggal_lulus,
        ]);
    }

    private function calculateWaitingTime($graduationDate, $firstJobDate)
    {
        if (!$graduationDate || !$firstJobDate) {
            return null;
        }

        $graduation = new \DateTime($graduationDate);
        $firstJob = new \DateTime($firstJobDate);
        $interval = $graduation->diff($firstJob);

        if ($graduation->m == $firstJob->m && $graduation->y == $firstJob->y) {
            return 0; // No waiting time
        }

        // Return in months
        return ($interval->y * 12) + $interval->m;
    }
}