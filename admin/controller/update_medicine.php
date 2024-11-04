<?php
include '../config/connection.php';
include '../common_service/common_functions.php';
if(isset($_POST['update_meds'])){

    $medid = $_POST['medicineID'];
    
    $name =  trim($_POST['name']);
    $name =  ucwords(strtolower($name));


    $description =  trim($_POST['des']);
    $description =  ucwords(strtolower($description));

    $Category =  trim($_POST['Cat']);
    $Category =  ucwords(strtolower($Category));

    $supplier =  trim($_POST['supp']);
    $supplier =  ucwords(strtolower($supplier));

    $manuf =  trim($_POST['manuf']);
    $manuf =  ucwords(strtolower($manuf));
    $brand =  trim($_POST['brand']);
    $brand =  ucwords(strtolower($brand));

    $mandate = trim($_POST['mandate']);
    $dateArr = explode("/", $mandate);
    $mandate = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

    $expdate = trim($_POST['expdate']);
    $dateArr = explode("/", $expdate);
    $expdate = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

  

    if ($name != '' && $mandate != '' && $expdate != '') {
        // Construct the data array
        $updateData = [
            'medicine_name' => $name,
            'description' => $description,
            'supplier' => $supplier,
            'category' => $Category,
            'manuf_date' => $mandate,
            'ex_date' => $expdate,
            'manufacturer' => $manuf,
            'brand' => $brand
        ];

        // Update the medicine
        $result = update('tbl_medicines', 'medicineID', $medid, $updateData, $con);


        $affectedRecordName = getAffectedRecordName('tbl_medicines', $medid, $con);

     
        $userId = $_SESSION['admin_id']; 
        $action = "Updated Medicine,";
        $description = "Updated Medicine,  $affectedRecordName";

        logAuditTrail($userId, $action, $description, 'tbl_medicines', $medid, $con);

        // Check if update was successful
        if ($result) {
            $_SESSION['status'] = "Medicine successfully updated.";
            $_SESSION['status_code'] = "success";
            header('location: ../medicine.php');
            exit();
        } else {
            $_SESSION['status'] = "Something went wrong while updating medicine.";
            $_SESSION['status_code'] = "error";
            header('location: ../medicine.php');
            exit();
        }
    }
}

?>