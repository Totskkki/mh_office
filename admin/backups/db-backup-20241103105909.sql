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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_care VALUES("1","7","20241021001","2024-10-21","[\"Fully Immunized\",\"Diabetes Mellitus\",\"Anti-Rabies\",\"On Meds\",\"Allergy\",\"Drug\",\"Hypertension\",\"On Meds\",\"Food\"]","-","January","2024","fdsafsadfs","2024-10-21","palabillafdsa","[\"Non-bite\",\"Spontaneous\"]","2024-10-14","Vaccinated","Died","fdsaffff","yes","yes","yes","yes","yes","yes","2024-10-21","TT","II","fdsa","fsda","8","ongoing");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_vaccination VALUES("1","3","2024-10-21","2024-10-23","1","fdsa","7","1","1","1");
INSERT INTO tbl_animal_bite_vaccination VALUES("2","3","2024-10-23","2024-10-25","1","","7","0","2","1");



DROP TABLE IF EXISTS tbl_announcements;

CREATE TABLE `tbl_announcements` (
  `announceID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`announceID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_announcements VALUES("4","2024-10-30","Covid vaccination day","Covid vaccination day on November 5, 2024","2024-09-14 08:10:45","2024-10-22 15:09:27");
INSERT INTO tbl_announcements VALUES("5","2024-10-29","fa","fa","2024-10-27 07:26:32","2024-10-27 07:26:32");
INSERT INTO tbl_announcements VALUES("6","2024-11-07","fsafd","fdsa","2024-10-27 07:26:38","2024-10-27 07:26:38");
INSERT INTO tbl_announcements VALUES("7","2024-11-02","fsafs","fsdaf","2024-10-27 07:26:44","2024-10-27 07:26:44");
INSERT INTO tbl_announcements VALUES("8","2024-11-14","fsafsa","fsa","2024-10-27 07:26:51","2024-10-27 07:26:51");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_log VALUES("1","1","UPDATE","tbl_announcements","4","{\"date\":\"2024-09-26\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}","{\"date\":\"2024-10-14\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}","2024-10-12 15:42:07");
INSERT INTO tbl_audit_log VALUES("2","1","DELETE","tbl_announcements","3","{\"announceID\":3,\"date\":\"2024-09-20\",\"title\":\"test\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:47:28\",\"updated_at\":\"2024-09-14 07:47:28\"}","","2024-10-12 15:54:52");
INSERT INTO tbl_audit_log VALUES("3","1","DELETE","tbl_announcements","2","{\"announceID\":2,\"date\":\"2024-09-20\",\"title\":\"covid\",\"details\":\"test\",\"created_at\":\"2024-09-14 07:46:19\",\"updated_at\":\"2024-09-14 07:46:19\"}","","2024-10-12 15:54:54");
INSERT INTO tbl_audit_log VALUES("4","1","UPDATE","tbl_announcements","4","{\"date\":\"2024-10-14\",\"title\":\"fdsafa\",\"details\":\"fdsafsda\"}","{\"date\":\"2024-10-14\",\"title\":\"Covid vaccination day\",\"details\":\"Covid vaccination day on November 5, 2024\"}","2024-10-12 15:55:20");
INSERT INTO tbl_audit_log VALUES("5","1","added","tbl_medicine_details","3","","{\"medicine_id\":\"6\",\"packing\":\"injectable\",\"qt\":\"19\"}","2024-10-16 13:33:21");
INSERT INTO tbl_audit_log VALUES("6","1","added","tbl_medicine_details","4","","{\"medicine_id\":\"1\",\"packing\":\"injectable\",\"qt\":\"100\"}","2024-10-16 13:36:47");



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
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_audit_trail VALUES("1","1","Update Events","Updated Events Covid vaccination day Covid vaccination day on November 5, 2024","tbl_announcements","4","2024-10-14 07:24:50","::1");
INSERT INTO tbl_audit_trail VALUES("2","7","Insert","Added patient: Irene basco","tbl_patients","8","2024-10-15 16:25:36","::1");
INSERT INTO tbl_audit_trail VALUES("3","7","Insert","Added patient: Fdsaf fdsa","tbl_patients","9","2024-10-18 09:50:56","::1");
INSERT INTO tbl_audit_trail VALUES("4","7","Insert","Added patient: Fdsafasd fdsafd","tbl_patients","10","2024-10-18 15:37:02","::1");
INSERT INTO tbl_audit_trail VALUES("5","1","Update Events","Updated Events Covid vaccination day Covid vaccination day on November 5, 2024","tbl_announcements","4","2024-10-21 10:18:37","::1");
INSERT INTO tbl_audit_trail VALUES("6","1","Update Patient Record","Updated  Unknown","tbl_patients","","2024-10-21 10:22:23","::1");
INSERT INTO tbl_audit_trail VALUES("7","1","Update Patient Record","Updated  Rolly Beans Anderson","tbl_patients","10","2024-10-21 10:24:19","::1");
INSERT INTO tbl_audit_trail VALUES("8","1","Update Patient Record","Updated Patient Record Rolly Beans v Anderson","tbl_patients","10","2024-10-21 10:27:00","::1");
INSERT INTO tbl_audit_trail VALUES("9","1","Update Events","Updated Events Covid vaccination day Covid vaccination day on November 5, 2024","tbl_announcements","4","2024-10-22 15:09:27","::1");
INSERT INTO tbl_audit_trail VALUES("10","1","Update Schedule","Updated the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 09:54:27","::1");
INSERT INTO tbl_audit_trail VALUES("11","1","Add Schedule","Added a schedule for Doctor  joven  joven","tbl_doctor_schedule","3","2024-10-23 09:59:10","::1");
INSERT INTO tbl_audit_trail VALUES("12","1","Update Schedule","Updated the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 10:00:58","::1");
INSERT INTO tbl_audit_trail VALUES("13","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-23 11:25:17","::1");
INSERT INTO tbl_audit_trail VALUES("14","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","5","2024-10-23 11:33:07","::1");
INSERT INTO tbl_audit_trail VALUES("15","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 11:36:12","::1");
INSERT INTO tbl_audit_trail VALUES("16","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","2","2024-10-23 11:38:23","::1");
INSERT INTO tbl_audit_trail VALUES("17","1","Add Schedule","Added a schedule for Doctor  Joven  Joven","tbl_doctor_schedule","3","2024-10-23 11:53:24","::1");
INSERT INTO tbl_audit_trail VALUES("18","1","Add Schedule","Added a schedule for Doctor  Joven  Joven","tbl_doctor_schedule","4","2024-10-23 11:53:50","::1");
INSERT INTO tbl_audit_trail VALUES("19","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","4","2024-10-23 11:54:03","::1");
INSERT INTO tbl_audit_trail VALUES("20","1","Add Schedule","Added a schedule for Doctor  Joven  Joven","tbl_doctor_schedule","5","2024-10-23 11:54:16","::1");
INSERT INTO tbl_audit_trail VALUES("21","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 12:46:22","::1");
INSERT INTO tbl_audit_trail VALUES("22","1","Update Schedule","Updated the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 13:10:23","::1");
INSERT INTO tbl_audit_trail VALUES("23","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-23 13:10:30","::1");
INSERT INTO tbl_audit_trail VALUES("24","1","Add Schedule","Added a schedule for Doctor  Joven  Joven","tbl_doctor_schedule","2","2024-10-23 13:11:13","::1");
INSERT INTO tbl_audit_trail VALUES("25","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","3","2024-10-23 14:04:53","::1");
INSERT INTO tbl_audit_trail VALUES("26","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-23 14:07:48","::1");
INSERT INTO tbl_audit_trail VALUES("27","1","Add Schedule","Added a schedule for Doctor  Ben Test Manatad","tbl_doctor_schedule","4","2024-10-23 14:08:50","::1");
INSERT INTO tbl_audit_trail VALUES("28","1","Update Events","Updated Events Covid vaccination day Covid vaccination day on November 5, 2024","tbl_announcements","4","2024-10-27 07:20:50","::1");
INSERT INTO tbl_audit_trail VALUES("29","1","Add Events","Added Events  fa fa","tbl_announcements","5","2024-10-27 07:26:32","::1");
INSERT INTO tbl_audit_trail VALUES("30","1","Add Events","Added Events  fsafd fdsa","tbl_announcements","6","2024-10-27 07:26:38","::1");
INSERT INTO tbl_audit_trail VALUES("31","1","Add Events","Added Events  fsafs fsdaf","tbl_announcements","7","2024-10-27 07:26:44","::1");
INSERT INTO tbl_audit_trail VALUES("32","1","Add Events","Added Events  fsafsa fsa","tbl_announcements","8","2024-10-27 07:26:52","::1");
INSERT INTO tbl_audit_trail VALUES("33","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-27 16:44:45","::1");
INSERT INTO tbl_audit_trail VALUES("34","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-27 16:46:14","::1");
INSERT INTO tbl_audit_trail VALUES("35","1","Add Schedule","Added a schedule for Doctor  Unknown","tbl_doctor_schedule","0","2024-10-27 16:55:42","::1");
INSERT INTO tbl_audit_trail VALUES("36","1","Add Schedule","Added a schedule for Doctor  Unknown","tbl_doctor_schedule","0","2024-10-27 16:55:58","::1");
INSERT INTO tbl_audit_trail VALUES("37","1","Add Schedule","Added a schedule for Doctor  Unknown","tbl_doctor_schedule","0","2024-10-27 16:57:24","::1");
INSERT INTO tbl_audit_trail VALUES("38","1","Add Schedule","Added a schedule for Doctor  Unknown","tbl_doctor_schedule","0","2024-10-27 17:09:18","::1");
INSERT INTO tbl_audit_trail VALUES("39","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-27 17:20:39","::1");
INSERT INTO tbl_audit_trail VALUES("40","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","2","2024-10-27 17:21:43","::1");
INSERT INTO tbl_audit_trail VALUES("41","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-27 17:24:59","::1");
INSERT INTO tbl_audit_trail VALUES("42","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-27 17:25:22","::1");
INSERT INTO tbl_audit_trail VALUES("43","1","Add Schedule","Added a schedule for Doctor Unknown","tbl_doctor_schedule","3","2024-10-27 17:26:32","::1");
INSERT INTO tbl_audit_trail VALUES("44","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-27 17:28:40","::1");
INSERT INTO tbl_audit_trail VALUES("45","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-27 17:29:33","::1");
INSERT INTO tbl_audit_trail VALUES("46","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-27 17:41:34","::1");
INSERT INTO tbl_audit_trail VALUES("47","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-27 17:53:31","::1");
INSERT INTO tbl_audit_trail VALUES("48","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","3","2024-10-27 21:09:48","::1");
INSERT INTO tbl_audit_trail VALUES("50","1","Delete Schedule","Deleted the schedule for Doctor admin M. admin","tbl_doctor_schedule","2","2024-10-28 19:09:11","::1");
INSERT INTO tbl_audit_trail VALUES("55","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 19:25:11","::1");
INSERT INTO tbl_audit_trail VALUES("56","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","3","2024-10-28 19:27:35","::1");
INSERT INTO tbl_audit_trail VALUES("57","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","3","2024-10-28 19:30:05","::1");
INSERT INTO tbl_audit_trail VALUES("58","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","4","2024-10-28 19:30:52","::1");
INSERT INTO tbl_audit_trail VALUES("59","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","5","2024-10-28 19:34:06","::1");
INSERT INTO tbl_audit_trail VALUES("60","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","5","2024-10-28 19:34:14","::1");
INSERT INTO tbl_audit_trail VALUES("61","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","4","2024-10-28 19:34:36","::1");
INSERT INTO tbl_audit_trail VALUES("62","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-28 19:37:14","::1");
INSERT INTO tbl_audit_trail VALUES("63","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 19:37:15","::1");
INSERT INTO tbl_audit_trail VALUES("64","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-28 19:37:46","::1");
INSERT INTO tbl_audit_trail VALUES("65","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-28 19:40:32","::1");
INSERT INTO tbl_audit_trail VALUES("66","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 19:42:55","::1");
INSERT INTO tbl_audit_trail VALUES("67","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-28 19:46:45","::1");
INSERT INTO tbl_audit_trail VALUES("68","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 19:48:44","::1");
INSERT INTO tbl_audit_trail VALUES("69","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-28 19:48:51","::1");
INSERT INTO tbl_audit_trail VALUES("70","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","4","2024-10-28 19:49:06","::1");
INSERT INTO tbl_audit_trail VALUES("71","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-28 19:50:26","::1");
INSERT INTO tbl_audit_trail VALUES("72","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","5","2024-10-28 19:52:13","::1");
INSERT INTO tbl_audit_trail VALUES("73","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","5","2024-10-28 19:55:02","::1");
INSERT INTO tbl_audit_trail VALUES("74","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","6","2024-10-28 19:55:13","::1");
INSERT INTO tbl_audit_trail VALUES("75","1","Add Schedule","Added a schedule for Doctor Joven  Joven on MONDAY","tbl_doctor_schedule","7","2024-10-28 19:55:40","::1");
INSERT INTO tbl_audit_trail VALUES("76","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","7","2024-10-28 20:03:28","::1");
INSERT INTO tbl_audit_trail VALUES("77","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-28 20:03:30","::1");
INSERT INTO tbl_audit_trail VALUES("78","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on TUESDAY","tbl_doctor_schedule","8","2024-10-28 20:03:48","::1");
INSERT INTO tbl_audit_trail VALUES("79","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-28 20:04:33","::1");
INSERT INTO tbl_audit_trail VALUES("80","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","9","2024-10-28 20:04:46","::1");
INSERT INTO tbl_audit_trail VALUES("81","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on MONDAY","tbl_doctor_schedule","1","2024-10-28 20:05:38","::1");
INSERT INTO tbl_audit_trail VALUES("82","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-28 20:07:41","::1");
INSERT INTO tbl_audit_trail VALUES("83","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","2","2024-10-28 20:09:10","::1");
INSERT INTO tbl_audit_trail VALUES("84","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on MONDAY","tbl_doctor_schedule","3","2024-10-28 20:09:10","::1");
INSERT INTO tbl_audit_trail VALUES("85","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","4","2024-10-28 20:10:21","::1");
INSERT INTO tbl_audit_trail VALUES("86","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on MONDAY","tbl_doctor_schedule","5","2024-10-28 20:10:21","::1");
INSERT INTO tbl_audit_trail VALUES("87","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","1","2024-10-28 20:14:21","::1");
INSERT INTO tbl_audit_trail VALUES("88","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on MONDAY","tbl_doctor_schedule","2","2024-10-28 20:14:21","::1");
INSERT INTO tbl_audit_trail VALUES("89","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on SUNDAY","tbl_doctor_schedule","3","2024-10-28 20:25:24","::1");
INSERT INTO tbl_audit_trail VALUES("90","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on MONDAY","tbl_doctor_schedule","4","2024-10-28 20:25:47","::1");
INSERT INTO tbl_audit_trail VALUES("91","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad on TUESDAY","tbl_doctor_schedule","5","2024-10-28 20:25:47","::1");
INSERT INTO tbl_audit_trail VALUES("92","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","2","2024-10-28 20:30:39","::1");
INSERT INTO tbl_audit_trail VALUES("93","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-28 20:31:56","::1");
INSERT INTO tbl_audit_trail VALUES("94","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:32:23","::1");
INSERT INTO tbl_audit_trail VALUES("95","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:32:58","::1");
INSERT INTO tbl_audit_trail VALUES("96","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:33:10","::1");
INSERT INTO tbl_audit_trail VALUES("97","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:50:01","::1");
INSERT INTO tbl_audit_trail VALUES("98","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:51:00","::1");
INSERT INTO tbl_audit_trail VALUES("99","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 20:53:22","::1");
INSERT INTO tbl_audit_trail VALUES("100","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 21:16:52","::1");
INSERT INTO tbl_audit_trail VALUES("101","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 21:17:17","::1");
INSERT INTO tbl_audit_trail VALUES("102","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 21:18:33","::1");
INSERT INTO tbl_audit_trail VALUES("103","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","0","2024-10-28 21:24:31","::1");
INSERT INTO tbl_audit_trail VALUES("104","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","0","2024-10-28 21:24:41","::1");
INSERT INTO tbl_audit_trail VALUES("105","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 21:25:26","::1");
INSERT INTO tbl_audit_trail VALUES("106","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-28 21:30:45","::1");
INSERT INTO tbl_audit_trail VALUES("107","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-28 21:30:48","::1");
INSERT INTO tbl_audit_trail VALUES("108","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","3","2024-10-28 21:31:00","::1");
INSERT INTO tbl_audit_trail VALUES("109","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","3","2024-10-28 21:37:01","::1");
INSERT INTO tbl_audit_trail VALUES("110","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-28 21:37:55","::1");
INSERT INTO tbl_audit_trail VALUES("111","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-28 21:38:35","::1");
INSERT INTO tbl_audit_trail VALUES("112","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","5","2024-10-28 21:39:06","::1");
INSERT INTO tbl_audit_trail VALUES("113","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","5","2024-10-28 22:04:59","::1");
INSERT INTO tbl_audit_trail VALUES("114","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-28 22:05:23","::1");
INSERT INTO tbl_audit_trail VALUES("115","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","6","2024-10-29 06:46:32","::1");
INSERT INTO tbl_audit_trail VALUES("116","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-29 06:46:53","::1");
INSERT INTO tbl_audit_trail VALUES("117","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-29 06:48:35","::1");
INSERT INTO tbl_audit_trail VALUES("118","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-29 06:49:01","::1");
INSERT INTO tbl_audit_trail VALUES("119","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","9","2024-10-29 07:26:08","::1");
INSERT INTO tbl_audit_trail VALUES("120","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","9","2024-10-29 07:26:13","::1");
INSERT INTO tbl_audit_trail VALUES("121","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-29 07:26:15","::1");
INSERT INTO tbl_audit_trail VALUES("122","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","10","2024-10-29 07:26:22","::1");
INSERT INTO tbl_audit_trail VALUES("123","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","10","2024-10-29 07:37:59","::1");
INSERT INTO tbl_audit_trail VALUES("124","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","11","2024-10-29 07:38:41","::1");
INSERT INTO tbl_audit_trail VALUES("125","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","11","2024-10-29 17:35:46","::1");
INSERT INTO tbl_audit_trail VALUES("126","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","12","2024-10-29 17:44:00","::1");
INSERT INTO tbl_audit_trail VALUES("127","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","12","2024-10-29 17:45:20","::1");
INSERT INTO tbl_audit_trail VALUES("128","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","13","2024-10-29 17:45:29","::1");
INSERT INTO tbl_audit_trail VALUES("129","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","14","2024-10-29 17:45:30","::1");
INSERT INTO tbl_audit_trail VALUES("130","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","15","2024-10-29 17:46:08","::1");
INSERT INTO tbl_audit_trail VALUES("131","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","16","2024-10-29 17:46:25","::1");
INSERT INTO tbl_audit_trail VALUES("132","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","16","2024-10-29 17:53:31","::1");
INSERT INTO tbl_audit_trail VALUES("133","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","15","2024-10-29 17:53:33","::1");
INSERT INTO tbl_audit_trail VALUES("134","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","14","2024-10-29 17:53:35","::1");
INSERT INTO tbl_audit_trail VALUES("135","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","13","2024-10-29 17:53:37","::1");
INSERT INTO tbl_audit_trail VALUES("136","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","17","2024-10-29 17:53:54","::1");
INSERT INTO tbl_audit_trail VALUES("137","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","18","2024-10-29 17:53:55","::1");
INSERT INTO tbl_audit_trail VALUES("138","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","19","2024-10-29 18:02:41","::1");
INSERT INTO tbl_audit_trail VALUES("139","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","20","2024-10-29 18:03:27","::1");
INSERT INTO tbl_audit_trail VALUES("140","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","21","2024-10-29 18:03:49","::1");
INSERT INTO tbl_audit_trail VALUES("141","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","22","2024-10-29 18:04:34","::1");
INSERT INTO tbl_audit_trail VALUES("142","1","Add Schedule","Added a schedule for Doctor Unknown","tbl_doctor_schedule","0","2024-10-29 18:55:37","::1");
INSERT INTO tbl_audit_trail VALUES("143","1","Add Schedule","Added a schedule for Doctor Unknown","tbl_doctor_schedule","0","2024-10-29 18:55:37","::1");
INSERT INTO tbl_audit_trail VALUES("144","1","Add Schedule","Added a schedule for Doctor Unknown","tbl_doctor_schedule","0","2024-10-29 18:56:33","::1");
INSERT INTO tbl_audit_trail VALUES("145","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","1","2024-10-29 19:00:17","::1");
INSERT INTO tbl_audit_trail VALUES("146","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-29 19:01:04","::1");
INSERT INTO tbl_audit_trail VALUES("147","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-29 19:01:41","::1");
INSERT INTO tbl_audit_trail VALUES("148","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-29 19:01:43","::1");
INSERT INTO tbl_audit_trail VALUES("149","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-29 19:01:45","::1");
INSERT INTO tbl_audit_trail VALUES("150","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","5","2024-10-29 19:02:00","::1");
INSERT INTO tbl_audit_trail VALUES("151","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-29 19:02:59","::1");
INSERT INTO tbl_audit_trail VALUES("152","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-29 19:26:04","::1");
INSERT INTO tbl_audit_trail VALUES("153","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-29 19:26:17","::1");
INSERT INTO tbl_audit_trail VALUES("154","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-29 19:26:55","::1");
INSERT INTO tbl_audit_trail VALUES("155","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-29 20:07:21","::1");
INSERT INTO tbl_audit_trail VALUES("156","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-29 20:07:24","::1");
INSERT INTO tbl_audit_trail VALUES("157","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-29 20:08:09","::1");
INSERT INTO tbl_audit_trail VALUES("158","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","1","2024-10-29 20:28:52","::1");
INSERT INTO tbl_audit_trail VALUES("159","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-29 20:29:00","::1");
INSERT INTO tbl_audit_trail VALUES("160","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","2","2024-10-29 20:45:08","::1");
INSERT INTO tbl_audit_trail VALUES("161","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-29 20:45:22","::1");
INSERT INTO tbl_audit_trail VALUES("162","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","3","2024-10-29 21:05:14","::1");
INSERT INTO tbl_audit_trail VALUES("163","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-29 21:05:54","::1");
INSERT INTO tbl_audit_trail VALUES("164","1","Add Schedule","Added a schedule for Doctor Joven  Joven","tbl_doctor_schedule","5","2024-10-29 21:20:48","::1");
INSERT INTO tbl_audit_trail VALUES("165","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","6","2024-10-29 21:39:35","::1");
INSERT INTO tbl_audit_trail VALUES("166","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","4","2024-10-29 21:46:26","::1");
INSERT INTO tbl_audit_trail VALUES("167","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","5","2024-10-29 21:56:13","::1");
INSERT INTO tbl_audit_trail VALUES("168","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","6","2024-10-29 21:56:15","::1");
INSERT INTO tbl_audit_trail VALUES("169","1","Add Schedule","Added a schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-29 21:56:45","::1");
INSERT INTO tbl_audit_trail VALUES("170","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","7","2024-10-30 18:10:44","::1");
INSERT INTO tbl_audit_trail VALUES("171","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","8","2024-10-30 18:27:14","::1");
INSERT INTO tbl_audit_trail VALUES("172","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","9","2024-10-30 18:32:31","::1");
INSERT INTO tbl_audit_trail VALUES("173","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","10","2024-10-30 18:46:59","::1");
INSERT INTO tbl_audit_trail VALUES("174","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","11","2024-10-30 19:04:10","::1");
INSERT INTO tbl_audit_trail VALUES("175","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","12","2024-10-30 20:49:38","::1");
INSERT INTO tbl_audit_trail VALUES("176","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","13","2024-10-30 20:55:05","::1");
INSERT INTO tbl_audit_trail VALUES("177","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","14","2024-10-30 20:58:58","::1");
INSERT INTO tbl_audit_trail VALUES("178","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","15","2024-10-30 21:34:15","::1");
INSERT INTO tbl_audit_trail VALUES("179","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","16","2024-10-30 21:39:48","::1");
INSERT INTO tbl_audit_trail VALUES("180","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","17","2024-10-30 21:43:50","::1");
INSERT INTO tbl_audit_trail VALUES("181","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","18","2024-10-30 21:58:09","::1");
INSERT INTO tbl_audit_trail VALUES("182","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","19","2024-10-31 06:20:11","::1");
INSERT INTO tbl_audit_trail VALUES("183","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","20","2024-10-31 06:24:04","::1");
INSERT INTO tbl_audit_trail VALUES("184","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","21","2024-10-31 06:27:31","::1");
INSERT INTO tbl_audit_trail VALUES("185","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","22","2024-10-31 06:29:46","::1");
INSERT INTO tbl_audit_trail VALUES("186","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","23","2024-10-31 06:33:07","::1");
INSERT INTO tbl_audit_trail VALUES("187","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","24","2024-10-31 06:37:37","::1");
INSERT INTO tbl_audit_trail VALUES("188","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","25","2024-10-31 06:42:17","::1");
INSERT INTO tbl_audit_trail VALUES("189","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","26","2024-10-31 06:54:23","::1");
INSERT INTO tbl_audit_trail VALUES("190","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","27","2024-10-31 07:00:40","::1");
INSERT INTO tbl_audit_trail VALUES("191","1","Delete Schedule","Deleted the schedule for Doctor Ben Test Manatad","tbl_doctor_schedule","28","2024-10-31 07:03:40","::1");
INSERT INTO tbl_audit_trail VALUES("192","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","29","2024-10-31 07:12:58","::1");
INSERT INTO tbl_audit_trail VALUES("193","1","Delete Schedule","Deleted the schedule for Doctor Joven  Joven","tbl_doctor_schedule","30","2024-10-31 07:17:19","::1");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birth_info VALUES("1","8","20241017001","2024-10-17","fd","fds","fds","{\"g\":\"fds\",\"p\":\"fds\",\"term\":\"fds\",\"preterm\":\"fd\",\"abortion\":\"fd\",\"living\":\"fd\"}","fdsaf","[\"Heart Disease\",\"\"]","","","","[\"Hypertension\",\"\"]","{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}","{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}","{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"fds\",\"illness\":\"fds\",\"tot_visit\":\"fds\",\"others\":\"\"}","[{\"year\":\"fsd\",\"place_of_confinement\":\"fds\",\"aog\":\"fds\",\"bw\":\"fd\",\"manner_of_delivery\":\"sfds\",\"complication_remarks\":\"fds\"}]","7","1","1","31","done","2024-10-17");
INSERT INTO tbl_birth_info VALUES("2","6","20241018001","2024-10-18","2","2","2","{\"g\":\"2\",\"p\":\"2\",\"term\":\"2\",\"preterm\":\"2\",\"abortion\":\"2\",\"living\":\"22\"}","fdsa","[\"Pulmonary TB\",\"\"]","fdsa","fdsa","fdsa","[\"Hypertension\",\"\"]","{\"smoking\":\"Yes\"}","{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}","{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"\",\"illness\":\"\",\"tot_visit\":\"\",\"others\":\"\"}","[{\"year\":\"12\",\"place_of_confinement\":\"21\",\"aog\":\"12\",\"bw\":\"2\",\"manner_of_delivery\":\"2\",\"complication_remarks\":\"2\"}]","7","2","2","31","ongoing","2024-10-18");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birth_ivfluids VALUES("1","8","2024-10-17","16:27:00","16:27:00","1","fdsa","fsda","1","2024-10-17 16:27:18");
INSERT INTO tbl_birth_ivfluids VALUES("2","6","2024-10-18","08:52:00","08:52:00","2","fdsa","fsda","2","2024-10-18 08:53:01");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthing_medication VALUES("1","8","2024-10-17","2","fsda","fsda","16:26:00","2024-10-17","sample1","fsda","fdsa","1","2024-10-17 16:26:55");
INSERT INTO tbl_birthing_medication VALUES("2","8","2024-10-17","2","fdsa","fdsa","17:27:00","2024-10-17","fdsafsa","fsda","fdsa","1","2024-10-17 16:27:09");
INSERT INTO tbl_birthing_medication VALUES("3","6","2024-10-18","2","10","2 X A DAY","20:53:00","2024-10-18","dfsad","fdassssssssssss","fdsaf","2","2024-10-18 08:53:29");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthing_monitoring VALUES("1","1","20241017001","8","fdsfds","2024-10-17","16:25:00","16:25:00","16:25:00","16:25:00","16:25:00","16:25","Yes","fds","16:25:00","Livebirth","Yes","4kg","Yes","fsd","fdsa","ACTIVE LABOUR","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","fdsafd","fdsa","fdsa","fdsa","fdsa","2024-10-17 16:26:04");
INSERT INTO tbl_birthing_monitoring VALUES("2","2","20241017001","6","fdsa","2024-10-03","05:00:00","19:00:00","15:00:00","08:00:00","20:08:00","04:29","Yes","122","08:00:00","Livebirth","Yes","ffffff","Yes","no","1123","NOT IN ACTIVE LABOUR","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","[\"11\"]","FDSAFDFFFFFF","12DSAD","DADA12","12DA","12DSA","2024-10-18 08:08:41");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthroom VALUES("1","8","2024-10-18","fsda","fdsa","fsda","fsd","","","{\"labor\":{\"types\":[\"Spontaneous\"],\"time\":\"08:51\",\"date\":\"08\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"cervix\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"baby\":{\"time\":\"20:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"placenta\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}}}","{\"placenta\":{\"expelled\":[\"Expelled Completely\"]},\"umbilicalCord\":{\"cm\":\"21\",\"loops\":\"2\",\"none\":\"None\"},\"other\":\"2\",\"bloodLoss\":{\"antepartum\":\"2\",\"intrapartum\":\"2\",\"postpartum\":\"2\",\"total\":\"2\"}}","[\"Cesarean\",\"\"]","[]","[]","[]","[]","[]","[\"\"]","[]","","","","fsda","fdsa","31","1","2024-10-17 12:28:09");
INSERT INTO tbl_birthroom VALUES("2","6","2024-10-03","1","1","1","","","","{\"labor\":{\"types\":[\"Spontaneous\"],\"time\":\"08:51\",\"date\":\"08\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"cervix\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"baby\":{\"time\":\"20:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"placenta\":{\"time\":\"08:51\",\"date\":\"18\\/10\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}}}","{\"placenta\":{\"expelled\":[\"Retained for Method of Expulsion\"]},\"umbilicalCord\":{\"cm\":\"1\",\"loops\":\"1\",\"none\":\"None\"},\"other\":\"1\",\"bloodLoss\":{\"antepartum\":\"1\",\"intrapartum\":\"1\",\"postpartum\":\"1\",\"total\":\"1\"}}","[\"Cesarean\",\"\"]","[\"Median\"]","[\"Perinial 1 2 3\"]","[\"Local Infiltration\"]","[\"Yes\"]","[\"Reactive\"]","[\"Voided\",\"1\"]","[\"Relaxing\"]","None","None","None","1","1","31","2","2024-10-18 08:52:04");



