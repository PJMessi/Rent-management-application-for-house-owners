-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2019 at 08:50 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `renter`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_05_02_153005_add_photo_column_to_users_table', 2),
(4, '2019_05_03_150342_add_type_and_photo_column_to_users_table', 3),
(5, '2016_06_01_000001_create_oauth_auth_codes_table', 4),
(6, '2016_06_01_000002_create_oauth_access_tokens_table', 4),
(7, '2016_06_01_000003_create_oauth_refresh_tokens_table', 4),
(8, '2016_06_01_000004_create_oauth_clients_table', 4),
(9, '2016_06_01_000005_create_oauth_personal_access_clients_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'J4AAvAqEqfBn0WpdTYLUhwN1NzU4t66eGKvH0CIS', 'http://localhost', 1, 0, 0, '2019-05-05 05:19:11', '2019-05-05 05:19:11'),
(2, NULL, 'Laravel Password Grant Client', '7DlpDt5al97b8aotf99t0wkCSOaJN5aZc04QfDDj', 'http://localhost', 0, 1, 0, '2019-05-05 05:19:11', '2019-05-05 05:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-05-05 05:19:11', '2019-05-05 05:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `t_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_join` date NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `l_name`, `phone_1`, `phone_2`, `p_address`, `t_address`, `date_of_birth`, `date_of_join`, `email`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(3, 'Prajwal', 'Shrestha', '9843471707', NULL, 'Swoyambhu, Kathmandu', 'Swoyambhu, Kathmandu', '1998-07-02', '2015-01-01', 'pjmessi25@gmail.com', NULL, '$2y$10$oMaCrBuq.JZbdNFGPsvcB.tHDuYlDlO7o4E7C.iYfJ3RvO.GH3N46', '1557109106.png', NULL, '2019-05-02 07:00:46', '2019-05-05 20:33:27', 'admin'),
(4, 'Anisha', 'Maharjan', '9843471707', NULL, 'Thulo Bharyang, Kathmandu', 'Thulo Bharyang, Kathmandu', '1997-11-15', '2015-01-01', 'anishamaharjan4@gmail.com', NULL, '$2y$10$WghWlS4Ei2bZKRePKiZyZesOSlN2nRez5IMRzSGPkhpxIn9zBKd8K', NULL, NULL, '2019-05-02 11:27:21', '2019-05-04 00:55:51', 'renter'),
(5, 'Angel', 'Shrestha', '9876543210', NULL, 'Swoyambhu, Kathmandu', 'Swoyambhu, Kathmandu', '2012-05-01', '2017-05-23', 'angelshrestha@gmail.com', NULL, 'angelshrestha', NULL, NULL, '2019-05-03 08:28:05', '2019-05-03 08:28:05', 'renter'),
(6, 'Mina', 'Maharjan', '9849223395', NULL, 'Swoyambhu, Kathmandu', 'Swoyambhu, Kathmandu', '1988-05-07', '2019-05-01', 'minaxshrestha@gmail.com', NULL, 'minashrestha', NULL, NULL, '2019-05-03 08:32:08', '2019-05-03 08:32:08', 'renter'),
(7, 'Pralhad', 'Shrestha', '9841399854', NULL, 'Swoyambhu, Kathmandu', 'Swoyambhu, Kathmandu', '1989-06-05', '2015-05-05', 'pralhadshrestha@gmail.com', NULL, 'pralhadshrestha', NULL, NULL, '2019-05-03 08:41:33', '2019-05-03 08:41:33', 'renter'),
(11, 'Ashok', 'Chhetri', '9860079333', NULL, 'Boratar, Kathmandu', 'Boratar, Kathmandu', '2017-06-04', '2018-06-04', 'ashokchhetri61@gmail.com', NULL, 'ashokchhetri', NULL, NULL, '2019-05-03 11:19:24', '2019-05-03 11:19:24', 'renter'),
(12, 'Wqea', 'Qwe', '9843471707', '9843471707', 'Fgh', 'Fgh', '2019-04-30', '2019-05-06', 'pjmessi10@outlook.com', NULL, '12345678', '1556988268.png', NULL, '2019-05-03 20:32:34', '2019-05-04 21:53:57', 'renter'),
(16, 'Harry', 'Potter', '9876543210', '9876543210', 'London', 'London', '2019-04-29', '2019-04-29', 'harrypotter10@gmail.com', NULL, '$2y$10$mGl8P7ekC9sAhoOmRZaOnulIGnp/PB6S.R.YKl6wSYwcXDeWvTGEy', NULL, NULL, '2019-05-06 00:46:06', '2019-05-06 00:46:06', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
