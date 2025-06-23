<?php
header('Content-Type: application/json');
require_once 'database.php';


$database = new Database();
$con = $database->getConnection();

$date = date('Y-m-d');

$queryToday = "SELECT count(*) as `today` 
  from `tbl_patient_visits` 
  where `visit_date` = '$date';";

if (isset($_GET['count']) && $_GET['count'] == 'patientcounttoday') {
    try {
        $todaysCount = 0;
        $stmtToday = $con->prepare($queryToday);
        $stmtToday->execute();
        $r = $stmtToday->fetch(PDO::FETCH_ASSOC);
        $todaysCount = $r['today'];

        // Return the count of today's patients as JSON
        echo json_encode(['today_patient_count' => $todaysCount]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}

