<?php
include './config/connection.php';

include './common_service/common_functions.php';


ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');



// if (isset($_POST['dsID'])) {
//     $id = $_POST['dsID'];

//     // Adjusted query to select only the necessary columns
//     $query = "SELECT s.day_of_week, s.start_time, s.end_time, s.work_length,user.*,s.doc_scheduleID,s.userID,s.reapet,
//                      CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
//               FROM tbl_doctor_schedule AS s
//               LEFT JOIN tbl_users AS user ON user.userID = s.userID
//               LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
//               WHERE s.doc_scheduleID = :id";

//     $stmt = $con->prepare($query);
//     $stmt->execute([':id' => $id]);
//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     $schedules = [];

//     // Loop through results and build events array
//     foreach ($results as $event) {
//         // Ensure these fields are set
//         $event['day_of_week'] = $event['day_of_week'] ?? '';
//         $event['start_time'] = $event['start_time'] ?? '';
//         $event['end_time'] = $event['end_time'] ?? '';
//         $event['work_length'] = $event['work_length'] ?? '';
//         $doctorName = htmlspecialchars($event['doctorsname'] ?? 'Unknown');

//         // Split days of the week if needed
//         $workDays = explode(',', $event['day_of_week']);

//         foreach ($workDays as $day) {
//             // Create an event entry for each day
//             $schedules[] = [
//                 'doc_scheduleID' => $event['doc_scheduleID'],
//                 'userID' => $event['userID'],
//                 'day_of_week' => trim($day),
//                 'start_time' => $event['start_time'],
//                 'end_time' => $event['end_time'],
//                 'work_length' => $event['work_length'],
//                 'reapet' => $event['reapet'],

//                 'doctor_name' => $doctorName
//             ];
//         }
//     }

//     echo json_encode($schedules);
//     exit;
// }


if (isset($_POST['dsID'])) {
    $id = $_POST['dsID'];

    // Query to fetch the doctor's schedule
    $query = "SELECT s.*,s.schedules,s.doc_scheduleID,
                     CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
              FROM tbl_doctor_schedule AS s
              LEFT JOIN tbl_users AS user ON user.userID = s.userID
              LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
              WHERE s.doc_scheduleID = :id";

    $stmt = $con->prepare($query);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);
    exit;
}

