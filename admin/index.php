<?php

include './config/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = '';

// if (isset($_POST['admin_login'])) {
//   $userName = $_POST['user_name'];
//   $password = $_POST['password'];



//   // Query to check if the user exists
//   $query = "SELECT user.*, personnel.*
//   FROM `tbl_users` AS user
//   INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
//   WHERE (user.`user_name` = ? OR personnel.`email` = ?) LIMIT 1";
//   $stmtLogin = $con->prepare($query);
//   $stmtLogin->execute([$userName,$userName]);
//   $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

//   if ($result) {
//     // User found, now verify the password
//     if (password_verify($password, $result['password']) && $result['UserType'] == 'admin') {
//       // Password is correct and user is admin
//       $_SESSION['admin_id'] = $result['userID'];
//       $_SESSION['first_name'] = $result['first_name'];
//       $_SESSION['last_name'] = $result['last_name'];
//       $_SESSION['username'] = $result['user_name'];
//       $_SESSION['profile_picture'] = $result['profile_picture'];
//       $_SESSION['login'] = true;
//       $_SESSION['UserType'] = 'admin';

//       $_SESSION['status'] = "Login successful!";
//       $_SESSION['status_code'] = "success";

//       // Log user login
//       $admin_id = $result['userID'];
//       $username = $result['user_name'];
//       $user_ip = $_SERVER['REMOTE_ADDR'];
//       $status = 1;

//       $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
//       $stmtLog = $con->prepare($logQuery);
//       $stmtLog->execute([$admin_id, $username, $user_ip, $status]);

//       header("location: dashboard.php");
//       exit;
//     } else {
//       // Incorrect password or user is not an admin
//       $message = 'Incorrect username or password.';
      
//       $username = $userName;
//       $user_ip = $_SERVER['REMOTE_ADDR'];
//       $status = 0;

//       // Log failed login attempt
//       $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
//       $stmtLog = $con->prepare($logQuery);
//       $stmtLog->execute([$username, $user_ip, $status]);
//     }
//   } else {
//     // No user found
//     $message = 'No user found with this username.';
    
//     $username = $userName;
//     $user_ip = $_SERVER['REMOTE_ADDR'];
//     $status = 0;

//     // Log failed login attempt
//     $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
//     $stmtLog = $con->prepare($logQuery);
//     $stmtLog->execute([$username, $user_ip, $status]);
//   }
// }

