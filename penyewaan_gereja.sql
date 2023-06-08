-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2023 pada 18.16
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penyewaan_gereja`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `dibaca` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kritik_saran`
--

INSERT INTO `kritik_saran` (`id`, `nama`, `email`, `pesan`, `tanggal_waktu`, `dibaca`) VALUES
(3, 'Laras', 'laras345@gmail.com', 'suka bgt sama dekorasi pernikahannya, mewah banget', '2023-06-01 11:11:14', 1),
(4, 'Sehun', 'sehunoh@gmail.com', 'Menurut saya dekorasi pernikahannya terlalu biasa, dan juga tidak bisa memilih tema dekor. Tolong diperbaiki lagi deko', '2023-06-01 11:11:52', 1),
(5, 'Coco', 'cocome@gmail.com', 'Sesuai harganya', '2023-06-01 20:23:29', 1),
(6, 'Bob', 'bob78@gmail.com', 'Tidak mengecewakan sih', '2023-06-04 11:32:37', 1),
(7, 'siapa', 'aku@gmail.com', 'ok', '2023-06-04 15:08:19', 1),
(8, 'Fred', 'fred34@gmail.com', 'Suka bgt sama gedung pernikahannya, rasanya ingin menikah lagi', '2023-06-04 15:51:18', 1),
(9, 'Orang Biasa', 'bukanemail@gmail.com', 'Baguss bangetttt', '2023-06-04 15:54:14', 1),
(10, 'Orang Normal', 'normalemail@gmail.com', 'Makanannya enak enak', '2023-06-04 15:55:50', 1),
(11, 'Lala', 'lala@gmail.com', 'iii kiyowok', '2023-06-05 10:56:43', 1),
(12, 'Nomi', 'nomnom@gmail.com', 'lebih di tingkatkan lagi :)', '2023-06-08 21:16:27', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `nama_paket`, `harga`, `waktu`) VALUES
(1, 'Pernikahan Gerejawi', 2000000, 1),
(2, 'Pertemuan', 300000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyewaan`
--

CREATE TABLE `penyewaan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` int(11) NOT NULL,
  `sudah_bayar` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penyewaan`
--

INSERT INTO `penyewaan` (`id`, `nama`, `tanggal`, `jam_mulai`, `jam_selesai`, `ruangan`, `sudah_bayar`) VALUES
(10, 'Olaf', '2023-08-15', '08:00:00', '17:00:00', 1, 1),
(18, 'Moana', '2023-09-16', '08:00:00', '15:00:00', 1, 1),
(20, 'Lala', '2023-12-24', '09:00:00', '18:00:00', 1, 1),
(21, 'Rani', '2024-06-10', '07:00:00', '20:00:00', 2, 0),
(22, 'Risma', '2024-06-15', '10:00:00', '20:00:00', 1, 0),
(23, 'Sukme', '2025-07-17', '09:30:00', '20:00:00', 1, 1),
(24, 'Nisa', '2032-12-01', '10:30:00', '21:00:00', 1, 0),
(25, 'Dante', '2026-06-26', '10:00:00', '12:00:00', 1, 0),
(26, 'Maria', '2025-01-30', '09:00:00', '12:00:00', 2, 0),
(27, 'Oh Sehun', '2027-02-09', '09:00:00', '11:30:00', 2, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `email`, `password`) VALUES
(1, 'Admin Gereja', 'admingereja', 'admin@gereja.com', '7488e331b8b64e5794da3fa4eb10ad5d');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `penyewaan`
--
ALTER TABLE `penyewaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