if (isset($_POST['add_schedule'])) {


    var_dump($_POST);
    $doctor = $_POST['doctor'];
    $days = $_POST['day']; // Only captures checked days
    $fromtime = $_POST['fromtime'];
    $totime = $_POST['totime'];
    $worklength = $_POST['worklength'];
    $isAvailable = 1;
    $schedulesArray = [];

    // Loop over the days and add valid time slots to schedulesArray
    foreach ($days as $index => $day) {
        if (!empty($fromtime[$index]) && !empty($totime[$index])) {
            // Collect time slots for each day
            $schedulesArray[$day][] = [
                'fromtime' => $fromtime[$index],
                'totime' => $totime[$index],
                'worklength' => $worklength[$index]
            ];
        }
    }

    $schedulesJson = json_encode($schedulesArray);

    $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
                            VALUES (:userID, :schedules, :is_available)");

    $stmt->bindParam(':userID', $doctor);
    $stmt->bindParam(':schedules', $schedulesJson);
    $stmt->bindParam(':is_available', $isAvailable);

    try {
        $stmt->execute();
        $_SESSION['status'] = "Schedule added successfully for selected days!";
        $_SESSION['status_code'] = "success";
        header('location: Doctor_schedule.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
        header('location: Doctor_schedule.php');
        exit();
    }
}


// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day']; // Only captures checked days
//     $fromtime = $_POST['fromtime'];
//     $totime = $_POST['totime'];
//     $worklength = $_POST['worklength'];
//     $isAvailable = 1;
//     $schedulesArray = [];

//     // Loop over selected days and add valid time slots to schedulesArray
//     foreach ($days as $index => $day) {
//         if (!empty($fromtime[$index]) && !empty($totime[$index])) {
//             $schedulesArray[$day][] = [
//                 'fromtime' => $fromtime[$index],
//                 'totime' => $totime[$index],
//                 'worklength' => $worklength[$index]
//             ];
//         }
//     }

//     $schedulesJson = json_encode($schedulesArray);

//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
//                             VALUES (:userID, :schedules, :is_available)");

//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':is_available', $isAvailable);

//     try {
//         $stmt->execute();
//         $_SESSION['status'] = "Schedule added successfully for selected days!";
//         $_SESSION['status_code'] = "success";
//     } catch (PDOException $e) {
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//     }
// }

// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day'];
//     $worklength = $_POST['worklength'];
//     $fromtime = $_POST['fromtime'];
//     $totime = $_POST['totime'];
//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

//     $isAvailable = 1;
//     $schedulesArray = [];

//     // Group schedules by day
//     for ($i = 0; $i < count($days); $i++) {
//         $day = $days[$i];
//         $from = $fromtime[$i];
//         $to = $totime[$i];
//         $length = $worklength[$i];

//         // Check if this day already exists in the array
//         if (!isset($schedulesArray[$day])) {
//             $schedulesArray[$day] = []; // Initialize array for each day
//         }

//         // Add each time slot as a sub-array within the current day
//         $schedulesArray[$day][] = [
//             'fromtime' => $from,
//             'totime' => $to,
//             'worklength' => $length,
//         ];
//     }

//     // Convert the schedules array to JSON format for storage
//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the SQL statement for insertion
//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
//                             VALUES (:userID, :schedules, :is_available)");

//     // Bind parameters
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':is_available', $isAvailable);

//     try {
//         $stmt->execute();
//         $_SESSION['status'] = "Schedule added successfully for selected days!";
//         $_SESSION['status_code'] = "success";
//     } catch (PDOException $e) {
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//     }

//     // Debugging: Log the added schedules
//     error_log(print_r($schedulesArray, true)); // Log the collected schedules for debugging
// }


// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day'];
//     $worklength = $_POST['worklength'];
//     $fromtime = $_POST['fromtime'];
//     $totime = $_POST['totime'];
//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

//     $isAvailable = 1;
//     $schedulesArray = [];

//     for ($i = 0; $i < count($days); $i++) {
//         $schedulesArray[] = [
//             'day' => $days[$i],
//             'fromtime' => $fromtime[$i],
//             'totime' => $totime[$i],
//             'worklength' => $worklength[$i],
//         ];
//     }

//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the SQL statement for insertion
//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
//                             VALUES (:userID, :schedules, :is_available)");

//     // Bind parameters
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':is_available', $isAvailable);

//     try {
//         $stmt->execute();
//         $_SESSION['status'] = "Schedule added successfully for selected days!";
//         $_SESSION['status_code'] = "success";
//     } catch (PDOException $e) {
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//     }

//     // Debugging: Log the added schedules
//     error_log(print_r($schedulesArray, true)); // Log the collected schedules for debugging
// }


// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day'];
//     $worklength = $_POST['worklength'];
//     $fromtime = $_POST['fromtime'];
//     $totime = $_POST['totime'];
//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

//     $isAvailable = 1;
//     $schedulesArray = [];

//     for ($i = 0; $i < count($days); $i++) {
//         $schedulesArray[] = [
//             'day_of_week' => $days[$i],
//             'start_time' => $fromtime[$i],
//             'end_time' => $totime[$i],
//             'worklength' => $worklength[$i],
//         ];
//     }

//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the SQL statement for insertion
//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
//                             VALUES (:userID, :schedules, :is_available)");

//     // Bind parameters
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':is_available', $isAvailable);

//     try {
//         $stmt->execute();
//         $_SESSION['status'] = "Schedule added successfully for selected days!";
//         $_SESSION['status_code'] = "success";
//     } catch (PDOException $e) {
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//     }

