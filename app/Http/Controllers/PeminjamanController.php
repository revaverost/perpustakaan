<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'user', 'detailPeminjaman.buku'])
            ->latest('id_peminjaman')
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan form transaksi peminjaman baru.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::where('status_aktif', true)->get();
        $buku = Buku::where('stok', '>', 0)->get();

        return view('peminjaman.create', compact('mahasiswa', 'buku'));
    }

    /**
     * Menyimpan transaksi peminjaman baru dengan DB Transaction.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'nim' => 'required|exists:mahasiswa,nim',
            'buku' => 'required|array|min:1',
            'buku.*.kode_buku' => 'required|exists:buku,kode_buku',
            'buku.*.jumlah' => 'required|integer|min:1',
        ], [
            'nim.required' => 'Mahasiswa peminjam wajib dipilih.',
            'nim.exists' => 'Mahasiswa tidak terdaftar.',
            'buku.required' => 'Minimal pilih 1 buku untuk dipinjam.',
            'buku.*.jumlah.min' => 'Jumlah pinjam buku minimal 1.',
        ]);

        // 2. Jalankan Database Transaction
        try {
            DB::transaction(function () use ($request) {
                // Ambil NIP user (Admin/Pustakawan) yang sedang login
                $nipPetugas = Auth::user()->nip ?? $request->nip;

                // A. Buat Header Transaksi Peminjaman
                $tglPinjam = Carbon::now();
                $tglTenggat = $tglPinjam->copy()->addDays(14); // Tenggat otomatis 2 minggu

                $peminjaman = Peminjaman::create([
                    'nim' => $request->nim,
                    'nip' => $nipPetugas,
                    'tgl_pinjam' => $tglPinjam->toDateString(),
                    'tgl_tenggat' => $tglTenggat->toDateString(),
                    'status' => 'Dipinjam',
                ]);

                // B. Loop Detail Buku & Validasi Stok
                foreach ($request->buku as $item) {
                    $buku = Buku::where('kode_buku', $item['kode_buku'])->lockForUpdate()->first();

                    // Validasi Ketersediaan Stok
                    if ($buku->stok < $item['jumlah']) {
                        throw new \Exception("Stok buku '{$buku->judul}' tidak mencukupi. Sisa stok: {$buku->stok}.");
                    }

                    // Simpan Detail Peminjaman
                    DetailPeminjaman::create([
                        'id_peminjaman' => $peminjaman->id_peminjaman,
                        'kode_buku' => $item['kode_buku'],
                        'jumlah' => $item['jumlah'],
                    ]);

                    // Kurangi Stok Buku
                    $buku->decrement('stok', $item['jumlah']);
                }
            });

            return redirect()->route('peminjaman.index')
                ->with('success', 'Transaksi peminjaman berhasil disimpan! Tenggat pengembalian: 14 hari.');
        } catch (\Exception $e) {
            // Transaction otomatis Rollback jika terjadi error/exception
            return back()->withInput()->with('error', 'Gagal memproses peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail transaksi peminjaman tertentu.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'user', 'detailPeminjaman.buku', 'pengembalian.denda'])
            ->findOrFail($id);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function perpanjang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat diperpanjang.');
        }

        // Batasi maksimal perpanjangan (Contoh: maksimal 2 kali)
        if ($peminjaman->jumlah_perpanjang >= 2) {
            return back()->with('error', 'Peminjaman ini sudah mencapai batas maksimal perpanjangan (2 kali).');
        }

        // Tambah 7 hari ke tanggal tenggat & increment jumlah_perpanjang
        $tglTenggatBaru = \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->addDays(7);

        $peminjaman->update([
            'tgl_tenggat' => $tglTenggatBaru,
            'jumlah_perpanjang' => $peminjaman->jumlah_perpanjang + 1,
        ]);

        return back()->with('success', 'Masa peminjaman diperpanjang 7 hari. Total diperpanjang: ' . $peminjaman->jumlah_perpanjang . 'x.');
    }
}
