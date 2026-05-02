<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RekapnilaiController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\UbahKataSandiController;

// first page
Route::get('/', function () {
    return view('pages.login');
})->name('login');

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
// siswa
Route::get('/data_siswa', [SiswaController::class, 'showDataSiswa'])->name('data_siswa');
// guru
Route::get('/data_guru', [GuruController::class, 'showGuru'])->name('data_guru');
// kelas
Route::get('/data_kelas', [KelasController::class, 'showKelas'])->name('data_kelas');
// mapel
Route::get('/data_mapel', [MapelController::class, 'showMapel'])->name('data_mapel');
// rapor
Route::get('/data_rapor', [RaporController::class, 'showRapor'])->name('data_rapor');
// pengampu
Route::get('/pengampu', [PengampuController::class, 'showPengampu'])->name('pengampu');
// input nilai
Route::get('/input_nilai', [InputNilaiController::class, 'showInputNilai'])->name('input_nilai');
// lupa sandi
Route::get('/lupa_sandi', function () {
    return view('pages.lupa_sandi');
})->name('lupa_sandi');
Route::get('/presensi', [PresensiController::class, 'showPresensi'])->name('presensi');

// ubah kata sandi
Route::get('/ubah_kata_sandi', function () {
    return view('pages.ubah_kata_sandi');
})->name('ubah_kata_sandi');

Route::put('/password/update', function () {
    return back()->with('status', 'Kata sandi berhasil diperbarui!');
})->name('password.update');

// tambah pengampu
Route::resource('pengampu', PengampuController::class)->except(['index']);

// rekap nilai
Route::get('/rekap_nilai', [RekapnilaiController::class, 'showRekapNilai'])->name('rekap_nilai');