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
use App\Http\Controllers\KegiatanPimpinanController;
use App\Http\Controllers\SambutanController;
use App\Http\Controllers\MediaSosialController;
use App\Http\Controllers\SubKomunikasiPimpinanController;
use App\Http\Controllers\SubDokumentasiPimpinanController;
use App\Http\Controllers\GaleriArsipController;
use App\Http\Controllers\SubProtokolController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AsistenAiController;
use App\Http\Controllers\NotifikasiController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kegiatan Pimpinan
    Route::get('/kegiatan-pimpinan', [KegiatanPimpinanController::class, 'index'])->name('kegiatan-pimpinan.index');
    Route::get('/kegiatan-pimpinan/create', [KegiatanPimpinanController::class, 'create'])->name('kegiatan-pimpinan.create');
    Route::post('/kegiatan-pimpinan', [KegiatanPimpinanController::class, 'store'])->name('kegiatan-pimpinan.store');
    Route::get('/kegiatan-pimpinan/{kegiatan}/success', [KegiatanPimpinanController::class, 'success'])->name('kegiatan-pimpinan.success');
    Route::get('/kegiatan-pimpinan/{kegiatan}/edit', [KegiatanPimpinanController::class, 'edit'])->name('kegiatan-pimpinan.edit');
    Route::put('/kegiatan-pimpinan/{kegiatan}', [KegiatanPimpinanController::class, 'update'])->name('kegiatan-pimpinan.update');
    Route::delete('/kegiatan-pimpinan/{kegiatan}', [KegiatanPimpinanController::class, 'destroy'])->name('kegiatan-pimpinan.destroy');

    // Komunikasi Pimpinan — Sambutan
    Route::get('/komunikasi-pimpinan/sambutan', [SambutanController::class, 'index'])->name('sambutan.index');
    Route::get('/komunikasi-pimpinan/sambutan/create', [SambutanController::class, 'createPermohonan'])->name('sambutan.create-permohonan');
    Route::get('/komunikasi-pimpinan/sambutan/hasil/create', [SambutanController::class, 'createHasil'])->name('sambutan.create-hasil');
    Route::post('/komunikasi-pimpinan/sambutan', [SambutanController::class, 'store'])->name('sambutan.store');
    Route::get('/komunikasi-pimpinan/sambutan/{sambutan}/edit', [SambutanController::class, 'edit'])->name('sambutan.edit');
    Route::put('/komunikasi-pimpinan/sambutan/{sambutan}', [SambutanController::class, 'update'])->name('sambutan.update');
    Route::post('/komunikasi-pimpinan/sambutan/bulk-destroy', [SambutanController::class, 'bulkDestroy'])->name('sambutan.bulk-destroy');
    Route::get('/komunikasi-pimpinan/sambutan/{sambutan}/success', [SambutanController::class, 'success'])->name('sambutan.success');
    Route::delete('/komunikasi-pimpinan/sambutan/{sambutan}', [SambutanController::class, 'destroy'])->name('sambutan.destroy');

    // Komunikasi Pimpinan — Media Sosial
    Route::get('/komunikasi-pimpinan/media-sosial', [MediaSosialController::class, 'index'])->name('media-sosial.index');
    Route::post('/komunikasi-pimpinan/media-sosial', [MediaSosialController::class, 'store'])->name('media-sosial.store');
    Route::put('/komunikasi-pimpinan/media-sosial/{mediaSosial}', [MediaSosialController::class, 'update'])->name('media-sosial.update');
    Route::delete('/komunikasi-pimpinan/media-sosial/{mediaSosial}', [MediaSosialController::class, 'destroy'])->name('media-sosial.destroy');

    // Sub Komunikasi Pimpinan (legacy)
    Route::get('/sub-komunikasi-pimpinan', [SubKomunikasiPimpinanController::class, 'index'])->name('sub-komunikasi-pimpinan.index');

    // Sub Dokumentasi Pimpinan
    Route::get('/sub-dokumentasi-pimpinan', [SubDokumentasiPimpinanController::class, 'index'])->name('sub-dokumentasi-pimpinan.index');

    // Dokumentasi Pimpinan — Galeri Arsip
    Route::get('/dokumentasi-pimpinan/galeri-arsip', [GaleriArsipController::class, 'index'])->name('galeri-arsip.index');
    Route::post('/dokumentasi-pimpinan/galeri-arsip', [GaleriArsipController::class, 'store'])->name('galeri-arsip.store');
    Route::put('/dokumentasi-pimpinan/galeri-arsip/{galeriArsip}', [GaleriArsipController::class, 'update'])->name('galeri-arsip.update');
    Route::delete('/dokumentasi-pimpinan/galeri-arsip/{galeriArsip}', [GaleriArsipController::class, 'destroy'])->name('galeri-arsip.destroy');

    // Sub Protokol
    Route::get('/sub-protokol', [SubProtokolController::class, 'index'])->name('sub-protokol.index');

    // Kegiatan
    Route::resource('/kegiatan', KegiatanController::class);

    // Protokol Pimpinan — Penugasan
    Route::get('/protokol-pimpinan/penugasan', [PenugasanController::class, 'index'])->name('protokol-pimpinan.penugasan.index');
    Route::get('/protokol-pimpinan/penugasan/create', [PenugasanController::class, 'create'])->name('protokol-pimpinan.penugasan.create');
    Route::post('/protokol-pimpinan/penugasan', [PenugasanController::class, 'store'])->name('protokol-pimpinan.penugasan.store');
    Route::get('/protokol-pimpinan/penugasan/{penugasan}/edit', [PenugasanController::class, 'edit'])->name('protokol-pimpinan.penugasan.edit');
    Route::put('/protokol-pimpinan/penugasan/{penugasan}', [PenugasanController::class, 'update'])->name('protokol-pimpinan.penugasan.update');
    Route::delete('/protokol-pimpinan/penugasan/{penugasan}', [PenugasanController::class, 'destroy'])->name('protokol-pimpinan.penugasan.destroy');

    // Penugasan legacy aliases
    Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
    Route::get('/penugasan/create', [PenugasanController::class, 'create'])->name('penugasan.create');
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
    Route::get('/arsip/create', [ArsipController::class, 'create'])->name('arsip.create');
    Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
    Route::delete('/arsip/{arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy');

    // Asset Management (Administrasi)
    Route::get('/administrasi/asset', [AssetController::class, 'index'])->name('asset.index');
    Route::get('/administrasi/asset/create-inventaris', [AssetController::class, 'createInventaris'])->name('asset.create-inventaris');
    Route::post('/administrasi/asset/store-inventaris', [AssetController::class, 'storeInventaris'])->name('asset.store-inventaris');
    Route::get('/administrasi/asset/create-kendaraan', [AssetController::class, 'createKendaraan'])->name('asset.create-kendaraan');
    Route::post('/administrasi/asset/store-kendaraan', [AssetController::class, 'storeKendaraan'])->name('asset.store-kendaraan');
    Route::delete('/administrasi/asset/{asset}/inventaris', [AssetController::class, 'destroyInventaris'])->name('asset.destroy-inventaris');
    Route::delete('/administrasi/asset/{kendaraan}/kendaraan', [AssetController::class, 'destroyKendaraan'])->name('asset.destroy-kendaraan');
    Route::get('/administrasi/asset/export', [AssetController::class, 'export'])->name('asset.export');
    Route::get('/asset', fn() => redirect()->route('asset.index'));

    // Pegawai Management (Administrasi)
    Route::get('/administrasi/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/administrasi/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/administrasi/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/administrasi/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/administrasi/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/administrasi/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::get('/administrasi/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');
    Route::get('/pegawai', fn() => redirect()->route('pegawai.index'));

    // Keuangan Management (Administrasi)
    Route::get('/administrasi/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('/administrasi/keuangan/create', [KeuanganController::class, 'create'])->name('keuangan.create');
    Route::post('/administrasi/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
    Route::get('/administrasi/keuangan/{keuangan}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');
    Route::put('/administrasi/keuangan/{keuangan}', [KeuanganController::class, 'update'])->name('keuangan.update');
    Route::delete('/administrasi/keuangan/{keuangan}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
    Route::get('/administrasi/keuangan/export', [KeuanganController::class, 'export'])->name('keuangan.export');
    Route::get('/keuangan', fn() => redirect()->route('keuangan.index'));

    // Asisten AI Chatbot
    Route::get('/asisten-ai', [AsistenAiController::class, 'index'])->name('asisten-ai.index');
    Route::post('/asisten-ai/send', [AsistenAiController::class, 'sendMessage'])->name('asisten-ai.send');
    Route::post('/asisten-ai/clear', [AsistenAiController::class, 'clearChat'])->name('asisten-ai.clear');
    Route::post('/asisten-ai/api-key', [AsistenAiController::class, 'saveApiKey'])->name('asisten-ai.api-key');

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

    // Notifikasi (real-time polling)
    Route::get('/notifikasi/count', [NotifikasiController::class, 'count'])->name('notifikasi.count');
    Route::get('/notifikasi/list', [NotifikasiController::class, 'index'])->name('notifikasi.list');
    Route::post('/notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllRead'])->name('notifikasi.read-all');
    Route::post('/notifikasi/preferences', [NotifikasiController::class, 'savePreferences'])->name('notifikasi.preferences');
});
