<?php

include '../config/connection.php';

if (isset($_POST['patientid'])) {
    $patientID = $_POST['patientid'];

    // Query to get the last certificate generated for the patient
    $query = "
        SELECT generated_at, status 
        FROM tbl_certificate_log 
        WHERE patient_id = :patientID 
        ORDER BY generated_at DESC 
        LIMIT 1
    ";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
    $stmt->execute();
    $lastGenerated = $stmt->fetch(PDO::FETCH_ASSOC);

    $canGenerate = true;
    if ($lastGenerated) {
        $lastGeneratedDate = new DateTime($lastGenerated['generated_at']);
        $currentDate = new DateTime();
        $interval = $lastGeneratedDate->diff($currentDate);
        $canGenerate = $interval->days >= 3;
    }

    if ($canGenerate) {
        // Check if the last status was 'pending'
        if (isset($lastGenerated['status']) && $lastGenerated['status'] == 'pending') {
            // Update the status to 'done'
            $updateQuery = "UPDATE tbl_certificate_log SET status = 'done', generated_at = NOW() WHERE patient_id = :patientID AND status = 'pending'";
            $updateStmt = $con->prepare($updateQuery);
            $updateStmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
            if ($updateStmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Certificate status updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating certificate status."]);
            }
        } else {
            // Insert a new record if no pending status exists
            $status = 'done';
            $insertQuery = "INSERT INTO tbl_certificate_log (patient_id, generated_at, status) VALUES (:patientID, NOW(), :status)";
            $insertStmt = $con->prepare($insertQuery);
            $insertStmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
            $insertStmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($insertStmt->execute()) {
                // Generate the certificate here (you can add your certificate generation logic)
                $filename = 'certificate_' . $patientID . '.pdf'; // Example filename
                // Assuming the certificate is generated and saved
                $filePath = __DIR__ . '/certificates/' . $filename; // Full file path for the generated certificate

                // Respond with a success message and the URL to view the certificate
                $response = [
                    'status' => 'success',
                    'fileUrl' => '/certificates/' . $filename, // Relative URL path to the certificate
                    'message' => 'Certificate successfully generated.'
                ];
                echo json_encode($response); // Send the response back to the frontend
            } else {
                echo json_encode(["status" => "error", "message" => "Error generating certificate."]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "A certificate for this patient has already been generated, Please go back after 3 days."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Required data not submitted."]);
}


// include '../config/connection.php';

// if (isset($_POST['patientid'])) {
//     $patientID = $_POST['patientid'];

//     // Query to get the last certificate generated for the patient
//     $query = "
//         SELECT generated_at, status 
//         FROM tbl_certificate_log 
//         WHERE patient_id = :patientID 
//         ORDER BY generated_at DESC 
//         LIMIT 1
//     ";
//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
//     $stmt->execute();
//     $lastGenerated = $stmt->fetch(PDO::FETCH_ASSOC);

//     $canGenerate = true;
//     if ($lastGenerated) {
//         $lastGeneratedDate = new DateTime($lastGenerated['generated_at']);
//         $currentDate = new DateTime();
//         $interval = $lastGeneratedDate->diff($currentDate);
//         $canGenerate = $interval->days >= 3;
//     }

//     if ($canGenerate) {
//         // Check if the last status was 'pending'
//         if (isset($lastGenerated['status']) && $lastGenerated['status'] == 'pending') {
//             // Update the status to 'done'
//             $updateQuery = "UPDATE tbl_certificate_log SET status = 'done', generated_at = NOW() WHERE patient_id = :patientID AND status = 'pending'";
//             $updateStmt = $con->prepare($updateQuery);
//             $updateStmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
//             if ($updateStmt->execute()) {
//                 echo json_encode(["status" => "success", "message" => "Certificate status updated successfully."]);
//             } else {
//                 echo json_encode(["status" => "error", "message" => "Error updating certificate status."]);
//             }
//         } else {
//             // Insert a new record if no pending status exists
//             $status = 'done';
//             $insertQuery = "INSERT INTO tbl_certificate_log (patient_id, generated_at, status) VALUES (:patientID, NOW(), :status)";
//             $insertStmt = $con->prepare($insertQuery);
//             $insertStmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
//             $insertStmt->bindParam(':status', $status, PDO::PARAM_STR);
//             if ($insertStmt->execute()) {
//                 echo json_encode(["status" => "success", "message" => "Certificate successfully generated."]);
//             } else {
//                 echo json_encode(["status" => "error", "message" => "Error generating certificate."]);
//             }
//         }
//     } else {
//         echo json_encode(["status" => "error", "message" => "A certificate for this patient has already been generated, Please go back after 3 days."]);
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "Required data not submitted."]);
// }

?>
