<?php

include("./pdflib/logics-builder-pdf.php");
include './config/connection.php';

$reportTitle = "Patients Visits";
$from = $_GET['from'];
$to = $_GET['to'];

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
	'Address', 'Contact#', 'Illness', 'Doctor'
);

$pdf->SetWidths(array(15, 25, 50, 70, 30, 30, 30));
$pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L'));
// $pdf->Ln();
// $pdf->Ln();
$pdf->Ln(15);

$pdf->AddTableHeader($titlesArr);

$query = "SELECT 
            pat.patientID,per.*,
            CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS name,
            CONCAT(fam.brgy, ' ', fam.purok, ' ', fam.province) AS familyaddress,
			CONCAT(per.first_name , ' ', per.middlename , ' ', per.lastname ) AS doctors_name,
            pat.phone_number, 
		
            GROUP_CONCAT(pv.disease ORDER BY pv.visit_date ASC SEPARATOR ', ') AS diseases,
            MIN(pv.visit_date) AS first_visit_date 
          FROM 
            tbl_patients AS pat
          JOIN 
            tbl_familyaddress AS fam ON pat.family_address = fam.famID
          JOIN 
            tbl_patient_visits AS pv ON pv.patient_id = pat.patientID
          JOIN 
            tbl_users AS d ON pv.doctor_id = d.userID
			JOIN 
            tbl_personnel AS per ON per.personnel_id  = d.personnel_id 
          WHERE 
            pv.visit_date BETWEEN :fromMysql AND :toMysql
          GROUP BY 
            pat.patientID
          ORDER BY 
            first_visit_date DESC";

$stmt = $con->prepare($query);
$stmt->bindParam(':fromMysql', $fromMysql);
$stmt->bindParam(':toMysql', $toMysql);
$stmt->execute();

$i = 0;
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$i++;

	$data = array(
		$i,
		$r['first_visit_date'],
		$r['name'],
		$r['familyaddress'],
		$r['phone_number'],
		$r['diseases'], $r['doctors_name']
	);

	$pdf->AddRow($data);
}
ob_clean();
$pdf->Output('print_patient_visits.pdf', 'I');
