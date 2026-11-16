<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiPengembalianMail;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;



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
            'buku',
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
        $peminjaman = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku', 'pengembalian'])
            ->where('status', 'Dipinjam')
            ->findOrFail($id_peminjaman);

        // Daftar kode_buku yang sudah pernah dikembalikan pada transaksi ini
        $kodeBukuSudahKembali = $peminjaman->pengembalian->pluck('kode_buku')->toArray();

        return view('pengembalian.create', compact('peminjaman', 'kodeBukuSudahKembali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'          => 'required|exists:peminjaman,id_peminjaman',
            'tgl_kembali'            => 'required|date',
            'items'                  => 'required|array|min:1',
            'items.*.dipilih'        => 'nullable|boolean',
            'items.*.kode_buku'      => 'required|exists:buku,kode_buku',
            'items.*.kondisi'        => 'required_if:items.*.dipilih,1|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'items.*.denda_fisik'    => 'required_if:items.*.dipilih,1|numeric|min:0',
            'items.*.keterangan'     => 'nullable|string|max:255',
        ]);

        $selectedItems = collect($request->items)->filter(function ($item) {
            return isset($item['dipilih']) && $item['dipilih'] == '1';
        });

        if ($selectedItems->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors(['items' => 'Pilih minimal satu buku yang akan dikembalikan.']);
        }

        $peminjamanValidasi = Peminjaman::with(['detailPeminjaman', 'pengembalian'])
            ->findOrFail($request->id_peminjaman);

        if ($peminjamanValidasi->status !== 'Dipinjam') {
            return back()
                ->withInput()
                ->with('error', 'Transaksi peminjaman ini sudah selesai dan tidak dapat diproses kembali.');
        }

        $kodeDipinjam = $peminjamanValidasi->detailPeminjaman->pluck('kode_buku')->all();
        $kodeSudahKembali = $peminjamanValidasi->pengembalian->pluck('kode_buku')->all();

        foreach ($selectedItems as $item) {
            if (! in_array($item['kode_buku'], $kodeDipinjam, true)) {
                return back()
                    ->withInput()
                    ->with('error', 'Buku dengan kode ' . $item['kode_buku'] . ' bukan bagian dari peminjaman ini.');
            }

            if (in_array($item['kode_buku'], $kodeSudahKembali, true)) {
                return back()
                    ->withInput()
                    ->with('error', 'Buku dengan kode ' . $item['kode_buku'] . ' sudah pernah dikembalikan.');
            }
        }

        $hasilTransaksi = DB::transaction(function () use ($request, $selectedItems) {
            $peminjaman = Peminjaman::with(['detailPeminjaman', 'pengembalian'])
                ->findOrFail($request->id_peminjaman);

            $kodeSudahKembali = $peminjaman->pengembalian->pluck('kode_buku')->toArray();

            $tglTenggat = \Carbon\Carbon::parse($peminjaman->tgl_tenggat)->startOfDay();
            $tglKembali = \Carbon\Carbon::parse($request->tgl_kembali)->startOfDay();

            $terlambatHari = $tglKembali->gt($tglTenggat) ? $tglTenggat->diffInDays($tglKembali) : 0;
            $tarifPerHari = 1000;
            $dendaTerlambat = $terlambatHari * $tarifPerHari;

            $totalDendaFisik = 0;
            $alasanDenda = [];
            $pengembalianBaruIds = [];

            if ($terlambatHari > 0) {
                $alasanDenda[] = 'Terlambat';
            }

            foreach ($selectedItems as $item) {
                if (in_array($item['kode_buku'], $kodeSudahKembali)) {
                    continue;
                }

                $pengembalian = Pengembalian::create([
                    'id_peminjaman'      => $peminjaman->id_peminjaman,
                    'kode_buku'          => $item['kode_buku'],
                    'nip'                => auth()->user()->nip,
                    'tgl_kembali'        => $request->tgl_kembali,
                    'terlambat_hari'     => $terlambatHari,
                    'kondisi'            => $item['kondisi'],
                    'keterangan_kondisi' => $item['keterangan'] ?? null,
                ]);

                $pengembalianBaruIds[] = $pengembalian->id_pengembalian;
                $totalDendaFisik += (float) $item['denda_fisik'];

                if ($item['kondisi'] !== 'Baik') {
                    $labelKondisi = str_contains($item['kondisi'], 'Rusak') ? 'Rusak' : $item['kondisi'];
                    if (!in_array($labelKondisi, $alasanDenda)) {
                        $alasanDenda[] = $labelKondisi;
                    }
                }

                if ($item['kondisi'] !== 'Hilang') {
                    $detail = $peminjaman->detailPeminjaman->where('kode_buku', $item['kode_buku'])->first();
                    $qty = $detail ? $detail->jumlah : 1;
                    Buku::where('kode_buku', $item['kode_buku'])->increment('stok', $qty);
                }
            }

            $totalJumlahDenda = $dendaTerlambat + $totalDendaFisik;
            $dendaBaru = null;

            if ($totalJumlahDenda > 0 && !empty($pengembalianBaruIds)) {
                $dendaBaru = Denda::create([
                    'id_pengembalian' => $pengembalianBaruIds[0],
                    'nip'             => auth()->user()->nip,
                    'denda_terlambat' => $dendaTerlambat,
                    'denda_fisik'     => $totalDendaFisik,
                    'jumlah_denda'    => $totalJumlahDenda,
                    'status_bayar'    => 'Belum Lunas',
                    'keterangan'      => Str::limit(implode(', ', $alasanDenda), 50, ''),
                ]);
            }

            $totalBukuDipinjam = $peminjaman->detailPeminjaman->pluck('kode_buku')->unique()->count();
            $totalBukuDikembalikan = Pengembalian::where('id_peminjaman', $peminjaman->id_peminjaman)
                ->pluck('kode_buku')
                ->unique()
                ->count();

            if ($totalBukuDikembalikan >= $totalBukuDipinjam) {
                $peminjaman->update(['status' => 'Selesai']);
            }

            return [
                'id_peminjaman'       => $peminjaman->id_peminjaman,
                'pengembalianBaruIds' => $pengembalianBaruIds,
                'dendaBaru'           => $dendaBaru,
            ];
        });

        // Kirim email bukti pengembalian setelah database sukses di-commit
        if (!empty($hasilTransaksi['pengembalianBaruIds'])) {
            $peminjamanLengkap = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku', 'pengembalian'])
                ->find($hasilTransaksi['id_peminjaman']);

            $daftarBukuKembali = Pengembalian::with('buku')
                ->whereIn('id_pengembalian', $hasilTransaksi['pengembalianBaruIds'])
                ->get();

            // Hitung sisa buku yang belum dikembalikan (jika pengembalian parsial)
            $kodeSemuaKembali = $peminjamanLengkap->pengembalian->pluck('kode_buku')->toArray();
            $sisaBukuBelumKembali = $peminjamanLengkap->detailPeminjaman->reject(function ($detail) use ($kodeSemuaKembali) {
                return in_array($detail->kode_buku, $kodeSemuaKembali);
            });

            if ($peminjamanLengkap && !empty($peminjamanLengkap->mahasiswa->email)) {
                try {
                    Mail::to($peminjamanLengkap->mahasiswa->email)
                        ->send(new NotifikasiPengembalianMail(
                            $peminjamanLengkap,
                            $daftarBukuKembali,
                            $hasilTransaksi['dendaBaru'],
                            $sisaBukuBelumKembali
                        ));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email bukti pengembalian: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian buku berhasil diproses.');
    }

    public function exportPdf()
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.mahasiswa',
            'buku',
            'user',
            'denda'
        ])->latest()->get();

        $pdf = Pdf::loadView('pengembalian.pdf', compact('pengembalian'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengembalian-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportCsv()
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.mahasiswa',
            'buku',
            'user',
            'denda'
        ])->latest()->get();

        $fileName = 'laporan-pengembalian-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($pengembalian) {
            $file = fopen('php://output', 'w');

            // Header Kolom CSV
            fputcsv($file, [
                'ID Kembali',
                'ID Pinjam',
                'NIM',
                'Nama Peminjam',
                'Tanggal Kembali',
                'Keterlambatan (Hari)',
                'Kondisi Fisik Buku',
                'Petugas Penerima',
                'Total Denda (Rp)',
                'Status Denda'
            ]);

            // Isi Baris Data
            foreach ($pengembalian as $k) {
                $judul = $k->buku->judul ?? $k->kode_buku;
                $kondisiText = "[{$k->kode_buku}] {$judul}: {$k->kondisi}";

                fputcsv($file, [
                    '#' . $k->id_pengembalian,
                    '#' . $k->id_peminjaman,
                    $k->peminjaman->nim ?? '-',
                    $k->peminjaman->mahasiswa->nama ?? '-',
                    $k->tgl_kembali,
                    $k->terlambat_hari,
                    $kondisiText ?: '-',
                    $k->user->nama ?? $k->nip,
                    $k->denda ? $k->denda->jumlah_denda : 0,
                    $k->denda ? $k->denda->status_bayar : 'Tidak Ada Denda',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
