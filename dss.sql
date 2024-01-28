-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2024 at 04:19 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dss`
--

-- --------------------------------------------------------

--
-- Table structure for table `ahp_alternatives`
--

CREATE TABLE `ahp_alternatives` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_alternatives_sub_criteria_priority`
--

CREATE TABLE `ahp_alternatives_sub_criteria_priority` (
  `id` int NOT NULL,
  `id_ahp_alternatives` bigint NOT NULL,
  `id_ahp_criteria` bigint NOT NULL,
  `id_ahp_sub_criteria` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_criteria`
--

CREATE TABLE `ahp_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_criteria_priority`
--

CREATE TABLE `ahp_criteria_priority` (
  `id` int NOT NULL,
  `id_ahp_criteria` int NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_criteria_weights`
--

CREATE TABLE `ahp_criteria_weights` (
  `id` bigint NOT NULL,
  `id_ahp_criteria_x` int NOT NULL,
  `id_ahp_criteria_y` int NOT NULL,
  `id_projects` int NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_criteria_weights_total`
--

CREATE TABLE `ahp_criteria_weights_total` (
  `id` int NOT NULL,
  `id_criteria` int NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_random_index`
--

CREATE TABLE `ahp_random_index` (
  `id` int NOT NULL,
  `criteria_count` int NOT NULL,
  `value` float NOT NULL,
  `id_projects` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ahp_random_index`
--

INSERT INTO `ahp_random_index` (`id`, `criteria_count`, `value`, `id_projects`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(2, 2, 0, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(3, 3, 0.58, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(4, 4, 0.9, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(5, 5, 1.12, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(6, 6, 1.24, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(7, 7, 1.32, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(8, 8, 1.41, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(9, 9, 1.45, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(10, 10, 1.49, 0, '2023-11-17 15:09:07', '2023-11-17 15:09:07', '2023-11-17 15:09:07'),
(11, 3, 0.58, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(12, 4, 0.9, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(13, 5, 1.12, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(14, 6, 1.24, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(15, 7, 1.32, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(16, 8, 1.41, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(17, 9, 1.45, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(18, 10, 1.49, 12, '2023-11-17 08:39:25', '2023-11-17 08:39:25', '2023-11-17 15:39:25'),
(19, 3, 0.55, 13, '2023-11-17 08:47:00', '2023-11-17 12:37:21', '2023-11-17 15:47:00'),
(20, 4, 0.9, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(21, 5, 1.12, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(22, 6, 1.24, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(23, 7, 1.32, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(24, 8, 1.41, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(25, 9, 1.45, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00'),
(26, 10, 1.49, 13, '2023-11-17 08:47:00', '2023-11-17 08:47:00', '2023-11-17 15:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `ahp_sub_criteria`
--

CREATE TABLE `ahp_sub_criteria` (
  `id` int NOT NULL,
  `id_ahp_criteria` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_sub_criteria_priority`
--

CREATE TABLE `ahp_sub_criteria_priority` (
  `id` int NOT NULL,
  `id_ahp_sub_criteria` int NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ahp_sub_criteria_weights`
--

CREATE TABLE `ahp_sub_criteria_weights` (
  `id` bigint NOT NULL,
  `id_ahp_sub_criteria_x` int NOT NULL,
  `id_ahp_sub_criteria_y` int NOT NULL,
  `id_projects` int NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `id_users` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `dss` enum('ahp','saw','wp','topsis') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saw_alternatives`
--

CREATE TABLE `saw_alternatives` (
  `id` bigint NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saw_alternatives_criteria_weight`
--

CREATE TABLE `saw_alternatives_criteria_weight` (
  `id` bigint NOT NULL,
  `id_saw_criteria` int NOT NULL,
  `id_alternatives` bigint NOT NULL,
  `id_saw_sub_criteria` bigint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saw_criteria`
--

CREATE TABLE `saw_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost_benefit` enum('benefit','cost') NOT NULL,
  `weight` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saw_sub_criteria`
--

CREATE TABLE `saw_sub_criteria` (
  `id` bigint NOT NULL,
  `id_projects` int NOT NULL,
  `id_saw_criteria` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `google_client_id` varchar(255) NOT NULL,
  `google_client_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `google_client_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smart_alternatives`
--

CREATE TABLE `smart_alternatives` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smart_alternatives_sub_criteria`
--

CREATE TABLE `smart_alternatives_sub_criteria` (
  `id` bigint NOT NULL,
  `id_smart_alternatives` bigint NOT NULL,
  `id_smart_sub_criteria` bigint NOT NULL,
  `id_smart_criteria` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smart_criteria`
--

CREATE TABLE `smart_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int NOT NULL,
  `cost_benefit` enum('cost','benefit') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smart_sub_criteria`
--

CREATE TABLE `smart_sub_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `id_smart_criteria` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `deleted_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_alternatives`
--

CREATE TABLE `topsis_alternatives` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_alternatives_sub_criteria`
--

CREATE TABLE `topsis_alternatives_sub_criteria` (
  `id` bigint NOT NULL,
  `id_topsis_alternatives` bigint NOT NULL,
  `id_topsis_sub_criteria` bigint NOT NULL,
  `id_topsis_criteria` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_criteria`
--

CREATE TABLE `topsis_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int NOT NULL,
  `cost_benefit` enum('cost','benefit') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topsis_sub_criteria`
--

CREATE TABLE `topsis_sub_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `id_topsis_criteria` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `deleted_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('aktif','suspend','freeze') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `picture` mediumblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_limit`
--

CREATE TABLE `users_limit` (
  `id` int NOT NULL,
  `id_users` int NOT NULL,
  `project` int NOT NULL DEFAULT '5',
  `criteria` int NOT NULL DEFAULT '25',
  `alternatives` bigint NOT NULL DEFAULT '300',
  `sub_criteria` bigint NOT NULL DEFAULT '125'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_alternatives`
--

CREATE TABLE `wp_alternatives` (
  `id` bigint NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_alternatives_sub_criteria`
--

CREATE TABLE `wp_alternatives_sub_criteria` (
  `id` bigint NOT NULL,
  `id_wp_alternatives` bigint NOT NULL,
  `id_wp_sub_criteria` bigint NOT NULL,
  `id_wp_criteria` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_criteria`
--

CREATE TABLE `wp_criteria` (
  `id` int NOT NULL,
  `id_projects` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` float NOT NULL,
  `cost_benefit` enum('cost','benefit') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_sub_criteria`
--

CREATE TABLE `wp_sub_criteria` (
  `id` bigint NOT NULL,
  `id_projects` int NOT NULL,
  `id_wp_criteria` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `weight` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ahp_alternatives`
--
ALTER TABLE `ahp_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_alternatives_sub_criteria_priority`
--
ALTER TABLE `ahp_alternatives_sub_criteria_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_criteria`
--
ALTER TABLE `ahp_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_criteria_priority`
--
ALTER TABLE `ahp_criteria_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_criteria_weights`
--
ALTER TABLE `ahp_criteria_weights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_criteria_weights_total`
--
ALTER TABLE `ahp_criteria_weights_total`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_random_index`
--
ALTER TABLE `ahp_random_index`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_sub_criteria`
--
ALTER TABLE `ahp_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_sub_criteria_priority`
--
ALTER TABLE `ahp_sub_criteria_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ahp_sub_criteria_weights`
--
ALTER TABLE `ahp_sub_criteria_weights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saw_alternatives`
--
ALTER TABLE `saw_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saw_alternatives_criteria_weight`
--
ALTER TABLE `saw_alternatives_criteria_weight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saw_criteria`
--
ALTER TABLE `saw_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saw_sub_criteria`
--
ALTER TABLE `saw_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_alternatives`
--
ALTER TABLE `smart_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_alternatives_sub_criteria`
--
ALTER TABLE `smart_alternatives_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_criteria`
--
ALTER TABLE `smart_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smart_sub_criteria`
--
ALTER TABLE `smart_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topsis_alternatives`
--
ALTER TABLE `topsis_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topsis_alternatives_sub_criteria`
--
ALTER TABLE `topsis_alternatives_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topsis_criteria`
--
ALTER TABLE `topsis_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topsis_sub_criteria`
--
ALTER TABLE `topsis_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_limit`
--
ALTER TABLE `users_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_alternatives`
--
ALTER TABLE `wp_alternatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_alternatives_sub_criteria`
--
ALTER TABLE `wp_alternatives_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_criteria`
--
ALTER TABLE `wp_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp_sub_criteria`
--
ALTER TABLE `wp_sub_criteria`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ahp_alternatives`
--
ALTER TABLE `ahp_alternatives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_alternatives_sub_criteria_priority`
--
ALTER TABLE `ahp_alternatives_sub_criteria_priority`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_criteria`
--
ALTER TABLE `ahp_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_criteria_priority`
--
ALTER TABLE `ahp_criteria_priority`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_criteria_weights`
--
ALTER TABLE `ahp_criteria_weights`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_criteria_weights_total`
--
ALTER TABLE `ahp_criteria_weights_total`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_random_index`
--
ALTER TABLE `ahp_random_index`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ahp_sub_criteria`
--
ALTER TABLE `ahp_sub_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_sub_criteria_priority`
--
ALTER TABLE `ahp_sub_criteria_priority`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ahp_sub_criteria_weights`
--
ALTER TABLE `ahp_sub_criteria_weights`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saw_alternatives`
--
ALTER TABLE `saw_alternatives`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saw_alternatives_criteria_weight`
--
ALTER TABLE `saw_alternatives_criteria_weight`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saw_criteria`
--
ALTER TABLE `saw_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saw_sub_criteria`
--
ALTER TABLE `saw_sub_criteria`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smart_alternatives`
--
ALTER TABLE `smart_alternatives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smart_alternatives_sub_criteria`
--
ALTER TABLE `smart_alternatives_sub_criteria`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smart_criteria`
--
ALTER TABLE `smart_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smart_sub_criteria`
--
ALTER TABLE `smart_sub_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_alternatives`
--
ALTER TABLE `topsis_alternatives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_alternatives_sub_criteria`
--
ALTER TABLE `topsis_alternatives_sub_criteria`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_criteria`
--
ALTER TABLE `topsis_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topsis_sub_criteria`
--
ALTER TABLE `topsis_sub_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_limit`
--
ALTER TABLE `users_limit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_alternatives`
--
ALTER TABLE `wp_alternatives`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_alternatives_sub_criteria`
--
ALTER TABLE `wp_alternatives_sub_criteria`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_criteria`
--
ALTER TABLE `wp_criteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp_sub_criteria`
--
ALTER TABLE `wp_sub_criteria`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
