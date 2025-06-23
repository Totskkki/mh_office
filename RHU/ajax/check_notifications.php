<?php
include '../config/connection.php';

// Define the response array
$response = [
    'success' => false,
    'checkup_count' => 0,
    'birthing_count' => 0,
    'prenatal_count' => 0,
    'animalbite' => 0,
    'vaccination' => 0
  
];

try {
    // Prepare the query to get counts based on consultation purposes
    $query = "SELECT 
                SUM(CASE WHEN consultation_purpose = 'Checkup' THEN 1 ELSE 0 END) AS checkup_count,
                SUM(CASE WHEN consultation_purpose = 'Birthing' THEN 1 ELSE 0 END) AS birthing_count,
                SUM(CASE WHEN consultation_purpose = 'Prenatal' THEN 1 ELSE 0 END) AS prenatal_count,
                SUM(CASE WHEN consultation_purpose = 'Animal bite and Care' THEN 1 ELSE 0 END) AS animalbite,
                SUM(CASE WHEN consultation_purpose = 'Vaccination and Immunization' THEN 1 ELSE 0 END) AS vaccination

              FROM tbl_complaints
              WHERE status = 'Pending'"; 

    $stmt = $con->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $response['success'] = true;
        $response['checkup_count'] = (int) $result['checkup_count'];
        $response['birthing_count'] = (int) $result['birthing_count'];
        $response['prenatal_count'] = (int) $result['prenatal_count'];
        $response['animalbite'] = (int) $result['animalbite'];
           $response['vaccination'] = (int) $result['vaccination'];
    }
} catch (PDOException $ex) {
    error_log("Error checking notifications: " . $ex->getMessage());
}

// Return the response as JSON
echo json_encode($response);

