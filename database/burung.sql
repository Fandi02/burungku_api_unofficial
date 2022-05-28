-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2022 at 06:57 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `burung`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` char(36) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `deskripsi` varchar(225) DEFAULT NULL,
  `jml_kol` int(11) DEFAULT NULL,
  `jml_baris` int(11) DEFAULT NULL,
  `jml_tiket` int(11) DEFAULT NULL,
  `harga` int(100) DEFAULT NULL,
  `aturan` text,
  `jenisburung_id` char(36) NOT NULL,
  `tgl_start` date DEFAULT NULL,
  `tgl_end` date DEFAULT NULL,
  `jam_start` time DEFAULT NULL,
  `jam_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `nama`, `tgl`, `jam`, `deskripsi`, `jml_kol`, `jml_baris`, `jml_tiket`, `harga`, `aturan`, `jenisburung_id`, `tgl_start`, `tgl_end`, `jam_start`, `jam_end`) VALUES
('3BA9499B-900F-0040-84EA-24549120AC03', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 2, 2, 2, 1000, 'akeh pokok e', '53746699-2226-C59E-46BA-AE68289D0FF3', '2022-05-26', '2022-05-30', '13:00:00', '13:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `eventlokasi`
--

CREATE TABLE `eventlokasi` (
  `id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `lokasi_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eventlokasi`
--

INSERT INTO `eventlokasi` (`id`, `event_id`, `lokasi_id`) VALUES
('7F95AC2F-600F-BFC1-C488-34328D316AE8', '3BA9499B-900F-0040-84EA-24549120AC03', '8AA11846-CEF9-7F75-F957-1FF500863252');

-- --------------------------------------------------------

--
-- Table structure for table `jenisburung`
--

CREATE TABLE `jenisburung` (
  `id` char(36) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenisburung`
--

INSERT INTO `jenisburung` (`id`, `nama`) VALUES
('53746699-2226-C59E-46BA-AE68289D0FF3', 'kenari');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id`, `nama`) VALUES
(1, 'bandung');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` char(36) NOT NULL,
  `kota_id` int(11) NOT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `latitut` varchar(225) NOT NULL,
  `longitut` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `kota_id`, `alamat`, `latitut`, `longitut`) VALUES
('8AA11846-CEF9-7F75-F957-1FF500863252', 1, NULL, '00009', '00999');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` char(36) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `jkel` tinyint(1) DEFAULT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sesi`
--

CREATE TABLE `sesi` (
  `id` char(36) NOT NULL,
  `no` int(11) DEFAULT NULL,
  `jam_start` time NOT NULL,
  `jam_end` time NOT NULL,
  `id_event` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sesi`
--

INSERT INTO `sesi` (`id`, `no`, `jam_start`, `jam_end`, `id_event`) VALUES
('2cca2806-de35-11ec-8ee0-c0185038215b', 1, '09:00:00', '10:00:00', '3BA9499B-900F-0040-84EA-24549120AC03'),
('2cca33ea-de35-11ec-8ee0-c0185038215b', 2, '10:00:00', '11:00:00', '3BA9499B-900F-0040-84EA-24549120AC03');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `eventlokasi_id` char(36) NOT NULL,
  `no_kursi` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `sesi` char(36) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `bukti` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `eventlokasi_id`, `no_kursi`, `metode_pembayaran`, `sesi`, `status`, `tgl`, `bukti`) VALUES
('63BA0B65-4AAA-484D-BB5F-4389536B00EE', 'a7868f1a-de41-11ec-8ee0-c0185038215b', '7F95AC2F-600F-BFC1-C488-34328D316AE8', 2, 'on the sport', '2cca33ea-de35-11ec-8ee0-c0185038215b', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` char(36) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `role` int(2) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `otp` int(5) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `nama`, `role`, `is_verified`, `otp`, `no_hp`, `password`) VALUES
('a7868f1a-de41-11ec-8ee0-c0185038215b', 'user1@user.com', 'user', 2, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usersecret`
--

CREATE TABLE `usersecret` (
  `token` char(36) NOT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenisburung_id` (`jenisburung_id`);

--
-- Indexes for table `eventlokasi`
--
ALTER TABLE `eventlokasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `jenisburung`
--
ALTER TABLE `jenisburung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kota_id` (`kota_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_event` (`id_event`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`eventlokasi_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sesi` (`sesi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usersecret`
--
ALTER TABLE `usersecret`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`jenisburung_id`) REFERENCES `jenisburung` (`id`);

--
-- Constraints for table `eventlokasi`
--
ALTER TABLE `eventlokasi`
  ADD CONSTRAINT `eventlokasi_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `eventlokasi_ibfk_2` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`);

--
-- Constraints for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD CONSTRAINT `lokasi_ibfk_1` FOREIGN KEY (`kota_id`) REFERENCES `kota` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `sesi`
--
ALTER TABLE `sesi`
  ADD CONSTRAINT `sesi_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`eventlokasi_id`) REFERENCES `eventlokasi` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`sesi`) REFERENCES `sesi` (`id`);

--
-- Constraints for table `usersecret`
--
ALTER TABLE `usersecret`
  ADD CONSTRAINT `usersecret_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
