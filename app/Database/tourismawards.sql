-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2022 at 10:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourismawards`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `prefix` varchar(255) NOT NULL COMMENT 'คำนำหน้า',
  `name` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `surname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `member_type` int(1) NOT NULL COMMENT 'ประเภทสมาชิก\r\n1.ผู้ประกอบการ\r\n2.เจ้าหน้าที่ ททท.\r\n3. คณะกรรมการ\r\n4. ผู้ดูแลระบบ',
  `award_type` int(1) NOT NULL COMMENT 'ประเภทการตัดสิน\r\n1.ประเภทแหล่งท่องเที่ยว (Attraction)\r\n2.ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)\r\n3.ประเภทที่พักนักท่องเที่ยว (Accommodation)\r\n4.ประเภทรายการนำเที่ยว (Tour Programmes)',
  `assessment_group` int(1) NOT NULL COMMENT 'กลุ่มการประเมิน\r\n1.ด้าน Tourism Excellence\r\n2.ด้าน Supporting Business & Marketing Factors\r\n3.ด้านความยั่งยืน (Responsibility)\r\n',
  `mobile` varchar(25) NOT NULL COMMENT 'เบอร์มือถือ',
  `email` varchar(255) NOT NULL COMMENT 'E-mail',
  `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `role_id` int(1) NOT NULL COMMENT 'สิทธิ์การใช้งาน',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `application_form`
--

CREATE TABLE `application_form` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NULL COMMENT 'รหัสแบบฟอร์ม',
  `year` varchar(4) NULL COMMENT 'ปี พ.ศ.',
  `application_type_id` int(11) NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
  `application_type_sub_id` int(11) NULL COMMENT 'สาขารางวัลย่อยเข้าร่วมประกวด',
  `definition_of_award` text NULL COMMENT 'นิยามรางวัลแต่ละประเภท',
  `highlights` text NULL COMMENT 'อธิบายจุดเด่นของผลงานที่ต้องการส่งเข้าประกวด',
  `link` varchar(255) NULL COMMENT 'ลิงค์เว็บไซต์ หรือ ลิงค์วีดีโอ',
  `attraction_name_th` varchar(255) NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (TH)',
  `attraction_name_en` varchar(255) NULL COMMENT 'ชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว (EN)',
  `address_no` varchar(50) NULL COMMENT 'ที่ตั้ง เลขที่',
  `address_road` varchar(255) NULL COMMENT 'ถนน',
  `address_sub_district` varchar(255) NULL COMMENT 'แขวง/ตำบล',
  `address_district` varchar(255) NULL COMMENT 'เขต/อำเภอ',
  `address_province` varchar(255) NULL COMMENT 'จังหวัด',
  `address_zipcode` int(5) NULL COMMENT 'รหัสไปรษณีย์',
  `facebook` varchar(255) NULL COMMENT 'Facebook',
  `instagram` varchar(255) NULL COMMENT 'Instagram',
  `line_id` varchar(255) NULL COMMENT 'Line ID',
  `other_social` varchar(255) NULL COMMENT 'โซเชียลมีเดียอื่นๆ',
  `company_name` varchar(255) NULL COMMENT 'ชื่อหน่วยงาน/บริษัท',
  `company_addr_no` varchar(50) NULL COMMENT 'เลขที่บริษัท',
  `company_addr_road` varchar(255) NULL COMMENT 'ถนน',
  `company_addr_sub_district` varchar(255) NULL COMMENT 'แขวง/ตำบล',
  `company_addr_district` varchar(255) NULL COMMENT 'เขต/อำเภอ',
  `company_addr_province` varchar(255) NULL COMMENT 'จังหวัด',
  `company_addr_zipcode` varchar(5) NULL COMMENT 'รหัสไปรษณีย์',
  `mobile` varchar(20) NULL COMMENT 'มือถือ',
  `email` varchar(255) NULL COMMENT 'E-Mail',
  `created_by` int(11) NOT NULL COMMENT 'ผู้สร้างเอกสาร',
  `updated_by` int(11) NOT NULL COMMENT 'ผู้แก้ไขเอกสาร',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'วันที่สร้าง',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันที่แก้ไข'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `application_type`
--

CREATE TABLE `application_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'ประเภทแบบฟอร์มการสมัคร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_type`
--

INSERT INTO `application_type` (`id`, `name`) VALUES
(1, 'ประเภทแหล่งท่องเที่ยว (Attraction)'),
(2, 'ประเภทที่พักนักท่องเที่ยว (Accommodation)'),
(3, 'ประเภทการท่องเที่ยวเชิงสุขภาพ (Health and Wellness Tourism)'),
(4, 'ประเภทรายการการนำเที่ยว');

-- --------------------------------------------------------

--
-- Table structure for table `application_type_sub`
--

