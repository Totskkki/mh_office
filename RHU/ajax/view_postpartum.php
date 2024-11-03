<?php
include '../config/connection.php';

header('Content-Type: application/json');


if (isset($_POST['postID'])) {
    $postID = $_POST['postID'];

    try {
        // Prepare and execute the SQL query to fetch the record
        $query = "SELECT b.*, p.*,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name
                  
                  FROM tbl_postpartum b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id              
                  WHERE b.postpartumID   = :recordId";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $postID, PDO::PARAM_INT);
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