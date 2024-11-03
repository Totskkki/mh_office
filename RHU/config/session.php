<?php

// if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['user_type'] === 'BHW') {
//         // Redirect to BHW dashboard
//         header("location: ../home.php");
//         exit;
//     }

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Securely regenerate the session ID if necessary
if (!isset($_SESSION['initiated'])) {
  session_regenerate_id(true);
  $_SESSION['initiated'] = true;
}

// Periodically regenerate the session ID (e.g., every 5 minutes)
if (!isset($_SESSION['last_regenerate'])) {
  $_SESSION['last_regenerate'] = time();
} elseif (time() - $_SESSION['last_regenerate'] > 300) { // 300 seconds = 5 minutes
  // session_regenerate_id(true);
  $_SESSION['last_regenerate'] = time();
}

if ($_SESSION['user_type'] === 'Admin') {
        header("location: ../admin/dashboard.php");
        exit;
      } else if ($_SESSION['user_type'] === 'BHW') {
      
        header("location: ../home.php");
        exit;
      }
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}



$sql = "SELECT user.*, personnel.*, position.*, user.UserType AS UserType 
        FROM `tbl_users` AS user
        INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
        INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
        WHERE user.`userID` = :user_id";

$stmt = $con->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);



?>