if (isset($_POST['admin_login'])) {
    $userName = $_POST['user_name'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $query = "SELECT user.*, personnel.*
              FROM `tbl_users` AS user
              INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
              WHERE (user.`user_name` = ? OR personnel.`email` = ?) LIMIT 1";

    $stmtLogin = $con->prepare($query);
    $stmtLogin->execute([$userName, $userName]);
    $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $userID = $result['userID'];
        $failedAttempts = (int) $result['failed_attempts'];
        $lockedUntil = isset($result['locked_until']) ? new DateTime($result['locked_until']) : null;
        $currentTime = new DateTime();
        $canLogin = true;

        // Check if account is locked
        if ($lockedUntil && $currentTime < $lockedUntil) {
            $message = 'Account locked until ' . $lockedUntil->format('Y-m-d H:i:s') . '. Please try again later.';
            $canLogin = false;
        }

        if ($canLogin) {
            if ($result['status'] === 'Inactive') {
                $message = 'Your account is inactive.';
            } elseif ($result['UserType'] !== 'admin') { // Ensure only admin can log in
                $message = 'Access denied. Admin accounts only.';
            } elseif (password_verify($password, $result['password'])) {
             
                $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = 0, locked_until = NULL WHERE userID = ?");
                $stmtUpdate->execute([$userID]);

                // Set session variables
                session_start();
                $_SESSION['admin_id'] = $result['userID'];
                $_SESSION['first_name'] = $result['first_name'];
                $_SESSION['last_name'] = $result['last_name'];
                $_SESSION['username'] = $result['user_name'];
                $_SESSION['profile_picture'] = $result['profile_picture'];
                $_SESSION['UserType'] = 'admin';
                $_SESSION['login'] = true;
                $_SESSION['status'] = "Login successful!";
                $_SESSION['status_code'] = "success";

                // Log user login
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
                $stmtLog = $con->prepare($logQuery);
                $stmtLog->execute([$userID, $result['user_name'], $user_ip, 1]);

                header("Location: dashboard.php");
                exit;
            } else {
                // Incorrect password
                $failedAttempts++;
                $lockoutDuration = $failedAttempts >= 3 ? '+3 minutes' : null;
                $lockedUntilTime = $lockoutDuration ? (clone $currentTime)->modify($lockoutDuration)->format('Y-m-d H:i:s') : null;

                $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = ?, locked_until = ? WHERE userID = ?");
                $stmtUpdate->execute([$failedAttempts, $lockedUntilTime, $userID]);

                $message = $failedAttempts >= 3
                    ? 'Too many failed attempts. Account temporarily locked for 3 minutes.'
                    : 'Incorrect username or password.';

                // Log failed login attempt
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `login_time`, `status`) VALUES (?, ?, NOW(), 0)";
                $stmtLog = $con->prepare($logQuery);
                $stmtLog->execute([$userName, $user_ip]);
            }
        }
    } else {
        $message = 'No user found with this username or email.';
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
    <link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css" />

  <style>
    body {
      background: url('logo/test.png') fixed;
      background-size: cover;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
    }

    .container-fluid {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .left-section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px; /* Adjust padding for better spacing */
    }

    .right-section {
      flex: 1;
    }

    .login-box {
      width: 400px;
      max-width: 400px; /* Adjust the maximum width of the login box */
      background: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .login-box h2 {
      text-align: center;
      font-weight: bold;
      color: #17a2b8;
      margin-bottom: 30px;
      font-size: 1.8rem;
    }

    .btn-login {
      background-color: #B20303;
      color: white;
      font-weight: bold;
      font-size: 1.1rem;
    }

    .btn-login:hover {
      background-color: #7A3242;
    }

    .input-group-text {
      background-color: #f8f9fa;
    }

    .text-gradient {
      background: linear-gradient(to right, #B20303, #B20303);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .form-control {
      font-size: 1.1rem;
      padding: 10px;
    }

    .input-group {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <!-- Full-Width Container -->
  <div class="container-fluid">
    <!-- Left Section -->
    <div class="left-section">
      <form method="post" id="loginUser">
        <div class="login-box">
          <h2 class="text-gradient">WELCOME ADMIN</h2>
          <p class="text-center">Please enter your login credentials</p>

         
          <div class="input-group mb-3">
            <input type="text" class="form-control rounded-0" required="required" placeholder="Username" id="user_name" name="user_name">
            <div class="input-group-append">
              <div class="input-group-text" style="width:100%;height:100%">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <!--<div class="input-group mb-3">-->
          <!--  <input type="password" class="form-control rounded" required="required" placeholder="Password" id="password" name="password">-->
          <!--  <div class="input-group-append">-->
          <!--    <div class="input-group-text" style="width:100%;height:100%">-->
          <!--      <span class="fs-3 icon-key"></span>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
           <div class="input-group mb-3">
          <!-- Password Input -->
          <input type="password" 
                 class="form-control rounded-0" 
                 required="required" 
                 placeholder="Password" 
                 id="password" 
                 name="password">
        
          <!-- Key Icon (Hidden When Typing) -->
          <div class="input-group-append" id="keyContainer">
            <div class="input-group-text" style="width:100%;height:100%">
              <span class="fas fa-key"></span>
            </div>
          </div>
        
          <!-- Eye Icon (Visible Only When Typing) -->
          <div class="input-group-append" id="eyeContainer" style="display: none;">
            <div class="input-group-text" style="cursor: pointer;">
              <span class="fas fa-eye" id="togglePasswordIcon"></span>
            </div>
          </div>
        </div>



          <div class="row">
            <div class="d-grid py-3 mt-2">
              <button type="submit" name="admin_login" class="btn btn-lg btn-login">
                LOGIN
              </button>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <p class="text-danger font-weight-bold">
                <?php if ($message != '') echo $message; ?>
              </p>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Right Section (Empty space for now) -->
    <div class="right-section">
      <!-- Right section can be used for other content if needed -->
    </div>
  </div>
</body>


<script>
// Select the necessary elements
const passwordInput = document.getElementById('password');
const keyContainer = document.getElementById('keyContainer');
const eyeContainer = document.getElementById('eyeContainer');
const togglePasswordIcon = document.getElementById('togglePasswordIcon');

// Show or hide the icons based on input
passwordInput.addEventListener('input', function () {
  if (passwordInput.value.trim() !== '') {
    keyContainer.style.display = 'none'; // Hide key icon
    eyeContainer.style.display = 'flex'; // Show eye icon container
  } else {
    keyContainer.style.display = 'flex'; // Show key icon
    eyeContainer.style.display = 'none'; // Hide eye icon container
  }
});

// Toggle password visibility on eye icon click
togglePasswordIcon.addEventListener('click', function () {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text'; // Show password as text
    togglePasswordIcon.classList.remove('fa-eye');
    togglePasswordIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password'; // Hide password
    togglePasswordIcon.classList.remove('fa-eye-slash');
    togglePasswordIcon.classList.add('fa-eye');
  }
});
</script>

</html>
