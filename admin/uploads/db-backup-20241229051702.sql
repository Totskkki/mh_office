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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




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
  `sync_status` int(11) DEFAULT 0,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




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
  `sync_status` int(11) DEFAULT 0,
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
  KEY `userID` (`userID`)
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO tbl_medicine_details VALUES("1","1","10","938","0");
INSERT INTO tbl_medicine_details VALUES("2","2","Pack of 10 Tablets","1993","0");
INSERT INTO tbl_medicine_details VALUES("3","6","Blister Pack of 10 Capsules","3000","0");
INSERT INTO tbl_medicine_details VALUES("4","5","1mL Single-Dose Vial, Box of 5 Vials","4998","0");
INSERT INTO tbl_medicine_details VALUES("5","4","1mL Ampoule, Box of 10 Ampoules","1011","0");
INSERT INTO tbl_medicine_details VALUES("6","3","Blister Pack of 30 Tablets","5002","0");
INSERT INTO tbl_medicine_details VALUES("7","8","90","120","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
INSERT INTO tbl_medicines VALUES("12","Test","Test","Test","Analgesics","2024-12-09","2024-12-18","test","test","1","2024-12-20 13:31:58","0");



DROP TABLE IF EXISTS tbl_membership_info;

CREATE TABLE `tbl_membership_info` (
  `membershipID` int(11) NOT NULL AUTO_INCREMENT,
  `phil_mem` varchar(50) NOT NULL,
  `philhealth_no` varchar(255) DEFAULT NULL,
  `phil_membership` varchar(100) DEFAULT NULL,
  `ps_mem` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `sync_status` int(11) DEFAULT 0,
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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`patient_med_historyID`),
  KEY `patient_visit_id` (`patient_visit_id`),
  KEY `medicine_details_id` (`medicine_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




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
  `sync_status` int(11) DEFAULT 0,
  PRIMARY KEY (`personnel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_personnel VALUES("1","Lutayan","A.","RHU-admin","1234567890","admin@example.com","123 Admin St","0");
INSERT INTO tbl_personnel VALUES("2","Irlan","Santos","Cruz","+632131321321","drc123@gmail.com","south cotabato","0");
INSERT INTO tbl_personnel VALUES("3","Loreine","A","Santos","+639999999999","mariar.reyes@example.com","Marbel","0");
INSERT INTO tbl_personnel VALUES("4","Jerom","","Badio","+639451234567","rhu123@gmail","Rhu123rhu123","0");
INSERT INTO tbl_personnel VALUES("5","John","","Erwe","+635434563465","John@gmail.com","lutayan Sultan kudarat","0");
INSERT INTO tbl_personnel VALUES("6","ricardo","","saliling","+639633252321","ricardo@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("7","Nicole","","Dela Cruz","+639653232154","Nicole@gmail.com","Lutayan Sultan Kudarat","0");
INSERT INTO tbl_personnel VALUES("8","Sandara","","Raquim","+639653212228","Sandara@gmail.com","koronadal city , south cotabato","0");
INSERT INTO tbl_personnel VALUES("9","Rose","Cy","Lopez","+639453457245","rosecylopez19@gmail.com","Brgy. Blingkong Lutayan, Sultan Kudarat","0");



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

INSERT INTO tbl_position VALUES("1","1","Administrator","N/A","Professional Admin","12345","0");
INSERT INTO tbl_position VALUES("2","2","Doctor","Family Picture","M.D","0123","0");
INSERT INTO tbl_position VALUES("3","3","","","","","0");
INSERT INTO tbl_position VALUES("4","4","","","","","0");
INSERT INTO tbl_position VALUES("5","5","Doctor","Family doctor","M.D","9632659862","0");
INSERT INTO tbl_position VALUES("6","6","Physician","Physician","Physician","","0");
INSERT INTO tbl_position VALUES("7","7","Midwife","Midwife","Midwife","","0");
INSERT INTO tbl_position VALUES("8","8","Nurse","Certified Nurse","Nurse","","0");
INSERT INTO tbl_position VALUES("9","9","","","","","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_user_log VALUES("1","3","bhw123","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-29 05:16:06","","1","0");
INSERT INTO tbl_user_log VALUES("2","1","administrator","::1\0\0\0\0\0\0\0\0\0\0\0\0\0","2024-12-29 05:16:29","","1","0");



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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tbl_users VALUES("1","administrator","admin","$2a$12$SXm.VE78VdZGzVif9V2G/OZLlp1LGlHAYA7F7sHQT/HTEdCl6xbeK","Active","462576482_1255523679046233_1002729174393918453_n.png","1","1","0","2024-12-09 10:55:51","0","0000-00-00 00:00:00","0","2024-12-29 05:16:48","");
INSERT INTO tbl_users VALUES("2","drcruz21","Doctor","$2y$10$QF.ILK2lMn5vEkH5X0qt9eeNYoqdm/cOYXfS5bPG4jIlNyUXMY0v2","Active","../user_images/676e4ec82d6b2_profile_pic5758276332707777082.jpg","2","2","0","2024-12-09 10:58:26","0","0000-00-00 00:00:00","0","2024-12-28 08:43:55","");
INSERT INTO tbl_users VALUES("3","bhw123","BHW","$2y$10$l8JV7LK458Cyod5T5I6bMeZTardL/Gah.zQI3kuoJR5zLGFSNJS1u","Active","","3","3","0","2024-12-09 11:00:26","0","0000-00-00 00:00:00","0","2024-12-26 01:57:31","");
INSERT INTO tbl_users VALUES("4","rhu123","RHU","$2y$10$giM9NBTfrvbLQTwHpDaUlOMsRchU0cZjtjPovmcMVTOMJisQf3gam","Active","","4","4","0","2024-12-11 02:28:42","0","0000-00-00 00:00:00","0","2024-12-26 02:00:08","");
INSERT INTO tbl_users VALUES("5","Qwerty","Doctor","$2y$10$uvvlGbNhwLJmdbGCR2Zqs.XHTwCi/xaV7Ay3vaWoi3sMaBLicO882","Active","tg logo.png","5","5","","2024-12-28 14:09:10","0","","0","2024-12-28 14:15:18","");
INSERT INTO tbl_users VALUES("6","Ricardo","Physician","","Active","","6","6","","2024-12-28 14:13:50","0","","0","","");
INSERT INTO tbl_users VALUES("7","Nicole","Midwife","","Active","","7","7","","2024-12-28 14:19:06","0","","0","","");
INSERT INTO tbl_users VALUES("8","Sandara","Nurse","","Active","","8","8","","2024-12-28 14:19:55","0","","0","","");
INSERT INTO tbl_users VALUES("9","Roselopez123","BHW","$2y$10$XnIcOmRHHG6XafLXY7cZQ.9Qy1KO26AbZU8EoxgOgAe0FBmwdWkD.","Active","Screenshot 2024-11-18 135427.png","9","9","","2024-12-28 14:47:21","0","","0","2024-12-28 14:48:42","");



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




