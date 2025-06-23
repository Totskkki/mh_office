<?php
include './config/connection.php';

include './common_service/common_functions.php';


ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');




if (isset($_POST['dsID'])) {
    $id = $_POST['dsID'];

    // Query to fetch the doctor's schedule
    $query = "SELECT s.*, s.schedules, s.doc_scheduleID,
                     CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
              FROM tbl_doctor_schedule AS s
              LEFT JOIN tbl_users AS user ON user.userID = s.userID
              LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
              WHERE s.doc_scheduleID = :id order by s.doc_scheduleID asc";

    $stmt = $con->prepare($query);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    echo json_encode($result);
    exit;
}

//   this work
if (isset($_POST['add_schedule'])) {

    $doctor = $_POST['doctor'];
    $days = $_POST['day']; // Array of selected days
    $fromtimeArray = $_POST['fromtime'];
    $totimeArray = $_POST['totime'];
    $worklengthArray = $_POST['worklength'];
    $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';
    $isAvailable = 1;



    $schedulesArray = [];

    foreach ($days as $day) {

        $schedulesArray[$day] = [];


        foreach ($_POST['fromtime'] as $index => $fromtimeArray) {
            if (isset($fromtimeArray[$day]) && isset($_POST['totime'][$index][$day])) {
                $fromtime = $fromtimeArray[$day];
                $totime = $_POST['totime'][$index][$day];
                $worklength = $_POST['worklength'][$index][$day] ?? null; // Optional

                if ($fromtime && $totime) {
                    $schedulesArray[$day][] = [
                        'fromtime' => $fromtime,
                        'totime' => $totime,
                        'worklength' => $worklength,
                    ];
                }
            }
        }
    }
    // Convert schedules array to JSON format for database storage
    $schedulesJson = json_encode($schedulesArray);

    // Prepare and execute database insert query
    $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available, reapet) 
                            VALUES (:userID, :schedules, :is_available, :repeat)");

    $stmt->bindParam(':userID', $doctor);
    $stmt->bindParam(':schedules', $schedulesJson);
    $stmt->bindParam(':is_available', $isAvailable);
    $stmt->bindParam(':repeat', $repeat);




    try {
        $stmt->execute();



        $scheduleId = $con->lastInsertId();


        $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);


        $userId = $_SESSION['admin_id'];
        $action = "Add Schedule";
        $description = "Added a schedule for Doctor  $affectedRecordName";

        logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);


        $_SESSION['status'] = "Schedule added successfully for selected days!";
        $_SESSION['status_code'] = "success";
        header('location: Doctor_schedule.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
        header('location:Doctor_schedule.php');
        exit();
    }
}


/////////////////////can edit single timeslot but cannot add more timeslot///////////////////////////////////////////

// if (isset($_POST['update_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $scheduleId = $_POST['doc_scheduleID'];
//     $days = $_POST['day'] ?? [];
//     $repeat = $_POST['repeat'] ?? '';
//     $fromtimeArray = $_POST['fromtime'] ?? [];
//     $totimeArray = $_POST['totime'] ?? [];
//     $worklengthArray = $_POST['worklength'] ?? [];

//     // Retrieve existing schedule
//     $stmt = $con->prepare("SELECT schedules FROM tbl_doctor_schedule WHERE doc_scheduleID = :doc_scheduleID");
//     $stmt->bindParam(':doc_scheduleID', $scheduleId);
//     $stmt->execute();
//     $existingSchedule = $stmt->fetchColumn();

//     // Initialize the schedules array
//     $schedulesArray = $existingSchedule ? json_decode($existingSchedule, true) : [];

//     // Log before changes
//     error_log("Before update: " . print_r($schedulesArray, true));

//     // Log input arrays for debugging
//     error_log("fromtimeArray: " . print_r($fromtimeArray, true));
//     error_log("totimeArray: " . print_r($totimeArray, true));
//     error_log("worklengthArray: " . print_r($worklengthArray, true));

//     // Initialize the flag for changes made
//     $changesMade = false;

//     foreach ($days as $day) {
//         $updatedDaySchedule = [];

//         // Check if the current day exists in the input arrays
//         if (isset($fromtimeArray) && is_array($fromtimeArray) && count($fromtimeArray) > 0) {
//             foreach ($fromtimeArray as $index => $fromtimeValue) {
//                 // Ensure we are within bounds of the other arrays
//                 $totimeValue = $totimeArray[$index] ?? null; // Gets corresponding totime or null if not set
//                 $worklengthValue = $worklengthArray[$index] ?? '0m'; // Default to '0m' if not set

//                 // Log the values being processed
//                 error_log("Processing Day: $day, Index: $index");
//                 error_log("fromtime: $fromtimeValue, totime: $totimeValue, worklength: $worklengthValue");

//                 // Only update if both fromtime and totime are set
//                 if (!empty($fromtimeValue) && !empty($totimeValue)) {
//                     // Create the updated schedule array
//                     $updatedDaySchedule[] = [
//                         'fromtime' => $fromtimeValue,
//                         'totime' => $totimeValue,
//                         'worklength' => $worklengthValue,
//                     ];
//                     $changesMade = true; // Flag changes
//                 }
//             }
//         }