//     // Debugging: Log the added schedules
//     error_log(print_r($schedulesArray, true)); // Log the collected schedules for debugging
// }


// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day'];
//     $worklength = $_POST['worklength']; // Collect all work lengths
//     $fromtime = $_POST['fromtime']; // Collect all from times
//     $totime = $_POST['totime']; // Collect all to times
//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

//     $isAvailable = 1;
//     $hasConflict = false;

//     // Array to hold all schedules to be added
//     $schedulesArray = [];

//     // Loop through each selected day
//     foreach ($days as $index => $day) {
//         // Use a single index to ensure each day has its corresponding work length, from time, and to time
//         for ($i = 0; $i < count($fromtime); $i++) {
//             $startTime = $fromtime[$i];
//             $endTime = $totime[$i];
//             $length = $worklength[$i];

//             // Check for conflicts
//             $checkStmt = $con->prepare("SELECT * FROM tbl_doctor_schedule 
//                                          WHERE userID = :userID 
//                                          AND JSON_CONTAINS(schedules, :day_schedule) 
//                                          AND is_available = :is_available 
//                                          AND (
//                                              (JSON_EXTRACT(schedules, '$[*].start_time') < :end_time AND JSON_EXTRACT(schedules, '$[*].end_time') > :start_time)
//                                          )");

//             $checkStmt->bindParam(':userID', $doctor);
//             $checkStmt->bindParam(':day_schedule', json_encode(['day_of_week' => $day])); // check if the day is part of the schedule
//             $checkStmt->bindParam(':is_available', $isAvailable);
//             $checkStmt->bindParam(':start_time', $startTime);
//             $checkStmt->bindParam(':end_time', $endTime);
//             $checkStmt->execute();

//             if ($checkStmt->rowCount() > 0) {
//                 // Conflict found for this time slot
//                 $hasConflict = true;
//                 break; // Exit the loop if a conflict is found
//             }

//             // Add the schedule data to the array
//             $schedulesArray[] = [
//                 'day_of_week' => $day,
//                 'start_time' => $startTime,
//                 'end_time' => $endTime,
//                 'work_length' => $length,
//                 'repeat' => $repeat
//             ];
//         }
//     }

//     if ($hasConflict) {
//         $_SESSION['status'] = "Schedule conflicts with existing schedule!";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Convert the schedules array to JSON
//     $schedulesJson = json_encode($schedulesArray);

//     // Prepare the SQL statement for insertion
//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, schedules, is_available) 
//                             VALUES (:userID, :schedules, :is_available)");

//     // Bind parameters
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':schedules', $schedulesJson);
//     $stmt->bindParam(':is_available', $isAvailable);

//     try {
//         $stmt->execute();
//     } catch (PDOException $e) {
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     $_SESSION['status'] = "Schedule added successfully for selected days!";
//     $_SESSION['status_code'] = "success";
//     header('location: Doctor_schedule.php');
//     exit();
// }


$doctors = getDoctorSchedule($con);



// if (isset($_POST['add_schedule'])) {
//     $doctor = $_POST['doctor'];
//     $days = $_POST['day'];
//     $worklength = $_POST['worklength'];
//     $fromtime = $_POST['fromtime'];
//     $totime = $_POST['totime'];


//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';


//     $isAvailable = 1;
//     $hasConflict = false;


//     foreach ($days as $index => $day) {

//         $startTime = $fromtime[$index];
//         $endTime = $totime[$index];


//         $checkStmt = $con->prepare("SELECT * FROM tbl_doctor_schedule 
//                                     WHERE userID = :userID 
//                                     AND day_of_week = :day_of_week 
//                                     AND is_available = :is_available 
//                                     AND (
//                                         (start_time < :end_time AND end_time > :start_time)
//                                     )");

