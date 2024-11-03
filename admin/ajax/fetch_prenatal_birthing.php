<?php
include '../config/connection.php';

date_default_timezone_set('Asia/Manila');


// Checking if a year has been specified, otherwise use the current year
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Function to fetch counts by month for a given SQL query and year
function fetchCounts($con, $query, $year) {
    $stmt = $con->prepare($query);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $counts = array_fill(1, 12, 0);  // Initialize all months to 0
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $counts[$row['Month']] = (int) $row['Count'];
    }
    return array_values($counts);
}

// Define SQL queries to fetch data by year
$queryBirthing = "SELECT MONTH(date) AS Month, COUNT(*) AS Count FROM tbl_birth_info WHERE YEAR(date) = :year GROUP BY MONTH(date)";
$queryPrenatal = "SELECT MONTH(date) AS Month, COUNT(*) AS Count FROM tbl_prenatal WHERE YEAR(date) = :year GROUP BY MONTH(date)";
$queryAnimalBite = "SELECT MONTH(date_bite) AS Month, COUNT(*) AS Count FROM tbl_animal_bite_care WHERE YEAR(date_bite) = :year GROUP BY MONTH(date_bite)";
$queryImmunization = "SELECT MONTH(immunization_date) AS Month, COUNT(*) AS Count FROM tbl_immunization_records WHERE YEAR(immunization_date) = :year GROUP BY MONTH(immunization_date)";

// Fetching data for each category
$birthingCounts = fetchCounts($con, $queryBirthing, $year);
$prenatalCounts = fetchCounts($con, $queryPrenatal, $year);
$animalBiteCounts = fetchCounts($con, $queryAnimalBite, $year);
$immunizationCounts = fetchCounts($con, $queryImmunization, $year);

// Output the data in JSON format
header('Content-Type: application/json');
echo json_encode([
    'birthing' => $birthingCounts,
    'prenatal' => $prenatalCounts,
    'animalBites' => $animalBiteCounts,
    'immunizations' => $immunizationCounts
]);

// $date = date('Y-m-d');
// $year =  date('Y');
// $month =  date('m');

// $queryBirthing = "SELECT MONTH(date) AS Month, COUNT(*) AS Count FROM tbl_birth_info GROUP BY MONTH(date)";
// $stmt = $con->query($queryBirthing);
// $birthingCounts = array_fill(1, 12, 0); 
// while ($row = $stmt->fetch()) {
//     $birthingCounts[$row['Month']] = (int) $row['Count'];
// }


// $queryPrenatal = "SELECT MONTH(date) AS Month, COUNT(*) AS Count FROM tbl_prenatal GROUP BY MONTH(date)";
// $stmt = $con->query($queryPrenatal);
// $prenatalCounts = array_fill(1, 12, 0);
// while ($row = $stmt->fetch()) {
//     $prenatalCounts[$row['Month']] = (int) $row['Count'];
// }

// $queryAnimalBite = "SELECT MONTH(date_bite) AS Month, COUNT(*) AS Count FROM tbl_animal_bite_care WHERE YEAR(date_bite) = :year GROUP BY MONTH(date_bite)";
// $stmt = $con->prepare($queryAnimalBite);
// $stmt->bindParam(':year', $year);
// $stmt->execute();
// $animalBiteCounts = array_fill(1, 12, 0);
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $animalBiteCounts[$row['Month']] = $row['Count'];
// }


// $queryImmunization = "SELECT MONTH(immunization_date) AS Month, COUNT(*) AS Count FROM tbl_immunization_records WHERE YEAR(immunization_date) = :year GROUP BY MONTH(immunization_date)";
// $stmt = $con->prepare($queryImmunization);
// $stmt->bindParam(':year', $year);
// $stmt->execute();
// $immunizationCounts = array_fill(1, 12, 0);
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $immunizationCounts[$row['Month']] = $row['Count'];
// }


// echo json_encode([
//     'birthing' => array_values($birthingCounts),
//     'prenatal' => array_values($prenatalCounts),
//     'animalBites' => array_values($animalBiteCounts),
//     'immunizations' => array_values($immunizationCounts)
// ]);
