-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 01:15 PM
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
-- Database: `visdomrio`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `counselor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appoin-------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `ulid`, `name`, `status`, `created_at`, `updated_at`) VALUES
(6, '01jmesxcvsjxw73bdf6a49nh6n', 'English', 'Active', '2025-02-19 04:21:34', '2025-03-04 01:57:51'),
(8, '01jmesyg76svx696e6ssnr7nc2', 'Math', 'Active', '2025-02-19 04:22:10', '2025-03-04 01:58:12'),
(9, '01jng0wqq67nf6s3jw9h50qw0m', 'Science', 'Active', '2025-03-04 01:58:29', '2025-03-04 01:58:29'),
(10, '01jng0y3emh82g22p6g603bs24', 'Social Science', 'Active', '2025-03-04 01:59:14', '2025-03-04 02:28:14'),
(11, '01jng0yq11h5yxrcjspkrk366n', 'Foreign Language', 'Active', '2025-03-04 01:59:34', '2025-03-04 02:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `ulid`, `name`, `created_at`, `updated_at`) VALUES
(5, '01jmcevtk5k7wfqpwm8f6exk7d', 'Canada', '2025-02-18 06:30:00', '2025-02-18 07:02:39'),
(7, '01jmf3kyt1q7bceamkefqe6d2k', 'USA', '2025-02-19 07:11:11', '2025-02-19 07:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_scales`
--

CREATE TABLE `grade_scales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `min` int(10) UNSIGNED NOT NULL,
  `max` int(10) UNSIGNED NOT NULL,
  `grade_point` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_scales`
--

