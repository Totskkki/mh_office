<?php

if (session_status() === PHP_SESSION_NONE) {
      
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
        session_regenerate_id(true);
        $_SESSION['last_regenerate'] = time();
    }
    
    // Redirect to login if the user is not authenticated
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }


$sql = "SELECT user.*, personnel.*, position.*,p.*, user.UserType AS UserType
        FROM `tbl_users` AS user
        INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
        INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
        LEFT JOIN tbl_user_page AS p ON user.userID = p.userID
        WHERE user.`userID` = :user_id";

$stmt = $con->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);



?>