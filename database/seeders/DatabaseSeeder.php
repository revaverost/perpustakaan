<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Buku;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin & Pustakawan)
        User::updateOrCreate(['nip' => '1992011001'], [
            'nip' => '1992011001',
            'nama' => 'Budi Santoso (Admin)',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'Admin'
        ]);

        User::updateOrCreate(['nip' => '1995031202'], [
            'nip' => '1995031202',
            'nama' => 'Siti Rahma (Pustakawan)',
            'email' => 'pustakawan@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'Pustakawan'
        ]);

        // 2. Seed Mahasiswa
        Mahasiswa::updateOrCreate(['nim' => '230101001'], [
            'nim' => '230101001',
            'nama' => 'Ahmad Rizki',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => '2023',
            'no_hp' => '081234567890',
            'email' => 'rizki@student.ac.id',
            'status_aktif' => true
        ]);

        foreach ([
            ['nim' => '230101002', 'nama' => 'Siti Aisyah', 'jurusan' => 'Sistem Informasi', 'angkatan' => '2023', 'no_hp' => '081234567891', 'email' => 'aisyah@student.ac.id', 'status_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '230101003', 'nama' => 'Dimas Pratama', 'jurusan' => 'Teknik Informatika', 'angkatan' => '2023', 'no_hp' => '081234567892', 'email' => 'dimas@student.ac.id', 'status_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '230101004', 'nama' => 'Nabila Putri', 'jurusan' => 'Manajemen', 'angkatan' => '2023', 'no_hp' => '081234567893', 'email' => 'nabila@student.ac.id', 'status_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '230101005', 'nama' => 'Fajar Maulana', 'jurusan' => 'Akuntansi', 'angkatan' => '2023', 'no_hp' => '081234567894', 'email' => 'fajar@student.ac.id', 'status_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nim' => '230101006', 'nama' => 'Rina Kurniawati', 'jurusan' => 'Ilmu Komunikasi', 'angkatan' => '2023', 'no_hp' => '081234567895', 'email' => 'rina@student.ac.id', 'status_aktif' => true, 'created_at' => now(), 'updated_at' => now()],
        ] as $mahasiswa) {
            Mahasiswa::updateOrCreate(['nim' => $mahasiswa['nim']], $mahasiswa);
        }

        // 3. Seed Buku
        Buku::updateOrCreate(['kode_buku' => '250001'], [
            'kode_buku' => '250001',
            'judul' => 'Pemrograman Web dengan Laravel 10',
            'pengarang' => 'Rian H.',
            'penerbit' => 'Informatika',
            'tahun_terbit' => '2023',
            'kategori' => 'Komputer',
            'stok' => 5,
            'harga' => 150000,
            'lokasi_rak' => 'R-01'
        ]);

        foreach ([
            ['kode_buku' => '250003', 'judul' => 'Basis Data untuk Pemula', 'pengarang' => 'Fathansyah', 'penerbit' => 'Informatika', 'tahun_terbit' => '2021', 'kategori' => 'Komputer', 'stok' => 4, 'harga' => 135000, 'lokasi_rak' => 'R-02', 'created_at' => now(), 'updated_at' => now()],
            ['kode_buku' => '250004', 'judul' => 'Pengantar Jaringan Komputer', 'pengarang' => 'Budi Sutedjo', 'penerbit' => 'Andi Offset', 'tahun_terbit' => '2020', 'kategori' => 'Komputer', 'stok' => 6, 'harga' => 145000, 'lokasi_rak' => 'R-02', 'created_at' => now(), 'updated_at' => now()],
            ['kode_buku' => '250005', 'judul' => 'Manajemen Organisasi Modern', 'pengarang' => 'T. Hani Handoko', 'penerbit' => 'BPFE', 'tahun_terbit' => '2019', 'kategori' => 'Manajemen', 'stok' => 3, 'harga' => 110000, 'lokasi_rak' => 'R-03', 'created_at' => now(), 'updated_at' => now()],
            ['kode_buku' => '250006', 'judul' => 'Akuntansi Keuangan Dasar', 'pengarang' => 'Slamet Sugiri', 'penerbit' => 'UPP STIM YKPN', 'tahun_terbit' => '2022', 'kategori' => 'Akuntansi', 'stok' => 5, 'harga' => 125000, 'lokasi_rak' => 'R-03', 'created_at' => now(), 'updated_at' => now()],
            ['kode_buku' => '250007', 'judul' => 'Metode Penelitian Ilmiah', 'pengarang' => 'Sugiyono', 'penerbit' => 'Alfabeta', 'tahun_terbit' => '2023', 'kategori' => 'Referensi', 'stok' => 4, 'harga' => 95000, 'lokasi_rak' => 'R-04', 'created_at' => now(), 'updated_at' => now()],
        ] as $buku) {
            Buku::updateOrCreate(['kode_buku' => $buku['kode_buku']], $buku);
        }

        Buku::updateOrCreate(['kode_buku' => '250002'], [
            'kode_buku' => '250002',
            'judul' => 'Struktur Data dan Algoritma Dasar',
            'pengarang' => 'Suryadi',
            'penerbit' => 'Andi Offset',
            'tahun_terbit' => '2022',
            'kategori' => 'Komputer',
            'stok' => 3,
            'harga' => 120000,
            'lokasi_rak' => 'R-01'
        ]);

        $this->call(DummyDataSeeder::class);
    }
}
