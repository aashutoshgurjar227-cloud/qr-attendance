-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 08:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qr-attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin113C04@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `session_time` varchar(50) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expiry_time` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `subject`, `department`, `session_time`, `otp`, `created_at`, `expiry_time`, `status`) VALUES
(1, 'mc', 'cse', '10 AM', '510656', '2026-03-19 14:52:22', NULL, 'inactive'),
(2, 'mc', 'cse', '10 AM', '386078', '2026-03-19 15:02:53', NULL, 'inactive'),
(3, 'mc', 'cse', '10 AM', '275737', '2026-03-20 04:40:22', NULL, 'inactive'),
(4, 'mc', 'cse', '10 AM', '516781', '2026-03-20 04:48:42', NULL, 'inactive'),
(5, 'mobile  computing', 'CSE', '10:30 AM - 11:30 AM', '592675', '2026-03-20 05:02:49', '2026-03-20 06:17:49', 'inactive'),
(6, 'mobile  computing', 'CSE', '11:30 AM - 12:30 PM', '586784', '2026-03-20 05:57:04', '2026-03-20 07:12:04', 'inactive'),
(7, 'mobile  computing', 'CSE', '10-11', NULL, '2026-03-20 06:17:25', NULL, 'inactive'),
(8, 'mobile  computing', 'CSE', '10:30-1:00', NULL, '2026-03-20 06:32:34', NULL, 'inactive'),
(9, 'mobile  computing', 'CSE', '10:30-11:30', NULL, '2026-03-20 06:40:02', NULL, 'inactive'),
(10, 'mobile  computing', 'CSE', '10:30-11:30', NULL, '2026-03-20 15:10:05', NULL, 'inactive'),
(11, 'os', 'CSE', '11:30-12:30', NULL, '2026-03-21 04:44:11', NULL, 'inactive'),
(12, 'os', 'CSE', '', NULL, '2026-03-21 04:50:53', NULL, 'inactive'),
(13, 'os', 'CSE', '', NULL, '2026-03-21 04:50:58', NULL, 'inactive'),
(14, 'os', 'CSE', '11:30-12:30', NULL, '2026-03-21 04:51:28', NULL, 'inactive'),
(15, 'os', 'CSE', '', NULL, '2026-03-21 04:55:21', NULL, 'inactive'),
(16, 'mc', 'CSE', '10:30-11:30', NULL, '2026-03-21 05:10:14', NULL, 'active'),
(17, 'mc', 'CSE', '10:30-11:30', NULL, '2026-03-21 05:43:33', NULL, 'inactive'),
(18, 'mc', 'cse', '10-11', NULL, '2026-03-21 05:59:52', '2026-03-21 11:44:52', 'inactive'),
(19, 'mobile  computing', 'cse', '10-11', NULL, '2026-03-21 06:18:33', '2026-03-21 12:03:33', 'inactive'),
(20, 'mobile  computing', 'CSE', '10:30-11:30', NULL, '2026-03-21 06:39:06', NULL, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `department` varchar(50) NOT NULL DEFAULT 'CSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `roll_number`, `email`, `password`, `otp`, `otp_expiry`, `department`) VALUES
(1, 'Anurag Pandey', '2311304010', 'rgpvdeploma4@gmail.com', '12345', '173008', '2026-03-21 07:54:06', 'CSE');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `password`) VALUES
(1, 'Deepika Malviya', 'anuragpande122@gmail.com', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roll_number` (`roll_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
