<?php
session_start();
include './config/connection.php';

$message = '';

if (isset($_POST['verify'])) {
  $userOtp = $_POST['otp'];
  if (isset($_SESSION['otp']) && $userOtp == $_SESSION['otp']) {
    $userId = $_SESSION['otp_user_id'];
    
    // Retrieve user details again
    $stmtUser = $con->prepare("SELECT user.*, personnel.*, position.*, user.UserType
                               FROM `tbl_users` AS user
                               INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                               INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
                               WHERE user.`userID` = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      completeLogin($user);
    } else {
      $message = 'Invalid user details.';
    }
  } else {
    $message = 'Incorrect OTP. Please try again.';
  }
}

function completeLogin($user) {
  $_SESSION['user_id'] = $user['userID'];
  $_SESSION['first_name'] = $user['first_name'];
  $_SESSION['last_name'] = $user['lastname'];
  $_SESSION['user_name'] = $user['user_name'];
  $_SESSION['profile_picture'] = $user['profile_picture'];
  $_SESSION['login'] = true;
  $_SESSION['status'] = "Login successful!";
  $_SESSION['status_code'] = "success";
  $_SESSION['user_type'] = $user['UserType'];

  logUserLogin($user['userID'], $user['user_name']);

  if ($user['UserType'] == 'RHU') {
    header("Location: RHU/dashboard-mho.php");
  } elseif ($user['UserType'] == 'BHW') {
    header("Location: home.php");
  } elseif ($user['UserType'] == 'admin') {
    header("Location: admin/dashboard.php");
  }
  exit;
}

function logUserLogin($userId, $username) {
  global $con;
  $userIp = $_SERVER['REMOTE_ADDR'];
  $status = 1;
  $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
  $stmtLog = $con->prepare($logQuery);
  $stmtLog->execute([$userId, $username, $userIp, $status]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Verify OTP</title>
  <link rel="stylesheet" href="assets/css/main.min.css" />
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
        <form method="post" class="my-5">
          <div class="bg-white rounded-3 p-4">
            <h2 class="my-3 text-center font-weight-bolder text-info text-gradient">VERIFY OTP</h2>
            <p class="login-box-msg text-center">Enter the OTP sent to your email</p>

            <div class="input-group mb-3">
              <input type="text" class="form-control form-control rounded-0" Required="required" placeholder="OTP" id="otp" name="otp">
            </div>
            <div class="d-grid py-3 mt-2">
              <button type="submit" name="verify" class="btn btn-lg" style="background-color: #808080;color:white">VERIFY</button>
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
</body>
</html>
