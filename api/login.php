<?php

// require_once 'database.php';


// $response = array();

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//     // $data = json_decode(file_get_contents("php://input"), true);
//     // // $username = $data['username'] ? $data['username'] : '';
//     // // $password = $data['password'] ? $data['password'] : '';

//     $user_name = $_POST['username'] ?? '';
//     $password = $_POST['password'] ?? '';


//     if (!empty($user_name) && !empty($password)) {

//         $db = new Database();
//         $conn = $db->getConnection();

//         // Prepare SQL query to fetch user data where UserType is 'Doctor'
//         $query = "SELECT u.*,p.*, pos.*
//                   FROM tbl_users u
//                   LEFT JOIN tbl_personnel p ON u.personnel_id = p.personnel_id
//                   LEFT JOIN tbl_position pos ON u.position_id = pos.position_id
//                   WHERE u.user_name = :username AND u.UserType = 'Doctor' AND u.status = 'active'";

//         $stmt = $conn->prepare($query);
//         $stmt->bindParam(':username', $user_name);
//         $stmt->execute();

//         if ($stmt->rowCount() > 0) {
//             // Fetch the user record
//             $user = $stmt->fetch(PDO::FETCH_ASSOC);

//             // Verify password
//             if (password_verify($password, $user['password'])) {


//                 $response['success'] = true;
//                 $response['message'] = "Login successful";
//                 $response['userID'] = $user['userID'];
//                 $response['profile_picture'] =  $user['profile_picture'];
//                 $response['first_name'] = $user['first_name'];
//                 $response['middlename'] = $user['middlename'];
//                 $response['lastname'] = $user['lastname'];
//                 $response['LicenseNo'] = $user['LicenseNo'];
//                 $response['Specialty'] = $user['Specialty'];
//                 $response['email'] = $user['email'];
//                 $response['ProfessionalType'] = $user['ProfessionalType'];
//                 $response['address'] = $user['address'];
//                 $response['personnel_id'] = $user['personnel_id'];
//                 $response['position_id'] = $user['position_id'];


//                 $response['user'] = array(
//                     'userID' => $user['userID'],
//                     'user_name' => $user['user_name'],
//                     'UserType' => $user['UserType'],
//                     'profile_picture' => $user['profile_picture'],
//                     'personnel_id' => $user['personnel_id'],
//                     'first_name' => $user['first_name'],
//                     'middlename' => $user['middlename'],
//                     'lastname' => $user['lastname'],
//                     'PositionName' => $user['PositionName'],
//                     'Specialty' => $user['Specialty'],
//                     'ProfessionalType' => $user['ProfessionalType'],
//                     'LicenseNo' => $user['LicenseNo'],
//                     'email' => $user['email'],
//                     'Specialty' => $user['Specialty'],
//                     'address' => $user['address'],
//                     'personnel_id' => $user['personnel_id'],
//                     'position_id' => $user['position_id']
//                 );

//                 $user_ip = $_SERVER['REMOTE_ADDR'];

//                 $status = 1;

//                 $logQuery = "INSERT INTO tbl_user_log (userID, username, user_ip, login_time, status)
//                              VALUES (:userID, :username, :user_ip, NOW(), 1)";
//                 $logStmt = $conn->prepare($logQuery);
//                 $logStmt->bindParam(':userID', $user['userID']);
//                 $logStmt->bindParam(':username', $user['user_name']);
//                 $logStmt->bindParam(':user_ip', $user_ip);
//                 $logStmt->bindParam(':user_ip', $status);
//                 $logStmt->execute();
//             } else {
//                 // Incorrect password
//                 $response['success'] = false;
//                 $response['message'] = "Incorrect username or password";

//                 $user_ip = $_SERVER['REMOTE_ADDR'];
//                 $status = 0;
//                 $logQuery = "INSERT INTO tbl_user_log (username, user_ip, login_time, status) 
//                              VALUES (:username, :user_ip, NOW(), :status)";
//                 $logStmt = $conn->prepare($logQuery);
//                 $logStmt->bindParam(':username', $username);  // No userID since login failed
//                 $logStmt->bindParam(':user_ip', $user_ip);
//                 $logStmt->bindParam(':status', $status); // Status for failure
//                 $logStmt->execute();
//             }
//         } else {
//             // No doctor found or user is inactive
//             $response['success'] = false;
//             $response['message'] = "User not found, inactive, or not a doctor";
//         }
//     } else {
//         // Missing fields
//         $response['success'] = false;
//         $response['message'] = "Please provide username and password";
//     }
// } else {
//     // Invalid request method
//     $response['success'] = false;
//     $response['message'] = "Invalid request method";
// }


// // Return the response as JSON
// header('Content-Type: application/json');
// echo json_encode($response);

