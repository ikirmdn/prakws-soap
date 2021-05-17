-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Bulan Mei 2021 pada 16.49
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbbookstore`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `author_name` varchar(500) NOT NULL,
  `price` varchar(500) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author_name`, `price`, `isbn`, `category`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', 'Rp 89.000', '979-3062-79-7', 'Novel (Roman)'),
(2, 'Perahu Kertas', 'Dewi Lestari', 'Rp 50.000', '978-979-1227-78-0', 'Fiksi'),
(3, 'Buku Latihan Soal Mantappu Jiwa ', 'Jerome Polin Sijabat', 'Rp 86.900', '978-602-06-3241-4', 'Matematika'),
(4, 'Belajar Sendiri Mengolah Data Dengan Python dan Pandas', 'Jubilee Enterprise', 'Rp 65.000', '978-623-0026-21-8', 'Komputer dan Teknologi'),
(5, 'Sinyal dan Sistem Dengan Matlab', 'Dr. Eng RH. Sianipar., S.T., M.Eng.', 'Rp 195.000', '978-979-29-6793-7', 'Sains dan Matematika');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
