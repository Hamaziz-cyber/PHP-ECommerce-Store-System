-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 06:51 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(23, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'cpu'),
(2, 'gpu'),
(4, 'keyborad'),
(5, 'mouse'),
(3, 'storage');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `Email` varchar(254) NOT NULL,
  `feedback_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_id`, `user_id`, `name`, `Email`, `feedback_desc`) VALUES
(3, 4, 'Hamza', 'alo@gmail.com', 'lo siento hermano'),
(4, 4, 'Hamza', 'alo@gmail.com', 'hello'),
(5, 4, 'Abash', 'abash@gmail.com', 'abcdefg'),
(6, 4, 'Abash', 'abash@gmail.com', 'abcdefg'),
(7, 4, 'Hamza', 'test@gmail.com', 'hi'),
(8, 4, 'Hamza', 'test@gmail.com', 'hi'),
(9, 4, 'Hala', 'email@gmail.com', 'hello'),
(10, 4, 'Ahed', 'fake@gmail.com', '11111'),
(11, 4, 'Ef', 'abash@gmaol.com', '1233e');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total`) VALUES
(1, 4, '2025-09-09 18:32:32', '640.00'),
(8, 4, '2025-09-10 17:19:04', '920.00'),
(9, 4, '2025-09-10 17:28:55', '583.00'),
(10, 4, '2025-09-11 14:16:06', '2000.00'),
(11, 4, '2025-09-11 14:21:29', '160.00'),
(12, 4, '2025-09-22 14:46:38', '449.00'),
(13, 4, '2025-09-26 22:29:20', '320.00'),
(14, 4, '2025-09-26 23:11:20', '449.00'),
(15, 4, '2025-09-26 23:41:46', '1360.00'),
(16, 4, '2025-09-27 00:36:00', '160.00'),
(17, 4, '2025-09-27 01:42:54', '79.00'),
(18, 4, '2025-09-27 02:32:41', '449.00'),
(19, 4, '2025-10-09 08:44:20', '898.00'),
(20, 4, '2026-04-23 17:00:11', '6893.00'),
(21, 4, '2026-04-26 16:51:04', '2398.00'),
(22, 4, '2026-04-26 18:30:39', '3597.00'),
(23, 4, '2026-04-26 19:38:58', '1940.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 4, '160.00'),
(10, 8, 1, 1, '160.00'),
(11, 8, 2, 2, '380.00'),
(13, 9, 12, 1, '25.00'),
(14, 9, 13, 2, '39.00'),
(15, 9, 1, 3, '160.00'),
(16, 10, 1, 3, '160.00'),
(17, 10, 2, 4, '380.00'),
(19, 11, 1, 1, '160.00'),
(20, 12, 6, 1, '449.00'),
(21, 13, 1, 2, '160.00'),
(22, 14, 6, 1, '449.00'),
(23, 15, 5, 4, '340.00'),
(24, 16, 1, 1, '160.00'),
(25, 17, 10, 1, '79.00'),
(26, 18, 6, 1, '449.00'),
(27, 19, 6, 2, '449.00'),
(28, 20, 6, 2, '449.00'),
(29, 20, 7, 5, '1199.00'),
(30, 21, 7, 2, '1199.00'),
(31, 22, 7, 3, '1199.00'),
(32, 23, 1, 5, '160.00'),
(33, 23, 2, 3, '380.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `Active` varchar(25) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `price`, `image`, `Active`) VALUES
(1, 1, 'Intel Core i5', '6 cores, 12 threads, 4.4GHz boost. Great budget CPU for everyday tasks.', '160.00', 'intel core i5.png', 'Active'),
(2, 1, 'Intel Core i7', '16 cores (8P + 8E), high turbo speeds. Balanced for heavy multitasking and gaming.', '380.00', 'intel core i7.jpg', 'Active'),
(3, 1, 'Intel Core i9', '24 cores (8P + 16E). Flagship performance for gaming, streaming, and content creation.', '520.00', 'intel core i9.jpg', 'Active'),
(4, 1, 'AMD Ryzen 5', '6 cores, Zen 4 architecture. Efficient gaming CPU with PCIe 5.0 support.', '220.00', 'Ryzen 5.png', 'Active'),
(5, 1, 'AMD Ryzen 7', '8 cores, high boost clock (5.4GHz). Ideal for high-FPS gaming and streaming.', '340.00', 'Ryzen 7.png', 'Active'),
(6, 2, 'NVIDIA GeForce RTX 3070 8GB', 'Excellent 1440p gaming GPU with ray tracing support. Strong price-to-performance.', '449.00', 'RTX 3070.png', 'Active'),
(7, 2, 'NVIDIA GeForce RTX 4080 16GB', 'High-end GPU for 4K gaming and heavy rendering workloads.', '1199.00', 'RTX 4080.png', 'Active'),
(8, 2, 'AMD Radeon RX 6800 XT 16GB', 'Excellent 4K gaming GPU, strong competitor to NVIDIA’s high-end cards.', '599.00', 'radeon 6800.png', 'Active'),
(9, 3, 'SSD NVMe 500GB Gen3 ', 'Fast read/write speeds, great for OS and essential apps.', '45.00', 'ssd 500.png', 'Active'),
(10, 3, 'SSD NVMe 1TB Gen4', 'High-speed Gen4 drive. Excellent for gaming and large programs.', '79.00', 'ssd 1png.png', 'Active'),
(11, 3, 'SSD NVMe 2TB Gen4', 'Massive storage with top-tier speeds for creators and gamers.', '139.00', 'ssd 2png.png', 'Active'),
(12, 4, 'OfficeBoard Slim', 'Compact, lightweight membrane keyboard for office or casual use.', '25.00', 'k1.png', 'Active'),
(13, 4, 'Redragon K552', 'Budget mechanical keyboard with Outemu Red switches. Durable & responsive.', '39.00', 'k2.png', 'Active'),
(14, 4, 'Logitech G915 TKL', 'Premium low-profile wireless mechanical keyboard with Lightspeed tech.', '179.00', 'k3.png', 'Active'),
(15, 5, 'Razer DeathAdder Essential', 'Classic ergonomic gaming mouse with 6,400 DPI optical sensor.', '29.00', 'mouse 1.png', 'Active'),
(16, 5, 'Razer Viper 8KHz', 'Ultrafast wired gaming mouse. Ambidextrous, 8,000Hz polling rate.', '69.00', 'mouse 2.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` char(255) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'user',
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `status`, `reg_date`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$pG0NRoN46H7/hi3WqtzzVOvhckXyrtOIhuewsZeNCZ8Rij/.vUGeu', 'admin', '2025-09-05 23:30:29'),
(4, 'User', 'user@gmail.com', '$2y$10$mYWu2iDFPvjvDueW6xjNOOUKiFMUswGXJBsZ7FRVNQawPV4Cm4EJG', 'user', '2025-09-09 11:15:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD UNIQUE KEY `cart_id` (`cart_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
