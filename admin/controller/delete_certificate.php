<?php
include './config/connection.php';

if (isset($_POST['delete_certificate'])) {
    $patientId = $_POST['delete_certificate'];

    try {
        $query = "DELETE FROM med_cert_info WHERE id = :Id";
        $statement = $con->prepare($query);
        $statement->bindParam(':Id', $patientId, PDO::PARAM_INT);
        $query_execute = $statement->execute();

        if ($query_execute) {
            // Optionally, you can redirect to a page with a success message
            header("Location: congratulation.php?goto_page=medical_certificates.php&message=Certificate deleted successfully!");
            exit;
        }
    } catch (PDOException $ex) {
        // Log the error to a file or database for further investigation
        error_log("Error deleting certificate: " . $ex->getMessage());
        
        // Optionally, redirect to an error page
        header("Location: error.php");
        exit;
    }
}

// If execution reaches here, there was an issue
header("Location: error.php");
exit;
?>
