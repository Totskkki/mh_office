<?php
include '../config/connection.php';
header('Content-Type: application/json');

if (isset($_POST['patient_id'])) {
    $patientId = $_POST['patient_id'];

    // Prepare and execute the query
    $query = "SELECT `checkupID`, `admitted`, `history`, `per_pas_med`, `pertinent_signs`, `gen_survey`, `heent`, `chest`, `CSV`, `abdomen`, `GU`, `skin_extremeties`, `neuro_exam`, `disability`, `disability_type`, `doctor_order`, `patient_id`, `no_illness`, `created_at`, `sync_status` 
              FROM tbl_checkup 
              WHERE patient_id = :patient_id 
              ORDER BY created_at DESC limit 1";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':patient_id', $patientId, PDO::PARAM_INT);
    $stmt->execute();

    $checkupDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decode JSON columns for each record
    foreach ($checkupDetails as &$record) {

        
        $record['pertinent_signs'] = json_decode($record['pertinent_signs'], true);
        $record['gen_survey'] = json_decode($record['gen_survey'], true);
        $record['heent'] = json_decode($record['heent'], true);
        $record['chest'] = json_decode($record['chest'], true);
        $record['CSV'] = json_decode($record['CSV'], true);
        $record['abdomen'] = json_decode($record['abdomen'], true);
        $record['GU'] = json_decode($record['GU'], true);
        $record['skin_extremeties'] = json_decode($record['skin_extremeties'], true);
        $record['neuro_exam'] = json_decode($record['neuro_exam'], true);
    }

    // Return the response
    echo json_encode([
        'status' => 'success',
        'checkupDetails' => $checkupDetails,

    ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    // Return an error response if patient_id is not provided
    echo json_encode(['status' => 'error', 'message' => 'Patient ID not provided']);
}
?>
