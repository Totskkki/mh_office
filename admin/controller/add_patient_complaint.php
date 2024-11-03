

<?php


$message = '';
if (isset($_POST['save_complaints'])) {
  try {
    // Sanitize and validate input data
    $patientid = trim($_POST['hidden_id']);
    $Complaint = trim($_POST['Complaint']);
    $remarks = trim($_POST['remarks']);
    $bp = trim($_POST['bp']);
    $hr = trim($_POST['hr']);
    $weight = trim($_POST['weight']."kg");
    $rr = trim($_POST['rr']);
    $Temp = $_POST['Temp'] . "°C";
    $Height = trim($_POST['Height']);
    $Nature_visit = trim($_POST['Nature_visit']);
    $cp_visit = trim($_POST['cp_visit']);
    $Refferred = trim($_POST['Refferred']);

    // Check if all required fields are filled
    if (
      $Complaint != '' && $remarks != '' &&
      $bp != '' && $hr != '' && $weight != '' &&  $rr != ''
    ) {
    

    // Prepare and execute the SQL query
    $query = "INSERT INTO `complaints`(`patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`,`Height`, `Nature_Visit`, `consult_pur`, `refferred`, `status`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 'Pending')";
    $con->beginTransaction();
    $stmt = $con->prepare($query);
    $stmt->execute([$patientid, $Complaint, $remarks, $bp, $hr, $weight, $rr, $Temp,$Height, $Nature_visit, $cp_visit, $Refferred]);
    $con->commit();

    $message = 'Patient complaint added successfully.';

    // Redirect after successful submission
   header('location=../patient_list.php'.$message);
    // echo ("<script> location.replace('./patient_list.php');</script>");
    exit; // Terminate script execution after redirection
} else {
    // Handle case where required fields are not filled
    $message = 'Please fill in all required fields.';
}
} catch (PDOException $ex) {
// Handle PDO exception
$message = 'An error occurred while processing the request. Please try again later.';
echo $ex->getMessage(); // Output error message for debugging
echo $ex->getTraceAsString(); // Output stack trace for debugging
exit; // Terminate script execution
}
}



?>