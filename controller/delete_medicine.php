<?php
include './config/connection.php';
include './common_service/common_functions.php';

if (isset($_POST['delete_medicine'])) {
    $medicines = $_POST['delete_medicine'];

    try {
        $query = "DELETE FROM medicines WHERE id=$medicines";
        $statement = $con->prepare($query);
        $query_execute = $statement->execute($data);

        if ($query_execute) {
            // Redirect with a success message
            header("Location: congratulation.php?goto_page=medicines.php&message=Medicines deleted successfully!");
            exit;
        }
    } catch (PDOException $ex) {
        // Log the error to a file or database for further investigation
        error_log("Error deleting medicines: " . $ex->getMessage());
        
        // Optionally, redirect to an error page
        header("Location: error.php");
        exit;
    }
}

// If execution reaches here, there was an issue
header("Location: error.php");
exit;
?>
