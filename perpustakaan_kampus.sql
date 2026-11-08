-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 08, 2026 at 01:51 PM
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
('250001', 'Pemrograman Web dengan Laravel 10', 'Rian H.', 'Informatika', '2023', 'Komputer', 3, '150000.00', 'R-01', '2026-11-06 04:26:36', '2026-11-08 01:10:34'),
('250002', 'Struktur Data dan Algoritma Dasar', 'Suryadi', 'Andi Offset', '2022', 'Komputer', 3, '120000.00', 'R-01', '2026-11-06 04:26:36', '2026-11-06 04:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `id_denda` bigint UNSIGNED NOT NULL,
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status_bayar` enum('Belum Lunas','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `keterangan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_bayar` timestamp NULL DEFAULT NULL,
  `metode_bayar` enum('Tunai','QRIS','Transfer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`id_denda`, `id_pengembalian`, `nip`, `jumlah_denda`, `status_bayar`, `keterangan`, `tgl_bayar`, `metode_bayar`, `created_at`, `updated_at`) VALUES
(1, 2, '1995031202', '153000.00', 'Lunas', 'Terlambat, Hilang', '2026-11-06 04:35:20', 'Tunai', '2026-11-06 04:34:54', '2026-11-06 04:35:20'),
(2, 3, '1995031202', '78000.00', 'Lunas', 'Terlambat, Rusak', '2026-11-06 04:41:28', 'Tunai', '2026-11-06 04:41:11', '2026-11-06 04:41:28'),
(3, 4, '1995031202', '150000.00', 'Belum Lunas', 'Hilang', NULL, NULL, '2026-11-08 01:12:46', '2026-11-08 01:12:46');

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
(1, 1, '250001', 1, '2026-11-06 04:28:30', '2026-11-06 04:28:30'),
(2, 2, '250001', 1, '2026-11-06 04:35:57', '2026-11-06 04:35:57'),
(3, 3, '250001', 1, '2026-11-08 01:10:34', '2026-11-08 01:10:34');

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
-- Table structure for table `kondisi_buku_kembali`
--

CREATE TABLE `kondisi_buku_kembali` (
  `id_kondisi` bigint UNSIGNED NOT NULL,
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `kode_buku` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat','Hilang') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Baik',
  `denda_fisik` decimal(10,2) NOT NULL DEFAULT '0.00',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kondisi_buku_kembali`
--

INSERT INTO `kondisi_buku_kembali` (`id_kondisi`, `id_pengembalian`, `kode_buku`, `kondisi`, `denda_fisik`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 2, '250001', 'Hilang', '150000.00', NULL, '2026-11-06 04:34:54', '2026-11-06 04:34:54'),
(3, 3, '250001', 'Rusak Berat', '75000.00', NULL, '2026-11-06 04:41:11', '2026-11-06 04:41:11'),
(4, 4, '250001', 'Hilang', '150000.00', NULL, '2026-11-08 01:12:46', '2026-11-08 01:12:46');

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
('230101001', 'Ahmad Rizki', 'Teknik Informatika', '2023', '081234567890', 'rizki@student.ac.id', 1, '2026-11-06 04:26:36', '2026-11-06 04:26:36');

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
(11, '2026_11_06_080523_create_kondisi_buku_kembali_table', 1);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `nim`, `nip`, `tgl_pinjam`, `tgl_tenggat`, `jumlah_perpanjang`, `status`, `created_at`, `updated_at`) VALUES
(1, '230101001', '1995031202', '2026-11-06', '2026-11-27', 1, 'Selesai', '2026-11-06 04:28:30', '2026-11-06 04:34:54'),
(2, '230101001', '1995031202', '2026-11-06', '2026-11-20', 0, 'Selesai', '2026-11-06 04:35:57', '2026-11-06 04:41:11'),
(3, '230101001', '1995031202', '2026-11-08', '2026-11-29', 1, 'Selesai', '2026-11-08 01:10:34', '2026-11-08 01:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `nip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_kembali` date NOT NULL,
  `terlambat_hari` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_peminjaman`, `nip`, `tgl_kembali`, `terlambat_hari`, `created_at`, `updated_at`) VALUES
(2, 1, '1995031202', '2026-11-30', 3, '2026-11-06 04:34:54', '2026-11-06 04:34:54'),
(3, 2, '1995031202', '2026-11-23', 3, '2026-11-06 04:41:11', '2026-11-06 04:41:11'),
(4, 3, '1995031202', '2026-11-08', 0, '2026-11-08 01:12:46', '2026-11-08 01:12:46');

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`nip`, `nama`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
('1992011001', 'Budi Santoso (Admin)', 'admin@kampus.ac.id', '$2y$10$eFayLot5OdzOef5AGYm9weGKW.DZ1i5YDChv1fIDQsClEARQCyhOS', 'Admin', 'JSVrv430DCvEsRl16KdYBWbRieocOnchIXcFgLjgdtwDmJ3BulxfjAuh0whR', '2026-11-06 04:26:36', '2026-11-06 04:26:36'),
('1995031202', 'Siti Rahma (Pustakawan)', 'pustakawan@kampus.ac.id', '$2y$10$9fxrnUwqXRyu6T8AQNH2OOxYCbS5B43NEWZ03Sd.qNgjG.7u.XC92', 'Pustakawan', 'HHMjgJDITpCtayr2jzGDZRUOyYSfvtBzrn2J93EnjE5RfT1USzczkclpkrGd', '2026-11-06 04:26:36', '2026-11-06 04:26:36');

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
-- Indexes for table `kondisi_buku_kembali`
--
ALTER TABLE `kondisi_buku_kembali`
  ADD PRIMARY KEY (`id_kondisi`),
  ADD KEY `kondisi_buku_kembali_id_pengembalian_foreign` (`id_pengembalian`),
  ADD KEY `kondisi_buku_kembali_kode_buku_foreign` (`kode_buku`);

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
  ADD UNIQUE KEY `pengembalian_id_peminjaman_unique` (`id_peminjaman`),
  ADD KEY `pengembalian_nip_foreign` (`nip`);

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
  MODIFY `id_denda` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kondisi_buku_kembali`
--
ALTER TABLE `kondisi_buku_kembali`
  MODIFY `id_kondisi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `kondisi_buku_kembali`
--
ALTER TABLE `kondisi_buku_kembali`
  ADD CONSTRAINT `kondisi_buku_kembali_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalian` (`id_pengembalian`) ON DELETE CASCADE,
  ADD CONSTRAINT `kondisi_buku_kembali_kode_buku_foreign` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode_buku`) ON DELETE RESTRICT ON UPDATE CASCADE;

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
  ADD CONSTRAINT `pengembalian_nip_foreign` FOREIGN KEY (`nip`) REFERENCES `users` (`nip`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
