<?php
header('Content-Type: application/json');
require_once 'database.php';


$requiredFields = [
    'userID', 'first_name',  'lastname', 'email',
    'specialty', 'ProfessionalType', 'LicenseNo', 'address',
    'personnel_id', 'position_id'
];

// Check for missing fields
$missingFields = [];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Incomplete input data.',
        'missing_fields' => $missingFields
    ]);
    exit;
}

$database = new Database();
$con = $database->getConnection();

// Input data
$userID = $_POST['userID'];
$firstName = $_POST['first_name'];
$middleName = $_POST['middlename'];
$lastName = $_POST['lastname'];
$email = $_POST['email'];
$specialty = $_POST['specialty'];
$professionalType = $_POST['ProfessionalType'];
$licenseNo = $_POST['LicenseNo'];
$address = $_POST['address'];
$personnel_id = $_POST['personnel_id'];
$position_id = $_POST['position_id'];

$profilePicturePath = null;

// Check and handle profile picture upload
if (isset($_FILES['profile_picture']) && is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
    $uploadDir = '../user_images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Ensure the directory exists
    }

    $fileName = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($_FILES['profile_picture']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.'
        ]);
        exit;
    }

    if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFilePath)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to upload profile picture.'
        ]);
        exit;
    }

    $profilePicturePath = $uploadFilePath;
}

try {
    // Update personnel data
    $updatePersonnel = "UPDATE tbl_personnel 
                         SET first_name = ?, middlename = ?, lastname = ?, email = ?, address = ? 
                         WHERE personnel_id = ?";
    $stmt1 = $con->prepare($updatePersonnel);
    $stmt1->execute([$firstName, $middleName, $lastName, $email, $address, $personnel_id]);

    // Update position data
    $updatePosition = "UPDATE tbl_position 
                       SET Specialty = ?, ProfessionalType = ?, LicenseNo = ? 
                       WHERE position_id = ?";
    $stmt2 = $con->prepare($updatePosition);
    $stmt2->execute([$specialty, $professionalType, $licenseNo, $position_id]);

    // Update profile picture if uploaded
    if ($profilePicturePath) {
        $updateProfilePic = "UPDATE tbl_users SET profile_picture = ? WHERE userID = ?";
        $stmt3 = $con->prepare($updateProfilePic);
        $stmt3->execute([$profilePicturePath, $userID]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Data updated successfully.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error updating data: ' . $e->getMessage()
    ]);
}
