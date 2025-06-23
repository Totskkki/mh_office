<?php
header('Content-Type: application/json');

require_once 'database.php'; 

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['userID'])) {
    $userId = $_GET['userID'];

    $stmt = $db->prepare("SELECT profile_picture FROM tbl_users WHERE userID = :userID");
    $stmt->bindParam(':userID', $userId);
    
    if ($stmt->execute()) {
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $profilePictureUrl = $result['profile_picture'] ?? 'user_images/default_profile.jpg';

      

        echo json_encode([
            'profile_picture' => $profilePictureUrl,
            'userID' => $userId // Include the userID
        ]);
    } else {
        // Return an error if the query fails
        echo json_encode(['error' => 'Failed to execute query.']);
    }
} else {
    // Return an error if userID is not provided
    echo json_encode(['error' => 'UserID not provided.']);
}
?>
