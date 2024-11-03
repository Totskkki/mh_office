<?php 
	include '../config/connection.php';

  $patient = $_GET['patient_name'];

  $query = "select count(*) as `count` from `tbl_patients` 
	where `patient_name` = '$patient';";
  $stmt = $con->prepare($query);
  $stmt->execute();

$r = $stmt->fetch(PDO::FETCH_ASSOC);
  $count = $r['count'];
  
  echo $count;

?>