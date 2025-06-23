<?php

include("./pdflib/logics-builder-pdf.php");
include './config/connection.php';

$reportTitle = "Doctor's Reports";
$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$doctorName = $_GET['doctor'] ?? null;

// Validate required parameters
if (!$from || !$to || !$doctorName) {
    die("Missing required parameters.");
}

// Convert dates to MySQL format
$fromArr = explode("/", $from);
$toArr = explode("/", $to);

$fromMysql = $fromArr[2] . '-' . $fromArr[0] . '-' . $fromArr[1];
$toMysql = $toArr[2] . '-' . $toArr[0] . '-' . $toArr[1];

// Initialize PDF
$pdf = new LB_PDF('L', false, $reportTitle, $from, $to);
$pdf->SetMargins(15, 10);
$pdf->AliasNbPages();
$pdf->AddPage();

$titlesArr = array(
    '#',
    'Patient Name',
    'Address',
    'Contact#',
    'Illness',
    'Visit Date'
);

$pdf->SetWidths(array(10, 70, 70, 30, 30, 30));
$pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L'));
$pdf->Ln(15);
$Dr = strtoupper('Dr. ');
$doctorCaption = strtoupper($Dr . $doctorName);
$pdf->AddTableCaption($doctorCaption);

$pdf->AddTableHeader($titlesArr);

// SQL Query to fetch patient data based on the doctor and date range
$sql = "
    SELECT 
        pat.patientID,
        CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', IFNULL(pat.suffix, '')) AS patient_name,
        CONCAT(fam.brgy, ', ', fam.purok, ', ', fam.province) AS familyaddress,
        CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS doctor_name,
        pat.phone_number,
        GROUP_CONCAT(pv.disease ORDER BY pv.visit_date ASC SEPARATOR ', ') AS diseases,
        MIN(pv.visit_date) AS first_visit_date
    FROM 
        tbl_patients AS pat
    JOIN 
        tbl_familyAddress AS fam ON pat.family_address = fam.famID
    JOIN 
        tbl_patient_visits AS pv ON pv.patient_id = pat.patientID
    JOIN 
        tbl_users AS d ON pv.doctor_id = d.userID
    JOIN 
        tbl_personnel AS per ON per.personnel_id = d.personnel_id
    WHERE 
        pv.visit_date BETWEEN :from AND :to
        AND CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) = :doctorName
    GROUP BY 
        pat.patientID
    ORDER BY 
        first_visit_date DESC
";

// Prepare and execute statement
$stmt = $con->prepare($sql);
$stmt->bindParam(':from', $fromMysql);
$stmt->bindParam(':to', $toMysql);
$stmt->bindParam(':doctorName', $doctorName);
$stmt->execute();

// Fetch data and populate PDF
$i = 0;
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $i++;
    $data = array(
        $i,
        $r['patient_name'],
        $r['familyaddress'],
        $r['phone_number'],
        $r['diseases'],
        $r['first_visit_date']
    );
    $pdf->AddRow($data);
}

// Output the PDF
ob_clean();
$pdf->Output('print_doctors_record.pdf', 'I');

