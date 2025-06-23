<?php
include '../config/connection.php';

try {
    // Sanitize and validate input
    $patient_name = htmlspecialchars(trim($_GET['patient_name']));
    $middle_name = htmlspecialchars(trim($_GET['middle_name']));
    $last_name = htmlspecialchars(trim($_GET['last_name']));

    // Query to check for duplicates
    $query = "SELECT COUNT(*) AS `count` FROM `tbl_patients` 
              WHERE `patient_name` = :patient_name AND `middle_name` = :middle_name AND `last_name` = :last_name";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':patient_name', $patient_name);
    $stmt->bindParam(':middle_name', $middle_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    echo $count; // Return the count to the frontend
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Return error message
}
?>