DROP TABLE IF EXISTS tbl_certificate_log;

CREATE TABLE `tbl_certificate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `generated_at` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_certificate_log VALUES("2","5","2024-09-23 18:48:40","done","D:\\xampp\\htdocs\\MH_Office_final\\RHU/certificates/5_2024-09-23.pdf");
INSERT INTO tbl_certificate_log VALUES("3","1","2024-09-23 18:49:25","done","D:\\xampp\\htdocs\\MH_Office_final\\RHU/certificates/1_2024-09-23.pdf");
INSERT INTO tbl_certificate_log VALUES("4","8","2024-10-18 15:57:29","done","D:\\xampp\\htdocs\\MH_Office\\RHU/certificates/8_2024-10-18.pdf");
INSERT INTO tbl_certificate_log VALUES("5","7","2024-10-18 16:02:21","done","D:\\xampp\\htdocs\\MH_Office\\RHU/certificates/7_2024-10-18.pdf");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_clinicalrecords VALUES("1","8","fdsa","fdsafsdafa","","2024-10-17","16:25:00","2024-10-15","16:29:00","new","Angel  Lobrido","roel cabigas","national highway DSWD","fdsa","sfda","fdsa","improved","1","2024-10-16 16:29:37");
INSERT INTO tbl_clinicalrecords VALUES("2","6","1","AFDSAFSDAF","","2024-10-03","05:00:00","2024-10-17","10:50:00","old","Angel  Lobrido","FSA","FDSA","FDSA","FDSA","FDSAF","unimproved","2","2024-10-18 10:50:45");
INSERT INTO tbl_clinicalrecords VALUES("3","8","1232","fdsafsdafa","0965321546","2024-10-17","16:25:00","2024-10-15","16:29:00","new","Angel  Lobrido","roel cabigas","national highway DSWD","fdsa","sfda","fdsa","improved","1","2024-10-17 16:29:37");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("1","8","","","122 / 90","2","2kg","20","2°C","2cm","Follow-up visit","Birthing","fdsa","sda","Done","2","","","2024-10-17");
INSERT INTO tbl_complaints VALUES("2","6","","","122 / 80_","22","2kg","21","2°C","2cm","Follow-up visit","Birthing","fdsa","fdsa","Under Monitoring","02","","","2024-10-18");
INSERT INTO tbl_complaints VALUES("3","7","fdsa","fdsa","122 / 80_","12","2kg","22","35°C","12cm","Follow-up visit","Animal bite and Care","fdsa","fsda","for vaccination","2","","","2024-10-21");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_discharged VALUES("5","5","1","fda","2024-10-06","[\"fdsa\",\"fdsa\",\"fas\"]","2024-10-06","31","38","2024-10-06 11:11:18");
INSERT INTO tbl_discharged VALUES("7","5","2","fdsa","2024-10-02","[\"REW\",\"fdsa\"]","2024-10-12","31","38","2024-10-06 11:33:52");
INSERT INTO tbl_discharged VALUES("8","8","6","fdsa","2024-10-15","[\"fsadfsda\",\"fdsaf\"]","2024-10-15","31","38","2024-10-15 16:42:54");
INSERT INTO tbl_discharged VALUES("9","6","4","fdsafsdaf","2024-10-17","[\"fsdaffds\"]","2024-10-23","31","38","2024-10-17 15:55:04");
INSERT INTO tbl_discharged VALUES("10","8","1","fdsafdsa","2024-10-17","[\"ffdsafd\",\"fdsafd\",\"fdsafd\"]","2024-10-23","31","38","2024-10-17 16:30:12");



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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("31","39","","","","","1","","Weekly","{\"SUNDAY\":[{\"fromtime\":\"07:17\",\"totime\":\"08:17\",\"worklength\":\"1h 0m\"},{\"fromtime\":\"08:17\",\"totime\":\"09:17\",\"worklength\":\"1h 0m\"}],\"MONDAY\":[{\"fromtime\":\"07:18\",\"totime\":\"10:18\",\"worklength\":\"3h 0m\"},{\"fromtime\":\"10:18\",\"totime\":\"11:18\",\"worklength\":\"1h 0m\"}],\"TUESDAY\":[{\"fromtime\":\"10:47\",\"totime\":\"11:47\",\"worklength\":\"1h 0m\"}]}","2024-10-31 07:17:27");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","test","Father","+639123131231","PUROK RIVERSIDE,BRGY.SANTO NINO(BO.2)KORONADAL CITY SOUTH COTABATO","10","2024-10-18 15:41:16");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyaddress VALUES("1","Sampao","Magsaysay","Lutayan","Sultan Kudarat","sultan kudarat","2024-09-09 10:02:11","");
INSERT INTO tbl_familyaddress VALUES("3","Bayasong","Riverside","City Of Koronadal (Capital)","South Cotabato","LAMBA, BANGA","2024-09-13 08:08:05","2024-10-14 07:28:22");
INSERT INTO tbl_familyaddress VALUES("4","Blingkong","Masagana","	 Lutayan","South Cotabato","	\nLutayan","2024-09-13 11:19:29","2024-10-16 13:52:18");
INSERT INTO tbl_familyaddress VALUES("5","Punol","Lacia Residence","Lutayan","Sultan Kudarat","LAMBA","2024-09-13 11:31:32","");
INSERT INTO tbl_familyaddress VALUES("6","Sampao","","Lutayan","Sultan Kudarat","hfggh","2024-09-14 13:18:45","");
INSERT INTO tbl_familyaddress VALUES("7","Mamali","Pag Asa","Lutayan","Sultan Kudarat","pag asa","2024-09-17 14:09:14","");
INSERT INTO tbl_familyaddress VALUES("8","Bayasong","Riverside","Lutayan","Sultan Kudarat","sultan kudarat","2024-10-15 16:25:36","2024-10-15 16:34:58");
INSERT INTO tbl_familyaddress VALUES("9","Manili","Fdsa","Lutayan","Sultan Kudarat","fdsa","2024-10-18 09:50:56","");
INSERT INTO tbl_familyaddress VALUES("10","Bayasong","Fsda","Lutayan","Sultan Kudarat","fdsa","2024-10-18 15:37:01","2024-10-21 10:15:35");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_healthnotes VALUES("1","8","29","2024-10-17","16:29:00","fdsaffffffff","","1","2024-10-17 16:29:11");
INSERT INTO tbl_healthnotes VALUES("2","8","29","2024-10-17","04:29:00","fdsafdaf","","1","2024-10-17 16:29:11");
INSERT INTO tbl_healthnotes VALUES("3","8","29","2024-10-17","04:29:00","","fdsafdaf","1","2024-10-17 16:29:11");
INSERT INTO tbl_healthnotes VALUES("4","6","29","2024-10-18","08:06:00","fdsaffffff","","2","2024-10-18 08:06:34");
INSERT INTO tbl_healthnotes VALUES("5","6","29","2024-10-07","08:06:00","fdsafdfffff","","2","2024-10-18 08:06:34");
INSERT INTO tbl_healthnotes VALUES("6","6","0","2024-10-16","08:06:00","","fdsafsd","2","2024-10-18 08:06:49");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_laboratory VALUES("1","Complete Blood Count (CBC)","2024-09-09","fsa","1","","2024-09-09 10:59:08");
INSERT INTO tbl_laboratory VALUES("2","Urinalysis","2024-09-13","hardware.PNG","3","","2024-09-13 11:16:13");
INSERT INTO tbl_laboratory VALUES("3","Sputum Examination","2024-09-13","","3","","2024-09-13 11:16:32");
INSERT INTO tbl_laboratory VALUES("4","Complete Blood Count (CBC)","2024-10-01","positive","10","Patients-PNG-HD.png","2024-10-18 15:54:36");



DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","2","mg","438");
INSERT INTO tbl_medicine_details VALUES("2","3","injectable","295");
INSERT INTO tbl_medicine_details VALUES("3","6","injectable","19");
INSERT INTO tbl_medicine_details VALUES("4","1","injectable","100");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicines VALUES("1","Polio","Poliomyelitis, Commonly Shortened To Polio, Is An Infectious Disease Caused By The Poliovirus. Approximately 75% Of Cases Are Asymptomatic","Test","Vaccines","2024-09-12","2027-03-05","test","branded","2024-09-12 15:14:39");
INSERT INTO tbl_medicines VALUES("2","Bio-flu","Test","Cefdinir","Antibiotics","2024-09-12","2027-04-21","Cefdinir","Cefdinir","2024-09-13 15:31:31");
INSERT INTO tbl_medicines VALUES("3","Anti-rabies","Anti-rabies","Anti-rabies","Vaccines","2024-09-22","2024-09-22","Anti-Rabies","Anti-Rabies","2024-09-22 11:21:12");
INSERT INTO tbl_medicines VALUES("4","Bcg Vaccine","Bcg Vaccine","Bcg Vaccine","Vaccines","2024-10-16","2027-02-04","BCG Vaccine","BCG Vaccine","2024-10-16 13:30:08");
INSERT INTO tbl_medicines VALUES("5","Hepatitis B Vaccine","Hepatitis B Vaccine","Hepatitis B Vaccine","Vaccines","2024-10-01","2026-09-17","Hepatitis B Vaccine","Hepatitis B Vaccine","2024-10-16 13:30:30");
INSERT INTO tbl_medicines VALUES("6","Pentavalent Vaccine","Pentavalent Vaccine","Pentavalent Vaccine","Vaccines","2024-10-16","2029-02-01","Pentavalent Vaccine","Pentavalent Vaccine","2024-10-16 13:30:50");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","Yes","062469896512","Member","4PS","2024-09-11 00:00:00","2024-10-08 11:14:52");
INSERT INTO tbl_membership_info VALUES("3","Yes","123123123123","Member","LGU","2024-09-13 08:08:05","2024-10-14 07:28:22");
INSERT INTO tbl_membership_info VALUES("4","No","","","NHTS","2024-09-13 11:19:29","2024-10-16 13:52:19");
INSERT INTO tbl_membership_info VALUES("5","Yes","123112312312","Dependent","4PS","2024-09-13 11:31:32","");
INSERT INTO tbl_membership_info VALUES("6","Yes","123123121222","Dependent","4PS","2024-09-14 13:18:45","");
INSERT INTO tbl_membership_info VALUES("7","No","","","4PS","2024-09-17 14:09:14","2024-09-26 17:44:48");
INSERT INTO tbl_membership_info VALUES("8","Yes","123333333333","Member","4PS","2024-10-15 16:25:36","2024-10-15 16:34:58");
INSERT INTO tbl_membership_info VALUES("9","No","","","LGU","2024-10-18 09:50:56","2024-10-21 10:16:03");
INSERT INTO tbl_membership_info VALUES("10","No","","","LGU","2024-10-18 15:37:02","2024-10-21 10:27:00");



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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patient_medication_history VALUES("1","1","2","Oral(p/o)","3","as needed","","500 mg","Every 4 hours","3 (Day)","test");
INSERT INTO tbl_patient_medication_history VALUES("2","2","2","Oral(p/o)","1","schedule dose","After Meal","11 mg","Daily","2 (Day)","test");
INSERT INTO tbl_patient_medication_history VALUES("4","4","2","Oral(p/o)","2","as needed","","100 mg","Daily","1 (Day)","fdsa");
INSERT INTO tbl_patient_medication_history VALUES("5","5","2","Oral(p/o)","10","as needed","","1-00 mg","Every 3 hours","3 (Day)","test");
INSERT INTO tbl_patient_medication_history VALUES("6","6","2","Oral(p/o)","10","as needed","","500 MG","Every 4 hours","2 (Day)","FDSA");
INSERT INTO tbl_patient_medication_history VALUES("7","7","2","Oral(p/o)","10","as needed","","100 mg","Hourly","3 (Day)","fdsafa");



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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patient_visits VALUES("1","2024-09-13","2024-09-18","cough","test","3","29");
INSERT INTO tbl_patient_visits VALUES("2","2024-09-13","2024-09-25","none","able to work","3","31");
INSERT INTO tbl_patient_visits VALUES("4","2024-09-14","2024-09-18","cough","fdsa","4","29");
INSERT INTO tbl_patient_visits VALUES("5","2024-09-14","2024-09-17","fever","test","4","29");
INSERT INTO tbl_patient_visits VALUES("6","2024-09-14","2024-09-24","cough","FDSA","6","29");
INSERT INTO tbl_patient_visits VALUES("7","2024-09-17","2024-09-24","cough","test","7","29");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","1399077","Ronaldo","","Teere","","Alexa","Pablito","0000000001","2024-09-02","0 Months","+63096778195","Male","Married","A+","No Formal Education","Patient","Islam","Filipino","2024-09-09 10:02:11","7","2024-10-08 11:14:52");
INSERT INTO tbl_patients VALUES("3","3","3","1399078","Joven Rey","","Flores","","Eleonora","Pablito","0000000002","2024-10-14","31 Years","+630967781950","Male","Married","A+","College Level","Radio Operator","Baptists","Filipino","2024-09-13 08:08:05","7","2024-10-14 07:28:22");
INSERT INTO tbl_patients VALUES("4","4","4","1399079","George","B","laput","","Fdsa","Fdsafd","0000000004","2024-09-04","0 Months","9999999999","Other","Married","A-","No Formal Education","Fdsaf","Islam","Filipino","2024-09-13 11:19:29","8","2024-10-16 13:52:19");
INSERT INTO tbl_patients VALUES("5","5","5","1399080","Lorena","ALCANTARA","LACIA","","alexa","pablito","0000000005","1999-04-20","25 years","+639677819501","Female","Single","A-","Elementary","none","Roman Catholic","Filipino","2024-09-13 11:31:32","7","");
INSERT INTO tbl_patients VALUES("6","6","6","1399081","Josh","b","garcia","","danna","pedro","0000000006","1993-02-04","31 years","+639999999999","Female","Single","B+","College Level","test","Roman Catholic","Filipino","2024-09-14 13:18:45","37","2024-10-09 10:45:50");
INSERT INTO tbl_patients VALUES("7","7","7","1399082","Irlan","","Badio","","Fds","Affdsa","0000000007","1999-02-10","25 Years","+630967781950","Male","Single","A-","","","","Filipino","2024-09-17 14:09:14","8","2024-09-26 17:44:48");
INSERT INTO tbl_patients VALUES("8","8","8","1399083","Irene","B","Basco","","Danna","Roberta","0000000008","1985-02-10","35 Years","+639531167141","Female","Single","A-","Elementary","","","Filipino","2024-10-15 16:25:36","7","2024-10-18 09:56:19");
INSERT INTO tbl_patients VALUES("9","9","9","1399084","Marcelo","","panopio","","Fdsa","Fdsa","0000000009","2024-10-21","0 Months","+630999999999","Other","Single","A+","","Dfsafd","Kingdom of Jesus Christ, The Name Above Every Name(KOJIC)","Asian","2024-10-18 09:50:56","7","2024-10-21 10:16:03");
INSERT INTO tbl_patients VALUES("10","10","10","1399085","Rolly Beans","v","Anderson","","Fdsa","Fdsa","0000000010","2024-10-21","0 Months","+630999999999","Other","Single","A-","","Dfsafd","Islam","Filipino","2024-10-18 15:37:02","7","2024-10-21 10:27:00");



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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","Admin","M.","Admin","+634744477477","admin@gmail.com","+639645563132");
INSERT INTO tbl_personnel VALUES("7","Rhu","R","Rhu","+639623564556","rhulutayan@gmail.com","+631232131321");
INSERT INTO tbl_personnel VALUES("8","Elleen","","Tunguia","+634744477477","elleen@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("34","Ben","Test","Manatad","+639665123213","test@gmail.com","Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato");
INSERT INTO tbl_personnel VALUES("36","Angel","","Lobrido","+639665123213","angel@GMAIL.COM","koronadal city , south cotabato");
INSERT INTO tbl_personnel VALUES("41","Joven Rey","","Flores","+630967781950","floresjovenrey26@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("42","Test","V","Test","+630967781950","test26@gmail.com","Koronadal City , South Cotabato");
INSERT INTO tbl_personnel VALUES("43","Carlos","","Basco","+639123123123","carlo@gmail.com","koronadal city , south cotabato");
INSERT INTO tbl_personnel VALUES("44","Joven","","Joven","+639665123213","joven@gmail.com","Blk. 4 Andres Bonifacio St, Poblacion, Koronadal City, South Cotabato");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_physicalexam VALUES("1","dfs","fsd","fds","fdfd","fd","fds","[\"Nodules\",\"\"]","[\"anicteric sclerea\",\"Exudates\",\"\"]","[\"\"]","[\"Normal rate regular rhythm\",\"\"]","[\"Muscle Guarding\",\"\"]","[\"Full and equal pulses\",\"\"]","2024-10-17 16:25:16");
INSERT INTO tbl_physicalexam VALUES("2","fsd","fdsa","fsda","fdas","fdsa","fdsa","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"Palpable Mass \",\"\"]","[\"\"]","2024-10-18 08:06:13");



DROP TABLE IF EXISTS tbl_position;

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `personnel_id` int(11) NOT NULL,
  `PositionName` varchar(100) NOT NULL,
  `Specialty` varchar(100) NOT NULL,
  `ProfessionalType` varchar(100) NOT NULL,
  `LicenseNo` varchar(255) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","","","","");
INSERT INTO tbl_position VALUES("7","7","","","","");
INSERT INTO tbl_position VALUES("8","8","","","","");
INSERT INTO tbl_position VALUES("34","34","Family physician","Family physician","MD, FPSMS","09523215");
INSERT INTO tbl_position VALUES("36","36","midwife","birhting","midwife","");
INSERT INTO tbl_position VALUES("41","41","","","","");
INSERT INTO tbl_position VALUES("42","42","","","","");
INSERT INTO tbl_position VALUES("43","43","Physician","Physician","Physician","");
INSERT INTO tbl_position VALUES("44","44","Physician","Physician","MD, FPSMS","1231312321");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_postpartum VALUES("1","8","2024-10-18","{\"date\":\"2024-10-17\",\"time\":\"16:31\",\"monitoring\":{\"every5_15\":{\"times\":[\"\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}","1. CONSCIOUS","","","","","1. EXCLUSIVE BREASTFEEDING","1. FULL BLADDER","","Yes","1. Proper Nutrition","1","2024-10-17 16:28:46");
INSERT INTO tbl_postpartum VALUES("2","6","2024-10-30","{\"date\":\"2024-10-30\",\"time\":\"06:22\",\"monitoring\":{\"every5_15\":{\"times\":[\"18:22\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}","","","","","","1. EXCLUSIVE BREASTFEEDING","","","","","2","2024-10-30 18:22:23");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_prenatal VALUES("1","2024-09-20","  22 ","38","qweq","e","ewq","ewq","qwe","qwe","qew","","","","","","","","","","","","","","","","","","","","","Ewqeq","Totski","6","7");
INSERT INTO tbl_prenatal VALUES("2","2024-10-16","  Fdsa ","38","13","12","2","23","32","32","23","123","1","12","1","1","1","1","1","1","1","1","1","1","Single","Cephalic","Normal","Fundus","Low Lying","0","limb","Fdsa","1212","6","7");



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
INSERT INTO tbl_referrals_log VALUES("12","5","2024-09-20","7","");
INSERT INTO tbl_referrals_log VALUES("13","7","2024-09-23","7","");
INSERT INTO tbl_referrals_log VALUES("14","6","2024-10-09","7","");
INSERT INTO tbl_referrals_log VALUES("15","7","2024-10-14","7","");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_systemreview VALUES("1","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-10-17 16:25:16");
INSERT INTO tbl_systemreview VALUES("2","[]","[]","[]","[]","[]","[\"Stuffiness\"]","[\"Dentures\"]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-10-18 08:06:13");



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
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("0","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 18:43:45","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("1","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 10:04:21","22-10-2024 03:06:35 PM","1");
INSERT INTO tbl_user_log VALUES("2","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 15:06:48","22-10-2024 03:08:10 PM","1");
INSERT INTO tbl_user_log VALUES("3","37","test","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 15:08:16","22-10-2024 03:08:28 PM","1");
INSERT INTO tbl_user_log VALUES("4","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 15:08:43","22-10-2024 03:10:23 PM","1");
INSERT INTO tbl_user_log VALUES("5","29","1","192.168.1.2\0\0\0\0\0","2024-10-22 16:26:59","2024-10-22 10:44:24","0");
INSERT INTO tbl_user_log VALUES("6","29","1","192.168.1.2\0\0\0\0\0","2024-10-22 16:41:43","2024-10-22 10:44:24","0");
INSERT INTO tbl_user_log VALUES("7","29","1","192.168.1.2\0\0\0\0\0","2024-10-22 16:44:18","2024-10-22 10:44:24","0");
INSERT INTO tbl_user_log VALUES("8","29","1","192.168.1.2\0\0\0\0\0","2024-10-22 16:44:34","2024-10-22 10:44:42","0");
INSERT INTO tbl_user_log VALUES("9","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 16:46:41","2024-10-22 10:48:11","0");
INSERT INTO tbl_user_log VALUES("10","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 16:49:49","2024-10-22 10:50:47","0");
INSERT INTO tbl_user_log VALUES("11","","1","192.168.1.2\0\0\0\0\0","2024-10-22 16:53:09","","0");
INSERT INTO tbl_user_log VALUES("12","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 16:53:22","2024-10-22 10:53:59","1");
INSERT INTO tbl_user_log VALUES("13","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 16:54:23","22-10-2024 04:54:39 PM","1");
INSERT INTO tbl_user_log VALUES("14","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 16:55:53","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("15","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:05:01","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("16","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:11:16","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("17","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:15:07","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("18","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:18:53","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("19","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:19:51","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("20","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-22 17:20:16","2024-10-22 11:20:19","1");
INSERT INTO tbl_user_log VALUES("21","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 07:47:57","","1");
INSERT INTO tbl_user_log VALUES("22","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:05:37","2024-10-23 02:09:46","1");
INSERT INTO tbl_user_log VALUES("23","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:06:27","2024-10-23 02:09:46","1");
INSERT INTO tbl_user_log VALUES("24","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:07:52","2024-10-23 02:09:46","1");
INSERT INTO tbl_user_log VALUES("25","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:08:34","2024-10-23 02:09:46","1");
INSERT INTO tbl_user_log VALUES("26","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:09:39","2024-10-23 02:09:46","1");
INSERT INTO tbl_user_log VALUES("27","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:13:24","2024-10-23 02:18:49","1");
INSERT INTO tbl_user_log VALUES("28","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:17:39","2024-10-23 02:18:49","1");
INSERT INTO tbl_user_log VALUES("29","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:19:23","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("30","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:20:42","","1");
INSERT INTO tbl_user_log VALUES("31","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:35:16","","0");
INSERT INTO tbl_user_log VALUES("32","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:35:21","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("33","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:47:29","","0");
INSERT INTO tbl_user_log VALUES("34","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:47:33","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("35","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:47:38","","0");
INSERT INTO tbl_user_log VALUES("36","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:47:52","","0");
INSERT INTO tbl_user_log VALUES("37","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:48:00","","0");
INSERT INTO tbl_user_log VALUES("38","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:48:04","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("39","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:48:07","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("40","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:48:10","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("41","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:49:48","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("42","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:49:52","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("43","","1","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 08:50:31","","0");
INSERT INTO tbl_user_log VALUES("44","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:50:50","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("45","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:51:41","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("46","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:52:13","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("47","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:52:17","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("48","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:53:22","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("49","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:54:13","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("50","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:55:19","2024-10-23 02:55:28","1");
INSERT INTO tbl_user_log VALUES("51","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:56:17","2024-10-23 02:56:25","1");
INSERT INTO tbl_user_log VALUES("52","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 08:58:54","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("53","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:01:23","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("54","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:30:42","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("55","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:33:20","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("56","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:36:53","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("57","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:39:04","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("58","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:39:39","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("59","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:52:09","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("60","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:57:08","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("61","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:57:19","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("62","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 09:59:17","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("63","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:01:10","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("64","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:04:13","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("65","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:09:41","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("66","","Joven123","127.0.0.1\0\0\0\0\0\0\0","2024-10-23 10:13:58","","0");
INSERT INTO tbl_user_log VALUES("67","39","Joven123","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:14:30","","1");
INSERT INTO tbl_user_log VALUES("68","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:43:10","2024-10-23 04:45:08","1");
INSERT INTO tbl_user_log VALUES("69","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 10:54:56","2024-10-23 05:02:09","1");
INSERT INTO tbl_user_log VALUES("70","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:02:00","2024-10-23 05:02:09","1");
INSERT INTO tbl_user_log VALUES("71","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:06:26","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("72","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:15:54","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("73","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:16:45","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("74","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:17:27","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("75","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:18:02","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("76","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:23:17","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("77","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 11:56:24","2024-10-23 05:56:35","1");
INSERT INTO tbl_user_log VALUES("78","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:11:25","2024-10-23 07:23:09","1");
INSERT INTO tbl_user_log VALUES("79","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:13:30","2024-10-23 07:23:09","1");
INSERT INTO tbl_user_log VALUES("80","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:23:12","2024-10-23 07:23:15","1");
INSERT INTO tbl_user_log VALUES("81","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:23:26","2024-10-23 07:25:58","1");
INSERT INTO tbl_user_log VALUES("82","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:25:54","2024-10-23 07:25:58","1");
INSERT INTO tbl_user_log VALUES("83","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:27:56","2024-10-23 07:28:00","1");
INSERT INTO tbl_user_log VALUES("84","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:28:27","2024-10-23 07:29:44","1");
INSERT INTO tbl_user_log VALUES("85","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:29:39","2024-10-23 07:29:44","1");
INSERT INTO tbl_user_log VALUES("86","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:34:34","2024-10-23 07:36:20","1");
INSERT INTO tbl_user_log VALUES("87","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:36:12","2024-10-23 07:36:20","1");
INSERT INTO tbl_user_log VALUES("88","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:40:01","2024-10-23 07:40:18","1");
INSERT INTO tbl_user_log VALUES("89","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:41:34","2024-10-23 07:52:48","1");
INSERT INTO tbl_user_log VALUES("90","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:47:32","2024-10-23 07:52:48","1");
INSERT INTO tbl_user_log VALUES("91","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:49:11","2024-10-23 07:52:48","1");
INSERT INTO tbl_user_log VALUES("92","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:51:08","2024-10-23 07:52:48","1");
INSERT INTO tbl_user_log VALUES("93","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:52:36","2024-10-23 07:52:48","1");
INSERT INTO tbl_user_log VALUES("94","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:54:34","2024-10-23 08:00:35","1");
INSERT INTO tbl_user_log VALUES("95","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:57:52","2024-10-23 08:00:35","1");
INSERT INTO tbl_user_log VALUES("96","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 13:58:38","2024-10-23 08:00:35","1");
INSERT INTO tbl_user_log VALUES("97","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:00:10","2024-10-23 08:00:35","1");
INSERT INTO tbl_user_log VALUES("98","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:02:18","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("99","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:02:48","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("100","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:04:01","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("101","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:05:02","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("102","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:05:29","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("103","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:07:55","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("104","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:08:58","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("105","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 14:12:14","2024-10-23 08:12:25","1");
INSERT INTO tbl_user_log VALUES("106","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 17:07:02","2024-10-23 11:16:58","1");
INSERT INTO tbl_user_log VALUES("107","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 17:16:55","2024-10-23 11:16:58","1");
INSERT INTO tbl_user_log VALUES("108","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 17:17:07","2024-10-23 11:17:12","1");
INSERT INTO tbl_user_log VALUES("109","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 18:48:25","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("110","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 18:53:42","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("111","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 18:59:48","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("112","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 19:10:11","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("113","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 19:23:55","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("114","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-23 19:25:50","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("115","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 20:20:47","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("116","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 20:23:56","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("117","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 20:24:13","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("118","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 20:36:47","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("119","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 21:00:04","2024-10-24 15:00:15","1");
INSERT INTO tbl_user_log VALUES("120","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 21:08:22","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("121","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 21:11:06","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("122","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 21:13:24","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("123","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-24 21:14:08","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("124","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-25 12:14:19","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("125","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:08:50","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("126","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:18:17","2024-10-27 01:19:17","1");
INSERT INTO tbl_user_log VALUES("127","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:19:32","","1");
INSERT INTO tbl_user_log VALUES("128","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:19:55","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("129","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:21:32","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("130","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:21:57","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("131","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:24:23","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("132","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:25:35","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("133","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:27:07","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("134","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:33:49","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("135","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:34:38","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("136","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:52:16","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("137","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:57:25","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("138","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 07:58:52","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("139","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 08:02:21","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("140","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 08:39:47","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("141","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 12:19:44","27-10-2024 12:27:26 PM","1");
INSERT INTO tbl_user_log VALUES("142","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 12:27:35","","1");
INSERT INTO tbl_user_log VALUES("143","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 12:29:26","27-10-2024 02:46:57 PM","1");
INSERT INTO tbl_user_log VALUES("144","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 14:47:03","","1");
INSERT INTO tbl_user_log VALUES("145","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-27 20:11:31","27-10-2024 10:07:20 PM","1");
INSERT INTO tbl_user_log VALUES("146","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-28 07:03:43","","1");
INSERT INTO tbl_user_log VALUES("147","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-28 17:55:15","28-10-2024 07:10:20 PM","1");
INSERT INTO tbl_user_log VALUES("148","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-28 19:10:24","28-10-2024 09:05:51 PM","1");
INSERT INTO tbl_user_log VALUES("149","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-28 21:05:56","28-10-2024 09:23:14 PM","1");
INSERT INTO tbl_user_log VALUES("150","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-28 21:23:25","","1");
INSERT INTO tbl_user_log VALUES("151","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 06:38:37","29-10-2024 07:09:30 AM","1");
INSERT INTO tbl_user_log VALUES("152","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 07:09:34","29-10-2024 07:23:50 AM","1");
INSERT INTO tbl_user_log VALUES("153","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 07:23:53","","1");
INSERT INTO tbl_user_log VALUES("154","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 07:33:36","","1");
INSERT INTO tbl_user_log VALUES("155","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 17:29:19","","1");
INSERT INTO tbl_user_log VALUES("156","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 17:32:05","29-10-2024 05:32:10 PM","1");
INSERT INTO tbl_user_log VALUES("157","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 17:32:16","","1");
INSERT INTO tbl_user_log VALUES("158","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 17:32:21","29-10-2024 09:53:00 PM","1");
INSERT INTO tbl_user_log VALUES("159","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-29 21:55:46","","1");
INSERT INTO tbl_user_log VALUES("160","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-30 18:09:28","","1");
INSERT INTO tbl_user_log VALUES("161","7","RHU","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-30 18:21:35","","1");
INSERT INTO tbl_user_log VALUES("162","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-30 20:35:11","","1");
INSERT INTO tbl_user_log VALUES("163","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-30 21:33:11","","1");
INSERT INTO tbl_user_log VALUES("164","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 06:15:09","31-10-2024 07:23:39 AM","1");
INSERT INTO tbl_user_log VALUES("165","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 18:20:49","","1");
INSERT INTO tbl_user_log VALUES("166","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 18:29:23","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("167","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 18:32:39","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("168","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 18:33:32","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("169","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 20:27:44","2024-10-31 13:28:34","1");
INSERT INTO tbl_user_log VALUES("170","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 20:28:41","2024-10-31 13:29:11","1");
INSERT INTO tbl_user_log VALUES("171","29","1","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-10-31 20:33:57","2024-10-31 13:34:29","1");
INSERT INTO tbl_user_log VALUES("172","1","admin","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-11-03 10:22:49","","1");



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
  `profile_picture` varchar(255) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_users VALUES("1","admin","admin","$2y$10$xiqYBaDz.Dfh1riuP6JiouPKSDoRtyIJRXIs9AdqpFMvgB2FreLgu","active","profile.jpg","1","1","0","2024-04-24 16:39:15","0","");
INSERT INTO tbl_users VALUES("7","RHU","RHU","$2y$10$mbPs3TBDXv./hO5qY29..e9rZ45EdeBkulxSpxXQYD2sQwRCng/wO","active","photo1718592536 (3).jpeg","7","7","0","2024-05-02 10:55:03","0","");
INSERT INTO tbl_users VALUES("8","Elleen","RHU","$2y$10$K3X5eArj9SJzJ7S.hu1l.ePlQSK2uIhJaY2IGT8l1A1LF7Vmex2DK","active","girl.png","8","8","2","2024-05-02 13:15:38","0","");
INSERT INTO tbl_users VALUES("29","1","Doctor","$2y$10$LL1UaURxO/bcrq1ayZQCSegp05nJldMCef0qmKkmludDfew.Yt932","active","photo1718592515 (7).jpeg","34","34","0","2024-08-04 09:46:14","0","2024-08-11 15:48:29");
INSERT INTO tbl_users VALUES("31","angel","Midwife","","active","commentor-item3.jpg","36","36","0","2024-08-04 09:47:01","0","2024-08-11 15:48:29");
INSERT INTO tbl_users VALUES("36","joven","BHW","$2y$10$m7q5alOPF40NAzJBbfa8buhGxCrRsF6pMtBjkZLXLoj62ZkoPT5uG","active","1656551981avatar.png","41","41","6","2024-08-07 17:23:41","0","");
INSERT INTO tbl_users VALUES("37","test","BHW","$2y$10$vR3.xMkzF2dXSX3JcWG9Juk49HlM6OCovIkxO3vCtkCNWyW2WXqtm","active","OIP.jpg","42","42","1","2024-08-17 18:21:00","0","");
INSERT INTO tbl_users VALUES("38","Carlos","Physician","","inactive","Capture3.PNG","43","43","","2024-08-27 16:54:40","0","");
INSERT INTO tbl_users VALUES("39","Joven123","Doctor","$2y$10$tOxTn6pBDgI11aL6Ms33y.K0ckHRxgU9SCTDW8miq.BNFeB5rIZ12","active","photo1718592536 (3).jpeg","44","44","","2024-10-23 09:58:53","0","");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_vitalsigns_monitoring VALUES("1","223","2024-10-17","16:26:00","120/20","2","2","2","2","2","2","2","31","8","1","2024-10-17 16:26:18");
INSERT INTO tbl_vitalsigns_monitoring VALUES("2","223","2024-10-10","16:27:00","120/20","2","2","2","2","2","2","2","31","8","1","2024-10-17 16:26:42");
INSERT INTO tbl_vitalsigns_monitoring VALUES("3","223","2024-10-17","02:26:00","120/20","f","ew","rwe","rew","re","wrew","rew","31","8","1","2024-10-17 16:26:42");
INSERT INTO tbl_vitalsigns_monitoring VALUES("4","12","2024-10-10","08:07:00","120/20","2","2","2","2","2","2","2","31","6","2","2024-10-18 08:07:16");



