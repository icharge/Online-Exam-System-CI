-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2014 at 03:17 PM
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
-- Table structure for table `Branch`
--

CREATE TABLE IF NOT EXISTS `Branch` (
`branch_id` int(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `fac_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Chapter`
--

CREATE TABLE IF NOT EXISTS `Chapter` (
`chapter_id` int(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text,
  `subject_id` int(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=11 ;

--
-- Dumping data for table `Chapter`
--

INSERT INTO `Chapter` (`chapter_id`, `name`, `description`, `subject_id`) VALUES
(4, 'บทที่ 1', NULL, 1),
(5, 'บทที่ 2', NULL, 1),
(7, 'บทที่ 1 แนะนำ OOP', NULL, 2),
(8, 'บทที่ 2 Class', NULL, 2),
(9, 'บทที่ 3', NULL, 1),
(10, 'Chapter 1', NULL, 4);

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
('55321e3dbafe1f5f3141e083e6f10b4f', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) Ap', 1415797479, 'a:12:{s:9:"user_data";s:0:"";s:2:"id";s:1:"3";s:3:"uid";s:1:"2";s:8:"username";s:7:"uraiwan";s:8:"fullname";s:47:"อ.อุไรวรรณ บัวตูม";s:5:"fname";s:28:"อ.อุไรวรรณ";s:5:"lname";s:18:"บัวตูม";s:7:"faculty";N;s:4:"role";s:7:"teacher";s:6:"logged";b:1;s:16:"flash:old:noAnim";b:1;s:16:"flash:new:noAnim";b:1;}');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`course_id`, `year`, `pwd`, `visible`, `status`, `subject_id`) VALUES
(1, '2014', NULL, 1, 'active', 1),
(2, '2014', '12345', 1, 'inactive', 2),
(3, '2014', NULL, 0, 'inactive', 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `Course_Students_group`
--

INSERT INTO `Course_Students_group` (`group_id`, `name`, `description`, `course_id`) VALUES
(1, 'Sec 1', NULL, 1),
(9, 'Sec 2', 'กลุ่มเพิ่มเติม', 1),
(10, 'Group1', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Exam_Papers`
--

CREATE TABLE IF NOT EXISTS `Exam_Papers` (
`paper_id` int(7) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text,
  `rules` text,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `course_id` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Exam_Papers`
--

INSERT INTO `Exam_Papers` (`paper_id`, `title`, `description`, `rules`, `starttime`, `endtime`, `course_id`) VALUES
(1, 'สอบพื้นฐาน', 'สอบก่อนเรียน', 'ทำด้วยตนเอง ตามความเข้าใจ', '2014-10-03 09:00:00', '2014-10-03 09:30:00', 1),
(2, 'ชุด A', 'desc', 'r', '2014-10-14 22:06:00', '2014-10-14 22:06:00', 1),
(3, 'Final', 'ปลายภาค', 'ห้ามลอก', '2014-10-20 10:00:00', '2014-10-20 15:00:00', 1),
(4, 'ชุด B', 'บท 4', 'ห้ามลอก\nนำชีทเข้าไปได้', '2014-10-16 12:00:00', '2014-10-16 14:00:00', 1),
(5, 'สอบก่อนเรียน', '', '', '2014-10-23 15:30:00', '2014-10-23 15:45:00', 3),
(6, 'ชุด  ก', '', '', '2014-11-10 01:05:00', '2014-11-10 10:20:00', 2),
(7, 'ชุด ข', 'ไม่ซ้ำ ก', '', '2014-11-10 00:23:00', '2014-11-10 00:23:00', 2);

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
(1, 1, 1, 2),
(3, 1, 1, 4),
(4, 5, 6, 1),
(4, 7, 7, 1),
(5, 5, 6, 2),
(5, 7, 7, 2),
(6, 6, 6, 1),
(6, 7, 7, 1),
(7, 6, 6, 2),
(7, 7, 7, 2),
(8, 6, 6, 3),
(8, 7, 7, 3),
(9, 2, 1, 1),
(9, 4, 2, 1),
(10, 4, 2, 1),
(11, 1, 1, 3),
(12, 2, 1, 2),
(12, 4, 2, 2),
(13, 5, 6, 3),
(13, 7, 7, 3),
(15, 1, 1, 1),
(16, 4, 2, 1),
(18, 1, 1, 3),
(21, 4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Exam_Papers_Parts`
--

CREATE TABLE IF NOT EXISTS `Exam_Papers_Parts` (
`part_id` int(7) NOT NULL,
  `no` tinyint(3) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` text,
  `israndom` tinyint(1) NOT NULL,
  `paper_id` int(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Exam_Papers_Parts`
--

INSERT INTO `Exam_Papers_Parts` (`part_id`, `no`, `title`, `description`, `israndom`, `paper_id`) VALUES
(1, 1, 'ตอน 1', 'เลือกคำตอบที่ถูกต้อง', 0, 1),
(2, 2, 'ตอน 2', 'หาคำตอบจากโจทย์', 0, 1),
(3, 1, 'ตอนที่ 1', 'ทำความเข้าใจ', 0, 5),
(4, 1, 'Choice', '...', 0, 2),
(5, 2, 'ข้อตัวเลือก', 'เป็นตัวเลือก 4 ข้อ', 0, 6),
(6, 1, 'ตัวเลือกอัน2', '', 1, 6),
(7, 1, 'ตัวเลือก', '', 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Faculty`
--

CREATE TABLE IF NOT EXISTS `Faculty` (
`fac_id` int(4) NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` text
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `Questions`
--

INSERT INTO `Questions` (`question_id`, `question`, `type`, `status`, `created_time`, `chapter_id`, `created_by_id`) VALUES
(1, '<p><strong><span style="font-size:16px;">ปัจจุบัน Office เวอร์ชั่นอะไร ที่นิยมที่สุด</span></strong></p>', 'numeric', 'active', '2014-09-02 18:30:26', 4, 8),
(2, '<p>Test2</p>', 'choice', 'active', '2014-09-09 09:14:28', 4, 3),
(3, '<p>คำสั่ง <br /><span style="line-height:1.6em;">   echo "Hello World";<br />\nเป็นภาษาใด</span></p>', 'choice', 'active', '2014-09-15 12:23:25', 5, 8),
(4, '<p><span style="font-size:16px;"><u><strong>Method</strong></u> มีอีกชื่อเรียกหนึ่งว่าอะไร</span></p>', 'choice', 'active', '2014-09-17 19:41:24', 7, 3),
(5, '<p>VB.NET ถือเป็นการเขียนโปรแกรมแบบ OOP</p>', 'boolean', 'active', '2014-09-08 16:35:48', 7, 8),
(6, '<p><strong>Class</strong> ประกอบไปด้วย <strong>Attribute</strong> และ <strong>Method</strong>  <u><span style="color:#FF0000;">ไม่สามารถสืบทอดได้</span></u></p>', 'boolean', 'active', '2014-09-22 08:23:26', 8, 3),
(7, '<p><span style="font-size:22px;"><span style="font-family:''th sarabun new'', ''th sarabun psk'';">หากมี <strong>Method</strong>  <u>Run() </u> ใน <strong>Class</strong>  ต้องการให้เรียกใช้จากภายนอกได้  จะต้องกำหนด <span style="color:#FF0000;"><strong>Encapsulation</strong></span> อย่างไร</span></span></p>', 'choice', 'active', '2014-09-24 13:20:44', 8, 3),
(8, '<blockquote>\n<p>Class Fan {</p>\n\n<p>    private int speed;<br /><span style="line-height:1.6em;">    private double power</span><br /><span style="line-height:1.6em;">    private bool isSwing;</span><br /><span style="line-height:1.6em;">    public string name;</span><br /><span style="line-height:1.6em;">}</span></p>\n</blockquote>\n\n<p>จาก Class ดังกล่าว  มีการกำหนด  Attribute กี่ตัว  </p>', 'numeric', 'active', '2014-09-29 09:32:17', 8, 8),
(9, '<p>Drafting question</p>', 'boolean', 'active', '2014-09-22 09:48:18', 5, 3),
(10, '<p>Drafting 2</p>', 'choice', 'draft', '2014-10-01 15:20:10', 4, 3),
(11, '<p>Disabled question</p>', 'numeric', 'inactive', '2014-09-08 21:05:28', 4, 8),
(12, '<p>Trueeee</p>', 'boolean', 'active', '2014-09-08 21:09:05', 4, 8),
(13, '<p><strong>jhglkdjf;sldkfs;dkjfls;</strong></p>', 'numeric', 'active', '2014-09-09 15:38:00', 7, 8),
(14, '<p><em>dfkjs;ldkfjs;ldfsoduypofsdjo</em></p>', 'choice', 'active', '2014-10-02 13:58:53', 4, 8),
(15, '<p><span style="background-color:rgb(249,249,249);color:rgb(102,102,102);font-family:''source sans pro'', sans-serif;font-size:17px;">IT Consultancy Method</span></p>\n\n<p><font color="#666666" face="source sans pro, sans-serif"><span style="background-color:rgb(249,249,249);font-size:17px;">รหัสวิชาคืออะไร</span></font></p>', 'numeric', 'active', '2014-10-02 14:05:21', 4, 8),
(16, '<p><span style="font-size:18px;">ITITITITITITITIT</span></p>', 'boolean', 'active', '2014-10-02 14:07:00', 4, 8),
(17, '<p><strong>bfafrstjvghulkbjklinjkljkl</strong></p>', 'boolean', 'active', '2014-10-02 14:08:47', 4, 8),
(18, '<p><span style="color:#FF0000;"> bbcbcvxvcxvxccvxcvxcxcvxcv</span></p>', 'numeric', 'active', '2014-10-02 15:17:08', 4, 8),
(19, '<p><u>yrttewewerwe</u></p>', 'boolean', 'active', '2014-10-02 15:23:38', 4, 8),
(20, '<p>werwertertwertr</p>', 'boolean', 'active', '2014-10-02 15:32:12', 9, 8),
(21, '<p><span style="font-size:20px;">1+2 = ?</span></p>', 'numeric', 'active', '2014-10-09 20:43:29', 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `Question_boolean`
--

CREATE TABLE IF NOT EXISTS `Question_boolean` (
`id` int(10) NOT NULL,
  `answer` varchar(20) NOT NULL,
  `question_id` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

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
(8, 't', 20);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Question_choice`
--

INSERT INTO `Question_choice` (`id`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`, `choice6`, `answer`, `question_id`) VALUES
(1, 'aaaa', 'bbbb', 'cccc', 'dddd', '', '', '1', 2),
(2, 'HTML', 'C#.NET', 'PHP', 'MySQL', '', '', '3', 3),
(3, 'Public', 'Function', 'Attribute', 'ถูกทุกข้อ', '', '', '2', 4),
(4, 'Private', 'Public', 'Protected', 'Void', '', '', '2', 7),
(5, '5656', '7404', '', '', '', '', '2', 10),
(6, 'a', 'b', 'c', 'd', '', '', '1', 14);

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
,`chapter_name` varchar(30)
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
,`chapter_name` varchar(30)
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
('54311095', 63, '', 'นลินนิภา', 'โพธิ์มี', '1992-12-02', 'female', NULL, 2011, 'วิทยาศาสตร์และศิลปศาสตร์', 'บริหารธุรกิจ', 'nalinnipa.pm@gmail.com', NULL),
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
('54310104', '3', 10),
('54311095', '1', 1),
('54311095', '3', 10),
('57700194', '1', 9),
('57700197', '1', 9),
('58700127', '1', 9),
('58700157', '1', 9);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`subject_id`, `code`, `name`, `shortname`, `description`, `status`) VALUES
(1, '291311', 'IT Consultancy Method', 'ITCM', '<p>เครือข่ายทางธุรกิจขนาดเล็ก รวมถึงเครือข่ายไร้สาย การติดตั้งเราเตอร์และไฟร์วอล การสร้างเว็บไซต์ พาณิชย์อิเล็กทรอนิกส์ ความปลอดภัยของข้อมูล รวมถึงวิธีการสำรองข้อมูลและการกู้คืนข้อมูลที่เสียหาย ซอฟต์แวร์ต่างๆ เช่น โปรแกรมฐานข้อมูลและโปรแกรมการจัดการความสัมพันธ์กับลูกค้า เทคนิคทางธุรกิจที่เกี่ยวข้องกับการให้คำปรึกษาทางด้านธุรกิจ และลูกค้าสัมพันธ์ รวมไปถึง กฎหมายและหลักจริยธรรมที่เกี่ยวข้องกับการให้คำปรึกษาด้านระบบสารสนเทศ</p>\n', 'active'),
(2, '291436', 'Object-Oriented Programming', 'OOP', 'ความเป็นมาของการเขียนโปรแกรมเชิงวัตถุ แนวคิดโปรแกรมเชิงวัตถุ คลาส ออปเจก และองค์ประกอบต่างๆ ของออปเจก วงจรชีวิตวัตถุ การสืบทอดคุณสมบัติ โพลีมอร์ฟิซึม การนำคลาสมาใช้งาน เหตุการณ์ต่างๆ ที่ใช้กับวัตถุ การใช้เอพีไอ การเชื่อมต่อฐานข้อมูล การจัดการความผิดปกติโดย Exception ภาคปฏิบัติใช้โปรแกรมเครื่องมือช่วยพัฒนาเพื่อทดลองเขียนโปรแกรมเชิงวัตถุประยุกต์ใช้ในงานธุรกิจ ด้วยภาษาที่กำหนด', 'active'),
(3, '291472', 'Special Project 1', 'SP1', 'โครงงานปฏิบัติเพื่อการวิเคราะห์และออกแบบระบบงานคอมพิวเตอร์เพื่อช่วยแก้ปัญหาทางธุรกิจต่างๆ ที่น่าสนใจ และได้รับความเห็นชอบของอาจารย์ที่ปรึกษา โดยมุ่งเน้นให้นักศึกษาสามารถวิเคราะห์ปัญหาเพื่อจัดทำเป็นข้อกำหนดรายละเอียดซอฟต์แวร์ที่สามารถนำไปสู่การสร้างซอฟต์แวร์ทางธุรกิจได้', 'active'),
(4, '291303', 'System Analysis and Design', 'SAD', 'แนวคิดระบบสารสนเทศและประเภทของระบบสารสนเทศในองค์การธุรกิจ วงจรการพัฒนาระบบ ระเบียบวิธีการ เครื่องมือในการวิเคราะห์ระบบ ผังงานระบบ ตารางการตัดสินใจ การกำหนดปัญหาและการศึกษาความเป็นไปได้ของระบบ การวิเคราะห์ความคุ้มค่าในการลงทุน การออกแบบข้อมูลนำเข้า การออกแบบการแสดงผลลัพธ์ของระบบ การออกแบบฐานข้อมูล การออกแบบกระบวนการประมวลผลระบบ และการจัดทำเอกสารคู่มือระบบ', 'active'),
(5, '1234', '1234n', 'ssss', '<h1><span style="background-color:rgb(255,255,0);"><strong>คำอธิบายวิชา ของ บลาๆๆๆ</strong></span></h1>\n\n<p><img alt="User Image" src="http://localhost/oxproject/img/avatar3.png" style="height:45px;width:45px;" /></p>\n\n<p>รูปภาพ</p>\n', 'active');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`tea_id`, `id`, `name`, `lname`, `fac_id`, `email`, `pic`) VALUES
(1, 4, 'ดร.สมบัติ', 'ฝอยทอง', 'วิทยาศาสตร์และศิลปศาสตร์', 'sombut@buu.ac.th', NULL),
(2, 3, 'อ.อุไรวรรณ', 'บัวตูม', 'วิทยาศาสตร์และศิลปศาสตร์', 'ajuraiwan@buu.ac.th', NULL),
(3, 8, 'อ.ธารารัตน์', 'พวงสุวรรณ', 'วิทยาศาสตร์และศิลปศาสตร์', '', NULL),
(4, 9, 'อ.อรวรรณ', 'จิตะกาญจน์', 'วิทยาศาสตร์และศิลปศาสตร์', NULL, NULL);

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
(2, 2),
(3, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=64 ;

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
(63, '54311095', '81dc9bdb52d04dc20036dbd8313ed055', 'student', 'active');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `Branch`
--
ALTER TABLE `Branch`
 ADD PRIMARY KEY (`branch_id`);

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
-- Indexes for table `Faculty`
--
ALTER TABLE `Faculty`
 ADD PRIMARY KEY (`fac_id`);

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
-- AUTO_INCREMENT for table `Branch`
--
ALTER TABLE `Branch`
MODIFY `branch_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Chapter`
--
ALTER TABLE `Chapter`
MODIFY `chapter_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
MODIFY `course_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Course_Students_group`
--
ALTER TABLE `Course_Students_group`
MODIFY `group_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Exam_Papers`
--
ALTER TABLE `Exam_Papers`
MODIFY `paper_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Exam_Papers_Parts`
--
ALTER TABLE `Exam_Papers_Parts`
MODIFY `part_id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Faculty`
--
ALTER TABLE `Faculty`
MODIFY `fac_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Questions`
--
ALTER TABLE `Questions`
MODIFY `question_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `Question_boolean`
--
ALTER TABLE `Question_boolean`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Question_choice`
--
ALTER TABLE `Question_choice`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Question_numerical`
--
ALTER TABLE `Question_numerical`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Subjects`
--
ALTER TABLE `Subjects`
MODIFY `subject_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
MODIFY `tea_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
