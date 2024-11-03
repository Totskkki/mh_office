-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 11:07 AM
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
(4, '2024-10-16', 'Covid vaccination day', 'Covid vaccination day on November 5, 2024', '2024-09-14 00:10:45', '2024-10-13 23:24:50');

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
(2, 7, 'Insert', 'Added patient: Irene basco', 'tbl_patients', 8, '2024-10-15 08:25:36', '::1');

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
(2, 8, '2024-10-17', 2, 'fdsa', 'fdsa', '17:27:00', '2024-10-17', 'fdsafsa', 'fsda', 'fdsa', 1, '2024-10-17 16:27:09');

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
(1, 1, '20241017001', 8, 'fdsfds', '2024-10-17', '16:25:00', '16:25:00', '16:25:00', '16:25:00', '16:25:00', '16:25', 'Yes', 'fds', '16:25:00', 'Livebirth', 'Yes', '4kg', 'Yes', 'fsd', 'fdsa', 'ACTIVE LABOUR', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', 'fdsafd', 'fdsa', 'fdsa', 'fdsa', 'fdsa', '2024-10-17 08:26:04');

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
(1, 8, '2024-10-17', 'fsda', 'fdsa', 'fsda', 'fsd', '', '', '{\"labor\":{\"types\":[\"Onset\"],\"time\":\"16:27\",\"date\":\"17\\/10\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"cervix\":{\"time\":\"16:27\",\"date\":\"17\\/10\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"baby\":{\"time\":\"03:27\",\"date\":\"17\\/10\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}},\"placenta\":{\"time\":\"10:27\",\"date\":\"17\\/10\\/2024\",\"duration\":{\"hrs\":\"2\",\"mins\":\"2\"}}}', '{\"placenta\":{\"expelled\":[\"Expelled Completely\"]},\"umbilicalCord\":{\"cm\":\"21\",\"loops\":\"2\",\"none\":\"None\"},\"other\":\"2\",\"bloodLoss\":{\"antepartum\":\"2\",\"intrapartum\":\"2\",\"postpartum\":\"2\",\"total\":\"2\"}}', '[\"Cesarean\",\"\"]', '[]', '[]', '[]', '[]', '[]', '[\"\"]', '[]', '', '', '', 'fsda', 'fdsa', 31, 1, '2024-10-17 16:28:09');

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
(1, 8, '20241017001', '2024-10-17', 'fd', 'fds', 'fds', '{\"g\":\"fds\",\"p\":\"fds\",\"term\":\"fds\",\"preterm\":\"fd\",\"abortion\":\"fd\",\"living\":\"fd\"}', 'fdsaf', '[\"Heart Disease\",\"\"]', '', '', '', '[\"Hypertension\",\"\"]', '{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}', '{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}', '{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"fds\",\"illness\":\"fds\",\"tot_visit\":\"fds\",\"others\":\"\"}', '[{\"year\":\"fsd\",\"place_of_confinement\":\"fds\",\"aog\":\"fds\",\"bw\":\"fd\",\"manner_of_delivery\":\"sfds\",\"complication_remarks\":\"fds\"}]', 7, 1, 1, '31', 'done', '2024-10-17');

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
(1, 8, '2024-10-17', '16:27:00', '16:27:00', '1', 'fdsa', 'fsda', 1, '2024-10-17 08:27:18');

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
(3, 1, '2024-09-23 18:49:25', 'done', 'D:\\xampp\\htdocs\\MH_Office_final\\RHU/certificates/1_2024-09-23.pdf');

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
  `address` varchar(255) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `admission_time` time DEFAULT NULL,
  `dischargeDate` date DEFAULT NULL,
  `dischargeTime` time NOT NULL,
  `type_of_admission` varchar(100) DEFAULT NULL,
  `admitting_midwife` varchar(100) DEFAULT NULL,
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

INSERT INTO `tbl_clinicalrecords` (`recordID`, `patient_id`, `employer`, `address`, `admission_date`, `admission_time`, `dischargeDate`, `dischargeTime`, `type_of_admission`, `admitting_midwife`, `admitting_diagnosis`, `final_diagnosis`, `procedure_done`, `disposition`, `birth_info_id`, `created_at`) VALUES
(1, 8, 'fdsa', 'fdsa', '2024-10-17', '16:25:00', '2024-10-15', '16:29:00', 'new', 'Angel  Lobrido', 'fdsa', 'sfda', 'fdsa', 'improved', 1, '2024-10-17 08:29:37');

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
(1, 8, '', '', '122 / 80_', '2', '2kg', '2', '2°C', '2cm', 'Follow-up visit', 'Birthing', 'fdsa', 'sda', 'Done', '2', '', '', '2024-10-17');

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
  `userID` int(11) NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_doctor_schedule`
--

INSERT INTO `tbl_doctor_schedule` (`doc_scheduleID`, `userID`, `day_of_week`, `start_time`, `end_time`, `is_available`) VALUES
(1, 29, 'Tuesday,Wednesday,Friday', '07:00:00', '17:26:00', 1);

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
(8, 'Bayasong', 'Riverside', 'Lutayan', 'Sultan Kudarat', 'sultan kudarat', '2024-10-15 08:25:36', '2024-10-15 08:34:58');

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
(1, 'pablito', 'Father', 'koronadal city , south cotabato', '09677819501', 1, '2024-09-09 02:02:11'),
(2, 'alexa', 'Mother', 'koronadal city , south cotabato', '09677819501', 1, '2024-09-09 02:02:11'),
(6, 'pablito', 'Father', 'LAMBA,BANGA, SOUTH COTABATO', '09103253465', 3, '2024-09-13 00:08:05'),
(7, 'eleonora', 'Mother', 'LAMBA,BANGA, SOUTH COTABATO', '09103253465', 3, '2024-09-13 00:08:05'),
(8, 'pablito', 'Father', 'LACIA RESIDENCE', '09677819501', 5, '2024-09-13 03:31:32'),
(9, 'alexa', 'Mother', 'LACIA RESIDENCE', '09677819501', 5, '2024-09-13 03:31:32'),
(10, 'pedro', 'Father', 'sisiman', '09531167141', 6, '2024-09-14 05:18:45'),
(11, 'danna', 'Mother', 'sisiman', '09531167141', 6, '2024-09-14 05:18:45'),
(12, 'affdsa', 'Father', 'koronadal city , south cotabato', '09677819501', 7, '2024-09-17 06:09:14'),
(13, 'fds', 'Mother', 'koronadal city , south cotabato', '09677819501', 7, '2024-09-17 06:09:14'),
(14, 'robert', 'Father', 'PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT', '953116714', 8, '2024-10-15 08:25:36'),
(15, 'danna', 'Mother', 'PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT', '953116714', 8, '2024-10-15 08:25:36');

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
(2, 8, 29, '2024-10-17', '04:29:00', 'fdsafdaf', '', 1, '2024-10-17 16:29:11');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_laboratory`
--

INSERT INTO `tbl_laboratory` (`labid`, `services`, `date_test`, `test_result`, `patient_id`, `created_at`) VALUES
(1, 'Complete Blood Count (CBC)', '2024-09-09', 'fsa', 1, '2024-09-09 02:59:08'),
(2, 'Urinalysis', '2024-09-13', 'hardware.PNG', 3, '2024-09-13 03:16:13'),
(3, 'Sputum Examination', '2024-09-13', '', 3, '2024-09-13 03:16:32');

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
(2, 'Bio-flu', 'Test', 'Cefdinir', 'Antibiotics', '2024-09-13', '2027-04-30', 'cefdinir', 'cefdinir', '2024-09-13 15:31:31'),
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
(1, 2, 'mg', '448'),
(2, 3, 'injectable', '297'),
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
(8, 'Yes', '123333333333', 'Member', '4PS', '2024-10-15 08:25:36', '2024-10-15 08:34:58');

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
(8, 8, 8, '1399083', 'Irene', 'B', 'Basco', '', 'Danna', 'Robert', '0000000008', '1985-02-10', '35 Years', '+639531167141', 'Female', 'Single', 'A-', 'Elementary', '', '', 'Filipino', '2024-10-15 16:25:36', 7, '2024-10-17 07:36:47');

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
(7, 'Rhu', 'R', 'Rhu', '+639623564556', 'RHU_LUTAYAN@gmail.com', '+631232131321'),
(8, 'Elleen', '', 'Tunguia', '+634744477477', 'elleen@gmail.com', 'Koronadal City , South Cotabato'),
(34, 'Ben', 'Test', 'Manatad', '+639665123213', 'test@gmail.com', 'Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato'),
(36, 'Angel', '', 'Lobrido', '+639665123213', 'angel@GMAIL.COM', 'koronadal city , south cotabato'),
(41, 'Joven Rey', '', 'Flores', '+630967781950', 'floresjovenrey26@gmail.com', 'Koronadal City , South Cotabato'),
(42, 'Test', 'V', 'Test', '+630967781950', 'test26@gmail.com', 'Koronadal City , South Cotabato'),
(43, 'Carlo', '', 'Basco', '+639123123123', 'carlo@gmail.com', 'koronadal city , south cotabato');

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
(1, 'dfs', 'fsd', 'fds', 'fdfd', 'fd', 'fds', '[\"Nodules\",\"\"]', '[\"anicteric sclerea\",\"Exudates\",\"\"]', '[\"\"]', '[\"Normal rate regular rhythm\",\"\"]', '[\"Muscle Guarding\",\"\"]', '[\"Full and equal pulses\",\"\"]', '2024-10-17 08:25:16');

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
(34, 34, 'doctor', 'doctor', 'doctor', '09523215'),
(36, 36, 'midwife', 'birhting', 'midwife', ''),
(41, 41, '', '', '', ''),
(42, 42, '', '', '', ''),
(43, 43, 'Physician', 'Physician', 'Physician', '');

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
(1, 8, '2024-10-17', '{\"date\":\"2024-10-17\",\"time\":\"16:31\",\"monitoring\":{\"every5_15\":{\"times\":[\"\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}', '1. CONSCIOUS', '', '', '', '', '1. EXCLUSIVE BREASTFEEDING', '1. FULL BLADDER', '', 'Yes', '1. Proper Nutrition', 1, '2024-10-17 08:28:46');

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
(1, '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '[]', '2024-10-17 08:25:16');

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
  `profile_picture` varchar(40) NOT NULL,
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
(8, 'Elleen', 'BHW', '$2y$10$K3X5eArj9SJzJ7S.hu1l.ePlQSK2uIhJaY2IGT8l1A1LF7Vmex2DK', 'active', 'girl.png', 8, 8, 2, '2024-05-02 13:15:38', 0, NULL),
(29, 'Ben', 'Doctor', '$2y$10$yG0OWd2U/qcjNkFD0MiRA.l2jJTMIosae.F3nD0//SgF6o99qvRCO', 'active', '', 34, 34, 0, '2024-08-04 09:46:14', 0, '2024-08-11 15:48:29'),
(31, 'angel', 'Midwife', '', 'active', 'commentor-item3.jpg', 36, 36, 0, '2024-08-04 09:47:01', 0, '2024-08-11 15:48:29'),
(36, 'joven', 'BHW', '$2y$10$m7q5alOPF40NAzJBbfa8buhGxCrRsF6pMtBjkZLXLoj62ZkoPT5uG', 'active', '1656551981avatar.png', 41, 41, 6, '2024-08-07 17:23:41', 0, NULL),
(37, 'test', 'BHW', '$2y$10$vR3.xMkzF2dXSX3JcWG9Juk49HlM6OCovIkxO3vCtkCNWyW2WXqtm', 'active', 'OIP.jpg', 42, 42, 1, '2024-08-17 18:21:00', 0, NULL),
(38, 'Carlo', 'Physician', NULL, 'inactive', 'Capture3.PNG', 43, 43, NULL, '2024-08-27 16:54:40', 0, NULL);

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
(1, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-12 07:11:50', NULL, 1),
(2, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-12 07:13:19', NULL, 1),
(3, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 00:04:45', NULL, 1),
(4, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 00:08:58', NULL, 1),
(5, 8, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:07:29', '13-09-2024 11:07:35 AM', 1),
(6, NULL, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:07:43', NULL, 0),
(7, 8, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:08:06', '13-09-2024 11:52:30 AM', 1),
(8, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 03:10:31', NULL, 1),
(9, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 03:17:34', '13-09-2024 11:39:52 AM', 1),
(10, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 03:39:57', '13-09-2024 11:40:01 AM', 1),
(11, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 03:40:06', '13-09-2024 11:59:20 AM', 1),
(12, NULL, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:52:35', NULL, 0),
(13, 8, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:52:40', '13-09-2024 11:52:43 AM', 1),
(14, 8, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-13 03:53:14', '13-09-2024 11:58:59 AM', 1),
(15, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 03:59:29', '13-09-2024 12:29:25 PM', 1),
(16, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 04:03:39', NULL, 1),
(17, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 04:29:29', NULL, 1),
(18, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 04:58:34', NULL, 1),
(19, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 07:09:57', NULL, 1),
(20, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 07:31:07', NULL, 1),
(21, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-13 23:26:33', '14-09-2024 09:22:40 AM', 1),
(22, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-13 23:46:10', NULL, 1),
(23, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-14 01:22:49', NULL, 1),
(24, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-14 04:41:40', NULL, 1),
(25, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-14 07:25:52', '14-09-2024 05:26:50 PM', 1),
(26, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-14 07:58:07', '14-09-2024 04:54:17 PM', 1),
(27, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-14 09:24:17', '14-09-2024 05:28:30 PM', 1),
(28, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-15 23:48:26', NULL, 1),
(29, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-17 02:10:55', NULL, 1),
(30, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-17 04:36:01', NULL, 1),
(31, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-17 04:47:48', NULL, 1),
(32, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-17 05:43:01', '17-09-2024 07:27:30 PM', 1),
(33, NULL, 'test', 0x3a3a3100000000000000000000000000, '2024-09-17 06:04:19', NULL, 0),
(34, NULL, 'test', 0x3a3a3100000000000000000000000000, '2024-09-17 06:04:24', NULL, 0),
(35, NULL, 'test', 0x3a3a3100000000000000000000000000, '2024-09-17 06:04:28', NULL, 0),
(36, 8, 'Elleen', 0x3a3a3100000000000000000000000000, '2024-09-17 06:07:17', '17-09-2024 02:11:37 PM', 1),
(37, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-17 11:27:35', NULL, 1),
(38, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-17 11:27:39', '17-09-2024 07:36:18 PM', 1),
(39, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-17 11:36:25', NULL, 1),
(40, NULL, 'test', 0x3a3a3100000000000000000000000000, '2024-09-18 12:36:59', NULL, 0),
(41, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-18 12:37:02', '18-09-2024 02:37:56 PM', 1),
(42, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-18 12:38:01', '18-09-2024 02:54:02 PM', 1),
(43, NULL, 'test', 0x3a3a3100000000000000000000000000, '2024-09-18 12:56:08', NULL, 0),
(44, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-09-18 12:56:11', NULL, 1),
(45, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-20 10:32:24', NULL, 1),
(46, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-21 12:14:58', '21-09-2024 09:07:36 PM', 1),
(47, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-22 01:29:15', NULL, 1),
(48, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-22 03:20:47', NULL, 1),
(49, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-22 09:02:27', '22-09-2024 05:58:21 PM', 1),
(50, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-22 12:25:52', '22-09-2024 10:07:29 PM', 1),
(51, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-23 10:40:37', '23-09-2024 09:01:38 PM', 1),
(52, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-25 12:38:51', '25-09-2024 08:53:09 PM', 1),
(53, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-25 12:55:43', NULL, 0),
(54, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-25 12:55:47', '25-09-2024 08:57:05 PM', 1),
(55, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-25 12:57:10', '25-09-2024 09:15:22 PM', 1),
(56, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:06:31', '26-09-2024 05:33:43 PM', 1),
(57, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-26 09:33:53', '26-09-2024 05:34:52 PM', 1),
(58, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-26 09:35:26', '26-09-2024 05:35:34 PM', 1),
(59, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:35:47', '26-09-2024 05:38:48 PM', 1),
(60, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:38:55', '26-09-2024 05:39:37 PM', 1),
(61, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:39:43', '26-09-2024 05:40:31 PM', 1),
(62, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:40:36', NULL, 0),
(63, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:40:42', '26-09-2024 05:45:02 PM', 1),
(64, NULL, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:49:31', NULL, 0),
(65, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:49:33', '26-09-2024 05:49:48 PM', 1),
(66, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 09:49:50', '26-09-2024 05:50:24 PM', 1),
(67, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-09-26 11:05:59', NULL, 1),
(68, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-09-30 21:46:04', NULL, 1),
(69, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-06 02:19:55', '06-10-2024 11:44:37 AM', 1),
(70, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-08 02:21:38', NULL, 1),
(71, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-08 03:14:03', NULL, 1),
(72, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-08 23:17:17', NULL, 1),
(73, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-09 01:23:03', NULL, 1),
(74, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-09 04:49:11', NULL, 1),
(75, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-09 07:04:00', NULL, 1),
(76, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-09 07:54:02', '09-10-2024 03:55:02 PM', 1),
(77, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-09 08:14:02', NULL, 1),
(78, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-09 22:54:39', NULL, 1),
(79, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-10 06:40:57', '10-10-2024 04:16:05 PM', 1),
(80, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-10 08:16:08', '10-10-2024 04:19:43 PM', 1),
(81, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-11 03:24:06', '11-10-2024 11:27:18 AM', 1),
(82, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-11 07:24:34', '11-10-2024 03:36:04 PM', 1),
(83, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-11 07:36:07', NULL, 1),
(84, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 00:10:31', '12-10-2024 08:59:35 AM', 1),
(85, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 01:01:05', NULL, 1),
(86, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 01:01:30', '12-10-2024 09:10:03 AM', 1),
(87, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 06:52:45', '12-10-2024 03:51:39 PM', 1),
(88, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-12 07:51:46', NULL, 0),
(89, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-12 07:51:50', NULL, 0),
(90, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-12 07:52:10', NULL, 0),
(91, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-10-12 07:52:45', '12-10-2024 03:54:24 PM', 1),
(92, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 07:54:30', '12-10-2024 03:55:40 PM', 1),
(93, 37, 'test', 0x3a3a3100000000000000000000000000, '2024-10-12 07:55:50', '12-10-2024 03:57:28 PM', 1),
(94, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 09:37:43', '12-10-2024 06:21:36 PM', 1),
(95, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-12 10:21:42', NULL, 1),
(96, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-13 23:23:18', NULL, 1),
(97, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-13 23:29:46', NULL, 0),
(98, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-13 23:30:15', NULL, 0),
(99, NULL, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-13 23:30:18', NULL, 0),
(100, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-13 23:30:32', NULL, 1),
(101, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-14 01:28:53', NULL, 1),
(102, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-14 01:29:02', NULL, 1),
(103, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-14 06:36:44', NULL, 1),
(104, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-14 09:04:42', NULL, 1),
(105, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-14 23:23:13', NULL, 1),
(106, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-15 08:13:43', '15-10-2024 07:04:54 PM', 1),
(107, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-15 08:16:04', NULL, 1),
(108, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-15 11:06:13', '15-10-2024 07:07:13 PM', 1),
(109, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-16 01:48:01', NULL, 1),
(110, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-16 03:56:53', '16-10-2024 12:04:43 PM', 1),
(111, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-16 04:04:45', NULL, 1),
(112, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-16 04:19:35', NULL, 1),
(113, 7, 'RHU', 0x3a3a3100000000000000000000000000, '2024-10-17 01:49:00', NULL, 1),
(114, 1, 'admin', 0x3a3a3100000000000000000000000000, '2024-10-17 07:39:07', NULL, 1);

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
(3, '223', '2024-10-17', '02:26:00', '120/20', 'f', 'ew', 'rwe', 'rew', 're', 'wrew', 'rew', 31, 8, 1, '2024-10-17 08:26:42');

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
  ADD KEY `doctor_id` (`userID`);

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
  MODIFY `animal_biteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_animal_bite_vaccination`
--
ALTER TABLE `tbl_animal_bite_vaccination`
  MODIFY `animal_bite_vacID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  MODIFY `announceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birthing_medication`
--
ALTER TABLE `tbl_birthing_medication`
  MODIFY `medicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_birthing_monitoring`
--
ALTER TABLE `tbl_birthing_monitoring`
  MODIFY `birthMonitorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_birthroom`
--
ALTER TABLE `tbl_birthroom`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_birth_info`
--
ALTER TABLE `tbl_birth_info`
  MODIFY `birth_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_birth_ivfluids`
--
ALTER TABLE `tbl_birth_ivfluids`
  MODIFY `fluidsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_certificate_log`
--
ALTER TABLE `tbl_certificate_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `complaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_discharged`
--
ALTER TABLE `tbl_discharged`
  MODIFY `dischargedid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_doctor_schedule`
--
ALTER TABLE `tbl_doctor_schedule`
  MODIFY `doc_scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_familyaddress`
--
ALTER TABLE `tbl_familyaddress`
  MODIFY `famID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_family_members`
--
ALTER TABLE `tbl_family_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_healthnotes`
--
ALTER TABLE `tbl_healthnotes`
  MODIFY `notedsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_immunization_records`
--
ALTER TABLE `tbl_immunization_records`
  MODIFY `immunID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_laboratory`
--
ALTER TABLE `tbl_laboratory`
  MODIFY `labid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `membershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `personnel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_physicalexam`
--
ALTER TABLE `tbl_physicalexam`
  MODIFY `physical_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `system_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_user_log`
--
ALTER TABLE `tbl_user_log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `tbl_user_page`
--
ALTER TABLE `tbl_user_page`
  MODIFY `userpageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_vitalsigns_monitoring`
--
ALTER TABLE `tbl_vitalsigns_monitoring`
  MODIFY `vitalSignsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
