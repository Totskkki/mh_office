<?php
ob_start(); // Start output buffering

if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}

if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

if (!isset($_SESSION['last_regenerate'])) {
    $_SESSION['last_regenerate'] = time();
} elseif (time() - $_SESSION['last_regenerate'] > 300) { // 300 seconds = 5 minutes
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
}

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Database query to fetch admin details
$sql = "SELECT user.*, personnel.*, position.*, user.UserType AS UserType 
        FROM `tbl_users` AS user
        INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
        INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
        WHERE user.`userID` = :admin_id";

$stmt = $con->prepare($sql);
$stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>
