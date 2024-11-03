<?php

include './config/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = '';

if (isset($_POST['admin_login'])) {
  $userName = $_POST['user_name'];
  $password = $_POST['password'];

  // Hash the password (This should only be done when registering users, not when logging in)
  // $encryptedPassword = password_hash($password, PASSWORD_DEFAULT); // Not needed for login

  // Query to check if the user exists
  $query = "SELECT user.*, personnel.*, position.* 
  FROM `tbl_users` AS user
  INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
  INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
  WHERE user.`user_name` = ? LIMIT 1";
  $stmtLogin = $con->prepare($query);
  $stmtLogin->execute([$userName]);
  $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    // User found, now verify the password
    if (password_verify($password, $result['password']) && $result['UserType'] == 'admin') {
      // Password is correct and user is admin
      $_SESSION['admin_id'] = $result['userID'];
      $_SESSION['first_name'] = $result['first_name'];
      $_SESSION['last_name'] = $result['last_name'];
      $_SESSION['username'] = $result['user_name'];
      $_SESSION['profile_picture'] = $result['profile_picture'];
      $_SESSION['login'] = true;
      $_SESSION['UserType'] = 'Admin';

      $_SESSION['status'] = "Login successful!";
      $_SESSION['status_code'] = "success";

      // Log user login
      $admin_id = $result['userID'];
      $username = $result['user_name'];
      $user_ip = $_SERVER['REMOTE_ADDR'];
      $status = 1;

      $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
      $stmtLog = $con->prepare($logQuery);
      $stmtLog->execute([$admin_id, $username, $user_ip, $status]);

      header("location: dashboard.php");
      exit;
    } else {
      // Incorrect password or user is not an admin
      $message = 'Incorrect username or password.';
      
      $username = $userName;
      $user_ip = $_SERVER['REMOTE_ADDR'];
      $status = 0;

      // Log failed login attempt
      $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
      $stmtLog = $con->prepare($logQuery);
      $stmtLog->execute([$username, $user_ip, $status]);
    }
  } else {
    // No user found
    $message = 'No user found with this username.';
    
    $username = $userName;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $status = 0;

    // Log failed login attempt
    $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
    $stmtLog = $con->prepare($logQuery);
    $stmtLog->execute([$username, $user_ip, $status]);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Kalilintad Lutayan-Municipal Health Office</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../assets/fonts/icomoon/style.css" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="../assets/css/main.min.css" />

  <style>
    body {
      background: url('logo/test.png') fixed;
      background-size: cover;
      -webkit-background-size: cover;
      -moz-background-size: cover; 
      -o-background-size: cover;
      

    }

    .container {
      margin-top: 15%;
      margin-left: -15%;
    }

    .login-form-container {
      max-width: 200px;

    }
  </style>
</head>
<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>


<?php


}

?>

<body>
  <!-- Container start -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
        <form method="post" class="my-5">
          <div class="bg-white rounded-3 p-4">
            <div class="login-form">
              <!-- <a href="index.html" class="mb-4 d-flex">
									<img src="assets/images/logo-dark.svg" class="img-fluid login-logo" alt="AdminPro Admin Dashboard" />
								</a> -->

              <h2 class="my-3 text-center font-weight-bolder text-info text-gradient">WELCOME ADMIN</h2>
              <p class="login-box-msg text-center">Please enter your login credentials</p>

              <div class="input-group mb-3">
                <input type="text" class="form-control form-control rounded-0 autofocus" Required="required" placeholder="Username" id="user_name" name="user_name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fs-3 icon-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-2">
                <input type="password" class="form-control form-control rounded-0" Required="required" placeholder="Password" id="password" name="password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fs-3 icon-key"></span>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="form-check m-0">
                  <!-- <input class="form-check-input" type="checkbox" value="" id="rememberPassword" />
										<label class="form-check-label" for="rememberPassword">Remember</label> -->
                </div>
                <!-- <a href="#" class="text-info text-decoration-underline">Forget
                  password?</a> -->
              </div>
              <div class="row">


                <div class="d-grid py-3">
                  <button type="submit" name="admin_login" class="btn btn-lg " style="background-color: #808080;color:white">
                    LOGIN
                  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <p class="text-danger">
                    <?php
                    if ($message != '') {
                      echo $message;
                    }
                    ?>
                  </p>
                </div>
              </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Container end -->
</body>

</html>