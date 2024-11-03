<?php 
// $host = "localhost";
// $user = "root";
// $password = "";
// $db = "mh_office";
// try {

//   $con = new PDO("mysql:dbname=$db;port=3306;host=$host", 
//   	$user, $password);
//   // set the PDO error mode to exception
//   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
//   //echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: ".
//    $e->getMessage();
//   echo $e->getTraceAsString();
//   exit;
// }

// session_start();

// //24 minutes default idle time
// // if(isset($_SESSION['ABC'])) {
// // 	unset($_SESSION['ABC']);
// // }
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


// $sessionTimeout = 7200; 


// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionTimeout) {

//     session_unset();    
//     session_destroy();   
//     echo "<script>alert('Your session has expired. Please log in again.');</script>";

//     echo "<script>window.location = '../index.php';</script>";
//     exit;
// }


// $_SESSION['LAST_ACTIVITY'] = time();
?>

