-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2023 at 10:43 AM
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
  `dss` enum('ahp','saw','wp') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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
  `id_criteria` int NOT NULL,
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
  `id_criteria` int NOT NULL,
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
