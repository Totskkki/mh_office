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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`announceID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_announcements VALUES("1","2024-12-15","Final defense","Final defense","2024-12-08 01:46:29","2024-12-08 01:46:29","0");
INSERT INTO tbl_announcements VALUES("2","2024-12-25","Christmas day","Christmas day","2024-12-08 01:49:12","2024-12-08 01:49:12","0");
INSERT INTO tbl_announcements VALUES("3","2024-12-31","New years Eve","Panahon ng pagbabago 🤣","2024-12-08 01:50:29","2024-12-08 01:50:29","0");
INSERT INTO tbl_announcements VALUES("4","2025-01-26","My birthday","Mag ihaw ko ka baka\n\n\n\nBaka- wala 🛴🏍🛵🚚🚛🚑🚌🏎🚖🚝🚄🚃","2024-12-08 01:51:02","2024-12-08 01:52:35","0");
INSERT INTO tbl_announcements VALUES("6","2024-12-08","Bloodletting","blood","2024-12-08 03:19:00","2024-12-08 03:19:00","0");
INSERT INTO tbl_announcements VALUES("7","2025-01-23","Phil Medical Exhibition","Phil Medical Exhibition 2024 – A Leading Healthcare Exhibition in the Philippines","2024-12-09 07:41:03","2024-12-09 07:41:44","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_trail VALUES("1","14","Insert","Added patient: Maris RACAL","tbl_patients","1","2024-12-08 00:04:28","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("2","1","Add Schedule","Added a schedule for Doctor  Hazel Joy Alvarez","tbl_doctor_schedule","2","2024-12-08 01:43:49","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("3","1","Add Events","Added Events  Final defense Final defense","tbl_announcements","1","2024-12-08 01:46:29","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("4","1","Add Events","Added Events  Christmas day Christmas day","tbl_announcements","2","2024-12-08 01:49:12","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("5","1","Add Events","Added Events  New years Eve Panahon ng pagbabago 🤣","tbl_announcements","3","2024-12-08 01:50:29","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("6","1","Add Events","Added Events  My birthday My birthday","tbl_announcements","4","2024-12-08 01:51:02","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("7","1","Update Events","Updated Events My birthday Mag ihaw ko ka baka\n\n\n\nBaka- wala 🛴","tbl_announcements","4","2024-12-08 01:52:10","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("8","1","Update Events","Updated Events My birthday Mag ihaw ko ka baka\n\n\n\nBaka- wala 🛴🏍🛵🚚🚛🚑🚌🏎🚖🚝🚄🚃","tbl_announcements","4","2024-12-08 01:52:35","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("9","1","Add Events","Added Events  (Akap) 3000 per person Pero tulion sa liwat 🤣🤣🤣🤣🤣🤣","tbl_announcements","5","2024-12-08 02:04:17","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("10","13","Insert","Added patient: Loreto laraza","tbl_patients","2","2024-12-08 02:27:20","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("11","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-08 03:10:47","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("12","1","Add Schedule","Added a schedule for Doctor  Kirigaya L Kazuto","tbl_doctor_schedule","5","2024-12-08 03:12:36","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("13","1","Add Events","Added Events  Bloodletting blood","tbl_announcements","6","2024-12-08 03:19:00","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("14","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-08 03:30:13","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("15","1","Add Health Professional","Added Health Professional,  Sai sam dsa","tbl_users","28","2024-12-08 03:33:28","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("16","1","Updated Health Professional","Updated Health Professional, Sai Sam Dsa","tbl_users","28","2024-12-08 03:34:11","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("17","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-08 08:29:26","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("18","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-08 08:30:42","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("19","1","Updated Health Professional","Updated Health Professional, Werty Werty Werty","tbl_users","21","2024-12-08 08:30:56","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("20","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-08 08:31:22","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("21","1","Delete Events","Deleted Events for (Akap) 3000 per person Pero tulion sa liwat 🤣🤣🤣🤣🤣🤣","tbl_announcements","5","2024-12-08 08:31:44","175.176.93.140","0");
INSERT INTO tbl_audit_trail VALUES("22","1","Updated Health Professional","Updated Health Professional, Sai Sam Dsa","tbl_users","28","2024-12-08 23:27:50","2001:4456:1ea:aa00:dc82:754:31c:6ba3","0");
INSERT INTO tbl_audit_trail VALUES("23","1","Updated Health Professional","Updated Health Professional, Werty Werty Werty","tbl_users","21","2024-12-08 23:44:26","2001:4456:1ea:aa00:dc82:754:31c:6ba3","0");
INSERT INTO tbl_audit_trail VALUES("24","1","Update","Updated Patient Information,  Maris Racal","tbl_patients","1","2024-12-09 07:09:28","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("25","1","Update","Updated Patient Information,  Maris Racal","tbl_patients","1","2024-12-09 07:09:28","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("26","1","Added Medicine,","Added Medicine  Solmux Tablet","tbl_medicines","11","2024-12-09 07:12:53","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("27","1","Updated Medicine,","Updated Medicine,  Cetirizine","tbl_medicines","10","2024-12-09 07:14:08","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("28","1","Add Health Professional","Added Health Professional,  Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:22:19","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("29","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:23:28","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("30","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:23:57","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("31","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:24:13","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("32","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:24:26","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("33","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:31:28","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("34","1","Updated Health Professional","Updated Health Professional, Sebastian  Fanthomhive","tbl_users","29","2024-12-09 07:32:34","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("35","1","Add Schedule","Added a schedule for Doctor  Sebastian  Fanthomhive","tbl_doctor_schedule","8","2024-12-09 07:36:42","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("36","1","Delete Schedule","Deleted the schedule for Doctor Sebastian  Fanthomhive","tbl_doctor_schedule","9","2024-12-09 07:37:30","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("37","1","Add Events","Added Events  Phil Medical Exhibition Phil Medical Exhibition 2024 – A Leading Healthcare Exhibition in the Philippines","tbl_announcements","7","2024-12-09 07:41:03","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("38","1","Update Events","Updated Events Phil Medical Exhibition Phil Medical Exhibition 2024 – A Leading Healthcare Exhibition in the Philippines","tbl_announcements","7","2024-12-09 07:41:44","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("39","1","Updated Users","Updated User,  Hazel S Dsa","tbl_users","27","2024-12-09 07:57:21","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("40","1","Updated Users","Updated User,  Hazel S Dsa","tbl_users","27","2024-12-09 07:58:03","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("41","1","Updated Users","Updated User,  Hazel S Dsa","tbl_users","27","2024-12-09 07:58:14","119.92.143.161","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_certificate_log;

CREATE TABLE `tbl_certificate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `generated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`log_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_certificate_log VALUES("1","2","2024-12-08 23:42:06","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/2_2024-12-09.pdf","0");



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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`checkupID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_checkup VALUES("1","2024-12-08 08:05:00","FDSA","FDSA","[\"Altered mental sensorium\",\"\"]","Awake and alert","[\"\"]","[\"Essentially normal\",\"\"]","[\"Essentially normal\",\"\"]","[\"Essentially normal\",\"\"]","[\"Essentially normal\",\"\"]","[\"Essentially normal\",\"\"]","[\"on\",\"\"]","no","","CHEATER SYA","1","0","2024-12-08","0");
INSERT INTO tbl_checkup VALUES("2","2024-12-08 10:33:00","none","none","[\"Headache\",\"\"]","","[\"\"]","[\"Essentially normal\",\"\"]","[\"Irregular rhythm\",\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","no","","further assestment","2","0","2024-12-08","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `action_taken` text NOT NULL,
  `instruction_to` text NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`complaintID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("1","1","FS","DS","12/2","22","2kg","2","2°C","2","New consultation/case","Checkup","Maria Reyes","FDFASSSSSSSSSS","Done","2","","","","","2024-12-08","0");
