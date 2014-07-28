-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 28, 2014 at 03:14 PM
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
(1, 1, 'สตีฟ', 'แอปเปิล', 'steve@apple.com', NULL),
(2, 5, 'นายโค้ด', 'พีเอชพี', 'code-php@hotmail.com', NULL),
(3, 6, 'นายโปรแกรม', 'บัคน้อย', 'program_bug@oxs.com', NULL),
(4, 7, 'amino', 'okok', 'xxx@hotmail.com', NULL);

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
('7b7ec98d60a91f5391ca24c145a74969', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) App', 1406551059, 'a:7:{s:9:"user_data";s:0:"";s:8:"username";s:5:"admin";s:8:"fullname";s:34:"สตีฟ แอปเปิล";s:5:"fname";s:12:"สตีฟ";s:5:"lname";s:21:"แอปเปิล";s:4:"role";s:5:"admin";s:6:"logged";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
  `course_id` int(4) NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL DEFAULT '',
  `pwd` varchar(20) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(20) NOT NULL,
  `subject_id` int(5) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`course_id`, `year`, `pwd`, `startdate`, `visible`, `status`, `subject_id`) VALUES
(1, '2014', NULL, '2014-07-22', 1, 'active', 1),
(2, '2014', '12345', '2014-05-04', 1, 'active', 2),
(3, '2014', NULL, '2014-07-24', 1, 'inactive', 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `courseslist_view`
--
CREATE TABLE IF NOT EXISTS `courseslist_view` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`startdate` date
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
,`visible` tinyint(1)
,`status` varchar(20)
);
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
-- Table structure for table `log_usage`
--

CREATE TABLE IF NOT EXISTS `log_usage` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(6) NOT NULL,
  `action` text NOT NULL,
  `ipaddress` varchar(128) NOT NULL,
  `iphostname` varchar(128) NOT NULL,
  `iplocal` varchar(128) NOT NULL,
  `useragent` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('0', 2, 'นาย', 'นรภัทร', 'นิ่มมณี', '1992-09-14', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'charge_n@hotmail.com', NULL),
