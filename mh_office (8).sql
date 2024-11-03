-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 03:07 PM
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
-- Database: `mh_office`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_animal_bite_care`
--

CREATE TABLE `tbl_animal_bite_care` (
  `animal_biteID` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `med_history` varchar(255) DEFAULT NULL,
  `bleeding` varchar(20) NOT NULL,
  `cpi_month` varchar(20) DEFAULT NULL,
  `cpi_year` varchar(20) DEFAULT NULL,
  `animal_type` varchar(50) DEFAULT NULL,
  `date_bite` date DEFAULT NULL,
  `Place` varchar(255) DEFAULT NULL,
  `Type_bite` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `pet_vaccinated` varchar(255) DEFAULT NULL,
  `animal_status` varchar(255) DEFAULT NULL,
  `site_exposure` varchar(255) DEFAULT NULL,
  `wound` varchar(20) DEFAULT NULL,
  `washed` varchar(20) DEFAULT NULL,
  `soap` varchar(20) DEFAULT NULL,
  `Tandok` varchar(20) DEFAULT NULL,
  `Applied` varchar(20) DEFAULT NULL,
  `Tetanus` varchar(20) DEFAULT NULL,
  `vac_date` date DEFAULT NULL,
  `vaccine` varchar(255) DEFAULT NULL,
  `category_exposure` varchar(255) DEFAULT NULL,
  `a` varchar(255) DEFAULT NULL,
  `p` varchar(255) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `bite_status` enum('ongoing','done') NOT NULL DEFAULT 'ongoing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_animal_bite_care`
--

