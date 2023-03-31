-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2018 at 06:31 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mercedes`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `id` int(11) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tgl_lahir` date NOT NULL,
  `kd_divisi` varchar(12) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `tgl_masuk_karyawan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_karyawan`
--

INSERT INTO `data_karyawan` (`id`, `nik`, `nama_karyawan`, `jenis_kelamin`, `tgl_lahir`, `kd_divisi`, `jabatan`, `tgl_masuk_karyawan`) VALUES
(1, '100013', 'Ahmad Shiddiq MelFarros', 'L', '1996-05-18', 'HK', 'Staff', '2017-09-16'),
(2, '100023', 'Muhammad Bagus Santoso', 'L', '1995-11-14', 'HK', 'Supervisor', '2013-07-04'),
(3, '100067', 'Raka Nugroho', 'L', '1989-07-18', 'OBOG', 'Manager', '2010-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mst_cuti_detail`
--

CREATE TABLE `tbl_mst_cuti_detail` (
  `id` int(11) NOT NULL,
  `kd_cuti_head` varchar(5) NOT NULL,
  `kd_cuti_dtl` varchar(5) NOT NULL COMMENT 'Kode Detail jenis Cuti',
  `detail_cuti` varchar(25) NOT NULL COMMENT 'Detail Jenis Cuti',
  `jml_hari` int(11) NOT NULL COMMENT 'Hak hari'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_mst_cuti_detail`
--

INSERT INTO `tbl_mst_cuti_detail` (`id`, `kd_cuti_head`, `kd_cuti_dtl`, `detail_cuti`, `jml_hari`) VALUES
(1, 'C1', 'CD1', 'CUTI TAHUNAN', 12),
(2, 'C2', 'CD2', 'SAKIT', 0),
(3, 'C3', 'CD3', 'IJIN', 0),
(4, 'C4', 'CD4', 'CUTI BESAR', 6),
(5, 'C5', 'CD5', 'PERNIKAHAN', 3),
(6, 'C5', 'CD5', 'PERNIKAHAN ANAK', 2),
(7, 'C5', 'CD6', 'ISTRI MELAHIRKAN / KEGUGU', 2),
(8, 'C5', 'CD7', 'KEMATIAN ISTRI / SUAMI / ', 2),
(9, 'C5', 'CD8', 'KEMATIAN ORANGTUA / MERTU', 2),
(10, 'C5', 'CD9', 'KHITANAN / PEMBAPTISAN', 2),
(11, 'C5', 'CD10', 'KELUARGA SATU RUMAH MENIN', 1),
(12, 'C5', 'CD11', 'IBADAH HAJI', 40),
(13, 'C5', 'CD12', 'MELAHIRKAN', 90),
(14, 'C5', 'CD13', 'KEGUGURAN', 45),
(15, 'C6', 'CD14', 'KEGUGURAN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan_cuti`
--

CREATE TABLE `tbl_pengajuan_cuti` (
  `id` int(11) NOT NULL,
  `kd_pengajuan_cuti` varchar(10) NOT NULL,
  `tgl_pengajuan_cuti` datetime NOT NULL,
  `tgl_cuti_awal` date NOT NULL,
  `tgl_cuti_akhir` date NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `sisa_cuti` int(11) NOT NULL,
  `sisa_cuti_khusus` int(11) NOT NULL,
  `jenis_cuti` enum('C1','C2','C3','C4','C5','C6') NOT NULL,
  `jenis_cuti_detail` text NOT NULL,
  `penjelasan_cuti` text NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `kd_divisi` varchar(10) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `petugas_pengganti` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_cuti`
--

INSERT INTO `tbl_pengajuan_cuti` (`id`, `kd_pengajuan_cuti`, `tgl_pengajuan_cuti`, `tgl_cuti_awal`, `tgl_cuti_akhir`, `jumlah_hari`, `sisa_cuti`, `sisa_cuti_khusus`, `jenis_cuti`, `jenis_cuti_detail`, `penjelasan_cuti`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `petugas_pengganti`, `created_at`, `updated_at`) VALUES
(1, 'CUTI001', '2018-11-23 00:00:00', '2018-11-19', '2018-11-21', 5, 9, 0, 'C2', 'Cuti Pernikahan (3 Hari)', 'Mau Nikah', 'Farros', '100013', 'HK', '', 'Bagus', '2018-11-27 16:47:59', NULL),
(2, 'CUTI002', '2018-11-28 00:00:00', '2018-12-01', '2018-12-02', 2, 0, 0, 'C5', '', '', 'Bagus', '100023', 'HK', '', 'Farros', '2018-11-27 17:27:33', NULL),
(4, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 2, 1, 0, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HK', 'MANAGER', 'Ucok', '2018-11-27 16:52:47', '2018-11-22 06:52:40'),
(5, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 2, 2, 0, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HK', 'MANAGER', 'Ucok', '2018-11-25 01:52:17', '2018-11-25 01:52:17'),
(6, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 4, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HRGA', 'MANAGER', 'Ucok', '2018-11-25 06:48:53', '2018-11-25 06:48:53'),
(7, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 4, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HRGA', 'MANAGER', 'Ucok', '2018-11-25 06:59:47', '2018-11-25 06:59:47'),
(8, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 4, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HRGA', 'MANAGER', 'Ucok', '2018-11-25 07:00:46', '2018-11-25 07:00:46'),
(9, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 4, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'Farros Siregar', '100013', 'HRGA', 'MANAGER', 'Ucok', '2018-11-25 07:04:42', '2018-11-25 07:04:42'),
(10, 'TEST003', '2018-12-11 00:00:00', '2018-11-01', '2018-12-31', 3, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'Raka Nugroho', '100067', 'OBOG', 'Manager', 'Ucok', '2018-11-26 00:36:42', '2018-11-26 00:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan_ijin`
--

CREATE TABLE `tbl_pengajuan_ijin` (
  `id` int(11) NOT NULL,
  `kd_pengajuan_ijin` varchar(10) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `kd_divisi` varchar(20) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `tgl_ijin_awal` datetime NOT NULL,
  `tgl_ijin_akhir` datetime NOT NULL,
  `tgl_pengajuan_ijin` datetime NOT NULL,
  `tindak_lanjut` varchar(20) NOT NULL,
  `keterangan_ijin` text NOT NULL,
  `mngr_app` enum('Y','N') DEFAULT NULL,
  `mngr_app_time` datetime DEFAULT NULL,
  `mngr_app_name` varchar(30) DEFAULT NULL,
  `hrd_app` enum('Y','N') DEFAULT NULL,
  `hrd_app_time` datetime DEFAULT NULL,
  `hrd_app_name` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_ijin`
--

INSERT INTO `tbl_pengajuan_ijin` (`id`, `kd_pengajuan_ijin`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `tgl_ijin_awal`, `tgl_ijin_akhir`, `tgl_pengajuan_ijin`, `tindak_lanjut`, `keterangan_ijin`, `mngr_app`, `mngr_app_time`, `mngr_app_name`, `hrd_app`, `hrd_app_time`, `hrd_app_name`, `created_at`, `updated_at`) VALUES
(1, 'IJN1811001', 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:18:42', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:18:42', '2018-11-27 23:18:42'),
(2, 'IJN1811001', 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:21:18', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:21:18', '2018-11-27 23:21:18'),
(3, 'IJN1811001', 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:21:42', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:21:42', '2018-11-27 23:21:42'),
(4, 'IJN1811001', 'Farros Siregar', '100013', 'HK', 'Staff', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-27 23:50:02', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:50:02', '2018-11-27 23:50:02'),
(5, 'IJN1811001', 'Farros Siregar', '100013', 'HK', 'Staff', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-27 23:55:50', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:55:50', '2018-11-27 23:55:50'),
(6, 'IJN1811001', 'Farros Siregar', '100013', 'HK', 'Staff', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-27 23:59:27', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:59:27', '2018-11-27 23:59:27'),
(7, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:23:49', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:23:49', '2018-11-28 00:23:49'),
(8, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:25:50', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:25:50', '2018-11-28 00:25:50'),
(9, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:25:54', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:25:54', '2018-11-28 00:25:54'),
(10, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:26:41', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:26:41', '2018-11-28 00:26:41'),
(11, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:26:57', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:26:57', '2018-11-28 00:26:57'),
(12, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:27:28', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:27:28', '2018-11-28 00:27:28'),
(13, 'IJN1811001', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:27:33', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-28 00:27:34', '2018-11-28 00:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan_lembur`
--

CREATE TABLE `tbl_pengajuan_lembur` (
  `id` int(11) NOT NULL,
  `kd_pengajuan_lembur` varchar(10) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` int(11) NOT NULL,
  `kd_divisi` varchar(10) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `tgl_lembur_awal` datetime NOT NULL,
  `tgl_lembur_akhir` datetime NOT NULL,
  `tgl_pengajuan_lembur` datetime NOT NULL,
  `tindak_lanjut` enum('POTONG CUTI','POTONG INTENSIF','EXTRA CUTI') NOT NULL,
  `jenis_lembur` enum('L','K') NOT NULL,
  `keterangan_lembur` text NOT NULL,
  `mngr_app` enum('Y','N') DEFAULT NULL,
  `mngr_app_time` datetime DEFAULT NULL,
  `mngr_app_name` varchar(30) DEFAULT NULL,
  `hrd_app` enum('Y','N') DEFAULT NULL,
  `hrd_app_time` datetime DEFAULT NULL,
  `hrd_app_name` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_lembur`
--

INSERT INTO `tbl_pengajuan_lembur` (`id`, `kd_pengajuan_lembur`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `tgl_lembur_awal`, `tgl_lembur_akhir`, `tgl_pengajuan_lembur`, `tindak_lanjut`, `jenis_lembur`, `keterangan_lembur`, `mngr_app`, `mngr_app_time`, `mngr_app_name`, `hrd_app`, `hrd_app_time`, `hrd_app_name`, `created_at`, `updated_at`) VALUES
(1, 'LBR1811002', 'Raka', 123456, 'OBOG', '', '2018-11-26 17:00:00', '2018-11-26 21:30:00', '2018-11-24 00:00:00', '', 'L', 'LG BANYAK KERJAAN', 'Y', '0000-00-00 00:00:00', 'Manager', 'Y', '0000-00-00 00:00:00', 'HRD', '2018-11-25 15:42:00', '0000-00-00 00:00:00'),
(2, 'LBR1811001', 'Farros Siregar', 100013, 'OBOG', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-25 08:48:55', 'POTONG INTENSIF', 'K', 'MAU LEMBUR', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-25 08:48:55', '2018-11-25 08:48:55'),
(3, 'LBR1811001', 'Farros Siregar', 100013, 'Purchasing', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-25 08:51:52', 'POTONG CUTI', 'K', 'MAU LEMBUR', NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-25 08:51:52', '2018-11-25 08:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `test_table`
--

CREATE TABLE `test_table` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_table`
--

INSERT INTO `test_table` (`id`, `nama_karyawan`, `nik`, `created_at`, `updated_at`) VALUES
(1, 'jyguygtu', 'nmbnmb', '2018-11-22 05:30:02', '2018-11-22 05:30:02'),
(2, 'test', 'test', '2018-11-22 05:57:35', '2018-11-22 05:57:35'),
(3, 'jhghjg', 'mbvmnhb', '2018-11-22 05:58:21', '2018-11-22 05:58:21'),
(4, 'YYY', 'MMM', '2018-11-22 06:21:44', '2018-11-22 06:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(115, 'admin', 'admin@me.com', '$2y$10$IEme9BNfvZhnDepD2FmgvOE6hYqKKOOuxlZCA39hECfoX2OBbFQmW', 'db5QbbU1Oxcr7OL6uhdlUEgSNz0SrNGvesKVZfkYgWZCP5Me98RnD4v8zJS7', '2018-11-17 14:10:30', '2018-11-17 07:10:16'),
(116, 'farros', 'farros@admin.me', '$2y$10$l0NPs8yQimgATnpHD.J.VecoBf6/bWjAU7eoFgxIsjlrT5MF6hO26', 'o38DAWRumxsY8P1KEDTtAJBRVye1a8yvC40Ms8D54GHlA12fFCeVcXTJtiFF', '2018-11-25 09:03:32', '2018-11-18 06:04:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mst_cuti_detail`
--
ALTER TABLE `tbl_mst_cuti_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengajuan_cuti`
--
ALTER TABLE `tbl_pengajuan_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengajuan_ijin`
--
ALTER TABLE `tbl_pengajuan_ijin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengajuan_lembur`
--
ALTER TABLE `tbl_pengajuan_lembur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_table`
--
ALTER TABLE `test_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mst_cuti_detail`
--
ALTER TABLE `tbl_mst_cuti_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_cuti`
--
ALTER TABLE `tbl_pengajuan_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_ijin`
--
ALTER TABLE `tbl_pengajuan_ijin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_lembur`
--
ALTER TABLE `tbl_pengajuan_lembur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test_table`
--
ALTER TABLE `test_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
