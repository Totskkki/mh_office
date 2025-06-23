<?php
header('Content-Type: application/json');
require_once 'database.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Create a database instance and get the connection
    $database = new Database();
    $con = $database->getConnection();

    $query = "SELECT *
              FROM tbl_doctor_schedule 
              WHERE userID = :userID AND (is_available = 3 OR is_available = 4 ) 
              ORDER BY action_time DESC";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $currentDateTime = new DateTime();

    foreach ($notifications as &$notification) {
        // Remove the timeAgo field from the response
        unset($notification['timeAgo']);

        // Set the isApproved flag based on is_available value
        $notification['isApproved'] = ($notification['is_available'] == 3); // true if approved, false if rejected

        // Only compute and return the approval/rejection times
        if ($notification['is_available'] == 3) {
            // Approved message
            if (strpos($notification['message'], 'Rejected: ') === 0) {
                $notification['message'] = substr($notification['message'], 10); // Remove "Rejected: "
            }

            if (!empty($notification['action_time'])) {
                $approvedAt = new DateTime($notification['action_time']);
                $approvalInterval = $currentDateTime->diff($approvedAt);
                $notification['approvedTimeAgo'] = $approvalInterval->format('%h hours %i minutes ago');
            }
        } elseif ($notification['is_available'] == 4) {
            // Remove "Rejected: " from the message if it's there
            if (strpos($notification['message'], 'Rejected: ') === 0) {
                $notification['message'] = substr($notification['message'], 10); // Remove "Rejected: "
            }
            if (!empty($notification['action_time'])) {
                $rejectedAt = new DateTime($notification['action_time']);
                $rejectionInterval = $currentDateTime->diff($rejectedAt);
                $notification['rejectedTimeAgo'] = $rejectionInterval->format('%h hours %i minutes ago');
            }
        }
        $notification['isUnread'] = ($notification['is_read'] == 0);
    }

    // Return the response with only approvedTimeAgo and rejectedTimeAgo
    $response = [
        'success' => true,
        'notifications' => $notifications
    ];

    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
