-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2023 at 01:36 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mebel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(20) NOT NULL,
  `id_produk` int(15) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `harga` int(20) NOT NULL,
  `ket` varchar(35) NOT NULL,
  `foto` varchar(225) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `id_produk`, `nama`, `harga`, `ket`, `foto`, `jumlah`) VALUES
(140, 8, 29, 'Chamilo', 450000, '', '64d77f51f1c6d.png', 2),
(141, 2, 28, 'Cocoo', 520000, '', '64d77f01c0f11.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `harga` int(20) NOT NULL,
  `stok` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `kategori` varchar(35) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nama`, `harga`, `stok`, `keterangan`, `kategori`, `foto`) VALUES
(1, 'Sawda', 400000, 6, 'This is a longer card with supporting text below as a natural.', 'Lemari', '64e6211fdde48.png'),
(2, 'Salma', 460000, 4, 'This is a longer card with supporting text below as a natural.', 'Lemari', '64d7760c74326.png'),
(26, 'Baariz', 450000, 5, 'This is a longer card with supporting text below as a natural.', 'Lemari', '64e6216119db1.png'),
(27, 'Daya Solid Stool', 470000, 5, 'This is a longer card with supporting text below as a natural.', 'Kursi', '64d77ed01b9bb.png'),
(28, 'Cocoo', 520000, 3, 'This is a longer card with supporting text below as a natural.', 'Kursi', '64d77f01c0f11.png'),
(29, 'Chamilo', 450000, 5, 'This is a longer card with supporting text below as a natural.', 'Kursi', '64d77f51f1c6d.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_item`
--

CREATE TABLE `transaksi_item` (
  `no_trans` varchar(100) NOT NULL,
  `id_user` int(50) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(100) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `ket` varchar(200) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `tgl_transaksi` varchar(50) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `pembayaran` varchar(50) NOT NULL,
  `proses_status` varchar(50) NOT NULL,
  `bukti_bayar` varchar(100) NOT NULL,
  `ket_reject` varchar(100) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `ekspedisi` varchar(50) NOT NULL,
  `tgl_selesai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_item`
--

INSERT INTO `transaksi_item` (`no_trans`, `id_user`, `id_produk`, `nama`, `harga`, `jumlah`, `ket`, `foto`, `tgl_transaksi`, `nama_penerima`, `no_hp`, `alamat`, `pembayaran`, `proses_status`, `bukti_bayar`, `ket_reject`, `no_resi`, `ekspedisi`, `tgl_selesai`) VALUES
('TR230001', 2, 2, 'Salma', 460000, 2, 'ukuran 2 m', '64d7760c74326.png', '2023-08-17 07:52:33', 'irfan faiz', '083865050949', 'Sanggrahan, RT.15/04, Pelem, Simo, Boyolali, Jawa Tengah', 'dana', 'done', 'TR230001.jpeg', '', 'JT097474984', 'J&T', '2023-08-20 07:52:33'),
('TR230001', 2, 28, 'Cocoo', 520000, 2, 'ukuran 1 m', '64d77f01c0f11.png', '2023-08-17 07:52:33', 'irfan faiz', '083865050949', 'Sanggrahan, RT.15/04, Pelem, Simo, Boyolali, Jawa Tengah', 'dana', 'done', 'TR230001.jpeg', '', 'JT097474984', 'J&T', '2023-08-20 07:52:33'),
('TR230002', 2, 27, 'Daya Solid Stool', 470000, 1, '', '64d77ed01b9bb.png', '2023-08-17 08:55:19', 'irfan faiz', '083865050949', 'karangpandan, rt.05 karanganyar jawa tengah indonesia', 'dana', 'done', 'TR230002.png', 'rekening tujuan anda salah, silahkan cek kembali', 'jn54646458', 'jne', '2023-08-20 07:52:33'),
('TR230003', 2, 28, 'Cocoo', 520000, 1, '1m yak', '64d77f01c0f11.png', '2023-08-18 05:46:51', 'david nur', '087632462378', 'Karanganyar, Jawa Tengah, Indonesia', 'bca', 'done', 'TR230003.jpeg', '', 'JT0974749846', 'J&T', '2023-08-20 07:52:33'),
('TR230003', 2, 2, 'Salma', 460000, 2, '2m yak', '64d7760c74326.png', '2023-08-18 05:46:51', 'david nur', '087632462378', 'Karanganyar, Jawa Tengah, Indonesia', 'bca', 'done', 'TR230003.jpeg', '', 'JT0974749846', 'J&T', '2023-08-20 07:52:33'),
('TR230004', 2, 29, 'Chamilo', 450000, 2, 'jangan ketinggian', '64d77f51f1c6d.png', '2023-08-18 05:53:22', 'Surya adi', '08534632788', 'Makamhaji, manang, sukoharjo, solo, jawa tengah', 'bca', 'on delivery', 'TR230004_2023-08-18 06:28:53.png', 'rekening salah', '0039425872', 'AnterAja', ''),
('TR230005', 3, 28, 'Cocoo', 520000, 2, '2m yak', '64d77f01c0f11.png', '2023-08-18 13:23:53', 'Nicho dewa', '087634738979', 'Mojolaban, Karanganyar, jawa tengah', 'ovo', 'on delivery', 'TR230005_2023-08-18 13.26.27.png', '', '002321434', 'Si Cepat', ''),
('TR230005', 3, 1, 'Zaabar', 400000, 3, '3m yak', '64d4911b6354c.png', '2023-08-18 13:23:53', 'Nicho dewa', '087634738979', 'Mojolaban, Karanganyar, jawa tengah', 'ovo', 'on delivery', 'TR230005_2023-08-18 13.26.27.png', '', '002321434', 'Si Cepat', ''),
('TR230006', 2, 28, 'Cocoo', 520000, 2, 'ukuran2', '64d77f01c0f11.png', '2023-08-20 21:02:44', 'irfan faiz', '083865050949', 'simo', 'bca', 'on process', 'TR230006_2023-08-20 21.03.10.png', '', '', '', ''),
('TR230007', 2, 28, 'Cocoo', 520000, 2, 'ukuran 2', '64d77f01c0f11.png', '2023-08-21 10:27:19', 'dapid', '083865050949', 'karanganyar', 'bca', 'on process', 'TR230007_2023-08-21 10.27.44.png', '', '', '', ''),
('TR230008', 2, 28, 'Cocoo', 520000, 2, 'Kaki 2m', '64d77f01c0f11.png', '2023-08-22 08:06:34', 'Selvi', '083865050949', 'Titang, Simo, Boyolali', 'ovo', 'on process', 'TR230008_2023-08-29 09.23.37.png', '', '', '', ''),
('TR230008', 2, 2, 'Salma', 460000, 1, 'Warna merah', '64d7760c74326.png', '2023-08-22 08:06:34', 'Selvi', '083865050949', 'Titang, Simo, Boyolali', 'ovo', 'on process', 'TR230008_2023-08-29 09.23.37.png', '', '', '', ''),
('TR230010', 7, 1, 'Sawda', 400000, 2, '', '64e6211fdde48.png', '2023-08-30 08:16:39', 'irfan faiz', '083865050949', 'simo, boyolali, jawa tengah, indonesia', 'ovo', 'payment confirmation', 'TR230010_2023-08-30 08.17.06.png', '', '', '', ''),
('TR230010', 7, 28, 'Cocoo', 520000, 2, '', '64d77f01c0f11.png', '2023-08-30 08:16:39', 'irfan faiz', '083865050949', 'simo, boyolali, jawa tengah, indonesia', 'ovo', 'payment confirmation', 'TR230010_2023-08-30 08.17.06.png', '', '', '', ''),
('TR230011', 7, 29, 'Chamilo', 450000, 1, '', '64d77f51f1c6d.png', '2023-08-30 11:32:49', 'Akbar Pranowo', '083865050949', 'Jepara,  jawa tengah, indonesia', 'dana', 'payment confirmation', 'TR230011_2023-08-30 11.33.56.png', '', '', '', ''),
('TR230011', 7, 26, 'Baariz', 450000, 3, '', '64e6216119db1.png', '2023-08-30 11:32:49', 'Akbar Pranowo', '083865050949', 'Jepara,  jawa tengah, indonesia', 'dana', 'payment confirmation', 'TR230011_2023-08-30 11.33.56.png', '', '', '', ''),
('TR230012', 3, 27, 'Daya Solid Stool', 470000, 1, '', '64d77ed01b9bb.png', '2023-08-30 11:33:19', 'ahmad', '087356345734', 'Titang, simo, boyolali, jawa tengah, indonesia', 'bca', 'payment confirmation', 'TR230012_2023-08-30 11.34.20.png', '', '', '', ''),
('TR230012', 3, 2, 'Salma', 460000, 2, '', '64d7760c74326.png', '2023-08-30 11:33:19', 'ahmad', '087356345734', 'Titang, simo, boyolali, jawa tengah, indonesia', 'bca', 'payment confirmation', 'TR230012_2023-08-30 11.34.20.png', '', '', '', ''),
('TR230013', 8, 27, 'Daya Solid Stool', 470000, 2, '', '64d77ed01b9bb.png', '2023-09-06 14:05:22', 'Surya Adi', '08764376828', 'Pajang, Makamhaji, Sukoharjo, Jawa Tengah', 'gopay', 'payment confirmation', 'TR230013_2023-09-06 14.06.00.jpeg', '', '', '', ''),
('TR230013', 8, 28, 'Cocoo', 520000, 2, '', '64d77f01c0f11.png', '2023-09-06 14:05:22', 'Surya Adi', '08764376828', 'Pajang, Makamhaji, Sukoharjo, Jawa Tengah', 'gopay', 'payment confirmation', 'TR230013_2023-09-06 14.06.00.jpeg', '', '', '', ''),
('TR230013', 8, 29, 'Chamilo', 450000, 1, '', '64d77f51f1c6d.png', '2023-09-06 14:05:22', 'Surya Adi', '08764376828', 'Pajang, Makamhaji, Sukoharjo, Jawa Tengah', 'gopay', 'payment confirmation', 'TR230013_2023-09-06 14.06.00.jpeg', '', '', '', ''),
('TR230014', 8, 1, 'Sawda', 400000, 2, '', '64e6211fdde48.png', '2023-09-06 14:15:23', 'Nicholas', '083865050949', 'Karangpandan, Karanganyar, Jawa Tengah', 'ovo', 'payment confirmation', 'TR230014_2023-09-06 14.15.35.png', '', '', '', ''),
('TR230014', 8, 26, 'Baariz', 450000, 3, '', '64e6216119db1.png', '2023-09-06 14:15:23', 'Nicholas', '083865050949', 'Karangpandan, Karanganyar, Jawa Tengah', 'ovo', 'payment confirmation', 'TR230014_2023-09-06 14.15.35.png', '', '', '', ''),
('TR230016', 8, 2, 'Salma', 460000, 2, '', '64d7760c74326.png', '2023-09-06 15:13:08', 'Tito arigato', '08658478290', 'Wonosobo, Jawa Tengah', 'dana', 'waiting for payment', '', '', '', '', ''),
('TR230016', 8, 27, 'Daya Solid Stool', 470000, 2, '', '64d77ed01b9bb.png', '2023-09-06 15:13:08', 'Tito arigato', '08658478290', 'Wonosobo, Jawa Tengah', 'dana', 'waiting for payment', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `level_user` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_user`, `username`, `password`, `no_hp`, `level_user`) VALUES
(2, 'irfan faiz', 'irfan13', '$2y$10$sNplF59/wm5WIovGoDAIouBR17BLO/ZP2n4z3L9Q0kgE7kE0ySdV.', '085526388358', ''),
(3, 'ahmad', 'ahmad1', '$2y$10$jvhDKoK3lLo6BWiYm6C1VeFjMisOOC.7zn1JTQ0FviyZF5PilQdsO', '2147483647', 'user'),
(4, 'Agustinus Surya Adi', 'surya1', '$2y$10$hcNwsD4Yl97WIXb2u/i3lOd3tdjYtE8xpgrsHKdMRweD09yOkUTaa', '2147483647', 'user'),
(5, 'David Nur', 'david1', '$2y$10$BqzhuMgjXr60JMvoQIO5Vetut1CABIKej8KT4oWbgB.TKH/wGb1Bq', '2147483647', ''),
(6, 'bagas adi', 'bagas', '$2y$10$1edZuC22NVvCO95vVRSDJugFSZ5Gp7IAXCQrKG2/f.bYNtE8nEBUq', '874475940', ''),
(7, 'Akbar', 'akbar', '$2y$10$pMd7BHNN88/QpMCtUoxRNOL9zXgO9Efi2k3.PuXCcqavE0n4mdELm', '08734638879', ''),
(8, 'Surya Adi', 'surya', '$2y$10$QxnIYNSkTwiFlWllTGvs2eCv9z52ufDB3zfxnRiwihMOxZURzJKE.', '08764376828', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level_user` varchar(25) NOT NULL,
  `ip` varchar(225) NOT NULL,
  `device` varchar(225) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `id_user`, `nama`, `level_user`, `ip`, `device`, `waktu`) VALUES
(0, 2, 'irfan faiz', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-08-29 09:06:03'),
(0, 7, 'Akbar', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-08-30 08:15:42'),
(0, 2, 'irfan faiz', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-08-30 11:29:08'),
(0, 3, 'ahmad', 'user', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.1 Safari/605.1.15', '2023-08-30 11:31:30'),
(0, 7, 'Akbar', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-08-30 11:31:33'),
(0, 2, 'irfan faiz', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-09-05 08:05:15'),
(0, 7, '', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-09-06 11:32:17'),
(0, 2, '', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-09-06 13:57:27'),
(0, 8, '', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-09-06 14:03:54'),
(0, 2, '', '', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36', '2023-09-08 10:38:16'),
(0, 2, '', '', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', '2023-10-19 20:26:55'),
(0, 2, '', '', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', '2023-10-19 20:27:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi_item`
--
ALTER TABLE `transaksi_item`
  ADD KEY `no_trans` (`no_trans`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
