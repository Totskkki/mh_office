<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila');

$database = new Database();
$con = $database->getConnection();

$query = "
    SELECT 
        chk.checkupID,
        chk.*, 
        p.*, 
        c.Chief_Complaints,
        CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name) AS name
    FROM tbl_checkup AS chk
    LEFT JOIN tbl_patients AS p ON p.patientID = chk.patient_id
    LEFT JOIN (
        SELECT patient_id, GROUP_CONCAT(Chief_Complaint SEPARATOR ', ') AS Chief_Complaints
        FROM tbl_complaints
        WHERE status = 'Done' AND consultation_purpose = 'Checkup'
        GROUP BY patient_id
    ) AS c ON c.patient_id = p.patientID
    ORDER BY p.patientID, chk.checkupID DESC
";


$stmt = $con->prepare($query);

try {
    $stmt->execute();
    $checkuplist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if we fetched any records
    if (!$checkuplist) {
        echo json_encode(['error' => 'No checkups found.']);
        exit;
    }

    // Arrays to hold patient data
    $patients = [];

    $currentDate = date('Y-m-d');

    foreach ($checkuplist as $checkup) {
        $patientID = $checkup['patient_id'];

        // Check if the patient data already exists in the array, if not, initialize it
        if (!isset($patients[$patientID])) {
            $patients[$patientID] = [
                'patient_info' => [
                    'name' => $checkup['name'],
                    'gender' => $checkup['gender'],
                    'age' => $checkup['age'],
                    'doctor_order' => $checkup['doctor_order'],
                    'phone_number' => $checkup['phone_number'],
                    'admitted' => $checkup['admitted'],
                ],
                'present_records' => [],
                'past_records' => []
            ];
        }

        // Separate the records based on the admitted date
        $admittedDate = substr($checkup['admitted'], 0, 10); 

        if ($admittedDate === $currentDate) {
            $patients[$patientID]['present_records'][] = $checkup;
        } else {
            $patients[$patientID]['past_records'][] = $checkup;
        }
    }

    // Return the patients data in JSON format
    echo json_encode(['patients' => array_values($patients)]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
}

