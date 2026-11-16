<?php

namespace Tests\Feature;

use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class PengembalianTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    private function makeLoan($pustakawan, $mahasiswa, $buku, int $jumlah = 1, int $terlambatHari = 5): Peminjaman
    {
        $peminjaman = Peminjaman::create([
            'nim' => $mahasiswa->nim,
            'nip' => $pustakawan->nip,
            'tgl_pinjam' => now()->subDays(20)->toDateString(),
            'tgl_tenggat' => now()->subDays($terlambatHari)->toDateString(),
            'status' => 'Dipinjam',
        ]);

        DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'jumlah' => $jumlah,
        ]);

        $buku->decrement('stok', $jumlah);

        return $peminjaman;
    }

    public function test_return_restores_stock_and_creates_late_fine(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 5, 'harga' => 100000]);
        $peminjaman = $this->makeLoan($pustakawan, $mahasiswa, $buku, 1, 5);

        $response = $this->actingAs($pustakawan)->post(route('pengembalian.store'), [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_kembali' => now()->toDateString(),
            'items' => [
                ['dipilih' => '1', 'kode_buku' => $buku->kode_buku, 'kondisi' => 'Baik', 'denda_fisik' => 0],
            ],
        ]);

        $response->assertRedirect(route('pengembalian.index'));
        $this->assertSame('Selesai', $peminjaman->fresh()->status);
        $this->assertSame(5, $buku->fresh()->stok);
        $this->assertDatabaseHas('pengembalian', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'terlambat_hari' => 5,
        ]);
        $pengembalian = \App\Models\Pengembalian::where('id_peminjaman', $peminjaman->id_peminjaman)->firstOrFail();
        $this->assertDatabaseHas('denda', [
            'id_pengembalian' => $pengembalian->id_pengembalian,
            'jumlah_denda' => 5000,
            'status_bayar' => 'Belum Lunas',
        ]);
    }

    public function test_lost_book_is_not_returned_to_stock_and_charged_full_price(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 5, 'harga' => 120000]);
        $peminjaman = $this->makeLoan($pustakawan, $mahasiswa, $buku, 1, 0);

        $response = $this->actingAs($pustakawan)->post(route('pengembalian.store'), [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_kembali' => now()->toDateString(),
            'items' => [
                ['dipilih' => '1', 'kode_buku' => $buku->kode_buku, 'kondisi' => 'Hilang', 'denda_fisik' => 120000],
            ],
        ]);

        $response->assertRedirect(route('pengembalian.index'));
        $this->assertSame(4, $buku->fresh()->stok);
        $this->assertDatabaseHas('denda', ['jumlah_denda' => 120000]);
    }

    public function test_book_outside_the_loan_is_rejected(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 5]);
        $bukuLain = $this->makeBuku(['stok' => 5]);
        $peminjaman = $this->makeLoan($pustakawan, $mahasiswa, $buku);

        $response = $this->actingAs($pustakawan)->from(route('pengembalian.create', $peminjaman->id_peminjaman))->post(route('pengembalian.store'), [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_kembali' => now()->toDateString(),
            'items' => [
                ['dipilih' => '1', 'kode_buku' => $bukuLain->kode_buku, 'kondisi' => 'Baik', 'denda_fisik' => 0],
            ],
        ]);

        $response->assertRedirect(route('pengembalian.create', $peminjaman->id_peminjaman));
        $response->assertSessionHas('error');
        $this->assertSame('Dipinjam', $peminjaman->fresh()->status);
        $this->assertDatabaseCount('pengembalian', 0);
    }

    public function test_cannot_return_the_same_loan_twice(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 5]);
        $peminjaman = $this->makeLoan($pustakawan, $mahasiswa, $buku);
        $peminjaman->update(['status' => 'Selesai']);

        $response = $this->actingAs($pustakawan)->post(route('pengembalian.store'), [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tgl_kembali' => now()->toDateString(),
            'items' => [
                ['dipilih' => '1', 'kode_buku' => $buku->kode_buku, 'kondisi' => 'Baik', 'denda_fisik' => 0],
            ],
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('pengembalian', 0);
    }
}
