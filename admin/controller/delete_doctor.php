<?php
include '../config/connection.php';

if (isset($_POST['deletehf'])) {
    $deleteId = $_POST['deleteid'];
    $personnelid = $_POST['personnelid'];
    $positionid = $_POST['positionid']; 

    try {
        $con->beginTransaction();

        // Delete from tbl_personnel first
        $deletePersonnelQuery = "DELETE FROM tbl_personnel WHERE personnel_id = :personnelid";
        $stmtPersonnel = $con->prepare($deletePersonnelQuery);
        $stmtPersonnel->bindParam(':personnelid', $personnelid, PDO::PARAM_INT);
        $stmtPersonnel->execute();

        // Delete from tbl_position
        $deletePositionQuery = "DELETE FROM tbl_position WHERE position_id = :positionid";
        $stmtPosition = $con->prepare($deletePositionQuery);
        $stmtPosition->bindParam(':positionid', $positionid, PDO::PARAM_INT);
        $stmtPosition->execute();

        // Delete from tbl_users last
        $deleteUserQuery = "DELETE FROM tbl_users WHERE userID = :deleteId";
        $stmtUser = $con->prepare($deleteUserQuery);
        $stmtUser->bindParam(':deleteId', $deleteId, PDO::PARAM_INT);
        $stmtUser->execute();

        $con->commit();
        $_SESSION['status'] = "User and related data deleted successfully";
        $_SESSION['status_code'] = "success";
    } catch (PDOException $e) {
        $con->rollBack();
        $_SESSION['status'] = "Failed to delete user: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    header('location: ../doctor.php');
    exit();
} else {
    exit('Required data not submitted.');
}
?>
