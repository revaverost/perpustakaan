<?php

namespace App\Http\Controllers;

use App\Mail\NotifikasiPelunasanDendaMail;
use App\Models\Denda;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DendaController extends Controller
{
    /**
     * Menampilkan daftar tagihan denda dengan filter status bayar.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'Belum Lunas');

        $query = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
        ])->latest('id_denda');

        if (in_array($status, ['Belum Lunas', 'Lunas'])) {
            $query->where('status_bayar', $status);
        } else {
            $status = 'Semua';
        }

        $denda = $query->paginate(10)->appends($request->query());

        return view('denda.index', compact('denda', 'status'));
    }

    /**
     * Menampilkan detail tagihan denda dan daftar buku yang rusak/hilang.
     */
    public function show($id)
    {
        $denda = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
            'pengembalian.buku',
            'pengembalian.user',
        ])->findOrFail($id);

        // Ambil daftar buku pada sesi pengembalian tersebut yang kondisinya tidak Baik (rusak/hilang)
        $bukuBermasalah = collect();
        if ($denda->pengembalian) {
            $bukuBermasalah = Pengembalian::with('buku')
                ->where('id_peminjaman', $denda->pengembalian->id_peminjaman)
                ->where('tgl_kembali', $denda->pengembalian->tgl_kembali)
                ->where('kondisi', '!=', 'Baik')
                ->get();
        }

        return view('denda.show', compact('denda', 'bukuBermasalah'));
    }

    /**
     * Memproses pembayaran/pelunasan denda oleh Pustakawan & kirim bukti pelunasan via email.
     */
    public function prosesPembayaran(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:Tunai,Transfer,QRIS',
        ]);

        $denda = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
            'pengembalian.buku',
        ])->findOrFail($id);

        if ($denda->status_bayar === 'Lunas') {
            return redirect()
                ->route('denda.show', $denda->id_denda)
                ->with('info', 'Tagihan denda ini sudah berstatus Lunas.');
        }

        $denda->update([
            'status_bayar' => 'Lunas',
            'tgl_bayar'    => now(),
            'metode_bayar' => $request->metode_bayar,
        ]);

        // Ambil daftar buku bermasalah untuk rincian kuitansi jika ada denda fisik
        $bukuBermasalah = collect();
        if ($denda->denda_fisik > 0 && $denda->pengembalian) {
            $bukuBermasalah = Pengembalian::with('buku')
                ->where('id_peminjaman', $denda->pengembalian->id_peminjaman)
                ->where('tgl_kembali', $denda->pengembalian->tgl_kembali)
                ->where('kondisi', '!=', 'Baik')
                ->get();
        }

        // Kirim email kuitansi pelunasan ke mahasiswa
        $emailMahasiswa = $denda->pengembalian->peminjaman->mahasiswa->email ?? null;
        if (!empty($emailMahasiswa)) {
            try {
                Mail::to($emailMahasiswa)
                    ->send(new NotifikasiPelunasanDendaMail($denda, $bukuBermasalah));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email bukti pelunasan denda #' . $denda->id_denda . ': ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('denda.index', ['status' => 'Lunas'])
            ->with('success', 'Pembayaran denda #' . $denda->id_denda . ' berhasil diproses.');
    }

    /**
     * Export laporan data denda ke format PDF.
     */
    public function exportPdf(Request $request)
    {
        $status = $request->query('status', 'Semua');

        $query = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
        ])->latest('id_denda');

        if (in_array($status, ['Belum Lunas', 'Lunas'])) {
            $query->where('status_bayar', $status);
        } else {
            $status = 'Semua';
        }

        $denda = $query->get();

        $pdf = Pdf::loadView('denda.pdf', compact('denda', 'status'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-denda-' . strtolower(str_replace(' ', '-', $status)) . '-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export laporan data denda ke format CSV.
     */
    public function exportCsv(Request $request)
    {
        $status = $request->query('status', 'Semua');

        $query = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
        ])->latest('id_denda');

        if (in_array($status, ['Belum Lunas', 'Lunas'])) {
            $query->where('status_bayar', $status);
        } else {
            $status = 'Semua';
        }

        $denda = $query->get();
        $fileName = 'laporan-denda-' . strtolower(str_replace(' ', '-', $status)) . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($denda) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID Denda',
                'ID Pinjam',
                'NIM',
                'Nama Mahasiswa',
                'Keterlambatan (Hari)',
                'Denda Terlambat (Rp)',
                'Denda Fisik (Rp)',
                'Total Denda (Rp)',
                'Status Bayar',
                'Keterangan',
                'Tanggal Bayar',
                'Metode Bayar',
            ]);

            foreach ($denda as $d) {
                fputcsv($file, [
                    '#' . $d->id_denda,
                    '#' . ($d->pengembalian->id_peminjaman ?? '-'),
                    $d->pengembalian->peminjaman->nim ?? '-',
                    $d->pengembalian->peminjaman->mahasiswa->nama ?? '-',
                    $d->pengembalian->terlambat_hari ?? 0,
                    $d->denda_terlambat,
                    $d->denda_fisik,
                    $d->jumlah_denda,
                    $d->status_bayar,
                    $d->keterangan ?? '-',
                    $d->tgl_bayar ? \Carbon\Carbon::parse($d->tgl_bayar)->format('d/m/Y H:i') : '-',
                    $d->metode_bayar ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}