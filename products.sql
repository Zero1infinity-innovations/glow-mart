-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 09:41 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `mrp_price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_gallery`)),
  `category` int(11) DEFAULT NULL,
  `subCategory` int(11) DEFAULT NULL,
  `product_status` int(11) DEFAULT NULL COMMENT '1=active, 0=inactive',
  `payment_method` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `sale_price`, `mrp_price`, `quantity`, `product_image`, `product_gallery`, `category`, `subCategory`, `product_status`, `payment_method`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Test Product', 150, 160, 150, 'assets/products/1743097653_heating.png', '[\"assets\\/products\\/gallery\\/1743097653_specials.png\",\"assets\\/products\\/gallery\\/1743097653_plumber-arlington-tx.png\",\"assets\\/products\\/gallery\\/1743097653_heating.png\"]', 4, NULL, 1, 'prepaid_only', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2025-03-27 17:47:33', '2025-03-27 18:46:17'),
(2, 'Rice', 450, 460, 20, 'assets/products/1743100683_1666259831-news.jpeg', '[\"assets\\/products\\/gallery\\/1743100683_images (2).jpg\",\"assets\\/products\\/gallery\\/1743100683_images (1).jpg\"]', 4, NULL, 1, 'cod_only', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-03-27 18:38:03', '2025-03-27 18:38:03'),
(3, 'Rice 2', 450, 500, 100, 'assets/products/1743101280_images (2).jpg', '[\"assets\\/products\\/gallery\\/1743101280_images (2).jpg\",\"assets\\/products\\/gallery\\/1743101280_images (1).jpg\",\"assets\\/products\\/gallery\\/1743101280_1666259831-news.jpeg\"]', 4, NULL, 1, 'cod_only', NULL, '2025-03-27 18:48:00', '2025-03-27 18:48:00'),
(4, 'Test new Product', 650, 750, 150, 'assets/products/1743359951_1666259831-news.jpeg', '[\"assets\\/products\\/gallery\\/1743359951_images (2).jpg\",\"assets\\/products\\/gallery\\/1743359951_images (1).jpg\",\"assets\\/products\\/gallery\\/1743359951_1666259831-news.jpeg\"]', 4, NULL, 1, 'cod_only', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-03-30 18:39:11', '2025-03-30 19:31:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
