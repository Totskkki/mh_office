<?php
include '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['deleteid'])) {
    $deleteId = $_POST['deleteid'];

    try {
      
        $con->beginTransaction();

        $deleteUserQuery = "DELETE FROM tbl_users WHERE userID = $deleteId";
        $con->exec($deleteUserQuery);

        $deletePersonnelQuery = "DELETE FROM tbl_personnel WHERE personnel_id NOT IN (SELECT personnel_id FROM tbl_users)";
        $con->exec($deletePersonnelQuery);

        $deletePositionQuery = "DELETE FROM tbl_position WHERE position_id NOT IN (SELECT position_id FROM tbl_users)";
        $con->exec($deletePositionQuery);

        $con->commit();
        $_SESSION['status'] = "User and related data deleted successfully";
        $_SESSION['status_code'] = "success";
    } catch (PDOException $e) {
        $con->rollback();
        $_SESSION['status'] = "Failed to delete user: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    header('location: ../user.php');
    exit();
} else {
    exit('Required data not submitted.');
}
?>