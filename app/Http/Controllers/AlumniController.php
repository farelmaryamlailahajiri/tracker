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

class AlumniController extends Controller
{
    public function create()
    {
        // Ambil data kategori profesi untuk dropdown
        $kategoriProfesi = Profesi::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('landingpage.alumni', compact('kategoriProfesi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:100',
            'tgl_pertama_kerja' => 'nullable|date',
            'tgl_mulai_instansi' => 'nullable|date|after_or_equal:tgl_pertama_kerja',
            'jenis_instansi' => 'required_if:kategori_profesi,!=,Tidak Bekerja|string|max:50',
            'nama_instansi' => 'nullable|required_if:kategori_profesi,!=,Tidak Bekerja|string|max:100',
            'skala_instansi' => 'nullable|string|max:20',
            'lokasi_instansi' => 'nullable|string|max:100',
            'kategori_profesi' => 'required|string|max:50',
            'profesi' => 'nullable|required_if:kategori_profesi,!=,Tidak Bekerja|string|max:100',
            'nama_atasan' => 'nullable|string|max:100',
            'jabatan_atasan' => 'nullable|string|max:100',
            'no_hp_atasan' => 'nullable|string|max:15',
            'email_atasan' => 'nullable|email|max:100',
        ]);

        DB::beginTransaction();

        try {
            // 1. Update data alumni
            $alumni = Alumni::findOrFail($validated['alumni_id']);
            $alumni->update([
                'no_hp' => $validated['no_hp'],
                'email' => $validated['email'],
            ]);

            // 2. Handle data pekerjaan (jika bukan "Tidak Bekerja")
            $instansi = null;
            $profesi = null;
            $penggunaLulusan = null;

            if ($validated['kategori_profesi'] !== 'Tidak Bekerja') {
                // 2a. Simpan instansi
                $instansi = Instansi::updateOrCreate(
                    ['nama_instansi' => $validated['nama_instansi']],
                    [
                        'jenis_instansi' => $validated['jenis_instansi'],
                        'skala' => $validated['skala_instansi'],
                        'lokasi' => $validated['lokasi_instansi'],
                    ]
                );

                // 2b. Simpan profesi
                $profesi = Profesi::updateOrCreate(
                    ['nama_profesi' => $validated['profesi']],
                    ['kategori' => $validated['kategori_profesi']]
                );

                // 2c. Simpan atasan jika ada data
                if (!empty($validated['nama_atasan'])) {
                    $penggunaLulusan = PenggunaLulusan::create([
                        'nama' => $validated['nama_atasan'],
                        'jabatan' => $validated['jabatan_atasan'],
                        'email' => $validated['email_atasan'],
                        'telepon' => $validated['no_hp_atasan'],
                        'instansi_id' => $instansi->id,
                    ]);
                }
            }

            // 3. Simpan tracer study
            Tracer::updateOrCreate(
                ['alumni_id' => $alumni->id],
                [
                    'profesi_id' => $profesi ? $profesi->id : null,
                    'instansi_id' => $instansi ? $instansi->id : null,
                    'email' => $validated['email'],
                    'no_hp' => $validated['no_hp'],
                    'tahun_lulus' => date('Y', strtotime($alumni->tanggal_lulus)),
                    'tanggal_pertama_kerja' => $validated['tgl_pertama_kerja'],
                    'tanggal_mulai_kerja_saat_ini' => $validated['tgl_mulai_instansi'],
                    'lokasi_kerja' => $validated['lokasi_instansi'],
                    'waktu_tunggu' => $this->calculateWaitingTime(
                        $alumni->tanggal_lulus, 
                        $validated['tgl_pertama_kerja']
                    ),
                ]
            );

            DB::commit();

            return redirect()->route('alumni.create')
                ->with('success', 'Data berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function searchNama(Request $request)
    {
        $search = $request->q;

        if (empty($search) || strlen($search) < 2) {
            return response()->json([]);
        }

        $alumni = Alumni::with('programStudi:id,nama')
            ->where('nama', 'like', '%' . $search . '%')
            ->orWhere('nim', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id', 'nama', 'nim', 'program_studi_id']);

        return response()->json(
            $alumni->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama . ' - ' . $item->nim . ' - ' . optional($item->programStudi)->nama,
                    'prodi' => optional($item->programStudi)->nama,
                    'tahun_lulus' => date('Y', strtotime($item->tanggal_lulus))
                ];
            })
        );
    }

    public function getProfesiByKategori(Request $request)
    {
        $request->validate(['kategori' => 'required|in:Infokom, Non-Infokom,Tidak Bekerja']);

        $profesi = Profesi::where('kategori', $request->kategori)
            ->orderBy('nama_profesi')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->nama_profesi,
                ];
            });

        return response()->json($profesi);
    }

    public function detail($id)
    {
        $alumni = Alumni::with('programStudi:id,nama')
            ->findOrFail($id, ['id', 'program_studi_id', 'tanggal_lulus']);

        return response()->json([
            'prodi' => optional($alumni->programStudi)->nama,
            'tahun_lulus' => date('Y', strtotime($alumni->tanggal_lulus)),
        ]);
    }

    private function calculateWaitingTime($graduationDate, $firstJobDate)
    {
        if (!$graduationDate || !$firstJobDate) {
            return null;
        }

        $graduation = new \DateTime($graduationDate);
        $firstJob = new \DateTime($firstJobDate);
        
        if ($firstJob < $graduation) {
            return 0;
        }

        $interval = $graduation->diff($firstJob);
        return ($interval->y * 12) + $interval->m;
    }
}