//         // Log updated schedule for the current day
//         error_log("Updated Day Schedule for $day: " . print_r($updatedDaySchedule, true));

//         if ($changesMade) {
//             // If we have changes, update the schedule for the day
//             $schedulesArray[$day] = $updatedDaySchedule;
//         }
//     }

//     // Log the final schedulesArray after processing all days
//     error_log("After loop, schedulesArray: " . print_r($schedulesArray, true));


//     // Convert the updated array to JSON
//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the update statement
//     $stmt = $con->prepare("UPDATE tbl_doctor_schedule 
//                            SET userID = :userID, schedules = :schedules, reapet = :repeat 
//                            WHERE doc_scheduleID = :doc_scheduleID");
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':repeat', $repeat);
//     $stmt->bindParam(':doc_scheduleID', $scheduleId);

//     try {
//         if ($stmt->execute()) {
//             $_SESSION['status'] = "Schedule updated successfully!";
//             $_SESSION['status_code'] = "success";
//         } else {
//             $_SESSION['status'] = "Failed to update schedule!";
//             $_SESSION['status_code'] = "error";
//         }
//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }

//     header('location: Doctor_schedule.php');
//     exit();
// }
/////////////////////can edit single timeslot but cannot add more timeslot///////////////////////////////////////////

// if (isset($_POST['update_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $scheduleId = $_POST['doc_scheduleID'];
//     $days = $_POST['day'] ?? [];
//     $repeat = $_POST['repeat'] ?? '';
//     $fromtimeArray = $_POST['fromtime'] ?? [];
//     $totimeArray = $_POST['totime'] ?? [];
//     $worklengthArray = $_POST['worklength'] ?? [];

//     // Retrieve existing schedule
//     $stmt = $con->prepare("SELECT schedules FROM tbl_doctor_schedule WHERE doc_scheduleID = :doc_scheduleID");
//     $stmt->bindParam(':doc_scheduleID', $scheduleId);
//     $stmt->execute();
//     $existingSchedule = $stmt->fetchColumn();

//     // Initialize the schedules array
//     $schedulesArray = $existingSchedule ? json_decode($existingSchedule, true) : [];

//     // Log before changes
//     error_log("Before update: " . print_r($schedulesArray, true));

//     // Initialize the flag for changes made
//     $changesMade = false;

//     // Initialize an array to hold time slots
//     $timeSlotData = [];

//     foreach ($days as $day) {
//         // Initialize time slots for the current day
//         $timeSlotData[$day] = [];

//         // Process each fromtime entry
//         foreach ($fromtimeArray as $index => $fromtimeValue) {
//             $totimeValue = $totimeArray[$index] ?? null; // Gets corresponding totime or null if not set
//             $worklengthValue = $worklengthArray[$index] ?? '0m'; // Default to '0m' if not set

//             // Only update if both fromtime and totime are set
//             if (!empty($fromtimeValue) && !empty($totimeValue)) {
//                 // Create the updated schedule array for this time slot
//                 $timeSlotData[$day][] = [
//                     'fromtime' => $fromtimeValue,
//                     'totime' => $totimeValue,
//                     'worklength' => $worklengthValue,
//                 ];
//                 $changesMade = true; // Flag changes
//             }
//         }
//     }

//     // Update schedulesArray with the new time slot data
//     foreach ($timeSlotData as $day => $slots) {
//         if ($changesMade && !empty($slots)) {
//             $schedulesArray[$day] = $slots; // Update the schedule for the day
//         }
//     }

//     // Log the final schedulesArray after processing all days
//     error_log("After loop, schedulesArray: " . print_r($schedulesArray, true));

//     // Convert the updated array to JSON
//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the update statement
//     $stmt = $con->prepare("UPDATE tbl_doctor_schedule 
//                            SET userID = :userID, schedules = :schedules, reapet = :repeat 
//                            WHERE doc_scheduleID = :doc_scheduleID");
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':repeat', $repeat);
//     $stmt->bindParam(':doc_scheduleID', $scheduleId);

//     try {
//         if ($stmt->execute()) {
//             $_SESSION['status'] = "Schedule updated successfully!";
//             $_SESSION['status_code'] = "success";
//         } else {
//             $_SESSION['status'] = "Failed to update schedule!";
//             $_SESSION['status_code'] = "error";
//         }
//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }

//     header('location: Doctor_schedule.php');
//     exit();
// }



