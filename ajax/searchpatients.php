<?php
include '../config/connection.php';

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT users.patientID, users.patient_name, users.middle_name,users.last_name
              FROM tbl_patients AS users 
              WHERE users.userID = :user_id
              AND (users.patient_name LIKE :searchTerm OR users.gender LIKE :searchTerm OR users.phone_number LIKE :searchTerm)
              ORDER BY users.patient_name ASC";

    $stmtUsers = $con->prepare($query);
    $stmtUsers->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtUsers->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmtUsers->execute();

    $patients = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    if (count($patients) > 0) {
        // Output patients as clickable div elements
        foreach ($patients as $patient) {
            echo '<div class="search-item" data-patient-id="' . $patient['patientID'] . '">' . $patient['patient_name'] .' '. $patient['middle_name'] . ' '. $patient['last_name'] .'</div>';
        }
    } else {
        echo '<div class="search-item">No results found</div>';
    }
}
?>



