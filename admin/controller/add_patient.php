<?php

ob_start();

$message = '';

if (isset($_POST['save_Patient'])) {

  // echo "Form submitted";

  $patientName = trim($_POST['patient_name']);
  $patientName = ucwords(strtolower($patientName));
  $middle_name = trim($_POST['middle_name']);
  $last_name = trim($_POST['last_name']);
  $suffix = trim($_POST['suffix']);
  $family_no = trim($_POST['family_no']);
  $address = trim($_POST['address']);
  $address = ucwords(strtolower($address));
  $cnic = trim($_POST['cnic']);

  $dateBirth = trim($_POST['date_of_birth']);
  $dateArr = explode("/", $dateBirth);
  $dateBirth = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

  $phoneNumber = trim($_POST['phone_number']);

  $gender = isset($_POST['gender']) ? $_POST['gender'] : '';


  $Purok = trim($_POST['Purok']);
  $Nationality = trim($_POST['Nationality']);
  $ed_att = trim($_POST['ed_att']);
  $emp_stat = trim($_POST['emp_stat']);
  $status = trim($_POST['Status']);
  // $Weight = trim($_POST['Weight']);
  $Blood  = trim($_POST['Blood']);
  $philhealth  = trim($_POST['Philhealth']);
  $Phil_member  = trim($_POST['Phil_member']);
  $Phil_no  = trim($_POST['Phil_no']);
  $MemCat = isset($_POST['MemCat']) ? $_POST['MemCat'] : '';

  $Age = trim($_POST['Age']);

  if (
    $patientName != '' && $address != '' &&
    $cnic != '' && $dateBirth != '' && $phoneNumber != '' && $gender != ''
    && $Purok !== '' && $status !== '' && $Nationality !== ''
    && $Blood !== '' && $philhealth !== '' && $MemCat !== '' && $Age !== ''
  ) {
    // Check for duplicate patient name
    // Check for duplicate patient name
    $duplicateQuery = "SELECT COUNT(*) as count FROM patients WHERE patient_name = :patientName";
    $duplicateStatement = $con->prepare($duplicateQuery);
    $duplicateStatement->bindParam(':patientName', $patientName, PDO::PARAM_STR);

    if (!$duplicateStatement->execute()) {
      // Error executing the statement
      $errorInfo = $duplicateStatement->errorInfo();
      echo "Error executing duplicate query: " . $errorInfo[2];
      exit;
    }

    $duplicateResult = $duplicateStatement->fetch(PDO::FETCH_ASSOC);

    if ($duplicateResult['count'] > 0) {
      $message = 'Duplicate patient name found. Please choose a different name.';
     echo "<script>alert('Duplicate patient name found. Please choose a different name.');</script>";
    } else {
      // Proceed with the insertion
      // Your insertion code here...
      $query = "INSERT INTO `patients`( `patient_name`, `family_no`, `middle_name`,
    `last_name`, `suffix`, `address`, `purok`, `cnic`, `date_of_birth`, `age`, 
    `phone_number`, `gender`, `status`, `blood_type`, `phil_mem`, `philhealth_no`, 
    `phil_membership`, `ps_mem`, `ed_at`, `emp_stat`, `Nationality`)
         VALUES ('$patientName','$family_no', '$middle_name', '$last_name','$suffix','$address','$Purok',
          '$cnic','$dateBirth','$Age', '$phoneNumber', '$gender','$status',
         '$Blood', '$philhealth','$Phil_no', '$Phil_member','$MemCat', 
          '$ed_att', '$emp_stat', '$Nationality')";


      try {
        $con->beginTransaction();
        $stmtPatient = $con->prepare($query);
        $stmtPatient->execute();
        $lastInsertId = $con->lastInsertId(); // Get the ID of the last inserted record
        $con->commit();
        echo "<script>alert('Patient added successfully. You will be redirected to another page.');</script>";
        $message = 'Patient added successfully.';
        echo "<script>window.location.href = 'individual_treatment.php?id=$lastInsertId&message=$message';</script>";
        exit; // Exit to prevent further execution
      } catch (PDOException $ex) {
        $con->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        exit;
      }
    }
  }
}
