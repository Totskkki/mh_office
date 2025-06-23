
<?php
include '../config/connection.php';


// if (isset($_POST['patient_id'])) {
//     $patientID = $_POST['patient_id'];

//     $query = "SELECT 
//         p.*, 
//           CONCAT(IFNULL(per.first_name, ''), ' ', IFNULL(per.middlename, ''), ' ', IFNULL(per.lastname, '')) AS doctors_name,
//         tc.*, 
//         pv.patient_visitID,
//         IFNULL(pv.visit_date, 'No visit recorded') as visit_date, 
//         IFNULL(pv.disease, 'No illness') as disease, 
//         IFNULL(pv.next_visit_date, '') as next_visit_date
        
//     FROM tbl_patients AS p
//     LEFT JOIN tbl_patient_visits AS pv ON p.patientID = pv.patient_id
//     LEFT JOIN tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
//     LEFT JOIN tbl_checkup AS tc ON p.patientID = tc.patient_id
//     LEFT JOIN tbl_users AS u ON pv.doctor_id = u.userID
//     LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id
//     WHERE p.patientID = :patientID
//     ORDER BY pv.patient_visitID DESC";

//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
//     $stmt->execute();

//     $patientDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     if ($patientDetails) {
//         echo json_encode($patientDetails);
//     } else {
//         echo json_encode(array("error" => "No details found for the given patient ID."));
//     }
// }

if (isset($_POST['patient_id'])) {
    $patientID = $_POST['patient_id'];

    $query = "SELECT 
        p.*, 
        CONCAT(IFNULL(per.first_name, ''), ' ', IFNULL(per.middlename, ''), ' ', IFNULL(per.lastname, '')) AS doctors_name,
        tc.*, 
        pv.patient_visitID,
        CASE 
            WHEN pv.visit_date = '0000-00-00' OR pv.visit_date IS NULL THEN 'No visit recorded'
            ELSE pv.visit_date
        END AS visit_date, 
        IFNULL(pv.disease, 'No illness') as disease, 
        CASE 
            WHEN pv.next_visit_date = '0000-00-00' OR pv.next_visit_date IS NULL THEN 'No next visit scheduled'
            ELSE pv.next_visit_date
        END AS next_visit_date
    FROM tbl_patients AS p
    LEFT JOIN tbl_patient_visits AS pv ON p.patientID = pv.patient_id
    LEFT JOIN tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
    LEFT JOIN tbl_checkup AS tc ON p.patientID = tc.patient_id
    LEFT JOIN tbl_users AS u ON pv.doctor_id = u.userID
    LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id
    WHERE p.patientID = :patientID
    ORDER BY pv.patient_visitID DESC";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $stmt->execute();

    $patientDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($patientDetails) {
        echo json_encode($patientDetails);
    } else {
        echo json_encode(array("error" => "No details found for the given patient ID."));
    }
}



?>