<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest('kode_buku')->paginate(10);
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|string|max:20|unique:buku,kode_buku',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_rak' => 'required|string|max:50',
        ], [
            'kode_buku.unique' => 'Kode buku ini sudah ada di database.',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil disimpan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_rak' => 'required|string|max:50',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Informasi buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        // Buku yang sudah pernah masuk transaksi tidak boleh dihapus agar
        // riwayat peminjaman/pengembalian tetap utuh (FK memakai ON DELETE RESTRICT).
        if ($buku->detailPeminjaman()->exists() || $buku->pengembalian()->exists()) {
            return back()->with('error', 'Buku "' . $buku->judul . '" tidak dapat dihapus karena masih memiliki riwayat peminjaman atau pengembalian.');
        }

        try {
            $buku->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Buku tidak dapat dihapus karena masih terkait dengan data transaksi.');
        }

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus dari katalog.');
    }
}