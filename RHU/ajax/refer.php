<?php
include '../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['referID'])) {
    $RoomID = $_POST['referID'];

    try {
        // Prepare and execute the SQL query to fetch the record
        $query = "SELECT p.*, a.*,bm.*,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                  CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
                  FROM tbl_patients p    
                  LEFT JOIN tbl_familyaddress a ON a.famID = p.family_address
                  LEFT JOIN tbl_birth_info bm on bm.patient_id = p.patientID
                
                  WHERE p.patientID = :recordId";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $RoomID, PDO::PARAM_INT);
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
