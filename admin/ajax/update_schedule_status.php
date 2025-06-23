<?php
include '../config/connection.php';

$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['doc_scheduleID']) && isset($input['is_available']) && isset($input['action_time'])) {
    $docScheduleID = $input['doc_scheduleID'];
    $newStatus = $input['is_available'];
    $actionTime = $input['action_time'];  
    try {
      
        $query = "UPDATE tbl_doctor_schedule 
                  SET is_available = :is_available, action_time = :action_time 
                  WHERE doc_scheduleID = :doc_scheduleID";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":is_available", $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(":doc_scheduleID", $docScheduleID, PDO::PARAM_INT);
        $stmt->bindParam(":action_time", $actionTime, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            // Send success response
            echo json_encode(["success" => true]);
        } else {
            // Send failure response
            echo json_encode(["success" => false]);
        }
    } catch (PDOException $ex) {
        // Handle error
        echo json_encode(["success" => false, "error" => $ex->getMessage()]);
    }
} else {
    // Invalid input
    echo json_encode(["success" => false, "error" => "Invalid input"]);
}
?>

