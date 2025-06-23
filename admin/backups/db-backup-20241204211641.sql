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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_care VALUES("1","3","20241202001","2024-12-02","[\"Fully Immunized\",\"On Meds\",\"Drug\",\"Hypertension\",\"\"]","+","January","2020","Dog","2024-11-27","SOuth China Sea","[\"Non-bite\",\"Induced\"]","2024-12-02","Vaccinated","Killed Intentionally","SOuth China Sea","yes","yes","yes","yes","yes","yes","2024-09-29","TT","III","CATEGORY EXPOSURE:","CATEGORY EXPOSURE:","3","done","0");
INSERT INTO tbl_animal_bite_care VALUES("2","2","20241204001","2024-12-04","[\"Anti-Rabies\",\"Drug\",\"\"]","-","January","2024","Cat","2024-12-04","palabilla","[\"Non-bite\",\"Spontaneous\"]","2024-12-04","Vaccinated","Died","adfsssssssssssssssssssssssssss","no","no","no","no","no","no","2024-12-04","TT","III","fdsaaaaaaaaaaaaaaaaaaaaaaaaaa","adfsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss","3","ongoing","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_animal_bite_vaccination VALUES("1","1","2024-12-02","2024-12-05","1","","3","1","1","1","0");
INSERT INTO tbl_animal_bite_vaccination VALUES("2","1","2024-12-04","2024-12-18","1","napaakan iro balik sunod adlaw para sa 2nd dose","2","0","1","2","0");
INSERT INTO tbl_animal_bite_vaccination VALUES("3","1","2024-12-05","2024-12-09","1","patay na ang iro nga nagpaak","3","1","2","1","0");
INSERT INTO tbl_animal_bite_vaccination VALUES("4","1","2024-12-09","2024-12-09","1","done","3","1","3","1","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
INSERT INTO tbl_audit_trail VALUES("34","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 23:00:49","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("35","1","Update","Updated Patient Information,  Luz Loreto","tbl_patients","1","2024-12-02 23:01:03","175.176.92.247","0");
INSERT INTO tbl_audit_trail VALUES("36","1","Add Users","Added User,  James  Bond","tbl_users","11","2024-12-03 02:49:55","210.1.101.101","0");
INSERT INTO tbl_audit_trail VALUES("37","1","Delete Schedule","Deleted the schedule for Doctor Josep  Santos","tbl_doctor_schedule","3","2024-12-03 03:17:41","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("38","1","Delete Schedule","Deleted the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","2","2024-12-03 03:17:43","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("39","1","Add Schedule","Added a schedule for Doctor  Chashieda Tunguia Lamalan","tbl_doctor_schedule","4","2024-12-03 03:17:54","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("40","1","Delete Schedule","Deleted the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","4","2024-12-03 03:18:11","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("41","1","Add Schedule","Added a schedule for Doctor  Chashieda Tunguia Lamalan","tbl_doctor_schedule","5","2024-12-03 03:18:23","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("42","1","Update Schedule","Updated the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","5","2024-12-03 03:18:39","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("43","1","Update Schedule","Updated the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","5","2024-12-03 03:18:48","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("44","1","Update Schedule","Updated the schedule for Doctor Chashieda Tunguia Lamalan","tbl_doctor_schedule","5","2024-12-03 03:18:54","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("45","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 04:50:57","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("46","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 04:51:06","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("47","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 04:51:17","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("48","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:07:14","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("49","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:07:26","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("50","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:26:50","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("51","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:26:59","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("52","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:27:07","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("53","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:28:09","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("54","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:28:15","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("55","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:30:59","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("56","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:31:08","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("57","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:31:14","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("58","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:32:57","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("59","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:33:05","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("60","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:33:09","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("61","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:33:51","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("62","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:34:14","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("63","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:38:59","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("64","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:39:25","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("65","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:45:47","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("66","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:45:54","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("67","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:46:00","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("68","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:46:08","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("69","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:46:16","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("70","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:46:23","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("71","1","Update","Updated Patient Information,  Mark Carpio","tbl_patients","3","2024-12-03 05:47:43","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("72","1","Update","Updated Patient Information,  Maria Magdalena","tbl_patients","2","2024-12-03 05:48:15","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("73","1","Update","Updated Patient Information,  Maria Fee Magdalena","tbl_patients","2","2024-12-03 05:49:40","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("74","1","Update","Updated Patient Information,  Maria Fee Magdalena","tbl_patients","2","2024-12-03 05:49:53","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("75","2","Insert","Added patient: Ancel lobrido","tbl_patients","4","2024-12-03 06:01:22","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("76","5","Insert","Added patient: Suga Daddy","tbl_patients","5","2024-12-03 06:07:46","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("77","1","Updated Users","Updated User,  James  Bond","tbl_users","11","2024-12-03 06:09:11","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("78","1","Update Medicine Stock","Updated Medicine Stock Bio-flu mg 10","tbl_medicine_details","2","2024-12-03 07:47:02","210.1.101.101","0");
INSERT INTO tbl_audit_trail VALUES("79","1","Add Medicine Stock","Added Medicine Stock  Fast Relax mg 19","tbl_medicine_details","4","2024-12-03 07:53:56","210.1.101.101","0");
INSERT INTO tbl_audit_trail VALUES("80","1","Update Medicine Stock","Updated Medicine Stock Bio-flu mg 30","tbl_medicine_details","2","2024-12-03 07:54:53","210.1.101.101","0");
INSERT INTO tbl_audit_trail VALUES("81","1","Update Medicine Stock","Updated Medicine Stock Fast Relax mg 100","tbl_medicine_details","4","2024-12-03 07:55:01","210.1.101.101","0");
INSERT INTO tbl_audit_trail VALUES("82","11","Insert","Added patient: Laila Mobile legend","tbl_patients","6","2024-12-03 08:59:24","2001:4456:1ea:aa00:39a0:cb65:9283:6451","0");
INSERT INTO tbl_audit_trail VALUES("83","1","Added Medicine,","Added Medicine  Hepatitis B Vaccine","tbl_medicines","5","2024-12-04 00:51:02","2001:4456:1ea:aa00:b8a1:3c72:35a6:e443","0");
INSERT INTO tbl_audit_trail VALUES("84","1","Updated Health Professional","Updated Health Professional, Chashieda Tunguia Lamalan","tbl_users","9","2024-12-04 02:19:01","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("85","1","Updated Health Professional","Updated Health Professional, Chashieda Tunguia Lamalan","tbl_users","9","2024-12-04 02:24:19","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("86","5","Insert","Added patient: Mash masharap","tbl_patients","7","2024-12-04 05:17:41","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("87","3","Insert","Added patient: Ishma Suarez","tbl_patients","8","2024-12-04 06:19:19","131.226.112.89","0");
INSERT INTO tbl_audit_trail VALUES("88","1","Updated Users","Updated User,  Josep M Santos","tbl_users","5","2024-12-04 07:19:29","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("89","1","Updated Users","Updated User,  Josep M Santos","tbl_users","5","2024-12-04 07:20:14","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("90","1","Add Users","Added User,  Abubakar  Abubakar","tbl_users","12","2024-12-04 07:23:54","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("91","1","Updated Health Professional","Updated Health Professional, Erlinda Antique Lapus","tbl_users","8","2024-12-04 08:58:42","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("92","1","Updated Health Professional","Updated Health Professional, Erlinda Antique Lapus","tbl_users","8","2024-12-04 08:58:57","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("93","1","Updated Health Professional","Updated Health Professional, Erlinda Antique Lapus","tbl_users","8","2024-12-04 09:03:57","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("94","1","Updated Health Professional","Updated Health Professional, Erlinda Antique Lapus","tbl_users","8","2024-12-04 09:04:35","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0");
INSERT INTO tbl_audit_trail VALUES("95","1","Update","Updated Patient Information,  Ishma Suarez","tbl_patients","8","2024-12-04 13:03:05","175.176.92.199","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birth_info VALUES("1","1","20241203001","2024-12-03","DAD","DAS","DSA","{\"g\":\"DSA\",\"p\":\"D\",\"term\":\"DS\",\"preterm\":\"SD\",\"abortion\":\"DS\",\"living\":\"DS\"}","DASSSSSSSSSSSSS","[\"Torch Infection\",\"\"]","DAS","DSA","DSA","[\"Hypertension\",\"Asthma\",\"\"]","{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}","{\"menarche\":\"\",\"duration\":\"\",\"days\":\"\",\"remarks\":\"\",\"first_sexual_contact\":\"\"}","{\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"DSA\",\"illness\":\"\",\"tot_visit\":\"\",\"others\":\"\"}","[{\"year\":\"\",\"place_of_confinement\":\"\",\"aog\":\"\",\"bw\":\"\",\"manner_of_delivery\":\"\",\"complication_remarks\":\"\"}]","2","1","1","10","ongoing","2024-12-02","0");
INSERT INTO tbl_birth_info VALUES("2","6","20241203002","2024-12-03","1","1","1","{\"g\":\"1\",\"p\":\"1\",\"term\":\"11\",\"preterm\":\"1\",\"abortion\":\"1\",\"living\":\"1\"}","FDS","[\"Heart Disease\",\"Gonorrhea\",\"Other STI\",\"\"]","","","","[\"Heart Disease\",\"Hypertension\",\"Diabetes\",\"\"]","{\"multiple\":\"No\",\"alcohol\":\"No\",\"smoking\":\"No\"}","{\"menarche\":\"2\",\"regular\":\"No\",\"duration\":\"2\",\"days\":\"2\",\"remarks\":\"2\",\"flow\":[\"profuse\"],\"dysmenorrhea\":\"yes\",\"first_sexual_contact\":\"1 YEAR\"}","{\"antepartal_care\":\"Health Center\",\"start_visit\":\"\",\"aog\":\"\",\"tt\":\"\",\"ogct\":\"2\",\"illness\":\"2\",\"tot_visit\":\"2\",\"others\":\"2\"}","[{\"year\":\"2\",\"place_of_confinement\":\"2\",\"aog\":\"2\",\"bw\":\"2\",\"manner_of_delivery\":\"2\",\"complication_remarks\":\"2\"}]","3","2","2","8","done","2024-12-03","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birth_ivfluids VALUES("1","6","2024-12-03","19:08:00","19:08:00","1","12313","2","2","2024-12-03 11:08:31","0");
INSERT INTO tbl_birth_ivfluids VALUES("2","1","2024-12-03","07:08:00","19:08:00","2","fads","fdsaaaaaaaa","1","2024-12-03 11:09:14","0");
INSERT INTO tbl_birth_ivfluids VALUES("3","1","2024-12-03","09:09:00","21:09:00","1","2","12321312fasfsdaf","1","2024-12-03 11:09:14","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthing_medication VALUES("1","6","2024-12-03","2","1","12","19:07:00","2024-12-03","fdsadafs","Hold","Discontinued","2","2024-12-03 11:07:45","0");
INSERT INTO tbl_birthing_medication VALUES("2","6","2024-12-03","4","1","12","19:07:00","2024-12-03","fdsadafsfasdfs","Hold","Discontinued","2","2024-12-03 11:07:45","0");
INSERT INTO tbl_birthing_medication VALUES("3","1","2024-12-03","2","1","1","19:36:00","2024-12-03","22222222","fdaaaassssssssssss","fdsaa","1","2024-12-03 11:36:38","0");



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

INSERT INTO tbl_birthing_monitoring VALUES("1","1","20241203001","1","DASDDDDDDDDDDDDDDD","2024-12-03","07:06:00","07:06:00","07:06:00","07:06:00","07:06:00","07:06","Yes","100","07:06:00","Livebirth","Yes","4kg","Yes","no","DASSSSSSSSSSSSSSSSSS","NOT IN ACTIVE LABOUR","[\"5\"]","[\"5\"]","[\"2\"]","[]","[]","[\"7\"]","[]","[\"7\"]","[]","[]","DASSSSSSSSSSSSSSSSSSS","DASSS","DSAD","DAS","DAS","2024-12-02 23:06:55","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_birthroom VALUES("1","1","2024-12-03","fdsa","fd","dsa","ds","","","{\"labor\":{\"types\":[\"Spontaneous\"],\"time\":\"18:55\",\"date\":\"03\\/12\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"cervix\":{\"time\":\"18:55\",\"date\":\"03\\/12\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"baby\":{\"time\":\"18:55\",\"date\":\"03\\/12\\/2024\",\"duration\":{\"hrs\":\"1\",\"mins\":\"1\"}},\"placenta\":{\"time\":\"18:55\",\"date\":\"03\\/12\\/2024\",\"duration\":{\"hrs\":\"3\",\"mins\":\"3\"}}}","{\"placenta\":{\"expelled\":[\"Spontaneous\"]},\"umbilicalCord\":{\"cm\":\"1\",\"loops_at_neck\":\"\",\"loops\":\"1\",\"none\":\"None\",\"loopsNone\":\"\"},\"other\":\"1\",\"bloodLoss\":{\"antepartum\":\"1\",\"intrapartum\":\"1\",\"postpartum\":\"1\",\"total\":\"1\"}}","[\"Other\"]","[\"Right Med. Lateral\"]","[\"Cervical\"]","[]","[]","[]","[]","[\"Relaxing\"]","None","None","None","FDS","fsda","10","1","2024-12-03 10:56:20","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_certificate_log VALUES("1","3","2024-12-03 01:01:34","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/3_2024-12-03.pdf","0");
INSERT INTO tbl_certificate_log VALUES("8","4","2024-12-03 08:03:51","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/4_2024-12-03.pdf","0");
INSERT INTO tbl_certificate_log VALUES("9","5","0000-00-00 00:00:00","pending","","0");
INSERT INTO tbl_certificate_log VALUES("10","6","2024-12-04 01:53:30","done","/home/u926430213/domains/lutayanrhu.site/public_html/RHU/certificates/6_2024-12-04.pdf","0");
INSERT INTO tbl_certificate_log VALUES("11","8","0000-00-00 00:00:00","pending","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_clinicalrecords VALUES("1","1","","","","2024-12-03","07:06:00","2024-12-03","19:37:00","new","Wakwak  Wakwak","fdsa","fdsaaaaaaaaaaaaaaaaaaaaa","fsaf","fsadddddddddddd","fdasasasasasasasasasasasasasas","improved","1","2024-12-03 11:37:15","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_complaints VALUES("1","1","fsda","sad","120/80","22","22kg","22","22°C","22cm","New admission","Vaccination and Immunization","Leni Robrido","server headache","Done","22","22","referred","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("2","2","","","120/80","60","33kg","22","22°C","33cm","New admission","Vaccination and Immunization","Leni Robrido","12313","Done","33","33","referred","2024-12-01","0");
INSERT INTO tbl_complaints VALUES("3","2","test","test","120/90","60","50kg","22","23°C","22.9cm","Follow-up visit","Checkup","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","Done","22","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("4","2","","","120/20","22","22kg","22","22°C","22","Follow-up visit","Animal bite and Care","Leni Robrido","","for vaccination","22","22","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("5","3","","","120/160","33","33kg","33","33°C","33","New consultation/case","Animal bite and Care","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","Done","33","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("6","1","","","120/80","22","2kg","2","2°C","2cm","Follow-up visit","Vaccination and Immunization","Rhu Rhu","fdsaaaaaaaaaaaaaaaa","Done","2","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("7","1","FD","SADF","120/90","22","22kg","22","22°C","22.66cm","Follow-up visit","Birthing","Bhw Bhw","dfhgg","Under Monitoring","22","","","2024-12-02","0");
INSERT INTO tbl_complaints VALUES("8","5","fdsa","fsd","120/22","2","2kg","2","2°C","2cm","Follow-up visit","Checkup","Rhu Rhu","server headache","Pending","2","","","2024-12-03","0");
INSERT INTO tbl_complaints VALUES("9","6","fdsa","fdsa","120/80","22","22kg","2","2°C","2cm","New consultation/case","Birthing","James Bond","fdsaffffffffffffffff","Done","2","2","referred","2024-12-03","0");
INSERT INTO tbl_complaints VALUES("10","6","","","120/90","22","2kg","22","22°C","2cm","Follow-up visit","Prenatal","Rhu Rhu","prenatal","Done","22","","","2024-12-03","0");
INSERT INTO tbl_complaints VALUES("11","4","","","120/90","22","2kg","2","2°C","2cm","Follow-up visit","Vaccination and Immunization","Rhu Rhu","for vaccination","Done","2","","","2024-12-04","0");
INSERT INTO tbl_complaints VALUES("12","7","","","120/22","22","22kg","22","22°C","22cm","New consultation/case","Checkup","Josep Santos","dfsafffffdd","Pending","2","22","","2024-12-04","0");
INSERT INTO tbl_complaints VALUES("13","8","Headache","","120/80","76","174kg","15","36°C","176cm","Follow-up visit","Checkup","Rhu Rhu","Assessment","Pending","16","","","2024-12-04","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_doctor_schedule VALUES("1","9","","vvaccation leave","","","","3","","","2024-12-04","2024-12-12","2024-12-04 02:29:00","2024-12-04 11:55:22","0","0","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_familyAddress VALUES("1","Blingkong","St. 123","Lutayan","Sultan Kudarat","test","2024-12-02 05:28:01","2024-12-02 10:27:27","0");
INSERT INTO tbl_familyAddress VALUES("2","Palavilla","St. 123","Lutayan","Sultan Kudarat","Lutayan","2024-12-02 05:30:20","2024-12-03 05:31:08","0");
INSERT INTO tbl_familyAddress VALUES("3","Tananzang","Abubakar","Lutayan","Sultan Kudarat","Abubakar, Koronadal","2024-12-02 08:36:01","2024-12-03 05:34:14","0");
INSERT INTO tbl_familyAddress VALUES("4","Tamnag (pob.)","Masagana","","Sultan Kudarat","lutayan","2024-12-03 06:01:22","","0");
INSERT INTO tbl_familyAddress VALUES("5","Palavilla","Malipayon","","Sultan Kudarat","tamnag lutayan","2024-12-03 06:07:46","","0");
INSERT INTO tbl_familyAddress VALUES("6","Mangudadatu","Mobile Legend","","Sultan Kudarat","Mobile legend","2024-12-03 08:59:24","","0");
INSERT INTO tbl_familyAddress VALUES("7","Punol","Masharap","","Sultan Kudarat","sultan kudarat","2024-12-04 05:17:41","","0");
INSERT INTO tbl_familyAddress VALUES("8","Antong","Pag-asa","","Sultan Kudarat","Davao City","2024-12-04 06:19:19","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_family_members VALUES("1","maria loreto","Mother","09677819501","Sultan kudarat","1","2024-12-02 05:28:01","0");
INSERT INTO tbl_family_members VALUES("2","Maria  Magdale","Sibling","96523232","Palavi\'ll","2","2024-12-02 05:30:20","0");
INSERT INTO tbl_family_members VALUES("3","Mark  a. Carpio ","Sibling","09652","Ab","3","2024-12-02 08:36:01","0");
INSERT INTO tbl_family_members VALUES("4","Maria  Magdale","Mother","09652323229","Tamnga pob","4","2024-12-03 06:01:22","0");
INSERT INTO tbl_family_members VALUES("5","Maria Santos","Employer","0966532154","Koronadal city","5","2024-12-03 06:07:46","0");
INSERT INTO tbl_family_members VALUES("6","Hector Mobile","Father","095623232","Mobile legend BANG-BANG","6","2024-12-03 08:59:24","0");
INSERT INTO tbl_family_members VALUES("7","Edna Mobile","Mother","+639123131231","Mobile Legend, Brgy. Mangudadatu, ,","6","2024-12-03 11:17:02","0");
INSERT INTO tbl_family_members VALUES("8","fsda fsa fsdaf","Mother","098632323","sultan kudarat","7","2024-12-04 05:17:41","0");
INSERT INTO tbl_family_members VALUES("9","Lyn Suarez","Daugther","0986786678","Davao","8","2024-12-04 06:19:19","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_healthnotes VALUES("1","1","6","2024-12-03","07:14:00","FDAAAAAAAAAAAAAAAAAAAAAAAAAA","","1","2024-12-02 23:14:49","0");
INSERT INTO tbl_healthnotes VALUES("2","1","8","2024-12-03","19:27:00","","fda","1","2024-12-03 11:27:20","0");
INSERT INTO tbl_healthnotes VALUES("3","1","8","2024-12-03","07:27:00","","fdsaaaaaaaaaaaaaaaaaaaaaaaaaaaa","1","2024-12-03 11:27:30","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_immunization_records VALUES("1","1","Bcg Vaccine","2024-12-01","2024-12-16","sample tex","3","2024-12-02","0");
INSERT INTO tbl_immunization_records VALUES("2","2","Rabies Vaccine","2024-12-02","2024-12-18","sample text","3","2024-12-02","0");
INSERT INTO tbl_immunization_records VALUES("3","1","Bcg Vaccine","2024-12-02","2024-12-19","fdsaaaaaaaaaaaaaaaaaaaaaa","3","2024-12-02","0");
INSERT INTO tbl_immunization_records VALUES("4","4","Bcg Vaccine","2024-12-04","2024-12-12","fdsaaaaaaf","3","2024-12-04","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_login_attempts VALUES("1","2","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0","","");
INSERT INTO tbl_login_attempts VALUES("2","5","2001:4456:1ea:aa00:f030:de53:b5c7:23d7","0","","");



DROP TABLE IF EXISTS tbl_medicine_details;

CREATE TABLE `tbl_medicine_details` (
  `med_detailsID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `packing` varchar(60) NOT NULL,
  `qt` varchar(255) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`med_detailsID`),
  KEY `medicine_id` (`medicine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","1","injectable","90","0");
INSERT INTO tbl_medicine_details VALUES("2","2","mg","27","0");
INSERT INTO tbl_medicine_details VALUES("3","3","injectable","99","0");
INSERT INTO tbl_medicine_details VALUES("4","4","mg","99","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_medicines VALUES("1","Rabies Vaccine","Rabies Vaccine","Rabies Vaccine","Vaccines","2024-12-01","2027-05-05","Rabies vaccine","Rabies vaccine","1","2024-12-01 11:26:43","0");
INSERT INTO tbl_medicines VALUES("2","Bio-flu","Bio-flu","Bio-flu","Analgesics","2024-12-01","2027-05-05","Bio-flu","Bio-flu","1","2024-12-01 12:14:31","0");
INSERT INTO tbl_medicines VALUES("3","Bcg Vaccine","Provides Immunity Or Protection Against Tuberculosis (tb)","Bcg Vaccine","Vaccines","2024-12-01","2025-01-08","BCG vaccine","Branded","1","2024-12-01 12:30:03","0");
INSERT INTO tbl_medicines VALUES("4","Fast Relax","Gamot Na Maaasahan","Tunguia Pharma","Analgesics","2024-01-03","2025-07-18","Neytunguia","Iduno","1","2024-12-02 11:41:16","0");
INSERT INTO tbl_medicines VALUES("5","Hepatitis B Vaccine","Hepatitis B Vaccine","Hepatitis B Vaccine","Vaccines","2024-12-04","2027-02-05","Hepatitis B vaccine","Hepatitis B vaccine","0","2024-12-04 00:51:02","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_membership_info VALUES("1","No","","","NHTS","2024-12-02 05:28:01","2024-12-02 23:00:49","0");
INSERT INTO tbl_membership_info VALUES("2","Yes","062469896511","Member","4PS","2024-12-02 05:30:20","0000-00-00 00:00:00","0");
INSERT INTO tbl_membership_info VALUES("3","Yes","091658753256","Dependent","NHTS","2024-12-02 08:36:01","2024-12-03 05:07:26","0");
INSERT INTO tbl_membership_info VALUES("4","Yes","062469896533","None Member","4PS","2024-12-03 06:01:22","","0");
INSERT INTO tbl_membership_info VALUES("5","Yes","062469896566","Dependent","4PS","2024-12-03 06:07:46","","0");
INSERT INTO tbl_membership_info VALUES("6","No","","","NHTS","2024-12-03 08:59:24","","0");
INSERT INTO tbl_membership_info VALUES("7","Yes","989899562323","Member","4PS","2024-12-04 05:17:41","","0");
INSERT INTO tbl_membership_info VALUES("8","No","","","NHTS","2024-12-04 06:19:19","2024-12-04 13:03:05","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_medication_history VALUES("1","12","2","Oral(p/o)","3","as needed","","5 mg","","4 (Day)","dfsaaaaaaa","0");
INSERT INTO tbl_patient_medication_history VALUES("2","13","2","Cream/Lotion/Ointment","3","as needed","","3","","7 (Day)","fdsaaaaaaaaaaaaaaaa","0");
INSERT INTO tbl_patient_medication_history VALUES("3","18","2","Oral(p/o)","1","as needed","","250","","7 (Day)","Eat","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patient_visits VALUES("1","2024-12-02","","","","1","0","0");
INSERT INTO tbl_patient_visits VALUES("2","2024-12-02","","","","2","0","0");
INSERT INTO tbl_patient_visits VALUES("3","2024-12-02","","","","3","0","0");
INSERT INTO tbl_patient_visits VALUES("4","2024-12-02","","","","1","0","0");
INSERT INTO tbl_patient_visits VALUES("5","2024-12-03","","","","1","0","0");
INSERT INTO tbl_patient_visits VALUES("12","2024-12-03","2024-12-17","cough","fdsaaaaaaa","4","10","0");
INSERT INTO tbl_patient_visits VALUES("13","2024-12-03","2024-12-17","kurikong","katola lang na","5","8","0");
INSERT INTO tbl_patient_visits VALUES("14","2024-12-03","","","","6","0","0");
INSERT INTO tbl_patient_visits VALUES("15","2024-12-04","","","","6","0","0");
INSERT INTO tbl_patient_visits VALUES("16","2024-12-04","","","","2","0","0");
INSERT INTO tbl_patient_visits VALUES("17","2024-12-04","","","","4","0","0");
INSERT INTO tbl_patient_visits VALUES("18","2024-12-04","2024-12-10","Uti","Sleep","8","9","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO tbl_patients VALUES("1","1","1","5091397","Luz","","Loreto","","","","0000000001","1989-02-01","35 years","09677819501","Female","Single","A-","","","Islam","Filipino","2024-12-02","5","2024-12-02 23:01:03","0");
INSERT INTO tbl_patients VALUES("2","2","2","5091398","Maria Fee","","Magdalena","","","Maria  Magdalena","0000000002","2024-12-03","5 Years","0963326452311","Other","Single","B-","","None","Jehovah\'s Witnesses","Filipino","2024-12-02","5","2024-12-03 05:49:40","0");
INSERT INTO tbl_patients VALUES("3","3","3","5091399","Mark","","Carpio","","Soraida carpio","","0000000003","2024-12-03","35 Years","09623655449","Female","Single","O-","Master\'s Degree","Programmer","Methodists","Filipino","2024-12-02","3","2024-12-03 05:34:14","0");
INSERT INTO tbl_patients VALUES("4","4","4","5091400","Ancel","","lobrido","","Maria  Magdale","","0000000004","2024-12-01","0 months","09633264523","Male","Single","A+","","none","Baptists","Filipino","2024-12-03","2","","0");
INSERT INTO tbl_patients VALUES("5","5","5","5091401","Suga","","Daddy","","","","0000000005","1983-02-09","41 years","0965321565","Male","Single","B+","","Sugar Daddy","Hinduism","Filipino","2024-12-03","5","","0");
INSERT INTO tbl_patients VALUES("6","6","6","5091402","Laila","","Mobile legend","","","","0000000006","2005-05-11","19 years","09677819501","Female","Single","B+","Undergrad","marksman","Philippine Independent Church (Aglipayan Church)","Filipino","2024-12-03","11","","0");
INSERT INTO tbl_patients VALUES("7","7","7","5091403","Mash","","masharap","","","","0000000007","2000-02-07","24 years","0962358746","Male","Single","AB+","MD","none","Iglesia ni Cristo(INC)","Filipino","2024-12-04","5","","0");
INSERT INTO tbl_patients VALUES("8","8","8","5091404","Ishma","T","Suarez","","Lyn Suarez","","0000000008","2024-12-04","21 Years","09876787667","Male","Single","A-","Undergrad","Student","Roman Catholic","Filipino","2024-12-04","3","2024-12-04 13:03:05","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","admin","","adminadmin","09653231212","admin123@gmail.com","","0");
INSERT INTO tbl_personnel VALUES("2","Bhw","Pero","Bhw","+639665123662","bhw@gmail.com","Bhw","0");
INSERT INTO tbl_personnel VALUES("3","Rhu","","Rhu","+632131321321","RHULUTAYAN@gmail.com","Rhurhu","0");
INSERT INTO tbl_personnel VALUES("5","Josep","M","Santos","+639665123662","Josep@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("7","gerald","","anders","+631232131321","gerald@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("8","Erlinda","Antique","Lapus","+631232131321","Erlinda@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("9","Chashieda","Tunguia","Lamalan","+639547544444","azumi_maiya@yahoo.com","Purok Kaugnayan, Koronadal City","0");
INSERT INTO tbl_personnel VALUES("10","Wakwak","","Wakwak","+632131321321","wakwak@mail","wakwakwakwak","0");
INSERT INTO tbl_personnel VALUES("11","Chashieda","Tunguia","Lamalan","+631232131321","azumi_maiya@yahoo.com","Purok Kaugnayan, Koronadal City","0");
INSERT INTO tbl_personnel VALUES("12","Abubakar","m","Abubakar","+632133333333","abubakar@gmail","Abubakar","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_physicalexam VALUES("1","DAS","DA","DSA","DSA","DSA","DSA","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","2024-12-02 23:06:16","0");
INSERT INTO tbl_physicalexam VALUES("2","2","2","2","2","2","","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","[\"\"]","2024-12-03 10:49:17","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_position VALUES("1","1","admin","","","","0");
INSERT INTO tbl_position VALUES("2","3","","","","","0");
INSERT INTO tbl_position VALUES("4","5","","","","","0");
INSERT INTO tbl_position VALUES("6","7","Physician","Family doctor","M.D","12312321312","0");
INSERT INTO tbl_position VALUES("7","8","Midwife","erlinda","M.D","102656369","0");
INSERT INTO tbl_position VALUES("9","10","Doctor","test","M.D","0956232","0");
INSERT INTO tbl_position VALUES("11","11","test1","test1","M.D","0956232","0");
INSERT INTO tbl_position VALUES("12","12","","","","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_postpartum VALUES("1","1","2024-12-03","{\"date\":\"2024-12-03\",\"time\":\"\",\"monitoring\":{\"every5_15\":{\"times\":[\"\",\"\",\"\",\"\"]},\"2HR\":\"\",\"3HR\":\"\",\"4HR\":\"\",\"8HR\":\"\",\"12HR\":\"\",\"date2\":\"\",\"16HR\":\"\",\"20HR\":\"\",\"24HR\":\"\",\"discharge\":\"\"}}","","","","","","","","","","","1","2024-12-03 10:59:24","0");



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

INSERT INTO tbl_prenatal VALUES("1","2024-12-04","   ","7","1","1","1","dsad","af","fds","1","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fdsa","fsda","Multiple","Breech","Decreased","Anterior","Complete","2","heart","Fdsaaaaaaaaaaaaaaaaaaaaaaa","Telan Bansilan","6","3","2024-12-04 00:11:42","0");



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

INSERT INTO tbl_referrals_log VALUES("1","1","2024-12-02","5","","0");
INSERT INTO tbl_referrals_log VALUES("2","2","2024-12-02","5","","0");
INSERT INTO tbl_referrals_log VALUES("3","4","2024-12-03","3","","0");
INSERT INTO tbl_referrals_log VALUES("4","6","2024-12-03","3","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_systemreview VALUES("1","[]","[]","[]","[]","[\"Glasses\\/Contacts\"]","[]","[]","[\"Pain\"]","[\"Breastfeeding\"]","[]","[]","[\"Change in Appetite\"]","[\"Urgency\"]","[]","[]","[]","[]","[]","[]","[\"Depression\"]","2024-12-02 23:06:16","0");
INSERT INTO tbl_systemreview VALUES("2","[]","[]","[]","[]","[]","[\"Stuffiness\"]","[]","[]","[]","[\"Dyspnea\"]","[]","[]","[]","[]","[]","[]","[]","[]","[]","[]","2024-12-03 10:49:17","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=392 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
INSERT INTO tbl_user_log VALUES("55","1","admin","175.176.92.247\0\0","2024-12-02 22:47:21","03-12-2024 07:01:20 AM","1","0");
INSERT INTO tbl_user_log VALUES("56","1","admin","175.176.92.247\0\0","2024-12-02 23:01:25","","1","0");
INSERT INTO tbl_user_log VALUES("57","5","leni","175.176.92.247\0\0","2024-12-02 23:04:33","03-12-2024 07:04:55 AM","1","0");
INSERT INTO tbl_user_log VALUES("58","2","BHW","175.176.92.247\0\0","2024-12-02 23:05:04","03-12-2024 07:07:13 AM","1","0");
INSERT INTO tbl_user_log VALUES("59","2","BHW","175.176.92.247\0\0","2024-12-02 23:07:20","03-12-2024 07:08:15 AM","1","0");
INSERT INTO tbl_user_log VALUES("60","1","admin","175.176.92.247\0\0","2024-12-02 23:08:30","03-12-2024 07:10:38 AM","1","0");
INSERT INTO tbl_user_log VALUES("61","5","leni","175.176.92.247\0\0","2024-12-02 23:10:50","03-12-2024 07:12:26 AM","1","0");
INSERT INTO tbl_user_log VALUES("62","2","BHW","175.176.92.247\0\0","2024-12-02 23:12:41","03-12-2024 07:16:51 AM","1","0");
INSERT INTO tbl_user_log VALUES("63","2","BHW","2001:4456:1ea:aa","2024-12-03 00:31:06","03-12-2024 08:47:12 AM","1","0");
INSERT INTO tbl_user_log VALUES("64","3","RHU","2001:4456:1ea:aa","2024-12-03 01:00:31","03-12-2024 09:00:45 AM","1","0");
INSERT INTO tbl_user_log VALUES("65","","BHW","2001:4456:1ea:aa","2024-12-03 01:01:01","","0","0");
INSERT INTO tbl_user_log VALUES("66","","Bhw","2001:4456:1ea:aa","2024-12-03 01:01:15","","0","0");
INSERT INTO tbl_user_log VALUES("67","2","BHW","2001:4456:1ea:aa","2024-12-03 01:01:20","03-12-2024 09:01:51 AM","1","0");
INSERT INTO tbl_user_log VALUES("68","","BHW","2001:4456:1ea:aa","2024-12-03 01:02:13","","0","0");
INSERT INTO tbl_user_log VALUES("69","","BHW","2001:4456:1ea:aa","2024-12-03 01:02:24","","0","0");
INSERT INTO tbl_user_log VALUES("70","","BHW","2001:4456:1ea:aa","2024-12-03 01:02:34","","0","0");
INSERT INTO tbl_user_log VALUES("71","","BHW","2001:4456:1ea:aa","2024-12-03 01:02:41","","0","0");
INSERT INTO tbl_user_log VALUES("72","2","BHW","2001:4456:1ea:aa","2024-12-03 01:02:57","03-12-2024 09:03:09 AM","1","0");
INSERT INTO tbl_user_log VALUES("73","2","BHW","2001:4456:1ea:aa","2024-12-03 01:03:15","03-12-2024 09:03:26 AM","1","0");
INSERT INTO tbl_user_log VALUES("74","","BHW","2001:4456:1ea:aa","2024-12-03 01:04:17","","0","0");
INSERT INTO tbl_user_log VALUES("75","2","BHW","2001:4456:1ea:aa","2024-12-03 01:04:22","03-12-2024 09:04:36 AM","1","0");
INSERT INTO tbl_user_log VALUES("76","","BHW","2001:4456:1ea:aa","2024-12-03 01:04:53","","0","0");
INSERT INTO tbl_user_log VALUES("77","","BHW","2001:4456:1ea:aa","2024-12-03 01:05:05","","0","0");
INSERT INTO tbl_user_log VALUES("78","","BHW","2001:4456:1ea:aa","2024-12-03 01:05:23","","0","0");
INSERT INTO tbl_user_log VALUES("79","2","BHW","2001:4456:1ea:aa","2024-12-03 01:05:35","03-12-2024 09:05:45 AM","1","0");
INSERT INTO tbl_user_log VALUES("80","","leni","2001:4456:1ea:aa","2024-12-03 01:06:15","","0","0");
INSERT INTO tbl_user_log VALUES("81","","admin","2001:4456:1ea:aa","2024-12-03 01:06:19","","0","0");
INSERT INTO tbl_user_log VALUES("82","","admin","2001:4456:1ea:aa","2024-12-03 01:06:24","","0","0");
INSERT INTO tbl_user_log VALUES("83","","admin","2001:4456:1ea:aa","2024-12-03 01:06:26","","0","0");
INSERT INTO tbl_user_log VALUES("84","","admin","2001:4456:1ea:aa","2024-12-03 01:06:38","","0","0");
INSERT INTO tbl_user_log VALUES("85","1","admin","2001:4456:1ea:aa","2024-12-03 01:06:49","","1","0");
INSERT INTO tbl_user_log VALUES("86","","admin","2001:4456:1ea:aa","2024-12-03 01:34:50","","0","0");
INSERT INTO tbl_user_log VALUES("87","","admin","2001:4456:1ea:aa","2024-12-03 01:34:53","","0","0");
INSERT INTO tbl_user_log VALUES("88","","admin","2001:4456:1ea:aa","2024-12-03 01:34:55","","0","0");
INSERT INTO tbl_user_log VALUES("89","1","admin","2001:4456:1ea:aa","2024-12-03 01:35:06","","1","0");
INSERT INTO tbl_user_log VALUES("90","","admin","2001:4456:1ea:aa","2024-12-03 01:35:11","","0","0");
INSERT INTO tbl_user_log VALUES("91","","admin","2001:4456:1ea:aa","2024-12-03 01:35:31","","0","0");
INSERT INTO tbl_user_log VALUES("92","","admin","2001:4456:1ea:aa","2024-12-03 01:35:33","","0","0");
INSERT INTO tbl_user_log VALUES("93","","admin","2001:4456:1ea:aa","2024-12-03 01:35:35","","0","0");
INSERT INTO tbl_user_log VALUES("94","1","admin","2001:4456:1ea:aa","2024-12-03 01:35:38","03-12-2024 09:35:54 AM","1","0");
INSERT INTO tbl_user_log VALUES("95","1","admin","2001:4456:1ea:aa","2024-12-03 01:36:10","","1","0");
INSERT INTO tbl_user_log VALUES("96","1","admin","2001:4456:1ea:aa","2024-12-03 01:36:29","03-12-2024 09:36:46 AM","1","0");
INSERT INTO tbl_user_log VALUES("97","","admin","2001:4456:1ea:aa","2024-12-03 01:38:49","","0","0");
INSERT INTO tbl_user_log VALUES("98","","admin","2001:4456:1ea:aa","2024-12-03 01:38:52","","0","0");
INSERT INTO tbl_user_log VALUES("99","","admin","2001:4456:1ea:aa","2024-12-03 01:38:54","","0","0");
INSERT INTO tbl_user_log VALUES("100","","admin","2001:4456:1ea:aa","2024-12-03 01:40:23","","0","0");
INSERT INTO tbl_user_log VALUES("101","","admin","2001:4456:1ea:aa","2024-12-03 01:40:25","","0","0");
INSERT INTO tbl_user_log VALUES("102","1","admin","2001:4456:1ea:aa","2024-12-03 01:40:56","","1","0");
INSERT INTO tbl_user_log VALUES("103","1","admin","2001:4456:1ea:aa","2024-12-03 01:41:09","03-12-2024 10:41:24 AM","1","0");
INSERT INTO tbl_user_log VALUES("104","","admin","210.1.101.101\0\0\0","2024-12-03 02:41:32","","0","0");
INSERT INTO tbl_user_log VALUES("105","","admin","210.1.101.101\0\0\0","2024-12-03 02:41:34","","0","0");
INSERT INTO tbl_user_log VALUES("106","","admin","210.1.101.101\0\0\0","2024-12-03 02:41:36","","0","0");
INSERT INTO tbl_user_log VALUES("107","1","admin","210.1.101.101\0\0\0","2024-12-03 02:41:55","","1","0");
INSERT INTO tbl_user_log VALUES("108","1","admin","210.1.101.101\0\0\0","2024-12-03 02:42:44","03-12-2024 10:46:27 AM","1","0");
INSERT INTO tbl_user_log VALUES("109","","admin","210.1.101.101\0\0\0","2024-12-03 02:43:43","","0","0");
INSERT INTO tbl_user_log VALUES("110","","admin","210.1.101.101\0\0\0","2024-12-03 02:43:45","","0","0");
INSERT INTO tbl_user_log VALUES("111","","admin","210.1.101.101\0\0\0","2024-12-03 02:43:47","","0","0");
INSERT INTO tbl_user_log VALUES("112","","admin","210.1.101.101\0\0\0","2024-12-03 02:46:33","","0","0");
INSERT INTO tbl_user_log VALUES("113","","admin","210.1.101.101\0\0\0","2024-12-03 02:46:36","","0","0");
INSERT INTO tbl_user_log VALUES("114","","admin","210.1.101.101\0\0\0","2024-12-03 02:46:38","","0","0");
INSERT INTO tbl_user_log VALUES("115","1","admin","210.1.101.101\0\0\0","2024-12-03 02:46:40","03-12-2024 10:47:56 AM","1","0");
INSERT INTO tbl_user_log VALUES("116","","BHW","210.1.101.101\0\0\0","2024-12-03 03:00:55","","0","0");
INSERT INTO tbl_user_log VALUES("117","2","BHW","210.1.101.101\0\0\0","2024-12-03 03:00:57","03-12-2024 11:01:05 AM","1","0");
INSERT INTO tbl_user_log VALUES("118","","BHW","210.1.101.101\0\0\0","2024-12-03 03:01:08","","0","0");
INSERT INTO tbl_user_log VALUES("119","","BHW","210.1.101.101\0\0\0","2024-12-03 03:01:09","","0","0");
INSERT INTO tbl_user_log VALUES("120","","BHW","210.1.101.101\0\0\0","2024-12-03 03:01:11","","0","0");
INSERT INTO tbl_user_log VALUES("121","2","BHW","210.1.101.101\0\0\0","2024-12-03 03:01:14","03-12-2024 11:01:28 AM","1","0");
INSERT INTO tbl_user_log VALUES("122","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:23","","0","0");
INSERT INTO tbl_user_log VALUES("123","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:26","","0","0");
INSERT INTO tbl_user_log VALUES("124","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:27","","0","0");
INSERT INTO tbl_user_log VALUES("125","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:33","","0","0");
INSERT INTO tbl_user_log VALUES("126","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:34","","0","0");
INSERT INTO tbl_user_log VALUES("127","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:36","","0","0");
INSERT INTO tbl_user_log VALUES("128","","BHW","2001:4456:1ea:aa","2024-12-03 03:02:57","","0","0");
INSERT INTO tbl_user_log VALUES("129","2","BHW","2001:4456:1ea:aa","2024-12-03 03:02:59","03-12-2024 11:03:41 AM","1","0");
INSERT INTO tbl_user_log VALUES("130","5","leni","2001:4456:1ea:aa","2024-12-03 03:03:50","03-12-2024 11:04:54 AM","1","0");
INSERT INTO tbl_user_log VALUES("131","5","leni","2001:4456:1ea:aa","2024-12-03 03:06:36","03-12-2024 11:06:44 AM","1","0");
INSERT INTO tbl_user_log VALUES("132","","leni","2001:4456:1ea:aa","2024-12-03 03:06:46","","0","0");
INSERT INTO tbl_user_log VALUES("133","","leni","2001:4456:1ea:aa","2024-12-03 03:06:48","","0","0");
INSERT INTO tbl_user_log VALUES("134","","leni","2001:4456:1ea:aa","2024-12-03 03:06:49","","0","0");
INSERT INTO tbl_user_log VALUES("135","5","leni","2001:4456:1ea:aa","2024-12-03 03:06:52","03-12-2024 11:06:54 AM","1","0");
INSERT INTO tbl_user_log VALUES("136","5","leni","2001:4456:1ea:aa","2024-12-03 03:06:57","03-12-2024 11:06:59 AM","1","0");
INSERT INTO tbl_user_log VALUES("137","","leni","2001:4456:1ea:aa","2024-12-03 03:07:01","","0","0");
INSERT INTO tbl_user_log VALUES("138","","leni","2001:4456:1ea:aa","2024-12-03 03:07:04","","0","0");
INSERT INTO tbl_user_log VALUES("139","","leni","2001:4456:1ea:aa","2024-12-03 03:07:05","","0","0");
INSERT INTO tbl_user_log VALUES("140","","leni","2001:4456:1ea:aa","2024-12-03 03:07:07","","0","0");
INSERT INTO tbl_user_log VALUES("141","","leni","2001:4456:1ea:aa","2024-12-03 03:07:09","","0","0");
INSERT INTO tbl_user_log VALUES("142","5","leni","2001:4456:1ea:aa","2024-12-03 03:07:17","","1","0");
INSERT INTO tbl_user_log VALUES("143","","leni","2001:4456:1ea:aa","2024-12-03 03:09:37","","0","0");
INSERT INTO tbl_user_log VALUES("144","","leni","2001:4456:1ea:aa","2024-12-03 03:09:39","","0","0");
INSERT INTO tbl_user_log VALUES("145","","leni","2001:4456:1ea:aa","2024-12-03 03:09:40","","0","0");
INSERT INTO tbl_user_log VALUES("146","5","leni","2001:4456:1ea:aa","2024-12-03 03:09:46","03-12-2024 11:09:48 AM","1","0");
INSERT INTO tbl_user_log VALUES("147","1","admin","2001:4456:1ea:aa","2024-12-03 03:11:29","03-12-2024 11:30:34 AM","1","0");
INSERT INTO tbl_user_log VALUES("148","","leni","2001:4456:1ea:aa","2024-12-03 03:13:29","","0","0");
INSERT INTO tbl_user_log VALUES("149","","leni","2001:4456:1ea:aa","2024-12-03 03:13:31","","0","0");
INSERT INTO tbl_user_log VALUES("150","","leni","2001:4456:1ea:aa","2024-12-03 03:13:32","","0","0");
INSERT INTO tbl_user_log VALUES("151","","leni","2001:4456:1ea:aa","2024-12-03 03:31:00","","0","0");
INSERT INTO tbl_user_log VALUES("152","","leni","2001:4456:1ea:aa","2024-12-03 03:31:01","","0","0");
INSERT INTO tbl_user_log VALUES("153","","leni","2001:4456:1ea:aa","2024-12-03 03:31:03","","0","0");
INSERT INTO tbl_user_log VALUES("154","5","leni","2001:4456:1ea:aa","2024-12-03 03:31:08","03-12-2024 11:31:11 AM","1","0");
INSERT INTO tbl_user_log VALUES("155","","leni","2001:4456:1ea:aa","2024-12-03 03:32:57","","0","0");
INSERT INTO tbl_user_log VALUES("156","","leni","2001:4456:1ea:aa","2024-12-03 03:32:59","","0","0");
INSERT INTO tbl_user_log VALUES("157","","leni","2001:4456:1ea:aa","2024-12-03 03:33:00","","0","0");
INSERT INTO tbl_user_log VALUES("158","","leni","2001:4456:1ea:aa","2024-12-03 03:33:04","","0","0");
INSERT INTO tbl_user_log VALUES("159","5","leni","2001:4456:1ea:aa","2024-12-03 03:33:06","03-12-2024 11:33:08 AM","1","0");
INSERT INTO tbl_user_log VALUES("160","","leni","2001:4456:1ea:aa","2024-12-03 03:34:32","","0","0");
INSERT INTO tbl_user_log VALUES("161","","leni","2001:4456:1ea:aa","2024-12-03 03:34:33","","0","0");
INSERT INTO tbl_user_log VALUES("162","","leni","2001:4456:1ea:aa","2024-12-03 03:34:35","","0","0");
INSERT INTO tbl_user_log VALUES("163","5","leni","2001:4456:1ea:aa","2024-12-03 03:34:38","03-12-2024 11:34:40 AM","1","0");
INSERT INTO tbl_user_log VALUES("164","","leni","2001:4456:1ea:aa","2024-12-03 03:37:34","","0","0");
INSERT INTO tbl_user_log VALUES("165","","leni","2001:4456:1ea:aa","2024-12-03 03:37:36","","0","0");
INSERT INTO tbl_user_log VALUES("166","","leni","2001:4456:1ea:aa","2024-12-03 03:37:37","","0","0");
INSERT INTO tbl_user_log VALUES("167","5","leni","2001:4456:1ea:aa","2024-12-03 03:37:39","03-12-2024 11:43:57 AM","1","0");
INSERT INTO tbl_user_log VALUES("168","2","BHW","2001:4456:1ea:aa","2024-12-03 03:44:02","03-12-2024 02:03:20 PM","1","0");
INSERT INTO tbl_user_log VALUES("169","1","admin","2001:4456:1ea:aa","2024-12-03 03:52:01","","1","0");
INSERT INTO tbl_user_log VALUES("170","5","leni","2001:4456:1ea:aa","2024-12-03 06:03:26","03-12-2024 02:09:16 PM","1","0");
INSERT INTO tbl_user_log VALUES("171","1","admin","2001:4456:1ea:aa","2024-12-03 06:09:01","","1","0");
INSERT INTO tbl_user_log VALUES("172","11","james123","2001:4456:1ea:aa","2024-12-03 06:09:19","03-12-2024 02:09:31 PM","1","0");
INSERT INTO tbl_user_log VALUES("173","3","RHU","2001:4456:1ea:aa","2024-12-03 06:09:36","03-12-2024 04:33:01 PM","1","0");
INSERT INTO tbl_user_log VALUES("174","1","admin","2001:4456:1ea:aa","2024-12-03 06:27:54","","1","0");
INSERT INTO tbl_user_log VALUES("175","2","BHW","2001:4456:1ea:aa","2024-12-03 06:41:09","","1","0");
INSERT INTO tbl_user_log VALUES("176","3","RHU","2001:4456:1ea:aa","2024-12-03 08:33:08","03-12-2024 05:00:15 PM","1","0");
INSERT INTO tbl_user_log VALUES("177","1","admin","2001:4456:1ea:aa","2024-12-03 08:38:26","","1","0");
INSERT INTO tbl_user_log VALUES("178","5","leni","2001:4456:1ea:aa","2024-12-03 08:56:43","03-12-2024 04:57:13 PM","1","0");
INSERT INTO tbl_user_log VALUES("179","11","james123","2001:4456:1ea:aa","2024-12-03 08:57:15","","1","0");
INSERT INTO tbl_user_log VALUES("180","3","RHU","2001:4456:1ea:aa","2024-12-03 09:00:20","","1","0");
INSERT INTO tbl_user_log VALUES("181","3","RHU","175.176.92.247\0\0","2024-12-03 10:47:26","03-12-2024 08:07:51 PM","1","0");
INSERT INTO tbl_user_log VALUES("182","3","RHU","175.176.92.247\0\0","2024-12-03 12:07:59","03-12-2024 09:20:24 PM","1","0");
INSERT INTO tbl_user_log VALUES("183","","RHU","175.176.92.247\0\0","2024-12-03 20:00:40","","0","0");
INSERT INTO tbl_user_log VALUES("184","3","RHU","175.176.92.247\0\0","2024-12-03 20:00:48","04-12-2024 04:06:30 AM","1","0");
INSERT INTO tbl_user_log VALUES("185","3","RHU","2001:4456:1ea:aa","2024-12-03 23:57:32","04-12-2024 10:16:51 AM","1","0");
INSERT INTO tbl_user_log VALUES("186","1","admin","2001:4456:1ea:aa","2024-12-04 00:48:13","","1","0");
INSERT INTO tbl_user_log VALUES("187","6","josep123","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:13:55","2024-12-04 10:14:28","1","0");
INSERT INTO tbl_user_log VALUES("188","6","josep123","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:14:32","2024-12-04 10:16:33","1","0");
INSERT INTO tbl_user_log VALUES("189","6","josep123","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:16:37","","1","0");
INSERT INTO tbl_user_log VALUES("190","1","admin","2001:4456:1ea:aa","2024-12-04 02:17:01","04-12-2024 10:29:14 AM","1","0");
INSERT INTO tbl_user_log VALUES("191","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:19:28","2024-12-04 10:20:45","1","0");
INSERT INTO tbl_user_log VALUES("192","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:20:51","2024-12-04 10:21:57","1","0");
INSERT INTO tbl_user_log VALUES("193","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:22:26","2024-12-04 10:23:01","1","0");
INSERT INTO tbl_user_log VALUES("194","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:23:05","2024-12-04 10:23:18","1","0");
INSERT INTO tbl_user_log VALUES("195","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:23:21","2024-12-04 10:25:30","1","0");
INSERT INTO tbl_user_log VALUES("196","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:25:34","2024-12-04 10:25:50","1","0");
INSERT INTO tbl_user_log VALUES("197","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:25:54","2024-12-04 10:26:44","1","0");
INSERT INTO tbl_user_log VALUES("198","9","Baibai","1\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-04 02:27:00","2024-12-04 16:46:58","1","0");
INSERT INTO tbl_user_log VALUES("199","1","admin","2001:4456:1ea:aa","2024-12-04 02:29:18","","1","0");
INSERT INTO tbl_user_log VALUES("200","1","admin","2001:4456:1ea:aa","2024-12-04 02:29:37","","1","0");
INSERT INTO tbl_user_log VALUES("201","","BHW","2001:4456:1ea:aa","2024-12-04 03:49:24","","0","0");
INSERT INTO tbl_user_log VALUES("202","","BHW","2001:4456:1ea:aa","2024-12-04 03:49:26","","0","0");
INSERT INTO tbl_user_log VALUES("203","","BHW","2001:4456:1ea:aa","2024-12-04 03:49:28","","0","0");
INSERT INTO tbl_user_log VALUES("204","2","BHW","2001:4456:1ea:aa","2024-12-04 03:49:31","","1","0");
INSERT INTO tbl_user_log VALUES("205","","BHW","2001:4456:1ea:aa","2024-12-04 03:59:39","","0","0");
INSERT INTO tbl_user_log VALUES("206","","BHW","2001:4456:1ea:aa","2024-12-04 03:59:41","","0","0");
INSERT INTO tbl_user_log VALUES("207","","BHW","2001:4456:1ea:aa","2024-12-04 03:59:42","","0","0");
INSERT INTO tbl_user_log VALUES("208","","BHW","2001:4456:1ea:aa","2024-12-04 03:59:48","","0","0");
INSERT INTO tbl_user_log VALUES("209","2","BHW","2001:4456:1ea:aa","2024-12-04 03:59:52","04-12-2024 12:06:18 PM","1","0");
INSERT INTO tbl_user_log VALUES("210","1","admin","2001:4456:1ea:aa","2024-12-04 04:15:42","04-12-2024 12:30:57 PM","1","0");
INSERT INTO tbl_user_log VALUES("211","","Rhu","131.226.112.89\0\0","2024-12-04 04:27:55","","0","0");
INSERT INTO tbl_user_log VALUES("212","","Rhu","131.226.112.89\0\0","2024-12-04 04:28:03","","0","0");
INSERT INTO tbl_user_log VALUES("213","","Rhu","131.226.112.89\0\0","2024-12-04 04:28:10","","0","0");
INSERT INTO tbl_user_log VALUES("214","","BHW","2001:4456:1ea:aa","2024-12-04 04:34:24","","0","0");
INSERT INTO tbl_user_log VALUES("215","","BHW","2001:4456:1ea:aa","2024-12-04 04:34:42","","0","0");
INSERT INTO tbl_user_log VALUES("216","","BHW","2001:4456:1ea:aa","2024-12-04 04:34:43","","0","0");
INSERT INTO tbl_user_log VALUES("217","","BHW","2001:4456:1ea:aa","2024-12-04 04:34:49","","0","0");
INSERT INTO tbl_user_log VALUES("218","","BHW","2001:4456:1ea:aa","2024-12-04 04:35:06","","0","0");
INSERT INTO tbl_user_log VALUES("219","2","BHW","2001:4456:1ea:aa","2024-12-04 04:35:09","04-12-2024 12:35:16 PM","1","0");
INSERT INTO tbl_user_log VALUES("220","","BHW","2001:4456:1ea:aa","2024-12-04 04:35:23","","0","0");
INSERT INTO tbl_user_log VALUES("221","","BHW","2001:4456:1ea:aa","2024-12-04 04:35:25","","0","0");
INSERT INTO tbl_user_log VALUES("222","","BHW","2001:4456:1ea:aa","2024-12-04 04:35:27","","0","0");
INSERT INTO tbl_user_log VALUES("223","2","BHW","2001:4456:1ea:aa","2024-12-04 04:35:30","04-12-2024 12:37:53 PM","1","0");
INSERT INTO tbl_user_log VALUES("224","","bhw","2001:4456:1ea:aa","2024-12-04 04:38:37","","0","0");
INSERT INTO tbl_user_log VALUES("225","","bhw","2001:4456:1ea:aa","2024-12-04 04:38:40","","0","0");
INSERT INTO tbl_user_log VALUES("226","","bhw","2001:4456:1ea:aa","2024-12-04 04:38:43","","0","0");
INSERT INTO tbl_user_log VALUES("227","2","BHW","2001:4456:1ea:aa","2024-12-04 04:38:50","04-12-2024 12:38:58 PM","1","0");
INSERT INTO tbl_user_log VALUES("228","","leni","2001:4456:1ea:aa","2024-12-04 04:39:19","","0","0");
INSERT INTO tbl_user_log VALUES("229","","leni","2001:4456:1ea:aa","2024-12-04 04:39:38","","0","0");
INSERT INTO tbl_user_log VALUES("230","","leni","2001:4456:1ea:aa","2024-12-04 04:39:40","","0","0");
INSERT INTO tbl_user_log VALUES("231","","leni","2001:4456:1ea:aa","2024-12-04 04:39:42","","0","0");
INSERT INTO tbl_user_log VALUES("232","1","admin","2001:4456:1ea:aa","2024-12-04 04:40:19","04-12-2024 12:40:53 PM","1","0");
INSERT INTO tbl_user_log VALUES("233","5","leni","2001:4456:1ea:aa","2024-12-04 04:41:03","04-12-2024 12:41:07 PM","1","0");
INSERT INTO tbl_user_log VALUES("234","","leni","2001:4456:1ea:aa","2024-12-04 04:42:24","","0","0");
INSERT INTO tbl_user_log VALUES("235","","leni","2001:4456:1ea:aa","2024-12-04 04:42:26","","0","0");
INSERT INTO tbl_user_log VALUES("236","","leni","2001:4456:1ea:aa","2024-12-04 04:42:28","","0","0");
INSERT INTO tbl_user_log VALUES("237","5","leni","2001:4456:1ea:aa","2024-12-04 04:42:30","04-12-2024 01:04:06 PM","1","0");
INSERT INTO tbl_user_log VALUES("238","2","BHW","2001:4456:1ea:aa","2024-12-04 04:47:38","04-12-2024 12:47:45 PM","1","0");
INSERT INTO tbl_user_log VALUES("239","","BHW","2001:4456:1ea:aa","2024-12-04 04:47:46","","0","0");
INSERT INTO tbl_user_log VALUES("240","","BHW","2001:4456:1ea:aa","2024-12-04 04:47:48","","0","0");
INSERT INTO tbl_user_log VALUES("241","","BHW","2001:4456:1ea:aa","2024-12-04 04:47:50","","0","0");
INSERT INTO tbl_user_log VALUES("242","","BHW","2001:4456:1ea:aa","2024-12-04 04:47:54","","0","0");
INSERT INTO tbl_user_log VALUES("243","2","BHW","2001:4456:1ea:aa","2024-12-04 04:47:57","04-12-2024 01:12:48 PM","1","0");
INSERT INTO tbl_user_log VALUES("244","","bhw","2001:4456:1ea:aa","2024-12-04 04:50:01","","0","0");
INSERT INTO tbl_user_log VALUES("245","","bhw","2001:4456:1ea:aa","2024-12-04 04:50:12","","0","0");
INSERT INTO tbl_user_log VALUES("246","","BHW","2001:4456:1ea:aa","2024-12-04 04:50:14","","0","0");
INSERT INTO tbl_user_log VALUES("247","","BHW","2001:4456:1ea:aa","2024-12-04 04:50:18","","0","0");
INSERT INTO tbl_user_log VALUES("248","","BHW","2001:4456:1ea:aa","2024-12-04 05:00:52","","0","0");
INSERT INTO tbl_user_log VALUES("249","","BHW","2001:4456:1ea:aa","2024-12-04 05:00:54","","0","0");
INSERT INTO tbl_user_log VALUES("250","","BHW","2001:4456:1ea:aa","2024-12-04 05:00:58","","0","0");
INSERT INTO tbl_user_log VALUES("251","","BHW","2001:4456:1ea:aa","2024-12-04 05:01:02","","0","0");
INSERT INTO tbl_user_log VALUES("252","5","leni","2001:4456:1ea:aa","2024-12-04 05:04:09","04-12-2024 01:13:07 PM","1","0");
INSERT INTO tbl_user_log VALUES("253","","leni","2001:4456:1ea:aa","2024-12-04 05:04:44","","0","0");
INSERT INTO tbl_user_log VALUES("254","","leni","2001:4456:1ea:aa","2024-12-04 05:04:48","","0","0");
INSERT INTO tbl_user_log VALUES("255","","leni","2001:4456:1ea:aa","2024-12-04 05:04:50","","0","0");
INSERT INTO tbl_user_log VALUES("256","","leni","2001:4456:1ea:aa","2024-12-04 05:04:53","","0","0");
INSERT INTO tbl_user_log VALUES("257","","leni","2001:4456:1ea:aa","2024-12-04 05:04:56","","0","0");
INSERT INTO tbl_user_log VALUES("258","","BHW","2001:4456:1ea:aa","2024-12-04 05:12:31","","0","0");
INSERT INTO tbl_user_log VALUES("259","","BHW","2001:4456:1ea:aa","2024-12-04 05:12:33","","0","0");
INSERT INTO tbl_user_log VALUES("260","","BHW","2001:4456:1ea:aa","2024-12-04 05:12:36","","0","0");
INSERT INTO tbl_user_log VALUES("261","","BHW","2001:4456:1ea:aa","2024-12-04 05:12:39","","0","0");
INSERT INTO tbl_user_log VALUES("262","5","leni","2001:4456:1ea:aa","2024-12-04 05:14:43","","1","0");
INSERT INTO tbl_user_log VALUES("263","","Rhu","131.226.112.89\0\0","2024-12-04 06:11:59","","0","0");
INSERT INTO tbl_user_log VALUES("264","3","RHU","131.226.112.89\0\0","2024-12-04 06:12:18","","1","0");
INSERT INTO tbl_user_log VALUES("265","3","RHU","131.226.112.89\0\0","2024-12-04 06:12:53","","1","0");
INSERT INTO tbl_user_log VALUES("266","2","BHW","2001:4456:1ea:aa","2024-12-04 06:43:57","04-12-2024 02:53:18 PM","1","0");
INSERT INTO tbl_user_log VALUES("267","","leni","2001:4456:1ea:aa","2024-12-04 06:53:23","","0","0");
INSERT INTO tbl_user_log VALUES("268","","leni","2001:4456:1ea:aa","2024-12-04 06:53:24","","0","0");
INSERT INTO tbl_user_log VALUES("269","","leni","2001:4456:1ea:aa","2024-12-04 06:53:26","","0","0");
INSERT INTO tbl_user_log VALUES("270","5","leni","2001:4456:1ea:aa","2024-12-04 06:54:29","04-12-2024 02:55:49 PM","1","0");
INSERT INTO tbl_user_log VALUES("271","5","leni","2001:4456:1ea:aa","2024-12-04 06:55:55","04-12-2024 02:55:57 PM","1","0");
INSERT INTO tbl_user_log VALUES("272","","leni","2001:4456:1ea:aa","2024-12-04 06:55:59","","0","0");
INSERT INTO tbl_user_log VALUES("273","","leni","2001:4456:1ea:aa","2024-12-04 06:56:01","","0","0");
INSERT INTO tbl_user_log VALUES("274","","leni","2001:4456:1ea:aa","2024-12-04 06:56:02","","0","0");
INSERT INTO tbl_user_log VALUES("275","","leni","2001:4456:1ea:aa","2024-12-04 07:02:05","","0","0");
INSERT INTO tbl_user_log VALUES("276","","leni","2001:4456:1ea:aa","2024-12-04 07:02:09","","0","0");
INSERT INTO tbl_user_log VALUES("277","","bhw","2001:4456:1ea:aa","2024-12-04 07:02:33","","0","0");
INSERT INTO tbl_user_log VALUES("278","","bhw","2001:4456:1ea:aa","2024-12-04 07:02:37","","0","0");
INSERT INTO tbl_user_log VALUES("279","2","BHW","2001:4456:1ea:aa","2024-12-04 07:02:42","04-12-2024 03:04:42 PM","1","0");
INSERT INTO tbl_user_log VALUES("280","5","leni","2001:4456:1ea:aa","2024-12-04 07:04:55","04-12-2024 03:04:59 PM","1","0");
INSERT INTO tbl_user_log VALUES("281","","LENI","2001:4456:1ea:aa","2024-12-04 07:05:14","","0","0");
INSERT INTO tbl_user_log VALUES("282","","LENI","2001:4456:1ea:aa","2024-12-04 07:05:17","","0","0");
INSERT INTO tbl_user_log VALUES("283","","LENI","2001:4456:1ea:aa","2024-12-04 07:05:18","","0","0");
INSERT INTO tbl_user_log VALUES("284","5","leni","2001:4456:1ea:aa","2024-12-04 07:05:23","04-12-2024 03:05:31 PM","1","0");
INSERT INTO tbl_user_log VALUES("285","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:08","","0","0");
INSERT INTO tbl_user_log VALUES("286","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:10","","0","0");
INSERT INTO tbl_user_log VALUES("287","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:11","","0","0");
INSERT INTO tbl_user_log VALUES("288","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:13","","0","0");
INSERT INTO tbl_user_log VALUES("289","5","leni","2001:4456:1ea:aa","2024-12-04 07:06:19","04-12-2024 03:06:21 PM","1","0");
INSERT INTO tbl_user_log VALUES("290","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:31","","0","0");
INSERT INTO tbl_user_log VALUES("291","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:32","","0","0");
INSERT INTO tbl_user_log VALUES("292","","LENI","2001:4456:1ea:aa","2024-12-04 07:06:34","","0","0");
INSERT INTO tbl_user_log VALUES("293","5","leni","2001:4456:1ea:aa","2024-12-04 07:15:40","04-12-2024 03:15:52 PM","1","0");
INSERT INTO tbl_user_log VALUES("294","5","leni","2001:4456:1ea:aa","2024-12-04 07:15:54","04-12-2024 03:15:58 PM","1","0");
INSERT INTO tbl_user_log VALUES("295","","leni","2001:4456:1ea:aa","2024-12-04 07:16:17","","0","0");
INSERT INTO tbl_user_log VALUES("296","","leni","2001:4456:1ea:aa","2024-12-04 07:16:19","","0","0");
INSERT INTO tbl_user_log VALUES("297","","leni","2001:4456:1ea:aa","2024-12-04 07:16:22","","0","0");
INSERT INTO tbl_user_log VALUES("298","5","leni","2001:4456:1ea:aa","2024-12-04 07:18:42","04-12-2024 03:18:53 PM","1","0");
INSERT INTO tbl_user_log VALUES("299","1","admin","2001:4456:1ea:aa","2024-12-04 07:19:10","04-12-2024 03:19:37 PM","1","0");
INSERT INTO tbl_user_log VALUES("300","1","admin","2001:4456:1ea:aa","2024-12-04 07:20:08","","1","0");
INSERT INTO tbl_user_log VALUES("301","5","leni","2001:4456:1ea:aa","2024-12-04 07:20:29","04-12-2024 03:23:58 PM","1","0");
INSERT INTO tbl_user_log VALUES("302","12","abubakar","2001:4456:1ea:aa","2024-12-04 07:24:01","","1","0");
INSERT INTO tbl_user_log VALUES("303","","Abubakar","2001:4456:1ea:aa","2024-12-04 07:25:21","","0","0");
INSERT INTO tbl_user_log VALUES("304","","Abubakar","2001:4456:1ea:aa","2024-12-04 07:25:44","","0","0");
INSERT INTO tbl_user_log VALUES("305","12","abubakar","2001:4456:1ea:aa","2024-12-04 07:26:04","04-12-2024 03:29:19 PM","1","0");
INSERT INTO tbl_user_log VALUES("306","","abubakar","2001:4456:1ea:aa","2024-12-04 07:29:23","","0","0");
INSERT INTO tbl_user_log VALUES("307","","abubakar","2001:4456:1ea:aa","2024-12-04 07:29:29","","0","0");
INSERT INTO tbl_user_log VALUES("308","","abubakar","2001:4456:1ea:aa","2024-12-04 07:29:31","","0","0");
INSERT INTO tbl_user_log VALUES("309","12","abubakar","2001:4456:1ea:aa","2024-12-04 07:29:38","04-12-2024 03:29:43 PM","1","0");
INSERT INTO tbl_user_log VALUES("310","12","abubakar","2001:4456:1ea:aa","2024-12-04 07:31:17","04-12-2024 03:31:37 PM","1","0");
INSERT INTO tbl_user_log VALUES("311","","abubakar","2001:4456:1ea:aa","2024-12-04 07:31:46","","0","0");
INSERT INTO tbl_user_log VALUES("312","","abubakar","2001:4456:1ea:aa","2024-12-04 07:31:48","","0","0");
INSERT INTO tbl_user_log VALUES("313","","abubakar","2001:4456:1ea:aa","2024-12-04 07:31:49","","0","0");
INSERT INTO tbl_user_log VALUES("314","","","2001:4456:1ea:aa","2024-12-04 08:47:07","","0","0");
INSERT INTO tbl_user_log VALUES("315","","","2001:4456:1ea:aa","2024-12-04 08:47:09","","0","0");
INSERT INTO tbl_user_log VALUES("316","","","2001:4456:1ea:aa","2024-12-04 08:47:09","","0","0");
INSERT INTO tbl_user_log VALUES("317","","","2001:4456:1ea:aa","2024-12-04 08:47:10","","0","0");
INSERT INTO tbl_user_log VALUES("318","","","2001:4456:1ea:aa","2024-12-04 08:47:11","","0","0");
INSERT INTO tbl_user_log VALUES("319","","","2001:4456:1ea:aa","2024-12-04 08:47:11","","0","0");
INSERT INTO tbl_user_log VALUES("320","","","2001:4456:1ea:aa","2024-12-04 08:47:12","","0","0");
INSERT INTO tbl_user_log VALUES("321","","","2001:4456:1ea:aa","2024-12-04 08:47:52","","0","0");
INSERT INTO tbl_user_log VALUES("322","","Baibai","2001:4456:1ea:aa","2024-12-04 08:53:33","","0","0");
INSERT INTO tbl_user_log VALUES("323","","Baibai","2001:4456:1ea:aa","2024-12-04 08:53:35","","0","0");
INSERT INTO tbl_user_log VALUES("324","","Baibai","2001:4456:1ea:aa","2024-12-04 08:53:36","","0","0");
INSERT INTO tbl_user_log VALUES("325","9","Baibai","2001:4456:1ea:aa","2024-12-04 08:56:55","2024-12-04 17:02:54","1","0");
INSERT INTO tbl_user_log VALUES("326","9","Baibai","2001:4456:1ea:aa","2024-12-04 08:57:02","2024-12-04 17:02:54","1","0");
INSERT INTO tbl_user_log VALUES("327","9","Baibai","2001:4456:1ea:aa","2024-12-04 08:57:37","2024-12-04 17:02:54","1","0");
INSERT INTO tbl_user_log VALUES("328","9","Baibai","2001:4456:1ea:aa","2024-12-04 08:57:51","2024-12-04 17:02:54","1","0");
INSERT INTO tbl_user_log VALUES("329","1","admin","2001:4456:1ea:aa","2024-12-04 08:58:28","04-12-2024 05:11:06 PM","1","0");
INSERT INTO tbl_user_log VALUES("330","8","Erlinda","2001:4456:1ea:aa","2024-12-04 08:59:32","2024-12-04 17:04:09","1","0");
INSERT INTO tbl_user_log VALUES("331","9","Baibai","2001:4456:1ea:aa","2024-12-04 09:02:42","2024-12-04 17:02:54","1","0");
INSERT INTO tbl_user_log VALUES("332","","Baibai","2001:4456:1ea:aa","2024-12-04 09:03:01","","0","0");
INSERT INTO tbl_user_log VALUES("333","","Baibai","2001:4456:1ea:aa","2024-12-04 09:03:02","","0","0");
INSERT INTO tbl_user_log VALUES("334","","Baibai","2001:4456:1ea:aa","2024-12-04 09:03:02","","0","0");
INSERT INTO tbl_user_log VALUES("335","8","Erlinda","2001:4456:1ea:aa","2024-12-04 09:03:36","2024-12-04 17:04:09","1","0");
INSERT INTO tbl_user_log VALUES("336","8","Erlinda","2001:4456:1ea:aa","2024-12-04 09:04:12","2024-12-04 17:05:51","1","0");
INSERT INTO tbl_user_log VALUES("337","9","Baibai","2001:4456:1ea:aa","2024-12-04 09:07:21","2024-12-04 17:36:27","1","0");
INSERT INTO tbl_user_log VALUES("338","","Erlinda","175.176.92.199\0\0","2024-12-04 09:36:35","","0","0");
INSERT INTO tbl_user_log VALUES("339","","Erlinda","175.176.92.199\0\0","2024-12-04 09:36:36","","0","0");
INSERT INTO tbl_user_log VALUES("340","","Erlinda","175.176.92.199\0\0","2024-12-04 09:36:38","","0","0");
INSERT INTO tbl_user_log VALUES("341","8","Erlinda","175.176.92.199\0\0","2024-12-04 10:13:00","2024-12-04 18:13:03","1","0");
INSERT INTO tbl_user_log VALUES("342","","Erlinda","175.176.92.199\0\0","2024-12-04 10:13:11","","0","0");
INSERT INTO tbl_user_log VALUES("343","","Erlinda","175.176.92.199\0\0","2024-12-04 10:13:11","","0","0");
INSERT INTO tbl_user_log VALUES("344","","Erlinda","175.176.92.199\0\0","2024-12-04 10:13:12","","0","0");
INSERT INTO tbl_user_log VALUES("345","","leni","175.176.92.199\0\0","2024-12-04 10:55:24","","0","0");
INSERT INTO tbl_user_log VALUES("346","","leni","175.176.92.199\0\0","2024-12-04 10:55:26","","0","0");
INSERT INTO tbl_user_log VALUES("347","","leni","175.176.92.199\0\0","2024-12-04 10:55:28","","0","0");
INSERT INTO tbl_user_log VALUES("348","5","leni","175.176.92.199\0\0","2024-12-04 10:55:33","04-12-2024 07:06:36 PM","1","0");
INSERT INTO tbl_user_log VALUES("349","","leni","175.176.92.199\0\0","2024-12-04 11:14:00","","0","0");
INSERT INTO tbl_user_log VALUES("350","","leni","175.176.92.199\0\0","2024-12-04 11:14:02","","0","0");
INSERT INTO tbl_user_log VALUES("351","","leni","175.176.92.199\0\0","2024-12-04 11:14:03","","0","0");
INSERT INTO tbl_user_log VALUES("352","5","leni","175.176.92.199\0\0","2024-12-04 11:14:40","04-12-2024 07:14:43 PM","1","0");
INSERT INTO tbl_user_log VALUES("353","5","leni","175.176.92.199\0\0","2024-12-04 11:15:38","04-12-2024 07:15:48 PM","1","0");
INSERT INTO tbl_user_log VALUES("354","5","leni","175.176.92.199\0\0","2024-12-04 11:16:36","04-12-2024 07:17:06 PM","1","0");
INSERT INTO tbl_user_log VALUES("355","","admin","175.176.92.199\0\0","2024-12-04 11:16:45","","0","0");
INSERT INTO tbl_user_log VALUES("356","1","admin","175.176.92.199\0\0","2024-12-04 11:16:50","04-12-2024 07:19:42 PM","1","0");
INSERT INTO tbl_user_log VALUES("357","","abubakar","175.176.92.199\0\0","2024-12-04 11:17:25","","0","0");
INSERT INTO tbl_user_log VALUES("358","5","leni","175.176.92.199\0\0","2024-12-04 11:18:26","04-12-2024 07:18:42 PM","1","0");
INSERT INTO tbl_user_log VALUES("359","12","abubakar","175.176.92.199\0\0","2024-12-04 11:21:04","04-12-2024 07:21:11 PM","1","0");
INSERT INTO tbl_user_log VALUES("360","3","RHU","131.226.112.89\0\0","2024-12-04 11:21:23","04-12-2024 07:21:27 PM","1","0");
INSERT INTO tbl_user_log VALUES("361","8","Erlinda","175.176.92.199\0\0","2024-12-04 11:22:03","2024-12-04 19:22:07","1","0");
INSERT INTO tbl_user_log VALUES("362","","Cccff","131.226.112.89\0\0","2024-12-04 11:22:07","","0","0");
INSERT INTO tbl_user_log VALUES("363","","Cccc","131.226.112.89\0\0","2024-12-04 11:22:12","","0","0");
INSERT INTO tbl_user_log VALUES("364","","Erlinda","175.176.92.199\0\0","2024-12-04 11:22:13","","0","0");
INSERT INTO tbl_user_log VALUES("365","","Erlinda","175.176.92.199\0\0","2024-12-04 11:22:14","","0","0");
INSERT INTO tbl_user_log VALUES("366","","Erlinda","175.176.92.199\0\0","2024-12-04 11:22:15","","0","0");
INSERT INTO tbl_user_log VALUES("367","","Cccc","131.226.112.89\0\0","2024-12-04 11:22:17","","0","0");
INSERT INTO tbl_user_log VALUES("368","","Ccccc","131.226.112.89\0\0","2024-12-04 11:22:21","","0","0");
INSERT INTO tbl_user_log VALUES("369","12","abubakar","175.176.92.199\0\0","2024-12-04 11:23:13","04-12-2024 07:23:16 PM","1","0");
INSERT INTO tbl_user_log VALUES("370","","abubakar","175.176.92.199\0\0","2024-12-04 11:23:20","","0","0");
INSERT INTO tbl_user_log VALUES("371","","abubakar","175.176.92.199\0\0","2024-12-04 11:23:22","","0","0");
INSERT INTO tbl_user_log VALUES("372","","abubakar","175.176.92.199\0\0","2024-12-04 11:23:25","","0","0");
INSERT INTO tbl_user_log VALUES("373","1","admin","175.176.92.199\0\0","2024-12-04 11:54:42","04-12-2024 08:48:29 PM","1","0");
INSERT INTO tbl_user_log VALUES("374","9","Baibai","175.176.92.199\0\0","2024-12-04 11:55:36","","1","0");
INSERT INTO tbl_user_log VALUES("375","5","leni","175.176.92.199\0\0","2024-12-04 12:43:41","04-12-2024 08:44:55 PM","1","0");
INSERT INTO tbl_user_log VALUES("376","2","BHW","175.176.92.199\0\0","2024-12-04 12:45:02","04-12-2024 08:46:40 PM","1","0");
INSERT INTO tbl_user_log VALUES("377","12","abubakar","175.176.92.199\0\0","2024-12-04 12:49:00","04-12-2024 08:51:16 PM","1","0");
INSERT INTO tbl_user_log VALUES("378","","abubakar","175.176.92.199\0\0","2024-12-04 12:51:22","","0","0");
INSERT INTO tbl_user_log VALUES("379","","abubakar","175.176.92.199\0\0","2024-12-04 12:51:25","","0","0");
INSERT INTO tbl_user_log VALUES("380","","abubakar","175.176.92.199\0\0","2024-12-04 12:51:27","","0","0");
INSERT INTO tbl_user_log VALUES("381","5","leni","175.176.92.199\0\0","2024-12-04 12:52:06","04-12-2024 08:53:20 PM","1","0");
INSERT INTO tbl_user_log VALUES("382","1","admin","175.176.92.199\0\0","2024-12-04 12:53:37","","1","0");
INSERT INTO tbl_user_log VALUES("383","1","admin","175.176.92.199\0\0","2024-12-04 12:56:31","04-12-2024 08:56:50 PM","1","0");
INSERT INTO tbl_user_log VALUES("384","1","admin","175.176.92.199\0\0","2024-12-04 12:57:03","04-12-2024 08:58:39 PM","1","0");
INSERT INTO tbl_user_log VALUES("385","2","BHW","175.176.92.199\0\0","2024-12-04 12:58:53","04-12-2024 09:02:37 PM","1","0");
INSERT INTO tbl_user_log VALUES("386","1","admin","175.176.92.199\0\0","2024-12-04 13:02:44","","1","0");
INSERT INTO tbl_user_log VALUES("387","8","Erlinda","175.176.92.199\0\0","2024-12-04 13:05:33","2024-12-04 21:05:45","1","0");
INSERT INTO tbl_user_log VALUES("388","8","Erlinda","175.176.92.199\0\0","2024-12-04 13:05:59","","1","0");
INSERT INTO tbl_user_log VALUES("389","1","admin","175.176.92.199\0\0","2024-12-04 13:10:21","","1","0");
INSERT INTO tbl_user_log VALUES("390","1","admin","175.176.92.199\0\0","2024-12-04 13:10:38","04-12-2024 09:11:39 PM","1","0");
INSERT INTO tbl_user_log VALUES("391","1","admin","175.176.92.199\0\0","2024-12-04 13:15:37","","1","0");



DROP TABLE IF EXISTS tbl_user_page;

CREATE TABLE `tbl_user_page` (
  `userpageID` int(11) NOT NULL AUTO_INCREMENT,
  `home_img` varchar(100) NOT NULL,
  `sidebar` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `headerColor` varchar(100) NOT NULL,
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`userpageID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_page VALUES("1","Screenshot 2024-11-21 094125.png","BRGY. LAMPARE","5","#6519c2","0");
INSERT INTO tbl_user_page VALUES("2","FB_IMG_1733227823220.jpg","Manili","12","#1c596d","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_users VALUES("1","admin","admin","$2a$12$piDPv0I3muQYv5z613q/Ru0B2z1dtnYzJ3r/XrvltmGuJ1fjQ8Z4e","Active","ic_doctor.png","1","1","0","2024-12-01 05:47:10","0","","0","2024-12-04 07:03:56","");
INSERT INTO tbl_users VALUES("2","BHW","RHU","$2y$10$USbkIdtfXITuJpxVzjuVNuDl3Lq8eH78.8nxtrPV3plxHQ8vBCij2","Active","box-img2.jpg","2","1","2","2024-12-01 05:48:18","0","","0","2024-12-04 07:02:42","");
INSERT INTO tbl_users VALUES("3","RHU","RHU","$2y$10$yGaKtJuF1f..s64.E0RsEesuiR8BV5aXrKHZ3lAlFH0qPtR7ocB0m","Active","","3","2","0","2024-12-01 05:48:37","0","","0","2024-12-04 07:04:00","");
INSERT INTO tbl_users VALUES("5","leni","BHW","$2y$10$Zkmxkrs/CGuKDfn6Wl9SnuwytAyszqrxvWFDmbaihlhlRqMdIvMD.","Active","photo1718592536 (3).jpeg","5","4","1","2024-12-01 06:03:49","0","2024-12-04 11:14:40","0","2024-12-04 11:14:40","");
INSERT INTO tbl_users VALUES("7","Gerald","Physician","","Active","","7","6","0","2024-12-02 00:56:14","0","","0","2024-12-04 07:04:04","");
INSERT INTO tbl_users VALUES("8","Erlinda","Doctor","$2y$10$voSPitgNl/APKmlhJ6JSjOOsvSjdH5O54f2elllgbI9t.ymOTY2dS","Active","","8","7","0","2024-12-02 01:00:00","0","","0","2024-12-04 13:05:33","");
INSERT INTO tbl_users VALUES("9","Baibai","Doctor","$2y$10$ueYxLCvwF81HgfcS6gIk.OVky56M2M1sp3qXIvu9J9HgxrC.thtHO","Active","ProfilePhoto.jpg","11","11","0","2024-12-02 12:34:24","0","","0","2024-12-04 09:07:21","");
INSERT INTO tbl_users VALUES("10","Wakwak","Midwife","$2y$10$F.oelIfQKYrAyHQZC/vA2.qTaH8Ts3g8YdnjLsOeq8EZJOzKPTb6W","Active","674db152dd3b3.jpg","10","9","0","2024-12-02 13:01:12","0","","0","2024-12-04 07:04:10","");
INSERT INTO tbl_users VALUES("12","abubakar","BHW","$2y$10$kwpx2irdLCAs.rNla8V0Bu1d4hSJThXbWY1KmF6TqZdQvoWWt.3di","Active","Untitled.png","12","12","2","2024-12-04 07:23:54","3","","0","2024-12-04 12:51:27","2024-12-04 20:54:27");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_vitalsigns_monitoring VALUES("1","203","2024-12-03","07:13:00","120/90","22","22","22","22","22","22","22","8","1","1","2024-12-02 23:13:48","0");
INSERT INTO tbl_vitalsigns_monitoring VALUES("2","22","2024-12-03","19:03:00","120/80","2","2","2","2","2","2","2","8","6","2","2024-12-03 11:03:54","0");



