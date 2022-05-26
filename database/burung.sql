-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2022 at 10:31 AM
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
  `jml_sesi` int(11) DEFAULT NULL,
  `harga` int(100) DEFAULT NULL,
  `aturan` text,
  `jenisburung_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `nama`, `tgl`, `jam`, `deskripsi`, `jml_kol`, `jml_baris`, `jml_tiket`, `jml_sesi`, `harga`, `aturan`, `jenisburung_id`) VALUES
('485458BF-F57A-EB6A-22E4-0488DA6E1559', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 2, 2, 2, 2, 1000, 'akeh pokok e', 'c2eebd33-5421-43c3-901f-cf535d94e81e'),
('d444db7b-dcae-11ec-8b64-c0185038215b', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 2, 2, 2, 2, 100000, 'akeh pokok e', 'c2eebd33-5421-43c3-901f-cf535d94e81e'),
('d644db7b-dcae-11ec-8b64-c0185038215b', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 2, 2, 2, 2, 100000, 'akeh pokok e', 'c2eebd33-5421-43c3-901f-cf535d94e81e'),
('f644db7b-dcae-11ec-8b64-c0185038215b', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 3, 3, 3, 3, 1000, 'akeh ws', 'c2eebd33-5421-43c3-901f-cf535d94e81e'),
('F7E4DFC3-AE86-1C25-161C-4215F167634D', 'gantangan', '2022-05-01', '13:58:00', 'gantangan', 2, 2, 2, 2, 1000, 'akeh pokok e', 'c2eebd33-5421-43c3-901f-cf535d94e81e');

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
('53924253-B15D-0E1D-9B79-95507BD7585E', 'f644db7b-dcae-11ec-8b64-c0185038215b', '69f4a067-dca5-11ec-8b64-c0185038215b'),
('71D3FCD2-9BE5-E6D2-D15C-57CC78084FDB', 'f644db7b-dcae-11ec-8b64-c0185038215b', '69f4a067-dca5-11ec-8b64-c0185038215b'),
('79E9DE52-771F-DF33-3A2B-6C1635E6F56A', 'f644db7b-dcae-11ec-8b64-c0185038215b', '69f4a067-dca5-11ec-8b64-c0185038215b');

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
('92607A37-6AE0-F53A-D70B-E087600B60C3', 'kenari'),
('BB67441E-3976-3859-7BE4-6C1974A428DB', 'kenari'),
('c2eebd33-5421-43c3-901f-cf535d94e81e', 'emprit');

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
('69f4a067-dca5-11ec-8b64-c0185038215b', 1, 'cisitu', '00009', '00999'),
('C0F14FF3-F4AD-601E-DB05-9E61BFEC0E92', 1, NULL, '00009', '00999');

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

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `no_hp`, `alamat`, `jkel`, `user_id`) VALUES
('1FB5F0F5-3340-F7D7-7B4F-9BFF32259C7F', '0999999', 'bandung', 0, '9AAA83C8-B50F-E4FA-7803-31E74081FAB4'),
('4B550CFD-1CC7-9448-B601-32058B978A2C', NULL, NULL, NULL, '1EF90C69-12E1-4C32-88E5-8A99A3AFACDE'),
('6F848023-8A1A-9155-795C-B4DB3E52052E', NULL, NULL, NULL, 'DB155FEA-0B91-0A2C-5E2B-18EA27F32279'),
('7272b29c-dcca-11ec-8b64-c0185038215b', '09999', 'malang', 0, '05abedd0-dcca-11ec-8b64-c0185038215b'),
('96150627-dcca-11ec-8b64-c0185038215b', '09999', 'suroboyo', 0, '17b6d169-dcca-11ec-8b64-c0185038215b'),
('B5F82786-C8F6-6609-7F9B-F335019CBB9B', NULL, NULL, NULL, '0B08D2D6-2763-87AA-67A1-FB01DFFED25F'),
('EFDC3432-213C-53A6-0DDE-AF3525F76773', NULL, NULL, NULL, '355C4F26-9CF5-3D4C-9A0B-54667D983004');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `no_kursi` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `sesi` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `event_id`, `no_kursi`, `metode_pembayaran`, `sesi`, `status`, `tgl`) VALUES
('E7396382-582E-3FA1-3010-EF1864C85636', '0B08D2D6-2763-87AA-67A1-FB01DFFED25F', 'f644db7b-dcae-11ec-8b64-c0185038215b', 2, 'on the sport', 2, 1, NULL),
('ef6af0aa-dcba-11ec-8b64-c0185038215b', '0B08D2D6-2763-87AA-67A1-FB01DFFED25F', 'f644db7b-dcae-11ec-8b64-c0185038215b', 2, 'on the sport', 1, 1, NULL);

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
  `otp` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `nama`, `role`, `is_verified`, `otp`) VALUES
('05abedd0-dcca-11ec-8b64-c0185038215b', 'eo1@eo.com', 'eo1', 1, 1, NULL),
('0B08D2D6-2763-87AA-67A1-FB01DFFED25F', 'fajar', 'fajar', 2, 0, 75574),
('17b6d169-dcca-11ec-8b64-c0185038215b', 'eo2@eo.com', 'eo2', 1, 1, NULL),
('1EF90C69-12E1-4C32-88E5-8A99A3AFACDE', 'f@f.com', 'f', 1, 1, NULL),
('355C4F26-9CF5-3D4C-9A0B-54667D983004', 'a@a.com', 'fajar', 2, 0, 99545),
('5dbed634-dcce-11ec-8b64-c0185038215b', 'admin@admin.com', 'admin', 0, 1, NULL),
('9AAA83C8-B50F-E4FA-7803-31E74081FAB4', 'fhidayatulloh33@gmail.com', 'fajar', 2, 0, 60238),
('B17644A3-34C0-B0AB-959A-FCFA53C95A4A', 'fajar_18520003@stimata.ac.id', 'fajar', 2, 1, 27279),
('DB155FEA-0B91-0A2C-5E2B-18EA27F32279', 'f@f.com', 'f', 2, 0, NULL);

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
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `usersecret`
--
ALTER TABLE `usersecret`
  ADD CONSTRAINT `usersecret_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
