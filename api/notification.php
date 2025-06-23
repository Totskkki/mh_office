<?php
header('Content-Type: application/json');
require_once 'database.php';

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Create a database instance and get the connection
    $database = new Database();
    $con = $database->getConnection();

    $query = "SELECT COUNT(*)   
              FROM tbl_doctor_schedule 
              WHERE userID = :userID AND (is_available = 3 OR is_available = 4) AND is_read = 0";
    

    $stmt = $con->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    $notificationCount = $stmt->fetchColumn();

    $response = [
        'success' => true,
        'notificationCount' => (int) $notificationCount
    ];

  
    echo json_encode($response);
} else {
 
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