require_once 'database.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($user_name) && !empty($password)) {
        $db = new Database();
        $conn = $db->getConnection();

        // Prepare SQL query to fetch user data 
        $query = "SELECT u.*, 
                         p.*, 
                         pos.* 
                  FROM tbl_users u
                  LEFT JOIN tbl_personnel p ON u.personnel_id = p.personnel_id
                  LEFT JOIN tbl_position pos ON u.position_id = pos.position_id
                  WHERE u.user_name = :username AND u.UserType = 'Doctor' AND u.status = 'active'";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $user_name);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Fetch user record
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Handle account lockout
            $current_time = new DateTime();
            if ($user['locked_until'] && $current_time < new DateTime($user['locked_until'])) {
                $response['success'] = false;
                $response['message'] = "Account is locked until " . $user['locked_until'];
            } else {
                // If the account is not locked, proceed with login verification
                if (password_verify($password, $user['password'])) {
                    // Login successful
                    $response['success'] = true;
                    $response['message'] = "Login successful";
                    $response['userID'] = $user['userID'];
                    $response['profile_picture'] =  $user['profile_picture'];
                    $response['first_name'] = $user['first_name'];
                    $response['middlename'] = $user['middlename'];
                    $response['lastname'] = $user['lastname'];
                    $response['LicenseNo'] = $user['LicenseNo'];
                    $response['Specialty'] = $user['Specialty'];
                    $response['email'] = $user['email'];
                    $response['ProfessionalType'] = $user['ProfessionalType'];
                    $response['address'] = $user['address'];
                    $response['personnel_id'] = $user['personnel_id'];
                    $response['position_id'] = $user['position_id'];
            
                    $stmtUpdate = $conn->prepare("UPDATE tbl_users SET failed_attempts = 0, locked_until = NULL WHERE userID = :userId");
                    $stmtUpdate->bindParam(':userId', $user['userID']);
                    $stmtUpdate->execute();

                  


                $response['user'] = array(
                    'userID' => $user['userID'],
                    'user_name' => $user['user_name'],
                    'UserType' => $user['UserType'],
                    'profile_picture' => $user['profile_picture'],
                    'personnel_id' => $user['personnel_id'],
                    'first_name' => $user['first_name'],
                    'middlename' => $user['middlename'],
                    'lastname' => $user['lastname'],
                    'PositionName' => $user['PositionName'],
                    'Specialty' => $user['Specialty'],
                    'ProfessionalType' => $user['ProfessionalType'],
                    'LicenseNo' => $user['LicenseNo'],
                    'email' => $user['email'],
                    'Specialty' => $user['Specialty'],
                    'address' => $user['address'],
                    'personnel_id' => $user['personnel_id'],
                    'position_id' => $user['position_id']
                );

                    // Log user login
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $logQuery = "INSERT INTO tbl_user_log (userID, username, user_ip, login_time, status)
                                 VALUES (:userID, :username, :user_ip, NOW(), 1)";
                    $logStmt = $conn->prepare($logQuery);
                    $logStmt->bindParam(':userID', $user['userID']);
                    $logStmt->bindParam(':username', $user['user_name']);
                    $logStmt->bindParam(':user_ip', $user_ip);
                    $logStmt->execute();
                } else {
                    // Incorrect password
                    $response['success'] = false;
                    $response['message'] = "Incorrect username or password";

                    // Update failed attempts
                    $failedAttempts = (int) $user['failed_attempts'] + 1;
                    $lockedUntil = null;

                    if ($failedAttempts >= 3) {
                        // Lock the account for 3 minutes
                        $lockedUntil = (clone $current_time)->modify('+3 minutes')->format('Y-m-d H:i:s');
                        $response['message'] = "Too many failed attempts. Account locked until " . $lockedUntil;
                    }

                    // Update the user's failed attempts and locked until time
                    $stmtUpdate = $conn->prepare("UPDATE tbl_users SET failed_attempts = :failedAttempts, locked_until = :lockedUntil WHERE userID = :userId");
                    $stmtUpdate->bindParam(':failedAttempts', $failedAttempts);
                    $stmtUpdate->bindParam(':lockedUntil', $lockedUntil);
                    $stmtUpdate->bindParam(':userId', $user['userID']);
                    $stmtUpdate->execute();

                    // Log failed attempt
                    $user_ip = $_SERVER['REMOTE_ADDR'];
                    $logQuery = "INSERT INTO tbl_user_log (username, user_ip, login_time, status) 
                                 VALUES (:username, :user_ip, NOW(), 0)";
                    $logStmt = $conn->prepare($logQuery);
                    $logStmt->bindParam(':username', $user_name); // No userID since login failed
                    $logStmt->bindParam(':user_ip', $user_ip);
                    $logStmt->execute();
                }
            }
        } else {
            // No doctor found or user is inactive
            $response['success'] = false;
            $response['message'] = "User not found";
        }
    } else {
        // Missing fields
        $response['success'] = false;
        $response['message'] = "Please provide username and password";
    }
} else {
    // Invalid request method
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);