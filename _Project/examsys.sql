-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2014 at 08:17 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `examsys`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getAnswer`(`Qid` INT) RETURNS text CHARSET utf8
    NO SQL
BEGIN
	DECLARE result text;
	SELECT IFNULL(IFNULL(answer_choice,answer_numeric),answer_boolean) as answer
    into @result
from question_list
    where question_id = Qid;

	IF FOUND_ROWS() > 0 THEN
		RETURN @result;
    ELSE
    	RETURN "false";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getEnrollCount`(`courseid` INT) RETURNS int(10)
    NO SQL
BEGIN

declare result int(10);
select count(course_id) as a into @result from Student_Enroll
where course_id = courseid;

return @result;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getNameFromUid`(`Uid` INT) RETURNS varchar(100) CHARSET utf8
    NO SQL
BEGIN
	DECLARE fullname varchar(100);
	SELECT IFNULL(IFNULL( concat(admins.name,' ',admins.lname), concat(teachers.name,' ',teachers.lname) ), concat(students.name,' ',students.lname)) as fullname
    into @fullname
from users
left join admins on (users.id = admins.id)
left join teachers on (users.id = teachers.id)
left join students on (users.id = students.id)
    where users.id = Uid;

	IF FOUND_ROWS() > 0 THEN
		RETURN @fullname;
    ELSE
    	RETURN "false";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getScoreByPaperId`(`paperid` INT, `stuid` INT) RETURNS float
    NO SQL
BEGIN
declare rscore float;
SELECT Score INTO @rscore FROM Scoreboard WHERE paper_id = paperid and stu_id = stuid;

IF FOUND_ROWS() > 0 THEN
		RETURN @rscore;
    ELSE
    	RETURN null;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `getSubjectIdFromCourseId`(`CourseId` INT) RETURNS int(5)
    NO SQL
BEGIN
Declare ret1 INT(5);
	SELECT subject_id into @ret1
from Courses
    where course_id = CourseId;

	IF FOUND_ROWS() > 0 THEN
		RETURN @ret1;
    ELSE
    	RETURN -1;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `isHasQuestion`(`sub_id` INT) RETURNS varchar(20) CHARSET utf8
    NO SQL
BEGIN
	DECLARE chapter INT;
	SELECT chapter_id into @chapter from Chapter where subject_id = sub_id LIMIT 1;
	-- SET chapter = FOUND_ROWS();
	IF FOUND_ROWS() > 0 THEN
		RETURN "true";
    ELSE
    	RETURN "false";
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
`admin_id` int(10) NOT NULL,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL
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
-- Table structure for table `Answer_Papers`
--

