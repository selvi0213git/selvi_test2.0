-- phpMyAdmin SQL Dump
-- version 4.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 17-08-25 10:27
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
-- 테이블 구조 `wp_event_delivery`
--

CREATE TABLE IF NOT EXISTS `wp_event_delivery` (
  `delivery_id` bigint(20) NOT NULL,
  `enter_id` bigint(20) NOT NULL,
  `delivery_name` varchar(250) NOT NULL,
  `delivery_phone` varchar(13) NOT NULL,
  `delivery_zip` varchar(10) NOT NULL,
  `delivery_addr1` varchar(250) NOT NULL,
  `delivery_addr2` varchar(250) NOT NULL,
  `basic_YN` varchar(1) NOT NULL DEFAULT 'Y',
  `delivery_etc` text NOT NULL,
  `rgst_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updt_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wp_event_delivery`
--
ALTER TABLE `wp_event_delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `enter_id` (`enter_id`) USING BTREE;

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wp_event_delivery`
--
ALTER TABLE `wp_event_delivery`
  MODIFY `delivery_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=110;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
