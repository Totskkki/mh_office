<?php
include '../config/connection.php';
include '../common_service/common_functions.php';


if (isset($_POST['deleteid'])) {
    $id = $_POST['deleteid'];

    try {
        $con->beginTransaction();
  

        $affectedRecordName = getAffectedRecordName('tbl_doctor_schedule', $id, $con);
        // Delete from tbl_users
        $stmtdschedule = $con->prepare("DELETE FROM tbl_doctor_schedule WHERE doc_scheduleID  = ?");
        $stmtdschedule->execute([$id]);

        $userId = $_SESSION['admin_id']; 
        $action = "Delete Schedule";
        $description = "Deleted the schedule for Doctor $affectedRecordName";
        logAuditTrail($userId, $action, $description, 'tbl_doctor_schedule', $id, $con);

        $con->commit();

        $_SESSION['status'] = "Doctor Schdedule successfully deleted.";
        $_SESSION['status_code'] = "success";
    } catch (Exception $e) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
    }

    header('location: ../Doctor_schedule.php');
    exit();
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    header('location: ../Doctor_schedule.php');
    exit();
}  
?>