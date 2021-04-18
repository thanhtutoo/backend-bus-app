-- -------------------------------------------------------------
-- TablePlus 3.12.6(366)
--
-- https://tableplus.com/
--
-- Database: bus_projects
-- Generation Time: 2021-04-19 01:14:08.5640
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `bus_routes`;
CREATE TABLE `bus_routes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) NOT NULL,
  `bus_stop_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_routes_bus_id_bus_stop_id_unique` (`bus_id`,`bus_stop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `bus_stops`;
CREATE TABLE `bus_stops` (
  `bus_stop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bus_stop_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bus_stop_id`),
  UNIQUE KEY `bus_stops_bus_stop_name_unique` (`bus_stop_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `bus_timings`;
CREATE TABLE `bus_timings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `arrival_timing` int(11) NOT NULL,
  `bus_stop_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `buses`;
CREATE TABLE `buses` (
  `bus_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bus_number` int(11) NOT NULL,
  `bus_name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bus_id`),
  UNIQUE KEY `buses_bus_number_unique` (`bus_number`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `bus_routes` (`id`, `bus_id`, `bus_stop_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2021-04-18 15:37:25', '2021-04-18 15:37:25'),
(2, 5, 1, '2021-04-18 15:38:34', '2021-04-18 15:38:34'),
(3, 6, 4, '2021-04-18 15:40:36', '2021-04-18 15:40:36');

INSERT INTO `bus_stops` (`bus_stop_id`, `bus_stop_name`, `lat`, `lng`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 'blk 65', '1.3274494', '103.8784111', 370065, '2021-04-18 15:12:14', '2021-04-18 15:12:14'),
(3, 'Macpherson Stn Exit C', '1.3249943', '103.8868429', 370065, '2021-04-18 15:38:56', '2021-04-18 15:38:56'),
(4, 'Paya Lebar Square', '1.3187595', '103.8903791', 409051, '2021-04-18 15:40:02', '2021-04-18 15:40:02');

INSERT INTO `bus_timings` (`id`, `arrival_timing`, `bus_stop_id`, `bus_id`, `created_at`, `updated_at`) VALUES
(3, 1619762210, 1, 3, '2021-04-18 16:10:22', '2021-04-18 16:10:22'),
(4, 1619762210, 3, 4, '2021-04-18 16:10:30', '2021-04-18 16:10:30');

INSERT INTO `buses` (`bus_id`, `bus_number`, `bus_name`, `created_at`, `updated_at`) VALUES
(3, 6, 'Kits', '2021-04-18 11:43:03', '2021-04-18 11:43:03'),
(4, 7, 'Kits', '2021-04-18 11:43:06', '2021-04-18 11:43:06'),
(5, 99, 'Hello', '2021-04-18 15:38:09', '2021-04-18 15:38:09'),
(6, 150, 'Tan', '2021-04-18 15:38:20', '2021-04-18 15:38:20');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2021_04_16_134205_create_bus_timings_table', 3),
(9, '2021_04_16_134022_create_bus_stops_table', 6),
(11, '2021_04_16_123904_create_buses_table', 7),
(12, '2021_04_16_135434_create_bus_routes_table', 8);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$GNYKU9uQYrBCFlOTw.m1vesn5mml7ZOS56m2olhs7kohgcwSLBCCS', NULL, '2021-04-17 16:46:48', '2021-04-17 16:46:48');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;