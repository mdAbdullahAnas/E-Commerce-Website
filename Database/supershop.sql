-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2025 at 05:43 AM
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
-- Database: `supershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Number` int(11) NOT NULL,
  `ID` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Number`, `ID`, `Password`) VALUES
(1, 'Anas', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `type` enum('percent','fixed') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `created_at`) VALUES
(1, 'QKOD302Y', 'percent', 20.00, '2025-09-18 18:52:10'),
(2, 'BAS4OX17', 'fixed', 10.00, '2025-09-22 18:39:34'),
(3, 'L9JACJV2', 'percent', 50.00, '2025-10-02 10:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `delivery_men`
--

INSERT INTO `delivery_men` (`id`, `name`, `phone`, `vendor_id`, `created_at`) VALUES
(1, 'A', '01711112222', 1, '2025-09-22 13:31:09'),
(2, 'Nur E Fatema', '01833334444', 1, '2025-09-22 13:31:09'),
(3, 'A', '01955556666', 2, '2025-09-22 13:31:09'),
(4, 'Nitu', '01677778888', 2, '2025-09-22 13:31:09'),
(5, 'A', '01711112222', 3, '2025-09-22 13:31:52'),
(6, 'Nur E Fatema', '01833334444', 3, '2025-09-22 13:31:52'),
(7, 'A', '01955556666', 3, '2025-09-22 13:31:52'),
(8, 'Nitu', '01677778888', 3, '2025-09-22 13:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `coupon_code` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `payment_method` enum('Card','Mobile Wallet','Cash on Delivery') NOT NULL,
  `card_number` varchar(25) DEFAULT NULL,
  `card_expiry` varchar(10) DEFAULT NULL,
  `card_cvv` varchar(5) DEFAULT NULL,
  `wallet_type` enum('Bkash','Rocket','Nagad') DEFAULT NULL,
  `wallet_phone` varchar(20) DEFAULT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `delivery_man_id` int(11) DEFAULT NULL,
  `expected_delivery` date DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total`, `discount`, `coupon_code`, `address`, `contact_number`, `payment_method`, `card_number`, `card_expiry`, `card_cvv`, `wallet_type`, `wallet_phone`, `status`, `created_at`, `delivery_man_id`, `expected_delivery`, `delivered_at`) VALUES
