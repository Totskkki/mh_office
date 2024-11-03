<?php
date_default_timezone_set('Asia/Manila');


$host = "localhost";
$user = "root";
$password = "";
$db = "mh_office";

try {
    $con = new PDO("mysql:dbname=$db;port=3306;host=$host", $user, $password);
  
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo $e->getTraceAsString();
    exit;
}


session_start();


// $sessionTimeout = 3600; 


// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionTimeout) {
 
//     session_unset();     
//     session_destroy();  
//     echo "<script>alert('Your session has expired. Please log in again.');</script>";

 
//     echo "<script>window.location = './index.php';</script>";
//     exit;
// }

// $_SESSION['LAST_ACTIVITY'] = time();

// // Database configuration
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'mh_office');

// // Establish a PDO connection
// try {
//     $con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
//     // Set the PDO error mode to exception
//     $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     error_log("PDO Connection Error: " . $e->getMessage());
//     exit(json_encode(array('status' => 'error', 'message' => 'Database connection failed')));
// }

// // Establish a MySQLi connection
// $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// // Check MySQLi connection
// if ($mysqli->connect_error) {
//     error_log("MySQLi Connection Error: " . $mysqli->connect_error);
//     exit(json_encode(array('status' => 'error', 'message' => 'Database connection failed')));
// }


// session_start();

// // Set session timeout duration (in seconds)
// $sessionTimeout = 3600; 

// // Check if the session has timed out
// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionTimeout) {
//     // Session has timed out
//     session_unset();    
//     session_destroy();  
//     echo "<script>alert('Your session has expired. Please log in again.');</script>";

//     // Redirect to the login page
//     echo "<script>window.location = '../index.php';</script>";
//     exit;
// }

// // Update last activity time
// $_SESSION['LAST_ACTIVITY'] = time();
?>
