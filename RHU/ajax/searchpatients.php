<?php
include '../config/connection.php';

// if (isset($_POST['searchTerm'])) {
//     $searchTerm = $_POST['searchTerm'];
//     $query = "SELECT users.patientID, users.patient_name, users.middle_name, users.last_name
//               FROM tbl_patients AS users 
//               WHERE users.patient_name LIKE :searchTerm 
//                  OR users.gender LIKE :searchTerm 
//                  OR users.phone_number LIKE :searchTerm
//               ORDER BY users.patient_name ASC";

//     $stmtUsers = $con->prepare($query);
 
//     $stmtUsers->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
//     $stmtUsers->execute();

//     $patients = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

//     if (count($patients) > 0) {
//         // Output patients as options
//         foreach ($patients as $patient) {
//             echo '<option value="' . $patient['patientID'] . '">' . $patient['patient_name'] .' '. $patient['middle_name'] . ' '. $patient['last_name'] .'</option>';
//         }
//     } else {
//         echo '<option value="0">No results found</option>';
//     }
// }
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $query = "SELECT users.patientID, users.patient_name, users.middle_name, users.last_name
              FROM tbl_patients AS users 
              WHERE users.patient_name LIKE :search 
                 OR users.middle_name LIKE :search 
                 OR users.last_name LIKE :search
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
?>

