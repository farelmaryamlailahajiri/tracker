<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Imports\AlumniImport;

class LulusanController extends Controller
{
    // Menampilkan halaman lulusan
    public function index()
    {
        $alumni = Alumni::paginate(10); // paginate 10 data
        return view('dashboard.importLulusan', compact('alumni'));
    }


    // Menangani import file Excel
    public function import(Request $request)
    {
        $request->validate([
            'file_lulusan' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file_lulusan');
            $data = Excel::toArray([], $file);
            $rows = $data[0];

            // Skip header
            unset($rows[0]);

            DB::beginTransaction();

            foreach ($rows as $row) {
                $programStudi = ProgramStudi::firstOrCreate(['nama' => $row[0]]);

                Alumni::create([
                    'program_studi_id' => $programStudi->id,
                    'nim' => $row[1],
                    'nama' => $row[2],
                    'tanggal_lulus' => date('Y-m-d', strtotime($row[3]))
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Data berhasil diimpor.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['message' => 'Gagal mengimpor data!'], 500);
        }
    }
}
