-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 28, 2024 at 09:10 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u926430213_mh_office`
--

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
  `bite_status` enum('ongoing','done') NOT NULL DEFAULT 'ongoing',
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_animal_bite_care`
--

INSERT INTO `tbl_animal_bite_care` (`animal_biteID`, `patient_id`, `reg_no`, `date`, `med_history`, `bleeding`, `cpi_month`, `cpi_year`, `animal_type`, `date_bite`, `Place`, `Type_bite`, `source`, `pet_vaccinated`, `animal_status`, `site_exposure`, `wound`, `washed`, `soap`, `Tandok`, `Applied`, `Tetanus`, `vac_date`, `vaccine`, `category_exposure`, `a`, `p`, `userID`, `bite_status`, `sync_status`) VALUES
(1, 2, '20241228001', '2024-12-28', '[\"\"]', 'yes', '', '', 'Dog', '2024-12-25', 'Brgy. Sampao, Sultan Kudarat', '[\"Bite\",\"Induced\"]', NULL, '', 'Alive', 'Big Bite', 'yes', '', 'yes', 'no', 'yes', 'yes', '2024-12-28', 'HTIG', 'III', '', '', 4, 'ongoing', 0);

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
  `bite_status` int(11) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_animal_bite_vaccination`
--

INSERT INTO `tbl_animal_bite_vaccination` (`animal_bite_vacID`, `vaccination_name`, `vaccination_date`, `next_visit_date`, `dose_number`, `remarks`, `patient_id`, `stat`, `dose_status`, `bite_status`, `sync_status`) VALUES
(1, '5', '2024-12-28', '2025-01-01', '1', 'Patient received the first dose of the rabies vaccine following an animal bite incident.', 2, 0, 1, 1, 0);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcements`
--

INSERT INTO `tbl_announcements` (`announceID`, `date`, `title`, `details`, `created_at`, `updated_at`, `sync_status`) VALUES
(1, '2024-12-29', 'final defense', 'final defense', '2024-12-12 20:31:24', '2024-12-28 08:54:09', 0),
(2, '2024-12-31', 'Free Health Check-Up & Vaccination Drive', 'The healthcare center is organizing a Free Health Check-Up and Vaccination Drive for all residents of Brgy. Tananzang. The event will provide free consultations, vital sign monitoring (blood pressure, heart rate, etc.), and free vaccines for children and adults (e.g., flu, tetanus, and COVID-19 booster).', '2024-12-28 15:42:44', '2024-12-28 15:42:44', 0),
(3, '2025-01-11', 'The healthcare center is organizing a Free Health Check-Up and Vaccination Drive for all residents of Brgy. Tananzang. The event will provide free con', 'To maintain a safe and hygienic environment for patients and staff, a routine disinfection will be conducted at the healthcare center.', '2024-12-28 15:44:51', '2024-12-28 15:44:51', 0),
(4, '2025-02-19', 'BHW Training on New Medical Equipment', 'To ensure that the healthcare center’s staff is well-prepared to use newly acquired medical equipment, this training session will cover the operation, maintenance, and safety guidelines for the equipment. ', '2024-12-28 15:45:54', '2024-12-28 15:45:54', 0),
(5, '2025-01-09', 'Dental Checkup & Cleaning', 'A free community dental checkup and cleaning will be held to provide preventive oral health services, detect early signs of dental issues, and provide professional cleaning for patients who may not have access to regular dental care.', '2024-12-28 15:46:45', '2024-12-28 15:46:45', 0),
(6, '2024-12-30', 'No Work Announcement', 'In observance of the National Holiday, ', '2024-12-28 15:47:42', '2024-12-28 15:47:42', 0);

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
  `ip_address` varchar(50) DEFAULT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`id`, `user_id`, `action`, `description`, `affected_table`, `affected_record_id`, `action_timestamp`, `ip_address`, `sync_status`) VALUES
