<?php
include("./pdflib/logics-builder-pdf.php");
include './config/connection.php';

$reportTitle = "Disease Based Visits";
$from = $_GET['from'];
$to = $_GET['to'];
$disease = $_GET['disease'];
$barangay = $_GET['barangay']; 

$fromArr = explode("/", $from);
$toArr = explode("/", $to);

$fromMysql = $fromArr[2] . '-' . $fromArr[0] . '-' . $fromArr[1];
$toMysql = $toArr[2] . '-' . $toArr[0] . '-' . $toArr[1];

$pdf = new LB_PDF('L', false, $reportTitle, $from, $to);
$pdf->SetMargins(15, 10);
$pdf->AliasNbPages();
$pdf->AddPage();

$titlesArr = array(
    '#', 'Visit Date', 'Patient Name',
    'Barangay', 'Contact#', 'Illness'
);

$pdf->SetWidths(array(15, 25, 50, 70, 30, 70));
$pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L'));
$pdf->Ln(15);
$diseaseCaption = strtoupper($disease);
$pdf->AddTableCaption($diseaseCaption);
$pdf->AddTableHeader($titlesArr);

$query = "SELECT 
          pat.*,
          pat.phone_number, 
          pv.visit_date, 
          pv.disease, 
          fam.famID,
          fam.brgy, 
          fam.purok, 
          fam.province, 
          CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS name,
          CONCAT(fam.brgy, ' ', fam.purok, ' ',fam.city_municipality, ' ', fam.province) AS familyaddress
        FROM 
          tbl_patients AS pat
        JOIN 
          tbl_patient_visits AS pv ON pv.patient_id = pat.patientID 
        JOIN 
          tbl_familyaddress AS fam ON pat.family_address = fam.famID
        WHERE 
          pv.visit_date BETWEEN '$fromMysql' AND '$toMysql'
          AND pv.disease LIKE ('%$disease%')
          AND fam.brgy = '$barangay'  -- Add barangay filter
        ORDER BY 
          pv.visit_date ASC";
$stmt = $con->prepare($query);
$stmt->execute();

$i = 0;
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $i++;
    $data = array(
        $i,
        $r['visit_date'],
        $r['name'],
        $r['familyaddress'],
        $r['phone_number'],
        $r['disease']
    );
    $pdf->AddRow($data);
}
ob_clean();
$pdf->Output('print_patient_diseases.pdf', 'D');
