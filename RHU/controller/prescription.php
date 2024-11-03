<?php
// require_once('../tcpdf/tcpdf.php');
// include '../config/connection.php';
// ob_start(); 
// // Check if the vaccination ID is set
// if (isset($_GET['id'])) {
//     $vaccinationId = $_GET['id'];

//     // Fetch the patient and vaccination details
//     $query = "SELECT av.*, p.*, ad.*,
//     CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
//     CONCAT(ad.brgy, ' ', ad.city_municipality, ' ', ad.province) AS address
//     FROM tbl_patient_visits av
//     LEFT JOIN tbl_patients p ON p.patientID = av.patient_id
//     LEFT JOIN tbl_familyaddress ad ON ad.famID = p.family_address
//     LEFT JOIN tbl_patient_medication_history  pm ON pm.patient_visit_id  =av.patient_visitID 

//     WHERE av.patient_id = :patient_id ";

//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':patient_id', $vaccinationId, PDO::PARAM_INT);
//     $stmt->execute();

//     $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     if ($records) {
//         // Page dimensions: 127mm x 153mm (portrait orientation)
//         $pageWidth = 127;
//         $pageHeight = 160;

//         // Create a new PDF document with custom page size and portrait orientation
//         $pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);

//         // Set document information
//         $pdf->SetCreator(PDF_CREATOR);
//         $pdf->SetAuthor('Joven Rey Flores');
//         $pdf->SetTitle('ANIMAL BITE VACCINE FORM');
//         $pdf->SetSubject('ANIMAL BITE VACCINE FORM REPORT');

//         $pdf->SetHeaderMargin(0);
//         $pdf->SetFooterMargin(0);

//         // Add a page
//         $pdf->AddPage();

//         // Set font
//         $pdf->SetFont('helvetica', '', 8);

//         $logoPath = '../../logo/animalbite.png';

       
    

//         // Generate HTML content for the PDF
//         $html = '
//         <table border="1" cellpadding="4" cellspacing="0">
//             <tr>
//                 <td colspan="2">
//                     <img src="' . $logoPath . '" width="200px" height="50px"> 
//                 </td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Registration No.:</b> ' . $records[0]['reg_no'] . ' &nbsp; &nbsp; &nbsp; <span><b>Date:</b> ' . $records[0]['date'] . '</span></td>
//             </tr>
//             <tr>
//                 <td><b>Name:</b> ' . strtoupper($records[0]['name']) . '</td>
//                 <td><b>Age:</b> ' . $records[0]['age'] . '</td>
//             </tr>
//             <tr>
//                 <td><b>Address:</b> ' . strtoupper($records[0]['address']) . '</td>
//                 <td><b>Sex:</b> ' . $records[0]['gender'] . '</td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>History of Exposure</b></td>
//             </tr>
//             <tr>
//                 <td colspan="2">
//                     <ul>
//                         <li><b>Date:</b> ' . $records[0]['date_bite'] . '</li>
//                         <li><b>Place:</b> ' . $records[0]['Place'] . '</li>
//                         <li><b>Type:</b> ' . $typeToShow . ' <b>Source:</b> ' . $records[0]['animal_type'] . '</li>
//                     </ul>
//                 </td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Category of Exposure:</b> <u>' . $records[0]['category_exposure'] . '</u> &nbsp; <span><b>PEP:</b>______________</span></td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Washing of Bite Wound:</b> ' . $records[0]['washed'] . '</td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>RIG:</b>____________ </td>
//             </tr>
//             <tr>
//                 <td colspan="2"><b>Anti-Rabies Vaccine:</b>_______________<span>Route____________</span></td>
//             </tr>';

//         // Prepare the HTML for the vaccination records
//         $html .= '<tr><td colspan="2"><b>Vaccination Records:</b></td></tr><tr><td colspan="2"><ul>';

//         foreach ($records as $record) {
//             switch ($record['dose_status']) {
//                 case 1:
//                     $doseLabel = 'D0';
//                     break;
//                 case 2:
//                     $doseLabel = 'D3';
//                     break;
//                 case 3:
//                     $doseLabel = 'D7';
//                     break;
//                 case 4:
//                     $doseLabel = 'D14(IM)';
//                     break;
//                 case 5:
//                     $doseLabel = 'D28/30';
//                     break;
//                 default:
//                     $doseLabel = 'Unknown Dose';
//                     break;
//             }

       
//             $html .= '<li><b>' . $doseLabel . ':</b> ' . date("Y-m-d", strtotime($record['vaccination_date'])) . '</li>';
//         }

//         $html .= '</ul></td></tr>';

//         $html .= '
//             <tr>
//                 <td colspan="2"><b>Status of animal 14 days after exposure:</b> ' . $records[0]['animal_status'] . '</td>
//             </tr>
//             <tr>
//               <td colspan="2"><b>Remarks:</b> ' . $latestRemarks. '</td>
//             </tr>
//         </table>';

     
//         $pdf->writeHTML($html, true, false, true, false, '');
//         $patientName = strtoupper($records[0]['name']); // Retrieve and format the patient's name
//         $vaccinationDate = date('Y-m-d', strtotime($records[0]['vaccination_date'])); // Format the vaccination date

//         $filename = '' . str_replace(' ', '_', $patientName) . '_' . $vaccinationDate . '.pdf';
//         $pdf->Output($filename, 'D');
        
        
      
//     } else {
//         echo "No records found!";
//     }
// } else {
//     echo "Invalid request!";
// }
// ob_end_flush(); 
?>
