<?php

namespace Tests\Feature;

use App\Models\Denda;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class DendaTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    private function makeDenda($pustakawan, $mahasiswa, $buku): Denda
    {
        $peminjaman = Peminjaman::create([
            'nim' => $mahasiswa->nim,
            'nip' => $pustakawan->nip,
            'tgl_pinjam' => now()->subDays(20)->toDateString(),
            'tgl_tenggat' => now()->subDays(5)->toDateString(),
            'status' => 'Selesai',
        ]);

        DetailPeminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'jumlah' => 1,
        ]);

        $pengembalian = Pengembalian::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'nip' => $pustakawan->nip,
            'tgl_kembali' => now()->toDateString(),
            'terlambat_hari' => 5,
        ]);

        return Denda::create([
            'id_pengembalian' => $pengembalian->id_pengembalian,
            'nip' => $pustakawan->nip,
            'jumlah_denda' => 5000,
            'status_bayar' => 'Belum Lunas',
            'keterangan' => 'Terlambat',
        ]);
    }

    public function test_pustakawan_can_mark_fine_as_paid(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku();
        $denda = $this->makeDenda($pustakawan, $mahasiswa, $buku);

        $response = $this->actingAs($pustakawan)->post(route('denda.bayar', $denda->id_denda), [
            'metode_bayar' => 'QRIS',
        ]);

        $response->assertRedirect(route('denda.index', ['status' => 'Lunas']));
        $denda->refresh();
        $this->assertSame('Lunas', $denda->status_bayar);
        $this->assertSame('QRIS', $denda->metode_bayar);
        $this->assertNotNull($denda->tgl_bayar);
    }

    public function test_admin_cannot_mark_fine_as_paid(): void
    {
        $admin = $this->makeUser('Admin');
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku();
        $denda = $this->makeDenda($pustakawan, $mahasiswa, $buku);

        $this->actingAs($admin)->post(route('denda.bayar', $denda->id_denda), [
            'metode_bayar' => 'Tunai',
        ])->assertForbidden();

        $this->assertSame('Belum Lunas', $denda->fresh()->status_bayar);
    }

    public function test_fine_cannot_be_paid_twice(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku();
        $denda = $this->makeDenda($pustakawan, $mahasiswa, $buku);
        $denda->update(['status_bayar' => 'Lunas', 'tgl_bayar' => now(), 'metode_bayar' => 'Tunai']);

        $response = $this->actingAs($pustakawan)->from(route('denda.show', $denda->id_denda))->post(route('denda.bayar', $denda->id_denda), [
            'metode_bayar' => 'Transfer',
        ]);

        $response->assertSessionHas('info');
        $this->assertSame('Tunai', $denda->fresh()->metode_bayar);
    }
}
