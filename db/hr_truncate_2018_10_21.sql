-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.23 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5284
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table hr_v3_data.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_login_id_unique` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.admins: ~1 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `login_id`, `password`, `password_text`, `role_code`, `remember_token`, `deleted_flg`, `created_at`, `updated_at`) VALUES
	(1, 'admin123456', 'admin@gmail.com', 'admin123456', '$2y$10$B8CEviBhWJh8Av7TagGiUedhOeIaTvwfeHFw5ACbFLXPx0aJtZZYO', 'admin123456', 'admin', 'BJOvYmScTt5xZJFbCsHzu6KNAEE35Uok6fugqROOp41IKMalOve7bhYrNaN7', 0, '2018-10-20 16:55:09', '2018-10-20 16:55:09');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.blog: ~0 rows (approximately)
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.gift
CREATE TABLE IF NOT EXISTS `gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `send_date` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.gift: ~0 rows (approximately)
/*!40000 ALTER TABLE `gift` DISABLE KEYS */;
/*!40000 ALTER TABLE `gift` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_bulk
CREATE TABLE IF NOT EXISTS `mail_bulk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reserve_datetime` timestamp NULL DEFAULT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition` longtext COLLATE utf8mb4_unicode_ci,
  `list_user` longtext COLLATE utf8mb4_unicode_ci,
  `total_user` int(11) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `bulk_number` int(11) DEFAULT NULL,
  `bulk_send_number` int(11) DEFAULT NULL,
  `send_datetime` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_bulk: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_bulk` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_bulk` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_bulk_detail
CREATE TABLE IF NOT EXISTS `mail_bulk_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mail_bulk_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_bulk_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_bulk_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_bulk_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_bulk_done
CREATE TABLE IF NOT EXISTS `mail_bulk_done` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mail_bulk_id` int(11) NOT NULL,
  `total_user` int(11) NOT NULL,
  `send_success_number` int(11) NOT NULL,
  `read_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_bulk_done: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_bulk_done` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_bulk_done` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_contact
CREATE TABLE IF NOT EXISTS `mail_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `user_read_at` timestamp NULL DEFAULT NULL,
  `admin_read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_contact: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_contact` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_deposit_detail
CREATE TABLE IF NOT EXISTS `mail_deposit_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `transaction_deposit_id` int(11) NOT NULL,
  `mail_template_deposit_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_deposit_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_deposit_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_deposit_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_gift_detail
CREATE TABLE IF NOT EXISTS `mail_gift_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `gift_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_gift_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_gift_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_gift_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_payment_detail
CREATE TABLE IF NOT EXISTS `mail_payment_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `transaction_payment_id` int(11) NOT NULL,
  `mail_template_payment_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_payment_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_payment_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_payment_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_prediction_open_detail
CREATE TABLE IF NOT EXISTS `mail_prediction_open_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prediction_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_prediction_open_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_prediction_open_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_prediction_open_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_prediction_result_detail
CREATE TABLE IF NOT EXISTS `mail_prediction_result_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prediction_id` int(11) NOT NULL,
  `transaction_prediction_result_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_prediction_result_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_prediction_result_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_prediction_result_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_register_detail
CREATE TABLE IF NOT EXISTS `mail_register_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mail_template_register_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_register_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_register_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_register_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_replace
CREATE TABLE IF NOT EXISTS `mail_replace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `source` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_replace: ~24 rows (approximately)
/*!40000 ALTER TABLE `mail_replace` DISABLE KEYS */;
INSERT INTO `mail_replace` (`id`, `name`, `type`, `source`, `deleted_flg`, `created_at`, `updated_at`) VALUES
	(1, 'login id', 0, '<p>%login_id%<br></p>', 0, '2018-10-18 18:45:54', '2018-10-18 18:53:35'),
	(2, 'user key', 0, '<p>%user_key%<br></p>', 0, '2018-10-18 18:46:08', '2018-10-18 18:53:46'),
	(3, 'password', 0, '<p>%password%<br></p>', 0, '2018-10-18 18:46:28', '2018-10-18 18:54:01'),
	(4, 'nickname', 0, '<p>%nickname%<br></p>', 0, '2018-10-18 18:46:39', '2018-10-18 18:54:24'),
	(5, 'gender', 0, '<p>%gender%<br></p>', 0, '2018-10-18 18:46:50', '2018-10-18 18:54:14'),
	(6, 'age', 0, '<p>%age%<br></p>', 0, '2018-10-18 18:47:01', '2018-10-18 18:54:34'),
	(7, 'member level', 0, '<p>%member_level%<br></p>', 0, '2018-10-18 18:47:28', '2018-10-18 18:54:47'),
	(8, 'mail pc', 0, '<p>%mail_pc%<br></p>', 0, '2018-10-18 18:48:01', '2018-10-18 18:54:59'),
	(9, 'mail mobile', 0, '<p>%mail_mobile%<br></p>', 0, '2018-10-18 18:48:15', '2018-10-18 18:55:08'),
	(10, 'register time', 0, '<p>%register_time%<br></p>', 0, '2018-10-18 18:48:33', '2018-10-18 18:55:21'),
	(11, 'interim register time', 0, '<p>%interim_register_time%<br></p>', 0, '2018-10-18 18:48:56', '2018-10-18 18:55:34'),
	(12, 'user deleted', 0, '<p>%user_deleted%<br></p>', 0, '2018-10-18 18:49:19', '2018-10-18 18:55:49'),
	(13, 'user point', 0, '<p>%user_point%<br></p>', 0, '2018-10-18 18:49:32', '2018-10-18 18:56:05'),
	(14, 'login number', 0, '<p>%login_number%<br></p>', 0, '2018-10-18 18:49:46', '2018-10-18 18:56:16'),
	(15, 'last login time', 0, '<p>%last_login_time%<br></p>', 0, '2018-10-18 18:50:00', '2018-10-18 18:56:30'),
	(16, 'last access time', 0, '<p>%last_access_time%<br></p>', 0, '2018-10-18 18:50:16', '2018-10-18 18:56:56'),
	(17, 'first payment time', 0, '<p>%first_payment_time%<br></p>', 0, '2018-10-18 18:50:35', '2018-10-18 18:57:09'),
	(18, 'last payment time', 0, '<p>%last_payment_time%<br></p>', 0, '2018-10-18 18:50:49', '2018-10-18 18:57:20'),
	(19, 'prediction name', 0, '<p>%prediction_name%<br></p>', 0, '2018-10-18 18:51:08', '2018-10-18 18:57:31'),
	(20, 'prediction point', 0, '<p>%prediction_point%<br></p>', 0, '2018-10-18 18:51:48', '2018-10-18 18:57:43'),
	(21, 'gift point', 0, '<p>%gift_point%<br></p>', 0, '2018-10-18 18:52:03', '2018-10-18 18:58:07'),
	(22, 'trans point', 0, '<p>%trans_point%<br></p>', 0, '2018-10-18 18:52:38', '2018-10-18 18:57:57'),
	(23, 'trans amount', 0, '<p>%trans_amount%<br></p>', 0, '2018-10-18 18:53:01', '2018-10-18 18:53:01'),
	(24, 'prediction id', 0, '<p>%prediction_id%<br></p>', 0, '2018-10-18 18:53:21', '2018-10-18 18:53:21');