('54310409', 9, 'นาย', 'วรพงษ์', 'คงประเสริฐ', '1992-07-27', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'penguin_poat@hotmail.com', NULL),
('54310854', 9, 'นาย', 'ธนภาค', 'จิระวิทิตชัย', '1992-10-18', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'thanapak_09@hotmail.com', NULL),
('57700188', 10, 'นาย', 'ธรลักษณ์', 'แก้วดี', NULL, 'male', '5770000000188', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700189', 11, 'นาย', 'นามเหมือน', 'แก้วทอง', NULL, 'male', '5770000000189', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700190', 12, 'นาย', 'นามไม่เหมือน', 'แก้วเงิน', NULL, 'male', '5770000000190', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700191', 13, 'นาย', 'สายชลดี', 'ภาพุ', NULL, 'male', '5770000000191', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700192', 14, 'นางสาว', 'พา', 'หากเหมือน', NULL, 'female', '5770000000192', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700193', 15, 'นาย', 'ขำ', 'ไม่เหมือน', NULL, 'male', '5770000000193', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700194', 16, 'นาย', 'ชายกลาง', 'ลาภผล', NULL, 'male', '5770000000194', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700195', 17, 'นางสาว', 'หญิง', 'ประสบ', NULL, 'female', '5770000000195', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700196', 18, 'นาย', 'มีมาก', 'เชิงชาย', NULL, 'male', '5770000000196', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700197', 19, 'นาย', 'ขม', 'สามผล', NULL, 'male', '5770000000197', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700198', 20, 'นางสาว', 'วลัยพร', 'นามมี', NULL, 'female', '5770000000198', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700199', 21, 'นางสาว', 'วาสนา', 'สวาดี', NULL, 'female', '5770000000199', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700200', 22, 'นาย', 'มั่นคง', 'กิมจอง', NULL, 'male', '5770000000200', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('58700101', 23, 'นาย', 'สมพงษ์', 'อยู่รอด', NULL, 'male', '1190704545660', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700105', 24, 'นาย', 'องอาจ', 'มานะศิล', NULL, 'male', '1154369903444', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700112', 25, 'นาย', 'พงศกร', 'งามเหลือ', NULL, 'male', '1145777764432', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700115', 26, 'นาย', 'กิตติชนม์', 'ไพศาลพานิช', NULL, 'male', '1188455446477', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700120', 27, 'นางสาว', 'ศศิกาญ', 'ไพโรจน์กิจ', NULL, 'female', '1178765643090', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700121', 28, 'นาย', 'นพรุจ', 'สานแก้วค้า', NULL, 'male', '1199966744325', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700127', 29, 'นาย', 'กิตตินัน', 'มากล้ำ', NULL, 'male', '1178890000756', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700133', 30, 'นางสาว', 'บวรลักษณ์', 'จิตรงาม', NULL, 'female', '1111445470034', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('58700135', 31, 'นาย', 'ทวี', 'หอมหวน', NULL, 'male', '1163222789007', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('58700140', 32, 'นาย', 'ตะวัน', 'พานทอง', NULL, 'male', '1154367753409', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'เทคโนโลยีการเกษตร', NULL, NULL),
('58700141', 33, 'นางสาว', 'พรกัญญา', 'กิจมานะ', NULL, 'female', '1145556094556', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'เทคโนโลยีการเกษตร', NULL, NULL),
('58700156', 34, 'นางสาว', 'วาสนา', 'สวาดี', NULL, 'female', '1115570934226', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('58700157', 35, 'นาย', 'ติณนภพ', 'ณ อยุธา', NULL, 'male', '1110009226543', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL);

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
  `status` varchar(20) DEFAULT 'active',
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`subject_id`, `code`, `name`, `shortname`, `description`, `status`) VALUES
(1, '291311', 'IT Consultancy Method', 'ITCM', 'เครือข่ายทางธุรกิจขนาดเล็ก รวมถึงเครือข่ายไร้สาย การติดตั้งเราเตอร์และไฟร์วอล การสร้างเว็บไซต์ พาณิชย์อิเล็กทรอนิกส์ ความปลอดภัยของข้อมูล รวมถึงวิธีการสำรองข้อมูลและการกู้คืนข้อมูลที่เสียหาย ซอฟต์แวร์ต่างๆ เช่น โปรแกรมฐานข้อมูลและโปรแกรมการจัดการความสัมพันธ์กับลูกค้า เทคนิคทางธุรกิจที่เกี่ยวข้องกับการให้คำปรึกษาทางด้านธุรกิจ และลูกค้าสัมพันธ์ รวมไปถึง กฎหมายและหลักจริยธรรมที่เกี่ยวข้องกับการให้คำปรึกษาด้านระบบสารสนเทศ', 'active'),
(2, '291436', 'Object-Oriented Programming', 'OOP', 'ความเป็นมาของการเขียนโปรแกรมเชิงวัตถุ แนวคิดโปรแกรมเชิงวัตถุ คลาส ออปเจก และองค์ประกอบต่างๆ ของออปเจก วงจรชีวิตวัตถุ การสืบทอดคุณสมบัติ โพลีมอร์ฟิซึม การนำคลาสมาใช้งาน เหตุการณ์ต่างๆ ที่ใช้กับวัตถุ การใช้เอพีไอ การเชื่อมต่อฐานข้อมูล การจัดการความผิดปกติโดย Exception ภาคปฏิบัติใช้โปรแกรมเครื่องมือช่วยพัฒนาเพื่อทดลองเขียนโปรแกรมเชิงวัตถุประยุกต์ใช้ในงานธุรกิจ ด้วยภาษาที่กำหนด', 'active'),
(3, '291472', 'Special Project 1', 'SP1', 'โครงงานปฏิบัติเพื่อการวิเคราะห์และออกแบบระบบงานคอมพิวเตอร์เพื่อช่วยแก้ปัญหาทางธุรกิจต่างๆ ที่น่าสนใจ และได้รับความเห็นชอบของอาจารย์ที่ปรึกษา โดยมุ่งเน้นให้นักศึกษาสามารถวิเคราะห์ปัญหาเพื่อจัดทำเป็นข้อกำหนดรายละเอียดซอฟต์แวร์ที่สามารถนำไปสู่การสร้างซอฟต์แวร์ทางธุรกิจได้', 'active'),
(4, '291303', 'System Analysis and Design', 'SAD', 'แนวคิดระบบสารสนเทศและประเภทของระบบสารสนเทศในองค์การธุรกิจ วงจรการพัฒนาระบบ ระเบียบวิธีการ เครื่องมือในการวิเคราะห์ระบบ ผังงานระบบ ตารางการตัดสินใจ การกำหนดปัญหาและการศึกษาความเป็นไปได้ของระบบ การวิเคราะห์ความคุ้มค่าในการลงทุน การออกแบบข้อมูลนำเข้า การออกแบบการแสดงผลลัพธ์ของระบบ การออกแบบฐานข้อมูล การออกแบบกระบวนการประมวลผลระบบ และการจัดทำเอกสารคู่มือระบบ', 'active'),
(5, '1234', '1234n', 'ssss', '<h1><span style="background-color:rgb(255,255,0);"><strong>คำอธิบายวิชา ของ บลาๆๆๆ</strong></span></h1>\n\n<p><img alt="User Image" src="http://localhost/oxproject/img/avatar3.png" style="height:45px;width:45px;" /></p>\n\n<p>รูปภาพ</p>\n', 'active');

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
(1, 4, 'ดร.สมบัติ', 'ฝอยทอง', 'วิทยาศาสตร์และศิลปศาสตร์', 'sombut@buu.ac.th', NULL),
(2, 3, 'อ.อุไรวรรณ', 'บัวตูม', 'วิทยาศาสตร์และศิลปศาสตร์', 'ajuraiwan@buu.ac.th', NULL),
(3, 8, 'อ.ธารารัตน์', 'พวงสุวรรณ', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=36 ;

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
(7, 'admin3', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'inactive'),
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
(23, '58700101', '67d2ce973dfe2aec3279d8e957cce9f9', 'student', 'active'),
(24, '58700105', '9e5433b81ee5c5912cfe934b84b74e73', 'student', 'active'),
(25, '58700112', '341f4eb75f1a53e1f6ddcc470f933e70', 'student', 'active'),
(26, '58700115', 'd1bdc133b4784098c686b0c5ca1ea00d', 'student', 'active'),
(27, '58700120', '1cc25c938d648d6e4fda4775c17413e0', 'student', 'active'),
(28, '58700121', '9c51a68150d03bb11b475fc0973cd373', 'student', 'active'),
(29, '58700127', '3a302f28028a573242054324089dc0ce', 'student', 'active'),
(30, '58700133', '6592a2ca0cb86cdf8dcb15d9b5c7b0c3', 'student', 'active'),
(31, '58700135', '3157f62f08435873f5e609a8b516e9e8', 'student', 'active'),
(32, '58700140', '6e83bbdf1dad2c7afbc730a9a3f19609', 'student', 'active'),
(33, '58700141', 'c0064bb3ef67639fb47b1d3632242c02', 'student', 'active'),
(34, '58700156', '3b66eb863d7180d06c9bdca6e41e2981', 'student', 'active'),
(35, '58700157', '97648f4805e0f8fdcd68eeb44cd08056', 'student', 'active');

-- --------------------------------------------------------

--
-- Structure for view `courseslist_view`
--
DROP TABLE IF EXISTS `courseslist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `courseslist_view` AS select `c`.`course_id` AS `course_id`,`s`.`subject_id` AS `subject_id`,`s`.`code` AS `code`,`c`.`year` AS `year`,`c`.`startdate` AS `startdate`,`s`.`name` AS `name`,`s`.`shortname` AS `shortname`,`s`.`description` AS `description`,`c`.`visible` AS `visible`,`c`.`status` AS `status` from (`courses` `c` left join `subjects` `s` on((`c`.`subject_id` = `s`.`subject_id`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
