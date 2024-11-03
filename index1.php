<?php
include './config/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');
date_default_timezone_set('Asia/Manila');


$message = '';


if (isset($_POST['login'])) {
  $loginInput = $_POST['user_name']; 
  $password = $_POST['password'];


  $stmtLogin = $con->prepare("SELECT user.*, personnel.*, position.*, user.UserType
                              FROM `tbl_users` AS user
                              LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                              LEFT JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
                              WHERE user.`user_name` = ? OR personnel.`email` = ? LIMIT 1");
  $stmtLogin->execute([$loginInput, $loginInput]);
  $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

  if ($result) {
      $userID = $result['userID'];
      $failedAttempts = isset($result['failed_attempts']) ? (int) $result['failed_attempts'] : 0;
      $lastAttemptTime = isset($result['last_attempt_time']) ? new DateTime($result['last_attempt_time']) : new DateTime();

      $currentTime = new DateTime();
      $lockoutTime = 5 * 60; 

      if ($failedAttempts >= 3 && ($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < $lockoutTime) {
          $message = 'Account locked. Please try again after 5 minutes.';
      } else {
          if (password_verify($password, $result['password'])) {

          
             session_regenerate_id(true);
              
              $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = 0, last_attempt_time = NULL WHERE userID = ?");
              $stmtUpdate->execute([$userID]);

            
              $_SESSION['user_id'] = $result['userID'];
              $_SESSION['first_name'] = $result['first_name'];
              $_SESSION['last_name'] = $result['lastname'];
              $_SESSION['user_name'] = $result['user_name'];
              $_SESSION['profile_picture'] = $result['profile_picture'];
              $_SESSION['login'] = true;
              $_SESSION['status'] = "Login successful!";
              $_SESSION['status_code'] = "success";

              // Log user login
              $user_ip = $_SERVER['REMOTE_ADDR'];
              $status = 1;
              $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
              $stmtLog = $con->prepare($logQuery);
              $stmtLog->execute([$userID, $result['user_name'], $user_ip, $status]);

          
              if (!isset($_SESSION['user_type'])) {
                  $_SESSION['user_type'] = $result['UserType'];
              }

              // Redirect based on user type
              if ($_SESSION['user_type'] == 'RHU') {
                  header("location: RHU/dashboard-mho.php");
                  exit;
              } elseif ($_SESSION['user_type'] === 'BHW') {
                  header("location: home.php");
                  exit;
              } elseif ($_SESSION['user_type'] === 'admin') {
                  header("location: admin/dashboard.php");
                  exit;
              }
          } else {
              // Increment failed attempts and update last attempt time
              $failedAttempts++;
              $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = ?, last_attempt_time = NOW() WHERE userID = ?");
              $stmtUpdate->execute([$failedAttempts, $userID]);

              $message = $failedAttempts >= 3 ? 'Account temporarily locked. Please try again after 5 minutes.' : 'Incorrect username or password.';
              
              // Log failed login attempt
              $user_ip = $_SERVER['REMOTE_ADDR'];
              $status = 0;
              $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
              $stmtLog = $con->prepare($logQuery);
              $stmtLog->execute([$loginInput, $user_ip, $status]);
          }
      }
  } else {
      $message = 'Incorrect username or password.';
  }
}


if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    if ($_SESSION['user_type'] === 'RHU') {
        header("location: RHU/dashboard-mho.php");
        exit;
    } elseif ($_SESSION['user_type'] === 'BHW') {
        header("location: home.php");
        exit;
    } elseif ($_SESSION['user_type'] === 'admin') {
        header("location: admin/dashboard.php");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>

  <!-- Icomoon Font Icons css -->
  <link rel="stylesheet" href="assets/fonts/icomoon/style.css" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="assets/css/main.min.css" />

  <style>
    body {
      /* background-image: linear-gradient(to right, #004000, #ffffff); */
      background: url('logo/untitled.png') fixed;
      background-size: cover;
      -webkit-background-size: cover;
      -moz-background-size: cover; 
      -o-background-size: cover;
    }

    .container {
      margin-top: 5rem;
    }

    .input-group input:invalid {
        border-color: #dc3545;
    }
    
    .input-group input:valid {
        border-color: #28a745;
    }

    .invalid-feedback {
        display: none;
    }

    .input-group input:invalid + .invalid-feedback {
        display: block;
    }
    .is-invalid {
    border-color: #dc3545;
  }

  .invalid-feedback {
    display: block; 
    color: #dc3545;
  }
  </style>
</head>

<body>
  <!-- Container start -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
        <form method="post" class="my-5" novalidate id="loginUser">
          <div class="bg-white rounded-3 p-4">
            <div class="login-form">
              <h2 class="my-3 text-center font-weight-bolder text-info text-gradient">WELCOME USER</h2>
              <p class="login-box-msg text-center">Please enter your login credentials</p>

              <div class="input-group mb-3">
                <input type="text" class="form-control form-control rounded-0 autofocus" required="required" placeholder="Username or Email" id="user_name" name="user_name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fs-3 icon-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control form-control rounded-0" required="required" placeholder="Password" required minlength="6" id="password" name="password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fs-3 icon-key"></span>
                  </div>
                </div>
                <!-- <div class="invalid-feedback">Your password is too short</div> -->
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="form-check m-0">
                </div>
              </div>
              <div class="row">
                <div class="d-grid py-3 mt-2">
                  <button type="submit" name="login" class="btn btn-lg " style="background-color: #808080;color:white">
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
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const invalidFeedback = document.querySelector('.invalid-feedback');
    const form = document.getElementById('loginUser');

    // Initially hide the feedback message
    invalidFeedback.style.display = 'none';

    // Function to validate password length
    function validatePassword() {
      if (passwordInput.value.length < 6) {
        invalidFeedback.style.display = 'block'; // Show error message
        passwordInput.classList.add('is-invalid');
      } else {
        invalidFeedback.style.display = 'none'; // Hide error message
        passwordInput.classList.remove('is-invalid');
      }
    }

    // Listen for input events on the password field
    passwordInput.addEventListener('input', validatePassword);

    // Optional: Validate on form submit
    form.addEventListener('submit', function(event) {
      if (passwordInput.value.length < 6) {
        validatePassword();
        event.preventDefault(); // Prevent form submission
      }
    });
  });
</script>



  <!-- Container end -->
</body>
</html>