if (isset($_POST['update_schedule'])) {


    $doctor = $_POST['doctor'];
    $scheduleId = $_POST['doc_scheduleID'];
    $days = isset($_POST['day']) ? $_POST['day'] : [];
    $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';
    $fromtimeArray = $_POST['fromtime'];
    $totimeArray = $_POST['totime'];
    $worklengthArray = $_POST['worklength'];


    $stmt = $con->prepare("SELECT schedules FROM tbl_doctor_schedule WHERE doc_scheduleID = :doc_scheduleID");
    $stmt->bindParam(':doc_scheduleID', $scheduleId);
    $stmt->execute();
    $existingSchedule = $stmt->fetchColumn();


    $schedulesArray = $existingSchedule ? json_decode($existingSchedule, true) : [];

    $changesMade = false;


    foreach ($days as $day) {

        $updatedDaySchedule = [];


        foreach ($fromtimeArray as $index => $fromtime) {
            if (isset($fromtime[$day]) && isset($totimeArray[$index][$day])) {
                $fromtimeValue = $fromtime[$day];
                $totimeValue = $totimeArray[$index][$day];
                $worklengthValue = isset($worklengthArray[$index][$day]) ? $worklengthArray[$index][$day] : null;


                if (!empty($fromtimeValue) && !empty($totimeValue) && !empty($worklengthValue)) {
                    $updatedDaySchedule[] = [
                        'fromtime' => $fromtimeValue,
                        'totime' => $totimeValue,
                        'worklength' => (string)$worklengthValue,
                    ];
                }
            }
        }

        if (!empty($updatedDaySchedule)) {

            $schedulesArray[$day] = $updatedDaySchedule;
            $changesMade = true;
        } elseif (isset($schedulesArray[$day])) {

            $schedulesArray[$day] = $schedulesArray[$day];
        }
    }


    if ($changesMade) {
        $schedulesJson = json_encode($schedulesArray);


        $stmt = $con->prepare("UPDATE tbl_doctor_schedule 
                               SET userID = :userID, schedules = :schedules, reapet = :repeat 
                               WHERE doc_scheduleID = :doc_scheduleID");
        $stmt->bindParam(':userID', $doctor);
        $stmt->bindParam(':schedules', $schedulesJson);
        $stmt->bindParam(':repeat', $repeat);
        $stmt->bindParam(':doc_scheduleID', $scheduleId);


        try {
            if ($stmt->execute()) {


                $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);


                $userId = $_SESSION['admin_id'];
                $action = "Update Schedule";
                $description = "Updated the schedule for Doctor $affectedRecordName";
                logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);

                $_SESSION['status'] = "Schedule updated successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Failed to update schedule!";
                $_SESSION['status_code'] = "error";
            }
        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['status'] = "No changes made to the schedule.";
        $_SESSION['status_code'] = "info";
    }

    header('location: Doctor_schedule.php');
    exit();
}








$doctors = getDoctorSchedule($con);

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
    <link href='../assets/fullcalendar/main.min.css' rel='stylesheet' />






