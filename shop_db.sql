-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 08, 2023 at 11:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(10, 'Breakfast'),
(11, 'Lunch'),
(12, 'Dinner'),
(13, 'Snacks'),
(15, 'Dessert'),
(17, 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `dish_id`, `user_id`, `comment`, `created_at`, `updated_at`) VALUES
(7, 20, 10, 'Test 123', '2023-11-25 22:16:54', '2023-11-25 22:16:54'),
(17, 27, 10, 'Test 123', '2023-11-26 02:05:14', '2023-11-26 02:05:14'),
(18, 2, 8, 'Test1234', '2023-11-26 05:53:21', '2023-11-26 05:53:38'),
(22, 20, 12, 'testing comment', '2023-11-27 14:24:05', '2023-11-27 14:24:05'),
(23, 35, 8, 'test 123', '2023-11-27 14:40:10', '2023-11-27 14:40:10'),
(25, 24, 8, 'TESTING 123', '2023-11-29 05:54:52', '2023-12-05 22:18:43'),
(26, 35, 8, 'testing', '2023-11-29 06:12:42', '2023-11-29 06:12:42'),
(27, 20, 8, 'Hello', '2023-11-29 06:18:58', '2023-11-29 06:18:58'),
(31, 20, 15, 'Testing!!', '2023-12-06 00:44:40', '2023-12-06 00:44:54'),
(32, 24, 15, 'Testing!!', '2023-12-07 21:50:30', '2023-12-07 21:50:30'),
(33, 97, 15, 'Testing!!! 123', '2023-12-08 03:07:51', '2023-12-08 03:08:04'),
(34, 27, 15, 'Best Dish !!', '2023-12-08 03:58:02', '2023-12-08 03:58:02'),
(35, 85, 15, 'Testing!!', '2023-12-08 06:43:02', '2023-12-08 06:43:02'),
(36, 93, 15, 'TEst11', '2023-12-08 07:44:25', '2023-12-08 07:44:25'),
(37, 81, 15, 'Testing!!', '2023-12-08 22:36:41', '2023-12-08 22:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 8, 'James', 'james16@gmail.com', '204999', 'Helloo!!\r\nTest \r\nTest\r\nTest');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `placed_on` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 3, 'selena', '88997700', 'selenaAnsari@gmail.com', 'paytm', 'rz-405A street number 25 tkd new delhi-19', '3', '540', '13/12/2022', 'pending'),
(6, 6, 'mahi', '88997700', 'selenaAnsari@gmail.com', 'paytm', 'rz-405A street number 25 tkd new delhi-19', '3', '540', '13/12/2022', 'pending'),
(10, 8, 'James', '45364567', 'james', 'cradit card', 'flat no. 1255 troy avenye,unit-1,winnipeg,mb,Canada,fiuekjds,', '', '20', '24-Nov-2023', 'complete'),
(12, 8, '', '', '', '', 'flat no. ,,,,,', '', '10', '26-Nov-2023', 'pending'),
(13, 8, '', '', '', '', 'flat no. ,,,,,', '', '0', '26-Nov-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `product_detail` varchar(1000) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `product_detail`, `image`, `created_at`, `updated_at`, `category_id`) VALUES
(81, 'Samosa', '10', '<p><strong>Samosa</strong></p>', '1.jpg', '0000-00-00', '0000-00-00', 11),
(85, 'Channa Masala', '40', '<h1><strong><em><u>Channa Masala</u></em></strong></h1>', '0.jpg', '0000-00-00', '0000-00-00', 10),
(89, 'Pani Puri', '10', '<h1><strong><em><u>Pani Puri</u></em></strong></h1>', 'P.png', '0000-00-00', '0000-00-00', 13),
(90, 'Kheer', '30', '<p><strong><em><u>Kheer Sweet Dish</u></em></strong></p>', 'Kheer.png', '0000-00-00', '0000-00-00', 15),
(91, 'Fish Tikka', '50', '<h1><strong><em><u>Fish Tikka</u></em></strong></h1>', '2.jpg', '0000-00-00', '0000-00-00', 12),
(92, 'Butter Chicken', '20', '<h1><strong><em><u>Butter Chicken</u></em></strong></h1>', '', '0000-00-00', '0000-00-00', 12),
(93, 'Halwa', '15', '<h1><strong><em><u>Halwa</u></em></strong></h1>', 'M.png', '0000-00-00', '0000-00-00', 15),
(94, 'Makki ki roti, sarson ka saag', '40', '<h1><strong><em><u>Makki ki roti, sarson ka saag</u></em></strong></h1>', 'food.png', '0000-00-00', '0000-00-00', 10),
(95, 'Dal Makhani', '25', '<h1><strong><em><u>Dal Makhani</u></em></strong></h1>', 'DALL·E 2023-11-23 20.08.31 - A rich and creamy plate of Dal Makhani, a beloved Indian dish, featuring slow-cooked lentils and beans in a buttery, spiced gravy, garnished with crea.png', '0000-00-00', '0000-00-00', 11),
(96, 'Mix Vegetable', '60', '<h2><strong><em><u>Mix Vegetable</u></em></strong></h2>', 'N.png', '0000-00-00', '0000-00-00', 13),
(97, 'Biryani', '25', '<h1><em><u>Biryani</u></em></h1>', '6 (2).png', '0000-00-00', '0000-00-00', 11),
(98, 'Aloo Tikki', '15', '<h2><strong><em><u>Aloo Tikki</u></em></strong></h2>', '5.png', '0000-00-00', '0000-00-00', 10),
(100, 'Empty', '30', '<p>Empty</p>', '', '0000-00-00', '0000-00-00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(255) NOT NULL,
  `thumb1` varchar(255) NOT NULL,
  `thumb2` varchar(255) NOT NULL,
  `thumb3` varchar(255) NOT NULL,
  `thumb4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `thumb1`, `thumb2`, `thumb3`, `thumb4`) VALUES
(1, '8.webp', '9.webp', '10.webp', '11.webp'),
(2, 'product-1-2.png', 'product-1-3.png', 'product-1-6.png', 'product-1-7.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(3, 'Navjot', 'navjot10@gmail.com', '$2y$10$9INxIO850b.mBAvsdDq.0OlcdCpApRCpLiYg2SZZks0JfRfiiz98K', 'admin'),
(14, 'Ankita', 'ankita10@gmail.com', '$2y$10$.U/bVIbR1aucEHF/YXfdlu7U01hh21YaABq/khEo.hbXjt6cTvU4e', 'user'),
(15, 'James', 'james15@gmail.com', '$2y$10$oaCmWVtiTQKVe3HkI8a4A.Qdf1uRmoaS7QCebcL.IQjHSdzM3IvEi', 'user'),
(16, 'Daisy', 'daisy10@gmail.com', '$2y$10$KdB3JSnFmORLKxOf6acwbuxdFolrdY8qYBwH0uVoRNs/UVCr7prZW', 'admin'),
(18, 'Bob', 'bob10@gmail.com', '$2y$10$UeV5105ep0Yv3EAsc2/AwuTpruca54DnTsXG6tXQ/lXXtm.C6SE6i', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
