-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2022 at 09:05 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kontes_burung`
--

-- --------------------------------------------------------

--
-- Table structure for table `booktiket`
--

CREATE TABLE `booktiket` (
  `id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nomer_tiket` varchar(18) NOT NULL,
  `is_canceled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booktiket`
--

INSERT INTO `booktiket` (`id`, `event_id`, `user_id`, `nomer_tiket`, `is_canceled`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `databank`
--

CREATE TABLE `databank` (
  `id` char(36) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `nomer_rekening` varchar(20) NOT NULL,
  `nama_bank` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` char(36) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` varchar(250) NOT NULL,
  `jadwal` datetime(6) NOT NULL,
  `jml_tiket` int(25) NOT NULL,
  `jml_sesi` int(25) NOT NULL,
  `harga_tiket` int(9) NOT NULL,
  `aturan` varchar(250) NOT NULL,
  `jenisburung_id` int(7) NOT NULL,
  `lokasi_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `judul`, `deskripsi`, `jadwal`, `jml_tiket`, `jml_sesi`, `harga_tiket`, `aturan`, `jenisburung_id`, `lokasi_id`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'kontes burungku', 'burungku', '2022-05-26 13:01:18.000000', 20, 1, 2000, 'bebas', 12, 'C6E057AA-6B82-A823-B7E3-0C5DD74BDD74');

-- --------------------------------------------------------

--
-- Table structure for table `jenisburung`
--

CREATE TABLE `jenisburung` (
  `id` int(7) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenisburung`
--

INSERT INTO `jenisburung` (`id`, `nama`) VALUES
(1, 'test'),
(5, 'kuntulmilikku'),
(12, 'ohhh...burung'),
(234224, 'burungku dan burungmu'),
(567686585, 'burungku dan burungmu'),
(567686590, 'kenari');

-- --------------------------------------------------------

--
-- Table structure for table `jenispembayaran`
--

CREATE TABLE `jenispembayaran` (
  `id` int(12) NOT NULL,
  `nama` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` char(36) NOT NULL,
  `kota` varchar(33) NOT NULL,
  `longitude` varchar(12) NOT NULL,
  `latitude` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `kota`, `longitude`, `latitude`) VALUES
('C6E057AA-6B82-A823-B7E3-0C5DD74BDD74', 'malang', '12442', '-1234'),
('db99a49b-78fe-40a6-9efa-591ffcaf13a5', 'landungsariku', '12442', '-1234');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` char(36) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `user_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `transaksi_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `user_id`, `event_id`, `transaksi_id`) VALUES
('0471151D-0397-D51A-096A-AE7B8770535F', 'testp', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'CFECF3F0-0F04-7F03-5B87-494635A29ED4'),
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'CFECF3F0-0F04-7F03-5B87-494635A29ED4');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(2) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nama`) VALUES
(1, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `statuspembayaran`
--

CREATE TABLE `statuspembayaran` (
  `id` int(12) NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `event_id` char(36) NOT NULL,
  `sesi` varchar(2) NOT NULL,
  `no_kursi` varchar(3) NOT NULL,
  `booktiket_id` char(36) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `event_id`, `sesi`, `no_kursi`, `booktiket_id`, `bukti_pembayaran`) VALUES
('CFECF3F0-0F04-7F03-5B87-494635A29ED4', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '3', '4', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'images');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` char(36) NOT NULL,
  `username` varchar(25) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `nama`, `email`, `password`, `no_hp`, `role`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku', 'fandi', 'aku@gmail.com', '123', '0812', 1);

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi`
--

CREATE TABLE `verifikasi` (
  `id` char(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booktiket`
--
ALTER TABLE `booktiket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `databank`
--
ALTER TABLE `databank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenisburung_id` (`jenisburung_id`),
  ADD KEY `lokasi_id` (`lokasi_id`);

--
-- Indexes for table `jenisburung`
--
ALTER TABLE `jenisburung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuspembayaran`
--
ALTER TABLE `statuspembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booktiket_id` (`booktiket_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `verifikasi`
--
ALTER TABLE `verifikasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenisburung`
--
ALTER TABLE `jenisburung`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=567686592;

--
-- AUTO_INCREMENT for table `jenispembayaran`
--
ALTER TABLE `jenispembayaran`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuspembayaran`
--
ALTER TABLE `statuspembayaran`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booktiket`
--
ALTER TABLE `booktiket`
  ADD CONSTRAINT `booktiket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `booktiket_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`jenisburung_id`) REFERENCES `jenisburung` (`id`),
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`);

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `peserta_ibfk_2` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `peserta_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`booktiket_id`) REFERENCES `booktiket` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
