<?php

namespace Tests\Feature;

use App\Models\DetailPeminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesLibraryData;
use Tests\TestCase;

class PeminjamanTest extends TestCase
{
    use CreatesLibraryData, RefreshDatabase;

    public function test_creating_loan_decrements_stock_and_saves_detail(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 5]);

        $response = $this->actingAs($pustakawan)->post(route('peminjaman.store'), [
            'nim' => $mahasiswa->nim,
            'buku' => [
                ['kode_buku' => $buku->kode_buku, 'jumlah' => 2],
            ],
        ]);

        $response->assertRedirect(route('peminjaman.index'));

        $peminjaman = \App\Models\Peminjaman::where('nim', $mahasiswa->nim)->firstOrFail();
        $this->assertSame('Dipinjam', $peminjaman->status);
        $this->assertSame($pustakawan->nip, $peminjaman->nip);
        $this->assertDatabaseHas('detail_peminjaman', [
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'kode_buku' => $buku->kode_buku,
            'jumlah' => 2,
        ]);
        $this->assertSame(3, $buku->fresh()->stok);
    }

    public function test_loan_rejected_when_stock_insufficient(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $mahasiswa = $this->makeMahasiswa();
        $buku = $this->makeBuku(['stok' => 1]);

        $response = $this->actingAs($pustakawan)->from(route('peminjaman.create'))->post(route('peminjaman.store'), [
            'nim' => $mahasiswa->nim,
            'buku' => [
                ['kode_buku' => $buku->kode_buku, 'jumlah' => 2],
            ],
        ]);

        $response->assertRedirect(route('peminjaman.create'));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('peminjaman', 0);
        $this->assertSame(1, $buku->fresh()->stok);
    }

    public function test_loan_form_only_lists_active_students_and_available_books(): void
    {
        $pustakawan = $this->makeUser('Pustakawan');
        $this->makeMahasiswa(['status_aktif' => true]);
        $this->makeMahasiswa(['status_aktif' => false]);
        $this->makeBuku(['stok' => 0]);

        $response = $this->actingAs($pustakawan)->get(route('peminjaman.create'));

        $response->assertOk();
        $response->assertViewHas('mahasiswa', fn ($rows) => $rows->count() === 1);
        $response->assertViewHas('buku', fn ($rows) => $rows->count() === 0);
    }
}
