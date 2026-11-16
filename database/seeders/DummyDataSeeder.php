<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $now = now();
            $petugas = '1995031202';
            $anggota = [];
            $buku = [];
            $namaAnggota = [
                'Raka Pratama', 'Intan Permata Sari', 'Bagas Saputra', 'Citra Lestari',
                'Yoga Ramadhan', 'Aulia Rahma', 'Dhani Kurniawan', 'Maya Safitri',
                'Rizky Maulana', 'Nadia Putri', 'Arif Hidayat', 'Salsa Amelia',
                'Gilang Nugraha', 'Dinda Maharani', 'Fikri Setiawan', 'Anisa Wulandari',
                'Reza Firmansyah', 'Laila Nuraini', 'Bima Adi Prakoso', 'Tiara Kusuma',
            ];
            $namaPenulis = [
                'Andi Wijaya', 'Mira Anggraini', 'Taufik Hidayat', 'Lukman Hakim',
                'Dewi Kartika', 'Hendra Saputra', 'Nina Marlina', 'Rudi Hartono',
                'Yuni Astuti', 'Fajar Nugroho', 'Sari Puspita', 'Bambang Setiawan',
                'Dian Pratiwi', 'Wahyu Kurnia', 'Rina Aprilia', 'Agus Salim',
                'Maya Lestari', 'Eko Prasetyo', 'Putri Amelia', 'Rizal Maulana',
            ];

            for ($i = 1; $i <= 20; $i++) {
                $nim = '240201' . str_pad((string) $i, 3, '0', STR_PAD_LEFT);
                $anggota[] = $nim;
                Mahasiswa::updateOrCreate(['nim' => $nim], [
                    'nama' => $namaAnggota[$i - 1],
                    'jurusan' => ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi'][$i % 4],
                    'angkatan' => '2024',
                    'no_hp' => '08210000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                    'email' => strtolower(str_replace(' ', '.', $namaAnggota[$i - 1])) . $i . '@example.test',
                    'status_aktif' => true,
                ]);

                $kode = '260' . str_pad((string) $i, 3, '0', STR_PAD_LEFT);
                $buku[] = $kode;
                Buku::updateOrCreate(['kode_buku' => $kode], [
                    'judul' => ['Panduan Dasar Pemrograman', 'Mengenal Teknologi Informasi', 'Belajar Basis Data', 'Jaringan Komputer Modern', 'Manajemen Waktu Efektif', 'Pengantar Ekonomi Kreatif', 'Strategi Komunikasi Digital', 'Dasar-Dasar Akuntansi', 'Metode Penelitian Terapan', 'Psikologi Pendidikan', 'Kewirausahaan untuk Pemula', 'Sastra dan Kebudayaan', 'Matematika Terapan', 'Administrasi Perkantoran', 'Dasar Desain Grafis', 'Pengembangan Aplikasi Web', 'Manajemen Proyek', 'Pengantar Statistika', 'Etika Profesi', 'Kepemimpinan Modern'][$i - 1],
                    'pengarang' => $namaPenulis[$i - 1],
                    'penerbit' => 'Penerbit Dummy',
                    'tahun_terbit' => '2024',
                    'kategori' => ['Komputer', 'Referensi', 'Manajemen', 'Fiksi'][$i % 4],
                    'stok' => 10,
                    'harga' => 75000 + ($i * 1000),
                    'lokasi_rak' => 'D-' . str_pad((string) ceil($i / 5), 2, '0', STR_PAD_LEFT),
                ]);
            }

            // Hapus transaksi dummy sebelumnya agar seeder aman dijalankan ulang.
            $oldLoans = Peminjaman::whereIn('nim', $anggota)->pluck('id_peminjaman');
            Pengembalian::whereIn('id_peminjaman', $oldLoans)->delete();
            DetailPeminjaman::whereIn('id_peminjaman', $oldLoans)->delete();
            Peminjaman::whereIn('id_peminjaman', $oldLoans)->delete();

            for ($i = 1; $i <= 50; $i++) {
                // 1-20 selesai, 21-35 aktif normal, 36-50 aktif dan terlambat.
                $selesai = $i <= 20;
                $terlambat = $i > 35;
                $tglPinjam = $terlambat ? now()->subDays(30 + $i) : now()->subDays($i);
                $tglTenggat = $terlambat ? now()->subDays(15 + $i) : $tglPinjam->copy()->addDays(14);

                $loan = Peminjaman::create([
                    'nim' => $anggota[($i - 1) % 20],
                    'nip' => $petugas,
                    'tgl_pinjam' => $tglPinjam->toDateString(),
                    'tgl_tenggat' => $tglTenggat->toDateString(),
                    'jumlah_perpanjang' => $i % 3,
                    'status' => $selesai ? 'Selesai' : 'Dipinjam',
                ]);

                $kodeBuku = $buku[($i - 1) % 20];
                DetailPeminjaman::create([
                    'id_peminjaman' => $loan->id_peminjaman,
                    'kode_buku' => $kodeBuku,
                    'jumlah' => 1,
                ]);

                if ($selesai) {
                    Pengembalian::create([
                        'id_peminjaman' => $loan->id_peminjaman,
                        'kode_buku' => $kodeBuku,
                        'nip' => $petugas,
                        'tgl_kembali' => $tglTenggat->copy()->subDays($i % 4)->toDateString(),
                        'terlambat_hari' => 0,
                        'kondisi' => 'Baik',
                    ]);
                }
            }
        });
    }
}
