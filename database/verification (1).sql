-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 04:42 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verification`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `parent_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@example.com', 'superadmin', 1, NULL, '$2y$10$Z4T4EXCB3Y/cqIo0q.E2EOFTZ07/H1LRrGD05WEG5YVS0sT6CGPtW', NULL, '2024-08-04 07:03:10', '2024-08-04 07:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `application_types`
--

CREATE TABLE `application_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_types`
--

INSERT INTO `application_types` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Guranter', '1', 1, '2024-08-04 11:10:47', 1, '2024-08-04 11:10:47'),
(2, 'Seller', '1', 1, '2024-08-04 11:11:08', 1, '2024-08-04 11:11:08'),
(3, 'Applicant', '1', 1, '2024-08-04 11:11:46', 1, '2024-08-04 11:11:46'),
(4, 'Co-Applicant', '1', 1, '2024-08-04 11:11:46', 1, '2024-08-04 11:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `branch_code`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'SBI', 'sbi Noida', '0', 1, '2024-08-04 07:04:03', 1, '2024-08-04 07:04:03'),
(2, 'HDFC', 'HDFC Noida', '0', 1, '2024-08-04 07:04:25', 1, '2024-08-04 07:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `bank_product_mappings`
--

CREATE TABLE `bank_product_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_product_mappings`
--

INSERT INTO `bank_product_mappings` (`id`, `bank_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-04 07:04:03', '2024-08-04 07:04:03'),
(2, 1, 2, '2024-08-04 07:04:03', '2024-08-04 07:04:03'),
(3, 1, 3, '2024-08-04 07:04:03', '2024-08-04 07:04:03'),
(4, 1, 4, '2024-08-04 07:04:03', '2024-08-04 07:04:03'),
(5, 1, 5, '2024-08-04 07:04:03', '2024-08-04 07:04:03'),
(6, 2, 1, '2024-08-04 07:04:25', '2024-08-04 07:04:25'),
(7, 2, 2, '2024-08-04 07:04:25', '2024-08-04 07:04:25'),
(8, 2, 3, '2024-08-04 07:04:25', '2024-08-04 07:04:25'),
(9, 2, 4, '2024-08-04 07:04:25', '2024-08-04 07:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `refrence_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `vehicle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `co_applicant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guarantee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_limit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tat_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `application_type`, `bank_id`, `product_id`, `refrence_number`, `status`, `applicant_name`, `amount`, `vehicle`, `co_applicant_name`, `guarantee_name`, `geo_limit`, `tat_time`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 1, 'EP01010', '1', 'Susheel Sahoo', 100000.00, 'Honda', 'Joyti Sahu', 'Ankit Sahu', 'Local', '00:35', 'Test Remark', 1, 1, '2024-08-04 07:12:37', '2024-08-04 07:12:37'),
(2, '1', 1, 1, 'EP01010', '1', 'Susheel Sahoo', 100000.00, 'Honda', 'Joyti Sahu', 'Ankit Sahu', 'Local', '00:35', 'Test Remark', 1, 1, '2024-08-04 07:14:02', '2024-08-04 07:14:02'),
(3, '1', 1, 1, 'EP01010', '1', 'Susheel Sahoo', 100000.00, 'Honda', 'Joyti Sahu', 'Ankit Sahu', 'Local', '00:35', 'Test Remark', 1, 1, '2024-08-04 07:15:00', '2024-08-04 07:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `cases_fi_types`
--

CREATE TABLE `cases_fi_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `fi_type_id` int(11) NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` int(11) NOT NULL,
  `land_mark` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases_fi_types`
--

INSERT INTO `cases_fi_types` (`id`, `case_id`, `fi_type_id`, `mobile`, `address`, `pincode`, `land_mark`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '9876543211', 'Address1', 2013011, 'Landmark1', 1, '2024-08-04 07:15:00', '2024-08-04 07:15:00'),
(2, 3, 2, '9876543212', 'Address2', 2013012, 'Landmark2', 1, '2024-08-04 07:15:00', '2024-08-04 07:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fi_types`
--

CREATE TABLE `fi_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fi_types`
--

INSERT INTO `fi_types` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'RV', '1', 1, '2024-08-04 07:03:20', 1, '2024-08-04 07:03:20'),
(2, 'BV', '1', 1, '2024-08-04 07:03:20', 1, '2024-08-04 07:03:20'),
(3, 'TV', '1', 1, '2024-08-04 07:03:20', 1, '2024-08-04 07:03:20'),
(4, 'PV', '1', 1, '2024-08-04 07:03:20', 1, '2024-08-04 07:03:20'),
(5, 'upload.xlsx', '0', 1, '2024-08-07 00:40:29', 1, '2024-08-07 00:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(66, '2014_10_12_000000_create_fi_type_table', 1),
(67, '2014_10_12_000000_create_users_table', 1),
(68, '2014_10_12_100000_create_password_resets_table', 1),
(69, '2019_08_19_000000_create_failed_jobs_table', 1),
(70, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(71, '2020_07_24_184706_create_permission_tables', 1),
(72, '2020_09_12_043205_create_admins_table', 1),
(73, '2024_07_21_063128_create_products_table', 1),
(74, '2024_07_21_065533_create_banks_table', 1),
(75, '2024_07_22_031455_create_bank_product_mappings_table', 1),
(76, '2024_07_28_095400_create_application_type', 1),
(77, '2024_08_04_103747_create_cases_table', 1),
(78, '2024_08_04_103903_create_cases_fi_types_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard.view', 'admin', 'dashboard', '2024-08-04 07:03:11', '2024-08-04 07:03:11'),
(2, 'dashboard.edit', 'admin', 'dashboard', '2024-08-04 07:03:11', '2024-08-04 07:03:11'),
(3, 'case.create', 'admin', 'case', '2024-08-04 07:03:11', '2024-08-04 07:03:11'),
(4, 'case.view', 'admin', 'case', '2024-08-04 07:03:12', '2024-08-04 07:03:12'),
(5, 'case.edit', 'admin', 'case', '2024-08-04 07:03:12', '2024-08-04 07:03:12'),
(6, 'case.delete', 'admin', 'case', '2024-08-04 07:03:12', '2024-08-04 07:03:12'),
(7, 'case.approve', 'admin', 'case', '2024-08-04 07:03:13', '2024-08-04 07:03:13'),
(8, 'report.create', 'admin', 'report', '2024-08-04 07:03:13', '2024-08-04 07:03:13'),
(9, 'report.view', 'admin', 'report', '2024-08-04 07:03:13', '2024-08-04 07:03:13'),
(10, 'report.edit', 'admin', 'report', '2024-08-04 07:03:14', '2024-08-04 07:03:14'),
(11, 'report.delete', 'admin', 'report', '2024-08-04 07:03:14', '2024-08-04 07:03:14'),
(12, 'bank.create', 'admin', 'bank', '2024-08-04 07:03:14', '2024-08-04 07:03:14'),
(13, 'bank.view', 'admin', 'bank', '2024-08-04 07:03:14', '2024-08-04 07:03:14'),
(14, 'bank.edit', 'admin', 'bank', '2024-08-04 07:03:14', '2024-08-04 07:03:14'),
(15, 'bank.delete', 'admin', 'bank', '2024-08-04 07:03:15', '2024-08-04 07:03:15'),
(16, 'product.create', 'admin', 'product', '2024-08-04 07:03:15', '2024-08-04 07:03:15'),
(17, 'product.view', 'admin', 'product', '2024-08-04 07:03:15', '2024-08-04 07:03:15'),
(18, 'product.edit', 'admin', 'product', '2024-08-04 07:03:15', '2024-08-04 07:03:15'),
(19, 'product.delete', 'admin', 'product', '2024-08-04 07:03:16', '2024-08-04 07:03:16'),
(20, 'fitype.create', 'admin', 'fitype', '2024-08-04 07:03:16', '2024-08-04 07:03:16'),
(21, 'fitype.view', 'admin', 'fitype', '2024-08-04 07:03:16', '2024-08-04 07:03:16'),
(22, 'fitype.edit', 'admin', 'fitype', '2024-08-04 07:03:16', '2024-08-04 07:03:16'),
(23, 'fitype.delete', 'admin', 'fitype', '2024-08-04 07:03:16', '2024-08-04 07:03:16'),
(24, 'admin.create', 'admin', 'admin', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(25, 'admin.view', 'admin', 'admin', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(26, 'admin.edit', 'admin', 'admin', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(27, 'admin.delete', 'admin', 'admin', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(28, 'admin.approve', 'admin', 'admin', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(29, 'user.create', 'admin', 'user', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(30, 'user.view', 'admin', 'user', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(31, 'user.edit', 'admin', 'user', '2024-08-04 07:03:17', '2024-08-04 07:03:17'),
(32, 'user.delete', 'admin', 'user', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(33, 'user.approve', 'admin', 'user', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(34, 'role.create', 'admin', 'role', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(35, 'role.view', 'admin', 'role', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(36, 'role.edit', 'admin', 'role', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(37, 'role.delete', 'admin', 'role', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(38, 'role.approve', 'admin', 'role', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(39, 'profile.view', 'admin', 'profile', '2024-08-04 07:03:18', '2024-08-04 07:03:18'),
(40, 'profile.edit', 'admin', 'profile', '2024-08-04 07:03:19', '2024-08-04 07:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `product_code`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Personal Loan', 'PL', '1', 1, '2024-08-04 07:03:19', 1, '2024-08-04 07:03:19'),
(2, 'Home Loan', 'HL', '1', 1, '2024-08-04 07:03:19', 1, '2024-08-04 07:03:19'),
(3, 'Auto Loan', 'AL', '1', 1, '2024-08-04 07:03:19', 1, '2024-08-04 07:03:19'),
(4, 'BSV', 'BSV', '1', 1, '2024-08-04 07:03:19', 1, '2024-08-04 07:03:19'),
(5, 'ITR', 'ITR', '1', 1, '2024-08-04 07:03:19', 1, '2024-08-04 07:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'admin', '2024-08-04 07:03:11', '2024-08-04 07:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin_id`, `name`, `email`, `email_verified_at`, `password`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Maniruzzaman Akash', 'manirujjamanakash@gmail.com', NULL, '$2y$10$pBJ2FwhrvPHp4S933wc9uOBuSQQ0UhpRxzpwNEhkmPJQnf09l989.', 'aaad4807161d8a153de6ea716ff29a6fc975c2e690a735a29926989404ef', NULL, '2024-08-04 07:03:10', '2024-08-07 02:05:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `application_types`
--
ALTER TABLE `application_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_product_mappings`
--
ALTER TABLE `bank_product_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_product_mappings_bank_id_foreign` (`bank_id`),
  ADD KEY `bank_product_mappings_product_id_foreign` (`product_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases_fi_types`
--
ALTER TABLE `cases_fi_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cases_fi_types_case_id_foreign` (`case_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fi_types`
--
ALTER TABLE `fi_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_types`
--
ALTER TABLE `application_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_product_mappings`
--
ALTER TABLE `bank_product_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cases_fi_types`
--
ALTER TABLE `cases_fi_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fi_types`
--
ALTER TABLE `fi_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_product_mappings`
--
ALTER TABLE `bank_product_mappings`
  ADD CONSTRAINT `bank_product_mappings_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_product_mappings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cases_fi_types`
--
ALTER TABLE `cases_fi_types`
  ADD CONSTRAINT `cases_fi_types_case_id_foreign` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