//         $checkStmt->bindParam(':userID', $doctor);
//         $checkStmt->bindParam(':day_of_week', $day);
//         $checkStmt->bindParam(':is_available', $isAvailable);
//         $checkStmt->bindParam(':start_time', $startTime);
//         $checkStmt->bindParam(':end_time', $endTime);

//         $checkStmt->execute();

//         if ($checkStmt->rowCount() > 0) {
//             // Conflict found for this time slot
//             $hasConflict = true;
//             break; // Exit the loop if a conflict is found
//         }
//     }

//     if ($hasConflict) {
//         // Duplicate found, do not insert
//         $_SESSION['status'] = "Schedule conflicts with existing schedule!";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Concatenate days, start times, end times, and work lengths into strings for insertion
//     $daysOfWeek = implode(',', $days);
//     $startTimes = implode(',', $fromtime); // Join start times
//     $endTimes = implode(',', $totime); // Join end times
//     $workLengths = implode(',', $worklength); // Join work lengths

//     // Prepare the SQL statement for insertion
//     $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, day_of_week, start_time, end_time, is_available, work_length, reapet) 
//                             VALUES (:userID, :day_of_week, :start_time, :end_time, :is_available, :work_length, :reapet)");

//     // Binding parameters
//     $stmt->bindParam(':userID', $doctor);
//     $stmt->bindParam(':day_of_week', $daysOfWeek);
//     $stmt->bindParam(':start_time', $startTimes);
//     $stmt->bindParam(':end_time', $endTimes);
//     $stmt->bindParam(':is_available', $isAvailable);
//     $stmt->bindParam(':work_length', $workLengths);
//     $stmt->bindParam(':reapet', $repeat);

//     try {
//         $stmt->execute();

//         $scheduleId = $con->lastInsertId();
//         $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);

//         $userId = $_SESSION['admin_id'];
//         $action = "Add Schedule";
//         $description = "Added a schedule for Doctor $affectedRecordName";

//         logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);

//         $_SESSION['status'] = "Schedule added successfully for selected days!";
//         $_SESSION['status_code'] = "success";
//         header('location: Doctor_schedule.php');
//         exit();
//     } catch (PDOException $e) {
//         $con->rollBack();
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
// }

// if (isset($_POST['update_schedule'])) {

//     $doctor = $_POST['doctor'];
//     $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';
//     $isAvailable = 1;


//     $scheduleIds = isset($_POST['doc_scheduleID']) ? $_POST['doc_scheduleID'] : []; // IDs for updating
//     $days = isset($_POST['day']) ? $_POST['day'] : []; // Days
//     $worklength = isset($_POST['worklength']) ? array_filter($_POST['worklength']) : []; // Work lengths
//     $fromtime = isset($_POST['fromtime']) ? array_filter($_POST['fromtime']) : []; // Start times
//     $totime = isset($_POST['totime']) ? array_filter($_POST['totime']) : []; // End times

//     // Ensure $scheduleIds is an array
//     if (!is_array($scheduleIds)) {
//         $scheduleIds = [$scheduleIds];
//     }


//     $con->beginTransaction();

//     try {

//         $concatenatedDays = implode(',', array_unique($days));
//         $concatenatedWorkLengths = implode(',', array_unique($worklength));
//         $concatenatedStartTimes = implode(',', array_unique($fromtime));
//         $concatenatedEndTimes = implode(',', array_unique($totime));

//         $placeholders = implode(',', array_fill(0, count($scheduleIds), '?'));

//         $stmt = $con->prepare("UPDATE tbl_doctor_schedule 
//                                SET userID = ?, 
//                                    day_of_week = ?, 
//                                    start_time = ?, 
//                                    end_time = ?,        
//                                    work_length = ?, 
//                                    reapet = ? 
//                                WHERE doc_scheduleID IN ($placeholders)");


//         $stmt->execute(array_merge([$doctor, $concatenatedDays, $concatenatedStartTimes, $concatenatedEndTimes, $concatenatedWorkLengths, $repeat], $scheduleIds));