INSERT INTO `tbl_animal_bite_care` (`animal_biteID`, `patient_id`, `reg_no`, `date`, `med_history`, `bleeding`, `cpi_month`, `cpi_year`, `animal_type`, `date_bite`, `Place`, `Type_bite`, `source`, `pet_vaccinated`, `animal_status`, `site_exposure`, `wound`, `washed`, `soap`, `Tandok`, `Applied`, `Tetanus`, `vac_date`, `vaccine`, `category_exposure`, `a`, `p`, `userID`, `bite_status`) VALUES
(1, 7, '20241021001', '2024-10-21', '[\"Fully Immunized\",\"Diabetes Mellitus\",\"Anti-Rabies\",\"On Meds\",\"Allergy\",\"Drug\",\"Hypertension\",\"On Meds\",\"Food\"]', '-', 'January', '2024', 'fdsafsadfs', '2024-10-21', 'palabillafdsa', '[\"Non-bite\",\"Spontaneous\"]', '2024-10-14', 'Vaccinated', 'Died', 'fdsaffff', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '2024-10-21', 'TT', 'II', 'fdsa', 'fsda', 8, 'ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_animal_bite_vaccination`
--

CREATE TABLE `tbl_animal_bite_vaccination` (
  `animal_bite_vacID` int(11) NOT NULL,
  `vaccination_name` varchar(100) NOT NULL,
  `vaccination_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `dose_number` varchar(100) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `stat` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=completed',
  `dose_status` tinyint(4) NOT NULL,
  `bite_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_animal_bite_vaccination`
--

INSERT INTO `tbl_animal_bite_vaccination` (`animal_bite_vacID`, `vaccination_name`, `vaccination_date`, `next_visit_date`, `dose_number`, `remarks`, `patient_id`, `stat`, `dose_status`, `bite_status`) VALUES
(1, '3', '2024-10-21', '2024-10-23', '1', 'fdsa', 7, 1, 1, 1),
(2, '3', '2024-10-23', '2024-10-25', '1', '', 7, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcements`
--

CREATE TABLE `tbl_announcements` (
  `announceID` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcements`
--

INSERT INTO `tbl_announcements` (`announceID`, `date`, `title`, `details`, `created_at`, `updated_at`) VALUES
(4, '2024-10-30', 'Covid vaccination day', 'Covid vaccination day on November 5, 2024', '2024-09-14 00:10:45', '2024-10-22 07:09:27'),
(5, '2024-10-29', 'fa', 'fa', '2024-10-26 23:26:32', '2024-10-26 23:26:32'),
(6, '2024-11-07', 'fsafd', 'fdsa', '2024-10-26 23:26:38', '2024-10-26 23:26:38'),
(7, '2024-11-02', 'fsafs', 'fsdaf', '2024-10-26 23:26:44', '2024-10-26 23:26:44'),
(8, '2024-11-14', 'fsafsa', 'fsa', '2024-10-26 23:26:51', '2024-10-26 23:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointments`
--

CREATE TABLE `tbl_appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_log`
--

CREATE TABLE `tbl_audit_log` (
  `auditID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_log`
--

INSERT INTO `tbl_audit_log` (`auditID`, `user_id`, `action`, `table_name`, `record_id`, `old_value`, `new_value`, `timestamp`) VALUES
(1, 1, 'UPDATE', 'tbl_announcements', 4, '{\"date\":\"2024-09-26\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}', '{\"date\":\"2024-10-14\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}', '2024-10-12 15:42:07'),
(2, 1, 'DELETE', 'tbl_announcements', 3, '{\"announceID\":3,\"date\":\"2024-09-20\",\"title\":\"test\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:47:28\",\"updated_at\":\"2024-09-14 07:47:28\"}', NULL, '2024-10-12 15:54:52'),
(3, 1, 'DELETE', 'tbl_announcements', 2, '{\"announceID\":2,\"date\":\"2024-09-20\",\"title\":\"covid\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:46:19\",\"updated_at\":\"2024-09-14 07:46:19\"}', NULL, '2024-10-12 15:54:54'),
(4, 1, 'UPDATE', 'tbl_announcements', 4, '{\"date\":\"2024-10-14\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}', '{\"date\":\"2024-10-14\",\"title\":\"Covid vaccination day\",\"details\":\"Covid vaccination day on November 5, 2024\"}', '2024-10-12 15:55:20'),
(5, 1, 'added', 'tbl_medicine_details', 3, NULL, '{\"medicine_id\":\"6\",\"packing\":\"injectable\",\"qt\":\"19\"}', '2024-10-16 13:33:21'),
(6, 1, 'added', 'tbl_medicine_details', 4, NULL, '{\"medicine_id\":\"1\",\"packing\":\"injectable\",\"qt\":\"100\"}', '2024-10-16 13:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_trail`
--

CREATE TABLE `tbl_audit_trail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `affected_table` varchar(255) DEFAULT NULL,
  `affected_record_id` int(11) DEFAULT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`id`, `user_id`, `action`, `description`, `affected_table`, `affected_record_id`, `action_timestamp`, `ip_address`) VALUES
(1, 1, 'Update Events', 'Updated Events Covid vaccination day Covid vaccination day on November 5, 2024', 'tbl_announcements', 4, '2024-10-13 23:24:50', '::1'),
(2, 7, 'Insert', 'Added patient: Irene basco', 'tbl_patients', 8, '2024-10-15 08:25:36', '::1'),
(3, 7, 'Insert', 'Added patient: Fdsaf fdsa', 'tbl_patients', 9, '2024-10-18 01:50:56', '::1'),
(4, 7, 'Insert', 'Added patient: Fdsafasd fdsafd', 'tbl_patients', 10, '2024-10-18 07:37:02', '::1'),
(5, 1, 'Update Events', 'Updated Events Covid vaccination day Covid vaccination day on November 5, 2024', 'tbl_announcements', 4, '2024-10-21 02:18:37', '::1'),
(6, 1, 'Update Patient Record', 'Updated  Unknown', 'tbl_patients', NULL, '2024-10-21 02:22:23', '::1'),
(7, 1, 'Update Patient Record', 'Updated  Rolly Beans Anderson', 'tbl_patients', 10, '2024-10-21 02:24:19', '::1'),
(8, 1, 'Update Patient Record', 'Updated Patient Record Rolly Beans v Anderson', 'tbl_patients', 10, '2024-10-21 02:27:00', '::1'),
(9, 1, 'Update Events', 'Updated Events Covid vaccination day Covid vaccination day on November 5, 2024', 'tbl_announcements', 4, '2024-10-22 07:09:27', '::1'),
(10, 1, 'Update Schedule', 'Updated the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 01:54:27', '::1'),
(11, 1, 'Add Schedule', 'Added a schedule for Doctor  joven  joven', 'tbl_doctor_schedule', 3, '2024-10-23 01:59:10', '::1'),
(12, 1, 'Update Schedule', 'Updated the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 02:00:58', '::1'),
(13, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 4, '2024-10-23 03:25:17', '::1'),
(14, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 5, '2024-10-23 03:33:07', '::1'),
(15, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 03:36:12', '::1'),
(16, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 2, '2024-10-23 03:38:23', '::1'),
(17, 1, 'Add Schedule', 'Added a schedule for Doctor  Joven  Joven', 'tbl_doctor_schedule', 3, '2024-10-23 03:53:24', '::1'),
(18, 1, 'Add Schedule', 'Added a schedule for Doctor  Joven  Joven', 'tbl_doctor_schedule', 4, '2024-10-23 03:53:50', '::1'),
(19, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 4, '2024-10-23 03:54:03', '::1'),
(20, 1, 'Add Schedule', 'Added a schedule for Doctor  Joven  Joven', 'tbl_doctor_schedule', 5, '2024-10-23 03:54:16', '::1'),
(21, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 04:46:22', '::1'),
(22, 1, 'Update Schedule', 'Updated the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 05:10:23', '::1'),
(23, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-23 05:10:30', '::1'),
(24, 1, 'Add Schedule', 'Added a schedule for Doctor  Joven  Joven', 'tbl_doctor_schedule', 2, '2024-10-23 05:11:13', '::1'),
(25, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 3, '2024-10-23 06:04:53', '::1'),
(26, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 3, '2024-10-23 06:07:48', '::1'),
(27, 1, 'Add Schedule', 'Added a schedule for Doctor  Ben Test Manatad', 'tbl_doctor_schedule', 4, '2024-10-23 06:08:50', '::1'),
(28, 1, 'Update Events', 'Updated Events Covid vaccination day Covid vaccination day on November 5, 2024', 'tbl_announcements', 4, '2024-10-26 23:20:50', '::1'),
(29, 1, 'Add Events', 'Added Events  fa fa', 'tbl_announcements', 5, '2024-10-26 23:26:32', '::1'),
(30, 1, 'Add Events', 'Added Events  fsafd fdsa', 'tbl_announcements', 6, '2024-10-26 23:26:38', '::1'),
(31, 1, 'Add Events', 'Added Events  fsafs fsdaf', 'tbl_announcements', 7, '2024-10-26 23:26:44', '::1'),
(32, 1, 'Add Events', 'Added Events  fsafsa fsa', 'tbl_announcements', 8, '2024-10-26 23:26:52', '::1'),
(33, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-27 08:44:45', '::1'),
(34, 1, 'Delete Schedule', 'Deleted the schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 2, '2024-10-27 08:46:14', '::1'),
(35, 1, 'Add Schedule', 'Added a schedule for Doctor  Unknown', 'tbl_doctor_schedule', 0, '2024-10-27 08:55:42', '::1'),
(36, 1, 'Add Schedule', 'Added a schedule for Doctor  Unknown', 'tbl_doctor_schedule', 0, '2024-10-27 08:55:58', '::1'),
(37, 1, 'Add Schedule', 'Added a schedule for Doctor  Unknown', 'tbl_doctor_schedule', 0, '2024-10-27 08:57:24', '::1'),
(38, 1, 'Add Schedule', 'Added a schedule for Doctor  Unknown', 'tbl_doctor_schedule', 0, '2024-10-27 09:09:18', '::1'),
(39, 1, 'Add Schedule', 'Added a schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 1, '2024-10-27 09:20:39', '::1'),
(40, 1, 'Add Schedule', 'Added a schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 2, '2024-10-27 09:21:43', '::1'),
(41, 1, 'Add Schedule', 'Added a schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 1, '2024-10-27 09:24:59', '::1'),
(42, 1, 'Add Schedule', 'Added a schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 2, '2024-10-27 09:25:22', '::1'),
(43, 1, 'Add Schedule', 'Added a schedule for Doctor Unknown', 'tbl_doctor_schedule', 3, '2024-10-27 09:26:32', '::1'),
(44, 1, 'Add Schedule', 'Added a schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 4, '2024-10-27 09:28:40', '::1'),
(45, 1, 'Add Schedule', 'Added a schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 1, '2024-10-27 09:29:33', '::1'),
(46, 1, 'Add Schedule', 'Added a schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 1, '2024-10-27 09:41:34', '::1'),
(47, 1, 'Add Schedule', 'Added a schedule for Doctor Ben Test Manatad', 'tbl_doctor_schedule', 2, '2024-10-27 09:53:31', '::1'),
(48, 1, 'Add Schedule', 'Added a schedule for Doctor Joven  Joven', 'tbl_doctor_schedule', 3, '2024-10-27 13:09:48', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_birthing_medication`
--

CREATE TABLE `tbl_birthing_medication` (
  `medicationID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `medicineID` int(11) NOT NULL,
  `dosage` varchar(20) NOT NULL,
  `Frequency` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `date_signature` date NOT NULL,
  `signature` varchar(50) NOT NULL,
  `medProcedure` varchar(150) NOT NULL,
  `Specimen` varchar(150) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthing_medication`
--

INSERT INTO `tbl_birthing_medication` (`medicationID`, `patient_id`, `orderDate`, `medicineID`, `dosage`, `Frequency`, `time`, `date_signature`, `signature`, `medProcedure`, `Specimen`, `birth_info_id`, `created_at`) VALUES
(1, 8, '2024-10-17', 2, 'fsda', 'fsda', '16:26:00', '2024-10-17', 'sample1', 'fsda', 'fdsa', 1, '2024-10-17 16:26:55'),
(2, 8, '2024-10-17', 2, 'fdsa', 'fdsa', '17:27:00', '2024-10-17', 'fdsafsa', 'fsda', 'fdsa', 1, '2024-10-17 16:27:09'),
(3, 6, '2024-10-18', 2, '10', '2 X A DAY', '20:53:00', '2024-10-18', 'dfsad', 'fdassssssssssss', 'fdsaf', 2, '2024-10-18 08:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_birthing_monitoring`
--

CREATE TABLE `tbl_birthing_monitoring` (
  `birthMonitorID` int(11) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `case_no` varchar(100) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `parity` varchar(100) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `admission_time` time DEFAULT NULL,
  `time_active` time DEFAULT NULL,
  `time_membranes` time DEFAULT NULL,
  `time_second` time DEFAULT NULL,
  `birth_time` time NOT NULL,
  `oxytocin` varchar(50) DEFAULT NULL,
  `placenta_complete` varchar(50) DEFAULT NULL,
  `estimated` varchar(50) DEFAULT NULL,
  `time_delivered` time DEFAULT NULL,
  `live_birth` varchar(50) DEFAULT NULL,
  `RESUSCITATION` varchar(20) NOT NULL,
  `birth_weight` varchar(50) DEFAULT NULL,
  `preterm` varchar(50) DEFAULT NULL,
  `second_baby` varchar(50) DEFAULT NULL,
  `newborn` varchar(50) DEFAULT NULL,
  `stage_of_labour` varchar(20) DEFAULT NULL,
  `ruptured_membranes` text DEFAULT NULL,
  `vaginal_bleeding` text DEFAULT NULL,
  `strong_contractions` text DEFAULT NULL,
  `fetal_heart_rate` text DEFAULT NULL,
  `temperature_axillary` text DEFAULT NULL,
  `pulse` text DEFAULT NULL,
  `respiratory_rate` text DEFAULT NULL,
  `blood_pressure` text DEFAULT NULL,
  `urine_voided` text DEFAULT NULL,
  `cervical_dilatation` text DEFAULT NULL,
  `maternal_plan` varchar(255) DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `time_onset` varchar(100) DEFAULT NULL,
  `treatments` text DEFAULT NULL,
  `referral_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthing_monitoring`
--

INSERT INTO `tbl_birthing_monitoring` (`birthMonitorID`, `birth_info_id`, `case_no`, `patient_id`, `parity`, `admission_date`, `admission_time`, `time_active`, `time_membranes`, `time_second`, `birth_time`, `oxytocin`, `placenta_complete`, `estimated`, `time_delivered`, `live_birth`, `RESUSCITATION`, `birth_weight`, `preterm`, `second_baby`, `newborn`, `stage_of_labour`, `ruptured_membranes`, `vaginal_bleeding`, `strong_contractions`, `fetal_heart_rate`, `temperature_axillary`, `pulse`, `respiratory_rate`, `blood_pressure`, `urine_voided`, `cervical_dilatation`, `maternal_plan`, `problem`, `time_onset`, `treatments`, `referral_details`, `created_at`) VALUES
(1, 1, '20241017001', 8, 'fdsfds', '2024-10-17', '16:25:00', '16:25:00', '16:25:00', '16:25:00', '16:25:00', '16:25', 'Yes', 'fds', '16:25:00', 'Livebirth', 'Yes', '4kg', 'Yes', 'fsd', 'fdsa', 'ACTIVE LABOUR', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', 'fdsafd', 'fdsa', 'fdsa', 'fdsa', 'fdsa', '2024-10-17 08:26:04'),
(2, 2, '20241017001', 6, 'fdsa', '2024-10-03', '05:00:00', '19:00:00', '15:00:00', '08:00:00', '20:08:00', '04:29', 'Yes', '122', '08:00:00', 'Livebirth', 'Yes', 'ffffff', 'Yes', 'no', '1123', 'NOT IN ACTIVE LABOUR', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', '[\"11\"]', 'FDSAFDFFFFFF', '12', '12', '12', '12', '2024-10-18 00:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_birthroom`
--

CREATE TABLE `tbl_birthroom` (
  `roomID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `dateAdmitted` date DEFAULT NULL,
  `gravida` varchar(20) NOT NULL,
  `para` varchar(20) NOT NULL,
  `fullTerm` varchar(20) NOT NULL,
  `premature` varchar(20) NOT NULL,
  `abortion` varchar(20) NOT NULL,
  `noOfLiving` varchar(20) NOT NULL,
  `labor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`labor`)),
  `placenta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`placenta`)),
  `method_delivery` varchar(255) NOT NULL,
  `Episiotomy` varchar(255) NOT NULL,
  `Laceration` varchar(255) NOT NULL,
  `Anethesia` varchar(255) NOT NULL,
  `Analgesia` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `urinary_bladder` varchar(255) NOT NULL,
  `uterus` varchar(255) NOT NULL,
  `pregnancy` varchar(255) NOT NULL,
  `not_related` varchar(255) NOT NULL,
  `complications` varchar(255) NOT NULL,
  `Handled_by` varchar(30) NOT NULL,
  `assisted_by` varchar(30) NOT NULL,
  `physician` int(11) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthroom`
--

INSERT INTO `tbl_birthroom` (`roomID`, `patient_id`, `dateAdmitted`, `gravida`, `para`, `fullTerm`, `premature`, `abortion`, `noOfLiving`, `labor`, `placenta`, `method_delivery`, `Episiotomy`, `Laceration`, `Anethesia`, `Analgesia`, `condition`, `urinary_bladder`, `uterus`, `pregnancy`, `not_related`, `complications`, `Handled_by`, `assisted_by`, `physician`, `birth_info_id`, `created_at`) VALUES
(1, 8, '2024-10-18', 'fsda', 'fdsa', 'fsda', 'fsd', '', '', '{\"labor\":{\"types\":[\"Spontaneous\"],\"time\":\"08:51\",\"date\":\"08\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"cervix\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"baby\":{\"time\":\"20:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"placenta\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}}}', '{\"placenta\":{\"expelled\":[\"Expelled Completely\"]},\"umbilicalCord\":{\"cm\":\"21\",\"loops\":\"2\",\"none\":\"None\"},\"other\":\"2\",\"bloodLoss\":{\"antepartum\":\"2\",\"intrapartum\":\"2\",\"postpartum\":\"2\",\"total\":\"2\"}}', '[\"Cesarean\",\"\"]', '[]', '[]', '[]', '[]', '[]', '[\"\"]', '[]', '', '', '', 'fsda', 'fdsa', 31, 1, '2024-10-17 12:28:09'),
(2, 6, '2024-10-03', '1', '1', '1', '', '', '', '{\"labor\":{\"types\":[\"Spontaneous\"],\"time\":\"08:51\",\"date\":\"08\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"cervix\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"baby\":{\"time\":\"20:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"placenta\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}}}', '{\"placenta\":{\"expelled\":[\"Retained for Method of Expulsion\"]},\"umbilicalCord\":{\"cm\":\"1\",\"loops\":\"1\",\"none\":\"None\"},\"other\":\"1\",\"bloodLoss\":{\"antepartum\":\"1\",\"intrapartum\":\"1\",\"postpartum\":\"1\",\"total\":\"1\"}}', '[\"Cesarean\",\"\"]', '[\"Median\"]', '[\"Perinial 1 2 3\"]', '[\"Local Infiltration\"]', '[\"Yes\"]', '[\"Reactive\"]', '[\"Voided\",\"1\"]', '[\"Relaxing\"]', 'None', 'None', 'None', '1', '1', 31, 2, '2024-10-18 08:52:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_birth_info`
--

CREATE TABLE `tbl_birth_info` (
  `birth_info_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `case_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `LMP` varchar(100) DEFAULT NULL,
  `EDC` varchar(100) DEFAULT NULL,
  `AOG` varchar(100) DEFAULT NULL,
  `OBSCORE` varchar(255) DEFAULT NULL,
  `chief_complaint` text DEFAULT NULL,
  `past_med_history` text DEFAULT NULL,
  `past_operations` text DEFAULT NULL,
  `medication` text DEFAULT NULL,
  `past_admission` text DEFAULT NULL,
  `family_history` text DEFAULT NULL,
  `ps_history` text DEFAULT NULL,
  `gyne_history` text DEFAULT NULL,
  `present_pregnancy` text DEFAULT NULL,
  `obstetrical_history` text DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `systemReviewID` int(11) NOT NULL,
  `physicalExamID` int(11) NOT NULL,
  `midwife_nurse` varchar(100) NOT NULL,
  `birthing_status` enum('ongoing','done') DEFAULT 'ongoing',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birth_info`
--

INSERT INTO `tbl_birth_info` (`birth_info_id`, `patient_id`, `case_no`, `date`, `LMP`, `EDC`, `AOG`, `OBSCORE`, `chief_complaint`, `past_med_history`, `past_operations`, `medication`, `past_admission`, `family_history`, `ps_history`, `gyne_history`, `present_pregnancy`, `obstetrical_history`, `userID`, `systemReviewID`, `physicalExamID`, `midwife_nurse`, `birthing_status`, `created_at`) VALUES
(1, 8, '20241017001', '2024-10-17', 'fd', 'fds', 'fds', '{\"g\":\"fds\",\"p\":\"fds\",\"term\":\"fds\",\"preterm\":\"fd\",\"abortion\":\"fd\",\"living\":\"fd\"}', 'fdsaf', '[\"Heart Disease\",\"\"]', '', '', '', '[\"Hypertension\",\"\"]', '{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}', '{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}', '{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"fds\",\"illness\":\"fds\",\"tot_visit\":\"fds\",\"others\":\"\"}', '[{\"year\":\"fsd\",\"place_of_confinement\":\"fds\",\"aog\":\"fds\",\"bw\":\"fd\",\"manner_of_delivery\":\"sfds\",\"complication_remarks\":\"fds\"}]', 7, 1, 1, '31', 'done', '2024-10-17'),
(2, 6, '20241018001', '2024-10-18', '2', '2', '2', '{\"g\":\"2\",\"p\":\"2\",\"term\":\"2\",\"preterm\":\"2\",\"abortion\":\"2\",\"living\":\"22\"}', 'fdsa', '[\"Pulmonary TB\",\"\"]', 'fdsa', 'fdsa', 'fdsa', '[\"Hypertension\",\"\"]', '{\"smoking\":\"Yes\"}', '{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}', '{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"\",\"illness\":\"\",\"tot_visit\":\"\",\"others\":\"\"}', '[{\"year\":\"12\",\"place_of_confinement\":\"21\",\"aog\":\"12\",\"bw\":\"2\",\"manner_of_delivery\":\"2\",\"complication_remarks\":\"2\"}]', 7, 2, 2, '31', 'ongoing', '2024-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_birth_ivfluids`
--

CREATE TABLE `tbl_birth_ivfluids` (
  `fluidsID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeStarted` time NOT NULL,
  `timeconsumed` time NOT NULL,
  `bottleno` varchar(100) NOT NULL,
  `solution` varchar(100) NOT NULL,
  `signature_remarks` varchar(100) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birth_ivfluids`
--

INSERT INTO `tbl_birth_ivfluids` (`fluidsID`, `patient_id`, `date`, `timeStarted`, `timeconsumed`, `bottleno`, `solution`, `signature_remarks`, `birth_info_id`, `created_at`) VALUES
(1, 8, '2024-10-17', '16:27:00', '16:27:00', '1', 'fdsa', 'fsda', 1, '2024-10-17 08:27:18'),
(2, 6, '2024-10-18', '08:52:00', '08:52:00', '2', 'fdsa', 'fsda', 2, '2024-10-18 00:53:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_certificate_log`
--

CREATE TABLE `tbl_certificate_log` (
  `log_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `generated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_certificate_log`
--

INSERT INTO `tbl_certificate_log` (`log_id`, `patient_id`, `generated_at`, `status`, `file_path`) VALUES
(2, 5, '2024-09-23 18:48:40', 'done', 'D:\\xampp\\htdocs\\MH_Office_final\\RHU/certificates/5_2024-09-23.pdf'),
(3, 1, '2024-09-23 18:49:25', 'done', 'D:\\xampp\\htdocs\\MH_Office_final\\RHU/certificates/1_2024-09-23.pdf'),
(4, 8, '2024-10-18 15:57:29', 'done', 'D:\\xampp\\htdocs\\MH_Office\\RHU/certificates/8_2024-10-18.pdf'),
(5, 7, '2024-10-18 16:02:21', 'done', 'D:\\xampp\\htdocs\\MH_Office\\RHU/certificates/7_2024-10-18.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checkup`
--

CREATE TABLE `tbl_checkup` (
  `checkupID` int(11) NOT NULL,
  `admitted` datetime NOT NULL,
  `history` varchar(255) NOT NULL,
  `per_pas_med` varchar(255) NOT NULL,
  `pertinent_signs` varchar(255) NOT NULL,
  `gen_survey` varchar(255) NOT NULL,
  `heent` varchar(255) NOT NULL,
  `chest` varchar(255) NOT NULL,
  `CSV` varchar(255) NOT NULL,
  `abdomen` varchar(255) NOT NULL,
  `GU` varchar(255) NOT NULL,
  `skin_extremeties` varchar(255) NOT NULL,
  `neuro_exam` varchar(255) NOT NULL,
  `disability` varchar(50) NOT NULL,
  `disability_type` varchar(50) NOT NULL,
  `doctor_order` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `no_illness` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkup`
--

INSERT INTO `tbl_checkup` (`checkupID`, `admitted`, `history`, `per_pas_med`, `pertinent_signs`, `gen_survey`, `heent`, `chest`, `CSV`, `abdomen`, `GU`, `skin_extremeties`, `neuro_exam`, `disability`, `disability_type`, `doctor_order`, `patient_id`, `no_illness`, `created_at`) VALUES
(1, '2024-09-14 11:52:00', '', '', '[\"\"]', '', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', 'no', '', 'able to work', 1, 1, '2024-09-14 03:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clinicalrecords`
--

CREATE TABLE `tbl_clinicalrecords` (
  `recordID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `employer` varchar(50) DEFAULT NULL,
  `empaddress` varchar(255) DEFAULT NULL,
  `tel_cell-no` varchar(50) NOT NULL,
  `admission_date` date DEFAULT NULL,
  `admission_time` time DEFAULT NULL,
  `dischargeDate` date DEFAULT NULL,
  `dischargeTime` time NOT NULL,
  `type_of_admission` varchar(100) DEFAULT NULL,
  `admitting_midwife` varchar(100) DEFAULT NULL,
  `datafurnished` varchar(255) NOT NULL,
  `datafurnishedaddress` varchar(255) NOT NULL,
  `admitting_diagnosis` text DEFAULT NULL,
  `final_diagnosis` text DEFAULT NULL,
  `procedure_done` text DEFAULT NULL,
  `disposition` text DEFAULT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_clinicalrecords`
--

INSERT INTO `tbl_clinicalrecords` (`recordID`, `patient_id`, `employer`, `empaddress`, `tel_cell-no`, `admission_date`, `admission_time`, `dischargeDate`, `dischargeTime`, `type_of_admission`, `admitting_midwife`, `datafurnished`, `datafurnishedaddress`, `admitting_diagnosis`, `final_diagnosis`, `procedure_done`, `disposition`, `birth_info_id`, `created_at`) VALUES
(1, 8, 'fdsa', 'fdsafsdafa', '', '2024-10-17', '16:25:00', '2024-10-15', '16:29:00', 'new', 'Angel  Lobrido', 'roel cabigas', 'national highway DSWD', 'fdsa', 'sfda', 'fdsa', 'improved', 1, '2024-10-16 08:29:37'),
(2, 6, '1', 'AFDSAFSDAF', '', '2024-10-03', '05:00:00', '2024-10-17', '10:50:00', 'old', 'Angel  Lobrido', 'FSA', 'FDSA', 'FDSA', 'FDSA', 'FDSAF', 'unimproved', 2, '2024-10-18 02:50:45'),
(3, 8, '1232', 'fdsafsdafa', '0965321546', '2024-10-17', '16:25:00', '2024-10-15', '16:29:00', 'new', 'Angel  Lobrido', 'roel cabigas', 'national highway DSWD', 'fdsa', 'sfda', 'fdsa', 'improved', 1, '2024-10-17 08:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_complaints`
--

CREATE TABLE `tbl_complaints` (
  `complaintID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `Chief_Complaint` varchar(255) NOT NULL,
  `Remarks` varchar(255) NOT NULL,
  `bp` varchar(20) NOT NULL,
  `hr` varchar(20) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `rr` varchar(20) NOT NULL,
  `temp` varchar(20) NOT NULL,
  `Height` varchar(20) NOT NULL,
  `Nature_Visit` varchar(100) NOT NULL,
  `consultation_purpose` varchar(100) NOT NULL,
  `refferred` varchar(100) NOT NULL,
  `reason_ref` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `pr` varchar(50) NOT NULL,
  `O2SAT` varchar(50) NOT NULL,
  `transferred` varchar(50) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_complaints`
--

INSERT INTO `tbl_complaints` (`complaintID`, `patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`, `Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `reason_ref`, `status`, `pr`, `O2SAT`, `transferred`, `created_at`) VALUES
(1, 8, '', '', '122 / 90', '2', '2kg', '20', '2°C', '2cm', 'Follow-up visit', 'Birthing', 'fdsa', 'sda', 'Done', '2', '', '', '2024-10-17'),
(2, 6, '', '', '122 / 80_', '22', '2kg', '21', '2°C', '2cm', 'Follow-up visit', 'Birthing', 'fdsa', 'fdsa', 'Under Monitoring', '02', '', '', '2024-10-18'),
(3, 7, 'fdsa', 'fdsa', '122 / 80_', '12', '2kg', '22', '35°C', '12cm', 'Follow-up visit', 'Animal bite and Care', 'fdsa', 'fsda', 'for vaccination', '2', '', '', '2024-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discharged`
--

CREATE TABLE `tbl_discharged` (
  `dischargedid` int(11) NOT NULL,
  `patientid` int(11) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `date_discharged` date DEFAULT NULL,
  `home_medications` text DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `nurse_midwife` varchar(100) DEFAULT NULL,
  `physician` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_discharged`
--

INSERT INTO `tbl_discharged` (`dischargedid`, `patientid`, `birth_info_id`, `diagnosis`, `date_discharged`, `home_medications`, `follow_up_date`, `nurse_midwife`, `physician`, `created_at`) VALUES
(5, 5, 1, 'fda', '2024-10-06', '[\"fdsa\",\"fdsa\",\"fas\"]', '2024-10-06', '31', '38', '2024-10-06 03:11:18'),
(7, 5, 2, 'fdsa', '2024-10-02', '[\"REW\",\"fdsa\"]', '2024-10-12', '31', '38', '2024-10-06 03:33:52'),
(8, 8, 6, 'fdsa', '2024-10-15', '[\"fsadfsda\",\"fdsaf\"]', '2024-10-15', '31', '38', '2024-10-15 08:42:54'),
(9, 6, 4, 'fdsafsdaf', '2024-10-17', '[\"fsdaffds\"]', '2024-10-23', '31', '38', '2024-10-17 07:55:04'),
(10, 8, 1, 'fdsafdsa', '2024-10-17', '[\"ffdsafd\",\"fdsafd\",\"fdsafd\"]', '2024-10-23', '31', '38', '2024-10-17 08:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctor_schedule`
--

CREATE TABLE `tbl_doctor_schedule` (
  `doc_scheduleID` int(11) NOT NULL,
  `userID` varchar(50) NOT NULL,
  `date_schedule` date DEFAULT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1 COMMENT '0=not availble,1=available',
  `work_length` varchar(50) DEFAULT NULL,
  `reapet` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_doctor_schedule`
--

INSERT INTO `tbl_doctor_schedule` (`doc_scheduleID`, `userID`, `date_schedule`, `day_of_week`, `start_time`, `end_time`, `is_available`, `work_length`, `reapet`, `created_at`) VALUES
(2, '29', NULL, 'Sunday,Tuesday', '17:53,20:53,17:52', '19:53,21:53,19:52', 1, '2h 0m,,2h 0m,,,,', 'Weekly', '2024-10-27 09:53:31'),
(3, '39', NULL, 'SUNDAY,MONDAY,TUESDAY,WEDNESDAY,THURSDAY,FRIDAY', '21:09,21:09,21:09,21:09,21:09,09:09', '22:09,22:09,22:09,22:09,22:09,21:09', 1, '1h 0m,1h 0m,1h 0m,1h 0m,1h 0m,12h 0m,', 'Monthly', '2024-10-27 13:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_familyaddress`
--

CREATE TABLE `tbl_familyaddress` (
  `famID` int(11) NOT NULL,
  `brgy` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_familyaddress`
--

INSERT INTO `tbl_familyaddress` (`famID`, `brgy`, `purok`, `city_municipality`, `province`, `place_of_birth`, `created_at`, `updated_at`) VALUES
(1, 'Sampao', 'Magsaysay', 'Lutayan', 'Sultan Kudarat', 'sultan kudarat', '2024-09-09 02:02:11', NULL),
(3, 'Bayasong', 'Riverside', 'City Of Koronadal (Capital)', 'South Cotabato', 'LAMBA, BANGA', '2024-09-13 00:08:05', '2024-10-13 23:28:22'),
(4, 'Blingkong', 'Masagana', '	 Lutayan', 'South Cotabato', '	\nLutayan', '2024-09-13 03:19:29', '2024-10-16 05:52:18'),
(5, 'Punol', 'Lacia Residence', 'Lutayan', 'Sultan Kudarat', 'LAMBA', '2024-09-13 03:31:32', NULL),
(6, 'Sampao', '', 'Lutayan', 'Sultan Kudarat', 'hfggh', '2024-09-14 05:18:45', NULL),
(7, 'Mamali', 'Pag Asa', 'Lutayan', 'Sultan Kudarat', 'pag asa', '2024-09-17 06:09:14', NULL),
(8, 'Bayasong', 'Riverside', 'Lutayan', 'Sultan Kudarat', 'sultan kudarat', '2024-10-15 08:25:36', '2024-10-15 08:34:58'),
(9, 'Manili', 'Fdsa', 'Lutayan', 'Sultan Kudarat', 'fdsa', '2024-10-18 01:50:56', NULL),
(10, 'Bayasong', 'Fsda', 'Lutayan', 'Sultan Kudarat', 'fdsa', '2024-10-18 07:37:01', '2024-10-21 02:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_family_members`
--

CREATE TABLE `tbl_family_members` (
  `member_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_family_members`
--

INSERT INTO `tbl_family_members` (`member_id`, `name`, `relationship`, `contact`, `address`, `patient_id`, `created_at`) VALUES
(1, 'test', 'Father', '+639123131231', 'PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CITY SOUTH COTABATO', 10, '2024-10-18 07:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_healthnotes`
--

CREATE TABLE `tbl_healthnotes` (
  `notedsID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `doctorNotes` varchar(255) NOT NULL,
  `nureNotes` varchar(255) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_healthnotes`
--

INSERT INTO `tbl_healthnotes` (`notedsID`, `patient_id`, `userID`, `date`, `time`, `doctorNotes`, `nureNotes`, `birth_info_id`, `created_at`) VALUES
(1, 8, 29, '2024-10-17', '16:29:00', 'fdsaffffffff', '', 1, '2024-10-17 16:29:11'),
(2, 8, 29, '2024-10-17', '04:29:00', 'fdsafdaf', '', 1, '2024-10-17 16:29:11'),
(3, 8, 29, '2024-10-17', '04:29:00', '', 'fdsafdaf', 1, '2024-10-17 16:29:11'),
(4, 6, 29, '2024-10-18', '08:06:00', 'fdsaffffff', '', 2, '2024-10-18 08:06:34'),
(5, 6, 29, '2024-10-07', '08:06:00', 'fdsafdfffff', '', 2, '2024-10-18 08:06:34'),
(6, 6, 0, '2024-10-16', '08:06:00', '', 'fdsafsd', 2, '2024-10-18 08:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_immunization_records`
--

CREATE TABLE `tbl_immunization_records` (
  `immunID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `immunization_date` date DEFAULT NULL,
  `immunization_next_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laboratory`
--

CREATE TABLE `tbl_laboratory` (
  `labid` int(11) NOT NULL,
  `services` varchar(100) NOT NULL,
  `date_test` date DEFAULT NULL,
  `test_result` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_laboratory`
--

INSERT INTO `tbl_laboratory` (`labid`, `services`, `date_test`, `test_result`, `patient_id`, `image`, `created_at`) VALUES
(1, 'Complete Blood Count (CBC)', '2024-09-09', 'fsa', 1, '', '2024-09-09 02:59:08'),
(2, 'Urinalysis', '2024-09-13', 'hardware.PNG', 3, '', '2024-09-13 03:16:13'),
(3, 'Sputum Examination', '2024-09-13', '', 3, '', '2024-09-13 03:16:32'),
(4, 'Complete Blood Count (CBC)', '2024-10-01', 'positive', 10, 'Patients-PNG-HD.png', '2024-10-18 07:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicines`
--

CREATE TABLE `tbl_medicines` (
  `medicineID` int(11) NOT NULL,
  `medicine_name` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `manuf_date` date NOT NULL,
  `ex_date` date DEFAULT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_medicines`
--

INSERT INTO `tbl_medicines` (`medicineID`, `medicine_name`, `description`, `supplier`, `category`, `manuf_date`, `ex_date`, `manufacturer`, `brand`, `date_added`) VALUES
(1, 'Polio', 'Poliomyelitis, Commonly Shortened To Polio, Is An Infectious Disease Caused By The Poliovirus. Approximately 75% Of Cases Are Asymptomatic', 'Test', 'Vaccines', '2024-09-12', '2027-03-05', 'test', 'branded', '2024-09-12 15:14:39'),
(2, 'Bio-flu', 'Test', 'Cefdinir', 'Antibiotics', '2024-09-12', '2027-04-21', 'Cefdinir', 'Cefdinir', '2024-09-13 15:31:31'),
(3, 'Anti-rabies', 'Anti-rabies', 'Anti-rabies', 'Vaccines', '2024-09-22', '2024-09-22', 'Anti-Rabies', 'Anti-Rabies', '2024-09-22 11:21:12'),
(4, 'Bcg Vaccine', 'Bcg Vaccine', 'Bcg Vaccine', 'Vaccines', '2024-10-16', '2027-02-04', 'BCG Vaccine', 'BCG Vaccine', '2024-10-16 13:30:08'),
(5, 'Hepatitis B Vaccine', 'Hepatitis B Vaccine', 'Hepatitis B Vaccine', 'Vaccines', '2024-10-16', '2026-05-06', 'Hepatitis B Vaccine', 'Hepatitis B Vaccine', '2024-10-16 13:30:30'),
(6, 'Pentavalent Vaccine', 'Pentavalent Vaccine', 'Pentavalent Vaccine', 'Vaccines', '2024-10-16', '2029-02-01', 'Pentavalent Vaccine', 'Pentavalent Vaccine', '2024-10-16 13:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicine_details`
--

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_medicine_details`
--

INSERT INTO `tbl_medicine_details` (`med_detailsID`, `medicine_id`, `packing`, `qt`) VALUES
(1, 2, 'mg', '438'),
(2, 3, 'injectable', '295'),
(3, 6, 'injectable', '19'),
(4, 1, 'injectable', '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_membership_info`
--

CREATE TABLE `tbl_membership_info` (
  `membershipID` int(11) NOT NULL,
  `phil_mem` varchar(50) NOT NULL,
  `philhealth_no` varchar(255) DEFAULT NULL,
  `phil_membership` varchar(100) NOT NULL,
  `ps_mem` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_membership_info`
--

INSERT INTO `tbl_membership_info` (`membershipID`, `phil_mem`, `philhealth_no`, `phil_membership`, `ps_mem`, `created_at`, `updated_at`) VALUES
(1, 'Yes', '062469896512', 'Member', '4PS', '2024-09-10 16:00:00', '2024-10-08 03:14:52'),
(3, 'Yes', '123123123123', 'Member', 'LGU', '2024-09-13 00:08:05', '2024-10-13 23:28:22'),
(4, 'No', '', '', 'NHTS', '2024-09-13 03:19:29', '2024-10-16 05:52:19'),
(5, 'Yes', '123112312312', 'Dependent', '4PS', '2024-09-13 03:31:32', NULL),
(6, 'Yes', '123123121222', 'Dependent', '4PS', '2024-09-14 05:18:45', NULL),
(7, 'No', '', '', '4PS', '2024-09-17 06:09:14', '2024-09-26 09:44:48'),
(8, 'Yes', '123333333333', 'Member', '4PS', '2024-10-15 08:25:36', '2024-10-15 08:34:58'),
(9, 'No', '', '', 'LGU', '2024-10-18 01:50:56', '2024-10-21 02:16:03'),
(10, 'No', '', '', 'LGU', '2024-10-18 07:37:02', '2024-10-21 02:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patients`
--

CREATE TABLE `tbl_patients` (
  `patientID` int(11) NOT NULL,
  `family_address` int(11) DEFAULT NULL,
  `Membership_Info` int(11) DEFAULT NULL,
  `household_no` varchar(255) NOT NULL,
  `patient_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `father_guardian_name` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `cnic` varchar(100) NOT NULL,
  `date_of_birth` varchar(100) NOT NULL,
  `age` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `blood_type` varchar(20) NOT NULL,
  `ed_at` varchar(100) NOT NULL,
  `emp_stat` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`patientID`, `family_address`, `Membership_Info`, `household_no`, `patient_name`, `middle_name`, `last_name`, `suffix`, `father_guardian_name`, `mother_name`, `cnic`, `date_of_birth`, `age`, `phone_number`, `gender`, `civil_status`, `blood_type`, `ed_at`, `emp_stat`, `religion`, `Nationality`, `reg_date`, `userID`, `updated_at`) VALUES
(1, 1, 1, '1399077', 'Ronaldo', '', 'Teere', '', 'Alexa', 'Pablito', '0000000001', '2024-09-02', '0 Months', '+63096778195', 'Male', 'Married', 'A+', 'No Formal Education', 'Patient', 'Islam', 'Filipino', '2024-09-09 10:02:11', 7, '2024-10-08 03:14:52'),
(3, 3, 3, '1399078', 'Joven Rey', '', 'Flores', '', 'Eleonora', 'Pablito', '0000000002', '2024-10-14', '31 Years', '+630967781950', 'Male', 'Married', 'A+', 'College Level', 'Radio Operator', 'Baptists', 'Filipino', '2024-09-13 08:08:05', 7, '2024-10-13 23:28:22'),
(4, 4, 4, '1399079', 'George', 'B', 'laput', '', 'Fdsa', 'Fdsafd', '0000000004', '2024-09-04', '0 Months', '9999999999', 'Other', 'Married', 'A-', 'No Formal Education', 'Fdsaf', 'Islam', 'Filipino', '2024-09-13 11:19:29', 8, '2024-10-16 05:52:19'),
(5, 5, 5, '1399080', 'Lorena', 'ALCANTARA', 'LACIA', '', 'alexa', 'pablito', '0000000005', '1999-04-20', '25 years', '+639677819501', 'Female', 'Single', 'A-', 'Elementary', 'none', 'Roman Catholic', 'Filipino', '2024-09-13 11:31:32', 7, NULL),
(6, 6, 6, '1399081', 'Josh', 'b', 'garcia', '', 'danna', 'pedro', '0000000006', '1993-02-04', '31 years', '+639999999999', 'Female', 'Single', 'B+', 'College Level', 'test', 'Roman Catholic', 'Filipino', '2024-09-14 13:18:45', 37, '2024-10-09 02:45:50'),
(7, 7, 7, '1399082', 'Irlan', '', 'Badio', '', 'Fds', 'Affdsa', '0000000007', '1999-02-10', '25 Years', '+630967781950', 'Male', 'Single', 'A-', '', '', '', 'Filipino', '2024-09-17 14:09:14', 8, '2024-09-26 09:44:48'),
(8, 8, 8, '1399083', 'Irene', 'B', 'Basco', '', 'Danna', 'Roberta', '0000000008', '1985-02-10', '35 Years', '+639531167141', 'Female', 'Single', 'A-', 'Elementary', '', '', 'Filipino', '2024-10-15 16:25:36', 7, '2024-10-18 01:56:19'),
(9, 9, 9, '1399084', 'Marcelo', '', 'panopio', '', 'Fdsa', 'Fdsa', '0000000009', '2024-10-21', '0 Months', '+630999999999', 'Other', 'Single', 'A+', '', 'Dfsafd', 'Kingdom of Jesus Christ, The Name Above Every Name(KOJIC)', 'Asian', '2024-10-18 09:50:56', 7, '2024-10-21 02:16:03'),
(10, 10, 10, '1399085', 'Rolly Beans', 'v', 'Anderson', '', 'Fdsa', 'Fdsa', '0000000010', '2024-10-21', '0 Months', '+630999999999', 'Other', 'Single', 'A-', '', 'Dfsafd', 'Islam', 'Filipino', '2024-10-18 15:37:02', 7, '2024-10-21 02:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_medication_history`
--

CREATE TABLE `tbl_patient_medication_history` (
  `patient_med_historyID` int(11) NOT NULL,
  `patient_visit_id` int(11) NOT NULL,
  `medicine_details_id` int(11) NOT NULL,
  `con_type` varchar(30) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `dosage` varchar(20) NOT NULL,
  `schedule_dosage` varchar(100) NOT NULL,
  `mg_ml` varchar(20) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `time_frame` varchar(100) NOT NULL,
  `advice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_patient_medication_history`
--

INSERT INTO `tbl_patient_medication_history` (`patient_med_historyID`, `patient_visit_id`, `medicine_details_id`, `con_type`, `quantity`, `dosage`, `schedule_dosage`, `mg_ml`, `duration`, `time_frame`, `advice`) VALUES
(1, 1, 2, 'Oral(p/o)', '3', 'as needed', '', '500 mg', 'Every 4 hours', '3 (Day)', 'test'),
(2, 2, 2, 'Oral(p/o)', '1', 'schedule dose', 'After Meal', '11 mg', 'Daily', '2 (Day)', 'test'),
(4, 4, 2, 'Oral(p/o)', '2', 'as needed', '', '100 mg', 'Daily', '1 (Day)', 'fdsa'),
(5, 5, 2, 'Oral(p/o)', '10', 'as needed', '', '1-00 mg', 'Every 3 hours', '3 (Day)', 'test'),
(6, 6, 2, 'Oral(p/o)', '10', 'as needed', '', '500 MG', 'Every 4 hours', '2 (Day)', 'FDSA'),
(7, 7, 2, 'Oral(p/o)', '10', 'as needed', '', '100 mg', 'Hourly', '3 (Day)', 'fdsafa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_visits`
--

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_patient_visits`
--

INSERT INTO `tbl_patient_visits` (`patient_visitID`, `visit_date`, `next_visit_date`, `disease`, `recom`, `patient_id`, `doctor_id`) VALUES
(1, '2024-09-13', '2024-09-18', 'cough', 'test', 3, 29),
(2, '2024-09-13', '2024-09-25', 'none', 'able to work', 3, 31),
(4, '2024-09-14', '2024-09-18', 'cough', 'fdsa', 4, 29),
(5, '2024-09-14', '2024-09-17', 'fever', 'test', 4, 29),
(6, '2024-09-14', '2024-09-24', 'cough', 'FDSA', 6, 29),
(7, '2024-09-17', '2024-09-24', 'cough', 'test', 7, 29);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personnel`
--

CREATE TABLE `tbl_personnel` (
  `personnel_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personnel`
--

INSERT INTO `tbl_personnel` (`personnel_id`, `first_name`, `middlename`, `lastname`, `contact`, `email`, `address`) VALUES
(1, 'admin', 'M.', 'admin', 'Koronadal City', 'admin@gmail.com', '+639645563132'),
(7, 'Rhu', 'R', 'Rhu', '+639623564556', 'rhulutayan@gmail.com', '+631232131321'),
(8, 'Elleen', '', 'Tunguia', '+634744477477', 'elleen@gmail.com', 'Koronadal City , South Cotabato'),
(34, 'Ben', 'Test', 'Manatad', '+639665123213', 'test@gmail.com', 'Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato'),
(36, 'Angel', '', 'Lobrido', '+639665123213', 'angel@GMAIL.COM', 'koronadal city , south cotabato'),
(41, 'Joven Rey', '', 'Flores', '+630967781950', 'floresjovenrey26@gmail.com', 'Koronadal City , South Cotabato'),
(42, 'Test', 'V', 'Test', '+630967781950', 'test26@gmail.com', 'Koronadal City , South Cotabato'),
(43, 'Carlos', '', 'Basco', '+639123123123', 'carlo@gmail.com', 'koronadal city , south cotabato'),
(44, 'Joven', '', 'Joven', '+639665123213', 'joven@gmail.com', 'Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_physicalexam`
--

CREATE TABLE `tbl_physicalexam` (
  `physical_exam_id` int(11) NOT NULL,
  `fht` varchar(50) DEFAULT NULL,
  `fundic_ht` varchar(50) DEFAULT NULL,
  `dilation` varchar(50) DEFAULT NULL,
  `effacement` varchar(50) DEFAULT NULL,
  `bow` varchar(50) DEFAULT NULL,
  `maneuver` varchar(255) NOT NULL,
  `SKIN` text DEFAULT NULL,
  `heent` text DEFAULT NULL,
  `chest_lungs` text DEFAULT NULL,
  `CARDIOVASCULAR` text DEFAULT NULL,
  `abdomen` text DEFAULT NULL,
  `extremities` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_physicalexam`
--

INSERT INTO `tbl_physicalexam` (`physical_exam_id`, `fht`, `fundic_ht`, `dilation`, `effacement`, `bow`, `maneuver`, `SKIN`, `heent`, `chest_lungs`, `CARDIOVASCULAR`, `abdomen`, `extremities`, `created_at`) VALUES
(1, 'dfs', 'fsd', 'fds', 'fdfd', 'fd', 'fds', '[\"Nodules\",\"\"]', '[\"anicteric sclerea\",\"Exudates\",\"\"]', '[\"\"]', '[\"Normal rate regular rhythm\",\"\"]', '[\"Muscle Guarding\",\"\"]', '[\"Full and equal pulses\",\"\"]', '2024-10-17 08:25:16'),
(2, 'fsd', 'fdsa', 'fsda', 'fdas', 'fdsa', 'fdsa', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"Palpable Mass \",\"\"]', '[\"\"]', '2024-10-18 00:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `PositionName` varchar(100) NOT NULL,
  `Specialty` varchar(100) NOT NULL,
  `ProfessionalType` varchar(100) NOT NULL,
  `LicenseNo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`position_id`, `personnel_id`, `PositionName`, `Specialty`, `ProfessionalType`, `LicenseNo`) VALUES
(1, 1, '', '', '', ''),
(7, 7, '', '', '', ''),
(8, 8, '', '', '', ''),
(34, 34, 'Family physician', 'Family physician', 'MD, FPSMS', '09523215'),
(36, 36, 'midwife', 'birhting', 'midwife', ''),
(41, 41, '', '', '', ''),
(42, 42, '', '', '', ''),
(43, 43, 'Physician', 'Physician', 'Physician', ''),
(44, 44, 'Physician', 'Physician', 'MD, FPSMS', '1231312321');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_postpartum`
--

CREATE TABLE `tbl_postpartum` (
  `postpartumID` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date_postpartum` date NOT NULL,
  `monitoring_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`monitoring_data`)),
  `maternal_wellbeing` varchar(255) NOT NULL,
  `uterine_firmness` varchar(255) NOT NULL,
  `rubra` varchar(255) NOT NULL,
  `perineum_pain` varchar(255) NOT NULL,
  `breast_condition` varchar(255) NOT NULL,
  `feeding` varchar(255) NOT NULL,
  `bladder` varchar(255) NOT NULL,
  `bowel_movement` varchar(255) NOT NULL,
  `vaginal_discharge` varchar(255) NOT NULL,
  `key_messages` text NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_postpartum`
--

INSERT INTO `tbl_postpartum` (`postpartumID`, `patient_id`, `date_postpartum`, `monitoring_data`, `maternal_wellbeing`, `uterine_firmness`, `rubra`, `perineum_pain`, `breast_condition`, `feeding`, `bladder`, `bowel_movement`, `vaginal_discharge`, `key_messages`, `birth_info_id`, `created_at`) VALUES
(1, 8, '2024-10-18', '{\"date\":\"2024-10-17\",\"time\":\"16:31\",\"monitoring\":{\"every5_15\":{\"times\":[\"\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}', '1. CONSCIOUS', '', '', '', '', '1. EXCLUSIVE BREASTFEEDING', '1. FULL BLADDER', '', 'Yes', '1. Proper Nutrition', 1, '2024-10-17 08:28:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prenatal`
--

CREATE TABLE `tbl_prenatal` (
  `prenatalID` int(11) NOT NULL,
  `date` date NOT NULL,
  `chief_complaint` varchar(100) NOT NULL,
  `attending_physician` int(11) NOT NULL,
  `lmp` varchar(20) NOT NULL,
  `ga_by_lmp` varchar(20) NOT NULL,
  `edc_by_lmp` varchar(20) NOT NULL,
  `fhr` varchar(20) NOT NULL,
  `ga_by_sonar` varchar(20) NOT NULL,
  `edc_by_utz` varchar(20) NOT NULL,
  `pregnancy_age` varchar(20) NOT NULL,
  `biparietal_diameter` varchar(20) NOT NULL,
  `biparietal_eq` varchar(20) NOT NULL,
  `head_circumference` varchar(20) NOT NULL,
  `head_circumference_eq` varchar(20) NOT NULL,
  `abdominal_circumference` varchar(20) NOT NULL,
  `abdominal_circumference_eq` varchar(20) NOT NULL,
  `femoral_length` varchar(20) NOT NULL,
  `femoral_length_eq` varchar(20) NOT NULL,
  `crown_rump_length` varchar(20) NOT NULL,
  `crown_rump_length_eq` varchar(20) NOT NULL,
  `mean_gest_sac_diameter` varchar(20) NOT NULL,
  `mean_gest_sac_diameter_eq` varchar(20) NOT NULL,
  `average_fetal_weight` varchar(20) NOT NULL,
  `gestation` varchar(20) DEFAULT NULL,
  `presentation_lie` varchar(20) DEFAULT NULL,
  `amniotic_fluid` varchar(20) DEFAULT NULL,
  `placenta_location` varchar(20) DEFAULT NULL,
  `previa` varchar(20) DEFAULT NULL,
  `placenta_grade` varchar(20) DEFAULT NULL,
  `fetal_activity` varchar(20) DEFAULT NULL,
  `comments` varchar(100) NOT NULL,
  `radiologist` varchar(30) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prenatal`
--

INSERT INTO `tbl_prenatal` (`prenatalID`, `date`, `chief_complaint`, `attending_physician`, `lmp`, `ga_by_lmp`, `edc_by_lmp`, `fhr`, `ga_by_sonar`, `edc_by_utz`, `pregnancy_age`, `biparietal_diameter`, `biparietal_eq`, `head_circumference`, `head_circumference_eq`, `abdominal_circumference`, `abdominal_circumference_eq`, `femoral_length`, `femoral_length_eq`, `crown_rump_length`, `crown_rump_length_eq`, `mean_gest_sac_diameter`, `mean_gest_sac_diameter_eq`, `average_fetal_weight`, `gestation`, `presentation_lie`, `amniotic_fluid`, `placenta_location`, `previa`, `placenta_grade`, `fetal_activity`, `comments`, `radiologist`, `patient_id`, `user_id`) VALUES
(1, '2024-09-20', '  22 ', 38, 'qweq', 'e', 'ewq', 'ewq', 'qwe', 'qwe', 'qew', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ewqeq', 'Totski', 6, 7),
(2, '2024-10-16', '  Fdsa ', 38, '13', '12', '2', '23', '32', '32', '23', '123', '1', '12', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'Single', 'Cephalic', 'Normal', 'Fundus', 'Low Lying', '0', 'limb', 'Fdsa', '1212', 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referrals_log`
--

CREATE TABLE `tbl_referrals_log` (
  `referral_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `referral_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_referrals_log`
--

INSERT INTO `tbl_referrals_log` (`referral_id`, `patient_id`, `referral_date`, `userID`, `status`) VALUES
(10, 6, '2024-09-14', 37, ''),
(11, 3, '2024-09-14', 7, ''),
(12, 5, '2024-09-20', 7, ''),
(13, 7, '2024-09-23', 7, ''),
(14, 6, '2024-10-09', 7, ''),
(15, 7, '2024-10-14', 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_systemreview`
--

CREATE TABLE `tbl_systemreview` (
  `system_review_id` int(11) NOT NULL,
  `general` text DEFAULT NULL,
  `skin` text DEFAULT NULL,
  `head` text DEFAULT NULL,
  `ears` text DEFAULT NULL,
  `eyes` text DEFAULT NULL,
  `nose` text DEFAULT NULL,
  `throat` text DEFAULT NULL,
  `neck` text DEFAULT NULL,
  `breast` text DEFAULT NULL,
  `respiratory` text DEFAULT NULL,
  `cardiovascular` text DEFAULT NULL,
  `gastrointestinal` text DEFAULT NULL,
  `urinary` text DEFAULT NULL,
  `genitalia` text NOT NULL,
  `vascular` text DEFAULT NULL,
  `musculoskeletal` text DEFAULT NULL,
  `neurologic1` text DEFAULT NULL,
  `hematologic` text DEFAULT NULL,
  `endocrine` text DEFAULT NULL,
  `neurologic2` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_systemreview`
--

INSERT INTO `tbl_systemreview` (`system_review_id`, `general`, `skin`, `head`, `ears`, `eyes`, `nose`, `throat`, `neck`, `breast`, `respiratory`, `cardiovascular`, `gastrointestinal`, `urinary`, `genitalia`, `vascular`, `musculoskeletal`, `neurologic1`, `hematologic`, `endocrine`, `neurologic2`, `created_at`) VALUES
(1, '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '2024-10-17 08:25:16'),
(2, '[]', '[]', '[]', '[]', '[]', '[\"Stuffiness\"]', '[\"Dentures\"]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '2024-10-18 00:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `UserType` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `userpageID` int(11) DEFAULT NULL,
  `reg` datetime DEFAULT current_timestamp(),
  `failed_attempts` tinyint(4) NOT NULL DEFAULT 0,
  `last_attempt_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `user_name`, `UserType`, `password`, `status`, `profile_picture`, `personnel_id`, `position_id`, `userpageID`, `reg`, `failed_attempts`, `last_attempt_time`) VALUES
(1, 'admin', 'admin', '$2y$10$UU5F8l0cJB5e1F8jof5RQuGzVE5gObQ8z3ZSojriezvZ9JOKBvZKK', 'active', 'user.jpg', 1, 1, 0, '2024-04-24 16:39:15', 0, NULL),
(7, 'RHU', 'RHU', '$2y$10$mbPs3TBDXv./hO5qY29..e9rZ45EdeBkulxSpxXQYD2sQwRCng/wO', 'active', 'photo1718592536 (3).jpeg', 7, 7, 0, '2024-05-02 10:55:03', 0, NULL),
(8, 'Elleen', 'RHU', '$2y$10$K3X5eArj9SJzJ7S.hu1l.ePlQSK2uIhJaY2IGT8l1A1LF7Vmex2DK', 'active', 'girl.png', 8, 8, 2, '2024-05-02 13:15:38', 0, NULL),
(29, '1', 'Doctor', '$2y$10$LL1UaURxO/bcrq1ayZQCSegp05nJldMCef0qmKkmludDfew.Yt932', 'active', 'photo1718592515 (7).jpeg', 34, 34, 0, '2024-08-04 09:46:14', 0, '2024-08-11 15:48:29'),
(31, 'angel', 'Midwife', '', 'active', 'commentor-item3.jpg', 36, 36, 0, '2024-08-04 09:47:01', 0, '2024-08-11 15:48:29'),
(36, 'joven', 'BHW', '$2y$10$m7q5alOPF40NAzJBbfa8buhGxCrRsF6pMtBjkZLXLoj62ZkoPT5uG', 'active', '1656551981avatar.png', 41, 41, 6, '2024-08-07 17:23:41', 0, NULL),
(37, 'test', 'BHW', '$2y$10$vR3.xMkzF2dXSX3JcWG9Juk49HlM6OCovIkxO3vCtkCNWyW2WXqtm', 'active', 'OIP.jpg', 42, 42, 1, '2024-08-17 18:21:00', 0, NULL),
(38, 'Carlos', 'Physician', NULL, 'inactive', 'Capture3.PNG', 43, 43, NULL, '2024-08-27 16:54:40', 0, NULL),
(39, 'Joven123', 'Doctor', '$2y$10$tOxTn6pBDgI11aL6Ms33y.K0ckHRxgU9SCTDW8miq.BNFeB5rIZ12', 'active', 'photo1718592536 (3).jpeg', 44, 44, NULL, '2024-10-23 09:58:53', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_log`
--

CREATE TABLE `tbl_user_log` (
  `logID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `user_ip` binary(16) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_log`
--

INSERT INTO `tbl_user_log` (`logID`, `userID`, `username`, `user_ip`, `login_time`, `logout`, `status`) VALUES
(0, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 10:43:45', '2024-10-24 15:00:15', 1),
(1, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-22 02:04:21', '22-10-2024 03:06:35 PM', 1),
(2, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-22 07:06:48', '22-10-2024 03:08:10 PM', 1),
(3, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-10-22 07:08:16', '22-10-2024 03:08:28 PM', 1),
(4, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-22 07:08:43', '22-10-2024 03:10:23 PM', 1),
(5, 29, '1', 0x3139322e3136382e312e320000000000, '2024-10-22 08:26:59', '2024-10-22 10:44:24', 0),
(6, 29, '1', 0x3139322e3136382e312e320000000000, '2024-10-22 08:41:43', '2024-10-22 10:44:24', 0),
(7, 29, '1', 0x3139322e3136382e312e320000000000, '2024-10-22 08:44:18', '2024-10-22 10:44:24', 0),
(8, 29, '1', 0x3139322e3136382e312e320000000000, '2024-10-22 08:44:34', '2024-10-22 10:44:42', 0),
(9, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 08:46:41', '2024-10-22 10:48:11', 0),
(10, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 08:49:49', '2024-10-22 10:50:47', 0),
(11, NULL, '1', 0x3139322e3136382e312e320000000000, '2024-10-22 08:53:09', NULL, 0),
(12, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 08:53:22', '2024-10-22 10:53:59', 1),
(13, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-22 08:54:23', '22-10-2024 04:54:39 PM', 1),
(14, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 08:55:53', '2024-10-22 11:20:19', 1),
(15, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:05:01', '2024-10-22 11:20:19', 1),
(16, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:11:16', '2024-10-22 11:20:19', 1),
(17, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:15:07', '2024-10-22 11:20:19', 1),
(18, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:18:53', '2024-10-22 11:20:19', 1),
(19, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:19:51', '2024-10-22 11:20:19', 1),
(20, 29, '1', 0x31000000000000000000000000000000, '2024-10-22 09:20:16', '2024-10-22 11:20:19', 1),
(21, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-22 23:47:57', NULL, 1),
(22, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:05:37', '2024-10-23 02:09:46', 1),
(23, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:06:27', '2024-10-23 02:09:46', 1),
(24, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:07:52', '2024-10-23 02:09:46', 1),
(25, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:08:34', '2024-10-23 02:09:46', 1),
(26, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:09:39', '2024-10-23 02:09:46', 1),
(27, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:13:24', '2024-10-23 02:18:49', 1),
(28, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:17:39', '2024-10-23 02:18:49', 1),
(29, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:19:23', '2024-10-23 02:55:28', 1),
(30, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-23 00:20:42', NULL, 1),
(31, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:35:16', NULL, 0),
(32, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:35:21', '2024-10-23 02:55:28', 1),
(33, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:47:29', NULL, 0),
(34, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:47:33', '2024-10-23 02:55:28', 1),
(35, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:47:38', NULL, 0),
(36, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:47:52', NULL, 0),
(37, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:48:00', NULL, 0),
(38, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:48:04', '2024-10-23 02:55:28', 1),
(39, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:48:07', '2024-10-23 02:55:28', 1),
(40, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:48:10', '2024-10-23 02:55:28', 1),
(41, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:49:48', '2024-10-23 02:55:28', 1),
(42, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:49:52', '2024-10-23 02:55:28', 1),
(43, NULL, '1', 0x3132372e302e302e3100000000000000, '2024-10-23 00:50:31', NULL, 0),
(44, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:50:50', '2024-10-23 02:55:28', 1),
(45, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:51:41', '2024-10-23 02:55:28', 1),
(46, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:52:13', '2024-10-23 02:55:28', 1),
(47, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:52:17', '2024-10-23 02:55:28', 1),
(48, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:53:22', '2024-10-23 02:55:28', 1),
(49, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:54:13', '2024-10-23 02:55:28', 1),
(50, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:55:19', '2024-10-23 02:55:28', 1),
(51, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:56:17', '2024-10-23 02:56:25', 1),
(52, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 00:58:54', '2024-10-23 04:45:08', 1),
(53, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:01:23', '2024-10-23 04:45:08', 1),
(54, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:30:42', '2024-10-23 04:45:08', 1),
(55, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:33:20', '2024-10-23 04:45:08', 1),
(56, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:36:53', '2024-10-23 04:45:08', 1),
(57, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:39:04', '2024-10-23 04:45:08', 1),
(58, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:39:39', '2024-10-23 04:45:08', 1),
(59, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:52:09', '2024-10-23 04:45:08', 1),
(60, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:57:08', '2024-10-23 04:45:08', 1),
(61, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:57:19', '2024-10-23 04:45:08', 1),
(62, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 01:59:17', '2024-10-23 04:45:08', 1),
(63, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 02:01:10', '2024-10-23 04:45:08', 1),
(64, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 02:04:13', '2024-10-23 04:45:08', 1),
(65, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 02:09:41', '2024-10-23 04:45:08', 1),
(66, NULL, 'Joven123', 0x3132372e302e302e3100000000000000, '2024-10-23 02:13:58', NULL, 0),
(67, 39, 'Joven123', 0x31000000000000000000000000000000, '2024-10-23 02:14:30', NULL, 1),
(68, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 02:43:10', '2024-10-23 04:45:08', 1),
(69, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 02:54:56', '2024-10-23 05:02:09', 1),
(70, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:02:00', '2024-10-23 05:02:09', 1),
(71, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:06:26', '2024-10-23 05:56:35', 1),
(72, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:15:54', '2024-10-23 05:56:35', 1),
(73, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:16:45', '2024-10-23 05:56:35', 1),
(74, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:17:27', '2024-10-23 05:56:35', 1),
(75, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:18:02', '2024-10-23 05:56:35', 1),
(76, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:23:17', '2024-10-23 05:56:35', 1),
(77, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 03:56:24', '2024-10-23 05:56:35', 1),
(78, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:11:25', '2024-10-23 07:23:09', 1),
(79, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:13:30', '2024-10-23 07:23:09', 1),
(80, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:23:12', '2024-10-23 07:23:15', 1),
(81, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:23:26', '2024-10-23 07:25:58', 1),
(82, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:25:54', '2024-10-23 07:25:58', 1),
(83, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:27:56', '2024-10-23 07:28:00', 1),
(84, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:28:27', '2024-10-23 07:29:44', 1),
(85, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:29:39', '2024-10-23 07:29:44', 1),
(86, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:34:34', '2024-10-23 07:36:20', 1),
(87, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:36:12', '2024-10-23 07:36:20', 1),
(88, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:40:01', '2024-10-23 07:40:18', 1),
(89, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:41:34', '2024-10-23 07:52:48', 1),
(90, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:47:32', '2024-10-23 07:52:48', 1),
(91, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:49:11', '2024-10-23 07:52:48', 1),
(92, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:51:08', '2024-10-23 07:52:48', 1),
(93, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:52:36', '2024-10-23 07:52:48', 1),
(94, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:54:34', '2024-10-23 08:00:35', 1),
(95, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:57:52', '2024-10-23 08:00:35', 1),
(96, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 05:58:38', '2024-10-23 08:00:35', 1),
(97, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:00:10', '2024-10-23 08:00:35', 1),
(98, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:02:18', '2024-10-23 08:12:25', 1),
(99, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:02:48', '2024-10-23 08:12:25', 1),
(100, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:04:01', '2024-10-23 08:12:25', 1),
(101, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:05:02', '2024-10-23 08:12:25', 1),
(102, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:05:29', '2024-10-23 08:12:25', 1),
(103, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:07:55', '2024-10-23 08:12:25', 1),
(104, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:08:58', '2024-10-23 08:12:25', 1),
(105, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 06:12:14', '2024-10-23 08:12:25', 1),
(106, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 09:07:02', '2024-10-23 11:16:58', 1),
(107, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 09:16:55', '2024-10-23 11:16:58', 1),
(108, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 09:17:07', '2024-10-23 11:17:12', 1),
(109, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 10:48:25', '2024-10-24 15:00:15', 1),
(110, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 10:53:42', '2024-10-24 15:00:15', 1),
(111, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 10:59:48', '2024-10-24 15:00:15', 1),
(112, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 11:10:11', '2024-10-24 15:00:15', 1),
(113, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 11:23:55', '2024-10-24 15:00:15', 1),
(114, 29, '1', 0x31000000000000000000000000000000, '2024-10-23 11:25:50', '2024-10-24 15:00:15', 1),
(115, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 12:20:47', '2024-10-24 15:00:15', 1),
(116, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 12:23:56', '2024-10-24 15:00:15', 1),
(117, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 12:24:13', '2024-10-24 15:00:15', 1),
(118, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 12:36:47', '2024-10-24 15:00:15', 1),
(119, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 13:00:04', '2024-10-24 15:00:15', 1),
(120, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 13:08:22', '2024-10-27 01:19:17', 1),
(121, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 13:11:06', '2024-10-27 01:19:17', 1),
(122, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 13:13:24', '2024-10-27 01:19:17', 1),
(123, 29, '1', 0x31000000000000000000000000000000, '2024-10-24 13:14:08', '2024-10-27 01:19:17', 1),
(124, 29, '1', 0x31000000000000000000000000000000, '2024-10-25 04:14:19', '2024-10-27 01:19:17', 1),
(125, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:08:50', '2024-10-27 01:19:17', 1),
(126, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:18:17', '2024-10-27 01:19:17', 1),
(127, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-26 23:19:32', NULL, 1),
(128, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:19:55', NULL, 1),
(129, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:21:32', NULL, 1),
(130, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:21:57', NULL, 1),
(131, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:24:23', NULL, 1),
(132, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:25:35', NULL, 1),
(133, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:27:07', NULL, 1),
(134, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:33:49', NULL, 1),
(135, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:34:38', NULL, 1),
(136, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:52:16', NULL, 1),
(137, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:57:25', NULL, 1),
(138, 29, '1', 0x31000000000000000000000000000000, '2024-10-26 23:58:52', NULL, 1),
(139, 29, '1', 0x31000000000000000000000000000000, '2024-10-27 00:02:21', NULL, 1),
(140, 29, '1', 0x31000000000000000000000000000000, '2024-10-27 00:39:47', NULL, 1),
(141, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-27 04:19:44', '27-10-2024 12:27:26 PM', 1),
(142, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-27 04:27:35', NULL, 1),
(143, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-27 04:29:26', '27-10-2024 02:46:57 PM', 1),
(144, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-27 06:47:03', NULL, 1),
(145, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-27 12:11:31', '27-10-2024 10:07:20 PM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_page`
--

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_page`
--

INSERT INTO `tbl_user_page` (`userpageID`, `home_img`, `sidebar`, `userID`) VALUES
(1, 'CALENDAR.PNG', 'BRGY. AVACEÑA', 37),
(2, 'CALENDAR.PNG', 'BRGY. LAMPARE', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vitalsigns_monitoring`
--

CREATE TABLE `tbl_vitalsigns_monitoring` (
  `vitalSignsID` int(11) NOT NULL,
  `room` varchar(100) NOT NULL,
  `date_shift` date NOT NULL,
  `time` time NOT NULL,
  `bp` varchar(20) NOT NULL,
  `cr` varchar(20) NOT NULL,
  `rr` varchar(20) NOT NULL,
  `temp` varchar(20) NOT NULL,
  `fht` varchar(20) NOT NULL,
  `duration` varchar(20) NOT NULL,
  `frequency` varchar(20) NOT NULL,
  `intensity` varchar(20) NOT NULL,
  `nurse_midwife` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vitalsigns_monitoring`
--

INSERT INTO `tbl_vitalsigns_monitoring` (`vitalSignsID`, `room`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `fht`, `duration`, `frequency`, `intensity`, `nurse_midwife`, `patient_id`, `birth_info_id`, `created_at`) VALUES
(1, '223', '2024-10-17', '16:26:00', '120/20', '2', '2', '2', '2', '2', '2', '2', 31, 8, 1, '2024-10-17 08:26:18'),
(2, '223', '2024-10-10', '16:27:00', '120/20', '2', '2', '2', '2', '2', '2', '2', 31, 8, 1, '2024-10-17 08:26:42'),
(3, '223', '2024-10-17', '02:26:00', '120/20', 'f', 'ew', 'rwe', 'rew', 're', 'wrew', 'rew', 31, 8, 1, '2024-10-17 08:26:42'),
(4, '12', '2024-10-10', '08:07:00', '120/20', '2', '2', '2', '2', '2', '2', '2', 31, 6, 2, '2024-10-18 00:07:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tbl_animal_bite_care`
--
ALTER TABLE `tbl_animal_bite_care`
  ADD PRIMARY KEY (`animal_biteID`);

--
-- Indexes for table `tbl_animal_bite_vaccination`
--
ALTER TABLE `tbl_animal_bite_vaccination`
  ADD PRIMARY KEY (`animal_bite_vacID`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  ADD PRIMARY KEY (`announceID`);

--
-- Indexes for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `tbl_audit_log`
--
ALTER TABLE `tbl_audit_log`
  ADD PRIMARY KEY (`auditID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_audit_trail`
--
ALTER TABLE `tbl_audit_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_birthing_medication`
--
ALTER TABLE `tbl_birthing_medication`
  ADD PRIMARY KEY (`medicationID`);

--
-- Indexes for table `tbl_birthing_monitoring`
--
ALTER TABLE `tbl_birthing_monitoring`
  ADD PRIMARY KEY (`birthMonitorID`),
  ADD KEY `patientID` (`patient_id`);

--
-- Indexes for table `tbl_birthroom`
--
ALTER TABLE `tbl_birthroom`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `tbl_birth_info`
--
ALTER TABLE `tbl_birth_info`
  ADD PRIMARY KEY (`birth_info_id`);

--
-- Indexes for table `tbl_birth_ivfluids`
--
ALTER TABLE `tbl_birth_ivfluids`
  ADD PRIMARY KEY (`fluidsID`);

--
-- Indexes for table `tbl_certificate_log`
--
ALTER TABLE `tbl_certificate_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_checkup`
--
ALTER TABLE `tbl_checkup`
  ADD PRIMARY KEY (`checkupID`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_clinicalrecords`
--
ALTER TABLE `tbl_clinicalrecords`
  ADD PRIMARY KEY (`recordID`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_complaints`
--
ALTER TABLE `tbl_complaints`
  ADD PRIMARY KEY (`complaintID`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_discharged`
--
ALTER TABLE `tbl_discharged`
  ADD PRIMARY KEY (`dischargedid`);

--
-- Indexes for table `tbl_doctor_schedule`
--
ALTER TABLE `tbl_doctor_schedule`
  ADD PRIMARY KEY (`doc_scheduleID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `tbl_familyaddress`
--
ALTER TABLE `tbl_familyaddress`
  ADD PRIMARY KEY (`famID`);

--
-- Indexes for table `tbl_family_members`
--
ALTER TABLE `tbl_family_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `address_id` (`address`);

--
-- Indexes for table `tbl_healthnotes`
--
ALTER TABLE `tbl_healthnotes`
  ADD PRIMARY KEY (`notedsID`);

--
-- Indexes for table `tbl_immunization_records`
--
ALTER TABLE `tbl_immunization_records`
  ADD PRIMARY KEY (`immunID`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_laboratory`
--
ALTER TABLE `tbl_laboratory`
  ADD PRIMARY KEY (`labid`);

--
-- Indexes for table `tbl_medicines`
--
ALTER TABLE `tbl_medicines`
  ADD PRIMARY KEY (`medicineID`);

--
-- Indexes for table `tbl_medicine_details`
--
ALTER TABLE `tbl_medicine_details`
  ADD PRIMARY KEY (`med_detailsID`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `tbl_membership_info`
--
ALTER TABLE `tbl_membership_info`
  ADD PRIMARY KEY (`membershipID`);

--
-- Indexes for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  ADD PRIMARY KEY (`patientID`),
  ADD KEY `Membership_Info` (`Membership_Info`),
  ADD KEY `family_no` (`family_address`);

--
-- Indexes for table `tbl_patient_medication_history`
--
ALTER TABLE `tbl_patient_medication_history`
  ADD PRIMARY KEY (`patient_med_historyID`),
  ADD KEY `patient_visit_id` (`patient_visit_id`),
  ADD KEY `medicine_details_id` (`medicine_details_id`);

--
-- Indexes for table `tbl_patient_visits`
--
ALTER TABLE `tbl_patient_visits`
  ADD PRIMARY KEY (`patient_visitID`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `tbl_personnel`
--
ALTER TABLE `tbl_personnel`
  ADD PRIMARY KEY (`personnel_id`);

--
-- Indexes for table `tbl_physicalexam`
--
ALTER TABLE `tbl_physicalexam`
  ADD PRIMARY KEY (`physical_exam_id`);

--
-- Indexes for table `tbl_position`
--
ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `tbl_postpartum`
--
ALTER TABLE `tbl_postpartum`
  ADD PRIMARY KEY (`postpartumID`);

--
-- Indexes for table `tbl_prenatal`
--
ALTER TABLE `tbl_prenatal`
  ADD PRIMARY KEY (`prenatalID`);

--
-- Indexes for table `tbl_referrals_log`
--
ALTER TABLE `tbl_referrals_log`
  ADD PRIMARY KEY (`referral_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `tbl_systemreview`
--
ALTER TABLE `tbl_systemreview`
  ADD PRIMARY KEY (`system_review_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `personnel_id` (`personnel_id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  ADD PRIMARY KEY (`logID`),
  ADD KEY `tbl_user_log_ibfk_1` (`userID`);

--
-- Indexes for table `tbl_user_page`
--
ALTER TABLE `tbl_user_page`
  ADD PRIMARY KEY (`userpageID`);

--
-- Indexes for table `tbl_vitalsigns_monitoring`
--
ALTER TABLE `tbl_vitalsigns_monitoring`
  ADD PRIMARY KEY (`vitalSignsID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_animal_bite_care`
--
ALTER TABLE `tbl_animal_bite_care`
  MODIFY `animal_biteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_animal_bite_vaccination`
--
ALTER TABLE `tbl_animal_bite_vaccination`
  MODIFY `animal_bite_vacID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  MODIFY `announceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_audit_log`
--
ALTER TABLE `tbl_audit_log`
  MODIFY `auditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_audit_trail`
--
ALTER TABLE `tbl_audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_birthing_medication`
--
ALTER TABLE `tbl_birthing_medication`
  MODIFY `medicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_birthing_monitoring`
--
ALTER TABLE `tbl_birthing_monitoring`
  MODIFY `birthMonitorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birthroom`
--
ALTER TABLE `tbl_birthroom`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birth_info`
--
ALTER TABLE `tbl_birth_info`
  MODIFY `birth_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birth_ivfluids`
--
ALTER TABLE `tbl_birth_ivfluids`
  MODIFY `fluidsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_certificate_log`
--
ALTER TABLE `tbl_certificate_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_checkup`
--
ALTER TABLE `tbl_checkup`
  MODIFY `checkupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_clinicalrecords`
--
ALTER TABLE `tbl_clinicalrecords`
  MODIFY `recordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_complaints`
--
ALTER TABLE `tbl_complaints`
  MODIFY `complaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_discharged`
--
ALTER TABLE `tbl_discharged`
  MODIFY `dischargedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_doctor_schedule`
--
ALTER TABLE `tbl_doctor_schedule`
  MODIFY `doc_scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_familyaddress`
--
ALTER TABLE `tbl_familyaddress`
  MODIFY `famID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_family_members`
--
ALTER TABLE `tbl_family_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_healthnotes`
--
ALTER TABLE `tbl_healthnotes`
  MODIFY `notedsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_immunization_records`
--
ALTER TABLE `tbl_immunization_records`
  MODIFY `immunID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_laboratory`
--
ALTER TABLE `tbl_laboratory`
  MODIFY `labid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_medicines`
--
ALTER TABLE `tbl_medicines`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_medicine_details`
--
ALTER TABLE `tbl_medicine_details`
  MODIFY `med_detailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_membership_info`
--
ALTER TABLE `tbl_membership_info`
  MODIFY `membershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_patient_medication_history`
--
ALTER TABLE `tbl_patient_medication_history`
  MODIFY `patient_med_historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_patient_visits`
--
ALTER TABLE `tbl_patient_visits`
  MODIFY `patient_visitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_personnel`
--
ALTER TABLE `tbl_personnel`
  MODIFY `personnel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_physicalexam`
--
ALTER TABLE `tbl_physicalexam`
  MODIFY `physical_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_postpartum`
--
ALTER TABLE `tbl_postpartum`
  MODIFY `postpartumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_prenatal`
--
ALTER TABLE `tbl_prenatal`
  MODIFY `prenatalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_referrals_log`
--
ALTER TABLE `tbl_referrals_log`
  MODIFY `referral_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_systemreview`
--
ALTER TABLE `tbl_systemreview`
  MODIFY `system_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `tbl_user_page`
--
ALTER TABLE `tbl_user_page`
  MODIFY `userpageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_vitalsigns_monitoring`
--
ALTER TABLE `tbl_vitalsigns_monitoring`
  MODIFY `vitalSignsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_audit_log`
--
ALTER TABLE `tbl_audit_log`
  ADD CONSTRAINT `tbl_audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `tbl_personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_users_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `tbl_position` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
