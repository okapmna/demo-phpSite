-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Apr 01, 2026 at 03:40 PM
-- Server version: 12.2.2-MariaDB-ubu2404
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo-php`
--
CREATE DATABASE IF NOT EXISTS `demo-php`;
USE `demo-php`;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `content`, `created_at`) VALUES
(2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam ipsa, tempore error similique libero fuga inventore nihil voluptate quo cumque recusandae natus qui maxime pariatur iure quis doloremque ad. Distinctio!', '2026-04-01 15:36:41'),
(3, 'Halo ini percobaan setup PHP, NGINX, dan MariaDB', '2026-04-01 15:37:14'),
(4, 'Halo ini percobaan setup PHP, NGINX, dan MariaDB', '2026-04-01 15:38:37'),
(5, 'Halo ini percobaan setup PHP, NGINX, dan MariaDB', '2026-04-01 15:39:47'),
(6, 'Haiii', '2026-04-01 15:39:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;