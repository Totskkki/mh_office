<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
// $message = '';
// if (isset($_POST['patient_id'])) {
//     $patientID = $_POST['patient_id'];
//     $currentDate = date('Y-m-d'); 
//     $userID = $_SESSION['user_id'];
  
//     $query = "SELECT COUNT(*) FROM tbl_referrals_log WHERE patient_id = :patient_id AND userID =:user_id AND DATE(referral_date) = :current_date";
//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':patient_id', $patientID, PDO::PARAM_INT);
//     $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
//     $stmt->bindParam(':current_date', $currentDate, PDO::PARAM_STR);
//     $stmt->execute();
//     $existingReferrals = $stmt->fetchColumn();
  
//     if ($existingReferrals > 0) {
//         echo json_encode(["status" => "error", "message" => "A referral for this patient already exists today. Only one referral per day is allowed."]);
//     } else {
//         $insertQuery = "INSERT INTO tbl_referrals_log (patient_id, referral_date, userID) VALUES (:patient_id, CURRENT_TIMESTAMP, :user_id)";
//         $insertStmt = $con->prepare($insertQuery);
//         $insertStmt->bindParam(':patient_id', $patientID, PDO::PARAM_INT);
//         $insertStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    
//         if ($insertStmt->execute()) {
//             echo json_encode(["status" => "success", "message" => "Referral successfully created."]);
//         } else {
//             echo json_encode(["status" => "error", "message" => "Error creating referral."]);
//         }
//     }
// } else {
//     echo "Required data not submitted.";
// }

$response = array();

if (isset($_POST['patient_id'])) {
    $patientID = $_POST['patient_id'];
    $currentDate = date('Y-m-d'); 
    $userID = $_SESSION['user_id'];

    try {
        // Check if a referral already exists for today
        $query = "SELECT COUNT(*) FROM tbl_referrals_log WHERE patient_id = :patient_id AND userID = :user_id AND DATE(referral_date) = :current_date";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':patient_id', $patientID, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':current_date', $currentDate, PDO::PARAM_STR);
        $stmt->execute();
        $existingReferrals = $stmt->fetchColumn();

        if ($existingReferrals > 0) {
            $response['status'] = 'error';
            $response['message'] = 'A referral for this patient already exists today. Only one referral per day is allowed.';
        } else {
            // Begin transaction
            $con->beginTransaction();

            // Insert new referral log
            $insertQuery = "INSERT INTO tbl_referrals_log (patient_id, referral_date, userID) VALUES (:patient_id, CURRENT_TIMESTAMP, :user_id)";
            $insertStmt = $con->prepare($insertQuery);
            $insertStmt->bindParam(':patient_id', $patientID, PDO::PARAM_INT);
            $insertStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

            if ($insertStmt->execute()) {
                // Update the referred column in tbl_complaints
                $updateQuery = "UPDATE tbl_complaints SET transferred = 'referred', status = 'Done' WHERE patient_id = :id";
                $updateStmt = $con->prepare($updateQuery);
                $updateStmt->bindParam(':id', $patientID, PDO::PARAM_INT);

                if ($updateStmt->execute()) {
                    // Update birth info in tbl_birth_info
                    $stmtUpdateBirthInfo = $con->prepare("
                        UPDATE tbl_birth_info 
                        SET birthing_status = 'done' 
                        WHERE patient_id = :patientID
                    ");
                    $stmtUpdateBirthInfo->bindParam(':patientID', $patientID, PDO::PARAM_INT);

                    if ($stmtUpdateBirthInfo->execute()) {
                        // Commit transaction
                        $con->commit();
                        $response['status'] = 'success';
                        $response['message'] = 'Referral successfully created, complaint referred status updated, and birth info updated.';
                    } else {
                        // Rollback transaction if updating birth info fails
                        $con->rollBack();
                        $response['status'] = 'error';
                        $response['message'] = 'Error updating birth info.';
                    }
                } else {
                    // Rollback transaction if updating complaints fails
                    $con->rollBack();
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating referred status.';
                }
            } else {
                // Rollback transaction if insert fails
                $con->rollBack();
                $response['status'] = 'error';
                $response['message'] = 'Error creating referral.';
            }
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request. Patient ID is missing.';
}

echo json_encode($response);

?>

