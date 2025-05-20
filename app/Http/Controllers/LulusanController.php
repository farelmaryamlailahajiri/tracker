<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;

class LulusanController extends Controller
{
    // Menampilkan halaman import lulusan
    public function index()
    {
        $alumni = Alumni::with('programStudi')->get(); // Mengambil data alumni dengan eager loading
        return view('dashboard.importLulusan', compact('alumni')); // Pastikan ini ada
    }


    // Fungsi untuk mengimpor data lulusan lewat AJAX
    public function importAjax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input file
            $rules = [
                'file_lulusan' => ['required', 'mimes:xlsx,xls', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_lulusan');

            try {

                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // Format: A = Program Studi, B = NIM, C = Nama, D = Tanggal

                $inserted = 0;
                foreach ($data as $key => $row) {
                    if ($key === 0) continue; // Lewati baris header

                    $program_studi_nama = $row['A'] ?? null;
                    $nim                 = $row['B'] ?? null;
                    $nama                = $row['C'] ?? null;
                    $tanggal_lulus       = $row['D'] ?? null;

                    // Lewati baris kosong
                    if (empty($nim) && empty($nama) && empty($program_studi_nama) && empty($tanggal_lulus)) {
                        continue;
                    }

                    // Pastikan semua data tersedia
                    if ($nim && $nama && $program_studi_nama && $tanggal_lulus) {
                        // Cek apakah data dengan NIM tersebut sudah ada
                        $existing = Alumni::where('nim', $nim)->first();
                        if (!$existing) {
                            // Cek nama program studi berdasarkan nama
                            $program_studi = ProgramStudi::where('nama', $program_studi_nama)->first();
                            if (!$program_studi) {
                                continue; // Skip jika nama tidak valid
                            }

                            // Konversi tanggal Excel ke format Y-m-d
                            try {
                                if (is_numeric($tanggal_lulus)) {
                                    $tgl = Date::excelToDateTimeObject($tanggal_lulus)->format('Y-m-d');
                                } else {
                                    $tgl = date('Y-m-d', strtotime($tanggal_lulus));
                                }
                            } catch (\Exception $e) {
                                $tgl = null; // Atau bisa diatur ke nilai default
                            }

                            Alumni::create([
                                'nim' => $nim,
                                'nama' => $nama,
                                'program_studi_id' => $program_studi->id, // Simpan ID program studi
                                'tanggal_lulus' => $tgl
                            ]);

                            $inserted++;
                        }
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => "Import berhasil. $inserted data lulusan ditambahkan."
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }
}
