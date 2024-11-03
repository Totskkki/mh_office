<?php
include './config/connection.php';

include './common_service/common_functions.php';


// if (isset($_POST['add_schedule'])) {
//     $doctor_id = $_POST['doctor'];
//     $days_of_week_array = $_POST['days_of_week'] ?? []; // This is an array of days
//     $start_time = $_POST['start_time'];
//     $end_time = $_POST['end_time'];
//     $status = $_POST['status'];


//     if (empty($days_of_week_array)) {
//         $_SESSION['status'] = "Days of the week cannot be empty.";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
//     // Combine days into a comma-separated string
//     $days_of_week = implode(',', $days_of_week_array);

//     $duplicateCheckQuery = "SELECT COUNT(*) FROM tbl_doctor_schedule WHERE userID = ? AND day_of_week = ?";
//     $duplicateCheckStmt = $con->prepare($duplicateCheckQuery);
//     $duplicateCheckStmt->execute([$doctor_id, $days_of_week]);
//     $duplicateCount = $duplicateCheckStmt->fetchColumn();

//     if ($duplicateCount > 0) {
//         $_SESSION['status'] = "Schedule for the selected days already exists for this doctor. Please choose different days.";
//         $_SESSION['status_code'] = "warning";
//         header('location: Doctor_schedule.php');
//         exit();
//     }


//     $con->beginTransaction();
//     try {
//         $query = "INSERT INTO tbl_doctor_schedule (userID, day_of_week, start_time, end_time, is_available) VALUES (:doctor_id, :day_of_week, :start_time, :end_time, :is_available)";
//         $stmt = $con->prepare($query);
//         $stmt->execute([
//             ':doctor_id' => $doctor_id,
//             ':day_of_week' => $days_of_week,
//             ':start_time' => $start_time,
//             ':end_time' => $end_time,
//             ':is_available' => $status,
//         ]);

