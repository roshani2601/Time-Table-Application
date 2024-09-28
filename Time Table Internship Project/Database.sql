-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 04:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytimetable`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `contact_no`, `type`, `image`) VALUES
(1, 'Roshani Borsadiya', 'roshaniborsadiya@gmail.com', 'Roshani@123', '9870050518', 'admin', 'Roshani Borsadiya.jpg'),
(2, 'Ashruti Pagral', 'ashrutipagral@gmail.com', 'Ashrutipagral@123', '6987412356', 'admin', 'Ashruti Pagral.jpg'),
(3, 'Adminor', 'admin@gmail.com', 'Admin@123', '6987412356', 'staff', 'Adminor.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(200) NOT NULL,
  `description` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `description`) VALUES
(1, 'BSCIT', 'Bachelor of Science in Information Technology'),
(2, 'MSCIT', 'Master of Science in Information Technology\r\n'),
(3, 'BBA', 'Bachelor of Business Administration\r\n'),
(4, 'MBA', 'Master of Business Administration\r\n'),
(5, 'BCOM', 'Bachelor of Commerce\r\n'),
(6, 'LLB', 'Bachelor of Laws\r\n'),
(7, 'Mcom', 'Master'),
(8, 'BBA1', 'bbaq');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `sem_id` int(11) NOT NULL,
  `sem_name` varchar(20) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`sem_id`, `sem_name`, `course_id`) VALUES
(1, '1st', 2),
(2, '1st', 3),
(4, '1st', 1),
(5, '3rd', 1),
(6, '1st', 4),
(7, '3rd', 5),
(8, '3rd', 4),
(9, '3rd', 2),
(10, '3rd', 3),
(11, '5th', 3),
(12, '1st', 5),
(13, '5th', 1),
(14, '5th', 5),
(15, '2nd', 3),
(16, '1st', 7);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `student_email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `course_id` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL,
  `bod` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `student_email`, `password`, `contact_no`, `course_id`, `sem_id`, `bod`, `gender`, `image`) VALUES
