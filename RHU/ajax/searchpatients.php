<?php
include '../config/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $query = "SELECT users.patientID, users.patient_name, users.middle_name, users.last_name,fm.*
              FROM tbl_patients AS users 
              LEFT JOIN tbl_family_members fm on fm.patient_id = users.patientID
              WHERE users.patient_name LIKE :search 
                 OR users.middle_name LIKE :search 
                 OR users.last_name LIKE :search OR fm.name like :search
                 GROUP BY users.patientID
              ORDER BY users.patient_name ASC";

    $stmtUsers = $con->prepare($query);
 
    $stmtUsers->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmtUsers->execute();

    $patients = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    if (count($patients) > 0) {
        // Output patients as clickable div elements
        foreach ($patients as $patient) {
            echo '<div class="search-item" data-patient-id="' .$patient['patientID']  . '">' .ucwords($patient['patient_name'])  .' '.ucwords($patient['middle_name'])  . ' '.ucwords($patient['last_name'])  .'</div>';
        }
    } else {
        echo '<div class="search-item">No results found</div>';
    }
}

// if (isset($_POST['search'])) {
//     $searchTerm = $_POST['search'];
    
// $query = "
//     SELECT 
//         users.patientID AS id,
//         CONCAT(users.patient_name, ' ', users.middle_name, ' ', users.last_name) AS name,
//         'patient' AS type
//     FROM 
//         tbl_patients AS users
//     WHERE 
//         users.patient_name LIKE :search 
//         OR users.middle_name LIKE :search 
//         OR users.last_name LIKE :search

//     UNION ALL

//     SELECT 
//         fm.member_id AS id,
//         fm.name AS name,
//         'family_member' AS type
//     FROM 
//         tbl_family_members AS fm
//     WHERE 
//         fm.name LIKE :search
//     ORDER BY 
//         name ASC";


//     $stmt = $con->prepare($query);
//     $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
//     $stmt->execute();
//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//   if (count($results) > 0) {
//     foreach ($results as $result) {
//         echo '<div class="search-item" data-id="' . $result['id'] . '" data-type="' . $result['type'] . '">'
//             . htmlspecialchars($result['name']) . '</div>';
//     }
// } else {
//     echo '<div class="search-item">No results found</div>';
// }

// }


