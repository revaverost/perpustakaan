-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2026 at 05:07 PM
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
  `kode_buku` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengarang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_terbit` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lokasi_rak` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `kategori`, `stok`, `harga`, `lokasi_rak`, `created_at`, `updated_at`) VALUES
('250001', 'Pemrograman Web dengan Laravel 10', 'Rian H.', 'Informatika', '2023', 'Komputer', 5, '150000.00', 'R-01', '2026-11-06 04:26:36', '2026-11-12 03:14:20'),
('250002', 'Struktur Data dan Algoritma Dasar', 'Suryadi', 'Andi Offset', '2022', 'Komputer', 3, '120000.00', 'R-01', '2026-11-06 04:26:36', '2026-11-12 02:58:46'),
('250003', 'Basis Data untuk Pemula', 'Fathansyah', 'Informatika', '2021', 'Komputer', 3, '135000.00', 'R-02', '2026-11-10 23:30:53', '2026-11-12 03:12:07'),
('250004', 'Pengantar Jaringan Komputer', 'Budi Sutedjo', 'Andi Offset', '2020', 'Komputer', 6, '145000.00', 'R-02', '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('250005', 'Manajemen Organisasi Modern', 'T. Hani Handoko', 'BPFE', '2019', 'Manajemen', 3, '110000.00', 'R-03', '2026-11-10 23:30:53', '2026-11-12 09:42:51'),
('250006', 'Akuntansi Keuangan Dasar', 'Slamet Sugiri', 'UPP STIM YKPN', '2022', 'Akuntansi', 5, '125000.00', 'R-03', '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('250007', 'Metode Penelitian Ilmiah', 'Sugiyono', 'Alfabeta', '2023', 'Referensi', 4, '95000.00', 'R-04', '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('260001', 'Panduan Dasar Pemrograman', 'Andi Wijaya', 'Penerbit Dummy', '2024', 'Referensi', 10, '76000.00', 'D-01', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260002', 'Mengenal Teknologi Informasi', 'Mira Anggraini', 'Penerbit Dummy', '2024', 'Manajemen', 10, '77000.00', 'D-01', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260003', 'Belajar Basis Data', 'Taufik Hidayat', 'Penerbit Dummy', '2024', 'Fiksi', 10, '78000.00', 'D-01', '2026-11-10 23:30:53', '2026-11-12 09:21:53'),
('260004', 'Jaringan Komputer Modern', 'Lukman Hakim', 'Penerbit Dummy', '2024', 'Komputer', 10, '79000.00', 'D-01', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260005', 'Manajemen Waktu Efektif', 'Dewi Kartika', 'Penerbit Dummy', '2024', 'Referensi', 10, '80000.00', 'D-01', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260006', 'Pengantar Ekonomi Kreatif', 'Hendra Saputra', 'Penerbit Dummy', '2024', 'Manajemen', 10, '81000.00', 'D-02', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260007', 'Strategi Komunikasi Digital', 'Nina Marlina', 'Penerbit Dummy', '2024', 'Fiksi', 10, '82000.00', 'D-02', '2026-11-10 23:30:53', '2026-11-12 03:48:12'),
('260008', 'Dasar-Dasar Akuntansi', 'Rudi Hartono', 'Penerbit Dummy', '2024', 'Komputer', 10, '83000.00', 'D-02', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260009', 'Metode Penelitian Terapan', 'Yuni Astuti', 'Penerbit Dummy', '2024', 'Referensi', 10, '84000.00', 'D-02', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260010', 'Psikologi Pendidikan', 'Fajar Nugroho', 'Penerbit Dummy', '2024', 'Manajemen', 10, '85000.00', 'D-02', '2026-11-10 23:30:53', '2026-11-12 03:48:12'),
('260011', 'Kewirausahaan untuk Pemula', 'Sari Puspita', 'Penerbit Dummy', '2024', 'Fiksi', 10, '86000.00', 'D-03', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260012', 'Sastra dan Kebudayaan', 'Bambang Setiawan', 'Penerbit Dummy', '2024', 'Komputer', 10, '87000.00', 'D-03', '2026-11-10 23:30:53', '2026-11-12 09:21:53'),
('260013', 'Matematika Terapan', 'Dian Pratiwi', 'Penerbit Dummy', '2024', 'Referensi', 10, '88000.00', 'D-03', '2026-11-10 23:30:53', '2026-11-12 09:44:25'),
('260014', 'Administrasi Perkantoran', 'Wahyu Kurnia', 'Penerbit Dummy', '2024', 'Manajemen', 10, '89000.00', 'D-03', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260015', 'Dasar Desain Grafis', 'Rina Aprilia', 'Penerbit Dummy', '2024', 'Fiksi', 10, '90000.00', 'D-03', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260016', 'Pengembangan Aplikasi Web', 'Agus Salim', 'Penerbit Dummy', '2024', 'Komputer', 10, '91000.00', 'D-04', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260017', 'Manajemen Proyek', 'Maya Lestari', 'Penerbit Dummy', '2024', 'Referensi', 10, '92000.00', 'D-04', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260018', 'Pengantar Statistika', 'Eko Prasetyo', 'Penerbit Dummy', '2024', 'Manajemen', 10, '93000.00', 'D-04', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260019', 'Etika Profesi', 'Putri Amelia', 'Penerbit Dummy', '2024', 'Fiksi', 10, '94000.00', 'D-04', '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('260020', 'Kepemimpinan Modern', 'Rizal Maulana', 'Penerbit Dummy', '2024', 'Komputer', 10, '95000.00', 'D-04', '2026-11-10 23:30:53', '2026-11-10 23:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id_denda` bigint UNSIGNED NOT NULL,
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `nip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denda_terlambat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `denda_fisik` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jumlah_denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status_bayar` enum('Belum Lunas','Lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bayar` timestamp NULL DEFAULT NULL,
  `metode_bayar` enum('Tunai','QRIS','Transfer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id_denda`, `id_pengembalian`, `nip`, `denda_terlambat`, `denda_fisik`, `jumlah_denda`, `status_bayar`, `keterangan`, `tgl_bayar`, `metode_bayar`, `created_at`, `updated_at`) VALUES
(1, 2, '1995031202', '153000.00', '0.00', '153000.00', 'Lunas', 'Terlambat, Hilang', '2026-11-06 04:35:20', 'Tunai', '2026-11-06 04:34:54', '2026-11-06 04:35:20'),
(2, 3, '1995031202', '78000.00', '0.00', '78000.00', 'Lunas', 'Terlambat, Rusak', '2026-11-06 04:41:28', 'Tunai', '2026-11-06 04:41:11', '2026-11-06 04:41:28'),
(3, 4, '1995031202', '150000.00', '0.00', '150000.00', 'Belum Lunas', 'Hilang', NULL, NULL, '2026-11-08 01:12:46', '2026-11-08 01:12:46'),
(4, 45, '1995031202', '4000.00', '15000.00', '19000.00', 'Belum Lunas', 'Terlambat, Rusak', NULL, NULL, '2026-11-12 02:58:46', '2026-11-12 02:58:46'),
(5, 47, '1995031202', '0.00', '15000.00', '15000.00', 'Lunas', 'Rusak', '2026-11-12 03:24:55', 'Tunai', '2026-11-12 03:14:20', '2026-11-12 03:24:55'),
(6, 54, '1995031202', '0.00', '15000.00', '15000.00', 'Lunas', 'Rusak', '2026-11-12 09:48:24', 'Tunai', '2026-11-12 09:42:51', '2026-11-12 09:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id_detail`, `id_peminjaman`, `kode_buku`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, '250001', 1, '2026-11-06 04:28:30', '2026-11-06 04:28:30'),
(2, 2, '250001', 1, '2026-11-06 04:35:57', '2026-11-06 04:35:57'),
(3, 3, '250001', 1, '2026-11-08 01:10:34', '2026-11-08 01:10:34'),
(54, 54, '260001', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(55, 55, '260002', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(56, 56, '260003', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(57, 57, '260004', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(58, 58, '260005', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(59, 59, '260006', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(60, 60, '260007', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(61, 61, '260008', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(62, 62, '260009', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(63, 63, '260010', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(64, 64, '260011', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(65, 65, '260012', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(66, 66, '260013', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(67, 67, '260014', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(68, 68, '260015', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(69, 69, '260016', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(70, 70, '260017', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(71, 71, '260018', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(72, 72, '260019', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(73, 73, '260020', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(74, 74, '260001', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(75, 75, '260002', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(76, 76, '260003', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(77, 77, '260004', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(78, 78, '260005', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(79, 79, '260006', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(80, 80, '260007', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(81, 81, '260008', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(82, 82, '260009', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(83, 83, '260010', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(84, 84, '260011', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(85, 85, '260012', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(86, 86, '260013', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(87, 87, '260014', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(88, 88, '260015', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(89, 89, '260016', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(90, 90, '260017', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(91, 91, '260018', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(92, 92, '260019', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(93, 93, '260020', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(94, 94, '260001', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(95, 95, '260002', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(96, 96, '260003', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(97, 97, '260004', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(98, 98, '260005', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(99, 99, '260006', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(100, 100, '260007', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(101, 101, '260008', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(102, 102, '260009', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(103, 103, '260010', 1, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(104, 104, '250001', 1, '2026-11-11 23:14:07', '2026-11-11 23:14:07'),
(105, 104, '250002', 1, '2026-11-11 23:14:07', '2026-11-11 23:14:07'),
(106, 105, '250001', 1, '2026-11-12 03:12:07', '2026-11-12 03:12:07'),
(107, 105, '250003', 1, '2026-11-12 03:12:07', '2026-11-12 03:12:07'),
(108, 106, '260010', 1, '2026-11-12 03:44:13', '2026-11-12 03:44:13'),
(109, 106, '260007', 1, '2026-11-12 03:44:13', '2026-11-12 03:44:13'),
(110, 107, '260012', 1, '2026-11-12 03:50:31', '2026-11-12 03:50:31'),
(111, 107, '260003', 1, '2026-11-12 03:50:31', '2026-11-12 03:50:31'),
(112, 108, '260012', 1, '2026-11-12 03:50:34', '2026-11-12 03:50:34'),
(113, 108, '260003', 1, '2026-11-12 03:50:34', '2026-11-12 03:50:34'),
(114, 109, '250005', 1, '2026-11-12 09:22:17', '2026-11-12 09:22:17'),
(115, 110, '260013', 1, '2026-11-12 09:44:12', '2026-11-12 09:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `angkatan`, `no_hp`, `email`, `status_aktif`, `created_at`, `updated_at`) VALUES
('10250032', 'RIFKY AL ADLI', 'Rekayasa Perangkat Lunak', '2026', '089528429181', 'rifkyaladli@student.ac.id', 1, '2026-11-10 23:16:49', '2026-11-10 23:17:02'),
('10250096', 'REVA TRIANA SUKMA', 'Rekayasa Perangkat Lunak', '2026', '088802362631', 'revatriana9@gmail.com', 1, '2026-11-12 03:43:20', '2026-11-12 03:49:12'),
('230101001', 'Ahmad Rizki', 'Teknik Informatika', '2023', '081234567890', 'rizki@student.ac.id', 1, '2026-11-06 04:26:36', '2026-11-10 23:30:53'),
('230101002', 'Siti Aisyah', 'Sistem Informasi', '2023', '081234567891', 'aisyah@student.ac.id', 1, '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('230101003', 'Dimas Pratama', 'Teknik Informatika', '2023', '081234567892', 'dimas@student.ac.id', 1, '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('230101004', 'Nabila Putri', 'Manajemen', '2023', '081234567893', 'nabila@student.ac.id', 1, '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('230101005', 'Fajar Maulana', 'Akuntansi', '2023', '081234567894', 'fajar@student.ac.id', 1, '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('230101006', 'Rina Kurniawati', 'Ilmu Komunikasi', '2023', '081234567895', 'rina@student.ac.id', 1, '2026-11-10 23:30:53', '2026-11-10 23:30:53'),
('240201001', 'Raka Pratama', 'Sistem Informasi', '2024', '082100000001', 'raka.pratama1@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201002', 'Intan Permata Sari', 'Manajemen', '2024', '082100000002', 'intan.permata.sari2@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201003', 'Bagas Saputra', 'Akuntansi', '2024', '082100000003', 'bagas.saputra3@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201004', 'Citra Lestari', 'Teknik Informatika', '2024', '082100000004', 'citra.lestari4@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201005', 'Yoga Ramadhan', 'Sistem Informasi', '2024', '082100000005', 'yoga.ramadhan5@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201006', 'Aulia Rahma', 'Manajemen', '2024', '082100000006', 'aulia.rahma6@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201007', 'Dhani Kurniawan', 'Akuntansi', '2024', '082100000007', 'dhani.kurniawan7@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201008', 'Maya Safitri', 'Teknik Informatika', '2024', '082100000008', 'maya.safitri8@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201009', 'Rizky Maulana', 'Sistem Informasi', '2024', '082100000009', 'rizky.maulana9@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201010', 'Nadia Putri', 'Manajemen', '2024', '082100000010', 'nadia.putri10@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201011', 'Arif Hidayat', 'Akuntansi', '2024', '082100000011', 'arif.hidayat11@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201012', 'Salsa Amelia', 'Teknik Informatika', '2024', '082100000012', 'salsa.amelia12@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201013', 'Gilang Nugraha', 'Sistem Informasi', '2024', '082100000013', 'gilang.nugraha13@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201014', 'Dinda Maharani', 'Manajemen', '2024', '082100000014', 'dinda.maharani14@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201015', 'Fikri Setiawan', 'Akuntansi', '2024', '082100000015', 'fikri.setiawan15@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201016', 'Anisa Wulandari', 'Teknik Informatika', '2024', '082100000016', 'anisa.wulandari16@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201017', 'Reza Firmansyah', 'Sistem Informasi', '2024', '082100000017', 'reza.firmansyah17@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201018', 'Laila Nuraini', 'Manajemen', '2024', '082100000018', 'laila.nuraini18@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201019', 'Bima Adi Prakoso', 'Akuntansi', '2024', '082100000019', 'bima.adi.prakoso19@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21'),
('240201020', 'Tiara Kusuma', 'Teknik Informatika', '2024', '082100000020', 'tiara.kusuma20@example.test', 1, '2026-11-10 23:30:53', '2026-11-10 23:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(12, '2026_11_11_070000_create_jadwal_pustakawan_table', 2),
(13, '2026_11_12_091447_merge_kondisi_into_pengembalian_table', 3),
(14, '2026_11_12_094453_move_denda_columns_to_denda_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `nim` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_tenggat` date NOT NULL,
  `jumlah_perpanjang` int NOT NULL DEFAULT '0',
  `status` enum('Dipinjam','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `nim`, `nip`, `tgl_pinjam`, `tgl_tenggat`, `jumlah_perpanjang`, `status`, `created_at`, `updated_at`) VALUES
(1, '230101001', '1995031202', '2026-11-06', '2026-11-27', 1, 'Selesai', '2026-11-06 04:28:30', '2026-11-06 04:34:54'),
(2, '230101001', '1995031202', '2026-11-06', '2026-11-20', 0, 'Selesai', '2026-11-06 04:35:57', '2026-11-06 04:41:11'),
(3, '230101001', '1995031202', '2026-11-08', '2026-11-29', 1, 'Selesai', '2026-11-08 01:10:34', '2026-11-08 01:12:46'),
(54, '240201001', '1995031202', '2026-11-10', '2026-11-24', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(55, '240201002', '1995031202', '2026-11-09', '2026-11-23', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(56, '240201003', '1995031202', '2026-11-08', '2026-11-22', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(57, '240201004', '1995031202', '2026-11-07', '2026-11-21', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(58, '240201005', '1995031202', '2026-11-06', '2026-11-20', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(59, '240201006', '1995031202', '2026-11-05', '2026-11-19', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(60, '240201007', '1995031202', '2026-11-04', '2026-11-18', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(61, '240201008', '1995031202', '2026-11-03', '2026-11-17', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(62, '240201009', '1995031202', '2026-11-02', '2026-11-16', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(63, '240201010', '1995031202', '2026-11-01', '2026-11-15', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(64, '240201011', '1995031202', '2026-10-31', '2026-11-14', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(65, '240201012', '1995031202', '2026-10-30', '2026-11-13', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(66, '240201013', '1995031202', '2026-10-29', '2026-11-12', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(67, '240201014', '1995031202', '2026-10-28', '2026-11-11', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(68, '240201015', '1995031202', '2026-10-27', '2026-11-10', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(69, '240201016', '1995031202', '2026-10-26', '2026-11-09', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(70, '240201017', '1995031202', '2026-10-25', '2026-11-08', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(71, '240201018', '1995031202', '2026-10-24', '2026-11-07', 0, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(72, '240201019', '1995031202', '2026-10-23', '2026-11-06', 1, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(73, '240201020', '1995031202', '2026-10-22', '2026-11-05', 2, 'Selesai', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(74, '240201001', '1995031202', '2026-10-21', '2026-11-04', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(75, '240201002', '1995031202', '2026-10-20', '2026-11-03', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(76, '240201003', '1995031202', '2026-10-19', '2026-11-02', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(77, '240201004', '1995031202', '2026-10-18', '2026-11-01', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(78, '240201005', '1995031202', '2026-10-17', '2026-10-31', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(79, '240201006', '1995031202', '2026-10-16', '2026-10-30', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(80, '240201007', '1995031202', '2026-10-15', '2026-10-29', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(81, '240201008', '1995031202', '2026-10-14', '2026-10-28', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(82, '240201009', '1995031202', '2026-10-13', '2026-10-27', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(83, '240201010', '1995031202', '2026-10-12', '2026-10-26', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(84, '240201011', '1995031202', '2026-10-11', '2026-10-25', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(85, '240201012', '1995031202', '2026-10-10', '2026-10-24', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(86, '240201013', '1995031202', '2026-10-09', '2026-10-23', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(87, '240201014', '1995031202', '2026-10-08', '2026-10-22', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(88, '240201015', '1995031202', '2026-10-07', '2026-10-21', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(89, '240201016', '1995031202', '2026-09-06', '2026-09-21', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(90, '240201017', '1995031202', '2026-09-05', '2026-09-20', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(91, '240201018', '1995031202', '2026-09-04', '2026-09-19', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(92, '240201019', '1995031202', '2026-09-03', '2026-09-18', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(93, '240201020', '1995031202', '2026-09-02', '2026-09-17', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(94, '240201001', '1995031202', '2026-09-01', '2026-09-16', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(95, '240201002', '1995031202', '2026-08-31', '2026-09-22', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-12 03:26:00'),
(96, '240201003', '1995031202', '2026-08-30', '2026-09-14', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(97, '240201004', '1995031202', '2026-08-29', '2026-09-13', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(98, '240201005', '1995031202', '2026-08-28', '2026-09-12', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(99, '240201006', '1995031202', '2026-08-27', '2026-09-11', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(100, '240201007', '1995031202', '2026-08-26', '2026-09-10', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(101, '240201008', '1995031202', '2026-08-25', '2026-09-09', 0, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(102, '240201009', '1995031202', '2026-08-24', '2026-09-08', 1, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(103, '240201010', '1995031202', '2026-08-23', '2026-09-07', 2, 'Dipinjam', '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(104, '10250032', '1995031202', '2026-11-12', '2026-11-26', 0, 'Selesai', '2026-11-11 23:14:07', '2026-11-12 02:58:46'),
(105, '10250032', '1995031202', '2026-11-12', '2026-11-26', 0, 'Dipinjam', '2026-11-12 03:12:07', '2026-11-12 03:12:07'),
(106, '10250096', '1995031202', '2026-11-12', '2026-11-26', 0, 'Selesai', '2026-11-12 03:44:13', '2026-11-12 03:48:12'),
(107, '10250096', '1995031202', '2026-11-12', '2026-11-26', 0, 'Selesai', '2026-11-12 03:50:31', '2026-11-12 09:21:53'),
(108, '10250096', '1995031202', '2026-11-12', '2026-11-26', 0, 'Selesai', '2026-11-12 03:50:34', '2026-11-12 09:21:32'),
(109, '10250096', '1995031202', '2026-11-12', '2026-11-13', 0, 'Selesai', '2026-11-12 09:22:17', '2026-11-12 09:42:51'),
(110, '10250096', '1995031202', '2026-11-12', '2026-11-26', 0, 'Selesai', '2026-11-12 09:44:12', '2026-11-12 09:44:25');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(2, 1, '250001', '1995031202', '2026-11-30', 3, 'Baik', NULL, '2026-11-06 04:34:54', '2026-11-06 04:34:54'),
(3, 2, '250001', '1995031202', '2026-11-23', 3, 'Baik', NULL, '2026-11-06 04:41:11', '2026-11-06 04:41:11'),
(4, 3, '250001', '1995031202', '2026-11-08', 0, 'Baik', NULL, '2026-11-08 01:12:46', '2026-11-08 01:12:46'),
(25, 54, '260001', '1995031202', '2026-11-23', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(26, 55, '260002', '1995031202', '2026-11-21', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(27, 56, '260003', '1995031202', '2026-11-19', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(28, 57, '260004', '1995031202', '2026-11-21', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(29, 58, '260005', '1995031202', '2026-11-19', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(30, 59, '260006', '1995031202', '2026-11-17', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(31, 60, '260007', '1995031202', '2026-11-15', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(32, 61, '260008', '1995031202', '2026-11-17', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(33, 62, '260009', '1995031202', '2026-11-15', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(34, 63, '260010', '1995031202', '2026-11-13', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(35, 64, '260011', '1995031202', '2026-11-11', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(36, 65, '260012', '1995031202', '2026-11-13', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(37, 66, '260013', '1995031202', '2026-11-11', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(38, 67, '260014', '1995031202', '2026-11-09', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(39, 68, '260015', '1995031202', '2026-11-07', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(40, 69, '260016', '1995031202', '2026-11-09', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(41, 70, '260017', '1995031202', '2026-11-07', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(42, 71, '260018', '1995031202', '2026-11-05', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(43, 72, '260019', '1995031202', '2026-11-03', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(44, 73, '260020', '1995031202', '2026-11-05', 0, 'Baik', NULL, '2026-11-10 23:32:21', '2026-11-10 23:32:21'),
(45, 104, '250001', '1995031202', '2026-11-30', 4, 'Rusak Ringan', NULL, '2026-11-12 02:58:46', '2026-11-12 02:58:46'),
(46, 104, '250002', '1995031202', '2026-11-30', 4, 'Baik', NULL, '2026-11-12 02:58:46', '2026-11-12 02:58:46'),
(47, 105, '250001', '1995031202', '2026-11-12', 0, 'Rusak Ringan', NULL, '2026-11-12 03:14:20', '2026-11-12 03:14:20'),
(48, 106, '260010', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 03:48:12', '2026-11-12 03:48:12'),
(49, 106, '260007', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 03:48:12', '2026-11-12 03:48:12'),
(50, 108, '260012', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 09:21:32', '2026-11-12 09:21:32'),
(51, 108, '260003', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 09:21:32', '2026-11-12 09:21:32'),
(52, 107, '260012', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 09:21:53', '2026-11-12 09:21:53'),
(53, 107, '260003', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 09:21:53', '2026-11-12 09:21:53'),
(54, 109, '250005', '1995031202', '2026-11-12', 0, 'Rusak Ringan', NULL, '2026-11-12 09:42:51', '2026-11-12 09:42:51'),
(55, 110, '260013', '1995031202', '2026-11-12', 0, 'Baik', NULL, '2026-11-12 09:44:25', '2026-11-12 09:44:25');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Pustakawan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nip`, `nama`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
('1992011001', 'Budi Santoso (Admin)', 'admin@kampus.ac.id', '$2y$10$aP1uInNo91uqjSReDtRnR.O0N2.UNNnwtsfZOztIqhPt6ooBJlA9q', 'Admin', 'qjvcgU1Awp2gIDYLQxX8jKAwPfFypLDLb2UajOXGLSmWQElEp8rvUwYZsCvB', '2026-11-06 04:26:36', '2026-11-10 23:30:53'),
('1995031202', 'Siti Rahma (Pustakawan)', 'pustakawan@kampus.ac.id', '$2y$10$7avjpE4gxb1c2r1hPIGdiuJd1UNwhobz9LaJA0FmZE8PT51te.4Re', 'Pustakawan', 'iI8LP7b3wr6IK7orIZ1dzXPNzxS4dVhnf8mbGKahZ8OSPTGwohnS7oYn0jx6', '2026-11-06 04:26:36', '2026-11-10 23:30:53');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
  ADD CONSTRAINT `denda_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `users` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_kode_buku_foreign` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `users` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengembalian_kode_buku_foreign` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalian_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `users` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
