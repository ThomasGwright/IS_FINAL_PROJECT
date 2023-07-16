-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 16, 2023 at 02:10 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE `customer_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`id`, `name`, `email`, `phone`, `address`, `password`) VALUES
(1, 'Thomas George Wright', 'twright00@icloud.com', '9712842294', '12643 s iron mountain blvd', 'thomas'),
(2, 'sarah', 'sarah@sarah', '67890987', '6789087ghikhujl', 'sarah'),
(4, 'Kevin Wright', 'kevin@kevin', '098765434567', 'Kevin address', '$2y$10$FM44AUkPNf8kaJLknUcpJuFnJFSBsJwIA4AMb98JIXEdhcTMZRME6'),
(5, 'annabel', 'annabel@annabel', '98567890', 'annabel road', '$2y$10$DZDUR/Y8lT0YX1gpfJfSdesjA4KIs1pypYSI7ho1aeConW.l8.Yk.'),
(6, 'annabel', 'annabel@annabel', '98567890', 'annabel road', '$2y$10$S2aKq6G1VMOtcJrsKb.B4ufoNA45PVrmmTG2aTM4M6dV5krchqQXi'),
(7, 'simon', 'simon@simon', '9712842294', '12643 s iron mountain blvd', '$2y$10$GdhcppqGuzBNglOJ.P/hdepNn0nZyGxf1fk7H9V3yYFTa5cJIVs52'),
(8, 'http', 'http@http', '1234567890', 'erdtfcvgbh1234', '$2y$10$QjFKFMkSR5yZ7trj7mWrI.2lKL1J9Uizke8HlwbtZb1AUau4DrO9y'),
(9, 'Kevin Wright', 'k@k', '9712842294', '12643 South Iron Mountain Boulevard', '$2y$10$zp.vqGsdBxlSsmLaEw0SLunupO/4HfpCtHc9Jhbvns.hpLx8qp/3K'),
(10, 'noodle', 'noodle@noodle', '123456789', 'gvhiojkl,n', '$2y$10$Bo0Xs8dI6M/QqmhjXaX91eNG5kQnoC8TnO1bxzAIKex8rL18xZPRG'),
(11, 'noodle', 'noodle@noodle', '123456789', 'gvhiojkl,n', '$2y$10$4iceruR4swYSHOrhnvS3R.YUWTe5AdFBTRUhBk4xkcqKy0IDwnQDG'),
(12, 'nate', 'nate@nate', '1234567890', 'gyvbhjknlm', '$2y$10$M7rbk2hTDoEKWcq6h7R2de9e1QNiC1HFzn9CXIF2odoKVTI7Z.bva'),
(13, 'nate', 'nate@nate', '1234567890', 'gyvbhjknlm', '$2y$10$s/eX.hRKQXz0Kp4kWvOVG.Tk5XzJqFB/96ERYHfnmoLFfVz.NiM46'),
(14, 'nate', 'nate@nate', '1234567890', 'gyvbhjknlm', '$2y$10$ke5BZFRS8T9RBQ930mlNV.MGd6zxxHzjQUzr9FiISLo7R3uKBAxfe'),
(15, 'nate', 'nate@nate', '34567890-', 'gvhjklk', '$2y$10$iXFbgziwPC46kHYtHHT5tO4.wDXsgGcABjHn7hCIqpC5wSULo3jji'),
(16, 'Thomas George Wright', 'twright00@icloud.com', '9712842294', '12643 s iron mountain blvd', '$2y$10$DHRWccV.ZAw0Imd4djJLSe5Y/7SvywbyNdAyh11uYF86KU.rP69Va'),
(17, 'david kale', 'david@david', '234567890', 'turyiuogiho;jl', '$2y$10$oyvwKfCuih/P3YdLEQ10DuL0bTmmILVWJuZMdMaACJB2ryPdX7qze'),
(18, 'Thomas Wright', 'thomas@thomas', '9712842294', '12643 s iron mountain blvd', '$2y$10$mkHAd2GBOGksa98yW55RgOJBp4aNKQAxmo2JhbqN./ifFQ/jnWil.'),
(19, 'ricki', 'ricki@ricki', '1234567890', 'tokyo', '$2y$10$7veVD4qNSdqNeCG2ZjQXmewWloXwGgzRcx7Pc4vkcDSOXE4hFfTuO'),
(20, 'nate', 'nate@nate', '1234567890', 'salt lake city', '$2y$10$Wxdg4dnwRDXTFSHxslJUNOGyxhMixVeu0a0S7R.tnrAPBTG4beFwS');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`id`, `name`, `email`, `password`) VALUES
(1, 'error', 'error@error', 'error'),
(2, 'admin', 'admin@admin', 'admin'),
(3, 'thomas', 'thomas@thomas', 'thomas'),
(4, 'carter', 'carter@carter', 'carter'),
(5, 'nate', 'nate@nate', 'nate'),
(6, 'Patrick Russell', 'patrick@patrick', 'patrick'),
(7, 'david kale', 'david@david', 'david'),
(8, 'Sarah Wright', 'sarah@sarah', '$2y$10$CsAGfTRN.kf6mJ.HpZ/h4uuPgw2PTHUbGuQ.i7NKYPit2UUI7IWtW');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `employee_id`) VALUES
(8, 'elan skis', 'these are elan skis', '32.00', 'uploads/elan.jpg', 1),
(9, 'scott skis', 'these are scott skis', '25.00', 'uploads/scott.jpg', 1),
(10, 'cool skis', 'these skis are really cool', '24.00', 'uploads/sample_skis.jpg', 6),
(11, 'old skis', 'these skis are really old', '33.00', 'uploads/old_skis.jpg', 6),
(12, 'Bent chetlers', 'these are atomic bent chetlers', '22.00', 'uploads/bent.chetler.jpg', 5),
(13, 'mfree skis', 'these are dynastar mfree skis', '55.00', 'uploads/mfree.jpg', 5),
(14, 'park skis', 'these skis are for park', '22.00', 'uploads/volkl-all-mountain-ski-2020.png', 8);

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `delete_product_record` AFTER DELETE ON `products` FOR EACH ROW BEGIN
  DELETE FROM product_records WHERE product_id = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_product_record` AFTER INSERT ON `products` FOR EACH ROW BEGIN
  INSERT INTO product_records (product_id, product_name, employee_id, employee_name)
  VALUES (NEW.id, NEW.name, NEW.employee_id, (SELECT name FROM employee_info WHERE id = NEW.employee_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_records`
--

CREATE TABLE `product_records` (
  `product_record_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_records`
--

INSERT INTO `product_records` (`product_record_id`, `product_id`, `product_name`, `employee_id`, `employee_name`) VALUES
(2, 8, 'elan skis', 1, 'error'),
(3, 9, 'scott skis', 1, 'error'),
(4, 10, 'cool skis', 6, 'Patrick Russell'),
(5, 11, 'old skis', 6, 'Patrick Russell'),
(6, 12, 'Bent chetlers', 5, 'nate'),
(7, 13, 'mfree skis', 5, 'nate'),
(8, 14, 'park skis', 8, 'Sarah Wright');

-- --------------------------------------------------------

--
-- Table structure for table `sales_report`
--

CREATE TABLE `sales_report` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `cart_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_report`
--

INSERT INTO `sales_report` (`order_id`, `customer_id`, `customer_name`, `cart_total`) VALUES
(3, 4, NULL, '276.00'),
(4, 4, 'Kevin Wright', '276.00'),
(5, 4, 'Kevin Wright', '276.00'),
(6, 4, '', '276.00'),
(7, 4, '', '276.00'),
(8, 4, 'Kevin Wright', '276.00'),
(9, 4, 'Kevin Wright', '276.00'),
(10, 4, 'Kevin Wright', '276.00'),
(11, 4, 'Kevin Wright', '276.00'),
(12, 19, 'ricki', '746.00'),
(13, 19, 'ricki', '746.00'),
(14, 19, 'ricki', '746.00'),
(15, 19, 'ricki', '746.00'),
(16, 20, 'nate', '159.00'),
(17, 20, 'nate', '159.00'),
(18, 4, 'Kevin Wright', '121.00'),
(19, 4, 'Kevin Wright', '121.00'),
(20, 4, 'Kevin Wright', '121.00'),
(21, 4, 'Kevin Wright', '121.00'),
(22, 4, 'Kevin Wright', '0.00'),
(23, 4, 'Kevin Wright', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_records`
--
ALTER TABLE `product_records`
  ADD PRIMARY KEY (`product_record_id`);

--
-- Indexes for table `sales_report`
--
ALTER TABLE `sales_report`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_records`
--
ALTER TABLE `product_records`
  MODIFY `product_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales_report`
--
ALTER TABLE `sales_report`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