CREATE TABLE IF NOT EXISTS `Answer_Papers` (
  `question_id` int(10) NOT NULL,
  `sco_id` int(6) NOT NULL,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Answer_Papers`
--

INSERT INTO `Answer_Papers` (`question_id`, `sco_id`, `answer`) VALUES
(1, 10, '2010'),
(2, 10, '3'),
(3, 10, '1'),
(4, 1, '2'),
(4, 7, '4'),
(4, 8, '2'),
(5, 1, 't'),
(5, 7, 't'),
(5, 8, 't'),
(6, 1, 'f'),
(6, 7, 'f'),
(6, 8, 'f'),
(7, 1, '2'),
(7, 7, '2'),
(7, 8, '1'),
(8, 1, '4'),
(8, 7, '2'),
(8, 8, '4'),
(9, 10, 'f'),
(10, 10, '1'),
(11, 10, '555'),
(12, 10, 't'),
(13, 1, ''),
(13, 7, '4'),
(13, 8, '222222222222222222222222222'),
(14, 10, '2'),
(15, 10, '8888'),
(16, 10, 't'),
(17, 10, 'f'),
(18, 10, '44'),
(19, 10, 'f'),
(20, 10, 't'),
(21, 10, '3'),
(23, 2, '3'),
(23, 6, '3'),
(23, 11, '3'),
(23, 13, '2'),
(23, 14, '1'),
(23, 15, '3'),
(23, 17, '3'),
(23, 18, '2'),
(24, 2, '2'),
(24, 6, '3'),
(24, 11, '1'),
(24, 13, '2'),
(24, 14, '2'),
(24, 15, '2'),
(24, 17, '2'),
(24, 18, '3'),
(25, 2, '3'),
(25, 6, '3'),
(25, 11, '3'),
(25, 13, '1'),
(25, 14, '4'),
(25, 15, '3'),
(25, 17, '3'),
(25, 18, '2'),
(26, 2, '3'),
(26, 6, '1'),
(26, 11, '1'),
(26, 13, '1'),
(26, 14, '4'),
(26, 15, '4'),
(26, 17, '2'),
(26, 18, '4'),
(27, 2, '3'),
(27, 6, '2'),
(27, 11, '1'),
(27, 13, '2'),
(27, 15, '3'),
(27, 17, '2'),
(27, 18, '4'),
(28, 2, '1'),
(28, 6, '1'),
(28, 11, '1'),
(28, 13, '1'),
(28, 15, '4'),
(28, 17, '3'),
(28, 18, '2'),
(29, 2, '4'),
(29, 6, '4'),
(29, 11, '4'),
(29, 13, '4'),
(29, 14, '2'),
(29, 15, '4'),
(29, 17, '4'),
(29, 18, '4'),
(30, 2, '2'),
(30, 6, '2'),
(30, 11, '4'),
(30, 13, '1'),
(30, 14, '2'),
(30, 15, '2'),
(30, 17, '2'),
(30, 18, '2'),
(31, 2, '3'),
(31, 6, '2'),
(31, 11, '2'),
(31, 13, '2'),
(31, 14, '3'),
(31, 15, '2'),
(31, 17, '4'),
(31, 18, '2'),
(32, 2, '4'),
(32, 6, '1'),
(32, 11, '1'),
(32, 13, '3'),
(32, 14, '1'),
(32, 15, '3'),
(32, 17, '3'),
(32, 18, '2'),
(33, 3, '3'),
(33, 5, '1'),
(34, 3, '4'),
(34, 5, '1'),
(35, 3, '3'),
(35, 5, '3'),
(36, 3, '4'),
(36, 5, '4'),
(37, 3, '1'),
(37, 5, '2'),
(38, 3, '1'),
(38, 5, '1'),
(39, 3, '2'),
(39, 5, '3'),
(40, 3, '1'),
(40, 5, '3'),
(41, 3, '1'),
(41, 5, '1'),
(42, 3, '4'),
(42, 5, '4'),
(43, 4, 't'),
(43, 9, 't'),
(43, 12, 't'),
(43, 19, 'f'),
(44, 4, 't'),
(44, 9, 't'),
(44, 12, 't'),
(44, 19, 'f'),
(45, 4, 'f'),
(45, 9, 't'),
(45, 12, 'f'),
(45, 19, 't'),
(46, 4, 'f'),
(46, 9, 'f'),
(46, 12, 't'),
(46, 19, 'f'),
(47, 4, 'f'),
(47, 9, 't'),
(47, 12, 'f'),
(47, 19, 'f'),
(48, 4, 't'),
(48, 9, 'f'),
(48, 12, 't'),
(48, 19, 't'),
(49, 4, 't'),
(49, 9, 'f'),
(49, 12, 't'),
(49, 19, 't'),
(50, 4, 't'),
(50, 9, 't'),
(50, 12, 't'),
(50, 19, 't'),
(53, 4, '1'),
(53, 9, '1'),
(53, 12, '1'),
(53, 19, '4'),
(54, 4, '4'),
(54, 9, '4'),
(54, 12, '4'),
(54, 19, '4'),
(55, 4, '4'),
(55, 9, '4'),
(55, 12, '4'),
(55, 19, '3'),
(56, 4, '3'),
(56, 9, '2'),
(56, 12, '3'),
(56, 19, '3'),
(57, 4, '2'),
(57, 9, '2'),
(57, 12, '2'),
(57, 19, '4'),
(80, 16, '3'),
(81, 16, '2'),
(82, 16, '2'),
(83, 16, '4'),
(84, 16, '2'),
(85, 16, '3'),
(86, 16, '2'),
(87, 16, '2'),
(88, 16, '2'),
(89, 16, '3'),
(90, 16, '1'),
(91, 16, '2'),
(92, 16, '3'),
(93, 16, '3'),
(94, 16, '2'),
(95, 16, '3'),
(96, 16, '1'),
(97, 16, '2'),
(98, 16, '3'),
(99, 16, '2');

-- --------------------------------------------------------

--
-- Table structure for table `Chapter`
--

CREATE TABLE IF NOT EXISTS `Chapter` (
`chapter_id` int(7) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text,
  `subject_id` int(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=18 ;

--
-- Dumping data for table `Chapter`
--

INSERT INTO `Chapter` (`chapter_id`, `name`, `description`, `subject_id`) VALUES
(4, 'บทที่ 1', NULL, 1),
(5, 'บทที่ 2', NULL, 1),
(7, 'บทที่ 1 แนะนำ OOP', NULL, 2),
(8, 'บทที่ 2 Class', NULL, 2),
(9, 'บทที่ 3', NULL, 1),
(10, 'Chapter 1', NULL, 4),
(11, 'เรื่อง ระบบย่อยอาหาร', NULL, 6),
(12, 'การจัดเรียงอิเล็กตรอนในระดับพลังงานต่างๆ', NULL, 7),
(13, 'การตลาดระดับโลก ถูกผิด', NULL, 8),
(14, 'การตลาดระดับโลก ปรนัย', NULL, 8),
(15, 'reading comprehension', NULL, 9),
(16, 'การเจริญเติบโตของร่างกาย', NULL, 6),
(17, 'กีฬาเทควันโด', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) DEFAULT NULL,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('0d0ae9965daf98ca3583503e347b03d1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1418722918, ''),
('137ae4a351cd64289741e3ecff777156', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) Ap', 1418713669, ''),
('4ce8dd72d2722515c89599f2c3b074e4', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) Ap', 1418736466, ''),
('563fe65a94fb712452a921cac935d6bb', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) Ap', 1418752069, 'a:10:{s:9:"user_data";s:0:"";s:2:"id";s:1:"1";s:3:"uid";s:1:"1";s:8:"username";s:5:"admin";s:8:"fullname";s:34:"สตีฟ แอปเปิล";s:5:"fname";s:12:"สตีฟ";s:5:"lname";s:21:"แอปเปิล";s:4:"role";s:5:"admin";s:6:"logged";b:1;s:16:"flash:old:noAnim";b:1;}'),
('deeeeff3c40e697d0d2ab91ae56dc4fd', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) Ap', 1418709205, '');

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
`course_id` int(4) NOT NULL,
  `year` varchar(4) NOT NULL DEFAULT '',
  `pwd` varchar(20) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(20) NOT NULL,
  `subject_id` int(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`course_id`, `year`, `pwd`, `visible`, `status`, `subject_id`) VALUES
(1, '2014', NULL, 1, 'active', 1),
(2, '2014', '12345', 1, 'active', 2),
(3, '2014', NULL, 0, 'inactive', 4),
(4, '2014', NULL, 1, 'active', 6),
(5, '2014', NULL, 1, 'active', 7),
(6, '2014', NULL, 1, 'active', 8),
(7, '2014', NULL, 1, 'active', 9),
(8, '2014', NULL, 1, 'active', 10);

-- --------------------------------------------------------

--
-- Stand-in structure for view `coursesbystudents`
--
CREATE TABLE IF NOT EXISTS `coursesbystudents` (
`stu_id` varchar(10)
,`course_id` int(4)
,`subject_id` int(5)
,`group_id` int(6)
,`year` varchar(4)
,`visible` tinyint(1)
,`status` varchar(20)
,`code` varchar(10)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `courseslist_view`
--
CREATE TABLE IF NOT EXISTS `courseslist_view` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
,`visible` tinyint(1)
,`status` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `Course_Students_group`
--

CREATE TABLE IF NOT EXISTS `Course_Students_group` (
`group_id` int(6) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` text,
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `Course_Students_group`
--

INSERT INTO `Course_Students_group` (`group_id`, `name`, `description`, `course_id`) VALUES
(1, 'Sec 1', NULL, 1),
(9, 'Sec 2', 'กลุ่มเพิ่มเติม', 1),
(11, 'group1', '', 2),
(12, 'กลุ่ม Sci1', '', 4),
(13, 'Sci.p 1', '', 5),
(14, 'GM', '', 6),
(15, 'TOEIC 1', 'เฉพาะผู้ที่ลงเรียนเท่านั้น', 7),
(16, 'TOEIC 2', 'ลงเพิ่มเติม', 7),
(17, 'กลุ่ม 1', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Exam_Papers`
--

CREATE TABLE IF NOT EXISTS `Exam_Papers` (
`paper_id` int(7) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` text,
  `rules` text,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Exam_Papers`
--

INSERT INTO `Exam_Papers` (`paper_id`, `title`, `description`, `rules`, `starttime`, `endtime`, `visible`, `status`, `course_id`) VALUES
(1, 'สอบพื้นฐาน', 'สอบก่อนเรียน', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-12-07 09:00:00', '2014-12-07 10:00:00', 1, 'active', 1),
(2, 'A', 'ชุดข้อสอบ', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-12-08 09:00:00', '2014-12-08 10:00:00', 1, 'deleted', 1),
(3, 'สอบพื้นฐาน', 'สอบก่อนเรียน', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-12-03 09:00:00', '2014-12-03 10:00:00', 1, 'deleted', 1),
(4, 'สอบพื้นฐาน', 'สอบก่อนเรียน', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-12-03 09:00:00', '2014-12-03 10:00:00', 1, 'deleted', 1),
(5, 'สอบก่อนเรียน', '', '', '2014-12-08 15:30:00', '2014-12-08 15:45:00', 1, 'active', 3),
(6, 'สอบก่อนเรียน', '', '', '2014-12-10 09:00:00', '2014-12-10 10:20:00', 1, 'active', 2),
(7, 'สอบกลางภาค', '', '', '2014-12-16 09:20:00', '2014-12-16 10:30:00', 1, 'active', 2),
(8, 'สอบพื้นฐาน', 'สอบก่อนเรียน', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-12-03 09:00:00', '2014-12-03 10:00:00', 1, 'deleted', 1),
(9, 'ระบบย่อยอาหาร', 'จงเลือกคำตอบที่ถูกที่สุดเพียงคำตอบเดียว', 'ใช้เวลาในการสอบ 10 นาที\nห้ามเปิดตำราเรียน\nทุจริตปรับตกวิชานี้', '2014-12-08 13:00:00', '2014-12-08 13:10:00', 1, 'active', 4),
(10, 'การจัดเรียงอิเล็กตรอนในระดับพลังงาน', 'เลือกคำตอบที่ถูกต้องที่สุด เพียงคำตอบเดียว', 'ใช้เวลาในการสอบ 20 นาที\nห้ามนำตำราเข้าห้องสอบ\nทุจริตปรับตกวิชานี้', '2014-12-08 09:00:00', '2014-12-08 09:20:00', 1, 'active', 5),
(11, 'การตลาดระดับโลก', 'ข้อสอบมี 2 ตอน ทำทุกตอน', '1. ห้ามนำตำราเข้าห้องสอบ\n2.  ทุจริตปรับตกวิชานี้\n3. ใช้เวลาในการสอบ 40 นาที', '2014-12-27 08:00:00', '2014-12-27 08:40:00', 1, 'active', 6),
(12, 'TOEIC TEST', 'Reading Comprehension', '60 minutes for testing', '2014-12-09 09:00:00', '2014-12-09 10:00:00', 1, 'active', 7),
(13, 'การเจริญเติบโตของร่างกาย', '', '', '2014-12-16 10:00:00', '2014-12-16 11:00:00', 1, 'active', 4),
(14, 'ทดสอบความรู้สัตว์เลี้ยงลูกด้วยนม', '', '', '2014-12-16 10:00:00', '2014-12-16 11:00:00', 1, 'deleted', 4),
(15, 'กีฬาเทควันโด', '', '', '2014-12-25 13:00:00', '2014-12-25 14:30:00', 1, 'active', 8);

-- --------------------------------------------------------

--
-- Table structure for table `Exam_Papers_Detail`
--

CREATE TABLE IF NOT EXISTS `Exam_Papers_Detail` (
  `question_id` int(10) NOT NULL,
  `part_id` int(7) NOT NULL,
  `paper_id` int(7) NOT NULL,
  `no` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Exam_Papers_Detail`
--

INSERT INTO `Exam_Papers_Detail` (`question_id`, `part_id`, `paper_id`, `no`) VALUES
(1, 1, 1, 1),
(1, 9, 8, 1),
(2, 1, 1, 2),
(2, 8, 8, 2),
(3, 1, 1, 7),
(3, 8, 8, 7),
(4, 5, 6, 1),
(4, 7, 7, 1),
(5, 5, 6, 2),
(5, 7, 7, 2),
(6, 6, 6, 1),
(6, 7, 7, 1),
(7, 6, 6, 2),
(7, 7, 7, 2),
(8, 7, 7, 1),
(9, 1, 1, 6),
(11, 1, 1, 5),
(11, 9, 8, 5),
(12, 1, 1, 3),
(13, 5, 6, 3),
(13, 7, 7, 3),
(14, 8, 8, 1),
(15, 1, 1, 8),
(15, 9, 8, 8),
(18, 1, 1, 9),
(20, 1, 1, 4),
(21, 9, 8, 1),
(23, 13, 9, 1),
(23, 19, 13, 1),
(24, 13, 9, 2),
(24, 19, 13, 2),
(25, 13, 9, 4),
(25, 19, 13, 4),
(26, 13, 9, 3),
(26, 19, 13, 3),
(27, 13, 9, 5),
(27, 19, 13, 5),
(28, 13, 9, 6),
(28, 19, 13, 6),
(29, 13, 9, 7),
(29, 19, 13, 7),
(30, 13, 9, 8),
(30, 19, 13, 8),
(31, 13, 9, 9),
(31, 19, 13, 9),
(32, 13, 9, 10),
(32, 19, 13, 10),
(33, 15, 10, 1),
(34, 15, 10, 2),
(35, 15, 10, 3),
(36, 15, 10, 4),
(37, 15, 10, 5),
(38, 15, 10, 6),
(39, 15, 10, 7),
(40, 15, 10, 8),
(41, 15, 10, 9),
(42, 15, 10, 10),
(43, 16, 11, 1),
(44, 16, 11, 2),
(45, 16, 11, 3),
(46, 16, 11, 4),
(47, 16, 11, 5),
(48, 16, 11, 6),
(49, 16, 11, 7),
(50, 16, 11, 8),
(53, 17, 11, 1),
(54, 17, 11, 2),
(55, 17, 11, 3),
(56, 17, 11, 4),
(57, 17, 11, 5),
(58, 18, 12, 1),
(59, 18, 12, 2),
(60, 18, 12, 3),
(61, 18, 12, 4),
(62, 18, 12, 5),
(63, 18, 12, 6),
(64, 18, 12, 7),
(65, 18, 12, 8),
(66, 18, 12, 9),
(67, 18, 12, 10),
(68, 18, 12, 11),
(69, 18, 12, 12),
(80, 20, 15, 1),
(81, 20, 15, 2),
(82, 20, 15, 3),
(83, 20, 15, 4),
(84, 20, 15, 5),
(85, 20, 15, 6),
(86, 20, 15, 7),
(87, 20, 15, 8),
(88, 20, 15, 9),
(89, 20, 15, 10),
(90, 20, 15, 11),
(91, 20, 15, 12),
(92, 20, 15, 13),
(93, 20, 15, 14),
(94, 20, 15, 15),
(95, 20, 15, 16),
(96, 20, 15, 17),
(97, 20, 15, 18),
(98, 20, 15, 19),
(99, 20, 15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `Exam_Papers_Parts`
--

CREATE TABLE IF NOT EXISTS `Exam_Papers_Parts` (
`part_id` int(7) NOT NULL,
  `no` tinyint(3) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` text,
  `israndom` tinyint(1) NOT NULL,
  `paper_id` int(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `Exam_Papers_Parts`
--

INSERT INTO `Exam_Papers_Parts` (`part_id`, `no`, `title`, `description`, `israndom`, `paper_id`) VALUES
(1, 1, 'ตอน 1', 'เลือกคำตอบที่ถูกต้อง', 0, 1),
(3, 1, 'ตอนที่ 1', 'ทำความเข้าใจ', 0, 5),
(5, 2, 'ข้อตัวเลือก', 'เป็นตัวเลือก 4 ข้อ', 0, 6),
(6, 1, 'ตัวเลือกอัน2', '', 1, 6),
(7, 1, 'ตัวเลือก', '', 0, 7),
(8, 1, 'Choice', 'ตัวเลือก', 1, 8),
(9, 2, 'Fill the Answer', 'เติมคำตอบให้ถูกต้อง', 1, 8),
(13, 1, 'ระบบย่อยอาหาร', '', 1, 9),
(15, 1, 'ปรนัย', '', 1, 10),
(16, 1, 'ถูกผิด', '', 1, 11),
(17, 2, 'ปรนัย', '', 0, 11),
(18, 1, 'reading comprehension', '', 0, 12),
(19, 1, 'เลือกตอบ', '', 1, 13),
(20, 1, 'เลือกตอบ', '', 1, 15);

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
-- Table structure for table `Questions`
--

CREATE TABLE IF NOT EXISTS `Questions` (
`question_id` int(10) NOT NULL,
  `question` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chapter_id` int(7) NOT NULL,
  `created_by_id` int(8) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `Questions`
--

INSERT INTO `Questions` (`question_id`, `question`, `type`, `status`, `created_time`, `chapter_id`, `created_by_id`) VALUES
(1, '<p><strong><span style="font-size:16px;">ปัจจุบัน Office เวอร์ชั่นอะไร ที่นิยมที่สุด</span></strong></p>', 'numeric', 'inuse', '2014-09-02 18:30:26', 4, 8),
(2, '<p>Test2</p>', 'choice', 'inuse', '2014-09-09 09:14:28', 4, 3),
(3, '<p>คำสั่ง <br /><span style="line-height:1.6em;">   echo "Hello World";<br />\nเป็นภาษาใด</span></p>', 'choice', 'inuse', '2014-09-15 12:23:25', 5, 8),
(4, '<p><span style="font-size:16px;"><u><strong>Method</strong></u> มีอีกชื่อเรียกหนึ่งว่าอะไร</span></p>', 'choice', 'active', '2014-09-17 19:41:24', 7, 3),
(5, '<p>VB.NET ถือเป็นการเขียนโปรแกรมแบบ OOP</p>', 'boolean', 'active', '2014-09-08 16:35:48', 7, 8),
(6, '<p><strong>Class</strong> ประกอบไปด้วย <strong>Attribute</strong> และ <strong>Method</strong>  <u><span style="color:#FF0000;">ไม่สามารถสืบทอดได้</span></u></p>', 'boolean', 'inuse', '2014-09-22 08:23:26', 8, 3),
(7, '<p><span style="font-size:22px;"><span style="font-family:''th sarabun new'', ''th sarabun psk'';">หากมี <strong>Method</strong>  <u>Run() </u> ใน <strong>Class</strong>  ต้องการให้เรียกใช้จากภายนอกได้  จะต้องกำหนด <span style="color:#FF0000;"><strong>Encapsulation</strong></span> อย่างไร</span></span></p>', 'choice', 'inuse', '2014-09-24 13:20:44', 8, 3),
(8, '<blockquote>\n<p>Class Fan {</p>\n\n<p>    private int speed;<br /><span style="line-height:1.6em;">    private double power</span><br /><span style="line-height:1.6em;">    private bool isSwing;</span><br /><span style="line-height:1.6em;">    public string name;</span><br /><span style="line-height:1.6em;">}</span></p>\n</blockquote>\n\n<p>จาก Class ดังกล่าว  มีการกำหนด  Attribute กี่ตัว  </p>', 'numeric', 'inuse', '2014-09-29 09:32:17', 8, 8),
(9, '<p>Drafting question</p>', 'boolean', 'inuse', '2014-09-22 09:48:18', 5, 3),
(10, '<p>Drafting 2</p>', 'choice', 'inuse', '2014-10-01 15:20:10', 4, 3),
(11, '<p>Disabled question</p>', 'numeric', 'inuse', '2014-09-08 21:05:28', 4, 8),
(12, '<p>Trueeee</p>', 'boolean', 'inuse', '2014-09-08 21:09:05', 4, 8),
(13, '<p><strong>jhglkdjf;sldkfs;dkjfls;</strong></p>', 'numeric', 'active', '2014-09-09 15:38:00', 7, 8),
(14, '<p><em>dfkjs;ldkfjs;ldfsoduypofsdjo</em></p>', 'choice', 'inuse', '2014-10-02 13:58:53', 4, 8),
(15, '<p><span style="background-color:rgb(249,249,249);color:rgb(102,102,102);font-family:''source sans pro'', sans-serif;font-size:17px;">IT Consultancy Method</span></p>\n\n<p><font color="#666666" face="source sans pro, sans-serif"><span style="background-color:rgb(249,249,249);font-size:17px;">รหัสวิชาคืออะไร</span></font></p>', 'numeric', 'inuse', '2014-10-02 14:05:21', 4, 8),
(16, '<p><span style="font-size:18px;">ITITITITITITITIT</span></p>', 'boolean', 'inuse', '2014-10-02 14:07:00', 4, 8),
(17, '<p><strong>bfafrstjvghulkbjklinjkljkl</strong></p>', 'boolean', 'inuse', '2014-10-02 14:08:47', 4, 8),
(18, '<p><span style="color:#FF0000;"> bbcbcvxvcxvxccvxcvxcxcvxcv</span></p>', 'numeric', 'inuse', '2014-10-02 15:17:08', 4, 8),
(19, '<p><u>yrttewewerwe</u></p>', 'boolean', 'inuse', '2014-10-02 15:23:38', 4, 8),
(20, '<p>werwertertwertr</p>', 'boolean', 'inuse', '2014-10-02 15:32:12', 9, 8),
(21, '<p><span style="font-size:20px;">1+2 = ?</span></p>', 'numeric', 'inuse', '2014-10-09 20:43:29', 4, 8),
(22, '<p><strong>gtsrtgertyer</strong></p>', 'choice', 'active', '2014-12-06 11:21:00', 4, 8),
(23, '<p><strong>เพราะเหตุใดเวลาเราเคี้ยวข้าวนานๆ จะรู้สึกข้าวนั้นหวาน</strong></p>', 'choice', 'inuse', '2014-12-06 12:31:47', 11, 8),
(24, '<p><strong> อนุภาคที่เล็กที่สุดได้จากการย่อยโปรตีนคืออะไร</strong></p>', 'choice', 'inuse', '2014-12-06 12:34:22', 11, 8),
(25, '<p><strong>ที่กระเพาะอาหารมีการย่อยอาหารประเภทใด และอยู่ในภาวะใด</strong></p>', 'choice', 'inuse', '2014-12-06 12:35:55', 11, 8),
(26, '<p><strong>ถ้าเป็นโรคตับอักเสบ จะส่งผลกระทบต่อระบบย่อยอาหารประเภทใด</strong></p>', 'choice', 'inuse', '2014-12-06 12:39:24', 11, 8),
(27, '<p><strong>ถ้าหากเรารับประทานข้าวมันไก่จะมีการย่อยสิ้นสุดที่อวัยวะใดเป็นลำดับสุดท้าย</strong></p>', 'choice', 'inuse', '2014-12-06 12:40:55', 11, 8),
(28, '<p><strong>อาหารประเภทวิตามินและแร่ธาตุนั้นไม่ต้องผ่านกระบวนการย่อย <u>ใช่</u>หรือ<u>ไม่  </u>เพราะเหตุใด</strong></p>', 'choice', 'inuse', '2014-12-06 12:42:46', 11, 8),
(29, '<p><strong>ถ้าหากเรากินอาหารไม่เป็นเวลา จะก่อให้เกิดอาการอย่างไร</strong></p>', 'choice', 'inuse', '2014-12-06 12:45:20', 11, 8),
(30, '<p><strong>ที่อวัยวะบริเวณใดบ้าง เกิดการย่อยอาหารประเภทโปรตีน</strong></p>', 'choice', 'inuse', '2014-12-06 12:47:40', 11, 8),
(31, '<p><strong>อวัยวะบริเวณใดมีการย่อยอาหารครบทั้ง คาร์โบไฮเดรต โปรตีนและไขมัน</strong></p>', 'choice', 'inuse', '2014-12-06 12:49:56', 11, 8),
(32, '<p><strong> อวัยวะใดบ้าง ที่สามารถผลิตน้ำย่อยและย่อยอาหารจำพวกแป้งได้</strong></p>', 'choice', 'inuse', '2014-12-06 12:51:55', 11, 8),
(33, '<p><strong>ระดับพลังงานอิเล็กตรอน K L M N O P Q เป็นแบบจำลองอะตอมของใคร</strong></p>', 'choice', 'inuse', '2014-12-06 14:14:23', 12, 8),
(34, '<p><strong> จำนวนอิเล็กตรอนที่มีได้มากที่สุดในแต่ละดับชั้นพลังงานคือ</strong></p>', 'choice', 'inuse', '2014-12-06 14:16:11', 12, 8),
(35, '<p><strong>ระดับพลังงานที่ 3( n=3 ) มีจำนวนอิเล็กตรอนได้มากที่สุดคือเท่าไร</strong></p>', 'choice', 'inuse', '2014-12-06 14:17:39', 12, 8),
(36, '<p><strong>จัดอิเล็กตรอนของ</strong>  <strong><sub> 11</sub></strong><strong>Na</strong><strong>  ให้ถูกต้อง</strong></p>', 'choice', 'inuse', '2014-12-06 14:19:12', 12, 8),
(37, '<p><strong>จัดอิเล็กตรอนของ   <sub>20</sub>Ca   ให้ถูกต้อง</strong></p>', 'choice', 'inuse', '2014-12-06 14:22:29', 12, 8),
(38, '<p><strong>ระดับพลังงานที่ 4( n = 4 ) มี 4 ระดับพลังงานย่อยคือ</strong></p>', 'choice', 'inuse', '2014-12-06 14:23:26', 12, 8),
(39, '<p><strong>ธาตุ Li มีการจัดเรียงออร์บิทัลอย่างไร</strong></p>', 'choice', 'inuse', '2014-12-06 14:25:17', 12, 8),
(40, '<p><strong>ธาตุ O มีการจัดเรียงออร์บิทัลอย่างไร</strong></p>', 'choice', 'inuse', '2014-12-06 14:27:37', 12, 8),
(41, '<p><strong>อิเล็กตรอนที่อยู่ในระดับพลังงานสูงสุดหรือชั้นนอกสุดเรียกว่า</strong></p>', 'choice', 'inuse', '2014-12-06 14:28:25', 12, 8),
(42, '<p><strong>ระดับพลังงานที่ 4( n=4 ) มีจำนวนอิเล็กตรอนมากที่สุดได้เท่าไร</strong></p>', 'choice', 'inuse', '2014-12-06 14:32:46', 12, 8),
(43, '<p>ความหมายของราคาคือ จำนวนเงินที่มีมูลค่าเท่ากับสินค้าและบริการที่ลูกค้าต้องการ และมีศักยภาพในการจ่ายไป เพื่อให้ได้รับสินค้าและบริการที่ต้องการ </p>', 'boolean', 'inuse', '2014-12-06 16:57:43', 13, 64),
(44, '<p>แนวคิดการตั้งราคาที่นิยมใช้ มี 2 แนวคิด คือการตั้งราคาตากต้นทุน และ การตั้งราคาตามคุณค่า </p>', 'boolean', 'inuse', '2014-12-06 16:58:23', 13, 64),
(45, '<p>ปัจจัยที่มีผลต่อการกำหนดราคาขายในต่างประเทศนั้นมีหลายปัจจัยรวมไปถึง ปัจจัยด้านอายุการใช้งานด้วย</p>', 'boolean', 'inuse', '2014-12-06 16:58:46', 13, 64),
(46, '<p>นโยบายระดับราคา การตั้งราคา ณ ระดับตลาด เป็นการตั้งราคาสินค้าให้เท่ากับราคาของคู่แข่งขันที่ขายสินค้า ประเภทเดียวกัน คุณภาพด้อยกว่ากัน </p>', 'boolean', 'inuse', '2014-12-06 16:59:08', 13, 64),
(47, '<p>ปัจจัยที่ต้องพิจารณาในการเลือกใช้เครื่องมือการส่งเสริมการตลาด ประเภทตลาด เพียงอย่างเดียวเท่านั้น </p>', 'boolean', 'inuse', '2014-12-06 17:02:52', 13, 64),
(48, '<p>Target Group จะแบ่งออกแบบกว้างๆ ได้เป็น 2 กลุ่ม คือ Non – customer และ Customer Group </p>', 'boolean', 'inuse', '2014-12-06 17:03:21', 13, 64),
(49, '<p>จุดมุ่งหมายของ IMC คือความหลากหลายของเครื่องมือในการสื่อสาร ตลอดจน วิธีการใช้เครื่องมือต่างๆ เพื่อส่งข้อความไปยัง Target Market ให้มีประสิทธิภาพมากที่สุดในกานเข้าถึง แจ้งให้ทราบ และชักชวน และท้ายสุดโน้มน้าวให้เปลี่ยนพฤติกรรม </p>', 'boolean', 'inuse', '2014-12-06 17:03:47', 13, 64),
(50, '<p>การจำจำหน่ายสินค้าโดยตรงจากธุรกิจไปยัง Target Group โดยไม่ผ่านคนกลางทางการตลาด เช่น TV Direct ที่ขายสินค้าผ่าน TV หรือผ่าน Internet </p>', 'boolean', 'inuse', '2014-12-06 17:04:14', 13, 64),
(51, '<p>ผู้ค้าส่ง ( Wholesaler ) คือ ผู้ที่ทำหน้าที่กระจายสินค้า ไปยังผู้ค้าปลีก (Retailer) โดยผู้ค้าส่งแบ่งออกเป็น 3 ประเภท คือ ยี่ปั๊ว นายหน้าและตัวแทนขาย กับ ศูนย์กระจายสินค้า </p>', 'boolean', 'active', '2014-12-06 17:04:39', 13, 64),
(52, '<p>ระบบ EDI คือระบบที่สามารถเช็คสินค้าได้เมื่อสินค้าหมดชั้นวางสินค้า</p>', 'boolean', 'active', '2014-12-06 17:05:02', 13, 64),
(53, '<p>ปัจจัยภายในใดบ้าง ที่ใช้ในการวางแผนช่องทางการจัดจำหน่าย</p>', 'choice', 'inuse', '2014-12-06 17:09:18', 14, 64),
(54, '<p>ข้อเสียของการซื้อผ่านอินเตอร์เน็ตคืออะไร</p>', 'choice', 'inuse', '2014-12-06 17:10:31', 14, 64),
(55, '<p>ข้อใดไม่จัดเป็นวิธีการขนส่งสินค้า</p>', 'choice', 'inuse', '2014-12-06 17:11:57', 14, 64),
(56, '<p>กระบวนการขนส่งสินค้า สำคัญพอๆกับกระบวนการผลิตเพราะเหตุใด</p>', 'choice', 'inuse', '2014-12-06 17:13:17', 14, 64),
(57, '<p>ประเทศใดไม่ใช่ประเทศในกลุ่ม ประเทศ MINT </p>', 'choice', 'inuse', '2014-12-06 17:14:36', 14, 64),
(58, '<p>Small computer software company is looking for an office manager .College degree not required, but applicant must have at least two year experience at a similar job. Call Ms. Chang (director) at 348-555-0987. <span style="line-height:1.6em;">What kind of job is advertised ?</span></p>', 'choice', 'inuse', '2014-12-06 23:41:04', 15, 64),
(59, '<p>Small computer software company is looking for an office manager .College degree not required, but applicant must have at least two year experience at a similar job. Call Ms. Chang (director) at 348-555-0987. What is a requirement for this job ?</p>', 'choice', 'inuse', '2014-12-06 23:44:11', 15, 64),
(60, '<p style="text-align:center;"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style="text-align:center;"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style="text-align:center;"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>What kind of computer paper is on sale?</strong></p>', 'choice', 'inuse', '2014-12-06 23:53:54', 15, 64),
(61, '<p style="text-align:center;"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style="text-align:center;"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style="text-align:center;"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>How can you get a free notebook ?</strong></p>', 'choice', 'inuse', '2014-12-06 23:56:50', 15, 64),
(62, '<p style="text-align:center;"><strong>OFFICE SUPPLY SALE</strong></p>\n\n<p style="text-align:center;"><strong>This week only</strong></p>\n\n<ul><li>Computer paper (white only) 25 %</li>\n	<li>Envelopes (all colors, including pink, purple, and gold) 50 %</li>\n	<li>Notebooks-buy five, get one free</li>\n	<li>Pens (blue,back.and red ink) 12 for 1 USD</li>\n</ul><p style="text-align:center;"><strong>Sale ends Saturday</strong></p>\n\n<p><strong>When is the sale ?</strong></p>', 'choice', 'inuse', '2014-12-06 23:58:42', 15, 64),
(63, '<p style="text-align:center;">CITY ZOO</p>\n\n<p><img alt="" src="http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png" style="height:209px;width:485px;" /></p>\n\n<p>How many people visited the zoo in February?</p>', 'choice', 'inuse', '2014-12-07 00:16:54', 15, 64),
(64, '<p style="text-align:center;">CITY ZOO</p>\n\n<p><img alt="" src="http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png" style="height:209px;width:485px;" /></p>\n\n<p>When did 4,980 people visit the zoo?</p>', 'choice', 'inuse', '2014-12-07 00:18:40', 15, 64),
(65, '<p style="text-align:center;">CITY ZOO</p>\n\n<p><img alt="" src="http://192.168.1.9/oxproject/vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-000838.png" style="height:209px;width:485px;" /></p>\n\n<p>Which was the most popular month to visit the zoo?</p>', 'choice', 'inuse', '2014-12-07 00:20:09', 15, 64),
(66, '<p><img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg" style="height:300px;width:454px;" /></p><p>Where will Brianna Herbert be next week?</p>', 'choice', 'inuse', '2014-12-07 00:37:21', 15, 64),
(67, '<p><img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg" style="height:300px;width:454px;" /></p><p>Who is Sherry Noyes?</p>', 'choice', 'inuse', '2014-12-07 00:41:22', 15, 64),
(68, '<p><img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg" style="height:300px;width:454px;" /></p><p>The word "<u>contact</u>" in  the line 8 is closest in meaning to...</p>', 'choice', 'inuse', '2014-12-07 00:43:50', 15, 64),
(69, '<p><img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/capture-20141207-003144.jpg" style="height:300px;width:454px;" /></p><p>Who should read the memo?</p>', 'choice', 'inuse', '2014-12-07 00:46:32', 15, 64),
(70, '<p>สารอาหาร หมายถึง</p>', 'choice', 'active', '2014-12-11 22:58:32', 16, 4),
(71, '<p>ร่างกายคนเรามีการเจริญเติบโตเมื่อใด</p>', 'choice', 'active', '2014-12-11 23:03:10', 16, 4),
(72, '<p>สิ่งใดที่บอกความเจริญเติบโตร่างกาย</p>', 'choice', 'active', '2014-12-11 23:07:30', 16, 4),
(73, '<p>ในวัยใดที่ร่างกายคนเราจะหยุดการเจริญเติบโต</p>', 'choice', 'active', '2014-12-11 23:08:54', 16, 4),
(74, '<p>ถ้าพลังงานที่เราได้รับจากอาหารใน 1 วัน เกินความต้องการของร่างกาย เราควรทำอย่างไร</p>', 'choice', 'active', '2014-12-11 23:11:23', 16, 4),
(75, '<p>ใคร น่าจะต้องการสารอาหารประเภท คาร์โบไฮเดรตมากที่สุด</p>', 'choice', 'active', '2014-12-11 23:14:17', 16, 4),
(76, '<p>ถ้าไม่รับประทานไขมันเลย ร่างกายจะไม่สามารถดูดซึมวิตามินใดได้</p>', 'choice', 'active', '2014-12-11 23:18:33', 16, 4),
(77, '<p>อาหารกลุ่มใดมีสารอาหารชนิดเดียวกันทั้งหมด</p>', 'choice', 'active', '2014-12-11 23:25:07', 16, 4),
(78, '<p>โรค เอ๋อ เกิดจากสาเหตุใด</p>', 'choice', 'active', '2014-12-11 23:37:13', 16, 4),
(79, '<p>ปริมาณอาหารประเภทใด ที่มีผลต่อการเจริญเติบโตของร่างกายมากที่สุด</p>', 'choice', 'active', '2014-12-11 23:38:48', 16, 4),
(80, '<p>เทควันโดมีการตั้งสมาคมและการแข่งขันครั้งแรกในปีใด</p>', 'choice', 'inuse', '2014-12-12 00:29:09', 17, 4),
(81, '<p>ใครเป็นผู้นำเทควันโดเข้ามาในประเทศไทยเป็นคนแรก</p>', 'choice', 'inuse', '2014-12-12 00:30:51', 17, 4),
(82, '<p>ข้อใดไม่ใช่บทบัญญัติของเทควันโด</p>', 'choice', 'inuse', '2014-12-12 00:32:07', 17, 4),
(83, '<p>สนามการแข่งขันมาตรฐานของกีฬาเทควันโดมีขนาดเท่าใด</p>', 'choice', 'inuse', '2014-12-12 00:34:05', 17, 4),
(84, '<p>การแบ่งน้ำหนักของนักกีฬาประเภทประชาชนชาย ในช่วง 62 กก. แต่ไม่เกิน 67 กก. จัดอยู่ในรุ่นแข่งขันใด</p>', 'choice', 'inuse', '2014-12-12 00:37:50', 17, 4),
(85, '<p><span style="background-color:rgb(248,248,248);color:rgb(0,0,0);font-family:tahoma;font-size:14px;">การแบ่งน้ำหนักของนักกีฬาประเภทประชาชนชาย ในช่วง 63 กก. แต่ไม่เกิน 67 กก. จัดอยู่ในรุ่นแข่งขันใด</span></p>', 'choice', 'inuse', '2014-12-12 00:40:40', 17, 4),
(86, '<p>ในกรณีใด ที่ถือเป็นการเตะที่ได้แต้ม</p>', 'choice', 'inuse', '2014-12-12 00:43:57', 17, 4),
(87, '<p>บริเวณใดที่กระทำแล้วไม่ได้คะแนน</p>', 'choice', 'inuse', '2014-12-12 00:49:12', 17, 4),
(88, '<p>ภาพต่อไปนี้มีชื่อท่าว่าอะไร <img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/Q000025637.jpg" style="height:334px;width:500px;" /></p>', 'choice', 'inuse', '2014-12-12 00:53:32', 17, 4),
(89, '<p>ภาพต่อไปนี้มีชื่อท่าว่าอะไร<img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/Q000025638.jpg" style="height:282px;width:424px;" /></p>', 'choice', 'inuse', '2014-12-12 00:56:13', 17, 4),
(90, '<p>ภาพต่อไปนี้มีชื่อท่าว่าอะไร<img alt="" src="vendor/js/plugins/ckeditor/plugins/uploads/Q000025641.gif" style="height:424px;width:290px;" /></p>', 'choice', 'inuse', '2014-12-12 00:58:47', 17, 4),
(91, '<p>การกระทำใดไม่ถูกตัด Kyong go</p>', 'choice', 'inuse', '2014-12-12 01:00:33', 17, 4),
(92, '<p>ข้อใดลำดับสายเทควันโดได้ถูกต้อง</p>', 'choice', 'inuse', '2014-12-12 01:02:04', 17, 4),
(93, '<p>สายดำ ดั้งใดถึงสามารถออกใบประกาศการสอบสายได้ (อย่างน้อยดั้งใด)</p>', 'choice', 'inuse', '2014-12-12 01:10:22', 17, 4),
(94, '<p>สายดำมีทั้งหมดกี่ดั้ง</p>', 'choice', 'inuse', '2014-12-12 01:11:54', 17, 4),
(95, '<p>จำนวณการแข่งขันแบบทีมมีนักกีฬากี่คนต่อทีม</p>', 'choice', 'inuse', '2014-12-12 01:14:50', 17, 4),
(96, '<p>ข้อใดไม่ใช้ส่วนประกอบการเรียนรู้กีฬาเทควันโด</p>', 'choice', 'inuse', '2014-12-12 01:16:50', 17, 4),
(97, '<p>Taekwondo  มาจากคำว่าอะไร</p>', 'choice', 'inuse', '2014-12-12 01:19:24', 17, 4),
(98, '<p>ต้นกำเนิดจริงๆของศิลปะการป้องกันตัวขนิดนี้มาจากประเทศอะไร (แรกเริ่มเลย)</p>', 'choice', 'inuse', '2014-12-12 01:23:48', 17, 4),
(99, '<p>คำอ่านที่ถูกต้องของคำว่า Tae-Kwon-Do คือข้อใด</p>', 'choice', 'inuse', '2014-12-12 01:25:55', 17, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Question_boolean`
--

CREATE TABLE IF NOT EXISTS `Question_boolean` (
`id` int(10) NOT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `Question_boolean`
--

INSERT INTO `Question_boolean` (`id`, `answer`, `question_id`) VALUES
(1, 't', 5),
(2, 'f', 6),
(3, 't', 9),
(4, 't', 12),
(5, 'f', 16),
(6, 't', 17),
(7, 't', 19),
(8, 't', 20),
(9, 't', 43),
(10, 't', 44),
(11, 'f', 45),
(12, 'f', 46),
(13, 'f', 47),
(14, 't', 48),
(15, 't', 49),
(16, 't', 50),
(17, 't', 51),
(18, 't', 52);

-- --------------------------------------------------------

--
-- Table structure for table `Question_choice`
--

CREATE TABLE IF NOT EXISTS `Question_choice` (
`id` int(10) NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text,
  `choice4` text,
  `choice5` text,
  `choice6` text,
  `answer` varchar(20) NOT NULL,
  `question_id` int(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `Question_choice`
--

INSERT INTO `Question_choice` (`id`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`, `choice6`, `answer`, `question_id`) VALUES
(1, 'aaaa', 'bbbb', 'cccc', 'dddd', '', '', '1', 2),
(2, 'HTML', 'C#.NET', 'PHP', 'MySQL', '', '', '3', 3),
(3, 'Public', 'Function', 'Attribute', 'ถูกทุกข้อ', '', '', '2', 4),
(4, 'Private', 'Public', 'Protected', 'Void', '', '', '2', 7),
(5, '5656', '7404', '', '', '', '', '2', 10),
(6, 'a', 'b', 'c', 'd', '', '', '1', 14),
(7, 'rtte', 'ere', 'fgsdf', 'dfg', '', '', '3', 22),
(8, 'เกิดความรู้สึกไปเอง', 'เพราะในข้าวมีน้ำตาลปนอยู่', 'เพราะข้าวถูกเปลี่ยนไปเป็นน้ำตาล', 'ในปากมีเอนไซม์ที่มีความหวานอย่ในตัวแล้ว', '', '', '3', 23),
(9, 'กรดไขมัน', 'กรดอะมิโน', 'กลีเซอลอล', 'น้ำตาลมอลโทส', '', '', '2', 24),
(10, 'แป้ง  ภาวะเป็นกรด', 'โปรตีน  ภาวะเป็นเบส', 'โปรตีน  ภาวะเป็นกรด', 'โปรตีน  ภาวะเป็นกลาง', '', '', '3', 25),
(11, 'ไขมัน', 'โปรตีน', 'คาร์โบไฮเดรต', 'วิตามินและเกลือแร่', '', '', '1', 26),
(12, 'ปาก', 'ลำไส้ใหญ่', 'ลำไส้เล็กเล็ก', 'กระเพาะอาหาร', '', '', '3', 27),
(13, 'ใช่ เพราะมีอนุภาคขนาดเล็กมาก', 'ใช่ เพราะไม่มีอวัยวะช่วยย่อย', 'ไม่ใช่ เพราะต้องผ่านการย่อย', 'ไม่ใช่ เพราะต้องผ่านการย่อยที่ลำไส้เล็ก', '', '', '1', 28),
(14, 'ท้องผูก', 'ท้องอืด', 'ปวดท้องอุจจาระ', 'ปวดแสบที่ท้อง', '', '', '4', 29),
(15, 'ปาก กระเพาะ', 'กระเพาะ ลำไส้ใหญ่', 'ลำไส้เล็ก ลำไส้ใหญ่', 'กระเพาะ ลำไส้ใหญ่', '', '', '2', 30),
(16, 'ปาก', 'กระเพาะ', 'ลำไส้เล็ก', 'ลำไส้ใหญ่', '', '', '3', 31),
(17, 'ปาก  ลำไส้เล็ก', 'กระเพาะอาหาร  ตับอ่อน', 'ปาก  กระเพาะอาหาร  ลำไส้เล็ก', 'ปากหลอดอาหาร  กระเพาะอาหาร  ลำไส้เล็ก', '', '', '1', 32),
(18, 'รัทเทอร์ฟอร์ด', 'โบร์', 'ทอมสัน', 'ดอลตัน', '', '', '2', 33),
(19, '2n^2', '2n^3', '2n^5', '2n^7', '', '', '2', 34),
(20, '2', '8', '18', '32', '', '', '3', 35),
(21, '2  2  4', '2  4  5', '1  2  8', '2  8  1', '', '', '4', 36),
(22, '2  8  10', '2  8  8  2', '2  8  2  8', '2  8  9  1', '', '', '2', 37),
(23, 's p d f', 's p d y', 's d p f', 's d p y', '', '', '1', 38),
(24, '1s^0 2s^2', '1s^0 2s^1 2s^2', '1s^2 2s^1', '1s^1 2s^3', '', '', '3', 39),
(25, '1s^2 2s^2 2s^4', '1s^1 2s^2 3s^5', '1s^1 2s^2 2p^5', '1s^2 2s^2 2p^4', '', '', '4', 40),
(26, 'เวเลนซ์อิเล็กตรอน', 'โควาเลนซ์อิเล็กตรอน', 'โคออดิเนตอิเล็กตรอน', 'วาเลนซ์ชันอิเล็กตรอน', '', '', '1', 41),
(27, '2', '16', '18', '32', '', '', '4', 42),
(28, 'เงินทุน ต้นทุน', 'ลักษณะของลูกค้า', 'การแข่งขัน เงินทุน', 'การควบคุม การแข่งขัน', 'การแข่งขัน ลักษณะของลูกค้า', '', '1', 53),
(29, 'สามารถเปรียบเทียบราคาได้', 'ทำการ 24 ชั่วโมง', 'ราคาอาจถูกกว่าสำหรับสินค้าที่ไม่ผ่านพ่อค้าคนกลาง', 'ไม่แน่ใจในคุณภาพถ้าไม่ คุ้นเคยสินค้า', 'มีสินค้าและราคาให้เลือกมากมาย', '', '4', 54),
(30, 'การขนส่งทางเรือ (Ocean Liner)', 'การขนส่งทางอากาศ (Air Freight)', 'การขนส่งทางบก (In – Land Freight)', 'การขนส่งทางนก (Bird Transport)', 'การขนส่งทางตัวกลาง (Electronics)', '', '4', 55),
(31, 'ต้องใช้พนักงานในการผลิต', 'มีค่าจ้างที่สูงมาก', 'มีหลายขั้นตอน และเอกสารมีรายละเอียดที่ซับซ้อน', 'เพราะต้องใช้เวลานานมากในการผลิต', 'สร้างผลกำไรให้บริษัทได้สูง', '', '3', 56),
(32, 'Mexico', 'Italy', 'Turkey', 'Indonesia', 'Nigeria', '', '2', 57),
(33, 'Director of a computer company', 'Office manager', 'Computer programmer', 'College professor', '', '', '2', 58),
(34, 'A college degree', 'Less than two years experience', 'Telephone skills', 'Two or more years experience', '', '', '4', 59),
(35, 'White', 'All colors', 'Pink, purple,and gold', 'Red,blue, and black', '', '', '1', 60),
(36, 'Pay one dollar', 'Spend 25 USD on computer paper', 'Buy colored envelopes', 'Buy five notebooks', '', '', '4', 61),
(37, 'All weekend', 'On Sunday only', 'All week', 'On Saturday only', '', '', '3', 62),
(38, '4,000', '4,500', '4,675', '5,000', '', '', '2', 63),
(39, 'March', 'April', 'May', 'June', '', '', '2', 64),
(40, 'March', 'April', 'May', 'June', '', '', '3', 65),
(41, 'In the office', 'At a conference', 'On vacation', 'At the XYZ Company', '', '', '2', 66),
(42, 'An  accountant', 'The writer of the memo', 'The owner of the XYZ Company', 'Brianna Herbert''s assistant', '', '', '4', 67),
(43, 'work with', 'call', 'touch', 'look at', '', '', '2', 68),
(44, 'All staff at the XYZ company', 'Brianna Herbert', 'People who work in the accounting department', 'Conference planners', '', '', '3', 69),
(45, 'สิ่งที่ให้พลังงานน้อย', 'สิ่งที่ไม่ให้พลังงาน', 'สารเคมีที่เป็นองค์ประกอบของอาหาร', 'สิ่งที่กินได้และก่อให้เกิดประโยชน์กับร่างกาย', '', '', '3', 70),
(46, 'หลังปฎิสนธิ', 'หลังอายุได้ 1 สัปดาห์', 'หลังจากที่ลืมตาได้', 'หลังจากคลอดจากครรภ์มารดา', '', '', '1', 71),
(47, 'การเดิน', 'การพูด', 'ลักษณะนิสัย', 'การขึ้นฟันแท้', '', '', '4', 72),
(48, 'วัยชรา', 'วัยรุ่น', 'วัยเด็ก', 'วัยทารก', '', '', '1', 73),
(49, 'กินอาหารมาก', 'งดกินอาหาร', 'ออกกำลังกาย', 'นั่งนิ่งๆ', '', '', '3', 74),
(50, 'นิดชอบเล่นคอมพิวเตอร์', 'ภูมิชอบเล่นกีฬา', 'ธิดาชอบอ่านหนังสือ', 'สุชาติชอบวาดภาพ', '', '', '2', 75),
(51, 'วิตามินบี 2', 'วิตามินบี 6', 'วิตามินดี', 'วิตามินซี', '', '', '3', 76),
(52, 'ข้าวเจ้า ข้าวเหนียว นมข้นหวาน', 'นมสด น้ำตาลทราย น้ำมันพืช', 'เนื้อปลา ข้าวเหนียว น้ำเต้าหู้', 'เนื้อหมู มันหมู ไขดาว', '', '', '1', 77),
(53, 'ขาดธาตุเหล็ก', 'ขาดธาตุไอโอดีน', 'ขาดธาตุแคลเซียม', 'ได้รับสารปรอทมาก', '', '', '2', 78),
(54, 'วิตามินและเกลือแร่', 'คาร์โบไฮเดรต', 'ไขมัน', 'โปรตีน', '', '', '4', 79),
(55, '1971', '1972', '1973', '1974', '', '', '3', 80),
(56, 'ซอง คุก ดี', 'ยนอง แมน รี', 'มุล ซู คิม', 'ซอง กี ยอง', '', '', '4', 81),
(57, 'เคารพพ่อแม่ ครูอาจารย์และผู้มีพระคุณ', 'อย่าทำร้ายผู้อื่น โดยไม่จำเป็น', 'กระทำตนให้ดีที่สุดอย่างสม่ำเสมอ', 'จงรักภักดีต่อประเทศชาติของตน', '', '', '3', 82),
(58, '10 X 10 ม.', '11 X 11 ม.', '12 X 12 ม.', '13 X 13 ม.', '', '', '3', 83),
(59, 'รุ่นเฟเธอร์เวท', 'รุ่นไลท์เวท', 'รุ่นเวลเธอร์เวท', 'รุ่นมิดเดิลเวท', '', '', '1', 84),
(60, 'รุ่นเฟเธอร์เวท', 'รุ่นไลท์เวท', 'รุ่นเวลเธอร์เวท', 'รุ่นมิดเดิลเวท', '', '', '3', 85),
(61, 'ผู้แข่งขัน เตะเข้าที่ลำตัว และล้มตัวลงทันที', 'ผู้แข่งขัน เตะเข้าที่ลำตัว และเข้ากอดทันที', 'ผู้แข่งขัน เตะเข้าที่ลำตัว และร้องดีใจที่เตะได้ทันที', 'ผู้แข่งขัน เตะเข้าที่ลำตัว โดยใช้หน้าแข้งเข้าเป้าดังสนั่น', '', '', '2', 86),
(62, 'ลำตัว หน้าท้อง', 'ลำตัว ชายโครง', 'ใบหน้า ด้านหน้า', 'ใบหน้า ด้านหลัง', '', '', '4', 87),
(63, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '4', 88),
(64, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '2', 89),
(65, 'Front Kick', 'Side Kick', 'Round House Kick', 'Chop Kick', '', '', '1', 90),
(66, 'การออกนอกเส้นสนามแข่งทั้งสองเท้าไม่ว่าด้วยกรณีใด ๆ', 'การล้มที่เกิดจากการต่อสู้', 'ไม่ทำการต่อสู้ภายใน 10 วินาที', 'การยกเข่าขึ้นบังหรือ Block การเตะของคู่ต่อสู้ด้วยเข่า', '', '', '2', 91),
(67, 'ขาว เหลือง ฟ้า เขียว น้ำตาล แดง ดำ', 'ขาว เหลือง เขียว น้ำตาล ฟ้า แดง ดำ', 'ขาว เหลือง เขียว ฟ้า น้ำตาล แดง ดำ', 'ขาว ฟ้า เขียว เหลือง แดง น้ำตาล ดำ', '', '', '3', 92),
(68, 'ดั้ง 3', 'ดั้ง 4', 'ดั้ง 5', 'ดั้ง 6', '', '', '2', 93),
(69, '7 ดั้ง', '8 ดั้ง', '9 ดั้ง', '10 ดั้ง', '', '', '4', 94),
(70, '3 คน', '4คน', '5 คน', '6 คน', '', '', '3', 95),
(71, 'โคยังมูล', 'เคียกพ่า', 'เคียวรูกิ', 'โฮชินซูล', '', '', '1', 96),
(72, 'Takkwon + Kongsoodo', 'Takkyon + Kongsondo', 'Takkwon + Kongsondo', 'Takkyon + Kongsoodo', '', '', '4', 97),
(73, 'ประเทศจีน', 'ประเทศญี่ปุ่น', 'ประเทศเกาหลี', 'ประเทศมองโกเลีย', '', '', '3', 98),
(74, 'เท - ควัน - โด', 'เท - ควอน - โด', 'แท - ควัน - โด', 'แท - ควอน - โด', '', '', '4', 99);

-- --------------------------------------------------------

--
-- Stand-in structure for view `question_detail_list`
--
CREATE TABLE IF NOT EXISTS `question_detail_list` (
`paper_id` int(7)
,`part_id` int(7)
,`no` tinyint(3)
,`question_id` int(10)
,`question` text
,`type` varchar(10)
,`status` varchar(10)
,`chapter_id` int(7)
,`created_by` varchar(100)
,`created_time` datetime
,`choice1` text
,`choice2` text
,`choice3` text
,`choice4` text
,`choice5` text
,`choice6` text
,`answer_choice` varchar(20)
,`answer_numeric` varchar(20)
,`answer_boolean` varchar(20)
,`chapter_name` varchar(60)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `question_list`
--
CREATE TABLE IF NOT EXISTS `question_list` (
`question_id` int(10)
,`question` text
,`type` varchar(10)
,`status` varchar(10)
,`chapter_id` int(7)
,`created_by` varchar(100)
,`created_time` datetime
,`choice1` text
,`choice2` text
,`choice3` text
,`choice4` text
,`choice5` text
,`choice6` text
,`answer_choice` varchar(20)
,`answer_numeric` varchar(20)
,`answer_boolean` varchar(20)
,`chapter_name` varchar(60)
);
-- --------------------------------------------------------

--
-- Table structure for table `Question_numerical`
--

CREATE TABLE IF NOT EXISTS `Question_numerical` (
`id` int(10) NOT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Question_numerical`
--

INSERT INTO `Question_numerical` (`id`, `answer`, `question_id`) VALUES
(1, '2010', 1),
(2, '4', 8),
(3, '2', 11),
(4, '4234234', 13),
(5, '29311', 15),
(6, '22222', 18),
(7, '3', 21);

-- --------------------------------------------------------

--
-- Stand-in structure for view `report_courses`
--
CREATE TABLE IF NOT EXISTS `report_courses` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`name` varchar(60)
,`shortname` varchar(15)
,`description` text
,`visible` tinyint(1)
,`status` varchar(20)
,`examcount` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `report_course_calc`
--
CREATE TABLE IF NOT EXISTS `report_course_calc` (
`course_id` int(4)
,`subject_id` int(5)
,`code` varchar(10)
,`year` varchar(4)
,`subjectname` varchar(60)
,`shortname` varchar(15)
,`papername` varchar(70)
,`starttime` datetime
,`endtime` datetime
,`visible` tinyint(1)
,`status` varchar(20)
,`paper_id` int(7)
,`enrollcount` int(10)
,`testedcount` bigint(21)
,`average` double
,`minimum` float
,`maximum` float
);
-- --------------------------------------------------------

--
-- Table structure for table `Scoreboard`
--

CREATE TABLE IF NOT EXISTS `Scoreboard` (
`sco_id` int(6) NOT NULL,
  `stu_id` int(10) NOT NULL,
  `course_id` int(4) NOT NULL,
  `paper_id` int(7) NOT NULL,
  `Score` float DEFAULT NULL,
  `Max` float DEFAULT NULL,
  `Min` float DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `Scoreboard`
--

INSERT INTO `Scoreboard` (`sco_id`, `stu_id`, `course_id`, `paper_id`, `Score`, `Max`, `Min`) VALUES
(1, 54310104, 2, 6, 5, NULL, NULL),
(2, 54310104, 4, 9, 8, NULL, NULL),
(3, 54310104, 5, 10, 5, NULL, NULL),
(4, 54311095, 6, 11, 13, NULL, NULL),
(5, 54311095, 5, 10, 7, NULL, NULL),
(6, 54311095, 4, 9, 7, NULL, NULL),
(7, 54311095, 2, 6, 3, NULL, NULL),
(8, 54311095, 2, 7, 4, NULL, NULL),
(9, 57700188, 6, 11, 8, NULL, NULL),
(10, 57700188, 1, 1, 4, NULL, NULL),
(11, 57700188, 4, 9, 6, NULL, NULL),
(12, 57700189, 6, 11, 12, NULL, NULL),
(13, 57700189, 4, 9, 4, NULL, NULL),
(14, 57700190, 4, 9, 4, NULL, NULL),
(15, 54310104, 4, 13, 6, NULL, NULL),
(16, 54311095, 8, 15, 9, NULL, NULL),
(17, 57700192, 4, 13, 5, NULL, NULL),
(18, 57700196, 4, 13, 2, NULL, NULL),
(19, 57700193, 6, 11, 7, NULL, NULL),
(20, 54310104, 6, 11, 0, NULL, NULL);

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
  `pic` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`stu_id`, `id`, `title`, `name`, `lname`, `birth`, `gender`, `idcard`, `year`, `fac_id`, `branch_id`, `email`, `pic`) VALUES
('54310104', 2, 'นาย', 'นรภัทร', 'นิ่มมณี', '1992-09-14', 'male', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศ', 'charge_n@hotmail.com', NULL),
('54311095', 63, 'นางสาว', 'นลินนิภา', 'โพธิ์มี', '1992-12-02', 'female', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', 'nalinnipa.pm@gmail.com', NULL),
('57700188', 36, 'นาย', 'ธรลักษณ์', 'แก้วดี', NULL, 'male', '5770000000188', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700189', 37, 'นาย', 'นามเหมือน', 'แก้วทอง', NULL, 'male', '5770000000189', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700190', 38, 'นาย', 'นามไม่เหมือน', 'แก้วเงิน', NULL, 'male', '5770000000190', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700191', 39, 'นาย', 'สายชลดี', 'ภาพุ', NULL, 'male', '5770000000191', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('57700192', 40, 'นางสาว', 'พา', 'หากเหมือน', NULL, 'female', '5770000000192', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700193', 41, 'นาย', 'ขำ', 'ไม่เหมือน', NULL, 'male', '5770000000193', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700194', 42, 'นาย', 'ชายกลาง', 'ลาภผล', NULL, 'male', '5770000000194', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700195', 43, 'นางสาว', 'หญิง', 'ประสบ', NULL, 'female', '5770000000195', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700196', 44, 'นาย', 'มีมาก', 'เชิงชาย', NULL, 'male', '5770000000196', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('57700197', 45, 'นาย', 'ขม', 'สามผล', NULL, 'male', '5770000000197', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700198', 46, 'นางสาว', 'วลัยพร', 'นามมี', NULL, 'female', '5770000000198', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700199', 47, 'นางสาว', 'วาสนา', 'สวาดี', NULL, 'female', '5770000000199', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('57700200', 48, 'นาย', 'มั่นคง', 'กิมจอง', NULL, 'male', '5770000000200', 2014, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('58700101', 50, 'นาย', 'สมพงษ์', 'อยู่รอด', NULL, 'male', '1190704545660', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700105', 51, 'นาย', 'องอาจ', 'มานะศิล', NULL, 'male', '1154369903444', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700112', 52, 'นาย', 'พงศกร', 'งามเหลือ', NULL, 'male', '1145777764432', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700115', 53, 'นาย', 'กิตติชนม์', 'ไพศาลพานิช', NULL, 'male', '1188455446477', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางคอมพิวเตอร์', NULL, NULL),
('58700120', 54, 'นางสาว', 'ศศิกาญ', 'ไพโรจน์กิจ', NULL, 'female', '1178765643090', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700121', 55, 'นาย', 'นพรุจ', 'สานแก้วค้า', NULL, 'male', '1199966744325', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700127', 56, 'นาย', 'กิตตินัน', 'มากล้ำ', NULL, 'male', '1178890000756', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'โลจิสติกและการค้าชายแดน', NULL, NULL),
('58700133', 57, 'นางสาว', 'บวรลักษณ์', 'จิตรงาม', NULL, 'female', '1111445470034', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('58700135', 58, 'นาย', 'ทวี', 'หอมหวน', NULL, 'male', '1163222789007', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'ระบบสารสนเทศทางธุรกิจ', NULL, NULL),
('58700140', 59, 'นาย', 'ตะวัน', 'พานทอง', NULL, 'male', '1154367753409', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'เทคโนโลยีการเกษตร', NULL, NULL),
('58700141', 60, 'นางสาว', 'พรกัญญา', 'กิจมานะ', NULL, 'female', '1145556094556', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'เทคโนโลยีการเกษตร', NULL, NULL),
('58700156', 61, 'นางสาว', 'วาสนา', 'สวาดี', NULL, 'female', '1115570934226', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL),
('58700157', 62, 'นาย', 'ติณนภพ', 'ณ อยุธา', NULL, 'male', '1110009226543', 2015, 'คณะวิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Student_Enroll`
--

CREATE TABLE IF NOT EXISTS `Student_Enroll` (
  `stu_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `group_id` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Student_Enroll`
--

INSERT INTO `Student_Enroll` (`stu_id`, `course_id`, `group_id`) VALUES
('54310104', '1', 1),
('54310104', '2', 11),
('54310104', '4', 12),
('54310104', '5', 13),
('54310104', '6', 14),
('54310104', '7', 16),
('54311095', '2', 11),
('54311095', '4', 12),
('54311095', '5', 13),
('54311095', '6', 14),
('54311095', '7', 16),
('54311095', '8', 17),
('57700188', '1', 1),
('57700188', '4', 12),
('57700188', '6', 14),
('57700188', '7', 15),
('57700189', '4', 12),
('57700189', '6', 14),
('57700190', '4', 12),
('57700191', '4', 12),
('57700191', '7', 15),
('57700192', '4', 12),
('57700192', '5', 13),
('57700192', '8', 17),
('57700193', '4', 12),
('57700193', '6', 14),
('57700193', '7', 16),
('57700194', '1', 9),
('57700194', '4', 12),
('57700194', '6', 14),
('57700195', '4', 12),
('57700196', '4', 12),
('57700196', '5', 13),
('57700196', '7', 15),
('57700196', '8', 17),
('57700197', '1', 9),
('57700197', '4', 12),
('57700198', '4', 12),
('57700198', '5', 13),
('57700198', '7', 15),
('57700199', '4', 12),
('57700199', '7', 16),
('57700200', '4', 12),
('57700200', '5', 13),
('57700200', '7', 16),
('58700101', '4', 12),
('58700101', '5', 13),
('58700101', '7', 16),
('58700105', '4', 12),
('58700105', '5', 13),
('58700105', '7', 16),
('58700112', '4', 12),
('58700115', '4', 12),
('58700115', '5', 13),
('58700115', '6', 14),
('58700120', '4', 12),
('58700120', '7', 15),
('58700121', '4', 12),
('58700121', '6', 14),
('58700121', '7', 15),
('58700127', '1', 9),
('58700127', '4', 12),
('58700127', '7', 16),
('58700133', '4', 12),
('58700133', '6', 14),
('58700133', '7', 15),
('58700135', '1', 1),
('58700135', '4', 12),
('58700135', '6', 14),
('58700135', '7', 15),
('58700140', '1', 1),
('58700140', '4', 12),
('58700140', '6', 14),
('58700140', '7', 16),
('58700141', '4', 12),
('58700141', '5', 13),
('58700156', '4', 12),
('58700157', '1', 9),
('58700157', '4', 12),
('58700157', '6', 14);

-- --------------------------------------------------------

--
-- Table structure for table `Student_Group_Paper`
--

CREATE TABLE IF NOT EXISTS `Student_Group_Paper` (
  `group_id` int(6) NOT NULL,
  `paper_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Student_Group_Paper`
--

INSERT INTO `Student_Group_Paper` (`group_id`, `paper_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Subjects`
--

CREATE TABLE IF NOT EXISTS `Subjects` (
`subject_id` int(5) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `shortname` varchar(15) NOT NULL,
  `description` text,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`subject_id`, `code`, `name`, `shortname`, `description`, `status`) VALUES
(1, '291311', 'IT Consultancy Method', 'ITCM', '<p>เครือข่ายทางธุรกิจขนาดเล็ก รวมถึงเครือข่ายไร้สาย การติดตั้งเราเตอร์และไฟร์วอล การสร้างเว็บไซต์ พาณิชย์อิเล็กทรอนิกส์ ความปลอดภัยของข้อมูล รวมถึงวิธีการสำรองข้อมูลและการกู้คืนข้อมูลที่เสียหาย ซอฟต์แวร์ต่างๆ เช่น โปรแกรมฐานข้อมูลและโปรแกรมการจัดการความสัมพันธ์กับลูกค้า เทคนิคทางธุรกิจที่เกี่ยวข้องกับการให้คำปรึกษาทางด้านธุรกิจ และลูกค้าสัมพันธ์ รวมไปถึง กฎหมายและหลักจริยธรรมที่เกี่ยวข้องกับการให้คำปรึกษาด้านระบบสารสนเทศ</p>\n', 'active'),
(2, '291436', 'Object-Oriented Programming', 'OOP', 'ความเป็นมาของการเขียนโปรแกรมเชิงวัตถุ แนวคิดโปรแกรมเชิงวัตถุ คลาส ออปเจก และองค์ประกอบต่างๆ ของออปเจก วงจรชีวิตวัตถุ การสืบทอดคุณสมบัติ โพลีมอร์ฟิซึม การนำคลาสมาใช้งาน เหตุการณ์ต่างๆ ที่ใช้กับวัตถุ การใช้เอพีไอ การเชื่อมต่อฐานข้อมูล การจัดการความผิดปกติโดย Exception ภาคปฏิบัติใช้โปรแกรมเครื่องมือช่วยพัฒนาเพื่อทดลองเขียนโปรแกรมเชิงวัตถุประยุกต์ใช้ในงานธุรกิจ ด้วยภาษาที่กำหนด', 'active'),
(3, '291472', 'Special Project 1', 'SP1', 'โครงงานปฏิบัติเพื่อการวิเคราะห์และออกแบบระบบงานคอมพิวเตอร์เพื่อช่วยแก้ปัญหาทางธุรกิจต่างๆ ที่น่าสนใจ และได้รับความเห็นชอบของอาจารย์ที่ปรึกษา โดยมุ่งเน้นให้นักศึกษาสามารถวิเคราะห์ปัญหาเพื่อจัดทำเป็นข้อกำหนดรายละเอียดซอฟต์แวร์ที่สามารถนำไปสู่การสร้างซอฟต์แวร์ทางธุรกิจได้', 'active'),
(4, '291303', 'System Analysis and Design', 'SAD', 'แนวคิดระบบสารสนเทศและประเภทของระบบสารสนเทศในองค์การธุรกิจ วงจรการพัฒนาระบบ ระเบียบวิธีการ เครื่องมือในการวิเคราะห์ระบบ ผังงานระบบ ตารางการตัดสินใจ การกำหนดปัญหาและการศึกษาความเป็นไปได้ของระบบ การวิเคราะห์ความคุ้มค่าในการลงทุน การออกแบบข้อมูลนำเข้า การออกแบบการแสดงผลลัพธ์ของระบบ การออกแบบฐานข้อมูล การออกแบบกระบวนการประมวลผลระบบ และการจัดทำเอกสารคู่มือระบบ', 'active'),
(5, '1234', '1234n', 'ssss', '<h1><span style="background-color:rgb(255,255,0);"><strong>คำอธิบายวิชา ของ บลาๆๆๆ</strong></span></h1>\n\n<p><img alt="User Image" src="http://localhost/oxproject/img/avatar3.png" style="height:45px;width:45px;" /></p>\n\n<p>รูปภาพ</p>\n', 'active'),
(6, 'Sci32101', 'วิทยาศาสตร(พื้นฐาน)', 'Sci', '<p>ศึกษา วิเคราะห์ สำรวจ สืบค้นข้อมูล และอธิบายโครงสร้างและการทำงานของระบบย่อยอาหาร ระบบหมุนเวียนเลือด ระบบหายใจ  ระบบขับถ่าย ระบบสืบพันธุ์ ของมนุษย์และสัตว์ รวมทั้งระบบประสาทของมนุษย์   ความสัมพันธ์ของระบบต่าง ๆ ของมนุษย์ พฤติกรรมของมนุษย์และสัตว์ที่ตอบสนองต่อสิ่งเร้าภายนอกและภายใน หลักการและผลของการใช้เทคโนโลยีชีวภาพในการขยายพันธุ์ ปรับปรุงพันธุ์ และเพิ่มผลผลิตของสัตว์ สารอาหารในอาหารมีปริมาณพลังงานและสัดส่วนที่เหมาะสมกับเพศและวัย ผลของสารเสพติดต่อระบบต่าง ๆ ของร่างกาย เพื่อให้ให้ผู้เรียนเกิดความรู้ ความคิด ความเข้าใจ สามารถสื่อสารสิ่งที่เรียนรู้ และนำความรู้ไปใช้ประโยชน์ในการดำรงชีวิตและดูแลสิ่งแวดล้อม มีคุณธรรม จริยธรรม ค่านิยมที่เหมาะสม และเข้าใจว่าวิทยาศาสตร์ เทคโนโลยี สังคม และสิ่งแวดล้อมเกี่ยวข้องสัมพันธ์กัน</p>\n', 'active'),
(7, 'Sci30221', 'วิทยาศาสตร์(เพิ่มเติม)', 'Sci.p', '<p>วิเคราะห์และอธิบายโครงสร้างอะตอมและลักษณะนิวเคลียร์ของธาตุ การจัดเรียงอิเล็กตรอนในอะตอม ความสัมพันธ์ระหว่างอิเล็กตรอนในระดับพลังงานนอกสุดกับสมบัติของธาตุและการเกิดปฏิกิริยา การทำนายแนวโน้มสมบัติของธาตุในตารางธาตุ รวมถึงการเกิดพันธะเคมีในโครงผลึกและโมเลกุลของสาร โดยใช้กระบวนการทางวิทยาศาสตร์ เพื่อให้นักเรียนรักการเรียนรู้วิทยาศาสตร์ และเทคโนโลยี มีทักษะ กระบวนการทางวิทยาศาสตร์ เกิดความรู้ ความเข้าใจและนำความรู้ไปใช้ในชีวิตประจำวัน มีจิตวิทยาศาสตร์ จริยธรรมคุณธรรม และค่านิยมที่เหมาะสม</p>\n', 'active'),
(8, '276371', 'Global marketing', 'GM', '<p>บทบาทของการตลาดระดับโลกต่อการแข่งขันทางธุรกิจ ทฤษฎีการค้าระหว่างประเทศ สภาพแวดล้อมและสถาบันสำคัญทางการตลาดระดับโลก โครงสร้างและข้อมูลประชากรของตลาดโลก วัฒนธรรมและพฤติกรรมของผู้บริโภคในตลาดโลก กลยุทธ์การตลาดระดับโลกและการสร้างข้อได้เปรียบทางการแข่งขัน การกำหนดส่วนประสมทางการตลาดระดับโลก การจัดสายงานและการควบคุมกิจกรรมการตลาดโลก ประเด็นทางการตลาดระดับโลกที่เกี่ยวเนื่องกับจริยธรรมในการดำเนินธุรกิจ</p>\n', 'active'),
(9, '271232', 'English for Standardized Tests', 'TOEIC', '<p>Language patterns, test structures, grammar and vocabularies, reading excerpts, conversation styles and dialogues, and statements, commonly used in standardized tests</p>\n', 'active'),
(10, 'TkD22476', 'สุขศึกษาและพลศึกษา', 'HEMB', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE IF NOT EXISTS `Teachers` (
`tea_id` int(10) NOT NULL,
  `id` int(8) NOT NULL,
  `name` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `pic` varchar(40) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`tea_id`, `id`, `name`, `lname`, `fac_id`, `email`, `pic`) VALUES
(1, 4, 'ดร.สมบัติ', 'ฝอยทอง', 'วิทยาศาสตร์และศิลปศาสตร์', 'sombut@buu.ac.th', NULL),
(2, 3, 'อ.อุไรวรรณ', 'บัวตูม', 'วิทยาศาสตร์และศิลปศาสตร์', 'uraiwanu@buu.ac.th', NULL),
(3, 8, 'อ.ธารารัตน์', 'พวงสุวรรณ', 'วิทยาศาสตร์และศิลปศาสตร์', '', NULL),
(4, 9, 'อ.อรวรรณ', 'จิตะกาญจน์', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL),
(5, 64, 'สิทธิณี', 'ประภัศร', '0', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Teacher_Course_Detail`
--

CREATE TABLE IF NOT EXISTS `Teacher_Course_Detail` (
  `tea_id` int(10) NOT NULL,
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Teacher_Course_Detail`
--

INSERT INTO `Teacher_Course_Detail` (`tea_id`, `course_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 8),
(2, 2),
(3, 1),
(5, 4),
(5, 5),
(5, 6),
(5, 7);

-- --------------------------------------------------------

--
-- Stand-in structure for view `upcomingtest`
--
CREATE TABLE IF NOT EXISTS `upcomingtest` (
`stu_id` varchar(10)
,`group_id` int(6)
,`paper_id` int(7)
,`course_id` varchar(10)
,`papertitle` varchar(70)
,`paperdesc` text
,`rules` text
,`starttime` datetime
,`endtime` datetime
,`subject_id` int(5)
,`code` varchar(10)
,`subjectname` varchar(60)
,`shortname` varchar(15)
,`subjectdesc` varchar(60)
,`status` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(8) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=65 ;

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
(36, '57700188', '65350653c9baf66a82bd3eff3719e59c', 'student', 'active'),
(37, '57700189', '0d4a6549dcb0ee35ecb006d7f88a8b2d', 'student', 'active'),
(38, '57700190', '950e657b21be908c22477b92a55b362d', 'student', 'active'),
(39, '57700191', '281c939e1a1effb80020d274e3081c5c', 'student', 'active'),
(40, '57700192', 'ca2ce83788f3b73b90438e3de06897a2', 'student', 'active'),
(41, '57700193', '7a727f46360a98be4658156ace52d893', 'student', 'active'),
(42, '57700194', '3d9386dd7bc38e0420fd406f260e62aa', 'student', 'active'),
(43, '57700195', 'e26414761bb8fc0b74b0c1c423bcfd87', 'student', 'active'),
(44, '57700196', '6bf3de8a868cddc20513157179248624', 'student', 'active'),
(45, '57700197', 'add7099ea46b393dbcea34a0d59b3826', 'student', 'active'),
(46, '57700198', 'e597b2bc6e556a570aa57dc8c9504341', 'student', 'active'),
(47, '57700199', 'b2e894fca115093e29131568c984a574', 'student', 'active'),
(48, '57700200', '9a16c63a88acdda4057bd1516ace2d4f', 'student', 'active'),
(50, '58700101', '67d2ce973dfe2aec3279d8e957cce9f9', 'student', 'active'),
(51, '58700105', '9e5433b81ee5c5912cfe934b84b74e73', 'student', 'active'),
(52, '58700112', '341f4eb75f1a53e1f6ddcc470f933e70', 'student', 'active'),
(53, '58700115', 'd1bdc133b4784098c686b0c5ca1ea00d', 'student', 'active'),
(54, '58700120', '1cc25c938d648d6e4fda4775c17413e0', 'student', 'active'),
(55, '58700121', '9c51a68150d03bb11b475fc0973cd373', 'student', 'active'),
(56, '58700127', '3a302f28028a573242054324089dc0ce', 'student', 'active'),
(57, '58700133', '6592a2ca0cb86cdf8dcb15d9b5c7b0c3', 'student', 'active'),
(58, '58700135', '3157f62f08435873f5e609a8b516e9e8', 'student', 'active'),
(59, '58700140', '6e83bbdf1dad2c7afbc730a9a3f19609', 'student', 'active'),
(60, '58700141', 'c0064bb3ef67639fb47b1d3632242c02', 'student', 'active'),
(61, '58700156', '3b66eb863d7180d06c9bdca6e41e2981', 'student', 'active'),
(62, '58700157', '97648f4805e0f8fdcd68eeb44cd08056', 'student', 'active'),
(63, '54311095', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active'),
(64, 'sittinee', 'b59c67bf196a4758191e42f76670ceba', 'teacher', 'active');

-- --------------------------------------------------------

--
-- Structure for view `coursesbystudents`
--
DROP TABLE IF EXISTS `coursesbystudents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `coursesbystudents` AS select `se`.`stu_id` AS `stu_id`,`c`.`course_id` AS `course_id`,`s`.`subject_id` AS `subject_id`,`se`.`group_id` AS `group_id`,`c`.`year` AS `year`,`c`.`visible` AS `visible`,`c`.`status` AS `status`,`s`.`code` AS `code`,`s`.`name` AS `name`,`s`.`shortname` AS `shortname`,`s`.`description` AS `description` from ((`student_enroll` `se` left join `courses` `c` on((`se`.`course_id` = `c`.`course_id`))) left join `subjects` `s` on((`s`.`subject_id` = `c`.`subject_id`)));

-- --------------------------------------------------------

--
-- Structure for view `courseslist_view`
--
DROP TABLE IF EXISTS `courseslist_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `courseslist_view` AS select `c`.`course_id` AS `course_id`,`s`.`subject_id` AS `subject_id`,`s`.`code` AS `code`,`c`.`year` AS `year`,`s`.`name` AS `name`,`s`.`shortname` AS `shortname`,`s`.`description` AS `description`,`c`.`visible` AS `visible`,`c`.`status` AS `status` from (`courses` `c` left join `subjects` `s` on((`c`.`subject_id` = `s`.`subject_id`)));

-- --------------------------------------------------------

--
-- Structure for view `question_detail_list`
--
DROP TABLE IF EXISTS `question_detail_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `question_detail_list` AS select `epd`.`paper_id` AS `paper_id`,`epd`.`part_id` AS `part_id`,`epd`.`no` AS `no`,`q`.`question_id` AS `question_id`,`q`.`question` AS `question`,`q`.`type` AS `type`,`q`.`status` AS `status`,`q`.`chapter_id` AS `chapter_id`,`q`.`created_by` AS `created_by`,`q`.`created_time` AS `created_time`,`q`.`choice1` AS `choice1`,`q`.`choice2` AS `choice2`,`q`.`choice3` AS `choice3`,`q`.`choice4` AS `choice4`,`q`.`choice5` AS `choice5`,`q`.`choice6` AS `choice6`,`q`.`answer_choice` AS `answer_choice`,`q`.`answer_numeric` AS `answer_numeric`,`q`.`answer_boolean` AS `answer_boolean`,`q`.`chapter_name` AS `chapter_name` from (`exam_papers_detail` `epd` left join `question_list` `q` on((`epd`.`question_id` = `q`.`question_id`))) order by `epd`.`paper_id`,`epd`.`part_id`,`epd`.`no`;

-- --------------------------------------------------------

--
-- Structure for view `question_list`
--
DROP TABLE IF EXISTS `question_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `question_list` AS select `q`.`question_id` AS `question_id`,`q`.`question` AS `question`,`q`.`type` AS `type`,`q`.`status` AS `status`,`q`.`chapter_id` AS `chapter_id`,`getNameFromUid`(`q`.`created_by_id`) AS `created_by`,`q`.`created_time` AS `created_time`,`qc`.`choice1` AS `choice1`,`qc`.`choice2` AS `choice2`,`qc`.`choice3` AS `choice3`,`qc`.`choice4` AS `choice4`,`qc`.`choice5` AS `choice5`,`qc`.`choice6` AS `choice6`,`qc`.`answer` AS `answer_choice`,`qn`.`answer` AS `answer_numeric`,`qb`.`answer` AS `answer_boolean`,`ch`.`name` AS `chapter_name` from ((((`questions` `q` left join `question_choice` `qc` on((`q`.`question_id` = `qc`.`question_id`))) left join `question_numerical` `qn` on((`q`.`question_id` = `qn`.`question_id`))) left join `question_boolean` `qb` on((`q`.`question_id` = `qb`.`question_id`))) left join `chapter` `ch` on((`q`.`chapter_id` = `ch`.`chapter_id`)));

-- --------------------------------------------------------

--
-- Structure for view `report_courses`
--
DROP TABLE IF EXISTS `report_courses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report_courses` AS select `cv`.`course_id` AS `course_id`,`cv`.`subject_id` AS `subject_id`,`cv`.`code` AS `code`,`cv`.`year` AS `year`,`cv`.`name` AS `name`,`cv`.`shortname` AS `shortname`,`cv`.`description` AS `description`,`cv`.`visible` AS `visible`,`cv`.`status` AS `status`,count(`ep`.`course_id`) AS `examcount` from (`courseslist_view` `cv` left join `exam_papers` `ep` on((`cv`.`course_id` = `ep`.`course_id`))) group by `cv`.`course_id`;

-- --------------------------------------------------------

--
-- Structure for view `report_course_calc`
--
DROP TABLE IF EXISTS `report_course_calc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report_course_calc` AS select `c`.`course_id` AS `course_id`,`c`.`subject_id` AS `subject_id`,`c`.`code` AS `code`,`c`.`year` AS `year`,`c`.`name` AS `subjectname`,`c`.`shortname` AS `shortname`,`ep`.`title` AS `papername`,`ep`.`starttime` AS `starttime`,`ep`.`endtime` AS `endtime`,`c`.`visible` AS `visible`,`c`.`status` AS `status`,`s`.`paper_id` AS `paper_id`,`getEnrollCount`(`c`.`course_id`) AS `enrollcount`,count(`s`.`stu_id`) AS `testedcount`,avg(`s`.`Score`) AS `average`,min(`s`.`Score`) AS `minimum`,max(`s`.`Score`) AS `maximum` from ((`courseslist_view` `c` left join `scoreboard` `s` on((`c`.`course_id` = `s`.`course_id`))) left join `exam_papers` `ep` on((`s`.`paper_id` = `ep`.`paper_id`))) group by `s`.`course_id` order by `c`.`code`;

-- --------------------------------------------------------

--
-- Structure for view `upcomingtest`
--
DROP TABLE IF EXISTS `upcomingtest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `upcomingtest` AS select `se`.`stu_id` AS `stu_id`,`se`.`group_id` AS `group_id`,`ep`.`paper_id` AS `paper_id`,`se`.`course_id` AS `course_id`,`ep`.`title` AS `papertitle`,`ep`.`description` AS `paperdesc`,`ep`.`rules` AS `rules`,`ep`.`starttime` AS `starttime`,`ep`.`endtime` AS `endtime`,`s`.`subject_id` AS `subject_id`,`s`.`code` AS `code`,`s`.`name` AS `subjectname`,`s`.`shortname` AS `shortname`,`s`.`name` AS `subjectdesc`,`ep`.`status` AS `status` from ((`student_enroll` `se` left join `exam_papers` `ep` on((`se`.`course_id` = `ep`.`course_id`))) left join `subjects` `s` on((`s`.`subject_id` = `getSubjectIdFromCourseId`(`se`.`course_id`)))) where (`ep`.`endtime` >= now());

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Answer_Papers`
--
ALTER TABLE `Answer_Papers`
 ADD PRIMARY KEY (`question_id`,`sco_id`);

--
-- Indexes for table `Chapter`
--
ALTER TABLE `Chapter`
 ADD PRIMARY KEY (`chapter_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
 ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `Course_Students_group`
--
ALTER TABLE `Course_Students_group`
 ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `Exam_Papers`
--
ALTER TABLE `Exam_Papers`
 ADD PRIMARY KEY (`paper_id`);

--
-- Indexes for table `Exam_Papers_Detail`
--
ALTER TABLE `Exam_Papers_Detail`
 ADD PRIMARY KEY (`question_id`,`part_id`,`paper_id`);

--
-- Indexes for table `Exam_Papers_Parts`
--
ALTER TABLE `Exam_Papers_Parts`
 ADD PRIMARY KEY (`part_id`);

--
-- Indexes for table `Questions`
--
ALTER TABLE `Questions`
 ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `Question_boolean`
--
ALTER TABLE `Question_boolean`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Question_choice`
--
ALTER TABLE `Question_choice`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Question_numerical`
--
ALTER TABLE `Question_numerical`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Scoreboard`
--
ALTER TABLE `Scoreboard`
 ADD PRIMARY KEY (`sco_id`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
 ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `Student_Enroll`
--
ALTER TABLE `Student_Enroll`
 ADD PRIMARY KEY (`stu_id`,`course_id`);

--
-- Indexes for table `Student_Group_Paper`
--
ALTER TABLE `Student_Group_Paper`
 ADD PRIMARY KEY (`group_id`,`paper_id`);

--
-- Indexes for table `Subjects`
--
ALTER TABLE `Subjects`
 ADD PRIMARY KEY (`subject_id`), ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `Teachers`
--
ALTER TABLE `Teachers`
 ADD PRIMARY KEY (`tea_id`);

--
-- Indexes for table `Teacher_Course_Detail`
--
ALTER TABLE `Teacher_Course_Detail`
 ADD PRIMARY KEY (`tea_id`,`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Chapter`
--
ALTER TABLE `Chapter`
MODIFY `chapter_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
MODIFY `course_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Course_Students_group`
--
ALTER TABLE `Course_Students_group`
MODIFY `group_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `Exam_Papers`
--
ALTER TABLE `Exam_Papers`
MODIFY `paper_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `Exam_Papers_Parts`
--
ALTER TABLE `Exam_Papers_Parts`
MODIFY `part_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `Questions`
--
ALTER TABLE `Questions`
MODIFY `question_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `Question_boolean`
--
ALTER TABLE `Question_boolean`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `Question_choice`
--
ALTER TABLE `Question_choice`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `Question_numerical`
--
ALTER TABLE `Question_numerical`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Scoreboard`
--
ALTER TABLE `Scoreboard`
MODIFY `sco_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `Subjects`
--
ALTER TABLE `Subjects`
MODIFY `subject_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
MODIFY `tea_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
