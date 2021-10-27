-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Okt 2021 pada 03.25
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
  `halamans_id_s` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
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
  `groups_id` tinyint(3) UNSIGNED NOT NULL,
  `aktivitas` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `aktivitas`
--

INSERT INTO `aktivitas` (`id`, `groups_id`, `aktivitas`) VALUES
(1, 1, 'registrasi_sampel'),
(2, 1, 'verifikasi_lab'),
(3, 1, 'verifikasi_pelanggan'),
(4, 2, 'oven'),
(5, 3, 'preparasi');

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
  `ketersedian_alats_id` enum('1','') COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan_userlabs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan_pelanggans` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_sampels`
--

INSERT INTO `data_sampels` (`id`, `jenis_sampels_id`, `pelanggans_id`, `pakets_id_s`, `tanggal_masuk`, `tanggal_selesai`, `nomor_surat`, `jumlah_sampel`, `ketersedian_alats_id`, `catatan_userlabs`, `catatan_pelanggans`, `status`) VALUES
(1, 1, 2, '1-2-3', '2021-10-05 14:42:00', 12, '1112', 111, '', 'sadas', '', '0'),
(2, 1, 2, '1-2-3', '2021-10-05 14:42:00', 12, '1112', 111, '', 'sadas', '', '0'),
(3, 1, 2, '1-2-3', '2021-10-05 14:42:00', 12, '1112', 111, '', 'sadas', '', '0'),
(4, 1, 2, '1-2-3', '2021-10-06 08:18:00', 22, '1112', 11, '', 'asdasdasd', '', '0');

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
('2021-10-05 07:49:00', 1, 1, 1),
('2021-10-05 07:51:00', 2, 1, 1),
('2021-10-05 07:53:00', 3, 1, 1),
('2021-10-06 01:19:00', 4, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_aktivitas`
--

CREATE TABLE `group_aktivitas` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `group` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `group_aktivitas`
--

INSERT INTO `group_aktivitas` (`id`, `group`) VALUES
(1, 'REGISTRASI SAMPEL'),
(2, 'PREPARASI'),
(3, 'ANALISIS SAMPEL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `halamans`
--

CREATE TABLE `halamans` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `halaman` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `halamans`
--

INSERT INTO `halamans` (`id`, `halaman`, `url`, `simbol`) VALUES
(1, 'AKTIVITAS', 'admin/aktivitas', 'nav-icon fas fa-list'),
(2, 'LAB AKUN', 'admin/labakuns', 'nav-icon fas fa-list'),
(3, 'PARAMETER', 'admin/parameters', 'nav-icon fas fa-list');

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
  `lab_akuns_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hasil` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` tinyint(4) NOT NULL,
  `verifikasi_hasil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hasil_analisas`
--

INSERT INTO `hasil_analisas` (`id`, `jenis_sampels_id`, `data_sampels_id`, `tahun`, `no_lab`, `kode_contoh`, `lab_akuns_id`, `parameters_id`, `hasil`, `status`, `log`, `batch`, `verifikasi_hasil`) VALUES
(1, 1, 1, '21', 1, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(2, 1, 1, '21', 2, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(3, 1, 1, '21', 3, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(4, 1, 1, '21', 4, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(5, 1, 1, '21', 5, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(6, 1, 1, '21', 6, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(7, 1, 1, '21', 7, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(8, 1, 1, '21', 8, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(9, 1, 1, '21', 9, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(10, 1, 1, '21', 10, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(11, 1, 1, '21', 11, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(12, 1, 1, '21', 12, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(13, 1, 1, '21', 13, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(14, 1, 1, '21', 14, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(15, 1, 1, '21', 15, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(16, 1, 1, '21', 16, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(17, 1, 1, '21', 17, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(18, 1, 1, '21', 18, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(19, 1, 1, '21', 19, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(20, 1, 1, '21', 20, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(21, 1, 1, '21', 21, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(22, 1, 1, '21', 22, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(23, 1, 1, '21', 23, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(24, 1, 1, '21', 24, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(25, 1, 1, '21', 25, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(26, 1, 1, '21', 26, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(27, 1, 1, '21', 27, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(28, 1, 1, '21', 28, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(29, 1, 1, '21', 29, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(30, 1, 1, '21', 30, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(31, 1, 1, '21', 31, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(32, 1, 1, '21', 32, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(33, 1, 1, '21', 33, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(34, 1, 1, '21', 34, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(35, 1, 1, '21', 35, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(36, 1, 1, '21', 36, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(37, 1, 1, '21', 37, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(38, 1, 1, '21', 38, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(39, 1, 1, '21', 39, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(40, 1, 1, '21', 40, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(41, 1, 1, '21', 41, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(42, 1, 1, '21', 42, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(43, 1, 1, '21', 43, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(44, 1, 1, '21', 44, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(45, 1, 1, '21', 45, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(46, 1, 1, '21', 46, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(47, 1, 1, '21', 47, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(48, 1, 1, '21', 48, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(49, 1, 1, '21', 49, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(50, 1, 1, '21', 50, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(51, 1, 1, '21', 51, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(52, 1, 1, '21', 52, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(53, 1, 1, '21', 53, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(54, 1, 1, '21', 54, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(55, 1, 1, '21', 55, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(56, 1, 1, '21', 56, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(57, 1, 1, '21', 57, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(58, 1, 1, '21', 58, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(59, 1, 1, '21', 59, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(60, 1, 1, '21', 60, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(61, 1, 1, '21', 61, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(62, 1, 1, '21', 62, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(63, 1, 1, '21', 63, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(64, 1, 1, '21', 64, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(65, 1, 1, '21', 65, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(66, 1, 1, '21', 66, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(67, 1, 1, '21', 67, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(68, 1, 1, '21', 68, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(69, 1, 1, '21', 69, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(70, 1, 1, '21', 70, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(71, 1, 1, '21', 71, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(72, 1, 1, '21', 72, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(73, 1, 1, '21', 73, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(74, 1, 1, '21', 74, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(75, 1, 1, '21', 75, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(76, 1, 1, '21', 76, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(77, 1, 1, '21', 77, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(78, 1, 1, '21', 78, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(79, 1, 1, '21', 79, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(80, 1, 1, '21', 80, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(81, 1, 1, '21', 81, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(82, 1, 1, '21', 82, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(83, 1, 1, '21', 83, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(84, 1, 1, '21', 84, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(85, 1, 1, '21', 85, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(86, 1, 1, '21', 86, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(87, 1, 1, '21', 87, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(88, 1, 1, '21', 88, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(89, 1, 1, '21', 89, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(90, 1, 1, '21', 90, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(91, 1, 1, '21', 91, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(92, 1, 1, '21', 92, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(93, 1, 1, '21', 93, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(94, 1, 1, '21', 94, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(95, 1, 1, '21', 95, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(96, 1, 1, '21', 96, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(97, 1, 1, '21', 97, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(98, 1, 1, '21', 98, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(99, 1, 1, '21', 99, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(100, 1, 1, '21', 100, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(101, 1, 1, '21', 101, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(102, 1, 1, '21', 102, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(103, 1, 1, '21', 103, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(104, 1, 1, '21', 104, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(105, 1, 1, '21', 105, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(106, 1, 1, '21', 106, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(107, 1, 1, '21', 107, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(108, 1, 1, '21', 108, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(109, 1, 1, '21', 109, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(110, 1, 1, '21', 110, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(111, 1, 1, '21', 111, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(112, 1, 2, '21', 112, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(113, 1, 2, '21', 113, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(114, 1, 2, '21', 114, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(115, 1, 2, '21', 115, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(116, 1, 2, '21', 116, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(117, 1, 2, '21', 117, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(118, 1, 2, '21', 118, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(119, 1, 2, '21', 119, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(120, 1, 2, '21', 120, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(121, 1, 2, '21', 121, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(122, 1, 2, '21', 122, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(123, 1, 2, '21', 123, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(124, 1, 2, '21', 124, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(125, 1, 2, '21', 125, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(126, 1, 2, '21', 126, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(127, 1, 2, '21', 127, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(128, 1, 2, '21', 128, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(129, 1, 2, '21', 129, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(130, 1, 2, '21', 130, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(131, 1, 2, '21', 131, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(132, 1, 2, '21', 132, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(133, 1, 2, '21', 133, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(134, 1, 2, '21', 134, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(135, 1, 2, '21', 135, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(136, 1, 2, '21', 136, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(137, 1, 2, '21', 137, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(138, 1, 2, '21', 138, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(139, 1, 2, '21', 139, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(140, 1, 2, '21', 140, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(141, 1, 2, '21', 141, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(142, 1, 2, '21', 142, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(143, 1, 2, '21', 143, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(144, 1, 2, '21', 144, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(145, 1, 2, '21', 145, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(146, 1, 2, '21', 146, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(147, 1, 2, '21', 147, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(148, 1, 2, '21', 148, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(149, 1, 2, '21', 149, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(150, 1, 2, '21', 150, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(151, 1, 2, '21', 151, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(152, 1, 2, '21', 152, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(153, 1, 2, '21', 153, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(154, 1, 2, '21', 154, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(155, 1, 2, '21', 155, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(156, 1, 2, '21', 156, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(157, 1, 2, '21', 157, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(158, 1, 2, '21', 158, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(159, 1, 2, '21', 159, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(160, 1, 2, '21', 160, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(161, 1, 2, '21', 161, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(162, 1, 2, '21', 162, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(163, 1, 2, '21', 163, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(164, 1, 2, '21', 164, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(165, 1, 2, '21', 165, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(166, 1, 2, '21', 166, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(167, 1, 2, '21', 167, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(168, 1, 2, '21', 168, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(169, 1, 2, '21', 169, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(170, 1, 2, '21', 170, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(171, 1, 2, '21', 171, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(172, 1, 2, '21', 172, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(173, 1, 2, '21', 173, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(174, 1, 2, '21', 174, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(175, 1, 2, '21', 175, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(176, 1, 2, '21', 176, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(177, 1, 2, '21', 177, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(178, 1, 2, '21', 178, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(179, 1, 2, '21', 179, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(180, 1, 2, '21', 180, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(181, 1, 2, '21', 181, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(182, 1, 2, '21', 182, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(183, 1, 2, '21', 183, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(184, 1, 2, '21', 184, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(185, 1, 2, '21', 185, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(186, 1, 2, '21', 186, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(187, 1, 2, '21', 187, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(188, 1, 2, '21', 188, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(189, 1, 2, '21', 189, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(190, 1, 2, '21', 190, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(191, 1, 2, '21', 191, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(192, 1, 2, '21', 192, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(193, 1, 2, '21', 193, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(194, 1, 2, '21', 194, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(195, 1, 2, '21', 195, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(196, 1, 2, '21', 196, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(197, 1, 2, '21', 197, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(198, 1, 2, '21', 198, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(199, 1, 2, '21', 199, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(200, 1, 2, '21', 200, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(201, 1, 2, '21', 201, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(202, 1, 2, '21', 202, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(203, 1, 2, '21', 203, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(204, 1, 2, '21', 204, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(205, 1, 2, '21', 205, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(206, 1, 2, '21', 206, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(207, 1, 2, '21', 207, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(208, 1, 2, '21', 208, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(209, 1, 2, '21', 209, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(210, 1, 2, '21', 210, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(211, 1, 2, '21', 211, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(212, 1, 2, '21', 212, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(213, 1, 2, '21', 213, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(214, 1, 2, '21', 214, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(215, 1, 2, '21', 215, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(216, 1, 2, '21', 216, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(217, 1, 2, '21', 217, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(218, 1, 2, '21', 218, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(219, 1, 2, '21', 219, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(220, 1, 2, '21', 220, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(221, 1, 2, '21', 221, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(222, 1, 2, '21', 222, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(223, 1, 3, '21', 223, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(224, 1, 3, '21', 224, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(225, 1, 3, '21', 225, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(226, 1, 3, '21', 226, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(227, 1, 3, '21', 227, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(228, 1, 3, '21', 228, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(229, 1, 3, '21', 229, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(230, 1, 3, '21', 230, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(231, 1, 3, '21', 231, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(232, 1, 3, '21', 232, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(233, 1, 3, '21', 233, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(234, 1, 3, '21', 234, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(235, 1, 3, '21', 235, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(236, 1, 3, '21', 236, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(237, 1, 3, '21', 237, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(238, 1, 3, '21', 238, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(239, 1, 3, '21', 239, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(240, 1, 3, '21', 240, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(241, 1, 3, '21', 241, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(242, 1, 3, '21', 242, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(243, 1, 3, '21', 243, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(244, 1, 3, '21', 244, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(245, 1, 3, '21', 245, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(246, 1, 3, '21', 246, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(247, 1, 3, '21', 247, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(248, 1, 3, '21', 248, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(249, 1, 3, '21', 249, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(250, 1, 3, '21', 250, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(251, 1, 3, '21', 251, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(252, 1, 3, '21', 252, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(253, 1, 3, '21', 253, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(254, 1, 3, '21', 254, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(255, 1, 3, '21', 255, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(256, 1, 3, '21', 256, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(257, 1, 3, '21', 257, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(258, 1, 3, '21', 258, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(259, 1, 3, '21', 259, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(260, 1, 3, '21', 260, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(261, 1, 3, '21', 261, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(262, 1, 3, '21', 262, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(263, 1, 3, '21', 263, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(264, 1, 3, '21', 264, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(265, 1, 3, '21', 265, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(266, 1, 3, '21', 266, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(267, 1, 3, '21', 267, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(268, 1, 3, '21', 268, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(269, 1, 3, '21', 269, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(270, 1, 3, '21', 270, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(271, 1, 3, '21', 271, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(272, 1, 3, '21', 272, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(273, 1, 3, '21', 273, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(274, 1, 3, '21', 274, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(275, 1, 3, '21', 275, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(276, 1, 3, '21', 276, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(277, 1, 3, '21', 277, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(278, 1, 3, '21', 278, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(279, 1, 3, '21', 279, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(280, 1, 3, '21', 280, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(281, 1, 3, '21', 281, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(282, 1, 3, '21', 282, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(283, 1, 3, '21', 283, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(284, 1, 3, '21', 284, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(285, 1, 3, '21', 285, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(286, 1, 3, '21', 286, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(287, 1, 3, '21', 287, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(288, 1, 3, '21', 288, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(289, 1, 3, '21', 289, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(290, 1, 3, '21', 290, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(291, 1, 3, '21', 291, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(292, 1, 3, '21', 292, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(293, 1, 3, '21', 293, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(294, 1, 3, '21', 294, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(295, 1, 3, '21', 295, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(296, 1, 3, '21', 296, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(297, 1, 3, '21', 297, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(298, 1, 3, '21', 298, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(299, 1, 3, '21', 299, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(300, 1, 3, '21', 300, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(301, 1, 3, '21', 301, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(302, 1, 3, '21', 302, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(303, 1, 3, '21', 303, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(304, 1, 3, '21', 304, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(305, 1, 3, '21', 305, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(306, 1, 3, '21', 306, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(307, 1, 3, '21', 307, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(308, 1, 3, '21', 308, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(309, 1, 3, '21', 309, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(310, 1, 3, '21', 310, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(311, 1, 3, '21', 311, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(312, 1, 3, '21', 312, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(313, 1, 3, '21', 313, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(314, 1, 3, '21', 314, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(315, 1, 3, '21', 315, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(316, 1, 3, '21', 316, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(317, 1, 3, '21', 317, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(318, 1, 3, '21', 318, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(319, 1, 3, '21', 319, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(320, 1, 3, '21', 320, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(321, 1, 3, '21', 321, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(322, 1, 3, '21', 322, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(323, 1, 3, '21', 323, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(324, 1, 3, '21', 324, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(325, 1, 3, '21', 325, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(326, 1, 3, '21', 326, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(327, 1, 3, '21', 327, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(328, 1, 3, '21', 328, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(329, 1, 3, '21', 329, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(330, 1, 3, '21', 330, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(331, 1, 3, '21', 331, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(332, 1, 3, '21', 332, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(333, 1, 3, '21', 333, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(334, 1, 4, '21', 334, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(335, 1, 4, '21', 335, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(336, 1, 4, '21', 336, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(337, 1, 4, '21', 337, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(338, 1, 4, '21', 338, '', '1', '1-2-3', '-;-;-', '0', '', 1, 0),
(339, 1, 4, '21', 339, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(340, 1, 4, '21', 340, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(341, 1, 4, '21', 341, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(342, 1, 4, '21', 342, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(343, 1, 4, '21', 343, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0),
(344, 1, 4, '21', 344, '', '1', '1-2-3', '-;-;-', '0', '', 2, 0);

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
  `akses_levels_id` tinyint(4) NOT NULL,
  `metodes_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_akun` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lab_akuns`
--

INSERT INTO `lab_akuns` (`id`, `akses_levels_id`, `metodes_id_s`, `nama`, `email`, `password`, `jabatan`, `status_akun`) VALUES
(1, 3, '1-2-3', 'Indah', 'indah09@gmail.com', 'asdasdasd', 'penyelia', '1'),
(2, 1, '1-2-3', 'Yolanda Aptria', 'yolanda_aptria09@gmail.com', 'asdasdasd', 'analis', '1'),
(3, 4, '1', 'Andre S I W', 'andreirhamni09@gmail.com', 'luarbiasa', 'ADMIN', '1');

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
(1, '2021_08_05_084922_create_parameters_table', 1),
(2, '2021_08_05_084950_create_jenis_sampels_table', 1),
(3, '2021_08_05_092753_create_pelanggans_table', 1),
(4, '2021_08_05_092837_create_akses_levels_table', 1),
(5, '2021_08_05_092847_create_metodes_table', 1),
(6, '2021_08_05_092932_create_aktivitas_table', 1),
(7, '2021_08_05_092941_create_pakets_table', 1),
(8, '2021_08_05_092952_update_pakets_table', 1),
(9, '2021_08_05_093002_create_data_sampels_table', 1),
(10, '2021_09_07_142006_update_data_sampels_table', 1),
(11, '2021_09_07_142014_create_hasil_analisas_table', 2),
(12, '2021_09_07_142020_update_hasil_analisas_table', 2),
(13, '2021_09_07_142027_create_lab_akuns_table', 2),
(14, '2021_09_07_142033_update_lab_akuns_table', 2),
(15, '2021_09_07_142039_create_detail_trackings_table', 2),
(16, '2021_09_07_142045_update_detail_trackings_table', 2),
(17, '2021_09_07_142055_create_halamans_table', 2),
(18, '2021_09_08_003329_create_group_aktivitas_table', 2),
(19, '2021_09_08_003508_update_aktivitas_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pakets`
--

CREATE TABLE `pakets` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `jenis_sampels_id` tinyint(3) UNSIGNED NOT NULL,
  `paket` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodes_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pakets`
--

INSERT INTO `pakets` (`id`, `jenis_sampels_id`, `paket`, `parameters_id_s`, `metodes_id_s`, `harga`) VALUES
(1, 1, 'N', '1', '', 40000),
(2, 1, 'P', '2', '', 35000),
(3, 1, 'K', '3', '', 35000),
(4, 1, 'Mg', '4', '', 35000),
(5, 1, 'Ca', '5', '', 35000),
(6, 1, 'Cu', '6', '', 35000),
(7, 1, 'Zn', '7', '', 35000),
(8, 1, 'Mn', '8', '', 35000),
(9, 1, 'Fe', '9', '', 35000),
(10, 1, 'N,P,K', '1-2-3', '', 100000),
(11, 1, 'N,P,K,B', '1-2-3-10', '', 135000),
(12, 1, 'N,P,K,Mg', '1-2-3-4', '', 130000),
(13, 1, 'N,P,K,Mg,B', '1-2-3-4-10', '', 160000),
(14, 1, 'N,P,K,Mg,Ca', '1-2-3-4-5', '', 150000),
(15, 1, 'N,P,K,Mg,Ca,B', '1-2-3-4-5-10', '', 190000),
(16, 1, 'P,K', '2-3', '', 56000),
(17, 1, 'P,K,Mg', '2-3-4', '', 84000),
(18, 1, 'P,K,Mg,Ca', '2-3-4-5', '', 110000),
(20, 1, 'N, K', '1-3', '1-2', 110000);

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
(10, 'B', 'boron');

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
  `npwp` varchar(27) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuesioner` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_registrasi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `email`, `password`, `nama`, `perusahaan`, `nomor_telepon`, `alamat`, `npwp`, `kuesioner`, `tanggal_registrasi`) VALUES
(1, 'indah09@gmail.com', 'asdasdasd', 'Indah', 'RND', '088288102811', 'RND', '93.057.498.0-000.000', '', '2021-07-21'),
(2, 'andreirhamni09@gmail.com', 'asdasdasd', 'Andre S I W', 'PT MANA LAGI', '080808080801', 'RND', '93.057.498.0-000.000', '', '2021-09-30');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `aktivitas_groups_id_foreign` (`groups_id`);

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
-- Indeks untuk tabel `group_aktivitas`
--
ALTER TABLE `group_aktivitas`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `data_sampels`
--
ALTER TABLE `data_sampels`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `group_aktivitas`
--
ALTER TABLE `group_aktivitas`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `halamans`
--
ALTER TABLE `halamans`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `hasil_analisas`
--
ALTER TABLE `hasil_analisas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT untuk tabel `jenis_sampels`
--
ALTER TABLE `jenis_sampels`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `lab_akuns`
--
ALTER TABLE `lab_akuns`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `metodes`
--
ALTER TABLE `metodes`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_groups_id_foreign` FOREIGN KEY (`groups_id`) REFERENCES `group_aktivitas` (`id`) ON UPDATE CASCADE;

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