INSERT INTO `grade_scales` (`id`, `ulid`, `grade`, `min`, `max`, `grade_point`, `created_at`, `updated_at`, `school_id`) VALUES
(1, '01jmvtjcg35ecd4pwn0sgxs31y', 'A', 80, 100, 4, '2025-02-24 05:43:10', '2025-03-04 05:40:04', 11),
(2, '01jmvtjckpypctet7pvsm53940', 'B', 70, 79, 3, '2025-02-24 05:43:10', '2025-03-04 05:40:04', 11),
(10, '01jngdjf58ybvh9yxn0mqp69y9', 'C', 60, 69, 2, '2025-03-04 05:40:04', '2025-03-04 05:40:04', 11),
(11, '01jngdjf8ffvh1sabpqgd1md89', 'D', 50, 59, 1, '2025-03-04 05:40:04', '2025-03-04 05:40:04', 11),
(12, '01jngdjfck6fftxrfw5mmcnfb0', 'F', 0, 49, 0, '2025-03-04 05:40:04', '2025-03-04 05:41:06', 11),
(13, '01jngdym8rz78a7pzp99bmxddb', 'A', 90, 100, 4.4, '2025-03-04 05:46:42', '2025-03-04 05:46:42', 12),
(14, '01jngdyma8p3sasgs4jrj4kts4', 'B', 80, 89, 3.3, '2025-03-04 05:46:42', '2025-03-04 05:46:42', 12),
(15, '01jngdymb0f95wfbe7y2gpv79x', 'C', 70, 79, 2.2, '2025-03-04 05:46:42', '2025-03-04 05:46:42', 12),
(16, '01jngdymdw5kfnr7aksszd9thp', 'D', 65, 69, 1.1, '2025-03-04 05:46:43', '2025-03-04 05:46:43', 12),
(17, '01jngdymenykb9ngqps4mjz65q', 'F', 0, 64, 0, '2025-03-04 05:46:43', '2025-03-04 05:47:34', 12);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_31_104805_create_telescope_entries_table', 2),
(5, '2025_01_31_110341_create_permission_tables', 3),
(6, '2025_01_31_122445_add_display_name_table', 4),
(7, '2025_01_31_122854_create_permission_groups_table', 5),
(8, '2025_01_31_125549_add_display_name_name_table', 6),
(10, '2025_02_07_064559_add_address_table', 7),
(11, '2025_02_18_100003_create_countries_table', 8),
(12, '2025_02_18_103549_create_countries_table', 9),
(13, '2025_02_18_122617_create_states_table', 10),
(14, '2025_02_19_080546_create_categories_table', 11),
(15, '2025_02_20_054356_create_schools_table', 12),
(16, '2025_02_20_085644_create_school_classes_table', 13),
(17, '2025_02_20_110322_create_subjects_table', 14),
(18, '2025_02_24_102642_create_grade_scales_table', 15),
(19, '2025_02_25_072754_add_country_id_users_table', 16),
(20, '2025_02_28_092542_create_student_grades_table', 17),
(21, '2025_03_07_112340_create_personal_access_tokens_table', 18),
(23, '2025_03_21_064416_add_simpe_gpa_users_table', 19),
(24, '2025_04_16_075859_add_dob_users_table', 20),
(25, '2025_04_23_114905_add_time_duration_schools_table', 21),
(26, '2025_04_23_115158_create_student_counselors_table', 22),
(27, '2025_04_23_115301_create_appointments_table', 23),
(28, '2025_04_30_075327_add_notes_appointments_table', 24),
(29, '2025_05_26_091502_add_social_provider_users_table', 25);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 5),
(10, 'App\\Models\\User', 7),
(10, 'App\\Models\\User', 8),
(10, 'App\\Models\\User', 9),
(10, 'App\\Models\\User', 10),
(10, 'App\\Models\\User', 11),
(10, 'App\\Models\\User', 12),
(10, 'App\\Models\\User', 13),
(10, 'App\\Models\\User', 14),
(10, 'App\\Models\\User', 15),
(10, 'App\\Models\\User', 16),
(10, 'App\\Models\\User', 17),
(10, 'App\\Models\\User', 18),
(10, 'App\\Models\\User', 19),
(10, 'App\\Models\\User', 20),
(10, 'App\\Models\\User', 21),
(10, 'App\\Models\\User', 22),
(10, 'App\\Models\\User', 23),
(10, 'App\\Models\\User', 24),
(10, 'App\\Models\\User', 25),
(10, 'App\\Models\\User', 28),
(10, 'App\\Models\\User', 29),
(10, 'App\\Models\\User', 35),
(10, 'App\\Models\\User', 36),
(10, 'App\\Models\\User', 37),
(10, 'App\\Models\\User', 38),
(10, 'App\\Models\\User', 39),
(10, 'App\\Models\\User', 40),
(10, 'App\\Models\\User', 41),
(10, 'App\\Models\\User', 42),
(10, 'App\\Models\\User', 43),
(10, 'App\\Models\\User', 44),
(10, 'App\\Models\\User', 45),
(10, 'App\\Models\\User', 46),
(10, 'App\\Models\\User', 47),
(10, 'App\\Models\\User', 48),
(10, 'App\\Models\\User', 50),
(11, 'App\\Models\\User', 4),
(11, 'App\\Models\\User', 56),
(11, 'App\\Models\\User', 60),
(11, 'App\\Models\\User', 65),
(11, 'App\\Models\\User', 68),
(11, 'App\\Models\\User', 74),
(22, 'App\\Models\\User', 59),
(22, 'App\\Models\\User', 62),
(23, 'App\\Models\\User', 63),
(23, 'App\\Models\\User', 70),
(23, 'App\\Models\\User', 71),
(24, 'App\\Models\\User', 66),
(24, 'App\\Models\\User', 69);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('demo.seeders+dev@gmail.com', 'LcnaclnHD94TrkO9wulLt1a9aRJrvNQZvh1hKSbdIgdDsSzNTvyUKnPeBLyA5ADw', '2025-04-14 10:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `display_name`, `group_id`) VALUES
(1, 'role-list', 'web', '2025-01-31 07:41:00', '2025-01-31 07:41:00', 'List Role', 1),
(2, 'role-create', 'web', '2025-01-31 07:41:00', '2025-01-31 07:41:00', 'Create Role', 1),
(3, 'role-edit', 'web', '2025-01-31 07:41:01', '2025-01-31 07:41:01', 'Edit Role', 1),
(4, 'role-delete', 'web', '2025-01-31 07:41
-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Role Management', '2025-01-31 07:23:18', '2025-01-31 07:23:18'),
(2, 'User Management', '2025-01-31 07:23:19', '2025-01-31 07:23:19'),
(3, 'Permission Group', '2025-01-31 07:23:19', '2025-01-31 07:23:19'),
(8, 'Student Management', '2025-02-18 00:52:23', '2025-02-18 00:52:23'),
(9, 'Permission Management', '2025-02-18 03:46:17', '2025-02-18 03:46:17'),
(10, 'Country Management', '2025-02-19 03:56:23', '2025-02-19 03:56:23'),
(11, 'State Management', '2025-02-19 04:00:07', '2025-02-19 04:00:07'),
(12, 'Category Management', '2025-02-19 04:02:49', '2025-02-19 04:02:49'),
(13, 'Schoool Management', '2025-02-20 00:40:05', '2025-02-20 00:40:05'),
(14, 'Class Management', '2025-02-20 04:28:12', '2025-02-20 04:28:12'),
(15, 'Subject Management', '2025-02-21 03:30:34', '2025-02-21 03:30:34'),
(16, 'School User Management', '2025-03-11 07:54:08', '2025-04-15 07:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(ULL, '2025-06-16 11:58:08', '2025-06-16 11:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `display_name`) VALUES
(9, 'developer', 'web', '2025-02-03 00:25:10', '2025-02-03 00:25:10', 'Developer'),
(10, 'superAdmin', 'web', '2025-02-03 00:25:10', '2025-02-03 00:25:10', 'Super Admin'),
(11, 'student', 'web', '2025-02-03 00:25:10', '2025-02-03 00:25:10', 'Student'),
(22, 'admin', 'web', '2025-02-18 01:32:52', '2025-02-18 01:32:52', 'Admin'),
(23, 'counsellor', 'web', '2025-03-11 07:52:00', '2025-04-15 06:06:09', 'Counsellor'),
(24, 'schoolAdmin', 'web', '2025-04-15 06:07:47', '2025-04-15 06:07:47', 'School Admin');

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
(1, 9),
(1, 22),
(2, 9),
(2, 22),
(3, 9),
(3, 22),
(4, 9),
(4, 22),
(5, 9),
(5, 10),
(6, 9),
(6, 10),
(7, 9),
(7, 10),
(8, 9),
(8, 10),
(9, 9),
(9, 10),
(9, 22),
(9, 23),
(9, 24),
(10, 9),
(10, 10),
(10, 22),
(10, 24),
(11, 9),
(11, 10),
(11, 22),
(11, 23),
(11, 24),
(12, 9),
(12, 10),
(12, 22),
(12, 24),
(13, 9),
(13, 22),
(14, 9),
(14, 22),
(15, 9),
(15, 22),
(16, 9),
(16, 22),
(17, 9),
(17, 22),
(18, 9),
(18, 22),
(19, 9),
(19, 22),
(20, 9),
(20, 22),
(21, 9),
(21, 10),
(21, 22),
(22, 9),
(22, 10),
(22, 22),
(23, 9),
(23, 10),
(23, 22),
(24, 9),
(24, 10),
(24, 22),
(25, 9),
(25, 10),
(25, 22),
(26, 9),
(26, 10),
(26, 22),
(27, 9),
(27, 10),
(27, 22),
(28, 9),
(28, 10),
(28, 22),
(29, 9),
(30, 9),
(31, 9),
(32, 9),
(33, 9),
(33, 10),
(33, 22),
(34, 9),
(34, 10),
(34, 22),
(35, 9),
(35, 10),
(35, 22),
(35, 23),
(35, 24),
(36, 9),
(36, 10),
(36, 22),
(37, 9),
(37, 10),
(37, 22),
(37, 23),
(37, 24),
(38, 9),
(38, 10),
(38, 22),
(38, 23),
(38, 24),
(39, 9),
(39, 10),
(39, 22),
(39, 23),
(39, 24),
(40, 9),
(40, 10),
(40, 22),
(40, 23),
(40, 24),
(41, 9),
(41, 10),
(41, 22),
(41, 23),
(41, 24),
(42, 9),
(42, 10),
(42, 22),
(42, 23),
(42, 24),
(43, 9),
(43, 10),
(43, 22),
(43, 23),
(43, 24),
(44, 9),
(44, 10),
(44, 22),
(44, 23),
(44, 24),
(45, 9),
(45, 10),
(45, 22),
(45, 24),
(46, 9),
(46, 10),
(46, 22),
(46, 24),
(47, 9),
(47, 10),
(47, 22),
(47, 24),
(48, 9),
(48, 10),
(48, 22),
(48, 24);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `time_duration` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `ulid`, `state_id`, `name`, `created_at`, `updated_at`, `time_duration`) VALUES
(11, '01jmvtjcdnzbcd9gb113j11afg', 5, 'Canada Test School', '2025-02-24 05:43:10', '2025-04-23 11:50:26', 15),
(12, '01jngdym74w7qkz1vea6wtc57f', 8, 'Kenmore East Senior HS', '2025-03-04 05:46:42', '2025-04-23 11:50:37', 20);

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `ulid`, `name`, `created_at`, `updated_at`, `school_id`) VALUES
(7, '01jmxs9ssrdsyxtevfz7ccz3z3', '10', '2025-02-24 23:59:29', '2025-02-24 23:59:29', 11),
(8, '01jngncayvded7t0awa67rr4m1', '8', '2025-03-04 07:56:32', '2025-03-04 07:56:32', 11),
(9, '01jngncq4tmwmmpdg9ghg5xj4n', '11', '2025-03-04 07:56:44', '2025-03-04 07:56:44', 11),
(10, '01jnnf17x76d74r2xhtm49tnd3', '9', '2025-03-06 04:41:49', '2025-03-06 04:41:49', 12),
(11, '01jnnf1t6efb21j4yyvk6emwxe', '7', '2025-03-06 04:42:08', '2025-03-06 04:42:08', 12),
(12, '01jnnf27xfgpgb8864m5gdb3k5', '6', '2025-03-06 04:42:22', '2025-03-06 04:42:22', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qptGOJRBggzQsZKM4RSQWVeqwDgiavXLaghxvWNb', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTThteVBRSUtPbkZnVGh6OTVwOERQUWFZNW9vd0ZOQmk3RjZpWFM1UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdHVkZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1762927473);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `ulid`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(5, '01jmcj6jgvcqcxwd5t5e5r2e0z', 5, 'Ontario', '2025-02-18 07:28:18', '2025-03-04 00:15:12'),
(8, '01jmf3mmxvgmmvxrddvhb5e63a', 7, 'California', '2025-02-19 07:11:33', '2025-03-04 00:17:04'),
(9, '01jmkewhxs5s5jejzt2ymsw9z2', 5, 'Nunavut', '2025-02-20 23:45:05', '2025-03-04 00:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `student_counselors`
--

CREATE TABLE `student_counselors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `counselor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_counselors`
--

INSERT INTO `student_counselors` (`id`, `ulid`, `student_id`, `counselor_id`, `created_at`, `updated_at`) VALUES
(13, '01JSXXYAFKSH9T3R81RVCJ53TX', 65, 63, '2025-04-28 10:09:05', '2025-04-28 10:09:05'),
(17, '01JSXYEA80GY82PKJKXYT3F4FP', 56, 71, '2025-04-28 10:17:49', '2025-04-28 10:17:49'),
(18, '01JSXYW72K06ZFC2C6D4DCYQCE', 4, 63, '2025-04-28 10:25:24', '2025-04-28 10:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `ulid`, `created_at`, `updated_at`, `student_id`, `subject_id`, `class_id`, `grade_id`) VALUES
(66, '01jngne2ew5rckexrgvngs5css', '2025-03-04 07:57:28', '2025-03-04 07:57:28', 56, 13, 7, 1),
(67, '01jngne2gnnp8y520nmpjw860c', '2025-03-04 07:57:29', '2025-03-04 07:57:29', 56, 14, 7, 2),
(68, '01jngne2p4gj1ht1tepvvdg14x', '2025-03-04 07:57:29', '2025-03-04 07:57:29', 56, 15, 9, 11),
(100, '01jx9s29ddtx51apvdv2d7e5b6', '2025-06-09 07:21:50', '2025-06-09 07:21:50', 65, 13, 7, 2),
(107, '01jxsdzsqs980n5p1zrjn428sy', '2025-06-15 09:16:05', '2025-06-15 09:16:05', 74, 14, 7, 2),
(117, '01jxvn2q67a3t7ejfmtgy1q296', '2025-06-16 05:58:30', '2025-06-16 05:58:30', 4, 13, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `name` varchar(255) NOT NULL,
  `credit_type` enum('Full_Credit','Half_Credit') NOT NULL DEFAULT 'Full_Credit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `ulid`, `name`, `credit_type`, `created_at`, `updated_at`, `school_id`, `category_id`) VALUES
(11, '01jngeqmv3pfnjqr17kx4hze1x', 'French 1', 'Full_Credit', '2025-03-04 06:00:22', '2025-03-04 07:31:39', 12, 11),
(13, '01jngnag7maeetzwex78f3ed6h', 'Maths', 'Half_Credit', '2025-03-04 07:55:32', '2025-03-05 07:57:34', 11, 8),
(14, '01jngnb4pbx4ds1kehkncaq2qb', 'English', 'Half_Credit', '2025-03-04 07:55:52', '2025-03-05 07:36:20', 11, 6),
(15, '01jngnbrd1vhvjbyn03bkjhkxk', 'Science', 'Full_Credit', '2025-03-04 07:56:13', '2025-03-05 23:57:41', 11, NULL),
(22, '01jnnf32bx1n8xvefwjydkzpsr', 'English 1', 'Full_Credit', '2025-03-06 04:42:49', '2025-03-06 06:54:10', 12, 6),
(23, '01jnnf3gktvyms99ep5b92xsr3', 'English 2', 'Full_Credit', '2025-03-06 04:43:03', '2025-03-06 06:54:26', 12, 6),
(24, '01jnnf46fjep25kc6cv85gwykn', 'English 4', 'Full_Credit', '2025-03-06 04:43:26', '2025-03-06 04:48:54', 12, 6),
(25, '01jnnf529sskkh0h4t6bamye01', 'English 3', 'Full_Credit', '2025-03-06 04:43:54', '2025-03-06 04:48:31', 12, 6),
(26, '01jnnf67pht28wbn0bp8rxrfmn', 'Maths1', 'Full_Credit', '2025-03-06 04:44:32', '2025-03-06 04:44:32', 12, 8),
(27, '01jnnf6sbng8y4trfsbzszwdbz', 'Maths2', 'Full_Credit', '2025-03-06 04:44:50', '2025-03-06 04:44:50', 12, 8),
(28, '01jnnf7ktz61m1yf9kcp1x343c', 'Maths3', 'Full_Credit', '2025-03-06 04:45:18', '2025-03-06 04:45:18', 12, 8),
(29, '01jnnf8857jsyctzjxgs16w2ck', 'Science1', 'Full_Credit', '2025-03-06 04:45:38', '2025-03-06 04:45:38', 12, 9),
(30, '01jnnf8nftcz9hx1btvax6kzd2', 'Science2', 'Full_Credit', '2025-03-06 04:45:52', '2025-03-06 04:45:52', 12, 9),
(31, '01jnnf9k0cazcr12h3aa5m856x', 'Social Science1', 'Full_Credit', '2025-03-06 04:46:22', '2025-03-06 04:46:22', 12, 10),
(32, '01jnnf9z3xc9m50z9wv1mz0v9b', 'Social Science2', 'Full_Credit', '2025-03-06 04:46:35', '2025-03-06 04:46:35', 12, 10),
(33, '01jnnfavd76zcagywfp0hsnw65', 'Foreign Language1', 'Full_Credit', '2025-03-06 04:47:04', '2025-03-06 04:47:04', 12, 11),
(34, '01jnnfb9paa35p9gmq08j2gjyk', 'Foreign Language2', 'Full_Credit', '2025-03-06 04:47:18', '2025-03-06 04:47:18', 12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `telescope_entries`
-

-- --------------------------------------------------------

--
-- Table structure for table `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ulid` char(26) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `google_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facebook_id` bigint(20) UNSIGNED DEFAULT NULL,
  `apple_id` bigint(20) UNSIGNED DEFAULT NULL,
  `div1_eligibility` tinyint(1) DEFAULT 0,
  `div1_required_credits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`div1_required_credits`)),
  `div2_eligibility` tinyint(1) DEFAULT 0,
  `div2_required_credits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`div2_required_credits`)),
  `simple_gpa` double DEFAULT NULL,
  `core_gpa` double DEFAULT NULL,
  `weighted_gpa` double DEFAULT NULL,
  `carrer_goal` varchar(255) DEFAULT NULL,
  `interest` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `social_provider` varchar(255) DEFAULT NULL,
  `social_provider_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ulid`, `first_name`, `last_name`, `email`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `address_line_1`, `address_line_2`, `city`, `state`, `pincode`, `country`, `avatar`, `school_id`, `google_id`, `facebook_id`, `apple_id`, `div1_eligibility`, `div1_required_credits`, `div2_eligibility`, `div2_required_credits`, `simple_gpa`, `core_gpa`, `weighted_gpa`, `carrer_goal`, `interest`, `dob`, `social_provider`, `social_provider_id`) VALUES
(1, '01JK560Z8AZS05DNQ59XKSSZMN', 'Visdomr', 'Dev', 'demo.seeders+dev@gmail.com', 'Active', NULL, '$2y$12$kAKsOsCuXdwBBOIDl0TiyemdfwVB2tnslquSdbiHSY0e1UUAmILZa', NULL, '2025-02-03 00:25:08', '2025-04-14 10:13:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fpqtGuSzL2j9XpTBliO48X2a7JDO6c7Id5PbtpA4.jpg', NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '01JKAG8QP97MY0T5BQA1V3S8N3', 'test', 'Demo', 'test.stude12@gmail.com', 'Active', NULL, '$2y$12$RZGWNanNu7yzi74j3pE6gukUpaUR7agYg3Oi0gbrOyGZiFtfHPEHC', NULL, '2025-02-05 02:00:21', '2025-06-16 06:53:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'JscyEpZx92BYNVpoOCh36Ok8pvhJ7G0ezIUrAu7E.jpg', 11, NULL, NULL, NULL, 0, '{\"Math\": 2.5, \"English\": 4, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 0, '{\"Math\": 2.5, \"English\": 4, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 4, 4, 4, NULL, NULL, '2006-05-24', 'google', 1),
(5, '01jkqq70tnm0bwj2jhqvcprzk2', 'Demo', 'Seeders', 'visdomrio@gmail.com', 'Active', NULL, '$2y$12$/WyhPYpzMMM3quaw.tJqYuJDI2vvMCm6gYvL4A6n.mjPmaid1I2AS', NULL, '2025-02-10 05:11:52', '2025-04-09 10:47:01', '(905) 878-2725', NULL, NULL, 'Halton Hill', 'Ontario', NULL, NULL, '', NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '01jm9rw16416h18ebtv5n7np6q', 'Hazen', 'Audel', 'hazen12@gmail.com', 'Active', NULL, '$2y$12$wTlbY13WF.p/5q803v8ltOuNRF6lHjxnWwfteYoxl9JrFn0.RXv7C', NULL, '2025-02-17 05:27:09', '2025-06-10 06:20:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ZvVEkq3T0SwkC9nxkluI3SfEkGYnbb61ZQqYfVjg.jpg', 11, NULL, NULL, NULL, 0, '{\"Math\": 2.5, \"English\": 3.5, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 0, '{\"Math\": 2.5, \"English\": 3.5, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 2.67, 3.5, 2.25, NULL, NULL, NULL, NULL, NULL),
(59, '01jnftww5mwbdv1xv4y5jpmhk1', 'Demo', 'Seeders', 'demo.admin@gmail.com', 'Active', NULL, '$2y$12$wnS8m1caBGAq2csJiQDyUevfq35Lv9fPCSIEY7aeMXKlVNqGcn1FW', NULL, '2025-03-04 00:13:42', '2025-03-04 00:13:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '01jnqhhrfsjjphg7xkc0qrmyks', 'Maximus', 'Konopelski', 'maximus@gmail.com', 'Active', NULL, '$2y$12$BFFsAZUUiMsDY1K5jtD6juT95lKoynhX8rKIlaTTbFgsIVewHaApO', NULL, '2025-03-07 00:04:16', '2025-06-10 06:56:11', NULL, '952 25 Hwy', '9528 15 Hwy', 'Halton Hills', 'Ontario', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, 'dev,tesrt', 'books,movies', '2012-02-08', NULL, NULL),
(62, '01jp01y2etwpz7eb5evncx8wke', 'test', 'demos', 'testsd@gmail.com', 'Active', NULL, '$2y$12$QZaLuhIkzW1yM8gJpPjvQur7QiwzXkzEziqnmGZgkNtoQGsXJVmWa', NULL, '2025-03-10 12:54:32', '2025-03-10 12:54:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '01jp2cvyjd8dj8wvt52ycsr1cn', 'counselor', 'Testt', 'demo.seeders+couns@gmail.com', 'Active', NULL, '$2y$12$Np3b9N11e/QMSY0DdPWeN.RfuAIWrzZTp2Qz6YxG2cczdW/t3Kdim', NULL, '2025-03-11 10:44:06', '2025-04-15 07:33:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a5bph5GTXeBpEY9vBYpP9fn3QpTjZ54mdPKeUUoc.jpg', 11, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, '01jp2gf7df06gr82spxsd1vxpc', 'Mike', 'Young', 'demo.seeders+my@gmail.com', 'Active', NULL, '$2y$12$lF6GPmDQixj5cKH.q2REMeKOmhQ52Ull2g/vL4W8v7Y9RVK/rGDcC', NULL, '2025-03-11 11:47:03', '2025-06-10 06:21:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, NULL, 0, '{\"Math\": 2.5, \"English\": 4, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 0, '{\"Math\": 2.5, \"English\": 4, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 3, 3, 3, NULL, NULL, NULL, NULL, NULL),
(66, '01jrw5xxbb79e0ee9atcztfdqw', 'Test', 'Admin', 'demo.seeders+sa@gmail.com', 'Active', NULL, '$2y$12$6XIgObDR3J/UhC1EZtJzbOg96LgW6A.kb6DVVUzvRKRr2LHHQet6i', NULL, '2025-04-15 07:34:29', '2025-04-15 07:45:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '01jryt8r4hyjfwnhxt4mked1gn', 'test', 'teseer', 'test1@gmail.com', 'Active', NULL, '$2y$12$82UB51/QKwyfYCr7tqgRtO9snVV7Hm2hiVHr9PR9wF.Ley.o/bf6W', NULL, '2025-04-16 08:08:24', '2025-06-15 07:00:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, 'dev,tesrt', 'books,movies', '2014-06-04', NULL, NULL),
(69, '01jryysa31x66rtebq1jgea01f', 'Demos', 'Test', 'demo.seeders+sa2@gmail.com', 'Active', NULL, '$2y$12$5ciuOrB4e303dMiSxXJaU.83mODZTf/fsI5DTI4YLwQxeGMrN4Dki', NULL, '2025-04-16 09:27:21', '2025-04-16 09:29:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, '01jshb2z3m0dfnhan5tj9dfpwy', 'test', 'Test', 'test12@gmail.com', 'Active', NULL, '$2y$12$UivaOGVBmEtfUtBjjZTt4uEAjRejyx51EP.Ph4SKU/W/tc/2PeXvm', NULL, '2025-04-23 12:48:41', '2025-04-23 12:48:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '01jsxxkwfy1vh0069db8n236wd', 'Demo', 'Test', 'test121@gmail.com', 'Active', NULL, '$2y$12$rIIpt3Lh8RPJm3jrEoSFx.00Af9uuODVfqIxSeK1vR.5F3iRRrN3C', NULL, '2025-04-28 10:03:23', '2025-04-28 10:03:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, '01jtmrm5sb5848rjpw5f01s6jb', 'John', 'Test', 'john12@gmail.com', 'Active', NULL, '$2y$12$Lccx/hVf4BM/.HwYibu/eOZjcR6Smws5TURsCoGVfiNS3FE8c68qi', NULL, '2025-05-07 06:58:41', '2025-06-15 09:16:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL, NULL, 0, '{\"Math\": 3, \"English\": 3.5, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 0, '{\"Math\": 3, \"English\": 3.5, \"Science\": 2, \"Social Science\": 2, \"Foreign Lanaguage\": 2}', 3, 3, 3, NULL, NULL, '2012-02-09', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_counselor_id_foreign` (`counselor_id`),
  ADD KEY `appointments_student_id_foreign` (`student_id`),
  ADD KEY `appointments_ulid_index` (`ulid`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_ulid_index` (`ulid`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_ulid_index` (`ulid`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grade_scales`
--
ALTER TABLE `grade_scales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_scales_school_id_foreign` (`school_id`),
  ADD KEY `grade_scales_ulid_index` (`ulid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_group_id_foreign` (`group_id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_groups_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schools_state_id_foreign` (`state_id`),
  ADD KEY `schools_ulid_index` (`ulid`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_classes_school_id_foreign` (`school_id`),
  ADD KEY `school_classes_ulid_index` (`ulid`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`),
  ADD KEY `states_ulid_index` (`ulid`);

--
-- Indexes for table `student_counselors`
--
ALTER TABLE `student_counselors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_students_counselors_student_id_foreign` (`student_id`),
  ADD KEY `assign_students_counselors_ulid_index` (`ulid`),
  ADD KEY `counselor_id` (`counselor_id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_grades_student_id_foreign` (`student_id`),
  ADD KEY `student_grades_subject_id_foreign` (`subject_id`),
  ADD KEY `student_grades_class_id_foreign` (`class_id`),
  ADD KEY `student_grades_grade_id_foreign` (`grade_id`),
  ADD KEY `student_grades_ulid_index` (`ulid`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_school_id_foreign` (`school_id`),
  ADD KEY `subjects_category_id_foreign` (`category_id`),
  ADD KEY `subjects_ulid_index` (`ulid`);

--
-- Indexes for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indexes for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD PRIMARY KEY (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indexes for table `telescope_monitoring`
--
ALTER TABLE `telescope_monitoring`
  ADD PRIMARY KEY (`tag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_ulid_unique` (`ulid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_scales`
--
ALTER TABLE `grade_scales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student_counselors`
--
ALTER TABLE `student_counselors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434876;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_counselor_id_foreign` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_scales`
--
ALTER TABLE `grade_scales`
  ADD CONSTRAINT `grade_scales_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `permission_groups` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD CONSTRAINT `school_classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_counselors`
--
ALTER TABLE `student_counselors`
  ADD CONSTRAINT `assign_students_counselors_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_counselors_ibfk_1` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_grades_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_scales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
