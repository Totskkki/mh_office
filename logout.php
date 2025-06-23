<?php
session_start();
include './config/connection.php';
date_default_timezone_set('Asia/Manila');
$ldate = date('d-m-Y h:i:s A', time());



if (isset($_SESSION['user_id'])) {

  $stmtUpdateLogout = $con->prepare("UPDATE tbl_user_log SET logout = :logout WHERE userID = :uid ORDER BY logID DESC LIMIT 1");
  $stmtUpdateLogout->bindParam(':logout', $ldate);
  $stmtUpdateLogout->bindParam(':uid', $_SESSION['user_id']);
  $stmtUpdateLogout->execute();

  $_SESSION = array();

  session_destroy();

  $_SESSION['errmsg'] = "You have successfully logged out.";
  header("Location: index.php");
  exit();
} else {

  $_SESSION['status'] = "You have successfully logged out";
  $_SESSION['status_code'] = "success";
  header("Location: index.php");
  exit();
}

// include './config/database.php';
// include './Models/Users.php';

// // Initialize the Database and User
// $db = new Database();
// $user = new User($db);

// // Call the logout function
// $user->logout();
?>
