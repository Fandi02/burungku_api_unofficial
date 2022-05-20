-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 09:32 AM
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
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` char(36) NOT NULL,
  `desa` varchar(25) NOT NULL,
  `kecamatan` varchar(25) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `provinsi` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `desa`, `kecamatan`, `kota`, `provinsi`) VALUES
('a665a623-9c3b-463f-be96-ad4ca8bc1712', 'landungsari', 'dau', 'kab. malang', 'jawa timur');

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
  `lokasi_id` char(36) NOT NULL,
  `jenislomba_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `judul`, `deskripsi`, `jadwal`, `jml_tiket`, `jml_sesi`, `harga_tiket`, `aturan`, `jenisburung_id`, `lokasi_id`, `jenislomba_id`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'kontes burungku', 'burung', '2022-05-21 14:01:31.000000', 20, 1, 2000, 'tidak ada', 234224, 'db99a49b-78fe-40a6-9efa-591ffcaf13a5', 2);

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
-- Table structure for table `jenislomba`
--

CREATE TABLE `jenislomba` (
  `id` int(12) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `jenisburung_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenislomba`
--

INSERT INTO `jenislomba` (`id`, `nama`, `jenisburung_id`) VALUES
(1, 'laptop', 234224),
(2, 'kecantikan', 567686590),
(8000, 'bulu', 567686590);

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
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'CFECF3F0-0F04-7F03-5B87-494635A29ED4'),
('61916B7E-DD60-3DDB-8AB6-76ABE94628CE', 'coba', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'CFECF3F0-0F04-7F03-5B87-494635A29ED4'),
('7F6F597C-79C2-4850-94DA-CF458D357560', 'coba', '25bd3c05-180e-42f7-80ac-e528b86dbb23', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'CFECF3F0-0F04-7F03-5B87-494635A29ED4');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` char(36) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `user_id` char(36) NOT NULL,
  `email` varchar(33) NOT NULL,
  `jkel` varchar(25) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `alamat_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `nama`, `user_id`, `email`, `jkel`, `no_telp`, `alamat_id`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku@gmail.com', 'laki-laki', '08125687535', 'a665a623-9c3b-463f-be96-ad4ca8bc1712'),
('F5CB686F-B5FE-C2E6-5BE7-9547874B6986', 'coba', '25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku@gmail.com', 'laki-laki', '08125687535', 'a665a623-9c3b-463f-be96-ad4ca8bc1712');

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
  `role` int(2) NOT NULL,
  `otp` int(5) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `nama`, `email`, `password`, `no_hp`, `role`, `otp`, `is_verified`) VALUES
('25bd3c05-180e-42f7-80ac-e528b86dbb23', 'aku', 'fandi', 'aku@gmail.com', '123', '0812', 1, 0, 0);

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
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `lokasi_id` (`lokasi_id`),
  ADD KEY `jenislomba_id` (`jenislomba_id`);

--
-- Indexes for table `jenisburung`
--
ALTER TABLE `jenisburung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenislomba`
--
ALTER TABLE `jenislomba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenisburung_id` (`jenisburung_id`);

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
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alamat_id` (`alamat_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `jenislomba`
--
ALTER TABLE `jenislomba`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8002;

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
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`lokasi_id`) REFERENCES `lokasi` (`id`),
  ADD CONSTRAINT `event_ibfk_4` FOREIGN KEY (`jenislomba_id`) REFERENCES `jenislomba` (`id`);

--
-- Constraints for table `jenislomba`
--
ALTER TABLE `jenislomba`
  ADD CONSTRAINT `jenislomba_ibfk_1` FOREIGN KEY (`jenisburung_id`) REFERENCES `jenisburung` (`id`);

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `peserta_ibfk_2` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `peserta_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`alamat_id`) REFERENCES `alamat` (`id`),
  ADD CONSTRAINT `profil_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

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
