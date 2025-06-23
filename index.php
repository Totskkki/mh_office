<?php
include './config/connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');


$message = '';

// if (isset($_POST['login'])) {
//   $loginInput = htmlspecialchars(trim($_POST['user_name']));
//   $password = htmlspecialchars(trim($_POST['password']));

//   if (empty($loginInput) || empty($password)) {
//     $message = "Username or password cannot be empty.";
//   } else {
//     // Query to fetch user data
//     $stmtLogin = $con->prepare("SELECT user.*, personnel.*, position.*, user.UserType, user.status as user_status
//                                 FROM `tbl_users` AS user
//                                 LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
//                                 LEFT JOIN `tbl_position` AS position ON position.position_id = user.position_id
//                                 WHERE (user.`user_name` = ? OR personnel.`email` = ?) 
//                                 AND user.UserType NOT IN ('admin','Doctor')
//                                 LIMIT 1");
//     $stmtLogin->execute([$loginInput, $loginInput]);
//     $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

//     if ($result) {
//       $userID = $result['userID'];
//       $failedAttempts = isset($result['failed_attempts']) ? (int) $result['failed_attempts'] : 0;
//       $lastAttemptTime = isset($result['last_attempt_time']) ? new DateTime($result['last_attempt_time']) : new DateTime();
//       $userStatus = $result['status'];

//       $currentTime = new DateTime();
//       $lockoutTime = 5 * 60;

//       if ($failedAttempts >= 3 && ($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < $lockoutTime) {
//         $message = 'Account locked. Please try again after 5 minutes.';
//       } else {
//         if ($userStatus === 'Inactive') {
//           $message = 'Your account is inactive. Please contact the administrator.';
//         } elseif (password_verify($password, $result['password'])) {
//           session_regenerate_id(true);

//           $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = 0, last_attempt_time = NULL WHERE userID = ?");
//           $stmtUpdate->execute([$userID]);

//           $_SESSION['user_id'] = $result['userID'];
//           $_SESSION['first_name'] = $result['first_name'];
//           $_SESSION['last_name'] = $result['lastname'];
//           $_SESSION['user_name'] = $result['user_name'];
//           $_SESSION['profile_picture'] = $result['profile_picture'];
//           $_SESSION['login'] = true;
//           $_SESSION['status'] = "Login successful!";
//           $_SESSION['status_code'] = "success";

//           // Log user login
//           $user_ip = $_SERVER['REMOTE_ADDR'];
//           $status = 1;
//           $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
//           $stmtLog = $con->prepare($logQuery);
//           $stmtLog->execute([$userID, $result['user_name'], $user_ip, $status]);

//           $_SESSION['user_type'] = $result['UserType'];
//           switch ($_SESSION['user_type']) {
//             case 'RHU':
//               header("Location: RHU/dashboard-mho.php");
//               exit();
//             case 'BHW':
//               header("Location: home.php");
//               exit();
//             default:
//               header("Location: index.php");
//               exit();
//           }
//         } else {
//           $failedAttempts++;
//           $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = ?, last_attempt_time = NOW() WHERE userID = ?");
//           $stmtUpdate->execute([$failedAttempts, $userID]);

//           $message = $failedAttempts >= 3 ? 'Account temporarily locked. Please try again after 5 minutes.' : 'Incorrect username or password.';

//           $user_ip = $_SERVER['REMOTE_ADDR'];
//           $status = 0;
//           $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
//           $stmtLog = $con->prepare($logQuery);
//           $stmtLog->execute([$loginInput, $user_ip, $status]);
//         }
//       }
//     } else {
//       $message = 'No user found with this username or email.';
//     }
//   }
// }

// if (isset($_POST['login'])) {
//     $loginInput = htmlspecialchars(trim($_POST['user_name']));
//     $password = htmlspecialchars(trim($_POST['password']));

//     if (empty($loginInput) || empty($password)) {
//         $message = "Username or password cannot be empty.";
//     } else {
//         // Query to fetch user data
//         $stmtLogin = $con->prepare("SELECT user.*, personnel.*, position.*, user.UserType, user.status as user_status
//                                     FROM `tbl_users` AS user
//                                     LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
//                                     LEFT JOIN `tbl_position` AS position ON position.position_id = user.position_id
//                                     WHERE (user.`user_name` = ? OR personnel.`email` = ?) 
//                                     AND user.UserType NOT IN ('admin','Doctor')
//                                     LIMIT 1");
//         $stmtLogin->execute([$loginInput, $loginInput]);
//         $result = $stmtLogin->fetch(PDO::FETCH_ASSOC);

