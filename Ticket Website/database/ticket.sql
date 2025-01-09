-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 03:39 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `Email` varchar(50) NOT NULL,
  `Password` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Email`, `Password`) VALUES
('admin123@gmail.com', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `pesantiket`
--

CREATE TABLE `pesantiket` (
  `Status` varchar(50) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `No_Telepon` varchar(25) NOT NULL,
  `Harga` text NOT NULL,
  `Tanggal_Pemesanan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesantiket`
--

INSERT INTO `pesantiket` (`Status`, `ID`, `Nama`, `No_Telepon`, `Harga`, `Tanggal_Pemesanan`) VALUES
('Tiket Sudah Terpakai', 'TCKT_DIS_9184', 'Disvi Ariani', '085753223412', 'Rp.200,000', '2024-08-08 11:49:39'),
('Tiket Belum Terpakai', 'TCKT_FAU_7212', 'Fauzan Harris Muhammad', '084422709810', 'Rp.200,000', '2024-08-07 06:34:56'),
('Tiket Sudah Terpakai', 'TCKT_GHI_2783', 'Ghiyats Sudiro', '084422331188', 'Rp.200,000', '2024-07-26 13:39:51'),
('Tiket Sudah Terpakai', 'TCKT_KHA_3702', 'Khalifah Lateef', '084488672413', 'Rp.200,000', '2024-08-07 06:32:37'),
('Tiket Belum Terpakai', 'TCKT_RAK_3251', 'Rakama Galih Saputera', '083156221133', 'Rp.200,000', '2024-08-07 06:33:52'),
('Tiket Sudah Terpakai', 'TCKT_SAG_6082', 'Sagara Adri Putera', '085742331122', 'Rp.200,000', '2024-08-06 05:55:27'),
('Tiket Sudah Terpakai', 'TCKT_SAT_1487', 'Satria Manggala Wirasena', '082233344118', 'Rp.200,000', '2024-08-07 04:11:48'),
('Tiket Belum Terpakai', 'TCKT_SER_7713', 'Serena Aprilya', '084387218097', 'Rp.200,000', '2024-08-07 06:33:19'),
('Tiket Sudah Terpakai', 'TCKT_SYA_4131', 'Syakeena Syabila', '087743552244', 'Rp.200,000', '2024-07-26 07:45:32'),
('Tiket Sudah Terpakai', 'TCKT_WIB_9345', 'Wibisana Birawa', '074411332244', 'Rp.200,000', '2024-07-30 15:24:53'),
('Tiket Belum Terpakai', 'TCKT_ZAY_5116', 'Zayn Malik Wibowo', '0890918200', 'Rp.200,000', '2024-08-07 06:35:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesantiket`
--
ALTER TABLE `pesantiket`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