(1, 1, 'Add Schedule', 'Added a schedule for Doctor  John  Erwe', 'tbl_doctor_schedule', 1, '2024-12-28 14:37:24', '175.176.93.210', 0),
(2, 4, 'Insert', 'Added patient: Maria Dela Cruz', 'tbl_patients', 1, '2024-12-28 14:39:40', '175.176.93.210', 0),
(3, 3, 'Insert', 'Added patient: Juan Santos', 'tbl_patients', 2, '2024-12-28 14:45:11', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(4, 1, 'Add Users', 'Added User,  Rose Cy Lopez', 'tbl_users', 9, '2024-12-28 14:47:21', '158.62.79.124', 0),
(5, 1, 'Updated Users', 'Updated User,  Rose Cy Lopez', 'tbl_users', 9, '2024-12-28 14:48:42', '158.62.79.124', 0),
(6, 3, 'Insert', 'Added patient: Lhiam Marble', 'tbl_patients', 3, '2024-12-28 14:57:42', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(7, 3, 'Insert', 'Added patient: Meriam Quiambao', 'tbl_patients', 4, '2024-12-28 15:07:22', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(8, 3, 'Insert', 'Added patient: Nathia Lumgan', 'tbl_patients', 5, '2024-12-28 15:13:52', '210.1.97.177', 0),
(9, 9, 'Insert', 'Added patient: Gwen perez', 'tbl_patients', 6, '2024-12-28 15:15:48', '158.62.79.124', 0),
(10, 9, 'Insert', 'Added patient: Chris flores', 'tbl_patients', 7, '2024-12-28 15:26:59', '158.62.79.124', 0),
(11, 4, 'Insert', 'Added patient: Paul Marinay', 'tbl_patients', 8, '2024-12-28 15:30:33', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(12, 9, 'Insert', 'Added patient: Grace cruz', 'tbl_patients', 9, '2024-12-28 15:42:04', '158.62.79.124', 0),
(13, 1, 'Add Events', 'Added Events  Free Health Check-Up & Vaccination Drive The healthcare center is organizing a Free Health Check-Up and Vaccination Drive for all residents of Brgy. Tananzang. The event will provide free consultations, vital sign monitoring (blood pressure, heart rate, etc.), and free vaccines for children and adults (e.g., flu, tetanus, and COVID-19 booster).', 'tbl_announcements', 2, '2024-12-28 15:42:44', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(14, 1, 'Add Events', 'Added Events  The healthcare center is organizing a Free Health Check-Up and Vaccination Drive for all residents of Brgy. Tananzang. The event will provide free con To maintain a safe and hygienic environment for patients and staff, a routine disinfection will be conducted at the healthcare center.', 'tbl_announcements', 3, '2024-12-28 15:44:51', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(15, 1, 'Add Events', 'Added Events  BHW Training on New Medical Equipment To ensure that the healthcare center’s staff is well-prepared to use newly acquired medical equipment, this training session will cover the operation, maintenance, and safety guidelines for the equipment.', 'tbl_announcements', 4, '2024-12-28 15:45:54', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(16, 1, 'Add Events', 'Added Events  Dental Checkup & Cleaning A free community dental checkup and cleaning will be held to provide preventive oral health services, detect early signs of dental issues, and provide professional cleaning for patients who may not have access to regular dental care.', 'tbl_announcements', 5, '2024-12-28 15:46:45', '210.1.97.177', 0),
(17, 1, 'Add Events', 'Added Events  No Work Announcement In observance of the National Holiday,', 'tbl_announcements', 6, '2024-12-28 15:47:42', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0),
(18, 9, 'Insert', 'Added patient: Joli aquino', 'tbl_patients', 10, '2024-12-28 15:50:51', '158.62.79.124', 0),
(19, 1, 'Update', 'Updated Patient Information,  Gwen Perez', 'tbl_patients', 6, '2024-12-28 15:54:16', '175.176.93.210', 0),
(20, 4, 'Insert', 'Added patient: Manica Manila', 'tbl_patients', 11, '2024-12-28 16:19:44', '2001:4456:1b9:ad00:8424:881f:c467:5cdd', 0);

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthing_medication`
--

INSERT INTO `tbl_birthing_medication` (`medicationID`, `patient_id`, `orderDate`, `medicineID`, `dosage`, `Frequency`, `time`, `date_signature`, `signature`, `medProcedure`, `Specimen`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, '2024-12-28', 10, '500 mg', 'Every 6 hours', '11:00:00', '2024-12-28', 'Irlan Santos Cruz', 'N/A', 'N/A', 1, '2024-12-28 15:27:13', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthing_monitoring`
--

INSERT INTO `tbl_birthing_monitoring` (`birthMonitorID`, `birth_info_id`, `case_no`, `patient_id`, `parity`, `admission_date`, `admission_time`, `time_active`, `time_membranes`, `time_second`, `birth_time`, `oxytocin`, `placenta_complete`, `estimated`, `time_delivered`, `live_birth`, `RESUSCITATION`, `birth_weight`, `preterm`, `second_baby`, `newborn`, `stage_of_labour`, `ruptured_membranes`, `vaginal_bleeding`, `strong_contractions`, `fetal_heart_rate`, `temperature_axillary`, `pulse`, `respiratory_rate`, `blood_pressure`, `urine_voided`, `cervical_dilatation`, `maternal_plan`, `problem`, `time_onset`, `treatments`, `referral_details`, `created_at`, `sync_status`) VALUES
(1, 1, '20241228001', 1, 'P2 (2 Full-term, 0 Preterm, 0 Abortions, 2 Living)', '2024-12-28', '06:00:00', '10:56:00', '10:56:00', '19:58:00', '22:00:00', '09:56', 'Yes', '300 ml', '22:56:00', 'Livebirth', 'Yes', '4kg', 'Yes', 'no', 'Vitamin K Injection', 'NOT IN ACTIVE LABOUR', '[\"1\"]', '[\"2\"]', '[\"3\"]', '[\"4\"]', '[\"5\"]', '[\"6\"]', '[\"7\"]', '[\"8\"]', '[\"9\"]', '[\"10\"]', 'Oxytocin Administration', 'none', 'Immediately after delivery', 'Immediately after delivery', '', '2024-12-28 14:59:19', 0),
(2, 2, '20241229002', 6, 'fas', '2024-12-29', '16:48:00', '01:48:00', '15:47:00', '03:50:00', '03:48:00', '03:51', 'Yes', '324234324234', '14:48:00', 'Livebirth', 'No', '4324', '', 'eew', 'wer', '', '[\"5\"]', '[]', '[\"4\"]', '[]', '[]', '[\"7\"]', '[]', '[]', '[]', '[]', 'd', 'nothing', 'none', 'noe', 'none', '2024-12-28 16:46:24', 0);

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birthroom`
--

INSERT INTO `tbl_birthroom` (`roomID`, `patient_id`, `dateAdmitted`, `gravida`, `para`, `fullTerm`, `premature`, `abortion`, `noOfLiving`, `labor`, `placenta`, `method_delivery`, `Episiotomy`, `Laceration`, `Anethesia`, `Analgesia`, `condition`, `urinary_bladder`, `uterus`, `pregnancy`, `not_related`, `complications`, `Handled_by`, `assisted_by`, `physician`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, '2024-12-28', '3', 'P(2, 1, 0, 2)', '2', '1', '0', '2', '{\"labor\":{\"types\":[\"Onset\"],\"time\":\"11:18\",\"date\":\"28\\/12\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"cervix\":{\"time\":\"02:18\",\"date\":\"28\\/12\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"baby\":{\"time\":\"01:18\",\"date\":\"28\\/12\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"placenta\":{\"time\":\"13:18\",\"date\":\"28\\/12\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}}}', '{\"placenta\":{\"expelled\":[\"Expelled Completely\"]},\"umbilicalCord\":{\"cm\":\"1\",\"loops_at_neck\":\"\",\"loops\":\"\",\"none\":\"None\",\"loopsNone\":\"None\"},\"other\":\"2\",\"bloodLoss\":{\"antepartum\":\"100\",\"intrapartum\":\"50\",\"postpartum\":\"30\",\"total\":\"180\"}}', '[\"Cesarean\"]', '[\"Right Med. Lateral\"]', '[]', '[]', '[\"None\"]', '[\"Depressed\"]', '[\"Voided\"]', '[\"Relaxing\"]', 'None', 'None', 'None', 'Shane', 'Ternosa', 6, 1, '2024-12-28 15:19:36', 0);

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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birth_info`
--

INSERT INTO `tbl_birth_info` (`birth_info_id`, `patient_id`, `case_no`, `date`, `LMP`, `EDC`, `AOG`, `OBSCORE`, `chief_complaint`, `past_med_history`, `past_operations`, `medication`, `past_admission`, `family_history`, `ps_history`, `gyne_history`, `present_pregnancy`, `obstetrical_history`, `userID`, `systemReviewID`, `physicalExamID`, `midwife_nurse`, `birthing_status`, `created_at`, `sync_status`) VALUES
(1, 1, '20241228001', '2024-12-28', '2023-12-08', '2024-09-14', '39 weeks', '{\"g\":\"1\",\"p\":\"0\",\"term\":\"0\",\"preterm\":\"0\",\"abortion\":\"0\",\"living\":\"0\"}', 'Labor pains started 6 hours ago, Mother experienced regular contractions every 5 minutes with no fluid leakage.', '[\"Heart Disease\",\"Thyroid D\\/O\",\"\"]', 'None', 'Prenatal vitamins', 'None', '[\"Asthma\",\"\"]', '{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}', '{\"menarche\":\"15 years old\",\"regular\":\"No\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"flow\":[\"moderate\"],\"dysmenorrhea\":\"no\",\"first_sexual_contact\":\"12 weeks\"}', '{\"antepartal_care\":\"None\",\"start_visit\":\"2023-12-12\",\"aog\":\"39 weeks\",\"tt\":\"none\",\"feso4\":\"No\",\"ogct\":\"50g\",\"illness\":\"none\",\"tot_visit\":\"2\",\"others\":\"\"}', '[{\"year\":\"2020\",\"place_of_confinement\":\"City General Hospital\",\"aog\":\"39 weeks\",\"bw\":\"3.0 kg\",\"manner_of_delivery\":\"Normal Delivery\",\"complication_remarks\":\"None\"}]', 4, 2, 2, '7', 'ongoing', '2024-12-28', 0),
(2, 6, '20241229002', '2024-12-29', '3/15/2024', '12/22/2024', '39', '{\"g\":\"1\",\"p\":\"0\",\"term\":\"\",\"preterm\":\"\",\"abortion\":\"\",\"living\":\"\"}', 'Chief Complaint: Labor pains with regular contractions.\r\nBrief History: Full-term pregnancy with no complications reported during prenatal care.', '[\"\"]', '', '', '', '[\"Hypertension\",\"\"]', '{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}', '{\"menarche\":\"13\",\"regular\":\"Yes\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"flow\":[\"moderate\"],\"dysmenorrhea\":\"no\",\"first_sexual_contact\":\"19\"}', '{\"antepartal_care\":\"Health Center\",\"start_visit\":\"6\",\"aog\":\"5\",\"tt\":\"Completer\",\"feso4\":\"Yes\",\"ogct\":\"\",\"illness\":\"\",\"tot_visit\":\"8\",\"others\":\"\"}', '[{\"year\":\"2024\",\"place_of_confinement\":\"Rural Health Unit, Sultan Kudarat\",\"aog\":\"39\",\"bw\":\"not yet\",\"manner_of_delivery\":\"2\",\"complication_remarks\":\"2\"},{\"year\":\"\",\"place_of_confinement\":\"\",\"aog\":\"\",\"bw\":\"\",\"manner_of_delivery\":\"\",\"complication_remarks\":\"\"}]', 4, 3, 3, '7', 'done', '2024-12-28', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_birth_ivfluids`
--

INSERT INTO `tbl_birth_ivfluids` (`fluidsID`, `patient_id`, `date`, `timeStarted`, `timeconsumed`, `bottleno`, `solution`, `signature_remarks`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, '2024-12-28', '02:27:00', '13:28:00', '001', 'Normal Saline 0.9%', 'Administered as per doctor\'s order, Sarah Smith, RN', 1, '2024-12-28 15:28:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_certificate_log`
--

CREATE TABLE `tbl_certificate_log` (
  `log_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `generated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_certificate_log`
--

INSERT INTO `tbl_certificate_log` (`log_id`, `patient_id`, `generated_at`, `status`, `file_path`, `sync_status`) VALUES
(1, 8, '2024-12-28 15:38:40', 'done', '/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/8_2024-12-28.pdf', 0),
(3, 8, '0000-00-00 00:00:00', 'pending', '', 0),
(5, 11, '0000-00-00 00:00:00', 'pending', '', 0),
(6, 10, '0000-00-00 00:00:00', 'pending', '', 0);

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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkup`
--

INSERT INTO `tbl_checkup` (`checkupID`, `admitted`, `history`, `per_pas_med`, `pertinent_signs`, `gen_survey`, `heent`, `chest`, `CSV`, `abdomen`, `GU`, `skin_extremeties`, `neuro_exam`, `disability`, `disability_type`, `doctor_order`, `patient_id`, `no_illness`, `created_at`, `sync_status`) VALUES
(1, '2024-12-28 23:31:00', 'Patient presents with a complaint of persistent headache and dizziness for the last 3 days. The pain is described as dull, with intermittent episodes of severe dizziness, especially when standing. The patient denies nausea, vomiting, or blurred vision. No', 'No known chronic illnesses.\r\nNo previous surgeries.\r\nNo history of hypertension, diabetes, or heart disease.', '[\"Chest pain\\/discomfort\",\"Dizziness\",\"Headache\",\"\"]', 'Awake and alert', '[\"Essentially normal\",\"\"]', '[\"Essentially normal\",\"\"]', '[\"Essentially normal\",\"\"]', '[\"Essentially normal\",\"\"]', '[\"Essentially normal\",\"\"]', '[\"Essentially normal\",\"\"]', '[\"on\",\"\"]', 'no', '', 'Diagnosis: Possible tension-type headache with dizziness, rule out other causes. Order for Lab: Complete Blood Count (CBC) Electrolytes and metabolic panel Head CT scan (to rule out other neurological causes) Medications: Ibuprofen 400 mg every 6 hours fo', 6, 0, '2024-12-28', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_clinicalrecords`
--

INSERT INTO `tbl_clinicalrecords` (`recordID`, `patient_id`, `employer`, `empaddress`, `tel_cell-no`, `admission_date`, `admission_time`, `dischargeDate`, `dischargeTime`, `type_of_admission`, `admitting_midwife`, `datafurnished`, `datafurnishedaddress`, `admitting_diagnosis`, `final_diagnosis`, `procedure_done`, `disposition`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, '', '', '', '2024-12-28', '06:00:00', '2024-12-29', '11:28:00', 'new', 'Nicole  Dela Cruz', 'Nicole Dela Cruz', 'Lutayan Sultan Kudarat', 'Hypertension, Fever', 'Hypertension, Stable', 'IV Fluid Administration', 'discharged', 1, '2024-12-28 15:30:22', 0);

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
  `Height` varchar(50) NOT NULL,
  `Nature_Visit` varchar(100) NOT NULL,
  `consultation_purpose` varchar(100) NOT NULL,
  `refferred` varchar(100) NOT NULL,
  `reason_ref` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `pr` varchar(50) NOT NULL,
  `O2SAT` varchar(50) NOT NULL,
  `transferred` varchar(50) NOT NULL,
  `action_taken` text NOT NULL,
  `instruction_to` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_complaints`
--

INSERT INTO `tbl_complaints` (`complaintID`, `patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`, `Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `reason_ref`, `status`, `pr`, `O2SAT`, `transferred`, `action_taken`, `instruction_to`, `created_at`, `sync_status`) VALUES
(1, 1, 'birthing', 'birthing', '120/90', '33', '165kg', '23', '35°C', '135', 'New consultation/case', 'Birthing', 'Jerom Badio', 'birthing', 'Under Monitoring', '22', '', '', '', '', '2024-12-28', 0),
(2, 2, 'Animal bite (dog) on the right forearm', 'Patient reported the bite occurred approximately 6 hours prior, no prior rabies vaccination.', '120/80', '85', '65kg', '18', '37.5°C', '170cm', 'New consultation/case', 'Animal bite and Care', 'Loreine Santos', 'Patient requires rabies vaccination and wound management', 'for vaccination', '85', '98', '', 'Wound cleaned and disinfected with povidone-iodine\r\nAdministered Tetanus Toxoid Vaccine', 'Schedule follow-up doses of rabies vaccine on days 3, 7, and 14.\r\nAdvise patient to monitor wound for signs of infection and avoid contact with the animal.', '2024-12-28', 0),
(3, 3, 'Scheduled immunization visit', 'Patient is due for 1-year-old vaccines. No additional complaints from the guardian.', '0/0', '120', '10kg', '30', '36°C', '75cm', 'New consultation/case', 'Vaccination and Immunization', 'Loreine Santos', 'Scheduled immunization as part of routine health maintenance', 'Done', '120', '99', '', 'Administered MMR vaccine (1st dose)\r\nWound area cleaned before injection\r\nPost-vaccination observation conducted', 'Schedule follow-up for booster vaccines as needed\r\nAdvise guardian to monitor for any post-vaccine reactions, such as fever or redness at the injection site', '2024-12-28', 0),
(4, 4, 'Animal bite (dog bite) on the right leg', 'Bite occurred approximately 4 hours ago, no prior rabies vaccination', '120/80', '110', '54kg', '22', '37.2°C', '185cm', 'New consultation/case', 'Animal bite and Care', 'Loreine Santos', 'Animal bite requiring wound care and rabies vaccination', 'Pending', '110', '97', '', 'Wound cleaned thoroughly with antiseptic\r\nAdministered rabies vaccine (1st dose)\r\nTetanus toxoid vaccine administered', 'Continue the rabies vaccination schedule (3 doses, on days 3, 7, and 14)\r\nMonitor the wound for any signs of infection and swelling\r\nFollow-up visit in 2 weeks for additional vaccine doses and wound check', '2024-12-28', 0),
(5, 5, 'Seeking consultation for vaccination (flu vaccine, tetanus shot)', 'No specific complaints reported. Routine check-up for preventive care.', '110/70', '75', '50kg', '18', '36.7°C', '160cm', 'New consultation/case', 'Vaccination and Immunization', 'Loreine Santos', 'Preventive care and vaccination', 'Pending', '75', '98', '', 'Administered flu vaccine\r\nAdministered tetanus toxoid vaccine\r\nCounseled patient on common side effects', 'Continue with annual flu vaccination\r\nSchedule tetanus booster as needed every 10 years', '2024-12-28', 0),
(6, 6, 'Persistent headache and dizziness for the past 3 days.', 'Patient reports mild nausea associated with dizziness, no history of trauma.', '120/80', '78', '58kg', '16', '37.2°°C', '160cm', 'New consultation/case', 'Checkup', 'Rose Lopez', 'Persistent headache with dizziness, referred for further diagnostic workup (possible neurological evaluation).', 'Done', '78', '98%', 'referred', 'Referred to a neurologist for further evaluation, CT scan scheduled.', 'Please assess the patient\'s symptoms and recommend appropriate tests if necessary.', '2024-12-28', 0),
(7, 7, 'Severe lower abdominal pain and bloating for the past 2 days.', 'Patient denies nausea or vomiting, but reports discomfort after eating. No history of similar symptoms.', '135/85', '88', '70kg', '18', '36.8°C', '162cm', 'New consultation/case', 'Checkup', 'Rose Lopez', 'Acute lower abdominal pain with bloating, referred for ultrasound to rule out ovarian cysts or gastrointestinal issues.', 'Pending', '88', '97%', '', 'Referred for abdominal ultrasound, advised to fast for 8 hours before the procedure.', 'Please perform abdominal ultrasound to investigate possible causes of pain, including gastrointestinal or gynecological issues.', '2024-12-28', 0),
(8, 8, 'Complaints of severe abdominal pain after eating.', 'Pain started suddenly after a large meal, no previous history of similar issues.', '140/80', '80', '68kg', '18', '37°C', '170', 'New consultation/case', 'Checkup', 'Jerom Badio', 'Patient referred for further evaluation and treatment due to the nature of symptoms which may suggest gastrointestinal issues such as gastritis or ulcers. Needs to undergo diagnostic testing and possibly endoscopy for further diagnosis.', 'Done', '80', '', 'referred', '', '', '2024-12-28', 0),
(9, 9, 'Mild abdominal discomfort and lower back pain during pregnancy.', 'Patient is in the third trimester, and this is her second pregnancy. The discomfort has been present for the past two weeks but is not severe.', '120/80', '78', '70kg', '18', '37°C', '162cm', 'New consultation/case', 'Prenatal', 'Rose Lopez', 'Mild abdominal discomfort and lower back pain, patient is in the third trimester. Referred for a thorough prenatal evaluation.', 'Done', '78', '98%', '', 'Assessed abdominal pain and checked fetal heart rate (normal).\r\nPerformed a physical examination, including checking for signs of preterm labor or other complications.\r\nOrdered a urine test to rule out urinary tract infection (UTI) or other causes of discomfort.\r\nAdvised rest and hydration, continue taking prenatal vitamins.', 'Monitor any further signs of preterm labor or abnormal symptoms, such as increased pain, bleeding, or loss of amniotic fluid.\r\nFollow-up visit in 2 weeks or sooner if symptoms worsen.', '2024-12-28', 0),
(10, 10, 'Swelling of feet and legs, fatigue, and occasional shortness of breath.', 'Patient is in the second trimester of pregnancy. These symptoms started around 2 weeks ago, gradually worsening.', '130/85', '80', '65kg', '16', '35°C', '160cm', 'New consultation/case', 'Prenatal', 'Rose Lopez', 'Patient experiencing swelling of the feet and legs, fatigue, and occasional shortness of breath. Referred for monitoring of potential complications such as preeclampsia or gestational hypertension.', 'Pending', '80', '97%', '', 'Performed routine prenatal examination.\r\nChecked for signs of preeclampsia, such as elevated blood pressure and proteinuria.\r\nOrdered urinalysis to check for protein in the urine (test pending).\r\nChecked fetal heart rate and movements (normal).\r\nAdvised the patient to elevate legs when resting and avoid standing for long periods.\r\nRecommended regular monitoring of blood pressure.', 'Monitor for any sudden weight gain, severe headaches, or visual disturbances that might indicate preeclampsia.\r\nAdvise patient to come back if symptoms worsen or if any other unusual signs appear.\r\nFollow-up in 2 weeks for routine check-up and further assessment.', '2024-12-28', 0),
(11, 0, 'High fever', 'The patient has been experiencing high fever for three days, accompanied by chills and body weakness.', '120/80', '100', '65kg', '97', '39°C', '170cm', 'Follow-up visit', 'Checkup', 'Jerom Badio', 'Suspected infection, rule out dengue or other illnesses', 'Pending', '100', '', '', '', '', '2024-12-28', 0),
(12, 11, 'High Fever', 'Vomiting', '120/80', '75', '85kg', '85', '39°C', '170', 'New consultation/case', 'Checkup', 'Jerom Badio', 'Patient requires checkup', 'Pending', '78', '', '', '', '', '2024-12-28', 0),
(13, 6, 'Labor pains with regular contractions', 'Full-term pregnancy', '120/80', '88', '65kg', '20', '36°C', '160cm', 'Follow-up visit', 'Birthing', 'Jerom Badio', 'Active labor, full-term pregnancy', 'Done', '88', '', 'referred', '', '', '2024-12-28', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctor_schedule`
--

CREATE TABLE `tbl_doctor_schedule` (
  `doc_scheduleID` int(11) NOT NULL,
  `userID` varchar(50) NOT NULL,
  `date_schedule` date DEFAULT NULL,
  `message` text NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1 COMMENT '0=not availble,1=available,2=pending,3=approved,4=rejected,5=view',
  `reapet` varchar(20) NOT NULL,
  `schedules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `leave_start_date` date DEFAULT NULL,
  `leave_end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `action_time` datetime DEFAULT NULL,
  `sync_status` int(11) DEFAULT 0,
  `is_read` int(11) NOT NULL,
  `notified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_doctor_schedule`
--

INSERT INTO `tbl_doctor_schedule` (`doc_scheduleID`, `userID`, `date_schedule`, `message`, `day_of_week`, `start_time`, `end_time`, `is_available`, `reapet`, `schedules`, `leave_start_date`, `leave_end_date`, `created_at`, `action_time`, `sync_status`, `is_read`, `notified`) VALUES
(1, '5', NULL, '', '', '', '', 1, 'Weekly', '{\"MONDAY\":[{\"fromtime\":\"07:00\",\"totime\":\"15:00\",\"worklength\":\"8h 0m\"}]}', NULL, NULL, '2024-12-28 14:37:24', NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_familyAddress`
--

CREATE TABLE `tbl_familyAddress` (
  `famID` int(11) NOT NULL,
  `brgy` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_familyAddress`
--

INSERT INTO `tbl_familyAddress` (`famID`, `brgy`, `purok`, `city_municipality`, `province`, `place_of_birth`, `created_at`, `updated_at`, `sync_status`) VALUES
(1, 'Tamnag (pob.)', 'Maligaya', '', 'Sultan Kudarat', 'Sultan Kudarat', '2024-12-28 14:39:40', NULL, 0),
(2, 'Sampao', '3', '', 'Sultan Kudarat', 'Sultan Kudarat', '2024-12-28 14:45:11', NULL, 0),
(3, 'Mamali', '6', '', 'Sultan Kudarat', 'Lutayan, Sultan Kudarat', '2024-12-28 14:57:42', NULL, 0),
(7, 'Antong', 'Sigasig', '', 'Sultan Kudarat', 'Davao', '2024-12-28 15:07:22', NULL, 0),
(8, 'Bayasong', '2', '', 'Sultan Kudarat', 'Lutayan, Sultan Kudarat', '2024-12-28 15:13:52', NULL, 0),
(9, 'Blingkong', 'Urdaneta', '', 'Sultan Kudarat', 'Lutayan Sultan Kudarat', '2024-12-28 15:15:48', '2024-12-28 15:54:16', 0),
(10, 'Bayasong', 'Baluno', '', 'Sultan Kudarat', 'luatayan, sultan kudarat', '2024-12-28 15:26:59', NULL, 0),
(11, 'Tananzang', '4', '', 'Sultan Kudarat', 'Lutayan', '2024-12-28 15:30:33', NULL, 0),
(12, 'Blingkong', 'Urdaneta', '', 'Sultan Kudarat', 'lutayab sultan kudarat', '2024-12-28 15:42:04', NULL, 0),
(13, 'Bayasong', 'Baluno', '', 'Sultan Kudarat', 'lutayan sultan kudarat', '2024-12-28 15:50:51', NULL, 0),
(14, 'Manili', '6', '', 'Sultan Kudarat', 'Sultan Kudarat', '2024-12-28 16:19:44', NULL, 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_family_members`
--

INSERT INTO `tbl_family_members` (`member_id`, `name`, `relationship`, `contact`, `address`, `patient_id`, `created_at`, `sync_status`) VALUES
(1, 'Juan Dela Cruz', 'Father', '09632658478', 'Lutayan, Sultan Kudarat', 1, '2024-12-28 14:39:40', 0),
(2, 'Maria Cruz Santos', 'Mother', '09177654321', 'Purok 3, Barangay Sampao, Lutayan, Sultan Kudarat', 2, '2024-12-28 14:45:11', 0),
(3, 'Maria Marble', 'Mother', '09157584558', 'Barangay Sampao, Lutayan, Sultan Kudarat', 3, '2024-12-28 14:57:42', 0),
(4, 'Ethenia Quiambao', 'Aunt', '094587445887', 'Barangay Sampao, Lutayan, Sultan Kudarat', 4, '2024-12-28 15:07:22', 0),
(5, 'Mang Rigor', 'Father', '095478554785', 'Barangay Maunlad, Lutayan, Sultan Kudarat', 5, '2024-12-28 15:13:52', 0),
(6, 'Maria Perez', 'Mother', '09374628467', 'Prk.urdaneta Brgy.blingkong Lutayan Sultan Kudarat', 6, '2024-12-28 15:15:48', 0),
(7, 'jenefer flores', 'Wife', '09476274621', 'prk.baluno Brgy.bayasong lutayan, sultan kudarat', 7, '2024-12-28 15:26:59', 0),
(8, 'Tasha Lim', 'Employer', '09157844887', 'Brgy. Sampao, Sultan Kudarat', 8, '2024-12-28 15:30:33', 0),
(9, 'joseph cruz', 'Husband', '09274614827', 'prk.urdaneta brgy. blingkong lutayan,  sultan kudarat', 9, '2024-12-28 15:42:04', 0),
(10, 'jacob aquino', 'Husband', '09264826483', 'prk.baluno brgy.bayasong lutayan, sultan kudarat', 10, '2024-12-28 15:50:51', 0),
(11, 'Espe Ranxa', 'Grand Mother', '0915485258888', 'Manili, Lutayan Sultan Kudarat', 11, '2024-12-28 16:19:44', 0);

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_healthnotes`
--

INSERT INTO `tbl_healthnotes` (`notedsID`, `patient_id`, `userID`, `date`, `time`, `doctorNotes`, `nureNotes`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, 5, '2024-12-28', '23:32:00', 'Nebulizer Treatment', '', 1, '2024-12-28 15:30:51', 0),
(2, 1, 7, '2024-12-28', '02:30:00', '', 'Shortness of Breath', 1, '2024-12-28 15:31:12', 0);

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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_immunization_records`
--

INSERT INTO `tbl_immunization_records` (`immunID`, `patient_id`, `vaccine`, `immunization_date`, `immunization_next_date`, `remarks`, `userID`, `created_at`, `sync_status`) VALUES
(1, 3, 'Rabies Vaccine (purified Vero Cell Vaccine) 1ml', '2024-12-28', '2025-01-09', 'First dose of rabies vaccine administered as per post-exposure prophylaxis (PEP) protocol for animal bite (if applicable).\r\nKeep patient under observation for any adverse reactions following vaccine administration.', 4, '2024-12-28', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_laboratory`
--

INSERT INTO `tbl_laboratory` (`labid`, `services`, `date_test`, `test_result`, `patient_id`, `image`, `created_at`, `sync_status`) VALUES
(1, 'Blood Typing', '2024-12-24', 'something wrong', 8, 'ProfilePhoto.jpg', '2024-12-28 15:33:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_attempts`
--

CREATE TABLE `tbl_login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_attempt_time` timestamp NULL DEFAULT NULL,
  `locked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=active,0=inactive',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_medicines`
--

INSERT INTO `tbl_medicines` (`medicineID`, `medicine_name`, `description`, `supplier`, `category`, `manuf_date`, `ex_date`, `manufacturer`, `brand`, `status`, `date_added`, `sync_status`) VALUES
(1, 'Amoxicillin 250mg Capsules', 'A Broad-spectrum Antibiotic Used To Treat Bacterial Infections Such As Respiratory, Urinary, And Ear Infections.', 'Healthline Distributors', 'Antibiotics', '2023-06-10', '2025-06-10', 'Curemax Pharmaceuticals', 'Amoxicare', 1, '2024-12-05 05:30:57', 0),
(2, 'Cetirizine  10mg Tablets', 'An Antihistamine Used To Relieve Allergy Symptoms Such As Sneezing, Runny Nose, And Itching.', 'Allergen-free Pharma', 'Antihistamines', '2024-12-05', '2024-12-05', 'MediPro Labs', 'AllerEase', 1, '2024-12-05 05:33:57', 0),
(3, 'Folic Acid 5mg Tablets', 'A Vitamin Supplement Used During Pregnancy To Prevent Neural Tube Defects And Support Fetal Development.', 'Nutricare Pharma Supplies', 'Immunosuppressants', '2024-12-05', '2024-12-05', 'VitaWell Laboratories', 'PrenoCare', 1, '2024-12-05 05:36:52', 0),
(4, 'Oxytocin 10 Iu/ml Injection', 'A Hormone Injection Used To Induce Labor, Control Postpartum Bleeding, And Manage Uterine Contractions During Childbirth.', 'Mothercare Medical Supplies', 'Vaccines', '2024-12-05', '2024-12-05', 'BioHormone Pharma', 'OxyFlow', 1, '2024-12-05 05:38:11', 0),
(5, 'Rabies Vaccine (purified Vero Cell Vaccine) 1ml', 'A Vaccine Used For Pre- And Post-exposure Prophylaxis Of Rabies To Prevent Infection After Exposure To Rabies Virus.', 'Lifeshield Medical Distributors', 'Vaccines', '2024-12-05', '2024-12-05', 'SafeVax Biopharma', 'RabiShield', 1, '2024-12-05 05:39:32', 0),
(6, 'Loperamide 2mg Capsules', 'An Anti-diarrheal Medication Used To Treat Sudden Diarrhea And To Reduce The Frequency Of Bowel Movements.', 'Healthmed Distributors', 'Antipsychotics', '2024-12-05', '2024-12-07', 'Medplus Pharmaceuticals', 'Diastop', 1, '2024-12-05 05:41:53', 0),
(7, 'Wer', 'Wer23', 'Werwer', 'Analgesics', '2024-12-06', '2024-12-06', 'Werwerwer', 'Werfer', 1, '2024-12-06 02:48:55', 0),
(8, 'Omeprazole', 'Acid', 'Red Cross', 'Antidiabetic Drugs', '2024-12-05', '2024-12-06', '123fdsfsdf', 'Omeprazole', 1, '2024-12-06 02:55:43', 0),
(9, 'Sample Med', 'Assddsadnasd', 'Sample', 'Antibiotics', '2025-01-30', '2024-10-07', 'Sample Company', 'sample', 1, '2024-12-06 18:03:42', 0),
(10, 'Cetirizine', 'Fndsbsdbvlkdsb', 'Mercury', 'Analgesics', '2024-11-04', '2024-12-07', 'Sample', 'Sample', 1, '2024-12-07 05:50:23', 0),
(11, 'Solmux Tablet', 'Solmux Is Used To Treat Cough With Phlegm.', 'U', 'Antibiotics', '2024-08-22', '2025-02-21', 'Unilab', 'Unilab', 1, '2024-12-09 07:12:53', 0),
(12, 'Test', 'Test', 'Test', 'Analgesics', '2024-12-09', '2024-12-18', 'test', 'test', 1, '2024-12-20 13:31:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicine_details`
--

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_medicine_details`
--

INSERT INTO `tbl_medicine_details` (`med_detailsID`, `medicine_id`, `packing`, `qt`, `sync_status`) VALUES
(1, 1, '10', '938', 0),
(2, 2, 'Pack of 10 Tablets', '1993', 0),
(3, 6, 'Blister Pack of 10 Capsules', '3000', 0),
(4, 5, '1mL Single-Dose Vial, Box of 5 Vials', '4998', 0),
(5, 4, '1mL Ampoule, Box of 10 Ampoules', '1011', 0),
(6, 3, 'Blister Pack of 30 Tablets', '5002', 0),
(7, 8, '90', '120', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_membership_info`
--

CREATE TABLE `tbl_membership_info` (
  `membershipID` int(11) NOT NULL,
  `phil_mem` varchar(50) NOT NULL,
  `philhealth_no` varchar(255) DEFAULT NULL,
  `phil_membership` varchar(100) DEFAULT NULL,
  `ps_mem` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_membership_info`
--

INSERT INTO `tbl_membership_info` (`membershipID`, `phil_mem`, `philhealth_no`, `phil_membership`, `ps_mem`, `created_at`, `updated_at`, `sync_status`) VALUES
(1, 'Yes', '986523200125', 'Dependent', 'NHTS', '2024-12-28 14:39:40', NULL, 0),
(2, 'Yes', '123456789101', 'Member', '4PS', '2024-12-28 14:45:11', NULL, 0),
(3, 'Yes', '987654322101', 'Dependent', '4PS', '2024-12-28 14:57:42', NULL, 0),
(4, 'No', '', '', '4PS', '2024-12-28 15:07:22', NULL, 0),
(5, 'Yes', '026566868568', 'Member', 'Private', '2024-12-28 15:13:52', NULL, 0),
(6, 'Yes', '35454334646', 'Member', 'NHTS', '2024-12-28 15:15:48', '2024-12-28 15:54:16', 0),
(7, 'Yes', '35454334646', NULL, '', '2024-12-28 15:26:59', NULL, 0),
(8, 'Yes', '456476545343', 'Member', 'NHTS', '2024-12-28 15:30:33', NULL, 0),
(9, 'Yes', '354543346461', 'Member', '', '2024-12-28 15:42:04', NULL, 0),
(10, 'Yes', '131241564311', 'Member', '', '2024-12-28 15:50:51', NULL, 0),
(11, 'Yes', '446546435454', 'Member', 'Private', '2024-12-28 16:19:44', NULL, 0);

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
  `age` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `blood_type` varchar(20) NOT NULL,
  `ed_at` varchar(100) NOT NULL,
  `emp_stat` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `reg_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`patientID`, `family_address`, `Membership_Info`, `household_no`, `patient_name`, `middle_name`, `last_name`, `suffix`, `father_guardian_name`, `mother_name`, `cnic`, `date_of_birth`, `age`, `phone_number`, `gender`, `civil_status`, `blood_type`, `ed_at`, `emp_stat`, `religion`, `Nationality`, `reg_date`, `userID`, `updated_at`, `sync_status`) VALUES
(1, 1, 1, '9331421', 'Maria', '', 'Dela Cruz', '', 'Juan Dela Cruz', '', '0000000001', '1990-02-07', '34 years', '+639865623214', 'Female', 'Married', 'A+', '', '', '', 'Filipino', '2024-12-28', 4, NULL, 0),
(2, 2, 2, '9331422', 'Juan', 'Dela Cruz', 'Santos', 'Jr .', '', '', '0000000002', '1999-02-10', '25 years', '+639171234567', 'Male', 'Single', 'O+', 'Undergrad', 'Not Applicable', 'Roman Catholic', 'Filipino', '2024-12-28', 3, NULL, 0),
(3, 3, 3, '9331423', 'Lhiam', 'Santos', 'Marble', '', '', '', '0000000003', '2023-12-28', '1 year', '+639174567890', 'Male', 'Single', 'O+', 'No Formal Education', 'Not Applicable', 'Animism and Indigenous Beliefs', 'Filipino', '2024-12-28', 3, NULL, 0),
(4, 7, 4, '9331424', 'Meriam', '', 'Quiambao', '', '', '', '0000000004', '1999-02-03', '25 years', '+639545877455', 'Female', 'Single', 'AB+', 'Undergrad', 'Volleyball Coach', 'Iglesia ni Cristo(INC)', 'Filipino', '2024-12-28', 3, NULL, 0),
(5, 8, 5, '9331425', 'Nathia', 'Terea', 'Lumgan', '', '', '', '0000000005', '2002-02-05', '22 years', '+639458447885', 'Female', 'Married', 'A+', 'College Graduate', 'Teacher', 'Methodists', 'Filipino', '2024-12-28', 3, NULL, 0),
(6, 9, 6, '9331426', 'Gwen', 'Reyes', 'Perez', '', '', '', '0000000006', '2024-12-27', 'Newborn', '+639736521744', 'Female', 'Single', 'AB+', 'Undergrad', 'Sales Lady', 'Church of Jesus Christ of Latter-day Saints (LDS)', 'Filipino', '2024-12-28', 9, '2024-12-28 15:54:16', 0),
(7, 10, 7, '9331427', 'Chris', 'chu', 'flores', 'jr', '', '', '0000000007', '1997-12-23', '27 years', '+639847658747', 'Male', 'Married', 'B-', 'College Graduate', 'Driver', 'Roman Catholic', 'Filipino', '2024-12-28', 9, NULL, 0),
(8, 11, 8, '9331427', 'Paul', 'Mahinay', 'Marinay', '', 'Tasha Lim', '', '0000000007', '1999-08-15', '25 years', '+639458745225', 'Male', 'Single', 'O+', 'College Graduate', 'Nurse', 'ehovah\'s Witnesses', 'Filipino', '2024-12-28', 4, NULL, 0),
(9, 12, 9, '9331428', 'Grace', 'masong', 'cruz', '', '', '', '0000000009', '1999-04-27', '25 years', '+639874627364', 'Female', 'Married', 'B+', 'Undergrad', '', '', 'Filipino', '2024-12-28', 9, NULL, 0),
(10, 13, 10, '9331429', 'Joli', 'ali', 'aquino', '', '', '', '0000000010', '1995-05-14', '29 years', '+639736482617', 'Female', 'Married', 'A-', 'Undergrad', 'house wife', 'Baptists', 'Filipino', '2024-12-28', 9, NULL, 0),
(11, 14, 11, '9331430', 'Manica', 'Monica', 'Manila', '', 'Espe Ranxa', '', '0000000011', '1999-02-16', '25 years', '+639154875448', 'Female', 'Married', 'AB-', 'College Graduate', 'Clerk', 'Roman Catholic', 'Filipino', '2024-12-28', 4, NULL, 0);

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
  `advice` text NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_patient_medication_history`
--

INSERT INTO `tbl_patient_medication_history` (`patient_med_historyID`, `patient_visit_id`, `medicine_details_id`, `con_type`, `quantity`, `dosage`, `schedule_dosage`, `mg_ml`, `duration`, `time_frame`, `advice`, `sync_status`) VALUES
(1, 6, 8, 'Oral(p/o)', '1', 'schedule dose', 'Before Meal', '20', 'Once a day', '30 days (Month)', 'Take on an empty stomach before meals.', 0),
(2, 8, 1, 'Oral(p/o)', '1', 'as needed', '', '250', '', '5 (Day)', 'rest', 0),
(3, 9, 8, 'Oral(p/o)', '3', 'schedule dose', 'In the morning', '80', 'Every 3 hours', '2 (Day)', 'inom damo tubig', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_visits`
--

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL,
  `visit_date` date DEFAULT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `visit_counts` bigint(20) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_patient_visits`
--

INSERT INTO `tbl_patient_visits` (`patient_visitID`, `visit_date`, `next_visit_date`, `disease`, `recom`, `patient_id`, `doctor_id`, `visit_counts`, `sync_status`) VALUES
(1, '2024-12-28', NULL, '', '', 0, 0, 1, 0),
(2, '2024-12-28', NULL, '', '', 0, 0, 1, 0),
(3, '2024-12-28', NULL, '', '', 0, 0, 1, 0),
(4, '2024-12-28', NULL, '', '', 0, 0, 1, 0),
(6, '2024-12-29', '2025-01-07', 'Mild abdominal discomfort and lower back pain.', 'Rest for 3 days, avoid heavy lifting or strenuous physical activity.\r\nMaintain hydration and rest frequently.\r\nMonitor for any worsening symptoms such as bleeding, severe pain, or signs of preterm labor (e.g., contractions, water breaking).\r\nReturn if symptoms worsen or if new concerns arise.', 8, 5, 0, 0),
(8, '2024-12-29', '2025-01-11', 'Acute Febrile Illness (Suspected Viral Infection)', 'ret', 11, 2, 0, 0),
(9, '2024-12-29', '2025-01-04', 'Acute Ulcer', 'rest ka lang muna ', 10, 7, 0, 0),
(10, '2024-12-29', NULL, '', '', 0, 0, 2, 0);

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
  `address` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personnel`
--

INSERT INTO `tbl_personnel` (`personnel_id`, `first_name`, `middlename`, `lastname`, `contact`, `email`, `address`, `sync_status`) VALUES
(1, 'Lutayan', 'A.', 'RHU-admin', '1234567890', 'admin@example.com', '123 Admin St', 0),
(2, 'Irlan', 'Santos', 'Cruz', '+632131321321', 'drc123@gmail.com', 'south cotabato', 0),
(3, 'Loreine', 'A', 'Santos', '+639999999999', 'mariar.reyes@example.com', 'Marbel', 0),
(4, 'Jerom', '', 'Badio', '+639451234567', 'rhu123@gmail', 'Rhu123rhu123', 0),
(5, 'John', '', 'Erwe', '+635434563465', 'John@gmail.com', 'lutayan Sultan kudarat', 0),
(6, 'ricardo', '', 'saliling', '+639633252321', 'ricardo@gmail.com', 'koronadal city , south cotabato', 0),
(7, 'Nicole', '', 'Dela Cruz', '+639653232154', 'Nicole@gmail.com', 'Lutayan Sultan Kudarat', 0),
(8, 'Sandara', '', 'Raquim', '+639653212228', 'Sandara@gmail.com', 'koronadal city , south cotabato', 0),
(9, 'Rose', 'Cy', 'Lopez', '+639453457245', 'rosecylopez19@gmail.com', 'Brgy. Blingkong Lutayan, Sultan Kudarat', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_physicalexam`
--

INSERT INTO `tbl_physicalexam` (`physical_exam_id`, `fht`, `fundic_ht`, `dilation`, `effacement`, `bow`, `maneuver`, `SKIN`, `heent`, `chest_lungs`, `CARDIOVASCULAR`, `abdomen`, `extremities`, `created_at`, `sync_status`) VALUES
(1, '56', '5645', '56', '564', '456', '34', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '2024-12-28 14:23:44', 0),
(2, '35cm', '36 cm', '6 cm', '80%', 'Intact', 'Cephalic presentation, fetal back on the left side, head engaged', '[\"Nodules\",\"\"]', '[\"anicteric sclerea\",\"Nasal Discharge\",\"\"]', '[\"symmtrical chest expansion\",\"\"]', '[\"Adynamic Precordlum\",\"\"]', '[\"Globular\",\"\"]', '[\"Normal gait\",\"\"]', '2024-12-28 14:55:47', 0),
(3, '145', '35', '4', '60', 'intact', 'Cephalic presentation, fetal back on left.', '[\"Good skin turgor\",\"\"]', '[\"anicteric sclerea\",\"\"]', '[\"Clear Breath sounds\",\"\"]', '[\"\"]', '[\"\"]', '[\"\"]', '2024-12-28 16:44:13', 0);

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
  `LicenseNo` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`position_id`, `personnel_id`, `PositionName`, `Specialty`, `ProfessionalType`, `LicenseNo`, `sync_status`) VALUES
(1, 1, 'Administrator', 'N/A', 'Professional Admin', '12345', 0),
(2, 2, 'Doctor', 'Family Picture', 'M.D', '0123', 0),
(3, 3, '', '', '', '', 0),
(4, 4, '', '', '', '', 0),
(5, 5, 'Doctor', 'Family doctor', 'M.D', '9632659862', 0),
(6, 6, 'Physician', 'Physician', 'Physician', '', 0),
(7, 7, 'Midwife', 'Midwife', 'Midwife', '', 0),
(8, 8, 'Nurse', 'Certified Nurse', 'Nurse', '', 0),
(9, 9, '', '', '', '', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_postpartum`
--

INSERT INTO `tbl_postpartum` (`postpartumID`, `patient_id`, `date_postpartum`, `monitoring_data`, `maternal_wellbeing`, `uterine_firmness`, `rubra`, `perineum_pain`, `breast_condition`, `feeding`, `bladder`, `bowel_movement`, `vaginal_discharge`, `key_messages`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, 1, '2024-12-28', '{\"date\":\"2024-12-28\",\"time\":\"23:22\",\"monitoring\":{\"every5_15\":{\"times\":[\"\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}', '', '', '', '', '', '', '', '', '', '', 1, '2024-12-28 15:22:07', 0);

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
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prenatal`
--

INSERT INTO `tbl_prenatal` (`prenatalID`, `date`, `chief_complaint`, `attending_physician`, `lmp`, `ga_by_lmp`, `edc_by_lmp`, `fhr`, `ga_by_sonar`, `edc_by_utz`, `pregnancy_age`, `biparietal_diameter`, `biparietal_eq`, `head_circumference`, `head_circumference_eq`, `abdominal_circumference`, `abdominal_circumference_eq`, `femoral_length`, `femoral_length_eq`, `crown_rump_length`, `crown_rump_length_eq`, `mean_gest_sac_diameter`, `mean_gest_sac_diameter_eq`, `average_fetal_weight`, `gestation`, `presentation_lie`, `amniotic_fluid`, `placenta_location`, `previa`, `placenta_grade`, `fetal_activity`, `comments`, `radiologist`, `patient_id`, `user_id`, `created_at`, `sync_status`) VALUES
(1, '2024-12-28', '  Mild Abdominal Discomfort And Lower Back Pain During Pregnancy. ', 6, ' November 15, 2024', '150 bpm (normal)', 'August 22, 2025', '150 bpm (normal)', '18 weeks + 2 days (a', 'August 24, 2025 (bas', '18 weeks 2 days', '4.5 cm', '18 weeks + 2 days', '16.0 cm', '18 weeks + 2 days', '14.8 cm', '18 weeks + 2 days', '3.2 cm', '18 weeks + 2 days', '14.0 cm', '18 weeks + 2 days', '5.3 cm', '18 weeks + 2 days', '200 grams (approx.)', 'Single', 'Cephalic', 'Normal', 'Anterior', 'Low Lying', '1', 'limb', 'The Fetus Appears To Be Growing Appropriately For The Gestational Age.\r\nNo Signs Of Structural Abnor', 'Dr.cruz', 9, 4, '2024-12-28 16:00:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_referrals_log`
--

CREATE TABLE `tbl_referrals_log` (
  `referral_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `referral_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_referrals_log`
--

INSERT INTO `tbl_referrals_log` (`referral_id`, `patient_id`, `referral_date`, `userID`, `status`, `sync_status`) VALUES
(1, 8, '2024-12-28', 4, '', 0),
(2, 6, '2024-12-28', 4, '', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_systemreview`
--

INSERT INTO `tbl_systemreview` (`system_review_id`, `general`, `skin`, `head`, `ears`, `eyes`, `nose`, `throat`, `neck`, `breast`, `respiratory`, `cardiovascular`, `gastrointestinal`, `urinary`, `genitalia`, `vascular`, `musculoskeletal`, `neurologic1`, `hematologic`, `endocrine`, `neurologic2`, `created_at`, `sync_status`) VALUES
(1, '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '2024-12-28 14:23:44', 0),
(2, '[\"weight_loss_gain\"]', '[\"rashes\"]', '[]', '[]', '[\"Cataracts\"]', '[]', '[\"Thursh\"]', '[\"Swollen Glands\"]', '[]', '[\"Wheezing\"]', '[\"Chest Pain\\/Discomfort\"]', '[\"Change in Appetite\"]', '[\"Change in bowel Habits\"]', '[\"Viginal dryness\"]', '[]', '[\"Back pain\"]', '[\"Tremor\"]', '[\"Easy Bruising\"]', '[\"Sweeting\"]', '[\"Hot Flashes\"]', '2024-12-28 14:55:47', 0),
(3, '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '2024-12-28 16:44:13', 0);

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
  `last_attempt_time` datetime DEFAULT NULL,
  `sync_status` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `user_name`, `UserType`, `password`, `status`, `profile_picture`, `personnel_id`, `position_id`, `userpageID`, `reg`, `failed_attempts`, `last_attempt_time`, `sync_status`, `updated_at`, `locked_until`) VALUES
(1, 'administrator', 'admin', '$2a$12$SXm.VE78VdZGzVif9V2G/OZLlp1LGlHAYA7F7sHQT/HTEdCl6xbeK', 'Active', 'Doctor scheduling app.png', 1, 1, 0, '2024-12-09 10:55:51', 0, '0000-00-00 00:00:00', 0, '2024-12-26 01:56:48', NULL),
(2, 'drcruz21', 'Doctor', '$2y$10$QF.ILK2lMn5vEkH5X0qt9eeNYoqdm/cOYXfS5bPG4jIlNyUXMY0v2', 'Active', '../user_images/676e4ec82d6b2_profile_pic5758276332707777082.jpg', 2, 2, 0, '2024-12-09 10:58:26', 0, '0000-00-00 00:00:00', 0, '2024-12-28 08:43:55', NULL),
(3, 'bhw123', 'BHW', '$2y$10$l8JV7LK458Cyod5T5I6bMeZTardL/Gah.zQI3kuoJR5zLGFSNJS1u', 'Active', '', 3, 3, 0, '2024-12-09 11:00:26', 0, '0000-00-00 00:00:00', 0, '2024-12-26 01:57:31', NULL),
(4, 'rhu123', 'RHU', '$2y$10$giM9NBTfrvbLQTwHpDaUlOMsRchU0cZjtjPovmcMVTOMJisQf3gam', 'Active', '', 4, 4, 0, '2024-12-11 02:28:42', 0, '0000-00-00 00:00:00', 0, '2024-12-26 02:00:08', NULL),
(5, 'Qwerty', 'Doctor', '$2y$10$uvvlGbNhwLJmdbGCR2Zqs.XHTwCi/xaV7Ay3vaWoi3sMaBLicO882', 'Active', 'tg logo.png', 5, 5, NULL, '2024-12-28 14:09:10', 0, NULL, 0, '2024-12-28 14:15:18', NULL),
(6, 'Ricardo', 'Physician', NULL, 'Active', '', 6, 6, NULL, '2024-12-28 14:13:50', 0, NULL, 0, NULL, NULL),
(7, 'Nicole', 'Midwife', NULL, 'Active', '', 7, 7, NULL, '2024-12-28 14:19:06', 0, NULL, 0, NULL, NULL),
(8, 'Sandara', 'Nurse', NULL, 'Active', '', 8, 8, NULL, '2024-12-28 14:19:55', 0, NULL, 0, NULL, NULL),
(9, 'Roselopez123', 'BHW', '$2y$10$XnIcOmRHHG6XafLXY7cZQ.9Qy1KO26AbZU8EoxgOgAe0FBmwdWkD.', 'Active', 'Screenshot 2024-11-18 135427.png', 9, 9, NULL, '2024-12-28 14:47:21', 0, NULL, 0, '2024-12-28 14:48:42', NULL);

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
  `status` int(11) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_log`
--

INSERT INTO `tbl_user_log` (`logID`, `userID`, `username`, `user_ip`, `login_time`, `logout`, `status`, `sync_status`) VALUES
(1, 3, 'bhw123', 0x323030313a343435363a3162393a6164, '2024-12-28 14:40:49', NULL, 1, 0),
(2, 1, 'administrator', 0x3135382e36322e37392e313234000000, '2024-12-28 14:41:14', NULL, 1, 0),
(3, 9, 'Roselopez123', 0x3135382e36322e37392e313234000000, '2024-12-28 14:49:15', NULL, 1, 0),
(4, 4, 'rhu123', 0x3135382e36322e37392e313234000000, '2024-12-28 14:52:25', NULL, 1, 0),
(5, 3, 'bhw123', 0x3137352e3137362e39332e3231300000, '2024-12-28 15:04:35', '28-12-2024 11:16:23 PM', 1, 0),
(6, 4, 'rhu123', 0x323030313a343435363a3162393a6164, '2024-12-28 15:16:35', '28-12-2024 11:39:54 PM', 1, 0),
(7, 1, 'administrator', 0x323030313a343435363a3162393a6164, '2024-12-28 15:39:39', NULL, 1, 0),
(8, 4, 'rhu123', 0x3137352e3137362e39332e3231300000, '2024-12-28 15:40:01', '29-12-2024 12:14:36 AM', 1, 0),
(9, 1, 'administrator', 0x3137352e3137362e39332e3231300000, '2024-12-28 15:44:22', NULL, 1, 0),
(10, 1, 'administrator', 0x3137352e3137362e39332e3231300000, '2024-12-28 16:14:05', NULL, 1, 0),
(11, 3, 'bhw123', 0x323030313a343435363a3162393a6164, '2024-12-28 16:14:50', '29-12-2024 12:16:40 AM', 1, 0),
(12, 4, 'rhu123', 0x323030313a343435363a3162393a6164, '2024-12-28 16:16:50', '29-12-2024 04:08:22 AM', 1, 0),
(13, 1, 'administrator', 0x323030313a343435363a3162393a6164, '2024-12-28 16:24:59', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_page`
--

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `headerColor` varchar(100) NOT NULL,
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vitalsigns_monitoring`
--

INSERT INTO `tbl_vitalsigns_monitoring` (`vitalSignsID`, `room`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `fht`, `duration`, `frequency`, `intensity`, `nurse_midwife`, `patient_id`, `birth_info_id`, `created_at`, `sync_status`) VALUES
(1, '203', '2024-12-28', '08:00:00', '120/80', '80', '18', '37.1°C', '140', '45', 'Every 5 minutes', 'Mild', 7, 1, 1, '2024-12-28 15:24:04', 0);

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`doc_scheduleID`);

--
-- Indexes for table `tbl_familyAddress`
--
ALTER TABLE `tbl_familyAddress`
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
-- Indexes for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `userID` (`userID`);

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
-- AUTO_INCREMENT for table `tbl_animal_bite_care`
--
ALTER TABLE `tbl_animal_bite_care`
  MODIFY `animal_biteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_animal_bite_vaccination`
--
ALTER TABLE `tbl_animal_bite_vaccination`
  MODIFY `animal_bite_vacID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  MODIFY `announceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_audit_trail`
--
ALTER TABLE `tbl_audit_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_birthing_medication`
--
ALTER TABLE `tbl_birthing_medication`
  MODIFY `medicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_birthing_monitoring`
--
ALTER TABLE `tbl_birthing_monitoring`
  MODIFY `birthMonitorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birthroom`
--
ALTER TABLE `tbl_birthroom`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_birth_info`
--
ALTER TABLE `tbl_birth_info`
  MODIFY `birth_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birth_ivfluids`
--
ALTER TABLE `tbl_birth_ivfluids`
  MODIFY `fluidsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_certificate_log`
--
ALTER TABLE `tbl_certificate_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_checkup`
--
ALTER TABLE `tbl_checkup`
  MODIFY `checkupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_clinicalrecords`
--
ALTER TABLE `tbl_clinicalrecords`
  MODIFY `recordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_complaints`
--
ALTER TABLE `tbl_complaints`
  MODIFY `complaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_discharged`
--
ALTER TABLE `tbl_discharged`
  MODIFY `dischargedid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_doctor_schedule`
--
ALTER TABLE `tbl_doctor_schedule`
  MODIFY `doc_scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_familyAddress`
--
ALTER TABLE `tbl_familyAddress`
  MODIFY `famID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_family_members`
--
ALTER TABLE `tbl_family_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_healthnotes`
--
ALTER TABLE `tbl_healthnotes`
  MODIFY `notedsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_immunization_records`
--
ALTER TABLE `tbl_immunization_records`
  MODIFY `immunID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_laboratory`
--
ALTER TABLE `tbl_laboratory`
  MODIFY `labid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_medicines`
--
ALTER TABLE `tbl_medicines`
  MODIFY `medicineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_medicine_details`
--
ALTER TABLE `tbl_medicine_details`
  MODIFY `med_detailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_membership_info`
--
ALTER TABLE `tbl_membership_info`
  MODIFY `membershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_patient_medication_history`
--
ALTER TABLE `tbl_patient_medication_history`
  MODIFY `patient_med_historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_patient_visits`
--
ALTER TABLE `tbl_patient_visits`
  MODIFY `patient_visitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_personnel`
--
ALTER TABLE `tbl_personnel`
  MODIFY `personnel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_physicalexam`
--
ALTER TABLE `tbl_physicalexam`
  MODIFY `physical_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_postpartum`
--
ALTER TABLE `tbl_postpartum`
  MODIFY `postpartumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_prenatal`
--
ALTER TABLE `tbl_prenatal`
  MODIFY `prenatalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_referrals_log`
--
ALTER TABLE `tbl_referrals_log`
  MODIFY `referral_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_systemreview`
--
ALTER TABLE `tbl_systemreview`
  MODIFY `system_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user_page`
--
ALTER TABLE `tbl_user_page`
  MODIFY `userpageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vitalsigns_monitoring`
--
ALTER TABLE `tbl_vitalsigns_monitoring`
  MODIFY `vitalSignsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