(1, 'Purv Patel', 'purvpatel@gmail.com', 'Purvpatel@123', '9874563214', 1, 4, '2006-10-26', 'male', 'Purv Patel.jpg'),
(2, 'Aditya Narayan', 'adityanarayan@gmail.com', 'Adityanarayan@123', '8426571399', 2, 1, '2003-06-23', 'male', 'Aditya Narayan.jpg'),
(3, 'Priya Patel', 'priyapatel@gmail.com', 'Priyapatel@123', '7894561234', 4, 6, '2002-12-10', 'female', 'Priya Patel.jpg'),
(4, 'Arjun Shingh', 'arjunsingh@gmail.com', 'Arunshingh@123', '7418523696', 3, 10, '2004-01-01', 'male', 'Arjun Shingh.jpg'),
(5, 'Isha Khan', 'ishakhan@gmail.com', 'Ishakhan@123', '8426571396', 5, 14, '2003-05-13', 'female', 'Isha Khan.jpg'),
(6, 'Ananya Sharma', 'ananyasharma@gmail.com', 'Ananyasharma@123', '7896541236', 4, 8, '2002-12-09', 'female', 'Ananya Sharma.jpg'),
(7, 'Diya Varma', 'diyavarma@gmail.com', 'Diyavarma@123', '7413698252', 2, 9, '2002-08-25', 'female', 'Diya Varma.jpg'),
(8, 'Aryan Reddy', 'aryanreddy@gmail.com', 'Aryanreddy@123', '7539514862', 1, 13, '2005-01-01', 'male', 'Aryan Reddy.jpg'),
(9, 'Rohan Kumar', 'rohankumar@gmail.com', 'Rohankumar@123', '7539511236', 3, 10, '2006-06-02', 'male', 'Rohan Kumar.jpg'),
(10, 'Yash Damodar', 'yashdamodar@gmail.com', 'Yashdamodar@123', '7913648526', 4, 6, '2003-12-12', 'male', 'Yash Damodar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `course_id`, `sem_id`, `assign_id`) VALUES
(1, 'Programming in C', 1, 4, 8),
(2, 'Communication Skills', 1, 4, 21),
(3, 'Fundamentals of Information Technology', 1, 4, 1),
(4, 'Mathematics I', 1, 4, 3),
(5, 'Digital Logic and Computer Design', 1, 4, 5),
(6, 'Data Structures and Algorithms', 1, 5, 8),
(7, 'Object-Oriented Programming', 1, 5, 5),
(8, 'Database Management Systems', 1, 5, 3),
(9, 'Operating Systems', 1, 5, 1),
(10, 'Mathematics III', 1, 5, 5),
(11, 'Web Programming', 1, 13, 3),
(12, 'Computer Networks', 1, 13, 1),
(13, 'Artificial Intelligence', 1, 13, 5),
(14, 'Information Security', 1, 13, 8),
(15, 'Mobile Computing', 2, 1, 2),
(16, 'Digital Graphics ', 2, 1, 6),
(17, 'Java', 2, 1, 7),
(18, 'EDBMS', 2, 1, 4),
(19, 'Data Communication and network', 2, 1, 2),
(20, 'Big Data', 1, 4, 27);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `email`, `password`, `contact_no`, `gender`, `address`, `image`) VALUES
(1, 'Dr. Papri Das', 'papridas@gmail.com', 'Papridas@123', '9514782365', 'female', 'A-503 Happy bungalow\'s, near VR mall,surat', 'Dr. Papri Das.jpg'),
(2, 'Dr. Akhilesh Latoria', 'akhileshlatoria@gmail.com', 'Akhileshlatoria@123', '8527419635', 'male', '23,Baben bungalow bardoli', 'Dr. Akhilesh Latoria.jpg'),
(3, 'Dr. Bhanu Pratap Singh', 'bhanupratapsingh@gmail.com', 'Bhanupratapsingh@123', '7896541235', 'male', 'C-902 Raghuvir Spectrum, behind of agrawal vidhya school surat', 'Dr. Bhanu Pratap Singh.jpg'),
(4, 'Ms. Juhi Khengar', 'juhikhengar@gmail.com', 'Juhikhengar@123', '8963214755', 'female', 'A-803 Sangini Solitaire Canal road ,G D Goenka school Surat', 'Ms. Juhi Khengar.jpg'),
(5, 'Prakruti Desai', 'prakrutidesai@gmail.com', 'Prakrutidesai@123', '8523697412', 'female', '102, Shreeji Apartment Ghod Dod Road,Surat', 'Prakruti Desai.jpg'),
(6, 'Shivangi Patel', 'shivangipatel@gmail.com', 'Shivangipatel@123', '8426571396', 'female', 'B-4, Adajan Residency, Near Pal RTO, Adajan, Surat', 'Shivangi Patel.jpg'),
(7, 'Ashok Shah', 'ashokshah@gmail.com', 'Ashokshah@123', '7891234569', 'male', '12, Jolly Bunglows, Vesu Main Road, Surat, Gujarat 395007', 'Ashok Shah.jpg'),
(8, 'Aarti Sondagar', 'aartisondagar@gmail.com', 'Aartisondagar@123', '7539514862', 'female', '22, Shubh Residency, Parle Point, Athwa, Surat', 'Aarti Sondagar.jpg'),
(9, 'Bharati Dudhagara', 'bhartidudhagara@gmail.com', 'Bharidudhagara@123', '8795462136', 'female', 'Flat No. 303, Dev Heights, Althan Canal Road, Bhatar, Surat', 'Bharati Dudhagara.jpg'),
(10, 'Swati Patel', 'swatipatel@gmail.com', 'Swatipatel@123', '7753214862', 'female', 'D-503, Green Valley, VIP Road, Vesu, Surat', 'Swati Patel.jpg'),
(11, 'Shobhna Shah', 'shobhnashah@gmail.com', 'Shobhnashah@123', '9874563215', 'female', '15, Shantiniketan Society, Piplod, Surat', 'Shobhna Shah.jpg'),
(12, 'Shayam Damodar ', 'shayamdamodar@123', 'Shayamdamodar@123', '8521479639', 'male', '204, Shyam Villa Apartments, City Light Road, Athwa, Surat', 'Shayam Damodar .jpg'),
(13, 'Divyesh Ramoliya', 'divyeshramoliya@gmail.com', 'Divyeshramoliliya@12', '7895461329', 'male', '6, Radhe Shyam Society, Rander Road, Adajan, Surat', 'Divyesh Ramoliya.jpg'),
(14, 'Bhadresh Paneliya', 'bhadreshpaneliya@gmail.com', 'Bhadreshpaneliya@123', '7889456123', 'male', 'G-2, Krishna Residency, Palanpur Patia, Adajan, Surat', 'Bhadresh Paneliya.jpg'),
(15, 'Sanjay Kumar', 'sanjaykumar@gmail.com', 'Sanjaykumar@123', '7854123698', 'male', '301, Shivalik Apartment, Udhna Magdalla Road, Surat', 'Sanjay Kumar.jpg'),
(16, 'Dhaval Thakkar', 'davalthakkr@gmail.com', 'Dhavalthakkar@123', '8521479635', 'male', 'Happy bungalows near vesu, surat.', 'Dhaval Thakkar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assign`
--

CREATE TABLE `teacher_assign` (
  `assign_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_assign`
--

INSERT INTO `teacher_assign` (`assign_id`, `course_id`, `teacher_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 4),
(4, 2, 4),
(5, 1, 2),
(6, 2, 3),
(7, 2, 2),
(8, 1, 3),
(9, 3, 8),
(10, 4, 8),
(11, 3, 9),
(12, 4, 9),
(13, 3, 12),
(14, 4, 12),
(15, 3, 15),
(16, 4, 15),
(17, 5, 11),
(18, 5, 13),
(19, 5, 6),
(20, 5, 10),
(21, 1, 6),
(22, 3, 6),
(23, 5, 14),
(24, 2, 5),
(25, 7, 14),
(27, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `timetable_id` int(11) NOT NULL,
  `time` varchar(20) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `sem_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`timetable_id`, `time`, `course_id`, `sem_id`, `subject_id`, `teacher_id`, `day`) VALUES
(1, '04:00 to 05:00', 1, 4, 2, 6, 'Tuesday'),
(2, '11:00 to 12:00', 1, 4, 2, 6, 'Monday'),
(3, '11:00 to 12:00', 1, 4, 2, 6, 'Thursday'),
(4, '11:00 to 12:00', 1, 4, 2, 6, 'Friday'),
(5, '01:00 to 02:00', 1, 4, 3, 1, 'Wednesday'),
(6, '01:00 to 02:00', 1, 4, 3, 1, 'Thursday'),
(7, '01:00 to 02:00', 1, 4, 3, 1, 'Friday'),
(8, '01:00 to 02:00', 1, 4, 3, 1, 'Tuesday'),
(9, '10:00 to 11:00', 1, 4, 5, 2, 'Monday'),
(10, '10:00 to 11:00', 1, 4, 5, 2, 'Tuesday'),
(11, '10:00 to 11:00', 1, 4, 5, 2, 'Wednesday'),
(12, '10:00 to 11:00', 1, 4, 5, 2, 'Thursday'),
(13, '10:00 to 11:00', 1, 4, 4, 4, 'Friday'),
(14, '11:00 to 12:00', 1, 4, 4, 4, 'Wednesday'),
(15, '01:00 to 02:00', 1, 4, 4, 4, 'Monday'),
(16, '02:00 to 03:00', 1, 4, 1, 3, 'Monday'),
(17, '02:00 to 03:00', 1, 4, 1, 3, 'Tuesday'),
(18, '02:00 to 03:00', 1, 4, 1, 3, 'Wednesday'),
(19, '02:00 to 03:00', 1, 4, 1, 3, 'Thursday'),
(20, '02:00 to 03:00', 1, 4, 4, 4, 'Friday'),
(21, '04:00 to 05:00', 2, 1, 17, 2, 'Monday'),
(22, '03:00 to 04:00', 1, 4, 20, 16, 'Tuesday'),
(23, '03:00 to 04:00', 1, 4, 20, 16, 'Monday');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`sem_id`),
  ADD KEY `course_id_fk` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `course_id_fk4` (`course_id`),
  ADD KEY `sem_id_fk2` (`sem_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `sem_id_fk` (`sem_id`),
  ADD KEY `course_id_fk2` (`course_id`) USING BTREE,
  ADD KEY `ta_id_fk` (`assign_id`) USING BTREE;

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_assign`
--
ALTER TABLE `teacher_assign`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `teacher_id_fk` (`teacher_id`),
  ADD KEY `course_id_fk1` (`course_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `course_id_fk3` (`course_id`),
  ADD KEY `subject_id_fk` (`subject_id`),
  ADD KEY `teacher_id_fk3` (`teacher_id`),
  ADD KEY `sem_id_fk1` (`sem_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teacher_assign`
--
ALTER TABLE `teacher_assign`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `course_id_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `course_id_fk4` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sem_id_fk2` FOREIGN KEY (`sem_id`) REFERENCES `semesters` (`sem_id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `course_id_fk2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sem_id_fk` FOREIGN KEY (`sem_id`) REFERENCES `semesters` (`sem_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ta_id_fk` FOREIGN KEY (`assign_id`) REFERENCES `teacher_assign` (`assign_id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_assign`
--
ALTER TABLE `teacher_assign`
  ADD CONSTRAINT `course_id_fk1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_id_fk` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `course_id_fk3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sem_id_fk1` FOREIGN KEY (`sem_id`) REFERENCES `semesters` (`sem_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_id_fk` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_id_fk3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
