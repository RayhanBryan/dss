-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Apr 2021 pada 15.51
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahp_saw_maps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ahp_saw_maps` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ahp_saw_maps`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values 
('admin','admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(256) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_alternatif`
--

INSERT INTO `tb_alternatif` (`kode_alternatif`, `nama_alternatif`, `keterangan`, `lat`, `lng`) VALUES
('A3', 'Pendaftar 3', '', '-7.6299754', '111.4930317'),
('A2', 'Kopi Merapi', 'Kopi Merapi Sumijo', '-7.609372299999998', '110.4530214'),
('A1', 'Blackbone Cafe', '', '-7.7623107', '110.3782537');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_crips`
--

CREATE TABLE `tb_crips` (
  `kode_crips` int(11) NOT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `keterangan` varchar(256) DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_crips`
--

INSERT INTO `tb_crips` (`kode_crips`, `kode_kriteria`, `keterangan`, `nilai`) VALUES
(11, 'C02', 'Pogung', 125);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(256) DEFAULT NULL,
  `atribut` varchar(16) DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  `maps` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`kode_kriteria`, `nama_kriteria`, `atribut`, `bobot`, `maps`) VALUES
('C01', 'Aksesibilitas & Visibilitas', 'cost', 0.19761657906239, 'jarak'),
('C02', 'Lingkungan', 'benefit', 0.27484760119428, 'tidak'),
('C03', 'Kompetitor', 'cost', 0.13007482540025, 'jumlah'),
('C04', 'Parkir', 'benefit', 0.097876839615859, 'tidak'),
('C05', 'Ukuran Lokasi', 'benefit', 0.14979207736361, 'tidak'),
('C06', 'Biaya', 'cost', NULL, 'tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rel_alternatif`
--

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `kode_crips` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_rel_alternatif`
--

INSERT INTO `tb_rel_alternatif` (`ID`, `kode_alternatif`, `kode_kriteria`, `kode_crips`) VALUES
(1, 'A1', 'C01', 2),
(2, 'A2', 'C01', 1),
(3, 'A3', 'C01', 1),
(4, 'A1', 'C02', 4),
(5, 'A2', 'C02', 3),
(6, 'A3', 'C02', 3),
(7, 'A1', 'C03', 6),
(8, 'A2', 'C03', 5),
(9, 'A3', 'C03', 5),
(10, 'A1', 'C04', 4),
(11, 'A2', 'C04', 1),
(12, 'A3', 'C04', 20),
(13, 'A1', 'C05', 170.426),
(14, 'A2', 'C05', 236.783),
(15, 'A3', 'C05', 120.688),
(30, 'A3', 'C06', 0),
(29, 'A2', 'C06', 0),
(28, 'A1', 'C06', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rel_kriteria`
--

CREATE TABLE `tb_rel_kriteria` (
  `ID1` varchar(16) NOT NULL,
  `ID2` varchar(16) NOT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_rel_kriteria`
--

INSERT INTO `tb_rel_kriteria` (`ID1`, `ID2`, `nilai`) VALUES
('C01', 'C01', 1),
('C01', 'C02', 0.2),
('C01', 'C03', 3),
('C01', 'C04', 4),
('C01', 'C05', 0.333333333),
('C01', 'C06', 0.5),
('C02', 'C01', 5),
('C02', 'C02', 1),
('C02', 'C03', 2),
('C02', 'C04', 3),
('C02', 'C05', 1),
('C02', 'C06', 0.25),
('C03', 'C01', 0.333333333),
('C03', 'C02', 0.5),
('C03', 'C03', 1),
('C03', 'C04', 2),
('C03', 'C05', 1),
('C03', 'C06', 1),
('C04', 'C01', 0.25),
('C04', 'C02', 0.333333333),
('C04', 'C03', 0.5),
('C04', 'C04', 1),
('C04', 'C05', 1),
('C04', 'C06', 0.166666666),
('C05', 'C01', 3),
('C05', 'C02', 1),
('C05', 'C03', 1),
('C05', 'C04', 1),
('C05', 'C05', 1),
('C05', 'C06', 0.2),
('C06', 'C01', 2),
('C06', 'C02', 4),
('C06', 'C03', 1),
('C06', 'C04', 6),
('C06', 'C05', 5),
('C06', 'C06', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indeks untuk tabel `tb_crips`
--
ALTER TABLE `tb_crips`
  ADD PRIMARY KEY (`kode_crips`);

--
-- Indeks untuk tabel `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indeks untuk tabel `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `tb_rel_kriteria`
--
ALTER TABLE `tb_rel_kriteria`
  ADD PRIMARY KEY (`ID1`,`ID2`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_crips`
--
ALTER TABLE `tb_crips`
  MODIFY `kode_crips` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
