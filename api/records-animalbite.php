<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila');

$database = new Database();
$con = $database->getConnection();

// Get the type of record to fetch
$type = isset($_GET['type']) ? $_GET['type'] : 'animalbite';  // Default to 'checkup'

// Modify query based on the type
$query = "";
if ($type == 'animalbite') {
    $query = "SELECT 
                chk.animal_biteID,chk.date,
                chk.*, 
                p.*, v.*, m.medicineID,
                CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name) AS name
              FROM tbl_animal_bite_care AS chk
              LEFT JOIN tbl_patients AS p ON p.patientID = chk.patient_id
              LEFT JOIN tbl_animal_bite_vaccination AS v ON v.bite_status = chk.bite_status
              LEFT JOIN tbl_medicines AS m ON m.medicineID = v.vaccination_name
              GROUP BY p.patientID
              ORDER BY p.patientID, chk.animal_biteID DESC";
} 
// Fetch data
$stmt = $con->prepare($query);

try {
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$records) {
        echo json_encode(['error' => 'No records found.']);
        exit;
    }

    // Organize records by patient
    $patients = [];
    $currentDate = date('Y-m-d');

    foreach ($records as $record) {
        $patientID = $record['patient_id'];

        // Initialize patient info if not already done
        if (!isset($patients[$patientID])) {
            $patients[$patientID] = [
                'patient_info' => [
                    'name' => $record['name'],
                    'gender' => $record['gender'],
                    'age' => $record['age'],
                    'phone_number' => $record['phone_number'],
                    'remarks' => $record['remarks'],
                    'date_bite' => $record['date_bite'],
                    'vaccination_name' => isset($record['vaccination_name']) ? $record['vaccination_name'] : '',
                    'vaccination_date' => isset($record['vaccination_date']) ? $record['vaccination_date'] : ''
                ],
                'present_records' => [],
                'past_records' => []
            ];
        }

        // Separate the records into present and past
        $recordDate = substr($record['date'], 0, 10);
        if ($recordDate === $currentDate) {
            $patients[$patientID]['present_records'][] = $record;
        } else {
            $patients[$patientID]['past_records'][] = $record;
        }
    }

    echo json_encode(['patients' => array_values($patients)]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
}

