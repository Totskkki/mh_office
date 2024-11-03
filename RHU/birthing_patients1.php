<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');



if (isset($_POST['birthID'])) {
    $id = $_POST['birthID'];
    $queryUsers = "SELECT b.*,com.*
     FROM tbl_birth_info b
    LEFT JOIN tbl_complaints com on com.patient_id = b.patient_id
    
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
    $vitalSignsQuery = "SELECT vitals.*,u.*,p.* FROM tbl_vitalSigns_Monitoring vitals
    LEFT JOIN tbl_users u on u.userID = vitals.nurse_midwife
    LEFT JOIN tbl_personnel p on p.personnel_id = u.personnel_id 
     WHERE patient_id = :id ORDER BY vitals.vitalSignsID  DESC";
    $stmt = $con->prepare($vitalSignsQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $vitalSignsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $birthMonitoringgnsQuery = "SELECT birth.*,u.*,p.* FROM tbl_birthing_monitoring birth
    LEFT JOIN tbl_users u on u.userID = birth.patient_id
    LEFT JOIN tbl_personnel p on p.personnel_id = u.personnel_id 
     WHERE patient_id = :id ORDER BY birth.birthMonitorID  DESC";
    $stmt = $con->prepare($birthMonitoringgnsQuery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $monitoringRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt = $con->prepare("INSERT INTO `tbl_birthing_monitoring`(`case_no`,`patient_id`, `parity`, `admission_date`, `admission_time`, `time_active`, `time_membranes`, `time_second`,`birth_time`, `oxytocin`, `placenta_complete`, `estimated`, `time_delivered`, `live_birth`,`RESUSCITATION`, `birth_weight`, `preterm`, `second_baby`, `newborn`, `stage_of_labour`, `ruptured_membranes`, `vaginal_bleeding`, `strong_contractions`, `fetal_heart_rate`, `temperature_axillary`, `pulse`, `respiratory_rate`, `blood_pressure`, `urine_voided`, `cervical_dilatation`, `maternal_plan`, `problem`, `time_onset`, `treatments`, `referral_details`)
        VALUES (:case_no,:patient_id, :parity, :admission_date, :admission_time, :time_active, :time_membranes, :time_second,:birth_time, :oxytocin, :placenta_complete, :estimated, :time_delivered, :live_birth,:RESUSCITATION, :birth_weight, :preterm, :second_baby, :newborn, :stage_of_labour, :ruptured_membranes, :vaginal_bleeding, :strong_contractions, :fetal_heart_rate, :temperature_axillary, :pulse, :respiratory_rate, :blood_pressure, :urine_voided, :cervical_dilatation, :maternal_plan, :problem, :time_onset, :treatments, :referral_details)");

        $stmt->execute([
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

        $stmt = $con->prepare("INSERT INTO tbl_vitalSigns_Monitoring (`room`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `fht`, `duration`, `frequency`, `intensity`, `nurse_midwife`, `patient_id`)
        VALUES (:room, :date_shift, :time, :bp, :cr, :rr, :temp, :fht, :duration,:frequency, :intensity,:nurse_midwife_signature,:patient_id)");

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
                    ':patient_id' =>   $patientID
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


// if (isset($_POST['saveVitals'])) {
//     $patientID = trim($_POST['patientID']);
//     $room = trim($_POST['room']);
//     $date_shift = $_POST['Date_Shift'];
//     $time = $_POST['Time'];
//     $bp = $_POST['BP'];
//     $cr = $_POST['CR'];
//     $rr = $_POST['RR'];
//     $temp = $_POST['Temp'];
//     $fht = $_POST['FHT'];
//     $duration = $_POST['Duration'];
//     $frequency = $_POST['Frequency'];
//     $intensity = $_POST['Intensity'];
//     $nurse_midwife_signature = $_POST['Nurse_Midwife'];

//     // Validate that there is at least one set of vital signs data
//     $hasData = false;
//     for ($i = 0; $i < count($date_shift); $i++) {
//         if (!empty($date_shift[$i]) && !empty($time[$i])) {
//             $hasData = true;
//             break;
//         }
//     }

//     if (!$hasData) {
//         $_SESSION['status'] = "At least one set of vital signs data must be provided.";
//         $_SESSION['status_code'] = "error";
//         header('Location: birthing_patients.php?id=' . urlencode($patientID));
//         exit();
//     }

//     try {
//         $con->beginTransaction();

//         $stmt = $con->prepare("INSERT INTO tbl_vitalSigns_Monitoring (`room`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `fht`, `duration`, `frequency`, `intensity`, `nurse_midwife`, `patient_id`)
//          VALUES (:room, :date_shift, :time, :bp, :cr, :rr, :temp, :fht, :duration, :frequency, :intensity, :nurse_midwife_signature, :patient_id)");

//         for ($i = 0; $i < count($date_shift); $i++) {
//             if (!empty($date_shift[$i]) && !empty($time[$i])) {
//                 $stmt->execute([
//                     ':room' => $room,
//                     ':date_shift' => $date_shift[$i],
//                     ':time' => $time[$i],
//                     ':bp' => $bp[$i],
//                     ':cr' => $cr[$i],
//                     ':rr' => $rr[$i],
//                     ':temp' => $temp[$i],
//                     ':fht' => $fht[$i],
//                     ':duration' => $duration[$i],
//                     ':frequency' => $frequency[$i],
//                     ':intensity' => $intensity[$i],
//                     ':nurse_midwife_signature' => $nurse_midwife_signature[$i],
//                     ':patient_id' => $patientID
//                 ]);
//             }
//         }

//         $con->commit();
//         $_SESSION['status'] = "Vital Signs added successfully.";
//         $_SESSION['status_code'] = "success";
//         header('Location: birthing_patients.php?id=' . urlencode($patientID));
//         exit();
//     } catch (Exception $e) {
//         $con->rollBack();
//         die("Error: " . $e->getMessage());
//     }
// }



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
                                            <h5 class="card-title text-center"> <span class="float-end"></span></h5>
                                        </div>

                                        <div class="card-body">


                                            <!-- 
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#deliveryRecord" data-patient-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                                    DISCHARGED <i class="icon-arrow-right"></i>
                                                </button> -->

                                            <div class="row flex-container">


                                                <div class="flex-item">
                                                    <h2><strong><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></strong><span>
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deliveryRecord" class="btn btn-primary float-end" data-patient-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                                                DISCHARGED </button>
                                                        </span> </h2>

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
                                                    <select name="" id="recordSelect" class="form-select text-center" style="width: 15%;color:#ffffff;background-color:#009879;font-size:15px">
                                                        <option value="">--Select Record--</option>
                                                        <option value="delivery"> Delivery Room Record</option>
                                                        <option value="Monitor"> Monitor Patient During Birth</option>
                                                        <option value="Postpartum">Postpartum</option>
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
                                                                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#labourRecord" data-patient-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
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
                                                                                    <strong>Admission:</strong>
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

                                                    <div class="col-xl-4 col-sm-6 col-12">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header rounded-1 shadow">
                                                                <h5 class="card-title">
                                                                    Monitor Patient During Birth Record
                                                                    <span>
                                                                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#labourRecord" data-patient-id="<?php echo htmlspecialchars($patientData['patientID']); ?>">
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
                                                                                    <strong>Admission:</strong>
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


                                                    <div class="col-xl-4 col-sm-6 col-12">
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

                                                    <div class="col-xl-4 col-sm-6 col-12">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">Medication <span><a href="maternity.php" type="button" class="btn btn-info float-end">
                                                                            <i class="icon-plus"></i>

                                                                        </a></span></h5>

                                                            </div>
                                                            <div class="card-body">
                                                                <p>

                                                                </p>
                                                                <!-- <a href="#" class="btn btn-primary"></a> -->
                                                            </div>
                                                            <div class="card-footer">
                                                                <span class="badge border border-primary text-primary"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-sm-6 col-12">
                                                        <div class="card mb-4 card-outline rounded-0 shadow">
                                                            <div class="card-header  rounded-1 shadow ">
                                                                <h5 class="card-title">IV FLUID <span><a href="maternity.php" type="button" class="btn btn-info float-end">
                                                                            <i class="icon-plus"></i>

                                                                        </a></span></h5>

                                                            </div>
                                                            <div class="card-body">
                                                                <p>

                                                                </p>
                                                                <!-- <a href="#" class="btn btn-primary"></a> -->
                                                            </div>
                                                            <div class="card-footer">
                                                                <span class="badge border border-primary text-primary"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                            </div>


                                            <form method="POST" id="vitalsignsForm" style="display: none;" novalidate>
                                                <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <h3>VITAL SIGNS MONITORING SHEET <span> <button style="margin-left: 2rem;" id="goBack" type="button" class="btn btn-primary">
                                                                        <i class="icon-arrow-left"></i> Back</button></span></h3>

                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="12" class="pt-3 pb-3">
                                                                            <div style="text-align: left; flex: 1;">
                                                                                <label class="form-label">ROOM: </label>
                                                                                <input class="form-input" type="text" name="room" value="<?php echo htmlspecialchars($vitalSignsData[0]['room'] ?? ''); ?>" required>
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
                                                                                    <input type="date" class="form-control date-shift" name="Date_Shift[]" value="<?php echo htmlspecialchars($vitalSign['date_shift']); ?>">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <?php include './config/site_js_links.php';

    $message = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }

    ?>





    </script>



    <script src="assets/moment/moment.min.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>



    <!-- 
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

        // Also call the function whenever a new row is added
        document.getElementById('Vital-Signs-body').addEventListener('DOMNodeInserted', setMaxDateForDateInputs);
    </script> -->

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
            // Triggered when the "Add Labour Record" button is clicked
            $('body').on('show.bs.modal', '#labourRecord, #deliveryRecord', function(event) {
                var button = $(event.relatedTarget);
                var patientId = button.data('patient-id');

                // Fetch patient data
                $.ajax({
                    type: 'POST',
                    url: 'birthing_patients.php',
                    data: {
                        birthID: patientId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            // Populate modal fields for adding a new record
                            // var caseNo = response.case_no || 'CASE-' + Math.floor(100000 + Math.random() * 900000);
                            // $('#case_no').val(caseNo); // Set the case number
                            $('#case_no').val(response.case_no);
                            $('#patientid').val(response.patient_id);
                            $('#patient').val(response.patient_id);
                            $('#bp').val(response.bp || '');
                            $('#pr').val(response.pr || '');
                            $('#rr').val(response.rr || '');
                            $('#t').val(response.temp || '');
                            $('#lmp').val(response.LMP || '');
                            $('#edc').val(response.EDC || '');
                            $('#aog').val(response.AOG || '');


                        } else {
                            console.error('No response data');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + error);
                    }
                });
            });


            // Triggered when the "View Record" button is clicked
            $('#viewRecord').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var recordId = button.data('record-id'); // Extract record ID from data-* attributes
                console.log(recordId);
                // Fetch record data
                $.ajax({
                    type: 'POST',
                    url: 'ajax/view_record.php', // Update with the correct URL for your PHP script
                    data: {
                        recordID: recordId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            // Populate modal fields for viewing a record
                            $('#view_case_no').val(response.case_no);
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
                                $('input[name="livebirth"]').prop('checked', true);
                                $('input[name="stillbirth_fresh"]').prop('checked', false);
                            } else if (response.live_birth === 'Stillbirth-Fresh') {
                                $('input[name="livebirth"]').prop('checked', false);
                                $('input[name="stillbirth_fresh"]').prop('checked', true);
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
                            if (response.stage_of_labour === 'NOT IN ACTIVE LABOUR') {
                                $('input[name="stage_of_labour"]').prop('checked', true);
                                $('input[name="active_labour"]').prop('checked', false);
                            } else if (response.stage_of_labour === 'ACTIVE LABOUR') {
                                $('input[name="stage_of_labour"]').prop('checked', false);
                                $('input[name="active_labour"]').prop('checked', true);
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
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('addEventForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);



        });
        document.getElementById('recordSelect').addEventListener('change', function () {
    // Hide all cards initially
    document.getElementById('deliveryCard').classList.add('d-none');
    document.getElementById('monitorCard').classList.add('d-none');
    document.getElementById('postpartumCard').classList.add('d-none');

    // Display the selected card
    if (this.value === 'delivery') {
        document.getElementById('deliveryCard').classList.remove('d-none');
    } else if (this.value === 'monitor') {
        document.getElementById('monitorCard').classList.remove('d-none');
    } else if (this.value === 'postpartum') {
        document.getElementById('postpartumCard').classList.remove('d-none');
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


        // window.jsPDF = window.jspdf.jsPDF;

        // // Create the jsPDF document with portrait orientation for a letter-sized page
        // var docPDF = new jsPDF({
        //     orientation: 'landscape',
        //     unit: 'pt', 
        //     format: 'letter' // Letter size: 8.5 x 11 inches
        // });

        // // Set the font size (e.g., 12)
        // docPDF.setFontSize(10);

        // function downlaodcontent(birthinfo) {
        //     var elementHtml = document.querySelector("#print");

        //     docPDF.html(elementHtml, {
        //         callback: function() {
        //             docPDF.save(birthinfo + '.pdf');
        //         },
        //         x: 15,
        //         y: 15,
        //         width: 582,
        //         windowWidth: 900,
        //         scale: 0.7 
        //     });
        // }
    </script>





</body>



</html>