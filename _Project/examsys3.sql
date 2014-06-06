-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2014 at 03:02 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `examsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`admin_id`, `id`, `name`, `lname`, `email`, `pic`) VALUES
(1, 1, 'สตีฟ', 'แอปเปิล', NULL, NULL),
(2, 5, 'qqq', 'eeee', NULL, NULL),
(3, 6, 'นายโปรแกรม', 'บัคน้อย', NULL, NULL),
(4, 7, 'amino', 'okok', NULL, NULL),
(5, 23, 'วรพงษ์', 'คงประเสริฐ', 'penguin_poat@hotmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Branch`
--

CREATE TABLE IF NOT EXISTS `Branch` (
  `branch_id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `fac_id` int(4) NOT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) DEFAULT NULL,
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('b7f09795e157bc1d4d6f45690a5289d9', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App', 1402050831, 'a:8:{s:9:"user_data";s:0:"";s:8:"username";s:5:"admin";s:8:"fullname";s:34:"สตีฟ แอปเปิล";s:5:"fname";s:12:"สตีฟ";s:5:"lname";s:21:"แอปเปิล";s:4:"role";s:5:"admin";s:6:"logged";b:1;s:16:"flash:new:noAnim";b:1;}'),
('c9197d9b0d1a7f572810505a189fe664', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1402056411, 'a:7:{s:9:"user_data";s:0:"";s:8:"username";s:4:"post";s:8:"fullname";s:49:"วรพงษ์ คงประเสริฐ";s:5:"fname";s:18:"วรพงษ์";s:5:"lname";s:30:"คงประเสริฐ";s:4:"role";s:5:"admin";s:6:"logged";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE IF NOT EXISTS `Course` (
  `course_id` varchar(10) NOT NULL,
  `year` varchar(4) NOT NULL DEFAULT '',
  `tea_id` int(10) DEFAULT NULL,
  `pwd` varchar(20) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `shortname` varchar(15) NOT NULL,
  `description` text,
  `startdate` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`course_id`,`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`course_id`, `year`, `tea_id`, `pwd`, `name`, `shortname`, `description`, `startdate`, `visible`, `enabled`) VALUES
('291311', '2014', NULL, NULL, 'Object-Oriented Programming', 'OOP', 'ความเป็นมาของการเขียนโปรแกรมเชิงวัตถุ แนวคิดโปรแกรมเชิงวัตถุ คลาส ออปเจก และองค์ประกอบต่างๆ ของออปเจก วงจรชีวิตวัตถุ การสืบทอดคุณสมบัติ โพลีมอร์ฟิซึม การนำคลาสมาใช้งาน เหตุการณ์ต่างๆ ที่ใช้กับวัตถุ การใช้เอพีไอ การเชื่อมต่อฐานข้อมูล การจัดการความผิดปกติโดย Exception ภาคปฏิบัติใช้โปรแกรมเครื่องมือช่วยพัฒนาเพื่อทดลองเขียนโปรแกรมเชิงวัตถุประยุกต์ใช้ในงานธุรกิจ ด้วยภาษาที่กำหนด', '2014-04-26', 1, 1),
('291436', '2014', NULL, '12345', 'IT Consultancy Method', 'ITCM', 'เครือข่ายทางธุรกิจขนาดเล็ก รวมถึงเครือข่ายไร้สาย การติดตั้งเราเตอร์และไฟร์วอล การสร้างเว็บไซต์ พาณิชย์อิเล็กทรอนิกส์ ความปลอดภัยของข้อมูล รวมถึงวิธีการสำรองข้อมูลและการกู้คืนข้อมูลที่เสียหาย ซอฟต์แวร์ต่างๆ เช่น โปรแกรมฐานข้อมูลและโปรแกรมการจัดการความสัมพันธ์กับลูกค้า เทคนิคทางธุรกิจที่เกี่ยวข้องกับการให้คำปรึกษาทางด้านธุรกิจ และลูกค้าสัมพันธ์ รวมไปถึง กฎหมายและหลักจริยธรรมที่เกี่ยวข้องกับการให้คำปรึกษาด้านระบบสารสนเทศ', '2014-05-04', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Faculty`
--

CREATE TABLE IF NOT EXISTS `Faculty` (
  `fac_id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` text,
  PRIMARY KEY (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `stu_id` varchar(10) NOT NULL,
  `id` int(8) NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `birth` date DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `idcard` varchar(13) DEFAULT NULL,
  `year` int(4) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `branch_id` varchar(50) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`stu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`stu_id`, `id`, `title`, `name`, `lname`, `birth`, `gender`, `idcard`, `year`, `fac_id`, `branch_id`, `email`, `pic`) VALUES
