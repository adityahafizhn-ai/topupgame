-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2025 pada 16.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `celleboytopup`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `promo`
--

INSERT INTO `promo` (`id`, `judul`, `deskripsi`, `status`, `tanggal_mulai`, `tanggal_selesai`, `gambar`) VALUES
(2, 'Promo Mobile Legends!', 'Diskon spesial top up diamond Mobile Legends.', 'aktif', '2025-12-29', '2026-01-05', 'promo-ml.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game` varchar(100) NOT NULL,
  `id_game` varchar(100) NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `game`, `id_game`, `jumlah`, `harga`, `metode`, `status`, `tanggal`, `bukti_pembayaran`) VALUES
(2, 1, 'Mobile Legends', '1111-1111', '86 Diamond (1)', 20000, 'Dana', 'Sukses', '2025-12-15 16:01:31', NULL),
(3, 1, 'Mobile Legends', '1111-1111', '86 Diamond (1)', 20000, 'DANA', 'Sukses', '2025-12-15 16:05:34', NULL),
(4, 1, 'Mobile Legends', '1111-1111', '86 Diamond (1)', 20000, 'QRIS', 'Sukses', '2025-12-15 16:26:22', NULL),
(5, 1, 'Mobile Legends', '1111-1111', '257 Diamond (1)', 60000, 'QRIS', 'Sukses', '2025-12-15 17:08:55', NULL),
(6, 1, 'Mobile Legends', '1111-2628', '170 Diamond (1)', 40000, 'QRIS', 'Sukses', '2025-12-15 17:49:27', NULL),
(7, 1, 'Mobile Legends', '1111-2628', '86 Diamond (1)', 20000, 'QRIS', 'Sukses', '2025-12-15 17:53:34', NULL),
(8, 1, 'Mobile Legends', '1111-2628', '514 Diamond (1)', 115000, 'QRIS', 'Sukses', '2025-12-15 17:56:37', NULL),
(9, 1, 'Mobile Legends', '1111-2628', '170 Diamond (1)', 40000, 'QRIS', 'Sukses', '2025-12-15 18:18:32', NULL),
(10, 1, 'Mobile Legends', '1111-2628', '257 Diamond (1)', 60000, 'QRIS', 'Sukses', '2025-12-15 18:20:39', NULL),
(11, 1, 'Mobile Legends', '1111-1111', '170 Diamond (1)', 40000, 'QRIS', 'Sukses', '2025-12-15 18:24:39', NULL),
(12, 1, 'Mobile Legends', '1111-1111', '86 Diamond (1)', 20000, 'QRIS', 'Sukses', '2025-12-15 18:45:37', NULL),
(13, 1, 'Free Fire', '1111-1111', '170 Diamond (1)', 40000, 'QRIS', 'Sukses', '2025-12-15 18:47:12', NULL),
(14, 1, 'Roblox', '-', '50.000 x1', 50000, 'QRIS', 'Sukses', '2025-12-15 19:56:07', NULL),
(15, 1, 'Mobile Legends', '32132-1111', '750 Diamond', 200000, 'QRIS', 'Sukses', '2025-12-15 20:20:40', NULL),
(16, 1, 'Mobile Legends', '1111-1111', '568 Diamond', 150000, 'QRIS', 'Sukses', '2025-12-15 20:22:55', NULL),
(17, 1, 'Mobile Legends', 'test | 1111-1111', '1506 Diamond', 400000, 'QRIS', 'Sukses', '2025-12-15 20:26:28', NULL),
(18, 1, 'Mobile Legends', 'test | 1111-1111', '568 Diamond', 150000, 'QRIS', 'Sukses', '2025-12-15 20:28:02', NULL),
(19, 1, 'Mobile Legends', '1111', '568 Diamond', 150000, 'QRIS', 'Sukses', '2025-12-15 20:32:17', NULL),
(20, 3, 'Mobile Legends', 'test | 1111-1111', '80 Diamond', 20000, 'QRIS', 'Sukses', '2025-12-16 02:39:18', NULL),
(21, 4, 'Mobile Legends', 'test | 1111-1111', '750 Diamond', 200000, 'QRIS', 'Sukses', '2025-12-16 02:42:24', NULL),
(22, 6, 'PUBG Mobile', 'jaya | 123-11111', '1800 UC', 400000, 'QRIS', 'Sukses', '2025-12-16 09:16:02', NULL),
(23, 6, 'Mobile Legends', 'dani | 1234-1553', '1358 Diamond', 350000, 'QRIS', 'Sukses', '2025-12-16 09:17:30', NULL),
(24, 7, 'Mobile Legends', 'jaya | 1111-1111', '568 Diamond', 150000, 'QRIS', 'Sukses', '2025-12-16 09:52:02', NULL),
(25, 7, 'Roblox', 'jaya | ---', 'Gift Card', 100000, 'QRIS', 'Menunggu Pembayaran', '2025-12-16 09:54:23', NULL),
(26, 7, 'Mobile Legends', 'jaya | 1111-1111', '80 Diamond', 20000, 'QRIS', 'Sukses', '2025-12-16 09:55:22', NULL),
(27, 8, 'Mobile Legends', 'aditya | 12345-678910', '966 Diamond', 250000, 'QRIS', 'Sukses', '2025-12-16 10:15:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'adit', 'adit@gmail.com', '$2y$10$hpWaAPTiMFdLBGmtEHR0NeshCFeFktnA4oiRp..xfRwx4tV12/Xja', '2025-12-15 14:47:38', 'user'),
(2, 'admin', 'admin@gmail.com', '$2y$10$3y1WR2Z2ZljnMi7CfJBOQ.Y3Zmb35NOFEZpVPScP3It0pnUrKj0Dq', '2025-12-15 15:00:03', 'admin'),
(3, 'test', 'test@gmail.com', '$2y$10$f6xAGbt6HuDJd3/SSBvHauIR09vOHHbLsEywqQAxFGH42k1NQj3Nu', '2025-12-15 19:38:53', 'user'),
(4, 'Aditya', 'Adityahafizhn@gmail.com', '$2y$10$O/PR8nvYi40ugYBN1rxQR.tsdHpmqz/yhl.IyGMVlrT5YIQz0Sope', '2025-12-15 19:42:00', 'user'),
(5, 'jaya', 'nfwjfjw@gmail.com', '$2y$10$vOBfXZsaWPcVi3NJNsARnekE5y49DrYBd5cGbH1cSHRzvDD/7zm1i', '2025-12-16 02:15:05', 'user'),
(6, '123', 'jaya@gmail.com', '$2y$10$O0qzv0/2sN3twSFb4Ha3uO5p.wD56KP8LBDKZS5wY/.26BAYm/7nu', '2025-12-16 02:15:28', 'user'),
(7, 'Martuah', 'martuah@gmail.com', '$2y$10$aVP9DG9vFXBBwFwx4l8yzuzEFsYzI/oYJXorm8qxHADlSeh5dvdza', '2025-12-16 02:50:51', 'user'),
(8, 'Adityahafizh', 'adityahafizh@gmail.com', '$2y$10$z1pZHBRhGHnfMG4EK9kNdOC61yblbL8RpzC36IGoNC7sqqlWNUhIi', '2025-12-16 03:14:36', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
