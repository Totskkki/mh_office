<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila'); 


if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $logoutTime = date('Y-m-d H:i:s'); // Get the current time

    
    $database = new Database();
    $conn = $database->getConnection();

    // Prepare the SQL query to update the logout time
    $sql = "UPDATE tbl_user_log SET logout = :logout  WHERE userID = :userID AND logout IS NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':logout', $logoutTime);
    $stmt->bindParam(':userID', $userID);

    // Execute the query
    if ($stmt->execute()) {
        // Respond with success
        echo json_encode(['success' => true, 'message' => 'Logout time updated.']);
    } else {
        // Respond with failure
        echo json_encode(['success' => false, 'message' => 'Failed to update logout time.']);
    }
} else {
    // Respond with an error if no userID is provided
    echo json_encode(['success' => false, 'message' => 'No userID provided.']);
}

