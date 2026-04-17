-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:5222
-- Generation Time: Apr 15, 2026 at 07:22 PM
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
-- Database: `daffodil_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambulance`
--

CREATE TABLE `ambulance` (
  `id` int(11) NOT NULL,
  `driver_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `ambulance_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ambulance`
--

INSERT INTO `ambulance` (`id`, `driver_name`, `phone`, `ambulance_type`) VALUES
(2, 'Abdur Rahman', '01992234987', 'Normal'),
(3, 'Mominul', '01987362864', 'ICU'),
(4, 'Hasem', '01834876209', 'CCU'),
(5, 'Shakil', '019873510987', 'ICU');

--
-- Triggers `ambulance`
--
DELIMITER $$
CREATE TRIGGER `before_ambulance_insert` BEFORE INSERT ON `ambulance` FOR EACH ROW BEGIN
    -- If the phone number is empty or shorter than 10 digits, cancel the insert
    IF NEW.phone IS NULL OR LENGTH(NEW.phone) < 10 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Valid emergency phone number is required for ambulance drivers!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `app_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `app_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`app_id`, `patient_id`, `doc_id`, `app_date`, `status`) VALUES
(1, 1, 1, '2026-03-12 18:00:00', 'Pending'),
(2, 1, 2, '2026-03-29 18:00:00', 'Pending'),
(3, 1, 2, '2026-03-29 18:00:00', 'Pending'),
(4, 3, 4, '2026-04-14 18:00:00', 'Pending'),
(5, 3, 4, '2026-04-14 18:00:00', 'Pending'),
(6, 3, 6, '2026-04-14 18:00:00', 'Pending'),
(7, 3, 6, '2026-04-14 18:00:00', 'Pending');

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `after_appointment_insert` AFTER INSERT ON `appointments` FOR EACH ROW BEGIN
    INSERT INTO audit_log VALUES (CONCAT('New appointment for Patient ID: ', NEW.patient_id));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointment_details`
-- (See below for the actual view)
--
CREATE TABLE `appointment_details` (
`app_id` int(11)
,`patient_id` int(11)
,`doc_id` int(11)
,`app_date` timestamp
,`status` varchar(20)
,`patient_name` varchar(100)
,`patient_phone` varchar(20)
,`doctor_name` varchar(100)
,`department` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `log_msg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`log_msg`) VALUES
('New appointment for Patient ID: 1'),
('New appointment for Patient ID: 1'),
('New appointment for Patient ID: 1'),
('New appointment for Patient ID: 3'),
('New appointment for Patient ID: 3'),
('New appointment for Patient ID: 3'),
('New appointment for Patient ID: 3');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `patient_id`, `booking_time`) VALUES
(1, 1, '2026-03-13 16:37:51'),
(2, 3, '2026-04-15 17:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `doc_id` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doc_id`, `name`, `phone`, `department`, `schedule`, `password`) VALUES
(1, 'd-001', 'sahed', '0173512233', 'cardiology', NULL, '12345678'),
(2, NULL, 'Abir Rahman', NULL, 'Cardiology', NULL, NULL),
(3, NULL, 'Sarah Islam', NULL, 'Neurology', NULL, NULL),
(4, 'd002', 'ahnaf', '01721211771', 'eye', NULL, '12345678'),
(5, 'd003', 'Amdad Hasan', '01823798109', 'Orthopedics', NULL, '12345678'),
(6, 'd008', 'Haran', '01333333333', 'cardiology', NULL, '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE `hospital_info` (
  `address` text DEFAULT NULL,
  `hotline` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital_info`
--

INSERT INTO `hospital_info` (`address`, `hotline`) VALUES
('Daffodil Smart City, Birulia, Savar.', '017XXXXXXXX');

-- --------------------------------------------------------

--
-- Table structure for table `pathology`
--

CREATE TABLE `pathology` (
  `id` int(11) NOT NULL,
  `test_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pathology`
--

INSERT INTO `pathology` (`id`, `test_name`, `category`, `price`) VALUES
(2, 'Blind Test', 'EYE', 400.00),
(3, 'CBC', 'Blood', 600.00),
(4, 'RBS', 'Blood', 1000.00),
(5, 'HIV-Test', 'Blood', 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `phone`, `email`, `password`) VALUES
(1, 'asa', '01945194788', 'asa@email.com', '12345678'),
(2, 'md sayeed', '01735133199', 'sayeed@email.com', '12345678'),
(3, 'rokibul', '00000011111', 'rokibul@gmail.com', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`username`, `password`) VALUES
('admin', 'admindiuhospital');

-- --------------------------------------------------------

--
-- Structure for view `appointment_details`
--
DROP TABLE IF EXISTS `appointment_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointment_details`  AS SELECT `a`.`app_id` AS `app_id`, `a`.`patient_id` AS `patient_id`, `a`.`doc_id` AS `doc_id`, `a`.`app_date` AS `app_date`, `a`.`status` AS `status`, `p`.`name` AS `patient_name`, `p`.`phone` AS `patient_phone`, `d`.`name` AS `doctor_name`, `d`.`department` AS `department` FROM ((`appointments` `a` join `patients` `p` on(`a`.`patient_id` = `p`.`id`)) join `doctors` `d` on(`a`.`doc_id` = `d`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambulance`
--
ALTER TABLE `ambulance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doc_id` (`doc_id`);

--
-- Indexes for table `pathology`
--
ALTER TABLE `pathology`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambulance`
--
ALTER TABLE `ambulance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pathology`
--
ALTER TABLE `pathology`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
