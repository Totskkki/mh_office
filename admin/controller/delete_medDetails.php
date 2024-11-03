<?php
include '../config/connection.php';

if (isset($_POST['deleteid'])) {
    $id = $_POST['deleteid'];
    $user_id = $_SESSION['admin_id'];

    try {
        $con->beginTransaction();

        // Fetch the current values before deletion for audit logging
        $selectQuery = "SELECT * FROM tbl_medicine_details WHERE med_detailsID = :id";
        $selectStmt = $con->prepare($selectQuery);
        $selectStmt->execute([':id' => $id]);
        $record = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            // Delete the record
            $deleteQuery = "DELETE FROM tbl_medicine_details WHERE med_detailsID = ?";
            $deleteStmt = $con->prepare($deleteQuery);
            $deleteStmt->execute([$id]);

            // Prepare old values for audit log
            $old_value = json_encode($record);

            // Insert into audit log
            $auditQuery = "INSERT INTO tbl_audit_log (user_id, action, table_name, record_id, old_value) VALUES (?, 'DELETE', 'tbl_medicine_details', ?, ?)";
            $auditStmt = $con->prepare($auditQuery);
            $auditStmt->execute([$user_id, $id, $old_value]);

            $con->commit();

            $_SESSION['status'] = "Medicine Stock successfully deleted.";
            $_SESSION['status_code'] = "success";
        } else {
            // If no record is found with the given ID
            $_SESSION['status'] = "Event not found.";
            $_SESSION['status_code'] = "error";
        }
    } catch (Exception $e) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
    }

    header('location: ../medicine_details.php');
    exit();
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header('location: ../medicine_details.php');
    exit();
}
?>
