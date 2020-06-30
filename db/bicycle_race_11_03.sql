-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th3 10, 2019 lúc 10:25 PM
-- Phiên bản máy phục vụ: 5.7.23
-- Phiên bản PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bicycle_race`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_flg` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `login_id`, `password`, `password_text`, `role_code`, `media_code`, `remember_token`, `billing_flg`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'admin123456', 'admin@gmail.com', 'admin123456', '$2y$10$DpLHc0t5AKiI8P9PAcAEpuqs/hemtywE15Are.r2YNpjMxdFNYO4O', 'admin123456', 'admin', NULL, 'fB0hiFFPHEuOqDfg2eGCSifSXMmE5fZMQDO7RUk5YuvMVVtSyHh0ILZ2OWnQ', 0, 0, '2018-10-20 21:55:09', '2018-10-23 21:15:57'),
(2, 'partner', NULL, '123456', '$2y$10$uj8ds9ngJIu24cg/lWBwx.7dmRdYLKp.Gu4neI6CsdVMMeMrTfBH2', '123456', 'partner', 'zzz', NULL, 0, 0, '2019-03-01 10:38:36', '2019-03-01 10:38:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `public_at` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blog`
--

INSERT INTO `blog` (`id`, `title`, `status`, `content`, `number_access`, `public_at`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'Huynh_create', 1, 'hehe', 1, '2019-03-05 17:00:00', 1, '2019-03-07 12:56:03', '2019-03-08 06:37:02'),
(2, 'Huynh_change_prediction', 0, '<p>what the hell</p>', 1, '2019-03-07 17:00:00', 1, '2019-03-08 04:42:12', '2019-03-08 06:05:27'),
(3, 'Huynh_change_prediction', 0, '<p>what the hell</p>', 2, '2019-03-07 17:00:00', 0, '2019-03-08 04:43:14', '2019-03-09 08:08:42'),
(4, 'change something', 0, '<p>hehe haha</p>', 1, '2019-03-07 17:00:00', 1, '2019-03-08 04:43:30', '2019-03-08 06:10:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `entrance`
--

CREATE TABLE `entrance` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_point` int(11) NOT NULL DEFAULT '0',
  `default_user_stage` int(11) DEFAULT NULL,
  `default_flg` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `entrance`
--

INSERT INTO `entrance` (`id`, `name`, `default_point`, `default_user_stage`, `default_flg`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'デフォルト', 0, 11, 1, 0, '2018-11-02 21:22:10', '2019-01-15 23:51:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `frontend_image`
--

CREATE TABLE `frontend_image` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `frontend_image`
--

INSERT INTO `frontend_image` (`id`, `name`, `code`, `image`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, NULL, 'attention', '/uploads/image/1552281518_server.png', 0, '2019-03-10 06:59:35', '2019-03-11 07:18:38'),
(12, NULL, 'logo', 'hhkkk', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gift`
--

CREATE TABLE `gift` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `send_date` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gift`
--

INSERT INTO `gift` (`id`, `name`, `point`, `type`, `send_date`, `content`, `start_time`, `end_time`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'Register 10 point', 10, 1, NULL, '<p>You have 10 point for register<br></p>', '2018-10-22 05:00:00', '2019-10-22 05:00:00', 1, '2018-10-22 08:09:43', '2018-10-22 08:09:43'),
(2, 'Register 50 point', 50, 1, NULL, 'You have 50 point for register<br><p><br></p>', '2018-10-22 05:00:00', '2019-10-22 05:00:00', 1, '2018-10-22 08:10:15', '2018-10-22 08:10:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_ban`
--

CREATE TABLE `mail_ban` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_ban`
--

INSERT INTO `mail_ban` (`id`, `mail`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '@i.is-hacked.ga', 0, '2019-01-23 01:43:25', '2019-01-23 01:43:25'),
(2, 'theresia616@i.is-hacked.ga', 0, '2019-01-23 01:43:32', '2019-01-23 01:43:32'),
(3, 'spam@spam2.com', 0, '2019-01-23 01:44:19', '2019-01-23 01:44:19'),
(4, 'spam@spam.com', 0, '2019-01-23 01:44:27', '2019-01-23 01:44:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_bulk`
--

CREATE TABLE `mail_bulk` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_bulk`
--

INSERT INTO `mail_bulk` (`id`, `reserve_datetime`, `mail_from_address`, `mail_from_name`, `mail_title`, `mail_body`, `condition`, `list_user`, `total_user`, `status`, `bulk_number`, `bulk_send_number`, `send_datetime`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '2019-03-04 14:29:00', 'info@kamikeirin.jp', 'One and only', 'huynh_send_mail', '<p>testtttttttttt</p>', '{\"login_id\":\"3841308\"}', '{\"1\":1}', 1, 2, NULL, NULL, NULL, 0, '2019-03-06 16:29:59', '2019-03-06 16:31:11'),
(2, '2019-03-01 14:32:00', 'info@kamikeirin.jp', 'One and only', 'huynh_send_mail_again', '<p>ưedsdsdsd</p>', '{\"login_id\":null,\"user_key\":null,\"point_min\":null,\"point_max\":null,\"nickname\":null,\"member_level\":null,\"deposit_total_amount_min\":null,\"deposit_total_amount_max\":null,\"age\":null,\"deposit_total_number_min\":null,\"deposit_total_number_max\":null,\"mail_pc\":null,\"mail_mobile\":null,\"login_number_min\":null,\"login_number_max\":null,\"ip\":null,\"prediction_type\":null,\"register_time_start\":null,\"register_time_end\":null,\"media_code\":null,\"entrance_id\":null,\"stop_mail\":null,\"specify_stage\":\"1\",\"first_deposit_time_start\":null,\"first_deposit_time_end\":null,\"last_deposit_time_start\":null,\"last_deposit_time_end\":null,\"first_payment_time_start\":null,\"first_payment_time_end\":null,\"last_payment_time_start\":null,\"last_payment_time_end\":null,\"last_login_time_start\":null,\"last_login_time_end\":null,\"user_register\":true}', '{\"1\":1,\"2\":2}', 2, 0, NULL, NULL, NULL, 0, '2019-03-06 16:32:54', '2019-03-06 16:32:54'),
(3, '2019-03-04 14:40:00', 'info@kamikeirin.jp', 'One and only', 'huynh_send_mail_again', '<p>lllllllllllllllllll</p>', '{\"login_id\":\"3841308\"}', '{\"1\":1}', 1, 0, NULL, NULL, NULL, 0, '2019-03-06 16:40:39', '2019-03-06 16:40:39'),
(4, '2019-03-04 14:43:00', 'info@kamikeirin.jp', 'One and only', 'huynh_test_mail', '<p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>', '{\"login_id\":\"8709418\"}', '{\"2\":2}', 1, 0, NULL, NULL, NULL, 0, '2019-03-06 16:43:16', '2019-03-06 16:43:16'),
(5, '2019-03-04 14:47:00', 'info@kamikeirin.jp', 'One and only', 'huynh_send_mail', '<p>i love you</p>', '{\"login_id\":\"3841308\"}', '{\"1\":1}', 1, 0, NULL, NULL, NULL, 0, '2019-03-06 16:48:04', '2019-03-06 16:48:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_bulk_detail`
--

CREATE TABLE `mail_bulk_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_bulk_done`
--

CREATE TABLE `mail_bulk_done` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_bulk_id` int(11) NOT NULL,
  `total_user` int(11) NOT NULL,
  `send_success_number` int(11) NOT NULL,
  `read_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_contact`
--

CREATE TABLE `mail_contact` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_contact`
--

INSERT INTO `mail_contact` (`id`, `user_id`, `mail_from_address`, `mail_from_name`, `mail_to_address`, `mail_to_name`, `mail_title`, `mail_body`, `status`, `user_read_at`, `admin_read_at`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadsf', 0, '2019-02-26 05:54:05', '2019-03-06 16:41:57', 0, '2019-02-26 05:54:05', '2019-03-06 16:41:57'),
(2, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadsf', 0, '2019-02-26 05:58:27', '2019-03-06 16:41:57', 0, '2019-02-26 05:58:27', '2019-03-06 16:41:57'),
(3, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadsf', 0, '2019-02-26 05:59:04', '2019-03-06 16:41:57', 0, '2019-02-26 05:59:04', '2019-03-06 16:41:57'),
(4, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadf', 0, '2019-02-26 06:00:37', '2019-03-06 16:41:57', 0, '2019-02-26 06:00:37', '2019-03-06 16:41:57'),
(5, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadf', 0, '2019-02-26 06:01:32', '2019-03-06 16:41:57', 0, '2019-02-26 06:01:32', '2019-03-06 16:41:57'),
(6, 1, 'testuser001@gmail.com', 'test', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadf', 0, '2019-02-26 06:02:49', '2019-03-06 16:41:57', 0, '2019-02-26 06:02:49', '2019-03-06 16:41:57'),
(7, 0, 'adfa@adfad', 'GUEST', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadf', 0, '2019-03-01 10:06:05', '2019-03-06 16:44:36', 0, '2019-03-01 10:06:05', '2019-03-06 16:44:36'),
(8, 0, 'adfa@adfad', 'GUEST', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'adfadf', 0, '2019-03-01 10:06:56', '2019-03-06 16:44:36', 0, '2019-03-01 10:06:56', '2019-03-06 16:44:36'),
(9, 1, 'testuser12345@gmail.com', 'khanh', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', '', 0, '2019-03-06 16:28:09', '2019-03-06 16:41:57', 0, '2019-03-06 16:28:09', '2019-03-06 16:41:57'),
(10, 1, 'testuser12345@gmail.com', 'khanh', 'info@kamikeirin.jp', 'One and only', 'お問い合わせ', 'come with me!', 0, '2019-03-06 16:45:41', NULL, 0, '2019-03-06 16:45:41', '2019-03-06 16:45:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_deposit_detail`
--

CREATE TABLE `mail_deposit_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_gift_detail`
--

CREATE TABLE `mail_gift_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_interim_detail`
--

CREATE TABLE `mail_interim_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_template_interim_id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_payment_detail`
--

CREATE TABLE `mail_payment_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_prediction_open_detail`
--

CREATE TABLE `mail_prediction_open_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_prediction_result_detail`
--

CREATE TABLE `mail_prediction_result_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_register_detail`
--

CREATE TABLE `mail_register_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_register_detail`
--

INSERT INTO `mail_register_detail` (`id`, `user_id`, `mail_template_register_id`, `mail_from_address`, `mail_from_name`, `mail_to_address`, `mail_to_name`, `mail_title`, `mail_body`, `status`, `read_at`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 2, 12, 'info@kamikeirin.jp', 'One and only', 'testuser12345@gmail.com', 'teo', '【重要】本登録審査通過おめでとうございます。', '<p><span style=\"font-size: 1rem;\">おめでとうございます！</span><span style=\"font-size: 1rem;\"><br>【ワンアンドオンリー】でございます。<br></span><span style=\"font-size: 1rem;\"><br>この度は、無事に無料本登録会員の審査に通過されましたので、まずは［トライアルメンバー］として【ワンアンドオンリー】の世界で、競馬をお楽しみいただけるようになりました。<br></span><span style=\"font-size: 1rem;\"><br>審査内容につきましては、詳細を申し上げることはできませんが、過去に情報漏洩などをされたことのある会員様リストにあがっているメールアドレス等を照合させていただきました。<br></span><span style=\"font-size: 1rem;\"><br>審査通過にともない［限定コラム］コーナーにおいて、競馬関係者より寄せられる極秘情報等を閲覧いただくことや、各種情報提供に参加いただけるようになります。<br></span><span style=\"font-size: 1rem;\"><br>【ワンアンドオンリー】の世界を知っていただき、有益にご利用いただくためにも、まずはログイン後に下記手順に沿ってサイト内をご覧ください。<br></span><span style=\"font-size: 1rem;\"><br>［1］『初めての方』をクリック。</span></p><p>［2］「ONE AND ONLYとは」を確認。</p><p>［3］「ランクの仕組み」を確認。</p><p>［4］「勝ち組になるための秘訣」を確認。<br><span style=\"font-size: 1rem;\"><br>上記3ページは必ずご確認ください。こちらを確認された方とそうではない方とでは、将来的に大きな格差が出ることになります。</span></p><p>弊社はステータス制度（ランク制度）を導入しておりますが、昇格時には昇格費用はかかりません。<br><span style=\"font-size: 1rem;\"><br>━━━━━━━━━━━━━━━━</span></p><p>◇会員ID番号&nbsp; 【<span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">7398975</span>】</p><p>◇パスワード&nbsp; 【<span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">12345</span>】<br><span style=\"font-size: 1rem;\"><br>◆ログインURL</span></p><p><span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\"><a href=\"http://localhost/bicycle-race/public/login/DJnxLR580q\">http://localhost/bicycle-race/public/login/DJnxLR580q</a></span><br></p><p>━━━━━━━━━━━━━━━━<br><span style=\"font-size: 1rem;\"><br>発行元：ワンアンドオンリー</span></p>', 1, '2019-03-09 16:16:26', 0, '2019-03-09 16:16:00', '2019-03-09 16:16:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_replace`
--

CREATE TABLE `mail_replace` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `source` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_replace`
--

INSERT INTO `mail_replace` (`id`, `name`, `type`, `source`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'ログインID', 0, '<p>%login_id%<br></p>', 0, '2018-10-18 23:45:54', '2018-11-09 20:23:13'),
(2, 'ハッシュ', 0, '<p>%user_key%<br></p>', 0, '2018-10-18 23:46:08', '2018-11-09 20:23:28'),
(3, 'パスワード', 0, '<p>%password%<br></p>', 0, '2018-10-18 23:46:28', '2018-11-09 20:23:52'),
(4, 'ハンドルネーム', 0, '<p>%nickname%<br></p>', 0, '2018-10-18 23:46:39', '2018-11-09 20:27:36'),
(5, '性別', 0, '<p>%gender%<br></p>', 0, '2018-10-18 23:46:50', '2018-11-09 20:27:49'),
(6, '年代', 0, '<p>%age%<br></p>', 0, '2018-10-18 23:47:01', '2018-11-09 20:27:58'),
(7, '現在のメンバーシップ', 0, '<p>%member_level%<br></p>', 0, '2018-10-18 23:47:28', '2018-11-09 20:28:10'),
(8, 'PCメールアドレス', 0, '<p>%mail_pc%<br></p>', 0, '2018-10-18 23:48:01', '2018-11-10 00:36:44'),
(9, 'モバイルメールアドレス', 0, '<p>%mail_mobile%<br></p>', 0, '2018-10-18 23:48:15', '2018-11-10 00:37:04'),
(10, '登録日時', 0, '<p>%register_time%<br></p>', 0, '2018-10-18 23:48:33', '2018-11-10 00:37:12'),
(11, '仮登録日時', 0, '<p>%interim_register_time%<br></p>', 0, '2018-10-18 23:48:56', '2018-11-10 00:37:20'),
(12, 'user deleted', 0, '<p>%user_deleted%<br></p>', 1, '2018-10-18 23:49:19', '2018-10-18 23:55:49'),
(13, 'ユーザー所有ポイント', 0, '<p>%user_point%<br></p>', 0, '2018-10-18 23:49:32', '2018-11-10 00:40:07'),
(14, 'ログイン回数', 0, '<p>%login_number%<br></p>', 0, '2018-10-18 23:49:46', '2018-11-10 01:10:01'),
(15, '最終ログイン日時', 0, '<p>%last_login_time%<br></p>', 0, '2018-10-18 23:50:00', '2018-11-10 01:10:16'),
(16, '最終アクセス日時', 0, '<p>%last_access_time%<br></p>', 0, '2018-10-18 23:50:16', '2018-11-10 01:10:26'),
(17, '最終課金日時', 0, '<p>%first_payment_time%<br></p>', 0, '2018-10-18 23:50:35', '2018-11-10 01:10:33'),
(18, '最終課金日時', 0, '<p>%last_payment_time%<br></p>', 0, '2018-10-18 23:50:49', '2018-11-10 01:11:46'),
(19, '購入買い目情報名', 0, '<p>%prediction_name%<br>ユーザーが最後に購入した買い目情報名です。<br><span style=\"font-size: 1rem;\">買い目情報一覧で表示される「名前」が入ります。</span></p>', 0, '2018-10-18 23:51:08', '2018-11-10 01:15:29'),
(20, '買い目情報ポイント', 0, '<p>%prediction_point%<br>ユーザーが最後に購入した買い目情報のポイントが入ります。</p>', 0, '2018-10-18 23:51:48', '2018-11-10 01:16:07'),
(21, 'ポイント付与総額', 0, '<p>%gift_point%</p><p>システムがユーザーに自動で追加した / または手動で追加したポイントの総額です。</p>', 0, '2018-10-18 23:52:03', '2018-11-10 01:22:20'),
(22, '購入ポイント数', 0, '<p>%trans_point%</p><p>ユーザーが最後に購入したポイント数です。</p>', 0, '2018-10-18 23:52:38', '2018-11-10 01:23:38'),
(23, '購入金額', 0, '<p>%trans_amount%</p><p>ユーザーが最後に購入した金額です。<br></p>', 0, '2018-10-18 23:53:01', '2018-11-10 01:23:58'),
(24, 'prediction id', 0, '<p>%prediction_id%<br></p>', 1, '2018-10-18 23:53:21', '2018-10-18 23:53:21'),
(25, '買い目情報URL', 0, '<p>%url_prediction_[ID]%</p><p>ユーザーが購入した買い目情報URLが記載されます。<br>[ID]にIDを入力してください。</p><p>例：%url_prediction_1%<br>※買い目情報単体のURLです。メンバーシップページではありません。<br></p>', 0, '2018-10-22 13:16:17', '2018-11-10 01:36:23'),
(26, '本登録URL', 0, '<p><span style=\"color: rgb(68, 68, 68); font-family: &quot;Hiragino Kaku Gothic Pro&quot;, &quot;ヒラギノ角ゴ Pro W3&quot;, &quot;ＭＳ Ｐゴシック&quot;, Osaka; font-size: 13px; white-space: nowrap;\">%regist_url%</span><br></p>', 1, '2018-11-07 17:04:43', '2018-11-07 17:04:43'),
(27, '本登録用URL', 0, '<p><span style=\"color: rgb(68, 68, 68); font-family: &quot;Hiragino Kaku Gothic Pro&quot;, &quot;ヒラギノ角ゴ Pro W3&quot;, &quot;ＭＳ Ｐゴシック&quot;, Osaka; font-size: 13px; white-space: nowrap;\">%regist_url%</span><br></p>', 1, '2018-11-07 17:32:04', '2018-11-07 17:32:04'),
(28, 'ログインURL', 0, '<p><span style=\"color: rgb(68, 68, 68); font-family: &quot;Hiragino Kaku Gothic Pro&quot;, &quot;ヒラギノ角ゴ Pro W3&quot;, &quot;ＭＳ Ｐゴシック&quot;, Osaka; font-size: 13px; white-space: nowrap;\">%login_url%</span><br></p>', 1, '2018-11-07 17:32:40', '2018-11-07 17:32:40'),
(29, '本登録用URL', 0, '<p>%url_login%</p>', 0, '2018-11-07 17:36:47', '2018-11-16 22:09:45'),
(30, '限定コラム', 0, '<p>%url_blog_[ID]%</p><p>[ID] にコンテンツIDを入力してください。<br>例：<span style=\"font-size: 1rem;\">%url_blog_1%</span></p>', 0, '2018-11-10 01:33:10', '2018-11-10 01:33:10'),
(31, '的中実績へのリンク', 0, '<p>%url_result%</p><p>※ ログアウト状態のユーザーがアクセスすると、自動でログインし、的中実績のトップページへ飛びます。</p>', 0, '2018-12-28 00:40:06', '2018-12-28 00:40:06'),
(32, '限定コラムへのリンク', 0, '<p>%url_column%</p><p><span style=\"color: rgb(52, 73, 95); white-space: nowrap;\">※ ログアウト状態のユーザーがアクセスすると、自動でログインし、限定コラムのトップページへ飛びます。</span><br></p>', 0, '2018-12-28 00:40:51', '2018-12-28 00:40:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_schedule`
--

CREATE TABLE `mail_schedule` (
  `id` int(10) UNSIGNED NOT NULL,
  `schedule_type` tinyint(4) DEFAULT NULL,
  `properties` tinyint(4) DEFAULT NULL,
  `target` tinyint(4) DEFAULT NULL,
  `elapsed_time` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_schedule`
--

INSERT INTO `mail_schedule` (`id`, `schedule_type`, `properties`, `target`, `elapsed_time`, `reserve_datetime`, `day_of_week`, `week_time_send`, `daily_hour`, `mail_from_address`, `mail_from_name`, `mail_title`, `mail_body`, `memo`, `condition`, `status`, `send_datetime`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(11, NULL, 1, 4, '0:00:00:00', NULL, NULL, NULL, NULL, 'info@kamikeirin.jp', 'One and only', 'ワンアンドオンリーでございます。', '<p class=\"p1\">空メールの送信ありがとうございます。<br><br></p><p class=\"p1\">業界初の至高のシークレット空間！</p><p class=\"p1\">「競馬関係者の社交場」＝弊社【ワンアンドオンリー】にご登録いただきまして、誠にありがとうございます。<br><br></p><p class=\"p1\"><span class=\"s1\">※</span>このメールを受信いただいた現時点では、まだ本登録は完了しておりません。<br><br></p><p class=\"p1\">無料コンテンツを含む【ワンアンドオンリー】の情報提供を閲覧いただくには無料本登録が必要となりますので、下記<span class=\"s1\">URL</span>をクリックしていただくことで無料本登録が完了致します。<br><br></p><p class=\"p3\">━━━━━━━━━━━━━━━━</p><p class=\"p1\"><span class=\"s2\">◆</span>無料本登録用<span class=\"s1\">URL</span></p><p class=\"p3\"><span style=\"color: rgb(52, 73, 95); font-family: Poppins; font-size: 14px; white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">%url_login%</span><br></p><p class=\"p3\">━━━━━━━━━━━━━━━━<br><br></p><p class=\"p1\">本登録が完了いたしますと、重要なお知らせが記載されている本登録完了会員様限定のメールがお手元に届きますので、必ずご確認ください。<br><br>発行元：ワンアンドオンリー</p><style type=\"text/css\">\r\np.p1 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px \'Hiragino Sans\'}\r\np.p2 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px Helvetica; min-height: 14.0px}\r\np.p3 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px Helvetica}\r\nspan.s1 {font: 12.0px Helvetica}\r\nspan.s2 {font: 12.0px \'Lucida Grande\'}\r\n</style>', NULL, '{\"gender\":null,\"login_id\":null,\"point_min\":null,\"point_max\":null,\"user_key\":null,\"deposit_total_amount_min\":null,\"deposit_total_amount_max\":null,\"nickname\":null,\"deposit_total_number_min\":null,\"deposit_total_number_max\":null,\"member_level\":null,\"login_number_min\":null,\"login_number_max\":null,\"mail_pc\":null,\"last_payment_time_start\":null,\"last_payment_time_end\":null,\"mail_mobile\":null,\"register_time_start\":null,\"register_time_end\":null,\"age\":null,\"last_login_time_start\":null,\"last_login_time_end\":null,\"first_deposit_time_start\":null,\"first_deposit_time_end\":null,\"last_deposit_time_start\":null,\"last_deposit_time_end\":null,\"ip\":null,\"first_payment_time_start\":null,\"first_payment_time_end\":null,\"prediction_type\":null,\"media_code\":null,\"entrance_id\":null,\"user_stage_id\":null}', 0, NULL, 0, '2018-12-12 02:30:26', '2018-12-18 23:14:34'),
(12, NULL, 1, 1, '0:00:05:00', NULL, NULL, NULL, NULL, 'info@kamikeirin.jp', 'One and only', '【重要】本登録審査通過おめでとうございます。', '<p><span style=\"font-size: 1rem;\">おめでとうございます！</span><span style=\"font-size: 1rem;\"><br>【ワンアンドオンリー】でございます。<br></span><span style=\"font-size: 1rem;\"><br>この度は、無事に無料本登録会員の審査に通過されましたので、まずは［トライアルメンバー］として【ワンアンドオンリー】の世界で、競馬をお楽しみいただけるようになりました。<br></span><span style=\"font-size: 1rem;\"><br>審査内容につきましては、詳細を申し上げることはできませんが、過去に情報漏洩などをされたことのある会員様リストにあがっているメールアドレス等を照合させていただきました。<br></span><span style=\"font-size: 1rem;\"><br>審査通過にともない［限定コラム］コーナーにおいて、競馬関係者より寄せられる極秘情報等を閲覧いただくことや、各種情報提供に参加いただけるようになります。<br></span><span style=\"font-size: 1rem;\"><br>【ワンアンドオンリー】の世界を知っていただき、有益にご利用いただくためにも、まずはログイン後に下記手順に沿ってサイト内をご覧ください。<br></span><span style=\"font-size: 1rem;\"><br>［1］『初めての方』をクリック。</span></p><p>［2］「ONE AND ONLYとは」を確認。</p><p>［3］「ランクの仕組み」を確認。</p><p>［4］「勝ち組になるための秘訣」を確認。<br><span style=\"font-size: 1rem;\"><br>上記3ページは必ずご確認ください。こちらを確認された方とそうではない方とでは、将来的に大きな格差が出ることになります。</span></p><p>弊社はステータス制度（ランク制度）を導入しておりますが、昇格時には昇格費用はかかりません。<br><span style=\"font-size: 1rem;\"><br>━━━━━━━━━━━━━━━━</span></p><p>◇会員ID番号&nbsp; 【<span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">%login_id%</span>】</p><p>◇パスワード&nbsp; 【<span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">%password%</span>】<br><span style=\"font-size: 1rem;\"><br>◆ログインURL</span></p><p><span style=\"color: rgb(52, 73, 95); white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">%url_login%</span><br></p><p>━━━━━━━━━━━━━━━━<br><span style=\"font-size: 1rem;\"><br>発行元：ワンアンドオンリー</span></p>', NULL, '{\"gender\":null,\"login_id\":null,\"point_min\":null,\"point_max\":null,\"user_key\":null,\"deposit_total_amount_min\":null,\"deposit_total_amount_max\":null,\"nickname\":null,\"deposit_total_number_min\":null,\"deposit_total_number_max\":null,\"member_level\":null,\"login_number_min\":null,\"login_number_max\":null,\"mail_pc\":null,\"last_payment_time_start\":null,\"last_payment_time_end\":null,\"mail_mobile\":null,\"register_time_start\":null,\"register_time_end\":null,\"age\":null,\"last_login_time_start\":null,\"last_login_time_end\":null,\"first_deposit_time_start\":null,\"first_deposit_time_end\":null,\"last_deposit_time_start\":null,\"last_deposit_time_end\":null,\"ip\":null,\"first_payment_time_start\":null,\"first_payment_time_end\":null,\"prediction_type\":null,\"media_code\":null,\"entrance_id\":null,\"user_stage_id\":null}', 0, NULL, 0, '2018-12-12 02:38:56', '2018-12-27 23:56:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_schedule_detail`
--

CREATE TABLE `mail_schedule_detail` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_schedule_done`
--

CREATE TABLE `mail_schedule_done` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_schedule_id` int(11) NOT NULL,
  `total_user` int(11) NOT NULL,
  `send_success_number` int(11) NOT NULL,
  `read_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mail_template`
--

CREATE TABLE `mail_template` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `mail_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_from_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mail_template`
--

INSERT INTO `mail_template` (`id`, `name`, `type`, `mail_from_address`, `mail_from_name`, `mail_title`, `mail_body`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '仮登録リメール', 1, 'info@1and0nly.jp', 'One and only', 'ワンアンドオンリーでございます。', '<p class=\"p1\">空メールの送信ありがとうございます。<br><br></p><p class=\"p1\">業界初の至高のシークレット空間！</p><p class=\"p1\">「競馬関係者の社交場」＝弊社【ワンアンドオンリー】にご登録いただきまして、誠にありがとうございます。<br><br></p><p class=\"p1\"><span class=\"s1\">※</span>このメールを受信いただいた現時点では、まだ本登録は完了しておりません。<br><br></p><p class=\"p1\">無料コンテンツを含む【ワンアンドオンリー】の情報提供を閲覧いただくには無料本登録が必要となりますので、下記<span class=\"s1\">URL</span>をクリックしていただくことで無料本登録が完了致します。<br><br></p><p class=\"p3\">━━━━━━━━━━━━━━━━</p><p class=\"p1\"><span class=\"s2\">◆</span>無料本登録用<span class=\"s1\">URL</span></p><p class=\"p3\"><span style=\"color: rgb(52, 73, 95); font-family: Poppins; font-size: 14px; white-space: nowrap; background-color: rgba(0, 0, 0, 0.05);\">%url_login%</span><br></p><p class=\"p3\">━━━━━━━━━━━━━━━━<br><br></p><p class=\"p1\">本登録が完了いたしますと、重要なお知らせが記載されている本登録完了会員様限定のメールがお手元に届きますので、必ずご確認ください。<br><br>発行元：ワンアンドオンリー</p><style type=\"text/css\">\r\np.p1 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px \'Hiragino Sans\'}\r\np.p2 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px Helvetica; min-height: 14.0px}\r\np.p3 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px Helvetica}\r\nspan.s1 {font: 12.0px Helvetica}\r\nspan.s2 {font: 12.0px \'Lucida Grande\'}\r\n</style>', 0, '2018-10-22 08:07:02', '2018-12-12 02:20:22'),
(2, 'Buy prediction', 2, 'info@1and0nly.jp', 'One and only', 'Buy prediction', '<p>You have buy prediction success with \r\n                %prediction_point% point.<br></p><p>%prediction_name%</p><p>link: <br></p><p>%url_prediction%<br></p>', 0, '2018-10-22 08:13:02', '2018-10-22 13:00:24'),
(3, 'Deposit', 3, 'info@1and0nly.jp', 'One and only', 'Deposit', '<p>You have buy %trans_point% with %trans_amount% is success.</p><p>Member level is %member_level%.<br></p>', 0, '2018-10-22 08:16:01', '2018-10-22 12:31:28'),
(4, 'Mail bulk', 4, 'info@1and0nly.jp', 'One and only', 'Mail bulk', '<p>Mail bulk Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk  Mail bulk </p>', 0, '2018-10-22 08:17:45', '2018-10-22 08:17:45'),
(5, 'Mail schedule', 5, 'info@1and0nly.jp', 'One and only', 'Mail schedule', '<p>Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule Mail schedule </p>', 0, '2018-10-22 08:18:09', '2018-10-22 08:18:09'),
(6, 'Mail contact', 6, 'info@1and0nly.jp', 'One and only', 'Mail contact', '<p>Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact Mail contact </p>', 1, '2018-10-22 08:18:27', '2018-10-22 08:18:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media`
--

CREATE TABLE `media` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media`
--

INSERT INTO `media` (`id`, `name`, `code`, `link`, `cost`, `url`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '【PC】デフォルト', 'zzz', NULL, 0, 'https://1and0nly.jp?ref=zzz', 0, '2018-10-24 05:03:18', '2018-12-06 00:19:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media_access`
--

CREATE TABLE `media_access` (
  `id` int(10) UNSIGNED NOT NULL,
  `media_id` int(11) NOT NULL,
  `media_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `access_date` timestamp NULL DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media_access`
--

INSERT INTO `media_access` (`id`, `media_id`, `media_code`, `number_access`, `access_date`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 'zzz', 56, '2019-02-22 08:00:00', 0, '2019-02-23 00:36:26', '2019-02-23 04:13:08'),
(2, 1, 'zzz', 42, '2019-02-22 17:00:00', 0, '2019-02-23 04:16:29', '2019-02-23 16:26:17'),
(3, 1, 'zzz', 10, '2019-02-23 17:00:00', 0, '2019-02-24 10:13:58', '2019-02-24 13:44:38'),
(4, 1, 'zzz', 16, '2019-02-24 17:00:00', 0, '2019-02-25 03:34:44', '2019-02-25 12:30:51'),
(5, 1, 'zzz', 60, '2019-02-25 17:00:00', 0, '2019-02-26 03:32:24', '2019-02-26 11:19:57'),
(6, 1, 'zzz', 1, '2019-02-26 17:00:00', 0, '2019-02-27 04:40:22', '2019-02-27 04:40:22'),
(7, 1, 'zzz', 42, '2019-02-27 17:00:00', 0, '2019-02-28 04:05:17', '2019-02-28 09:23:22'),
(8, 1, 'zzz', 6, '2019-02-28 17:00:00', 0, '2019-03-01 09:07:19', '2019-03-01 10:15:31'),
(9, 1, 'zzz', 1, '2019-02-28 17:00:00', 0, '2019-03-01 09:07:19', '2019-03-01 09:07:19'),
(10, 1, 'zzz', 1, '2019-03-01 17:00:00', 0, '2019-03-02 11:04:15', '2019-03-02 11:04:15'),
(11, 1, 'zzz', 7, '2019-03-03 17:00:00', 0, '2019-03-04 03:20:46', '2019-03-04 06:22:22'),
(12, 1, 'zzz', 1, '2019-03-03 17:00:00', 0, '2019-03-04 03:20:46', '2019-03-04 03:20:46'),
(13, 1, 'zzz', 9, '2019-03-04 17:00:00', 0, '2019-03-05 06:51:48', '2019-03-05 09:41:08'),
(14, 1, 'zzz', 1, '2019-03-04 17:00:00', 0, '2019-03-05 06:51:48', '2019-03-05 06:51:48'),
(15, 1, 'zzz', 48, '2019-03-05 17:00:00', 0, '2019-03-06 04:23:22', '2019-03-06 16:45:10'),
(16, 1, 'zzz', 15, '2019-03-06 17:00:00', 0, '2019-03-07 03:04:06', '2019-03-07 11:29:41'),
(17, 1, 'zzz', 1, '2019-03-06 17:00:00', 0, '2019-03-07 03:04:06', '2019-03-07 03:04:06'),
(18, 1, 'zzz', 5, '2019-03-07 17:00:00', 0, '2019-03-08 03:29:52', '2019-03-08 10:39:24'),
(19, 1, 'zzz', 31, '2019-03-08 17:00:00', 0, '2019-03-09 04:03:11', '2019-03-09 16:37:19'),
(20, 1, 'zzz', 1, '2019-03-08 17:00:00', 0, '2019-03-09 04:03:11', '2019-03-09 04:03:11'),
(21, 1, 'zzz', 5, '2019-03-09 17:00:00', 0, '2019-03-10 04:51:13', '2019-03-10 11:16:33'),
(22, 1, 'zzz', 11, '2019-03-10 17:00:00', 0, '2019-03-11 03:39:43', '2019-03-11 07:03:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

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
(34, '2018_10_17_074031_create_user_access_prediction_table', 32),
(35, '2018_10_23_133312_create_user_access_blog_table', 33),
(36, '2018_10_23_132727_create_result_table', 34),
(37, '2018_10_23_183516_create_media_table', 35);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `page`
--

CREATE TABLE `page` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `page`
--

INSERT INTO `page` (`id`, `name`, `code`, `link`, `source`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'ONE AND ONLYとは', 'about_one', '/about-one', '<div id=\"about01\" class=\"font\">\r\n        <p class=\"center title\">＜<span class=\"gold\">ONE AND ONLY</span>とは・・・＞</p>\r\n\r\n        <p>競馬の発祥の地である英国では、「競馬は貴族の遊び」と言われているように、元々は庶民とは縁の遠い存在にあった競馬。</p>\r\n        <p>つまりは、競馬の本質は、資本力のある成功者にとっての「大人のたしなみ」である。</p>\r\n\r\n        <p class=\"txt23 center\">「ダービー馬のオーナーになることは一国の宰相になることより難しい」</p>\r\n\r\n        <p>このような言葉が生まれた背景には、資本力、強運だけでは簡単にダービーのタイトルを獲ることはできない成功者たちによる激しい競争という資本主義的な背景がある。</p>\r\n\r\n        <p>「資本力」や「強運力」を競い合い、誰よりも強い競走馬を所有することに喜びを感じる貴族たちにとっての遊びが進化し、日本という国では“馬券売り上げ”が国の財源の1つとして確立されたのが現代日本競馬誕生の経緯。</p>\r\n\r\n        <p>資本力を持つビジネスの成功者が、サラブレッドを購入し走らせる側の「馬主」となり、繰り広げられているのが競馬の本質。<br>\r\n          だからこそ、競馬界の中心は【馬主】ということである。</p>\r\n\r\n        <p>一般の競馬ファンによる馬券購入の売り上げによって、大きな興業ビジネスとなっている競馬であるにも関わらず、いまだに一般競馬ファンには届くことのない情報は数多い。</p>\r\n\r\n        <p>競走馬を生産した牧場が、庭先での取引やセールに上場させて、馬主に「より高額で」競走馬を購入してもらう。</p>\r\n\r\n        <p>競走馬を購入した「馬主」は、繋がりのある調教師のもとに愛馬を預ける。</p>\r\n\r\n        <p>調教師は、「馬主」や「牧場」と相談しながら、レースや騎手を選び、レース賞金を稼ぎながら、厩舎を経営してゆく。</p>\r\n\r\n        <p>生産牧場は、「1頭でも多く、1円でも高く、馬を購入してもらう」ことに精力を尽くす。<br>\r\n          そのためには馬主とともに競走馬の所有権利を“半持ち”にしてでも、馬主側へのリスク対策も提案しながら、売りさばいていく。</p>\r\n\r\n        <p>馬主は、「ダービーを勝てる馬」を探し求める夢を追う場合や「購入金額よりも稼いでくれる馬」という投資的観点から、買う価値があると判断する馬を選んで購入する。</p>\r\n\r\n        <p>ここには、当然【政治力】が働き、またビジネスである以上は【駆け引き】も存在している。<br>\r\n          「走らない馬でも高く買ってもらいたい」という本音もあるが、誰を相手にしてでもそのような営業をしていれば、次回は買ってもらうことはできなくなることは当然。</p>\r\n\r\n        <p>\r\n          そのために、「長く馬主を続けるであろう」という重要馬主には、“駄馬”はそう簡単には売らない。もちろん「これは走る！」という馬が、思ったほど走らないケースもあるが、その場合には、また良い条件で馬の購入を提案する動きは必ずと言っていいほどある。</p>\r\n\r\n        <p>しかしながら、その一方で「この馬主は、長くはやらないだろうなぁ。お金があるだけだな」と見るやいなや、「良血でも走らないであろうデキのよくない馬」を血統面だけの魅力を説き、強気の高額購入へと舵を取る。</p>\r\n\r\n        <p>客観的に見れば、牧場の「ぼったくり」のようにも見えてしまうが、「一見さん」に対しては、最初は「疑いの目」から入るのは、どの業界でも珍しい話ではなく、ビジネスという観点では当然と言っても過言ではない。</p>\r\n\r\n        <p>もちろん良好な関係にある馬主には、「レースで勝って良い思いをしてもらいたい！」という思惑も働くことで、間接的に利権関係者による圧力がレースに影響を及ぼすことも日常茶飯事である。</p>\r\n\r\n        <p>このような「競馬の本質」を知っていれば、「走る馬」や「走る情報」、「本気の勝負どころ」を事前に知れることになるわけだが、そのような裏側のやりとりなどが表沙汰になることはまずあり得ない。</p>\r\n\r\n        <p class=\"center txt23\">競馬は「資本力のある成功者たちの遊び」が本質。</p>\r\n\r\n        <p>\r\n          馬券売り上げについては、馬券を購入するファンが「馬券の勝ち負け」を楽しんでくれていれば成り立つわけであり、馬券を購入する人間に対しては、誰が勝とうが、誰が負けようが、主催者側や競馬界の重鎮組織にとっては、一切関係ないのである。</p>\r\n\r\n        <p>主催者は、「100円でも多く馬券が売れる」ことが目的であるため、走らせる側の思惑については、一般競馬ファン側に伝える必要は全くない。</p>\r\n\r\n        <p>また馬を走らせる重鎮関係者にとっても、「一般の競馬ファンの馬券の勝ち負け」は一切関係ない。「馬を走らせる側の利権関係者が良い思いができるかどうか」が焦点となる。</p>\r\n\r\n        <p>そのような相関関係を知っていれば、一般競馬ファンに知れ渡るような情報は、勝負とはあまり関係のない次元の情報内容に過ぎないということが当たり前であることも理解できるはず。</p>\r\n\r\n        <p>これが、「馬券売り上げで成り立つ日本競馬」と、「馬券を購入する一般の競馬ファンには本物の情報が出回らない」という矛盾が生じる真相である。</p>\r\n\r\n        <p>情報を共有する場を設けて、交流の場を作り、そして、この「矛盾」を少しでも埋めることが出来る場所、それが<span class=\"gold\">＜ONE AND ONLY＞</span>の世界。</p>\r\n\r\n        <p>\r\n          もちろん馬券を購入するのは、一般の競馬ファンだけでなく、馬主や牧場関係者も馬券を購入できる立場であるからこそ、馬主関係者や生産牧場関係者を中心とし、【完全招待制】【会員制】を導入させていただいたというわけである。</p>\r\n\r\n        <p>情報を持っている者同士が交流し、情報を共有することで［WIN＝WIN］の関係を構築していくための<span class=\"gold\">＜ONE AND ONLY＞</span>の世界で、より充実した競馬ライフ・馬主ライフをお過ごし頂きたい。\r\n        </p>\r\n\r\n        <p>本気で競馬を愛する者同士が、一般競馬ファンとは次元の違う領域で上質な競馬を楽しんでいただく場所を、<span class=\"gold\">＜ONE AND ONLY＞</span>という名を用いて、業界で初めて導入した経緯をご理解ください。\r\n        </p>\r\n\r\n        <p>そのため<span class=\"gold\">＜ONE AND ONLY＞</span>の会員登録については、</p>\r\n\r\n        <p class=\"center txt23 red\">馬主関係者様<br>\r\n          牧場関係者様<br>\r\n          競馬メディア関係者様<br>\r\n          競馬サークル関係者様<br>\r\n        </p>\r\n\r\n        <p>そして、信頼ある競馬関係者の会員様の紹介を受けて、「情報の取り扱いに関して信用できる一般会員様」に限らせて頂いております。</p>\r\n\r\n        <p>\r\n          また長期的にご愛顧頂いている会員様や情報提供をくださっている会員様、有料情報に数多く参加されている会員様におかれましては、より快適に、より有益に弊社をご利用いただけるサービスプログラムを用意するために、＜ステータス制度＞を設けております。</p>\r\n\r\n        <p class=\"center\"><a href=\"{{ route(\'about_three\') }}\">＜ステータス制度＞に関する詳細はこちら！</a></p>\r\n\r\n      </div>', 0, '2018-10-16 19:39:36', '2019-02-22 01:32:23'),
(2, 'ランクの仕組み', 'about_two', '/about-two', '<div id=\"about01\" class=\"font\">\r\n			<p class=\"center title\">＜<span class=\"gold\">勝ち組</span>になるための<span class=\"gold\">秘訣</span>＞</p>\r\n\r\n			<p>「村社会」と言われる競馬の世界。<br>\r\n			馬券売り上げで成り立っている競馬の世界とはいえ、実際には裏側に様々な利権が絡んでいるために、一部の内部関係者にしか出回らないような情報が多いのもこの業界の特徴。</p>\r\n\r\n			<p>「競馬ファンにはあえて言わない」という都合の悪い事情もあれば、「自分たちだけ知っていればいい」というような「言わなくていい」といった判断の中には馬券に直結するようなレベルの話ばかりである。</p>\r\n\r\n			<p>なぜ、このようなことが生まれるのか？<br>\r\n			競馬関係者は、「競馬ファンに貴重な情報が出回らない」ということに対しては、問題とは捉えていない。いや、そもそも「貴重」だと思っていない人も多い。</p>\r\n\r\n			<p>競馬ファンからすれば、「最初から言っといてくれよ！」「教えてくれよ！」といったニーズも生まれるわけだが、「聞かれなければ答える必要がない」という競馬関係者の考えは当たり前といえば当たり前でもある。</p>\r\n\r\n			<p>つまり、現代競馬メディア業界の役割というのは、『馬券売り上げ増加』『馬券売り上げのキープ』を目的としているために、「競馬関係者しか知らない貴重な情報」を「競馬ファンに届ける」という目的ではないのだ。</p>\r\n\r\n			<p>出走させる側にしてみれば、1つ1つのレースに対する「目的」「意図」は異なる。</p>\r\n\r\n			<p>「1着を目指す」という表向きのテーマは、あくまでも表向き。</p>\r\n\r\n			<p>「ここを叩いて次で勝負」<br>\r\n				「今回はとりあえず使うだけ。経験させたいことがあるから」<br>\r\n				<br>\r\n				といった調教代わりのようにレースにただ使うようなこともあれば、<br>\r\n				<br>\r\n				「確勝を期して、レースを選んだ。負けられない」<br>\r\n				「今後のローテを考えて、ここは勝ちに行く！」<br>\r\n				「賞金が欲しいから、相手関係も見てここを選んだ。なんとかする」<br>\r\n				<br>\r\n			といった必勝モードでレースを迎えることもある。</p>\r\n\r\n			<p>たとえ、同じ馬の出走だとしても、出走に対する経緯、裏事情によって勝負気配が全くことなるだけに、前者のような調教代わりで負けの可能性が高いレースに多額の軍資金を突っ込んでしまえば、負ける確率が高まることは当然。</p>\r\n\r\n			<p>また後者のような必勝ムードの際に、勝負気配が薄い時と同額の軍資金で勝負するのも「もったいない」。</p>\r\n\r\n			<p>「競馬に絶対はない」「ディープインパクトでも負けてしまう時がある」というこれまでの歴史を振り返れば、どんなに鉄板だとしても「敗れてしまう1%の可能性」も常にリスクヘッジを考慮する必要がある。</p>\r\n\r\n			<p>だからこそ、より確率の高いところでこそ、大勝負に挑むことによって、競馬は勝つことが出来るのである。</p>\r\n\r\n			<p>「万馬券配当でなければ、競馬は勝てない」といった考えの方も競馬ファンの中には少なくないが、すべてのレースを同じ視点、同額で馬券購入をしているようであれば、そういう思考になってしまうが、大勝負する価値があるレースに、いつもの倍額、3倍、10倍の軍資金を投入し、的中馬券を掴むことができれば、【一発逆転】は勿論、長期的にみれば【安定した馬券収支】に繋げられることは理解いただけるはず。</p>\r\n\r\n			<p>その【勝負の瞬間】の嗅覚を研ぎ澄ますためにも、弊社内でリリースされる情報や何気ないニュースなどを確認いただきながら、競馬ライフをお楽しみ頂きたい。</p>\r\n\r\n			<p>1日中、毎日、競馬のことを考え続けていられるような方はなかなかいない。<br>\r\n			とはいえ、競馬界は毎日動いている。</p>\r\n\r\n			<p>情報を取り逃さないためにも、日常生活の中、1日5分程度でも、〈ONE AND ONLY〉の世界を覗くことで、【競馬で勝つために必要な下地が自ずと築かれていくこと】は間違いないはず。</p>\r\n\r\n			<p>朝の数分、寝る前の数分、是非とも【勝つためのルーティーン】として、歯磨きをするような感覚で身につけていただきたい。</p>\r\n\r\n			<p>それが自然に出来るようになった時に、【勝負の機を察知する勝者の嗅覚】が間違いなく身についているはずである。。</p>\r\n\r\n		</div>', 0, '2018-10-16 19:44:08', '2018-12-12 02:12:38'),
(3, '勝ち組になるための秘訣', 'about_three', '/about-three', '<div id=\"about01\">\r\n			<div class=\"font\">\r\n				<p class=\"center title\">＜<span class=\"gold\">ステータス制度</span>の仕組み＞</p>\r\n\r\n				<p>より多くの機会で弊社をご利用いただいている会員様には、より有益なサービスや情報を提供させて頂くためステータス制度を導入しております。</p>\r\n				<p>尚、一度昇格ステータスが降格することはございません。</p>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide01.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				<span class=\"star\">★</span>昇格条件は非公開（完全招待制）<br>※昇格費用は一切かかりません。<br>\r\n				<br>\r\n				<span class=\"star\">★</span>クリスタルメンバー様「限定特典」あり。<br>※詳細は昇格時にご案内致します。<br>\r\n				<br><span class=\"star\">★</span>クリスタルメンバー様「専用情報」のお申込が可能となります。<br>※ダイヤモンドメンバー様向けコースへの継続お申込も出来ます。<br>※ゴールドメンバー様向けコースへの継続お申込も出来ます。<br>※トライアルメンバー様向けコースへの継続お申込も出来ます。<br>\r\n<br><span class=\"star\">★</span>会員様限定コンテンツを閲覧いただけます。\r\n</div>		\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide02.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				<span class=\"star\">★</span>昇格条件は非公開（完全招待制）<br>\r\n				※昇格費用は一切かかりません。<br>\r\n				<br>\r\n				<span class=\"star\">★</span>ダイヤモンドメンバー様「限定特典」あり。<br>\r\n				※詳細は昇格時にご案内致します。<br>\r\n				<br><span class=\"star\">★</span>ダイヤモンドメンバー様向け「専用情報」のお申込が可能となります。<br>※ゴールドメンバー様向けコースへの継続お申込も出来ます。<br>※トライアルメンバー様向けコースへの継続お申込も出来ます。<br><br><span class=\"star\">★</span>会員様限定コンテンツを閲覧いただけます。<br>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide03.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				<span class=\"star\">★</span>【トライアルパック】参加後に【ゴールドメンバー] に自動昇格致します。<br>\r\n				※トライアルメンバー様向けコースへの継続お申込も出来ます。<br>\r\n				<br>\r\n				<span class=\"star\">★</span>ゴールドメンバー様向け「専用情報」のお申込が可能となります。<br>\r\n				<br><span class=\"star\">★</span>会員様限定コンテンツを閲覧いただけます。<br>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide04.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				<span class=\"star\">★</span>登録を完了された後は、まずは皆さま【トライアルメンバー】となります。<br>\r\n				<br>\r\n				<span class=\"star\">★</span>トライアルメンバー様向け情報である【トライアルパック】に一度参加いただくと、4週間後に自動的に【ゴールドメンバー】に昇格となります。<br><br><span class=\"star\">★</span>会員様限定コンテンツを閲覧いただけます。</div>\r\n\r\n\r\n\r\n		</div>', 0, '2018-10-16 19:44:39', '2018-12-12 18:38:46'),
(4, '限定コラム', 'column', '/column', '<p>■■■■■■■■■■■■<br><span style=\"font-size: 1rem;\">京都記念週［結果回顧］<br></span><span style=\"font-size: 1rem;\">■■■■■■■■■■■■</span></p><p><span style=\"font-size: 1rem;\">執筆者：情報監査室 岸本修<br></span><span style=\"font-size: 1rem;\">--------------------------------</span></p><p><span style=\"background-color: rgb(255, 0, 255);\"><span style=\"font-weight: 600;\">≪クリスタルクラス限定提供≫</span></span></p><p><u style=\"font-size: 1rem; font-weight: bold;\">【ONLY ONE】</u><br></p><p><span style=\"font-size: 1rem;\">2月10日（日）</span><br></p><p><span style=\"font-size: 1rem;\">京都9</span><span style=\"font-size: 1rem;\">R 松籟ステークス</span></p><p><span style=\"font-size: 1rem;\">1着◎シャルドネゴールド（1</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着○マイハートビート（2番人気）</span></p><p><u style=\"font-weight: 600; color: rgb(255, 0, 0); font-size: 1rem;\">馬単460円的中！<br></u><br>［レース回顧］<br><span style=\"font-size: 1rem;\">「京都記念に出走したとしても勝ち負けできるだけの状態にあるし、能力もある」と池江泰寿厩舎サイドが絶対的な確勝の自信を示していた◎シャルドネゴールドが1番人気。<br></span><span style=\"font-size: 1rem;\">「勝てる力はあるけど、今回はシャルドネゴールドが勝つと思う」と陣営が謙遜していた2番人気の○マイハートビート。<br></span><span style=\"font-size: 1rem;\">結果だけを見れば、1番人気◎シャルドネゴールド→2番人気○マイハートビートという順当の決着だが、究極の馬単1点で勝負できるだけの銀行レースという背景もあっただけに、難なく馬単460円的中を仕留めた今回の【ONLY ONE】の提供。<br></span><span style=\"font-size: 1rem;\">配当460円＝回収率460%。大爆発とまでは大威張りできないとはいえ、狙い澄ましての馬単1点的中の魅力を堪能いただくことができたのではないだろうか。馬券の究極形ともいえる1点提供の【ONLY ONE】で、競馬の醍醐味に今後も酔いしれていただきたい。<br></span><span style=\"font-size: 1rem;\"><br>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</span></p><p><span style=\"font-size: 1rem; background-color: rgb(0, 255, 255);\"><span style=\"font-weight: 600;\">≪ダイヤモンドクラス以上限定提供≫</span></span></p><p><u style=\"font-size: 1rem; font-weight: bold;\">【THE STALLION】</u><br></p><p><span style=\"font-size: 1rem;\">2月9日（土）</span><br></p><p><span style=\"font-size: 1rem;\">京都10</span><span style=\"font-size: 1rem;\">R 琵琶湖特別</span></p><p><span style=\"font-size: 1rem;\">1着◎フォイヤーヴェルグ（4</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着○アロマドゥルセ（2番人気）</span></p><p><span style=\"font-size: 1rem;\">3着△テーオーフォルテ（3番人気）</span></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>3連単5540円的中！</u></span></font></p><p>［レース回顧］<br><span style=\"font-size: 1rem;\">出走馬は8頭に落ち着いた京都芝2400m戦の「琵琶湖特別」に、ノーザンファーム生産のディープインパクト産駒の◎フォイヤーヴェルクと○アロマドゥルセの2頭が名を連ねていた。高額で募集されながら、6歳となったフォイヤーヴェルクが1000万クラスに留まっていることは生産サイドとしては不本意であり、結果を残すべくここを目標に仕上げていたのが今回。前回に引き続きフォイヤーヴェルクの騎乗を託されていた和田竜二騎手が「前走は直線で窮屈になったから、あれさえなければ勝てた。別の進路を取っていれば、もっと際どい勝負に持ち込めたと思うし、今度こそ勝たせたい」と良いイメージでレースを迎えられたのも今回の勝利に繋がったといえよう。素質的には今回のメンバーを相手に4番人気に甘んじるような馬ではないが、勝ちきれないイメージが強かったせいか人気になりきらなかったことも8頭立てと少頭数だったわりに3連単5540円的中という好配当の要因だったともいえる。種牡馬ディープインパクトという利権に関連するイメージ戦略は現代日本競馬ではまだまだ続くことになる。引き続き【THE STALLION】の提供に参加いただきながら、皆様には種牡馬利権の裏側を知っていただく。</span></p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"font-size: 1rem; background-color: rgb(0, 255, 0);\"><span style=\"font-weight: 600;\">≪ゴールドクラス以上限定提供≫</span></span><br></p><p><u style=\"font-size: 1rem; font-weight: bold;\">【AGENT-EYE】</u><br></p><p><span style=\"font-size: 1rem;\">2月9日（土）</span><br></p><p><span style=\"font-size: 1rem;\">小倉9R 4歳以上500万下</span><br></p><p><span style=\"font-size: 1rem;\">1着◎サトノゲイル（2番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着▲ブラックカード（1番人気）</span></p><p><span style=\"font-size: 1rem;\">3着○メンターモード（5番人気）</span><br></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>3連単3220円的中！</u></span></font></p><p>［レース回顧］<br><span style=\"font-size: 1rem;\">今年からC.ルメール騎手と同じ豊沢氏がエージェントを担当することになった武豊騎手。<br></span><span style=\"font-size: 1rem;\">小倉競馬場で武豊展を開催するということも重なり小倉競馬開幕初日の土曜開催だけ小倉で騎乗することを決めていた武豊騎手。無論、若手中心のローカル開催に、1人だけ「力の違い過ぎる騎手」が乗り込んでいたということもあり騎乗オファーが殺到していたが、午前中から3連勝を決めると、池江泰寿厩舎から託されていた大物個人馬主サトミホースカンパニーの所有馬◎サトノゲイルで、この日4勝目を飾り、3連単3220円的中に貢献してくれた。3連単6点提供により、回収率は536.6%を記録。配当こそ目立たないが［好回収］といえる効率の良い結果だったといっても差し支えないだろう。今後も【AGENT-EYE】の提供にご期待いただこう。</span></p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\"><span style=\"font-weight: 600;\">【トライアルパック】</span></span><br></p><p><span style=\"font-size: 1rem;\">2月10日（日）</span><br></p><p><span style=\"font-size: 1rem;\">東京9</span><span style=\"font-size: 1rem;\">R 初音ステークス</span></p><p><span style=\"font-size: 1rem;\">1着　ダノングレース（6</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着　フィニフティ（3番人気）</span></p><p><span style=\"font-size: 1rem;\">3着　シャンティローザ（12番人気）</span></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>不的中<br></u></span></font><span style=\"font-size: 1rem;\"><br>［レース回顧］<br></span><span style=\"font-size: 1rem;\">土曜の東京競馬が雪により中止となり、日曜日の開催も発走時刻に大幅な変更があった先週の東京競馬。芝の馬場状態に関しては想定していたものとは異なり、狙いや戦略にズレが生じてしまったと言わざるを得なかったのが牝馬限定戦の「初音ステークス」。<br></span><span style=\"font-size: 1rem;\">「ここで惨敗するような馬ではないんだけど、ちょっと馬場も展開も合わなかったかな。1800mでもやれるとは思ったけど、ちょっと方針を変える。1400mくらいに距離を短くするとこの馬も本来の能力を発揮してくれるのではないかと思う。この距離でも牝馬限定ならやれると思ったけど、次回はオーナーの許可さえおりれば、距離を縮めてみる。次回こそなんとしてでも巻き返さなくては・・」と厩舎サイドがすぐに切り替えていたのは、同馬に対する評価に変わりがないからこそ。今回は残念ながら力を発揮することはできなかったが、次回以降の巻き返しに期待いただきたい。<br></span><span style=\"font-size: 1rem;\">【トライアルパック】は今年初めての連敗を喫してしまったが、“的中率3割”でもプラス収支を叩き出すことが出来るのが競馬の魅力。【トライアルパック】に参加されている会員様は2連敗という結果に落胆されることなく、次回以降の巻き返しに目を向けていただきたい。</span></p>', 0, '2018-10-16 19:45:42', '2019-02-22 01:33:00'),
(5, '商品一覧', 'list', '/list', '<div id=\"list\">\r\n			<div class=\"font\">\r\n				<p class=\"center title\">主な提供商品ラインナップ</p>\r\n\r\n				<p class=\"center\">ONE AND ONLYの世界でご堪能いただける主な商品群</p>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide01.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				クリスタルメンバー限定提供<br>\r\n				＜情報レベル＞<span class=\"star\">★★★★★</span>(5つ星)以上<br>\r\n				【GREAT-NINE】牧場系コラボ情報<br>\r\n				【ONLY ONE】究極の1点提供<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide02.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				ダイヤモンドメンバー限定提供<br>\r\n				＜情報レベル＞<span class=\"star\">★★★★</span>(4つ星)以上<br>\r\n				【RECEPTION RACE】接待レース<br>\r\n				【THE STALLION】種牡馬系情報<br>\r\n				【PERFECT-TRIFECTA】究極の3連単提供<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide03.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				ゴールドメンバー限定提供<br>\r\n				＜情報レベル＞<span class=\"star\">★★★</span>(3つ星)以上<br>\r\n				【OWNERS SECRET】馬主情報網限定の極秘情報<br>\r\n				【AGENT-EYE】騎手エージェント情報筋の勝負情報<br>\r\n				etc・・・上記の他にも随時公開となります<br>\r\n			</div>\r\n\r\n			<div class=\"rank-info\">\r\n				<p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide04.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n				トライアルメンバー<br>\r\n				＜情報レベル＞<span class=\"star\">★</span>～<span class=\"star\">★★★</span>(1つ星～3つ星)<br>\r\n				【トライアルパック】<br>\r\n				記者の取材によるオフレコ情報のパッケージ<br>\r\n			</div>\r\n\r\n		</div>', 0, '2018-10-16 19:47:30', '2018-12-12 22:45:03'),
(6, '今週のラインナップ', 'week', '/week', '<div id=\"list\">\r\n        <div class=\"font\">\r\n          <p class=\"center title\">主な提供商品ラインナップ</p>\r\n\r\n          <p class=\"center\">ONE AND ONLYの世界でご堪能いただける主な商品群</p>\r\n        </div>\r\n\r\n        <div class=\"rank-info\">\r\n          <p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide01.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n          クリスタルクラス限定提供<br>\r\n          ＜情報レベル＞<span class=\"star\">★★★★★</span>以上<br>\r\n          【GREAT-NINE】牧場系コラボ情報<br>\r\n          【ONLY ONE】究極の1点提供<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class=\"rank-info\">\r\n          <p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide02.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n          ダイヤモンドクラス限定提供<br>\r\n          ＜情報レベル＞<span class=\"star\">★★★★</span>以上<br>\r\n          【RECEPTION RACE】接待レース<br>\r\n          【THE STALLION】種牡馬系情報<br>\r\n          【PERFECT-TRIFECTA】究極の3連単提供<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class=\"rank-info\">\r\n          <p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide03.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n          ゴールドクラス限定提供<br>\r\n          ＜情報レベル＞<span class=\"star\">★★★</span>以上<br>\r\n          【OWNERS SECRET】馬主情報網限定の極秘情報<br>\r\n          【AGENT-EYE】騎手エージェント情報筋の勝負情報<br>\r\n          etc・・・上記の他にも随時公開となります<br>\r\n        </div>\r\n\r\n        <div class=\"rank-info\">\r\n          <p class=\"rank-img\"><img src=\"{{ asset(\'frontend/images/slide04.jpg\') }}\" width=\"660\" height=\"222\"></p>\r\n          トライアルメンバー<br>\r\n          ＜情報レベル＞<span class=\"star\">☆～☆☆☆</span><br>\r\n          【トライアルパック】<br>\r\n          記者の取材によるオフレコ情報のパッケージ<br>\r\n        </div>\r\n\r\n      </div>', 0, '2018-10-16 19:48:40', '2018-11-22 17:39:52'),
(7, 'ふぁく', 'faq', '/faq', '<dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１条【定義】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．サービスとは、当社および当サイトが提供する各種情報およびサービス、メールマガジン等の配信サービスを指します。（以下、当サービス）<br>２．会員とは、当社が定める所定の手続きに従い当サービスを利用する資格を持つ個人を指します。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第２条【本規約の範囲および変更】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．本規約は当サイトを利用するすべての会員に適用されます。<br>２．本規約は状況に応じて追記および変更する場合があり、変更後の利用規約は当サイトに掲示した時点で効力を生じますので、当サイトを利用する際は必ず本規約をご確認下さい。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第３条【サービスの原則】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．当サービスは、いかなる場合も確実性が保証されない競馬に関連するサービスとなります。<br>２．当サービスは、情報提供者個人を特定できない範囲で潤色を交えた内容となります。<br>３．情報およびそれに基づく実績はあくまでも目安としてお知らせするもので、実際の結果を保証するものではありません。<br>４．当サービスはメールマガジン配信による情報コンテンツのご案内を主としておりますが、メールマガジンの受信を必須とするものではありません。メールマガジンの停止をご希望の場合につきましては、事務局（info@）までご連絡下さい。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第４条【自己責任の原則】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．ＩＤおよびパスワードは会員自身の責任の下に使用および管理を行って下さい。<br>２．メールボックスの容量不足またはメール受信制限など当社の責任の及ばない理由により当サービスを受けられなかった場合においても、当社は一切の責任を負いません。<br>３．当サービスの利用および馬券投票は会員自身の任意となります。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第５条【当サービスの変更および中止】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">以下に該当する場合、当サービスを変更または中止致します。<br>・天災または火災、停電などの不測の事態により当サービスの提供が困難であると判断した場合<br>・サーバーおよびシステムに対し、保守または点検が必要であると判断した場合<br>・当サービスまたはシステムに変更があった場合<br>・情報の保全または競馬開催の中止など、合理的な理由で中止または変更が必要であると判断した場合<br>・その他、当サービスの提供が困難であると判断した場合</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第６条【会員の資格】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">以下の個人を会員とします。<br>・本規約および別途定めるプライバシーポリシーに同意し、当社が定める所定の手続きを経た個人<br>・日本国籍を持った個人<br>・法人またはそれに準じる団体組織および暴力団に属さない個人<br>・「競馬法第２８条（勝馬投票券の購入等の制限）」で定められた未成年ではない個人<br>・個人情報を虚偽なく正確に登録した個人</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第７条【禁止事項】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">当サイトおよび当サービスの利用において、以下の行為を禁止します。<br>・当サービスの内容およびＩＤを第三者と共有する行為、またはそれを不特定多数の人間に開示する行為<br>・当サービスを利用した営利目的の行為<br>・当サイトおよび当サービスに掲載または記載された著作物に対し、無断で行う複製、改変、編集または転送などの行為<br>・当サイトの運営を妨害する行為</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第８条【会員登録の解除】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">退会手続きは会員様の任意にてご申請下さい。手続きの際、処理手数料等は一切発生致しません。<br>退会についてはページ下部の退会申請より手続きを頂くか、メールマガジン下部に記載される退会専用アドレスにご登録のメールアドレスから送信して頂く事で退会が可能です。また、お問い合わせ頂く事でも手続きをお受けしております。<br>退会申請の受付後、48時間後にデータベースからご登録のメールアドレスを含む全ての情報が削除されます（それまでは再入会が可能です）ので、ご了承下さい。データベースから削除された時点で、購入またはサービスにより付与された保有ポイントは全て失効となります。<br>なお、以下に該当する会員に対し、当社の判断にて登録の解除を行う場合がございます。その際、既にお支払い頂いた情報料の返金は致しません。<br>・本規約の違反により登録解除の処分を受けたことのある会員、または当社がそれと判断した会員<br>・２つ以上のアカウント（お客様ＩＤ）を所有する会員、または当社がそれと判断した会員<br>・第６条の各項に該当しない会員<br>・第７条の各項に該当する会員<br>・当社が不適切と判断した会員</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第９条【通知および連絡】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．当社から会員へのご案内および連絡は、会員の登録したメールアドレスに対して行います。この際、当社の責任に及ばない理由により通知または連絡が完了しなかった場合でも、その通知および連絡は完了したものとします。<br>２．会員から当社への通知および連絡はメールで行うものとし、来訪による対応はお断りさせて頂きます。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１０条【著作権】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">当サイトおよび当サービスに関連するすべての画像および文章の著作権は当社に帰属します。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１１条【免責事項】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．天候または天災などの事情により競馬開催が中止または延期された場合、または競走馬の出走取消、競走除外、競走中止について、当社は責任を負うところはなく、それに対しての保障は致しません。<br>２．当サービスにおける参加費用の保障サービスについてはすべてポイントでの返還となり、情報料の返金は致しません。<br>３．当サイトの利用状況に応じ、会員ごとに異なるサービスを提供する場合があります。<br>４．会員のインターネット接続環境により当サイトにアクセスできない場合でも、当社は一切の責任を負いません。<br>５．当サービスは一般的なインターネット利用環境（デフォルト設定）における利用者を対象としており、それに該当しない環境で利用する会員に対しての影響は考慮致しません。<br>６．当サイトの的中結果は１点あたり千円で算出した払戻金額を掲載しております。<br>７．当社が通知および連絡する情報の利用は任意のものであり、それによって会員個人および第三者の受けた利益または損害ついて当社は一切の責任を負いません。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１２条【情報料金およびポイント】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．会員登録および無料情報の閲覧における料金は一切発生致しません。<br>２．有料情報の閲覧を希望する会員はポイントを事前に購入してご利用下さい。<br>３．購入したポイントの換金および情報料の返金は致しません。<br>４．ポイントの有効期限は発行から１８０日となります。期限は、再度ご購入等頂いた場合１８０日延長されます。<br>５．情報料金は提供される内容または期間、時期および会員に応じて変動することがあります。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１３条【準拠法および管轄裁判所】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">１．規約の成立、効力、履行および解釈は日本法を適用します。<br>２．当サービスについて、当社と会員との間で紛争が生じた際は誠意を持って協議します。その際は当社の所在地を管轄する裁判所を第一審の専属管轄裁判所とします。</dd></dl><dl style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; padding: 0px; width: 680px; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; border: 5px solid rgb(0, 0, 0); color: rgb(255, 255, 255); font-family: &quot;Noto Sans Japanese&quot;, sans-serif, &quot;ヒラギノ角ゴ ProN W3&quot;, &quot;Hiragino Kaku Gothic ProN&quot;, メイリオ, Meiryo, sans-serif;\"><dt style=\"margin: 0px; padding: 20px; background: rgb(1, 90, 0); border-bottom: 5px solid rgb(0, 0, 0);\">第１４条【その他】</dt><dd style=\"margin-top: 0px; margin-right: 0px; margin-bottom: 0px; padding: 20px; color: rgb(0, 0, 0); background: rgb(225, 225, 225);\">本規約に定めのない事項については、当社が別途定める規則に従うものとします。 情報ルート、情報元との機密保持上、各予想家の名前は充てとなっておりますことを予めご了承ください。実名での公開は致しかねます。</dd></dl>', 0, '2018-10-16 19:49:12', '2018-11-22 17:11:34'),
(8, '利用規約', 'agree', '/agree', '<p><b>第１条【定義】</b></p><p>１．サービスとは、当社および当サイトが提供する各種情報およびサービス、メールマガジン等の配信サービスを指します。（以下、当サービス）</p><p>２．会員とは、当社が定める所定の手続きに従い当サービスを利用する資格を持つ個人を指します。</p><p><br></p><p><b>第２条【本規約の範囲および変更】</b></p><p>１．本規約は当サイトを利用するすべての会員に適用されます。</p><p>２．本規約は状況に応じて追記および変更する場合があり、変更後の利用規約は当サイトに掲示した時点で効力を生じますので、当サイトを利用する際は必ず本規約をご確認下さい。</p><p><br></p><p><b>第３条【サービスの原則】</b></p><p>１．当サービスは、いかなる場合も確実性が保証されない競馬に関連するサービスとなります。</p><p>２．当サービスは、情報提供者個人を特定できない範囲で潤色を交えた内容となります。</p><p>３．情報およびそれに基づく実績はあくまでも目安としてお知らせするもので、実際の結果を保証するものではありません。</p><p>４．当サービスはメールマガジン配信による情報コンテンツのご案内を主としておりますが、メールマガジンの受信を必須とするものではありません。メールマガジンの停止をご希望の場合につきましては、事務局（info@）までご連絡下さい。</p><p><br></p><p><b>第４条【自己責任の原則】</b></p><p>１．ＩＤおよびパスワードは会員自身の責任の下に使用および管理を行って下さい。</p><p>２．メールボックスの容量不足またはメール受信制限など当社の責任の及ばない理由により当サービスを受けられなかった場合においても、当社は一切の責任を負いません。</p><p>３．当サービスの利用および馬券投票は会員自身の任意となります。</p><p><br></p><p><b>第５条【当サービスの変更および中止】</b></p><p>以下に該当する場合、当サービスを変更または中止致します。</p><p>・天災または火災、停電などの不測の事態により当サービスの提供が困難であると判断した場合</p><p>・サーバーおよびシステムに対し、保守または点検が必要であると判断した場合</p><p>・当サービスまたはシステムに変更があった場合</p><p>・情報の保全または競馬開催の中止など、合理的な理由で中止または変更が必要であると判断した場合</p><p>・その他、当サービスの提供が困難であると判断した場合</p><p><br></p><p><b>第６条【会員の資格】</b></p><p>以下の個人を会員とします。</p><p>・本規約および別途定めるプライバシーポリシーに同意し、当社が定める所定の手続きを経た個人</p><p>・日本国籍を持った個人</p><p>・法人またはそれに準じる団体組織および暴力団に属さない個人</p><p>・「競馬法第２８条（勝馬投票券の購入等の制限）」で定められた未成年ではない個人</p><p>・個人情報を虚偽なく正確に登録した個人</p><p><br></p><p><b>第７条【禁止事項】</b></p><p>当サイトおよび当サービスの利用において、以下の行為を禁止します。</p><p>・当サービスの内容およびＩＤを第三者と共有する行為、またはそれを不特定多数の人間に開示する行為</p><p>・当サービスを利用した営利目的の行為</p><p>・当サイトおよび当サービスに掲載または記載された著作物に対し、無断で行う複製、改変、編集または転送などの行為</p><p>・当サイトの運営を妨害する行為</p><p><br></p><p><b>第８条【会員登録の解除】</b></p><p>退会手続きは会員様の任意にてご申請下さい。手続きの際、処理手数料等は一切発生致しません。</p><p>退会についてはページ下部の退会申請より手続きを頂くか、メールマガジン下部に記載される退会専用アドレスにご登録のメールアドレスから送信して頂く事で退会が可能です。また、お問い合わせ頂く事でも手続きをお受けしております。</p><p>退会申請の受付後、48時間後にデータベースからご登録のメールアドレスを含む全ての情報が削除されます（それまでは再入会が可能です）ので、ご了承下さい。データベースから削除された時点で、購入またはサービスにより付与された保有ポイントは全て失効となります。</p><p>なお、以下に該当する会員に対し、当社の判断にて登録の解除を行う場合がございます。その際、既にお支払い頂いた情報料の返金は致しません。</p><p>・本規約の違反により登録解除の処分を受けたことのある会員、または当社がそれと判断した会員</p><p>・２つ以上のアカウント（お客様ＩＤ）を所有する会員、または当社がそれと判断した会員</p><p>・第６条の各項に該当しない会員</p><p>・第７条の各項に該当する会員</p><p>・当社が不適切と判断した会員</p><p><br></p><p><b>第９条【通知および連絡】</b></p><p>１．当社から会員へのご案内および連絡は、会員の登録したメールアドレスに対して行います。この際、当社の責任に及ばない理由により通知または連絡が完了しなかった場合でも、その通知および連絡は完了したものとします。</p><p>２．会員から当社への通知および連絡はメールで行うものとし、来訪による対応はお断りさせて頂きます。</p><p><br></p><p><b>第１０条【著作権】</b></p><p>当サイトおよび当サービスに関連するすべての画像および文章の著作権は当社に帰属します。</p><p><br></p><p><b>第１１条【免責事項】</b></p><p>１．天候または天災などの事情により競馬開催が中止または延期された場合、または競走馬の出走取消、競走除外、競走中止について、当社は責任を負うところはなく、それに対しての保障は致しません。</p><p>２．当サービスにおける参加費用の保障サービスについてはすべてポイントでの返還となり、情報料の返金は致しません。</p><p>３．当サイトの利用状況に応じ、会員ごとに異なるサービスを提供する場合があります。</p><p>４．会員のインターネット接続環境により当サイトにアクセスできない場合でも、当社は一切の責任を負いません。</p><p>５．当サービスは一般的なインターネット利用環境（デフォルト設定）における利用者を対象としており、それに該当しない環境で利用する会員に対しての影響は考慮致しません。</p><p>６．当サイトの的中結果は１点あたり千円で算出した払戻金額を掲載しております。</p><p>７．当社が通知および連絡する情報の利用は任意のものであり、それによって会員個人および第三者の受けた利益または損害ついて当社は一切の責任を負いません。</p><p><br></p><p><b>第１２条【情報料金およびポイント】</b></p><p>１．会員登録および無料情報の閲覧における料金は一切発生致しません。</p><p>２．有料情報の閲覧を希望する会員はポイントを事前に購入してご利用下さい。</p><p>３．購入したポイントの換金および情報料の返金は致しません。</p><p>４．ポイントの有効期限は発行から１８０日となります。期限は、再度ご購入等頂いた場合１８０日延長されます。</p><p>５．情報料金は提供される内容または期間、時期および会員に応じて変動することがあります。</p><p><br></p><p><b>第１３条【準拠法および管轄裁判所】</b></p><p>１．規約の成立、効力、履行および解釈は日本法を適用します。</p><p>２．当サービスについて、当社と会員との間で紛争が生じた際は誠意を持って協議します。その際は当社の所在地を管轄する裁判所を第一審の専属管轄裁判所とします。</p><p><br></p><p><b>第１４条【その他】</b></p><p>本規約に定めのない事項については、当社が別途定める規則に従うものとします。 情報ルート、情報元との機密保持上、各予想家の名前は充てとなっておりますことを予めご了承ください。実名での公開は致しかねます。</p>', 0, '2018-10-16 19:49:40', '2019-03-08 10:56:49'),
(9, 'プライバシーポリシー', 'privacy', '/privacy', '<p><b>個人情報保護の策定</b></p><p>当社は個人情報への不正アクセス、紛失、破壊、改ざんおよび漏洩などのリスクを認識し、予防ならびに是正のために必要な対応策を講じます。 また、個人情報の適切な取扱いと運用のための基準、ルール、手順などを定めた個人情報保護プログラムを策定し実施します。</p><p><br></p><p><b>個人情報保護の組織活動</b></p><p>当社は基本方針を具体的に実践するため以下の活動を行います。</p><p>・役員ならびに役職員は、個人情報に関する指針その他の規範を遵守します。</p><p>・個人情報保護管理責任者を選任し、個人情報保護プログラムの実施および運用に関する責任と権限を与え、その業務を行います。</p><p>・個人情報保護監査責任者を選任し、個人情報の保護に関する実践と運用状況の内部監査を実施します。</p><p>・取引先企業および個人に対し、個人情報の保護に係わる協力を要請します。</p><p>・個人情報保護プログラムは適宜見直しをし、継続的に改善します。</p><p><br></p><p><b>個人情報の定義</b></p><p>個人に関する情報であって、当該情報に含まれる氏名、生年月日その他の記述、または個人別に付けられた番号、記号その他の符号、 画像または音声によって当該個人を識別できるもの（当該情報だけでは識別できないが他の情報と照合することができ、それによって当該個人を識別できるものを含む）。</p><p>当社では個人を特定できる情報は最低限のもの取得するようにしております。当サイトでは利用者の本人確認および連絡の目的のために次の情報を得ることとします。</p><p>・メールアドレス</p><p>・お客様ＩＤ</p><p>・パスワード</p><p><br></p><p><b>個人情報の収集</b></p><p>１．当社はお客様の個人情報を収集する際、収集目的および利用目的をウェブサイト上で通知し、お客様の同意を得た上で適正な方法で収集します。</p><p>２．当初の収集目的以外にお客様の個人情報を利用する場合にはお客様の同意を得ます。この同意を頂かない限り、当初の収集目的以外にお客様の個人情報を利用することはありません。</p><p>３．当社はお客様から収集した個人情報を変更することなく保存するものとし、お客様からのお申し出があった場合のみ個人情報の変更を行います、 また、お客様は個人情報について正確かつ最新の状態を保つ責務を負います。</p><p>４．当社は賞品発送時その他必要に応じ、お客様の個人情報を第三者に預託または提供することがあります。</p><p>サイト上で収集する個人情報</p><p>１．当社は以下に該当する場合にお客様の個人情報を収集します。</p><p>・当サイトのサービスを利用する場合</p><p>・お問い合わせ、ご意見またはご要望を頂く場合</p><p>２．クッキーについて</p><p>当サイトでは効果測定のためにクッキーを使用することがあります。ただし、それは個人を特定できる情報とはなりません。</p><p>３．ウェブサイトを閲覧されたお客様情報の統計処理について</p><p>お客様が当サイトを閲覧された場合、当社のシステムにより自動的にお客様の閲覧状況の統計を収集しております。ただし、それは個人を特定できる情報とはなりません。</p><p><br></p><p><b>収集個人情報とその利用方法の確認</b></p><p>当社がプライバシーポリシーを変更する場合には、当社はこの変更についてホームページに掲載します。それによりお客様は常に当社がどのような情報を収集しているのか、 そしてどのようにその情報を利用しているかについてご確認頂けます。</p><p>目的の範囲内での利用</p><p>当社は、当サイト上で収集されるお客様の個人情報ならびに当サイトを介さないで収集されるお客様の個人情報を、 プライバシーポリシーに開示されていることと異なった方法で利用することは致しません。</p><p><br></p><p><b>収集した個人情報の利用</b></p><p>１．お客様に競馬に関する情報または特別なサービスや企画などの情報を的確にお知らせするために利用します。</p><p>２．事業を遂行するために必要な範囲において利用します。</p><p>３．必要に応じてお客様と連絡を取るために利用します。</p><p>４．個人情報の公開または個人を特定できるような利用は致しません。</p><p>個人情報の開示、修正、利用停止、削除</p><p>弊社が保有する個人情報について、お客様からの要請に基づき個人情報の開示、誤りなどの修正、利用停止、削除等がある場合には、 第三者による個人情報の改ざんを防止するため、お客様本人であることを確認の上、弊社手続きに従い個人情報の開示、修正、利用停止、削除などを行います。要請はメールにて受け付けるものとします。</p><p><br></p><p><b>第三者への提供</b></p><p>当社は、以下に該当する場合を除き、あらかじめ本人の同意なくして個人情報を第三者に提供致しません。 なお、下記のパートナーシップを築いている会社および委託協力会社とは、必要に応じて情報の共有に際して守秘義務を含む契約を締結し、 必要な目的の範囲内で必要な情報のみを開示し、サービスの提供を目的とする以外での情報の利用を禁止しております。パートナーシップを築いている会社、 委託協力会社にも当社同様に個人情報の適切な管理を要求しております。</p><p>１．事業を遂行するために必要な範囲において利用します。</p><p>２．お客様により良いサービスを提供するために当社が保有している情報と組み合わせて使用する場合があり、ご登録頂いた個人情報は提携配送業者等に一部情報を提供しております。 ただし、上記の業務範囲に限ります。</p><p>３．プレゼント賞品の配送には外部の運送業者を使用しております。</p><p>４．新たなサービスの提供をする場合には他の第三者とパートナー関係を築くことがあります。この際、お客様がこれらのサービスをご利用されることに同意された場合に限り、 当社はこれらサービスを提供する第三者にとって必要となるお客様の氏名やその他連絡先等の情報を預託または提供することがあります。</p><p>５．法律に基づいた手続きにより開示が求められた場合、お客様の個人情報を正規手続きの後、公的機関に対して開示することがあります。ただし以下に該当する場合は上記に定める第三者には該当しません。</p><p>・運営者が利用目的の達成に必要な範囲内において個人情報の取扱いの全部または一部を委託する場合</p><p>・個人情報を特定の者との間で共同して利用する場合であって、共同して利用される個人情報の項目、共同して利用する者の範囲、 利用する者の利用目的および当該個人情報の管理について責任を有する者の氏名または名称について、あらかじめご本人に通知し、またはご本人が容易に知り得る状態に置いている場合。</p><p><br></p><p><b>外部サイトへのリンク</b></p><p>当サイトは外部サイトへのリンクを含んでおりますが、外部サイトで収集されるお客様の個人情報について責任を負いません。 当社としては、お客様が当社のサイトからリンク先のサイトに移るとき、もしくは当社以外のサイトに直接移るときは、 個人情報を収集するすべてのサイトのプライバシーポリシーをお読み頂くようお願い申し上げます。</p>', 0, '2018-10-16 19:49:56', '2019-03-08 06:56:06'),
(10, '特商法', 'trans', '/trans', '<table>\r\n  <tbody>\r\n  <tr>\r\n    <th>販売事業者</th>\r\n    <td>ワンアンドオンリー運営事務局<br></td>\r\n  </tr>\r\n  <tr>\r\n    <th>運営サイト</th>\r\n    <td>ワンアンドオンリー</td>\r\n  </tr>\r\n  <tr>\r\n    <th>所在地</th>\r\n    <td> 東京都中野区中野4-2-1</td>\r\n  </tr>\r\n  <tr>\r\n    <th>運営・販売責任者</th>\r\n    <td>上野亘広</td>\r\n  </tr>\r\n  <tr>\r\n    <th>連絡先</th>\r\n    <td>\r\n      TEL：050-6874-4880<br>\r\n      E-MAIL：info@1and0nly.jp\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>商品の種類</th>\r\n    <td>■ポイント制<br>\r\n      有料情報1pt＝100円<br>\r\n      商品ページに個別表記<br>\r\n      無料情報・無料コンテンツ＝無料(0円)<br>\r\n      有料情報であるキャンペーン・イベント期間等は商品内容により販売価格が異なります。<br>\r\n      詳細はウェブページ・ご案内メールにてご確認下さい。\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>お支払い方法</th>\r\n    <td>\r\n      銀行振込 <br>\r\n      クレジット <br>\r\n      <br>\r\n      お問い合わせはテレコムクレジット株式会社にご連絡下さい。 <br>\r\n      テレコムクレジット株式会社 <br>\r\n      ・電話番号：0570-055-065 <br>\r\n      ・メールアドレス：info@telecomcredit.co.jp<br>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>支払い期限</th>\r\n    <td>\r\n      商品･サービス提供前の前払い制となります。\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>商品代金以外の費用</th>\r\n    <td>\r\n      通信費、振込み手数料はお客様のご負担となります。\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>引渡し日時</th>\r\n    <td>\r\n      競馬開催日の前日、または当日に特設ページにて引き渡し。\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <th>返品（返金）に関する特約</th>\r\n    <td>\r\n      約 ポイントの返金は受け付けておりません。<br>\r\n      デジタルコンテンツでの情報サービスという商品の性質上、返金は行っておりません。<br>\r\n      また、返品依頼も受け付けておりません。\r\n    </td>\r\n  </tr>\r\n  </tbody>\r\n</table>', 0, '2018-10-16 19:50:12', '2019-03-09 16:30:18'),
(11, 'TEST_about', 'about', 'about', '<div id=\"about01\" class=\"font\">\r\n        <p class=\"center title\"><span class=\"gold\">＜ONE AND ONLY＞</span>とは・・・</p>\r\n\r\n        <p>競馬の発祥の地である英国では、「競馬は貴族の遊び」と言われているように、元々は庶民とは縁の遠い存在にあった競馬。</p>\r\n        <p>つまりは、競馬の本質は、資本力のある成功者にとっての「大人のたしなみ」である。</p>\r\n\r\n        <p class=\"txt23 center\">「ダービー馬のオーナーになることは一国の宰相になることより難しい」</p>\r\n\r\n        <p>このような言葉が生まれた背景には、資本力、強運だけでは簡単にダービーのタイトルを獲ることはできない成功者たちによる激しい競争という資本主義的な背景がある。</p>\r\n\r\n        <p>「資本力」や「強運力」を競い合い、誰よりも強い競走馬を所有することに喜びを感じる貴族たちにとっての遊びが進化し、日本という国では“馬券売り上げ”が国の財源の1つとして確立されたのが現代日本競馬誕生の経緯。</p>\r\n\r\n        <p>資本力を持つビジネスの成功者が、サラブレッドを購入し走らせる側の「馬主」となり、繰り広げられているのが競馬の本質。<br>\r\n          だからこそ、競馬界の中心は【馬主】ということである。</p>\r\n\r\n        <p>一般の競馬ファンによる馬券購入の売り上げによって、大きな興業ビジネスとなっている競馬であるにも関わらず、いまだに一般競馬ファンには届くことのない情報は数多い。</p>\r\n\r\n        <p>競走馬を生産した牧場が、庭先での取引やセールに上場させて、馬主に「より高額で」競走馬を購入してもらう。</p>\r\n\r\n        <p>競走馬を購入した「馬主」は、繋がりのある調教師のもとに愛馬を預ける。</p>\r\n\r\n        <p>調教師は、「馬主」や「牧場」と相談しながら、レースや騎手を選び、レース賞金を稼ぎながら、厩舎を経営してゆく。</p>\r\n\r\n        <p>生産牧場は、「1頭でも多く、1円でも高く、馬を購入してもらう」ことに精力を尽くす。<br>\r\n          そのためには馬主とともに競走馬の所有権利を“半持ち”にしてでも、馬主側へのリスク対策も提案しながら、売りさばいていく。</p>\r\n\r\n        <p>馬主は、「ダービーを勝てる馬」を探し求める夢を追う場合や「購入金額よりも稼いでくれる馬」という投資的観点から、買う価値があると判断する馬を選んで購入する。</p>\r\n\r\n        <p>ここには、当然【政治力】が働き、またビジネスである以上は【駆け引き】も存在している。<br>\r\n          「走らない馬でも高く買ってもらいたい」という本音もあるが、誰を相手にしてでもそのような営業をしていれば、次回は買ってもらうことはできなくなることは当然。</p>\r\n\r\n        <p>\r\n          そのために、「長く馬主を続けるであろう」という重要馬主には、“駄馬”はそう簡単には売らない。もちろん「これは走る！」という馬が、思ったほど走らないケースもあるが、その場合には、また良い条件で馬の購入を提案する動きは必ずと言っていいほどある。</p>\r\n\r\n        <p>しかしながら、その一方で「この馬主は、長くはやらないだろうなぁ。お金があるだけだな」と見るやいなや、「良血でも走らないであろうデキのよくない馬」を血統面だけの魅力を説き、強気の高額購入へと舵を取る。</p>\r\n\r\n        <p>客観的に見れば、牧場の「ぼったくり」のようにも見えてしまうが、「一見さん」に対しては、最初は「疑いの目」から入るのは、どの業界でも珍しい話ではなく、ビジネスという観点では当然と言っても過言ではない。</p>\r\n\r\n        <p>もちろん良好な関係にある馬主には、「レースで勝って良い思いをしてもらいたい！」という思惑も働くことで、間接的に利権関係者による圧力がレースに影響を及ぼすことも日常茶飯事である。</p>\r\n\r\n        <p>このような「競馬の本質」を知っていれば、「走る馬」や「走る情報」、「本気の勝負どころ」を事前に知れることになるわけだが、そのような裏側のやりとりなどが表沙汰になることはまずあり得ない。</p>\r\n\r\n        <p class=\"center txt23\">競馬は「資本力のある成功者たちの遊び」が本質。</p>\r\n\r\n        <p>\r\n          馬券売り上げについては、馬券を購入するファンが「馬券の勝ち負け」を楽しんでくれていれば成り立つわけであり、馬券を購入する人間に対しては、誰が勝とうが、誰が負けようが、主催者側や競馬界の重鎮組織にとっては、一切関係ないのである。</p>\r\n\r\n        <p>主催者は、「100円でも多く馬券が売れる」ことが目的であるため、走らせる側の思惑については、一般競馬ファン側に伝える必要は全くない。</p>\r\n\r\n        <p>また馬を走らせる重鎮関係者にとっても、「一般の競馬ファンの馬券の勝ち負け」は一切関係ない。「馬を走らせる側の利権関係者が良い思いができるかどうか」が焦点となる。</p>\r\n\r\n        <p>そのような相関関係を知っていれば、一般競馬ファンに知れ渡るような情報は、勝負とはあまり関係のない次元の情報内容に過ぎないということが当たり前であることも理解できるはず。</p>\r\n\r\n        <p>これが、「馬券売り上げで成り立つ日本競馬」と、「馬券を購入する一般の競馬ファンには本物の情報が出回らない」という矛盾が生じる真相である。</p>\r\n\r\n        <p>情報を共有する場を設けて、交流の場を作り、そして、この「矛盾」を少しでも埋めることが出来る場所、それが<span class=\"gold\">＜ONE AND ONLY＞</span>の世界。</p>\r\n\r\n        <p>\r\n          もちろん馬券を購入するのは、一般の競馬ファンだけでなく、馬主や牧場関係者も馬券を購入できる立場であるからこそ、馬主関係者や生産牧場関係者を中心とし、【完全招待制】【会員制】を導入させていただいたというわけである。</p>\r\n\r\n        <p>情報を持っている者同士が交流し、情報を共有することで［WIN＝WIN］の関係を構築していくための<span class=\"gold\">＜ONE AND ONLY＞</span>の世界で、より充実した競馬ライフ・馬主ライフをお過ごし頂きたい。\r\n        </p>\r\n\r\n        <p>本気で競馬を愛する者同士が、一般競馬ファンとは次元の違う領域で上質な競馬を楽しんでいただく場所を、<span class=\"gold\">＜ONE AND ONLY＞</span>という名を用いて、業界で初めて導入した経緯をご理解ください。\r\n        </p>\r\n\r\n        <p>そのため<span class=\"gold\">＜ONE AND ONLY＞</span>の会員登録については、</p>\r\n\r\n        <p class=\"center txt23 red\">馬主関係者様<br>\r\n          牧場関係者様<br>\r\n          競馬メディア関係者様<br>\r\n          競馬サークル関係者様<br>\r\n        </p>\r\n\r\n        <p>そして、信頼ある競馬関係者の会員様の紹介を受けて、「情報の取り扱いに関して信用できる一般会員様」に限らせて頂いております。</p>\r\n\r\n        <p>\r\n          また長期的にご愛顧頂いている会員様や情報提供をくださっている会員様、有料情報に数多く参加されている会員様におかれましては、より快適に、より有益に弊社をご利用いただけるサービスプログラムを用意するために、＜ステータス制度＞を設けております。</p>\r\n\r\n      </div>', 0, '2018-11-30 22:43:07', '2019-02-22 01:35:34'),
(12, '的中実績', 'result', '/result', '<p>\r\n\r\n\r\n\r\n\r\n<style type=\"text/css\">\r\np.p1 {margin: 0.0px 0.0px 0.0px 0.0px; font: 12.0px \'Hiragino Sans\'}\r\n</style>\r\n\r\n\r\n</p><blockquote><p><b>京都記念週 2019年2月9日・10日・11日</b><br></p><p>▼提供結果一覧▼</p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"background-color: rgb(255, 0, 255);\"><span style=\"font-weight: 600;\">≪クリスタルクラス限定提供≫</span></span></p><p><span style=\"font-size: 1rem; font-weight: bold;\"><u>【GREAT-NINE】</u></span><br></p><p>本日の提供はございません</p><p><br></p><p><u style=\"font-weight: bold;\">【ONLY ONE】</u></p><p><span style=\"font-size: 1rem;\">2月10日（日）</span><br></p><p><span style=\"font-size: 1rem;\">京都9</span><span style=\"font-size: 1rem;\">R 松籟ステークス</span></p><p><span style=\"font-size: 1rem;\">1着◎シャルドネゴールド（1</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着○マイハートビート（2番人気）</span></p><p><u style=\"font-weight: 600; color: rgb(255, 0, 0); font-size: 1rem;\">馬単460円的中！</u><br></p><p><br></p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"font-size: 1rem; background-color: rgb(0, 255, 255);\"><span style=\"font-weight: 600;\">≪ダイヤモンドクラス以上限定提供≫</span></span></p><p><span style=\"font-size: 1rem; font-weight: bold;\"><u>【RECEPTION RACE】</u></span><br></p><p>本日の提供はございません</p><p><br></p><p><u style=\"font-weight: bold;\">【THE STALLION】</u></p><p><span style=\"font-size: 1rem;\">2月9日（土）</span><br></p><p><span style=\"font-size: 1rem;\">京都10</span><span style=\"font-size: 1rem;\">R 琵琶湖特別</span></p><p><span style=\"font-size: 1rem;\">1着◎フォイヤーヴェルグ（4</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着○アロマドゥルセ（2番人気）</span></p><p><span style=\"font-size: 1rem;\">3着△テーオーフォルテ（3番人気）</span></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>3連単5540円的中！</u></span></font></p><p><br></p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"font-size: 1rem; background-color: rgb(0, 255, 0);\"><span style=\"font-weight: 600;\">≪ゴールドクラス以上限定提供≫</span></span><br></p><p><u style=\"font-size: 1rem; font-weight: bold;\">【OWNERS SECRET】</u><br></p><p>本日の提供はございません</p><div><span style=\"color: rgb(255, 0, 0); font-size: 1rem; font-weight: bold; text-decoration-line: underline;\"><br></span></div><p><br></p><p><u style=\"font-weight: bold;\">【AGENT-EYE】</u></p><p><span style=\"font-size: 1rem;\">2月9日（土）</span><br></p><p><span style=\"font-size: 1rem;\">小倉9R 4歳以上500万下</span><br></p><p><span style=\"font-size: 1rem;\">1着◎サトノゲイル（2番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着▲ブラックカード（1番人気）</span></p><p><span style=\"font-size: 1rem;\">3着○メンターモード（5番人気）</span><br></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>3連単3220円的中！</u></span></font></p><p><br></p><p>◇◇◇◇◇◇◇◇◇◇◇◇◇◇◇</p><p><span style=\"font-size: 1rem; background-color: rgb(255, 255, 0);\"><span style=\"font-weight: 600;\">【トライアルパック】</span></span><br></p><p><span style=\"font-size: 1rem;\">2月10日（日）</span><br></p><p><span style=\"font-size: 1rem;\">東京9</span><span style=\"font-size: 1rem;\">R 初音ステークス</span></p><p><span style=\"font-size: 1rem;\">1着　ダノングレース（6</span><span style=\"font-size: 1rem;\">番人気）</span><br></p><p><span style=\"font-size: 1rem;\">2着　フィニフティ（3番人気）</span></p><p><span style=\"font-size: 1rem;\">3着　シャンティローザ（12番人気）</span></p><p><font color=\"#ff0000\"><span style=\"font-weight: 600;\"><u>不的中</u></span></font></p></blockquote>', 0, '2018-12-26 23:23:49', '2019-02-10 23:38:22'),
(13, 'free', 'free', '/free', '<p>text<br></p>', 0, '2019-02-27 06:19:47', '2019-02-27 06:19:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `point`
--

CREATE TABLE `point` (
  `id` int(10) UNSIGNED NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `point`
--

INSERT INTO `point` (`id`, `point`, `price`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 30, 3000, 1, '2018-10-21 08:33:17', '2018-10-21 08:33:17'),
(2, 50, 5000, 0, '2018-10-21 08:33:28', '2018-10-21 08:33:28'),
(3, 100, 10000, 0, '2018-10-21 08:33:37', '2018-10-21 08:33:37'),
(4, 140, 14000, 1, '2018-10-21 08:33:50', '2018-10-21 08:33:50'),
(5, 200, 20000, 0, '2018-10-21 08:33:59', '2018-10-21 08:33:59'),
(6, 300, 30000, 0, '2018-10-21 08:34:07', '2018-10-21 08:34:07'),
(7, 400, 40000, 0, '2018-10-21 08:34:16', '2018-10-21 08:34:16'),
(8, 500, 50000, 0, '2018-10-21 08:34:27', '2018-10-21 08:34:27'),
(9, 700, 70000, 0, '2018-10-21 08:34:37', '2018-10-21 08:34:37'),
(10, 800, 80000, 1, '2018-10-21 08:34:47', '2018-10-21 08:34:47'),
(11, 900, 90000, 0, '2018-10-21 08:34:58', '2018-10-21 08:34:58'),
(12, 1000, 100000, 0, '2018-10-21 08:35:09', '2018-10-21 08:35:09'),
(13, 1200, 120000, 1, '2018-10-21 08:35:26', '2018-10-21 08:35:26'),
(14, 1500, 150000, 0, '2018-10-21 08:35:37', '2018-10-21 08:35:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prediction`
--

CREATE TABLE `prediction` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_level` int(11) NOT NULL DEFAULT '0',
  `user_stage_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prediction_type` tinyint(4) DEFAULT NULL,
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
  `info_start_time` timestamp NULL DEFAULT NULL,
  `send_mail_open` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail_done` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `prediction`
--

INSERT INTO `prediction` (`id`, `name`, `img_banner`, `member_level`, `user_stage_id`, `prediction_type`, `default_point`, `status`, `content`, `after_buy`, `result`, `number_access`, `number_buyer`, `display_order`, `start_time`, `end_time`, `info_start_time`, `send_mail_open`, `send_mail_done`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'hehe', '/uploads/prediction_type/1542335031_trail_pack.png', 0, '0,1,2,11,12,14,15,16,17,19,20,22,25,', 1, 60, 2, 'aaaa', 'ssss', 'dddd', 2, 3, 0, '2019-02-01 03:27:00', '2019-03-10 03:27:00', '2019-03-01 03:27:00', 0, 0, 0, '2019-02-27 05:28:09', '2019-03-09 06:23:03'),
(2, 'haha', '/uploads/prediction_type/1542335031_trail_pack.png', 0, '0,1,2,11,12,14,15,16,17,19,20,22,25,', 1, 60, 2, 'www', 'www', 'www', 2, 0, 0, '2019-01-28 03:28:00', '2019-03-09 03:28:00', '2019-03-02 03:28:00', 0, 0, 0, '2019-02-27 05:28:49', '2019-03-08 11:33:05'),
(3, 'eee', '/uploads/prediction_type/1542335031_trail_pack.png', 0, '0,1,2,11,12,14,15,16,17,19,20,22,25,', 1, 120, 2, 'eee', 'rrr', 'ttt', 1, 1, 0, '2019-02-04 03:28:00', '2019-03-09 03:28:00', '2019-03-03 03:29:00', 0, 0, 0, '2019-02-27 05:29:25', '2019-02-27 05:45:36'),
(4, 'adfadf', NULL, 0, '0,1,2,11,12,14,15,16,17,19,20,22,25,', NULL, 120, 2, 'adfadf', 'adfadf', 'adfadf', 1, 1, 0, '2019-02-07 04:01:00', '2019-03-08 04:01:00', '2019-02-28 04:01:00', 0, 0, 0, '2019-02-27 06:02:28', '2019-02-27 06:11:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prediction_result`
--

CREATE TABLE `prediction_result` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `prediction_type`
--

CREATE TABLE `prediction_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `prediction_type`
--

INSERT INTO `prediction_type` (`id`, `name`, `code`, `image`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'トライアルパック', 'trial_pack', '/uploads/prediction_type/1552195809_lp-1st.jpg', 0, '2018-11-16 17:23:51', '2019-03-10 07:30:09'),
(2, 'オーナーズシークレット', 'owners_secret', '/uploads/prediction_type/1542335067_owners_secret.png', 1, '2018-11-16 17:24:27', '2018-11-16 17:24:27'),
(3, 'エージェントアイ', 'agent_eye', '/uploads/prediction_type/1542335091_agent_eye.png', 1, '2018-11-16 17:24:51', '2018-11-16 17:24:51'),
(4, 'レセプションレース', 'reception_race', '/uploads/prediction_type/1542335107_reception_race.png', 1, '2018-11-16 17:25:07', '2018-11-16 17:25:07'),
(5, 'ザスタリオン', 'the_stallion', '/uploads/prediction_type/1542335130_the_stallion.png', 1, '2018-11-16 17:25:30', '2018-11-16 17:25:30'),
(6, 'グレートナイン', 'great_nine', '/uploads/prediction_type/1542335192_great_nine.png', 1, '2018-11-16 17:26:32', '2018-11-16 17:26:32'),
(7, 'オンリーワン', 'only_one', '/uploads/prediction_type/1542335210_only_one.png', 1, '2018-11-16 17:26:50', '2018-11-16 17:26:50'),
(8, 'trial_01', '1', '/uploads/prediction_type/1552106408_trial01.png', 0, '2019-03-09 06:40:08', '2019-03-09 06:40:08'),
(9, 'trial_02', '2', '/uploads/prediction_type/1552106427_trial02.png', 0, '2019-03-09 06:40:27', '2019-03-09 06:40:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result`
--

CREATE TABLE `result` (
  `id` int(10) UNSIGNED NOT NULL,
  `course` tinyint(4) DEFAULT NULL,
  `double` tinyint(4) DEFAULT NULL,
  `race_no_1_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `race_no_1_num` tinyint(4) NOT NULL,
  `place_1` int(10) NOT NULL,
  `race_no_2_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `race_no_2_num` tinyint(4) NOT NULL,
  `place_2` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `korogashi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bike_number_1` tinyint(4) DEFAULT NULL,
  `bike_number_2` tinyint(4) DEFAULT NULL,
  `bike_number_3` tinyint(4) DEFAULT NULL,
  `won_man` int(10) NOT NULL DEFAULT '0',
  `won_yen` int(10) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `result`
--

INSERT INTO `result` (`id`, `course`, `double`, `race_no_1_title`, `race_no_1_num`, `place_1`, `race_no_2_title`, `race_no_2_num`, `place_2`, `date`, `korogashi`, `ticket_type`, `bike_number_1`, `bike_number_2`, `bike_number_3`, `won_man`, `won_yen`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'cường', 2, 44, 'khánh', 12, 40, '2019-02-13 17:00:00', '123', '3', 1, 1, 1, 0, 0, 0, '2019-02-28 10:47:17', '2019-03-01 09:14:35'),
(2, 1, 1, 'qwqwqw', 2, 43, 'aazxx', 5, 28, '2019-03-13 17:00:00', 'qwq', '2', 0, 0, 0, 0, 0, 0, '2019-03-10 10:15:59', '2019-03-10 10:15:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_deposit`
--

CREATE TABLE `transaction_deposit` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `method` tinyint(4) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail` tinyint(4) NOT NULL DEFAULT '0',
  `mail_deposit` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `result` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction_deposit`
--

INSERT INTO `transaction_deposit` (`id`, `user_id`, `login_id`, `member_level`, `method`, `point`, `amount`, `status`, `send_mail`, `mail_deposit`, `note`, `result`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:42:39', '2019-02-26 10:42:39'),
(2, 4, '6095850', 0, 1, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:44:16', '2019-02-26 10:44:16'),
(3, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:44:54', '2019-02-26 10:44:54'),
(4, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:44:56', '2019-02-26 10:44:56'),
(5, 4, '6095850', 0, 1, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:45:01', '2019-02-26 10:45:01'),
(6, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:49:42', '2019-02-26 10:49:42'),
(7, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:50:35', '2019-02-26 10:50:35'),
(8, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:51:11', '2019-02-26 10:51:11'),
(9, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:52:32', '2019-02-26 10:52:32'),
(10, 4, '6095850', 0, 0, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 10:59:20', '2019-02-26 10:59:20'),
(11, 4, '6095850', 0, 1, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 11:05:02', '2019-02-26 11:05:02'),
(12, 4, '6095850', 0, 1, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 11:05:44', '2019-02-26 11:05:44'),
(13, 4, '6095850', 0, 1, 50, 5000, 0, 0, NULL, NULL, NULL, 0, '2019-02-26 11:08:43', '2019-02-26 11:08:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_gift`
--

CREATE TABLE `transaction_gift` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction_gift`
--

INSERT INTO `transaction_gift` (`id`, `user_id`, `login_id`, `member_level`, `type`, `gift_id`, `gift_name`, `point`, `status`, `send_mail`, `note`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 3, '6787486', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-02-26 09:35:04', '2019-02-26 09:35:04'),
(2, 4, '6095850', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-02-26 09:42:49', '2019-02-26 09:42:49'),
(3, 5, '6290110', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-06 10:25:49', '2019-03-06 10:25:49'),
(4, 6, '9489570', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-06 10:26:32', '2019-03-06 10:26:32'),
(5, 7, '5983650', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-06 10:27:21', '2019-03-06 10:27:21'),
(6, 8, '3003896', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-06 10:33:12', '2019-03-06 10:33:12'),
(7, 9, '2772776', 1, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-06 16:16:44', '2019-03-06 16:16:44'),
(8, 10, '6100806', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-07 04:46:00', '2019-03-07 04:46:00'),
(9, 11, '9571322', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-07 05:38:30', '2019-03-07 05:38:30'),
(10, 12, '5355579', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-07 05:46:11', '2019-03-07 05:46:11'),
(11, 1, '4915659', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-07 06:55:15', '2019-03-07 06:55:15'),
(12, 2, '7398975', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-08 05:11:13', '2019-03-08 05:11:13'),
(13, 1, '4915659', 0, 2, 0, 'haha', 10000, 1, 0, NULL, 0, '2019-03-09 06:20:29', '2019-03-09 06:20:29'),
(14, 2, '7398975', 0, 2, 0, 'haha', 10000, 1, 0, NULL, 0, '2019-03-09 06:20:30', '2019-03-09 06:20:30'),
(15, 3, '7274581', 0, 3, 0, '入口設定により追加', 0, 1, 1, NULL, 0, '2019-03-09 16:23:49', '2019-03-09 16:23:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_payment`
--

CREATE TABLE `transaction_payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `point` int(11) NOT NULL DEFAULT '0',
  `prediction_id` int(11) NOT NULL,
  `prediction_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prediction_type` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `send_mail_payment` tinyint(4) NOT NULL DEFAULT '0',
  `mail_payment` text COLLATE utf8mb4_unicode_ci,
  `send_mail_prediction_result` tinyint(4) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction_payment`
--

INSERT INTO `transaction_payment` (`id`, `user_id`, `login_id`, `member_level`, `point`, `prediction_id`, `prediction_name`, `prediction_type`, `status`, `send_mail_payment`, `mail_payment`, `send_mail_prediction_result`, `note`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, '3841308', 2, 60, 1, 'hehe', NULL, 1, 0, NULL, 0, NULL, 0, '2019-02-27 05:29:53', '2019-02-27 05:29:53'),
(2, 1, '3841308', 2, 120, 3, 'eee', NULL, 1, 0, NULL, 0, NULL, 0, '2019-02-27 05:45:35', '2019-02-27 05:45:35'),
(3, 1, '3841308', 2, 120, 4, 'adfadf', NULL, 1, 0, NULL, 0, NULL, 0, '2019-02-27 06:11:41', '2019-02-27 06:11:41'),
(4, 2, '7398975', 0, 60, 1, 'hehe', NULL, 1, 0, NULL, 0, NULL, 0, '2019-03-09 06:20:42', '2019-03-09 06:20:42'),
(5, 2, '7398975', 0, 60, 1, 'hehe', NULL, 1, 0, NULL, 0, NULL, 0, '2019-03-09 06:23:02', '2019-03-09 06:23:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `provider` varchar(50) NOT NULL DEFAULT '0',
  `provider_id` varchar(50) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login_id` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_key` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL DEFAULT '0',
  `age` int(11) NOT NULL,
  `member_level` tinyint(4) NOT NULL DEFAULT '0',
  `mail_pc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stop_mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mail_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_stage_id` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entrance_id` int(11) DEFAULT NULL,
  `media_code` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT 'zzz',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_time` timestamp NULL DEFAULT NULL,
  `interim_register_time` timestamp NULL DEFAULT NULL,
  `send_mail` int(11) NOT NULL DEFAULT '0',
  `mail_register` text COLLATE utf8mb4_unicode_ci,
  `send_mail_interim` int(11) NOT NULL DEFAULT '0',
  `mail_interim` text COLLATE utf8mb4_unicode_ci,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `login_id`, `user_key`, `password`, `nickname`, `password_text`, `gender`, `age`, `member_level`, `mail_pc`, `stop_mail`, `mail_mobile`, `user_stage_id`, `entrance_id`, `media_code`, `remember_token`, `memo`, `register_time`, `interim_register_time`, `send_mail`, `mail_register`, `send_mail_interim`, `mail_interim`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '4915659', 'co2VVbX0XB', '$2y$10$ZFxwago6WWdGhJ2qEtyF8ulMs/PkAsRKk.z7TWYTpiO9LtFfSovQC', '', 'zn9UCwqrcB', 0, 20, 0, 'hoangdainghia0405@gmail.com', '0', '', '0,11,', 1, 'zzz', 'DGwuCGJtlAiosgwuHmiufVsNn9UcHX6KKK7SYr1nst7TOPkBxEEMTMxpYWQW', '', '2019-03-07 11:14:57', '2019-03-07 06:55:14', 0, NULL, 0, NULL, 0, '2019-03-07 06:55:14', '2019-03-08 05:16:51'),
(2, '7398975', 'DJnxLR580q', '$2y$10$Zo1Fqr45Rm6SS/mqebWIK.tV9gajJb2NPU/kLEH34Ej9cJWOmq.si', 'teo', '12345', 0, 20, 0, 'testuser12345@gmail.com', '0', 'teo@gmail.com', '0,1,2,11,12,14,15,16,17,19,20,22,25,', 1, 'zzz', '3FaCoi3qRKtaZrJ7eNzSMbIR05uEWODq9b5recPrT8MQRQiZ0TSQMvNa3nut', '', '2019-03-08 10:40:03', '2019-03-08 05:11:13', 1, '{\"12\":12}', 0, NULL, 0, '2019-03-08 05:11:13', '2019-03-11 03:46:59'),
(3, '7274581', 'kIBvssR7om', '$2y$10$7F.7jPH9lzX/xelCSFHcTuoRPOIFPgiP3NR3IlOz7ExM0gye3kSfO', '', 'cTfcKhkE4l', 0, 20, 0, 'admin123456@gmail.com', '0', '', '0,11,', 1, 'zzz', NULL, '', NULL, '2019-03-09 16:23:49', 0, NULL, 0, NULL, 0, '2019-03-09 16:23:49', '2019-03-09 16:23:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_access_blog`
--

CREATE TABLE `user_access_blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_access_blog`
--

INSERT INTO `user_access_blog` (`id`, `user_id`, `blog_id`, `number_access`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 6, 0, '2019-03-08 06:05:26', '2019-03-08 06:34:23'),
(2, 1, 4, 3, 0, '2019-03-08 06:10:40', '2019-03-08 06:11:09'),
(3, 1, 3, 8, 0, '2019-03-08 06:11:54', '2019-03-08 06:34:15'),
(4, 1, 1, 14, 0, '2019-03-08 06:37:02', '2019-03-08 06:53:21'),
(5, 2, 3, 2, 0, '2019-03-09 08:08:42', '2019-03-09 08:08:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_access_prediction`
--

CREATE TABLE `user_access_prediction` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `prediction_id` int(11) NOT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `buy` tinyint(4) NOT NULL DEFAULT '0',
  `access_result` tinyint(4) DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_access_prediction`
--

INSERT INTO `user_access_prediction` (`id`, `user_id`, `prediction_id`, `number_access`, `buy`, `access_result`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 1, 1, 0, '2019-02-27 05:29:43', '2019-03-08 03:30:29'),
(2, 1, 2, 4, 0, 0, 0, '2019-02-27 05:29:44', '2019-03-08 03:30:29'),
(3, 1, 3, 8, 1, 0, 0, '2019-02-27 05:29:44', '2019-02-27 06:12:09'),
(4, 1, 4, 4, 1, 0, 0, '2019-02-27 06:10:42', '2019-02-27 06:12:09'),
(5, 2, 1, 50, 1, 1, 0, '2019-03-08 11:33:05', '2019-03-09 16:18:15'),
(6, 2, 2, 1, 0, 0, 0, '2019-03-08 11:33:05', '2019-03-08 11:33:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `point`, `point_payment`, `point_deposit`, `point_gift`, `deposit_number`, `deposit_amount`, `payment_number`, `login_number`, `user_agent`, `ip`, `last_login_time`, `last_access_time`, `first_deposit_time`, `last_deposit_time`, `first_payment_time`, `last_payment_time`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, 10000, 0, 0, 10000, 0, 0, 0, 6, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-08 05:59:56', '2019-03-08 06:56:14', NULL, NULL, NULL, NULL, 0, '2019-03-07 06:55:14', '2019-03-09 06:20:30'),
(2, 2, 9880, 120, 0, 10000, 0, 0, 2, 12, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-11 04:48:51', '2019-03-11 06:02:30', NULL, NULL, '2019-03-09 06:20:43', '2019-03-09 06:23:02', 0, '2019-03-08 05:11:13', '2019-03-11 06:02:30'),
(3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2019-03-09 16:23:49', '2019-03-09 16:23:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_daily_access_history`
--

CREATE TABLE `user_daily_access_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_date` timestamp NULL DEFAULT NULL,
  `number_access` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_daily_access_history`
--

INSERT INTO `user_daily_access_history` (`id`, `user_id`, `login_id`, `user_agent`, `ip`, `access_date`, `number_access`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '::1', '2019-02-24 17:00:00', 9, 0, '2019-02-25 12:34:25', '2019-02-25 13:26:23'),
(2, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', '::1', '2019-02-25 17:00:00', 155, 0, '2019-02-26 03:35:48', '2019-02-26 11:41:40'),
(3, '4', '6095850', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', '::1', '2019-02-25 17:00:00', 34, 0, '2019-02-26 10:13:44', '2019-02-26 11:19:13'),
(4, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', '::1', '2019-02-26 17:00:00', 44, 0, '2019-02-27 04:40:46', '2019-02-27 06:20:52'),
(5, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-02-27 17:00:00', 49, 0, '2019-02-28 04:00:14', '2019-02-28 12:37:27'),
(6, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-02-28 17:00:00', 25, 0, '2019-03-01 09:11:51', '2019-03-01 12:11:09'),
(7, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-03 17:00:00', 4, 0, '2019-03-04 03:22:01', '2019-03-04 03:23:45'),
(8, '1', '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-05 17:00:00', 9, 0, '2019-03-06 16:27:40', '2019-03-06 16:45:45'),
(9, '1', '4915659', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-06 17:00:00', 18, 0, '2019-03-07 11:14:58', '2019-03-07 13:08:09'),
(10, '1', '4915659', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-07 17:00:00', 83, 0, '2019-03-08 03:30:16', '2019-03-08 06:56:14'),
(11, '2', '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-07 17:00:00', 20, 0, '2019-03-08 10:40:04', '2019-03-08 12:06:13'),
(12, '2', '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-08 17:00:00', 175, 0, '2019-03-09 04:04:06', '2019-03-09 16:18:15'),
(13, '2', '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-09 17:00:00', 2, 0, '2019-03-10 10:16:35', '2019-03-10 10:16:44'),
(14, '2', '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-10 17:00:00', 12, 0, '2019-03-11 03:45:39', '2019-03-11 06:02:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_daily_login_history`
--

CREATE TABLE `user_daily_login_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_date` timestamp NULL DEFAULT NULL,
  `login_number` int(11) NOT NULL DEFAULT '0',
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_daily_login_history`
--

INSERT INTO `user_daily_login_history` (`id`, `user_id`, `login_id`, `user_agent`, `ip`, `login_date`, `login_number`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36', '::1', '2019-02-24 17:00:00', 1, 0, '2019-02-25 12:34:24', '2019-02-25 12:34:24'),
(2, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', '::1', '2019-02-25 17:00:00', 6, 0, '2019-02-26 03:35:05', '2019-02-26 11:20:03'),
(3, 4, '6095850', 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1', '::1', '2019-02-25 17:00:00', 1, 0, '2019-02-26 10:13:44', '2019-02-26 10:13:44'),
(4, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:65.0) Gecko/20100101 Firefox/65.0', '::1', '2019-02-26 17:00:00', 1, 0, '2019-02-27 04:40:46', '2019-02-27 04:40:46'),
(5, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-02-27 17:00:00', 6, 0, '2019-02-28 05:56:11', '2019-02-28 09:23:48'),
(6, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-02-28 17:00:00', 2, 0, '2019-03-01 09:11:50', '2019-03-01 10:24:11'),
(7, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-03 17:00:00', 1, 0, '2019-03-04 03:21:58', '2019-03-04 03:21:58'),
(8, 1, '3841308', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-05 17:00:00', 2, 0, '2019-03-06 16:27:39', '2019-03-06 16:45:20'),
(9, 1, '4915659', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.119 Safari/537.36', '::1', '2019-03-06 17:00:00', 4, 0, '2019-03-07 11:14:57', '2019-03-07 11:29:49'),
(10, 1, '4915659', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-07 17:00:00', 2, 0, '2019-03-08 03:30:16', '2019-03-08 05:59:56'),
(11, 2, '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-07 17:00:00', 1, 0, '2019-03-08 10:40:03', '2019-03-08 10:40:03'),
(12, 2, '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-08 17:00:00', 8, 0, '2019-03-09 04:03:52', '2019-03-09 16:18:08'),
(13, 2, '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-09 17:00:00', 1, 0, '2019-03-10 10:16:34', '2019-03-10 10:16:34'),
(14, 2, '7398975', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36', '::1', '2019-03-10 17:00:00', 2, 0, '2019-03-11 03:45:39', '2019-03-11 04:48:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_stage`
--

CREATE TABLE `user_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(2) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_stage`
--

INSERT INTO `user_stage` (`id`, `name`, `stage`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, 'test user stay', 'test user stay 1', 0, '2018-10-23 18:50:30', '2019-01-15 23:50:50'),
(2, 'メール配信停止', 'メール配信停止', 0, '2018-10-23 18:51:20', '2019-02-03 01:08:21'),
(3, 'dsads', 'dsadsa', 1, '2018-10-23 19:01:06', '2018-10-23 19:01:06'),
(4, '123', '123', 1, '2018-10-23 21:42:12', '2018-10-23 21:42:12'),
(5, '3123', '123123', 1, '2018-10-23 21:42:16', '2018-10-23 21:42:16'),
(6, '123', '123', 1, '2018-10-23 21:42:19', '2018-10-23 21:42:19'),
(7, 'adf', 'adf', 1, '2018-10-23 21:42:31', '2018-10-23 21:42:31'),
(8, '123', '123123123', 1, '2018-10-23 21:42:34', '2018-10-23 21:42:34'),
(9, '123', '123123', 1, '2018-10-23 21:42:39', '2018-10-23 21:42:39'),
(10, 'adf', 'adfadf', 1, '2018-10-23 21:42:43', '2018-10-23 21:42:43'),
(11, 'トライアル', 'トライアル', 0, '2018-12-12 03:13:02', '2018-12-12 03:13:02'),
(12, 'ゴールド', 'ゴールド', 0, '2018-12-12 03:13:12', '2018-12-12 03:13:12'),
(13, 'ゴールド', 'ゴールド', 1, '2018-12-12 03:13:12', '2018-12-12 03:13:12'),
(14, 'ダイヤモンド', 'ダイヤモンド', 0, '2018-12-12 03:13:26', '2018-12-12 03:13:26'),
(15, 'クリスタル', 'クリスタル', 0, '2018-12-12 03:13:50', '2018-12-12 03:13:50'),
(16, '伸ばし', '伸ばしのアカウント', 0, '2019-01-16 00:21:31', '2019-01-16 00:21:31'),
(17, 'トライアルパック参加整理券取得者', '1/16(水)募集分', 0, '2019-01-17 18:29:34', '2019-01-17 18:29:34'),
(18, 'トライアル再案内', 'トライアル', 1, '2019-01-17 20:20:40', '2019-01-17 20:20:40'),
(19, 'トライアルパック参加確定(2月1週目より)', 'トライアルパック参加者', 0, '2019-01-18 16:06:18', '2019-02-02 00:26:58'),
(20, '【リークセレクション】モニター会員', '【リークセレクション】モニター会員', 0, '2019-01-25 17:28:46', '2019-01-25 17:28:46'),
(21, '2/1トライアルパック募集会員', '2/1トライアルパック募集会員', 1, '2019-02-01 16:46:46', '2019-02-01 16:46:46'),
(22, 'トライアルパック追加会員(2月1週目)', 'トライアルパック追加会員(2月1週目スタート)', 0, '2019-02-02 00:27:42', '2019-02-02 00:27:42'),
(23, 'aaaaaa', 'aaaa', 1, '2019-02-03 16:37:24', '2019-02-03 16:37:24'),
(24, '重賞オフレコパック案内者', '重賞オフレコパック', 1, '2019-02-08 01:12:39', '2019-02-08 01:12:56'),
(25, '重賞オフレコパック参加者', '重賞オフレコパック', 0, '2019-02-08 17:34:02', '2019-02-08 17:34:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `venue`
--

CREATE TABLE `venue` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `venue`
--

INSERT INTO `venue` (`id`, `name`, `css`, `image`, `deleted_flg`, `created_at`, `updated_at`) VALUES
(1, '函館', 'Hakodate', 'p-race01.svg', 0, '2019-02-27 11:56:14', '2019-02-27 11:56:14'),
(2, '青森', 'Aomori', 'p-race02.svg', 0, '2019-02-27 11:56:42', '2019-02-27 11:56:42'),
(3, 'いわき平', 'iwakitaira', 'p-race03.svg', 0, '2019-02-27 11:56:58', '2019-02-27 11:56:58'),
(4, '弥彦', 'yahiko', 'p-race04.svg', 0, '2019-02-27 11:57:18', '2019-02-27 11:57:18'),
(5, '前橋', 'maebashi', 'p-race05.svg', 0, '2019-02-27 11:57:35', '2019-02-27 11:57:35'),
(6, '取手', 'toride', 'p-race06.svg', 0, '2019-02-27 11:57:51', '2019-02-27 11:57:51'),
(7, '宇都宮', 'utsunomiya', 'p-race07.svg', 0, '2019-02-27 11:58:07', '2019-02-27 11:58:07'),
(8, '大宮', 'oomiya', 'p-race08.svg', 0, '2019-02-27 11:58:23', '2019-02-27 11:58:23'),
(9, '西武園', 'seibuen', 'p-race09.svg', 0, '2019-02-27 11:58:35', '2019-02-27 11:58:35'),
(10, '京王閣', 'keiokaku', 'p-race10.svg', 0, '2019-02-27 11:58:48', '2019-02-27 11:58:48'),
(11, '立川', 'tachikawa', 'p-race11.svg', 0, '2019-02-27 11:59:05', '2019-02-27 11:59:05'),
(12, '松戸', 'matsudo', 'p-race12.svg', 0, '2019-02-27 11:59:25', '2019-02-27 11:59:25'),
(13, '千葉', 'chiba', 'p-race13.svg', 0, '2019-02-27 11:59:52', '2019-02-27 11:59:52'),
(14, '川崎', 'kawasaki', 'p-race14.svg', 0, '2019-02-27 12:00:09', '2019-02-27 12:00:09'),
(15, '平塚', 'hiratsuka', 'p-race15.svg', 0, '2019-02-27 12:00:32', '2019-02-27 12:00:32'),
(16, '小田原', 'odawara', 'p-race16.svg', 0, '2019-02-27 12:00:46', '2019-02-27 12:00:46'),
(17, '伊東', 'ito', 'p-race17.svg', 0, '2019-02-27 12:01:04', '2019-02-27 12:01:04'),
(18, '静岡', 'shizuoka', 'p-race18.svg', 0, '2019-02-27 12:01:23', '2019-02-27 12:01:23'),
(19, '一宮', 'ichinomiya', 'p-race19.svg', 0, '2019-02-27 12:01:39', '2019-02-27 12:01:39'),
(20, '名古屋', 'nagoya', 'p-race20.svg', 0, '2019-02-27 12:01:53', '2019-02-27 12:01:53'),
(21, '岐阜', 'gifu', 'p-race21.svg', 0, '2019-02-27 12:02:17', '2019-02-27 12:02:17'),
(22, '大垣', 'ogaki', 'p-race22.svg', 0, '2019-02-27 12:02:32', '2019-02-27 12:02:32'),
(23, '豊橋', 'toyohashi', 'p-race23.svg', 0, '2019-02-27 12:02:49', '2019-02-27 12:02:49'),
(24, '富山', 'toyama', 'p-race24.svg', 0, '2019-02-27 12:03:07', '2019-02-27 12:03:07'),
(25, '松阪', 'matsuzaka', 'p-race25.svg', 0, '2019-02-27 12:03:23', '2019-02-27 12:03:23'),
(26, '四日市', 'yokkaichi', 'p-race26.svg', 0, '2019-02-27 12:03:39', '2019-02-27 12:03:39'),
(27, '福井', 'fukui', 'p-race27.svg', 0, '2019-02-27 12:03:56', '2019-02-27 12:03:56'),
(28, '奈良', 'nara', 'p-race28.svg', 0, '2019-02-27 12:04:13', '2019-02-27 12:04:13'),
(29, '向日町', 'mukomachi', 'p-race29.svg', 0, '2019-02-27 12:04:29', '2019-02-27 12:04:29'),
(30, '和歌山', 'wakayama', 'p-race30.svg', 0, '2019-02-27 12:04:43', '2019-02-27 12:04:43'),
(31, '岸和田', 'kishiwada', 'p-race31.svg', 0, '2019-02-27 12:04:57', '2019-02-27 12:04:57'),
(32, '玉野', 'tamano', 'p-race32.svg', 0, '2019-02-27 12:05:16', '2019-02-27 12:05:16'),
(33, '広島', 'hiroshima', 'p-race33.svg', 0, '2019-02-27 12:05:31', '2019-02-27 12:05:31'),
(34, '防府', 'hofu', 'p-race34.svg', 0, '2019-02-27 12:05:49', '2019-02-27 12:05:49'),
(35, '高松', 'takamatsu', 'p-race35.svg', 0, '2019-02-27 12:06:07', '2019-02-27 12:06:07'),
(36, '小松島', 'komatsujima', 'p-race36.svg', 0, '2019-02-27 12:06:22', '2019-02-27 12:06:22'),
(37, '高知', 'kochi', 'p-race37.svg', 0, '2019-02-27 12:06:40', '2019-02-27 12:06:40'),
(38, '松山', 'matsuyama', 'p-race38.svg', 0, '2019-02-27 12:06:54', '2019-02-27 12:06:54'),
(39, '小倉', 'ogura', 'p-race39.svg', 0, '2019-02-27 12:07:10', '2019-02-27 12:07:10'),
(40, '久留米', 'kurume', 'p-race40.svg', 0, '2019-02-27 12:07:22', '2019-02-27 12:07:22'),
(41, '武雄', 'takeo', 'p-race41.svg', 0, '2019-02-27 12:07:38', '2019-02-27 12:07:38'),
(42, '佐世保', 'sasebo', 'p-race42.svg', 0, '2019-02-27 12:07:51', '2019-02-27 12:07:51'),
(43, '別府', 'beppu', 'p-race43.svg', 0, '2019-02-27 12:08:09', '2019-02-27 12:08:09'),
(44, '熊本', 'kumamoto', 'p-race44.svg', 0, '2019-02-27 12:08:24', '2019-02-27 12:08:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_login_id_unique` (`login_id`);

--
-- Chỉ mục cho bảng `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `entrance`
--
ALTER TABLE `entrance`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `frontend_image`
--
ALTER TABLE `frontend_image`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_ban`
--
ALTER TABLE `mail_ban`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_bulk`
--
ALTER TABLE `mail_bulk`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_bulk_detail`
--
ALTER TABLE `mail_bulk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_bulk_done`
--
ALTER TABLE `mail_bulk_done`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_contact`
--
ALTER TABLE `mail_contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_deposit_detail`
--
ALTER TABLE `mail_deposit_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_gift_detail`
--
ALTER TABLE `mail_gift_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_interim_detail`
--
ALTER TABLE `mail_interim_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_payment_detail`
--
ALTER TABLE `mail_payment_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_prediction_open_detail`
--
ALTER TABLE `mail_prediction_open_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_prediction_result_detail`
--
ALTER TABLE `mail_prediction_result_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_register_detail`
--
ALTER TABLE `mail_register_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_replace`
--
ALTER TABLE `mail_replace`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_schedule`
--
ALTER TABLE `mail_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_schedule_detail`
--
ALTER TABLE `mail_schedule_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_schedule_done`
--
ALTER TABLE `mail_schedule_done`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `mail_template`
--
ALTER TABLE `mail_template`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `media_access`
--
ALTER TABLE `media_access`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_code_unique` (`code`);

--
-- Chỉ mục cho bảng `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `point_point_unique` (`point`);

--
-- Chỉ mục cho bảng `prediction`
--
ALTER TABLE `prediction`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `prediction_result`
--
ALTER TABLE `prediction_result`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `prediction_type`
--
ALTER TABLE `prediction_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction_deposit`
--
ALTER TABLE `transaction_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction_gift`
--
ALTER TABLE `transaction_gift`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction_payment`
--
ALTER TABLE `transaction_payment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD UNIQUE KEY `id` (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_login_id_unique` (`login_id`),
  ADD UNIQUE KEY `user_user_key_unique` (`user_key`);

--
-- Chỉ mục cho bảng `user_access_blog`
--
ALTER TABLE `user_access_blog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_access_prediction`
--
ALTER TABLE `user_access_prediction`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_daily_access_history`
--
ALTER TABLE `user_daily_access_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_daily_login_history`
--
ALTER TABLE `user_daily_login_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_stage`
--
ALTER TABLE `user_stage`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `entrance`
--
ALTER TABLE `entrance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `frontend_image`
--
ALTER TABLE `frontend_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `gift`
--
ALTER TABLE `gift`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `mail_ban`
--
ALTER TABLE `mail_ban`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `mail_bulk`
--
ALTER TABLE `mail_bulk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `mail_bulk_detail`
--
ALTER TABLE `mail_bulk_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_bulk_done`
--
ALTER TABLE `mail_bulk_done`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_contact`
--
ALTER TABLE `mail_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `mail_deposit_detail`
--
ALTER TABLE `mail_deposit_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_gift_detail`
--
ALTER TABLE `mail_gift_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_interim_detail`
--
ALTER TABLE `mail_interim_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_payment_detail`
--
ALTER TABLE `mail_payment_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_prediction_open_detail`
--
ALTER TABLE `mail_prediction_open_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_prediction_result_detail`
--
ALTER TABLE `mail_prediction_result_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_register_detail`
--
ALTER TABLE `mail_register_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `mail_replace`
--
ALTER TABLE `mail_replace`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `mail_schedule`
--
ALTER TABLE `mail_schedule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `mail_schedule_detail`
--
ALTER TABLE `mail_schedule_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_schedule_done`
--
ALTER TABLE `mail_schedule_done`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mail_template`
--
ALTER TABLE `mail_template`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `media_access`
--
ALTER TABLE `media_access`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `page`
--
ALTER TABLE `page`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `point`
--
ALTER TABLE `point`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `prediction`
--
ALTER TABLE `prediction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `prediction_result`
--
ALTER TABLE `prediction_result`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `prediction_type`
--
ALTER TABLE `prediction_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `result`
--
ALTER TABLE `result`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `transaction_deposit`
--
ALTER TABLE `transaction_deposit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `transaction_gift`
--
ALTER TABLE `transaction_gift`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `transaction_payment`
--
ALTER TABLE `transaction_payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `user_access_blog`
--
ALTER TABLE `user_access_blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user_access_prediction`
--
ALTER TABLE `user_access_prediction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `user_daily_access_history`
--
ALTER TABLE `user_daily_access_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `user_daily_login_history`
--
ALTER TABLE `user_daily_login_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `user_stage`
--
ALTER TABLE `user_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
