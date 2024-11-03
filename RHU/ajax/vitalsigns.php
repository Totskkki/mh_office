<?php
// db_connection.php - include your PDO connection here
include '../config/connection.php';

header('Content-Type: application/json');;

try {
    // Prepare the query
    $stmt = $con->prepare("SELECT `vitalSignsID`, `date_shift`, `time`, `bp`, `cr`, `rr`, `temp`, `nurse_midwife` FROM `tbl_vitalsigns_monitoring` ORDER BY `date_shift`, `time`");
    $stmt->execute();

    // Fetch all results as an associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);




    echo json_encode($data);
    // Check for JSON encoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON encoding error: ' . json_last_error_msg());
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>