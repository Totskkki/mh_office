<?php 
ob_start();
header('Content-Type: application/json; charset=utf-8');


require_once 'database.php';
require_once 'doctor_class.php'; 

file_put_contents("php://stderr", print_r($_POST, true));
$scheduleFetcher = new ScheduleFetcher();

if (isset($_POST['action']) && $_POST['action'] == 'applyForLeave') {
    if (isset($_POST['userID'], $_POST['leaveDate'], $_POST['message'], $_POST['startTime'], $_POST['endTime'])) {
        $userID = $_POST['userID'];
        $leaveDate = $_POST['leaveDate'];
        $message = $_POST['message'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];

        // Assume applyForLeave() returns a boolean indicating success or failure
        $result = $scheduleFetcher->applyForLeave($userID, $leaveDate, $message, $startTime, $endTime);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Leave applied successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to apply leave']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

ob_end_flush();
