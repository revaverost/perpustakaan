<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginOtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIPERPUS
|--------------------------------------------------------------------------
*/

// Redirect Halaman Utama (/) ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================================================================
// ROUTE GUEST (Hanya untuk pengguna yang belum login)
// =========================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Verifikasi OTP (dikirim ke email Admin/Pustakawan)
    Route::get('/login/otp', [LoginOtpController::class, 'show'])->name('login.otp');
    Route::post('/login/otp/verify', [LoginOtpController::class, 'verify'])->name('login.otp.verify');
    Route::post('/login/otp/resend', [LoginOtpController::class, 'resend'])->name('login.otp.resend');
});

// =========================================================================
// ROUTE AUTHENTICATED (Wajib Login Pustakawan / Admin)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profil & Password Staff
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =====================================================================
    // MASTER DATA
    // =====================================================================
    // Katalog Buku: Admin (Monitoring/Index), Pustakawan (CRUD)
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::resource('buku', BukuController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:Pustakawan');

    // Data Mahasiswa & Petugas/User: Khusus Admin (CRUD)
    Route::resource('mahasiswa', MahasiswaController::class)
        ->except(['show'])
        ->middleware('role:Admin');

    Route::resource('user', UserController::class)
        ->except(['show'])
        ->middleware('role:Admin');

    // =====================================================================
    // TRANSAKSI: PEMINJAMAN BUKU
    // =====================================================================
    // 1. Route spesifik (create, store, edit, update, destroy) harus di ATAS wildcard {peminjaman}
    Route::resource('peminjaman', PeminjamanController::class)
        ->only(['create', 'store'])
        ->middleware('role:Pustakawan');

    Route::post('peminjaman/{id}/perpanjang', [PeminjamanController::class, 'perpanjang'])
        ->middleware('role:Pustakawan')
        ->name('peminjaman.perpanjang');

    // 2. Route monitoring & cetak laporan (Admin & Pustakawan)
    Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'show']);
    Route::get('peminjaman-export/pdf', [PeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
    Route::get('peminjaman-export/csv', [PeminjamanController::class, 'exportCsv'])->name('peminjaman.export.csv');

    // =====================================================================
    // TRANSAKSI: PENGEMBALIAN BUKU
    // =====================================================================
    Route::middleware(['role:Pustakawan'])->group(function () {
        Route::get('pengembalian/create/{id_peminjaman}', [PengembalianController::class, 'create'])->name('pengembalian.create');
        Route::post('pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
        // TRANSAKSI: PENGEMBALIAN BUKU
        Route::get('pengembalian-export/pdf', [PengembalianController::class, 'exportPdf'])->name('pengembalian.export.pdf');
        Route::get('pengembalian-export/csv', [PengembalianController::class, 'exportCsv'])->name('pengembalian.export.csv');
    });

    Route::resource('pengembalian', PengembalianController::class)->only(['index', 'show']);

    // =====================================================================
    // TRANSAKSI: DENDA & PELUNASAN
    // =====================================================================
    Route::get('denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('denda/{id}', [DendaController::class, 'show'])->name('denda.show');
    // TRANSAKSI: DENDA & PELUNASAN
    Route::get('denda-export/pdf', [DendaController::class, 'exportPdf'])->name('denda.export.pdf');
    Route::get('denda-export/csv', [DendaController::class, 'exportCsv'])->name('denda.export.csv');
    Route::post('denda/{id}/bayar', [DendaController::class, 'prosesPembayaran'])
        ->middleware('role:Pustakawan')
        ->name('denda.bayar');
});
