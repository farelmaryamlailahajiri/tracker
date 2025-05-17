<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lulusan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;

class LulusanController extends Controller
{
    // Menampilkan halaman import lulusan
    public function index()
    {
        return view('dashboard.importLulusan'); // Ganti sesuai view yang kamu gunakan
    }

    // Fungsi untuk mengimpor data lulusan lewat AJAX
    public function importAjax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input file
            $rules = [
                'file_ajax' => ['required', 'mimes:xlsx,xls', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_ajax');

            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // Format: A = NIM, B = Nama, C = Prodi, D = Tanggal

                $inserted = 0;
                foreach ($data as $key => $row) {
                    if ($key === 1) continue; // Lewati baris header

                    $nim           = $row['A'] ?? null;
                    $nama          = $row['B'] ?? null;
                    $program_studi = $row['C'] ?? null;
                    $tanggal_lulus = $row['D'] ?? null;

                    // Lewati baris kosong
                    if (empty($nim) && empty($nama) && empty($program_studi) && empty($tanggal_lulus)) {
                        continue;
                    }

                    // Pastikan semua data tersedia
                    if ($nim && $nama && $program_studi && $tanggal_lulus) {
                        // Cek apakah data dengan NIM tersebut sudah ada
                        $existing = Lulusan::where('nim', $nim)->first();
                        if (!$existing) {
                            // Konversi tanggal Excel ke format Y-m-d
                            try {
                                $tgl = is_numeric($tanggal_lulus)
                                    ? Date::excelToDateTimeObject($tanggal_lulus)->format('Y-m-d')
                                    : date('Y-m-d', strtotime($tanggal_lulus));
                            } catch (\Exception $e) {
                                $tgl = null;
                            }

                            Lulusan::create([
                                'nim' => $nim,
                                'nama' => $nama,
                                'program_studi_id' => $program_studi,
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