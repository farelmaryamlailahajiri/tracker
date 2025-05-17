<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\PenggunaAlumniController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\LoginController;

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

Route::get('/pengguna-alumni', [PenggunaAlumniController::class, 'create'])->name('pengguna-alumni.create');
Route::post('/pengguna-alumni', [PenggunaAlumniController::class, 'store'])->name('pengguna-alumni.store');

Route::get('/dashboard', function () {
    return view('dashboard.index'); // nama file: resources/views/dashboard.blade.php
})->name('dashboard');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);

Route::get('/admin/dashboard', [LoginController::class, 'dashboard']);


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.index'); // arahkan ke view yang kamu buat
    })->name('admin.dashboard');
});


Route::get('/importLulusan', [LulusanController::class, 'index'])->name('lulusan.index');
Route::post('/importLulusan', [LulusanController::class, 'import'])->name('lulusan.import');
Route::post('/ajak/import_ajax', [LulusanController::class, 'importAjax'])->name('ajak.import_ajax');
