<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila'); 

if (isset($_POST['userID'], $_POST['start_date'], $_POST['end_date'], $_POST['reason'])) {
    $userID = $_POST['userID'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $reason = $_POST['reason'];
    $is_available = 2; // Assuming 2 means "leave applied"

    // Initialize database connection
    $database = new Database();
    $con = $database->getConnection();

    try {
        // Check if the provided leave dates overlap with an existing schedule
        $checkQuery = "SELECT COUNT(*) FROM `tbl_doctor_schedule`
                       WHERE `userID` = :userID 
                       AND ((`leave_start_date` BETWEEN :start_date AND :end_date) 
                       OR (`leave_end_date` BETWEEN :start_date AND :end_date)
                       OR (`leave_start_date` <= :start_date AND `leave_end_date` >= :end_date))";
        
        $stmt = $con->prepare($checkQuery);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);

        $stmt->execute();

        // Check if any existing overlapping schedules were found
        $existingScheduleCount = $stmt->fetchColumn();
        
        if ($existingScheduleCount > 0) {
            // Return error if a schedule already exists for the date range
            echo json_encode([
                'status' => 'error',
                'message' => 'Leave cannot be applied. A schedule already exists for this date.'
            ]);
            exit;
        }

        // Proceed with applying leave if no conflict is found
        $query = "INSERT INTO `tbl_doctor_schedule` (`userID`, `leave_start_date`, `leave_end_date`, `message`, `is_available`)
                  VALUES (:userID, :leave_start_date, :leave_end_date, :message, :is_available)";
        
        $stmt = $con->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':leave_start_date', $startDate);
        $stmt->bindParam(':leave_end_date', $endDate);
        $stmt->bindParam(':message', $reason);
        $stmt->bindParam(':is_available', $is_available);

        // Execute the query to apply leave
        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Leave applied successfully',
                'data' => [
                    'userID' => $userID,
                    'leave_start_date' => $startDate,
                    'leave_end_date' => $endDate,
                    'message' => $reason,
                    'is_available' => $is_available
                ]
            ]);
        } else {
            throw new Exception("Failed to apply leave. Please try again.");
        }
    } catch (Exception $e) {
        // Catch any errors related to the database or the application logic
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to apply leave',
            'error' => $e->getMessage()
        ]);
    }
} else {
    // If the required parameters are missing, return an error message
    echo json_encode([
        'status' => 'error',
        'message' => 'Incomplete parameters provided'
    ]);
}


