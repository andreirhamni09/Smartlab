-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Agu 2021 pada 14.13
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srsssmsc_slab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses_levels`
--

CREATE TABLE `akses_levels` (
  `id` tinyint(4) NOT NULL,
  `jabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `halamans_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `akses_levels`
--

INSERT INTO `akses_levels` (`id`, `jabatan`, `halamans_id_s`) VALUES
(1, 'analis', ''),
(2, 'admin', ''),
(3, 'penyelia', ''),
(4, 'qc', ''),
(5, 'penyelia', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `aktivitas` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `aktivitas`) VALUES
(1, 'registrasi_sampel'),
(2, 'verifikasi_lab'),
(3, 'verifikasi_pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_sampels`
--

CREATE TABLE `data_sampels` (
  `id` smallint(6) NOT NULL,
  `jenis_sampels_id` tinyint(3) UNSIGNED NOT NULL,
  `pelanggans_id` int(10) UNSIGNED NOT NULL,
  `pakets_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_selesai` tinyint(4) NOT NULL,
  `nomor_surat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_sampel` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_sampels`
--

INSERT INTO `data_sampels` (`id`, `jenis_sampels_id`, `pelanggans_id`, `pakets_id_s`, `tanggal_masuk`, `tanggal_selesai`, `nomor_surat`, `jumlah_sampel`, `status`) VALUES
(1, 1, 1, '1-2-3', '2021-08-09 11:00:00', 10, '1010', 100, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_trackings`
--

CREATE TABLE `detail_trackings` (
  `aktivitas_waktu` datetime NOT NULL,
  `data_sampels_id` smallint(6) NOT NULL,
  `aktivitas_id` tinyint(3) UNSIGNED NOT NULL,
  `lab_akuns_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_trackings`
--

INSERT INTO `detail_trackings` (`aktivitas_waktu`, `data_sampels_id`, `aktivitas_id`, `lab_akuns_id`) VALUES
('2021-08-09 11:00:00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `halamans`
--

CREATE TABLE `halamans` (
  `id` tinyint(4) NOT NULL,
  `halaman` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_analisas`
--

CREATE TABLE `hasil_analisas` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenis_sampels_id` tinyint(3) UNSIGNED NOT NULL,
  `data_sampels_id` smallint(6) NOT NULL,
  `tahun` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_lab` int(11) NOT NULL,
  `kode_contoh` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasil` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `retry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hasil_analisas`
--

INSERT INTO `hasil_analisas` (`id`, `jenis_sampels_id`, `data_sampels_id`, `tahun`, `no_lab`, `kode_contoh`, `parameters_id_s`, `hasil`, `status`, `retry`) VALUES
(2, 1, 1, '21', 1, '', '1-2-3', '', '0', 0),
(3, 1, 1, '21', 2, '', '1-2-3', '', '0', 0),
(4, 1, 1, '21', 3, '', '1-2-3', '', '0', 0),
(5, 1, 1, '21', 4, '', '1-2-3', '', '0', 0),
(6, 1, 1, '21', 5, '', '1-2-3', '', '0', 0),
(7, 1, 1, '21', 6, '', '1-2-3', '', '0', 0),
(8, 1, 1, '21', 7, '', '1-2-3', '', '0', 0),
(9, 1, 1, '21', 8, '', '1-2-3', '', '0', 0),
(10, 1, 1, '21', 9, '', '1-2-3', '', '0', 0),
(11, 1, 1, '21', 10, '', '1-2-3', '', '0', 0),
(12, 1, 1, '21', 11, '', '1-2-3', '', '0', 0),
(13, 1, 1, '21', 12, '', '1-2-3', '', '0', 0),
(14, 1, 1, '21', 13, '', '1-2-3', '', '0', 0),
(15, 1, 1, '21', 14, '', '1-2-3', '', '0', 0),
(16, 1, 1, '21', 15, '', '1-2-3', '', '0', 0),
(17, 1, 1, '21', 16, '', '1-2-3', '', '0', 0),
(18, 1, 1, '21', 17, '', '1-2-3', '', '0', 0),
(19, 1, 1, '21', 18, '', '1-2-3', '', '0', 0),
(20, 1, 1, '21', 19, '', '1-2-3', '', '0', 0),
(21, 1, 1, '21', 20, '', '1-2-3', '', '0', 0),
(22, 1, 1, '21', 21, '', '1-2-3', '', '0', 0),
(23, 1, 1, '21', 22, '', '1-2-3', '', '0', 0),
(24, 1, 1, '21', 23, '', '1-2-3', '', '0', 0),
(25, 1, 1, '21', 24, '', '1-2-3', '', '0', 0),
(26, 1, 1, '21', 25, '', '1-2-3', '', '0', 0),
(27, 1, 1, '21', 26, '', '1-2-3', '', '0', 0),
(28, 1, 1, '21', 27, '', '1-2-3', '', '0', 0),
(29, 1, 1, '21', 28, '', '1-2-3', '', '0', 0),
(30, 1, 1, '21', 29, '', '1-2-3', '', '0', 0),
(31, 1, 1, '21', 30, '', '1-2-3', '', '0', 0),
(32, 1, 1, '21', 31, '', '1-2-3', '', '0', 0),
(33, 1, 1, '21', 32, '', '1-2-3', '', '0', 0),
(34, 1, 1, '21', 33, '', '1-2-3', '', '0', 0),
(35, 1, 1, '21', 34, '', '1-2-3', '', '0', 0),
(36, 1, 1, '21', 35, '', '1-2-3', '', '0', 0),
(37, 1, 1, '21', 36, '', '1-2-3', '', '0', 0),
(38, 1, 1, '21', 37, '', '1-2-3', '', '0', 0),
(39, 1, 1, '21', 38, '', '1-2-3', '', '0', 0),
(40, 1, 1, '21', 39, '', '1-2-3', '', '0', 0),
(41, 1, 1, '21', 40, '', '1-2-3', '', '0', 0),
(42, 1, 1, '21', 41, '', '1-2-3', '', '0', 0),
(43, 1, 1, '21', 42, '', '1-2-3', '', '0', 0),
(44, 1, 1, '21', 43, '', '1-2-3', '', '0', 0),
(45, 1, 1, '21', 44, '', '1-2-3', '', '0', 0),
(46, 1, 1, '21', 45, '', '1-2-3', '', '0', 0),
(47, 1, 1, '21', 46, '', '1-2-3', '', '0', 0),
(48, 1, 1, '21', 47, '', '1-2-3', '', '0', 0),
(49, 1, 1, '21', 48, '', '1-2-3', '', '0', 0),
(50, 1, 1, '21', 49, '', '1-2-3', '', '0', 0),
(51, 1, 1, '21', 50, '', '1-2-3', '', '0', 0),
(52, 1, 1, '21', 51, '', '1-2-3', '', '0', 0),
(53, 1, 1, '21', 52, '', '1-2-3', '', '0', 0),
(54, 1, 1, '21', 53, '', '1-2-3', '', '0', 0),
(55, 1, 1, '21', 54, '', '1-2-3', '', '0', 0),
(56, 1, 1, '21', 55, '', '1-2-3', '', '0', 0),
(57, 1, 1, '21', 56, '', '1-2-3', '', '0', 0),
(58, 1, 1, '21', 57, '', '1-2-3', '', '0', 0),
(59, 1, 1, '21', 58, '', '1-2-3', '', '0', 0),
(60, 1, 1, '21', 59, '', '1-2-3', '', '0', 0),
(61, 1, 1, '21', 60, '', '1-2-3', '', '0', 0),
(62, 1, 1, '21', 61, '', '1-2-3', '', '0', 0),
(63, 1, 1, '21', 62, '', '1-2-3', '', '0', 0),
(64, 1, 1, '21', 63, '', '1-2-3', '', '0', 0),
(65, 1, 1, '21', 64, '', '1-2-3', '', '0', 0),
(66, 1, 1, '21', 65, '', '1-2-3', '', '0', 0),
(67, 1, 1, '21', 66, '', '1-2-3', '', '0', 0),
(68, 1, 1, '21', 67, '', '1-2-3', '', '0', 0),
(69, 1, 1, '21', 68, '', '1-2-3', '', '0', 0),
(70, 1, 1, '21', 69, '', '1-2-3', '', '0', 0),
(71, 1, 1, '21', 70, '', '1-2-3', '', '0', 0),
(72, 1, 1, '21', 71, '', '1-2-3', '', '0', 0),
(73, 1, 1, '21', 72, '', '1-2-3', '', '0', 0),
(74, 1, 1, '21', 73, '', '1-2-3', '', '0', 0),
(75, 1, 1, '21', 74, '', '1-2-3', '', '0', 0),
(76, 1, 1, '21', 75, '', '1-2-3', '', '0', 0),
(77, 1, 1, '21', 76, '', '1-2-3', '', '0', 0),
(78, 1, 1, '21', 77, '', '1-2-3', '', '0', 0),
(79, 1, 1, '21', 78, '', '1-2-3', '', '0', 0),
(80, 1, 1, '21', 79, '', '1-2-3', '', '0', 0),
(81, 1, 1, '21', 80, '', '1-2-3', '', '0', 0),
(82, 1, 1, '21', 81, '', '1-2-3', '', '0', 0),
(83, 1, 1, '21', 82, '', '1-2-3', '', '0', 0),
(84, 1, 1, '21', 83, '', '1-2-3', '', '0', 0),
(85, 1, 1, '21', 84, '', '1-2-3', '', '0', 0),
(86, 1, 1, '21', 85, '', '1-2-3', '', '0', 0),
(87, 1, 1, '21', 86, '', '1-2-3', '', '0', 0),
(88, 1, 1, '21', 87, '', '1-2-3', '', '0', 0),
(89, 1, 1, '21', 88, '', '1-2-3', '', '0', 0),
(90, 1, 1, '21', 89, '', '1-2-3', '', '0', 0),
(91, 1, 1, '21', 90, '', '1-2-3', '', '0', 0),
(92, 1, 1, '21', 91, '', '1-2-3', '', '0', 0),
(93, 1, 1, '21', 92, '', '1-2-3', '', '0', 0),
(94, 1, 1, '21', 93, '', '1-2-3', '', '0', 0),
(95, 1, 1, '21', 94, '', '1-2-3', '', '0', 0),
(96, 1, 1, '21', 95, '', '1-2-3', '', '0', 0),
(97, 1, 1, '21', 96, '', '1-2-3', '', '0', 0),
(98, 1, 1, '21', 97, '', '1-2-3', '', '0', 0),
(99, 1, 1, '21', 98, '', '1-2-3', '', '0', 0),
(100, 1, 1, '21', 99, '', '1-2-3', '', '0', 0),
(101, 1, 1, '21', 100, '', '1-2-3', '', '0', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_sampels`
--

CREATE TABLE `jenis_sampels` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `jenis_sampel` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lambang_sampel` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_sampels`
--

INSERT INTO `jenis_sampels` (`id`, `jenis_sampel`, `lambang_sampel`) VALUES
(1, 'daun', 'L'),
(2, 'racis', 'R');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lab_akuns`
--

CREATE TABLE `lab_akuns` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `metodes_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akses_levels_id` tinyint(4) NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_akun` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lab_akuns`
--

INSERT INTO `lab_akuns` (`id`, `metodes_id_s`, `akses_levels_id`, `nama`, `email`, `password`, `jabatan`, `status_akun`) VALUES
(1, '1-2-3', 3, 'Indah', 'indah09@gmail.com', 'asdasdasd', 'penyelia', '1'),
(2, '1-2-3', 1, 'Yolanda Aptria', 'yolanda_aptria09@gmail.com', 'asdasdasd', 'analis', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metodes`
--

CREATE TABLE `metodes` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `metode` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `metodes`
--

INSERT INTO `metodes` (`id`, `metode`, `parameters_id_s`) VALUES
(1, 'Flamephotometry/AAS', '3-4-5-6-7-8-9'),
(2, 'Spektrophotometry', '2-10'),
(3, 'Kjedahl', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(170, '2021_08_05_084922_create_parameters_table', 1),
(171, '2021_08_05_084950_create_jenis_sampels_table', 1),
(172, '2021_08_05_092753_create_pelanggans_table', 1),
(173, '2021_08_05_092837_create_akses_levels_table', 1),
(174, '2021_08_05_092847_create_metodes_table', 1),
(175, '2021_08_05_092932_create_aktivitas_table', 1),
(176, '2021_08_05_092941_create_pakets_table', 1),
(177, '2021_08_05_092952_update_pakets_table', 1),
(178, '2021_08_05_093002_create_data_sampels_table', 1),
(179, '2021_08_05_093012_update_data_sampels_table', 1),
(180, '2021_08_05_132834_create_hasil_analisas_table', 1),
(181, '2021_08_05_133213_update_hasil_analisas_table', 1),
(182, '2021_08_05_133227_create_lab_akuns_table', 1),
(183, '2021_08_05_133236_update_lab_akuns_table', 1),
(184, '2021_08_05_133249_create_detail_trackings_table', 1),
(185, '2021_08_05_133934_update_detail_trackings_table', 1),
(186, '2021_08_06_034847_create_halamans_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pakets`
--

CREATE TABLE `pakets` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `jenis_sampels_id` tinyint(3) UNSIGNED NOT NULL,
  `paket` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pakets`
--

INSERT INTO `pakets` (`id`, `jenis_sampels_id`, `paket`, `parameters_id_s`, `harga`) VALUES
(1, 1, 'N', '1', 40000),
(2, 1, 'P', '2', 35000),
(3, 1, 'K', '3', 35000),
(4, 1, 'Mg', '4', 35000),
(5, 1, 'Ca', '5', 35000),
(6, 1, 'Cu', '6', 35000),
(7, 1, 'Zn', '7', 35000),
(8, 1, 'Mn', '8', 35000),
(9, 1, 'Fe', '9', 35000),
(10, 1, 'N,P,K', '1-2-3', 100000),
(11, 1, 'N,P,K,B', '1-2-3-10', 135000),
(12, 1, 'N,P,K,Mg', '1-2-3-4', 130000),
(13, 1, 'N,P,K,Mg,B', '1-2-3-4-10', 160000),
(14, 1, 'N,P,K,Mg,Ca', '1-2-3-4-5', 150000),
(15, 1, 'N,P,K,Mg,Ca,B', '1-2-3-4-5-10', 190000),
(16, 1, 'P,K', '2-3', 56000),
(17, 1, 'P,K,Mg', '2-3-4', 84000),
(18, 1, 'P,K,Mg,Ca', '2-3-4-5', 110000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `parameters`
--

CREATE TABLE `parameters` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `simbol` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_unsur` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `parameters`
--

INSERT INTO `parameters` (`id`, `simbol`, `nama_unsur`) VALUES
(1, 'N', 'nitrogen'),
(2, 'P', 'pospor'),
(3, 'K', 'kalium'),
(4, 'Mg', 'magnesium'),
(5, 'Ca', 'kalsium'),
(6, 'Cu', 'tembaga'),
(7, 'Zn', 'seng'),
(8, 'Mn', 'mangan'),
(9, 'Fe', 'beso'),
(10, 'B', 'born');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_registrasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `email`, `password`, `nama`, `perusahaan`, `nomor_telepon`, `alamat`, `tanggal_registrasi`) VALUES
(1, '1-2-3', '3', 'Indah', 'indah09@gmail.com', 'asdasdasd', 'penyelia', '2021-07-21');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akses_levels`
--
ALTER TABLE `akses_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_sampels`
--
ALTER TABLE `data_sampels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_sampels_jenis_sampels_id_foreign` (`jenis_sampels_id`),
  ADD KEY `data_sampels_pelanggans_id_foreign` (`pelanggans_id`);

--
-- Indeks untuk tabel `detail_trackings`
--
ALTER TABLE `detail_trackings`
  ADD KEY `detail_trackings_data_sampels_id_foreign` (`data_sampels_id`),
  ADD KEY `detail_trackings_aktivitas_id_foreign` (`aktivitas_id`),
  ADD KEY `detail_trackings_lab_akuns_id_foreign` (`lab_akuns_id`);

--
-- Indeks untuk tabel `halamans`
--
ALTER TABLE `halamans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_analisas`
--
ALTER TABLE `hasil_analisas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_analisas_jenis_sampels_id_foreign` (`jenis_sampels_id`),
  ADD KEY `hasil_analisas_data_sampels_id_foreign` (`data_sampels_id`);

--
-- Indeks untuk tabel `jenis_sampels`
--
ALTER TABLE `jenis_sampels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lab_akuns`
--
ALTER TABLE `lab_akuns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_akuns_akses_levels_id_foreign` (`akses_levels_id`);

--
-- Indeks untuk tabel `metodes`
--
ALTER TABLE `metodes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pakets`
--
ALTER TABLE `pakets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pakets_jenis_sampels_id_foreign` (`jenis_sampels_id`);

--
-- Indeks untuk tabel `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggans_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_sampels`
--
ALTER TABLE `data_sampels`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `halamans`
--
ALTER TABLE `halamans`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hasil_analisas`
--
ALTER TABLE `hasil_analisas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `jenis_sampels`
--
ALTER TABLE `jenis_sampels`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `lab_akuns`
--
ALTER TABLE `lab_akuns`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `metodes`
--
ALTER TABLE `metodes`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT untuk tabel `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_sampels`
--
ALTER TABLE `data_sampels`
  ADD CONSTRAINT `data_sampels_jenis_sampels_id_foreign` FOREIGN KEY (`jenis_sampels_id`) REFERENCES `jenis_sampels` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_sampels_pelanggans_id_foreign` FOREIGN KEY (`pelanggans_id`) REFERENCES `pelanggans` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_trackings`
--
ALTER TABLE `detail_trackings`
  ADD CONSTRAINT `detail_trackings_aktivitas_id_foreign` FOREIGN KEY (`aktivitas_id`) REFERENCES `aktivitas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_trackings_data_sampels_id_foreign` FOREIGN KEY (`data_sampels_id`) REFERENCES `data_sampels` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_trackings_lab_akuns_id_foreign` FOREIGN KEY (`lab_akuns_id`) REFERENCES `lab_akuns` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_analisas`
--
ALTER TABLE `hasil_analisas`
  ADD CONSTRAINT `hasil_analisas_data_sampels_id_foreign` FOREIGN KEY (`data_sampels_id`) REFERENCES `data_sampels` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_analisas_jenis_sampels_id_foreign` FOREIGN KEY (`jenis_sampels_id`) REFERENCES `jenis_sampels` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lab_akuns`
--
ALTER TABLE `lab_akuns`
  ADD CONSTRAINT `lab_akuns_akses_levels_id_foreign` FOREIGN KEY (`akses_levels_id`) REFERENCES `akses_levels` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pakets`
--
ALTER TABLE `pakets`
  ADD CONSTRAINT `pakets_jenis_sampels_id_foreign` FOREIGN KEY (`jenis_sampels_id`) REFERENCES `jenis_sampels` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
