-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 11, 2014 at 10:30 PM
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
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `id`, `name`, `lname`, `email`, `pic`) VALUES
(1, 1, 'สตีฟ', 'แอปเปิล', NULL, NULL),
(2, 5, 'qqq', 'eeee', NULL, NULL),
(3, 6, 'นายโปรแกรม', 'บัคน้อย', NULL, NULL),
(4, 7, 'amino', 'okok', NULL, NULL);

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
('18e95f21ed4996f9154126251f52a10a', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App', 1402517910, ''),
('740cfaf8795458b90d627f502973bf15', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App', 1402491231, 'a:8:{s:9:"user_data";s:0:"";s:8:"username";s:5:"admin";s:8:"fullname";s:34:"สตีฟ แอปเปิล";s:5:"fname";s:12:"สตีฟ";s:5:"lname";s:21:"แอปเปิล";s:4:"role";s:5:"admin";s:6:"logged";b:1;s:16:"flash:new:noAnim";b:1;}'),
('f83163a0d093d0f40bd582f073756b94', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) App', 1402418421, '');

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE IF NOT EXISTS `Course` (
  `course_id` varchar(10) NOT NULL,
  `year` varchar(4) NOT NULL DEFAULT '',
  `tea_id` int(10) DEFAULT NULL,
  `pwd` varchar(20) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `subject_id` int(5) NOT NULL,
  PRIMARY KEY (`course_id`,`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`course_id`, `year`, `tea_id`, `pwd`, `startdate`, `visible`, `enabled`, `subject_id`) VALUES
('291311', '2014', NULL, '12345', '2014-04-26', 1, 1, 1),
('291436', '2014', NULL, '12345', '2014-05-04', 1, 1, 2);

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
('54310104', 2, 'นาย', 'นรภัทร', 'นิ่มมณี', '1992-09-14', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', NULL, NULL),
('54310409', 9, 'นาย', 'วรพงษ์', 'คงประเสริฐ', '1992-07-27', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'penguin_poat@hotmail.com', NULL),
('54310854', 9, 'นาย', 'ธนภาค', 'จิระวิทิตชัย', '1992-10-18', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'thanapak_09@hotmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Student_Enroll`
--

CREATE TABLE IF NOT EXISTS `Student_Enroll` (
  `stu_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  PRIMARY KEY (`stu_id`,`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Student_Enroll`
--

INSERT INTO `Student_Enroll` (`stu_id`, `course_id`) VALUES
('54310104', '291311');

-- --------------------------------------------------------

--
-- Table structure for table `Subjects`
--

CREATE TABLE IF NOT EXISTS `Subjects` (
  `subject_id` int(5) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `shortname` varchar(15) NOT NULL,
  `description` text,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`subject_id`, `code`, `name`, `shortname`, `description`) VALUES
(1, '291311', 'IT Consultancy Method', 'ITCM', 'เครือข่ายทางธุรกิจขนาดเล็ก รวมถึงเครือข่ายไร้สาย การติดตั้งเราเตอร์และไฟร์วอล การสร้างเว็บไซต์ พาณิชย์อิเล็กทรอนิกส์ ความปลอดภัยของข้อมูล รวมถึงวิธีการสำรองข้อมูลและการกู้คืนข้อมูลที่เสียหาย ซอฟต์แวร์ต่างๆ เช่น โปรแกรมฐานข้อมูลและโปรแกรมการจัดการความสัมพันธ์กับลูกค้า เทคนิคทางธุรกิจที่เกี่ยวข้องกับการให้คำปรึกษาทางด้านธุรกิจ และลูกค้าสัมพันธ์ รวมไปถึง กฎหมายและหลักจริยธรรมที่เกี่ยวข้องกับการให้คำปรึกษาด้านระบบสารสนเทศ'),
(2, '291436', 'Object-Oriented Programming', 'OOP', 'ความเป็นมาของการเขียนโปรแกรมเชิงวัตถุ แนวคิดโปรแกรมเชิงวัตถุ คลาส ออปเจก และองค์ประกอบต่างๆ ของออปเจก วงจรชีวิตวัตถุ การสืบทอดคุณสมบัติ โพลีมอร์ฟิซึม การนำคลาสมาใช้งาน เหตุการณ์ต่างๆ ที่ใช้กับวัตถุ การใช้เอพีไอ การเชื่อมต่อฐานข้อมูล การจัดการความผิดปกติโดย Exception ภาคปฏิบัติใช้โปรแกรมเครื่องมือช่วยพัฒนาเพื่อทดลองเขียนโปรแกรมเชิงวัตถุประยุกต์ใช้ในงานธุรกิจ ด้วยภาษาที่กำหนด'),
(3, '291472', 'Special Project 1', 'SP1', 'โครงงานปฏิบัติเพื่อการวิเคราะห์และออกแบบระบบงานคอมพิวเตอร์เพื่อช่วยแก้ปัญหาทางธุรกิจต่างๆ ที่น่าสนใจ และได้รับความเห็นชอบของอาจารย์ที่ปรึกษา โดยมุ่งเน้นให้นักศึกษาสามารถวิเคราะห์ปัญหาเพื่อจัดทำเป็นข้อกำหนดรายละเอียดซอฟต์แวร์ที่สามารถนำไปสู่การสร้างซอฟต์แวร์ทางธุรกิจได้'),
(4, '291303', 'System Analysis and Design', 'SAaD', 'แนวคิดระบบสารสนเทศและประเภทของระบบสารสนเทศในองค์การธุรกิจ วงจรการพัฒนาระบบ ระเบียบวิธีการ เครื่องมือในการวิเคราะห์ระบบ ผังงานระบบ ตารางการตัดสินใจ การกำหนดปัญหาและการศึกษาความเป็นไปได้ของระบบ การวิเคราะห์ความคุ้มค่าในการลงทุน การออกแบบข้อมูลนำเข้า การออกแบบการแสดงผลลัพธ์ของระบบ การออกแบบฐานข้อมูล การออกแบบกระบวนการประมวลผลระบบ และการจัดทำเอกสารคู่มือระบบ');

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
(3, 8, 'อ.มหาลัย', 'ดีสุดล่า', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL),
(4, 9, 'อ.อรวรรณ', 'จิตะกาญจน์', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL);

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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `status`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(2, '54310104', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active'),
(3, 'uraiwan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(4, 'sombut', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(5, 'test2', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(6, 'admin2', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(7, 'admin3', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'active'),
(8, 'teacher', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active'),
(9, 'orawan', '81dc9bdb52d04dc20036dbd8313ed055', 'teacher', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
