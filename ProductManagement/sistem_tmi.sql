-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 10:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_tmi`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id_checkout` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_operasional` int(11) DEFAULT NULL,
  `status_pengiriman` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id_checkout`, `id_pelanggan`, `id_operasional`, `status_pengiriman`) VALUES
(24, 2, 2, 'On Delivery'),
(25, 1, 1, 'Selesai'),
(26, 1, NULL, 'None'),
(27, 1, 2, 'On Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_detail`
--

CREATE TABLE `checkout_detail` (
  `id_orderdetail` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkout_detail`
--

INSERT INTO `checkout_detail` (`id_orderdetail`, `id_order`, `id_produk`, `jumlah_beli`, `harga`) VALUES
(13, 24, 1, 4, 10000),
(14, 24, 3, 3, 12000),
(15, 24, 5, 6, 2),
(16, 25, 1, 4, 10000),
(17, 25, 3, 3, 12000),
(18, 25, 5, 6, 2),
(19, 25, 7, 10, 1233),
(20, 26, 6, 10, 233),
(21, 27, 2, 3, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `id_receiver` int(11) NOT NULL,
  `receiver_type` text NOT NULL,
  `message` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id_message`, `id_receiver`, `receiver_type`, `message`, `timestamp`) VALUES
(3, 3, 'customer', 'asdasad', '2024-06-17 18:35:05'),
(4, 3, 'customer', 'pesanan punya anda bisa diambil pada tanggal 7, kak', '2024-06-17 18:38:31'),
(5, 3, 'customer', 'apa yang bisa dibantu?', '2024-06-18 04:14:59'),
(6, 3, 'customer', 'test berhasil', '2024-06-18 07:07:08'),
(7, 1, 'staff', 'halo', '2024-06-18 07:20:36'),
(8, 2, 'customer', 'halo, mas gary', '2024-06-18 08:14:44'),
(11, 21, 'supplier', 'halo supplier A', '2024-06-18 08:21:22'),
(12, 21, 'supplier', 'saya butuh produk a', '2024-06-18 08:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nama` text NOT NULL,
  `no_telepon` varchar(12) NOT NULL,
  `status_prioritas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `alamat`, `nama`, `no_telepon`, `status_prioritas`) VALUES
(1, 'gary1', '123', 'test 1', 'Gary', '012312334333', 'prioritas'),
(2, 'gary2', '456', 'sdffdsdfsd', 'gary william', '017371927917', 'non-prioritas'),
(3, '', '', 'vjkvhhvhv', 'kygkjgkj', '76878768', 'non-prioritas');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kategori` text NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jumlah`, `kategori`, `harga`) VALUES
(1, 'a', 5, 'storage', 10000),
(2, 'b', 10, 'display', 20000),
(3, 'c', 3, 'display', 12000),
(4, 'd', 0, 'storage', 1000),
(5, 'sgdf', 12, 'display', 2),
(6, 'sasa', 12, 'cvxvccv', 233),
(7, 'jack', 12, 'gdfg', 1233);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telepon` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `no_telepon`) VALUES
(21, 'Supplier A', '123 Main St, Cityville', '1234567890'),
(22, 'Supplier B', '456 Oak St, Townsville', '2345678901'),
(23, 'Supplier C', '789 Pine St, Villageville', '3456789012'),
(24, 'Supplier D', '101 Maple St, Countryside', '4567890123'),
(25, 'Supplier E', '202 Birch St, Hamlet', '5678901234'),
(26, 'Supplier F', '303 Cedar St, Suburbia', '6789012345'),
(27, 'Supplier G', '404 Fir St, Metropolis', '7890123456'),
(28, 'Supplier H', '505 Redwood St, Downtown', '8901234567'),
(29, 'Supplier I', '606 Willow St, Uptown', '9012345678'),
(30, 'Supplier J', '707 Elm St, Outer City', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `tim_operasional`
--

CREATE TABLE `tim_operasional` (
  `id_operasional` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` text NOT NULL,
  `no_telepon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tim_operasional`
--

INSERT INTO `tim_operasional` (`id_operasional`, `username`, `password`, `nama`, `no_telepon`) VALUES
(1, 'jery1', '123', 'bartholomew', 234234234),
(2, 'jery2', '456', 'jasuke', 729973971);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id_checkout`),
  ADD KEY `fk_id_pelanggan` (`id_pelanggan`),
  ADD KEY `fk_id_operasional` (`id_operasional`);

--
-- Indexes for table `checkout_detail`
--
ALTER TABLE `checkout_detail`
  ADD PRIMARY KEY (`id_orderdetail`),
  ADD KEY `fk_id_order` (`id_order`),
  ADD KEY `fk_id_produk` (`id_produk`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `fk_id_receiver` (`id_receiver`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tim_operasional`
--
ALTER TABLE `tim_operasional`
  ADD PRIMARY KEY (`id_operasional`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id_checkout` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `checkout_detail`
--
ALTER TABLE `checkout_detail`
  MODIFY `id_orderdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tim_operasional`
--
ALTER TABLE `tim_operasional`
  MODIFY `id_operasional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `fk_id_operasional` FOREIGN KEY (`id_operasional`) REFERENCES `tim_operasional` (`id_operasional`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkout_detail`
--
ALTER TABLE `checkout_detail`
  ADD CONSTRAINT `fk_id_order` FOREIGN KEY (`id_order`) REFERENCES `checkout` (`id_checkout`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
