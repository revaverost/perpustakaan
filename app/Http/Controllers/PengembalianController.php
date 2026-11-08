<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\KondisiBukuKembali;
use App\Models\Denda;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengembalian buku
     */
    public function index()
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.mahasiswa',
            'user',
            'kondisiBukuKembali.buku',
            'denda'
        ])
            ->latest('id_pengembalian')
            ->paginate(10);

        return view('pengembalian.index', compact('pengembalian'));
    }

    /**
     * Menampilkan form proses pengembalian berdasarkan ID Peminjaman
     */
    public function create($id_peminjaman)
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku'])->findOrFail($id_peminjaman);

        // Jika transaksi sudah selesai, kembalikan ke index
        if ($peminjaman->status === 'Selesai') {
            return redirect()->route('peminjaman.index')->with('error', 'Transaksi peminjaman ini sudah selesai diserahkan.');
        }

        // Kalkulasi estimasi denda keterlambatan (Rp 1.000 / hari)
        $tglKembali = Carbon::now();
        $tglTenggat = Carbon::parse($peminjaman->tgl_tenggat);

        $terlambatHari = $tglKembali->greaterThan($tglTenggat) ? $tglKembali->diffInDays($tglTenggat) : 0;
        $estimasiDenda = $terlambatHari * 1000;

        return view('pengembalian.create', compact('peminjaman', 'tglKembali', 'terlambatHari', 'estimasiDenda'));
    }

    /**
     * Menyimpan transaksi pengembalian dan menghitung total denda
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
            'tgl_kembali' => 'required|date',
            'kondisi' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detailPeminjaman.buku')->findOrFail($request->id_peminjaman);
            $tglKembali = Carbon::parse($request->tgl_kembali);
            $tglTenggat = Carbon::parse($peminjaman->tgl_tenggat);

            // 1. Hitung Hari Keterlambatan (Rp 1.000 / hari)
            $terlambatHari = $tglKembali->greaterThan($tglTenggat) ? $tglKembali->diffInDays($tglTenggat) : 0;
            $dendaTelat = $terlambatHari * 1000;

            // 2. Simpan Transaksi Utama Pengembalian
            $pengembalian = Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tgl_kembali' => $tglKembali->format('Y-m-d'),
                'terlambat_hari' => $terlambatHari,
                'nip' => Auth::user()->nip,
            ]);

            $totalDendaFisik = 0;

            // 3. Loop Pengecekan Kondisi Fisik Tiap Buku
            foreach ($request->kondisi as $item) {
                $buku = Buku::where('kode_buku', $item['kode_buku'])->first();
                $dendaBukuIni = 0;
                $statusKondisi = $item['status'];

                // Jika HILANG -> denda seharga buku (diambil dari kolom harga tabel buku)
                if ($statusKondisi === 'Hilang') {
                    $dendaBukuIni = $buku ? $buku->harga : (float) ($item['denda_fisik'] ?? 0);
                } else {
                    $dendaBukuIni = (float) ($item['denda_fisik'] ?? 0);
                }

                $totalDendaFisik += $dendaBukuIni;

                // Catat detail kondisi buku kembali
                KondisiBukuKembali::create([
                    'id_pengembalian' => $pengembalian->id_pengembalian,
                    'kode_buku' => $item['kode_buku'],
                    'kondisi' => $statusKondisi,
                    'denda_fisik' => $dendaBukuIni,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                // Tambahkan kembali stok buku HANYA jika fisik buku TIDAK hilang
                if ($statusKondisi !== 'Hilang' && $buku) {
                    $detail = $peminjaman->detailPeminjaman->where('kode_buku', $item['kode_buku'])->first();
                    $buku->increment('stok', $detail ? $detail->jumlah : 1);
                }
            }

            // 4. Update status transaksi peminjaman menjadi Selesai
            $peminjaman->update(['status' => 'Selesai']);

            // 5. Buat tagihan denda jika ada akumulasi denda telat atau denda fisik
            // 5. Buat tagihan denda jika ada total denda
            $totalDenda = $dendaTelat + $totalDendaFisik;

            if ($totalDenda > 0) {
                $alasan = [];

                // Cek jika ada denda keterlambatan
                if ($dendaTelat > 0) {
                    $alasan[] = 'Terlambat';
                }

                // Cek daftar kondisi fisik buku yang memicu denda
                $detailDendaFisik = KondisiBukuKembali::where('id_pengembalian', $pengembalian->id_pengembalian)
                    ->where('denda_fisik', '>', 0)
                    ->get();

                foreach ($detailDendaFisik as $df) {
                    if ($df->kondisi === 'Hilang') {
                        $alasan[] = 'Hilang';
                    } elseif (in_array($df->kondisi, ['Rusak Ringan', 'Rusak Berat'])) {
                        $alasan[] = 'Rusak';
                    }
                }

                // Hapus kata duplikat dan gabungkan dengan koma
                // Contoh hasil: "Terlambat", "Hilang", atau "Terlambat, Rusak"
                $keteranganSingkat = implode(', ', array_unique($alasan));

                Denda::create([
                    'id_pengembalian' => $pengembalian->id_pengembalian,
                    'jumlah_denda'    => $totalDenda,
                    'status_bayar'    => 'Belum Lunas',
                    'keterangan'      => $keteranganSingkat,
                    'nip'             => Auth::user()->nip,
                ]);
            }

            DB::commit();
            return redirect()->route('pengembalian.index')->with('success', 'Pengembalian buku berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}
