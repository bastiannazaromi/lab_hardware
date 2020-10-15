-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2020 at 05:46 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hardware`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `username`, `password`, `nama`, `level`, `foto`, `created_at`) VALUES
(1, 'superadmin', '$2y$10$Iit0t5yvPiwc4xYtOTs6leCimxd2mXziqtcH.orz.svDggVNTiPai', 'Super Admin', 'Super Admin', 'default.jpg', '2020-07-25 03:02:09'),
(2, 'admin', '$2y$10$eiVtzcVnUljttURODRznzuQARnRhzjKuQg5qe.gdrZzrN76vgydRS', 'Admin Hardware', 'Admin', 'default.jpg', '2020-09-25 10:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok` int(10) NOT NULL,
  `normal` int(10) NOT NULL,
  `rusak` int(10) NOT NULL,
  `dipinjam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `kategori`, `nama_barang`, `stok`, `normal`, `rusak`, `dipinjam`) VALUES
(1, 'Mikrokontroller & Modul', 'Arduino Uno', 20, 19, 1, 0),
(2, 'Sensor', 'Ultrasonik', 35, 30, 5, 0),
(3, 'Aktuator', 'Motor DC', 15, 15, 0, 0),
(4, 'Sensor', 'DHT 11', 30, 30, 0, 0),
(5, 'Mikrokontroller & Modul', 'NodeMCU 8266', 25, 15, 10, 0),
(6, 'Aktuator', 'Motor Servo', 25, 23, 2, 0),
(8, 'Sensor', 'Turbidity', 5, 3, 2, 0),
(9, 'Sensor', 'MQ-2', 10, 8, 2, 0),
(13, 'Mikrokontroller & Modul', 'Arduino Mega', 20, 18, 2, 0),
(24, 'Kabel', 'Kabel Jumper', 50, 40, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id` int(11) NOT NULL,
  `nidn_nipy` varchar(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `no_telepon` varchar(13) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`id`, `nidn_nipy`, `username`, `nama`, `password`, `no_telepon`, `email`, `foto`) VALUES
(1, '1010', 'dosen', 'Dosen Hardware', '$2y$10$eiVtzcVnUljttURODRznzuQARnRhzjKuQg5qe.gdrZzrN76vgydRS', '088209872343', 'dosen@gmail.com', '1010_140034.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `semester` int(2) NOT NULL,
  `kelas` varchar(2) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id`, `nim`, `password`, `nama`, `semester`, `kelas`, `no_telepon`, `email`, `foto`) VALUES
(1, '16040049', '$2y$10$REzLjVPAZ4dXpSAqmfvdyeSypq6gGzziduSrvA0JnNPdkQprwEjvO', 'Bastian Nazaromi', 6, 'B', '085747771509', 'bastian.nazaromi@gmail.com', '16040049_bastian_3x41.jpg'),
(2, '16040034', '$2y$10$YYKD5RJL11LUM1.FPgU/e.a0EHTpxfRd8VQsZ60WPEH53TyZymYOC', 'Zihan Sri Tahani', 2, 'J', '085747771509', 'zihan@gmail.com', 'default.jpg'),
(3, '16040045', '$2y$10$REzLjVPAZ4dXpSAqmfvdyeSypq6gGzziduSrvA0JnNPdkQprwEjvO', 'Mahasiswa Contoh', 4, 'G', NULL, NULL, 'default.jpg'),
(4, '16040030', '$2y$10$REzLjVPAZ4dXpSAqmfvdyeSypq6gGzziduSrvA0JnNPdkQprwEjvO', 'Mahasiswa Akhir', 6, 'A', NULL, NULL, 'default.jpg'),
(573, '16040087', '$2y$10$UYg/WlOTWBQvg5ciHavAxOlYP9gMIsr1hk6P.jvDucmzZthCFe.cu', 'Contoh Lagi', 2, 'E', NULL, NULL, 'default.jpg'),
(576, '16040050', '$2y$10$RcniDkEjsEiugE9qONij.easO8FwAGnCFVqvwWQuaof0fBR4d/epK', 'Maning coy', 4, 'D', NULL, NULL, 'default.jpg'),
(577, '16040057', '$2y$10$d6LJUDbzxGEW7oxuAJg38.IETtXg70OReAh9etC0VjK/JlxRoEAEq', 'Maning Bro', 4, 'D', NULL, NULL, 'default.jpg'),
(590, '12356789', '$2y$10$3vLhHLwVeKe3GI2lLjJ1xexw836axwr1dKWg4MXWW23nIuql.gtsq', 'sgsg', 6, 'F', NULL, NULL, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pinjaman`
--

CREATE TABLE `tb_pinjaman` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tanggal_pinjam` timestamp NULL DEFAULT NULL,
  `max_kembali` date NOT NULL,
  `tanggal_kembali` timestamp NULL DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pinjaman`
--

INSERT INTO `tb_pinjaman` (`id`, `nama_barang`, `id_user`, `jumlah`, `tanggal_pinjam`, `max_kembali`, `tanggal_kembali`, `status`, `role`) VALUES
(32, 'Arduino Uno', '16040049', 2, '2020-10-05 14:51:53', '2020-10-12', '2020-10-07 13:19:28', 'Selesai', 'mahasiswa'),
(34, 'Kabel Jumper', '16040049', 10, '2020-10-07 13:31:23', '2020-10-14', NULL, 'Dipinjam', 'mahasiswa'),
(35, 'DHT 11', '16040049', 3, '2020-10-07 13:34:53', '2020-10-14', '2020-10-07 13:54:11', 'Selesai', 'mahasiswa'),
(39, 'Motor DC', '1010', 5, '2020-10-07 14:03:30', '2020-10-14', '2020-10-07 14:04:10', 'Selesai', 'Dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_barang` (`nama_barang`);

--
-- Indexes for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn_nipy` (`nidn_nipy`);

--
-- Indexes for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `tb_pinjaman`
--
ALTER TABLE `tb_pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT for table `tb_pinjaman`
--
ALTER TABLE `tb_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
