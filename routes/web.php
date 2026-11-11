<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DendaController;

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
});

// =========================================================================
// ROUTE AUTHENTICATED (Wajib Login Petugas/Admin)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Utamss
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // MASTER DATA: Buku & Mahasiswa
    Route::resource('buku', BukuController::class)->except(['show']);
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show'])->middleware('role:Admin');

    // MASTER DATA: User/Petugas (Pengaturan Akses Admin)
    Route::resource('user', UserController::class)->except(['show']);

    // TRANSAKSI: Peminjaman Buku
    // Admin hanya dapat melihat/export data peminjaman. Mutasi hanya untuk Pustakawan.
    Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'show']);
    Route::resource('peminjaman', PeminjamanController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('role:Pustakawan');
    Route::get('peminjaman-export/pdf', [PeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
    Route::get('peminjaman-export/csv', [PeminjamanController::class, 'exportCsv'])->name('peminjaman.export.csv');
    Route::post('peminjaman/{id}/perpanjang', [PeminjamanController::class, 'perpanjang'])->middleware('role:Pustakawan')->name('peminjaman.perpanjang');

    // TRANSAKSI: Pengembalian Buku
    Route::get('pengembalian/create/{id_peminjaman}', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::resource('pengembalian', PengembalianController::class)->except(['create']);

    // TRANSAKSI: Denda & Pelunasan
    Route::get('denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('denda/{id}', [DendaController::class, 'show'])->name('denda.show');
    Route::post('denda/{id}/bayar', [DendaController::class, 'prosesPembayaran'])->name('denda.bayar');
});
