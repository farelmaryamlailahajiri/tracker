<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lulusan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LulusanImport;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class LulusanController extends Controller
{
    // Menampilkan halaman import lulusan
    public function index()
    {
        return view('dashboard.importLulusan');
    }

    // Fungsi untuk mengimpor data lulusan via AJAX
    public function importAjax(Request $request)
    {
        try {
            // Validasi input file
            $request->validate([
                'file_ajak' => 'required|mimes:xlsx,xls'
            ]);

            // Import menggunakan LulusanImport
            Excel::import(new LulusanImport, $request->file('file_ajak'));

            return response()->json([
                'status' => true,
                'message' => 'Data lulusan berhasil diimpor.'
            ]);

        } catch (\Exception $e) {
            // Logging error untuk debugging
            Log::error('Gagal import lulusan: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data.',
                'error' => $e->getMessage(), // optional untuk debug
            ]);
        }
    }

    // Menampilkan form import lulusan
public function import()
{
    return view('lulusan.importajax'); // Sesuaikan dengan nama view kamu
}

// Import data lulusan via Ajax
public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_lulusan' => ['required', 'mimes:xlsx', 'max:2048']
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
            $data = $sheet->toArray(null, false, true, true); // Format kolom A, B, C, D

            $inserted = 0;
            foreach ($data as $key => $row) {
                if ($key === 1) continue; // Skip header

                $tahunLulus             = $row['A'] ?? null;
                $jumlahLulusan          = $row['B'] ?? null;
                $jumlahLulusanTeracak   = $row['C'] ?? null;
                $rataRataWaktuTunggu    = $row['D'] ?? null;

                if ($tahunLulus && $jumlahLulusan && $jumlahLulusanTeracak && $rataRataWaktuTunggu) {
                    Lulusan::create([
                        'tahun_lulus'              => $tahunLulus,
                        'jumlah_lulusan'           => $jumlahLulusan,
                        'jumlah_lulusan_teracak'   => $jumlahLulusanTeracak,
                        'rata_rata_waktu_tunggu'   => $rataRataWaktuTunggu,
                    ]);
                    $inserted++;
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
