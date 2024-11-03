<?php
include '../config/connection.php';

// if (isset($_GET['date'])) {
//     $date = $_GET['date'];

//     $query = "SELECT * FROM tbl_prenatal WHERE date < :date ORDER BY date desc limit 4 ";
//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':date', $date);
//     $stmt->execute();

//     $records = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($records) {
//         header('Content-Type: application/json');
//         echo json_encode($records);
//         exit;
//     } else {
//         echo json_encode(array('error' => 'No previous records found'));
//     }
// } else {
//     echo json_encode(array('error' => 'Date parameter is missing'));
// }

if (isset($_GET['date'])) {
 
    $date = $_GET['date'];

    $query = "SELECT * FROM tbl_prenatal WHERE date < :date ORDER BY date DESC";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    $records = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($records) {
        header('Content-Type: application/json');
        echo json_encode($records);
        exit;
    } else {
        echo json_encode(array('error' => 'No previous records found'));
    }
} else {
    echo json_encode(array('error' => 'Date parameter is missing'));
}

?>


