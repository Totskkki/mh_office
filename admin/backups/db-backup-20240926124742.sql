DROP TABLE IF EXISTS audit_trail;

CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `affected_table` varchar(255) DEFAULT NULL,
  `affected_record_id` int(11) DEFAULT NULL,
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(50) DEFAULT NULL,
  `affected_record_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO audit_trail VALUES("7","7","Insert","Added patient: Shunsine cruz","tbl_patients","12","2024-09-23 17:03:25","::1","");



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
  `Remarks` varchar(255) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`animal_biteID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_care VALUES("1","6","20240924001","2024-09-24","[\"Anti-Rabies\",\"Allergy\",\"Hypertension\",\"\"]","-","February","2020","Dog","2024-09-24","palabilla","[\"Bite\",\"Induced\"]","2024-09-24","Vaccinated","Alive","Remarks","yes","yes","yes","yes","yes","yes","2024-09-24","HTIG","II","","7");
INSERT INTO tbl_animal_bite_care VALUES("2","3","20240924002","2024-09-24","[\"Anti-Rabies\",\"Allergy\",\"Drug\",\"Hypertension\",\"\"]","-","January","2021","Cat","2024-09-24","palabilla","[\"Non-bite\",\"Induced\"]","2024-04-29","Vaccinated","Died","Remarks","yes","yes","yes","yes","yes","yes","2024-09-24","HTIG","I","","7");
INSERT INTO tbl_animal_bite_care VALUES("3","7","20240924003","2024-09-24","[\"Diabetes Mellitus\",\"\"]","-","","","Cat","2024-09-24","palabilla","[\"Non-bite\",\"Induced\"]","2024-09-24","Vaccinated","Alive","Remarks","yes","yes","yes","yes","yes","yes","","HTIG","I","","7");



DROP TABLE IF EXISTS tbl_animal_bite_vaccination;

