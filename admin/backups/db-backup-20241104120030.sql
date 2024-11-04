DROP TABLE IF EXISTS cache;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS cache_locks;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS migrations;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS password_reset_tokens;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS sessions;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS tbl_animal_bite_care;

CREATE TABLE `tbl_animal_bite_care` (
  `animal_biteID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`animal_biteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_animal_bite_vaccination;

CREATE TABLE `tbl_animal_bite_vaccination` (
  `animal_bite_vacID` int(11) NOT NULL AUTO_INCREMENT,
  `vaccination_name` varchar(100) NOT NULL,
  `vaccination_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `dose_number` varchar(100) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `stat` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=completed',
  `dose_status` tinyint(4) NOT NULL,
  `bite_status` int(11) NOT NULL,
  PRIMARY KEY (`animal_bite_vacID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_announcements;

CREATE TABLE `tbl_announcements` (
  `announceID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`announceID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_announcements VALUES("2","2024-11-12","Covid vaccination day","Covid vaccination dayCovid vaccination dayCovid vaccination dayCovid vaccination day","2024-11-04 10:59:19","2024-11-04 10:59:19");



DROP TABLE IF EXISTS tbl_appointments;

CREATE TABLE `tbl_appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_audit_log;

CREATE TABLE `tbl_audit_log` (
  `auditID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`auditID`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_log VALUES("1","1","added","tbl_medicine_details","1","","{\"medicine_id\":\"1\",\"packing\":\"tablet\",\"qt\":\"50\"}","2024-11-03 15:37:48");
INSERT INTO tbl_audit_log VALUES("2","1","UPDATE","tbl_medicine_details","1","{\"medicine_id\":1,\"packing\":\"tablet\",\"qt\":\"50\"}","{\"medicine_id\":\"1\",\"packing\":\"mg\",\"qt\":\"50\"}","2024-11-03 15:37:58");
INSERT INTO tbl_audit_log VALUES("3","1","DELETE","tbl_medicine_details","1","{\"med_detailsID\":1,\"medicine_id\":1,\"packing\":\"mg\",\"qt\":\"50\"}","","2024-11-03 16:13:02");



DROP TABLE IF EXISTS tbl_audit_trail;

CREATE TABLE `tbl_audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `affected_table` varchar(255) DEFAULT NULL,
  `affected_record_id` int(11) DEFAULT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_trail VALUES("1","1","Add Events","Added Events  Health Campaign Health CampaignHealth Campaign","tbl_announcements","1","2024-11-03 13:42:37","::1");
INSERT INTO tbl_audit_trail VALUES("2","1","Update Events","Updated Events Health Campaign Health CampaignHealth Campaign","tbl_announcements","1","2024-11-03 13:58:42","::1");
INSERT INTO tbl_audit_trail VALUES("3","1","Delete Events","Deleted Events for Health Campaign Health CampaignHealth Campaign","tbl_announcements","1","2024-11-03 14:01:43","::1");
INSERT INTO tbl_audit_trail VALUES("4","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","2","2024-11-04 10:37:37","127.0.0.1");
INSERT INTO tbl_audit_trail VALUES("5","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","3","2024-11-04 10:41:22","::1");
INSERT INTO tbl_audit_trail VALUES("6","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","1","2024-11-04 10:41:36","::1");
INSERT INTO tbl_audit_trail VALUES("7","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","4","2024-11-04 10:43:31","::1");
INSERT INTO tbl_audit_trail VALUES("8","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","5","2024-11-04 10:54:24","::1");
INSERT INTO tbl_audit_trail VALUES("9","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","6","2024-11-04 10:54:49","::1");
INSERT INTO tbl_audit_trail VALUES("10","1","Add Events","Added Events  Covid vaccination day Covid vaccination dayCovid vaccination dayCovid vaccination dayCovid vaccination day","tbl_announcements","2","2024-11-04 10:59:19","::1");
INSERT INTO tbl_audit_trail VALUES("11","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","7","2024-11-04 11:08:03","::1");
INSERT INTO tbl_audit_trail VALUES("12","1","Add Schedule","Added a schedule for Doctor  Gerald  Anderson","tbl_doctor_schedule","8","2024-11-04 11:08:11","::1");
INSERT INTO tbl_audit_trail VALUES("13","1","Update Schedule","Updated the schedule for Doctor Unknown","tbl_doctor_schedule","","2024-11-04 11:09:28","::1");
INSERT INTO tbl_audit_trail VALUES("14","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","8","2024-11-04 11:11:37","::1");
INSERT INTO tbl_audit_trail VALUES("15","1","Add Schedule","Added a schedule for Doctor  Gerald  Anderson","tbl_doctor_schedule","9","2024-11-04 11:12:00","::1");
INSERT INTO tbl_audit_trail VALUES("16","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","9","2024-11-04 11:13:10","::1");
INSERT INTO tbl_audit_trail VALUES("17","1","Add Schedule","Added a schedule for Doctor  Gerald  Anderson","tbl_doctor_schedule","10","2024-11-04 11:15:01","::1");
INSERT INTO tbl_audit_trail VALUES("18","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","10","2024-11-04 11:20:17","::1");
INSERT INTO tbl_audit_trail VALUES("19","1","Delete Schedule","Deleted the schedule for Doctor Gerald  Anderson","tbl_doctor_schedule","11","2024-11-04 11:22:54","::1");
INSERT INTO tbl_audit_trail VALUES("20","1","Add Schedule","Added a schedule for Doctor  Gerald  Anderson","tbl_doctor_schedule","13","2024-11-04 11:25:36","::1");



DROP TABLE IF EXISTS tbl_birth_info;

CREATE TABLE `tbl_birth_info` (
  `birth_info_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`birth_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_birth_ivfluids;

CREATE TABLE `tbl_birth_ivfluids` (
  `fluidsID` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeStarted` time NOT NULL,
  `timeconsumed` time NOT NULL,
  `bottleno` varchar(100) NOT NULL,
  `solution` varchar(100) NOT NULL,
  `signature_remarks` varchar(100) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`fluidsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_birthing_medication;

CREATE TABLE `tbl_birthing_medication` (
  `medicationID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`medicationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_birthing_monitoring;

CREATE TABLE `tbl_birthing_monitoring` (
  `birthMonitorID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`birthMonitorID`),
  KEY `patientID` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_birthroom;

CREATE TABLE `tbl_birthroom` (
  `roomID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_certificate_log;

CREATE TABLE `tbl_certificate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `generated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_checkup;

CREATE TABLE `tbl_checkup` (
  `checkupID` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`checkupID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_clinicalrecords;

CREATE TABLE `tbl_clinicalrecords` (
  `recordID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`recordID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_complaints;

CREATE TABLE `tbl_complaints` (
  `complaintID` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`complaintID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_discharged;

CREATE TABLE `tbl_discharged` (
  `dischargedid` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `date_discharged` date DEFAULT NULL,
  `home_medications` text DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `nurse_midwife` varchar(100) DEFAULT NULL,
  `physician` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`dischargedid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_doctor_schedule;

CREATE TABLE `tbl_doctor_schedule` (
  `doc_scheduleID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` varchar(50) NOT NULL,
  `date_schedule` date DEFAULT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1 COMMENT '0=not availble,1=available',
  `work_length` varchar(50) DEFAULT NULL,
  `reapet` varchar(20) NOT NULL,
  `schedules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`schedules`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`doc_scheduleID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("12","5","","","","","1","","Weekly","{\"SUNDAY\":[{\"fromtime\":\"13:24\",\"totime\":\"14:24\",\"worklength\":\"1h 0m\"}],\"WEDNESDAY\":[{\"fromtime\":\"11:23\",\"totime\":\"12:23\",\"worklength\":\"1h 0m\"}],\"MONDAY\":[{\"fromtime\":\"11:24\",\"totime\":\"12:24\",\"worklength\":\"1h 0m\"}]}","2024-11-04 11:23:08");
INSERT INTO tbl_doctor_schedule VALUES("13","5","","","","","1","","Weekly","{\"SUNDAY\":[{\"fromtime\":\"06:00\",\"totime\":\"10:00\",\"worklength\":\"4h 0m\"}]}","2024-11-04 11:25:36");



DROP TABLE IF EXISTS tbl_family_members;

CREATE TABLE `tbl_family_members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`member_id`),
  KEY `address_id` (`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_familyaddress;

CREATE TABLE `tbl_familyaddress` (
  `famID` int(11) NOT NULL AUTO_INCREMENT,
  `brgy` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`famID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_healthnotes;

CREATE TABLE `tbl_healthnotes` (
  `notedsID` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `doctorNotes` varchar(255) NOT NULL,
  `nureNotes` varchar(255) NOT NULL,
  `birth_info_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notedsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_immunization_records;

CREATE TABLE `tbl_immunization_records` (
  `immunID` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `immunization_date` date DEFAULT NULL,
  `immunization_next_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`immunID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_laboratory;

CREATE TABLE `tbl_laboratory` (
  `labid` int(11) NOT NULL AUTO_INCREMENT,
  `services` varchar(100) NOT NULL,
  `date_test` date DEFAULT NULL,
  `test_result` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`labid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




DROP TABLE IF EXISTS tbl_medicines;

CREATE TABLE `tbl_medicines` (
  `medicineID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`medicineID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicines VALUES("1","Bio-flu","Bio-flu","Bio-flu","Anticoagulants","2023-11-03","2029-01-16","Bio-flu","Bio-flu","0","2024-11-03 15:31:54");



DROP TABLE IF EXISTS tbl_membership_info;

CREATE TABLE `tbl_membership_info` (
  `membershipID` int(11) NOT NULL AUTO_INCREMENT,
  `phil_mem` varchar(50) NOT NULL,
  `philhealth_no` varchar(255) DEFAULT NULL,
  `phil_membership` varchar(100) NOT NULL,
  `ps_mem` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`membershipID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_patient_medication_history;

CREATE TABLE `tbl_patient_medication_history` (
  `patient_med_historyID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`patient_med_historyID`),
  KEY `patient_visit_id` (`patient_visit_id`),
  KEY `medicine_details_id` (`medicine_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




DROP TABLE IF EXISTS tbl_patient_visits;

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL AUTO_INCREMENT,
  `visit_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  PRIMARY KEY (`patient_visitID`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




DROP TABLE IF EXISTS tbl_patients;

CREATE TABLE `tbl_patients` (
  `patientID` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`patientID`),
  KEY `Membership_Info` (`Membership_Info`),
  KEY `family_no` (`family_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




DROP TABLE IF EXISTS tbl_personnel;

CREATE TABLE `tbl_personnel` (
  `personnel_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","admin","","admin","09562331","admin@gmail.com","");
INSERT INTO tbl_personnel VALUES("4","Test","","Test","+639665123213","test26@gmail.com","Purok Riverside,brgy.santo Nino(bo.2)koronadal City South Cotabato");
INSERT INTO tbl_personnel VALUES("5","Gerald","","Anderson","+639665123213","Gerald@gmail.com","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CITY SOUTH COTABATO");
INSERT INTO tbl_personnel VALUES("6","Adni","","Igenman","+632131321321","floresjovenrey26@gmail.com","koronadal city , south cotabato");



DROP TABLE IF EXISTS tbl_physicalexam;

CREATE TABLE `tbl_physicalexam` (
  `physical_exam_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`physical_exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_position;

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `personnel_id` int(11) NOT NULL,
  `PositionName` varchar(100) NOT NULL,
  `Specialty` varchar(100) NOT NULL,
  `ProfessionalType` varchar(100) NOT NULL,
  `LicenseNo` varchar(255) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","admin","","","");
INSERT INTO tbl_position VALUES("4","4","","","","");
INSERT INTO tbl_position VALUES("5","5","Doctor","Family doctor","M.D","195632323232");
INSERT INTO tbl_position VALUES("6","6","Nurse","Family doctor","adni","");



DROP TABLE IF EXISTS tbl_postpartum;

CREATE TABLE `tbl_postpartum` (
  `postpartumID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`postpartumID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_prenatal;

CREATE TABLE `tbl_prenatal` (
  `prenatalID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`prenatalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_referrals_log;

CREATE TABLE `tbl_referrals_log` (
  `referral_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `referral_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`referral_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_systemreview;

CREATE TABLE `tbl_systemreview` (
  `system_review_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`system_review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_user_log;

CREATE TABLE `tbl_user_log` (
  `logID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `user_ip` binary(16) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`logID`),
  KEY `tbl_user_log_ibfk_1` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("30","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 09:25:51","","1");
INSERT INTO tbl_user_log VALUES("31","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 09:44:51","","1");
INSERT INTO tbl_user_log VALUES("32","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 09:57:20","","1");
INSERT INTO tbl_user_log VALUES("33","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 09:57:41","","1");
INSERT INTO tbl_user_log VALUES("34","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 09:58:08","","1");
INSERT INTO tbl_user_log VALUES("35","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 10:16:06","","1");
INSERT INTO tbl_user_log VALUES("36","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 10:19:18","","1");
INSERT INTO tbl_user_log VALUES("37","5","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-04 10:33:45","","1");



DROP TABLE IF EXISTS tbl_user_page;

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL AUTO_INCREMENT,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`userpageID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_page VALUES("1","451500468_781580517387534_204021789157193093_n (1).jpg","BRGY. AVACEÑA","2");



DROP TABLE IF EXISTS tbl_users;

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`userID`),
  KEY `personnel_id` (`personnel_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_users VALUES("1","admin","admin","$2a$12$gqy2DIumZzQHQgHTcDSK4.bY/0zoIaJR4rF0O4VNqAoc19GFAUVZ.","Active","how-to-play-youtube-videos-in-the-background-know-all-details-here.jpg","1","1","","2024-11-03 13:39:09","0","");
INSERT INTO tbl_users VALUES("4","Test","BHW","$2y$10$Panx0p49OgwVsup.15s7LOudI/vHVKCCLvOSZlMeD0CK8LaySYMeK","Active","photo1718592536 (3).jpeg","4","4","","2024-11-03 14:31:47","0","");
INSERT INTO tbl_users VALUES("5","1","Doctor","$2y$10$AnBtHPFvIrdJCX5254c1vul4GRVUg5qeVZ.jvQhoMyoMJ1knfMeeG","Active","photo1718592536 (3).jpeg","5","5","","2024-11-03 14:57:20","0","");
INSERT INTO tbl_users VALUES("6","Adni","Nurse","","Active","photo1718592515 (6).jpeg","6","6","","2024-11-04 11:41:28","0","");



DROP TABLE IF EXISTS tbl_vitalsigns_monitoring;

CREATE TABLE `tbl_vitalsigns_monitoring` (
  `vitalSignsID` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`vitalSignsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




