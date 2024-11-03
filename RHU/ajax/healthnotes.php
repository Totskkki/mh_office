<?php
include '../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['docnoteid'])) {
    $docid = $_POST['docnoteid'];

    try {
      
        $query = "SELECT p.*, v.*, per.*, u.userID,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name, 
                  v.nurse_midwife,
                  h.date, h.time, h.doctorNotes, h.nureNotes,
                  CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS doctor_name
          FROM tbl_patients p
          LEFT JOIN tbl_vitalsigns_monitoring v ON p.patientID = v.patient_id
          LEFT JOIN tbl_healthnotes h ON p.patientID = h.patient_id
          LEFT JOIN tbl_users u ON u.userID = h.userID
          LEFT JOIN tbl_personnel per ON per.personnel_id = u.personnel_id

          WHERE p.patientID = :recordId
           GROUP BY h.date, h.time, h.doctorNotes";


        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $docid, PDO::PARAM_INT);
        $stmt->execute();

       
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($records) {
           
            $response = [
                'patient_id' => $records[0]['patientID'] ?? '',
                'patient_name' => $records[0]['patient_name'] ?? '',
                'middle_name' => $records[0]['middle_name'] ?? '',
                'last_name' => $records[0]['last_name'] ?? '',
                'doctor_name' => $records[0]['doctor_name'] ?? '',
                'age' => $records[0]['age'] ?? 'N/A',
                'room' => $records[0]['room'] ?? 'N/A',
                'nurse_midwife' => $records[0]['nurse_midwife'] ?? 'N/A', 
                'doctor_notes' => [],
                'nurse_notes' => []
            ];

      
            foreach ($records as $record) {
          
                if ($record['doctorNotes']) {
                    $response['doctor_notes'][] = [
                        'date' => isset($record['date']) ? date('d/m/Y', strtotime($record['date'])) : '',
                        'time' => $record['time'] ?? '',
                        'doctor' => $record['doctor_name'] ?? '',
                        'notes' => $record['doctorNotes'] ?? ''
                    ];
                }
            
                if ($record['nureNotes']) {
                    $response['nurse_notes'][] = [
                        'date' => isset($record['date']) ? date('d/m/Y', strtotime($record['date'])) : '',
                        'time' => $record['time'] ?? '',
                        'notes' => $record['nureNotes'] ?? ''
                    ];
                }
                
            }

            // Return the response
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'No records found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
