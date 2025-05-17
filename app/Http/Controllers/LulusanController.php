<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lulusan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LulusanImport;

class LulusanController extends Controller
{
    // Menampilkan halaman import lulusan
    public function index()
    {
        return view('dashboard.importLulusan'); // Pastikan ini sesuai
    }

    // Fungsi untuk mengimpor data lulusan
    public function importAjax(Request $request)
{
    $request->validate([
        'file_ajak' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new AjaxImport, $request->file('file_ajak'));

    return response()->json(['status' => true, 'message' => 'Data Ajak berhasil diimpor.']);
}
}