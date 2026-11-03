<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\MataKuliahController as AdminMataKuliahController;
use App\Http\Controllers\Dosen\DosenController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;

// Auth Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes (Untuk semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Group Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('prodi', ProdiController::class)->except(['show']);
    Route::resource('mahasiswa', AdminMahasiswaController::class)->except(['show']);
    Route::resource('dosen', AdminDosenController::class)->except(['show']);
    Route::resource('mata-kuliah', AdminMataKuliahController::class)->except(['show']);
});

// Group Dosen
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/mata-kuliah', [DosenController::class, 'mataKuliahIndex'])->name('mata-kuliah.index');
    Route::get('/mata-kuliah/{mataKuliah}/mahasiswa', [DosenController::class, 'mataKuliahMahasiswa'])->name('mata-kuliah.mahasiswa');
    Route::get('/nilai', [DosenController::class, 'inputNilaiIndex'])->name('nilai.index');
    Route::get('/nilai/{mataKuliah}', [DosenController::class, 'inputNilaiForm'])->name('nilai.form');
    Route::post('/nilai/{mataKuliah}', [DosenController::class, 'simpanNilai'])->name('nilai.simpan');
});

// Group Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/krs', [MahasiswaController::class, 'krsIndex'])->name('krs.index');
    Route::post('/krs', [MahasiswaController::class, 'krsSimpan'])->name('krs.simpan');
    Route::get('/nilai', [MahasiswaController::class, 'nilaiIndex'])->name('nilai.index');
});
