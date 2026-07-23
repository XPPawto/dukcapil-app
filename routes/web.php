<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\PermohonanController;
use App\Http\Controllers\Warga\ProfilController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/lupa-password', [PageController::class, 'lupaPassword'])->name('lupa-password');

// Autentikasi warga
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register/berhasil', [RegisterController::class, 'success'])->name('register.success');

// Login terpadu: satu form untuk warga, admin, dan petugas.
// Backend mendeteksi jenis akun lalu mengarahkan ke dashboard yang sesuai.
Route::middleware('guest:admin,citizen')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth:citizen')->name('logout');

Route::get('/files/{file}', [FileController::class, 'show'])->middleware('signed')->name('files.show');

// Portal warga
Route::prefix('beranda')->name('warga.')->middleware('auth:citizen')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil');
    Route::put('/profil/email', [ProfilController::class, 'updateEmail'])->name('profil.email');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    Route::prefix('permohonan')->name('permohonan.')->group(function () {
        Route::get('/', [PermohonanController::class, 'pilih'])->name('pilih');
        Route::get('/kartu-keluarga', [PermohonanController::class, 'formKk'])->name('kk');
        Route::get('/akta-kelahiran', [PermohonanController::class, 'formAktaLahir'])->name('akta-lahir');
        Route::get('/akta-kematian', [PermohonanController::class, 'formAktaMati'])->name('akta-mati');
        Route::post('/{jenis}', [PermohonanController::class, 'store'])->name('store');
        Route::get('/riwayat/semua', [PermohonanController::class, 'riwayat'])->name('riwayat');
        Route::get('/detail/{ticket}', [PermohonanController::class, 'show'])->name('detail');
    });
});

// Admin / Petugas (login dilakukan lewat form terpadu di atas)
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        Route::get('/{ticket}', [VerifikasiController::class, 'show'])->name('show');
        Route::put('/{ticket}', [VerifikasiController::class, 'updateStatus'])->name('update-status');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::put('/{citizen}/reset-password', [AdminUserController::class, 'resetPassword'])->name('reset-password');
        Route::put('/{citizen}/unlock', [AdminUserController::class, 'unlock'])->name('unlock');
    });

    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit-logs.index');
});
