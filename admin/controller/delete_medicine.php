<?php
include '../config/connection.php';
ob_start();
if (isset($_POST['delete_medicine'])) {
    $medicines = $_POST['delete_medicine'];

    
        $query = "DELETE FROM tbl_medicines WHERE medicineID=$medicines";
        $statement = $con->prepare($query);
        $query_execute = $statement->execute($data);

        if ($query_execute) {
            
             $_SESSION['status'] = "Medicine deleted successfully";
            $_SESSION['status_code'] = "warning";

            header('location:../medicine.php');
           
            exit();
        }
        
   else{
       
        $_SESSION['status'] = "Something went wrong.";
        $_SESSION['status_code'] = "error";
        header('location:../medicine.php');
           
            exit();
    }
}

?>
