<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DendaController extends Controller
{
    /**
     * Menampilkan daftar denda dengan pencarian dan filter status.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'Belum Lunas');

        $denda = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
            'user'
        ])
            ->when($status !== 'Semua', function ($query) use ($status) {
                return $query->where('status_bayar', $status);
            })
            ->latest('id_denda')
            ->paginate(10);

        return view('denda.index', compact('denda', 'status'));
    }

    /**
     * Menampilkan detail denda beserta rincian peminjaman dan buku.
     */
    public function show($id)
    {
        $denda = Denda::with([
            'pengembalian.peminjaman.mahasiswa',
            'pengembalian.peminjaman.detailPeminjaman.buku',
            'pengembalian.kondisiBukuKembali.buku',
            'user'
        ])->findOrFail($id);

        return view('denda.show', compact('denda'));
    }

    /**
     * Memproses pelunasan denda (Pembayaran Tunai, QRIS, atau Transfer).
     */
    public function prosesPembayaran(Request $request, $id)
    {
        // 1. Validasi Input Pembayaran
        $request->validate([
            'metode_bayar' => 'required|in:Tunai,QRIS,Transfer',
        ], [
            'metode_bayar.required' => 'Metode pembayaran wajib dipilih.',
            'metode_bayar.in' => 'Metode pembayaran tidak valid.',
        ]);

        $denda = Denda::findOrFail($id);

        // 2. Cek apakah denda sudah lunas sebelumnya
        if ($denda->status_bayar === 'Lunas') {
            return back()->with('error', 'Denda ini sudah berstatus Lunas.');
        }

        // 3. Update Status Pelunasan
        $nipPetugas = Auth::user()->nip ?? $request->nip;

        $denda->update([
            'status_bayar' => 'Lunas',
            'tgl_bayar' => Carbon::now(),
            'metode_bayar' => $request->metode_bayar,
            'nip' => $nipPetugas, // NIP petugas yang melayani pembayaran
        ]);

        return redirect()->route('denda.index')
            ->with('success', "Pelunasan denda sebesar Rp " . number_format($denda->jumlah_denda, 0, ',', '.') . " berhasil diproses!");
    }
}
