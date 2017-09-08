-- phpMyAdmin SQL Dump
-- version 4.4.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 17-08-25 10:38
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
-- 테이블 구조 `wp_users`
--

CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint(20) unsigned NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_realname` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `user_phone` varchar(13) CHARACTER SET utf8 DEFAULT NULL,
  `user_zip` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `user_addr1` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `user_addr2` varchar(250) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 테이블의 덤프 데이터 `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`, `user_realname`, `user_phone`, `user_zip`, `user_addr1`, `user_addr2`) VALUES
(1, 'selvitest', '$P$ByyHFHgqG6mCZEblGmOIB/F2xF6oU/0', 'selvitest', 'eley@selvi.co.kr', 'eley@selvi.co.kr', '2017-02-01 02:56:47', '1495430486:$P$BikZ6377ZId0.Lr6fNiJ6WP7aH/eUQ1', 1, '셀비', '셀비', '070-4191-3544', '06621', '서울 서초구 강남대로 359 (서초동, 대우도씨에빛2)', '1408호'),
(7, 'jihyeon34@naver.com', '$P$BuNUt7LEi7DmCXkChYWfzCS61vu39R/', 'jihyeon34naver-com', '', 'http://blog.naver.com/jihyeon34', '2017-06-01 13:38:19', '', 1, '투엘리', '', NULL, NULL, NULL, NULL),
(9, 'kakao_59312647cbd27', '$P$BE9qx17PFA0p/OBt7ybHi4trYwxDBO1', 'kakao_59312647cbd27', '', '', '2017-06-02 08:48:07', '', 0, '지혀니', '', NULL, NULL, NULL, NULL),
(10, 'jihyeon34@gmail.com', '$P$BaPiJKCqVVhT05azhuxesENuUjl73c/', 'jihyeon34gmail-com', 'jihyeon34@gmail.com', '', '2017-06-16 06:25:10', '', 0, 'jihyeon34@gmail.com', '', NULL, NULL, NULL, NULL),
(11, 'jihyeon34@bridge4biz.com', '$P$BHEfDm337SYob5VQ5Gg/LexTNgwri3.', 'jihyeon34bridge4biz-com', 'jihyeon34@bridge4biz.com', '', '2017-06-16 08:42:57', '', 0, 'jihyeon34@bridge4biz.com', '', NULL, NULL, NULL, NULL),
(12, 'kisu9838@naver.com', '$P$BIqPRw.ZAYdcauO1flXOQXjGMni3OB/', 'kisu9838naver-com', 'kisu9838@naver.com', 'http://blog.naver.com/kisu9838', '2017-06-19 15:40:55', '', 0, 'kisu****', '', NULL, NULL, NULL, NULL),
(13, 'google_5947f37f9aec1', '$P$BlVwvslbk00JC1CwQso/fLs0LaoweE.', 'google_5947f37f9aec1', 'jihyeon34@naver.com', 'https://plus.google.com/109842014658762640453', '2017-06-19 15:53:35', '', 0, '서지현', '', NULL, NULL, NULL, NULL),
(14, 'facebook_5948955453cc1', '$P$BYEXW5uzmWUxQ38dEO6hgY0nNaajL60', 'facebook_5948955453cc1', '', 'http://www.facebook.com/110531972894720', '2017-06-20 03:24:04', '', 0, '에비츄당😵ㅎㅎ', '에비츄', '010-1234-5678', '06621', '서울 서초구 강남대로 359 (서초동, 대우도씨에빛2)', '1408호 셀비'),
(15, 'kisu9800@hanmail.net', '$P$B/RSg1IpT/bGX0IETsdsLEPjgAZMwc1', 'kisu9800hanmail-net', 'kisu9800@hanmail.net', 'http://www.facebook.com/1573514959386326', '2017-06-20 16:38:55', '', 0, 'Gisu Hwang', '키슈키슈', '010-1234-1234', '08826', '서울 관악구 신림동 산 56-1', '1'),
(16, 'lee@selvi.co.kr', '$P$BuW4/s/2WOgv6EJOeyNWTAeFgaoMb71', 'leeselvi-co-kr', 'lee@selvi.co.kr', 'http://www.facebook.com/1548773711833834', '2017-06-21 00:55:35', '', 0, '이상교', '이상교', '010-2377-3544', '06083', '서울 강남구 영동대로112길 24 (삼성동, 동구싼타빌)', '301호01'),
(17, 'hjpstone@daum.net', '$P$Belqd5a9/ZdQKrfvljfLmm1R/.Quh91', 'hjpstonedaum-net', 'hjpstone@daum.net', 'http://www.facebook.com/142941356264064', '2017-06-21 00:55:55', '', 0, '박현정', '박성우', '010-2865-1365', '06733', '서울 서초구 서운로 11 (서초동, 서초대우디오빌)', '2101호'),
(18, 'sjwon30003@naver.com', '$P$B0EPSTozqHq7AXzQ/2EFWIZRg/4XO.1', 'sjwon30003naver-com', 'sjwon30003@naver.com', 'http://blog.naver.com/sjwon30003', '2017-07-03 05:38:05', '', 0, '1553015서경호', NULL, NULL, NULL, NULL, NULL),
(19, 'facebook_595dc8ebd9fac', '$P$BxSNvrG4OxXs/hIY33hkWXQC/8xJTT0', 'facebook_595dc8ebd9fac', '', 'http://www.facebook.com/322737031486956', '2017-07-06 05:21:47', '', 0, '서경호', NULL, NULL, NULL, NULL, NULL),
(21, 'artshin1980@hanmail.net', '$P$BQWmvCCczB1lomdgwFmMS4vZJvqSYc0', 'artshin1980hanmail-net', 'artshin1980@hanmail.net', 'http://www.facebook.com/1042964935841008', '2017-07-19 02:57:05', '', 0, '신현숙', NULL, NULL, NULL, NULL, NULL),
(22, 'admin_jee', '$P$BJfl1XImW1ou8setaCWT2PF2DicPws.', '', '', '', '0000-00-00 00:00:00', '', 1, '지실장님 :)', NULL, NULL, NULL, NULL, NULL),
(23, 'createjyo@gmail.com', '$P$BpezLKaYDMef74eEhhYf6Tj3WUuvRb1', 'createjyogmail-com', 'createjyo@gmail.com', 'http://www.facebook.com/104660400250264', '2017-08-08 06:46:29', '', 0, 'Yeonok Ji', NULL, NULL, NULL, NULL, NULL),
(24, 'fairpl2014@naver.com', '$P$Bs6Heu5Plyu4m8YAyU3.LVbNY/pgka/', 'fairpl2014naver-com', 'fairpl2014@naver.com', 'http://www.facebook.com/1946799338865747', '2017-08-21 10:20:46', '', 0, 'Noritoapp Fairpl', NULL, NULL, NULL, NULL, NULL),
(25, 'facebook_599c0a64ef3cf', '$P$BTxeanTJKht1XTJfzbMOGrKBhHeJCn.', 'facebook_599c0a64ef3cf', '', 'http://www.facebook.com/1930510903873777', '2017-08-22 10:41:40', '', 0, '김기원', NULL, NULL, NULL, NULL, NULL),
(26, 'clixtoymcho@naver.com', '$P$B8cehf.sIhzb2W2vR5mQZoJIuAuzOv.', 'clixtoymchonaver-com', 'clixtoymcho@naver.com', 'http://www.facebook.com/10214505824422037', '2017-08-24 03:28:23', '', 0, 'Zenice Cho', NULL, NULL, NULL, NULL, NULL),
(27, 'lee', '$P$BYD6DWHpWyv4n7V974OHP1NmDYkZ.o.', '셀비', 'lee@selvi.co.kr', 'lee@selvi.co.kr', '0000-00-00 00:00:00', '', 1, '셀비', '이상교', '010-2377-3544', '06621', '서울 서초구 강남대로 359 (서초동, 대우도씨에빛2)', '1408호'),
(28, 'stone', '$P$BORqRCSjMxQkgde6Vxs0m3SIKzjbaM1', '셀비', 'hjpstone@selvi.co.kr', 'hjpstone@selvi.co.kr', '0000-00-00 00:00:00', '', 1, '셀비', '박현정', '010-2865-1365', '06621', '서울 서초구 강남대로 359 (서초동, 대우도씨에빛2)', '1408호'),
(29, 'facebook_599e73d35c5f6', '$P$BF9dnvLOis51TErwJf3VtoBQAz7Q340', 'facebook_599e73d35c5f6', '', 'http://www.facebook.com/1313897652064975', '2017-08-24 06:36:03', '', 0, '서지현', NULL, NULL, NULL, NULL, NULL),
(30, 'eley', '$P$BHfc.iSUcDKZQDAwH3jpSqsHHTKoCb0', '셀비', 'eley@selvi.co.kr', 'eley@selvi.co.kr', '0000-00-00 00:00:00', '', 1, '셀비', '서지현', '010-6412-9680', '06621', '서울 서초구 강남대로 359 (서초동, 대우도씨에빛2)', '1408호');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `user_login` (`user_login`) USING BTREE,
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