(2, 8, 22.00, 0.00, NULL, 'Ma Villa', '0198329991', 'Mobile Wallet', '', '', '', 'Bkash', '019832991', 'Delivered', '2025-09-15 17:44:09', NULL, NULL, NULL),
(3, 8, 45.00, 0.00, NULL, 'Ma Villa', '0198329991', 'Mobile Wallet', '', '', '', 'Bkash', '0198329991', 'Delivered', '2025-09-17 12:14:20', NULL, NULL, NULL),
(4, 8, 44.00, 0.00, NULL, 'Ma Villa', '019832991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Delivered', '2025-09-18 15:08:20', NULL, NULL, NULL),
(6, 8, 45.00, 0.00, NULL, 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Pending', '2025-09-18 18:45:58', NULL, NULL, NULL),
(7, 8, 16.00, 4.00, 'QKOD302Y', 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Pending', '2025-09-18 18:58:15', NULL, NULL, NULL),
(8, 8, 26.40, 6.60, 'QKOD302Y', 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Pending', '2025-09-18 18:59:05', NULL, NULL, NULL),
(9, 8, 26.40, 6.60, 'QKOD302Y', 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Pending', '2025-09-18 19:13:28', NULL, NULL, NULL),
(10, 10, 33.00, 0.00, '', 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Delivered', '2025-09-22 19:16:17', NULL, NULL, NULL),
(11, 8, 12.00, 10.00, 'BAS4OX17', 'M', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Pending', '2025-09-22 19:33:36', 6, '2025-02-22', NULL),
(12, 8, 35.00, 10.00, 'BAS4OX17', 'Ma Villa', '019832991', 'Card', '11', '09/13', '231', 'Bkash', '', 'Delivered', '2025-09-22 19:42:57', NULL, NULL, NULL),
(13, 8, 1199.00, 0.00, '', 'Ma Villa', '0198329991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Delivered', '2025-10-02 10:26:00', NULL, NULL, NULL),
(14, 10, 49.00, 0.00, '', 'Ma Villa', '0198329991', 'Mobile Wallet', '', '', '', 'Bkash', '0198329991', 'Pending', '2025-10-11 17:31:51', NULL, NULL, NULL),
(15, 8, 599.00, 0.00, '', 'Ma Villa', '019832991', 'Cash on Delivery', '', '', '', 'Bkash', '', 'Delivered', '2025-10-12 11:56:59', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 3, 15, 1, 45.00),
(5, 6, 15, 1, 45.00),
(7, 8, 21, 1, 33.00),
(8, 9, 21, 1, 33.00),
(9, 10, 21, 1, 33.00),
(10, 11, 22, 1, 22.00),
(11, 12, 15, 1, 45.00),
(12, 13, 25, 1, 1199.00),
(13, 14, 32, 1, 49.00),
(14, 15, 31, 1, 599.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('Card','Mobile Wallet','Cash on Delivery') NOT NULL,
  `card_number` varchar(25) DEFAULT NULL,
  `card_expiry` varchar(10) DEFAULT NULL,
  `card_cvv` varchar(5) DEFAULT NULL,
  `wallet_type` enum('Bkash','Rocket','Nagad') DEFAULT NULL,
  `wallet_phone` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `img` varchar(255) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `quantity`, `img`, `vendor_id`, `description`, `status`, `review`, `created_at`) VALUES
(15, 'Coffee Maker', 45.00, 21, '../../Asset/Images/coffeemaker.jpg', 1, 'Automatic coffee maker with timer.', 'accepted', NULL, '2025-09-11 07:25:46'),
(21, 'T shirt', 33.00, 20, '../../Asset/Images/T_shirt_1757598955.jpeg', 6, 'New T shirt', 'accepted', NULL, '2025-09-11 13:55:55'),
(22, 'mouse', 22.00, 1, '../../Asset/Images/mouse_1758544430.jpg', 3, 'Limited Addition Mouse', 'accepted', NULL, '2025-09-22 12:33:50'),
(23, 'Headphone', 300.00, 33, '../../Asset/Images/Headphone_1758546208.jpeg', 3, 'Premium Quality headphone', 'accepted', NULL, '2025-09-22 13:03:28'),
(24, 'Laptop', 300.00, 20, '../../Asset/Images/Laptop_1758697906.jpg', 11, 'Its a great laptop for students.', 'accepted', NULL, '2025-09-24 07:11:46'),
(25, 'iPhone', 1199.00, 39, '../../Asset/Images/Mobile_Phone_1758697980.webp', 11, 'Its a great phone for game. Latest iPhone. ', 'accepted', NULL, '2025-09-24 07:13:00'),
(27, 'Watch', 375.00, 43, '../../Asset/Images/Watch_1758698147.webp', 11, 'Our latest product. Water proof. ', 'accepted', NULL, '2025-09-24 07:15:47'),
(28, 'AirPod', 99.00, 221, '../../Asset/Images/AirPod_1758699545.webp', 11, 'Nice Air Pod .Easy to use.', 'accepted', NULL, '2025-09-24 07:39:05'),
(29, 'Grosary Combo', 399.00, 42, '../../Asset/Images/Grosary_Combo_1758708454.webp', 11, 'Grosary combo large', 'accepted', NULL, '2025-09-24 10:07:34'),
(30, 'Grosary Combo', 125.00, 32, '../../Asset/Images/Grosary_Combo_1758708491.webp', 11, 'Grosary Combo Small', 'rejected', NULL, '2025-09-24 10:08:11'),
(31, 'Camera', 799.00, 32, '../../Asset/Images/Camera_1758708546.jpg', 11, 'Very beautiful camera. ', 'accepted', NULL, '2025-09-24 10:09:06'),
(32, 'Make Up Item', 49.00, 52, '../../Asset/Images/Make_Up_Item_1758708589.jpeg', 11, 'Make Up Item Combo.', 'accepted', NULL, '2025-09-24 10:09:49'),
(33, 'Fruits', 109.00, 55, '../../Asset/Images/Fruits_1758708627.webp', 11, 'Fruits item combo.', 'accepted', NULL, '2025-09-24 10:10:27'),
(34, 'Selfie Stick ', 22.00, 32, '../../Asset/Images/Selfie_Stick__1758708672.jpg', 11, 'Very Hard and beautiful Selfie stick.', 'accepted', NULL, '2025-09-24 10:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text NOT NULL,
  `reply` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `vendor_username` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `membership` varchar(50) NOT NULL DEFAULT 'free'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `phone`, `address`, `password`, `created_at`, `membership`) VALUES
(1, 'MD Abdullah Anas', 'Anas', 'abd@gmail.com', '01984298833', 'Ma Villa', '1234567890', '2025-09-09 13:18:49', 'free'),
(5, 'MD Abdullah Anas', 'customer2', 'dc@gmail.com', '0198329991', 'Ma Villa', '$2y$10$giKNAjT7gNBBdQ5l/xbYCeyxS083ycn4D18H2biTHOY06uMcmMjTi', '2025-09-10 05:00:23', 'Premium'),
(8, 'c', 'c', 'c@gmail.com', '01983299910', 'M Villa', '$2y$10$Flvo7hhvzYp5XwIE4QkGzOh.dYaSbRhKLKD9TMr04xQhmi..ZWj5m', '2025-09-11 06:10:51', 'free'),
(10, 'MD Abdullah Anas', 'c2', 'ab22d@gmail.com', '019832991', 'Ma Villa', '$2y$10$HGAhYL7Puzdvcv1LdLSKWOHB48jttdivFKCgo0s.RRgbXnRAOz9NW', '2025-09-18 12:31:03', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `fullname`, `username`, `email`, `phone`, `address`, `password`, `experience`, `created_at`) VALUES
(1, 'MD Abdullah Anas', 'Anas', 'abd@gmail.com', '01521799812', 'Ma Villa', '$2y$10$D5RyLfWcfo5BTNBa.sl/qu4jAnaX6eLtzGfZlk796DFpaZXcFOUAS', '7 years', '2025-09-09 13:37:21'),
(3, 'v', 'v', 'v@gmail.com', 'v', 'vv', '$2y$10$sD6BuyH.TM.thB93w4zJie2KjKPbzrRYQj48Anl7VyAm4ZvHKs88K', '5 years', '2025-09-11 06:11:30'),
(6, 'MD Abdullah Anas', 'v1', 'abdfd@gmail.com', '0198329991', 'Ma Vddilla', '$2y$10$oMYTVNWLWRUxOCBWA9YDwOsru41zBZPMbN3aNi.H5XyvTPTXX79mu', '7 yesdars', '2025-09-11 13:55:14'),
(7, 'v5', 'v5', 'v5@gmail.com', '0198329555', 'Ma Villa', '$2y$10$e.Mqgkfwnv./5isvBcesbuQZUhNkM1ZR3kHrt2/hhG/3BiY6SiJfm', '5 years', '2025-09-24 06:39:28'),
(8, 'v6 (Sample)', 'v6', 'v6@gmail.com', '0198329991', 'Ma Villa', '$2y$10$.UEIzfb6Yum4hnk9JW4eWOt4aEhRWAhGjyKyVsFHZIA1lzxFD0jdi', '7 years', '2025-09-24 06:40:48'),
(10, 'Vendor8 (from Form)', 'v8', 'v8@gmail.com', '0198329991', 'Ma Villa', '$2y$10$xTYiy9kDh/A0pBWWLK9apOF/WF0uMQx5MG5lG9unLUcAv7HcH6WAy', '8', '2025-09-24 07:00:55'),
(11, 'Vendor10', 'v10', 'v10@gmail.com', '0198329991', 'Ma Villa', '$2y$10$iKY9JALsp0p8KGONfAjME.Fx76X3Gf2XbJ8mndGSNar/GzK3D/K9C', '10 years', '2025-09-24 07:04:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Number`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`vendor_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
