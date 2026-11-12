<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiPeminjamanMail;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman aktif.
     */
    public function index(Request $request)
    {
        $query = $this->filteredQuery($request);
        $peminjaman = (clone $query)
            ->with(['pengembalian'])
            ->where('status', 'Dipinjam')
            ->latest('id_peminjaman')
            ->paginate(10)
            ->appends($request->query());

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Export laporan peminjaman ke format PDF.
     */
    public function exportPdf(Request $request)
    {
        $peminjaman = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku', 'user'])
            ->latest('id_peminjaman')
            ->get();

        $pdf = Pdf::loadView('peminjaman.export-pdf', compact('peminjaman'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export laporan peminjaman ke format CSV.
     */
    public function exportCsv(Request $request)
    {
        $peminjaman = $this->filteredQuery($request)->latest('id_peminjaman')->get();
        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($peminjaman) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'NIM', 'Nama Anggota', 'Buku', 'Tanggal Pinjam', 'Tenggat', 'Petugas', 'Status']);
            foreach ($peminjaman as $item) {
                fputcsv($handle, [
                    $item->id_peminjaman,
                    $item->nim,
                    $item->mahasiswa->nama ?? '-',
                    $item->detailPeminjaman->map(fn($detail) => ($detail->buku->judul ?? $detail->kode_buku) . ' (x' . $detail->jumlah . ')')->implode('; '),
                    $item->tgl_pinjam,
                    $item->tgl_tenggat,
                    $item->user->nama ?? $item->nip,
                    $item->status,
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filteredQuery(Request $request)
    {
        return Peminjaman::with(['mahasiswa', 'user', 'detailPeminjaman.buku'])
            ->when($request->filled('tanggal_mulai'), fn($query) => $query->whereDate('tgl_pinjam', '>=', $request->tanggal_mulai))
            ->when($request->filled('tanggal_akhir'), fn($query) => $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir));
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
     * Menyimpan transaksi peminjaman baru dengan DB Transaction dan mengirim email notifikasi.
     */
    public function store(Request $request)
    {
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

        try {
            $peminjaman = DB::transaction(function () use ($request) {
                $nipPetugas = Auth::user()->nip ?? $request->nip;
                $tglPinjam = Carbon::now();
                $tglTenggat = $tglPinjam->copy()->addDays(14);

                $pinjam = Peminjaman::create([
                    'nim' => $request->nim,
                    'nip' => $nipPetugas,
                    'tgl_pinjam' => $tglPinjam->toDateString(),
                    'tgl_tenggat' => $tglTenggat->toDateString(),
                    'status' => 'Dipinjam',
                ]);

                foreach ($request->buku as $item) {
                    $buku = Buku::where('kode_buku', $item['kode_buku'])->lockForUpdate()->first();

                    if ($buku->stok < $item['jumlah']) {
                        throw new \Exception("Stok buku '{$buku->judul}' tidak mencukupi. Sisa stok: {$buku->stok}.");
                    }

                    DetailPeminjaman::create([
                        'id_peminjaman' => $pinjam->id_peminjaman,
                        'kode_buku' => $item['kode_buku'],
                        'jumlah' => $item['jumlah'],
                    ]);

                    $buku->decrement('stok', $item['jumlah']);
                }

                return $pinjam;
            });

            // Kirim notifikasi email setelah transaksi database sukses di-commit
            $peminjamanBaru = Peminjaman::with(['mahasiswa', 'detailPeminjaman.buku', 'user'])
                ->find($peminjaman->id_peminjaman);

            if ($peminjamanBaru && !empty($peminjamanBaru->mahasiswa->email)) {
                try {
                    Mail::to($peminjamanBaru->mahasiswa->email)
                        ->send(new NotifikasiPeminjamanMail($peminjamanBaru));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email bukti peminjaman: ' . $e->getMessage());
                }
            }

            return redirect()->route('peminjaman.index')
                ->with('success', 'Transaksi peminjaman berhasil disimpan! Tenggat pengembalian: 14 hari.');
        } catch (\Exception $e) {
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

    /**
     * Memperpanjang tenggat waktu peminjaman selama 7 hari (maksimal 2 kali).
     */
    public function perpanjang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat diperpanjang.');
        }

        if ($peminjaman->jumlah_perpanjang >= 2) {
            return back()->with('error', 'Peminjaman ini sudah mencapai batas maksimal perpanjangan (2 kali).');
        }

        $tglTenggatBaru = Carbon::parse($peminjaman->tgl_tenggat)->addDays(7);

        $peminjaman->update([
            'tgl_tenggat' => $tglTenggatBaru,
            'jumlah_perpanjang' => $peminjaman->jumlah_perpanjang + 1,
        ]);

        return back()->with('success', 'Masa peminjaman diperpanjang 7 hari. Total diperpanjang: ' . $peminjaman->jumlah_perpanjang . 'x.');
    }
}
