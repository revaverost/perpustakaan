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
        User::create([
            'nip' => '1992011001',
            'nama' => 'Budi Santoso (Admin)',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'Admin'
        ]);

        User::create([
            'nip' => '1995031202',
            'nama' => 'Siti Rahma (Pustakawan)',
            'email' => 'pustakawan@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'Pustakawan'
        ]);

        // 2. Seed Mahasiswa
        Mahasiswa::create([
            'nim' => '230101001',
            'nama' => 'Ahmad Rizki',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => '2023',
            'no_hp' => '081234567890',
            'email' => 'rizki@student.ac.id',
            'status_aktif' => true
        ]);

        // 3. Seed Buku
        Buku::create([
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

        Buku::create([
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
    }
}
