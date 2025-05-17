<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LulusanController extends Controller
{
    // Menampilkan data lulusan
    public function index()
    {
        return view('dashboard.importLulusan'); // Pastikan file ini sesuai dengan letak view Anda
    }

    // Menampilkan form import data lulusan
    public function showImportForm()
    {
        return view('dashboard.importLulusan'); // Buat view ini untuk form import
    }
}
