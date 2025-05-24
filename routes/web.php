<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\PenggunaAlumniController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfesiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landingpage.index');
});
Route::get('/form-alumni', [AlumniController::class, 'create'])->name('alumni.create');
Route::post('/form-alumni', [AlumniController::class, 'store'])->name('alumni.store');
Route::get('form-alumni/search', [AlumniController::class, 'searchNama'])->name('alumni.search');
Route::get('/form-alumni/detail/{id}', [AlumniController::class, 'detail'])->name('alumni.detail');
Route::get('/form-alumni/kategori', [ProfesiController::class, 'getAllKategori'])->name('alumni.kategori');
Route::get('/form-alumni/by-kategori', [ProfesiController::class, 'getByKategori'])->name('alumni.by-kategori');

Route::get('/pengguna-alumni', [PenggunaAlumniController::class, 'create'])->name('pengguna-alumni.create');
Route::post('/pengguna-alumni', [PenggunaAlumniController::class, 'store'])->name('pengguna-alumni.store');
Route::get('pengguna-alumni/search', [PenggunaAlumniController::class, 'searchNama'])->name('pengguna-alumni.search');
Route::get('pengguna-alumni/searchPengguna', [PenggunaAlumniController::class, 'searchNamaPengguna'])->name('pengguna-alumni.searchPenggunaLulusan');

// Dashboard (hanya GET untuk menampilkan halaman dashboard)
Route::get('/dashboard', function () {
    return view('dashboard.index'); // Sesuaikan nama file blade yang benar
})->name('dashboard');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/lulusan', [LulusanController::class, 'index'])->name('lulusan.index');
Route::post('/lulusan/import', [LulusanController::class, 'import'])->name('lulusan.import');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export/tracer', [LaporanController::class, 'exportTracer'])->name('laporan.export.tracer');
Route::get('/laporan/export/kepuasan', [LaporanController::class, 'exportKepuasan'])->name('laporan.export.kepuasan');
Route::get('/laporan/export/tracer/belum', [LaporanController::class, 'exportTracerBelum'])->name('laporan.export.tracer.belum');
Route::get('/laporan/export/kepuasan/belum', [LaporanController::class, 'exportKepuasanBelum'])->name('laporan.export.kepuasan.belum');

Route::resource('/profesi', ProfesiController::class);