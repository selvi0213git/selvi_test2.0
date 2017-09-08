-- phpMyAdmin SQL Dump
-- version 4.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 17-08-25 10:42
-- 서버 버전: 10.1.13-MariaDB
-- PHP 버전: 7.0.0p1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 데이터베이스: `selvitest`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `wp_event_info`
--

CREATE TABLE IF NOT EXISTS `wp_event_info` (
  `event_id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `event_all_prize` bigint(20) NOT NULL DEFAULT '0',
  `event_prize` bigint(20) NOT NULL DEFAULT '0',
  `event_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_end` datetime NOT NULL,
  `event_enter` bigint(20) NOT NULL DEFAULT '0',
  `event_type` int(5) NOT NULL DEFAULT '0',
  `rgst_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updt_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `wp_event_info`
--

INSERT INTO `wp_event_info` (`event_id`, `post_id`, `event_all_prize`, `event_prize`, `event_start`, `event_end`, `event_enter`, `event_type`, `rgst_date`, `updt_date`) VALUES
(8, 716, 20, 9, '2017-08-20 14:00:00', '2017-08-30 11:27:29', 21, 0, '2017-06-23 03:09:43', '2017-08-24 02:06:40'),
(6, 1063, 500, 400, '2017-08-20 16:03:00', '2017-08-30 03:02:00', 5, 0, '2017-06-12 05:52:24', '2017-08-21 06:03:04'),
(7, 711, 400, 375, '2017-08-18 14:02:00', '2017-08-31 03:02:00', 115, 0, '2017-07-07 05:55:10', '2017-08-24 08:18:19'),
(10, 706, 100, 8, '2017-08-18 12:00:00', '2017-08-31 12:00:01', 19, 0, '2017-07-05 03:58:41', '2017-08-24 08:20:48'),
(11, 688, 1000, 444, '2017-08-17 12:00:00', '2017-08-29 11:00:00', 26, 0, '2017-07-07 07:05:32', '2017-08-24 00:54:41'),
(12, 627, 300, 3, '2017-08-22 04:03:00', '2017-08-29 04:04:00', 1501, 0, '2017-07-12 00:31:35', '2017-08-23 00:03:49'),
(13, 1435, 105, 44, '2017-08-19 01:14:00', '2017-09-01 21:07:00', 166, 0, '2017-08-04 04:57:25', '2017-08-24 03:48:20'),
(14, 1505, 1000, 80, '2017-08-24 09:01:00', '2017-09-01 16:03:00', 1568, 0, '2017-08-17 00:40:47', '2017-08-24 05:43:13'),
(15, 1511, 100, 100, '2017-08-24 09:00:00', '2017-08-30 15:00:00', 112, 0, '2017-08-18 04:38:38', '2017-08-24 07:24:12'),
(16, 640, 100, 50, '2017-08-22 03:05:00', '2017-08-31 03:03:00', 102, 0, '2017-08-22 05:39:36', '2017-08-24 08:17:17'),
(17, 665, 100, 50, '2017-08-23 06:10:00', '2017-09-30 18:00:00', 80, 0, '2017-08-23 02:03:49', '2017-08-23 02:03:49');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wp_event_info`
--
ALTER TABLE `wp_event_info`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wp_event_info`
--
ALTER TABLE `wp_event_info`
  MODIFY `event_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