//         if ($result) {
//             $userID = $result['userID'];
//             $failedAttempts = isset($result['failed_attempts']) ? (int) $result['failed_attempts'] : 0;
//             $lastAttemptTime = isset($result['last_attempt_time']) ? new DateTime($result['last_attempt_time'], new DateTimeZone('Asia/Manila')) : new DateTime('now', new DateTimeZone('Asia/Manila'));
//             $userStatus = $result['status'];
//             $lockedUntil = isset($result['locked_until']) ? new DateTime($result['locked_until'], new DateTimeZone('Asia/Manila')) : null;

//             $currentTime = new DateTime();
//             $lockoutTime = 3 * 60; // 3 minutes
//             $canLogin = true;

//             // Check for lockout condition
//             if ($lockedUntil && $currentTime < $lockedUntil) {
//                 $message = 'Account locked until ' . $lockedUntil->format('Y-m-d H:i:s') . '. Please try again later.';
//                 $canLogin = false;
//             }

//             if ($failedAttempts >= 3 && ($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < $lockoutTime) {
//                 $message = 'Account locked. Please try again after 3 minutes.';
//                 $canLogin = false;
//             }

//             if ($canLogin) {
//                 if ($userStatus === 'Inactive') {
//                     $message = 'Your account is inactive. Please contact the administrator.';
//                 } elseif (password_verify($password, $result['password'])) { 
                   

//                     // Reset failed attempts and lockout
//                     $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = 0, last_attempt_time = NOW(), locked_until = NULL WHERE userID = ?");
//                     $stmtUpdate->execute([$userID]);

//                     // Set session variables
//                     $_SESSION['user_id'] = $result['userID'];
//                     $_SESSION['first_name'] = $result['first_name'];
//                     $_SESSION['last_name'] = $result['lastname'];
//                     $_SESSION['user_name'] = $result['user_name'];
//                     $_SESSION['profile_picture'] = $result['profile_picture'];
//                     $_SESSION['login'] = true;
//                     $_SESSION['status'] = "Login successful!";
//                     $_SESSION['status_code'] = "success";

//                     // Log user login
//                     $user_ip = $_SERVER['REMOTE_ADDR'];
//                     $status = 1;
//                     $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `status`) VALUES (?, ?, ?, ?)";
//                     $stmtLog = $con->prepare($logQuery);
//                     $stmtLog->execute([$userID, $result['user_name'], $user_ip, $status]);

//                     $_SESSION['user_type'] = $result['UserType'];
//                     switch ($_SESSION['user_type']) {
//                         case 'RHU':
//                             header("Location: RHU/dashboard-mho.php");
//                             exit();
//                         case 'BHW':
//                             header("Location: home.php");
//                             exit();
//                         default:
//                             header("Location: index.php");
//                             exit();
//                     }
//                 } else {
//                     $failedAttempts++;
//                     $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = ?, last_attempt_time = NOW(), locked_until = IF(?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), NULL) WHERE userID = ?");
//                     $stmtUpdate->execute([$failedAttempts, $failedAttempts >= 3, $userID]);

//                     $message = $failedAttempts >= 3 ? 'Account temporarily locked. Please try again after 3 minutes.' : 'Incorrect username or password.';

//                     $user_ip = $_SERVER['REMOTE_ADDR'];
//                     $status = 0;
//                     $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `status`) VALUES (?, ?, ?)";
//                     $stmtLog = $con->prepare($logQuery);
//                     $stmtLog->execute([$loginInput, $user_ip, $status]);
//                 }
//             }
//         } else {
//             $message = 'No user found with this username or email.';
//         }
//     }
// }


