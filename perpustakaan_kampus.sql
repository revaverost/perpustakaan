-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 16, 2026 at 02:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_kampus`
--
CREATE DATABASE IF NOT EXISTS `perpustakaan_kampus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `perpustakaan_kampus`;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode_buku` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengarang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_terbit` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lokasi_rak` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `kategori`, `stok`, `harga`, `lokasi_rak`, `created_at`, `updated_at`) VALUES
('250001', 'Pemrograman Web dengan Laravel 10', 'Rian H.', 'Informatika', '2023', 'Komputer', 5, '150000.00', 'R-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250002', 'Struktur Data dan Algoritma Dasar', 'Suryadi', 'Andi Offset', '2022', 'Komputer', 3, '120000.00', 'R-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250003', 'Basis Data untuk Pemula', 'Fathansyah', 'Informatika', '2021', 'Komputer', 4, '135000.00', 'R-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250004', 'Pengantar Jaringan Komputer', 'Budi Sutedjo', 'Andi Offset', '2020', 'Komputer', 6, '145000.00', 'R-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250005', 'Manajemen Organisasi Modern', 'T. Hani Handoko', 'BPFE', '2019', 'Manajemen', 3, '110000.00', 'R-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250006', 'Akuntansi Keuangan Dasar', 'Slamet Sugiri', 'UPP STIM YKPN', '2022', 'Akuntansi', 5, '125000.00', 'R-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('250007', 'Metode Penelitian Ilmiah', 'Sugiyono', 'Alfabeta', '2023', 'Referensi', 4, '95000.00', 'R-04', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260001', 'Panduan Dasar Pemrograman', 'Andi Wijaya', 'Penerbit Dummy', '2024', 'Referensi', 10, '76000.00', 'D-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260002', 'Mengenal Teknologi Informasi', 'Mira Anggraini', 'Penerbit Dummy', '2024', 'Manajemen', 10, '77000.00', 'D-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260003', 'Belajar Basis Data', 'Taufik Hidayat', 'Penerbit Dummy', '2024', 'Fiksi', 10, '78000.00', 'D-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260004', 'Jaringan Komputer Modern', 'Lukman Hakim', 'Penerbit Dummy', '2024', 'Komputer', 10, '79000.00', 'D-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260005', 'Manajemen Waktu Efektif', 'Dewi Kartika', 'Penerbit Dummy', '2024', 'Referensi', 10, '80000.00', 'D-01', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260006', 'Pengantar Ekonomi Kreatif', 'Hendra Saputra', 'Penerbit Dummy', '2024', 'Manajemen', 10, '81000.00', 'D-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260007', 'Strategi Komunikasi Digital', 'Nina Marlina', 'Penerbit Dummy', '2024', 'Fiksi', 10, '82000.00', 'D-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260008', 'Dasar-Dasar Akuntansi', 'Rudi Hartono', 'Penerbit Dummy', '2024', 'Komputer', 10, '83000.00', 'D-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260009', 'Metode Penelitian Terapan', 'Yuni Astuti', 'Penerbit Dummy', '2024', 'Referensi', 10, '84000.00', 'D-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260010', 'Psikologi Pendidikan', 'Fajar Nugroho', 'Penerbit Dummy', '2024', 'Manajemen', 10, '85000.00', 'D-02', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260011', 'Kewirausahaan untuk Pemula', 'Sari Puspita', 'Penerbit Dummy', '2024', 'Fiksi', 10, '86000.00', 'D-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260012', 'Sastra dan Kebudayaan', 'Bambang Setiawan', 'Penerbit Dummy', '2024', 'Komputer', 10, '87000.00', 'D-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260013', 'Matematika Terapan', 'Dian Pratiwi', 'Penerbit Dummy', '2024', 'Referensi', 10, '88000.00', 'D-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260014', 'Administrasi Perkantoran', 'Wahyu Kurnia', 'Penerbit Dummy', '2024', 'Manajemen', 10, '89000.00', 'D-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260015', 'Dasar Desain Grafis', 'Rina Aprilia', 'Penerbit Dummy', '2024', 'Fiksi', 10, '90000.00', 'D-03', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260016', 'Pengembangan Aplikasi Web', 'Agus Salim', 'Penerbit Dummy', '2024', 'Komputer', 10, '91000.00', 'D-04', '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('260017', 'Manajemen Proyek', 'Maya Lestari', 'Penerbit Dummy', '2024', 'Referensi', 10, '92000.00', 'D-04', '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('260018', 'Pengantar Statistika', 'Eko Prasetyo', 'Penerbit Dummy', '2024', 'Manajemen', 10, '93000.00', 'D-04', '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('260019', 'Etika Profesi', 'Putri Amelia', 'Penerbit Dummy', '2024', 'Fiksi', 10, '94000.00', 'D-04', '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('260020', 'Kepemimpinan Modern', 'Rizal Maulana', 'Penerbit Dummy', '2024', 'Komputer', 10, '95000.00', 'D-04', '2026-11-16 05:55:54', '2026-11-16 05:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id_denda` bigint UNSIGNED NOT NULL,
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denda_terlambat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `denda_fisik` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jumlah_denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status_bayar` enum('Belum Lunas','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `keterangan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bayar` timestamp NULL DEFAULT NULL,
  `metode_bayar` enum('Tunai','QRIS','Transfer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id_detail`, `id_peminjaman`, `kode_buku`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, '260001', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(2, 2, '260002', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(3, 3, '260003', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(4, 4, '260004', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(5, 5, '260005', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(6, 6, '260006', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(7, 7, '260007', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(8, 8, '260008', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(9, 9, '260009', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(10, 10, '260010', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(11, 11, '260011', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(12, 12, '260012', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(13, 13, '260013', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(14, 14, '260014', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(15, 15, '260015', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(16, 16, '260016', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(17, 17, '260017', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(18, 18, '260018', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(19, 19, '260019', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(20, 20, '260020', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(21, 21, '260001', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(22, 22, '260002', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(23, 23, '260003', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(24, 24, '260004', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(25, 25, '260005', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(26, 26, '260006', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(27, 27, '260007', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(28, 28, '260008', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(29, 29, '260009', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(30, 30, '260010', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(31, 31, '260011', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(32, 32, '260012', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(33, 33, '260013', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(34, 34, '260014', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(35, 35, '260015', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(36, 36, '260016', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(37, 37, '260017', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(38, 38, '260018', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(39, 39, '260019', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(40, 40, '260020', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(41, 41, '260001', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(42, 42, '260002', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(43, 43, '260003', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(44, 44, '260004', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(45, 45, '260005', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(46, 46, '260006', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(47, 47, '260007', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(48, 48, '260008', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(49, 49, '260009', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(50, 50, '260010', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_otps`
--

CREATE TABLE `login_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `expires_at` timestamp NOT NULL,
  `consumed_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_otps`
--

INSERT INTO `login_otps` (`id`, `nip`, `email`, `code_hash`, `attempts`, `expires_at`, `consumed_at`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, '1992011001', 'revatriana9@gmail.com', '$2y$10$l.TOOxZvarWhjbuhI5jsne8LTj/1mG12TvwxSkmwAWmautr8YIA1i', 0, '2026-11-16 07:34:38', '2026-11-16 07:30:15', '127.0.0.1', '2026-11-16 07:29:38', '2026-11-16 07:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `angkatan`, `no_hp`, `email`, `status_aktif`, `created_at`, `updated_at`) VALUES
('10250032', 'Rifky Al Adli', 'Rekayasa Perangkat Lunak', '2023', '089528429181', 'rifkyaladli61@gmail.com', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101001', 'Ahmad Rizki', 'Teknik Informatika', '2023', '081234567890', 'rizki@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101002', 'Siti Aisyah', 'Sistem Informasi', '2023', '081234567891', 'aisyah@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101003', 'Dimas Pratama', 'Teknik Informatika', '2023', '081234567892', 'dimas@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101004', 'Nabila Putri', 'Manajemen', '2023', '081234567893', 'nabila@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101005', 'Fajar Maulana', 'Akuntansi', '2023', '081234567894', 'fajar@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('230101006', 'Rina Kurniawati', 'Ilmu Komunikasi', '2023', '081234567895', 'rina@student.ac.id', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201001', 'Raka Pratama', 'Sistem Informasi', '2024', '082100000001', 'raka.pratama1@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201002', 'Intan Permata Sari', 'Manajemen', '2024', '082100000002', 'intan.permata.sari2@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201003', 'Bagas Saputra', 'Akuntansi', '2024', '082100000003', 'bagas.saputra3@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201004', 'Citra Lestari', 'Teknik Informatika', '2024', '082100000004', 'citra.lestari4@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201005', 'Yoga Ramadhan', 'Sistem Informasi', '2024', '082100000005', 'yoga.ramadhan5@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201006', 'Aulia Rahma', 'Manajemen', '2024', '082100000006', 'aulia.rahma6@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201007', 'Dhani Kurniawan', 'Akuntansi', '2024', '082100000007', 'dhani.kurniawan7@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201008', 'Maya Safitri', 'Teknik Informatika', '2024', '082100000008', 'maya.safitri8@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201009', 'Rizky Maulana', 'Sistem Informasi', '2024', '082100000009', 'rizky.maulana9@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201010', 'Nadia Putri', 'Manajemen', '2024', '082100000010', 'nadia.putri10@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201011', 'Arif Hidayat', 'Akuntansi', '2024', '082100000011', 'arif.hidayat11@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201012', 'Salsa Amelia', 'Teknik Informatika', '2024', '082100000012', 'salsa.amelia12@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201013', 'Gilang Nugraha', 'Sistem Informasi', '2024', '082100000013', 'gilang.nugraha13@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201014', 'Dinda Maharani', 'Manajemen', '2024', '082100000014', 'dinda.maharani14@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201015', 'Fikri Setiawan', 'Akuntansi', '2024', '082100000015', 'fikri.setiawan15@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201016', 'Anisa Wulandari', 'Teknik Informatika', '2024', '082100000016', 'anisa.wulandari16@example.test', 1, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('240201017', 'Reza Firmansyah', 'Sistem Informasi', '2024', '082100000017', 'reza.firmansyah17@example.test', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('240201018', 'Laila Nuraini', 'Manajemen', '2024', '082100000018', 'laila.nuraini18@example.test', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('240201019', 'Bima Adi Prakoso', 'Akuntansi', '2024', '082100000019', 'bima.adi.prakoso19@example.test', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
('240201020', 'Tiara Kusuma', 'Teknik Informatika', '2024', '082100000020', 'tiara.kusuma20@example.test', 1, '2026-11-16 05:55:54', '2026-11-16 05:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_11_06_080517_create_mahasiswa_table', 1),
(6, '2026_11_06_080518_create_buku_table', 1),
(7, '2026_11_06_080519_create_peminjaman_table', 1),
(8, '2026_11_06_080520_create_detail_peminjaman_table', 1),
(9, '2026_11_06_080521_create_pengembalian_table', 1),
(10, '2026_11_06_080522_create_denda_table', 1),
(11, '2026_11_06_080523_create_kondisi_buku_kembali_table', 1),
(12, '2026_11_12_000001_add_terakhir_pengingat_to_peminjaman_table', 1),
(13, '2026_11_12_000002_create_login_otps_table', 1),
(14, '2026_11_12_000003_create_jobs_table', 1),
(15, '2026_11_12_091447_merge_kondisi_into_pengembalian_table', 1),
(16, '2026_11_12_094453_move_denda_columns_to_denda_table', 1),
(17, '2026_11_14_104405_rename_users_table_to_petugas', 1),
(18, '2026_11_16_141530_change_login_otps_to_use_nip', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `nim` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_tenggat` date NOT NULL,
  `jumlah_perpanjang` int NOT NULL DEFAULT '0',
  `status` enum('Dipinjam','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dipinjam',
  `terakhir_pengingat` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `nim`, `nip`, `tgl_pinjam`, `tgl_tenggat`, `jumlah_perpanjang`, `status`, `terakhir_pengingat`, `created_at`, `updated_at`) VALUES
(1, '240201001', '1995031202', '2026-11-15', '2026-11-29', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(2, '240201002', '1995031202', '2026-11-14', '2026-11-28', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(3, '240201003', '1995031202', '2026-11-13', '2026-11-27', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(4, '240201004', '1995031202', '2026-11-12', '2026-11-26', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(5, '240201005', '1995031202', '2026-11-11', '2026-11-25', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(6, '240201006', '1995031202', '2026-11-10', '2026-11-24', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(7, '240201007', '1995031202', '2026-11-09', '2026-11-23', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(8, '240201008', '1995031202', '2026-11-08', '2026-11-22', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(9, '240201009', '1995031202', '2026-11-07', '2026-11-21', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(10, '240201010', '1995031202', '2026-11-06', '2026-11-20', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(11, '240201011', '1995031202', '2026-11-05', '2026-11-19', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(12, '240201012', '1995031202', '2026-11-04', '2026-11-18', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(13, '240201013', '1995031202', '2026-11-03', '2026-11-17', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(14, '240201014', '1995031202', '2026-11-02', '2026-11-16', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(15, '240201015', '1995031202', '2026-11-01', '2026-11-15', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(16, '240201016', '1995031202', '2026-10-31', '2026-11-14', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(17, '240201017', '1995031202', '2026-10-30', '2026-11-13', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(18, '240201018', '1995031202', '2026-10-29', '2026-11-12', 0, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(19, '240201019', '1995031202', '2026-10-28', '2026-11-11', 1, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(20, '240201020', '1995031202', '2026-10-27', '2026-11-10', 2, 'Selesai', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(21, '240201001', '1995031202', '2026-10-26', '2026-11-09', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(22, '240201002', '1995031202', '2026-10-25', '2026-11-08', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(23, '240201003', '1995031202', '2026-10-24', '2026-11-07', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(24, '240201004', '1995031202', '2026-10-23', '2026-11-06', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(25, '240201005', '1995031202', '2026-10-22', '2026-11-05', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(26, '240201006', '1995031202', '2026-10-21', '2026-11-04', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(27, '240201007', '1995031202', '2026-10-20', '2026-11-03', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(28, '240201008', '1995031202', '2026-10-19', '2026-11-02', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(29, '240201009', '1995031202', '2026-10-18', '2026-11-01', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(30, '240201010', '1995031202', '2026-10-17', '2026-10-31', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(31, '240201011', '1995031202', '2026-10-16', '2026-10-30', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(32, '240201012', '1995031202', '2026-10-15', '2026-10-29', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(33, '240201013', '1995031202', '2026-10-14', '2026-10-28', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(34, '240201014', '1995031202', '2026-10-13', '2026-10-27', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(35, '240201015', '1995031202', '2026-10-12', '2026-10-26', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(36, '240201016', '1995031202', '2026-09-11', '2026-09-26', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(37, '240201017', '1995031202', '2026-09-10', '2026-09-25', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(38, '240201018', '1995031202', '2026-09-09', '2026-09-24', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(39, '240201019', '1995031202', '2026-09-08', '2026-09-23', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(40, '240201020', '1995031202', '2026-09-07', '2026-09-22', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(41, '240201001', '1995031202', '2026-09-06', '2026-09-21', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(42, '240201002', '1995031202', '2026-09-05', '2026-09-20', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(43, '240201003', '1995031202', '2026-09-04', '2026-09-19', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(44, '240201004', '1995031202', '2026-09-03', '2026-09-18', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(45, '240201005', '1995031202', '2026-09-02', '2026-09-17', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(46, '240201006', '1995031202', '2026-09-01', '2026-09-16', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(47, '240201007', '1995031202', '2026-08-31', '2026-09-15', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(48, '240201008', '1995031202', '2026-08-30', '2026-09-14', 0, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(49, '240201009', '1995031202', '2026-08-29', '2026-09-13', 1, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(50, '240201010', '1995031202', '2026-08-28', '2026-09-12', 2, 'Dipinjam', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_kembali` date NOT NULL,
  `terlambat_hari` int NOT NULL DEFAULT '0',
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat','Hilang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `keterangan_kondisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_peminjaman`, `kode_buku`, `nip`, `tgl_kembali`, `terlambat_hari`, `kondisi`, `keterangan_kondisi`, `created_at`, `updated_at`) VALUES
(1, 1, '260001', '1995031202', '2026-11-28', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(2, 2, '260002', '1995031202', '2026-11-26', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(3, 3, '260003', '1995031202', '2026-11-24', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(4, 4, '260004', '1995031202', '2026-11-26', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(5, 5, '260005', '1995031202', '2026-11-24', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(6, 6, '260006', '1995031202', '2026-11-22', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(7, 7, '260007', '1995031202', '2026-11-20', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(8, 8, '260008', '1995031202', '2026-11-22', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(9, 9, '260009', '1995031202', '2026-11-20', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(10, 10, '260010', '1995031202', '2026-11-18', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(11, 11, '260011', '1995031202', '2026-11-16', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(12, 12, '260012', '1995031202', '2026-11-18', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(13, 13, '260013', '1995031202', '2026-11-16', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(14, 14, '260014', '1995031202', '2026-11-14', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(15, 15, '260015', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(16, 16, '260016', '1995031202', '2026-11-14', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(17, 17, '260017', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(18, 18, '260018', '1995031202', '2026-11-10', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(19, 19, '260019', '1995031202', '2026-11-08', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54'),
(20, 20, '260020', '1995031202', '2026-11-10', 0, 'Baik', NULL, '2026-11-16 05:55:54', '2026-11-16 05:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Pustakawan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`nip`, `nama`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
('1992011001', 'Reva Triana Sukma (Admin)', 'revatriana9@gmail.com', '$2y$10$rMRiPKyJJX675wLzZtdD0.QvSCrB0531CggZtWSk/U4nAezsR3tEm', 'Admin', NULL, '2026-11-16 05:55:53', '2026-11-16 05:55:53'),
('1995031202', 'Rifky Al Adli (Pustakawan)', 'rifkyaladli61@gmail.com', '$2y$10$M4MqbCSNQ2zrhEle/xBeXOkTzimfydeawCkw6t7Z/cEimn7iD5MPy', 'Pustakawan', NULL, '2026-11-16 05:55:53', '2026-11-16 05:55:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`),
  ADD UNIQUE KEY `denda_id_pengembalian_unique` (`id_pengembalian`),
  ADD KEY `denda_nip_foreign` (`nip`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `detail_peminjaman_id_peminjaman_foreign` (`id_peminjaman`),
  ADD KEY `detail_peminjaman_kode_buku_foreign` (`kode_buku`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `login_otps`
--
ALTER TABLE `login_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_otps_nip_email_index` (`nip`,`email`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD UNIQUE KEY `mahasiswa_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_nim_foreign` (`nim`),
  ADD KEY `peminjaman_nip_foreign` (`nip`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `pengembalian_nip_foreign` (`nip`),
  ADD KEY `pengembalian_id_peminjaman_foreign` (`id_peminjaman`),
  ADD KEY `pengembalian_kode_buku_foreign` (`kode_buku`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_otps`
--
ALTER TABLE `login_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id_pengembalian`) ON DELETE CASCADE,
  ADD CONSTRAINT `denda_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `petugas` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_kode_buku_foreign` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `login_otps`
--
ALTER TABLE `login_otps`
  ADD CONSTRAINT `login_otps_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `petugas` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `petugas` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengembalian_kode_buku_foreign` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalian_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `petugas` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
