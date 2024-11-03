

<?php
include '../config/connection.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Prepare and sanitize input data
$patientID = isset($data['patientID']) ? intval($data['patientID']) : null;
$complaintID = isset($data['complaintID']) ? intval($data['complaintID']) : null;

if ($patientID && $complaintID) {
    try {
        $con->beginTransaction();

        // Update the tbl_complaints table
        $stmtUpdate = $con->prepare("
            UPDATE tbl_complaints 
            SET status = 'Done' ,transferred = 'referred'
            WHERE patient_id = :patientID 
              AND (consultation_purpose = 'Prenatal' OR consultation_purpose = 'Birthing') 
              AND complaintID = :complaintID
        ");
        $stmtUpdate->bindParam(':patientID', $patientID);
        $stmtUpdate->bindParam(':complaintID', $complaintID);
        $stmtUpdate->execute();

        $con->commit();

        $_SESSION['status'] = "Patient referral submitted successfully.";
        $_SESSION['status_code'] = "success";

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $con->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
