-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2018 at 04:13 PM
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
(4, '2018', 'SILVIA ISTIQOMAH', '100356', 10, 32, 60, '2012-06-10');

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
  `jenis_hari` enum('LIBUR','KERJA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_shift`
--

INSERT INTO `jadwal_shift` (`id`, `nama_karyawan`, `nik`, `dept_id`, `tgl_shift`, `kode_schedule`, `jam_shift_awal`, `jam_shift_akhir`, `jenis_hari`) VALUES
(1, 'MARDIANA', '100013', '6', '2018-12-01', 'A', '07:00:00', '15:00:00', 'KERJA'),
(2, 'MARDIANA', '100013', '6', '2018-12-13', 'A', '07:00:00', '15:00:00', 'KERJA');

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
(4, 'App\\Models\\User', 118),
(5, 'App\\Models\\User', 119);

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
  `app1` enum('Y','N') DEFAULT NULL,
  `app_time1` datetime DEFAULT NULL,
  `app_name1` varchar(30) DEFAULT NULL,
  `app2` enum('Y','N') DEFAULT NULL,
  `app_time2` datetime DEFAULT NULL,
  `app_name2` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengajuan_cuti`
--

INSERT INTO `tbl_pengajuan_cuti` (`id`, `tgl_pengajuan_cuti`, `tgl_cuti_awal`, `tgl_cuti_akhir`, `jumlah_hari`, `sisa_cuti`, `sisa_cuti_khusus`, `jenis_cuti`, `jenis_cuti_detail`, `penjelasan_cuti`, `nama_karyawan`, `nik`, `kd_divisi`, `jabatan`, `petugas_pengganti`, `app1`, `app_time1`, `app_name1`, `app2`, `app_time2`, `app_name2`, `created_at`, `updated_at`) VALUES
(1, '2018-11-23 00:00:00', '2018-11-19', '2018-11-21', 5, 9, 0, 'C2', 'Cuti Pernikahan (3 Hari)', 'Mau Nikah', 'MARDIANA', '100013', 'HK', '', 'Bagus', NULL, NULL, '', 'Y', '0000-00-00 00:00:00', NULL, '2018-12-04 04:39:27', NULL),
(13, '2018-11-28 00:00:00', '2018-11-01', '2018-12-31', 2, 2, 2, 'C1', 'Cuti Tahunan', 'Farros', 'MARDIANA', '100013', 'HK', 'Staff', 'Ucok', 'Y', NULL, '', 'Y', '2018-12-03 14:55:00', 'MNGR_TEST', '2018-12-04 04:39:21', '2018-11-28 15:55:05'),
(21, '2018-11-29 00:00:00', '2018-11-01', '2018-12-31', 4, 2, 2, 'C1', 'Cuti Tahunan', 'kjbkjbkjb', 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', 'Ucok', NULL, NULL, '', 'Y', '0000-00-00 00:00:00', NULL, '2018-11-29 06:36:20', '2018-11-29 06:36:20'),
(28, '2018-11-29 00:00:00', '2018-11-01', '2018-12-31', 3, 2, 2, 'C1', 'Cuti Tahunan', 'hamil', 'Raka Nugroho', '100067', 'OBOG', 'Manager', 'Ucok', 'Y', NULL, NULL, 'Y', '2018-11-29 17:47:08', 'MNGR', '2018-12-03 07:19:39', '2018-11-29 10:04:19');

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
(1, 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:18:42', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:18:42', '2018-11-27 23:18:42'),
(2, 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:21:18', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:21:18', '2018-11-27 23:21:18'),
(3, 'Farros Siregar', '100013', 'HRGA', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '2018-11-27 23:21:42', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:21:42', '2018-11-27 23:21:42'),
(4, 'Farros Siregar', '100013', 'HK', 'Staff', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-27 23:50:02', 'POTONG CUTI', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27 23:50:02', '2018-11-27 23:50:02'),
(13, 'Muhammad Bagus Santoso', '100023', 'HK', 'Supervisor', '2018-11-01 11:00:00', '2018-11-01 15:00:00', '2018-11-28 00:27:33', 'POTONG INTENSIF', 'MAU ijin', 'Y', '2018-11-29 16:21:58', 'MNGR', 'Y', '2018-11-29 17:20:56', 'MNGR', NULL, NULL, NULL, '2018-11-28 00:27:34', '2018-11-28 00:27:34'),
(14, 'Raka Nugroho', '100067', 'OBOG', 'Manager', '2018-11-01 10:00:00', '2018-11-01 11:00:00', '2018-11-29 16:23:10', 'POTONG INTENSIF', 'MAU ijin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-29 16:23:10', '2018-11-29 16:23:10');

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
(3, 'Farros Siregar', 100013, 'Purchasing', 'Staff', '2018-11-01 00:00:00', '2018-11-01 00:00:00', '', '2018-11-25 08:51:52', 'POTONG CUTI', 'K', '', '', 'MAU LEMBUR', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '0000-00-00 00:00:00', '', '2018-11-25 08:51:52', '2018-11-25 08:51:52'),
(6, 'MARDIANA', 100013, 'HK', 'Staff', '2018-12-01 15:00:00', '2018-12-01 19:00:00', '4:00', '2018-11-29 14:10:06', 'POTONG CUTI', 'K', 'Y', 'Atas', 'Gantiin Temen', 'Y', '2018-11-29 15:50:21', 'Supervisor', 'Y', '2018-12-03 16:32:23', 'Manager', 'Y', '0000-00-00 00:00:00', '', '2018-11-29 14:10:06', '2018-11-29 14:10:06'),
(12, 'SILVIA ISTIQOMAH', 100356, 'FIN & ACC', 'Finance Staff', '2018-11-01 10:00:00', '2018-11-01 12:30:00', '2:30', '2018-12-03 16:54:57', 'POTONG CUTI', 'K', '', '', 'lembur biar dapet duit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-03 16:54:57', '2018-12-03 16:54:57'),
(13, 'MARDIANA', 100013, 'HK', 'Non Staff', '2018-11-01 10:00:00', '2018-11-01 12:30:00', '0:00', '2018-12-04 13:17:59', 'POTONG CUTI', 'K', 'N', 'Bawah', 'qqqqqqqq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-04 13:17:59', '2018-12-04 13:17:59'),
(14, 'MARDIANA', 100013, 'HK', 'Non Staff', '2018-12-01 10:00:00', '2018-12-01 12:30:00', '0:00', '2018-12-04 13:47:50', 'POTONG CUTI', 'K', 'N', 'Bawah', 'jkbjkbkjbh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-04 13:47:50', '2018-12-04 13:47:50'),
(15, 'MARDIANA', 100013, 'HK', 'Non Staff', '2018-12-01 15:00:00', '2018-12-01 19:00:00', '0:00', '2018-12-04 13:49:35', 'POTONG CUTI', 'K', 'N', 'Bawah', 'nyari duit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-04 13:49:35', '2018-12-04 13:49:35'),
(16, 'MARDIANA', 100013, 'HK', 'Non Staff', '2018-12-01 15:00:00', '2018-12-01 19:00:00', '4:00', '2018-12-04 14:00:56', 'POTONG CUTI', 'K', 'Y', 'Atas', 'lalalala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-12-04 14:00:56', '2018-12-04 14:00:56');

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
(116, 'farros', 'farros@admin.me', '$2y$10$l0NPs8yQimgATnpHD.J.VecoBf6/bWjAU7eoFgxIsjlrT5MF6hO26', 'o38DAWRumxsY8P1KEDTtAJBRVye1a8yvC40Ms8D54GHlA12fFCeVcXTJtiFF', '2018-11-25 09:03:32', '2018-11-18 06:04:33'),
(117, 'irvan dermawa', 'irvandermawa_mngr@finance.car', '$2y$10$wIGivc7CGiVeeTeoiKRyJuIrE2Z9lsz//FmJyHThIEoEANbcOZDEu', 'fdahHZeDXKKTFvJ28jAzuHI8gvGixYDArVEIfp4b7AYxy7JPONgjgj3urSxf', '2018-12-03 09:52:03', '2018-12-03 03:55:45'),
(118, 'kusumawati', 'kusumawati_spv@finance.car', '$2y$10$kQ/KhI027N1Rn0UMJ0I0dua2Vl7krS9spQWd0VarWQhsUrkC1I.Li', 'CpN5kF8OHXgz7UBiMVepyUmFU492aWaqgnN2XOaXtLxKir8OaUhP44oWwfTh', '2018-12-03 03:58:55', '2018-12-03 03:57:56'),
(119, 'silvia istiqomah', 'silvia_staff@finance.car', '$2y$10$P9MvF9BSHYupTh9RvSVD6eFaK8G3g75kMW7xBfTGq04E9f.JYyXvW', 'rRZsgfHv3w9miHWEBM8WaV6Lnq68pZ94ihpPUBWigTAMngLh4Wo8hdyXHrOh', '2018-12-03 04:31:47', '2018-12-03 03:59:47'),
(120, 'mardiana', 'mardiana_staff@hk.car', '$2y$10$TkK/UDk4cBKOtdxQnO24yuBFiUHTjDqTgLPOSy3/83sPPzuOZRTZK', 'hFbEWLFC72AeOaeQwic31WRvajlNGa98NzUnJOolWxR1ZkXkEMy931Bn7IDt', '2018-12-04 07:10:09', '2018-12-04 05:59:31'),
(121, 'USEP GANDARA', 'usepgandara_manager@hk.car', '$2y$10$a.k4WMsJOnipZas/1uiMdeiOx4xdPsJk6M1MtqbLohde6uDGSC4Ki', NULL, '2018-12-04 07:11:28', '2018-12-04 07:11:28');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tbl_mst_cuti_detail`
--
ALTER TABLE `tbl_mst_cuti_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_cuti`
--
ALTER TABLE `tbl_pengajuan_cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_ijin`
--
ALTER TABLE `tbl_pengajuan_ijin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_pengajuan_lembur`
--
ALTER TABLE `tbl_pengajuan_lembur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

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
