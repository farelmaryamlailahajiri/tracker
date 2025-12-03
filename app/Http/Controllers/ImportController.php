<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Tracer;
use App\Models\Profesi;
use App\Models\Instansi;
use App\Models\PenggunaLulusan;
use App\Models\KepuasanPengguna;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('import.form');
    }

    public function importAlumni(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0];
        
        // Skip header
        array_shift($data);
        
        foreach ($data as $row) {
            // Cari atau buat program studi
            $prodi = ProgramStudi::firstOrCreate(['nama' => $row[0]]);
            
            Alumni::updateOrCreate(
                ['nim' => $row[1]],
                [
                    'nama' => $row[2],
                    'program_studi_id' => $prodi->id,
                    'tanggal_lulus' => $row[3],
                    'token' => $row[4]
                ]
            );
        }
        
        return back()->with('success', 'Data alumni berhasil diimpor');
    }

    public function importTracer(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0];
        
        // Skip header
        array_shift($data);
        
        foreach ($data as $row) {
            $alumni = Alumni::where('nim', $row[1])->first();
            if (!$alumni) continue;
            
            // Cari atau buat profesi
            $profesi = Profesi::firstOrCreate(
                ['nama_profesi' => $row[15]],
                ['kategori' => str_contains($row[14], 'Infokom') ? 'IT' : 'Non-IT']
            );
            
            // Cari atau buat instansi
            $instansi = Instansi::firstOrCreate(
                ['nama_instansi' => $row[11]],
                [
                    'jenis_instansi' => $row[10],
                    'skala' => $row[12],
                    'lokasi' => $row[13]
                ]
            );
            
            // Cari atau buat pengguna lulusan
            $pengguna = PenggunaLulusan::firstOrCreate(
                ['email' => $row[19]],
                [
                    'nama' => $row[17],
                    'jabatan' => $row[18],
                    'telepon' => $row[20],
                    'instansi_id' => $instansi->id
                ]
            );
            
            // Buat tracer
            $tracer = Tracer::updateOrCreate(
                ['alumni_id' => $alumni->id],
                [
                    'profesi_id' => $profesi->id,
                    'instansi_id' => $instansi->id,
                    'email' => $row[4],
                    'no_hp' => $row[3],
                    'tahun_lulus' => $row[6],
                    'tanggal_lulus' => $this->excelToDate($row[5]),
                    'tanggal_pertama_kerja' => $this->excelToDate($row[7]),
                    'tanggal_mulai_kerja_saat_ini' => $this->excelToDate($row[9]),
                    'waktu_tunggu' => $row[8],
                    'lokasi_kerja' => $row[13],
                    'kategori_profesi' => $row[14]
                ]
            );
            
            // Buat data kepuasan pengguna
            KepuasanPengguna::updateOrCreate(
                ['tracer_id' => $tracer->id, 'pengguna_id' => $pengguna->id],
                [
                    'kerjasama_tim' => $this->getKepuasanValue($row[7]),
                    'keahlian_ti' => $this->getKepuasanValue($row[8]),
                    'bahasa_asing' => $this->getKepuasanValue($row[9]),
                    'komunikasi' => $this->getKepuasanValue($row[10]),
                    'pengembangan_diri' => $this->getKepuasanValue($row[11]),
                    'kepemimpinan' => $this->getKepuasanValue($row[12]),
                    'etos_kerja' => $this->getKepuasanValue($row[13]),
                    'kompetensi_yang_belum_dipenuhi' => $row[14],
                    'saran' => $row[15]
                ]
            );
        }
        
        return back()->with('success', 'Data tracer dan kepuasan berhasil diimpor');
    }
    
    private function excelToDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($excelDate - 2);
        }
        return \Carbon\Carbon::createFromFormat('d/m/Y', $excelDate);
    }
    
    private function getKepuasanValue($value)
    {
        $value = strtolower($value);
        if (str_contains($value, 'sangat baik')) return 'Sangat Baik';
        if (str_contains($value, 'baik')) return 'Baik';
        if (str_contains($value, 'cukup')) return 'Cukup';
        return 'Kurang';
    }
}