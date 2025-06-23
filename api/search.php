<?php
header('Content-Type: application/json');
require_once 'database.php';
date_default_timezone_set('Asia/Manila');

$database = new Database();
$con = $database->getConnection();

try {
    // Query tbl_announcements
    $searchTerm = htmlspecialchars($_GET['search']);

    $searchTerm = '%' . $searchTerm . '%';


    // Update the queries to include WHERE clauses
    $queryAnnouncements = "SELECT * FROM `tbl_announcements` WHERE `title` LIKE :searchTerm OR `details` LIKE :searchTerm LIMIT 10 OFFSET 0";
    $stmtAnnouncements = $con->prepare($queryAnnouncements);
    $stmtAnnouncements->execute([':searchTerm' => $searchTerm]);

    $announcements = $stmtAnnouncements->fetchAll(PDO::FETCH_ASSOC);

    $queryDoctorSchedule = "SELECT * FROM `tbl_doctor_schedule` WHERE `message` LIKE :searchTerm LIMIT 10 OFFSET 0" ;
    $stmtDoctorSchedule = $con->prepare($queryDoctorSchedule);
    $stmtDoctorSchedule->bindParam(':searchTerm', $searchTerm);
    $stmtDoctorSchedule->execute();
    $doctorSchedules = $stmtDoctorSchedule->fetchAll(PDO::FETCH_ASSOC);

    $queryPatients = "SELECT p.*,f.*,c.*,concat('Brgy.', ' ',f.brgy, ' ',f.purok,' ' ,f.city_municipality,' ',f.province) as address
     FROM tbl_patients p 
    LEFT JOIN tbl_familyAddress f on f.famID = p.family_address
    LEFT JOIN tbl_complaints c on c.patient_id = p.patientID  and c.created_at
    
    WHERE `patient_name` LIKE :searchTerm OR `last_name` LIKE :searchTerm 
    GROUP BY p.patientID
    LIMIT 10 OFFSET 0";
    $stmtPatients = $con->prepare($queryPatients);
    $stmtPatients->bindParam(':searchTerm', $searchTerm);
    $stmtPatients->execute();
    $patients = $stmtPatients->fetchAll(PDO::FETCH_ASSOC);


    // Combine results into a single array
    $response = [
        'status' => 'success',
        'announcements' => $announcements,
        'doctor_schedules' => $doctorSchedules,
        'patients' => $patients
    ];

    // Send JSON response
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
