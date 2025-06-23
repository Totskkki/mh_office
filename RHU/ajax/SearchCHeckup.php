<?php
include '../config/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $query = "SELECT 
                  users.patientID, 
                  users.patient_name, 
                  users.middle_name, 
                  users.last_name, 
                    users.suffix, 
                  fm.*, 
                  checkup.*
              FROM 
                  tbl_patients AS users
              LEFT JOIN 
                  tbl_family_members fm ON fm.patient_id = users.patientID
              LEFT JOIN 
                  tbl_checkup checkup ON checkup.patient_id = users.patientID
              WHERE 
                  users.patient_name LIKE :search 
                  OR users.middle_name LIKE :search 
                  OR users.last_name LIKE :search 
                  OR users.suffix LIKE :search 
                  OR fm.name LIKE :search
              GROUP BY 
                  users.patientID
              ORDER BY 
                  users.patient_name DESC";

    $stmtUsers = $con->prepare($query);
    $stmtUsers->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmtUsers->execute();

    $patients = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    if (count($patients) > 0) {
        foreach ($patients as $patient) {
            echo '<div class="search-item" data-patient-id="' . htmlspecialchars($patient['patientID']) . '">'
    . ucwords(strtolower($patient['patient_name'])) . ' '
    . ucwords(strtolower($patient['middle_name'])) . ' '
    . ucwords(strtolower($patient['last_name'])) . ' '
    . ucwords(strtolower($patient['suffix'])) . 
    '</div>';

        }
    } else {
        echo '<div class="search-item">No results found</div>';
    }
}

