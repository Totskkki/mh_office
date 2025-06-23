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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_care VALUES("1","3","20241202001","2024-12-02","[\"Fully Immunized\",\"On Meds\",\"Drug\",\"Hypertension\",\"\"]","+","January","2020","Dog","2024-11-27","SOuth China Sea","[\"Non-bite\",\"Induced\"]","2024-12-02","Vaccinated","Killed Intentionally","SOuth China Sea","yes","yes","yes","yes","yes","yes","2024-09-29","TT","III","CATEGORY EXPOSURE:","CATEGORY EXPOSURE:","3","ongoing","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_vaccination VALUES("1","1","2024-12-02","2024-12-05","1","","3","0","1","1","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_announcements VALUES("1","2024-12-11","Manghagbas, 2 hectars only","with free snacks and lunch","2024-12-02 13:04:10","2024-12-02 13:04:10","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_trail VALUES("1","5","Insert","Added patient: Luz loreto","tbl_patients","1","2024-12-02 05:28:01","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("2","5","Insert","Added patient: Maria magdalen","tbl_patients","2","2024-12-02 05:30:20","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("3","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 05:32:01","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("4","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 05:53:34","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("5","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 06:04:29","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("6","1","Updated Users","Updated User,  James  Laput","tbl_users","4","2024-12-02 08:28:32","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("7","3","Insert","Added patient: Mark carpio","tbl_patients","3","2024-12-02 08:36:01","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("8","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 09:29:59","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("9","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 10:27:27","2001:4456:1ea:aa00:c521:b4a:eb3d:5965","0");
INSERT INTO tbl_audit_trail VALUES("10","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-02 11:36:33","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("11","1","Added Medicine,","Added Medicine  Fast Relax","tbl_medicines","4","2024-12-02 11:41:16","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("12","1","Updated Medicine,","Updated Medicine,  Fast Relax","tbl_medicines","4","2024-12-02 11:42:01","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("13","1","Add Health Professional","Added Health Professional,  Chashieda Tunguia Lamalan","tbl_users","9","2024-12-02 12:34:24","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("14","1","Updated Health Professional","Updated Health Professional, Chashieda Tunguia Lamalan","tbl_users","9","2024-12-02 12:34:54","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("15","1","Updated Health Professional","Updated Health Professional, Chashieda Tunguia Lamalan","tbl_users","9","2024-12-02 12:35:15","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("16","1","Add Schedule","Added a schedule for Doctor  Chashieda Tunguia Lamalan","tbl_doctor_schedule","1","2024-12-02 12:38:09","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("17","1","Delete Schedule","Deleted the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","1","2024-12-02 12:41:27","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("18","1","Add Schedule","Added a schedule for Doctor  Chashieda Tunguia Lamalan","tbl_doctor_schedule","2","2024-12-02 12:42:01","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("19","1","Add Schedule","Added a schedule for Doctor  Josep  Santos","tbl_doctor_schedule","3","2024-12-02 12:42:28","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("20","1","Update Schedule","Updated the schedule for Doctor Josep  Santos","tbl_doctor_schedule","3","2024-12-02 12:55:48","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("21","1","Update Schedule","Updated the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","2","2024-12-02 12:56:03","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("22","1","Add Health Professional","Added Health Professional,  wakwak  wakwak","tbl_users","10","2024-12-02 13:01:12","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("23","1","Updated Health Professional","Updated Health Professional, Wakwak  Wakwak","tbl_users","10","2024-12-02 13:01:22","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("24","1","Add Events","Added Events  Manghagbas, 2 hectars only with free snacks and lunch","tbl_announcements","1","2024-12-02 13:04:10","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("25","1","Updated Health Professional","Updated Health Professional, Wakwak  Wakwak","tbl_users","10","2024-12-02 13:08:34","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("26","1","Add Events","Added Events  Blood Letting donation","tbl_announcements","2","2024-12-02 13:12:19","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("27","1","Update Events","Updated Events Blood Letting Sched donation","tbl_announcements","2","2024-12-02 13:19:16","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("28","1","Delete Events","Deleted Events for Blood Letting Sched donation","tbl_announcements","2","2024-12-02 13:20:15","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("29","1","Updated Users","Updated User,  Leni Pero Robrido","tbl_users","5","2024-12-02 15:29:47","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("30","1","Updated Users","Updated User,  Bhw Pero Bhw","tbl_users","2","2024-12-02 15:30:13","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("31","1","Updated Users","Updated User,  Bhw Pero Bhw","tbl_users","2","2024-12-02 15:31:07","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("32","1","Updated Users","Updated User,  Bhw Pero Bhw","tbl_users","2","2024-12-02 15:31:33","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");
INSERT INTO tbl_audit_trail VALUES("33","1","Updated Users","Updated User,  Bhw Pero Bhw","tbl_users","2","2024-12-02 15:31:55","2001:4456:1b9:ad00:b9d5:28a:5e36:4050","0");



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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`checkupID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_checkup VALUES("2","2024-12-02 13:33:00","none","none","[\"Abdomen cram\\/pain\",\"Epistaxis\",\"M yalgia\",\"\"]","","[\"Cervical lymphadenopathy\",\"\"]","[\"Decreased breath sounds\",\"\"]","[\"Muffled heart sounds\",\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"Poor muscle tone\\/strength\",\"\"]","no","","sample 2","2","0","2024-12-02","0");



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
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`complaintID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("1","1","fsda","sad","120/80","22","22kg","22","22°C","22cm","New admission","Vaccination and Immunization","Leni Robrido","server headache","Done","22","22","referred","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("2","2","","","120/80","60","33kg","22","22°C","33cm","New admission","Vaccination and Immunization","Leni Robrido","12313","Done","33","33","referred","2024-12-01","0");
INSERT INTO tbl_complaints VALUES("3","2","test","test","120/90","60","50kg","22","23°C","22.9cm","Follow-up visit","Checkup","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","Done","22","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("4","2","","","120/20","22","22kg","22","22°C","22","Follow-up visit","Animal bite and Care","Leni Robrido","","Pending","22","22","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("5","3","","","120/160","33","33kg","33","33°C","33","New consultation/case","Animal bite and Care","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","for vaccination","33","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("6","1","","","120/80","22","2kg","2","2°C","2cm","Follow-up visit","Vaccination and Immunization","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","Done","2","","","2024-12-02","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("2","9","0000-00-00","","","","","1","Weekly","{\"SUNDAY\":[{\"fromtime\":\"08:55\",\"totime\":\"13:55\",\"worklength\":\"5h 0m\"}]}","0000-00-00","0000-00-00","2024-12-02 12:42:01","0000-00-00 00:00:00","0","0","0");
INSERT INTO tbl_doctor_schedule VALUES("3","6","0000-00-00","","","","","1","Weekly","{\"SUNDAY\":[{\"fromtime\":\"08:00\",\"totime\":\"15:00\",\"worklength\":\"7h 0m\"}],\"SATURDAY\":[]}","0000-00-00","0000-00-00","2024-12-02 12:42:28","0000-00-00 00:00:00","0","0","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyAddress VALUES("1","Blingkong","St. 123","Lutayan","Sultan Kudarat","test","2024-12-02 05:28:01","2024-12-02 10:27:27","0");
INSERT INTO tbl_familyAddress VALUES("2","Palavilla","St. 123","Lutayan","Sultan Kudarat","st. 123","2024-12-02 05:30:20","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("3","Tananzang","Abubakar","Lutayan","Sultan Kudarat","abubakar, koronadal","2024-12-02 08:36:01","0000-00-00 00:00:00","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","maria loreto","Mother","09677819501","Sultan kudarat","1","2024-12-02 05:28:01","0");
INSERT INTO tbl_family_members VALUES("2","James BOnd","Father","096332659","Lutayan","2","2024-12-02 05:30:20","0");
INSERT INTO tbl_family_members VALUES("3","Soraida carpio","Wife","096523232","abubakar, koronadal","3","2024-12-02 08:36:01","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_immunization_records VALUES("1","1","Bcg Vaccine","2024-12-01","2024-12-16","sample tex","3","2024-12-02","0");
INSERT INTO tbl_immunization_records VALUES("2","2","Rabies Vaccine","2024-12-02","2024-12-18","sample text","3","2024-12-02","0");
INSERT INTO tbl_immunization_records VALUES("3","1","Bcg Vaccine","2024-12-02","2024-12-19","fdsaaaaaaaaaaaaaaaaaaaaaa","3","2024-12-02","0");



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




DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","1","injectable","93","0");
INSERT INTO tbl_medicine_details VALUES("2","2","mg","497","0");
INSERT INTO tbl_medicine_details VALUES("3","3","injectable","99","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicines VALUES("1","Rabies Vaccine","Rabies Vaccine","Rabies Vaccine","Vaccines","2024-12-01","2027-05-05","Rabies vaccine","Rabies vaccine","1","2024-12-01 11:26:43","0");
INSERT INTO tbl_medicines VALUES("2","Bio-flu","Bio-flu","Bio-flu","Analgesics","2024-12-01","2027-05-05","Bio-flu","Bio-flu","1","2024-12-01 12:14:31","0");
INSERT INTO tbl_medicines VALUES("3","Bcg Vaccine","Provides Immunity Or Protection Against Tuberculosis (tb)","Bcg Vaccine","Vaccines","2024-12-01","2025-01-08","BCG vaccine","Branded","1","2024-12-01 12:30:03","0");
INSERT INTO tbl_medicines VALUES("4","Fast Relax","Gamot Na Maaasahan","Tunguia Pharma","Analgesics","2024-01-03","2025-07-18","Neytunguia","Iduno","1","2024-12-02 11:41:16","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","No","","","LGU","2024-12-02 05:28:01","2024-12-02 05:32:01","0");
INSERT INTO tbl_membership_info VALUES("2","Yes","062469896511","Member","4PS","2024-12-02 05:30:20","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("3","Yes","091658753256","Dependent","Private","2024-12-02 08:36:01","0000-00-00 00:00:00","0");



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;




DROP TABLE IF EXISTS tbl_patient_visits;

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL AUTO_INCREMENT,
  `visit_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patient_visitID`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_visits VALUES("1","2024-12-02","0000-00-00","","","1","0","0");
INSERT INTO tbl_patient_visits VALUES("2","2024-12-02","0000-00-00","","","2","0","0");
INSERT INTO tbl_patient_visits VALUES("3","2024-12-02","0000-00-00","","","3","0","0");
INSERT INTO tbl_patient_visits VALUES("4","2024-12-02","0000-00-00","","","1","0","0");



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
  `reg_date` date NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patientID`),
  KEY `Membership_Info` (`Membership_Info`),
  KEY `family_no` (`family_address`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","5091397","Luz","","Loreto","","","","0000000001","2024-12-02","1 Year And 5 Months","09677819501","Other","Single","A-","","","Islam","Filipino","2024-12-02","5","2024-12-02 10:27:27","0");
INSERT INTO tbl_patients VALUES("2","2","2","5091398","Maria","","Magdalena","","","","0000000002","2024-12-02","5 Years","096332645","Female","Single","B-","","","Roman Catholic","Filipino","2024-12-02","5","2024-12-02 11:36:33","0");
INSERT INTO tbl_patients VALUES("3","3","3","5091399","Mark","","carpio","","Soraida carpio","","0000000003","1989-01-10","35 years","09623655449","Male","Single","O-","Master\'s Degree","programmer","Islam","Filipino","2024-12-02","3","0000-00-00 00:00:00","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","admin","","adminadmin","09653231212","admin123@gmail.com","","0");
INSERT INTO tbl_personnel VALUES("2","Bhw","Pero","Bhw","+639665123662","bhw@gmail.com","Bhw","0");
INSERT INTO tbl_personnel VALUES("3","Rhu","","Rhu","+632131321321","RHULUTAYAN@gmail.com","Rhurhu","0");
INSERT INTO tbl_personnel VALUES("4","James","","Laput","+639665123662","rhukoronadal@gmail","Koronadal City , South Cotabato","0");
INSERT INTO tbl_personnel VALUES("5","Leni","Pero","Robrido","+639665123662","leni@yahoo","Manila, Koronadal","0");
INSERT INTO tbl_personnel VALUES("6","Josep","","Santos","+639665123662","Josep@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("7","gerald","","anders","+631232131321","gerald@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("8","Erlinda","Antique","Lapus","+631232131321","floresjovenrey26@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("9","Chashieda","Tunguia","Lamalan","+639547544444","azumi_maiya@yahoo.com","Purok Kaugnayan, Koronadal City","0");
INSERT INTO tbl_personnel VALUES("10","Wakwak","","Wakwak","+632131321321","wakwak@mail","wakwakwakwak","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","admin","","","","0");
INSERT INTO tbl_position VALUES("2","3","","","","","0");
INSERT INTO tbl_position VALUES("3","4","","","","","0");
INSERT INTO tbl_position VALUES("4","5","","","","","0");
INSERT INTO tbl_position VALUES("5","6","Doctor","Family doctor","M.D","12312321312","0");
INSERT INTO tbl_position VALUES("6","7","Physician","gerald","gerald","","0");
INSERT INTO tbl_position VALUES("7","8","Midwife","erlinda","erlinda","","0");
INSERT INTO tbl_position VALUES("8","9","Doctor","Pedia","Senior","656465466465","0");
INSERT INTO tbl_position VALUES("9","10","Doctor","wakwak","wakwak","123123","0");



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

INSERT INTO tbl_referrals_log VALUES("1","1","2024-12-02","5","","0");
INSERT INTO tbl_referrals_log VALUES("2","2","2024-12-02","5","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("1","3","RHU","2001:4456:1ea:aa","2024-12-02 05:56:23","","1","0");
INSERT INTO tbl_user_log VALUES("2","2","BHW","2001:4456:1ea:aa","2024-12-02 07:01:29","02-12-2024 03:03:04 PM","1","0");
INSERT INTO tbl_user_log VALUES("3","5","leni","2001:4456:1ea:aa","2024-12-02 07:03:10","02-12-2024 03:03:59 PM","1","0");
INSERT INTO tbl_user_log VALUES("4","2","BHW","2001:4456:1ea:aa","2024-12-02 07:04:39","02-12-2024 03:09:15 PM","1","0");
INSERT INTO tbl_user_log VALUES("5","5","leni","2001:4456:1ea:aa","2024-12-02 07:09:23","","1","0");
INSERT INTO tbl_user_log VALUES("6","4","rhukoronadal","2001:4456:1ea:aa","2024-12-02 08:28:46","02-12-2024 04:29:28 PM","1","0");
INSERT INTO tbl_user_log VALUES("7","5","leni","2001:4456:1ea:aa","2024-12-02 08:29:35","02-12-2024 06:15:48 PM","1","0");
INSERT INTO tbl_user_log VALUES("8","3","RHU","2001:4456:1ea:aa","2024-12-02 08:33:44","","1","0");
INSERT INTO tbl_user_log VALUES("9","2","BHW","2001:4456:1ea:aa","2024-12-02 10:15:54","02-12-2024 06:33:09 PM","1","0");
INSERT INTO tbl_user_log VALUES("10","2","BHW","2001:4456:1b9:ad","2024-12-02 10:48:08","02-12-2024 06:50:56 PM","1","0");
INSERT INTO tbl_user_log VALUES("11","3","RHU","2001:4456:1b9:ad","2024-12-02 10:51:18","02-12-2024 06:52:24 PM","1","0");
INSERT INTO tbl_user_log VALUES("12","0","RHU","2001:4456:1b9:ad","2024-12-02 10:52:40","","0","0");
INSERT INTO tbl_user_log VALUES("13","0","RHU","2001:4456:1b9:ad","2024-12-02 10:53:04","","0","0");
INSERT INTO tbl_user_log VALUES("14","0","BHW","2001:4456:1ea:aa","2024-12-02 10:57:51","","0","0");
INSERT INTO tbl_user_log VALUES("15","0","BHW","2001:4456:1ea:aa","2024-12-02 10:58:06","","0","0");
INSERT INTO tbl_user_log VALUES("16","0","BHW","2001:4456:1ea:aa","2024-12-02 10:58:15","","0","0");
INSERT INTO tbl_user_log VALUES("17","3","RHU","2001:4456:1ea:aa","2024-12-02 10:59:49","02-12-2024 07:00:02 PM","1","0");
INSERT INTO tbl_user_log VALUES("18","3","RHU","2001:4456:1b9:ad","2024-12-02 11:00:08","02-12-2024 07:00:21 PM","1","0");
INSERT INTO tbl_user_log VALUES("19","5","leni","2001:4456:1ea:aa","2024-12-02 11:00:19","02-12-2024 07:01:36 PM","1","0");
INSERT INTO tbl_user_log VALUES("20","2","BHW","2001:4456:1ea:aa","2024-12-02 11:01:49","02-12-2024 07:02:09 PM","1","0");
INSERT INTO tbl_user_log VALUES("21","2","BHW","2001:4456:1ea:aa","2024-12-02 11:02:12","02-12-2024 07:03:07 PM","1","0");
INSERT INTO tbl_user_log VALUES("22","0","Rhu","2001:4456:1ea:aa","2024-12-02 11:03:16","","0","0");
INSERT INTO tbl_user_log VALUES("23","0","Rhu","2001:4456:1ea:aa","2024-12-02 11:03:29","","0","0");
INSERT INTO tbl_user_log VALUES("24","3","RHU","2001:4456:1ea:aa","2024-12-02 11:03:43","02-12-2024 07:04:21 PM","1","0");
INSERT INTO tbl_user_log VALUES("25","0","RHU","2001:4456:1b9:ad","2024-12-02 11:06:36","","0","0");
INSERT INTO tbl_user_log VALUES("26","0","RHU","2001:4456:1b9:ad","2024-12-02 11:07:10","","0","0");
INSERT INTO tbl_user_log VALUES("27","0","RHU","2001:4456:1b9:ad","2024-12-02 11:07:15","","0","0");
INSERT INTO tbl_user_log VALUES("28","0","1234","2001:4456:1b9:ad","2024-12-02 11:07:23","","0","0");
INSERT INTO tbl_user_log VALUES("29","0","WRW","2001:4456:1b9:ad","2024-12-02 11:07:30","","0","0");
INSERT INTO tbl_user_log VALUES("30","0","WRWR","2001:4456:1b9:ad","2024-12-02 11:07:34","","0","0");
INSERT INTO tbl_user_log VALUES("31","0","RWRW","2001:4456:1b9:ad","2024-12-02 11:07:38","","0","0");
INSERT INTO tbl_user_log VALUES("32","0","WRW","2001:4456:1b9:ad","2024-12-02 11:07:43","","0","0");
INSERT INTO tbl_user_log VALUES("33","0","WRRWR","2001:4456:1b9:ad","2024-12-02 11:07:48","","0","0");
INSERT INTO tbl_user_log VALUES("34","0","RHU","2001:4456:1b9:ad","2024-12-02 11:11:03","","0","0");
INSERT INTO tbl_user_log VALUES("35","0","ADMIN","2001:4456:1b9:ad","2024-12-02 11:11:28","","0","0");
INSERT INTO tbl_user_log VALUES("36","1","admin","2001:4456:1b9:ad","2024-12-02 11:11:46","02-12-2024 07:33:15 PM","1","0");
INSERT INTO tbl_user_log VALUES("37","0","rhu","2001:4456:1b9:ad","2024-12-02 11:19:48","","0","0");
INSERT INTO tbl_user_log VALUES("38","1","admin","2001:4456:1b9:ad","2024-12-02 11:33:26","","1","0");
INSERT INTO tbl_user_log VALUES("39","0","RHU","175.176.93.169\0\0","2024-12-02 11:52:08","","0","0");
INSERT INTO tbl_user_log VALUES("40","0","rhu","175.176.93.169\0\0","2024-12-02 11:55:55","","0","0");
INSERT INTO tbl_user_log VALUES("41","0","BHW","175.176.93.169\0\0","2024-12-02 11:56:23","","0","0");
INSERT INTO tbl_user_log VALUES("42","0","ADMIN","175.176.93.169\0\0","2024-12-02 11:58:59","","0","0");
INSERT INTO tbl_user_log VALUES("43","1","admin","175.176.93.169\0\0","2024-12-02 11:59:06","02-12-2024 08:08:33 PM","1","0");
INSERT INTO tbl_user_log VALUES("44","0","Rhu","175.176.93.169\0\0","2024-12-02 12:01:17","","0","0");
INSERT INTO tbl_user_log VALUES("45","3","RHU","175.176.93.169\0\0","2024-12-02 12:01:21","02-12-2024 08:01:38 PM","1","0");
INSERT INTO tbl_user_log VALUES("46","1","admin","175.176.92.247\0\0","2024-12-02 12:20:49","02-12-2024 11:49:32 PM","1","0");
INSERT INTO tbl_user_log VALUES("47","1","admin","175.176.92.247\0\0","2024-12-02 22:31:27","03-12-2024 06:34:18 AM","1","0");
INSERT INTO tbl_user_log VALUES("48","1","admin","175.176.92.247\0\0","2024-12-02 22:34:30","03-12-2024 06:36:33 AM","1","0");
INSERT INTO tbl_user_log VALUES("49","","BHW","175.176.92.247\0\0","2024-12-02 22:36:44","","0","0");
INSERT INTO tbl_user_log VALUES("50","2","BHW","175.176.92.247\0\0","2024-12-02 22:36:49","03-12-2024 06:37:05 AM","1","0");
INSERT INTO tbl_user_log VALUES("51","5","leni","175.176.92.247\0\0","2024-12-02 22:37:14","03-12-2024 06:40:32 AM","1","0");
INSERT INTO tbl_user_log VALUES("52","1","admin","175.176.92.247\0\0","2024-12-02 22:40:42","03-12-2024 06:41:31 AM","1","0");
INSERT INTO tbl_user_log VALUES("53","1","admin","175.176.92.247\0\0","2024-12-02 22:41:35","03-12-2024 06:41:43 AM","1","0");
INSERT INTO tbl_user_log VALUES("54","2","BHW","175.176.92.247\0\0","2024-12-02 22:41:56","03-12-2024 06:47:12 AM","1","0");
INSERT INTO tbl_user_log VALUES("55","1","admin","175.176.92.247\0\0","2024-12-02 22:47:21","","1","0");



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

INSERT INTO tbl_user_page VALUES("1","Screenshot 2024-11-21 094125.png","BRGY. LAMPARE","5","#482c96","0");



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
  PRIMARY KEY (`userID`),
  KEY `personnel_id` (`personnel_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_users VALUES("1","admin","admin","$2a$12$piDPv0I3muQYv5z613q/Ru0B2z1dtnYzJ3r/XrvltmGuJ1fjQ8Z4e","Active","ic_doctor.png","1","1","0","2024-12-01 05:47:10","0","","0","2024-12-02 22:31:27");
INSERT INTO tbl_users VALUES("2","BHW","RHU","$2y$10$USbkIdtfXITuJpxVzjuVNuDl3Lq8eH78.8nxtrPV3plxHQ8vBCij2","Active","box-img2.jpg","2","1","2","2024-12-01 05:48:18","0","","0","2024-12-02 22:36:49");
INSERT INTO tbl_users VALUES("3","RHU","RHU","$2y$10$yGaKtJuF1f..s64.E0RsEesuiR8BV5aXrKHZ3lAlFH0qPtR7ocB0m","Active","","3","2","0","2024-12-01 05:48:37","0","0000-00-00 00:00:00","0","2024-12-02 12:01:21");
INSERT INTO tbl_users VALUES("4","rhukoronadal","RHU","$2y$10$mTz4Ird6kvA0e6tNfS2FEO/2pgAjCezNtEIuXuTiTkFV8NBVf/jkG","Active","","4","3","0","2024-12-01 06:02:01","0","0000-00-00 00:00:00","0","2024-12-02 08:28:32");
INSERT INTO tbl_users VALUES("5","leni","BHW","$2y$10$Zkmxkrs/CGuKDfn6Wl9SnuwytAyszqrxvWFDmbaihlhlRqMdIvMD.","Active","photo1718592536 (3).jpeg","5","4","1","2024-12-01 06:03:49","0","","0","2024-12-02 22:37:14");
INSERT INTO tbl_users VALUES("6","josep123","Doctor","$2y$10$Q3H5r8jp3kt59m4j9F1rxeQHXtvL.wzewqIAjet8Jv1oci2U9pWxq","Active","","6","5","0","2024-12-01 12:13:58","0","0000-00-00 00:00:00","0","2024-12-02 02:47:59");
INSERT INTO tbl_users VALUES("7","Gerald","Physician","","Active","","7","6","0","2024-12-02 00:56:14","0","0000-00-00 00:00:00","0","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("8","Erlinda","Midwife","","Active","","8","7","0","2024-12-02 01:00:00","0","0000-00-00 00:00:00","0","2024-12-02 02:16:50");
INSERT INTO tbl_users VALUES("9","Baibai","Doctor","$2y$10$snsikaSQY4u30humwRG/3e8yeIP/Ljrk9VVNa7r51HKjqKq.lbUJ2","Active","ProfilePhoto.jpg","9","8","0","2024-12-02 12:34:24","0","0000-00-00 00:00:00","0","2024-12-02 12:35:15");
INSERT INTO tbl_users VALUES("10","Wakwak","Midwife","$2y$10$F.oelIfQKYrAyHQZC/vA2.qTaH8Ts3g8YdnjLsOeq8EZJOzKPTb6W","Active","674db152dd3b3.jpg","10","9","0","2024-12-02 13:01:12","0","0000-00-00 00:00:00","0","2024-12-02 13:08:34");



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




