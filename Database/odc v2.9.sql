-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2022 at 10:35 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `authorized` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `password`, `authorized`) VALUES
(1, 'arafat', '$2y$10$LGcfHtiLlIbt4f/XoPcHSuKxouhKijgcT4XACIHG3LN3HefQT8PDK', b'1'),
(2, 'ahmed', '$2y$10$013GKBEbVDSgwuXubD7d1.Rr4QtYufXTaQgGyUlPyF1Ue9fzKmX1i', b'0'),
(3, 'xyz', '$2y$10$akbk0C.WZLRCdu1Rsji/Je2SnUda8XMHXVIfjcyVEPh06bcIvxLUa', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `created_at`) VALUES
(2, 'FrontEnd', '2022-04-06 18:18:07'),
(3, 'BackEnd', '2022-04-06 18:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_level` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `Course_Tag` varchar(255) NOT NULL,
  `Is_Running` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_level`, `description`, `created_at`, `category_id`, `Course_Tag`, `Is_Running`) VALUES
(1, 'Data', 'Advanced', 'Hello Course', '2022-04-06 21:17:33', 2, 'DS', b'1'),
(13, 'Data -- updated', 'Easy', 'Hello Course', '2022-04-06 21:22:16', 2, 'SS', b'1'),
(24, 'Algorithms', 'Advanced', 'Hello', '2022-04-06 21:30:09', 3, 'ALGO', b'1'),
(26, 'Data', 'Advanced', 'Hello Course', '2022-04-06 21:49:45', 2, 'DsssS', b'0'),
(28, 'x', 'x', 'x', '2022-04-06 22:10:36', 2, 'DSss', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `course_instructor`
--

CREATE TABLE `course_instructor` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `course_id`) VALUES
(1, 24),
(3, 26),
(4, 28);

-- --------------------------------------------------------

--
-- Table structure for table `exam_result`
--

CREATE TABLE `exam_result` (
  `id` int(11) NOT NULL,
  `total_degree` int(11) NOT NULL,
  `total_right_degree` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `Is_Interview_Send` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_result`
--

INSERT INTO `exam_result` (`id`, `total_degree`, `total_right_degree`, `exam_id`, `student_id`, `Is_Interview_Send`) VALUES
(11, 15, 1, 1, 4, b'1'),
(12, 15, 15, 1, 2, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `otp` int(11) NOT NULL,
  `is_expired` bit(1) NOT NULL DEFAULT b'0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `otp`, `is_expired`, `created_at`, `student_id`) VALUES
(1, 459532, b'0', '0000-00-00 00:00:00', 4),
(2, 423627, b'0', '0000-00-00 00:00:00', 4),
(3, 220102, b'0', '0000-00-00 00:00:00', 4),
(5, 730282, b'0', '0000-00-00 00:00:00', 4),
(6, 258092, b'0', '0000-00-00 00:00:00', 4),
(7, 204798, b'0', '2022-04-07 00:41:52', 4),
(8, 990294, b'0', '2022-04-07 01:31:47', 4),
(9, 683919, b'0', '2022-04-07 01:56:01', 4);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `answer` text NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `answer`, `exam_id`) VALUES
(1, '... is an algorithm', 'stack', 'queue', 'graph', 'Binary Search', '4', 1),
(8, 'Question Number #1', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(9, 'Question Number #2', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(10, 'Question Number #3', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(11, 'Question Number #4', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(12, 'Question Number #5', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(13, 'Question Number #6', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(14, 'Question Number #7', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(15, 'Question Number #8', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(16, 'Question Number #9', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(17, 'Question Number #10', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(18, 'Question Number #11', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(19, 'Question Number #12', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(20, 'Question Number #13', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(21, 'Question Number #14', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(22, 'Question Number #15', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(23, 'Question Number #16', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(24, 'Question Number #17', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(25, 'Question Number #18', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(26, 'Question Number #19', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(27, 'Question Number #20', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(28, 'Question Number #21', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(29, 'Question Number #22', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(30, 'Question Number #23', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(31, 'Question Number #24', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(32, 'Question Number #25', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(33, 'Question Number #26', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(34, 'Question Number #27', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(35, 'Question Number #28', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(36, 'Question Number #29', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(37, 'Question Number #30', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(38, 'Question Number #31', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(39, 'Question Number #32', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(40, 'Question Number #33', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(41, 'Question Number #34', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(42, 'Question Number #35', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(43, 'Question Number #36', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(44, 'Question Number #37', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(45, 'Question Number #38', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(46, 'Question Number #39', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(47, 'Question Number #40', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(48, 'Question Number #41', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(49, 'Question Number #42', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(50, 'Question Number #43', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(51, 'Question Number #44', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(52, 'Question Number #45', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(53, 'Question Number #46', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(54, 'Question Number #47', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(55, 'Question Number #48', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(56, 'Question Number #49', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(57, 'Question Number #50', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(58, 'Question Number #51', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(59, 'Question Number #52', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(60, 'Question Number #53', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(61, 'Question Number #54', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(62, 'Question Number #55', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(63, 'Question Number #56', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(64, 'Question Number #57', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(65, 'Question Number #58', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(66, 'Question Number #59', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(67, 'Question Number #60', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(68, 'Question Number #61', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(69, 'Question Number #62', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(70, 'Question Number #63', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(71, 'Question Number #64', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(72, 'Question Number #65', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(73, 'Question Number #66', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(74, 'Question Number #67', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(75, 'Question Number #68', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(76, 'Question Number #69', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(77, 'Question Number #70', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(78, 'Question Number #71', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(79, 'Question Number #72', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(80, 'Question Number #73', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(81, 'Question Number #74', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(82, 'Question Number #75', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(83, 'Question Number #76', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(84, 'Question Number #77', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(85, 'Question Number #78', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(86, 'Question Number #79', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(87, 'Question Number #80', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(88, 'Question Number #81', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(89, 'Question Number #82', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(90, 'Question Number #83', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(91, 'Question Number #84', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(92, 'Question Number #85', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(93, 'Question Number #86', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(94, 'Question Number #87', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(95, 'Question Number #88', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(96, 'Question Number #89', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(97, 'Question Number #90', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(98, 'Question Number #91', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(99, 'Question Number #92', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(100, 'Question Number #93', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(101, 'Question Number #94', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(102, 'Question Number #95', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(103, 'Question Number #96', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(104, 'Question Number #97', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(105, 'Question Number #98', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(106, 'Question Number #99', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(107, 'Question Number #100', 'MSQ 1', 'MSQ 2', 'MSQ 3', 'MSQ 4', '4', 1),
(108, 'hi', 'hi1', 'hi2', 'hi3', 'hi4 Search', '4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `signedin`
--

CREATE TABLE `signedin` (
  `user_id` int(11) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signedin`
--

INSERT INTO `signedin` (`user_id`, `Token`, `Date`) VALUES
(1, 'fvfdsfsdfsd', '2022-04-07 05:05:24'),
(4, '0021c55727ac5e7828cd2d048bd4b99f', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `email`, `password`, `phone`, `address`, `college`, `created_at`) VALUES
(1, 'ahmed', 'ahmed@gmail.com', '', '01013769931', 'cairo', 'BIS', '2022-04-06 18:05:16'),
(2, 'ging', 'ging@gmail.com', '', '01013769931', 'Zamalek', 'FMI', '2022-04-06 18:05:16'),
(4, 'HISOKA', 'ahmedmoyousry.bis@gmail.com', '$2y$10$gUCXiJvsHQ2iRLOGrjFg4uQrOoMvsY/EHUt9SJgLHk/2ez35OASZG', '0101376', 'Haram', 'BIS', '2022-04-07 00:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_enroll`
--

CREATE TABLE `student_course_enroll` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `Enrollment_Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Code` varchar(255) DEFAULT NULL,
  `Code_Date` datetime DEFAULT NULL,
  `Is_Code_Expired` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_course_enroll`
--

INSERT INTO `student_course_enroll` (`id`, `student_id`, `course_id`, `Enrollment_Date`, `Code`, `Code_Date`, `Is_Code_Expired`) VALUES
(1, 4, 24, '2022-04-07 01:57:50', 'ALGO46826', '2022-04-07 05:02:39', b'1'),
(2, 1, 1, '2022-04-07 02:00:12', NULL, NULL, b'0'),
(3, 2, 24, '2022-04-07 05:03:06', 'ALGO46827', '2022-04-07 05:04:02', b'0'),
(4, 1, 24, '2022-04-07 05:05:57', 'ALGO46828', '2022-04-07 05:10:34', b'0'),
(5, 4, 1, '2022-04-07 05:17:16', NULL, NULL, b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Course_Tag` (`Course_Tag`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `exam_result`
--
ALTER TABLE `exam_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `signedin`
--
ALTER TABLE `signedin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course_enroll`
--
ALTER TABLE `student_course_enroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `course_instructor`
--
ALTER TABLE `course_instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_result`
--
ALTER TABLE `exam_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `signedin`
--
ALTER TABLE `signedin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_course_enroll`
--
ALTER TABLE `student_course_enroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `course_instructor`
--
ALTER TABLE `course_instructor`
  ADD CONSTRAINT `course_instructor_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `course_instructor_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`);

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `exam_result`
--
ALTER TABLE `exam_result`
  ADD CONSTRAINT `exam_result_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_result_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `otp`
--
ALTER TABLE `otp`
  ADD CONSTRAINT `otp_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`);

--
-- Constraints for table `signedin`
--
ALTER TABLE `signedin`
  ADD CONSTRAINT `signedin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `student_course_enroll`
--
ALTER TABLE `student_course_enroll`
  ADD CONSTRAINT `student_course_enroll_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `student_course_enroll_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
