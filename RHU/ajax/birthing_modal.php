<?php
include '../config/connection.php';

header('Content-Type: application/json');




if (isset($_POST['birthID'])) {
    $id = $_POST['birthID'];
    $queryUsers = "SELECT b.*, com.*, bm.admission_date
                   FROM tbl_birth_info b
                   JOIN tbl_complaints com ON com.patient_id = b.patient_id
                   JOIN tbl_birthing_monitoring bm ON bm.patient_id = b.patient_id
                   WHERE b.patient_id = :id";

    $stmtUsers = $con->prepare($queryUsers);

    if ($stmtUsers->execute([':id' => $id])) {
        $row = $stmtUsers->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'No data found for the given ID.']);
        }
    } else {
        $errorInfo = $stmtUsers->errorInfo();
        echo json_encode(['error' => 'Query failed: ' . $errorInfo[2]]);
    }
    exit;
}


