
<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

if (isset($_POST['save_complaints'])) {
  try {
   
    $patientid = trim($_POST['hidden_id']);
    $Complaint = trim($_POST['Complaint']);
    $remarks = trim($_POST['remarks']);
    $bp = trim($_POST['bp']);
    $hr = trim($_POST['hr']);
    $weight = trim($_POST['weight'] . "kg");
    $rr = trim($_POST['rr']);
    $Temp = $_POST['Temp'] . "°C";
    $Height = trim($_POST['Height']);
    $Nature_visit = trim($_POST['Nature_visit']);
    $cp_visit = trim($_POST['cp_visit']);
    $Refferred = trim($_POST['Refferred']);


    $query = $con->prepare("SELECT * FROM `tbl_patients` WHERE `patientID` = :id");
    $query->bindParam(':id', $patientid, PDO::PARAM_INT);
    $query->execute();
    $patient = $query->fetch(PDO::FETCH_ASSOC);


    if (
      $Complaint != '' && $remarks != '' &&
      $bp != '' && $hr != '' && $weight != '' &&  $rr != ''
    ) {
    

  
    if (($cp_visit == "Prenatal" || $cp_visit == "Maternity") && ($patient['gender'] == "Male")) {
      $_SESSION['status'] = "Invalid section for male patient.";
      $_SESSION['status_code'] = "error";
    }
    $query = "INSERT INTO `tbl_complaints`(`patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`,`Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `status`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 'Pending')";
    $con->beginTransaction();
    $stmt = $con->prepare($query);
    $stmt->execute([$patientid, $Complaint, $remarks, $bp, $hr, $weight, $rr, $Temp, $Height, $Nature_visit, $cp_visit, $Refferred]);
    $con->commit();

    $message = 'Patient complaint added successfully.';
    $_SESSION['status'] = "Patient complaint added successfully.";
    $_SESSION['status_code'] = "success";
 
}
} catch (PDOException $ex) {
  $con->rollback();
  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}

echo "<script>window.location.href = 'page_done.php';</script>";

exit;
}


?>