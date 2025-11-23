-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 23, 2025 at 08:46 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SkillHub`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `name`, `description`, `instructor`, `created_at`, `updated_at`) VALUES
(1, 'Desain Grafis', 'Kelas pengenalan dasar desain grafis menggunakan tools seperti Photoshop dan Illustrator.', 'Budi Santoso', '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(2, 'Pemrograman Dasar', 'Belajar dasar pemrograman menggunakan bahasa Python untuk pemula.', 'Ika Pratiwi', '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(3, 'Editing Video', 'Kelas editing video menggunakan Adobe Premiere dan teknik storytelling visual.', 'Rama Wijaya', '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(4, 'Public Speaking', 'Pelatihan public speaking, teknik bicara, dan management panggung untuk pemula.', 'Sinta Dewi', '2025-11-23 01:44:54', '2025-11-23 01:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_21_232711_create_users_table', 1),
(2, '2025_11_21_232724_create_kelas_table', 1),
(3, '2025_11_21_232825_create_pendaftaran_table', 1),
(4, '2025_11_21_234037_create_sessions_table', 1),
(5, '2025_11_22_000817_create_cache_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `user_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(2, 2, 2, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(3, 3, 3, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(4, 4, 1, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(5, 4, 2, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(6, 4, 3, '2025-11-23 01:44:54', '2025-11-23 01:44:54'),
(7, 4, 4, '2025-11-23 01:44:54', '2025-11-23 01:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','peserta') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peserta',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin SkillHub', 'admin@skillhub.com', '$2y$12$qQO2a4svNany1VXsHLeMfeJbnnuOPviYdmrM8U1Fn1h7eAV2LpKtG', 'admin', '2025-11-23 01:44:53', '2025-11-23 01:44:53'),
(2, 'Alif Rahman', 'alif.rahman@example.com', '$2y$12$9POh6pOZabk/de03ftjnueeOPJn2x8VrhEx4KWyToXqOMTVA0GLW.', 'peserta', '2025-11-23 01:44:53', '2025-11-23 01:44:53'),
(3, 'Nadia Putri', 'nadia.putri@example.com', '$2y$12$j/MOJN8zcnRGZIiV/thML.U6mDVeU1SKcyUzGv41bkItTg0poUsAS', 'peserta', '2025-11-23 01:44:53', '2025-11-23 01:44:53'),
(4, 'Rizky Pratama', 'rizky.pratama@example.com', '$2y$12$20aUgOCYqa4Eu44eba0/leGVQKcmXnr/o2R3.3nT3ztnF6yJO66Dy', 'peserta', '2025-11-23 01:44:53', '2025-11-23 01:44:53'),
(5, 'Sabrina Anggraini', 'sabrina.anggraini@example.com', '$2y$12$vNI1VkPVeR93xtHMI7gk2eoZGb9RLOjmwlnXzDGwznfHK73RHGA96', 'peserta', '2025-11-23 01:44:54', '2025-11-23 01:44:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_user_id_foreign` (`user_id`),
  ADD KEY `pendaftaran_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
