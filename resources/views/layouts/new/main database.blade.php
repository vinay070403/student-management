-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 02:12 PM
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
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
`key` varchar(255) NOT NULL,
`value` mediumtext NOT NULL,
`expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache',
'a:3:{s:5:\"alias\";a:6:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:8:\"group_id\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:12:\"display_name\";s:1:\"e\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:32:{i:0;a:6:{s:1:\"a\";i:1;s:1:\"b\";i:1;s:1:\"c\";s:9:\"user-list\";s:1:\"d\";s:9:\"User
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:6:{s:1:\"a\";i:2;s:1:\"b\";i:1;s:1:\"c\";s:11:\"user-create\";s:1:\"d\";s:11:\"User
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:6:{s:1:\"a\";i:3;s:1:\"b\";i:1;s:1:\"c\";s:9:\"user-edit\";s:1:\"d\";s:9:\"User
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:6:{s:1:\"a\";i:4;s:1:\"b\";i:1;s:1:\"c\";s:11:\"user-delete\";s:1:\"d\";s:11:\"User
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:6:{s:1:\"a\";i:5;s:1:\"b\";i:2;s:1:\"c\";s:12:\"country-list\";s:1:\"d\";s:12:\"Country
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:6:{s:1:\"a\";i:6;s:1:\"b\";i:2;s:1:\"c\";s:14:\"country-create\";s:1:\"d\";s:14:\"Country
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:6:{s:1:\"a\";i:7;s:1:\"b\";i:2;s:1:\"c\";s:12:\"country-edit\";s:1:\"d\";s:12:\"Country
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:6:{s:1:\"a\";i:8;s:1:\"b\";i:2;s:1:\"c\";s:14:\"country-delete\";s:1:\"d\";s:14:\"Country
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:6:{s:1:\"a\";i:9;s:1:\"b\";i:3;s:1:\"c\";s:10:\"state-list\";s:1:\"d\";s:10:\"State
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:6:{s:1:\"a\";i:10;s:1:\"b\";i:3;s:1:\"c\";s:12:\"state-create\";s:1:\"d\";s:12:\"State
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:6:{s:1:\"a\";i:11;s:1:\"b\";i:3;s:1:\"c\";s:10:\"state-edit\";s:1:\"d\";s:10:\"State
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:6:{s:1:\"a\";i:12;s:1:\"b\";i:3;s:1:\"c\";s:12:\"state-delete\";s:1:\"d\";s:12:\"State
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:6:{s:1:\"a\";i:13;s:1:\"b\";i:4;s:1:\"c\";s:9:\"role-list\";s:1:\"d\";s:9:\"Role
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:6:{s:1:\"a\";i:14;s:1:\"b\";i:4;s:1:\"c\";s:11:\"role-create\";s:1:\"d\";s:11:\"Role
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:6:{s:1:\"a\";i:15;s:1:\"b\";i:4;s:1:\"c\";s:9:\"role-edit\";s:1:\"d\";s:9:\"Role
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:6:{s:1:\"a\";i:16;s:1:\"b\";i:4;s:1:\"c\";s:11:\"role-delete\";s:1:\"d\";s:11:\"Role
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:6:{s:1:\"a\";i:17;s:1:\"b\";i:5;s:1:\"c\";s:15:\"permission-list\";s:1:\"d\";s:15:\"Permission
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:6:{s:1:\"a\";i:18;s:1:\"b\";i:5;s:1:\"c\";s:17:\"permission-create\";s:1:\"d\";s:17:\"Permission
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:6:{s:1:\"a\";i:19;s:1:\"b\";i:5;s:1:\"c\";s:15:\"permission-edit\";s:1:\"d\";s:15:\"Permission
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:6:{s:1:\"a\";i:20;s:1:\"b\";i:5;s:1:\"c\";s:17:\"permission-delete\";s:1:\"d\";s:17:\"Permission
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:6:{s:1:\"a\";i:21;s:1:\"b\";i:6;s:1:\"c\";s:11:\"school-list\";s:1:\"d\";s:11:\"School
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:6:{s:1:\"a\";i:22;s:1:\"b\";i:6;s:1:\"c\";s:13:\"school-create\";s:1:\"d\";s:13:\"School
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:6:{s:1:\"a\";i:23;s:1:\"b\";i:6;s:1:\"c\";s:11:\"school-edit\";s:1:\"d\";s:11:\"School
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:6:{s:1:\"a\";i:24;s:1:\"b\";i:6;s:1:\"c\";s:13:\"school-delete\";s:1:\"d\";s:13:\"School
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:6:{s:1:\"a\";i:25;s:1:\"b\";i:7;s:1:\"c\";s:10:\"class-list\";s:1:\"d\";s:10:\"Class
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:6:{s:1:\"a\";i:26;s:1:\"b\";i:7;s:1:\"c\";s:12:\"class-create\";s:1:\"d\";s:12:\"Class
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:6:{s:1:\"a\";i:27;s:1:\"b\";i:7;s:1:\"c\";s:10:\"class-edit\";s:1:\"d\";s:10:\"Class
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:6:{s:1:\"a\";i:28;s:1:\"b\";i:7;s:1:\"c\";s:12:\"class-delete\";s:1:\"d\";s:12:\"Class
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:6:{s:1:\"a\";i:29;s:1:\"b\";i:8;s:1:\"c\";s:12:\"subject-list\";s:1:\"d\";s:12:\"Subject
List\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:6:{s:1:\"a\";i:30;s:1:\"b\";i:8;s:1:\"c\";s:14:\"subject-create\";s:1:\"d\";s:14:\"Subject
Create\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:6:{s:1:\"a\";i:31;s:1:\"b\";i:8;s:1:\"c\";s:12:\"subject-edit\";s:1:\"d\";s:12:\"Subject
Edit\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:6:{s:1:\"a\";i:32;s:1:\"b\";i:8;s:1:\"c\";s:14:\"subject-delete\";s:1:\"d\";s:14:\"Subject
Delete\";s:1:\"e\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"c\";s:11:\"Super
Admin\";s:1:\"d\";s:11:\"Super
Admin\";s:1:\"e\";s:3:\"web\";}i:1;a:4:{s:1:\"a\";i:2;s:1:\"c\";s:5:\"Admin\";s:1:\"d\";s:5:\"Admin\";s:1:\"e\";s:3:\"web\";}}}',
1763639129);

-- --------------------------------------------------------

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
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
`id` bigint(20) UNSIGNED NOT NULL,
`ulid` char(26) DEFAULT NULL,
`school_id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `ulid`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
(20, '01KAE08Q7XEHX7NM7ZBJVGP6YS', 5, '12', '2025-11-19 06:38:43', '2025-11-19 06:38:43');

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
(6, '01KA0WHN2WWC0298883D2ZB2CP', 'India', '2025-11-14 04:23:33', '2025-11-14 04:23:33'),
(8, '01KAAN3TSKSQY962P7BYQ2GY7A', 'USA', '2025-11-17 23:26:05', '2025-11-17 23:26:05');

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
`ulid` char(26) DEFAULT NULL,
`school_id` bigint(20) UNSIGNED NOT NULL,
`grade` varchar(255) NOT NULL COMMENT 'Letter grade like A, B, C',
`min_score` int(11) NOT NULL COMMENT 'Minimum marks for this grade',
`max_score` int(11) NOT NULL COMMENT 'Maximum marks for this grade',
`grade_point` decimal(4,2) NOT NULL COMMENT 'Numeric value of grade like 4.0, 3.0',
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_scales`
--

INSERT INTO `grade_scales` (`id`, `ulid`, `school_id`, `grade`, `min_score`, `max_score`, `grade_point`, `created_at`,
`updated_at`) VALUES
(4, '01KAE09E71760HVYF1QB3P4066', 5, 'A', 90, 100, 5.00, '2025-11-19 06:39:06', '2025-11-19 06:39:06');

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
(15, '2025_10_27_091043_create_student_gardes', 1),
(19, '2025_11_06_055341_drop_student_grades_table', 1),
(28, '2025_11_14_091625_generate_ulid_for_existing_countries', 8),
(29, '0001_01_01_000000_create_users_table', 9),
(30, '0001_01_01_000001_create_cache_table', 9),
(31, '0001_01_01_000002_create_jobs_table', 9),
(32, '2025_09_05_060342_create_countries_table', 9),
(33, '2025_09_05_060446_create_states_table', 9),
(34, '2025_09_05_060552_create_schools_table', 9),
(35, '2025_09_05_062255_add_school_id_to_users--table=users', 9),
(36, '2025_09_05_091843_add_country_and_state_to_users_table', 9),
(37, '2025_09_05_111349_create_subjects_table', 9),
(38, '2025_09_05_112204_create_classes_table', 9),
(39, '2025_09_08_092810_create_permission_groups_table', 9),
(40, '2025_09_08_094136_add_phone_to_users_table', 9),
(41, '2025_10_27_062322_create_grade_scales_table', 9),
(42, '2025_10_27_084658_create_permission_tables', 9),
(43, '2025_10_27_091607__add_group_id_to_permissions_table', 9),
(44, '2025_10_27_091938__add_display_name_to_roles_table', 9),
(45, '2025_10_27_092057__add_display_name_to_permissions_table', 9),
(46, '2025_11_06_055507_create_student_grades_table', 9),
(47, '2025_11_12_061349_add_status_to_users_table', 9),
(48, '2025_11_14_061738_add_ulid_to_countries_table', 9),
(49, '2025_11_14_063008_add_ulid_to_states_table', 9),
(50, '2025_11_14_063442_add_ulid_to_subjects_table', 9),
(51, '2025_11_14_063622_add_ulid_to_grade_scales_table', 9),
(52, '2025_11_14_064132_add_ulid_to_schools_table', 9),
(53, '2025_11_14_093047_add_ulid_to_users_table', 10),
(54, '2025_11_18_071109_add_ulid_to_classes_table', 11);

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
(1, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
`email` varchar(255) NOT NULL,
`token` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
`id` bigint(20) UNSIGNED NOT NULL,
`group_id` bigint(20) UNSIGNED DEFAULT NULL,
`name` varchar(255) NOT NULL,
`display_name` varchar(255) DEFAULT NULL,
`guard_name` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_id`, `name`, `display_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'user-list', 'User List', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(2, 1, 'user-create', 'User Create', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(3, 1, 'user-edit', 'User Edit', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(4, 1, 'user-delete', 'User Delete', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(5, 2, 'country-list', 'Country List', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(6, 2, 'country-create', 'Country Create', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(7, 2, 'country-edit', 'Country Edit', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(8, 2, 'country-delete', 'Country Delete', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(9, 3, 'state-list', 'State List', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(10, 3, 'state-create', 'State Create', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(11, 3, 'state-edit', 'State Edit', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(12, 3, 'state-delete', 'State Delete', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(13, 4, 'role-list', 'Role List', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(14, 4, 'role-create', 'Role Create', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(15, 4, 'role-edit', 'Role Edit', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(16, 4, 'role-delete', 'Role Delete', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(17, 5, 'permission-list', 'Permission List', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(18, 5, 'permission-create', 'Permission Create', 'web', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(19, 5, 'permission-edit', 'Permission Edit', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(20, 5, 'permission-delete', 'Permission Delete', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(21, 6, 'school-list', 'School List', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(22, 6, 'school-create', 'School Create', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(23, 6, 'school-edit', 'School Edit', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(24, 6, 'school-delete', 'School Delete', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(25, 7, 'class-list', 'Class List', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(26, 7, 'class-create', 'Class Create', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(27, 7, 'class-edit', 'Class Edit', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(28, 7, 'class-delete', 'Class Delete', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(29, 8, 'subject-list', 'Subject List', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(30, 8, 'subject-create', 'Subject Create', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(31, 8, 'subject-edit', 'Subject Edit', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(32, 8, 'subject-delete', 'Subject Delete', 'web', '2025-11-14 04:18:18', '2025-11-14 04:18:18');

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
(1, 'User Management', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(2, 'Country Management', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(3, 'State Management', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(4, 'Role Management', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(5, 'Permission Management', '2025-11-14 04:18:17', '2025-11-14 04:18:17'),
(6, 'School Management', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(7, 'Class Management', '2025-11-14 04:18:18', '2025-11-14 04:18:18'),
(8, 'Subject Management', '2025-11-14 04:18:18', '2025-11-14 04:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
`id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(255) NOT NULL,
`display_name` varchar(255) DEFAULT NULL,
`guard_name` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Admin', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(2, 'Admin', 'Admin', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(3, 'School Admin', 'School Admin', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(4, 'Counsellor', 'Counsellor', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(5, 'Student', 'Student', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16'),
(6, 'Developer', 'Developer', 'web', '2025-11-14 04:18:16', '2025-11-14 04:18:16');

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
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
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
(32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
`id` bigint(20) UNSIGNED NOT NULL,
`ulid` char(26) DEFAULT NULL,
`name` varchar(255) NOT NULL,
`state_id` bigint(20) UNSIGNED NOT NULL,
`address` text DEFAULT NULL,
`zipcode` varchar(255) DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `ulid`, `name`, `state_id`, `address`, `zipcode`, `created_at`, `updated_at`) VALUES
(5, '01KAE086T4HMXQ2EGCQCPC82ZX', 'london school1', 3, NULL, NULL, '2025-11-19 06:38:26', '2025-11-19 06:38:26');

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
('yRcsBvg4ffqJExvaL4Ku6qG6WFP6UuJV7WJvPJtQ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)
AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',
'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicHNRUGJpUkh2bU4zVUlCQ2NNbHpqd0dLaW00WGdDSDA3eDB6NkwxNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdHVkZW50cy8wMUtBRTBCTTRUWlMxQUhLWjFKRzQ0RTU0Si9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319',
1763554243);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
`id` bigint(20) UNSIGNED NOT NULL,
`ulid` char(26) DEFAULT NULL,
`country_id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `ulid`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(3, '01KA10G2M7CKE6DBXRKKERC5DR', 6, 'Gujarat', '2025-11-14 05:32:36', '2025-11-14 05:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
`id` bigint(20) UNSIGNED NOT NULL,
`student_id` bigint(20) UNSIGNED NOT NULL,
`class_id` bigint(20) UNSIGNED NOT NULL,
`subject_id` bigint(20) UNSIGNED NOT NULL,
`grade_id` bigint(20) UNSIGNED NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
`id` bigint(20) UNSIGNED NOT NULL,
`ulid` char(26) DEFAULT NULL,
`school_id` bigint(20) UNSIGNED NOT NULL,
`name` varchar(255) NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `ulid`, `school_id`, `name`, `created_at`, `updated_at`) VALUES
(11, '01KAE08YBTPW1Q1AQB34JT5EAY', 5, 'maths', '2025-11-19 06:38:50', '2025-11-19 06:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` bigint(20) UNSIGNED NOT NULL,
`ulid` char(26) DEFAULT NULL,
`first_name` varchar(255) NOT NULL,
`last_name` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
`dob` date DEFAULT NULL,
`phone` varchar(255) DEFAULT NULL,
`avatar` varchar(255) DEFAULT NULL,
`address` text DEFAULT NULL,
`zipcode` varchar(255) DEFAULT NULL,
`password` varchar(255) NOT NULL,
`status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
`email_verified_at` timestamp NULL DEFAULT NULL,
`interest` text DEFAULT NULL,
`goal` text DEFAULT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL,
`school_id` char(26) DEFAULT NULL,
`country_id` bigint(20) UNSIGNED DEFAULT NULL,
`state_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ulid`, `first_name`, `last_name`, `email`, `dob`, `phone`, `avatar`, `address`, `zipcode`,
`password`, `status`, `email_verified_at`, `interest`, `goal`, `created_at`, `updated_at`, `school_id`, `country_id`,
`state_id`) VALUES
(1, '01KA0VFH39FZ07CX0RTEXERVE9', 'Admin', 'User', 'admin@example.com', NULL, NULL, NULL, NULL, NULL,
'$2y$12$TP7pOIB9hGuw6SOz4QM4p.Y6wetbtA2hWUzfBetc/mQpG4GseXpJG', 'Active', NULL, NULL, NULL, '2025-11-14 04:04:55',
'2025-11-14 04:04:55', NULL, 0, 0),
(2, '01KA0VJJKT66B4WS1DPW6F6S22', 'Super', 'Admin', 'superadmin@example.com', NULL, NULL, NULL, NULL, NULL,
'$2y$12$kWrDiCgCkCmyqZUYn/YvB.sc2WcCON9iRGGCe4xkiMfwA/WM7kWJy', 'Active', NULL, NULL, NULL, '2025-11-14 04:06:35',
'2025-11-14 04:14:28', NULL, 0, 0),
(9, '01KAE0BM4TZS1AHKZ1JG44E54J', 'Super', 'SDF', 'supeDSFradmin@example.com', NULL, '3433433333', NULL, NULL, NULL,
'$2y$12$I4JYe7QvdXJ0uLVoFiGPaeDp2oqq/9xUDypcUamqD.UYo6/TJOUeC', 'Active', NULL, NULL, NULL, '2025-11-19 06:40:18',
'2025-11-19 06:40:18', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `classes`
--
ALTER TABLE `classes`
ADD PRIMARY KEY (`id`),
ADD KEY `classes_school_id_foreign` (`school_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `countries_ulid_unique` (`ulid`);

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
ADD KEY `grade_scales_school_id_foreign` (`school_id`);

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
ADD KEY `schools_state_id_foreign` (`state_id`);

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
ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
ADD PRIMARY KEY (`id`),
ADD KEY `student_grades_student_id_foreign` (`student_id`),
ADD KEY `student_grades_class_id_foreign` (`class_id`),
ADD KEY `student_grades_subject_id_foreign` (`subject_id`),
ADD KEY `student_grades_grade_id_foreign` (`grade_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
ADD PRIMARY KEY (`id`),
ADD KEY `subjects_school_id_foreign` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `users_email_unique` (`email`),
ADD UNIQUE KEY `users_ulid_unique` (`ulid`),
ADD KEY `users_school_id_foreign` (`school_id`),
ADD KEY `users_country_id_foreign` (`country_id`),
ADD KEY `users_state_id_foreign` (`state_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_scales`
--
ALTER TABLE `grade_scales`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
ADD CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `grade_scales`
--
ALTER TABLE `grade_scales`
ADD CONSTRAINT `grade_scales_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions`
(`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
ADD CONSTRAINT `permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `permission_groups` (`id`) ON DELETE
SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions`
(`id`) ON DELETE CASCADE,
ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
ADD CONSTRAINT `schools_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
ADD CONSTRAINT `student_grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `student_grades_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grade_scales` (`id`) ON DELETE
CASCADE,
ADD CONSTRAINT `student_grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE
CASCADE,
ADD CONSTRAINT `student_grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE
CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
ADD CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
