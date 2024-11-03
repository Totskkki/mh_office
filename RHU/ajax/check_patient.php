<?php 
	// include '../config/connection.php';

  // $patient_name = $_GET['patient_name'];
  // // $household_no = $_GET['household_no'];
  
  // // Assuming connection to database is $con
  // $query = "SELECT COUNT(*) AS `count` FROM `tbl_patients` 
  //           WHERE `patient_name` = :patient_name ";
  // $stmt = $con->prepare($query);
  // $stmt->bindParam(':patient_name', $patient_name);
  // // $stmt->bindParam(':household_no', $household_no);
  // $stmt->execute();
  
  // $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // $count = $result['count'];
  
  // echo $count;

include '../config/connection.php';

$patient_name = $_GET['patient_name'];
$last_name = $_GET['last_name'];

// Query to check if the combination of first name and last name already exists
$query = "SELECT COUNT(*) AS `count` FROM `tbl_patients` 
          WHERE `patient_name` = :patient_name AND `last_name` = :last_name";
$stmt = $con->prepare($query);
$stmt->bindParam(':patient_name', $patient_name);
$stmt->bindParam(':last_name', $last_name);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $result['count'];

echo $count;
?>


