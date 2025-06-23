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

INSERT INTO tbl_animal_bite_care VALUES("1","3","20241205001","2024-12-05","[\"Fully Immunized\",\"Anti-Rabies\",\"On Meds\",\"Hypertension\",\"On Meds\",\"None\"]","+","August","2021","Stray","2021-12-04","Lutayan, Sultan Kudarat","[\"Bite\",\"Induced\"]","2024-12-05","","Alive","Description of Wound: Bite to the left lower leg","yes","yes","yes","no","no","yes","2024-12-05","TT","III","","","14","ongoing","0");



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

INSERT INTO tbl_animal_bite_vaccination VALUES("1","5","2024-12-05","2024-12-12","1","First dose administered; follow-up for additional doses required.","3","0","1","1","0");



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

INSERT INTO tbl_announcements VALUES("2","2024-12-06","bday","happy bday","2024-12-06 03:09:07","2024-12-06 03:09:07","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_trail VALUES("1","1","Updated Health Professional","Updated Health Professional, Erlinda Antique Lapus","tbl_users","8","2024-12-05 05:07:32","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("2","1","Add Users","Added User,  Juan Dela Cruz Santos","tbl_users","13","2024-12-05 05:15:14","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("3","1","Add Users","Added User,  Maria Garcia Reyes","tbl_users","14","2024-12-05 05:16:37","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("4","1","Add Health Professional","Added Health Professional,  ricardo villar cruz","tbl_users","15","2024-12-05 05:18:43","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("5","1","Add Health Professional","Added Health Professional,  karina ramos torres","tbl_users","16","2024-12-05 05:20:16","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("6","1","Add Health Professional","Added Health Professional,  lilibeth aquino de guzman","tbl_users","17","2024-12-05 05:22:47","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("7","1","Updated Health Professional","Updated Health Professional, Ricardo Villar Cruz","tbl_users","15","2024-12-05 05:23:42","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("8","1","Added Medicine,","Added Medicine  Amoxicillin","tbl_medicines","1","2024-12-05 05:30:57","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("9","1","Add Medicine Stock","Added Medicine Stock  Amoxicillin 10 1000","tbl_medicine_details","1","2024-12-05 05:32:40","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("10","1","Added Medicine,","Added Medicine  Cetirizine  10mg Tablets","tbl_medicines","2","2024-12-05 05:33:57","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("11","1","Add Medicine Stock","Added Medicine Stock  Cetirizine  10mg Tablets Pack of 10 Tablets 2000","tbl_medicine_details","2","2024-12-05 05:35:00","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("12","1","Updated Medicine,","Updated Medicine,  Amoxicillin 250mg Capsules","tbl_medicines","1","2024-12-05 05:35:20","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("13","1","Added Medicine,","Added Medicine  Folic Acid 5mg Tablets","tbl_medicines","3","2024-12-05 05:36:52","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("14","1","Added Medicine,","Added Medicine  Oxytocin 10 Iu/ml Injection","tbl_medicines","4","2024-12-05 05:38:11","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("15","1","Added Medicine,","Added Medicine  Rabies Vaccine (purified Vero Cell Vaccine) 1ml","tbl_medicines","5","2024-12-05 05:39:32","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("16","1","Added Medicine,","Added Medicine  Loperamide 2mg Capsules","tbl_medicines","6","2024-12-05 05:41:53","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("17","1","Add Medicine Stock","Added Medicine Stock  Loperamide 2mg Capsules Blister Pack of 10 Capsules 3000","tbl_medicine_details","3","2024-12-05 05:42:19","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("18","13","Insert","Added patient: Mika Reyes","tbl_patients","1","2024-12-05 05:42:21","158.62.75.222","0");
INSERT INTO tbl_audit_trail VALUES("19","1","Add Medicine Stock","Added Medicine Stock  Rabies Vaccine (purified Vero Cell Vaccine) 1ml 1mL Single-Dose Vial, Box of 5 Vials 5000","tbl_medicine_details","4","2024-12-05 05:42:41","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("20","1","Add Medicine Stock","Added Medicine Stock  Oxytocin 10 Iu/ml Injection 1mL Ampoule, Box of 10 Ampoules 1020","tbl_medicine_details","5","2024-12-05 05:43:11","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("21","1","Add Medicine Stock","Added Medicine Stock  Folic Acid 5mg Tablets Blister Pack of 30 Tablets 5052","tbl_medicine_details","6","2024-12-05 05:43:41","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("22","13","Insert","Added patient: Erlinda Lapus","tbl_patients","2","2024-12-05 05:59:58","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("23","1","Update","Updated Patient Information,  Erlinda Lapus","tbl_patients","2","2024-12-05 06:03:42","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("24","1","Add Health Professional","Added Health Professional,  Elizabeth  Harmon","tbl_users","18","2024-12-05 06:12:51","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("25","14","Insert","Added patient: Juan Santos","tbl_patients","3","2024-12-05 06:22:46","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("26","14","Insert","Added patient: Mariebel Garcia","tbl_patients","4","2024-12-05 06:40:39","2001:4456:1b9:ad00:1c65:6d39:f909:7514","0");
INSERT INTO tbl_audit_trail VALUES("27","1","Updated Health Professional","Updated Health Professional, Ricardo Villar Cruz","tbl_users","15","2024-12-05 08:05:56","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("28","1","Updated Health Professional","Updated Health Professional, Ricardo V Cruz","tbl_users","15","2024-12-05 08:13:18","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("29","1","Updated Health Professional","Updated Health Professional, Karina Ramos Torres","tbl_users","16","2024-12-05 08:13:45","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("30","1","Updated Health Professional","Updated Health Professional, Ricardo V Cruz","tbl_users","15","2024-12-05 08:14:45","2001:4456:1ea:aa00:14b7:2211:a468:cba1","0");
INSERT INTO tbl_audit_trail VALUES("31","14","Insert","Added patient: Regine Jesa Palara","tbl_patients","5","2024-12-06 02:15:17","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("32","14","Insert","Added patient: Dsadasd sdasda","tbl_patients","6","2024-12-06 02:31:11","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("33","1","Add Users","Added User,  Krai L Grievers","tbl_users","19","2024-12-06 02:45:47","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("34","1","Add Users","Added User,  Kraiiii L Domingo Jr","tbl_users","20","2024-12-06 02:48:05","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("35","1","Added Medicine,","Added Medicine  Wer","tbl_medicines","7","2024-12-06 02:48:55","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("36","1","Updated Medicine,","Updated Medicine,  Wer","tbl_medicines","7","2024-12-06 02:49:18","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("37","1","Add Health Professional","Added Health Professional,  werty werty werty","tbl_users","21","2024-12-06 02:50:41","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("38","19","Insert","Added patient: Joel DOMINGO JR","tbl_patients","7","2024-12-06 02:53:26","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("39","1","Added Medicine,","Added Medicine  Omeprazole","tbl_medicines","8","2024-12-06 02:55:43","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("40","1","Updated Medicine,","Updated Medicine,  Omeprazole","tbl_medicines","8","2024-12-06 02:55:56","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("41","1","Updated Medicine,","Updated Medicine,  Omeprazole","tbl_medicines","8","2024-12-06 02:56:13","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("42","1","Updated Medicine,","Updated Medicine,  Omeprazole","tbl_medicines","8","2024-12-06 02:57:09","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("43","1","Add Schedule","Added a schedule for Doctor  werty werty werty","tbl_doctor_schedule","1","2024-12-06 02:58:27","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("44","1","Add Schedule","Added a schedule for Doctor  werty werty werty","tbl_doctor_schedule","2","2024-12-06 02:58:27","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("45","1","Add Medicine Stock","Added Medicine Stock  Omeprazole 90 90","tbl_medicine_details","7","2024-12-06 02:58:41","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("46","1","Add Medicine Stock","Added Medicine Stock  Unknown","tbl_medicine_details","0","2024-12-06 02:58:41","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("47","1","Delete Schedule","Deleted the schedule for Doctor werty werty werty","tbl_doctor_schedule","2","2024-12-06 02:59:08","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("48","1","Add Events","Added Events  tuli qwertyui","tbl_announcements","1","2024-12-06 02:59:45","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("49","1","Update Events","Updated Events tuli3 qwertyui","tbl_announcements","1","2024-12-06 03:00:31","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("50","1","Delete Events","Deleted Events for tuli3 qwertyui","tbl_announcements","1","2024-12-06 03:00:37","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("51","1","Add Users","Added User,  Qeqweq Eqweq Eqwe","tbl_users","22","2024-12-06 03:03:33","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("52","1","Updated Users","Updated User,  Werwerwer Werwerwer Eqwe","tbl_users","22","2024-12-06 03:03:52","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("53","1","Updated Users","Updated User,  Kraiiii L Domingo Jr","tbl_users","20","2024-12-06 03:04:15","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("54","1","Add Health Professional","Added Health Professional,  kirigaya l kazuto","tbl_users","23","2024-12-06 03:05:55","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("55","1","Add Schedule","Added a schedule for Doctor  kirigaya l kazuto","tbl_doctor_schedule","3","2024-12-06 03:07:03","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("56","1","Delete Schedule","Deleted the schedule for Doctor werty werty werty","tbl_doctor_schedule","1","2024-12-06 03:07:57","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("57","1","Add Events","Added Events  bday happy bday","tbl_announcements","2","2024-12-06 03:09:07","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("58","20","Insert","Added patient: Kim Jasper venus","tbl_patients","8","2024-12-06 03:13:22","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("59","1","Updated Users","Updated User,  Kraiiii L Domingo Jr","tbl_users","20","2024-12-06 03:17:18","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("60","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-06 03:18:15","119.92.143.161","0");
INSERT INTO tbl_audit_trail VALUES("61","1","Updated Medicine,","Updated Medicine,  Loperamide 2mg Capsules","tbl_medicines","6","2024-12-06 06:54:13","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("62","1","Update","Updated Patient Information,  Dsadasd Sdasda","tbl_patients","6","2024-12-06 06:56:27","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("63","1","Update","Updated Patient Information,  Dsadasd Sdasda","tbl_patients","6","2024-12-06 07:23:51","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("64","1","Update","Updated Patient Information,  Regine Jesa Palara","tbl_patients","5","2024-12-06 10:44:31","175.176.93.9","0");
INSERT INTO tbl_audit_trail VALUES("65","14","Insert","Added patient: Alison Renz Quizon","tbl_patients","9","2024-12-06 17:28:05","158.62.79.251","0");
INSERT INTO tbl_audit_trail VALUES("66","13","Insert","Added patient: Sample sadsadasd","tbl_patients","10","2024-12-06 17:56:46","158.62.79.251","0");
INSERT INTO tbl_audit_trail VALUES("67","1","Added Medicine,","Added Medicine  Sample Med","tbl_medicines","9","2024-12-06 18:03:42","158.62.79.251","0");
INSERT INTO tbl_audit_trail VALUES("68","1","Updated Health Professional","Updated Health Professional, Kirigaya L Kazuto","tbl_users","23","2024-12-06 18:09:01","158.62.79.251","0");
INSERT INTO tbl_audit_trail VALUES("69","1","Update","Updated Patient Information,  Sample Sadsadasd","tbl_patients","10","2024-12-06 23:41:52","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("70","1","Update","Updated Patient Information,  Alison Renz Quizon","tbl_patients","9","2024-12-06 23:42:46","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("71","1","Update","Updated Patient Information,  Alison Renz Quizon","tbl_patients","9","2024-12-06 23:42:58","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");
INSERT INTO tbl_audit_trail VALUES("72","1","Update","Updated Patient Information,  Alison Renz Quizon","tbl_patients","9","2024-12-06 23:44:28","2001:4456:1ea:aa00:9d58:97b5:ef26:8a91","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birth_info VALUES("1","6","20241206001","2024-12-06","5","5","5","{\"g\":\"5\",\"p\":\"5\",\"term\":\"4\",\"preterm\":\"5\",\"abortion\":\"5\",\"living\":\"5\"}","wghfds","[\"Heart Disease\",\"Pulmonary TB\",\"Asthma\",\"Renal Disease\",\"lolo\"]","","","","[\"Heart Disease\",\"lol\"]","{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}","{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"flow\":[\"moderate\"],\"first_sexual_contact\":\"\"}","{\"antepartal_care\":\"OPD\",\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"feso4\":\"No\",\"ogct\":\"\",\"illness\":\"\",\"tot_visit\":\"\",\"others\":\"\"}","[{\"year\":\"\",\"place_of_confinement\":\"\",\"aog\":\"\",\"bw\":\"\",\"manner_of_delivery\":\"\",\"complication_remarks\":\"\"}]","14","1","1","16","done","2024-12-06","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthing_monitoring VALUES("1","1","20241206001","6","dwdwadaw","2024-12-06","10:37:00","10:37:00","10:37:00","10:38:00","10:37:00","10:37","No","100","10:37:00","Livebirth","No","100","No","100","sdasda","","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","[\"5\"]","dasdasda","qwewqe","12:00","dasdasd","dsadsada","2024-12-06 02:39:03","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_certificate_log VALUES("1","5","2024-12-06 02:26:49","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/5_2024-12-06.pdf","0");
INSERT INTO tbl_certificate_log VALUES("2","5","2024-12-06 02:26:49","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/5_2024-12-06.pdf","0");
INSERT INTO tbl_certificate_log VALUES("3","6","0000-00-00 00:00:00","pending","","0");
INSERT INTO tbl_certificate_log VALUES("4","8","0000-00-00 00:00:00","pending","","0");
INSERT INTO tbl_certificate_log VALUES("5","2","0000-00-00 00:00:00","pending","","0");
INSERT INTO tbl_certificate_log VALUES("6","1","0000-00-00 00:00:00","pending","","0");
INSERT INTO tbl_certificate_log VALUES("7","8","0000-00-00 00:00:00","pending","","0");



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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`recordID`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_clinicalrecords VALUES("1","6","","","","2024-12-06","10:37:00","2024-12-06","10:40:00","new","Karina Ramos Torres","","","ewea","dadwada","wadad","discharged","1","2024-12-06 02:39:55","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("1","2","fdddddddddddd","fdsa","120/22","22","2kg","2","2°C","2cm","New consultation/case","Prenatal","Juan Santos","fdsa","Pending","2","2","referred","prenatal","prenatal","2024-12-05","0");
INSERT INTO tbl_complaints VALUES("2","1","","","120/80","22","22kg","22","22°C","22","Follow-up visit","Prenatal","Juan Santos","prenatal","Done","22","22","","prenatal","prenatal","2024-12-05","0");
INSERT INTO tbl_complaints VALUES("3","3","Fever and headache","Patient has been experiencing fever for the last 2 days with occasional dizziness.","120/80","80","65kg","18","37.8°C","170","New consultation/case","Animal bite and Care","Maria Reyes","Patient was bitten by a dog and needs immediate care and rabies prophylaxis","for vaccination","80","","","","","2024-12-05","0");
INSERT INTO tbl_complaints VALUES("4","4","Dog bite to the right leg","Patient reports a bite from a stray dog on 12/04/2024, now seeking treatment for possible rabies exposure.","120/80","80","65kg","18","37°C","160","New consultation/case","Animal bite and Care","Maria Reyes","For animal bite treatment and rabies prophylaxis","Pending","80","","","","","2024-12-05","0");
INSERT INTO tbl_complaints VALUES("5","5","Migraine","Tubig lang ah","140/80","30","80kg","100","34°C","5cm","Follow-up visit","Checkup","Maria Reyes","Di makaya sang powers","Done","95","","referred","","","2024-12-06","0");
INSERT INTO tbl_complaints VALUES("6","6","dasd","dasds","140/80","30","80kg","100","34°C","5cm","Follow-up visit","Birthing","Maria Reyes","dasdasda","Done","95","","referred","","","2024-12-06","0");
INSERT INTO tbl_complaints VALUES("7","9","sakit sa ear","sdasdasdsadasd","200/157","25","325kg","23","34°C","45","New admission","Checkup","Maria Reyes","aasdsadas","Pending","23","","","","","2024-12-06","0");
INSERT INTO tbl_complaints VALUES("8","10","dasdsad","sdasdasd","121/12","12","12kg","12","12°C","12","Follow-up visit","Checkup","Juan Santos","12121aasdasd","Pending","12","12","","sadasdasd","asdasdas","2024-12-06","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("3","23","","","","","","1","Weekly","{\"SUNDAY\":[],\"FRIDAY\":[{\"fromtime\":\"05:15\",\"totime\":\"11:21\",\"worklength\":\"6h 6m\"}]}","","","2024-12-06 03:07:03","","0","0","0");
INSERT INTO tbl_doctor_schedule VALUES("4","15","","wfrgef2","","","","2","","","2025-01-04","2025-01-07","2024-12-06 03:14:10","","0","0","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyAddress VALUES("1","Blingkong","Urdaneta","","Sultan Kudarat","Lutayan, Sultan kudarat","2024-12-05 05:42:21","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("2","Antong","Test","","Sulatan Kudarat","Sulatan Kudarat","2024-12-05 05:59:58","2024-12-05 06:03:42","0");
INSERT INTO tbl_familyAddress VALUES("3","Tamnag (pob.)","Purok Malipayon","","Sultan Kudarat","General Santos City, South Cotabato","2024-12-05 06:22:46","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("4","Palavilla","Purok Mabuhay","","Sultan Kudarat","Koronadal City, South Cotabato","2024-12-05 06:40:39","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("5","Mangudadatu","Maligaya","","Sultan Kudarat","Cotabato City","2024-12-06 02:15:17","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("6","Sisiman","Dasda","","Dasda","Dsasdasd","2024-12-06 02:31:11","2024-12-06 06:56:27","0");
INSERT INTO tbl_familyAddress VALUES("7","Mamali","Agreda","","South Cot","koronadal","2024-12-06 02:53:26","0000-00-00 00:00:00","0");
INSERT INTO tbl_familyAddress VALUES("8","Palavilla","Aaaa","","Aaa","aaa","2024-12-06 03:13:22","","0");
INSERT INTO tbl_familyAddress VALUES("9","Sisiman","Sample","","Sdassaasd","Sdasdasdas","2024-12-06 17:28:05","2024-12-06 23:42:46","0");
INSERT INTO tbl_familyAddress VALUES("10","Tamnag (pob.)","Sadasdsa","","Sdasdas","sadasdasd","2024-12-06 17:56:46","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","Michael Lopez Reyes","Husband","09326748765","Purok Urdaneta Brgy. Blingkong Lutayan Sultan Kudarat","1","2024-12-05 05:42:21","0");
INSERT INTO tbl_family_members VALUES("2","Erlinda Antique Lapus","Mother","096232365","Sulatan Kudarat","2","2024-12-05 05:59:58","0");
INSERT INTO tbl_family_members VALUES("3","Maria Santos","Mother","09182345678","Purok Malipayon, Barangay Lutayan Proper, Lutayan, Sultan Kudarat","3","2024-12-05 06:22:46","0");
INSERT INTO tbl_family_members VALUES("4","Jo Garcia","Husband","09182345678","Purok Mabuhay, Barangay Lutayan Proper, Lutayan, Sultan Kudarat","4","2024-12-05 06:40:39","0");
INSERT INTO tbl_family_members VALUES("5","Hazel Joy Alvarez","Wife","09123456789","Sdfghjkytrew","5","2024-12-06 02:15:17","0");
INSERT INTO tbl_family_members VALUES("6","Hazel Joy Alvarez","Wife","09123456789","Sdfghjkytrew","5","2024-12-06 02:20:08","0");
INSERT INTO tbl_family_members VALUES("7","ddadwad","Guardian","09123456789","dawdad","6","2024-12-06 02:31:11","0");
INSERT INTO tbl_family_members VALUES("8","Ddadwad","Guardian","09123456789","Dawdad","6","2024-12-06 02:53:26","0");
INSERT INTO tbl_family_members VALUES("9","JOEL LEZLEE L. DOMINGO JR","Wife","909853303250","Agreda Subd. Koronadal City, South Cotabato","8","2024-12-06 03:13:22","0");
INSERT INTO tbl_family_members VALUES("10","sample lang","Mother","1234567893432432","sadasdasdasdsadjasdbajs","9","2024-12-06 17:28:05","0");
INSERT INTO tbl_family_members VALUES("11","Sample Lang","Mother","1234567893432432","Sadasdasdasdsadjasdbajs","9","2024-12-06 17:56:46","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_healthnotes VALUES("1","6","15","2024-12-06","10:40:00","fsefsefs","","1","2024-12-06 02:41:48","0");
INSERT INTO tbl_healthnotes VALUES("2","6","15","2024-12-06","10:42:00","sdfghjk","","1","2024-12-06 02:41:48","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_laboratory VALUES("1","Complete Blood Count (CBC)","2024-12-06","Normal","5","386745.jpg","2024-12-06 02:19:13","0");
INSERT INTO tbl_laboratory VALUES("2","Complete Blood Count (CBC)","2024-12-06","dsadasda","6","386745.jpg","2024-12-06 02:31:55","0");
INSERT INTO tbl_laboratory VALUES("3","Complete Blood Count (CBC)","2024-12-07","etregrgregre","9","Q1.png","2024-12-06 17:32:40","0");



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

INSERT INTO tbl_medicine_details VALUES("1","1","10","987","0");
INSERT INTO tbl_medicine_details VALUES("2","2","Pack of 10 Tablets","2000","0");
INSERT INTO tbl_medicine_details VALUES("3","6","Blister Pack of 10 Capsules","3000","0");
INSERT INTO tbl_medicine_details VALUES("4","5","1mL Single-Dose Vial, Box of 5 Vials","4999","0");
INSERT INTO tbl_medicine_details VALUES("5","4","1mL Ampoule, Box of 10 Ampoules","1020","0");
INSERT INTO tbl_medicine_details VALUES("6","3","Blister Pack of 30 Tablets","5002","0");
INSERT INTO tbl_medicine_details VALUES("7","8","90","126","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicines VALUES("1","Amoxicillin 250mg Capsules","A Broad-spectrum Antibiotic Used To Treat Bacterial Infections Such As Respiratory, Urinary, And Ear Infections.","Healthline Distributors","Antibiotics","2023-06-10","2025-06-10","Curemax Pharmaceuticals","Amoxicare","1","2024-12-05 05:30:57","0");
INSERT INTO tbl_medicines VALUES("2","Cetirizine  10mg Tablets","An Antihistamine Used To Relieve Allergy Symptoms Such As Sneezing, Runny Nose, And Itching.","Allergen-free Pharma","Antihistamines","2024-12-05","2024-12-05","MediPro Labs","AllerEase","1","2024-12-05 05:33:57","0");
INSERT INTO tbl_medicines VALUES("3","Folic Acid 5mg Tablets","A Vitamin Supplement Used During Pregnancy To Prevent Neural Tube Defects And Support Fetal Development.","Nutricare Pharma Supplies","Immunosuppressants","2024-12-05","2024-12-05","VitaWell Laboratories","PrenoCare","1","2024-12-05 05:36:52","0");
INSERT INTO tbl_medicines VALUES("4","Oxytocin 10 Iu/ml Injection","A Hormone Injection Used To Induce Labor, Control Postpartum Bleeding, And Manage Uterine Contractions During Childbirth.","Mothercare Medical Supplies","Vaccines","2024-12-05","2024-12-05","BioHormone Pharma","OxyFlow","1","2024-12-05 05:38:11","0");
INSERT INTO tbl_medicines VALUES("5","Rabies Vaccine (purified Vero Cell Vaccine) 1ml","A Vaccine Used For Pre- And Post-exposure Prophylaxis Of Rabies To Prevent Infection After Exposure To Rabies Virus.","Lifeshield Medical Distributors","Vaccines","2024-12-05","2024-12-05","SafeVax Biopharma","RabiShield","1","2024-12-05 05:39:32","0");
INSERT INTO tbl_medicines VALUES("6","Loperamide 2mg Capsules","An Anti-diarrheal Medication Used To Treat Sudden Diarrhea And To Reduce The Frequency Of Bowel Movements.","Healthmed Distributors","Antipsychotics","2024-12-05","2024-12-07","Medplus Pharmaceuticals","Diastop","1","2024-12-05 05:41:53","0");
INSERT INTO tbl_medicines VALUES("7","Wer","Wer23","Werwer","Analgesics","2024-12-06","2024-12-06","Werwerwer","Werfer","0","2024-12-06 02:48:55","0");
INSERT INTO tbl_medicines VALUES("8","Omeprazole","Acid","Red Cross","Antidiabetic Drugs","2024-12-05","2024-12-06","123fdsfsdf","Omeprazole","1","2024-12-06 02:55:43","0");
INSERT INTO tbl_medicines VALUES("9","Sample Med","Assddsadnasd","Sample","Antibiotics","2025-01-30","2024-10-07","Sample Company","sample","1","2024-12-06 18:03:42","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","Yes","35454334646","Member","","2024-12-05 05:42:21","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("2","No","","","NHTS","2024-12-05 05:59:58","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("3","Yes","123456789012","Member","LGU","2024-12-05 06:22:46","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("4","No","","","","2024-12-05 06:40:39","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("5","Yes","001111111110","Member","","2024-12-06 02:15:17","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("6","No","","","4PS","2024-12-06 02:31:11","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("7","No","","","4PS","2024-12-06 02:53:26","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("8","No","","","4PS","2024-12-06 03:13:22","","0");
INSERT INTO tbl_membership_info VALUES("9","No","","","Private","2024-12-06 17:28:05","","0");
INSERT INTO tbl_membership_info VALUES("10","No","","","Private","2024-12-06 17:56:46","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_medication_history VALUES("1","3","1","Oral(p/o)","1","as needed","","100","","Day","As needed lang","0");
INSERT INTO tbl_patient_medication_history VALUES("2","4","1","Oral(p/o)","10","as needed","","200","","","adsadsada","0");
INSERT INTO tbl_patient_medication_history VALUES("3","5","3","Oral(p/o)","50","as needed","","sda200","","","dsadas","0");
INSERT INTO tbl_patient_medication_history VALUES("4","7","8","Spray","2","schedule dose","At night","90","Hourly","2 (Day)","21323","0");
INSERT INTO tbl_patient_medication_history VALUES("5","8","8","Oral(p/o)","2","as needed","","50mg","","3 (Day)","fdsafffffff","0");
INSERT INTO tbl_patient_medication_history VALUES("6","9","8","Oral(p/o)","50","as needed","","50mg","","3 (Day)","fdsaaaaaaaaaaa","0");
INSERT INTO tbl_patient_medication_history VALUES("7","10","1","Oral(p/o)","2","as needed","","22","","2 (Day)","fdsaf","0");



DROP TABLE IF EXISTS tbl_patient_visits;

CREATE TABLE `tbl_patient_visits` (
  `patient_visitID` int(11) NOT NULL AUTO_INCREMENT,
  `visit_date` date DEFAULT NULL,
  `next_visit_date` date DEFAULT NULL,
  `disease` varchar(255) NOT NULL,
  `recom` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patient_visitID`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_visits VALUES("1","2024-12-05","0000-00-00","","","1","0","0");
INSERT INTO tbl_patient_visits VALUES("2","2024-12-05","0000-00-00","","","3","0","0");
INSERT INTO tbl_patient_visits VALUES("3","2024-12-06","2024-12-13","Migraine","Water Therapy, no radiation","5","15","0");
INSERT INTO tbl_patient_visits VALUES("4","2024-12-06","2024-12-06","Migraine","HAHAHAHAH","5","15","0");
INSERT INTO tbl_patient_visits VALUES("5","2024-12-06","2024-12-06","ddasda","sdasdas","6","17","0");
INSERT INTO tbl_patient_visits VALUES("6","2024-12-06","0000-00-00","","","6","0","0");
INSERT INTO tbl_patient_visits VALUES("7","2027-05-19","2024-12-06","ubo","asdasd","8","23","0");
INSERT INTO tbl_patient_visits VALUES("8","2024-12-06","2024-12-24","test","reafdsf","2","23","0");
INSERT INTO tbl_patient_visits VALUES("9","2024-12-06","2024-12-17","fdsa","fdsaaaaaaaa","1","15","0");
INSERT INTO tbl_patient_visits VALUES("10","2024-12-06","2024-12-16","fdsa","fdsaf","8","15","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","3832844","Mika","Diaz","Reyes","","","","0000000001","1998-07-10","26 years","09486984605","Female","Married","AB+","College Graduate","House Wife","Church of Jesus Christ of Latter-day Saints (LDS)","Filipino","2024-12-05","13","0000-00-00 00:00:00","0");
INSERT INTO tbl_patients VALUES("2","2","2","3832845","Erlinda","Antique","Lapus","","","","0000000002","2000-05-17","24 years","0965323232","Female","Single","A+","","","Roman Catholic","Filipino","2024-12-05","13","2024-12-05 06:03:42","0");
INSERT INTO tbl_patients VALUES("3","3","3","3832846","Juan","Cruz","Santos","Jr","Maria Santos","","0000000003","1990-12-05","34 years","09171234567","Male","Single","O+","College Graduate","Teacher","Islam","Filipino","2024-12-05","14","0000-00-00 00:00:00","0");
INSERT INTO tbl_patients VALUES("4","4","4","3832847","Mariebel","Lopez","Garcia","","Jo Garcia","","0000000004","1990-12-05","34 years","09181234567","Female","Married","A+","College Graduate","Business woman","Baptists","Filipino","2024-12-05","14","0000-00-00 00:00:00","0");
INSERT INTO tbl_patients VALUES("5","5","5","3832848","Regine Jesa","Jacob","Palara","","Hazel Joy Alvarez","","0000000005","2024-12-05","Newborn","09123456789","Female","Single","A+","Master\'s Degree","Teacher","Roman Catholic","Filipino","2024-12-06","14","2024-12-06 10:44:31","0");
INSERT INTO tbl_patients VALUES("6","6","6","3832849","Dsadasd","Sadsd","Sdasda","","ddadwad","","0000000006","2024-12-04","Newborn","09123456789","Female","Single","AB+","No Formal Education","Ewdadw","Methodists","Filipino","2024-12-06","14","2024-12-06 07:23:51","0");
INSERT INTO tbl_patients VALUES("7","7","7","3832850","Joel","Lozano","DOMINGO JR","Jr","JOEL LEZLEE L. DOMINGO JR","","0000000007","1996-12-06","28 years","909853303250","Male","Single","AB+","No Formal Education","","","Filipino","2024-12-06","19","0000-00-00 00:00:00","0");
INSERT INTO tbl_patients VALUES("8","8","8","3832851","Kim Jasper","o","venus","","","","0000000008","1996-12-06","28 years","909853303250","Male","Single","AB+","No Formal Education","a","Islam","Filipino","2024-12-06","20","","0");
INSERT INTO tbl_patients VALUES("9","9","9","3832852","Alison Renz","Agura","Quizon","","sample lang","","0000000009","2024-02-01","10 months old","12345678909898989898","Male","Single","O+","No Formal Education","Efewfewdfdfewe","Islam","Filipino","2024-12-06","14","2024-12-06 23:44:28","0");
INSERT INTO tbl_patients VALUES("10","10","10","3832853","Sample","Asdasdsad","Sadsadasd","Sadasdas","","","0000000010","1998-10-14","26 years","1234567890","Male","Single","O+","High School","Sdasdasdas","Islam","Filipino","2024-12-06","13","2024-12-06 23:41:52","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","Carlos","","Mendoza","09653231212","carlos.mendoza@example.com","","0");
INSERT INTO tbl_personnel VALUES("13","Juan","Dela Cruz","Santos","+639171534567","juansantos@example.com","123 Mabini Street, Barangay Maligaya, Quezon City, Metro Manila","0");
INSERT INTO tbl_personnel VALUES("14","Maria","Garcia","Reyes","+639281234567","mariar.reyes@example.com","456 Rizal Avenue, Barangay Bagong Lipunan, Cebu City, Cebu","0");
INSERT INTO tbl_personnel VALUES("15","Ricardox","V","Cruz","+639451234567","drcruz123@example.com","321 osmeña street, barangay san isidro, pasic city, metro manila","0");
INSERT INTO tbl_personnel VALUES("17","Karina","Ramos","Torres","+639562322656","katrinatorres_rn@example.com","654 quirino avenue,barangay santa rosa, iloilo city, iloilo","0");
INSERT INTO tbl_personnel VALUES("18","lilibeth","aquino","de guzman","+639562321547","lilibethdeguzman_mw@example.com","987 luna street, barangay balangay, cagayan de oro city, misamis oriental","0");
INSERT INTO tbl_personnel VALUES("19","Elizabeth","","Harmon","+631232131321","Elizabeth@yahoo","Davao City","0");
INSERT INTO tbl_personnel VALUES("20","Krai","L","Grievers","+639999999999","krai@gmail.com","Adsad","0");
INSERT INTO tbl_personnel VALUES("21","Kraiiii","L","Domingo Jr","+631234567834","joellezleejr@gmail.com","Agreda Subd. Koronadal City, South Cotabato","0");
INSERT INTO tbl_personnel VALUES("22","werty","werty","werty","+639354081494","wertywertywerty@gmail.com","wertywertywertywertywerty","0");
INSERT INTO tbl_personnel VALUES("24","Kirigaya","L","Kazuto","+63234567890_","kirigaya999@gmail.com","Agreda Subd. Koronadal City, South Cotabato","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_physicalexam VALUES("1","5","5","5","5","5","","[\"Rashes\",\"\"]","[\"Palpable Mass\",\"\"]","[\"symmtrical chest expansion\",\"\"]","[\"Adynamic Precordlum\",\"\"]","[\"Globular\",\"\"]","[\"Gross deformity\",\"\"]","2024-12-06 02:37:09","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","admin","","","","0");
INSERT INTO tbl_position VALUES("13","13","","","","","0");
INSERT INTO tbl_position VALUES("14","14","","","","","0");
INSERT INTO tbl_position VALUES("15","15","Doctor","Family doctor","M.D","095623245587","0");
INSERT INTO tbl_position VALUES("16","17","Nurse","Family doctor","M.D","095623245587","0");
INSERT INTO tbl_position VALUES("17","18","Midwife","Certifide Midwife","Certifide Midwife","","0");
INSERT INTO tbl_position VALUES("18","19","Physician","Neurology","Neurology","","0");
INSERT INTO tbl_position VALUES("19","20","","","","","0");
INSERT INTO tbl_position VALUES("20","21","","","","","0");
INSERT INTO tbl_position VALUES("21","22","Doctor","werty","werty","12351","0");
INSERT INTO tbl_position VALUES("23","24","Doctor","eat","sadsad","123456789","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_prenatal VALUES("1","2024-12-05","   ","18","04/15/2024","10 weeks 5 days"," 01/22/2025","140 bpm","10 weeks 3 days","01/20/2025","10 weeks 4 days","2.5 cm","10 weeks 5 days","9.8 cm","10 weeks 5 days","8.5 cm","10 weeks 5 days","2.3 cm","10 weeks 5 days","6.5 cm","10 weeks 5 days","3.5 cm","10 weeks 5 days","200 grams","Single","Cephalic","Normal","Posterior","Low Lying","1","limb","Normal Fetal Development For Gestational Age. Follow-up Ultrasound Recommended In 4 Weeks.","Dr. Maria Cruz","1","14","2024-12-05 06:26:17","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_referrals_log VALUES("1","2","2024-12-05","13","","0");
INSERT INTO tbl_referrals_log VALUES("2","5","2024-12-06","14","","0");
INSERT INTO tbl_referrals_log VALUES("3","6","2024-12-06","14","","0");
INSERT INTO tbl_referrals_log VALUES("4","8","2024-12-06","20","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_systemreview VALUES("1","[\"weight_loss_gain\"]","[\"lumps\"]","[\"Headache\"]","[\" Decrease hearing\"]","[\"Plain\"]","[\"Stuffiness\"]","[\"Teeth\"]","[]","[]","[]","[]","[]","[\"Change in bowel Habits\"]","[\"Pain during intercourse\"]","[]","[]","[]","[]","[\"Sweeting\"]","[\"Polyuria\"]","2024-12-06 02:37:09","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("1","0","Erlinda","2001:4456:1ea:aa","2024-12-05 05:06:49","","0","0");
INSERT INTO tbl_user_log VALUES("2","1","admin","2001:4456:1ea:aa","2024-12-05 05:07:11","05-12-2024 01:08:02 PM","1","0");
INSERT INTO tbl_user_log VALUES("3","8","Erlinda","2001:4456:1ea:aa","2024-12-05 05:07:36","2024-12-05 13:07:43","1","0");
INSERT INTO tbl_user_log VALUES("4","9","Baibai","2001:4456:1ea:aa","2024-12-05 05:07:48","2024-12-05 13:36:07","1","0");
INSERT INTO tbl_user_log VALUES("5","1","admin","2001:4456:1ea:aa","2024-12-05 05:10:38","05-12-2024 01:25:00 PM","1","0");
INSERT INTO tbl_user_log VALUES("6","14","mariar2024","158.62.75.222\0\0\0","2024-12-05 05:23:31","05-12-2024 01:26:44 PM","1","0");
INSERT INTO tbl_user_log VALUES("7","0","carlosmendoza88","2001:4456:1b9:ad","2024-12-05 05:25:19","","0","0");
INSERT INTO tbl_user_log VALUES("8","0","carlosmendoza88","2001:4456:1b9:ad","2024-12-05 05:25:57","","0","0");
INSERT INTO tbl_user_log VALUES("9","13","juansantos123","158.62.75.222\0\0\0","2024-12-05 05:27:10","05-12-2024 01:54:20 PM","1","0");
INSERT INTO tbl_user_log VALUES("10","1","carlosmendoza88","2001:4456:1b9:ad","2024-12-05 05:27:33","05-12-2024 01:27:34 PM","1","0");
INSERT INTO tbl_user_log VALUES("11","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-05 05:27:39","05-12-2024 01:35:36 PM","1","0");
INSERT INTO tbl_user_log VALUES("12","15","drcruz21","2001:4456:1ea:aa","2024-12-05 05:36:56","2024-12-05 15:32:16","1","0");
INSERT INTO tbl_user_log VALUES("13","14","mariar2024","158.62.75.222\0\0\0","2024-12-05 05:54:45","05-12-2024 01:55:55 PM","1","0");
INSERT INTO tbl_user_log VALUES("14","13","juansantos123","158.62.75.222\0\0\0","2024-12-05 05:56:23","2024-12-05 15:59:10","1","0");
INSERT INTO tbl_user_log VALUES("15","13","juansantos123","2001:4456:1ea:aa","2024-12-05 05:57:14","05-12-2024 02:02:39 PM","1","0");
INSERT INTO tbl_user_log VALUES("16","14","mariar2024","158.62.75.222\0\0\0","2024-12-05 06:02:53","","1","0");
INSERT INTO tbl_user_log VALUES("17","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-05 06:03:12","05-12-2024 05:02:27 PM","1","0");
INSERT INTO tbl_user_log VALUES("18","0","carlosmendoza88","2001:4456:1ea:aa","2024-12-05 06:05:53","","0","0");
INSERT INTO tbl_user_log VALUES("19","0","carlosmendoza88","2001:4456:1ea:aa","2024-12-05 06:06:04","","0","0");
INSERT INTO tbl_user_log VALUES("20","0","carlosmendoza88","2001:4456:1ea:aa","2024-12-05 06:06:11","","0","0");
INSERT INTO tbl_user_log VALUES("21","14","mariar2024","2001:4456:1b9:ad","2024-12-05 06:17:45","","1","0");
INSERT INTO tbl_user_log VALUES("22","15","drcruz21","2001:4456:1ea:aa","2024-12-05 07:32:23","2024-12-05 15:52:05","1","0");
INSERT INTO tbl_user_log VALUES("23","15","drcruz21","2001:4456:1ea:aa","2024-12-05 07:49:55","2024-12-05 15:52:05","1","0");
INSERT INTO tbl_user_log VALUES("24","15","drcruz21","2001:4456:1ea:aa","2024-12-05 07:52:33","2024-12-05 16:05:17","1","0");
INSERT INTO tbl_user_log VALUES("25","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 07:59:35","2024-12-05 16:05:17","1","0");
INSERT INTO tbl_user_log VALUES("26","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:04:47","2024-12-05 16:05:17","1","0");
INSERT INTO tbl_user_log VALUES("27","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:05:20","2024-12-05 16:06:02","1","0");
INSERT INTO tbl_user_log VALUES("28","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:06:05","2024-12-05 16:09:16","1","0");
INSERT INTO tbl_user_log VALUES("29","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:08:00","2024-12-05 16:09:16","1","0");
INSERT INTO tbl_user_log VALUES("30","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:10:17","2024-12-05 16:13:56","1","0");
INSERT INTO tbl_user_log VALUES("31","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:12:41","2024-12-05 16:13:56","1","0");
INSERT INTO tbl_user_log VALUES("32","0","drcruz21","2001:4456:1ea:aa","2024-12-05 08:14:26","","0","0");
INSERT INTO tbl_user_log VALUES("33","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:14:47","2024-12-05 16:15:13","1","0");
INSERT INTO tbl_user_log VALUES("34","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:15:19","2024-12-05 16:28:47","1","0");
INSERT INTO tbl_user_log VALUES("35","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:16:20","2024-12-05 16:28:47","1","0");
INSERT INTO tbl_user_log VALUES("36","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:24:24","2024-12-05 16:28:47","1","0");
INSERT INTO tbl_user_log VALUES("37","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:28:50","2024-12-05 16:29:20","1","0");
INSERT INTO tbl_user_log VALUES("38","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:29:23","2024-12-05 16:47:41","1","0");
INSERT INTO tbl_user_log VALUES("39","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:30:52","2024-12-05 16:47:41","1","0");
INSERT INTO tbl_user_log VALUES("40","0","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:36:13","","0","0");
INSERT INTO tbl_user_log VALUES("41","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:36:20","2024-12-05 16:47:41","1","0");
INSERT INTO tbl_user_log VALUES("42","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:48:06","2024-12-05 16:49:16","1","0");
INSERT INTO tbl_user_log VALUES("43","15","drcruz21","210.1.101.101\0\0\0","2024-12-05 08:51:47","2024-12-05 16:54:43","1","0");
INSERT INTO tbl_user_log VALUES("44","15","drcruz21","2001:4456:1ea:aa","2024-12-05 08:54:57","2024-12-05 18:15:56","1","0");
INSERT INTO tbl_user_log VALUES("45","15","drcruz21","110.54.202.27\0\0\0","2024-12-05 09:06:32","2024-12-05 18:15:56","1","0");
INSERT INTO tbl_user_log VALUES("46","15","drcruz21","175.176.93.9\0\0\0\0","2024-12-05 10:16:02","2024-12-05 20:20:51","1","0");
INSERT INTO tbl_user_log VALUES("47","0","carlosmendoza88","119.92.143.161\0\0","2024-12-06 02:09:40","","0","0");
INSERT INTO tbl_user_log VALUES("48","14","mariar2024","119.92.143.161\0\0","2024-12-06 02:10:57","","1","0");
INSERT INTO tbl_user_log VALUES("49","1","carlosmendoza88","131.226.112.98\0\0","2024-12-06 02:21:25","","1","0");
INSERT INTO tbl_user_log VALUES("50","1","carlosmendoza88","119.92.143.161\0\0","2024-12-06 02:21:42","","1","0");
INSERT INTO tbl_user_log VALUES("51","15","drcruz21","131.226.112.98\0\0","2024-12-06 02:26:07","2024-12-06 10:26:56","1","0");
INSERT INTO tbl_user_log VALUES("52","15","drcruz21","131.226.112.98\0\0","2024-12-06 02:27:04","2024-12-06 10:29:10","1","0");
INSERT INTO tbl_user_log VALUES("53","15","drcruz21","131.226.112.98\0\0","2024-12-06 02:29:22","","1","0");
INSERT INTO tbl_user_log VALUES("54","1","carlosmendoza88","119.92.143.161\0\0","2024-12-06 02:42:35","06-12-2024 10:52:43 AM","1","0");
INSERT INTO tbl_user_log VALUES("55","19","krai12345","119.92.143.161\0\0","2024-12-06 02:46:21","06-12-2024 10:47:16 AM","1","0");
INSERT INTO tbl_user_log VALUES("56","20","kraiiii12345","119.92.143.161\0\0","2024-12-06 02:48:16","06-12-2024 10:49:50 AM","1","0");
INSERT INTO tbl_user_log VALUES("57","19","krai12345","119.92.143.161\0\0","2024-12-06 02:50:03","06-12-2024 11:00:48 AM","1","0");
INSERT INTO tbl_user_log VALUES("58","1","carlosmendoza88","119.92.143.161\0\0","2024-12-06 02:55:30","","1","0");
INSERT INTO tbl_user_log VALUES("59","20","kraiiii12345","119.92.143.161\0\0","2024-12-06 03:00:52","06-12-2024 11:22:42 AM","1","0");
INSERT INTO tbl_user_log VALUES("60","14","mariar2024","119.92.143.161\0\0","2024-12-06 03:06:52","","1","0");
INSERT INTO tbl_user_log VALUES("61","","drcruz21","175.176.88.194\0\0","2024-12-06 03:12:02","","0","0");
INSERT INTO tbl_user_log VALUES("62","","drcruz21","175.176.88.194\0\0","2024-12-06 03:12:10","","0","0");
INSERT INTO tbl_user_log VALUES("63","15","drcruz21","175.176.88.194\0\0","2024-12-06 03:12:31","2024-12-06 12:06:09","1","0");
INSERT INTO tbl_user_log VALUES("64","","kirigaya999@gmail.com","119.92.143.161\0\0","2024-12-06 03:18:38","","0","0");
INSERT INTO tbl_user_log VALUES("65","","kirigaya999@gmail.com","119.92.143.161\0\0","2024-12-06 03:18:58","","0","0");
INSERT INTO tbl_user_log VALUES("66","23","Kirigaya999@gmail.com","119.92.143.161\0\0","2024-12-06 03:19:14","","1","0");
INSERT INTO tbl_user_log VALUES("67","19","krai12345","119.92.143.161\0\0","2024-12-06 03:23:14","06-12-2024 11:24:28 AM","1","0");
INSERT INTO tbl_user_log VALUES("68","","kraiiii12345","119.92.143.161\0\0","2024-12-06 03:24:31","","0","0");
INSERT INTO tbl_user_log VALUES("69","","kraiiii12345","119.92.143.161\0\0","2024-12-06 03:24:35","","0","0");
INSERT INTO tbl_user_log VALUES("70","19","krai12345","119.92.143.161\0\0","2024-12-06 03:24:45","","1","0");
INSERT INTO tbl_user_log VALUES("71","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-06 04:59:22","","1","0");
INSERT INTO tbl_user_log VALUES("72","14","mariar2024","2001:4456:1ea:aa","2024-12-06 05:00:57","06-12-2024 03:09:27 PM","1","0");
INSERT INTO tbl_user_log VALUES("73","15","drcruz21","2001:4456:1ea:aa","2024-12-06 05:47:03","2024-12-06 13:47:47","1","0");
INSERT INTO tbl_user_log VALUES("74","15","drcruz21","2001:4456:1ea:aa","2024-12-06 05:47:50","","1","0");
INSERT INTO tbl_user_log VALUES("75","","kraiiii12345","2001:4456:1ea:aa","2024-12-06 07:10:12","","0","0");
INSERT INTO tbl_user_log VALUES("76","","juansantos123","2001:4456:1ea:aa","2024-12-06 07:10:25","","0","0");
INSERT INTO tbl_user_log VALUES("77","13","juansantos123","2001:4456:1ea:aa","2024-12-06 07:11:00","06-12-2024 03:13:52 PM","1","0");
INSERT INTO tbl_user_log VALUES("78","14","mariar2024","2001:4456:1ea:aa","2024-12-06 07:14:15","06-12-2024 03:27:26 PM","1","0");
INSERT INTO tbl_user_log VALUES("79","","juansantos123","2001:4456:1ea:aa","2024-12-06 07:27:40","","0","0");
INSERT INTO tbl_user_log VALUES("80","","juansantos123","2001:4456:1ea:aa","2024-12-06 07:27:42","","0","0");
INSERT INTO tbl_user_log VALUES("81","","juansantos123","2001:4456:1ea:aa","2024-12-06 07:27:44","","0","0");
INSERT INTO tbl_user_log VALUES("82","","carlosmendoza88","2001:4456:1ea:aa","2024-12-06 07:29:27","","0","0");
INSERT INTO tbl_user_log VALUES("83","","carlosmendoza88","2001:4456:1ea:aa","2024-12-06 07:29:30","","0","0");
INSERT INTO tbl_user_log VALUES("84","","carlosmendoza88","2001:4456:1ea:aa","2024-12-06 07:29:32","","0","0");
INSERT INTO tbl_user_log VALUES("85","1","carlosmendoza88","175.176.93.9\0\0\0\0","2024-12-06 10:43:32","","1","0");
INSERT INTO tbl_user_log VALUES("86","14","mariar2024","158.62.79.251\0\0\0","2024-12-06 17:17:55","07-12-2024 01:34:20 AM","1","0");
INSERT INTO tbl_user_log VALUES("87","13","juansantos123","158.62.79.251\0\0\0","2024-12-06 17:34:45","07-12-2024 02:15:40 AM","1","0");
INSERT INTO tbl_user_log VALUES("88","1","carlosmendoza88","158.62.79.251\0\0\0","2024-12-06 17:58:54","","1","0");
INSERT INTO tbl_user_log VALUES("89","15","drcruz21","158.62.79.251\0\0\0","2024-12-06 18:14:09","","1","0");
INSERT INTO tbl_user_log VALUES("90","14","mariar2024","158.62.79.251\0\0\0","2024-12-06 18:15:43","07-12-2024 02:17:30 AM","1","0");
INSERT INTO tbl_user_log VALUES("91","13","juansantos123","158.62.79.251\0\0\0","2024-12-06 18:17:50","07-12-2024 02:19:21 AM","1","0");
INSERT INTO tbl_user_log VALUES("92","13","juansantos123","158.62.79.251\0\0\0","2024-12-06 18:19:23","07-12-2024 02:19:25 AM","1","0");
INSERT INTO tbl_user_log VALUES("93","14","mariar2024","158.62.79.251\0\0\0","2024-12-06 18:19:29","","1","0");
INSERT INTO tbl_user_log VALUES("94","1","carlosmendoza88","2001:4456:1ea:aa","2024-12-06 23:38:10","","1","0");



DROP TABLE IF EXISTS tbl_user_page;

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL AUTO_INCREMENT,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `headerColor` varchar(100) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`userpageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_users VALUES("1","carlosmendoza88","admin","$2y$10$VhB2s7wzLcs8R6sxV0ag4Oei3FoJ/ZXQSNaOBkTOPRqRzX/wRraEm","Active","user.jpg","1","1","0","2024-12-01 05:47:10","0","0000-00-00 00:00:00","0","2024-12-06 10:43:32","");
INSERT INTO tbl_users VALUES("13","juansantos123","BHW","$2y$10$0onCtpKMCBdS/Kegnrfw5.e5NMbRIP00NMhD4FihILZUGMOt0n1Be","Active","","13","13","0","2024-12-05 05:15:14","0","0000-00-00 00:00:00","0","2024-12-06 17:34:45","");
INSERT INTO tbl_users VALUES("14","mariar2024","RHU","$2y$10$MttBD06oR6R82MfGJdm6/uOf28.QHslsW83JUWk5RqHPs/Lekh4HK","Active","","14","14","0","2024-12-05 05:16:37","0","0000-00-00 00:00:00","0","2024-12-06 03:06:52","");
INSERT INTO tbl_users VALUES("15","drcruz21","Doctor","$2y$10$wTAQI.CGkOsHO8oQ.Vm6SOFRRqkCWWiRP2TkUriCJ822JKGHFyxRq","Active","../user_images/6752616aed945_profile_pic6843444080777802964.jpg","15","15","0","2024-12-05 05:18:43","0","0000-00-00 00:00:00","0","2024-12-06 03:12:31","");
INSERT INTO tbl_users VALUES("16","Nursekat.torres","Nurse","$2y$10$vIdwvesjWZq9RuEyGgyZFeZ4Od3XoyWOVhrvFHoRcLgwqVdzmdriO","Active","","17","16","0","2024-12-05 05:20:16","0","0000-00-00 00:00:00","0","2024-12-05 08:13:45","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("17","Midwifebeth.dgz","Midwife","","Active","","18","17","0","2024-12-05 05:22:47","0","0000-00-00 00:00:00","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("18","Leni","Physician","","Active","","19","18","0","2024-12-05 06:12:51","0","0000-00-00 00:00:00","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("19","krai12345","RHU","$2y$10$jI96ARM5TpoYrYVB6bDZVOMcbtAe6ANTjbLwnWhah.KzMLBkuu3hq","Active","cet.png","20","19","0","2024-12-06 02:45:47","0","0000-00-00 00:00:00","0","2024-12-06 03:23:14","");
INSERT INTO tbl_users VALUES("20","kraiiii12345","BHW","$2y$10$oWFnmJcURjztTc7yWqeao.0NCIPUS/Hp1P4/cXolzUfFdhupnkuL2","Active","449486198_926600769479325_2144451970134598149_n.jpg","21","20","0","2024-12-06 02:48:05","3","0000-00-00 00:00:00","0","2024-12-06 07:10:12","2024-12-06 15:13:12");
INSERT INTO tbl_users VALUES("21","Werty","Doctor","$2y$10$iQFHeRL.acvn3UlJANKzgeJ7JMGiTwoGLH5Vzgaj7DAF40.eYORAq","Active","386745.jpg","22","21","0","2024-12-06 02:50:41","0","0000-00-00 00:00:00","0","0000-00-00 00:00:00","0000-00-00 00:00:00");
INSERT INTO tbl_users VALUES("23","Kirigaya999@gmail.com","Doctor","$2y$10$LgCpVMZaSZ5sGiv6xlPhgeHv7KLJ/6cocsrHd59cRJTyugJuBMPaa","inactive","cet.png","24","23","","2024-12-06 03:05:55","0","","0","2024-12-06 18:09:01","");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_vitalsigns_monitoring VALUES("1","123","2024-12-06","10:39:00","12","12","12","12","12","12","12","12","16","6","1","2024-12-06 02:39:29","0");



