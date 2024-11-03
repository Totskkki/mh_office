<?php 
	include '../config/connection.php';

    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        $stmt = $con->prepare("SELECT COUNT(*) FROM tbl_users WHERE email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            echo 'exists';
        } else {
            echo 'available';
        }
    }
  
?>