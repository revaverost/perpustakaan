<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('stok');
        $totalMahasiswa = Mahasiswa::where('status_aktif', true)->count();
        $peminjamanAktif = Peminjaman::where('status', 'Dipinjam')->count();
        $totalDendaLunas = Denda::where('status_bayar', 'Lunas')->sum('jumlah_denda');

        return view('dashboard', compact('totalBuku', 'totalMahasiswa', 'peminjamanAktif', 'totalDendaLunas'));
    }
}