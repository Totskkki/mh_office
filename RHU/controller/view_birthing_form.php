<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {

    $birthInfoID = $_GET['id']; // assuming this is birth_info_id

    // Fetch patient data
    $query = "SELECT a.*, com.*, pat.*, fam.*, mem.*, u.*, per.*, a.date,
	CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
	CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as `address`,
	CONCAT(per.`first_name`, ' ', per.`middlename`, ' ', per.`lastname`) AS `personnel_name`
	FROM tbl_birth_info AS a 
	LEFT JOIN tbl_patients AS pat ON a.patient_id = pat.patientID
	LEFT JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
	LEFT JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID    
	LEFT JOIN tbl_complaints as com ON com.patient_id = a.patient_id 
	LEFT JOIN tbl_users AS u ON u.userID  = a.midwife_nurse
	LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id
	WHERE a.birth_info_id = :birthInfoID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $patientData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch vital signs data using the patientID (related to birth_info_id)
    $vitalSignsQuery = "SELECT vitals.*, u.*, p.*, b.*, COUNT(vitals.vitalSignsID) AS vital_count 
    FROM tbl_vitalSigns_Monitoring vitals
    JOIN tbl_users u ON u.userID = vitals.nurse_midwife
    JOIN tbl_personnel p ON p.personnel_id = u.personnel_id
    JOIN tbl_birth_info b ON b.birth_info_id = vitals.birth_info_id
    WHERE vitals.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY vitals.patient_id
    ORDER BY vitals.vitalSignsID DESC";

    $stmt = $con->prepare($vitalSignsQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $vitalSignsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $IVfluidsQuery = "SELECT iv.*,   b.*, COUNT(iv.fluidsID ) AS iv_count 
    FROM tbl_birth_ivfluids iv
  
    JOIN tbl_birth_info b ON b.birth_info_id = iv.birth_info_id
    WHERE iv.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY iv.patient_id
    ORDER BY iv.fluidsID  DESC";

    $stmt = $con->prepare($IVfluidsQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $IVfluidsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $MedicationQuery = "SELECT md.*, b.*, COUNT(md.medicationID) AS md_count 
    FROM tbl_birthing_medication md
    JOIN tbl_birth_info b ON b.birth_info_id = md.birth_info_id
    WHERE md.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY md.patient_id
    ORDER BY md.medicationID   DESC";

    $stmt = $con->prepare($MedicationQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $MedicationData = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $DocNotesQuery = "SELECT h.*, u.*, p.*, b.*, COUNT(h.notedsID) AS h_count 
    FROM tbl_healthnotes h
    JOIN tbl_users u ON u.userID = h.userID
    JOIN tbl_personnel p ON p.personnel_id = u.personnel_id
    JOIN tbl_birth_info b ON b.birth_info_id = h.birth_info_id
    WHERE h.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done' AND h.doctorNotes != '' 
        AND (h.nureNotes IS NULL OR h.nureNotes = '')
    GROUP BY h.patient_id
    ORDER BY h.notedsID, h.date, h.time, h.doctorNotes asc";

    $stmt = $con->prepare($DocNotesQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $DocNotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $NurseNotesQuery = "SELECT h.*, u.*, p.*, b.*, COUNT(h.notedsID) AS h_count 
    FROM tbl_healthnotes h
    JOIN tbl_users u ON u.userID = h.userID
    JOIN tbl_personnel p ON p.personnel_id = u.personnel_id
    JOIN tbl_birth_info b ON b.birth_info_id = h.birth_info_id
    WHERE h.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
        AND h.nureNotes != '' 
        AND (h.doctorNotes IS NULL OR h.doctorNotes = '')
         GROUP BY h.patient_id
          ORDER BY  h.date, h.time, h.nureNotes";

    $stmt = $con->prepare($NurseNotesQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $NurseNotesData = $stmt->fetchAll(PDO::FETCH_ASSOC);




    $BirthMonQuery = "SELECT birth.*, b.*,COUNT(birth.birthMonitorID) AS birth_count 
    FROM tbl_birthing_monitoring birth
   
    JOIN tbl_birth_info b ON b.birth_info_id = birth.birth_info_id
    WHERE birth.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY birth.patient_id
    ORDER BY birth.birthMonitorID  DESC";

    $stmt = $con->prepare($BirthMonQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $BirthMonQueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Delivery Room Record
    $DeliveryQuery = "SELECT birth.*, b.*,COUNT(birth.roomID) AS delivery_count 
    FROM tbl_birthroom  birth
   
    JOIN tbl_birth_info b ON b.birth_info_id = birth.birth_info_id
    WHERE birth.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY birth.patient_id
    ORDER BY birth.roomID   DESC";

    $stmt = $con->prepare($DeliveryQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $DeliveryData = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $PostpartumQuery = "SELECT birth.*, b.*,COUNT(birth.postpartumID ) AS post_count 
    FROM tbl_postpartum  birth
   
    JOIN tbl_birth_info b ON b.birth_info_id = birth.birth_info_id
    WHERE birth.birth_info_id = :birthInfoID
    AND b.birthing_status = 'done'
    GROUP BY birth.patient_id
    ORDER BY birth.postpartumID    DESC";

    $stmt = $con->prepare($PostpartumQuery);
    $stmt->bindParam(':birthInfoID', $birthInfoID, PDO::PARAM_INT);
    $stmt->execute();
    $PostpartumData = $stmt->fetchAll(PDO::FETCH_ASSOC);






    // Debug output for vital signs data
    // echo "<pre>";
    // print_r($vitalSignsData);
    // echo "</pre>";
}

?>




<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Meta -->



<head>



    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
    <link rel="canonical" href="https://www.bootstrap.gallery/">

    <link rel="shortcut icon" href="../../assets/images/favicon.svg" />

    <!-- *************
			************ CSS Files *************
		************* -->
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="../../assets/fonts/icomoon/style.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="../../assets/css/main.min.css" />

    <!-- *************
			************ Vendor Css Files *************
		************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

    <!-- Date Range CSS -->


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

        .app-body {
            padding: 2rem 2rem;
            height: 100vh;
            overflow: auto;
            margin: 0 0 10px 0;
        }
        .main-container {
            padding: 0 0 0 0;
            -webkit-transition: padding-left .1s ease;
            transition: padding-left .1s ease;

        }

        .app-footer {
            font-size: .7rem;

        }

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

        .patient-photo {
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-image {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-right: 20px;
            border: 2px solid #ff0000;
        }
    </style>
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">



            <!-- Sidebar menu starts -->

            <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->

                <!-- App header ends -->

                <!-- App body starts -->
                <div class="app-body">

                    <button onclick="window.history.back()" class="btn btn-primary"><i class="icon-chevron-left"></i>Back</button>
                    <!-- Container starts -->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">

                                        <!-- Row start -->
                                        <div class="bg-white px-4 p-2 rounded-3">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img src="Patients-PNG-HD.png" class=" rounded-circle p-1 border " alt="Patient Photo" style="width: 200px;height:200px;">
                                                    
                                                </div>
                                                <div class="col text-black">
                                                    <h2><strong><?php echo htmlspecialchars(ucwords(strtolower($patientData['name']))); ?></strong></h2>
                                                    <p class="mb-1"><strong>Age:</strong> <?php echo htmlspecialchars($patientData['age']); ?> Years</p>
                                                <p class="mb-1"><strong>Sex:</strong> <?php echo htmlspecialchars($patientData['gender']); ?></p>
                                                <p class="mb-1"><strong>BirthDate:</strong> <?php echo htmlspecialchars(!empty($patientData['date_of_birth']) ? date('F j, Y', strtotime($patientData['date_of_birth'])) : '')  ?></p>
                                                <p class="mb-1"><strong>Contact Number:</strong> <?php echo htmlspecialchars($patientData['phone_number']); ?></p>
                                                <p class="mb-1"><strong>Status:</strong> <?php echo htmlspecialchars(ucwords($patientData['civil_status'])); ?></p>
                                                <p class="mb-1"><strong>Blood Type:</strong> <?php echo htmlspecialchars(ucwords($patientData['blood_type'])); ?></p>
                                                <p class="mb-1"><strong>Address:</strong> <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', ' . $patientData['province']); ?></p>
                                                  <a href="print-clinical_records.php?id=<?php echo htmlspecialchars($patientData['patientID']); ?>" class="btn btn-secondary"><i class="fs-4 icon-download"></i> Clinical Record</a>
                                                </div>
                                            </div>
                                            <!-- Row end -->
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>



                        <div class="row">

                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Monitor Patient During Birth Record</h5>
                                    </div>

                                    <?php if (!empty($BirthMonQueryData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($BirthMonQueryData as $birhtMonDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($birhtMonDatas['admission_date']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($birhtMonDatas['admission_time']))); ?>

                                                        <!-- View Icon Button -->
                                                        <a href="form_monitor.php?id=<?php echo htmlspecialchars($birhtMonDatas['birthMonitorID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>

                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Delivery Room Record</h5>
                                    </div>
                                    <?php if (!empty($DeliveryData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($DeliveryData as $DeliveryDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($DeliveryDatas['dateAdmitted']))); ?>
                                                      
                                                       

                                                        <!-- View Icon Button -->
                                                        <a href="form_delivery.php?id=<?php echo htmlspecialchars($DeliveryDatas['roomID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Postpartum Record</h5>
                                    </div>
                                    <?php if (!empty($PostpartumData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($PostpartumData as $PostpartumDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($PostpartumDatas['date_postpartum']))); ?>
                                                      

                                                        <!-- View Icon Button -->
                                                        <a href="form_postpartum.php?id=<?php echo htmlspecialchars($PostpartumDatas['postpartumID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Vital Signs</h5>
                                    </div>

                                    <?php if (!empty($vitalSignsData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($vitalSignsData as $vitalSignsDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($vitalSignsDatas['date_shift']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($vitalSignsDatas['time']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($vitalSignsDatas['vital_count']); ?> Vital Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_vitalsigns.php?id=<?php echo htmlspecialchars($vitalSignsDatas['vitalSignsID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Vital Signs Graphing Sheet</h5>
                                    </div>

                                    <?php if (!empty($vitalSignsData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($vitalSignsData as $vitalSignsDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($vitalSignsDatas['date_shift']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($vitalSignsDatas['time']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($vitalSignsDatas['vital_count']); ?> Vital Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_vitalsgraph.php?id=<?php echo htmlspecialchars($vitalSignsDatas['vitalSignsID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>

                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Medication</h5>
                                    </div>
                                    <?php if (!empty($MedicationData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($MedicationData as $Medications) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($Medications['date_signature']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($Medications['time']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($Medications['md_count']); ?> Medication Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_medication.php?id=<?php echo htmlspecialchars($Medications['medicationID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">IV FLUID</h5>
                                    </div>

                                    <?php if (!empty($IVfluidsData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($IVfluidsData as $IVfluidData) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($IVfluidData['date']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($IVfluidData['timeStarted']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($IVfluidData['iv_count']); ?> IV Fluids Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_ivfluids.php?id=<?php echo htmlspecialchars($IVfluidData['fluidsID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Doctor's Order</h5>
                                    </div>


                                    <?php if (!empty($DocNotesData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($DocNotesData as $DocNotesDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($DocNotesDatas['date']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($DocNotesDatas['time']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($DocNotesDatas['h_count']); ?> Doctor Notes Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_doctorNotes.php?id=<?php echo htmlspecialchars($DocNotesDatas['notedsID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>
                            <div class="col-sm-4 col-12">
                                <!-- Card start -->
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <h5 class="card-title">Nurse's Notes</h5>
                                    </div>


                                    <?php if (!empty($NurseNotesData)) { ?>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <?php foreach ($NurseNotesData as $NurseNotesDatas) { ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <!-- Display date and time -->
                                                        <?php echo htmlspecialchars(date('M, d, Y', strtotime($NurseNotesDatas['date']))); ?> -
                                                        <?php echo htmlspecialchars(date('h:i A', strtotime($NurseNotesDatas['time']))); ?>

                                                        <!-- Display number of vital records -->
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($NurseNotesDatas['h_count']); ?> Nurse's Notes Records
                                                        </span>

                                                        <!-- View Icon Button -->
                                                        <a href="form_nurseNotes.php?id=<?php echo htmlspecialchars($NurseNotesDatas['notedsID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <!-- Optionally add a footer or leave empty -->
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-center mt-2" style="color:red;">No available data found</p>
                                    <?php } ?>
                                </div>
                                <!-- Card end -->
                            </div>



                        </div>
                        




                    </div>
                    <!-- Container ends -->

                   

                </div>
                <!-- App body ends -->

                <!-- App footer start -->
                <?php include '../../config/footer.php'; ?>
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






    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Overlay Scroll JS -->
    <script src="../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>



    <!-- Custom JS files -->
    <script src="../../assets/js/custom.js"></script>




</body>






</html>