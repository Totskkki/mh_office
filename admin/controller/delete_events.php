<?php
include '../config/connection.php';
include '../common_service/common_functions.php';

if (isset($_POST['deleteid'])) {
    $id = $_POST['deleteid'];
    $user_id = $_SESSION['admin_id'];

    try {
        $con->beginTransaction();

        // Fetch the current values before deletion for audit logging
        $selectQuery = "SELECT * FROM tbl_announcements WHERE announceID = :id";
        $selectStmt = $con->prepare($selectQuery);
        $selectStmt->execute([':id' => $id]);
        $record = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            // Delete the record

            $affectedRecordName = getAffectedRecordName('tbl_announcements', $id, $con);

            $deleteQuery = "DELETE FROM tbl_announcements WHERE announceID = ?";
            $deleteStmt = $con->prepare($deleteQuery);
            $deleteStmt->execute([$id]);

           
            $userId = $_SESSION['admin_id']; 
            $action = "Delete Events";
            $description = "Deleted Events for $affectedRecordName";
            logAuditTrail($userId, $action, $description, 'tbl_announcements', $id, $con);

            $con->commit();

            $_SESSION['status'] = "Event successfully deleted.";
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

    header('location: ../events.php');
    exit();
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header('location: ../events.php');
    exit();
}
?>