/*!40000 ALTER TABLE `mail_replace` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_schedule
CREATE TABLE IF NOT EXISTS `mail_schedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_type` tinyint(4) NOT NULL DEFAULT '0',
  `reserve_datetime` timestamp NULL DEFAULT NULL,
  `day_of_week` tinyint(4) DEFAULT NULL,
  `week_time_send` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_hour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci,
  `condition` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_datetime` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_schedule: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_schedule` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_schedule_detail
CREATE TABLE IF NOT EXISTS `mail_schedule_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mail_schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_to_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_schedule_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_schedule_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_schedule_detail` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_schedule_done
CREATE TABLE IF NOT EXISTS `mail_schedule_done` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mail_schedule_id` int(11) NOT NULL,
  `total_user` int(11) NOT NULL,
  `send_success_number` int(11) NOT NULL,
  `read_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_schedule_done: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_schedule_done` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_schedule_done` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.mail_template
CREATE TABLE IF NOT EXISTS `mail_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.mail_template: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_template` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.migrations: ~32 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2018_10_11_041624_create_user_table', 1),
	(4, '2018_10_11_041715_create_user_activity_table', 2),
	(5, '2018_10_13_040507_create_user_daily_access_history_table', 3),
	(6, '2018_10_13_040942_create_user_daily_login_history_table', 4),
	(7, '2018_10_13_041143_create_point_table', 5),
	(8, '2018_10_13_041307_create_blog_table', 6),
	(9, '2018_10_13_041701_create_gift_table', 7),
	(10, '2018_10_13_041854_create_venue_table', 8),
	(11, '2018_10_13_041945_create_page_table', 9),
	(12, '2018_10_13_042953_create_admin_table', 10),
	(13, '2018_10_13_062042_create_transaction_payment_table', 11),
	(14, '2018_10_13_062407_create_transaction_deposit_table', 12),
	(15, '2018_10_13_062515_create_transaction_gift_table', 13),
	(16, '2018_10_13_062658_create_mail_schedule_table', 14),
	(17, '2018_10_13_063026_create_mail_schedule_detail_table', 15),
	(18, '2018_10_13_063344_create_mail_schedule_done_table', 16),
	(19, '2018_10_13_063547_create_mail_bulk_table', 17),
	(20, '2018_10_13_063916_create_mail_bulk_done_table', 18),
	(21, '2018_10_13_064203_create_mail_bulk_detail_table', 19),
	(22, '2018_10_13_064508_create_mail_contact_table', 20),
	(23, '2018_10_13_064616_create_mail_gift_detail_table', 21),
	(24, '2018_10_13_064740_create_mail_payment_detail_table', 22),
	(25, '2018_10_13_065051_create_mail_payment_deposit_table', 23),
	(26, '2018_10_13_065128_create_mail_template_table', 24),
	(27, '2018_10_13_065409_create_mail_replace_table', 25),
	(28, '2018_10_13_172609_create_mail_register_detail_table', 26),
	(29, '2018_10_14_131021_create_mail_buy_prediction_detail_table', 27),
	(30, '2018_10_14_131243_create_mail_prediction_result_detail_table', 28),
	(31, '2018_10_14_153057_create_prediction_result_table', 29),
	(32, '2018_10_14_160907_create_prediction_table', 30),
	(33, '2018_10_16_135512_create_mail_prediction_open_detail_table', 31),
	(34, '2018_10_17_074031_create_user_access_prediction_table', 32);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.page
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.page: ~10 rows (approximately)
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` (`id`, `name`, `code`, `link`, `source`, `deleted_flg`, `created_at`, `updated_at`) VALUES
	(1, 'about-one', 'about_one', '/about-one', '<div id="about01" class="font">\r\n        <p class="center title"><span class="gold">＜ONE AND ONLY＞</span>とは・・・</p>\r\n\r\n        <p>競馬の発祥の地である英国では、「競馬は貴族の遊び」と言われているように、元々は庶民とは縁の遠い存在にあった競馬。</p>\r\n        <p>つまりは、競馬の本質は、資本力のある成功者にとっての「大人のたしなみ」である。</p>\r\n\r\n        <p class="txt23 center">「ダービー馬のオーナーになることは一国の宰相になることより難しい」</p>\r\n\r\n        <p>このような言葉が生まれた背景には、資本力、強運だけでは簡単にダービーのタイトルを獲ることはできない成功者たちによる激しい競争という資本主義的な背景がある。</p>\r\n\r\n        <p>「資本力」や「強運力」を競い合い、誰よりも強い競走馬を所有することに喜びを感じる貴族たちにとっての遊びが進化し、日本という国では“馬券売り上げ”が国の財源の1つとして確立されたのが現代日本競馬誕生の経緯。</p>\r\n\r\n        <p>資本力を持つビジネスの成功者が、サラブレッドを購入し走らせる側の「馬主」となり、繰り広げられているのが競馬の本質。<br>\r\n          だからこそ、競馬界の中心は【馬主】ということである。</p>\r\n\r\n        <p>一般の競馬ファンによる馬券購入の売り上げによって、大きな興業ビジネスとなっている競馬であるにも関わらず、いまだに一般競馬ファンには届くことのない情報は数多い。</p>\r\n\r\n        <p>競走馬を生産した牧場が、庭先での取引やセールに上場させて、馬主に「より高額で」競走馬を購入してもらう。</p>\r\n\r\n        <p>競走馬を購入した「馬主」は、繋がりのある調教師のもとに愛馬を預ける。</p>\r\n\r\n        <p>調教師は、「馬主」や「牧場」と相談しながら、レースや騎手を選び、レース賞金を稼ぎながら、厩舎を経営してゆく。</p>\r\n\r\n        <p>生産牧場は、「1頭でも多く、1円でも高く、馬を購入してもらう」ことに精力を尽くす。<br>\r\n          そのためには馬主とともに競走馬の所有権利を“半持ち”にしてでも、馬主側へのリスク対策も提案しながら、売りさばいていく。</p>\r\n\r\n        <p>馬主は、「ダービーを勝てる馬」を探し求める夢を追う場合や「購入金額よりも稼いでくれる馬」という投資的観点から、買う価値があると判断する馬を選んで購入する。</p>\r\n\r\n        <p>ここには、当然【政治力】が働き、またビジネスである以上は【駆け引き】も存在している。<br>\r\n          「走らない馬でも高く買ってもらいたい」という本音もあるが、誰を相手にしてでもそのような営業をしていれば、次回は買ってもらうことはできなくなることは当然。</p>\r\n\r\n        <p>\r\n          そのために、「長く馬主を続けるであろう」という重要馬主には、“駄馬”はそう簡単には売らない。もちろん「これは走る！」という馬が、思ったほど走らないケースもあるが、その場合には、また良い条件で馬の購入を提案する動きは必ずと言っていいほどある。</p>\r\n\r\n        <p>しかしながら、その一方で「この馬主は、長くはやらないだろうなぁ。お金があるだけだな」と見るやいなや、「良血でも走らないであろうデキのよくない馬」を血統面だけの魅力を説き、強気の高額購入へと舵を取る。</p>\r\n\r\n        <p>客観的に見れば、牧場の「ぼったくり」のようにも見えてしまうが、「一見さん」に対しては、最初は「疑いの目」から入るのは、どの業界でも珍しい話ではなく、ビジネスという観点では当然と言っても過言ではない。</p>\r\n\r\n        <p>もちろん良好な関係にある馬主には、「レースで勝って良い思いをしてもらいたい！」という思惑も働くことで、間接的に利権関係者による圧力がレースに影響を及ぼすことも日常茶飯事である。</p>\r\n\r\n        <p>このような「競馬の本質」を知っていれば、「走る馬」や「走る情報」、「本気の勝負どころ」を事前に知れることになるわけだが、そのような裏側のやりとりなどが表沙汰になることはまずあり得ない。</p>\r\n\r\n        <p class="center txt23">競馬は「資本力のある成功者たちの遊び」が本質。</p>\r\n\r\n        <p>\r\n          馬券売り上げについては、馬券を購入するファンが「馬券の勝ち負け」を楽しんでくれていれば成り立つわけであり、馬券を購入する人間に対しては、誰が勝とうが、誰が負けようが、主催者側や競馬界の重鎮組織にとっては、一切関係ないのである。</p>\r\n\r\n        <p>主催者は、「100円でも多く馬券が売れる」ことが目的であるため、走らせる側の思惑については、一般競馬ファン側に伝える必要は全くない。</p>\r\n\r\n        <p>また馬を走らせる重鎮関係者にとっても、「一般の競馬ファンの馬券の勝ち負け」は一切関係ない。「馬を走らせる側の利権関係者が良い思いができるかどうか」が焦点となる。</p>\r\n\r\n        <p>そのような相関関係を知っていれば、一般競馬ファンに知れ渡るような情報は、勝負とはあまり関係のない次元の情報内容に過ぎないということが当たり前であることも理解できるはず。</p>\r\n\r\n        <p>これが、「馬券売り上げで成り立つ日本競馬」と、「馬券を購入する一般の競馬ファンには本物の情報が出回らない」という矛盾が生じる真相である。</p>\r\n\r\n        <p>情報を共有する場を設けて、交流の場を作り、そして、この「矛盾」を少しでも埋めることが出来る場所、それが<span class="gold">＜ONE AND ONLY＞</span>の世界。</p>\r\n\r\n        <p>\r\n          もちろん馬券を購入するのは、一般の競馬ファンだけでなく、馬主や牧場関係者も馬券を購入できる立場であるからこそ、馬主関係者や生産牧場関係者を中心とし、【完全招待制】【会員制】を導入させていただいたというわけである。</p>\r\n\r\n        <p>情報を持っている者同士が交流し、情報を共有することで［WIN＝WIN］の関係を構築していくための<span class="gold">＜ONE AND ONLY＞</span>の世界で、より充実した競馬ライフ・馬主ライフをお過ごし頂きたい。\r\n        </p>\r\n\r\n        <p>本気で競馬を愛する者同士が、一般競馬ファンとは次元の違う領域で上質な競馬を楽しんでいただく場所を、<span class="gold">＜ONE AND ONLY＞</span>という名を用いて、業界で初めて導入した経緯をご理解ください。\r\n        </p>\r\n\r\n        <p>そのため<span class="gold">＜ONE AND ONLY＞</span>の会員登録については、</p>\r\n\r\n        <p class="center txt23 red">馬主関係者様<br>\r\n          牧場関係者様<br>\r\n          競馬メディア関係者様<br>\r\n          競馬サークル関係者様<br>\r\n        </p>\r\n\r\n        <p>そして、信頼ある競馬関係者の会員様の紹介を受けて、「情報の取り扱いに関して信用できる一般会員様」に限らせて頂いております。</p>\r\n\r\n        <p>\r\n          また長期的にご愛顧頂いている会員様や情報提供をくださっている会員様、有料情報に数多く参加されている会員様におかれましては、より快適に、より有益に弊社をご利用いただけるサービスプログラムを用意するために、＜ステータス制度＞を設けております。</p>\r\n\r\n        <p class="center"><a href="{{ route(\'about_two\') }}">＜ステータス制度＞に関する詳細はこちら！</a></p>\r\n\r\n      </div>', 0, '2018-10-16 14:39:36', '2018-10-16 14:39:36'),
	(2, 'about-two', 'about_two', '/about-two', '<div id="about01" class="font">\r\n			<p class="center title">「勝ち組になるための秘訣」</p>\r\n\r\n			<p>「村社会」と言われる競馬の世界。<br>\r\n			馬券売り上げで成り立っている競馬の世界とはいえ、実際には裏側に様々な利権が絡んでいるために、一部の内部関係者にしか出回らないような情報が多いのもこの業界の特徴。</p>\r\n\r\n			<p>「競馬ファンにはあえて言わない」という都合の悪い事情もあれば、「自分たちだけ知っていればいい」というような「言わなくていい」といった判断の中には馬券に直結するようなレベルの話ばかりである。</p>\r\n\r\n			<p>なぜ、このようなことが生まれるのか？<br>\r\n			競馬関係者は、「競馬ファンに貴重な情報が出回らない」ということに対しては、問題とは捉えていない。いや、そもそも「貴重」だと思っていない人も多い。</p>\r\n\r\n			<p>競馬ファンからすれば、「最初から言っといてくれよ！」「教えてくれよ！」といったニーズも生まれるわけだが、「聞かれなければ答える必要がない」という競馬関係者の考えは当たり前といえば当たり前でもある。</p>\r\n\r\n			<p>つまり、現代競馬メディア業界の役割というのは、『馬券売り上げ増加』『馬券売り上げのキープ』を目的としているために、「競馬関係者しか知らない貴重な情報」を「競馬ファンに届ける」という目的ではないのだ。</p>\r\n\r\n			<p>出走させる側にしてみれば、1つ1つのレースに対する「目的」「意図」は異なる。</p>\r\n\r\n			<p>「1着を目指す」という表向きのテーマは、あくまでも表向き。</p>\r\n\r\n			<p>「ここを叩いて次で勝負」<br>\r\n				「今回はとりあえず使うだけ。経験させたいことがあるから」<br>\r\n				<br>\r\n				といった調教代わりのようにレースにただ使うようなこともあれば、<br>\r\n				<br>\r\n				「確勝を期して、レースを選んだ。負けられない」<br>\r\n				「今後のローテを考えて、ここは勝ちに行く！」<br>\r\n				「賞金が欲しいから、相手関係も見てここを選んだ。なんとかする」<br>\r\n				<br>\r\n			といった必勝モードでレースを迎えることもある。</p>\r\n\r\n			<p>たとえ、同じ馬の出走だとしても、出走に対する経緯、裏事情によって勝負気配が全くことなるだけに、前者のような調教代わりで負けの可能性が高いレースに多額の軍資金を突っ込んでしまえば、負ける確率が高まることは当然。</p>\r\n\r\n			<p>また後者のような必勝ムードの際に、勝負気配が薄い時と同額の軍資金で勝負するのも「もったいない」。</p>\r\n\r\n			<p>「競馬に絶対はない」「ディープインパクトでも負けてしまう時がある」というこれまでの歴史を振り返れば、どんなに鉄板だとしても「敗れてしまう1%の可能性」も常にリスクヘッジを考慮する必要がある。</p>\r\n\r\n			<p>だからこそ、より確率の高いところでこそ、大勝負に挑むことによって、競馬は勝つことが出来るのである。</p>\r\n\r\n			<p>「万馬券配当でなければ、競馬は勝てない」といった考えの方も競馬ファンの中には少なくないが、すべてのレースを同じ視点、同額で馬券購入をしているようであれば、そういう思考になってしまうが、大勝負する価値があるレースに、いつもの倍額、3倍、10倍の軍資金を投入し、的中馬券を掴むことができれば、【一発逆転】は勿論、長期的にみれば【安定した馬券収支】に繋げられることは理解いただけるはず。</p>\r\n\r\n			<p>その【勝負の瞬間】の嗅覚を研ぎ澄ますためにも、弊社内でリリースされる情報や何気ないニュースなどを確認いただきながら、競馬ライフをお楽しみ頂きたい。</p>\r\n\r\n			<p>1日中、毎日、競馬のことを考え続けていられるような方はなかなかいない。<br>\r\n			とはいえ、競馬界は毎日動いている。</p>\r\n\r\n			<p>情報を取り逃さないためにも、日常生活の中、1日5分程度でも、〈ONE AND ONLY〉の世界を覗くことで、【競馬で勝つために必要な下地が自ずと築かれていくこと】は間違いないはず。</p>\r\n\r\n			<p>朝の数分、寝る前の数分、是非とも【勝つためのルーティーン】として、歯磨きをするような感覚で身につけていただきたい。</p>\r\n\r\n			<p>それが自然に出来るようになった時に、【勝負の機を察知する勝者の嗅覚】が間違いなく身についているはずである。。</p>\r\n\r\n		</div>', 0, '2018-10-16 14:44:08', '2018-10-16 14:44:08'),
	(3, 'about-three', 'about_three', '/about-three', '<div id="about01">\r\n			<div class="font">\r\n				<p class="center title">＜ステータス制度の仕組み＞</p>\r\n\r\n				<p>より多くの機会で弊社をご利用いただいている会員様には、より有益なサービスや情報を提供させて頂くために、ステータス制度を導入しております。</p>\r\n				<p>一度昇格した場合には、ステータスが降格することはございません。</p>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide01.jpg\') }}" width="660" height="222"></p>\r\n				<span class="star">★</span>昇格条件は非公開（完全招待制）<br>\r\n				※昇格費用はございません。<br>\r\n				<br>\r\n				<span class="star">★</span>クリスタルメンバー限定特典あり。<br>\r\n				※詳細は昇格時にご案内<br>\r\n				<br>\r\n				<span class="star">★</span>『クリスタルクラス』限定の情報提供へのお申込が可能に。<br>\r\n				・『ダイヤモンドクラス』の情報提供へのお申込も可能。<br>\r\n				・『ゴールドクラス』の情報提供へのお申込も可能。<br>\r\n				・【トライアルパック】への継続お申込も可能。<br>\r\n				・有料会員様限定コンテンツの閲覧が可能。<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide02.jpg\') }}" width="660" height="222"></p>\r\n				<span class="star">★</span>昇格条件は非公開（完全招待制）<br>\r\n				※昇格費用はございません。<br>\r\n				<br>\r\n				<span class="star">★</span>ダイヤモンドメンバー限定特典あり。<br>\r\n				※詳細は昇格時にご案内<br>\r\n				<br>\r\n				<span class="star">★</span>『ダイヤモンドクラス』限定の情報提供へのお申込が可能に。<br>\r\n				・『ゴールドクラス』の情報提供へのお申込も可能。<br>\r\n				・【トライアルパック】への継続お申込も可能。<br>\r\n				・有料会員様限定コンテンツの閲覧が可能。<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide03.jpg\') }}" width="660" height="222"></p>\r\n				<span class="star">★</span>【トライアルパック】参加後に［トライアルメンバー］から［ゴールドメンバー］\r\n				に自動昇格<br>\r\n				・【トライアルパック】への継続お申込も可能。<br>\r\n				<br>\r\n				<span class="star">★</span>【『ゴールドクラス』限定の情報提供へのお申込が可能に。<br>\r\n				<br>\r\n				<span class="star">★</span>【有料会員様限定コンテンツの閲覧が可能。<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide04.jpg\') }}" width="660" height="222"></p>\r\n				<span class="star">★</span>【トライアルパック】にお申込された会員様で、【トライアルパック】に参加中の会員様はトライアルメンバーに昇格<br>\r\n				<br>\r\n				<span class="star">★</span>有料会員様限定コンテンツの閲覧が可能に。<br>\r\n				※【トライアルパック】の参加費用は必要になりますが、昇格費用はございません。<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide05.jpg\') }}" width="660" height="222"></p>\r\n				<span class="star">★</span>一部の情報コンテンツと結果のみ閲覧可能<br>\r\n			</div>\r\n\r\n\r\n\r\n		</div>', 0, '2018-10-16 14:44:39', '2018-10-16 14:53:14'),
	(4, 'column', 'column', '/column', '<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br></p>', 0, '2018-10-16 14:45:42', '2018-10-16 14:45:42'),
	(5, 'list', 'list', '/list', '<div id="list">\r\n			<div class="font">\r\n				<p class="center title">主な提供商品ラインナップ</p>\r\n\r\n				<p class="center">ONE AND ONLYの世界でご堪能いただける主な商品群</p>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide01.jpg\') }}" width="660" height="222"></p>\r\n				クリスタルクラス限定提供<br>\r\n				＜情報レベル＞<span class="star">★★★★★</span>以上<br>\r\n				【GREAT-NINE】牧場系コラボ情報<br>\r\n				【ONLY ONE】究極の1点提供<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide02.jpg\') }}" width="660" height="222"></p>\r\n				ダイヤモンドクラス限定提供<br>\r\n				＜情報レベル＞<span class="star">★★★★</span>以上<br>\r\n				【RECEPTION RACE】接待レース<br>\r\n				【THE STALLION】種牡馬系情報<br>\r\n				【PERFECT-TRIFECTA】究極の3連単提供<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide03.jpg\') }}" width="660" height="222"></p>\r\n				ゴールドクラス限定提供<br>\r\n				＜情報レベル＞<span class="star">★★★</span>以上<br>\r\n				【OWNERS SECRET】馬主情報網限定の極秘情報<br>\r\n				【AGENT-EYE】騎手エージェント情報筋の勝負情報<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class="rank-info">\r\n				<p class="rank-img"><img src="{{ asset(\'frontend/images/slide04.jpg\') }}" width="660" height="222"></p>\r\n				トライアルメンバー<br>\r\n				＜情報レベル＞<span class="star">☆～☆☆☆</span><br>\r\n				【トライアルパック】<br>\r\n				記者の取材によるオフレコ情報のパッケージ<br>\r\n			</div>\r\n\r\n		</div>', 0, '2018-10-16 14:47:30', '2018-10-16 14:47:30'),
	(6, 'week', 'week', '/week', '<div id="list">\r\n        <div class="font">\r\n          <p class="center title">主な提供商品ラインナップ</p>\r\n\r\n          <p class="center">ONE AND ONLYの世界でご堪能いただける主な商品群</p>\r\n        </div>\r\n\r\n        <div class="rank-info">\r\n          <p class="rank-img"><img src="{{ asset(\'frontend/images/slide01.jpg\') }}" width="660" height="222"></p>\r\n          クリスタルクラス限定提供<br>\r\n          ＜情報レベル＞<span class="star">★★★★★</span>以上<br>\r\n          【GREAT-NINE】牧場系コラボ情報<br>\r\n          【ONLY ONE】究極の1点提供<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class="rank-info">\r\n          <p class="rank-img"><img src="{{ asset(\'frontend/images/slide02.jpg\') }}" width="660" height="222"></p>\r\n          ダイヤモンドクラス限定提供<br>\r\n          ＜情報レベル＞<span class="star">★★★★</span>以上<br>\r\n          【RECEPTION RACE】接待レース<br>\r\n          【THE STALLION】種牡馬系情報<br>\r\n          【PERFECT-TRIFECTA】究極の3連単提供<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class="rank-info">\r\n          <p class="rank-img"><img src="{{ asset(\'frontend/images/slide03.jpg\') }}" width="660" height="222"></p>\r\n          ゴールドクラス限定提供<br>\r\n          ＜情報レベル＞<span class="star">★★★</span>以上<br>\r\n          【OWNERS SECRET】馬主情報網限定の極秘情報<br>\r\n          【AGENT-EYE】騎手エージェント情報筋の勝負情報<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class="rank-info">\r\n          <p class="rank-img"><img src="{{ asset(\'frontend/images/slide04.jpg\') }}" width="660" height="222"></p>\r\n          トライアルメンバー<br>\r\n          ＜情報レベル＞<span class="star">☆～☆☆☆</span><br>\r\n          【トライアルパック】<br>\r\n          記者の取材によるオフレコ情報のパッケージ<br>\r\n        </div>\r\n\r\n      </div>', 0, '2018-10-16 14:48:40', '2018-10-16 14:48:40'),
	(7, 'faq', 'faq', '/faq', '<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br></p>', 0, '2018-10-16 14:49:12', '2018-10-16 14:49:12'),
	(8, 'agree', 'agree', '/agree', '<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br></p>', 0, '2018-10-16 14:49:40', '2018-10-16 14:49:40'),
	(9, 'privacy', 'privacy', '/privacy', '<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br></p>', 0, '2018-10-16 14:49:56', '2018-10-16 14:49:56'),
	(10, 'trans', 'trans', '/trans', '<p>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br></p>', 0, '2018-10-16 14:50:12', '2018-10-16 14:50:12');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.point
CREATE TABLE IF NOT EXISTS `point` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `point` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `point_point_unique` (`point`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.point: ~0 rows (approximately)
/*!40000 ALTER TABLE `point` DISABLE KEYS */;
INSERT INTO `point` (`id`, `point`, `price`, `deleted_flg`, `created_at`, `updated_at`) VALUES
	(1, 30, 3000, 0, '2018-10-21 03:33:17', '2018-10-21 03:33:17'),
	(2, 50, 5000, 0, '2018-10-21 03:33:28', '2018-10-21 03:33:28'),
	(3, 100, 10000, 0, '2018-10-21 03:33:37', '2018-10-21 03:33:37'),
	(4, 140, 14000, 0, '2018-10-21 03:33:50', '2018-10-21 03:33:50'),
	(5, 200, 20000, 0, '2018-10-21 03:33:59', '2018-10-21 03:33:59'),
	(6, 300, 30000, 0, '2018-10-21 03:34:07', '2018-10-21 03:34:07'),
	(7, 400, 40000, 0, '2018-10-21 03:34:16', '2018-10-21 03:34:16'),
	(8, 500, 50000, 0, '2018-10-21 03:34:27', '2018-10-21 03:34:27'),
	(9, 700, 70000, 0, '2018-10-21 03:34:37', '2018-10-21 03:34:37'),
	(10, 800, 80000, 0, '2018-10-21 03:34:47', '2018-10-21 03:34:47'),
	(11, 900, 90000, 0, '2018-10-21 03:34:58', '2018-10-21 03:34:58'),
	(12, 1000, 100000, 0, '2018-10-21 03:35:09', '2018-10-21 03:35:09'),
	(13, 1200, 120000, 0, '2018-10-21 03:35:26', '2018-10-21 03:35:26'),
	(14, 1500, 150000, 0, '2018-10-21 03:35:37', '2018-10-21 03:35:37');
