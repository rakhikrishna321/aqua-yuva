-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2023 at 01:45 PM
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
-- Database: `yuva_aqua`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_agents`
--

CREATE TABLE `delivery_agents` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL COMMENT 'admin/token',
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_agents`
--

INSERT INTO `delivery_agents` (`id`, `token`, `name`, `email`, `phone`, `created_at`, `created_by`, `status`) VALUES
(1, 't5dc6ea15-3c7e-4e3a-a2a0-1537ace6cbba', 'names', 'deli@mail.com', '987654321', '2023-02-11 20:56:42', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `handled_by` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `phone` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `token`, `name`, `handled_by`, `email`, `phone`, `created_at`, `status`) VALUES
(1, 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 'department 1', 'sajeesh rajan', 'dpt1@mail.com', '9874563214', '2023-02-11 20:32:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fcm_token`
--

CREATE TABLE `fcm_token` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fcm_token` longtext NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `department_token` varchar(255) DEFAULT NULL,
  `mrp_total` decimal(13,2) NOT NULL DEFAULT 0.00,
  `total` decimal(13,2) NOT NULL DEFAULT 0.00,
  `delivery_address` text DEFAULT NULL,
  `delivery_pincode` varchar(6) DEFAULT NULL,
  `delivery_contact` varchar(15) DEFAULT NULL,
  `payment` varchar(20) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'pending' COMMENT 'pending\r\norder placed\r\ntransit\r\nout for delivery\r\ndelivered',
  `agent` varchar(255) DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `review_notify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `token`, `department_token`, `mrp_total`, `total`, `delivery_address`, `delivery_pincode`, `delivery_contact`, `payment`, `created_by`, `created_at`, `status`, `agent`, `delivered_at`, `review_notify`) VALUES
