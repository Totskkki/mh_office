<?php
include '../config/connection.php';





// SQL query to get normal deliveries per barangay
// $query = "SELECT COUNT(*) AS delivery_count, 
//         MONTH(bi.`date`) AS month, 
//         b.brgy
//     FROM tbl_birth_info AS bi
//     LEFT JOIN tbl_patients AS p ON bi.patient_id = p.patientID
//     LEFT JOIN tbl_familyAddress AS b ON p.family_address = b.famID
//     LEFT JOIN tbl_complaints AS c ON c.patient_id = bi.patient_id
//     WHERE (c.status = 'Done' OR c.consultation_purpose = 'Birthing')
//     GROUP BY b.brgy, MONTH(bi.`date`)
//     ORDER BY b.brgy, month";

$query = "SELECT COUNT(*) AS delivery_count, 
        MONTH(bi.`date`) AS month, 
        b.brgy
    FROM tbl_birth_info AS bi
    LEFT JOIN tbl_patients AS p ON bi.patient_id = p.patientID
    LEFT JOIN tbl_familyAddress AS b ON p.family_address = b.famID
    LEFT JOIN tbl_complaints AS c ON c.patient_id = bi.patient_id
     WHERE c.consultation_purpose = 'Birthing' AND (c.status = 'Done' OR c.status IS NULL)
    GROUP BY b.brgy, MONTH(bi.`date`)
    ORDER BY b.brgy, month";

$stmt = $con->prepare($query);
$stmt->execute();

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $brgy = $row['brgy'];
    $month = $row['month'];
    $delivery_count = $row['delivery_count'];

    if (!isset($data[$brgy])) {
        $data[$brgy] = [];
    }
    $data[$brgy][$month] = $delivery_count;
}

// SQL query to get total referred cases per month
$query_referred = "SELECT COUNT(*) AS referred_count, 
        MONTH(c.`created_at`) AS month
    FROM tbl_complaints AS c
    WHERE c.transferred = 'referred' and c.consultation_purpose= 'Birthing'
    GROUP BY MONTH(c.`created_at`)
    ORDER BY month";

$stmt_referred = $con->prepare($query_referred);
$stmt_referred->execute();

$referredData = [];
while ($row_referred = $stmt_referred->fetch(PDO::FETCH_ASSOC)) {
    $month = $row_referred['month'];
    $referred_count = $row_referred['referred_count'];
    $referredData[$month] = $referred_count;
}

// Add the referred data to the response
$data['Total Referred'] = $referredData;

// Output the data as JSON
echo json_encode($data);