/*!40000 ALTER TABLE `point` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.prediction
CREATE TABLE IF NOT EXISTS `prediction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_level` int(11) NOT NULL DEFAULT '0',
  `prediction_type` tinyint(4) NOT NULL DEFAULT '0',
  `default_point` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `after_buy` longtext COLLATE utf8mb4_unicode_ci,
  `result` longtext COLLATE utf8mb4_unicode_ci,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `number_buyer` int(11) NOT NULL DEFAULT '0',
  `display_order` int(11) NOT NULL DEFAULT '0',
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `send_mail_open` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail_done` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.prediction: ~0 rows (approximately)
/*!40000 ALTER TABLE `prediction` DISABLE KEYS */;
/*!40000 ALTER TABLE `prediction` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.prediction_result
CREATE TABLE IF NOT EXISTS `prediction_result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prediction_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `prediction_type` int(11) NOT NULL,
  `race_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `race_no` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hit_race` double NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `race_date` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `reserve_datetime` timestamp NULL DEFAULT NULL,
  `send_mail` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.prediction_result: ~0 rows (approximately)
/*!40000 ALTER TABLE `prediction_result` DISABLE KEYS */;
/*!40000 ALTER TABLE `prediction_result` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.transaction_deposit
CREATE TABLE IF NOT EXISTS `transaction_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `method` tinyint(4) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `result` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.transaction_deposit: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaction_deposit` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_deposit` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.transaction_gift
CREATE TABLE IF NOT EXISTS `transaction_gift` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `gift_id` int(11) NOT NULL DEFAULT '0',
  `gift_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.transaction_gift: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaction_gift` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_gift` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.transaction_payment
CREATE TABLE IF NOT EXISTS `transaction_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `prediction_id` int(11) NOT NULL,
  `prediction_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail_payment` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail_prediction_result` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.transaction_payment: ~0 rows (approximately)
/*!40000 ALTER TABLE `transaction_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_payment` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_id` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_key` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `age` int(11) NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `mail_pc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_time` timestamp NULL DEFAULT NULL,
  `interim_register_time` timestamp NULL DEFAULT NULL,
  `send_mail` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_login_id_unique` (`login_id`),
  UNIQUE KEY `user_user_key_unique` (`user_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.user_access_prediction
CREATE TABLE IF NOT EXISTS `user_access_prediction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prediction_id` int(11) NOT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `buy` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.user_access_prediction: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_access_prediction` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_access_prediction` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.user_activity
CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `point_payment` int(11) NOT NULL DEFAULT '0',
  `point_deposit` int(11) NOT NULL DEFAULT '0',
  `point_gift` int(11) NOT NULL DEFAULT '0',
  `deposit_number` int(11) NOT NULL DEFAULT '0',
  `deposit_amount` int(11) NOT NULL DEFAULT '0',
  `payment_number` int(11) NOT NULL DEFAULT '0',
  `login_number` int(11) NOT NULL DEFAULT '0',
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL,
  `last_access_time` timestamp NULL DEFAULT NULL,
  `first_deposit_time` timestamp NULL DEFAULT NULL,
  `last_deposit_time` timestamp NULL DEFAULT NULL,
  `first_payment_time` timestamp NULL DEFAULT NULL,
  `last_payment_time` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.user_activity: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activity` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.user_daily_access_history
CREATE TABLE IF NOT EXISTS `user_daily_access_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_date` timestamp NULL DEFAULT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.user_daily_access_history: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_daily_access_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_daily_access_history` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.user_daily_login_history
CREATE TABLE IF NOT EXISTS `user_daily_login_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_date` timestamp NULL DEFAULT NULL,
  `login_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.user_daily_login_history: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_daily_login_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_daily_login_history` ENABLE KEYS */;

-- Dumping structure for table hr_v3_data.venue
CREATE TABLE IF NOT EXISTS `venue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table hr_v3_data.venue: ~5 rows (approximately)
/*!40000 ALTER TABLE `venue` DISABLE KEYS */;
INSERT INTO `venue` (`id`, `name`, `css`, `deleted_flg`, `created_at`, `updated_at`) VALUES
	(1, 'test', 'test', 1, '2018-10-15 08:24:58', '2018-10-18 15:57:43'),
	(2, 'test', 'test', 0, '2018-10-15 08:25:09', '2018-10-15 08:25:09'),
	(3, 'test', 'test', 0, '2018-10-15 08:25:25', '2018-10-15 08:25:39'),
	(4, 'adfadf', 'adfadf', 0, '2018-10-18 15:56:06', '2018-10-18 15:56:06'),
	(5, 'adf', 'adf', 0, '2018-10-18 15:57:38', '2018-10-18 15:57:38');
/*!40000 ALTER TABLE `venue` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
