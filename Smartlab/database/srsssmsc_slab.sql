-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Agu 2021 pada 10.02
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
(5, 'manager', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `aktivitas` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_sampels`
--

CREATE TABLE `jenis_sampels` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `jenis_sampel` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lambang_sampel` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `metodes`
--

CREATE TABLE `metodes` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `metode` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(89, '2021_08_05_084922_create_parameters_table', 1),
(90, '2021_08_05_084950_create_jenis_sampels_table', 1),
(91, '2021_08_05_092753_create_pelanggans_table', 1),
(92, '2021_08_05_092837_create_akses_levels_table', 1),
(93, '2021_08_05_092847_create_metodes_table', 1),
(94, '2021_08_05_092932_create_aktivitas_table', 1),
(95, '2021_08_05_092941_create_pakets_table', 1),
(96, '2021_08_05_092952_update_pakets_table', 1),
(97, '2021_08_05_093002_create_data_sampels_table', 1),
(98, '2021_08_05_093012_update_data_sampels_table', 1),
(99, '2021_08_05_132834_create_hasil_analisas_table', 1),
(100, '2021_08_05_133213_update_hasil_analisas_table', 1),
(101, '2021_08_05_133227_create_lab_akuns_table', 1),
(102, '2021_08_05_133236_update_lab_akuns_table', 1),
(103, '2021_08_05_133249_create_detail_trackings_table', 1),
(104, '2021_08_05_133934_update_detail_trackings_table', 1),
(105, '2021_08_06_034847_create_halamans_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pakets`
--

CREATE TABLE `pakets` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `jenis_sampels_id` tinyint(3) UNSIGNED NOT NULL,
  `paket` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paremeter_id_s` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `parameters`
--

CREATE TABLE `parameters` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `simbol` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_unsur` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akses_levels`
--
ALTER TABLE `akses_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `akses_levels_jabatan_unique` (`jabatan`);

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
-- AUTO_INCREMENT untuk tabel `akses_levels`
--
ALTER TABLE `akses_levels`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_sampels`
--
ALTER TABLE `data_sampels`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `halamans`
--
ALTER TABLE `halamans`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hasil_analisas`
--
ALTER TABLE `hasil_analisas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_sampels`
--
ALTER TABLE `jenis_sampels`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lab_akuns`
--
ALTER TABLE `lab_akuns`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `metodes`
--
ALTER TABLE `metodes`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
