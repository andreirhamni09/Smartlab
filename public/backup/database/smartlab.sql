-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jun 2021 pada 02.29
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartlab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `jabatan` varchar(45) NOT NULL,
  `akses_level` enum('1','2','3','4','5','6') NOT NULL,
  `status_akun` enum('0','1','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id`, `nama`, `jabatan`, `akses_level`, `status_akun`) VALUES
(1, 'Sulpi', 'Admin', '2', '1'),
(2, 'Ernawati', 'Admin', '2', '1'),
(3, 'Nur Isma Mardlotillah\r\n', 'Drafter ISO', '1', '1'),
(4, 'Indah\r\n', 'Penyelia', '3', '1'),
(5, 'Yevi Febtria Mukhti\r\n', 'Penyelia', '3', '1'),
(6, 'Wulan Permata Ardean\r\n', 'Penyelia', '3', '1'),
(7, 'Erinda Hamida\r\n', 'Analis', '1', '1'),
(8, 'Yolanda Aptria\r\n', 'Analis', '1', '1'),
(9, 'Yudha Prawira\r\n', 'Analis', '1', '1'),
(10, 'Muh. Alfadira\r\n', 'Analis', '1', '1'),
(11, 'Sundari puspita sari\r\n', 'Analis', '1', '1'),
(12, 'Dwi Julianto\r\n', 'Analis', '1', '1'),
(13, 'Andika Ika Saputra\r\n', 'Analis', '1', '1'),
(14, 'Ella Lestari\r\n', 'Analis', '1', '1'),
(15, 'Muh. Maskur Baihaqi\r\n', 'Analis', '1', '1'),
(16, 'Lukmanul Hakim\r\n', 'Maintenance', '1', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `harga`
--

CREATE TABLE `harga` (
  `id` int(11) NOT NULL,
  `jenis_sampel` enum('daun-racis','tanah','air','tbs','pupuk') NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `metode` text NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `harga`
--

INSERT INTO `harga` (`id`, `jenis_sampel`, `parameter`, `metode`, `harga`) VALUES
(1, 'daun-racis', 'Nitrogen (N)', 'Kjeldahl', 40000),
(2, 'daun-racis', 'Fosfor (P)', 'Spectrofotometry', 35000),
(3, 'daun-racis', 'Kalium (K)', 'Flamefhotometry(AAS)', 35000),
(4, 'daun-racis', 'Magnesium (Mg)', 'Flamefhotometry(AAS)', 35000),
(5, 'daun-racis', 'Kalsium (Ca)', 'Flamefhotometry(AAS)', 35000),
(6, 'daun-racis', 'Tembaga (Cu)', 'Flamefhotometry(AAS)', 35000),
(7, 'daun-racis', 'Seng (Zn)\r\n', 'Flamefhotometry(AAS)', 35000),
(8, 'daun-racis', 'Mangan (Mn)', 'Flamefhotometry(AAS)', 35000),
(9, 'daun-racis', 'Besi (Fe)\r\n', 'Flamefhotometry(AAS)', 35000),
(10, 'daun-racis', 'Boron (B)', 'Spectrofotometry', 40000),
(11, 'daun-racis', 'N, P, K', 'N=Kjeldahl, P=Spectrofotometry, K=Flamefhotometry(AAS)', 100000),
(12, 'daun-racis', 'N, P, K, B\r\n', 'N=Kjeldahl, P/B=Spectrofotometry, K=Flamefhotometry(AAS)', 135000),
(13, 'daun-racis', 'N, P, K, Mg\r\n', 'N=Kjeldahl, P=Spectrofotometry, K/Mg=Flamefhotometry(AAS)', 130000),
(14, 'daun-racis', 'N, P, K, Mg, B\r\n', 'N=Kjeldahl, P/B=Spectrofotometry, K/Mg=Flamefhotometry(AAS)', 160000),
(15, 'daun-racis', 'N, P, K, Mg, Ca\r\n', '', 150000),
(16, 'daun-racis', 'N, P, K, Mg, Ca, B\r\n', 'N=Kjeldahl, P/B=Spectrofotometry, K/Mg/Ca/CU/Zn/Fe=Flamefhotometry(AAS)', 190000),
(17, 'daun-racis', 'P, K\r\n', '', 56000),
(18, 'daun-racis', 'P, K, MG', '', 84000),
(19, 'daun-racis', 'P, K, Mg, Ca\r\n', '', 110000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kupa`
--

CREATE TABLE `kupa` (
  `id` int(11) NOT NULL,
  `masuk` datetime NOT NULL,
  `target` datetime NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `no_lab` varchar(100) NOT NULL,
  `perusahaan` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kode_user` int(11) NOT NULL,
  `jenis` enum('daunt') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `parameter` varchar(100) NOT NULL,
  `terkini` enum('sertifikat') NOT NULL,
  `draft` text NOT NULL,
  `hasil` text NOT NULL,
  `selesai` datetime NOT NULL,
  `petugas` text NOT NULL,
  `total_harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `harga`
--
ALTER TABLE `harga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kupa`
--
ALTER TABLE `kupa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `harga`
--
ALTER TABLE `harga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `kupa`
--
ALTER TABLE `kupa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
