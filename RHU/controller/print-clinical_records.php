<?php

require_once('../tcpdf/tcpdf.php');
include '../config/connection.php';
ob_start();




if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    $query = "SELECT   c.*,pat.*, fam.*, mem.*, com.*, b.*, d.date_discharged, u.*,per.*,famMem.*, famMem.contact, 
            	CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
                CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) AS address1,
                DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`
              FROM `tbl_clinicalrecords` AS c
              LEFT JOIN `tbl_patients` AS pat ON c.`patient_id` = pat.`patientID`
              LEFT JOIN `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
              LEFT JOIN `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
              LEFT JOIN `tbl_complaints` AS com ON pat.`patientID` = com.`patient_id`
              LEFT JOIN `tbl_birthing_monitoring` AS b ON b.`patient_id` = pat.`patientID`
              LEFT JOIN `tbl_discharged` AS d ON d.`patientid` = pat.`patientID`
              LEFT JOIN `tbl_birth_info` AS bi ON bi.`patient_id` = pat.`patientID`
              LEFT JOIN tbl_users AS u on u.userID  = bi.midwife_nurse
              LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id 
              LEFT JOIN tbl_family_members AS famMem ON famMem.patient_id = pat.patientID     
              WHERE     c.`patient_id` = :id
              ORDER BY c.created_at DESC";


    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $patientId, PDO::PARAM_INT);
    $stmt->execute();
    $patientData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details



    if ($patientData) {
        $pageWidth = 348;  // 14 inches in mm (landscape width)
        $pageHeight = 216; // 8.5 inches in mm (landscape height)
        
        // Create a new PDF document with custom page size and landscape orientation
        $pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);

      
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Joven Rey Flores');
        $pdf->SetTitle('Clinical Cover Sheet');
        $pdf->SetSubject('Clinical Cover Sheet');


        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 10);


        $imagePath = '../logo/2.png'; 

// Add image using TCPDF's Image() method
$pdf->Image($imagePath, 15, 15, 20, 20, '', '', 'T', false, 300, '', false, false, 1, false, false, false);


      
$html = '
<div style="width: 100%; text-align: center;">
    <table cellpadding="5" style="margin: 0 auto;">
        <tr>
            <td style="text-align: right; vertical-align: middle; padding-left: 10px;">
                <strong>LUTAYAN RHU BIRTHING CENTER</strong><br/>
                Brgy. Tamnag, Lutayan, Sultan Kudarat<br/>
                Email: lutayan_rhu@yahoo.com.ph<br/>
                Tel. #: (083)-228-1528
            </td>
        </tr>
    </table>
</div>
<hr/>
';

$pdf->writeHTML($html, true, false, true, false, '');

        $html = '
        <h2 >CLINICAL COVER SHEET</h2>
        
        <table border="1" cellpadding="5">
            <tr>
                <td colspan="4"><strong>Name of Patient:</strong> <u>' . $patientData['name'] . '</u></td>
                <td><strong>Case No.</strong> <u>' . $patientData['case_no'] . '</u></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Permanent Address:</strong> <u>' . $patientData['address1'] . '</u></td>
            </tr>
            <tr>
                <td><strong>Date of Birth:</strong> <u>' . $patientData['date_of_birth'] . '</u></td>
                <td><strong>Age:</strong> <u>' . $patientData['age'] . '</u></td>
                <td><strong>Sex:</strong> <u>' . $patientData['gender'] . '</u></td>
                <td><strong>Place of Birth:</strong> <u>' . $patientData['place_of_birth'] . '</u></td>
                <td><strong>Nationality:</strong> <u>' . $patientData['Nationality'] . '</u></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Employer:</strong> <u>' . $patientData['employer'] . '</u></td>
                <td colspan="2"><strong>Address:</strong><br> <u>' . $patientData['empaddress'] . '</u></td>
                <td colspan="2"><strong>Telephone/ CellNo.:</strong><br> <u>' . $patientData['tel_cell-no'] . '</u></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Name of Father/Guardian:</strong> <u>' . $patientData['father_guardian_name'] . '</u></td>
                <td colspan="2"><strong>Address:</strong> <u>' . $patientData['address'] . '</u></td>
                 <td colspan="2"><strong>Telephone/ CellNo.:</strong><br> <u>' . $patientData['contact'] . '</u></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Name of Mother (Maiden Name):</strong> <u>' . $patientData['mother_name'] . '</u></td>
                <td colspan="2"><strong>Address:</strong> <u>' . $patientData['address'] . '</u></td>
                 <td colspan="2"><strong>Telephone/ CellNo.:</strong><br> <u>' . $patientData['contact'] . '</u></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Admission:</strong><br>
                <u>Date:' . $patientData['admission_date'] . '</u> <strong>Time:</strong> <u>' . $patientData['admission_time'] . '</u>
                </td>
         
                <td ><strong>Discharge:</strong><br>
                <u>Date:' . $patientData['date_discharged'] . '</u> <strong>Time:</strong> <u>' . $patientData['dischargeTime'] . '</u></td>
              <td colspan="3"><u>' . $patientData['admitting_midwife'] . '</u><br><strong>Admitting Midwife/Nurse:</strong> </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Type of Admission:</strong> <u>' . $patientData['type_of_admission'] . '</u></td>
                <td colspan="3"><strong>Referred By:</strong> <u>' . $patientData['refferred'] . '</u></td>
                
            </tr>
            <tr>
                <td colspan="2"><strong>PhilHealth No:</strong> <u>' . $patientData['philhealth_no'] . '</u></td>
                <td colspan="2"><strong>Membership Category:</strong> <u>' . $patientData['ps_mem'] . '</u></td>
                <td><strong>Membership:</strong> <u>' . $patientData['phil_membership'] . '</u></td>
            </tr>
            <tr>
                <td colspan="1"><strong>Data Furnished By:</strong> <br><u>' . $patientData['datafurnished'] . '</u></td>
          
                  <td colspan="2"><strong>Admitting Address:</strong><br> <u>' . $patientData['datafurnishedaddress'] . '</u></td>
                    <td colspan="2"><strong>Admitting Relation to Patient:</strong><br> <u>' . $patientData['relationship'] . '</u></td>
          
                </tr>
            <tr>
                <td colspan="5"><strong>Admitting Diagnosis:</strong> <u>' . $patientData['admitting_diagnosis'] . '</u></td>
            </tr>
            <tr>
                <td colspan="5"><strong>Final Diagnosis:</strong> <u>' . $patientData['final_diagnosis'] . '</u></td>
            </tr>
            <tr>
                <td colspan="5"><strong>Procedure Done:</strong> <u>' . $patientData['procedure_done'] . '</u></td>
            </tr>
            <tr>
                <td colspan="5"><strong>Disposition:</strong> 
                    <u>' . $patientData['disposition'] . '</u>
                </td>
            </tr>
            
            
        </table>
        <h3 style="text-align:right;"><u>' . $patientData['admitting_midwife'] . '</u><br><strong>Midwife/Nurse on Duty</strong> </h3>
        ';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        // Close and output PDF document
        $pdf->Output('Doctor_notes.pdf', 'I');
    } else {
        echo "No doctor's notes found for this patient!";
    }
} else {
    echo "Invalid request!";
}





ob_end_flush();