INSERT INTO tbl_complaints VALUES("2","2","chest pain","suffering from todays chest pain","120/80","16","30kg","90","35°C","156.99cm","New consultation/case","Checkup","Juan Santos","chest pain","Done","22","15","referred","checkup","checkup","2024-12-08","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`dischargedid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_doctor_schedule;

CREATE TABLE `tbl_doctor_schedule` (
  `doc_scheduleID` int(11) NOT NULL AUTO_INCREMENT,
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
  `notified` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`doc_scheduleID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("1","15","0000-00-00","hßjejjeejekekekk","","","","3","","","2024-12-08","2024-12-13","2024-12-08 01:41:48","2024-12-08 01:42:34","0","1","1");
INSERT INTO tbl_doctor_schedule VALUES("2","15","0000-00-00","","","","","1","Weekly","{\"MONDAY\":[{\"fromtime\":\"07:00\",\"totime\":\"11:00\",\"worklength\":\"4h 0m\"}]}","0000-00-00","0000-00-00","2024-12-08 01:43:49","0000-00-00 00:00:00","0","0","0");
INSERT INTO tbl_doctor_schedule VALUES("3","15","2024-12-30","wala ko ron","","07:00 AM","11:00 AM","4","","","0000-00-00","0000-00-00","2024-12-08 01:44:22","2024-12-08 01:44:50","0","1","0");
INSERT INTO tbl_doctor_schedule VALUES("4","15","2024-12-16","hiki","","07:00 AM","11:00 AM","3","","","0000-00-00","0000-00-00","2024-12-08 02:09:52","2024-12-08 02:10:14","0","1","0");
INSERT INTO tbl_doctor_schedule VALUES("5","23","0000-00-00","","","","","1","Weekly","{\"MONDAY\":[{\"fromtime\":\"09:12\",\"totime\":\"11:12\",\"worklength\":\"2h 0m\"}]}","0000-00-00","0000-00-00","2024-12-08 03:12:36","0000-00-00 00:00:00","0","0","0");
INSERT INTO tbl_doctor_schedule VALUES("6","15","2025-02-03","haksksksj","","07:00 AM","11:00 AM","2","","","","","2024-12-08 11:38:22","","0","0","1");
INSERT INTO tbl_doctor_schedule VALUES("7","15","2025-01-06","ddjdjs","","07:00 AM","11:00 AM","3","","","","","2024-12-09 05:32:51","2024-12-09 05:33:20","0","0","1");
INSERT INTO tbl_doctor_schedule VALUES("8","29","","","","","","1","Weekly","{\"MONDAY\":[{\"fromtime\":\"10:00\",\"totime\":\"16:00\",\"worklength\":\"6h 0m\"}],\"TUESDAY\":[{\"fromtime\":\"10:00\",\"totime\":\"16:00\",\"worklength\":\"6h 0m\"}],\"WEDNESDAY\":[{\"fromtime\":\"10:00\",\"totime\":\"16:00\",\"worklength\":\"6h 0m\"}]}","","","2024-12-09 07:36:42","","0","0","0");



DROP TABLE IF EXISTS tbl_familyAddress;

CREATE TABLE `tbl_familyAddress` (
  `famID` int(11) NOT NULL AUTO_INCREMENT,
  `brgy` varchar(100) NOT NULL,
  `purok` varchar(100) NOT NULL,
  `city_municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`famID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyAddress VALUES("1","Antong","Cheater","","Sultan Kudarat","CHEATER","2024-12-08 00:04:28","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("2","Mangudadatu","Masagana","","Sultan Kudarat","Sultan Kudarat","2024-12-08 02:27:20","0000-00-00 00:00:00","0");



DROP TABLE IF EXISTS tbl_family_members;

CREATE TABLE `tbl_family_members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`member_id`),
  KEY `address_id` (`address`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","MARISA","Guardian","09562332","MANILA, KORONADAL","1","2024-12-08 00:04:28","0");
INSERT INTO tbl_family_members VALUES("2","John","Father","09876683833","Sultan Kudarat","2","2024-12-08 02:27:20","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`famID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyaddress VALUES("1","Antong","Malipayon","","Sultan Kudarat","Sulatan Kudarat","2024-12-07 17:50:38","2024-12-07 17:52:18","0");
INSERT INTO tbl_familyaddress VALUES("2","Sisiman","Purok Kaugnayan","","Sultan Kudarat","Davao","2024-12-07 21:04:12","0000-00-00 00:00:00","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`labid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_login_attempts;

CREATE TABLE `tbl_login_attempts` (
  `attempt_id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `last_attempt_time` timestamp NULL DEFAULT NULL,
  `locked_until` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attempt_id`),
  KEY `userID` (`userID`),
  CONSTRAINT `tbl_login_attempts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `tbl_users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","1","10","942","0");
INSERT INTO tbl_medicine_details VALUES("2","2","Pack of 10 Tablets","1993","0");
INSERT INTO tbl_medicine_details VALUES("3","6","Blister Pack of 10 Capsules","3000","0");
INSERT INTO tbl_medicine_details VALUES("4","5","1mL Single-Dose Vial, Box of 5 Vials","4999","0");
INSERT INTO tbl_medicine_details VALUES("5","4","1mL Ampoule, Box of 10 Ampoules","1018","0");
INSERT INTO tbl_medicine_details VALUES("6","3","Blister Pack of 30 Tablets","5002","0");
INSERT INTO tbl_medicine_details VALUES("7","8","90","124","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`medicineID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicines VALUES("1","Amoxicillin 250mg Capsules","A Broad-spectrum Antibiotic Used To Treat Bacterial Infections Such As Respiratory, Urinary, And Ear Infections.","Healthline Distributors","Antibiotics","2023-06-10","2025-06-10","Curemax Pharmaceuticals","Amoxicare","1","2024-12-05 05:30:57","0");
INSERT INTO tbl_medicines VALUES("2","Cetirizine  10mg Tablets","An Antihistamine Used To Relieve Allergy Symptoms Such As Sneezing, Runny Nose, And Itching.","Allergen-free Pharma","Antihistamines","2024-12-05","2024-12-05","MediPro Labs","AllerEase","1","2024-12-05 05:33:57","0");
INSERT INTO tbl_medicines VALUES("3","Folic Acid 5mg Tablets","A Vitamin Supplement Used During Pregnancy To Prevent Neural Tube Defects And Support Fetal Development.","Nutricare Pharma Supplies","Immunosuppressants","2024-12-05","2024-12-05","VitaWell Laboratories","PrenoCare","1","2024-12-05 05:36:52","0");
INSERT INTO tbl_medicines VALUES("4","Oxytocin 10 Iu/ml Injection","A Hormone Injection Used To Induce Labor, Control Postpartum Bleeding, And Manage Uterine Contractions During Childbirth.","Mothercare Medical Supplies","Vaccines","2024-12-05","2024-12-05","BioHormone Pharma","OxyFlow","1","2024-12-05 05:38:11","0");
INSERT INTO tbl_medicines VALUES("5","Rabies Vaccine (purified Vero Cell Vaccine) 1ml","A Vaccine Used For Pre- And Post-exposure Prophylaxis Of Rabies To Prevent Infection After Exposure To Rabies Virus.","Lifeshield Medical Distributors","Vaccines","2024-12-05","2024-12-05","SafeVax Biopharma","RabiShield","1","2024-12-05 05:39:32","0");
INSERT INTO tbl_medicines VALUES("6","Loperamide 2mg Capsules","An Anti-diarrheal Medication Used To Treat Sudden Diarrhea And To Reduce The Frequency Of Bowel Movements.","Healthmed Distributors","Antipsychotics","2024-12-05","2024-12-07","Medplus Pharmaceuticals","Diastop","1","2024-12-05 05:41:53","0");
INSERT INTO tbl_medicines VALUES("7","Wer","Wer23","Werwer","Analgesics","2024-12-06","2024-12-06","Werwerwer","Werfer","1","2024-12-06 02:48:55","0");
INSERT INTO tbl_medicines VALUES("8","Omeprazole","Acid","Red Cross","Antidiabetic Drugs","2024-12-05","2024-12-06","123fdsfsdf","Omeprazole","1","2024-12-06 02:55:43","0");
INSERT INTO tbl_medicines VALUES("9","Sample Med","Assddsadnasd","Sample","Antibiotics","2025-01-30","2024-10-07","Sample Company","sample","1","2024-12-06 18:03:42","0");
INSERT INTO tbl_medicines VALUES("10","Cetirizine","Fndsbsdbvlkdsb","Mercury","Analgesics","2024-11-04","2024-12-07","Sample","Sample","1","2024-12-07 05:50:23","0");
INSERT INTO tbl_medicines VALUES("11","Solmux Tablet","Solmux Is Used To Treat Cough With Phlegm.","U","Antibiotics","2024-08-22","2025-02-21","Unilab","Unilab","1","2024-12-09 07:12:53","0");



DROP TABLE IF EXISTS tbl_membership_info;

CREATE TABLE `tbl_membership_info` (
  `membershipID` int(11) NOT NULL AUTO_INCREMENT,
  `phil_mem` varchar(50) NOT NULL,
  `philhealth_no` varchar(255) DEFAULT NULL,
  `phil_membership` varchar(100) NOT NULL,
  `ps_mem` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`membershipID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","No","","","4PS","2024-12-08 00:04:28","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("2","Yes","199999999999","Member","Private","2024-12-08 02:27:20","0000-00-00 00:00:00","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patient_med_historyID`),
  KEY `patient_visit_id` (`patient_visit_id`),
  KEY `medicine_details_id` (`medicine_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_medication_history VALUES("1","2","2","Oral(p/o)","2","as needed","","5 mg","","2 (Day)","FDSAAAAAAAAAAAAAA","0");
INSERT INTO tbl_patient_medication_history VALUES("2","3","2","Drops","3","as needed","","20mg","","3 (Day)","take your meds on time","0");
INSERT INTO tbl_patient_medication_history VALUES("3","3","8","Oral(p/o)","2","schedule dose","Before Meal","30mg","Every 3 hours","2 (Day)","take your meds","0");
INSERT INTO tbl_patient_medication_history VALUES("4","4","1","Oral(p/o)","2","as needed","","5 mg","","3 (Day)","dfsasasasasasasasasa","0");



DROP TABLE IF EXISTS tbl_patient_visits;

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL AUTO_INCREMENT,
  `visit_date` date DEFAULT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `visit_counts` bigint(20) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patient_visitID`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_visits VALUES("2","2024-12-08","2024-12-10","CHEATER LAGE","FDASSSSSSSSSSSSSS","1","15","0","0");
INSERT INTO tbl_patient_visits VALUES("3","2024-12-08","2024-12-13","typhoid fever","rest 3 days","2","15","0","0");
INSERT INTO tbl_patient_visits VALUES("4","2024-12-09","2024-12-18","fever","fdasssssss","1","21","0","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patientID`),
  KEY `Membership_Info` (`Membership_Info`),
  KEY `family_no` (`family_address`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","7893880","Maris","","Racal","","MARISA","","0000000001","2000-02-03","24 Years","+632222222222","Female","Single","A-","Postdoctoral Fellow","CHEATER","Hinduism","Filipino","2024-12-08","14","2024-12-09 07:09:28","0");
INSERT INTO tbl_patients VALUES("2","2","2","7893881","Loreto","","laraza","","","","0000000002","2024-12-03","Newborn","+639999999999","Male","Single","A+","","","Islam","Filipino","2024-12-08","13","0000-00-00 00:00:00","0");



DROP TABLE IF EXISTS tbl_personnel;

CREATE TABLE `tbl_personnel` (
  `personnel_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","Carlos","","Mendoza","09653231212","carlos.mendoza@example.com","","0");
INSERT INTO tbl_personnel VALUES("13","Juan","Dela Cruz","Santos","+639171534567","juansantos@example.com","123 Mabini Street, Barangay Maligaya, Quezon City, Metro Manila","0");
INSERT INTO tbl_personnel VALUES("14","Maria","Garcia","Reyes","+639281234567","mariar.reyes@example.com","456 Rizal Avenue, Barangay Bagong Lipunan, Cebu City, Cebu","0");
INSERT INTO tbl_personnel VALUES("15","Hazel","Joy","Alvarez","+639451234567","drcruz123@example.com","321 osmeña street, barangay san isidro, pasic city, metro manila","0");
INSERT INTO tbl_personnel VALUES("17","Karina","Ramos","Torres","+639562322656","katrinatorres_rn@example.com","654 quirino avenue,barangay santa rosa, iloilo city, iloilo","0");
INSERT INTO tbl_personnel VALUES("19","Elizabeth","","Harmon","+631232131321","Elizabeth@yahoo","Davao City","0");
INSERT INTO tbl_personnel VALUES("20","Krai","L","Grievers","+639999999999","krai@gmail.com","Adsad","0");
INSERT INTO tbl_personnel VALUES("21","Kraiiii","L","Domingo Jr","+631234567834","joellezleejr@gmail.com","Agreda Subd. Koronadal City, South Cotabato","0");
INSERT INTO tbl_personnel VALUES("22","Werty","Werty","Werty","+639354081494","wertywertywerty@gmail.com","wertywertywertywertywerty","0");
INSERT INTO tbl_personnel VALUES("24","Kirigaya","L","Kazuto","+632345678909","kirigaya999@gmail.com","Agreda Subd. Koronadal City, South Cotabato","0");
INSERT INTO tbl_personnel VALUES("26","Hazel Joy","Marfil","Avarez","+639752481906","halvarez@gvcfi.edu.ph","Molo St, Brgy. Zone 3, Koronadal City, South Cotabato 9506","0");
INSERT INTO tbl_personnel VALUES("28","Hazel","S","Dsa","+635656448561","SAi@gmail.com","dadasd","0");
INSERT INTO tbl_personnel VALUES("29","Sai","Sam","Dsa","+631234567891","SAi@gmail.com","dadasd","0");
INSERT INTO tbl_personnel VALUES("30","Sebastian","","Fanthomhive","+631265465464","sebby@gmail.com","Japan","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","admin","","","","0");
INSERT INTO tbl_position VALUES("13","13","","","","","0");
INSERT INTO tbl_position VALUES("14","14","","","","","0");
INSERT INTO tbl_position VALUES("15","15","Doctor","Family doctor","M.D4","095623245587","0");
INSERT INTO tbl_position VALUES("16","17","Nurse","Family doctor","M.D","095623245587","0");
INSERT INTO tbl_position VALUES("18","19","Physician","Neurology","Neurology","","0");
INSERT INTO tbl_position VALUES("19","20","","","","","0");
INSERT INTO tbl_position VALUES("20","21","","","","","0");
INSERT INTO tbl_position VALUES("21","22","Doctor","werty","werty","12351","0");
INSERT INTO tbl_position VALUES("23","24","Doctor","eat","sadsad","123456789","0");
INSERT INTO tbl_position VALUES("25","26","Nurse","sample","sample","","0");
INSERT INTO tbl_position VALUES("27","28","","","","","0");
INSERT INTO tbl_position VALUES("28","29","Doctor","eat","sadsad","-2","0");
INSERT INTO tbl_position VALUES("29","30","Doctor","Cardiology","GP","4","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`prenatalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS tbl_referrals_log;

CREATE TABLE `tbl_referrals_log` (
  `referral_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `referral_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`referral_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_referrals_log VALUES("1","2","2024-12-08","13","","0");
INSERT INTO tbl_referrals_log VALUES("2","2","2024-12-08","14","","0");



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
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`logID`),
  KEY `tbl_user_log_ibfk_1` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("1","15","drcruz21","119.92.143.161\0\0","2024-12-08 01:40:42","2024-12-08 09:55:22","1","0");
INSERT INTO tbl_user_log VALUES("2","1","carlosmendoza88","119.92.143.161\0\0","2024-12-08 01:42:14","","1","0");
INSERT INTO tbl_user_log VALUES("3","15","drcruz21","119.92.143.161\0\0","2024-12-08 01:55:25","2024-12-08 09:56:28","1","0");
INSERT INTO tbl_user_log VALUES("4","15","drcruz21","119.92.143.161\0\0","2024-12-08 01:58:43","2024-12-08 10:08:27","1","0");
INSERT INTO tbl_user_log VALUES("5","15","drcruz21","119.92.143.161\0\0","2024-12-08 02:08:31","2024-12-08 11:30:27","1","0");
INSERT INTO tbl_user_log VALUES("6","13","juansantos123","119.92.143.161\0\0","2024-12-08 02:16:39","08-12-2024 10:18:14 AM","1","0");
INSERT INTO tbl_user_log VALUES("7","13","juansantos123","119.92.143.161\0\0","2024-12-08 02:24:10","08-12-2024 10:58:01 AM","1","0");
INSERT INTO tbl_user_log VALUES("8","14","mariar2024","119.92.143.161\0\0","2024-12-08 02:32:56","08-12-2024 11:17:10 AM","1","0");
INSERT INTO tbl_user_log VALUES("9","1","carlosmendoza88","119.92.143.161\0\0","2024-12-08 02:58:48","","1","0");
INSERT INTO tbl_user_log VALUES("10","1","carlosmendoza88","119.92.143.161\0\0","2024-12-08 03:18:35","","1","0");
INSERT INTO tbl_user_log VALUES("11","0","Kirigaya","119.92.143.161\0\0","2024-12-08 03:30:32","","0","0");
INSERT INTO tbl_user_log VALUES("12","0","Kirigaya","119.92.143.161\0\0","2024-12-08 03:30:44","","0","0");
INSERT INTO tbl_user_log VALUES("13","0","Kirigaya","119.92.143.161\0\0","2024-12-08 03:30:46","","0","0");
INSERT INTO tbl_user_log VALUES("14","15","drcruz21","119.92.143.161\0\0","2024-12-08 03:31:04","2024-12-08 11:31:33","1","0");
INSERT INTO tbl_user_log VALUES("15","0","Sai123","119.92.143.161\0\0","2024-12-08 03:33:49","","0","0");
INSERT INTO tbl_user_log VALUES("16","15","drcruz21","119.92.143.161\0\0","2024-12-08 03:34:23","2024-12-08 11:34:31","1","0");
INSERT INTO tbl_user_log VALUES("17","0","Sai123","119.92.143.161\0\0","2024-12-08 03:34:27","","0","0");
INSERT INTO tbl_user_log VALUES("18","28","Sai123","119.92.143.161\0\0","2024-12-08 03:34:40","","1","0");
INSERT INTO tbl_user_log VALUES("19","1","carlosmendoza88","175.176.93.140\0\0","2024-12-08 04:47:05","08-12-2024 12:47:21 PM","1","0");
INSERT INTO tbl_user_log VALUES("20","1","carlosmendoza88","175.176.93.140\0\0","2024-12-08 04:47:41","08-12-2024 05:41:46 PM","1","0");
INSERT INTO tbl_user_log VALUES("21","15","drcruz21","175.176.93.140\0\0","2024-12-08 05:31:47","2024-12-08 19:37:35","1","0");
INSERT INTO tbl_user_log VALUES("22","15","drcruz21","119.92.143.161\0\0","2024-12-08 07:55:33","2024-12-08 19:37:35","1","0");
INSERT INTO tbl_user_log VALUES("23","15","drcruz21","175.176.93.140\0\0","2024-12-08 11:37:40","2024-12-09 13:30:20","1","0");
INSERT INTO tbl_user_log VALUES("24","14","mariar2024","2001:4456:1ea:aa","2024-12-08 23:12:32","09-12-2024 12:15:53 PM","1","0");
INSERT INTO tbl_user_log VALUES("25","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-08 23:27:19","","1","0");
INSERT INTO tbl_user_log VALUES("26","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-08 23:43:53","09-12-2024 08:17:53 AM","1","0");
INSERT INTO tbl_user_log VALUES("27","15","drcruz21","203.177.118.139\0","2024-12-09 05:29:52","2024-12-09 13:30:20","1","0");
INSERT INTO tbl_user_log VALUES("28","15","drcruz21","203.177.118.139\0","2024-12-09 05:31:13","","1","0");
INSERT INTO tbl_user_log VALUES("29","1","carlosmendoza88","203.177.118.139\0","2024-12-09 05:33:06","","1","0");
INSERT INTO tbl_user_log VALUES("30","28","Sai123","210.1.102.27\0\0\0\0","2024-12-09 05:58:57","2024-12-09 15:22:55","1","0");
INSERT INTO tbl_user_log VALUES("31","28","Sai123","210.1.102.27\0\0\0\0","2024-12-09 06:01:15","2024-12-09 15:22:55","1","0");
INSERT INTO tbl_user_log VALUES("32","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-09 06:07:45","","1","0");
INSERT INTO tbl_user_log VALUES("33","14","mariar2024","119.92.143.161\0\0","2024-12-09 06:48:49","09-12-2024 02:50:59 PM","1","0");
INSERT INTO tbl_user_log VALUES("34","13","juansantos123","119.92.143.161\0\0","2024-12-09 06:51:08","","1","0");
INSERT INTO tbl_user_log VALUES("35","1","carlosmendoza88","119.92.143.161\0\0","2024-12-09 06:52:21","09-12-2024 02:54:19 PM","1","0");
INSERT INTO tbl_user_log VALUES("36","14","mariar2024","119.92.143.161\0\0","2024-12-09 06:55:35","","1","0");
INSERT INTO tbl_user_log VALUES("37","28","Sai123","119.92.143.161\0\0","2024-12-09 07:01:29","2024-12-09 15:22:55","1","0");
INSERT INTO tbl_user_log VALUES("38","1","carlosmendoza88","119.92.143.161\0\0","2024-12-09 07:06:26","","1","0");
INSERT INTO tbl_user_log VALUES("39","29","Sebby","119.92.143.161\0\0","2024-12-09 07:23:05","2024-12-09 15:23:34","1","0");
INSERT INTO tbl_user_log VALUES("40","","Sebby","119.92.143.161\0\0","2024-12-09 07:24:00","","0","0");
INSERT INTO tbl_user_log VALUES("41","29","Sebby","119.92.143.161\0\0","2024-12-09 07:24:29","2024-12-09 15:31:33","1","0");
INSERT INTO tbl_user_log VALUES("42","29","Sebby","119.92.143.161\0\0","2024-12-09 07:32:39","","1","0");
INSERT INTO tbl_user_log VALUES("43","1","carlosmendoza88","119.92.143.161\0\0","2024-12-09 07:36:58","","1","0");
INSERT INTO tbl_user_log VALUES("44","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-09 08:56:45","","1","0");



DROP TABLE IF EXISTS tbl_user_page;

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL AUTO_INCREMENT,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `headerColor` varchar(100) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`userpageID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_page VALUES("1","tg logo.png","","13","#3f7791","0");



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
  `sync_status` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `locked_until` datetime DEFAULT NULL,
  PRIMARY KEY (`userID`),
  KEY `personnel_id` (`personnel_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_users VALUES("1","carlosmendoza88","admin","$2y$10$VhB2s7wzLcs8R6sxV0ag4Oei3FoJ/ZXQSNaOBkTOPRqRzX/wRraEm","Active","user.jpg","1","1","0","2024-12-01 05:47:10","0","0000-00-00 00:00:00","0","2024-12-08 23:27:19","");
INSERT INTO tbl_users VALUES("13","juansantos123","BHW","$2y$10$Std6KT7sbuAT.Tba2N/jP.9gB6Oy5yPzS/x7Zvp4FtlFpuZGmqjW6","Active","jm.webp","13","13","1","2024-12-05 05:15:14","0","0000-00-00 00:00:00","0","2024-12-09 06:51:08","");
INSERT INTO tbl_users VALUES("14","mariar2024","RHU","$2y$10$MttBD06oR6R82MfGJdm6/uOf28.QHslsW83JUWk5RqHPs/Lekh4HK","Active","","14","14","0","2024-12-05 05:16:37","0","0000-00-00 00:00:00","0","2024-12-08 23:12:32","");
INSERT INTO tbl_users VALUES("15","drcruz21","Doctor","$2y$10$wTAQI.CGkOsHO8oQ.Vm6SOFRRqkCWWiRP2TkUriCJ822JKGHFyxRq","Active","../user_images/675444347856c_profile_pic8003182828480295660.jpg","15","15","0","2024-12-05 05:18:43","0","0000-00-00 00:00:00","0","2024-12-08 05:31:47","");
INSERT INTO tbl_users VALUES("16","Nursekat.torres","Nurse","$2y$10$vIdwvesjWZq9RuEyGgyZFeZ4Od3XoyWOVhrvFHoRcLgwqVdzmdriO","Active","","17","16","0","2024-12-05 05:20:16","0","0000-00-00 00:00:00","0","2024-12-05 08:13:45","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("18","Leni","Physician","","Active","67543c1830f0e.jpeg","19","18","0","2024-12-05 06:12:51","1","0000-00-00 00:00:00","0","2024-12-07 12:14:16","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("19","krai12345","RHU","$2y$10$jI96ARM5TpoYrYVB6bDZVOMcbtAe6ANTjbLwnWhah.KzMLBkuu3hq","Active","cet.png","20","19","0","2024-12-06 02:45:47","0","0000-00-00 00:00:00","0","2024-12-06 03:23:14","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("20","kraiiii12345","BHW","$2y$10$oWFnmJcURjztTc7yWqeao.0NCIPUS/Hp1P4/cXolzUfFdhupnkuL2","Active","449486198_926600769479325_2144451970134598149_n.jpg","21","20","0","2024-12-06 02:48:05","4","0000-00-00 00:00:00","0","2024-12-07 09:39:53","2024-12-07 17:42:52");
INSERT INTO tbl_users VALUES("21","Werty","Doctor","$2y$10$8Nf8gYtiIp3mtPbY1Vc03O21sg/FtdH9Mv9OJPxN.fs60hKhmgcJ6","inactive","67540b58abd2f.png","22","21","0","2024-12-06 02:50:41","0","0000-00-00 00:00:00","0","2024-12-08 23:44:26","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("23","Kirigaya","Doctor","$2y$10$G3LW0vVd3kap11HVt0AGSeo0CMAGjtrfjYZF8cmO7giEIcion9Sn.","Active","cet.png","24","23","0","2024-12-06 03:05:55","3","0000-00-00 00:00:00","0","2024-12-08 08:30:42","2024-12-08 11:33:46");
INSERT INTO tbl_users VALUES("25","Hazel123","Nurse","$2y$10$MO08yu8jqVXeEVevycrWCuuEIkoWqpPriZBGgFx/wmaeOhlb9ZmP.","Active","6754198b2b1c3.png","26","25","0","2024-12-07 06:05:45","0","0000-00-00 00:00:00","0","2024-12-07 09:46:51","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("27","kath123","BHW","$2y$10$bzwzOk5WZJwygcy86YIz/e1wjrB4M4vitLrI.M2z3TBcaleyNFnBK","Active","avatar.jpg","28","27","0","2024-12-07 06:19:18","3","0000-00-00 00:00:00","0","2024-12-09 07:58:14","2024-12-07 14:23:47");
INSERT INTO tbl_users VALUES("28","Sai123","Doctor","$2y$10$WZbNdlU4LuhqqpDLhp7xx.pTzw1ENwAg5sH7GvfR1GvyujJS7zIFO","Active","","29","28","0","2024-12-08 03:33:28","0","0000-00-00 00:00:00","0","2024-12-09 05:58:57","");
INSERT INTO tbl_users VALUES("29","Sebby","Doctor","$2y$10$qxe44RhMkQ/wfBPsKlCaJ.550fbsZPH/nUoRmLovbHBxAiYKcEH.K","Active","Shanbin.jpg","30","29","","2024-12-09 07:22:19","0","","0","2024-12-09 07:32:34","");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`vitalSignsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




