-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 09:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grow-mart`
--

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `aadhar_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `phone_number` varchar(225) DEFAULT NULL,
  `shop_image` varchar(500) DEFAULT NULL,
  `shop_status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_name`, `owner_name`, `owner_email`, `address`, `city`, `pincode`, `aadhar_number`, `pan_number`, `phone_number`, `shop_image`, `shop_status`, `created_at`, `updated_at`) VALUES
(4, 'Bilinkit', 'Test Bilinkit', 'bilinkit@gmail.com', 'Lucknow', 'Lucknow', 202013, '112233445566', 'CVD5242N', '1122334455', 'assets/shopIamges/1743272293_Blinkit-Franchises.jpg', 1, '2025-03-29 18:18:13', '2025-03-29 18:18:13'),
(5, 'Zomato', 'Test Zomato', 'zomato@gmail.com', 'Kanpur', 'Kanpur', 202014, '111122223333', 'CVD5242K', '1155223366', 'assets/shopIamges/1743272398_images (3).jpg', 1, '2025-03-29 18:19:58', '2025-03-29 18:19:58'),
(7, 'Zepto', 'Test Zepto', 'zepto@gmail.com', 'Lucknow', 'Lucknow', 226012, '774488559966', 'CVD5242A', '7744885599', 'assets/shopIamges/1743272942_images (1).png', 1, '2025-03-29 18:29:02', '2025-03-29 18:29:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shops_owner_email_unique` (`owner_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
