<?php
include './config/connection.php';
include './common_service/common_functions.php';

$message = '';

if (isset($_POST['delete_doctor'])) {
    $doctor = $_POST['delete_doctor'];

    try {
        // Start a transaction
        $con->beginTransaction();

        $query = "DELETE FROM doctor WHERE id=:hidden_id";
        $statement = $con->prepare($query);
        $data = [':hidden_id' => $doctor];
        $query_execute = $statement->execute($data);

        if ($query_execute) {
            // Commit the transaction if the delete is successful
            $con->commit();
            
            $message = "Doctor deleted successfully!";
            header("Location: congratulation.php?goto_page=doctors.php&message=$message");
            exit;
        }
    } catch (PDOException $ex) {
        // Rollback the transaction on error
        $con->rollBack();
        
        // Log the error to a file or database for further investigation
        error_log("Error deleting doctor: " . $ex->getMessage());
        
        // Optionally, redirect to an error page
        header("Location: error.php");
        exit;
    }
}

// If execution reaches here, there was an issue
header("Location: error.php");
exit;
?>
