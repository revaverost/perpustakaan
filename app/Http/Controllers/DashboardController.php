<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Denda;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::sum('stok');
        $totalMahasiswa = Mahasiswa::where('status_aktif', true)->count();
        $peminjamanAktif = Peminjaman::where('status', 'Dipinjam')->count();
        $totalDenda = Denda::sum('jumlah_denda');

        $startDate = Carbon::today()->subDays(6);
        $loanTrend = Peminjaman::query()
            ->whereDate('tgl_pinjam', '>=', $startDate)
            ->selectRaw('DATE(tgl_pinjam) as tanggal, COUNT(*) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $trendLabels = [];
        $trendValues = [];
        for ($date = $startDate->copy(); $date->lte(Carbon::today()); $date->addDay()) {
            $key = $date->toDateString();
            $trendLabels[] = $date->translatedFormat('d M');
            $trendValues[] = (int) ($loanTrend[$key] ?? 0);
        }

        $activities = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku'])
            ->latest('tgl_pinjam')->latest('id_peminjaman')->take(10)->get();

        return view('dashboard', compact('totalBuku', 'totalMahasiswa', 'peminjamanAktif', 'totalDenda', 'trendLabels', 'trendValues', 'activities'));
    }
}
