-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 08:25 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ghodo_admin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` enum('normal','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `status` enum('new','in_progress','completed','transferred') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`id`, `requester_id`, `floor`, `location`, `title`, `description`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(9, 14, 'الطابق الأول', 'غرفة 101', 'إصلاح النافذة المكسورة', 'النافذة في غرفة 101 بها كسر في الزجاج ويحتاج إلى استبدال', 'urgent', 'new', '2025-05-22 13:58:39', '2025-05-24 13:58:39'),
(10, 15, 'الطابق الثاني', 'المختبر A', 'مشكلة في التكييف', 'التكييف لا يعمل بشكل صحيح في المختبر A', 'normal', 'new', '2025-05-23 13:58:39', '2025-05-24 13:58:39'),
(11, 13, 'الطابق الأرضي', 'القاعة الرئيسية', 'إصلاح الإضاءة', 'بعض المصابيح في القاعة الرئيسية لا تعمل', 'normal', 'in_progress', '2025-05-19 13:58:39', '2025-05-24 13:58:39'),
(12, 14, 'الطابق الثانيnn', 'غرفة المعلمين', 'إصلاح مقبض الباب', 'مقبض الباب مكسور ويحتاج إلى استبدال', 'normal', 'in_progress', '2025-05-21 13:58:39', '2025-05-26 15:41:32'),
(13, 15, 'الطابق الأول', 'المكتبة', 'طلاء الجدران', 'إعادة طلاء جدران المكتبة', 'normal', 'completed', '2025-05-10 13:58:39', '2025-05-24 13:58:39'),
(15, 22, 'Ground Floor', 'Lab A', 'Leaking Pipe', 'Assumenda rerum voluptas enim error cumque aperiam eos neque atque est delectus.', 'normal', 'completed', '2025-01-21 14:58:39', '2025-05-08 13:58:39'),
(16, 22, '1st Floor', 'Room 201', 'Leaking Pipe', 'Reiciendis autem voluptatem repellendus sequi aut ipsum culpa voluptatem aut molestias.', 'normal', 'in_progress', '2025-03-04 14:58:39', '2025-04-29 13:58:39'),
(17, 22, '2nd Floor', 'Room 102', 'Paint Touch-up Required', 'Eos accusamus eligendi vero dolore facere velit.', 'urgent', 'transferred', '2025-04-13 14:58:39', '2025-04-25 13:58:39'),
(18, 22, 'Ground Floor', 'Main Hall', 'Broken Window', 'Quis culpa maxime molestiae aut inventore voluptatem animi et ipsum aut fugiat quae.', 'normal', 'transferred', '2025-02-05 14:58:39', '2025-05-24 13:58:39'),
(19, 22, '1st Floor', 'Room 201', 'Faulty Electrical Socket', 'Quae et pariatur voluptates sit quis qui nisi et error error libero alias eum.', 'normal', 'transferred', '2025-03-18 14:58:39', '2025-04-29 13:58:39'),
(20, 22, '2nd Floor', 'Room 201', 'Leaking Pipe', 'Qui occaecati voluptas ut animi eius placeat quam adipisci vel est omnis.', 'normal', 'completed', '2025-03-24 14:58:39', '2025-04-24 14:58:39'),
(21, 22, '1st Floor', 'Library', 'Broken Window', 'Tenetur magnam adipisci occaecati labore doloribus quos explicabo et nihil ut voluptatibus.', 'normal', 'new', '2025-04-28 13:58:39', '2025-05-14 13:58:39'),
(22, 22, '1st Floor', 'Principal Office', 'Damaged Door Handle', 'Officiis eius est sint et est minima qui dolorum inventore exercitationem.', 'urgent', 'completed', '2025-04-27 13:58:39', '2025-04-25 13:58:39'),
(23, 22, '1st Floor', 'Lab B', 'Damaged Door Handle', NULL, 'normal', 'in_progress', '2024-12-25 14:58:39', '2025-05-08 13:58:39'),
(24, 22, '3rd Floor', 'Main Hall', 'Faulty Electrical Socket', NULL, 'normal', 'transferred', '2024-12-05 14:58:39', '2025-05-18 13:58:39'),
(25, 22, 'Ground Floor', 'Room 202', 'Leaking Pipe', 'Qui mollitia debitis similique consequatur minus ipsum minus provident odio natus quod iusto.', 'urgent', 'transferred', '2025-05-20 13:58:39', '2025-05-23 13:58:39'),
(26, 22, '2nd Floor', 'Staff Room', 'Broken Window', 'Et aliquid consectetur sunt molestiae et voluptatem quos.', 'normal', 'transferred', '2025-03-07 14:58:39', '2025-05-23 13:58:39'),
(27, 22, '1st Floor', 'Room 102', 'Leaking Pipe', NULL, 'urgent', 'transferred', '2025-03-04 14:58:39', '2025-05-08 13:58:39'),
(28, 22, 'Basement', 'Main Hall', 'Paint Touch-up Required', 'Quod sunt architecto praesentium possimus enim magnam et voluptatum id omnis libero.', 'urgent', 'new', '2025-01-20 14:58:39', '2025-05-08 13:58:39'),
(29, 24, '1st Floor', 'Lab B', 'Faulty Electrical Socket', 'Vero voluptatem sint repudiandae veniam aut soluta magni dolores aut eligendi qui dolorum et.', 'normal', 'in_progress', '2025-04-30 13:58:40', '2025-05-23 13:58:40'),
(30, 25, '1st Floor', 'Lab A', 'Air Conditioning Issue', 'Id amet beatae quae maxime et non.', 'normal', 'in_progress', '2024-11-28 14:58:40', '2025-05-11 13:58:40'),
(31, 26, 'Basement', 'Staff Room', 'Air Conditioning Issue', 'Amet sint vel consequuntur aliquam sapiente aperiam.', 'urgent', 'transferred', '2025-04-22 14:58:40', '2025-05-15 13:58:40'),
(32, 27, 'Basement', 'Cafeteria', 'Ceiling Repair Needed', NULL, 'urgent', 'in_progress', '2024-12-11 14:58:40', '2025-04-24 14:58:40'),
(33, 28, '1st Floor', 'Room 201', 'Lighting Problem', 'Possimus iure laboriosam eum rerum quam sunt quae vel autem assumenda ut dignissimos.', 'normal', 'transferred', '2025-03-04 14:58:40', '2025-05-07 13:58:40'),
(34, 29, '3rd Floor', 'Principal Office', 'Broken Window', 'Odio nihil architecto laborum nemo est non omnis quam aut est eaque et.', 'urgent', 'transferred', '2025-01-12 14:58:40', '2025-05-16 13:58:40');

-- --------------------------------------------------------

--
-- Table structure for table `material_requests`
--

CREATE TABLE `material_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requester_id` bigint(20) UNSIGNED NOT NULL,
  `maintenance_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `cost` decimal(8,2) DEFAULT NULL,
  `funding_source` enum('school_budget','maintenance','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','fulfilled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_requests`
--

INSERT INTO `material_requests` (`id`, `requester_id`, `maintenance_request_id`, `item_description`, `quantity`, `cost`, `funding_source`, `status`, `created_at`, `updated_at`) VALUES
(13, 14, 12, 'مقبض باب نحاسي', 1, '75.00', 'maintenance', 'pending', '2025-05-22 13:58:40', '2025-05-24 13:58:40'),
(14, 15, NULL, 'مصابيح LED 60 واط (عبوة 10 قطع)', 2, '180.00', 'school_budget', 'pending', '2025-05-23 13:58:40', '2025-05-24 13:58:40'),
(15, 13, NULL, 'أدوات تنظيف متنوعة', 1, '120.00', 'school_budget', 'pending', '2025-05-24 01:58:40', '2025-05-24 13:58:40'),
(16, 14, NULL, 'طلاء أبيض (4 جالون)', 4, '320.00', 'maintenance', 'approved', '2025-05-17 13:58:40', '2025-05-24 13:58:40'),
(17, 17, 29, 'Drill Bits Set', 19, '390.30', 'other', 'approved', '2025-04-02 14:58:40', '2025-05-07 13:58:40'),
(18, 17, NULL, 'White Paint (1 Gallon)', 1, '348.36', 'other', 'approved', '2025-04-20 14:58:40', '2025-05-10 13:58:40'),
(19, 17, NULL, 'Safety Gloves (Pair)', 20, '339.95', 'school_budget', 'rejected', '2025-04-14 14:58:40', '2025-05-03 13:58:40'),
(20, 17, 30, 'Light Bulbs (LED 60W)', 19, '128.24', 'other', 'rejected', '2025-04-22 14:58:40', '2025-05-06 13:58:40'),
(21, 17, NULL, 'Light Bulbs (LED 60W)', 3, '365.93', 'other', 'approved', '2025-01-05 14:58:40', '2025-05-18 13:58:40'),
(22, 17, NULL, 'Floor Tiles (Pack of 10)', 5, '49.41', 'maintenance', 'approved', '2025-01-22 14:58:40', '2025-05-16 13:58:40'),
(23, 17, NULL, 'White Paint (1 Gallon)', 16, '492.99', 'maintenance', 'rejected', '2024-12-10 14:58:40', '2025-05-22 13:58:40'),
(24, 17, 31, 'Ceiling Fan', 13, '175.93', NULL, 'rejected', '2025-04-16 14:58:40', '2025-05-20 13:58:40'),
(25, 17, 32, 'Ceiling Fan', 13, '91.46', 'school_budget', 'approved', '2025-04-27 13:58:40', '2025-05-01 13:58:40'),
(26, 17, 33, 'Electrical Wire (50m)', 1, '136.52', 'maintenance', 'pending', '2025-05-14 13:58:40', '2025-05-03 13:58:40'),
(27, 17, NULL, 'White Paint (1 Gallon)', 7, '408.60', 'other', 'pending', '2024-12-06 14:58:40', '2025-05-16 13:58:40'),
(28, 17, NULL, 'Extension Cord (10m)', 11, '40.11', 'other', 'approved', '2025-02-09 14:58:40', '2025-05-14 13:58:40'),
(29, 17, NULL, 'Sandpaper (Assorted)', 9, '206.29', NULL, 'approved', '2025-04-04 14:58:40', '2025-05-22 13:58:40'),
(30, 17, NULL, 'Electrical Wire (50m)', 7, '199.25', 'other', 'approved', '2025-05-13 13:58:40', '2025-05-21 13:58:40'),
(31, 17, NULL, 'Screws Set (Box)', 11, '452.68', 'maintenance', 'rejected', '2025-04-03 14:58:40', '2025-05-07 13:58:40'),
(32, 17, NULL, 'Window Glass (24x36)', 11, '137.19', 'other', 'approved', '2025-02-10 14:58:40', '2025-05-08 13:58:40'),
(33, 17, NULL, 'Floor Tiles (Pack of 10)', 18, '149.41', 'maintenance', 'approved', '2025-04-14 14:58:40', '2025-05-20 13:58:40'),
(34, 17, 34, 'Power Outlet', 7, '195.88', 'other', 'approved', '2025-04-18 14:58:40', '2025-04-29 13:58:40'),
(35, 17, NULL, 'Electrical Wire (50m)', 7, '445.08', NULL, 'fulfilled', '2025-05-09 13:58:40', '2025-04-29 13:58:40'),
(36, 17, NULL, 'White Paint (1 Gallon)', 5, '307.42', 'other', 'pending', '2025-04-14 14:58:40', '2025-04-28 13:58:40');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_20_173534_add_fields_to_users_table', 1),
(5, '2025_05_20_175144_convert_role_to_string_in_users_table', 1),
(6, '2025_05_20_175608_fix_role_columns_in_users_table', 1),
(7, '2025_05_24_163958_create_maintenance_requests_table', 1),
(8, '2025_05_24_164032_create_material_requests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5uTb8qwOZq1EhGyNIdqcHzYZKuelmJUnKd4atvSX', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUnhaeFJPbk9zaWcwd3MwVUFwR0U3Wm83dlNNeTM2VEFVcFkwVTFkQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748449595),
('ksqoZHc7LqElLFm44JjeD9IdzmSfEItAIACMmemG', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUnZGY1FLVzN3Y2d6R1lVTWFWbjlOaHozNVNNUVFZUDJVZEdSbHMxNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748451593),
('lcye1kPAarCCaoZUqgMOMedvIF1QLmFNRzxBNAUw', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM1RZaEZsVDN4UnpLczNQcFo4N2VWbWVJZ1V1WnZjOHJSYTR2dlo4byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748456018),
('O0eLKHu6lmJ3iFmfm0MuUSxZgKpxVW9qy7zktsuO', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXh4Q1VRY3dCcDNvMzFkWGdEV0xacGtIUDd4ZkpSY0NuREo3NGZzVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748456594),
('OTTBcThAxy9FGVErC36OS7besMywVWCuR4uh9fuR', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV2FNaXdQNmJyeG9zTjFEUWJLMGlrZU54bTR6dkVOd1kxWUZtMUxFWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748448966),
('Rv1v5Dd8AFN1LeOOnSve2wb6xfqFXHAGb6oLLZQ5', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWRyVGJFd1o5T0V4N21pOU45T2c0d0lKREN6Ymczcm52Vmlub2hySiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748456602),
('sFNCxCl8KG8OxoryOIiBV5yLZ1cKcFvWbLqXgNsK', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoianROUzNyRktNTmRXdzlLNUpldFcwYmpmcmFrNm9CeHREdTZSR3NTTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748449335),
('swTCLi1J60r6MTUIDhx2e5pdk6O486LpEdWB8jYO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidURLRUJLTWxyYTF6cmhuVUdGOTFjUG05SlVJbDRxcTBYclFBMWREZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748449675),
('WDbAGBLu71JMRWyEnnl1H3hnA964x3RNG4PTmUKS', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZVREU1VDOHVTV3ZVWW9YUFAxazgzc3dqcEE1bVNNUnZMWUVCTzV6NiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9tYWludGVuYW5jZS1yZXF1ZXN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1748451525);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civil_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `civil_id`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(13, 'مدير النظام', 'admin@ghodo.test', '966501234567', NULL, 'admin', '2025-05-24 13:58:38', '$2y$12$FtZuTejcdZwxcZZm4obpDeL.Nf1/KN5Tb3iTZ9R9VcSCbuz.G092K', 'ToFg8f7yNBRUPUMPVqLlR9nEqGZgEoaJHSnS67gxISOLbncspVLd9O6t1OEQ', '2025-05-24 13:58:38', '2025-05-24 13:58:38'),
(14, 'أحمد محمد', 'ahmed@ghodo.test', '966507654321', NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$qBCC9LgPePsAmRdh/fhAEebaUhuHUfjYjNZBwqogCfwBwnkpOZCty', NULL, '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(15, 'فاطمة علي', 'fatima@ghodo.test', '966509876543', NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$uo51LBOYWzOKNe99WX1X4exFKwgMz/wBog0QymxXjAl6OUX9UaSEC', NULL, '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(16, 'Abbigail Murazik', 'khaag@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', '2ZVbs3Q8jr', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(17, 'Irma Wisoky', 'dagmar.hahn@example.com', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'UPYoNMpuLp', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(18, 'Gwendolyn Grimes', 'abernathy.aurelie@example.org', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'Rrqhs67uqY', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(19, 'Lamar Jast II', 'gottlieb.laisha@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'lEJR4ZCbJf', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(20, 'Virginie Kunze', 'roy62@example.org', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'g5SuCOLslo', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(21, 'Antonette Pfannerstill', 'marquardt.trenton@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'DGTuL5q0oA', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(22, 'Dr. Mattie Bahringer MD', 'simonis.julius@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'oMX0k5r4Vb', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(23, 'Dr. Hyman Ziemann IV', 'ulises76@example.org', NULL, NULL, 'staff', '2025-05-24 13:58:39', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'Y2ZnE0leNV', '2025-05-24 13:58:39', '2025-05-24 13:58:39'),
(24, 'Kacey Hudson', 'marilou.trantow@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'aJQuXMEoxd', '2025-05-24 13:58:40', '2025-05-24 13:58:40'),
(25, 'Kade Shanahan III', 'hans.herman@example.com', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'dcXB81bNlf', '2025-05-24 13:58:40', '2025-05-24 13:58:40'),
(26, 'Prof. Lia Lesch', 'nicola04@example.com', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'wL1SgDfUN5', '2025-05-24 13:58:40', '2025-05-24 13:58:40'),
(27, 'Aletha Kihn', 'hwhite@example.com', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'XurEQOTwYI', '2025-05-24 13:58:40', '2025-05-24 13:58:40'),
(28, 'Brittany Will II', 'beahan.augustine@example.com', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'Yw9Jj99DKR', '2025-05-24 13:58:40', '2025-05-24 13:58:40'),
(29, 'Jamir Lubowitz', 'arlo.witting@example.net', NULL, NULL, 'staff', '2025-05-24 13:58:40', '$2y$12$RMMek6JdTTvR2zrweS5Qj.kvqnAJAaUGVi.BNvYJdBEYJ.QDFIfAm', 'piJJnflLCa', '2025-05-24 13:58:40', '2025-05-24 13:58:40');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_requests_requester_id_foreign` (`requester_id`);

--
-- Indexes for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_requests_requester_id_foreign` (`requester_id`),
  ADD KEY `material_requests_maintenance_request_id_foreign` (`maintenance_request_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `material_requests`
--
ALTER TABLE `material_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `maintenance_requests_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `material_requests`
--
ALTER TABLE `material_requests`
  ADD CONSTRAINT `material_requests_maintenance_request_id_foreign` FOREIGN KEY (`maintenance_request_id`) REFERENCES `maintenance_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_requests_requester_id_foreign` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