('54310104', 2, '', 'นรภัทร', 'นิ่มมณี', '1992-09-14', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', NULL, NULL),
('54310409', 9, '', 'วรพงษ์', 'คงประเสริฐ', '1992-07-27', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'penguin_poat@hotmail.com', NULL),
('54310854', 9, '', 'ธนภาค', 'จิระวิทิตชัย', '1992-10-18', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'thanapak_09@hotmail.com', NULL),
('57700188', 10, 'รับตรง', 'ธรลักษณ์', 'แก้วดี', NULL, 'male', '5770000000188', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700189', 11, 'รับตรง', 'นามเหมือน', 'แก้วทอง', NULL, 'male', '5770000000189', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700190', 12, 'รับตรง', 'นามไม่เหมือน', 'แก้วเงิน', NULL, 'male', '5770000000190', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700191', 13, 'รับตรง', 'สายชลดี', 'ภาพุ', NULL, 'male', '5770000000191', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700192', 14, 'รับตรง', 'พา', 'หากเหมือน', NULL, 'male', '5770000000192', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700193', 15, 'รับตรง', 'ขำ', 'ไม่เหมือน', NULL, 'male', '5770000000193', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700194', 16, 'รับตรง', 'ชายกลาง', 'ลาภผล', NULL, 'male', '5770000000194', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700195', 17, 'รับตรง', 'หญิง', 'ประสบ', NULL, 'male', '5770000000195', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700196', 18, 'รับตรง', 'มีมาก', 'เชิงชาย', NULL, 'male', '5770000000196', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700197', 19, 'รับตรง', 'ขม', 'สามผล', NULL, 'male', '5770000000197', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700198', 20, 'รับตรง', 'วลัยพร', 'นามมี', NULL, 'male', '5770000000198', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700199', 21, 'รับตรง', 'วาสนา', 'สวาดี', NULL, 'male', '5770000000199', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700200', 22, 'รับตรง', 'มั่นคง', 'กิมจอง', NULL, 'male', '5770000000200', 0, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Student_Enroll_Detail`
--

CREATE TABLE IF NOT EXISTS `Student_Enroll_Detail` (
  `stu_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  PRIMARY KEY (`stu_id`,`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Student_Enroll_Detail`
--

INSERT INTO `Student_Enroll_Detail` (`stu_id`, `course_id`) VALUES
('54310104', '291311');

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE IF NOT EXISTS `Teachers` (
  `tea_id` int(10) NOT NULL AUTO_INCREMENT,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`tea_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`tea_id`, `id`, `name`, `lname`, `fac_id`, `email`, `pic`) VALUES
(1, 4, 'ดร.สมบัติ', 'ฝอยทอง', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL),
(2, 3, 'อ.อุไรวรรณ', 'บัวตูม', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL),
(3, 8, 'อ.มหาลัย', 'ดีสุดล่า', 'วิทยาศาสตร์และศิลปศาสตร์', '', NULL),
(4, 9, 'อ.อรวรรณ', 'จิตะกาญจน์', 'วิทยาศาสตร์และศิลปศาสตร์', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Teacher_Course_Detail`
--

CREATE TABLE IF NOT EXISTS `Teacher_Course_Detail` (
  `tea_id` int(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  PRIMARY KEY (`tea_id`,`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Teacher_Course_Detail`
--

INSERT INTO `Teacher_Course_Detail` (`tea_id`, `course_id`) VALUES
(1, '291311');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=24 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(2, '54310104', '827ccb0eea8a706c4c34a16891f84e7b', 'student', 'active'),
(3, 'uraiwan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(4, 'sombut', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(5, 'test2', '098f6bcd4621d373cade4e832627b4f6', 'admin', 'active'),
(6, 'admin2', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(7, 'admin3', 'b73fdaa1fb7669da760b49600c45d9be', 'admin', 'active'),
(8, 'teacher', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(9, 'orawan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(10, '57700188', '65350653c9baf66a82bd3eff3719e59c', 'student', 'active'),
(11, '57700189', '0d4a6549dcb0ee35ecb006d7f88a8b2d', 'student', 'active'),
(12, '57700190', '950e657b21be908c22477b92a55b362d', 'student', 'active'),
(13, '57700191', '281c939e1a1effb80020d274e3081c5c', 'student', 'active'),
(14, '57700192', 'ca2ce83788f3b73b90438e3de06897a2', 'student', 'active'),
(15, '57700193', '7a727f46360a98be4658156ace52d893', 'student', 'active'),
(16, '57700194', '3d9386dd7bc38e0420fd406f260e62aa', 'student', 'active'),
(17, '57700195', 'e26414761bb8fc0b74b0c1c423bcfd87', 'student', 'active'),
(18, '57700196', '6bf3de8a868cddc20513157179248624', 'student', 'active'),
(19, '57700197', 'add7099ea46b393dbcea34a0d59b3826', 'student', 'active'),
(20, '57700198', 'e597b2bc6e556a570aa57dc8c9504341', 'student', 'active'),
(21, '57700199', 'b2e894fca115093e29131568c984a574', 'student', 'active'),
(22, '57700200', '9a16c63a88acdda4057bd1516ace2d4f', 'student', 'active'),
(23, 'post', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
