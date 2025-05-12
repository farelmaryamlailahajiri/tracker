<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaAlumniController;

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

Route::post('/login', [LoginController::class, 'login']);
Route::get('/dashboard', function () {
    return view('dashboard.index'); // nama file: resources/views/dashboard.blade.php
})->name('dashboard');