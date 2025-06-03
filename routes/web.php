<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\PenggunaAlumniController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\AlumniLoginController;
use App\Http\Controllers\DashboardController;


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
Route::get('/form-alumni/verifikasi', [AlumniController::class, 'verifikasi']);
Route::get('form-alumni/search', [AlumniController::class, 'searchNama'])->name('alumni.search');
Route::get('/form-alumni/detail/{id}', [AlumniController::class, 'detail'])->name('alumni.detail');
Route::get('/form-alumni/kategori', [ProfesiController::class, 'getAllKategori'])->name('alumni.kategori');
Route::get('/form-alumni/by-kategori', [ProfesiController::class, 'getByKategori'])->name('alumni.by-kategori');

Route::post('/lulusan/import', [AlumniController::class, 'import'])->name('lulusan.import');

Route::get('/pengguna-alumni/create', [PenggunaAlumniController::class, 'create'])->name('pengguna-alumni.create');
Route::post('/pengguna-alumni', [PenggunaAlumniController::class, 'store'])->name('pengguna-alumni.store');
Route::get('pengguna-alumni/search', [PenggunaAlumniController::class, 'searchNama'])->name('pengguna-alumni.search');
Route::get('pengguna-alumni/searchPengguna', [PenggunaAlumniController::class, 'searchNamaPengguna'])->name('pengguna-alumni.searchPenggunaLulusan');

// Dashboard (hanya GET untuk menampilkan halaman dashboard)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/lulusan', [LulusanController::class, 'index'])->name('lulusan.index');
Route::post('/lulusan/import', [LulusanController::class, 'import'])->name('lulusan.import');

// Laporan Routes
Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    
    // Export Routes
    Route::get('/export/alumni-belum-ts', [LaporanController::class, 'exportAlumniBelumTS'])->name('laporan.export.alumni-belum-ts');
    Route::get('/export/pengguna-belum-survey', [LaporanController::class, 'exportPenggunaBelumSurvey'])->name('laporan.export.pengguna-belum-survey');
    Route::get('/export/survey-pengguna', [LaporanController::class, 'exportSurveyPengguna'])->name('laporan.export.survey-pengguna');
    Route::get('/laporan/export/tracer-alumni', [LaporanController::class, 'exportTracerAlumni'])->name('laporan.export.tracer-alumni');
});

Route::resource('/profesi', ProfesiController::class);