//         // Commit the transaction
//         $con->commit();

//         $_SESSION['status'] = "Schedule updated successfully!";
//         $_SESSION['status_code'] = "success";
//         header('location: Doctor_schedule.php');
//         exit();
//     } catch (PDOException $e) {
//         // Rollback if something goes wrong
//         $con->rollBack();
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
// }

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
                                                        <th>Start Time</th>
                                                        <th>End Time</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT ds.*, user.*, personnel.*, position.* 
                                                    FROM tbl_doctor_schedule as ds 
                                                    LEFT JOIN tbl_users as user ON ds.userID = user.userID  
                                                    LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                                                    LEFT JOIN tbl_position AS position ON user.position_id = position.position_id 
                                                    ORDER BY ds.doc_scheduleID DESC";

                                                    $stmt = $con->prepare($query);
                                                    $stmt->execute();

                                                    $doctorData = [];

                                                    // Fetch each doctor's schedule
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        // Decode the schedules from JSON
                                                        $schedulesArray = json_decode($row['schedules'], true);

                                                        // Prepare a structured array for each doctor
                                                        $doctorId = $row['userID'];
                                                        if (!isset($doctorData[$doctorId])) {
                                                            $doctorData[$doctorId] = [
                                                                'name' => htmlspecialchars($row['first_name'] . ' ' . ucwords($row['middlename']) . ' ' . ucwords($row['lastname'])),
                                                                'is_available' => $row['is_available'],
                                                                'schedules' => [],
                                                                'dsID' => $row['doc_scheduleID'],
                                                            ];
                                                        }

                                                        // Aggregate schedules for the doctor
                                                        if (is_array($schedulesArray)) {
                                                            foreach ($schedulesArray as $day => $slots) {
                                                                // Ensure we only add the day once, but can add multiple time slots
                                                                foreach ($slots as $slot) {
                                                                    $doctorData[$doctorId]['schedules'][$day][] = [
                                                                        'start_time' => htmlspecialchars($slot['fromtime']),
                                                                        'end_time' => htmlspecialchars($slot['totime']),
                                                                        'worklength' => htmlspecialchars($slot['worklength']),
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                    }

                                                    // Display the aggregated schedules
                                                    foreach ($doctorData as $doctor) {
                                                        // Prepare arrays for display
                                                        $workDays = [];
                                                        $startTimes = [];
                                                        $endTimes = [];

                                                        foreach ($doctor['schedules'] as $day => $slots) {
                                                            // Only add the day name once
                                                            $workDays[] = ucfirst($day);
                                                            // Collect all start and end times for that day
                                                            foreach ($slots as $slot) {
                                                                $startTimes[] = $slot['start_time'];
                                                                $endTimes[] = $slot['end_time'];
                                                            }
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td><?php echo ++$serial; ?></td>
                                                            <td><?php echo $doctor['name']; ?></td>
                                                            <td><?php echo implode(', ', $workDays) ?: 'No schedules available'; ?></td>
                                                            <td><?php echo implode(', ', $startTimes) ?: 'N/A'; ?></td>
                                                            <td><?php echo implode(', ', $endTimes) ?: 'N/A'; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($doctor['is_available'] == 1) {
                                                                    echo '<span class="badge bg-success">Available</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-warning">Not Available</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $doctor['dsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                                    <i class="icon-edit"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm delete" data-id="<?php echo $doctor['dsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                                    <i class="icon-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>


                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="card p-3">
                                        <!-- <h5>Date Overrides</h5>
                                        <h6 class="mb-4 fw-light">
                                            Add dates to override doctor's schedule from regular weekly hours.
                                        </h6>
                                        <div class="col-lg-4">
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




                                        $schedulesArray = json_decode($row['schedules'], true);


                                        $calendarEvents = [];

                                        foreach ($results as $event) {

                                            $workDays = explode(',', $event['day_of_week']);
                                            $startTimes = explode(',', $event['start_time']);
                                            $endTimes = explode(',', $event['end_time']);


                                            $baseDate = new DateTime();
                                            $baseDate->setTime(0, 0, 0);


                                            $repeatType = $event['reapet'];
                                            $doctorName = htmlspecialchars($event['doctorsname']);


                                            $color = $doctorColors[$doctorName] ?? '#0073e6';

                                            foreach ($workDays as $day) {
                                                $dayNumber = date('N', strtotime($day));

                                                $isToday = $baseDate->format('N') == $dayNumber;
                                                $eventDate = clone $baseDate;

                                                if (!$isToday) {
                                                    $eventDate->modify("next $day");
                                                }

                                                $statusText = $event['is_available'] == 1 ? 'Available' : 'Not Available';


                                                if ($repeatType === 'Weekly') {
                                                    for ($i = 0; $i < 4; $i++) {
                                                        $weeklyEventDate = clone $eventDate;
                                                        $weeklyEventDate->modify("+$i week");


                                                        foreach ($startTimes as $index => $startTime) {
                                                            $calendarEvents[] = [
                                                                'title' => 'Dr.: ' . $doctorName,
                                                                'start' => $weeklyEventDate->format('Y-m-d') . 'T' . $startTime,
                                                                'end'   => $weeklyEventDate->format('Y-m-d') . 'T' . $endTimes[$index],
                                                                'color' => $color,
                                                                'status' => $statusText,
                                                            ];
                                                        }
                                                    }
                                                } elseif ($repeatType === 'Monthly') {
                                                    for ($i = 0; $i < 4; $i++) {
                                                        $eventDate = clone $baseDate;

                                                        if (!$isToday) {
                                                            $eventDate->modify("first day of next month");
                                                            $eventDate->modify("+$i month");
                                                            $eventDate->modify("next $day");
                                                        }


                                                        foreach ($startTimes as $index => $startTime) {
                                                            $calendarEvents[] = [
                                                                'title' => 'Dr.: ' . $doctorName,
                                                                'start' => $eventDate->format('Y-m-d') . 'T' . $startTime,
                                                                'end'   => $eventDate->format('Y-m-d') . 'T' . $endTimes[$index],
                                                                'color' => $color,
                                                                'status' => $statusText,
                                                            ];
                                                        }
                                                    }
                                                } elseif ($repeatType === 'Yearly') {
                                                    for ($i = 0; $i < 4; $i++) {
                                                        $eventDate = clone $baseDate;

                                                        if (!$isToday) {
                                                            $eventDate->modify("first day of January");
                                                            $eventDate->modify("+$i year");
                                                            $eventDate->modify("next $day");
                                                        }


                                                        foreach ($startTimes as $index => $startTime) {
                                                            $calendarEvents[] = [
                                                                'title' => 'Dr.: ' . $doctorName,
                                                                'start' => $eventDate->format('Y-m-d') . 'T' . $startTime,
                                                                'end'   => $eventDate->format('Y-m-d') . 'T' . $endTimes[$index],
                                                                'color' => $color,
                                                                'status' => $statusText,
                                                            ];
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
        function toggleAvailability(checkbox) {
            const timeRowsContainer = checkbox.closest('.list-group-item').querySelector('.time-rows');

            // If the checkbox is checked, add the first row
            if (checkbox.checked) {
                addRow(timeRowsContainer, checkbox.value); // Add a row with the day's value
            } else {
                timeRowsContainer.innerHTML = ''; // Clear all rows for unselected days
            }
        }

        function addRow(container, day = null) {
            const newRow = document.createElement('div');
            newRow.classList.add('d-flex', 'align-items-center', 'time-row', 'mt-2');

            // Include `day` value only for the checkbox initially
            newRow.innerHTML = `
            ${day ? `<input type="hidden" name="day[]" value="${day}">` : ""}
            <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours">
            <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" placeholder="From" onchange="calculateWorkHours(this)">
            <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" placeholder="To" onchange="calculateWorkHours(this)">
            <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this.closest('.time-rows'))">+</button>
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

                const diffMinutes = toTotalMinutes - fromTotalMinutes;
                const hours = Math.floor(diffMinutes / 60);
                const minutes = diffMinutes % 60;
                workLengthInput.value = `${hours}h ${minutes}m`;
            } else {
                workLengthInput.value = "";
            }
        }
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


    <!-- 
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
                    type: 'POST',
                    url: 'Doctor_schedule.php',
                    data: {
                        dsID: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log("Fetched Data:", data);

                        $('#doc_scheduleID').val(data.doc_scheduleID);
                        $('#doctor').val(data.userID);
                        if (data.reapet) {
                            $('input[name="repeat"][value="' + data.reapet + '"]').prop('checked', true);
                        }

                        // Clear and reset all checkboxes and time rows
                        $('.day-checkbox').prop('checked', false);
                        $('.time-rows').empty();

                        // Loop through the schedules by day
                        for (const day in data.schedules) {
                            const timeSlots = data.schedules[day];

                            // Enable the checkbox for this day
                            $('#' + day.toLowerCase() + 'Check').prop('checked', true);

                            // Iterate through each time slot for the current day
                            timeSlots.start.forEach((startTime, index) => {
                                const endTime = timeSlots.end[index] || '';
                                const workLength = timeSlots.workLength[index] || '';

                                if (startTime && endTime) {
                                    const timeRow = `
                            <div class="d-flex align-items-center time-row">
                                <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" value="${workLength}" required>
                                <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" required placeholder="From" value="${startTime}">
                                <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" required placeholder="To" value="${endTime}">
                                <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)">+</button>
                            </div>`;

                                    // Append the time row to the specific day's container
                                    $('#' + day.toLowerCase() + 'TimeRows').append(timeRow);
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.log("Status: " + status);
                        console.dir(xhr);
                    }
                });
            }



        });
    </script> -->


    <script>
        $(function() {
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit_schedule').modal('show'); // Show the edit modal
                var id = $(this).data('id'); // Get the dsID from the button's data attribute
                getRow(id); // Call the function to get the row data
            });

            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete_doctor_schedule').modal('show'); // Show the delete confirmation modal
                var id = $(this).data('id'); // Get the dsID for deletion
                $('#deleteid').val(id); // Set the ID in the hidden input for deletion
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
                        console.log(response); // Log the response data for debugging

                        $('#doc_scheduleID').val(response.doc_scheduleID);
                        $('#doctor').val(response.userID);
                        if (response.reapet) {
                            $('input[name="repeat"][value="' + response.reapet + '"]').prop('checked', true);
                        }

                        // Clear any previous selections
                        $('.day-checkbox').prop('checked', false);
                        // $('.time-rows').empty(); // Clear existing time rows

                        if (response.schedules) {
                            const schedules = JSON.parse(response.schedules);
                            schedules.forEach(schedule => {
                                // Access properties from the schedule object
                                const day = schedule.day_of_week.toUpperCase(); // Ensure uppercase day
                                const fromTime = schedule.start_time;
                                const toTime = schedule.end_time;
                                const workLength = schedule.work_length;

                                // Check the day checkbox
                                $(`#${day.toLowerCase()}Check`).prop('checked', true);

                                // Append the time row
                                $(`#${day.toLowerCase()}TimeRows`).append(`
                            <div class="d-flex align-items-center time-row">
                                <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" value="${workLength}" placeholder="Hours">
                                <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" value="${fromTime}" required>
                                <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" value="${toTime}" required>
                                <button type="button" class="btn btn-info btn-sm ms-2" onclick="addRow(this)">+</button>
                            </div>
                        `);
                            });
                        }
                    },
                    error: function() {
                        alert('Error fetching schedule data.'); // Handle AJAX errors
                    }
                });
            }

        });
    </script>



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






</html>