<?php

namespace Tests\Support;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait CreatesLibraryData
{
    protected static int $counter = 0;

    protected function makeUser(string $role = 'Pustakawan'): User
    {
        $urut = ++static::$counter;

        return User::create([
            'nip' => str_pad((string) (9000000000 + $urut), 10, '0', STR_PAD_LEFT),
            'nama' => ucfirst($role) . ' ' . $urut,
            'email' => strtolower($role) . $urut . '@example.test',
            'password' => Hash::make('password123'),
            'role' => $role,
        ]);
    }

    protected function makeMahasiswa(array $attributes = []): Mahasiswa
    {
        $urut = ++static::$counter;

        return Mahasiswa::create(array_merge([
            'nim' => '23010' . str_pad((string) $urut, 4, '0', STR_PAD_LEFT),
            'nama' => 'Mahasiswa ' . $urut,
            'jurusan' => 'Teknik Informatika',
            'angkatan' => '2023',
            'no_hp' => '081200000000',
            'email' => 'mahasiswa' . $urut . '@example.test',
            'status_aktif' => true,
        ], $attributes));
    }

    protected function makeBuku(array $attributes = []): Buku
    {
        $urut = ++static::$counter;

        return Buku::create(array_merge([
            'kode_buku' => '90' . str_pad((string) $urut, 4, '0', STR_PAD_LEFT),
            'judul' => 'Buku Uji ' . $urut,
            'pengarang' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => '2024',
            'kategori' => 'Komputer',
            'stok' => 5,
            'harga' => 100000,
            'lokasi_rak' => 'R-01',
        ], $attributes));
    }
}