//         $con->commit();
//         $_SESSION['status'] = "Schedule added successfully.";
//         $_SESSION['status_code'] = "success";
//         header('location: Doctor_schedule.php');
//         exit();
//     } catch (Exception $e) {
//         $con->rollBack();
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
// }
if (isset($_POST['add_schedule'])) {
    $doctor = $_POST['doctor'];
    $days = $_POST['day'];
    $worklength = $_POST['worklength'];
    $fromtime = $_POST['fromtime'];
    $totime = $_POST['totime'];

    // Check if the repeat key exists in POST data
    $repeat = isset($_POST['repeat']) ? $_POST['repeat'] : '';

    // Concatenate days, start times, end times, and work lengths into strings
    $daysOfWeek = implode(',', $days);
    $startTimes = implode(',', $fromtime); // Join start times
    $endTimes = implode(',', $totime); // Join end times
    $workLengths = implode(',', $worklength); // Join work lengths

    // Prepare the SQL statement
    $stmt = $con->prepare("INSERT INTO tbl_doctor_schedule (userID, day_of_week, start_time, end_time, is_available, work_length, reapet) 
                            VALUES (:userID, :day_of_week, :start_time, :end_time, :is_available, :work_length, :reapet)");

    // Binding parameters
    $stmt->bindParam(':userID', $doctor);
    $stmt->bindParam(':day_of_week', $daysOfWeek);
    $stmt->bindParam(':start_time', $startTimes);
    $stmt->bindParam(':end_time', $endTimes);
    $isAvailable = 1;
    $stmt->bindParam(':is_available', $isAvailable);
    $stmt->bindParam(':work_length', $workLengths);
    $stmt->bindParam(':reapet', $repeat);

    try {
        $stmt->execute();

        // Get the last inserted schedule ID after executing the statement
        $scheduleId = $con->lastInsertId();
        $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);

        $userId = $_SESSION['admin_id'];
        $action = "Add Schedule";
        $description = "Added a schedule for Doctor $affectedRecordName";

        logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);

        $_SESSION['status'] = "Schedule added successfully for selected days!";
        $_SESSION['status_code'] = "success";
        header('location: Doctor_schedule.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}














if (isset($_POST['dsID'])) {


    $id = $_POST['dsID'];
    $queryUsers = "SELECT user.*, personnel.*, position.*, doctor.*
    FROM `tbl_users` AS user
    LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
    LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
    LEFT JOIN `tbl_doctor_schedule` AS doctor ON user.userID = doctor.userID
    WHERE doctor.doc_scheduleID = :id";
    $stmtds = $con->prepare($queryUsers);
    $stmtds->execute([':id' => $id]);
    $row = $stmtds->fetch(PDO::FETCH_ASSOC);

    echo json_encode($row);
    exit;
}








// if (isset($_POST['add_schedule'])) {

//     $doctor_id = $_POST['doctor'];
//     $days_of_week_array = $_POST['days_of_week'] ?? []; // Array of days
//     $start_time = $_POST['start_time'];
//     $end_time = $_POST['end_time'];
//     $status = $_POST['status'];

//     if (empty($days_of_week_array)) {
//         $_SESSION['status'] = "Days of the week cannot be empty.";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Check if the doctor is already added in the table
//     $duplicateDoctorQuery = "SELECT COUNT(*) FROM tbl_doctor_schedule WHERE userID = ?";
//     $duplicateDoctorStmt = $con->prepare($duplicateDoctorQuery);
//     $duplicateDoctorStmt->execute([$doctor_id]);
//     $duplicateCount = $duplicateDoctorStmt->fetchColumn();

//     if ($duplicateCount > 0) {
//         $_SESSION['status'] = "This doctor is already scheduled. Please edit their existing schedule.";
//         $_SESSION['status_code'] = "warning";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Combine days into a comma-separated string
//     $days_of_week = implode(',', $days_of_week_array);

//     // Proceed with adding the schedule
//     $con->beginTransaction();
//     try {
//         $query = "INSERT INTO tbl_doctor_schedule (userID, day_of_week, start_time, end_time, is_available) 
//                   VALUES (:doctor_id, :day_of_week, :start_time, :end_time, :is_available)";
//         $stmt = $con->prepare($query);
//         $stmt->execute([
//             ':doctor_id' => $doctor_id,
//             ':day_of_week' => $days_of_week,
//             ':start_time' => $start_time,
//             ':end_time' => $end_time,
//             ':is_available' => $status,
//         ]);

//         $scheduleId = $con->lastInsertId();

//         // Get affected record name (Doctor name in this case, if necessary)
//         $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);


//         $userId = $_SESSION['admin_id'];
//         $action = "Add Schedule";
//         $description = "Added a schedule for Doctor  $affectedRecordName";

//         logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);


//         $con->commit();  // Committing transaction if everything went fine

//         $_SESSION['status'] = "Schedule added successfully.";
//         $_SESSION['status_code'] = "success";
//         header('location: Doctor_schedule.php');
//         exit();
//     } catch (Exception $e) {
//         $con->rollBack();  // Rolling back on error
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
// }


// if (isset($_POST['add_schedule'])) {
//     $doctor_id = $_POST['doctor'];
//     $days_of_week_array = $_POST['days_of_week'] ?? []; // Array of days
//     $start_time = $_POST['start_time'];
//     $end_time = $_POST['end_time'];
//     $status = $_POST['status'];

//     if (empty($days_of_week_array)) {
//         $_SESSION['status'] = "Days of the week cannot be empty.";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Check if the doctor is already added in the table
//     $duplicateDoctorQuery = "SELECT COUNT(*) FROM tbl_doctor_schedule WHERE userID = ?";
//     $duplicateDoctorStmt = $con->prepare($duplicateDoctorQuery);
//     $duplicateDoctorStmt->execute([$doctor_id]);
//     $duplicateCount = $duplicateDoctorStmt->fetchColumn();

//     if ($duplicateCount > 0) {
//         $_SESSION['status'] = "This doctor is already scheduled. Please edit their existing schedule.";
//         $_SESSION['status_code'] = "warning";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Combine days into a comma-separated string
//     $days_of_week = implode(',', $days_of_week_array);

//     // Proceed with adding the schedule
//     $con->beginTransaction();
//     try {
//         $query = "INSERT INTO tbl_doctor_schedule (userID, day_of_week, start_time, end_time, is_available) 
//                   VALUES (:doctor_id, :day_of_week, :start_time, :end_time, :is_available)";
//         $stmt = $con->prepare($query);
//         $stmt->execute([
//             ':doctor_id' => $doctor_id,
//             ':day_of_week' => $days_of_week,
//             ':start_time' => $start_time,
//             ':end_time' => $end_time,
//             ':is_available' => $status,
//         ]);

//         $scheduleId = $con->lastInsertId();

//         // Get affected record name (Doctor name in this case, if necessary)
//         $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $scheduleId, $con);

//         // Log the action in the audit trail
//         $userId = $_SESSION['userID']; // Assuming you have the user ID in session
//         $action = "Add Schedule";
//         $description = "Added a schedule for Doctor ID: $doctor_id ($affectedRecordName)";
//         logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $scheduleId, $con);


//         $con->commit();
//         $_SESSION['status'] = "Schedule added successfully.";
//         $_SESSION['status_code'] = "success";
//         header('location: Doctor_schedule.php');
//         exit();
//     } catch (Exception $e) {
//         $con->rollBack();
//         $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//         $_SESSION['status_code'] = "danger";
//         header('location: Doctor_schedule.php');
//         exit();
//     }
// }



// if (isset($_POST['update_schedule'])) {
//     $schedule_id = $_POST['schedule_id'];
//     $doctor_id = $_POST['doctor'];
//     $days_of_week_array = $_POST['days_of_week'] ?? []; // Check if days_of_week is set
//     $start_time = $_POST['start_time'];
//     $end_time = $_POST['end_time'];
//     $status = $_POST['status'];

//     // Validate that days_of_week is not empty
//     if (empty($days_of_week_array)) {
//         $_SESSION['status'] = "Days of the week cannot be empty.";
//         $_SESSION['status_code'] = "error";
//         header('location: Doctor_schedule.php');
//         exit();
//     }

//     // Convert array to comma-separated string
//     $days_of_week = implode(',', $days_of_week_array);

//     $queryUpdate = "UPDATE `tbl_doctor_schedule` 
//                     SET `userID` = :doctor_id, 
//                         `day_of_week` = :days_of_week, 
//                         `start_time` = :start_time, 
//                         `end_time` = :end_time, 
//                         `is_available` = :status 
//                     WHERE `doc_scheduleID` = :schedule_id";

//     $stmtUpdate = $con->prepare($queryUpdate);
//     $stmtUpdate->execute([
//         ':doctor_id' => $doctor_id,
//         ':days_of_week' => $days_of_week,
//         ':start_time' => $start_time,
//         ':end_time' => $end_time,
//         ':status' => $status,
//         ':schedule_id' => $schedule_id
//     ]);


//     // Get affected record name (Doctor's name)
//     $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $schedule_id, $con);

//     // Log the action in the audit trail
//     $userId = $_SESSION['admin_id'];
//     $action = "Update Schedule";
//     $description = "Updated the schedule for Doctor $affectedRecordName";
//     logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $schedule_id, $con);


//     // Optionally, you can return a response or redirect the user
//     $_SESSION['status'] = "Doctor schedule successfully updated.";
//     $_SESSION['status_code'] = "success";
//     header('location: Doctor_schedule.php');
//     exit();
// }
$doctors = getDoctorSchedule($con);
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
    <link href='../assets/fullcalendar/main.min.css' rel='stylesheet' />



    <style>
        #calendar {
            border: 1px solid #ddd;
           
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            background: #f9f9f9;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .table thead th {
            background-color: #0d6efd;
            color: white;
            text-align: center;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
            padding: 12px;
        }

        .badge {
            font-size: 0.9em;
            padding: 6px 10px;
        }

        .btn-info {
            background-color: #0d6efd;
            color: #fff;
        }

        .btn-outline-info,
        .btn-outline-danger {
            border-radius: 20px;
            margin: 0 3px;
        }

        .badge {
            border-radius: 12px;
            font-size: 0.8em;
            padding: 6px 8px;
        }

        .tooltip-primary .tooltip-inner {
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            font-size: 0.85em;
        }
    </style>



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
                    <div class="container-fluid">

                        <!-- Row start -->
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
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add_schedule">
                                            <i class="icon-file-plus"></i> Add Schedule
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <div id="calendar"></div>
                                    </div>


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
                                                <!-- PHP dynamic rows go here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="user_list" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Doctor Name</th>
                                                <th>Work days schedule</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                            <?php
                                            $query = "SELECT ds.*, ds.doc_scheduleID as dsID,user.*,personnel.*, position.*
                                                     FROM tbl_doctor_schedule as ds
                                                    LEFT JOIN tbl_users as user ON ds.userID = user.userID  
                                                    LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                                                        LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
                                                        ORDER BY ds.doc_scheduleID DESC";

                                            $stmt = $con->prepare($query);
                                            $stmt->execute();
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $serial = 0;
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $serial++;
                                            ?>

                                                <tr>
                                                    <td><?php echo $serial; ?></td>


                                                    <td><?php echo $row['first_name'] . ' ' . ucwords($row['middlename']) . ' ' . ucwords($row['lastname']); ?></td>
                                                    <td><?php echo $row['day_of_week']; ?></td>

                                                    <td><?php echo $row['start_time']; ?></td>
                                                    <td><?php echo $row['end_time']; ?></td>

                                                    <td>
                                                        <?php

                                                        if ($row['is_available'] == 1) {
                                                            echo '<span class="badge bg-success">available</span>';
                                                        } else {
                                                            echo '<span class="badge bg-warning">not available</span>';
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>

                                                        <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $row['dsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Edit">
                                                            <i class="icon-edit"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm delete" data-id="<?php echo $row['dsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Delete">
                                                            <i class="icon-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <?php
                            // Step 1: Fetch unique doctor names
                            $doctorColors = [];
                            $colorList = ['#ff5733', '#44694a', '#3357ff', '#f39c12', '#8e44ad', '#2980b9', '#d35400', '#c0392b'];

                            $query = "SELECT DISTINCT CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
                                            FROM tbl_doctor_schedule AS s
                                            LEFT JOIN tbl_users AS user ON user.userID = s.userID
                                            LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id";

                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $doctorNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Step 2: Assign colors to doctors
                            foreach ($doctorNames as $index => $doctorName) {
                                // Use the modulus operator to cycle through colors if there are more doctors than colors
                                $color = $colorList[$index % count($colorList)];
                                $doctorColors[$doctorName] = $color; // Map the doctor name to a color
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
    // Split the work days, start times, and end times into arrays
    $workDays = explode(',', $event['day_of_week']);
    $startTimes = explode(',', $event['start_time']);
    $endTimes = explode(',', $event['end_time']);

    // Set the base date (Assuming starting from today)
    $baseDate = new DateTime();
    $baseDate->setTime(0, 0, 0); // Reset time for base date

    // Determine the repeat type
    $repeatType = $event['reapet']; // Assuming 'repeat' holds values like 'weekly', 'monthly', 'yearly'
    $doctorName = htmlspecialchars($event['doctorsname']); // Get doctor's name

    // Determine color for the doctor
    $color = $doctorColors[$doctorName] ?? '#0073e6'; // Default color if doctor not found

    // Loop through each workday
    foreach ($workDays as $day) {
        $dayNumber = date('N', strtotime($day)); // Convert day name to number (1 for Monday, 7 for Sunday)

        // Determine if we need to modify the base date
        $isToday = $baseDate->format('N') == $dayNumber;
        $eventDate = clone $baseDate;

        if (!$isToday) {
            $eventDate->modify("next $day");
        }

        $statusText = $event['is_available'] == 1 ? 'Available' : 'Not Available';

        // Adjust event generation based on repeat type
        if ($repeatType === 'Weekly') {
            for ($i = 0; $i < 4; $i++) { // Generate events for the next 4 weeks
                $weeklyEventDate = clone $eventDate;
                $weeklyEventDate->modify("+$i week");

                // Create events for each time slot
                foreach ($startTimes as $index => $startTime) {
                    $calendarEvents[] = [
                        'title' => 'Doctor: ' . $doctorName,
                        'start' => $weeklyEventDate->format('Y-m-d') . 'T' . $startTime,
                        'end'   => $weeklyEventDate->format('Y-m-d') . 'T' . $endTimes[$index],
                        'color' => $color, // Set color based on doctor
                        'status' => $statusText,
                    ];
                }
            }
        } elseif ($repeatType === 'Monthly') {
            for ($i = 0; $i < 4; $i++) { // Generate events for the next 4 months
                $eventDate = clone $baseDate;

                if (!$isToday) {
                    $eventDate->modify("first day of next month");
                    $eventDate->modify("+$i month"); // Increment by month
                    $eventDate->modify("next $day"); // Find the correct workday in the new month
                }

                // Create events for each time slot
                foreach ($startTimes as $index => $startTime) {
                    $calendarEvents[] = [
                        'title' => 'Doctor: ' . $doctorName,
                        'start' => $eventDate->format('Y-m-d') . 'T' . $startTime,
                        'end'   => $eventDate->format('Y-m-d') . 'T' . $endTimes[$index],
                        'color' => $color,
                        'status' => $statusText,
                    ];
                }
            }
        } elseif ($repeatType === 'Yearly') {
            for ($i = 0; $i < 4; $i++) { // Generate events for the next 4 years
                $eventDate = clone $baseDate;

                if (!$isToday) {
                    $eventDate->modify("first day of January");
                    $eventDate->modify("+$i year"); // Increment by year
                    $eventDate->modify("next $day"); // Find the correct workday in the new year
                }

                // Create events for each time slot
                foreach ($startTimes as $index => $startTime) {
                    $calendarEvents[] = [
                        'title' => 'Doctor: ' . $doctorName,
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















            </div>
            <!-- Container ends -->

        </div>
        <!-- App body ends -->



        <!-- App footer start -->
        <?php include './config/footer.php'; ?>
        <?php include './modal/doctor_schedule-modal.php'; ?>

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



    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>
    <script src='../assets/fullcalendar/main.min.js'></script>


    <script>
        // Array of days


        // Function to enable/disable time inputs and buttons based on checkbox state
        function toggleAvailability(checkbox) {
            const listItem = checkbox.closest('.list-group-item');
            const timeInputs = listItem.querySelectorAll('.time-input');
            const buttons = listItem.querySelectorAll('button');

            // Enable or disable inputs/buttons based on checkbox state
            timeInputs.forEach(input => input.disabled = !checkbox.checked);
            buttons.forEach(button => button.disabled = !checkbox.checked);
        }

        // Function to add a new time slot row beneath the first
        function addRow(button) {
            const timeRowsContainer = button.closest('.time-rows');
            const newRow = document.createElement('div');
            newRow.classList.add('d-flex', 'align-items-center', 'time-row', 'mt-2'); // Add margin-top for spacing

            newRow.innerHTML = `
        <input type="text" name="worklength[]" class="form-control me-2 worklength-input" style="width: 120px;" placeholder="Hours" disabled>
        <input type="time" name="fromtime[]" class="form-control me-2 time-input from-time" style="width: 120px;" placeholder="From" onchange="calculateWorkHours(this)">
        <input type="time" name="totime[]" class="form-control me-2 time-input to-time" style="width: 120px;" placeholder="To" onchange="calculateWorkHours(this)">
        <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeRow(this)">x</button>`;

            timeRowsContainer.appendChild(newRow);
        }

        // Function to remove a specific time slot row
        function removeRow(button) {
            const row = button.closest('.time-row');
            const timeRowsContainer = row.parentNode;

            // Ensure the initial row is not removed
            if (timeRowsContainer.querySelectorAll('.time-row').length > 1) {
                row.remove();
            }
        }

        // Function to calculate work hours based on 'From' and 'To' time inputs and check for overlaps
        function calculateWorkHours(input) {
            const row = input.closest('.time-row');
            const fromTime = row.querySelector('.from-time').value;
            const toTime = row.querySelector('.to-time').value;
            const workLengthInput = row.querySelector('.worklength-input');

            if (fromTime && toTime) {
                const [fromHours, fromMinutes] = fromTime.split(':').map(Number);
                const [toHours, toMinutes] = toTime.split(':').map(Number);

                // Calculate total minutes for comparison
                const fromTotalMinutes = fromHours * 60 + fromMinutes;
                const toTotalMinutes = toHours * 60 + toMinutes;

                // Check if the time is valid (start time should be before end time)
                if (fromTotalMinutes >= toTotalMinutes) {
                    alert("Start time must be before end time.");
                    row.querySelector('.from-time').value = '';
                    row.querySelector('.to-time').value = '';
                    workLengthInput.value = '';
                    return;
                }

                // Check for overlapping times
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

                // Calculate the time difference if no overlap is found
                const diffMinutes = toTotalMinutes - fromTotalMinutes;
                const hours = Math.floor(diffMinutes / 60);
                const minutes = diffMinutes % 60;
                workLengthInput.value = `${hours}h ${minutes}m`;
            } else {
                workLengthInput.value = ""; // Clear if one of the inputs is empty
            }
        }


        function logCheckedDays() {
            const checkboxes = document.querySelectorAll('.day-checkbox');
            let checkedDays = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedDays.push(checkbox.id);
                }
            });
            console.log("Checked days: ", checkedDays);
        }


        document.getElementById('scheduleForm').addEventListener('submit', function(event) {
            logCheckedDays(); // Log days when form is submitted

            const checkboxes = document.querySelectorAll('.day-checkbox');
            let hasErrors = false;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const listItem = checkbox.closest('.list-group-item');
                    const timeRows = listItem.querySelectorAll('.time-row');
                    let hasTime = false;

                    timeRows.forEach(row => {
                        const fromTime = row.querySelector('.from-time').value;
                        const toTime = row.querySelector('.to-time').value;

                        if (fromTime && toTime) {
                            hasTime = true;
                        }
                    });

                    if (!hasTime) {
                        alert(`Please enter time for ${checkbox.labels[0].innerText}.`);
                        hasErrors = true; // Set flag to true if there are errors
                    }
                }
            });

            if (hasErrors) {
                event.preventDefault(); // Prevent form submission if there are errors
            }
        });
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
        // $('.select2').select2()

        // //Initialize Select2 Elements
        // $('#scheduleSelect').select2({
        //     theme: 'bootstrap4',
        //     dropdownParent: $('#add_schedule')
        // })
        // $('#days_of_week').select2({
        //     theme: 'bootstrap4',
        //     dropdownParent: $('#edit_schedule')
        // })
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
                    type: 'POST',
                    url: 'Doctor_schedule.php',
                    data: {
                        dsID: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#schedule_id').val(response.doc_scheduleID);
                        $('#doctor').val(response.userID);
                        var days = response.day_of_week.split(',');
                        $('#days_of_week').val(days).trigger('change');
                        $('#start_time').val(response.start_time);
                        $('#end_time').val(response.end_time);
                        $('#status').val(response.is_available);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                slotMinTime: '06:00:00',
                slotMaxTime: '22:00:00',
                allDaySlot: false,
                editable: false,
                events: <?php echo $calendarEventsJson; ?>,
                eventDidMount: function(info) {
                    info.el.setAttribute('title', info.event.title);

                },
            });

            console.log(<?php echo $calendarEventsJson; ?>); // Log events JSON to the console

            calendar.render();
        });
    </script>
    <!-- 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Convert PHP events JSON into JavaScript variable
            var calendarEvents = <?php echo $calendarEventsJson; ?>;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: calendarEvents, // Load events into the calendar
                eventContent: function(arg) {
                    // Customize event display
                    let statusText = document.createElement('div');
                    statusText.innerHTML = `<b>${arg.event.extendedProps.status}</b>`;

                    return {
                        domNodes: [statusText]
                    };
                }
            });

            calendar.render();
        });
    </script> -->






</html>