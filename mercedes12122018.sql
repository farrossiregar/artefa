-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2018 at 04:23 AM
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
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `kd` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `wjm` varchar(50) DEFAULT NULL,
  `wjk` varchar(50) DEFAULT NULL,
  `mlate` varchar(50) DEFAULT NULL,
  `mleft` varchar(50) DEFAULT NULL,
  `prly` varchar(50) DEFAULT NULL,
  `wkhr` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `bulan` int(11) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`kd`, `id`, `date`, `nik`, `dept_id`, `wjm`, `wjk`, `mlate`, `mleft`, `prly`, `wkhr`, `keterangan`, `bulan`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 1849, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(2, 1850, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(3, 1851, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(4, 1852, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(5, 1853, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '477', NULL, 10, 2018, NULL, NULL),
(6, 1854, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '251', NULL, 10, 2018, NULL, NULL),
(7, 1855, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(8, 1856, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(9, 1857, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '472', NULL, 10, 2018, NULL, NULL),
(10, 1858, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '451', NULL, 10, 2018, NULL, NULL),
(11, 1859, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '471', NULL, 10, 2018, NULL, NULL),
(12, 1860, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '297', NULL, 10, 2018, NULL, NULL),
(13, 1861, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(14, 1862, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '465', NULL, 10, 2018, NULL, NULL),
(15, 1863, NULL, '100183', 9, NULL, NULL, '0', '0', '0', '0', 'Cuti', 10, 2018, NULL, NULL),
(16, 1756, NULL, '100002', 9, '07:15', '16:00', '15', '0', '0', '515', NULL, 10, 2018, NULL, NULL),
(17, 1757, NULL, '100002', 9, '07:30', '15:00', '30', '0', '0', '478', NULL, 10, 2018, NULL, NULL),
(18, 1758, NULL, '100002', 9, '06:00', '13:00', '0', '0', '120', '479', NULL, 10, 2018, NULL, NULL),
(19, 1759, NULL, '100002', 9, '07:00', '16:00', '0', '0', '0', '468', NULL, 10, 2018, NULL, NULL),
(20, 1760, NULL, '100002', 9, '07:00', '15:09', '0', '0', '0', '473', NULL, 10, 2018, NULL, NULL),
(21, 1761, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '158', NULL, 10, 2018, NULL, NULL),
(22, 1762, NULL, '100002', 9, '12:00', '15:00', '300', '0', '0', '284', '- Cuti 0.5', 10, 2018, NULL, NULL),
(23, 1763, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '488', NULL, 10, 2018, NULL, NULL),
(24, 1764, NULL, '100002', 9, NULL, NULL, '0', '0', '0', '0', 'Sakit', 10, 2018, NULL, NULL),
(25, 1765, NULL, '100002', 9, NULL, NULL, '0', '0', '0', '0', 'Sakit', 10, 2018, NULL, NULL),
(26, 1766, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '470', NULL, 10, 2018, NULL, NULL),
(27, 1767, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '330', NULL, 10, 2018, NULL, NULL),
(28, 1768, NULL, '100002', 9, NULL, NULL, '0', '0', '0', '480', 'Pameran', 10, 2018, NULL, NULL),
(29, 1769, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(30, 1770, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(31, 1771, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(32, 1772, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(33, 1773, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '360', NULL, 10, 2018, NULL, NULL),
(34, 1774, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(35, 1775, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(36, 1776, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(37, 1777, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(38, 1778, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '475', NULL, 10, 2018, NULL, NULL),
(39, 1779, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '153', NULL, 10, 2018, NULL, NULL),
(40, 1780, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(41, 1781, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(42, 1782, NULL, '100002', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(43, 1783, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '472', NULL, 10, 2018, NULL, NULL),
(44, 1784, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '476', NULL, 10, 2018, NULL, NULL),
(45, 1785, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '490', NULL, 10, 2018, NULL, NULL),
(46, 1786, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '474', NULL, 10, 2018, NULL, NULL),
(47, 1787, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '475', NULL, 10, 2018, NULL, NULL),
(48, 1788, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '325', NULL, 10, 2018, NULL, NULL),
(49, 1789, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(50, 1790, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(51, 1791, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(52, 1792, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(53, 1793, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(54, 1794, NULL, '100017', 9, '09:00', '15:00', '120', '0', '0', '360', NULL, 10, 2018, NULL, NULL),
(55, 1795, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(56, 1796, NULL, '100017', 9, '08:03', '15:00', '63', '0', '0', '467', NULL, 10, 2018, NULL, NULL),
(57, 1797, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '468', NULL, 10, 2018, NULL, NULL),
(58, 1798, NULL, '100017', 9, '08:00', '15:00', '60', '0', '0', '468', NULL, 10, 2018, NULL, NULL),
(59, 1799, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '472', NULL, 10, 2018, NULL, NULL),
(60, 1800, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '322', NULL, 10, 2018, NULL, NULL),
(61, 1801, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(62, 1802, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(63, 1803, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(64, 1804, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(65, 1805, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(66, 1806, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '360', NULL, 10, 2018, NULL, NULL),
(67, 1807, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '458', NULL, 10, 2018, NULL, NULL),
(68, 1808, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '475', NULL, 10, 2018, NULL, NULL),
(69, 1809, NULL, '100017', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(70, 1810, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(71, 1811, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(72, 1812, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(73, 1813, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(74, 1814, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(75, 1815, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '360', NULL, 10, 2018, NULL, NULL),
(76, 1816, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '471', NULL, 10, 2018, NULL, NULL),
(77, 1817, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '472', NULL, 10, 2018, NULL, NULL),
(78, 1818, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '471', NULL, 10, 2018, NULL, NULL),
(79, 1819, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '478', NULL, 10, 2018, NULL, NULL),
(80, 1820, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(81, 1821, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '146', NULL, 10, 2018, NULL, NULL),
(82, 1822, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(83, 1823, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(84, 1824, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(85, 1825, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(86, 1826, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(87, 1827, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '360', NULL, 10, 2018, NULL, NULL),
(88, 1828, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '471', NULL, 10, 2018, NULL, NULL),
(89, 1829, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '471', NULL, 10, 2018, NULL, NULL),
(90, 1830, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '482', NULL, 10, 2018, NULL, NULL),
(91, 1831, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '479', NULL, 10, 2018, NULL, NULL),
(92, 1832, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '481', NULL, 10, 2018, NULL, NULL),
(93, 1833, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '327', NULL, 10, 2018, NULL, NULL),
(94, 1834, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(95, 1835, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(96, 1836, NULL, '100131', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(97, 1837, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(98, 1838, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(99, 1839, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(100, 1840, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '477', NULL, 10, 2018, NULL, NULL),
(101, 1841, NULL, '100183', 9, '12:00', '15:00', '300', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(102, 1842, NULL, '100183', 9, NULL, NULL, '0', '0', '0', '0', 'Cuti', 10, 2018, NULL, NULL),
(103, 1843, NULL, '100183', 9, NULL, NULL, '0', '0', '0', '0', 'Cuti', 10, 2018, NULL, NULL),
(104, 1844, NULL, '100183', 9, NULL, NULL, '0', '0', '0', '0', 'Cuti', 10, 2018, NULL, NULL),
(105, 1845, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(106, 1846, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(107, 1847, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '480', NULL, 10, 2018, NULL, NULL),
(108, 1848, NULL, '100183', 9, '07:00', '15:00', '0', '0', '0', '348', NULL, 10, 2018, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_hak_cuti`
--

CREATE TABLE `data_hak_cuti` (
  `id` int(11) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `sisa_cuti_tahunan` int(11) NOT NULL,
  `sisa_cuti_khusus` int(11) NOT NULL,
  `sisa_cuti_besar` int(11) NOT NULL,
  `tgl_masuk_karyawan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_hak_cuti`
--

INSERT INTO `data_hak_cuti` (`id`, `tahun`, `nama_karyawan`, `nik`, `sisa_cuti_tahunan`, `sisa_cuti_khusus`, `sisa_cuti_besar`, `tgl_masuk_karyawan`) VALUES
(1, '2018', 'Ahmad Shiddiq MelFarros', '100013', 11, 54, 0, '2017-09-16'),
(2, '2018', 'Raka Nugroho', '100067', 5, 48, 12, '2013-07-04'),
(3, '2018', 'Muhammad Bagus Santoso', '100023', 8, 54, 0, '2010-12-20'),
(4, '2018', 'SILVIA ISTIQOMAH', '100356', 6, 32, 60, '2012-06-10');

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
-- Table structure for table `departements`
--

CREATE TABLE `departements` (
  `id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departements`
--

INSERT INTO `departements` (`id`, `department`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'Management', 'Management', NULL, NULL),
(2, 'Body Repair & Paint', 'Body Repair & Paint', NULL, NULL),
(3, 'Customer Care', 'Customer Care', NULL, NULL),
(4, 'Facility', 'Facility', NULL, NULL),
(5, 'Finance & Accounting', 'Finance & Accounting', NULL, NULL),
(6, 'HRGA', 'Housekeeping', NULL, NULL),
(7, 'HRGA', 'HRGA Office', NULL, NULL),
(8, 'IT & Warranty', 'IT & Warranty', NULL, NULL),
(9, 'HRGA', 'OBOG & Bargater', NULL, NULL),
(10, 'Purchasing', 'Purchasing', NULL, NULL),
(11, 'Sales & Marketing', 'Car Maintenance', NULL, NULL),
(12, 'Sales & Marketing', 'Sales & Marketing', NULL, NULL),
(13, 'Proven Exclusivity', 'Sales & Marketing', NULL, NULL),
(14, 'Service', 'Service', NULL, NULL),
(15, 'Spare Part', 'Spare Part', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `direct_supervisor` varchar(255) DEFAULT NULL,
  `next_higher_supervisor` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `dept_id`, `nama`, `nik`, `level`, `jabatan`, `direct_supervisor`, `next_higher_supervisor`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'HENDRIK TAYA', '100164', 'Management', 'CFO', 'RIZWAN HALIM', 'RIZWAN HALIM', 1, NULL, NULL),
(2, 1, 'RIZWAN HALIM', '100113', 'Management', 'Direktur Utama', '', '', 1, NULL, NULL),
(3, 1, 'IR LISA CHRISTIANTI WIJAYA', '100293', 'Management', 'General Manager', 'RIZWAN HALIM', 'RIZWAN HALIM', 1, NULL, NULL),
(4, 2, 'RUDY KUSMANTO', 'G100309', 'Manager', 'Body Repair, Paint & Facility Manager', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(5, 2, 'SUDI', '100058', 'Supervisor', 'Body Repair Supervisor', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(6, 2, 'MALIASRI SUPRIL', 'G100334', 'Staff', 'Welding Staff', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(7, 2, 'MOCH IDRIS', 'G100332', 'Staff', 'Body Parts Technicia', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(8, 2, 'ASEP MUNAWAR', 'G100329', 'Staff', 'Detailer Technicia', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(9, 2, 'FAJRI SURYADI', '100184', 'Staff', 'Detailer Technicia', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(10, 2, 'MUHAMAD NURHASA', 'G100434', 'Staff', 'Detailer Technicia', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(11, 2, 'HERI KUSMANTO', 'G100435', 'Staff', 'Car Washer', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(12, 2, 'ROBY SUGARA', 'G100343', 'Staff', 'Car Washer', 'SUDI', 'RUDY KUSMANTO', 1, NULL, NULL),
(13, 2, 'AGUS SANJAYA', 'G100433', 'Supervisor', 'Paint Specialist Supervisor', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(14, 2, 'JAJANG KUSWANDI', '100270', 'Staff', 'Paint Preparation Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(15, 2, 'ANGGA DWI CAHYA MAULANA', 'G100371', 'Staff', 'Paint Preparation Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(16, 2, 'FAKHRY AL FATAH', 'G100404', 'Staff', 'Paint Mixing Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(17, 2, 'IDING', 'G100346', 'Staff', 'Painter Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(18, 2, 'IMAN ABDUL RAJAB', 'G100406', 'Staff', 'Painter Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(19, 2, 'WAHID', 'G100339', 'Staff', 'Putty Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(20, 2, 'SUPARDI', 'G100376', 'Staff', 'Putty Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(21, 2, 'AHMAD SUPRIYANTO', 'G100438', 'Staff', 'Putty Staff', 'AGUS SANJAYA', 'RUDY KUSMANTO', 1, NULL, NULL),
(22, 2, 'INDAH WINANDATI', '100039', 'Staff', 'Service Administratio', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(23, 2, 'ARIS SUMANTRI', '100316', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(24, 2, 'BITARI FEBRIYANI', 'G100349', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(25, 2, 'SAPTONO', '100279', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(26, 2, 'IKHLAS KRISTIA', '100250', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(27, 2, 'JUNAEDI ABDULLAH HS', '100280', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(28, 2, 'EDY SUMANTO', 'G100398', 'Non Staff', 'Housekeeping Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(29, 2, 'CUT MUHIDI', '100046', 'Staff', 'Mechanical Electrical Staff', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(30, 2, 'GUSTAMA', 'G100369', 'Staff', 'Driver', 'INDAH WINANDATI', 'RUDY KUSMANTO', 1, NULL, NULL),
(31, 2, 'WINDA NIKMATUL MAULA', 'G100383', 'Staff', 'Final Controller', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(32, 2, 'RATNA FEBRIANI', '100246', 'Staff', 'Workshop Administrator/Parts Staff', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(33, 2, 'NURANDI HEHI', 'G100344', 'Staff', 'Parts Staff', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(34, 2, 'SANDY ARIFUZZAMA', 'G100342', 'Staff', 'Parts Staff', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(35, 2, 'ZULFI ANITA', '100200', 'Staff', 'Customer Care Sales', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(36, 2, 'SRI SUPATMI', 'G100330', 'Staff', 'Service Consultant', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(37, 2, 'RAHMAT IKHSA', 'G100440', 'Staff', 'Service Consultant', 'RUDY KUSMANTO', 'RUDY KUSMANTO', 1, NULL, NULL),
(38, 3, 'TRI MULIANI', '100314', 'Staff', 'Customer Care After Sales', 'IKA RESTU ANDINI', 'IKA RESTU ANDINI', 1, NULL, NULL),
(39, 3, 'FITRI APRILIANI', '100363', 'Staff', 'Customer Care Sales', 'IKA RESTU ANDINI', 'IKA RESTU ANDINI', 1, NULL, NULL),
(40, 3, 'IKA RESTU ANDINI', '100256', 'Supervisor', 'Customer Care Spv', 'IKA RESTU ANDINI', 'IKA RESTU ANDINI', 1, NULL, NULL),
(41, 3, 'IIS INDRA SUCI NURDI', '100187', 'Staff', 'Operator Telepo', 'IKA RESTU ANDINI', 'IKA RESTU ANDINI', 1, NULL, NULL),
(42, 3, 'NURMAYA', '100225', 'Staff', 'Operator Telepo', 'IKA RESTU ANDINI', 'IKA RESTU ANDINI', 1, NULL, NULL),
(43, 4, 'BAMBANG HERYANTO', '100001', 'Manager', 'Facility Manager', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(44, 4, 'PONIMA', '100051', 'Staff', 'Mechanical Electrical Leader', 'BAMBANG HERYANTO', 'BAMBANG HERYANTO', 1, NULL, NULL),
(45, 4, 'MUHAMAD NASIR', '100012', 'Staff', 'Mechanical Electrical Staff', 'PONIMA', 'BAMBANG HERYANTO', 1, NULL, NULL),
(46, 4, 'MUSLIM', '100026', 'Staff', 'Mechanical Electrical Staff', 'PONIMA', 'BAMBANG HERYANTO', 1, NULL, NULL),
(47, 4, 'NOER SYAIFUL AKBAR', '100028', 'Staff', 'Mechanical Electrical Staff', 'PONIMA', 'BAMBANG HERYANTO', 1, NULL, NULL),
(48, 4, 'SUPARDI ME', '100403', 'Staff', 'Mechanical Electrical Staff', 'PONIMA', 'BAMBANG HERYANTO', 1, NULL, NULL),
(49, 5, 'IRVAN DERMAWA', '100436', 'Manager', 'Finance & Accounting Manager', 'HENDRIK TAYA', 'HENDRIK TAYA', 1, NULL, NULL),
(50, 5, 'BAMBANG WAHYU TRI H SE', '100372', 'Supervisor', 'Assistant Accounting Manager', 'IRVAN DERMAWA', 'IRVAN DERMAWA', 1, NULL, NULL),
(51, 5, 'YULIAWATI', '100413', 'Staff', 'Accounting & Tax Staff', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(52, 5, 'ANNISA JULIANA', '100374', 'Staff', 'Accounting Staff', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(53, 5, 'AISHA HESTININGRUM', '100400', 'Staff', 'Accounting Staff', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(54, 5, 'SUKARWO', '100231', 'Staff', 'Administration Staff', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(55, 5, 'KUSUMAWATI', '100368', 'Supervisor', 'Finance Supervisor', 'IRVAN DERMAWA', 'IRVAN DERMAWA', 1, NULL, NULL),
(56, 5, 'SILVIA ISTIQOMAH', '100356', 'Staff', 'Finance Staff', 'KUSUMAWATI', 'IRVAN DERMAWA', 1, NULL, NULL),
(57, 5, 'SUSI ARIYANTI', '100418', 'Staff', 'Finance Staff', 'KUSUMAWATI', 'IRVAN DERMAWA', 1, NULL, NULL),
(58, 5, 'TRI PURWANTI', '100426', 'Staff', 'Finance Staff (AP)', 'KUSUMAWATI', 'IRVAN DERMAWA', 1, NULL, NULL),
(59, 5, 'IIL ILAWATI', '100035', 'Staff', 'Cashier', 'KUSUMAWATI', 'IRVAN DERMAWA', 1, NULL, NULL),
(60, 5, 'ISMA SEPTIANA', '100075', 'Staff', 'Cashier', 'KUSUMAWATI', 'IRVAN DERMAWA', 1, NULL, NULL),
(61, 5, 'MUHAMMAD SOLIHI', '100213', 'Staff', 'Administration Staff', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(62, 5, 'BASUKI ARISANTO', '100014', 'Non Staff', 'Messenger', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(63, 5, 'DJOHANA', '100337', 'Non Staff', 'Messenger', 'BAMBANG WAHYU TRI H SE', 'IRVAN DERMAWA', 1, NULL, NULL),
(64, 6, 'AGUNG PRIYONO', '100278', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(65, 6, 'ASUM', '100386', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(66, 6, 'ERWI', '100068', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(67, 6, 'HIDAYAT PARDANI', '100269', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(68, 6, 'MARDIANA', '100013', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(69, 6, 'MUHAMMAD ALIEP MUKLIS', '100160', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(70, 6, 'NUR AMINUDI', '100308', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(71, 6, 'RUDI SAPUTRA', '100315', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(72, 6, 'SLAMET RIYADI', '100111', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(73, 6, 'SOFA FADILA', '100212', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(74, 6, 'MOH KOSIM', '100023', 'Non Staff', 'Leader Housekeeping', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(75, 6, 'SITI KOMALASARI', '100048', 'Non Staff', 'Leader Housekeeping', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(76, 6, 'MUHAMAD IQBAL ANUGRAH', '100416', 'Non Staff', 'Housekeeping Staff', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(77, 7, 'ZAKKIYA ULFA', '100427', 'Staff', 'Recruitment & Dev. Officer', 'USEP GANDARA', 'USEP GANDARA', 1, NULL, NULL),
(78, 7, 'ROMI DHARMAWA', '100431', 'Staff', 'GA Staff', 'USEP GANDARA', 'USEP GANDARA', 1, NULL, NULL),
(79, 7, 'RANDI OXTALIDO', '100228', 'Staff', 'C & B Staff', 'USEP GANDARA', 'USEP GANDARA', 1, NULL, NULL),
(80, 7, 'USEP GANDARA', '100405', 'Manager', 'HRGA Manager', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(81, 7, 'SISWANTO', '100003', 'Supervisor', 'Personnel & GA Supervisor', 'USEP GANDARA', 'USEP GANDARA', 1, NULL, NULL),
(82, 8, 'ROHANI ROSSELINA', '100134', 'Staff', 'ISP & Warranty Staff', 'IVANNA USFIA AGUSTI', 'IVANNA USFIA AGUSTI', 1, NULL, NULL),
(83, 8, 'SETYA KARINA', '100239', 'Staff', 'ISP & Warranty Staff', 'IVANNA USFIA AGUSTI', 'IVANNA USFIA AGUSTI', 1, NULL, NULL),
(84, 8, 'IVANNA USFIA AGUSTI', '100272', 'Manager', 'IT & Warranty Manager', 'IVANNA USFIA AGUSTI', 'IVANNA USFIA AGUSTI', 1, NULL, NULL),
(85, 8, 'RUDIYANTO', '100292', 'Staff', 'IT SAP Staff', 'IVANNA USFIA AGUSTI', 'IVANNA USFIA AGUSTI', 1, NULL, NULL),
(86, 8, 'SRISETO', '100321', 'Supervisor', 'Warranty & Workshop Supervisor', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(87, 9, 'SALEH RAMDHANI', '100016', 'Non Staff', 'Bargater', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(88, 9, 'DENI DARMAWA', '100183', 'Non Staff', 'Office Boy', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(89, 9, 'FUADI', '100002', 'Non Staff', 'Office Boy Leader', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(90, 9, 'ESTI TIDAR', '100131', 'Non Staff', 'Office Girl', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(91, 9, 'USYANI', '100017', 'Non Staff', 'Office Girl', 'SISWANTO', 'USEP GANDARA', 1, NULL, NULL),
(92, 10, 'RISTA PERMATA', '100203', 'Staff', 'GA Purchasing Staff', 'VANESSA VITA CHRISTY', 'VANESSA VITA CHRISTY', 1, NULL, NULL),
(93, 10, 'RINI YUSRIANI SE', '100067', 'Staff', 'Parts Procurement Staff', 'VANESSA VITA CHRISTY', 'VANESSA VITA CHRISTY', 1, NULL, NULL),
(94, 10, 'VANESSA VITA CHRISTY', '100411', 'Supervisor', 'Office Secretary & Purchasing Spv', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(95, 11, 'NICO FERY SETIAWA', '100077', 'Staff', 'Car Maintenance Leader', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(96, 11, 'ANDES SABRIMA', '100393', 'Staff', 'Car Maintenance', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(97, 11, 'HARI APRIADI', '100348', 'Staff', 'Car Maintenance', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(98, 11, 'FUAD HASYIM ADNA', '100100', 'Staff', 'Car Maintenance', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(99, 12, 'LAMRIA N HARIANJA', '100378', 'Staff', 'Sales Admi', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(100, 12, 'DEWI ANGGRAENY', '100297', 'Staff', 'Sales Support Staff', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(101, 12, 'SELFI FITRIA', '100432', 'Staff', 'Sales Support Staff', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(102, 12, 'BING BAHAGIANTO', '100104', 'Staff', 'Driver', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(103, 12, 'WAHYONO', '100357', 'Non Staff', 'Messenger', 'ADI RACHMA', 'ADI RACHMA', 1, NULL, NULL),
(104, 13, 'GREGORY SOEDARPO', '100305', 'Staff', 'Product Expert', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(105, 12, 'EDWIN TANDAYU', '100408', 'Supervisor', 'Marketing Communication Spv', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(106, 12, 'DEBBY ALIXIA NJO', '100323', 'Manager', 'Sales & Marketing Manager', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(107, 13, 'JOHAN ALI ABIDI', '100117', 'Staff', 'Sales Consultant', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(108, 12, 'ADI RACHMA', '100226', 'Supervisor', 'Sales Admin Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(109, 12, 'TITI SUMIATI', '100099', 'Supervisor', 'Sales Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(110, 12, 'LYDIA MAGDALENA', '100122', 'Supervisor', 'Sales Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(111, 12, 'ANDY ONG', '100254', 'Supervisor', 'Sales Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(112, 12, 'RADINA FEBRIYANTI I L', '100252', 'Supervisor', 'Sales Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(113, 12, 'LORE', '100402', 'Staff', 'Sales Counter', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(114, 12, 'MARGARETH MAYA SRI REJEKI S', '100338', 'Staff', 'Sales Counter', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(115, 12, 'EDHIE ARISMUNANDAR', '100428', 'Supervisor', 'Sales Supervisor', 'DEBBY ALIXIA NJO', 'DEBBY ALIXIA NJO', 1, NULL, NULL),
(116, 12, 'AVIEF RAHARDIA', '100340', 'Staff', 'Sales Consultant', 'TITI SUMIATI', 'TITI SUMIATI', 1, NULL, NULL),
(117, 12, 'FITRAH AL QODRI MARWEKI', '100296', 'Staff', 'Sales Consultant', 'TITI SUMIATI', 'TITI SUMIATI', 1, NULL, NULL),
(118, 12, 'HERYANTO', '100319', 'Staff', 'Sales Consultant', 'TITI SUMIATI', 'TITI SUMIATI', 1, NULL, NULL),
(119, 12, 'RIEKY', '100360', 'Staff', 'Sales Consultant', 'TITI SUMIATI', 'TITI SUMIATI', 1, NULL, NULL),
(120, 12, 'ADRIAN ARIADI', '100422', 'Staff', 'Sales Consultant', 'TITI SUMIATI', 'TITI SUMIATI', 1, NULL, NULL),
(121, 12, 'BERCE GUMILANG', '100294', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(122, 12, 'WILLY', '100414', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(123, 12, 'JESSY', '100295', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(124, 12, 'RADEA ADI PUTRA NATAWIJAYA', '100379', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(125, 12, 'TOMY HERIYANTO', '100364', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(126, 12, 'TEGUH ZULFIKAR', '100425', 'Staff', 'Sales Consultant', 'ANDY ONG', 'ANDY ONG', 1, NULL, NULL),
(127, 12, 'BIONDY IMMANUEL', '100298', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(128, 12, 'EDI CANDRA', '100358', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(129, 12, 'MUHAMMAD DYMAS YAASI', '100399', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(130, 12, 'RIZAZ PAHLAVI', '100361', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(131, 12, 'DJAP SIU MIE', '100390', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(132, 12, 'RIDIK RIYANTO', '100437', 'Staff', 'Sales Consultant', 'LYDIA MAGDALENA', 'LYDIA MAGDALENA', 1, NULL, NULL),
(133, 12, 'FRANKY HAKIM', '100347', 'Staff', 'Sales Consultant', 'RADINA FEBRIYANTI I L', 'RADINA FEBRIYANTI I L', 1, NULL, NULL),
(134, 12, 'NENGAH ARI INDRAWA', '100401', 'Staff', 'Sales Consultant', 'RADINA FEBRIYANTI I L', 'RADINA FEBRIYANTI I L', 1, NULL, NULL),
(135, 12, 'BUDI JAYA', '100421', 'Staff', 'Sales Consultant', 'RADINA FEBRIYANTI I L', 'RADINA FEBRIYANTI I L', 1, NULL, NULL),
(136, 12, 'HELMI NURDIANSYAH SHALEH', '100423', 'Staff', 'Sales Consultant', 'RADINA FEBRIYANTI I L', 'RADINA FEBRIYANTI I L', 1, NULL, NULL),
(137, 12, 'HADI NUGROHO SETIAWA', '100420', 'Staff', 'Sales Consultant', 'RADINA FEBRIYANTI I L', 'RADINA FEBRIYANTI I L', 1, NULL, NULL),
(138, 12, 'S IFAN FANEAL', '100429', 'Staff', 'Sales Consultant', 'EDHIE ARISMUNANDAR', 'EDHIE ARISMUNANDAR', 1, NULL, NULL),
(139, 12, 'EKO LUMENA', '100430', 'Staff', 'Sales Consultant', 'EDHIE ARISMUNANDAR', 'EDHIE ARISMUNANDAR', 1, NULL, NULL),
(140, 14, 'IRMANSYAH', '100185', 'Staff', 'Car Washer', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(141, 14, 'AWALUDIN ROUF', '100118', 'Staff', 'Car Washer', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(142, 14, 'DIMAS PRIYANTO', '100351', 'Staff', 'Car Washer', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(143, 14, 'SUTAN SASMITA', '100285', 'Staff', 'Car Washer', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(144, 14, 'AGUS PRASOJO MG', '100201', 'Staff', 'Driver', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(145, 14, 'AHMAD', '100083', 'Staff', 'Driver', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(146, 14, 'IRWA', '100395', 'Staff', 'Driver', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(147, 14, 'MOH SUNARDI', '100370', 'Staff', 'Driver', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(148, 14, 'RAMITO', '100220', 'Staff', 'Driver', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(149, 14, 'DEVI FORIAH', '100151', 'Staff', 'Workshop Administration Staff', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(150, 14, 'ABDUL AZIS', 'G100381', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(151, 14, 'SUHANDANI', '100008', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(152, 14, 'IEF IRAWAN TRIYADI', '100132', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(153, 14, 'ACHMAD NUR YASI', '100219', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(154, 14, 'ANANDA DRIZZA FIZHARY', '100380', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(155, 14, 'ALVIANDRE SETIAJI', '100237', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(156, 14, 'AMIN MAUZU', '100196', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(157, 14, 'ANDRI', '100021', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(158, 14, 'ANTONIUS JUMAKIR', '100157', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(159, 14, 'DIKDIK NORMANSYAH', '100101', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(160, 14, 'HENDRI PRASETYO', '100189', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(161, 14, 'NOVAN YULISTYANTO', '100382', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(162, 14, 'MOH ABDUL KARIM', '100381', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(163, 14, 'NUROKMAN SUGIANTO', '100217', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(164, 14, 'PAWIT SUGIYANTO', '100056', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(165, 14, 'RIZAL ZAENUDI', '100218', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(166, 14, 'ROHMANIATI', '100383', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(167, 14, 'SUBARDIANTO', '100249', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(168, 14, 'YULIANTOKO RUSDIONO', '100155', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(169, 14, 'ZAINUDI', '100158', 'Staff', 'Mechanic', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(170, 14, 'DANIEL HASINTONGA', '100110', 'Staff', 'Service Consultant', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(171, 14, 'HAMBALI', '100024', 'Staff', 'Service Consultant', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(172, 14, 'MUNASYAR', '100106', 'Staff', 'Service Consultant', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(173, 14, 'SUPRIYANTO', '100317', 'Staff', 'Service Consultant', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(174, 14, 'FRANCISCA HERAWATI', '100169', 'Staff', 'Service Frontline Coordinator', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(175, 14, 'CASSANDRA ALEXSTA', '100387', 'Staff', 'Service Receptio', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(176, 14, 'ILA NURLELA', '100120', 'Staff', 'Service Receptio', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(177, 14, 'ARY SENTOSO', '100006', 'Staff', 'Progress Control', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(178, 14, 'INDRA SUGIHARTO', '100007', 'Staff', 'Final Controller', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(179, 14, 'NOOR BAMBANG DJAKARIA', '100103', 'Staff', 'Final Controller', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(180, 14, 'SABAR SANTOSO', '100054', 'Staff', 'Final Controller', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(181, 14, 'KHANISUL KHUFFADZ', '100130', 'Staff', 'Time Keeper', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(182, 14, 'SUKATNO', '100038', 'Staff', 'Tool Keeper', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(183, 14, 'AZALIA ZENITANIA', '100304', 'Staff', 'Time Keeper', 'EVENDY', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(184, 14, 'SUWANTA DJAJA, IR', '100081', 'Manager', 'Workshop Manager', 'IR LISA CHRISTIANTI WIJAYA', 'IR LISA CHRISTIANTI WIJAYA', 1, NULL, NULL),
(185, 14, 'EVENDY', '100022', 'Supervisor', 'Workshop Supervisor', 'SUWANTA DJAJA, IR', 'SUWANTA DJAJA, IR', 1, NULL, NULL),
(186, 15, 'ALFONS RUDI SUNARDI', '100162', 'Staff', 'OTC Parts Sales & Parts Technique Staff', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(187, 15, 'SENTOT SURYADI', '100027', 'Supervisor', 'Spareparts Supervisor', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(188, 15, 'JEFFRY HOLIDAJA', '100336', 'Manager', 'Spare Part Manager', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(189, 15, 'MONA SANTIKA PURBA', '100397', 'Staff', 'Spare Parts Administrator', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(190, 15, 'SAHRUL ALAMSYAH', '100119', 'Staff', 'Warehouse Purchasing Staff', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(191, 15, 'SUGANDA', '100010', 'Staff', 'Warehouse Staff', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL),
(192, 15, 'FX ERRY SUPRAPTO', '100412', 'Staff', 'OTC Parts Sales', 'JEFFRY HOLIDAJA', 'JEFFRY HOLIDAJA', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_shift`
--

CREATE TABLE `jadwal_shift` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `dept_id` varchar(2) NOT NULL,
  `tgl_shift` date NOT NULL,
  `kode_schedule` varchar(2) NOT NULL,
  `jam_shift_awal` time NOT NULL,
  `jam_shift_akhir` time NOT NULL,
  `jenis_hari` enum('LIBUR','KERJA') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_shift`
--

INSERT INTO `jadwal_shift` (`id`, `nama_karyawan`, `nik`, `dept_id`, `tgl_shift`, `kode_schedule`, `jam_shift_awal`, `jam_shift_akhir`, `jenis_hari`, `created_at`, `updated_at`) VALUES
(1, 'MARDIANA', '100013', '6', '2018-12-01', 'A', '07:00:00', '15:00:00', 'KERJA', '2018-12-05 09:47:17', '0000-00-00 00:00:00'),
(2, 'MARDIANA', '100013', '6', '2018-12-13', 'A', '07:00:00', '15:00:00', 'KERJA', '2018-12-05 09:47:17', '0000-00-00 00:00:00');

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
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 116),
(3, 'App\\Models\\User\r\n', 117),
(3, 'App\\Models\\User', 117),
(3, 'App\\Models\\User', 121),
(4, 'App\\Models\\User', 118),
(4, 'App\\Models\\User', 122),
(5, 'App\\Models\\User', 119),
(5, 'App\\Models\\User', 120);

-- --------------------------------------------------------

--
-- Table structure for table `mst_nonshift_schedules`
--

CREATE TABLE `mst_nonshift_schedules` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `day` varchar(50) DEFAULT NULL,
  `time_schedule_awal` time DEFAULT NULL,
  `time_schedule_akhir` time DEFAULT NULL,
  `sabtu_masuk` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nonshift_schedules`
--

CREATE TABLE `nonshift_schedules` (
  `id` int(11) NOT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `dept` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `schedule_code` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NULL, NULL),
(2, 'Employee', 'web', NULL, NULL),
(3, 'Manager', 'web', NULL, NULL),
(4, 'Supervisor', 'web', NULL, NULL),
(5, 'Staff', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `kd` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `time_schedule_awal` time NOT NULL,
  `time_schedule_akhir` time NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `uang_makan` varchar(5) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`kd`, `id`, `code`, `time_schedule_awal`, `time_schedule_akhir`, `dept_id`, `uang_makan`, `created_at`, `updated_at`) VALUES
(2, 1, 'A', '07:00:00', '15:00:00', '2', 'Y', NULL, NULL),
(3, 2, 'B', '07:00:00', '13:00:00', '2', 'Y', NULL, NULL),
(4, 3, 'C', '11:00:00', '19:00:00', '2', 'Y', NULL, NULL),
(5, 4, 'D', '00:00:00', '00:00:00', '2', 'Y', NULL, NULL),
(6, 5, 'E', '00:00:00', '00:00:00', '2', 'Y', NULL, NULL),
(7, 6, 'A', '00:00:00', '00:00:00', '3', 'Y', NULL, NULL),
(8, 7, 'B', '00:00:00', '00:00:00', '3', 'Y', NULL, NULL),
(9, 8, 'C', '00:00:00', '00:00:00', '3', 'Y', NULL, NULL),
(10, 9, 'D', '00:00:00', '00:00:00', '3', 'Y', NULL, NULL),
(11, 10, 'A', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(12, 11, 'B', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(13, 12, 'C', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(14, 13, 'D', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(15, 14, 'E', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(16, 15, 'F', '00:00:00', '00:00:00', '9', 'Y', NULL, NULL),
(17, 16, 'A', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(18, 17, 'B', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(19, 18, 'C', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(20, 19, 'D', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(21, 20, 'E', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(22, 21, 'F', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(23, 22, 'G', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(24, 23, 'H', '00:00:00', '00:00:00', '12', 'Y', NULL, NULL),
(25, 24, 'A', '00:00:00', '00:00:00', '11', 'Y', NULL, NULL),
(26, 25, 'B', '00:00:00', '00:00:00', '11', 'Y', NULL, NULL),
(27, 26, 'C', '00:00:00', '00:00:00', '11', 'N', NULL, NULL),
(28, 27, 'A', '00:00:00', '00:00:00', '14', 'Y', NULL, NULL),
(29, 28, 'B', '00:00:00', '00:00:00', '14', 'N', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shift_schedules`
--

CREATE TABLE `shift_schedules` (
  `id` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `schedule_code` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift_schedules`
--

INSERT INTO `shift_schedules` (`id`, `nik`, `dept`, `date`, `schedule_code`, `created_at`, `updated_at`) VALUES
(701, '100316', '2', NULL, 'A', NULL, NULL),
(702, 'G100349', '2', NULL, 'C', NULL, NULL),
(703, 'G100349', '2', NULL, 'B', NULL, NULL),
(704, 'G100349', '2', NULL, 'B', NULL, NULL),
(705, '100279', '2', NULL, 'C', NULL, NULL),
(814, '100002', '9', NULL, 'A', NULL, NULL),
(815, '100002', '9', NULL, 'C', NULL, NULL),
(816, '100002', '9', NULL, 'C', NULL, NULL),
(817, '100002', '9', NULL, 'C', NULL, NULL),
(818, '100002', '9', NULL, 'C', NULL, NULL),
(819, '100002', '9', NULL, 'C', NULL, NULL),
(820, '100002', '9', NULL, 'C', NULL, NULL),
(821, '100002', '9', NULL, 'C', NULL, NULL),
(822, '100002', '9', NULL, 'C', NULL, NULL),
(823, '100002', '9', NULL, 'C', NULL, NULL),
(824, '100002', '9', NULL, 'C', NULL, NULL),
(825, '100002', '9', NULL, 'C', NULL, NULL),
(826, '100002', '9', NULL, 'C', NULL, NULL),
(827, '100002', '9', NULL, 'C', NULL, NULL),
(828, '100002', '9', NULL, 'C', NULL, NULL),
(829, '100002', '9', NULL, 'C', NULL, NULL),
(830, '100002', '9', NULL, 'C', NULL, NULL),
(831, '100002', '9', NULL, 'C', NULL, NULL),
(832, '100002', '9', NULL, 'C', NULL, NULL),
(833, '100002', '9', NULL, 'C', NULL, NULL),
(834, '100002', '9', NULL, 'C', NULL, NULL),
(835, '100002', '9', NULL, 'C', NULL, NULL),
(836, '100002', '9', NULL, 'C', NULL, NULL),
(837, '100002', '9', NULL, 'C', NULL, NULL),
(838, '100002', '9', NULL, 'C', NULL, NULL),
(839, '100002', '9', NULL, 'C', NULL, NULL),
(840, '100002', '9', NULL, 'C', NULL, NULL),
(841, '100017', '9', NULL, 'C', NULL, NULL),
(842, '100017', '9', NULL, 'C', NULL, NULL),
(843, '100017', '9', NULL, 'D', NULL, NULL),
(844, '100017', '9', NULL, 'C', NULL, NULL),
(845, '100017', '9', NULL, 'C', NULL, NULL),
(846, '100017', '9', NULL, 'C', NULL, NULL),
(847, '100017', '9', NULL, 'C', NULL, NULL),
(848, '100017', '9', NULL, 'C', NULL, NULL),
(849, '100017', '9', NULL, 'C', NULL, NULL),
(850, '100017', '9', NULL, 'C', NULL, NULL),
(851, '100017', '9', NULL, 'C', NULL, NULL),
(852, '100017', '9', NULL, 'C', NULL, NULL),
(853, '100017', '9', NULL, 'C', NULL, NULL),
(854, '100017', '9', NULL, 'C', NULL, NULL),
(855, '100017', '9', NULL, 'C', NULL, NULL),
(856, '100017', '9', NULL, 'C', NULL, NULL),
(857, '100017', '9', NULL, 'C', NULL, NULL),
(858, '100017', '9', NULL, 'C', NULL, NULL),
(859, '100017', '9', NULL, 'C', NULL, NULL),
(860, '100017', '9', NULL, 'C', NULL, NULL),
(861, '100017', '9', NULL, 'C', NULL, NULL),
(862, '100017', '9', NULL, 'C', NULL, NULL),
(863, '100017', '9', NULL, 'C', NULL, NULL),
(864, '100017', '9', NULL, 'C', NULL, NULL),
(865, '100017', '9', NULL, 'C', NULL, NULL),
(866, '100017', '9', NULL, 'C', NULL, NULL),
(867, '100017', '9', NULL, 'C', NULL, NULL),
(868, '100131', '9', NULL, 'C', NULL, NULL),
(869, '100131', '9', NULL, 'C', NULL, NULL),
(870, '100131', '9', NULL, 'C', NULL, NULL),
(871, '100131', '9', NULL, 'C', NULL, NULL),
(872, '100131', '9', NULL, 'C', NULL, NULL),
(873, '100131', '9', NULL, 'C', NULL, NULL),
(874, '100131', '9', NULL, 'C', NULL, NULL),
(875, '100131', '9', NULL, 'C', NULL, NULL),
(876, '100131', '9', NULL, 'C', NULL, NULL),
(877, '100131', '9', NULL, 'C', NULL, NULL),
(878, '100131', '9', NULL, 'C', NULL, NULL),
(879, '100131', '9', NULL, 'C', NULL, NULL),
(880, '100131', '9', NULL, 'C', NULL, NULL),
(881, '100131', '9', NULL, 'C', NULL, NULL),
(882, '100131', '9', NULL, 'C', NULL, NULL),
(883, '100131', '9', NULL, 'C', NULL, NULL),
(884, '100131', '9', NULL, 'C', NULL, NULL),
(885, '100131', '9', NULL, 'C', NULL, NULL),
(886, '100131', '9', NULL, 'C', NULL, NULL),
(887, '100131', '9', NULL, 'C', NULL, NULL),
(888, '100131', '9', NULL, 'C', NULL, NULL),
(889, '100131', '9', NULL, 'C', NULL, NULL),
(890, '100131', '9', NULL, 'C', NULL, NULL),
(891, '100131', '9', NULL, 'C', NULL, NULL),
(892, '100131', '9', NULL, 'C', NULL, NULL),
(893, '100131', '9', NULL, 'C', NULL, NULL),
(894, '100131', '9', NULL, 'C', NULL, NULL),
(895, '100183', '9', NULL, 'C', NULL, NULL),
(896, '100183', '9', NULL, 'C', NULL, NULL),
(897, '100183', '9', NULL, 'C', NULL, NULL),
(898, '100183', '9', NULL, 'C', NULL, NULL),
(899, '100183', '9', NULL, 'C', NULL, NULL),
(900, '100183', '9', NULL, 'C', NULL, NULL),
(901, '100183', '9', NULL, 'C', NULL, NULL),
(902, '100183', '9', NULL, 'C', NULL, NULL),
(903, '100183', '9', NULL, 'C', NULL, NULL),
(904, '100183', '9', NULL, 'C', NULL, NULL),
(905, '100183', '9', NULL, 'C', NULL, NULL),
(906, '100183', '9', NULL, 'C', NULL, NULL),
(907, '100183', '9', NULL, 'C', NULL, NULL),
(908, '100183', '9', NULL, 'C', NULL, NULL),
(909, '100183', '9', NULL, 'C', NULL, NULL),
(910, '100183', '9', NULL, 'C', NULL, NULL),
(911, '100183', '9', NULL, 'C', NULL, NULL),
(912, '100183', '9', NULL, 'C', NULL, NULL),
(913, '100183', '9', NULL, 'C', NULL, NULL),
(914, '100183', '9', NULL, 'C', NULL, NULL),
(915, '100183', '9', NULL, 'C', NULL, NULL),
(916, '100183', '9', NULL, 'C', NULL, NULL),
(917, '100183', '9', NULL, 'C', NULL, NULL),
(918, '100183', '9', NULL, 'C', NULL, NULL),
(919, '100183', '9', NULL, 'C', NULL, NULL),
(920, '100183', '9', NULL, 'C', NULL, NULL),
(921, '100183', '9', NULL, 'C', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tanggal_merah`
--

CREATE TABLE `tanggal_merah` (
  `kd` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tanggal_merah`
--

INSERT INTO `tanggal_merah` (`kd`, `id`, `date`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-01-01', 'Hari Tahun Baru', NULL, NULL),
(2, 2, '2018-02-16', 'Hari Tahun Imlek', NULL, NULL),
(3, 3, '2018-03-17', 'Hari Raya Nyepi (Tahun Baru Saka)', NULL, NULL),
(4, 4, '2018-03-30', 'Wafat Isa Almasih', NULL, NULL),
(5, 5, '2018-04-01', 'Hari Paskah', NULL, NULL),
(6, 6, '2018-04-14', 'Isra Miraj Nabi Muhammad', NULL, NULL),
(7, 7, '2018-05-01', 'Hari Buruh Internasional/Pekerja', NULL, NULL),
(8, 8, '2018-05-10', 'Kenaikan Yesus Kristus', NULL, NULL),
(9, 9, '2018-04-29', 'Hari Raya Waisak', NULL, NULL),
(10, 10, '2018-06-01', 'Hari Lahir Pancasila', NULL, NULL),
(11, 11, '2018-06-15', 'Hari Raya Idul Fitri (1)', NULL, NULL),
(12, 12, '2018-06-16', 'Hari Raya Idul Fitri (2)', NULL, NULL),
(13, 13, '2018-06-27', 'Hari Pemilihan Pilkada Serentak', NULL, NULL),
(14, 14, '2018-08-17', 'Hari Kemerdekaan Indonesia', NULL, NULL),
(15, 15, '2018-08-22', 'Hari Raya Idul Adha', NULL, NULL),
(16, 16, '2018-09-11', 'Tahun Baru Islam', NULL, NULL),
(17, 17, '2018-11-20', 'Maulid Nabi Muhammad SAW', NULL, NULL),
(18, 18, '2018-12-25', 'Hari Natal', NULL, NULL);

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
  `tgl_pengajuan_cuti` datetime NOT NULL,
  `tgl_cuti_awal` date NOT NULL,
  `tgl_cuti_akhir` date NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `sisa_cuti_tahunan` int(11) NOT NULL,
  `sisa_cuti_khusus` int(11) NOT NULL,
  `sisa_cuti_besar` int(11) NOT NULL,
  `jenis_cuti` enum('C1','C2','C3','C4','C5','C6') NOT NULL,
  `jenis_cuti_detail` text NOT NULL,
  `penjelasan_cuti` text NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `kd_divisi` varchar(10) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `petugas_pengganti` varchar(25) NOT NULL,
  `app1` enum('Y','N') DEFAULT NULL,
  `app_time1` datetime DEFAULT NULL,
  `app_name1` varchar(30) DEFAULT NULL,
  `app2` enum('Y','N') DEFAULT NULL,
  `app_time2` datetime DEFAULT NULL,
  `app_name2` varchar(30) DEFAULT NULL,
  `app3` enum('','Y','N') DEFAULT NULL,
  `app_time3` datetime DEFAULT NULL,
  `app_name3` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_cuti`
--

INSERT INTO `tbl_pengajuan_cuti` (`id`, `tgl_pengajuan_cuti`, `tgl_cuti_awal`, `tgl_cuti_akhir`, `jumlah_hari`, `sisa_cuti_tahunan`, `sisa_cuti_khusus`, `sisa_cuti_besar`, `jenis_cuti`, `jenis_cuti_detail`, `penjelasan_cuti`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `petugas_pengganti`, `app1`, `app_time1`, `app_name1`, `app2`, `app_time2`, `app_name2`, `app3`, `app_time3`, `app_name3`, `created_at`, `updated_at`) VALUES
(1, '2018-11-23 00:00:00', '2018-11-19', '2018-11-21', 5, 4, 0, 0, 'C2', 'Cuti Pernikahan (3 Hari)', 'Mau Nikah', 'MARDIANA', '100013', '6', 'Staff', 'Bagus', 'Y', '2018-12-05 22:04:05', 'Supervisor', '', '0000-00-00 00:00:00', NULL, '', NULL, NULL, '2018-12-10 06:55:36', NULL),
(13, '2018-11-28 00:00:00', '2018-11-01', '2018-12-31', 2, 2, 2, 0, 'C1', 'Cuti Tahunan', 'Farros', 'MARDIANA', '100013', '6', 'Staff', 'Ucok', 'Y', NULL, '', 'Y', '2018-12-03 14:55:00', 'MNGR_TEST', NULL, NULL, NULL, '2018-12-04 15:46:52', '2018-11-28 15:55:05'),
(14, '2018-12-10 00:00:00', '2018-11-01', '2018-12-31', 2, 10, 32, 60, 'C1', 'Cuti Tahunan', 'hjvb,hbv', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'Ucok', NULL, NULL, NULL, 'Y', NULL, NULL, NULL, NULL, NULL, '2018-12-10 07:05:13', '2018-12-10 06:35:18'),
(15, '2018-12-10 00:00:00', '2018-11-01', '2018-12-31', 2, 4, 32, 60, 'C1', 'Cuti Tahunan', 'hjvb,hbv', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'Ucok', 'Y', NULL, NULL, 'Y', NULL, NULL, '', '2018-12-10 14:39:56', 'HRD', '2018-12-10 07:40:35', '2018-12-10 06:35:24'),
(16, '2018-12-10 00:00:00', '2018-11-01', '2018-12-31', 3, 6, 32, 60, 'C1', 'Cuti Tahunan', 'bosen kerja mulu', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'SUKARWO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-10 07:49:27', '2018-12-10 07:49:27'),
(17, '2018-12-10 00:00:00', '2018-11-01', '2018-12-31', 3, 6, 32, 60, 'C1', 'Cuti Tahunan', 'liburan', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'AISHA HESTININGRUM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-10 07:55:42', '2018-12-10 07:55:42'),
(18, '2018-12-10 15:00:15', '2018-11-01', '2018-12-31', 1, 6, 32, 60, 'C1', 'Cuti Tahunan', 'hvhjvjh', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'YULIAWATI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-10 08:00:15', '2018-12-10 08:00:15'),
(19, '2018-12-10 15:05:02', '2018-11-01', '2018-12-31', 3, 6, 32, 60, 'C1', 'Cuti Tahunan', 'hgvhgvhgvkjvh', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'SUSI ARIYANTI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-10 08:05:02', '2018-12-10 08:05:02'),
(20, '2018-12-10 15:05:46', '2018-11-01', '2018-12-31', 3, 6, 32, 60, 'C1', 'Cuti Tahunan', 'mnb,bn', 'SILVIA ISTIQOMAH', '100356', '1', 'Finance Staff', 'ISMA SEPTIANA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-10 08:05:46', '2018-12-10 08:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan_ijin`
--

CREATE TABLE `tbl_pengajuan_ijin` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `kd_divisi` varchar(20) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `tgl_ijin_awal` datetime NOT NULL,
  `tgl_ijin_akhir` datetime NOT NULL,
  `tgl_pengajuan_ijin` datetime NOT NULL,
  `tindak_lanjut` varchar(20) NOT NULL,
  `keterangan_ijin` text NOT NULL,
  `app1` enum('Y','N') DEFAULT NULL,
  `app_time1` datetime DEFAULT NULL,
  `app_name1` varchar(30) DEFAULT NULL,
  `app2` enum('Y','N') DEFAULT NULL,
  `app_time2` datetime DEFAULT NULL,
  `app_name2` varchar(30) DEFAULT NULL,
  `app3` enum('Y','N') DEFAULT NULL,
  `app_time3` datetime DEFAULT NULL,
  `app_name3` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_ijin`
--

INSERT INTO `tbl_pengajuan_ijin` (`id`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `tgl_ijin_awal`, `tgl_ijin_akhir`, `tgl_pengajuan_ijin`, `tindak_lanjut`, `keterangan_ijin`, `app1`, `app_time1`, `app_name1`, `app2`, `app_time2`, `app_name2`, `app3`, `app_time3`, `app_name3`, `created_at`, `updated_at`) VALUES
(1, 'MARDIANA', '100013', '6', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:18:42', 'POTONG CUTI', 'MAU ijin', 'Y', NULL, NULL, 'Y', NULL, NULL, 'Y', NULL, NULL, '2018-11-27 23:18:42', '2018-11-27 23:18:42'),
(3, 'Farros Siregar', '100013', '6', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:21:42', 'POTONG CUTI', 'MAU ijin', 'Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:21:42', '2018-11-27 23:21:42'),
(14, 'Raka Nugroho', '100067', '9', 'Manager', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-29 16:23:10', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-29 16:23:10', '2018-11-29 16:23:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan_lembur`
--

CREATE TABLE `tbl_pengajuan_lembur` (
  `id` int(11) NOT NULL,
  `nama_karyawan` varchar(30) NOT NULL,
  `nik` int(11) NOT NULL,
  `kd_divisi` varchar(10) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `tgl_lembur_awal` datetime NOT NULL,
  `tgl_lembur_akhir` datetime NOT NULL,
  `lama_lembur` varchar(10) NOT NULL,
  `tgl_pengajuan_lembur` datetime NOT NULL,
  `tindak_lanjut` enum('POTONG CUTI','POTONG INTENSIF','EXTRA CUTI') NOT NULL,
  `jenis_lembur` enum('L','K') NOT NULL,
  `uang_makan` enum('','Y','N') NOT NULL,
  `batas_lembur` enum('','Atas','Bawah') NOT NULL,
  `keterangan_lembur` text NOT NULL,
  `app1` enum('','Y','N') DEFAULT NULL,
  `app_time1` datetime DEFAULT NULL,
  `app_name1` varchar(30) DEFAULT NULL,
  `app2` enum('','Y','N') DEFAULT NULL,
  `app_time2` datetime DEFAULT NULL,
  `app_name2` varchar(30) DEFAULT NULL,
  `app3` enum('Y','N') DEFAULT NULL,
  `app_time3` datetime DEFAULT NULL,
  `app_name3` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_lembur`
--

INSERT INTO `tbl_pengajuan_lembur` (`id`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `tgl_lembur_awal`, `tgl_lembur_akhir`, `lama_lembur`, `tgl_pengajuan_lembur`, `tindak_lanjut`, `jenis_lembur`, `uang_makan`, `batas_lembur`, `keterangan_lembur`, `app1`, `app_time1`, `app_name1`, `app2`, `app_time2`, `app_name2`, `app3`, `app_time3`, `app_name3`, `created_at`, `updated_at`) VALUES
(31, 'MARDIANA', 100013, '6', 'Non Staff', '2018-12-01 15:00:00', '2018-11-01 19:00:00', '19:00', '2018-12-05 10:48:36', 'EXTRA CUTI', 'K', 'Y', 'Atas', 'mnbmnb', 'Y', '2018-12-05 22:21:13', 'Supervisor', 'N', '2018-12-05 22:25:05', 'Manager', NULL, NULL, NULL, '2018-12-05 10:48:36', '2018-12-05 10:48:36'),
(32, 'MARDIANA', 100013, '6', 'Non Staff', '2018-12-01 15:00:00', '2018-12-01 18:00:00', '3:00', '2018-12-05 21:41:28', 'POTONG CUTI', 'K', 'Y', '', 'ket lemb', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-05 21:41:28', '2018-12-05 21:41:28'),
(33, 'MARDIANA', 100013, '6', 'Non Staff', '2018-12-01 15:00:00', '2018-12-01 18:00:00', '3:00', '2018-12-05 21:48:28', 'POTONG CUTI', 'K', 'Y', 'Atas', 'ket lemb', 'Y', NULL, NULL, 'Y', NULL, NULL, '', NULL, NULL, '2018-12-05 21:48:28', '2018-12-05 21:48:28'),
(34, 'SILVIA ISTIQOMAH', 100356, '5', 'Staff', '2018-12-08 12:00:00', '2018-12-08 14:12:00', '2:00', '2018-12-05 22:58:16', 'POTONG CUTI', 'K', 'N', 'Atas', 'hujan males pulang lembur aja...', 'Y', '2018-12-05 23:05:30', 'Supervisor', 'N', '2018-12-05 23:06:37', 'Manager', NULL, NULL, NULL, '2018-12-05 22:58:16', '2018-12-05 22:58:16'),
(35, 'KUSUMAWATI', 100368, '5', 'Supervisor', '2018-12-06 06:00:00', '2018-12-06 08:00:00', '2:00', '2018-12-05 23:09:32', 'POTONG CUTI', 'K', 'N', 'Bawah', 'LMBR', 'Y', '2018-12-05 23:12:22', 'Manager', 'Y', '2018-12-05 23:12:22', 'Manager', NULL, NULL, NULL, '2018-12-05 23:09:32', '2018-12-05 23:09:32');

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
(116, 'farros', 'farros@admin.me', '$2y$10$l0NPs8yQimgATnpHD.J.VecoBf6/bWjAU7eoFgxIsjlrT5MF6hO26', 'yOlXPPeKJreHxHxVB6PlNK8Q1gVqt2ULE3ebuBiYDlWNR3XW8n7E4m4DLqGC', '2018-12-10 07:43:52', '2018-11-18 06:04:33'),
(117, 'irvan dermawa', 'irvandermawa_mngr@finance.car', '$2y$10$wIGivc7CGiVeeTeoiKRyJuIrE2Z9lsz//FmJyHThIEoEANbcOZDEu', 'q51m5SkleoaRRR8McoiYxzYtmNhM2lzp6DRi85YHehBmSxPI3TYYWrI8eCtY', '2018-12-05 17:43:36', '2018-12-03 03:55:45'),
(118, 'kusumawati', 'kusumawati_spv@finance.car', '$2y$10$kQ/KhI027N1Rn0UMJ0I0dua2Vl7krS9spQWd0VarWQhsUrkC1I.Li', 'yB6hPSeyGAMdX0ZSANRrFTXy7Y4hZ2AQ5EG6sFxI8jbHjPXsCzzYVLNKNpz5', '2018-12-05 16:26:54', '2018-12-03 03:57:56'),
(119, 'silvia istiqomah', 'silvia_staff@finance.car', '$2y$10$P9MvF9BSHYupTh9RvSVD6eFaK8G3g75kMW7xBfTGq04E9f.JYyXvW', 'C68W6aZfcrw5ceQ9kl2ZUGFi2DzTMDb4Ci1PUV2Oam7nbI5wtyHc6rWE7oQV', '2018-12-11 04:17:58', '2018-12-03 03:59:47'),
(120, 'mardiana', 'mardiana_staff@hk.car', '$2y$10$TkK/UDk4cBKOtdxQnO24yuBFiUHTjDqTgLPOSy3/83sPPzuOZRTZK', 'WswuciD7tLfQ7vNwer6BTeVZMMdyTg7TweYoPXcWUNi4GKT2XNmVXTvx8SBT', '2018-12-10 06:19:53', '2018-12-04 05:59:31'),
(121, 'USEP GANDARA', 'usepgandara_manager@hk.car', '$2y$10$a.k4WMsJOnipZas/1uiMdeiOx4xdPsJk6M1MtqbLohde6uDGSC4Ki', 'e1ea3dOVcYRpwWKtva24YClYRuyL3HA2YPPd0Z75zUBua0p6Z2OzCD9QO1x9', '2018-12-05 15:54:25', '2018-12-04 07:11:28'),
(122, 'siswanto', 'siswanto_spv@ga.car', '$2y$10$uCd5QIXtv55qkUX6loSyOuMQovTLaezi0.pfoFzUPnMiG0Gi.EpOm', 'MAO8usWmj57tdsCd9lqylvu07Ie2I9i2gzi6Ww82H5NvGGQGxwqcjDRh4OYg', '2018-12-05 15:23:43', '2018-12-05 14:17:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `data_hak_cuti`
--
ALTER TABLE `data_hak_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_shift`
--
ALTER TABLE `jadwal_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `tanggal_merah`
--
ALTER TABLE `tanggal_merah`
  ADD PRIMARY KEY (`kd`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `kd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `data_hak_cuti`
--
ALTER TABLE `data_hak_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_karyawan`
--
ALTER TABLE `data_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwal_shift`
--
ALTER TABLE `jadwal_shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `kd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tanggal_merah`
--
ALTER TABLE `tanggal_merah`
  MODIFY `kd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_mst_cuti_detail`
--
ALTER TABLE `tbl_mst_cuti_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_cuti`
--
ALTER TABLE `tbl_pengajuan_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_ijin`
--
ALTER TABLE `tbl_pengajuan_ijin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_lembur`
--
ALTER TABLE `tbl_pengajuan_lembur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
