<?php
header('Content-Type: application/json');
require_once 'database.php';

if (isset($_POST['userID'], $_POST['username'], $_POST['newPassword'], $_POST['confirmPassword'])) {
    $userID = $_POST['userID'];
    $username = $_POST['username'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (strlen($newPassword) < 6) {
        echo json_encode([
            "success" => false,
            "message" => "Password must be at least 6 characters."
        ]);
        exit;
    }

    if (!preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/\d/', $newPassword) || !preg_match('/[!$@%]/', $newPassword)) {
        echo json_encode([
            "success" => false,
            "message" => "Password must include letters, numbers, and special characters (!$@%)."
        ]);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode([
            "success" => false,
            "message" => "Passwords do not match."
        ]);
        exit;
    }

    try {
        $database = new Database();
        $con = $database->getConnection();

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $query = "UPDATE tbl_users SET user_name = :username, password = :password WHERE userID = :userID";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Password updated successfully."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to update password. Please try again."
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "An error occurred: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
