<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasienAuthController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterAuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\PasienController;

/*
|--------------------------------------------------------------------------
| PASIEN
|--------------------------------------------------------------------------
*/

Route::get('/pasien/antrian/realtime', [AntrianController::class, 'realtime']);

// Login & Register
Route::get('/pasien/login', [PasienAuthController::class, 'loginForm']);
Route::post('/pasien/login', [PasienAuthController::class, 'login']);

Route::get('/pasien/register', [PasienAuthController::class, 'registerForm']);
Route::post('/pasien/register', [PasienAuthController::class, 'register']);

Route::get('/pasien/logout', [PasienAuthController::class, 'logout']);

// Ambil antrian
Route::get('/pasien/ambil-antrian', [PasienController::class, 'ambilAntrianForm'])
    ->name('pasien.ambil');

Route::post('/pasien/ambil-antrian', [PasienController::class, 'ambilAntrian']);

// Lihat antrian
Route::get('/pasien/antrian', [PasienController::class, 'antrian']);
Route::get('/pasien/realtime', [AntrianController::class, 'realtime']);


/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/

Route::get('/dokter/login', [DokterAuthController::class, 'loginForm'])->name('dokter.login');
Route::post('/dokter/login', [DokterAuthController::class, 'login']);

Route::get('/dokter/dashboard', [DokterController::class, 'index'])
    ->middleware('dokter.auth')
    ->name('dokter.dashboard');

Route::post('/dokter/panggil/{id}', [DokterController::class, 'panggil'])->name('dokter.panggil');
Route::post('/dokter/selesai/{id}', [DokterController::class, 'selesai'])->name('dokter.selesai');

Route::get('/dokter/logout', function () {
    session()->forget('dokter_id');
    return redirect('/dokter/login');
});



Route::get('/', function () {
    return view('welcome');
});