(1, 't5ed1df3a-f277-4cf3-87ed-277e6d44f095', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', '8000.00', '6400.00', 'address', '798546', '3453453545', 'COD', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', '2023-02-22 23:55:07', 'DELIVERED', NULL, '2023-02-24 00:58:38', 0),
(2, 'te0e56c36-16e0-4fce-b4fe-589c9390ca87', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', '2500.00', '2000.00', 'address', '987654', '3453453545', 'COD', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', '2023-02-24 00:52:08', 'CANCELED', NULL, NULL, 0),
(3, 'tfc57df5b-e775-41f0-a7b2-5414e1bc020a', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', '2500.00', '2000.00', 'svdsf', '321123', '3453453545', 'COD', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', '2023-02-24 21:38:39', 'order placed', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `order_token` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` decimal(13,2) NOT NULL,
  `total` decimal(13,2) NOT NULL,
  `mrp` decimal(13,2) NOT NULL,
  `mrp_total` decimal(13,2) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`id`, `token`, `order_token`, `product`, `product_name`, `qty`, `rate`, `total`, `mrp`, `mrp_total`, `created_at`, `created_by`, `status`) VALUES
(2, 't8ec16398-6400-4a98-b0b1-d4a1d3d10539', 't5ed1df3a-f277-4cf3-87ed-277e6d44f095', 'tc7de4962-f718-422b-ae85-c9c45b623fb0', 'product 2', 1, '400.00', '400.00', '500.00', '500.00', '2023-02-22 23:55:19', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1),
(4, 't120fe5ee-b627-4477-a183-a229e4df497e', 't5ed1df3a-f277-4cf3-87ed-277e6d44f095', 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 'product 1', 3, '2000.00', '6000.00', '2500.00', '7500.00', '2023-02-22 23:55:27', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1),
(5, 't19beaeec-9dfa-4037-80ac-9cd508e17b55', 'te0e56c36-16e0-4fce-b4fe-589c9390ca87', 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 'product 1', 1, '2000.00', '2000.00', '2500.00', '2500.00', '2023-02-24 00:52:08', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1),
(7, 'tcfd04e63-d7dc-448d-9fcf-6a6e21aa5321', 'tfc57df5b-e775-41f0-a7b2-5414e1bc020a', 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 'product 1', 1, '2000.00', '2000.00', '2500.00', '2500.00', '2023-02-24 21:49:56', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `specification` longtext DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `mrp` decimal(13,2) DEFAULT 0.00,
  `rate` decimal(13,2) DEFAULT 0.00,
  `created_at` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `token`, `department`, `name`, `description`, `specification`, `stock`, `mrp`, `rate`, `created_at`, `created_by`, `status`) VALUES
(1, 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 'product 1', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.\n\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.\n\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.', 345, '2500.00', '2000.00', '2023-02-18 23:32:37', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 1),
(2, 'tc7de4962-f718-422b-ae85-c9c45b623fb0', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 'product 2', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus ullam beatae impedit quo mollitia minima, dolores ex incidunt eligendi! Atque ipsum in earum repellat excepturi ad totam quae voluptates porro.', 499, '500.00', '400.00', '2023-02-18 23:45:54', 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `product_token` varchar(255) NOT NULL,
  `file_path` longtext NOT NULL,
  `first_img` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `token`, `product_token`, `file_path`, `first_img`) VALUES
(2, 't9d3388c7-30bf-420d-8b12-03a63768302e', 'tc7de4962-f718-422b-ae85-c9c45b623fb0', 'files/t7dd83e14-9af5-4d33-9f33-afbca3dcf086.jpg', 1),
(5, 'tdee08cca-2ba9-4ef5-895e-b73e792e4c9d', 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 'files/tcc323a62-30d3-42c2-a105-1fdaa2380e48.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `token`, `product`, `rating`, `review`, `created_at`, `created_by`, `status`) VALUES
(1, 'tbda9a764-f513-47f5-be16-052b20f52b8d', 'tc7de4962-f718-422b-ae85-c9c45b623fb0', 3, 'very good ', '2023-02-24 01:26:41', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1),
(2, 't39c60313-0df6-4da2-ad97-5f9a3f0a081c', 't3cfd9378-3c5f-4d40-a27b-30d4deb8ecd4', 2, 'excelent\r\n', '2023-02-24 01:27:19', 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `remember_token`
--

CREATE TABLE `remember_token` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fcm_token` longtext NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remember_token`
--

INSERT INTO `remember_token` (`id`, `token`, `fcm_token`, `created_at`) VALUES
(1, 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 't3217210f-4d9a-4023-a1f1-11f52e5a148b', '2023-02-25 15:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(21) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `fcm` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `token`, `user_type`, `name`, `email`, `phone`, `password`, `status`, `created_at`, `fcm`) VALUES
(4, 'KJSDNKJWHNDKWHJNWKJNKDJJNKWJNKJNFL', 'admin', 'Admin', 'admin@mail.com', NULL, '123456', 1, '2022-03-07 18:03:29', 't85a8d199-fff5-4637-be7e-8a55578ac6f4'),
(10, 't151f22eb-24da-4b22-ac39-c09bde5e93f5', 'department', 'department 1', 'dpt1@mail.com', NULL, '696947754', 1, '2023-02-11 20:32:29', 't4c8fd59f-4313-4d0a-90a2-a771e4c0ba3a'),
(11, 't5dc6ea15-3c7e-4e3a-a2a0-1537ace6cbba', 'delivery', 'names', 'deli@mail.com', NULL, '123456', 1, '2023-02-11 20:56:42', NULL),
(12, 't4998e4a9-5d24-48df-9d04-3750f1d5ec03', 'user', 'User One', 'user1@mail.com', '3453453545', '123@Aqua', 1, '2023-02-19 08:54:35', 'tfa3e2342-7c71-46ad-b753-e167c30fe287');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fcm_token`
--
ALTER TABLE `fcm_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remember_token`
--
ALTER TABLE `remember_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fcm_token`
--
ALTER TABLE `fcm_token`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `remember_token`
--
ALTER TABLE `remember_token`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
