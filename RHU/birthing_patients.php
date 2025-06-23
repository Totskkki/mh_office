<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['birthID'])) {
    $id = $_POST['birthID'];
    $queryUsers = "SELECT b.*,com.*, bm.admission_date
     FROM tbl_birth_info b
     LEFT JOIN tbl_complaints com on com.patient_id = b.patient_id
     LEFT JOIN tbl_birthing_monitoring bm on bm.patient_id= b.patient_id
    
     WHERE b.patient_id = :id";

    $stmtUsers = $con->prepare($queryUsers);
    $stmtUsers->execute([':id' => $id]);
    $row = $stmtUsers->fetch(PDO::FETCH_ASSOC);

    echo json_encode($row);
    exit;
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT  pat.*,fam.*,mem.*,com.*,
    CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
    DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`
FROM   `tbl_patients` AS pat
    left JOIN  `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
    left JOIN   `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
    left  JOIN `tbl_complaints` as com ON pat.`patientID` = com.`patient_id`

WHERE     pat.`patientID` = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $patientData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details


    // Fetch vital signs data
    $vitalSignsQuery = "SELECT vitals.*,u.*,p.*,b.* 
    FROM tbl_vitalsigns_monitoring vitals
    LEFT JOIN tbl_users u on u.userID = vitals.nurse_midwife
    LEFT JOIN tbl_personnel p on p.personnel_id = u.personnel_id 
     LEFT JOIN tbl_birth_info b ON b.birth_info_id = vitals.birth_info_id
    WHERE vitals.patient_id = :id
    AND b.birthing_status = 'ongoing'
     ORDER BY vitals.vitalSignsID  DESC";

    $stmt = $con->prepare($vitalSignsQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $vitalSignsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $MedicationQuery = "SELECT brithMeds.*,m.*,md.*,b.*
     FROM tbl_birthing_medication brithMeds
    LEFT JOIN tbl_medicines m on m.medicineID  = brithMeds.medicineID
    LEFT JOIN tbl_medicine_details md on md.med_detailsID  = m.medicineID  
      LEFT JOIN tbl_birth_info b ON b.birth_info_id = brithMeds.birth_info_id
    WHERE brithMeds.patient_id = :id
    AND b.birthing_status = 'ongoing'
     ORDER BY brithMeds.medicationID DESC";
    $stmt = $con->prepare($MedicationQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $MedicationsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $medProcedure = '';
    $Specimen = '';

    // Check if there is any data
    if (!empty($MedicationsData)) {
        // Assuming you want to use the data from the most recent record
        $mostRecentData = $MedicationsData[0];
        $medProcedure = isset($mostRecentData['medProcedure']) ? htmlspecialchars($mostRecentData['medProcedure']) : '';
        $Specimen = isset($mostRecentData['Specimen']) ? htmlspecialchars($mostRecentData['Specimen']) : '';
    }

    $IVFluidsQuery = "SELECT iv.*,b.* 
    FROM tbl_birth_ivfluids iv
    LEFT JOIN tbl_birth_info b ON b.birth_info_id = iv.birth_info_id
    WHERE iv.patient_id = :id
    AND b.birthing_status = 'ongoing'
    ORDER BY fluidsID  DESC";
    $stmt = $con->prepare($IVFluidsQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $IVFluidsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $birthMonitoringQuery = " SELECT birth.*, u.*, p.*, b.* 
    FROM tbl_birthing_monitoring birth
    LEFT JOIN tbl_users u ON u.userID = birth.patient_id
    LEFT JOIN tbl_personnel p ON p.personnel_id = u.personnel_id 
    LEFT JOIN tbl_birth_info b ON b.birth_info_id = birth.birth_info_id
    WHERE birth.patient_id = :id
    AND b.birthing_status = 'ongoing'
    ORDER BY birth.birthMonitorID DESC";

    $stmt = $con->prepare($birthMonitoringQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $monitoringRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $birtDeliveryQuery = "SELECT birth.*,u.*,p.*,b.*
     FROM tbl_birthroom birth
    LEFT JOIN tbl_users u on u.userID = birth.patient_id
    LEFT JOIN tbl_personnel p on p.personnel_id = u.personnel_id 
    LEFT JOIN tbl_birth_info b ON b.birth_info_id = birth.birth_info_id
    WHERE birth.patient_id = :id
    AND b.birthing_status = 'ongoing'
    ORDER BY birth.roomID  DESC";
    $stmt = $con->prepare($birtDeliveryQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $DeliveryRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $postpartumQuery = "SELECT pos.*,b.* 
    FROM tbl_postpartum  pos
     LEFT JOIN tbl_birth_info b ON b.birth_info_id = pos.birth_info_id
    WHERE pos.patient_id = :id
    AND b.birthing_status = 'ongoing'
    ORDER BY pos.postpartumID  DESC";
    $stmt = $con->prepare($postpartumQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $postpartumData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



if (isset($_POST['saveLabour'])) {

    $patientID = trim($_POST['patientid']);
    $case_no = trim($_POST['case_no']);
    $parity = trim($_POST['parity']);
    $addmissiondate = trim($_POST['addmissiondate']);
    $admissionTime = trim($_POST['admissionTime']);
    $timeactive = trim($_POST['timeactive']);
    $timeMembranes = trim($_POST['timeMembranes']);
    $timeSecond = trim($_POST['timeSecond']);
    $birth_time = trim($_POST['birthTime']);
    $Oxytocin = trim($_POST['Oxytocin']);
    $placentaComplete = trim($_POST['placentaComplete']);
    $Estimated = trim($_POST['Estimated']);

    $timedelevered = trim($_POST['timedelevered']);
    $Livebirth = trim($_POST['Livebirth']);
    $RESUSCITATION = trim($_POST['RESUSCITATION']);

    $birthweight = trim($_POST['birthweight']);
    $Preterm = trim($_POST['Preterm']);
    $secondbaby = trim($_POST['secondbaby']);
    $newbord = trim($_POST['newbord']);

    // ENTRY EXAMINATION
    $stage_of_labour = trim($_POST['stage_of_labour']);
    $ruptured_membranes = isset($_POST['ruptured_membranes']) ? json_encode($_POST['ruptured_membranes']) : json_encode([]);
    $vaginal_bleeding = isset($_POST['vaginal_bleeding']) ? json_encode($_POST['vaginal_bleeding']) : json_encode([]);
    $strong_contractions = isset($_POST['strong_contractions']) ? json_encode($_POST['strong_contractions']) : json_encode([]);
    $fetal_heart_rate = isset($_POST['fetal_heart_rate']) ? json_encode($_POST['fetal_heart_rate']) : json_encode([]);
    $temperature_axillary = isset($_POST['temperature_axillary']) ? json_encode($_POST['temperature_axillary']) : json_encode([]);
    $pulse = isset($_POST['pulse']) ? json_encode($_POST['pulse']) : json_encode([]);
    $respiratory_rate = isset($_POST['respiratory_rate']) ? json_encode($_POST['respiratory_rate']) : json_encode([]);
    $blood_pressure = isset($_POST['blood_pressure']) ? json_encode($_POST['blood_pressure']) : json_encode([]);
    $urine_voided = isset($_POST['urine_voided']) ? json_encode($_POST['urine_voided']) : json_encode([]);
    $cervical_dilatation = isset($_POST['cervical_dilatation']) ? json_encode($_POST['cervical_dilatation']) : json_encode([]);
    $maternalplan = trim($_POST['maternalplan']);
    $problem = trim($_POST['problem']);
    $time_onset = trim($_POST['time_onset']);
    $treatments = trim($_POST['treatments']);
    $referral_details = trim($_POST['referral_details']);

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientID);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }


        $stmt = $con->prepare("INSERT INTO `tbl_birthing_monitoring`(`birth_info_id`,`case_no`,`patient_id`, `parity`, `admission_date`, `admission_time`, `time_active`, `time_membranes`, `time_second`,`birth_time`, `oxytocin`, `placenta_complete`, `estimated`, `time_delivered`, `live_birth`,`RESUSCITATION`, `birth_weight`, `preterm`, `second_baby`, `newborn`, `stage_of_labour`, `ruptured_membranes`, `vaginal_bleeding`, `strong_contractions`, `fetal_heart_rate`, `temperature_axillary`, `pulse`, `respiratory_rate`, `blood_pressure`, `urine_voided`, `cervical_dilatation`, `maternal_plan`, `problem`, `time_onset`, `treatments`, `referral_details`)
        VALUES (:birth_info_id,:case_no,:patient_id, :parity, :admission_date, :admission_time, :time_active, :time_membranes, :time_second,:birth_time, :oxytocin, :placenta_complete, :estimated, :time_delivered, :live_birth,:RESUSCITATION, :birth_weight, :preterm, :second_baby, :newborn, :stage_of_labour, :ruptured_membranes, :vaginal_bleeding, :strong_contractions, :fetal_heart_rate, :temperature_axillary, :pulse, :respiratory_rate, :blood_pressure, :urine_voided, :cervical_dilatation, :maternal_plan, :problem, :time_onset, :treatments, :referral_details)");

        $stmt->execute([
            ':birth_info_id' => $birth_info_id,
            ':case_no' => $case_no,
            ':patient_id' => $patientID,
            ':parity' => $parity,
            ':admission_date' => $addmissiondate,
            ':admission_time' => $admissionTime,
            ':time_active' => $timeactive,
            ':time_membranes' => $timeMembranes,
            ':time_second' => $timeSecond,
            ':birth_time' => $birth_time,
            ':oxytocin' => $Oxytocin,
            ':placenta_complete' => $placentaComplete,
            ':estimated' => $Estimated,
            ':time_delivered' => $timedelevered,
            ':live_birth' => $Livebirth,
            ':RESUSCITATION' => $RESUSCITATION,
            ':birth_weight' => $birthweight,
            ':preterm' => $Preterm,
            ':second_baby' => $secondbaby,
            ':newborn' => $newbord,
            ':stage_of_labour' => $stage_of_labour,
            ':ruptured_membranes' => $ruptured_membranes,
            ':vaginal_bleeding' => $vaginal_bleeding,
            ':strong_contractions' => $strong_contractions,
            ':fetal_heart_rate' => $fetal_heart_rate,
            ':temperature_axillary' => $temperature_axillary,
            ':pulse' => $pulse,
            ':respiratory_rate' => $respiratory_rate,
            ':blood_pressure' => $blood_pressure,
            ':urine_voided' => $urine_voided,
            ':cervical_dilatation' => $cervical_dilatation,
            ':maternal_plan' => $maternalplan,
            ':problem' => $problem,
            ':time_onset' => $time_onset,
            ':treatments' => $treatments,
            ':referral_details' => $referral_details,

        ]);
        $con->commit();

        $_SESSION['status'] = "Submitted successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}



$midwife = getNurseMidwife($con);
$getphysician = getphysician($con);



if (isset($_POST['saveVitals'])) {
    $patientID = trim($_POST['patientID']);
    $room = $_POST['room'];
    $date_shift = $_POST['Date_Shift'];
    $time = $_POST['Time'];
    $bp = $_POST['BP'];
    $cr = $_POST['CR'];
    $rr = $_POST['RR'];
    $temp = $_POST['Temp'];
    $fht = $_POST['FHT'];
    $duration = $_POST['Duration'];
    $frequency = $_POST['Frequency'];
    $intensity = $_POST['Intensity'];
    $nurse_midwife_signature = $_POST['Nurse_Midwife'];
    $row_status = $_POST['row_status'];

    // Validate that there is at least one set of vital signs data
    $hasData = false;
    for ($i = 0; $i < count($date_shift); $i++) {
        if (!empty($date_shift[$i]) && !empty($time[$i])) {
            $hasData = true;
            break;
        }
    }

    if (!$hasData) {
        $_SESSION['status'] = "At least one set of vital signs data must be provided.";
        $_SESSION['status_code'] = "error";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    }

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientID);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }


        $stmt = $con->prepare("INSERT INTO tbl_vitalsigns_monitoring (`room`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `fht`, `duration`, `frequency`, `intensity`, `nurse_midwife`, `patient_id`,`birth_info_id`)
        VALUES (:room, :date_shift, :time, :bp, :cr, :rr, :temp, :fht, :duration,:frequency, :intensity,:nurse_midwife_signature,:patient_id,:birth_info_id)");

        // Loop through each row and insert into the database
        for ($i = 0; $i < count($date_shift); $i++) {
            // Check if the row is new
            if ($row_status[$i] === 'new') {
                $stmt->execute([
                    ':room' => $room,
                    ':date_shift' => $date_shift[$i],
                    ':time' =>  $time[$i],
                    ':bp' => $bp[$i],
                    ':cr' => $cr[$i],
                    ':rr' => $rr[$i],
                    ':temp' => $temp[$i],
                    ':fht' => $fht[$i],
                    ':duration' => $duration[$i],
                    ':frequency' => $frequency[$i],
                    ':intensity' =>  $intensity[$i],
                    ':nurse_midwife_signature' =>   $nurse_midwife_signature[$i],
                    ':patient_id' =>   $patientID,
                    ':birth_info_id' =>  $birth_info_id,
                ]);
            }
        }

        $con->commit();
        $_SESSION['status'] = "Vital Signs added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}


$physician = getNurseMidwife($con);
$medicine = getMedication($con);
$doctor = getDOctor1($con);


if (isset($_POST['savedeliveryRecord'])) {


    $patientID = trim($_POST['patientid']);

    $laborTypes = isset($_POST['labor']) ? $_POST['labor'] : [];

    // Handle time and date inputs
    $laborTime = trim($_POST['laborTime']);
    $laborDate = trim($_POST['laborDate']);

    // Collect and sanitize other fields
    // $laborStage =trim($_POST['laborStage']);
    $laborDurationHrs = trim($_POST['laborHrs']);
    $laborDurationMins = trim($_POST['laborMins']);

    $cervixTime = trim($_POST['CervixTime']);
    $cervixDate = trim($_POST['CervixDate']);
    $cervixHrs = trim($_POST['CervixHrs']);
    $cervixMins = trim($_POST['CervixMins']);

    $babyTime = trim($_POST['BabylaborTime']);
    $babyDate = trim($_POST['BabylaborDate']);
    $babyHrs = trim($_POST['babyHrs']);
    $babyMins = trim($_POST['babyMins']);

    $placentaTime = trim($_POST['PlacentaTime']);
    $placentaDate = trim($_POST['PlacentaDate']);
    $placentaHrs = trim($_POST['PlacentaHrs']);
    $placentaMins = trim($_POST['PlacentaMins']);

    $physician = trim($_POST['physician']);


    $labor = [
        'labor' => [
            'types' => $laborTypes,
            'time' => $laborTime,
            'date' => $laborDate,
            'duration' => [
                'hrs' => $laborDurationHrs,
                'mins' => $laborDurationMins
            ]
        ],
        'cervix' => [
            'time' => $cervixTime,
            'date' => $cervixDate,
            'duration' => [
                'hrs' => $cervixHrs,
                'mins' => $cervixMins
            ]
        ],
        'baby' => [
            'time' => $babyTime,
            'date' => $babyDate,
            'duration' => [
                'hrs' => $babyHrs,
                'mins' => $babyMins
            ]
        ],
        'placenta' => [
            'time' => $placentaTime,
            'date' => $placentaDate,
            'duration' => [
                'hrs' => $placentaHrs,
                'mins' => $placentaMins
            ]
        ]
    ];

    // Convert the array to JSON
    $jsonDatalabor = json_encode($labor);


    $gravida = trim($_POST['gravida']);
    $para = trim($_POST['para']);
    $fullTerm = trim($_POST['fullTerm']);
    $premature = trim($_POST['premature']);
    $abortion = trim($_POST['abortion']);
    $noOfLiving = trim($_POST['noOfLiving']);


    // Handle checkbox inputs
    $placentaExpelled = isset($_POST['placentaExpelled']) ? $_POST['placentaExpelled'] : [];
    $placentaExpelled = array_map('trim', $placentaExpelled); // Optional: Trim each value

    // Handle other inputs
    $umbilicalCordCm = htmlspecialchars(trim($_POST['cm']));
    $umbilicalCordLoops = htmlspecialchars(trim($_POST['umbilicalCordLoops']));
    $umbilicalCordNone = isset($_POST['no_nexk']) ? 'None' : '';
    $placentaOther = htmlspecialchars(trim($_POST['placentaOther']));
    $bloodLossAntepartum = htmlspecialchars(trim($_POST['bloodLossAntepartum']));
    $bloodLossIntrapartum = htmlspecialchars(trim($_POST['bloodLossIntrapartum']));
    $bloodLossPostpartum = htmlspecialchars(trim($_POST['bloodLossPostpartum']));
    $totalBloodLoss = htmlspecialchars(trim($_POST['totalBloodLoss']));


    $placenta = [
        'placenta' => [
            'expelled' => $placentaExpelled
        ],
        'umbilicalCord' => [
            'cm' => $umbilicalCordCm,
            'loops' => $umbilicalCordLoops,
            'none' => $umbilicalCordNone
        ],
        'other' => $placentaOther,
        'bloodLoss' => [
            'antepartum' => $bloodLossAntepartum,
            'intrapartum' => $bloodLossIntrapartum,
            'postpartum' => $bloodLossPostpartum,
            'total' => $totalBloodLoss
        ]
    ];

    // Convert the array to JSON
    $jsonDataplacenta = json_encode($placenta);



    $methodDelivery = isset($_POST['method']) ? json_encode($_POST['method']) : '[]';
    $Episiotomy = isset($_POST['Episiotomy']) ? json_encode($_POST['Episiotomy']) : '[]';
    $Laceration = isset($_POST['Laceration']) ? json_encode($_POST['Laceration']) : '[]';
    $Anethesia = isset($_POST['Anethesia']) ? json_encode($_POST['Anethesia']) : '[]';
    $Analgesia = isset($_POST['Analgesia']) ? json_encode($_POST['Analgesia']) : '[]';
    $condition = isset($_POST['condition']) ? json_encode($_POST['condition']) : '[]';
    $urinary_Bladder = isset($_POST['urinary_bladder']) ? json_encode($_POST['urinary_bladder']) : '[]';
    $uterus = isset($_POST['uterus']) ? json_encode($_POST['uterus']) : '[]';



    $pregnancy = trim($_POST['pregnancy']);
    $not_Related = trim($_POST['not_related']);

    $complications = trim($_POST['complications']);
    $handledBy = trim($_POST['handledBy']);
    $assistedBy = trim($_POST['assistedBy']);
    $physician = trim($_POST['physician']);
    $dateAdmitted = trim($_POST['dateAdmitted']);



    try {
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientID);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }

        $stmt = $con->prepare("INSERT INTO tbl_birthroom (`patient_id`,`dateAdmitted`, `gravida`, `para`, `fullTerm`, `premature`, `abortion`, `noOfLiving`, `labor`, `placenta`, `method_delivery`, `Episiotomy`, `Laceration`, `Anethesia`, `Analgesia`, `condition`, `urinary_bladder`, `uterus`, `pregnancy`, `not_related`, `complications`, `Handled_by`, `assisted_by`, `physician`,`birth_info_id`)
         VALUES (:patient_id,:dateAdmitted,:gravida,:para, :fullTerm,:premature,:abortion,:noOfLiving,:labor,:placenta,:method_delivery,:Episiotomy,:Laceration,:Anethesia,:Analgesia,:condition,:urinary_bladder,:uterus,:pregnancy,:not_related,:Complications,:Handled_by,:assisted_by,:physician,:birth_info_id)");

        $stmt->execute([
            'patient_id' => $patientID,
            'dateAdmitted' => $dateAdmitted,
            'gravida' => $gravida,
            'para' => $para,
            'fullTerm' => $fullTerm,
            'premature' => $premature,
            'abortion' => $abortion,
            'noOfLiving' => $noOfLiving,
            ':labor' => $jsonDatalabor,
            ':placenta' => $jsonDataplacenta,
            ':method_delivery' => $methodDelivery,
            ':Episiotomy' => $Episiotomy,
            ':Laceration' => $Laceration,
            ':Anethesia' => $Anethesia,
            ':Analgesia' => $Analgesia,

            ':condition' => $condition,
            ':urinary_bladder' => $urinary_Bladder,
            ':uterus' => $uterus,
            ':pregnancy' => $pregnancy,
            ':not_related' => $not_Related,
            ':Complications' => $complications,
            ':Handled_by' => $handledBy,
            ':assisted_by' => $assistedBy,
            ':physician' => $physician,
            'birth_info_id' => $birth_info_id


        ]);

        $con->commit();
        $_SESSION['status'] = "Delivery Room Record added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

if (isset($_POST['submitMedications'])) {

    $patientID = trim($_POST['patientmedID']);

    $orderDate = $_POST['orderDate'];
    $MedDosage = $_POST['MedDosage'];
    $Dosage = $_POST['Dosage'];
    $Frequency = $_POST['Frequency'];
    $time = $_POST['time'];
    $date_signature = $_POST['date_signature'];
    $signature = $_POST['signature'];
    $medProcedure = $_POST['medProcedure'];
    $Specimen = $_POST['Specimen'];
    $row_med = $_POST['row_med'];

    $hasData = false;
    for ($i = 0; $i < count($orderDate); $i++) {
        if (!empty($orderDate[$i]) && !empty($time[$i])) {
            $hasData = true;
            break;
        }
    }

    if (!$hasData) {
        $_SESSION['status'] = "At least one set of vital signs data must be provided.";
        $_SESSION['status_code'] = "error";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    }

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientID);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }

        $stmt = $con->prepare("INSERT INTO `tbl_birthing_medication`(`patient_id`, `orderDate`, `medicineID`, `dosage`, `Frequency`, `time`, `date_signature`, `signature`,`medProcedure`,`Specimen`,`birth_info_id`) 
        VALUES (:patient_id, :orderDate, :medicineID,:dosage,:Frequency, :time,:date_signature,:signature,:medProcedure,:Specimen,:birth_info_id)");


        $updateQuery = "UPDATE tbl_medicine_details SET qt = qt - ? WHERE medicine_id = ?";
        $updateStmt = $con->prepare($updateQuery);
        // Loop through each row and insert into the database
        for ($i = 0; $i < count($orderDate); $i++) {
            if ($row_med[$i] === 'new') {
                // Convert the date to the format MySQL expects (YYYY-MM-DD)
                $convertedOrderDate = DateTime::createFromFormat('d/m/Y', $orderDate[$i])->format('Y-m-d');
                $convertedDateSignature = DateTime::createFromFormat('d/m/Y', $date_signature[$i])->format('Y-m-d');

                $stmt->execute([
                    ':patient_id' => $patientID,
                    ':orderDate' => $convertedOrderDate,
                    ':medicineID' => $MedDosage[$i],
                    ':dosage' => $Dosage[$i],
                    ':Frequency' => $Frequency[$i],
                    ':time' => $time[$i],
                    ':date_signature' => $convertedDateSignature,
                    ':signature' => $signature[$i],
                    ':medProcedure' => $medProcedure,
                    ':Specimen' => $Specimen,
                    'birth_info_id' => $birth_info_id
                ]);
                $updateStmt->execute([$Dosage[$i], $MedDosage[$i]]);
            }
        }







        $con->commit();
        $_SESSION['status'] = "Medication added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}


if (isset($_POST['submitFluids'])) {

    $patientID = trim($_POST['patientmedID']);

    $Date = $_POST['Date'];
    $timeStarted = $_POST['timeStarted'];
    $timeconsumed = $_POST['timeconsumed'];
    $bottleno = $_POST['bottleno'];
    $solution = $_POST['solution'];
    $signature_remarks = $_POST['signature_remarks'];

    $row_fluids = $_POST['row_fluids'];

    $hasData = false;
    for ($i = 0; $i < count($Date); $i++) {
        if (!empty($Date[$i]) && !empty($timeStarted[$i])) {
            $hasData = true;
            break;
        }
    }

    if (!$hasData) {
        $_SESSION['status'] = "At least one set of vital signs data must be provided.";
        $_SESSION['status_code'] = "error";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    }

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientID);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }

        $stmt = $con->prepare("INSERT INTO `tbl_birth_ivfluids`(`patient_id`, `date`, `timeStarted`, `timeconsumed`, `bottleno`, `solution`, `signature_remarks`,`birth_info_id`) 
        VALUES (:patient_id, :date, :timeStarted,:timeconsumed,:bottleno, :solution,:signature_remarks,:birth_info_id)");

        // Loop through each row and insert into the database
        for ($i = 0; $i < count($Date); $i++) {
            if ($row_fluids[$i] === 'new') {
                // Convert the date to the format MySQL expects (YYYY-MM-DD)
                $convertedOrderDate = DateTime::createFromFormat('d/m/Y', $Date[$i])->format('Y-m-d');


                $stmt->execute([
                    ':patient_id' => $patientID,
                    ':date' => $convertedOrderDate,
                    ':timeStarted' => $timeStarted[$i],
                    ':timeconsumed' => $timeconsumed[$i],
                    ':bottleno' => $bottleno[$i],
                    ':solution' => $solution[$i],
                    ':signature_remarks' => $signature_remarks[$i],
                    ':birth_info_id' => $birth_info_id

                ]);
            }
        }

        $con->commit();
        $_SESSION['status'] = "IVFluids added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}



if (isset($_POST['savepostpartum'])) {

    $patientid = trim($_POST['patientid']);

    $datepostpartum = trim($_POST['datepostpartum']);
    $formattedDatePostpartum = date('Y-m-d', strtotime(str_replace('/', '-', $datepostpartum)));
    $monitoringDate = trim($_POST['date']);
    $monitoringTime = trim($_POST['time']);

    $every5_15Times = [
        $_POST['every5_15'][0],
        $_POST['every5_15'][1],
        $_POST['every5_15'][2],
        $_POST['every5_15'][3]
    ];

    $time2HR = $_POST['2HR'];
    $time3HR = $_POST['3HR'];
    $time4HR = $_POST['4HR'];
    $time8HR = $_POST['8HR'];
    $time12HR = $_POST['12HR'];
    $date2 = $_POST['date2'];
    $time16HR = $_POST['16HR'];
    $time20HR = $_POST['20HR'];
    $time24HR = $_POST['24HR'];
    $timeDischarge = $_POST['DISCHARGE'];

    // Creating the JSON structure
    $monitoringData = [
        'date' => $monitoringDate,
        'time' => $monitoringTime,
        'monitoring' => [
            'every5_15' => [
                'times' => $every5_15Times
            ],
            '2HR' => $time2HR,
            '3HR' => $time3HR,
            '4HR' => $time4HR,
            '8HR' => $time8HR,
            '12HR' => $time12HR,
            'date2' => $date2,
            '16HR' => $time16HR,
            '20HR' => $time20HR,
            '24HR' => $time24HR,
            'discharge' => $timeDischarge
        ]
    ];

    // Convert the array to JSON
    $jsonMonitoringData = json_encode($monitoringData);

    $maternal = trim($_POST['maternal']);
    $uterine = trim($_POST['uterine']);
    $rubra = trim($_POST['rubra']);
    $perineum = trim($_POST['perineum']);
    $breast = trim($_POST['breast']);
    $feeding = trim($_POST['feeding']);
    $bladder = trim($_POST['bladder']);
    $bowel = trim($_POST['bowel']);
    $message = trim($_POST['message']);
    $viginaldischarge = trim($_POST['viginaldischarge']);

    try {
        $con->beginTransaction();


        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientid);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }


        $query =  $stmt = $con->prepare("INSERT INTO `tbl_postpartum`(`patient_id`, `date_postpartum`, `monitoring_data`, `maternal_wellbeing`, `uterine_firmness`, `rubra`, `perineum_pain`, `breast_condition`, `feeding`, `bladder`, `bowel_movement`, `vaginal_discharge`, `key_messages`,`birth_info_id`) 
    VALUES(:patient_id,:date_postpartum,:monitoring_data,:maternal_wellbeing,:uterine_firmness,:rubra,:perineum_pain,:breast_condition,:feeding,:bladder,:bowel_movement,:vaginal_discharge,:key_messages,:birth_info_id)");

        $stmt->execute([
            ':patient_id' => $patientid,
            ':date_postpartum' => $formattedDatePostpartum,
            ':monitoring_data' => $jsonMonitoringData,
            ':maternal_wellbeing' => $maternal,
            ':uterine_firmness' => $uterine,
            ':rubra' => $rubra,
            ':perineum_pain' => $perineum,
            ':breast_condition' => $breast,
            ':feeding' => $feeding,
            ':bladder' => $bladder,
            ':bowel_movement' => $bowel,
            ':vaginal_discharge' => $viginaldischarge,
            ':key_messages' => $message,
            ':birth_info_id' => $birth_info_id

        ]);

        $con->commit();
        $_SESSION['status'] = "Postpartum added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientid));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

if (isset($_POST['Updatepostpartum'])) {

    $postpartumId = trim($_POST['postpartumId']);
    $patientid = trim($_POST['patientid']);

    $datepost = trim($_POST['datepost']);
    $formattedDatePostpartum = date('Y-m-d', strtotime(str_replace('/', '-', $datepost)));
    $monitoringDate = trim($_POST['date']);
    $monitoringTime = trim($_POST['time']);

    $every5_15Times = [
        $_POST['every5'][0],
        $_POST['every5'][1],
        $_POST['every5'][2],
        $_POST['every5'][3]
    ];

    $time2HR = $_POST['2HR'];
    $time3HR = $_POST['3HR'];
    $time4HR = $_POST['4HR'];
    $time8HR = $_POST['8HR'];
    $time12HR = $_POST['12HR'];
    $date2 = $_POST['date2'];

    $time16HR = $_POST['16HR'];
    $time20HR = $_POST['20HR'];
    $time24HR = $_POST['24HR'];
    $timeDischarge = $_POST['DISCHARGE'];

    // Creating the JSON structure
    $monitoringData = [
        'date' => $monitoringDate,
        'time' => $monitoringTime,
        'monitoring' => [
            'every5_15' => [
                'times' => $every5_15Times
            ],
            '2HR' => $time2HR,
            '3HR' => $time3HR,
            '4HR' => $time4HR,
            '8HR' => $time8HR,
            '12HR' => $time12HR,
            'date2' => $date2,

            '16HR' => $time16HR,
            '20HR' => $time20HR,
            '24HR' => $time24HR,
            'discharge' => $timeDischarge
        ]
    ];

    // Convert the array to JSON
    $jsonMonitoringData = json_encode($monitoringData);

    $maternal = trim($_POST['maternal']);
    $uterine = trim($_POST['uterine']);
    $rubra = trim($_POST['rubra']);
    $perineum = trim($_POST['perineum']);
    $breast = trim($_POST['breast']);
    $feeding = trim($_POST['feeding']);
    $bladder = trim($_POST['bladder']);
    $bowel = trim($_POST['bowel']);
    $message = trim($_POST['message']);
    $viginaldischarge = trim($_POST['viginaldischarge']);

    try {
        $con->beginTransaction();

        $query = $con->prepare("
            UPDATE `tbl_postpartum` 
            SET 
                `patient_id` = :patient_id,
                `date_postpartum` = :date_postpartum,
                `monitoring_data` = :monitoring_data,
                `maternal_wellbeing` = :maternal_wellbeing,
                `uterine_firmness` = :uterine_firmness,
                `rubra` = :rubra,
                `perineum_pain` = :perineum_pain,
                `breast_condition` = :breast_condition,
                `feeding` = :feeding,
                `bladder` = :bladder,
                `bowel_movement` = :bowel_movement,
                `vaginal_discharge` = :vaginal_discharge,
                `key_messages` = :key_messages
            WHERE `postpartumID` = :postpartum_id
        ");

        $query->execute([
            ':postpartum_id' => $postpartumId,
            ':patient_id' => $patientid,
            ':date_postpartum' => $formattedDatePostpartum,
            ':monitoring_data' => $jsonMonitoringData,
            ':maternal_wellbeing' => $maternal,
            ':uterine_firmness' => $uterine,
            ':rubra' => $rubra,
            ':perineum_pain' => $perineum,
            ':breast_condition' => $breast,
            ':feeding' => $feeding,
            ':bladder' => $bladder,
            ':bowel_movement' => $bowel,
            ':vaginal_discharge' => $viginaldischarge,
            ':key_messages' => $message
        ]);

        $con->commit();
        $_SESSION['status'] = "Postpartum record updated successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientid));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}


if (isset($_POST['submitDischarged'])) {
    $patientID = trim($_POST['patientid']);
    $Diagnosis = trim($_POST['Diagnosis']);
    $birthiid = trim($_POST['birthiid']);

    $datedischarged = trim($_POST['datedischarged']);
    $datedischarged = date('Y-m-d', strtotime(str_replace('/', '-', $datedischarged)));
    $homeMedications = $_POST['homeMedications'];

    // Convert homeMedications array to JSON format
    $homeMedicationsJson = json_encode(array_map('trim', $homeMedications));

    $dateFollow = trim($_POST['dateFollow']);
    $dateFollow = date('Y-m-d', strtotime(str_replace('/', '-', $dateFollow)));

    $nursemidwife = trim($_POST['nursemidwife']);
    $getphysician = trim($_POST['getphysician']);

    try {
        // Begin transaction
        $con->beginTransaction();

        // Insert into tbl_discharged
        $stmt = $con->prepare("INSERT INTO `tbl_discharged`( `patientid`,`birth_info_id`, `diagnosis`, `date_discharged`, `home_medications`, `follow_up_date`,  `nurse_midwife`, `physician`) 
        VALUES (:patientid,:birth_info_id, :diagnosis, :date_discharged, :home_medications, :follow_up_date, :nurse_midwife, :physician)");

        $stmt->execute([
            ':patientid' => $patientID,
            ':birth_info_id' => $birthiid,
            ':diagnosis' => $Diagnosis,
            ':date_discharged' => $datedischarged,
            ':home_medications' => $homeMedicationsJson,
            ':follow_up_date' => $dateFollow,
            ':nurse_midwife' => $nursemidwife,
            ':physician' => $getphysician,
        ]);


        // Update tbl_complaints: Set status to 'Done' for Birthing consultations under monitoring
        $stmtUpdateComplaints = $con->prepare("
                            UPDATE tbl_complaints 
                            SET status = 'Done' 
                            WHERE patient_id = :patientID 
                            AND status = 'Under Monitoring' 
                            AND consultation_purpose = 'Birthing'
                            ");
        $stmtUpdateComplaints->bindParam(':patientID', $patientID);
        $stmtUpdateComplaints->execute();

        // Update tbl_birth_info: Set birthing_status to 'done'
        $stmtUpdateBirthInfo = $con->prepare("
                            UPDATE tbl_birth_info 
                            SET birthing_status = 'done' 
                            WHERE patient_id = :patientID
                            ");
        $stmtUpdateBirthInfo->bindParam(':patientID', $patientID);
        $stmtUpdateBirthInfo->execute();


        // Commit transaction
        $con->commit();

        // Set success message and redirect
        $_SESSION['status'] = "Patient discharged successfully.";
        $_SESSION['status_code'] = "success";
        // header('Location: records_birthing.php?id=' . urlencode($patientID));
        header('Location: records_birthing.php');
        exit();
    } catch (Exception $e) {
        // Rollback transaction in case of an error
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}


if (isset($_POST['submitdocnotes'])) {

    $patientid = trim($_POST['patientid']);
    $dates = isset($_POST['date']) ? $_POST['date'] : [];
    $times = isset($_POST['time']) ? $_POST['time'] : [];
    $doctors = isset($_POST['doctor']) ? $_POST['doctor'] : [];
    $docnotes = isset($_POST['docnotes']) ? $_POST['docnotes'] : [];


    // Begin transaction
    $con->beginTransaction();

    $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
    FROM tbl_birth_info 
    WHERE patient_id = :patientID 
      AND birthing_status = 'ongoing'
    ORDER BY birth_info_id DESC
    LIMIT 1");
    $stmt->bindParam(':patientID', $patientid);
    $stmt->execute();
    $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($birthInfo) {
        // Ongoing birthing event found
        $birth_info_id = $birthInfo['birth_info_id'];
        $birthing_status = $birthInfo['birthing_status'];
    } else {
        // No ongoing birthing event found
        // Handle accordingly: you can throw an error or start a new birthing event
        throw new Exception("No ongoing birthing event found for the patient.");
    }


    // Loop through the arrays to insert multiple rows
    for ($i = 0; $i < count($dates); $i++) {
        if (!isset($_POST['existing_row'][$i])) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $dates[$i]))); // Convert date format
            $time = $times[$i];
            $doctor = $doctors[$i];
            $docnote = $docnotes[$i];

            // Insert into tbl_healthnotes
            $stmt = $con->prepare("INSERT INTO `tbl_healthnotes`(`patient_id`, `userID`, `date`, `time`, `doctorNotes`,`birth_info_id`)
                                   VALUES(:patient_id, :userID, :date, :time, :doctorNotes,:birth_info_id)");

            $stmt->execute([
                ':patient_id' => $patientid,
                ':userID' => $doctor,
                ':date' => $date,
                ':time' => $time,
                ':doctorNotes' => $docnote,
                ':birth_info_id' => $birth_info_id,
            ]);
        }
    }

    $con->commit();


    $_SESSION['status'] = "Doctor notes added successfully.";
    $_SESSION['status_code'] = "success";
    header('Location: birthing_patients.php?id=' . urlencode($patientid));
    exit();
}


if (isset($_POST['submitnursenotes'])) {

    $patientid = trim($_POST['patientid']);
    $nurseid = trim($_POST['nurseid']);


    $dates = isset($_POST['date']) ? $_POST['date'] : [];
    $times = isset($_POST['time']) ? $_POST['time'] : [];
    $docnotes = isset($_POST['docnotes']) ? $_POST['docnotes'] : [];



    $con->beginTransaction();

    $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
    FROM tbl_birth_info 
    WHERE patient_id = :patientID 
      AND birthing_status = 'ongoing'
    ORDER BY birth_info_id DESC
    LIMIT 1");
    $stmt->bindParam(':patientID', $patientid);
    $stmt->execute();
    $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($birthInfo) {
        // Ongoing birthing event found
        $birth_info_id = $birthInfo['birth_info_id'];
        $birthing_status = $birthInfo['birthing_status'];
    } else {
        // No ongoing birthing event found
        // Handle accordingly: you can throw an error or start a new birthing event
        throw new Exception("No ongoing birthing event found for the patient.");
    }



    try {

        for ($i = 0; $i < count($dates); $i++) {
            // Check if the row is new
            if (!isset($_POST['existing_row'][$i])) {
                // Format the date to Y-m-d
                $date = date('Y-m-d', strtotime(str_replace('/', '-', $dates[$i])));
                $time = $times[$i];
                $docnote = $docnotes[$i];

                // Prepare and execute the insert statement
                $stmt = $con->prepare("INSERT INTO `tbl_healthnotes` (`patient_id`, `userID`, `date`, `time`, `nureNotes`,`birth_info_id`)
                                       VALUES (:patient_id, :userID, :date, :time, :nureNotes,:birth_info_id)");

                $stmt->execute([
                    ':patient_id' => $patientid,
                    ':userID' => $nurseid,
                    ':date' => $date,
                    ':time' => $time,
                    ':nureNotes' => $docnote,
                    ':birth_info_id' => $birth_info_id,
                ]);
            }
        }
        $con->commit();



        $_SESSION['status'] = "Nurses notes added successfully.";
        $_SESSION['status_code'] = "success";
    } catch (Exception $e) {
        // Rollback in case of error
        $con->rollBack();
        $_SESSION['status'] = "Failed to add nurse's notes: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    header('Location: birthing_patients.php?id=' . urlencode($patientid));
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        /* 
        @media print {
            @page {
                size: 8.5in 13in;
                max-width: 8.5in;
            }
        }
        #print {
            width: 850px;
            height: 1100px;
            overflow: hidden;
            
        } */
        .flex-container {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .flex-item {
            margin-bottom: 10px;
        }

        .double {
            display: flex;
            justify-content: space-between;
            width: 50%;
        }

        .double p {
            width: 50%;
            /* Each paragraph takes half the width of the container */
        }

        .full-width {
            width: 100%;
        }

        span {
            font-weight: bold;
        }

        .flex-item button {
            display: flex;
            flex-direction: column;
        }

        .form-input {
            border: none;
            border-bottom: 1px solid black;
            width: 10%;
            outline: none;
            text-align: center;
        }

        .form-label {
            font-weight: bold;
        }

        .form-input1 {
            border: none;
            border-bottom: 1px solid black;
            width: 35%;
            outline: none;
            text-align: center;

            margin-right: 10px;
            margin-bottom: 10px;
        }


        .modal-body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }



        .ml-4 {
            margin-left: 2rem;
        }

        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            width: 100%;
            border: 1px solid #dddddd;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            text-align: left;

        }

        .styled-table td {
            padding: 12px 15px;
            text-align: left;

        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
    </style>
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">



            <!-- Sidebar menu starts -->
            <?php include './config/sidebar.php'; ?>
            <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <?php include './config/header.php'; ?>
                <!-- App header ends -->

                <!-- App body starts -->
                <div class="app-body">
                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    ?>
                        <?php ?>

                    <?php


                    }

                    ?>
                    <!-- Container starts -->
                    <div class="container-fluid">


                        <div class="row">
                            <div class="col-xxl-12">
                                <h2></h2>
                                <?php if (isset($patientData)) : ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title "> <span> <a href="birthing_monitoring.php" type="button" class="btn btn-primary ">
                                                        <i class="icon-chevron-left"></i> Back

                                                    </a></span></h5>
                                        </div>

                                        <div class="card-body">



                                            <div class="row flex-container">


                                                <div class="flex-item" style="display: flex; align-items: center; justify-content: space-between;">
                                                    <h2 style="margin: 0;">
                                                        <strong><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></strong>
                                                    </h2>
                                                    <!-- <span style="display: flex; align-items: center; gap: 10px;">
                                                <a href="clinical_coversheet.php?patientID=<?php echo htmlspecialchars($patientData['patientID']); ?>" class="btn btn-primary" style="background-color: #009879; color: #ffffff;  text-decoration: none;">
                                                    Clinical Cover Sheet</a>
                                                <select id="ActionSelect" class="form-select text-center" style="color: #ffffff; background-color: #009879; font-size: 15px; padding: 0.5rem; border-radius: 4px;">
                                                    <option value="">Action</option>
                                                    <option value="Refer" data-discharged-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Refer</option>
                                                    <option value="Discharge" data-discharged-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Discharge</option>
                                                </select>
                                            </span> -->
                                                </div>


                                                <div class="flex-item double">
                                                    <p class="form-label">Age: <?php echo htmlspecialchars($patientData['age']); ?>

                                                    </p>
                                                    <p class="form-label">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></p>
                                                </div>


                                                <div class="flex-item  double ">
                                                    <p class="form-label">BirthDate: <?php echo htmlspecialchars(date('F j, Y', strtotime($patientData['date_of_birth']))); ?></p>
                                                    <p class="form-label">Contact Number: <?php echo htmlspecialchars($patientData['phone_number']); ?></p>
                                                </div>

                                                <div class="flex-item double ">
                                                    <p class="form-label">Status: <?php echo htmlspecialchars(ucwords($patientData['civil_status'])); ?></p>
                                                    <p class="form-label">Blood Type: <?php echo htmlspecialchars(ucwords($patientData['blood_type'])); ?></p>
                                                </div>
                                                <div class="flex-item ">

                                                    <p class="form-label">Address: <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', ' . $patientData['province']); ?></p>
                                                </div>

                                                <div class="d-flex gap-2 justify-content-left">
                                                    <select id="recordSelect" class="form-select text-center" style="width: 15%; color: #ffffff; background-color: #009879; font-size: 15px;">
                                                        <option value="">--Select Record--</option>
                                                        <option value="monitorCard">Monitor Patient During Birth</option>
                                                        <option value="deliveryCard">Delivery Room Record</option>

                                                        <option value="postpartumCard">Postpartum</option>
                                                    </select>
                                                    <select id="MedicationSelect" class="form-select text-center" style="width: 15%; color: #ffffff; background-color: #009879; font-size: 15px;">
                                                        <option value="">--Select Medication--</option>
                                                        <option value="VitalsCard">Vital Signs</option>
                                                        <option value="MedicationsCard">Medication</option>
                                                        <option value="IVCard">IV Fluid</option>
                                                    </select>

                                                    <a href="clinical_coversheet.php?patientID=<?php echo htmlspecialchars($patientData['patientID']); ?>" class="btn btn-primary" style="background-color: #009879; color: #ffffff;  text-decoration: none;">
                                                        Clinical Cover Sheet</a>

                                                    <!-- <a href="clinical_coversheet.php?patientID=<?php echo htmlspecialchars($patientData['patientID']); ?>" class="btn btn-primary" style="background-color: #009879; color: #ffffff;  text-decoration: none;">
                                              Notes</a> -->
                                                    <select id="HealthNotes" class="form-select text-center" style="color: #ffffff; background-color: #009879; font-size: 15px; padding: 0.5rem; border-radius: 4px;width: 15%;">
                                                        <option value="">-Select Notes-</option>
                                                        <option value="docnotes" data-healthnotes-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Doctor's Order</option>
                                                        <option value="nursenote" data-healthnotes-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Nurses Notes</option>
                                                    </select>
                                                    <select id="ActionSelect" class="form-select text-center" style="color: #ffffff; background-color: #009879; font-size: 15px; padding: 0.5rem; border-radius: 4px;width: 15%;">
                                                        <option value="">Action</option>
                                                        <option value="Refer" data-discharged-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Refer</option>
                                                        <option value="Discharge" data-discharged-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">Discharge</option>
                                                    </select>
                                                </div>


                                            </div>



                                            <hr />
                                            <div id="patient_record_history">

                                                <div class="row">
                                                    <div id="deliveryCard" class="col-xl-4 col-sm-6 col-12 d-none">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header rounded-1 shadow">
                                                                <h5 class="card-title">
                                                                    Delivery Room Record
                                                                    <span>
                                                                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#deliveryRecord" data-patient-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                                                            <i class="icon-plus"></i>
                                                                        </button>
                                                                    </span>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <?php if (!empty($DeliveryRecords)) { ?>
                                                                    <ul class="list-group list-group-flush">
                                                                        <?php foreach ($DeliveryRecords as $records) { ?>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                <span>
                                                                                    <strong>Record:</strong>
                                                                                    <?php echo htmlspecialchars(date('F j, Y', strtotime($records['created_at']))); ?>

                                                                                </span>
                                                                                <button class="btn btn-warning btn-sm"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#ViewdeliveryRecord"
                                                                                    data-record-id="<?php echo htmlspecialchars($records['roomID']); ?>">
                                                                                    <i class="icon-eye"></i>
                                                                                </button>


                                                                            </li>

                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } else { ?>
                                                                    <p class="text-center mt-2" style="color:red;">No available data found</p>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="card-footer">
                                                                <span class="badge border border-primary text-primary"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="monitorCard" class=" col-xl-4 col-sm-6 col-12  d-none">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header rounded-1 shadow">
                                                                <h5 class="card-title">
                                                                    Monitor Patient During Birth Record
                                                                    <span>
                                                                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#labourRecord" data-labour-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                                                            <i class="icon-plus"></i>
                                                                        </button>
                                                                    </span>
                                                                </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <?php if (!empty($monitoringRecords)) { ?>
                                                                    <ul class="list-group list-group-flush">
                                                                        <?php foreach ($monitoringRecords as $record) { ?>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                <span>
                                                                                    <strong>Record:</strong>
                                                                                    <?php echo htmlspecialchars(date('F j, Y', strtotime($record['admission_date']))); ?>
                                                                                    <?php echo htmlspecialchars(date('h:i A', strtotime($record['admission_time']))); ?>
                                                                                </span>
                                                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#viewRecord" data-record-id="<?php echo $record['birthMonitorID']; ?>">
                                                                                    <i class="icon-eye"></i>
                                                                                </button>
                                                                            </li>

                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } else { ?>
                                                                    <p class="text-center mt-2" style="color:red;">No available data found</p>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="card-footer">
                                                                <span class="badge border border-primary text-primary"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="postpartumCard" class="col-xl-4 col-sm-6 col-12 d-none">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">
                                                                    Postpartum Record
                                                                    <span>
                                                                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#PostpartumRecord" data-postpartum-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                                                            <i class="icon-plus"></i>
                                                                        </button>
                                                                    </span>
                                                                </h5>

                                                            </div>

                                                            <div class="card-body">
                                                                <?php if (!empty($postpartumData)) { ?>
                                                                    <ul class="list-group list-group-flush">
                                                                        <?php foreach ($postpartumData as $record) { ?>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                <span>
                                                                                    <strong>Record:</strong>
                                                                                    <?php echo htmlspecialchars(date('F j, Y', strtotime($record['date_postpartum']))); ?>

                                                                                </span>
                                                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ViewPostpartumRecord" data-record-id="<?php echo $record['postpartumID']; ?>">
                                                                                    <i class="icon-eye"></i>
                                                                                </button>
                                                                            </li>

                                                                        <?php } ?>
                                                                    </ul>
                                                                <?php } else { ?>
                                                                    <p class="text-center mt-2" style="color:red;">No available data found</p>
                                                                <?php } ?>
                                                                <!-- <a href="#" class="btn btn-primary"></a> -->
                                                            </div>
                                                            <div class="card-footer">
                                                                <span class="badge border border-primary text-primary"></span>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div id="VitalsCard" class="col-xl-4 col-sm-6 col-12 d-none ">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">Vital Signs <span><a href="#" type="button" id="vitalSigns" class="btn btn-info float-end">
                                                                            <i class="icon-plus"></i>

                                                                        </a></span></h5>

                                                            </div>
                                                            <?php if (!empty($vitalSignsData)) { ?>
                                                                <div class="card-body">
                                                                    <p>
                                                                        <?php foreach ($vitalSignsData as $vitalSignsDatas) { ?>
                                                                            <li>


                                                                                <?php echo htmlspecialchars(date('M, d, Y', strtotime($vitalSignsDatas['date_shift']))); ?> - <?php echo htmlspecialchars(date('h:i A', strtotime($vitalSignsDatas['time']))); ?>

                                                                                </a>

                                                                            </li>
                                                                        <?php } ?>
                                                                    </p>
                                                                    <!-- <a href="#" class="btn btn-primary"></a> -->
                                                                </div>
                                                                <div class="card-footer">
                                                                    <span class="badge border border-primary text-primary"></span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <p class="text-center mt-2 " style="color:red;"> No available data found</p>
                                                            <?php } ?>
                                                        </div>

                                                    </div>

                                                    <div id="MedicationsCard" class="col-xl-4 col-sm-6 col-12 d-none ">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">Medication <span><a href="#" id="Medication" type="button" class="btn btn-info float-end">
                                                                            <i class="icon-plus"></i>

                                                                        </a></span></h5>

                                                            </div>
                                                            <?php if (!empty($MedicationsData)) { ?>
                                                                <div class="card-body">

                                                                    <p>
                                                                        <?php foreach ($MedicationsData as $MedicationsDatas) { ?>
                                                                            <li>


                                                                                <?php echo htmlspecialchars(date('M, d, Y', strtotime($MedicationsDatas['orderDate']))); ?> - <?php echo htmlspecialchars(date('h:i A', strtotime($MedicationsDatas['time']))); ?>

                                                                                </a>

                                                                            </li>
                                                                        <?php } ?>
                                                                    </p>
                                                                    <!-- <a href="#" class="btn btn-primary"></a> -->
                                                                </div>
                                                                <div class="card-footer">
                                                                    <span class="badge border border-primary text-primary"></span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <p class="text-center mt-2 " style="color:red;"> No available data found</p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div id="IVCard" class="col-xl-4 col-sm-6 col-12 d-none">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">IV FLUID <span><a href="#" id="IVFluid" type="button" class="btn btn-info float-end">
                                                                            <i class="icon-plus"></i>

                                                                        </a></span></h5>

                                                            </div>
                                                            <?php if (!empty($IVFluidsData)) { ?>
                                                                <div class="card-body">
                                                                    <p>

                                                                        <?php foreach ($IVFluidsData as $IVFluidsDatas) { ?>
                                                                            <li>


                                                                                <?php echo htmlspecialchars(date('M, d, Y', strtotime($IVFluidsDatas['date']))); ?> - <?php echo htmlspecialchars(date('h:i A', strtotime($IVFluidsDatas['timeStarted']))); ?>

                                                                                </a>

                                                                            </li>
                                                                        <?php } ?>

                                                                    </p>
                                                                    <!-- <a href="#" class="btn btn-primary"></a> -->
                                                                </div>
                                                                <div class="card-footer">
                                                                    <span class="badge border border-primary text-primary"></span>
                                                                </div>
                                                            <?php } else { ?>
                                                                <p class="text-center mt-2 " style="color:red;"> No available data found</p>
                                                            <?php } ?>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <!-- vital signs -->
                                            <form method="POST" id="vitalsignsForm" style="display: none;" novalidate>
                                                <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <h3>VITAL SIGNS MONITORING SHEET <span> <button style="margin-left: 2rem;" id="goBack" type="button" class="btn btn-primary">
                                                                        <i class="icon-arrow-left"></i> Back</button></span><span class="float-end"><button class="btn btn-info btn-sm" type="button" id="vitalsGraph">Click to show graph</button></span></h3>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="12" class="pt-3 pb-3">
                                                                            <div style="text-align: left; flex: 1;">
                                                                                <label class="form-label">ROOM: </label>
                                                                                <input class="form-input" type="text" name="room" value="<?php echo htmlspecialchars($vitalSignsData[0]['room'] ?? ''); ?>" required>
                                                                                <span class="float-end">
                                                                                    <a href="print_vitalsigns.php?id=<?php echo $vitalSignsData[0]['vitalSignsID'] ?>" class="btn btn-secondary"> <i class="icon-printer"></i> </a> </span>
                                                                                <div class="invalid-feedback">
                                                                                    Please fill in Room no.
                                                                                </div>
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Date/Shift</th>
                                                                        <th>Time</th>
                                                                        <th>BP</th>
                                                                        <th>CR</th>
                                                                        <th>RR</th>
                                                                        <th>Temp</th>
                                                                        <th>FHT</th>
                                                                        <th>Duration</th>
                                                                        <th>Frequency</th>
                                                                        <th>Intensity</th>
                                                                        <th>Nurse/Midwife Signature</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Vital-Signs-body">
                                                                    <?php if (isset($vitalSignsData) && count($vitalSignsData) > 0) : ?>
                                                                        <?php foreach ($vitalSignsData as $vitalSign) : ?>
                                                                            <tr>
                                                                                <input type="hidden" name="row_status[]" value="existing">
                                                                                <td>
                                                                                    <input type="text" class="form-control date-shift" name="Date_Shift[]" value="<?php echo htmlspecialchars($vitalSign['date_shift']); ?>">
                                                                                </td>
                                                                                <td><input type="time" class="form-control" name="Time[]" value="<?php echo htmlspecialchars($vitalSign['time']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="BP[]" value="<?php echo htmlspecialchars($vitalSign['bp']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="CR[]" value="<?php echo htmlspecialchars($vitalSign['cr']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="RR[]" value="<?php echo htmlspecialchars($vitalSign['rr']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="Temp[]" value="<?php echo htmlspecialchars($vitalSign['temp']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="FHT[]" value="<?php echo htmlspecialchars($vitalSign['fht']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="Duration[]" value="<?php echo htmlspecialchars($vitalSign['duration']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="Frequency[]" value="<?php echo htmlspecialchars($vitalSign['frequency']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="Intensity[]" value="<?php echo htmlspecialchars($vitalSign['intensity']); ?>"></td>
                                                                                <td>
                                                                                    <select name="Nurse_Midwife[]" class="form-select">
                                                                                        <?php
                                                                                        $nurseMidwifeOptions = getNurseMidwife($con);
                                                                                        echo str_replace('value="' . htmlspecialchars($vitalSign['nurse_midwife']) . '">', 'value="' . htmlspecialchars($vitalSign['nurse_midwife']) . '" selected>', $nurseMidwifeOptions);
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-info add-row-btn"><i class="fas fa-plus"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <input type="hidden" name="row_status[]" value="new">
                                                                            <td>
                                                                                <input type="date" class="form-control date-shift" name="Date_Shift[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Date is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="time" class="form-control" name="Time[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Time is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="BP[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    BP is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="CR[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    CR is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="RR[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    RR is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Temp[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Temp is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="FHT[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    FHT is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Duration[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Duration is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Frequency[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Frequency is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Intensity[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Intensity is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <select name="Nurse_Midwife[]" class="form-select" required>
                                                                                    <?php echo $midwife; ?>
                                                                                </select>
                                                                                <div class="invalid-feedback">
                                                                                    Midwife/Nurse is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-info add-row-btn"><i class="fas fa-plus"></i></button>
                                                                                <button type="button" class="btn btn-danger remove-row-btn" style="display: none;"><i class="fas fa-minus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex gap-2 justify-content-end">
                                                            <button type="button" id="cancel_Vitals" class="btn btn-outline-primary">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" id="submitVitals" name="saveVitals" class="btn btn-info">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row" id="vitalSignsGraphRow" style="display: none;">
                                                <div class=" col-12">
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Vital Signs Graphing sheet <span> <button style="margin-left: 2rem;" id="Back" type="button" class="btn btn-primary">
                                                                        <i class="icon-arrow-left"></i> Back</button></span> <span class="float-end">
                                                                    <!-- <a href="print_vitalGraph.php?id=<?php echo $patientData['patientID'] ?>" target="_blank" class="btn btn-secondary"> <i class="icon-printer"></i> </a> </span> -->
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="lineGraph"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- medications -->

                                            <form method="POST" id="MedicationsForm" style="display: none;" novalidate>
                                                <input type="hidden" name="patientmedID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <h3>MEDICATION SHEET <span> <button style="margin-left: 2rem;" id="Medications" type="button" class="btn btn-primary">
                                                                        <i class="icon-arrow-left"></i> Back</button></span></h3>

                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="12" class="pt-3 pb-3">
                                                                            <div style="text-align: left; flex: 1;">
                                                                                <label class="form-label">ROOM: </label>
                                                                                <input class="form-input" type="text" name="room" value="<?php echo htmlspecialchars($vitalSignsData[0]['room'] ?? ''); ?>" required>

                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Date Ordered</th>
                                                                        <th>Medicine </th>
                                                                        <th>Dosage </th>

                                                                        <th>Frequency</th>
                                                                        <th>Time</th>
                                                                        <th>Date</th>
                                                                        <th>Signature</th>

                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Medication-body">
                                                                    <?php if (isset($MedicationsData) && count($MedicationsData) > 0) : ?>
                                                                        <?php foreach ($MedicationsData as $Medications) : ?>
                                                                            <tr>
                                                                                <input type="hidden" name="row_med[]" value="existing">
                                                                                <td>
                                                                                    <input type="text" class="form-control date-shift" name="orderDate[]" value="<?php echo htmlspecialchars($Medications['orderDate']); ?>">
                                                                                </td>
                                                                                <td>
                                                                                    <select name="MedDosage[]" class="form-select">
                                                                                        <?php
                                                                                        $nmedicineOptions = getpresMedicines($con);
                                                                                        echo str_replace('value="' . htmlspecialchars($Medications['medicineID']) . '">', 'value="' . htmlspecialchars($Medications['medicineID']) . '" selected>', $nmedicineOptions);
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td><input type="text" class="form-control" name="Dosage[]" value="<?php echo htmlspecialchars($Medications['dosage']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="Frequency[]" value="<?php echo htmlspecialchars($Medications['Frequency']); ?>"></td>
                                                                                <td><input type="time" class="form-control" name="time[]" value="<?php echo htmlspecialchars($Medications['time']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="date_signature[]" value="<?php echo htmlspecialchars($Medications['date_signature']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="signature[]" value="<?php echo htmlspecialchars($Medications['signature']); ?>"></td>




                                                                                <td>
                                                                                    <button class="btn btn-info add-btn"><i class="fas fa-plus"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <input type="hidden" name="row_med[]" value="new">
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control datepicker " name="orderDate[]">
                                                                                    <span class="input-group-text">
                                                                                        <i class="icon-calendar"></i>
                                                                                    </span>
                                                                                    <div class="invalid-feedback">
                                                                                        Date Ordered is required.
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <select name="MedDosage[]" class="form-select" required>
                                                                                    <?php echo $medicine; ?>
                                                                                    <!-- <div class="invalid-feedback">
                                                                                        Medicine is required.
                                                                                    </div> -->
                                                                                </select>


                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Dosage[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Dosage is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="Frequency[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Frequency is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="time" class="form-control" name="time[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Time is required.
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control datepicker " name="date_signature[]">
                                                                                    <span class="input-group-text">
                                                                                        <i class="icon-calendar"></i>
                                                                                    </span>

                                                                                    <div class="invalid-feedback">
                                                                                        Date is required.
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="signature[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Signature is required.
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <button type="button" class="btn btn-info add-btn"><i class="fas fa-plus"></i></button>
                                                                                <button type="button" class="btn btn-danger remove-btn" style="display: none;"><i class="fas fa-minus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                </tbody>
                                                            <?php endif; ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="Purok">Start Medications and Procedure</label>
                                                            <textarea class="form-control form-control-sm rounded-0" id="Purok" name="medProcedure" cols="30" rows="5"><?php echo $medProcedure; ?></textarea>
                                                            <div class="invalid-feedback">
                                                                Start Medications and Procedure is required.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="Specimen">Specimen Signature</label>
                                                            <textarea class="form-control form-control-sm rounded-0" id="Specimen" name="Specimen" cols="30" rows="5"><?php echo $Specimen; ?></textarea>
                                                            <div class="invalid-feedback">
                                                                Specimen Signature is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <table>
                                                    <tr>
                                                        <td class="no-border">
                                                            <table class="codes-table">
                                                                <tr>
                                                                    <td><strong>Code:</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>R - Refused</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DC - Discontinued</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>H - Hold</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Rx - Prescribed</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NPO - Nothing by Mouth Including Meds.</td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>

                                                </table>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex gap-2 justify-content-end">

                                                            <button type="submit" id="submitMedications" name="submitMedications" class="btn btn-info">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- iV FLUIDS -->

                                            <form method="POST" id="IVFluidsForm" style="display: none;" novalidate>
                                                <input type="hidden" name="patientmedID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <h3>IV FLUID SHEET <span> <button style="margin-left: 2rem;" id="IVFluidsback" type="button" class="btn btn-primary">
                                                                        <i class="icon-arrow-left"></i> Back</button></span></h3>

                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="12" class="pt-3 pb-3">
                                                                            <div style="text-align: left; flex: 1;">
                                                                                <label class="form-label">ROOM: </label>
                                                                                <input class="form-input" type="text" name="room" value="<?php echo htmlspecialchars($vitalSignsData[0]['room'] ?? ''); ?>" required>

                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>DATE</th>
                                                                        <th>TIME STARTED </th>
                                                                        <th>TIME CONSUMED </th>

                                                                        <th>BOTTLE NO.</th>
                                                                        <th>TYPE OF SOLUTION / INCORPORATED </th>
                                                                        <th>REMARKS / SIGNATURE</th>


                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="IVFluid-body">
                                                                    <?php if (isset($IVFluidsData) && count($IVFluidsData) > 0) : ?>
                                                                        <?php foreach ($IVFluidsData as $IVFluidsDatas) : ?>
                                                                            <tr>
                                                                                <input type="hidden" name="row_fluids[]" value="existing">
                                                                                <td>
                                                                                    <input type="text" class="form-control date-shift" name="Date[]" value="<?php echo htmlspecialchars($IVFluidsDatas['date']); ?>">
                                                                                </td>

                                                                                <td><input type="time" class="form-control" name="timeStarted[]" readonly value="<?php echo htmlspecialchars($IVFluidsDatas['timeStarted']); ?>"></td>
                                                                                <td><input type="time" class="form-control" name="timeconsumed[]" readonly value="<?php echo htmlspecialchars($IVFluidsDatas['timeconsumed']); ?>"></td>
                                                                                <td><input type="number" min="0" max="999" class="form-control" readonly name="bottleno[]" value="<?php echo htmlspecialchars($IVFluidsDatas['bottleno']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="solution[]" readonly value="<?php echo htmlspecialchars($IVFluidsDatas['solution']); ?>"></td>
                                                                                <td><input type="text" class="form-control" name="signature_remarks[]" readonly value="<?php echo htmlspecialchars($IVFluidsDatas['signature_remarks']); ?>"></td>




                                                                                <td>
                                                                                    <button class="btn btn-info add-btn"><i class="fas fa-plus"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else : ?>
                                                                        <tr>
                                                                            <input type="hidden" name="row_fluids[]" value="new">
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control datepicker " name="Date[]">
                                                                                    <span class="input-group-text">
                                                                                        <i class="icon-calendar"></i>
                                                                                    </span>
                                                                                    <div class="invalid-feedback">
                                                                                        Date is required.
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="time" class="form-control" name="timeStarted[]" required>


                                                                                <div class="invalid-feedback">
                                                                                    TIME STARTED is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="time" class="form-control" name="timeconsumed[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Time consumed is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control" min="0" max="999" name="bottleno[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Bottle no. is required.
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" name="solution[]" required>
                                                                                <div class="invalid-feedback">
                                                                                    Type of solution is required.
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control" name="signature_remarks[]" required>

                                                                                <div class="invalid-feedback">
                                                                                    Signature / Remarks is required.

                                                                                </div>

                                                                            </td>


                                                                            <td>
                                                                                <button type="button" class="btn btn-info add-btn"><i class="fas fa-plus"></i></button>
                                                                                <button type="button" class="btn btn-danger remove-btn" style="display: none;"><i class="fas fa-minus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                </tbody>
                                                            <?php endif; ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>






                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex gap-2 justify-content-end">

                                                            <button type="submit" id="submitFluids" name="submitFluids" class="btn btn-info">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>




                                        </div>

                                    </div>
                                    <!-- Row end -->









                                <?php else : ?>
                                    <p>No patient details found.</p>
                                <?php endif; ?>

                            </div>
                        </div>




                    </div>
                    <!-- Container ends -->

                </div>
                <!-- App body ends -->

                <!-- App footer start -->
                <?php include './config/footer.php'; ?>
                <!-- App footer end -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <?php include './modal/birth_modal.php'; ?>
    <?php include './modal/notes_modal.php'; ?>





    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->

    <?php include './config/site_js_links.php';


    $message = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }

    ?>

    <script src="../assets/vendor/apex/apexcharts.min.js"></script>
    <script src="./chart.js/Chart.min.js"></script>
    <!-- <script src="assets/vendor/apex/custom/graphs/line.js"></script> -->

    <script src="../assets/script.js"></script>
    <script src="../assets/vitals.js"></script>


    <script>
        $(document).ready(function() {
            $(".datepicker").daterangepicker({
                singleDatePicker: true,
                startDate: moment().startOf("hour"),
                endDate: moment().startOf("hour").add(32, "hour"),
                maxDate: moment(), // Set max date to today
                locale: {
                    format: "DD/MM/YYYY",
                },
            });
            // $('form').submit(function(event) {
            //     var dateInput = $("input[name='datepostpartum']").val();
            //     var formattedDate = moment(dateInput, "DD/MM/YYYY").format("YYYY-MM-DD");
            //     $("input[name='datepostpartum']").val(formattedDate);
            // });
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".datepicker").daterangepicker({
                singleDatePicker: true,
                startDate: moment().startOf("hour"),
                endDate: moment().startOf("hour").add(32, "hour"),
                maxDate: moment(), // Set max date to today
                locale: {
                    format: "DD/MM/YYYY",
                },
            });
            $(".datepickerNexvisit").daterangepicker({
                singleDatePicker: true,
                startDate: moment().startOf("hour"),
                endDate: moment().startOf("hour").add(32, "hour"),
                minDate: moment(), // Set max date to today
                locale: {
                    format: "DD/MM/YYYY",
                },
            });
            // $('form').submit(function(event) {
            //     var dateInput = $("input[name='datepostpartum']").val();
            //     var formattedDate = moment(dateInput, "DD/MM/YYYY").format("YYYY-MM-DD");
            //     $("input[name='datepostpartum']").val(formattedDate);
            // });
        });
    </script>




    <script>
        // Function to set max date for all date inputs with the class 'date-shift'
        function setMaxDateForDateInputs() {
            // Get the current date
            var today = new Date();
            var day = ("0" + today.getDate()).slice(-2);
            var month = ("0" + (today.getMonth() + 1)).slice(-2);
            var year = today.getFullYear();
            var maxDate = year + "-" + month + "-" + day;

            // Get all date inputs with the class 'date-shift'
            var dateInputs = document.querySelectorAll('.date-shift');

            // Set the max attribute for each date input
            dateInputs.forEach(function(input) {
                input.setAttribute('max', maxDate);
            });
        }

        // Call the function when the page loads
        document.addEventListener('DOMContentLoaded', setMaxDateForDateInputs);

        // Select the target node to observe for added nodes
        var targetNode = document.getElementById('Vital-Signs-body');

        // Options for the observer (which mutations to observe)
        var config = {
            childList: true,
            subtree: false
        };

        // Callback function to execute when mutations are observed
        var callback = function(mutationsList, observer) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'childList' && mutation.addedNodes.length) {
                    // Call the function to set the max date whenever a new row is added
                    setMaxDateForDateInputs();
                }
            }
        };

        // Create an instance of MutationObserver and pass in the callback
        var observer = new MutationObserver(callback);

        // Start observing the target node for configured mutations
        observer.observe(targetNode, config);
    </script>

    <script>
        document.getElementById('vitalSigns').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'none';
            document.getElementById('vitalsignsForm').style.display = 'block';
        });

        document.getElementById('cancel_Vitals').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'block';
            document.getElementById('vitalsignsForm').style.display = 'none';
        });
        document.getElementById('goBack').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'block';
            document.getElementById('vitalsignsForm').style.display = 'none';
        });

        document.getElementById('Medications').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'block';
            document.getElementById('MedicationsForm').style.display = 'none';
        });

        document.getElementById('Medication').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'none';
            document.getElementById('MedicationsForm').style.display = 'block';
        });


        document.getElementById('IVFluid').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'none';
            document.getElementById('IVFluidsForm').style.display = 'block';
        });
        document.getElementById('IVFluidsback').addEventListener('click', function() {
            document.getElementById('patient_record_history').style.display = 'block';
            document.getElementById('IVFluidsForm').style.display = 'none';
        });
        $(document).ready(function() {
            // When the "Click to show graph" button is clicked
            $('#vitalsGraph').click(function() {
                // Toggle the visibility of the graph section
                $('#vitalSignsGraphRow').toggle();

                // Optionally, hide the form or keep it visible
                $('#vitalsignsForm').toggle();
            });

            // When the "Back" button is clicked
            $('#Back').click(function() {
                // Hide the graph and show the form
                $('#vitalSignsGraphRow').hide();
                $('#vitalsignsForm').show();
            });
        });
    </script>


    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for add and remove row buttons
            document.getElementById('Vital-Signs-body').addEventListener('click', function(event) {
                if (event.target.classList.contains('add-row-btn') || event.target.closest('.add-row-btn')) {
                    event.preventDefault(); // Prevent default behavior

                    var tableBody = document.getElementById('Vital-Signs-body');
                    var newRow = document.createElement('tr');

                    newRow.innerHTML = `
            <input type="hidden" name="row_status[]" value="new">
                        <td>
                            <input type="date" class="form-control date-shift" name="Date_Shift[]" required>
                            <div class="invalid-feedback">
                                Date is required.
                            </div>
                        </td>
                        <td>
                            <input type="time" class="form-control" name="Time[]" required>
                            <div class="invalid-feedback">
                                Time is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="BP[]" required>
                            <div class="invalid-feedback">
                                BP is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="CR[]" required>
                            <div class="invalid-feedback">
                                CR is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="RR[]" required>
                            <div class="invalid-feedback">
                                RR is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="Temp[]" required>
                            <div class="invalid-feedback">
                                Temp is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="FHT[]" required>
                            <div class="invalid-feedback">
                                FHT is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="Duration[]" required>
                            <div class="invalid-feedback">
                                Duration is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="Frequency[]" required>
                            <div class="invalid-feedback">
                                Frequency is required.
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="Intensity[]" required>
                            <div class="invalid-feedback">
                                Intensity is required.
                            </div>
                        </td>
                        <td>
                            <select name="Nurse_Midwife[]" class="form-select" required>
                                <?php echo $midwife; ?>
                            </select>
                            <div class="invalid-feedback">
                                Midwife/Nurse is required.
                            </div>
                        </td>
                        <td>
                            
                            <button type="button" class="btn btn-danger remove-row-btn" ><i class="fas fa-minus"></i></button>
                        </td>
                            `;

                    tableBody.appendChild(newRow);

                    // Show remove button for the second row
                    var rows = tableBody.getElementsByTagName('tr');
                    if (rows.length == 2) {
                        rows[1].querySelector('.remove-row-btn').style.display = 'inline-block';
                    }

                } else if (event.target.classList.contains('remove-row-btn') || event.target.closest('.remove-row-btn')) {
                    event.preventDefault(); // Prevent default behavior

                    var row = event.target.closest('tr');
                    row.parentNode.removeChild(row);

                    // Hide remove button if only one row remains
                    var rows = document.querySelectorAll('#Vital-Signs-body tr');
                    if (rows.length === 1) {
                        rows[0].querySelector('.remove-row-btn').style.display = 'none';
                    }
                }
            });

            // Form validation before submission
            document.getElementById('vitalsignsForm').addEventListener('submit', function(event) {
                var rows = document.querySelectorAll('#Vital-Signs-body tr');
                var hasValidRow = false;

                rows.forEach(row => {
                    var inputs = Array.from(row.querySelectorAll('input, select'));
                    var isRowFilled = inputs.some(input => input.value.trim() !== '');

                    if (isRowFilled) {
                        hasValidRow = true;
                    }
                });

                if (!hasValidRow) {
                    event.preventDefault();
                    alert('Please add at least one valid row of vital signs.');
                }
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('vitalsignsForm');
            var submitButton = document.getElementById('submitVitals');

            var form2 = document.getElementById('MedicationsForm');
            var submitButton2 = document.getElementById('saveMedications');

            var form3 = document.getElementById('IVFluidsForm');
            var submitButton3 = document.getElementById('submitFluids');
            // Add validation on form submission
            form.addEventListener('submit', function(event) {
                var isValid = false;

                // Check if there are rows
                var rows = form.querySelectorAll('#Vital-Signs-body tr');
                if (rows.length > 0) {
                    // Validate at least one row
                    rows.forEach(function(row) {
                        var inputs = row.querySelectorAll('input, select');
                        if (Array.from(inputs).every(input => input.checkValidity())) {
                            isValid = true;
                        }
                    });
                }

                // Check built-in HTML5 form validation
                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    form.classList.remove('was-validated');
                }
            }, false);
            form3.addEventListener('submit', function(event) {
                var isValid = false;

                // Check if there are rows
                var rows = form3.querySelectorAll('#IVFluid-body tr');
                if (rows.length > 0) {
                    // Validate at least one row
                    rows.forEach(function(row) {
                        var inputs = row.querySelectorAll('input, select');
                        if (Array.from(inputs).every(input => input.checkValidity())) {
                            isValid = true;
                        }
                    });
                }

                // Check built-in HTML5 form validation
                if (!form3.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    form3.classList.remove('was-validated');
                }
            }, false);
            form2.addEventListener('submit', function(event) {
                var isValid = true;

                // Check if there are rows
                var rows = form2.querySelectorAll('#Medication-body tr');
                if (rows.length > 0) {
                    // Validate each row
                    rows.forEach(function(row) {
                        var inputs = row.querySelectorAll('input, select');
                        inputs.forEach(function(input) {
                            if (!input.checkValidity()) {
                                isValid = false;
                                input.classList.add('is-invalid');
                            } else {
                                input.classList.remove('is-invalid');
                            }
                        });
                    });
                }

                // Validate textareas for 'medProcedure' and 'Specimen'
                var medProcedure = document.getElementById('Purok');
                var specimen = document.getElementById('Specimen');

                if (!medProcedure.value.trim()) {
                    isValid = false;
                    medProcedure.classList.add('is-invalid');
                } else {
                    medProcedure.classList.remove('is-invalid');
                }

                if (!specimen.value.trim()) {
                    isValid = false;
                    specimen.classList.add('is-invalid');
                } else {
                    specimen.classList.remove('is-invalid');
                }

                // Check built-in HTML5 form validation
                if (!form2.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form2.classList.add('was-validated');
                } else {
                    form2.classList.remove('was-validated');
                }
            }, false);

            // Handle cancel button
            document.getElementById('cancel_Vitals').addEventListener('click', function() {
                form.reset();
                form.classList.remove('was-validated');
            });

            function toggleInput(checkboxId, inputId) {
                $(checkboxId).change(function() {
                    if ($(this).is(':checked')) {
                        $(inputId).prop('disabled', true).val('None');
                    } else {
                        $(inputId).prop('disabled', false).val('');
                    }
                });
            }

            // Apply the function to each checkbox and input pair
            toggleInput('#pregnancyCheckbox', '#pregnancyInput');
            toggleInput('#notRelatedCheckbox', '#notRelatedInput');
            toggleInput('#laborCheckbox', '#laborInput');
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('form-check-input')) {
                    const checkboxes = document.getElementsByName(e.target.name);
                    checkboxes.forEach((cb) => {
                        if (cb !== e.target) cb.checked = false;
                    });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {


            $('#deliveryRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

                var patientId = button.data('patient-id'); // Get the patient ID


                resetDeliveryForm();

                // Fetch record data
                $.ajax({
                    type: 'POST',
                    url: 'birthing_patients.php', // Ensure this URL is correct
                    data: {
                        birthID: patientId // Send the patient ID to the server
                    },
                    dataType: 'json',
                    success: function(response) {
                      

                        if (response) {

                            $('#patient').val(response.patient_id);
                            $('#dateAdmitted').val(response.admission_date);
                            $('#bp').val(response.bp || '');
                            $('#pr').val(response.pr || '');
                            $('#rr').val(response.rr || '');
                            $('#t').val(response.temp || '');
                            $('#lmp').val(response.LMP || '');
                            $('#edc').val(response.EDC || '');
                            $('#aog').val(response.AOG || '');


                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('XHR Object:', xhr);
                    }
                });
            });

            $('#labourRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var patientId = button.data('labour-id'); // Get the patient ID


                resetDeliveryForm();

                // Fetch record data
                $.ajax({
                    type: 'POST',
                    url: 'birthing_patients.php', // Ensure this URL is correct
                    data: {
                        birthID: patientId // Send the patient ID to the server
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX response:', response); // Debugging: Log the response

                        if (response) {

                            $('#patientid').val(response.patient_id);
                            $('#case_no').val(response.case_no);


                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('XHR Object:', xhr);
                    }
                });
            });

            $('#viewRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recordId = button.data('record-id'); // Extract record ID from data-* attributes

                $('#printPdfButton').attr('href', 'print_labour.php?recordID=' + recordId);
                // Fetch record data
                $('#checkbox-container').empty();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/view_record.php', // Update with the correct URL for your PHP script
                    data: {
                        recordID: recordId
                    },
                    dataType: 'json',
                    success: function(response) {
                     
                        if (response) {
                            // Populate modal fields for viewing a record



                            $('#checkbox-container').html(response.checkboxesHtml);
                            $('#view_case_no').val(response.case_no);
                            $('#birthMonitorID').val(response.birthMonitorID);
                            $('#view_patientid').val(response.patient_id);
                            $('#name').val(response.name.toUpperCase());
                            $('#Oxytocin').val(response.oxytocin);
                            $('#parity').val(response.parity);
                            $('#age').val(response.age);
                            $('#address').val(response.address.toUpperCase());
                            $('#addmissiondate').val(response.admission_date);
                            $('#admissionTime').val(response.admission_time);
                            $('#timeactive').val(response.time_active);
                            $('#timeMembranes').val(response.time_membranes);
                            $('#timeSecond').val(response.time_second);
                            $('#birthTime').val(response.birth_time);


                            if (response.placenta_complete === 'Yes') { // Use the actual key from the response
                                $('input[name="placentaComplete"][value="Yes"]').prop('checked', true);
                                $('input[name="placentaComplete"][value="No"]').prop('checked', false);
                            } else if (response.placenta_complete === 'No') {
                                $('input[name="placentaComplete"][value="Yes"]').prop('checked', false);
                                $('input[name="placentaComplete"][value="No"]').prop('checked', true);
                            }
                            $('#timedelevered').val(response.time_delivered);
                            $('#Estimated').val(response.estimated);

                            if (response.live_birth === 'Livebirth') {
                                $('input[name="Livebirth"][value="Livebirth"]').prop('checked', true); // Check the Livebirth checkbox
                                $('input[name="Livebirth"][value="Stillbirth-Fresh"]').prop('checked', false); // Uncheck the Stillbirth-Fresh checkbox
                            } else if (response.live_birth === 'Stillbirth-Fresh') {
                                $('input[name="Livebirth"][value="Livebirth"]').prop('checked', false); // Uncheck the Livebirth checkbox
                                $('input[name="Livebirth"][value="Stillbirth-Fresh"]').prop('checked', true); // Check the Stillbirth-Fresh checkbox
                            }

                            if (response.RESUSCITATION === 'Yes') { // Use the actual key from the response
                                $('input[name="RESUSCITATION"][value="Yes"]').prop('checked', true);
                                $('input[name="RESUSCITATION"][value="No"]').prop('checked', false);
                            } else if (response.RESUSCITATION === 'No') {
                                $('input[name="RESUSCITATION"][value="Yes"]').prop('checked', false);
                                $('input[name="RESUSCITATION"][value="No"]').prop('checked', true);
                            }
                            if (response.preterm === 'Yes') { // Use the actual key from the response
                                $('input[name="Preterm"][value="Yes"]').prop('checked', true);
                                $('input[name="Preterm"][value="No"]').prop('checked', false);
                            } else if (response.preterm === 'No') {
                                $('input[name="Preterm"][value="Yes"]').prop('checked', false);
                                $('input[name="Preterm"][value="No"]').prop('checked', true);
                            }
                            $('#birthweight').val(response.birth_weight);
                            $('#secondbaby').val(response.second_baby);
                            $('#newbord').val(response.newborn.toUpperCase());

                            // if (response.live_birth === 'Livebirth') {

                            //     $('input[name="livebirth"]').prop('checked', true);
                            //     $('input[name="stillbirth_fresh"]').prop('checked', false);
                            // } else if (response.live_birth === 'Stillbirth-Fresh') {
                            //     $('input[name="livebirth"]').prop('checked', false);
                            //     $('input[name="stillbirth_fresh"]').prop('checked', true);
                            // }

                            if (response.stage_of_labour === 'NOT IN ACTIVE LABOUR') {
                                $('input[name="stage_of_labour"][value="NOT IN ACTIVE LABOUR"]').prop('checked', true); // Check 'NOT IN ACTIVE LABOUR'
                                $('input[name="stage_of_labour"][value="ACTIVE LABOUR"]').prop('checked', false); // Uncheck 'ACTIVE LABOUR'
                            } else if (response.stage_of_labour === 'ACTIVE LABOUR') {
                                $('input[name="stage_of_labour"][value="NOT IN ACTIVE LABOUR"]').prop('checked', false); // Uncheck 'NOT IN ACTIVE LABOUR'
                                $('input[name="stage_of_labour"][value="ACTIVE LABOUR"]').prop('checked', true); // Check 'ACTIVE LABOUR'
                            }


                            $('#maternalplan').val(response.maternal_plan.toUpperCase());

                            if (response.ruptured_membranes) {
                                var rupturedMembranesArray = JSON.parse(response.ruptured_membranes); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="ruptured_membranes[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                rupturedMembranesArray.forEach(function(value) {
                                    $('input[name="ruptured_membranes[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.vaginal_bleeding) {
                                var vaginal_bleedingArray = JSON.parse(response.vaginal_bleeding); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="vaginal_bleeding[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="vaginal_bleeding[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.strong_contractions) {
                                var vaginal_bleedingArray = JSON.parse(response.strong_contractions); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="strong_contractions[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="strong_contractions[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.fetal_heart_rate) {
                                var vaginal_bleedingArray = JSON.parse(response.fetal_heart_rate); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="fetal_heart_rate[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="fetal_heart_rate[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.temperature_axillary) {
                                var vaginal_bleedingArray = JSON.parse(response.temperature_axillary); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="temperature_axillary[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="temperature_axillary[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.pulse) {
                                var vaginal_bleedingArray = JSON.parse(response.pulse); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="pulse[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="pulse[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }

                            if (response.respiratory_rate) {
                                var vaginal_bleedingArray = JSON.parse(response.respiratory_rate); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="respiratory_rate[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="respiratory_rate[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.blood_pressure) {
                                var vaginal_bleedingArray = JSON.parse(response.blood_pressure); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="blood_pressure[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="blood_pressure[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }

                            if (response.urine_voided) {
                                var vaginal_bleedingArray = JSON.parse(response.urine_voided); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="urine_voided[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="urine_voided[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.cervical_dilatation) {
                                var vaginal_bleedingArray = JSON.parse(response.cervical_dilatation); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="cervical_dilatation[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                vaginal_bleedingArray.forEach(function(value) {
                                    $('input[name="cervical_dilatation[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            $('#problem').val(response.problem);
                            $('#timeonset').val(response.time_onset);
                            $('#treatmentsupport').val(response.treatments);
                            $('#referralMother').val(response.referral_details);






                        } else {
                            console.error('No response data');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + error);
                    }
                });
            });


            $('#ViewdeliveryRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var RoomID = button.data('record-id'); // Use 'record-id' instead of 'DeliveryRecords-id'
                $('#printdelivery').attr('href', 'print_delivery.php?id=' + RoomID);

                resetDeliveryForm();
                // Fetch record data
                $.ajax({
                    type: 'POST',
                    url: 'ajax/view_delivery.php', // Ensure this URL is correct
                    data: {
                        RoomID: RoomID
                    },
                    dataType: 'json',
                    success: function(response) {



                        if (response) {


                             $('#deliveryid').val(response.roomID);
                            $('#patients').val(response.patient_id);
                            $('#patientName').val(response.name);
                            $('#Admitted').val(response.dateAdmitted);

                            $('#patientage').val(response.age || '');
                            $('#para').val(response.para || '');
                            $('#bp1').val(response.bp || '');
                            $('#pr1').val(response.pr || '');
                            $('#rr1').val(response.rr || '');
                            $('#t1').val(response.temp || '');
                            $('#lmp1').val(response.LMP || '');
                            $('#edc1').val(response.EDC || '');
                            $('#aog1').val(response.AOG || '');

                            $('#gravida').val(response.gravida);
                            $('#para').val(response.para);
                            $('#fullTerm').val(response.fullTerm);
                            $('#premature').val(response.premature);
                            $('#abortion').val(response.abortion);
                            $('#noOfLiving').val(response.noOfLiving);


                            if (response.labor) {
                                var laborData = JSON.parse(response.labor);

                                // Populate labor fields
                                if (laborData.labor) {
                                    // Populate labor types checkboxes
                                    laborData.labor.types.forEach(function(type) {
                                        $('input[name="labor[]"][value="' + type + '"]').prop('checked', true);
                                    });

                                    // Populate labor time, date, and duration
                                    $('input[name="laborTime"]').val(laborData.labor.time);
                                    $('input[name="laborDate"]').val(laborData.labor.date);
                                    $('input[name="laborHrs"]').val(laborData.labor.duration.hrs);
                                    $('input[name="laborMins"]').val(laborData.labor.duration.mins);
                                }

                                // Populate cervix fields
                                if (laborData.cervix) {
                                    $('input[name="CervixTime"]').val(laborData.cervix.time);
                                    $('input[name="CervixDate"]').val(laborData.cervix.date);
                                    $('input[name="CervixHrs"]').val(laborData.cervix.duration.hrs);
                                    $('input[name="CervixMins"]').val(laborData.cervix.duration.mins);
                                }

                                // Populate baby fields
                                if (laborData.baby) {
                                    $('input[name="BabylaborTime"]').val(laborData.baby.time);
                                    $('input[name="BabylaborDate"]').val(laborData.baby.date);
                                    $('input[name="babyHrs"]').val(laborData.baby.duration.hrs);
                                    $('input[name="babyMins"]').val(laborData.baby.duration.mins);
                                }

                                // Populate placenta fields
                                if (laborData.placenta) {
                                    $('input[name="PlacentaTime"]').val(laborData.placenta.time);
                                    $('input[name="PlacentaDate"]').val(laborData.placenta.date);
                                    $('input[name="PlacentaHrs"]').val(laborData.placenta.duration.hrs);
                                    $('input[name="PlacentaMins"]').val(laborData.placenta.duration.mins);
                                }
                            }


                            var placentaData = JSON.parse(response.placenta);

                            // Clear previous checks (optional, if you want to reset the checkboxes first)
                            $('input[name="placentaExpelled[]"]').prop('checked', false);

                            // Populate the placenta expulsion checkboxes
                            if (placentaData.placenta.expelled.includes("Expelled Completely")) {
                                $('input[name="placentaExpelled[]"][value="Expelled Completely"]').prop('checked', true);
                            }
                            if (placentaData.placenta.expelled.includes("Retained for Method of Expulsion")) {
                                $('input[name="placentaExpelled[]"][value="Retained for Method of Expulsion"]').prop('checked', true);
                            }
                            if (placentaData.placenta.expelled.includes("Spontaneous")) {
                                $('input[name="placentaExpelled[]"][value="Spontaneous"]').prop('checked', true);
                            }
                            if (placentaData.placenta.expelled.includes("Manual Extraction")) {
                                $('input[name="placentaExpelled[]"][value="Manual Extraction"]').prop('checked', true);
                            }



                            $('input[name="cm"]').val(placentaData.umbilicalCord.cm || '');

                            // Handle 'None' checkbox for umbilicalCordNone
                            if (placentaData.umbilicalCord.none === 'None') {
                                $('input[name="umbilicalCordNone"]').prop('checked', true);
                                $('input[name="no_nexk"]').val(''); // Clear No. of Loops field
                            } else {
                                $('input[name="umbilicalCordNone"]').prop('checked', false);
                                $('input[name="no_nexk"]').val(placentaData.umbilicalCord.loops_at_neck || '');
                            }

                            // Handle 'None' checkbox for umbilicalCordLoopsNone
                            if (placentaData.umbilicalCord.loopsNone === 'None') {
                                $('input[name="umbilicalCordLoopsNone"]').prop('checked', true);
                                $('input[name="umbilicalCordLoops"]').val(''); // Clear Other Abnormalities field
                            } else {
                                $('input[name="umbilicalCordLoopsNone"]').prop('checked', false);
                                $('input[name="umbilicalCordLoops"]').val(placentaData.umbilicalCord.loops || '');
                            }

                            // Populate other placenta info
                            $('input[name="placentaOther"]').val(placentaData.other || '');

                            // Populate blood loss data
                            $('input[name="bloodLossAntepartum"]').val(placentaData.bloodLoss.antepartum || '');
                            $('input[name="bloodLossIntrapartum"]').val(placentaData.bloodLoss.intrapartum || '');
                            $('input[name="bloodLossPostpartum"]').val(placentaData.bloodLoss.postpartum || '');
                            $('input[name="totalBloodLoss"]').val(placentaData.bloodLoss.total || '');



                            if (response.method_delivery) {
                                // Parse JSON string into an array
                                var method_delivery = JSON.parse(response.method_delivery);
                                console.log('Parsed method_delivery:', method_delivery); // Log the parsed data for debugging

                                // Uncheck all checkboxes and clear the "Other" text input
                                $('input[name="method[]"]').prop('checked', false);
                                $('#inputOther').val(''); // Clear the "Other" text input
                                $('#inputOther').hide(); // Hide the input for "Other" initially

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    console.log('Processing value:', value); // Log each value for debugging

                                    // Check if the value is "Other"
                                    if (value === "Other") {
                                        $('#checkboxOther').prop('checked', true); // Check the "Other" checkbox
                                        $('#inputOther').show(); // Show the input for "Other"
                                    } else {
                                        // Check other checkboxes based on the value
                                        $('input[name="method[]"][value="' + value + '"]').prop('checked', true);
                                    }
                                });

                                // Show the input for "Other" if any other specific input is provided
                                const otherValue = method_delivery.find(value => value !== "Other" && value.trim() !== "");
                                if (otherValue) {
                                    $('#inputOther').val(otherValue); // Set the value to the input
                                    $('#inputOther').show(); // Show the input field
                                }
                            }




                            if (response.Episiotomy) {
                                var method_delivery = JSON.parse(response.Episiotomy); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="Episiotomy[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="Episiotomy[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.Laceration) {
                                var method_delivery = JSON.parse(response.Laceration); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="Laceration[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="Laceration[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }

                            if (response.Anethesia) {
                                var method_delivery = JSON.parse(response.Anethesia); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="Anethesia[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="Anethesia[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.Analgesia) {
                                var method_delivery = JSON.parse(response.Analgesia); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="Analgesia[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="Analgesia[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.condition) {
                                var method_delivery = JSON.parse(response.condition); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="condition[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="condition[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }


                            if (response.urinary_bladder) {
                                // Parse the JSON string into an array
                                var urinaryBladderData = JSON.parse(response.urinary_bladder);

                                // Uncheck all checkboxes and clear the text input
                                $('input[name="urinary_bladder[]"]').prop('checked', false);
                                $('#urinaryBladderTotalOutput').val(''); // Clear the text input

                                // Loop through the array and populate the fields
                                urinaryBladderData.forEach(function(value) {
                                    if (value === 'W/Catheter') {
                                        $('#urinaryBladderWC').prop('checked', true);
                                    } else if (value === 'Voided') {
                                        $('#urinaryBladderVoided').prop('checked', true);
                                    } else if (!isNaN(value)) {
                                        // Assume numeric values are for the text input
                                        $('#urinaryBladderTotalOutput').val(value);
                                    }
                                });
                            }

                            if (response.uterus) {
                                var method_delivery = JSON.parse(response.uterus); // Parse JSON string into an array
                                // Uncheck all checkboxes first
                                $('input[name="uterus[]"]').prop('checked', false);

                                // Loop through the array and check the corresponding checkboxes
                                method_delivery.forEach(function(value) {
                                    $('input[name="uterus[]"][value="' + value + '"]').prop('checked', true);
                                });
                            }
                            if (response.pregnancy === 'None') {
                                $('#pregnancyCheckbox1').prop('checked', true);
                                $('#pregnancyInput1').val(''); // Clear text input if checkbox is checked
                            } else {
                                $('#pregnancyCheckbox1').prop('checked', false);
                                $('#pregnancyInput1').val(response.pregnancy); // Set the text input value
                            }
                            if (response.not_related === 'None') {
                                $('#notRelatedCheckbox1').prop('checked', true);
                                $('#notRelatedInput1').val(''); // Clear text input if checkbox is checked
                            } else {
                                $('#notRelatedCheckbox1').prop('checked', false);
                                $('#notRelatedInput1').val(response.not_related); // Set the text input value
                            }
                            if (response.complications === 'None') {
                                $('#laborCheckbox1').prop('checked', true);
                                $('#notRelatedInput1').val(''); // Clear text input if checkbox is checked
                            } else {
                                $('#laborCheckbox1').prop('checked', false);
                                $('#laborInput1').val(response.complications); // Set the text input value
                            }


                            $('#handledBy').val(response.Handled_by);
                            $('#assistedBy').val(response.assisted_by);
                            $('#physician').val(response.physician);





                            // Continue populating other fields...
                        } else {
                            console.error('No response data');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + error);
                    }
                });


            });


            $('#PostpartumRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var patientId = button.data('postpartum-id'); // Get the patient ID


                resetDeliveryForm();

                // Fetch record data
                $.ajax({
                    type: 'POST',
                    url: 'ajax/discharged.php', // Ensure this URL is correct
                    data: {
                        dischargedID: patientId // Send the patient ID to the server
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX response:', response); // Debugging: Log the response

                        if (response) {

                            $('#postpartumid').val(response.patient_id);


                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('XHR Object:', xhr);
                    }
                });
            });
            $('#ViewPostpartumRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var patientId = button.data('record-id');


                $('#printpostpartum').attr('href', 'print_postpartum.php?recordID=' + patientId);

                resetDeliveryForm();
                $.ajax({
                    type: 'POST',
                    url: 'ajax/view_postpartum.php',
                    data: {
                        postID: patientId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.monitoring_data) {
                            var monitoring = JSON.parse(response.monitoring_data);

                            $('#postpartumId').val(response.postpartumID);
                            $('#patientname').val(response.patient_id);
                            var dateFormatted = moment(response.date_postpartum).format("DD/MM/YYYY");
                            $('input[name="datepost"]').val(dateFormatted);

                            // Populate the first date and time fields
                            $('input[name="date"]').val(monitoring.date);
                            $('input[name="time"]').val(monitoring.time);

                            var every5_15Times = monitoring.monitoring.every5_15.times;

                            console.log('Every 5-15 Times:', every5_15Times);

                            // Only populate the available number of inputs
                            $('input[name="every5[]"]').each(function(index) {
                                if (index < every5_15Times.length) {

                                    $(this).val(every5_15Times[index]);
                                } else {

                                    $(this).val(''); // Clear the remaining inputs if any
                                }
                            });

                            // Populate the other time fields
                            $('input[name="2HR"]').val(monitoring.monitoring['2HR']);
                            $('input[name="3HR"]').val(monitoring.monitoring['3HR']);
                            $('input[name="4HR"]').val(monitoring.monitoring['4HR']);
                            $('input[name="8HR"]').val(monitoring.monitoring['8HR']);
                            $('input[name="12HR"]').val(monitoring.monitoring['12HR']);
                            $('input[name="date2"]').val(monitoring.monitoring['date2']);
                            $('input[name="16HR"]').val(monitoring.monitoring['16HR']);
                            $('input[name="20HR"]').val(monitoring.monitoring['20HR']);
                            $('input[name="24HR"]').val(monitoring.monitoring['24HR']);
                            $('input[name="DISCHARGE"]').val(monitoring.monitoring.discharge);

                            // Populate the second date field




                            if (response.maternal_wellbeing) {
                                var wellbeingValues = response.maternal_wellbeing.split(', '); // Split into an array
                                $('input[name="maternal"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.uterine_firmness) {
                                var wellbeingValues = response.uterine_firmness.split(', '); // Split into an array
                                $('input[name="uterine"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.rubra) {
                                var wellbeingValues = response.rubra.split(', '); // Split into an array
                                $('input[name="rubra"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }

                            if (response.perineum_pain) {
                                var wellbeingValues = response.perineum_pain.split(', '); // Split into an array
                                $('input[name="perineum"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.breast_condition) {
                                var wellbeingValues = response.breast_condition.split(', '); // Split into an array
                                $('input[name="breast"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.feeding) {
                                var wellbeingValues = response.feeding.split(', '); // Split into an array
                                $('input[name="feeding"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.bladder) {
                                var wellbeingValues = response.bladder.split(', '); // Split into an array
                                $('input[name="bladder"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.bowel_movement) {
                                var wellbeingValues = response.bowel_movement.split(', '); // Split into an array
                                $('input[name="bowel"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.bowel_movement) {
                                var wellbeingValues = response.bowel_movement.split(', '); // Split into an array
                                $('input[name="bowel"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.key_messages) {
                                var wellbeingValues = response.key_messages.split(', '); // Split into an array
                                $('input[name="message"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }
                            if (response.vaginal_discharge) {
                                var wellbeingValues = response.vaginal_discharge.split(', '); // Split into an array
                                $('input[name="viginaldischarge"]').each(function() {
                                    // Check if the checkbox's value is in the wellbeingValues array
                                    if (wellbeingValues.includes($(this).val().trim())) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            }



                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('XHR Object:', xhr);
                    }
                });

            });

            function resetDeliveryForm() {
                // Clear all text inputs
                $('input[type="text"]').val('');
                $('input[type="time"]').val('');
                $('input[type="date"]').val('');


                // Uncheck all checkboxes
                $('input[type="checkbox"]').prop('checked', false);

                // Clear custom invalid feedback, if necessary
                $('.placenta-invalid-feedback').hide();
                // Add any additional reset logic here if needed
            }


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('addEventForm');
            var formdelivery = document.getElementById('deliveryRecordForm');

            var dischargeform = document.getElementById('dischargeform');

            // Select all the checkboxes you want to validate
            var laborCheckboxes = formdelivery.querySelectorAll('input[name="labor[]"]');
            var placentaCheckboxes = formdelivery.querySelectorAll('input[name="placentaExpelled[]"]');

            var methodCheckboxes = formdelivery.querySelectorAll('input[name="method[]"]');

            // Invalid feedback elements
            var laborInvalidFeedback = formdelivery.querySelector('.labor-invalid-feedback');
            var placentaInvalidFeedback = formdelivery.querySelector('.placenta-invalid-feedback');

            var methodInvalidFeedback = formdelivery.querySelector('.method-invalid-feedback');



            dischargeform.addEventListener('submit', function(event) {
                if (!dischargeform.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                dischargeform.classList.add('was-validated');
            }, false);




            function validateCheckboxes(checkboxes, feedbackElement) {
                var isValid = false;
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        isValid = true;
                        break;
                    }
                }
                if (!isValid) {
                    feedbackElement.style.display = 'block';
                    checkboxes.forEach(function(checkbox) {
                        checkbox.classList.add('is-invalid');
                    });
                } else {
                    feedbackElement.style.display = 'none';
                    checkboxes.forEach(function(checkbox) {
                        checkbox.classList.remove('is-invalid');
                    });
                }
                return isValid;
            }

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            formdelivery.addEventListener('submit', function(event) {
                var isLaborValid = validateCheckboxes(laborCheckboxes, laborInvalidFeedback);
                var isPlacentaValid = validateCheckboxes(placentaCheckboxes, placentaInvalidFeedback);
                var ismethodValid = validateCheckboxes(methodCheckboxes, methodInvalidFeedback);




                if (!isLaborValid || !isPlacentaValid || !ismethodValid || !formdelivery.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                formdelivery.classList.add('was-validated');
            }, false);
        });
        $('#no_nexk_checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#no_nexk').val('').prop('disabled', true);
            } else {
                $('#no_nexk').prop('disabled', false);
            }
        });

        $('#umbilicalCordLoops_checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#umbilicalCordLoops').val('').prop('disabled', true);
            } else {
                $('#umbilicalCordLoops').prop('disabled', false);
            }
        });
    </script>





    <script>
        function printContent() {
            var printArea = document.getElementById("print");
            var inputs = printArea.getElementsByTagName("input");
            var textareas = printArea.getElementsByTagName("textarea");
            var checkboxes = printArea.querySelectorAll('input[type="checkbox"]');

            // Update the value attribute of all inputs
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type === "text" || inputs[i].type === "date" || inputs[i].type === "time") {
                    inputs[i].setAttribute("value", inputs[i].value);
                }
            }

            // Update the value of all textareas
            for (var i = 0; i < textareas.length; i++) {
                textareas[i].innerHTML = textareas[i].value;
            }

            // Update the checked attribute of all checkboxes
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checkboxes[i].setAttribute("checked", "checked");
                } else {
                    checkboxes[i].removeAttribute("checked");
                }
            }

            var today = new Date();
            var date = today.toLocaleDateString(); // e.g., MM/DD/YYYY
            var time = today.toLocaleTimeString(); // e.g., HH:MM:SS AM/PM

            // Create a title with the current date and time
            var documentTitle = "LABOUR RECORD - " + date + " " + time;

            var printableArea = printArea.innerHTML;
            var winPrint = window.open('', '');
            winPrint.document.write('<html><title>' + documentTitle + '</title>');
            winPrint.document.write('<body style="font-family:fangsong;">');
            winPrint.document.write(printableArea);
            winPrint.document.write('</body></html>');
            winPrint.document.close();
            winPrint.print();
        }
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to show/hide cards based on selected options
            function handleSelectChange() {
                var recordSelectValue = document.getElementById('recordSelect').value;
                var medicationSelectValue = document.getElementById('MedicationSelect').value;

                // Hide all cards initially
                document.querySelectorAll('#patient_record_history .col-xl-4').forEach(function(card) {
                    card.classList.add('d-none');
                });

                // Show relevant card based on record selection
                if (recordSelectValue) {
                    var recordCard = document.getElementById(recordSelectValue);
                    if (recordCard) {
                        recordCard.classList.remove('d-none');
                    }
                }

                // Show relevant card based on medication selection
                if (medicationSelectValue) {
                    var medicationCard = document.getElementById(medicationSelectValue);
                    if (medicationCard) {
                        medicationCard.classList.remove('d-none');
                    }
                }
            }

            // Event listeners for both selects
            document.getElementById('recordSelect').addEventListener('change', handleSelectChange);
            document.getElementById('MedicationSelect').addEventListener('change', handleSelectChange);
        });
    </script>

    <!-- <script src="./assets/script.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to initialize datepicker on date fields
            function initializeDatepicker() {
                $(".datepicker").daterangepicker({
                    singleDatePicker: true,
                    startDate: moment().startOf("hour"),
                    endDate: moment().startOf("hour").add(32, "hour"),
                    maxDate: moment(), // Set max date to today
                    locale: {
                        format: "DD/MM/YYYY",
                    },
                });
            }

            // Initialize datepicker for existing date fields
            initializeDatepicker();

            // Event listener for add and remove row buttons
            document.getElementById('Medication-body').addEventListener('click', function(event) {
                if (event.target.classList.contains('add-btn') || event.target.closest('.add-btn')) {
                    event.preventDefault(); // Prevent default behavior

                    var tableBody = document.getElementById('Medication-body');
                    var newRow = document.createElement('tr');

                    newRow.innerHTML = `
                <input type="hidden" name="row_med[]" value="new">
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" name="orderDate[]">
                        <span class="input-group-text">
                            <i class="icon-calendar"></i>
                        </span>
                    </div>
                </td>
                 <td>
                <select name="MedDosage[]" class="form-select" required>
                
                <?php echo $medicine; ?>
                  
                </select>
                  <div class="invalid-feedback">
                    Medicine  is required.
                </div>
                
               
            </td>
                <td>
                <input type="text" class="form-control" name="Dosage[]" required>
                <div class="invalid-feedback">
                Dosage  is required.
                </div>
            </td>
                <td>
                    <input type="text" class="form-control" name="Frequency[]" required>
                    <div class="invalid-feedback">
                        Frequency is required.
                    </div>
                </td>
                <td>
                    <input type="time" class="form-control" name="time[]" required>
                    <div class="invalid-feedback">
                        Time is required.
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" name="date_signature[]">
                        <span class="input-group-text">
                            <i class="icon-calendar"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control" name="signature[]" required>
                    <div class="invalid-feedback">
                        Signature is required.
                    </div>
                </td>
                <td>
                   
                    <button type="button" class="btn btn-danger remove-btn" style="display: inline-block;"><i class="fas fa-minus"></i></button>
                </td>
            `;

                    tableBody.appendChild(newRow);

                    // Re-initialize the datepicker for the new row
                    initializeDatepicker();

                } else if (event.target.classList.contains('remove-btn') || event.target.closest('.remove-btn')) {
                    event.preventDefault(); // Prevent default behavior

                    var row = event.target.closest('tr');
                    row.parentNode.removeChild(row);

                    // Hide remove button if only one row remains
                    var rows = document.querySelectorAll('#Medication-body tr');
                    if (rows.length === 1) {
                        rows[0].querySelector('.remove-btn').style.display = 'none';
                    }
                }
            });

            // Form validation before submission
            document.getElementById('MedicationsForm').addEventListener('submitMedications', function(event) {
                var rows = document.querySelectorAll('#Medication-body tr');
                var hasValidRow = false;

                rows.forEach(row => {
                    var inputs = Array.from(row.querySelectorAll('input, select'));
                    var isRowFilled = inputs.some(input => input.value.trim() !== '');

                    if (isRowFilled) {
                        hasValidRow = true;
                    }
                });

                if (!hasValidRow) {
                    event.preventDefault();
                    alert('Please add at least one valid row of vital signs.');
                }
            });
        });
    </script>


    <!-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            $.ajax({
                url: 'ajax/vitalsigns.php', // URL of your PHP script
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Initialize arrays for chart data
                    let labels = [];
                    let pulseData = [];
                    let tempData = [];

                    // Process the data and extract necessary values
                    data.forEach(item => {
                        labels.push(item.time); // Use time as labels
                        pulseData.push(item.cr); // Use 'cr' for pulse data
                        tempData.push(item.temp); // Use 'temp' for temperature data
                    });

                    // Initialize the chart
                    const ctx = document.getElementById('vitalSignsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels, // Use dynamic labels
                            datasets: [{
                                    label: 'Pulse',
                                    borderColor: 'red',
                                    fill: false,
                                    data: pulseData // Use dynamic pulse data
                                },
                                {
                                    label: 'Temp',
                                    borderColor: 'blue',
                                    fill: false,
                                    data: tempData // Use dynamic temperature data
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: false
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    </script> -->



    <script>
        // Trigger the modal when Discharge is selected
        document.getElementById('ActionSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var patientID = selectedOption.getAttribute('data-discharged-id');


            if (this.value === 'Discharge') {
                // Set the patient ID in the hidden input field in the discharge modal
                document.getElementById('patient').value = patientID;

                // Trigger the discharge modal
                var dischargedModal = new bootstrap.Modal(document.getElementById('discharged'), {
                    keyboard: false
                });
                dischargedModal.show();

            } else if (this.value === 'Refer') {

                var referModal = new bootstrap.Modal(document.getElementById('COnfirmRefer'), {
                    keyboard: false
                });
                referModal.show();

                // Handle the confirmation button click
                document.getElementById('confirmReferral').onclick = function() {
                    // Perform AJAX request to save the referral log
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'ajax/save_referral.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                // If referral log is successfully saved, redirect to referral page
                                window.location.href = 'print_referral.php?id=' + encodeURIComponent(patientID);
                            } else {
                                alert(response.message); // Show error message
                            }
                        }
                    };

                    xhr.send('patient_id=' + encodeURIComponent(patientID));
                };
            }
        });


        // AJAX call to fetch and populate data in the modal
        $('#discharged').on('show.bs.modal', function(event) {
            var patientID = document.getElementById('patient').value; // Get the patient ID from the hidden input field

            resetDeliveryForm();

            // Fetch record data via AJAX
            $.ajax({
                type: 'POST',
                url: 'ajax/discharged.php', // Ensure this URL is correct
                data: {
                    dischargedID: patientID // Send the patient ID to the server
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        if (response.error) {
                            console.error('Server Error:', response.error); // Handle server-side errors
                        } else {
                            // Populate modal fields
                            $('#patientdishcarged').val(response.patient_id);
                            $('#birthiid').val(response.birth_info_id);
                            $('#patientName1').val(response.name);
                            $('#age1').val(response.age);
                            $('#sex').val(response.gender);
                            // Populate other fields as needed
                        }
                    } else {
                        console.error('No response data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('XHR Object:', xhr);
                }
            });
        });

        // $('#referModal').on('show.bs.modal', function(event) {
        //     var referID = document.getElementById('referPatientId').value;

        //     resetDeliveryForm();

        //     // Fetch record data via AJAX
        //     $.ajax({
        //         type: 'POST',
        //         url: 'ajax/refer.php', // Ensure this URL is correct
        //         data: {
        //             referID: referID
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response) {
        //                 if (response.error) {
        //                     console.error('Server Error:', response.error);
        //                 } else {
        //                     // Populate modal fields
        //                     $('#referPatientName').val(response.name);
        //                     $('#referAge').val(response.age);
        //                     $('#dateAdmittedRefer').val(response.date);
        //                     // Populate other fields as needed
        //                 }
        //             } else {
        //                 console.error('No response data');
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('AJAX Error:', error);
        //             console.error('XHR Object:', xhr);
        //         }
        //     });
        // });

        function resetDeliveryForm() {
            // Reset the form fields in the modal before populating new data
            $('#patientName1').val('');
            $('#age1').val('');
            $('#dateAdmitted1').val('');
            // Reset other fields if necessary...
        }
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medicationContainer = document.getElementById('medicationContainer');

            medicationContainer.addEventListener('click', function(e) {
                // Add new medication input
                if (e.target && e.target.matches('button.add-medication, button.add-medication i')) {
                    const newRow = document.createElement('div');
                    newRow.className = 'row mb-2'; // Ensures new row follows Bootstrap grid
                    newRow.innerHTML = `
                <div class="col-md-12">
                    <div class="d-flex align-items-center" style="margin-left:  2rem;">
                        <input type="text" name="homeMedications[]" class="form-control me-2" required>
                        <button type="button" class="btn btn-danger remove-medication me-2"><i class="icon-trash"></i></button>
                    </div>
                </div>
            `;
                    medicationContainer.appendChild(newRow);
                }

                // Remove medication input
                if (e.target && e.target.matches('button.remove-medication, button.remove-medication i')) {
                    const rowToRemove = e.target.closest('.row');
                    rowToRemove.remove();
                }
            });
        });
    </script>



    <script>
        document.getElementById('HealthNotes').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var patientID = selectedOption.getAttribute('data-healthnotes-id');

            if (this.value === 'docnotes') {
                // Set the hidden input value for the patient ID
                document.getElementById('docid').value = patientID;

                // Trigger the doctor's notes modal
                var docnoteModal = new bootstrap.Modal(document.getElementById('docnotes'), {
                    keyboard: false
                });
                docnoteModal.show();
            } else if (this.value === 'nursenote') {
                // Set the hidden input value for the patient ID (if needed for nurse's notes)
                document.getElementById('nurseid').value = patientID;

                // Trigger the nurse's notes modal
                var nursenoteModal = new bootstrap.Modal(document.getElementById('nursenotes'), {
                    keyboard: false
                });
                nursenoteModal.show();
            }
        });

        $('#docnotes').on('show.bs.modal', function(event) {
            var patientid = document.getElementById('docid').value;

            $('#printNotes').attr('href', 'print_DoctorNotes.php?id=' + patientid);

            console.log(patientid);
            $.ajax({
                type: 'POST',
                url: 'ajax/healthnotes.php',
                data: {
                    docnoteid: patientid
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        if (response.error) {
                            console.error('Server Error:', response.error);
                        } else {
                            $('#docid').val(response.patient_id);
                            $('#dname').val(response.patient_name + ' ' + response.middle_name + ' ' + response.last_name || '').prop('readonly', true);
                            $('#dage').val(response.age || '').prop('readonly', true);
                            $('#droom').val(response.room || '').prop('readonly', true);

                            $('#docnotesTableBody').empty();

                            response.doctor_notes.forEach(function(note) {
                                let existingRow = `
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="${note.date || ''}" readonly>
                                </td>
                                <td>
                                    <input type="time" class="form-control" value="${note.time || ''}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="${note.doctor || ''}" readonly>
                                </td>
                                <td>
                                    <textarea class="form-control" readonly>${note.notes || ''}</textarea>
                                </td>
                                <td></td>
                            </tr>
                        `;
                                $('#docnotesTableBody').append(existingRow);
                            });

                            let emptyRow = `
                        <tr>
                            <td>
                                <input type="text" class="form-control datepicker" name="date[]" required>
                            </td>
                            <td><input type="time" class="form-control" name="time[]" required></td>
                            <td>
                                <select name="doctor[]" class="form-select" required>
                                    <?php echo $doctor; ?>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" name="docnotes[]" required></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove"><i class="icon-trash"></i></button>
                            </td>
                        </tr>
                    `;
                            $('#docnotesTableBody').append(emptyRow);
                            // Initialize datepicker only for the newly added empty row
                            initializeDatepicker($('#docnotesTableBody tr:last-child .datepicker'));
                        }
                    } else {
                        console.error('No response data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('XHR Object:', xhr);
                }
            });
        });

        $(document).on('click', '#NewRow', function() {
            let newRow = `
        <tr>
            <td>
                <input type="text" class="form-control datepicker" name="date[]" required>
            </td>
            <td><input type="time" class="form-control" name="time[]" required></td>
            <td>
                <select name="doctor[]" class="form-select" required>
                    <?php echo $doctor; ?>
                </select>
            </td>
            <td><textarea class="form-control" name="docnotes[]" required></textarea></td>
            <td><button type="button" class="btn btn-danger remove"><i class="icon-trash"></i></button></td>
        </tr>
    `;
            $('#docnotesTableBody').append(newRow);
            // Initialize datepicker only for the newly added row
            initializeDatepicker($('#docnotesTableBody tr:last-child .datepicker'));
        });

        // Remove a row
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });





        $('#nursenotes').on('show.bs.modal', function(event) {
            var patientid = document.getElementById('nurseid').value;
            $('#printNurseNotes').attr('href', 'print_NurseNotes.php?id=' + patientid);
            $.ajax({
                type: 'POST',
                url: 'ajax/healthnotes.php',
                data: {
                    docnoteid: patientid
                },
                dataType: 'json',
                success: function(response) {
                    if (response && !response.error) {
                        $('#pid').val(response.patient_id || '');
                        $('#nurseid').val(response.nurse_midwife || '');
                        $('#nname').val(response.patient_name || '').prop('readonly', true);
                        $('#nage').val(response.age || 'N/A').prop('readonly', true);
                        $('#nroom').val(response.room || 'N/A').prop('readonly', true);
                        $('#nursenotesTableBody').empty();

                        // Add existing nurse notes
                        response.nurse_notes.forEach(function(note) {
                            let existingRow = `
                        <tr>
                            <td>
                                <input type="text" class="form-control " value="${note.date || ''}" readonly>
                            </td>
                            <td><input type="time" class="form-control" value="${note.time || ''}" readonly></td>
                            <td><textarea class="form-control" readonly>${note.notes || ''}</textarea></td>
                            <td></td>
                        </tr>
                    `;
                            $('#nursenotesTableBody').append(existingRow);
                        });

                        // Add an empty row for new entries
                        let emptyRow = `
                    <tr>
                        <td>
                            <input type="text" class="form-control datepicker" name="date[]" required>
                        </td>
                        <td><input type="time" class="form-control" name="time[]" required></td>
                        <td><textarea class="form-control" name="docnotes[]" required></textarea></td>
                        <td><button type="button" class="btn btn-danger remove"><i class="icon-trash"></i></button></td>
                    </tr>
                `;
                        $('#nursenotesTableBody').append(emptyRow);
                        initializeDatepicker($('#nursenotesTableBody tr:last-child .datepicker'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        // Add new row
        $(document).on('click', '#addNewRow', function() {
            let newRow = `
        <tr>
            <td>
                <input type="text" class="form-control datepicker" name="date[]" required>
            </td>
            <td><input type="time" class="form-control" name="time[]" required></td>
            <td><textarea class="form-control" name="docnotes[]" required></textarea></td>
            <td><button type="button" class="btn btn-danger remove"><i class="icon-trash"></i></button></td>
        </tr>
    `;
            $('#nursenotesTableBody').append(newRow);

            initializeDatepicker($('#nursenotesTableBody tr:last-child .datepicker'));
        });

        // Remove a row
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });


        function initializeDatepicker(selector) {
            $(selector).daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: "DD/MM/YYYY"
                },
                startDate: moment(),
                maxDate: moment()
            });
        }
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('docnotesForm');
            var form1 = document.getElementById('nursenotesForm');


            // Add validation on form submission
            form.addEventListener('submit', function(event) {
                var isValid = true; // Assume the form is valid


                // Check built-in HTML5 form validation
                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    form.classList.remove('was-validated');
                }
            }, false);
            form1.addEventListener('submit', function(event) {
                var isValid = true; // Assume the form is valid


                // Check built-in HTML5 form validation
                if (!form1.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form1.classList.add('was-validated');
                } else {
                    form1.classList.remove('was-validated');
                }
            }, false);
        });
    </script>
</body>



</html>