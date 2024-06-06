-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 06, 2024 at 01:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `computer_parts_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(25, 1, 34, 20, '2024-05-27 11:42:50'),
(26, 1, 34, 9, '2024-05-27 11:43:01');

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
(1, 'Processors'),
(2, 'Graphics Cards'),
(3, 'Memory'),
(4, 'Storage'),
(5, 'Motherboards');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_posts`
--

CREATE TABLE `deleted_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_posts`
--

INSERT INTO `deleted_posts` (`id`, `title`, `content`, `image_url`, `created_at`, `position`) VALUES
(5, '', '', '', '2024-05-27 11:40:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_products`
--

CREATE TABLE `deleted_products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_products`
--

INSERT INTO `deleted_products` (`id`, `name`, `description`, `price`, `quantity`, `category_id`) VALUES
(9, 'sd', 'sd', 1.00, 1, 1),
(10, 'вап', 'вап', 1.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_reviews`
--

CREATE TABLE `deleted_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_content`
--

CREATE TABLE `home_content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_content`
--

INSERT INTO `home_content` (`id`, `title`, `subtitle`) VALUES
(1, 'Welcome to Computer Parts Store', 'Your one-stop shop for all computer parts...');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image_url`, `created_at`, `position`) VALUES
(1, 'Wee!', 'Best computer parts ever!', 'https://thumbs.dreamstime.com/b/computer-parts-isometric-set-isolated-white-background-inside-case-hardware-elements-hard-disk-drive-motherboard-video-card-124555433.jpg', '2024-05-23 10:01:17', 3),
(2, 'SALES!!!', 'Sale 142%', '../images/sales.jpg', '2024-05-23 10:06:42', 2),
(3, 'Holy mother!', 'Meming time!', '../images/mother.jpg', '2024-05-24 11:02:51', 4),
(4, 'Make the best gaming place!', 'With our accessories, you will have the most cyberpunk and cool gaming place!', '../images/Game_PC.webp', '2024-05-24 11:21:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `category_id`) VALUES
(34, 'Corsair Vengeance LPX 16GB', 'DDR4 DRAM 3200MHz C16 memory kit', 79.99, 30, 3),
(41, 'NVIDIA RTX 3080', 'High-performance GPU', 699.99, 5, 2),
(54, 'Samsung 970 EVO', 'NVMe SSD 1TB', 129.99, 20, 4),
(55, 'AMD Ryzen 9', 'High-performance CPU', 449.99, 15, 1),
(57, 'ASUS ROG Strix B450-F', 'Gaming motherboard with AMD AM4 socket', 139.99, 11, 5),
(58, 'Samsung 860 EVO 500GB', '2.5 Inch SATA III Internal SSD', 69.99, 26, 4),
(59, 'NVIDIA GTX 1660 Super', '6GB GDDR6 graphics card', 229.99, 15, 2),
(60, 'Memory 1000', 'Kingston', 122.00, 55, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `review`, `rating`, `created_at`) VALUES
(28, 57, 2, 'Rog 1', 1, '2024-05-25 06:25:33'),
(29, 57, 2, 'Rog 5', 5, '2024-05-25 06:25:39'),
(31, 41, 2, 'Meehh...', 1, '2024-05-25 06:51:57'),
(32, 34, 2, 'Corsairing!!!', 5, '2024-05-25 06:52:19'),
(33, 54, 2, 'So so', 3, '2024-05-25 06:52:31'),
(36, 55, 2, 'I like it!', 5, '2024-05-25 06:53:21'),
(37, 58, 2, 'So old', 2, '2024-05-25 06:53:07'),
(38, 59, 2, 'Very Super', 5, '2024-05-25 06:52:47'),
(39, 60, 2, 'Cool!', 5, '2024-05-25 06:51:43'),
(40, 34, 1, 'coll', 5, '2024-05-27 11:42:24'),
(41, 34, 1, 'cool', 1, '2024-05-27 11:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_type` enum('customer','admin','employee') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `account_type`) VALUES
(1, 'user1', '$2y$10$/dgHUl3pZWOg5EWxKp3QrOlV0xqmlSlvoo4jXBIPaboXdQoE.xa0G', '2024-05-22 09:31:48', 'customer'),
(2, 'user2', '$2y$10$MjVe1bNmlmEupxvguVuwoed/YCghj80I60/8MI4joclXU3CUndhta', '2024-05-22 17:13:40', 'customer'),
(3, 'admin', '$2y$10$TzpprYkRXtRnb9R9iW0mUO7izbZXSVTbpMTRBn7vFi78LCRwhqEDu', '2024-05-23 08:44:16', 'admin'),
(4, 'employee', '$2y$10$9CUseqSFwZCJi3fnK.VaNeYvVuUgU0d93/r2NloT8sghogXHU7.ea', '2024-05-23 09:13:44', 'employee'),
(5, 'anime', '$2y$10$bbzz4/cfrh5D5M1vyqlTmO9bnvcmJK1Srvc1XoVgqqvfi99kYfrYa', '2024-05-23 11:23:43', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_posts`
--
ALTER TABLE `deleted_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_reviews`
--
ALTER TABLE `deleted_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `home_content`
--
ALTER TABLE `home_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deleted_products`
--
ALTER TABLE `deleted_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `deleted_reviews`
--
ALTER TABLE `deleted_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `home_content`
--
ALTER TABLE `home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `deleted_reviews`
--
ALTER TABLE `deleted_reviews`
  ADD CONSTRAINT `deleted_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `deleted_products` (`id`),
  ADD CONSTRAINT `deleted_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
