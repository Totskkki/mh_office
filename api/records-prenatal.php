<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila');

$database = new Database();
$con = $database->getConnection();


    $query = "SELECT 
                chk.prenatalID ,chk.date,
                chk.*, 
                p.*, 
                CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name) AS name
              FROM tbl_prenatal AS chk
              LEFT JOIN tbl_patients AS p ON p.patientID = chk.patient_id
              GROUP BY p.patientID
              ORDER BY p.patientID, chk.prenatalID  DESC";

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
                    'date' => $record['date'],
                    'comments' => $record['comments'],

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