</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand px-3 py-2 d-flex align-items-center">
                    <!-- <a href="index.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a> -->
                </div>
                <!-- App brand ends -->

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
                    <div class="row">
                        <div class="col-12 col-xl-12">
                            <!-- Breadcrumb start -->
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item">
                                    <a href="dashboard.php">Home</a>

                                </li>
                                <li class=" breadcrumb-active">

                                </li>
                            </ol>
                            <!-- Breadcrumb end -->
                            <h2 class="mb-2"></h2>
                            <h6 class="mb-4 fw-light">
                                Doctor Schedules

                            </h6>
                        </div>
                    </div>

                    <!-- Container starts -->
                    <div class="card mb-4">
                        <div class="card-header d-flex ">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add_schedule">
                                <i class="icon-file-plus"></i> Add Schedule
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Schedule Settings Column -->
                                <div class="col-md-6 mb-3">
                                    <div class="card p-3">
                                        <div class="table-responsive mt-4">
                                            <table id="user_list" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Doctor Name</th>
                                                        <th>Work Days</th>
                                                        <th>Date Override</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT ds.*, user.*, personnel.*, position.*, ds.is_available 
                                                        FROM tbl_doctor_schedule as ds 
                                                        LEFT JOIN tbl_users as user ON ds.userID = user.userID  
                                                        LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                                                        LEFT JOIN tbl_position AS position ON user.position_id = position.position_id 
                                                        ORDER BY ds.doc_scheduleID DESC";

                                                    $stmt = $con->prepare($query);
                                                    $stmt->execute();

                                                    $serial = 0;
                                                    $schedulesGrouped = [];

                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $doc_scheduleID = $row['doc_scheduleID'];
                                                        $serial++;

                                                        if (!isset($schedulesGrouped[$doc_scheduleID])) {
                                                            $schedulesGrouped[$doc_scheduleID] = [
                                                                'doctor_name' => htmlspecialchars($row['first_name'] . ' ' . ucwords($row['middlename']) . ' ' . ucwords($row['lastname'])),
                                                                'schedules' => [],
                                                                'is_available' => $row['is_available'],
                                                                'date_schedule' => $row['date_schedule'],
                                                                'leave_start_date' => $row['leave_start_date'],
                                                                'leave_end_date' => $row['leave_end_date'],
                                                            ];
                                                        }

                                                        if (!empty($row['schedules'])) {
                                                            $decodedschedules = json_decode($row['schedules'], true);

                                                            if (is_array($decodedschedules)) {
                                                                foreach ($decodedschedules as $day => $slots) {
                                                                    foreach ($slots as $slot) {
                                                                        $schedulesGrouped[$doc_scheduleID]['schedules'][] = [
                                                                            'day' => ucfirst($day),
                                                                            'fromtime' => htmlspecialchars($slot['fromtime']),
                                                                            'totime' => htmlspecialchars($slot['totime']),
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }

                                                    foreach ($schedulesGrouped as $doc_scheduleID => $scheduleData) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $serial; ?></td>
                                                            <td><?php echo $scheduleData['doctor_name']; ?></td>
                                                            <td>
                                                                <?php
                                                                if (!empty($scheduleData['schedules'])) {
                                                                    foreach ($scheduleData['schedules'] as $index => $schedule) {
                                                                        $fromtime = DateTime::createFromFormat('H:i', $schedule['fromtime']);
                                                                        $totime = DateTime::createFromFormat('H:i', $schedule['totime']);
                                                                        echo $schedule['day'] . ' (' . ($fromtime ? $fromtime->format('g:i A') : '') . ' - ' . ($totime ? $totime->format('g:i A') : '') . ')';
                                                                        if ($index < count($scheduleData['schedules']) - 1) echo ', ';
                                                                    }
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>
                                                            </td>
                                                        <td>
                                                        <?php
                                                        // Check if the date_schedule is valid and not '0000-00-00'
                                                        if ($scheduleData['date_schedule'] && $scheduleData['date_schedule'] !== '0000-00-00') {
                                                            // Convert date_schedule to "Nov 3, 2024" format
                                                            try {
                                                                $dateSchedule = new DateTime($scheduleData['date_schedule']);
                                                                echo $dateSchedule->format('M j, Y');
                                                            } catch (Exception $e) {
                                                                echo 'Invalid date';  // Fallback message if the date is invalid
                                                            }
                                                        } else {
                                                            echo '';  // Fallback message for invalid date
                                                        }
                                                    
                                                        // Check for leave dates and format them as well
                                                        if (($scheduleData['leave_start_date'] && $scheduleData['leave_start_date'] !== '0000-00-00') && 
                                                            ($scheduleData['leave_end_date'] && $scheduleData['leave_end_date'] !== '0000-00-00')) :
                                                            try {
                                                                $leaveStart = new DateTime($scheduleData['leave_start_date']);
                                                                $leaveEnd = new DateTime($scheduleData['leave_end_date']);
                                                                echo ' - ' . htmlspecialchars($leaveStart->format('M j, Y')) . ' to ' . htmlspecialchars($leaveEnd->format('M j, Y'));
                                                            } catch (Exception $e) {
                                                                echo 'Invalid leave dates';  // Fallback message if leave dates are invalid
                                                            }
                                                        endif;
                                                        ?>
                                                    </td>



                                                            <td>
                                                                <?php
                                                                // Display the status based on `is_available` value
                                                                switch ($scheduleData['is_available']) {
                                                                    case 0:
                                                                        echo '<span class="badge bg-secondary">Not Available</span>';
                                                                        break;
                                                                    case 1:
                                                                        echo '<span class="badge bg-success">Available</span>';
                                                                        break;
                                                                    case 2:
                                                                        echo '<span class="badge bg-warning">Pending</span>';
                                                                        break;
                                                                    case 3:
                                                                        echo '<span class="badge bg-success">Approved</span>';
                                                                        break;
                                                                    case 4:
                                                                        echo '<span class="badge bg-danger">Rejected</span>';
                                                                        break;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($scheduleData['is_available'] == 1) : ?>
                                                                    <!-- Show Edit and Delete actions for Approved status -->
                                                                    <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $doc_scheduleID; ?>" data-bs-toggle="tooltip" title="Edit">
                                                                        <i class="icon-edit"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm delete" data-id="<?php echo $doc_scheduleID; ?>" data-bs-toggle="tooltip" title="Delete">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                <?php elseif ($scheduleData['is_available'] == 2) : ?>
                                                                    <!-- Only show Approve and Reject actions for Pending status -->
                                                                    <button class="btn btn-outline-info btn-sm approve" data-id="<?php echo $doc_scheduleID; ?>" data-bs-toggle="tooltip" title="Approve">
                                                                        <i class="icon-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm reject" data-id="<?php echo $doc_scheduleID; ?>" data-bs-toggle="tooltip" title="Reject">
                                                                        <i class="icon-close">x</i>
                                                                    </button>
                                                                <?php elseif ($scheduleData['is_available'] == 3) : ?>
                                                                    <!-- Only show Approve and Reject actions for Pending status -->
                                                                <?php elseif ($scheduleData['is_available'] == 4) : ?>
                                                                    <!-- Only show Approve and Reject actions for Pending status -->

                                                                <?php endif; ?>

                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>



                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="card p-3">
                                        <h5>Doctor's Calendar Schedule</h5>
                                        <h6 class="mb-4 fw-light">
                                            <!-- Add dates to override doctor's schedule from regular weekly hours. -->
                                        </h6>
                                        <!-- <div class="col-lg-4">
                                            <button class="btn btn-outline-info w-100 mb-3">Add a date override</button>
                                        </div> -->


                                        <?php

                                        $doctorColors = [];
                                        $colorList = ['#ff5733', '#44694a', '#3357ff', '#f39c12', '#8e44ad', '#2980b9', '#d35400', '#c0392b'];

                                        $query = "SELECT DISTINCT CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
                                            FROM tbl_doctor_schedule AS s
                                            LEFT JOIN tbl_users AS user ON user.userID = s.userID
                                            LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id";

                                        $stmt = $con->prepare($query);
                                        $stmt->execute();
                                        $doctorNames = $stmt->fetchAll(PDO::FETCH_COLUMN);


                                        foreach ($doctorNames as $index => $doctorName) {

                                            $color = $colorList[$index % count($colorList)];
                                            $doctorColors[$doctorName] = $color;
                                        }
                                        $query = "SELECT s.*, position.*, personnel.*, 
                                        CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
                                      FROM tbl_doctor_schedule AS s
                                      LEFT JOIN tbl_users AS user ON user.userID = s.userID
                                      LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                                      LEFT JOIN tbl_position AS position ON user.position_id = position.position_id";

                                        $stmt = $con->prepare($query);
                                        $stmt->execute();
                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                       $calendarEvents = [];

                                            foreach ($results as $event) {
                                                $schedulesArray = json_decode($event['schedules'], true);
                                                $doctorName = htmlspecialchars($event['doctorsname']);
                                                $color = $doctorColors[$doctorName] ?? '#0073e6';
                                            
                                                // Validate the 'date_schedule' and 'leave_start_date' and 'leave_end_date' for '0000-00-00' and empty dates
                                                $isValidDateSchedule = $event['date_schedule'] !== '0000-00-00' && !empty($event['date_schedule']);
                                                $isValidLeaveDates = !empty($event['leave_start_date']) && !empty($event['leave_end_date']) &&
                                                                     $event['leave_start_date'] !== '0000-00-00' && $event['leave_end_date'] !== '0000-00-00';
                                            
                                                // Check for "No Duty" status based on date_schedule
                                                if ($event['is_available'] == 3 && $isValidDateSchedule) {
                                                    $noDutyDate = new DateTime($event['date_schedule']);
                                                    $calendarEvents[] = [
                                                        'title' => 'On Leave: ' . $doctorName,
                                                        'start' => $noDutyDate->format('Y-m-d') . 'T00:00:00',
                                                        'end'   => $noDutyDate->format('Y-m-d') . 'T23:59:59',
                                                        'color' => '#FF0000',
                                                        'status' => 'On Leave',
                                                    ];
                                                }
                                                // Check for "On Leave" status
                                                elseif ($event['is_available'] == 3 && $isValidLeaveDates) {
                                                    $leaveStartDate = new DateTime($event['leave_start_date']);
                                                    $leaveEndDate = new DateTime($event['leave_end_date']);
                                            
                                                    // Add "On Leave" event to the calendar
                                                    $calendarEvents[] = [
                                                        'title' => 'On Leave: ' . $doctorName,
                                                        'start' => $leaveStartDate->format('Y-m-d') . 'T00:00:00',
                                                        'end'   => $leaveEndDate->format('Y-m-d') . 'T23:59:59',
                                                        'color' => '#FF0000',
                                                        'status' => 'On Leave',
                                                    ];
                                                } else {
                                                    // Handle doctor's available schedule
                                                    $statusText = $event['is_available'] == 1 ? 'Available' : 'Not Available';
                                            
                                                    foreach ($schedulesArray as $day => $slots) {
                                                        $dayNumber = date('N', strtotime($day));
                                            
                                                        foreach ($slots as $slot) {
                                                            $startTime = htmlspecialchars($slot['fromtime']);
                                                            $endTime = htmlspecialchars($slot['totime']);
                                                            $baseDate = new DateTime();
                                                            $baseDate->setTime(0, 0, 0);
                                            
                                                            $eventDate = clone $baseDate;
                                                            $eventDate->modify("next $day");
                                            
                                                            $repeatType = $event['reapet'];  // Typo should be 'repeat'
                                                            if ($repeatType === 'Weekly') {
                                                                for ($i = 0; $i < 4; $i++) {
                                                                    $weeklyEventDate = clone $eventDate;
                                                                    $weeklyEventDate->modify("+$i week");
                                            
                                                                    // Skip events that fall during the leave period or no duty date
                                                                    if ($isValidLeaveDates && $weeklyEventDate >= $leaveStartDate && $weeklyEventDate <= $leaveEndDate) {
                                                                        continue;
                                                                    }
                                            
                                                                    // Skip if the event matches a "No Duty" date
                                                                    if ($isValidDateSchedule && $weeklyEventDate->format('Y-m-d') == $noDutyDate->format('Y-m-d')) {
                                                                        continue;
                                                                    }
                                            
                                                                    $calendarEvents[] = [
                                                                        'title' => 'Dr.: ' . $doctorName,
                                                                        'start' => $weeklyEventDate->format('Y-m-d') . 'T' . $startTime,
                                                                        'end'   => $weeklyEventDate->format('Y-m-d') . 'T' . $endTime,
                                                                        'color' => $color,
                                                                        'status' => $statusText,
                                                                    ];
                                                                }
                                                            } elseif ($repeatType === 'Monthly') {
                                                                for ($i = 0; $i < 4; $i++) {
                                                                    $monthlyEventDate = clone $baseDate;
                                                                    $monthlyEventDate->modify("first day of next month");
                                                                    $monthlyEventDate->modify("+$i month");
                                                                    $monthlyEventDate->modify("next $day");
                                            
                                                                    // Skip events that fall during the leave period or no duty date
                                                                    if ($isValidLeaveDates && $monthlyEventDate >= $leaveStartDate && $monthlyEventDate <= $leaveEndDate) {
                                                                        continue;
                                                                    }
                                            
                                                                    // Skip if the event matches a "No Duty" date
                                                                    if ($isValidDateSchedule && $monthlyEventDate->format('Y-m-d') == $noDutyDate->format('Y-m-d')) {
                                                                        continue;
                                                                    }
                                            
                                                                    $calendarEvents[] = [
                                                                        'title' => 'Dr.: ' . $doctorName,
                                                                        'start' => $monthlyEventDate->format('Y-m-d') . 'T' . $startTime,
                                                                        'end'   => $monthlyEventDate->format('Y-m-d') . 'T' . $endTime,
                                                                        'color' => $color,
                                                                        'status' => $statusText,
                                                                    ];
                                                                }
                                                            } elseif ($repeatType === 'Yearly') {
                                                                for ($i = 0; $i < 4; $i++) {
                                                                    $yearlyEventDate = clone $baseDate;
                                                                    $yearlyEventDate->modify("first day of January");
                                                                    $yearlyEventDate->modify("+$i year");
                                                                    $yearlyEventDate->modify("next $day");
                                            
                                                                    // Skip events that fall during the leave period or no duty date
                                                                    if ($isValidLeaveDates && $yearlyEventDate >= $leaveStartDate && $yearlyEventDate <= $leaveEndDate) {
                                                                        continue;
                                                                    }
                                            
                                                                    // Skip if the event matches a "No Duty" date
                                                                    if ($isValidDateSchedule && $yearlyEventDate->format('Y-m-d') == $noDutyDate->format('Y-m-d')) {
                                                                        continue;
                                                                    }
                                            
                                                                    $calendarEvents[] = [
                                                                        'title' => 'Dr.: ' . $doctorName,
                                                                        'start' => $yearlyEventDate->format('Y-m-d') . 'T' . $startTime,
                                                                        'end'   => $yearlyEventDate->format('Y-m-d') . 'T' . $endTime,
                                                                        'color' => $color,
                                                                        'status' => $statusText,
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            
                                            $calendarEventsJson = json_encode($calendarEvents);


                                        ?>





                                        <!-- Calendar Container -->
                                        <div id="calendar"></div>
                                    </div>
                                </div>
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


    <?php include './modal/doctor_schedule-modal.php'; ?>
    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>
    <script src='../assets/fullcalendar/main.min.js'></script>




    <script>
        function toggleAllDays(checkbox) {
            // Get all day checkboxes
            const dayCheckboxes = document.querySelectorAll('.day-checkbox');
            dayCheckboxes.forEach(function(dayCheckbox) {
                dayCheckbox.checked = checkbox.checked; // Set the checked state
                toggleAvailability(dayCheckbox); // Call the toggle availability function
            });
        }

        function toggleAvailability(checkbox) {
            const timeRowsContainer = checkbox.closest('.list-group-item').querySelector('.time-rows');
            const dayErrorMessage = document.getElementById('dayErrorMessage');
            const anyChecked = Array.from(document.querySelectorAll('.day-checkbox')).some(checkbox => checkbox.checked);
            dayErrorMessage.style.display = anyChecked ? 'none' : 'block';

            if (checkbox.checked) {
                // If the checkbox is checked, add the first row if there are no existing rows
                if (timeRowsContainer.childElementCount === 0) {
                    addRow(timeRowsContainer, checkbox.value); // Add a row with the day's value
                }
            } else {
                // Clear the time rows for unchecked checkbox
                timeRowsContainer.innerHTML = ''; // Remove all rows
            }
        }

        let dayRowCounts = {}; // To keep track of row counts for each day

        function addRow(container, day = null) {
            if (!day) return; // Only add rows if we have a day context

            // Initialize the count for this day if it doesn't already exist
            if (!dayRowCounts[day]) {
                dayRowCounts[day] = 0;
            }

            const index = dayRowCounts[day]++;

            const newRow = document.createElement('div');
            newRow.classList.add('d-flex', 'align-items-center', 'time-row', 'mt-2');

            newRow.innerHTML = `
            <input type="hidden" name="day[]" value="${day}"> <!-- keep track of the day -->
            <input type="text" name="worklength[${index}][${day}]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
            <input type="time" name="fromtime[${index}][${day}]" class="form-control me-2 time-input from-time" style="width: 120px;" placeholder="From" onchange="calculateWorkHours(this)">
            <input type="time" name="totime[${index}][${day}]" class="form-control me-2 time-input to-time" style="width: 120px;" placeholder="To" onchange="calculateWorkHours(this)">
            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this.closest('.time-rows'), '${day}')">+</button>
            <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeRow(this)">x</button>
        `;

            container.appendChild(newRow);
        }

        function removeRow(button) {
            const row = button.closest('.time-row');
            row.remove();
        }

        function calculateWorkHours(input) {
            const row = input.closest('.time-row');
            const fromTime = row.querySelector('.from-time').value;
            const toTime = row.querySelector('.to-time').value;
            const workLengthInput = row.querySelector('.worklength-input');

            if (fromTime && toTime) {
                const [fromHours, fromMinutes] = fromTime.split(':').map(Number);
                const [toHours, toMinutes] = toTime.split(':').map(Number);

                const fromTotalMinutes = fromHours * 60 + fromMinutes;
                const toTotalMinutes = toHours * 60 + toMinutes;

                if (fromTotalMinutes >= toTotalMinutes) {
                    alert("Start time must be before end time.");
                    row.querySelector('.from-time').value = '';
                    row.querySelector('.to-time').value = '';
                    workLengthInput.value = '';
                    return;
                }

                const timeRows = row.parentNode.querySelectorAll('.time-row');
                for (let otherRow of timeRows) {
                    if (otherRow !== row) {
                        const otherFromTime = otherRow.querySelector('.from-time').value;
                        const otherToTime = otherRow.querySelector('.to-time').value;

                        if (otherFromTime && otherToTime) {
                            const [otherFromHours, otherFromMinutes] = otherFromTime.split(':').map(Number);
                            const [otherToHours, otherToMinutes] = otherToTime.split(':').map(Number);

                            const otherFromTotalMinutes = otherFromHours * 60 + otherFromMinutes;
                            const otherToTotalMinutes = otherToHours * 60 + otherToMinutes;

                            // Check if times overlap
                            if (
                                (fromTotalMinutes < otherToTotalMinutes && toTotalMinutes > otherFromTotalMinutes) ||
                                (otherFromTotalMinutes < toTotalMinutes && otherToTotalMinutes > fromTotalMinutes)
                            ) {
                                alert("This time overlaps with an existing time slot. Please select a different time.");
                                row.querySelector('.from-time').value = '';
                                row.querySelector('.to-time').value = '';
                                workLengthInput.value = '';
                                return;
                            }
                        }
                    }
                }


                const diffMinutes = toTotalMinutes - fromTotalMinutes;
                const hours = Math.floor(diffMinutes / 60);
                const minutes = diffMinutes % 60;
                workLengthInput.value = `${hours}h ${minutes}m`;
            } else {
                workLengthInput.value = "";
            }
        }
        //     function checkFormData(event) {
        //     event.preventDefault();  // Prevent form submission
        //     const formData = new FormData(event.target);

        //     console.log("Form Data:");
        //     formData.forEach((value, key) => {
        //         console.log(`${key}: ${value}`);
        //     });
        // }
    </script>


    <script>
        $(document).ready(function() {
            $("#user_list").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [5, 10, 20, 50, 100],
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('scheduleForm');
            var dayCheckboxes = document.querySelectorAll('.day-checkbox');
            var dayErrorMessage = document.getElementById('dayErrorMessage');

            form.addEventListener('submit', function(event) {
                var isDaySelected = Array.from(dayCheckboxes).some(checkbox => checkbox.checked);

                // Show error message if no day is selected
                if (!isDaySelected) {
                    event.preventDefault();
                    dayErrorMessage.style.display = 'block';
                } else {
                    dayErrorMessage.style.display = 'none';
                }

                // Standard form validation
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);

            // Hide error message when any checkbox is selected
            dayCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (Array.from(dayCheckboxes).some(checkbox => checkbox.checked)) {
                        dayErrorMessage.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        $(function() {
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit_schedule').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete_doctor_schedule').modal('show');
                var id = $(this).data('id');
                $('#deleteid').val(id);
            });

            function getRow(id) {
                $.ajax({
                    url: 'Doctor_schedule.php',
                    type: 'POST',
                    data: {
                        dsID: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Populate inputs with previous values
                        $('#doc_scheduleID').val(response.doc_scheduleID);
                        $('#doctor').val(response.userID);

                        // Prepopulate the repeat checkbox if it exists
                        if (response.reapet) {
                            $('input[name="repeat"][value="' + response.reapet + '"]').prop('checked', true);
                        }

                        $('.day-checkbox').prop('checked', false);
                        $('.time-rows').empty();

                        if (response.schedules) {
                            const schedule = typeof response.schedules === 'string' ? JSON.parse(response.schedules) : response.schedules;

                            for (const day in schedule) {
                                // Set day checkbox
                                $(`#${day.toLowerCase()}Check`).prop('checked', true);

                                // Initialize day row count
                                dayRowCounts[day] = 0;

                                // If there are time entries for the day, add them
                                if (Array.isArray(schedule[day])) {
                                    schedule[day].forEach(item => {
                                        const fromTime = item.fromtime;
                                        const toTime = item.totime;
                                        const workLength = item.worklength;

                                        // Append existing times to the UI for the specific day
                                        $(`#${day.toLowerCase()}TimeRows`).append(`
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[][${day}]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" value="${workLength}">
                                            <input type="time" name="fromtime[][${day}]" class="form-control me-2 time-input from-time" style="width: 120px;" value="${fromTime}" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[][${day}]" class="form-control me-2 time-input to-time" style="width: 120px;" value="${toTime}" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this.closest('.time-rows'), '${day}')">+</button>
                                           
                                        </div>
                                    `);


                                    });
                                }
                            }
                        }
                    },

                    error: function() {
                        alert('Error fetching schedule data.'); // Handle AJAX errors
                    }
                });
            }

        });
    </script>


    <!-- <script>
        $(function() {
            // Variable to track the number of rows per day
            let dayRowCounts = {}; // Initialize day row counts

            // Open modal and fetch schedule data
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit_schedule').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            // Delete action handler
            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete_doctor_schedule').modal('show');
                var id = $(this).data('id');
                $('#deleteid').val(id);
            });

            // Fetch schedule data and populate modal fields
            function getRow(id) {
                $.ajax({
                    url: 'Doctor_schedule.php',
                    type: 'POST',
                    data: {
                        dsID: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Populate doctor and schedule ID
                        $('#doc_scheduleID').val(response.doc_scheduleID);
                        $('#doctor').val(response.userID);

                        // Set repeat checkbox if applicable
                        if (response.reapet) {
                            $('input[name="repeat"][value="' + response.reapet + '"]').prop('checked', true);
                        }

                        // Clear existing checkbox and time rows
                        $('.day-checkbox').prop('checked', false);
                        $('.time-rows').empty();

                        // Load schedule data
                        if (response.schedules) {
                            const schedule = typeof response.schedules === 'string' ? JSON.parse(response.schedules) : response.schedules;

                            // Iterate through each day in the schedule
                            for (const day in schedule) {
                                // Check the checkbox for each scheduled day
                                $(`#${day.toLowerCase()}Check`).prop('checked', true);

                                // Initialize row count for the day
                                dayRowCounts[day] = 0;

                                // Add each time entry for the day
                                if (Array.isArray(schedule[day])) {
                                    schedule[day].forEach(item => {
                                        const fromTime = item.fromtime;
                                        const toTime = item.totime;
                                        const workLength = item.worklength;

                                        // Append the time row in the modal
                                        $(`#${day.toLowerCase()}TimeRows`).append(`
                                        <div class="d-flex align-items-center time-row">
                                            <input type="text" name="worklength[${day}][]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" value="${workLength}">
                                            <input type="time" name="fromtime[${day}][]" class="form-control me-2 time-input from-time" style="width: 120px;" value="${fromTime}" onchange="calculateWorkHours(this)">
                                            <input type="time" name="totime[${day}][]" class="form-control me-2 time-input to-time" style="width: 120px;" value="${toTime}" onchange="calculateWorkHours(this)">
                                            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow('${day}')">+</button>
                                            <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeRow(this)">x</button>
                                        </div>
                                    `);
                                        dayRowCounts[day]++; // Increment row count
                                    });
                                }
                            }
                        }
                    },
                    error: function() {
                        alert('Error fetching schedule data.');
                    }
                });
            }


        });
    </script> -->





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                allDaySlot: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php echo $calendarEventsJson; ?>,



                editable: false,
                selectable: false,
                eventClick: function(info) {
                    // alert('Event: ' + info.event.title);
                }
            });


            calendar.render();
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Approve button click event
            document.querySelectorAll(".approve").forEach(button => {
                button.addEventListener("click", function() {
                    const docScheduleID = this.getAttribute("data-id");
                    const confirmation = confirm("Are you sure you want to approve this schedule?");
                    if (confirmation) {
                        const actionTime = new Date().toISOString(); // Get current time in ISO format
                        updateAvailability(docScheduleID, 3, "approved", actionTime);
                    }
                });
            });

            // Reject button click event
            document.querySelectorAll(".reject").forEach(button => {
                button.addEventListener("click", function() {
                    const docScheduleID = this.getAttribute("data-id");
                    const confirmation = confirm("Are you sure you want to reject this schedule?");
                    if (confirmation) {
                        const actionTime = new Date().toISOString(); // Get current time in ISO format
                        updateAvailability(docScheduleID, 4, "rejected", actionTime);
                    }
                });
            });

            // Function to update is_available and log the action time
            function updateAvailability(docScheduleID, newStatus, action, actionTime) {
                fetch("ajax/update_schedule_status.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            doc_scheduleID: docScheduleID,
                            is_available: newStatus,
                            action_time: actionTime // Send the action time
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Schedule successfully ${action}.`);
                            location.reload();
                        } else {
                            alert(`Failed to ${action} the schedule.`);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while updating the status.");
                    });
            }
        });
    </script>

    <!-- <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Approve button click event
            document.querySelectorAll(".approve").forEach(button => {
                button.addEventListener("click", function() {
                    const docScheduleID = this.getAttribute("data-id");
                    updateAvailability(docScheduleID, 3);
                });
            });

            // Reject button click event
            document.querySelectorAll(".reject").forEach(button => {
                button.addEventListener("click", function() {
                    const docScheduleID = this.getAttribute("data-id");
                    updateAvailability(docScheduleID, 0);
                });
            });

            // Function to update is_available
            function updateAvailability(docScheduleID, newStatus) {
                fetch("ajax/update_schedule_status.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            doc_scheduleID: docScheduleID,
                            is_available: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Status updated successfully");
                            location.reload();
                        } else {
                            alert("Failed to update status");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        });
    </script> -->





</html>