if (isset($_POST['login'])) {
    $loginInput = htmlspecialchars(trim($_POST['user_name']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($loginInput) || empty($password)) {
        $message = "Username or password cannot be empty.";
    } else {
        // Query to fetch user data
        $stmtLogin = $con->prepare("SELECT user.*, personnel.*, position.*, user.UserType, user.status AS user_status
                                    FROM `tbl_users` AS user
                                    LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                                    LEFT JOIN `tbl_position` AS position ON position.position_id = user.position_id
                                    WHERE (user.`user_name` = ? OR personnel.`email` = ?) 
                                    AND user.UserType NOT IN ('admin', 'Doctor')
                                    LIMIT 1");
        $stmtLogin->execute([$loginInput, $loginInput]);
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
                if ($result['user_status'] === 'Inactive') {
                    $message = 'Your account is inactive. Please contact the administrator.';
                } elseif (password_verify($password, $result['password'])) {
                    // Login successful, reset failed attempts and lockout
                    $stmtUpdate = $con->prepare("UPDATE `tbl_users` SET failed_attempts = 0, locked_until = NULL WHERE userID = ?");
                    $stmtUpdate->execute([$userID]);

                    // Set session variables
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $userID;
                    $_SESSION['user_name'] = $result['user_name'];
                    $_SESSION['profile_picture'] = $result['profile_picture'];
                    $_SESSION['first_name'] = $result['first_name'];
                    $_SESSION['last_name'] = $result['lastname'];
                    $_SESSION['user_type'] = $result['UserType'];
                    $_SESSION['login'] = true;
                    $_SESSION['status'] = "Login successful!";
                    $_SESSION['status_code'] = "success";

                    // Log successful login
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $logQuery = "INSERT INTO `tbl_user_log` (`userID`, `username`, `user_ip`, `login_time`, `status`) VALUES (?, ?, ?, NOW(), 1)";
                    $stmtLog = $con->prepare($logQuery);
                    $stmtLog->execute([$userID, $result['user_name'], $user_ip]);

                    // Redirect based on user type
                    switch ($_SESSION['user_type']) {
                        case 'RHU':
                            header("Location: RHU/dashboard-mho.php");
                            exit();
                        case 'BHW':
                            header("Location: home.php");
                            exit();
                        default:
                            header("Location: index.php");
                            exit();
                    }
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

                    // Log failed attempt
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $logQuery = "INSERT INTO `tbl_user_log` (`username`, `user_ip`, `login_time`, `status`) VALUES (?, ?, NOW(), 0)";
                    $stmtLog = $con->prepare($logQuery);
                    $stmtLog->execute([$loginInput, $user_ip]);
                }
            }
        } else {
            $message = 'No user found with this username or email.';
        }
    }
}


if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
  switch ($_SESSION['user_type']) {
    case 'RHU':
      header("Location: RHU/dashboard-mho.php");
      exit();
    case 'BHW':
      header("Location: home.php");
      exit();
    case 'admin':
      header("Location: admin/dashboard.php");
      exit();
    default:
      header("Location: index.php");
      exit();
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
  <link rel="stylesheet" href="assets/fontawesome-free/css/all.min.css" />


  <style>
    body {
      background: url('logo/bgbackground.png') fixed;
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
    }

    .right-section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      width: 400px;
      max-width: 500px; 
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




   

    
    
</style>

</head>

<body>
  <!-- Full-Width Container -->
  <div class="container-fluid">
    <!-- Left Section -->
    <div class="container-fluid">
    <!-- Left Section -->
    <div class="left-section">
      <!-- This section remains empty for spacing -->
    </div>

    <!-- Right Section -->
    <div class="right-section">
      <form method="post" id="loginUser">
        <div class="login-box">
          <h2 class="text-gradient">WELCOME USER</h2>
          <p class="text-center">Please enter your login credentials</p>

          <div class="input-group mb-3">
            <input type="text" class="form-control rounded-0" required="required" placeholder="Username or Email" id="user_name" name="user_name">
            <div class="input-group-append">
              <div class="input-group-text" style="width:100%;height:100%">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <!--<div class="input-group mb-3">-->
          <!--  <input type="password" class="form-control rounded-0" required="required" placeholder="Password"  id="password" name="password">-->
          <!--  <div class="input-group-append">-->
          <!--    <div class="input-group-text" style="width:100%;height:100%">-->
          <!--      <span class="fs-3 icon-key" ></span>-->
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
              <button type="submit" name="login"id="loginButton" class="btn btn-lg btn-login">
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
