-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2024 at 10:53 PM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `attendance_id` varchar(255) NOT NULL,
  `subject_code` text DEFAULT NULL,
  `subject_id` text DEFAULT NULL,
  `course_id` text DEFAULT NULL,
  `course` text DEFAULT NULL,
  `student_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `attendance_id`, `subject_code`, `subject_id`, `course_id`, `course`, `student_id`, `created_at`) VALUES
(79, 'AID-630324', 'IT3204', 'SUB-588701', 'CRS-809317', 'BSIT', '0424-0613', '2024-06-17 14:51:55'),
(80, 'AID-207586', 'CSIT3216L', 'SUB-818001', 'CRS-809317', 'BSIT', '0424-0614', '2024-06-17 14:52:14'),
(81, 'AID-247832', 'CSIT3217', 'SUB-831793', 'CRS-809317', 'BSIT', '0424-0613', '2024-06-17 14:52:23'),
(82, 'AID-247832', 'CSIT3217', 'SUB-831793', 'CRS-809317', 'BSIT', '0424-0614', '2024-06-17 14:52:23'),
(85, 'AID-339475', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '0424-0614', '2024-06-17 18:03:35'),
(86, 'AID-339475', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '0424-0613', '2024-06-17 18:03:35'),
(87, 'AID-548508', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '19-0485-180', '2024-06-17 19:13:03'),
(88, 'AID-548508', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '19-0354-575', '2024-06-17 19:13:03'),
(89, 'AID-548508', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '19-0619-680', '2024-06-17 19:13:03'),
(90, 'AID-548508', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '0424-0614', '2024-06-17 19:13:03'),
(91, 'AID-548508', 'IT 5003', 'SUB-497365', 'CRS-809317', 'BSIT', '0424-0613', '2024-06-17 19:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `faculty_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_id`, `subject_code`, `faculty_id`, `created_at`) VALUES
(16, '1-A', 'CSIT3217', 'UPHSD-2131', '2024-06-16 14:58:30'),
(18, '2-A', 'CSIT3216L', 'UPHSD-3132', '2024-06-16 15:00:30'),
(21, '3-A', 'IT3204L', 'UPHSD-3132', '2024-06-16 15:28:16'),
(22, '1-B', 'IT3204', 'UPHSD-2131', '2024-06-16 15:36:31'),
(23, '3-A', 'IT 5003', 'UHSD 3542', '2024-06-17 03:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_id`, `course`, `description`, `created_at`) VALUES
(11, 'CRS-315275', 'BSA', 'Bachelor of Science in Accountancy', '2024-06-16 14:35:50'),
(12, 'CRS-809317', 'BSIT', 'Bachelor of Science in Information Technology', '2024-06-16 14:36:07'),
(13, 'CRS-547072', 'BSCS', 'Bachelor of Science in Computer Science', '2024-06-16 14:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `faculty_id` varchar(255) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_id`, `id_no`, `name`, `created_at`) VALUES
(17, 'FAC-362049', 'UPHSD-2131', 'Jerome Refran', '2024-06-16 14:56:47'),
(18, 'FAC-758748', 'UPHSD-3132', 'Crystal Orozco', '2024-06-17 00:40:23'),
(19, 'FAC-624391', 'UHSD 3542', 'Roselle Bengco', '2024-06-17 03:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `year_level` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `image`, `first_name`, `last_name`, `course`, `year_level`, `class_id`, `created_at`) VALUES
(30, '0424-0613', '0424-0613-Jane-Doe.jpg', 'Seralyn', 'Garejo', 'BSIT', '3', '3-A', '2024-06-17 02:52:46'),
(33, '19-0619-680', '19-0619-680-Charles-Llarena.png', 'Charles', 'Llarena', 'BSIT', '3', '3-A', '2024-06-17 03:45:52'),
(34, '19-0354-575', '19-0354-575-Ralph Erin-Saniel.jpg', 'Ralph Erin', 'Saniel', 'BSIT', '3', '3-A', '2024-06-17 03:50:23'),
(35, '19-0485-180', '19-0485-180-Yujin-Basilio.jpg', 'Arragen', 'Basilio', 'BSIT', '3', '3-A', '2024-06-17 03:52:31'),
(36, '21-0578-300', '21-0578-300-Mark John Rey-Ferol.jpg', 'Mark John Rey', 'Ferol', 'BSIT', '3', '3-A', '2024-06-17 04:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `subject_unit` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subject_id`, `subject_code`, `subject`, `subject_unit`, `description`, `created_at`) VALUES
(10, 'SUB-818001', 'CSIT3216L', 'Mobile Programming 2', '3', '', '2024-06-16 14:37:21'),
(11, 'SUB-831793', 'CSIT3217', 'Data Analytics', '3', '', '2024-06-16 14:37:36'),
(12, 'SUB-71901', 'IT3204L', 'System Integration and Architecture 2- Lab', '3', '', '2024-06-16 14:37:51'),
(13, 'SUB-588701', 'IT3204', 'System Integration and Architecture 2- Lec', '3', '', '2024-06-16 14:38:06'),
(14, 'SUB-497365', 'IT 5003', 'IT Elective II', '3', 'Game Maker ', '2024-06-17 02:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `full_name`, `username`, `password`, `created_at`) VALUES
(2, 'UID-985729323', 'Admin Panel', 'Admin001', '$2y$10$b8/B8Foy36s/9G.pNt.9ueBM/5E/p21ELeJLHgA6SqM08JguFA0mm', '2024-06-16 05:22:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
