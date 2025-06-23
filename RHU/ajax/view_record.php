<?php
include '../config/connection.php';

if (isset($_POST['recordID'])) {
    $recordId = $_POST['recordID'];

    try {
        // Prepare and execute the SQL query to fetch the record
        $query = "SELECT b.*, p.*, a.* ,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                   CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
                  FROM tbl_birthing_monitoring b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyAddress a ON a.famID = p.family_address
                  WHERE b.birthMonitorID = :recordId";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the record exists
        if ($record) {
            // Return the record as JSON
            echo json_encode($record);
        } else {
            // Return an error if the record is not found
            echo json_encode(['error' => 'Record not found']);
        }
    } catch (PDOException $e) {
        // Handle any PDO exceptions
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Return an error if the request is not valid
    echo json_encode(['error' => 'Invalid request']);
}
?>