CREATE TABLE `application_type_sub` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'ประเภทสาขารางวัลย่อยเข้าร่วมประกวด*',
  `application_type_id` int(11) NOT NULL COMMENT 'id ประเภทแบบฟอร์มการสมัคร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_type_sub`
--

INSERT INTO `application_type_sub` (`id`, `name`, `application_type_id`) VALUES
(1, 'สาขา Outdoor & Adventure Activities (แหล่งท่องเที่ยวเพื่อการผจญภัย)', 1),
(2, 'สาขา Learning & Doing (แหล่งท่องเที่ยวเพื่อการเรียนรู้)', 1),
(3, 'สาขา Nature & Park (แหล่งท่องเที่ยวธรรมชาติ)', 1),
(4, 'สาขา Recreation & Entertainment (แหล่งท่องเที่ยวนันทนาการและความบันเทิง)', 1),
(5, 'สาขา Historical & Culture (แหล่งท่องเที่ยวประวัติศาสตร์และวัฒนธรรม)', 1),
(6, 'สาขา Local & Community (แหล่งท่องเที่ยวชุมชน)', 1),
(7, 'สาขา Luxury Hotel (ลักซ์ชูรี โฮเทล)', 2),
(8, 'สาขา Location Hotel (โลเคชั่น โฮเทล)', 2),
(9, 'สาขา Resort (รีสอร์ต)', 2),
(10, 'สาขา Design Hotel (ดีไซน์ โฮเทล)', 2),
(11, 'สาขา Spa (สปา)', 3),
(12, 'สาขา Wellness Retreat (เวลเนส รีทรีต)', 3),
(13, 'นวดไทย', 3);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL COMMENT 'รหัสแบบฟอร์มการประเมิน',
  `year` int(4) NOT NULL COMMENT 'ปี พ.ศ.',
  `application_type_id` int(11) NOT NULL COMMENT 'ประเภทการประกวด',
  `application_type_sub_id` int(11) NOT NULL COMMENT 'ประเภทสาขารางวัลย่อยเข้าร่วมประกวด*',
  `criteria_topic` text NOT NULL COMMENT 'หัวข้อหลักเกณฑ์',
  `question` text NOT NULL COMMENT 'คำถามที่ใช้ในการประเมอณในแต่ละหมวดหมู่',
  `evaluation_criteria` text NOT NULL COMMENT 'เกณฑ์การประเมินผล',
  `file` text NOT NULL COMMENT 'แนบเอกสารในทุกข้อคำถาม',
  `remark` text NOT NULL COMMENT 'คำถาม-หมายเหตุ',
  `image` text NOT NULL COMMENT 'แนบภาพถ่าย\r\nส่วนนี้จะเปิด Function การถ่ายภาพ ในรอบลงพื้นที่ สำหรับคณะกรรมการ',
  `scoring_criteria` int(11) NOT NULL COMMENT 'เกณฑ์การให้คะแนน',
  `score` int(11) NOT NULL COMMENT 'คะแนนในแต่ละเกณฑ์',
  `weight` int(11) NOT NULL COMMENT 'น้ำหนักการให้คะแนนคำถาม',
  `note` text NOT NULL COMMENT 'ส่วนนี้จะเปิด Note ของทุกรอบสำหรับคณะกรรมการในการจดบันทึก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `user_groups` varchar(255) NOT NULL,
  `front_end` int(1) NOT NULL COMMENT '0.ไม่มีสิทธิ์, 1.มีสิทธิ์',
  `back_end` int(1) NOT NULL COMMENT '0.ไม่มีสิทธิ์, 1.มีสิทธิ์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `user_groups`, `front_end`, `back_end`) VALUES
(1, 'ผู้ประกอบการ', 1, 0),
(2, 'เจ้าหน้าที่ ททท.', 1, 1),
(3, 'คณะกรรมการ', 1, 0),
(4, 'ผู้ดูแลระบบ', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `prefix` varchar(255) NOT NULL COMMENT 'คำนำหน้า',
  `name` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `surname` varchar(255) NOT NULL COMMENT 'นามสกุล',
  `member_type` varchar(255) NOT NULL COMMENT 'ประเภทสมาชิก',
  `mobile` varchar(25) NOT NULL COMMENT 'เบอร์มือถือ',
  `email` varchar(120) NOT NULL COMMENT 'E-mail',
  `username` varchar(20) NOT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `password` varchar(100) NOT NULL COMMENT 'รหัสผ่าน',
  `captcha` varchar(255) NULL COMMENT 'Captcha',
  `role_id` int(11) NOT NULL COMMENT 'สิทธิ์การใช้งาน',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_form`
--
ALTER TABLE `application_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_type`
--
ALTER TABLE `application_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application_type_sub`
--
ALTER TABLE `application_type_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_form`
--
ALTER TABLE `application_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_type`
--
ALTER TABLE `application_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `application_type_sub`
--
ALTER TABLE `application_type_sub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