CREATE TABLE `tbl_animal_bite_vaccination` (
  `animal_bite_vacID` int(11) NOT NULL AUTO_INCREMENT,
  `vaccination_name` varchar(100) NOT NULL,
  `vaccination_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `dose_number` varchar(100) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `stat` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1 =completed',
  `dose_status` varchar(20) NOT NULL,
  PRIMARY KEY (`animal_bite_vacID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_vaccination VALUES("1","3","2024-09-24","2024-09-28","1","","6","1","1");
INSERT INTO tbl_animal_bite_vaccination VALUES("2","3","2024-09-28","2024-10-01","1","","6","1","2");
INSERT INTO tbl_animal_bite_vaccination VALUES("3","3","2024-10-01","2024-10-01","1","dog died","6","1","3");
INSERT INTO tbl_animal_bite_vaccination VALUES("4","3","2024-09-24","2024-09-29","1","","3","1","1");
INSERT INTO tbl_animal_bite_vaccination VALUES("5","3","2024-09-24","2024-09-28","1","","7","1","1");
INSERT INTO tbl_animal_bite_vaccination VALUES("6","3","2024-09-29","2024-10-02","1","","3","1","2");
INSERT INTO tbl_animal_bite_vaccination VALUES("7","3","2024-09-28","2024-10-01","1","","7","0","2");
INSERT INTO tbl_animal_bite_vaccination VALUES("8","3","2024-10-02","2024-10-05","1","dog alive","3","1","3");
INSERT INTO tbl_animal_bite_vaccination VALUES("9","3","2024-10-05","2024-10-08","1","","3","0","4");



DROP TABLE IF EXISTS tbl_announcements;

CREATE TABLE `tbl_announcements` (
  `announceID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`announceID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




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
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_audit_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_log VALUES("1","1","INSERT","tbl_announcements","1","","{\"date\":\"2024-09-25\",\"title\":\"covid vaccination\",\"details\":\"covid vaccination\"}","2024-09-11 10:46:30");
INSERT INTO tbl_audit_log VALUES("2","1","UPDATE","tbl_announcements","1","{\"date\":\"2024-09-25\",\"title\":\"covid vaccination\",\"details\":\"covid vaccination\"}","{\"date\":\"2024-10-02\",\"title\":\"covid\",\"details\":\"covid \"}","2024-09-13 11:17:51");
INSERT INTO tbl_audit_log VALUES("3","1","DELETE","tbl_announcements","1","{\"announceID\":1,\"date\":\"2024-10-02\",\"title\":\"covid\",\"details\":\"covid \",\"created_at\":\"2024-09-11 10:46:30\",\"updated_at\":\"2024-09-13 11:17:51\"}","","2024-09-13 12:58:57");
INSERT INTO tbl_audit_log VALUES("4","1","added","tbl_medicine_details","1","","{\"medicine_id\":\"2\",\"packing\":\"mg\",\"qt\":\"500\"}","2024-09-13 15:31:42");
INSERT INTO tbl_audit_log VALUES("5","1","INSERT","tbl_announcements","2","","{\"date\":\"2024-09-20\",\"title\":\"covid\",\"details\":\"test\"}","2024-09-14 07:46:19");
INSERT INTO tbl_audit_log VALUES("6","1","INSERT","tbl_announcements","3","","{\"date\":\"2024-09-20\",\"title\":\"test\",\"details\":\"test\"}","2024-09-14 07:47:28");
INSERT INTO tbl_audit_log VALUES("7","1","INSERT","tbl_announcements","4","","{\"date\":\"2024-09-26\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}","2024-09-14 08:10:45");
INSERT INTO tbl_audit_log VALUES("8","1","added","tbl_medicine_details","2","","{\"medicine_id\":\"3\",\"packing\":\"injectable\",\"qt\":\"500\"}","2024-09-23 07:35:12");
INSERT INTO tbl_audit_log VALUES("9","1","added","tbl_medicine_details","3","","{\"medicine_id\":\"1\",\"packing\":\"injectable\",\"qt\":\"500\"}","2024-09-23 07:35:31");
INSERT INTO tbl_audit_log VALUES("10","1","DELETE","tbl_announcements","4","{\"announceID\":4,\"date\":\"2024-09-26\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\",\"created_at\":\"2024-09-14 08:10:45\",\"updated_at\":\"2024-09-14 08:10:45\"}","","2024-09-24 17:01:05");
INSERT INTO tbl_audit_log VALUES("11","1","DELETE","tbl_announcements","2","{\"announceID\":2,\"date\":\"2024-09-20\",\"title\":\"covid\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:46:19\",\"updated_at\":\"2024-09-14 07:46:19\"}","","2024-09-24 17:01:25");
INSERT INTO tbl_audit_log VALUES("12","1","DELETE","tbl_announcements","3","{\"announceID\":3,\"date\":\"2024-09-20\",\"title\":\"test\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:47:28\",\"updated_at\":\"2024-09-14 07:47:28\"}","","2024-09-24 17:01:34");



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
  PRIMARY KEY (`medicationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_birthing_monitoring;

CREATE TABLE `tbl_birthing_monitoring` (
  `birthMonitorID` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_certificate_log VALUES("1","6","0000-00-00 00:00:00","pending","");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_checkup VALUES("1","2024-09-14 11:52:00","","","[\"\"]","","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","no","","able to work","1","1","2024-09-14 11:52:45");



DROP TABLE IF EXISTS tbl_clinicalrecords;

CREATE TABLE `tbl_clinicalrecords` (
  `recordID` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`recordID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_clinicalrecords VALUES("3","5","","","2024-09-13","11:41:00","2024-09-20","13:22:00","new","Angel  Lobrido","fdsa","fdsa","fdsa","discharged","2024-09-20 13:22:05");



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
  `status` varchar(20) NOT NULL,
  `pr` varchar(50) NOT NULL,
  `O2SAT` varchar(50) NOT NULL,
  `transferred` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`complaintID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("2","7","fdsa","fsda","122 / 80_","11","111kg","1","1°C","11cm","Follow-up visit","Animal bite and Care","FDSAFSDA","FDSAAAAAAAAAA","Done","1","","referred","2024-09-23 10:05:58");
INSERT INTO tbl_complaints VALUES("3","6","fda","sadf","122 / 80_","11","111kg","1","1°C","11cm","Follow-up visit","Animal bite and Care","FDSAFSDA","FDSAAAAAAAAAA","Done","1","","referred","2024-09-23 10:46:23");
INSERT INTO tbl_complaints VALUES("4","3","fdsa","fdsa","122 / 80_","11","111kg","1","1°C","11cm","Follow-up visit","Animal bite and Care","FDSAFSDA","FDSAAAAAAAAAA","for vaccination","1","","","2024-09-23 13:43:12");
INSERT INTO tbl_complaints VALUES("5","11","","","122 / 80_","11","111kg","1","1°C","11cm","Follow-up visit","Animal bite and Care","RHU LUTAYAN","totski","Pending","1","","","2024-09-24 10:23:31");
INSERT INTO tbl_complaints VALUES("8","5","","","122 / 80_","11","111kg","1","1°C","11cm","Follow-up visit","Birthing","RHU LUTAYAN","totski","Done","1","","referred","2024-09-25 09:57:45");
INSERT INTO tbl_complaints VALUES("10","12","","","110 / 80_","123","22kg","2","22°C","2cm","Follow-up visit","Animal bite and Care","fdsa","","Pending","22","","","2024-09-25 16:36:11");
INSERT INTO tbl_complaints VALUES("11","5","","","110 / 120","22","22kg","2","2°C","2cm","Follow-up visit","Prenatal","2","2","Done","2","","","2024-09-26 11:12:27");
INSERT INTO tbl_complaints VALUES("12","6","","","110 / 120","2","02kg","2","2°C","2cm","Follow-up visit","Prenatal","2","2","Done","2","","referred","2024-09-26 11:12:41");
INSERT INTO tbl_complaints VALUES("13","12","","","110 / 120","1","1kg","1","01°C","1cm","Follow-up visit","Vaccination and Immunization","11","11","Done","1","","","2024-09-26 11:34:35");



DROP TABLE IF EXISTS tbl_discharged;

CREATE TABLE `tbl_discharged` (
  `dischargedid` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) NOT NULL,
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
  `userID` int(11) NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`doc_scheduleID`),
  KEY `doctor_id` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("1","29","Tuesday,Wednesday,Friday","07:00:00","17:26:00","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","pablito","Father","koronadal city , south cotabato","09677819501","1","2024-09-09 10:02:11");
INSERT INTO tbl_family_members VALUES("2","alexa","Mother","koronadal city , south cotabato","09677819501","1","2024-09-09 10:02:11");
INSERT INTO tbl_family_members VALUES("6","pablito","Father","LAMBA,BANGA, SOUTH COTABATO","09103253465","3","2024-09-13 08:08:05");
INSERT INTO tbl_family_members VALUES("7","eleonora","Mother","LAMBA,BANGA, SOUTH COTABATO","09103253465","3","2024-09-13 08:08:05");
INSERT INTO tbl_family_members VALUES("8","pablito","Father","LACIA RESIDENCE","09677819501","5","2024-09-13 11:31:32");
INSERT INTO tbl_family_members VALUES("9","alexa","Mother","LACIA RESIDENCE","09677819501","5","2024-09-13 11:31:32");
INSERT INTO tbl_family_members VALUES("10","pedro","Father","sisiman","09531167141","6","2024-09-14 13:18:45");
INSERT INTO tbl_family_members VALUES("11","danna","Mother","sisiman","09531167141","6","2024-09-14 13:18:45");
INSERT INTO tbl_family_members VALUES("12","affdsa","Father","koronadal city , south cotabato","09677819501","7","2024-09-17 14:09:14");
INSERT INTO tbl_family_members VALUES("13","fds","Mother","koronadal city , south cotabato","09677819501","7","2024-09-17 14:09:14");
INSERT INTO tbl_family_members VALUES("18","robert","Father","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","953116714","10","2024-09-23 16:57:33");
INSERT INTO tbl_family_members VALUES("19","danna","Mother","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","953116714","10","2024-09-23 16:57:33");
INSERT INTO tbl_family_members VALUES("20","robert","Father","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","09999999999","11","2024-09-23 17:01:37");
INSERT INTO tbl_family_members VALUES("21","Registration","Mother","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","09999999999","11","2024-09-23 17:01:37");
INSERT INTO tbl_family_members VALUES("22","robert","Father","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","09999999999","12","2024-09-23 17:03:25");
INSERT INTO tbl_family_members VALUES("23","Registration","Mother","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CIT","09999999999","12","2024-09-23 17:03:25");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyaddress VALUES("1","Sampao","Magsaysay","Lutayan","Sultan Kudarat","sultan kudarat","2024-09-09 10:02:11","");
INSERT INTO tbl_familyaddress VALUES("3","Santo Niño (bo. 2)","Riverside","City Of Koronadal (Capital)","South Cotabato","LAMBA, BANGA","2024-09-13 08:08:05","");
INSERT INTO tbl_familyaddress VALUES("4","Blingkong","Fsddaf","","South Cotabato","fdsafd","2024-09-13 11:19:29","");
INSERT INTO tbl_familyaddress VALUES("5","Punol","Lacia Residence","Lutayan","Sultan Kudarat","LAMBA","2024-09-13 11:31:32","");
INSERT INTO tbl_familyaddress VALUES("6","Sampao","","Lutayan","Sultan Kudarat","hfggh","2024-09-14 13:18:45","");
INSERT INTO tbl_familyaddress VALUES("7","Mamali","Pag Asa","Lutayan","Sultan Kudarat","pag asa","2024-09-17 14:09:14","");
INSERT INTO tbl_familyaddress VALUES("10","Blingkong","Pag-asa","Lutayan","Sultan Kudarat","sultan kudarat","2024-09-23 16:57:33","");
INSERT INTO tbl_familyaddress VALUES("11","Palavilla","121","Lutayan","Sultan Kudarat","LAMBA, BANGA","2024-09-23 17:01:37","");
INSERT INTO tbl_familyaddress VALUES("12","Santa Fe","Fdsa","Caraga","Davao Oriental","fdsadf","2024-09-23 17:03:25","");



DROP TABLE IF EXISTS tbl_healthnotes;

CREATE TABLE `tbl_healthnotes` (
  `notedsID` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `doctorNotes` varchar(255) NOT NULL,
  `nureNotes` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notedsID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_healthnotes VALUES("1","6","29","2024-09-19","10:05:00","1","","2024-09-20 10:05:21");
INSERT INTO tbl_healthnotes VALUES("2","6","29","2024-09-12","06:10:00","fdsaff","","2024-09-20 10:10:38");
INSERT INTO tbl_healthnotes VALUES("3","6","29","2024-09-18","11:10:00","fdsaaaaaaaaaaa","","2024-09-20 10:10:38");
INSERT INTO tbl_healthnotes VALUES("4","6","0","2024-09-19","10:14:00","","fdsafd","2024-09-20 10:14:37");
INSERT INTO tbl_healthnotes VALUES("5","6","0","2024-09-05","10:16:00","","fdsafffffffff","2024-09-20 10:14:37");
INSERT INTO tbl_healthnotes VALUES("6","6","29","2024-09-12","10:30:00","fdsafsadfas","","2024-09-20 10:29:30");
INSERT INTO tbl_healthnotes VALUES("7","6","29","2024-09-19","11:29:00","fdsafasdfsa","","2024-09-20 10:29:30");
INSERT INTO tbl_healthnotes VALUES("8","6","29","2024-09-13","10:30:00","12","","2024-09-20 10:30:15");
INSERT INTO tbl_healthnotes VALUES("9","6","29","2024-08-29","10:30:00","123","","2024-09-20 10:30:15");
INSERT INTO tbl_healthnotes VALUES("10","6","0","2024-09-19","23:39:00","","test","2024-09-20 11:39:39");
INSERT INTO tbl_healthnotes VALUES("11","5","29","2024-09-20","16:22:00","FDSAAAAAAAAAAAA","","2024-09-20 16:22:14");



DROP TABLE IF EXISTS tbl_immunization_records;

CREATE TABLE `tbl_immunization_records` (
  `immunID` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `immunization_date` date DEFAULT NULL,
  `immunization_next_date` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`immunID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_immunization_records VALUES("1","1","Polio","2024-09-12","2024-10-16","test","7","2024-09-12 15:16:07");
INSERT INTO tbl_immunization_records VALUES("2","12","Polio","2024-09-26","2024-09-26","fsdafd","7","2024-09-26 11:37:55");



DROP TABLE IF EXISTS tbl_laboratory;

CREATE TABLE `tbl_laboratory` (
  `labid` int(11) NOT NULL AUTO_INCREMENT,
  `services` varchar(100) NOT NULL,
  `date_test` date DEFAULT NULL,
  `test_result` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`labid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_laboratory VALUES("1","Sputum Examination","2024-09-02","fdsafd","7","images.png","2024-09-19 08:16:29");
INSERT INTO tbl_laboratory VALUES("2","Platelet Count","2024-09-19","fdsaf","7","458260691_1011920697401080_5388181098710080441_n.jpg","2024-09-19 08:18:16");
INSERT INTO tbl_laboratory VALUES("3","Complete Blood Count (CBC)","2024-09-19","dsaaaaaaaaaaaa","3","370142508_355868630189692_8139824659532553362_n.jpg","2024-09-19 09:37:05");
INSERT INTO tbl_laboratory VALUES("4","Blood Typing","2024-09-12","fdsaf","3","451500468_781580517387534_204021789157193093_n (1).jpg","2024-09-19 09:38:51");
INSERT INTO tbl_laboratory VALUES("6","Complete Blood Count (CBC)","2024-09-10","abnormal","12","referrals.PNG","2024-09-24 14:43:13");



DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","2","mg","384");
INSERT INTO tbl_medicine_details VALUES("2","3","injectable","453");
INSERT INTO tbl_medicine_details VALUES("3","1","injectable","500");



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
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`medicineID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicines VALUES("1","Polio","Poliomyelitis, Commonly Shortened To Polio, Is An Infectious Disease Caused By The Poliovirus. Approximately 75% Of Cases Are Asymptomatic","Test","Vaccines","2024-09-12","2027-03-05","test","branded","2024-09-12 15:14:39");
INSERT INTO tbl_medicines VALUES("2","Bio-flu","Test","Cefdinir","Antibiotics","2024-09-13","2027-04-30","cefdinir","cefdinir","2024-09-13 15:31:31");
INSERT INTO tbl_medicines VALUES("3","Anti-rabies","Anti-rabies","Anti-rabies","Vaccines","2024-09-23","2029-05-16","Anti-rabies","Anti-rabies","2024-09-23 07:35:01");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","Yes","062469896512","Member","NHTS","2024-09-11 00:00:00","");
INSERT INTO tbl_membership_info VALUES("3","Yes","123123123123","Member","4PS","2024-09-13 08:08:05","");
INSERT INTO tbl_membership_info VALUES("4","No","","","[\"NHTS\"]","2024-09-13 11:19:29","");
INSERT INTO tbl_membership_info VALUES("5","Yes","123112312312","Dependent","4PS","2024-09-13 11:31:32","");
INSERT INTO tbl_membership_info VALUES("6","Yes","123123121222","Dependent","4PS","2024-09-14 13:18:45","");
INSERT INTO tbl_membership_info VALUES("7","No","","","NHTS","2024-09-17 14:09:14","");
INSERT INTO tbl_membership_info VALUES("10","Yes","123333333333","Dependent","4PS","2024-09-23 16:57:33","");
INSERT INTO tbl_membership_info VALUES("11","No","","","4PS","2024-09-23 17:01:37","");
INSERT INTO tbl_membership_info VALUES("12","Yes","222222222222","None Member","Private","2024-09-23 17:03:25","");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patient_medication_history VALUES("1","1","2","Oral(p/o)","30","schedule dose","Before Meal","500 mg","Twice a day","1 (Month)","drink plenty of water");
INSERT INTO tbl_patient_medication_history VALUES("2","2","2","Oral(p/o)","10","as needed","","100 mg","Twice a day","2 (Day)","ipahilot");
INSERT INTO tbl_patient_medication_history VALUES("3","3","2","Oral(p/o)","10","schedule dose","After Meal","500 mg","Three time a day","3 (Day)","eat fruits");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patient_visits VALUES("1","2024-09-24","2024-09-28","fever","drink plenty of water","7","31");
INSERT INTO tbl_patient_visits VALUES("2","2024-09-25","2024-10-01","nabikogan sa tiil","ipahilot","7","31");
INSERT INTO tbl_patient_visits VALUES("3","2024-09-24","2024-09-30","cough ","eat fruits","6","29");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","1399077","Ronaldo","","Teere","","Alexa","Pablito","0000000001","2024-09-17","0 Months","+63096778195","Male","Married","A+","No Formal Education","Patient","Islam","Filipino","2024-09-09 10:02:11","7","2024-09-17 14:40:24");
INSERT INTO tbl_patients VALUES("3","3","3","1399078","Joven Rey","","Flores","","eleonora","pablito","0000000002","1993-01-26","31 years","+630967781950","Male","Married","A+","College Level","radio operator","Baptists","Filipino","2024-09-13 08:08:05","7","");
INSERT INTO tbl_patients VALUES("4","4","4","1399079","Fsdaf","b","fdsadf","","fdsa","fdsafd","0000000004","2024-09-04","0 months","9999999999","Other","Married","A-","No Formal Education","fdsaf","Islam","Filipino","2024-09-13 11:19:29","8","");
INSERT INTO tbl_patients VALUES("5","5","5","1399080","Lorena","ALCANTARA","LACIA","","alexa","pablito","0000000005","1999-04-20","25 years","+639677819501","Female","Single","A-","Elementary","none","Roman Catholic","Filipino","2024-09-13 11:31:32","7","");
INSERT INTO tbl_patients VALUES("6","6","6","1399081","Josh","b","garcia","","danna","pedro","0000000006","1993-02-04","31 years","+639999999999","Female","Single","B+","College Level","test","","Filipino","2024-09-14 13:18:45","37","");
INSERT INTO tbl_patients VALUES("7","7","7","1399082","Irlan","","badio","","fds","affdsa","0000000007","1999-02-10","25 years","+630967781950","Male","Single","A-","","","","Filipino","2024-09-17 14:09:14","8","");
INSERT INTO tbl_patients VALUES("10","10","10","1399083","Rolando","b","neere","","danna","robert","0000000008","1998-12-28","25 years","+63953116714_","Male","Single","A+","No Formal Education","test","Islam","Filipino","2024-09-23 16:57:33","7","");
INSERT INTO tbl_patients VALUES("11","11","11","1399084","Telan","b","englisera","","Registration","robert","0000000011","2024-07-03","2 months","+63953116714_","Female","Single","A-","","test","Baptists","Filipino","2024-09-23 17:01:37","7","");
INSERT INTO tbl_patients VALUES("12","12","12","1399085","Shunsine","b","cruz","","Registration","robert","0000000012","2024-09-11","0 months","+639531167142","Female","Single","B-","","test","","Filipino","2024-09-23 17:03:25","7","");



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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","admin","M.","admin","Koronadal City","admin@gmail.com","+639645563132");
INSERT INTO tbl_personnel VALUES("7","Rhu","R","Rhu","+639623564556","RHU@gmail.com","+631232131321");
INSERT INTO tbl_personnel VALUES("8","Elleen","","Tunguia","+634744477477","elleen@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("34","Ben","Test","Manatad","+639665123213","test@gmail.com","Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato");
INSERT INTO tbl_personnel VALUES("36","Angel","","Lobrido","+639665123213","angel@GMAIL.COM","koronadal city , south cotabato");
INSERT INTO tbl_personnel VALUES("41","Joven Rey","","Flores","+630967781950","floresjovenrey26@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("42","Test","V","Test","+630967781950","test26@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("43","Carlo","","Basco","+639123123123","carlo@gmail.com","koronadal city , south cotabato");
INSERT INTO tbl_personnel VALUES("52","Sally",".","Tt","1232131321","ttttt@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("53","Sally",".","Lobrido","+63016454646_","Lobrido@gmail.com","+639232131312");



DROP TABLE IF EXISTS tbl_physicalexam;

CREATE TABLE `tbl_physicalexam` (
  `physical_exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `fht` varchar(50) DEFAULT NULL,
  `fundic_ht` varchar(50) DEFAULT NULL,
  `dilation` varchar(50) DEFAULT NULL,
  `effacement` varchar(50) DEFAULT NULL,
  `bow` varchar(50) DEFAULT NULL,
  `skin` text DEFAULT NULL,
  `heent` text DEFAULT NULL,
  `chest_lungs` text DEFAULT NULL,
  `cardiovascular` text DEFAULT NULL,
  `abdomen` text DEFAULT NULL,
  `extremities` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`physical_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_physicalexam VALUES("1","12","12","12","1212","12","[\"Pallor\",\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","2024-09-13 11:38:19");
INSERT INTO tbl_physicalexam VALUES("2","fdsa","fdsafdsa","fdsa","fdsa","fdsa","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","2024-09-17 13:59:53");
INSERT INTO tbl_physicalexam VALUES("3","gfd","gfds","gdfs","gfds","gdsf","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","2024-09-25 09:58:16");



DROP TABLE IF EXISTS tbl_position;

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `personnel_id` int(11) NOT NULL,
  `PositionName` varchar(100) NOT NULL,
  `Specialty` varchar(100) NOT NULL,
  `ProfessionalType` varchar(100) NOT NULL,
  `LicenseNo` varchar(255) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","","","","");
INSERT INTO tbl_position VALUES("7","7","","","","");
INSERT INTO tbl_position VALUES("8","8","","","","");
INSERT INTO tbl_position VALUES("34","34","doctor","doctor","doctor","09523215");
INSERT INTO tbl_position VALUES("36","36","midwife","birhting","midwife","");
INSERT INTO tbl_position VALUES("41","41","","","","");
INSERT INTO tbl_position VALUES("42","42","","","","");
INSERT INTO tbl_position VALUES("43","43","Physician","Physician","Physician","");
INSERT INTO tbl_position VALUES("44","44","","","","");
INSERT INTO tbl_position VALUES("45","45","","","","");
INSERT INTO tbl_position VALUES("46","46","","","","");
INSERT INTO tbl_position VALUES("47","47","","","","");
INSERT INTO tbl_position VALUES("48","48","","","","");
INSERT INTO tbl_position VALUES("49","49","","","","");
INSERT INTO tbl_position VALUES("50","50","","","","");
INSERT INTO tbl_position VALUES("51","51","","","","");
INSERT INTO tbl_position VALUES("52","52","","","","");
INSERT INTO tbl_position VALUES("53","53","","","","");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_prenatal VALUES("1","2024-09-26","   ","38","123","1","1","1","","","1","11","1","1","1","1","1","1","1","1","1","1","1","1","Single","Cephalic","Normal","Fundus","Low Lying","0","limb","Fdsa","Fdsa","5","7");



DROP TABLE IF EXISTS tbl_referrals_log;

CREATE TABLE `tbl_referrals_log` (
  `referral_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `referral_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`referral_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_referrals_log VALUES("10","6","2024-09-14","37","");
INSERT INTO tbl_referrals_log VALUES("11","3","2024-09-14","7","");
INSERT INTO tbl_referrals_log VALUES("12","6","2024-09-23","37","");
INSERT INTO tbl_referrals_log VALUES("13","7","2024-09-24","7","");
INSERT INTO tbl_referrals_log VALUES("14","5","2024-09-24","7","");
INSERT INTO tbl_referrals_log VALUES("15","5","2024-09-25","7","");



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
  `vascular` text DEFAULT NULL,
  `musculoskeletal` text DEFAULT NULL,
  `neurologic1` text DEFAULT NULL,
  `hematologic` text DEFAULT NULL,
  `endocrine` text DEFAULT NULL,
  `neurologic2` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`system_review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_systemreview VALUES("1","[]","[]","[]","[]","[]","[\"Nosebleed\"]","[\"Sore Tongue\"]","[\"Swollen Glands\"]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-09-13 11:38:19");
INSERT INTO tbl_systemreview VALUES("2","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-09-17 13:59:53");
INSERT INTO tbl_systemreview VALUES("3","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-09-25 09:58:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("1","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-25 18:50:25","25-09-2024 06:50:33 PM","1");
INSERT INTO tbl_user_log VALUES("2","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-25 18:50:34","","0");
INSERT INTO tbl_user_log VALUES("3","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-25 18:52:27","25-09-2024 06:52:35 PM","1");
INSERT INTO tbl_user_log VALUES("4","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-25 18:54:51","25-09-2024 06:55:22 PM","1");
INSERT INTO tbl_user_log VALUES("5","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 07:16:29","","1");
INSERT INTO tbl_user_log VALUES("6","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 08:06:01","26-09-2024 08:06:21 AM","1");
INSERT INTO tbl_user_log VALUES("7","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 08:06:26","26-09-2024 09:24:59 AM","1");
INSERT INTO tbl_user_log VALUES("8","","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 09:25:04","","0");
INSERT INTO tbl_user_log VALUES("9","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 09:25:06","26-09-2024 10:30:55 AM","1");
INSERT INTO tbl_user_log VALUES("10","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 10:30:58","","1");
INSERT INTO tbl_user_log VALUES("11","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 11:00:22","","1");
INSERT INTO tbl_user_log VALUES("12","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 12:47:24","26-09-2024 12:47:27 PM","1");
INSERT INTO tbl_user_log VALUES("13","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-09-26 12:47:36","","1");



DROP TABLE IF EXISTS tbl_user_page;

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL AUTO_INCREMENT,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`userpageID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_page VALUES("1","CALENDAR.PNG","BRGY. AVACEÑA","37");
INSERT INTO tbl_user_page VALUES("2","CALENDAR.PNG","BRGY. LAMPARE","8");



DROP TABLE IF EXISTS tbl_users;

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
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
  `last_attempt_time` datetime DEFAULT NULL,
  PRIMARY KEY (`userID`),
  KEY `personnel_id` (`personnel_id`),
  KEY `position_id` (`position_id`),
  CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `tbl_personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_users_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `tbl_position` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_users VALUES("1","admin","admin","$2y$10$UU5F8l0cJB5e1F8jof5RQuGzVE5gObQ8z3ZSojriezvZ9JOKBvZKK","active","user.jpg","1","1","0","2024-04-24 16:39:15","0","");
INSERT INTO tbl_users VALUES("7","RHU","RHU","$2y$10$C7Ii6iYoA4hfiICc/ML3.eb.1FoKh3dM2HxJ2HFuESp7F3v7vtjBu","active","photo1718592536 (3).jpeg","7","7","0","2024-05-02 10:55:03","0","");
INSERT INTO tbl_users VALUES("8","Elleen","BHW","$2y$10$K3X5eArj9SJzJ7S.hu1l.ePlQSK2uIhJaY2IGT8l1A1LF7Vmex2DK","Inactive","girl.png","8","8","2","2024-05-02 13:15:38","0","");
INSERT INTO tbl_users VALUES("29","Ben","Doctor","$2y$10$yG0OWd2U/qcjNkFD0MiRA.l2jJTMIosae.F3nD0//SgF6o99qvRCO","active","","34","34","0","2024-08-04 09:46:14","0","2024-08-11 15:48:29");
INSERT INTO tbl_users VALUES("31","angel","Midwife","","active","commentor-item3.jpg","36","36","0","2024-08-04 09:47:01","0","2024-08-11 15:48:29");
INSERT INTO tbl_users VALUES("36","joven","BHW","$2y$10$m7q5alOPF40NAzJBbfa8buhGxCrRsF6pMtBjkZLXLoj62ZkoPT5uG","active","1656551981avatar.png","41","41","6","2024-08-07 17:23:41","0","");
INSERT INTO tbl_users VALUES("37","test","BHW","$2y$10$vR3.xMkzF2dXSX3JcWG9Juk49HlM6OCovIkxO3vCtkCNWyW2WXqtm","active","OIP.jpg","42","42","1","2024-08-17 18:21:00","0","");
INSERT INTO tbl_users VALUES("38","Carlo","Physician","","inactive","Capture3.PNG","43","43","","2024-08-27 16:54:40","0","");
INSERT INTO tbl_users VALUES("47","Sally","BHW","$2y$10$id0tZUyjGZPdIsO8nm.5iuqarPU6.J41EboANtLzNsF88wPpcoGnq","active","f-4.jpg","52","52","","2024-09-26 10:37:42","0","");
INSERT INTO tbl_users VALUES("48","Lobrido","RHU","$2y$10$GlYYOoDinMHppWp2q92vl.rpDFLhauQYq.hEETiKHIAKLtDE/PZve","active","f-4.jpg","53","53","","2024-09-26 10:43:44","0","");



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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`vitalSignsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




