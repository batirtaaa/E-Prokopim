<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\NotulensiController;
use App\Http\Controllers\ArahanController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DaftarHadirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilAdminController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kegiatan
    Route::resource('/kegiatan', KegiatanController::class);

    // Penugasan
    Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
    Route::post('/penugasan', [PenugasanController::class, 'store'])->name('penugasan.store');
    Route::put('/penugasan/{penugasan}', [PenugasanController::class, 'update'])->name('penugasan.update');
    Route::delete('/penugasan/{penugasan}', [PenugasanController::class, 'destroy'])->name('penugasan.destroy');

    // Notulensi
    Route::resource('/notulensi', NotulensiController::class)->except(['create']);

    // Arahan Pimpinan
    Route::get('/arahan', [ArahanController::class, 'index'])->name('arahan.index');
    Route::post('/arahan', [ArahanController::class, 'store'])->name('arahan.store');
    Route::get('/arahan/{arahan}/edit', [ArahanController::class, 'edit'])->name('arahan.edit');
    Route::put('/arahan/{arahan}', [ArahanController::class, 'update'])->name('arahan.update');
    Route::delete('/arahan/{arahan}', [ArahanController::class, 'destroy'])->name('arahan.destroy');

    // Arsip Digital
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
    Route::delete('/arsip/{arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    // Dokumentasi
    Route::get('/dokumentasi', [DokumentasiController::class, 'index'])->name('dokumentasi.index');
    Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
    Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');

    // Daftar Hadir
    Route::get('/daftar-hadir', [DaftarHadirController::class, 'index'])->name('daftar-hadir.index');
    Route::post('/daftar-hadir', [DaftarHadirController::class, 'store'])->name('daftar-hadir.store');
    Route::delete('/daftar-hadir/{daftarHadir}', [DaftarHadirController::class, 'destroy'])->name('daftar-hadir.destroy');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan/instansi', [PengaturanController::class, 'updateInstansi'])->name('pengaturan.instansi.update');
    Route::post('/pengaturan/users', [PengaturanController::class, 'storeUser'])->name('pengaturan.users.store');
    Route::delete('/pengaturan/users/{user}', [PengaturanController::class, 'destroyUser'])->name('pengaturan.users.destroy');
    Route::patch('/pengaturan/users/{user}/toggle-status', [PengaturanController::class, 'toggleUserStatus'])->name('pengaturan.users.toggle-status');

    // Profil Admin
    Route::get('/profil-admin', [ProfilAdminController::class, 'index'])->name('profil-admin.index');
    Route::put('/profil-admin/profil', [ProfilAdminController::class, 'updateProfil'])->name('profil-admin.profil.update');
    Route::post('/profil-admin/foto', [ProfilAdminController::class, 'updateFoto'])->name('profil-admin.foto.update');
    Route::put('/profil-admin/password', [ProfilAdminController::class, 'updatePassword'])->name('profil-admin.password.update');
});
