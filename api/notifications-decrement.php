<?php
header('Content-Type: application/json');
require_once 'database.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Create a database instance and get the connection
    $database = new Database();
    $con = $database->getConnection();

    // Update the most recent unread notification (is_read = 0) to read (is_read = 1)
    $updateQuery = "UPDATE tbl_doctor_schedule 
                    SET is_read = 1
                    WHERE userID = :userID 
                    AND (is_available = 3 OR is_available = 4)
                    AND is_read = 0
                    ORDER BY action_time DESC 
                    LIMIT 1"; // Mark only the most recent unread notification as read

    $stmt = $con->prepare($updateQuery);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Get the count of unread notifications (is_read = 0) after the update
    $countQuery = "SELECT COUNT(*) FROM tbl_doctor_schedule 
                   WHERE userID = :userID AND (is_available = 3 OR is_available = 4) 
                   AND is_read = 0"; // Only count unread notifications

    $countStmt = $con->prepare($countQuery);
    $countStmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $countStmt->execute();

    $notificationCount = $countStmt->fetchColumn();

    $response = [
        'success' => true,
        'notificationCount' => (int) $notificationCount
    ];

    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
