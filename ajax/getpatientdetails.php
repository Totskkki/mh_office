<?php
include '../config/connection.php';

if (isset($_GET['patientID'])) {
    $patientID = $_GET['patientID'];

    // Fetch patient details
    $query = "SELECT pat.*, mem.*, complaints.*,fam.*,
       CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS name,
       CONCAT(fam.brgy, ' ', fam.purok, ' ', fam.province) AS familyaddress
    FROM tbl_patients AS pat 
    LEFT JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID 
    LEFT JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID
    LEFT JOIN tbl_complaints AS complaints ON pat.patientID = complaints.patient_id
    WHERE pat.patientID = :patientID
    ";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        echo json_encode($patient);
    } else {
        echo json_encode(["error" => "No details found for the given patient ID."]);
    }
}
?>
