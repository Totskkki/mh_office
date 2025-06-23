<?php

require_once('tcpdf/tcpdf.php');
include './config/connection.php';

ob_start();

if (isset($_GET['recordID'])) {
    $recordId = $_GET['recordID'];

    try {
        // Prepare and execute the SQL query to fetch the record
        $query = "SELECT b.*, 
                         CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                         CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
                  FROM tbl_postpartum b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyAddress a ON a.famID = p.family_address
                  WHERE b.postpartumID = :recordId";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $record = $stmt->fetch(PDO::FETCH_ASSOC);



        class MYPDF extends TCPDF
        {
            // Page header
            public function Header()
            {
                // Leave this empty to remove any header line or content
            }
        }
        if ($record) {
        
            $pageWidth = 348;  // 14 inches in mm (landscape width)
            $pageHeight = 216;
            // Create a new PDF document with A4 size and portrait orientation
            $pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);

            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Postpartum Monitoring Record');
            $pdf->SetSubject('Postpartum Monitoring Record');

            // Set margins (left, top, right)
            $pdf->SetMargins(12.7, 1, 12.7); // Left and right margins set to 12.7 mm (0.5 inches), top margin set to 0

            // Add a page
            $pdf->AddPage();

            // Set font
            $pdf->SetFont('helvetica', '', 8);

            // Set font
          



            $monitoringData = json_decode($record['monitoring_data'], true);


            $checkedImg = 'icons/check.png';  // Replace with actual path
            $uncheckedImg = 'icons/uncheck.png';  // Replace with actual path

            $maternal = ($record['maternal_wellbeing'] === '1. CONSCIOUS') ? $checkedImg : $uncheckedImg;
            $maternals = ($record['maternal_wellbeing'] === '2.PALLOR') ? $checkedImg : $uncheckedImg;

            $UTERINE = ($record['uterine_firmness'] === '1. CONTRACTED') ? $checkedImg : $uncheckedImg;
            $UTERINEs = ($record['uterine_firmness'] === '2. RELAX') ? $checkedImg : $uncheckedImg;

            $HEAVY = ($record['rubra'] === '1. HEAVY') ? $checkedImg : $uncheckedImg;
            $MODERATEs = ($record['rubra'] === '2. MODERATE') ? $checkedImg : $uncheckedImg;
              $SCANTY = ($record['rubra'] === '3. SCANTY') ? $checkedImg : $uncheckedImg;

              $MILD = ($record['perineum_pain'] === '1. MILD(1-3)') ? $checkedImg : $uncheckedImg;
            $MODERATE = ($record['perineum_pain'] === '2. MODERATE(4-6)') ? $checkedImg : $uncheckedImg;
              $STRONG = ($record['perineum_pain'] === '3. STRONG (7-9)') ? $checkedImg : $uncheckedImg;
              $UNDEARABLE = ($record['perineum_pain'] === '4. UNDEARABLE (10)') ? $checkedImg : $uncheckedImg;
            
              $ENGORGED = ($record['breast_condition'] === '1. ENGORGED') ? $checkedImg : $uncheckedImg;
              $SORE = ($record['breast_condition'] === '2. SORE NIPPLE') ? $checkedImg : $uncheckedImg;
  
              $EXCLUSIVE = ($record['feeding'] === '1. EXCLUSIVE BREASTFEEDING') ? $checkedImg : $uncheckedImg;
              $SORFEEDINGE = ($record['feeding'] === '2. MIXED FEEDING') ? $checkedImg : $uncheckedImg;
  
              $FULL = ($record['bladder'] === '1.FULL BLADDER') ? $checkedImg : $uncheckedImg;
              $BLADDER = ($record['bladder'] === '2. EMPTY BLADDER') ? $checkedImg : $uncheckedImg;
  
              $With = ($record['bowel_movement'] === '1. With BM') ? $checkedImg : $uncheckedImg;
              $Wbm = ($record['bowel_movement'] === '2. W/o BM') ? $checkedImg : $uncheckedImg;
  
              $yes = ($record['vaginal_discharge'] === 'Yes') ? $checkedImg : $uncheckedImg;
              $no = ($record['vaginal_discharge'] === 'No') ? $checkedImg : $uncheckedImg;
              
  

              $Proper = ($record['key_messages'] === '1. Proper Nutrition') ? $checkedImg : $uncheckedImg;
              $Personal = ($record['key_messages'] === '2. Personal hygien') ? $checkedImg : $uncheckedImg;
              $Danger = ($record['key_messages'] === '3. Danger signs') ? $checkedImg : $uncheckedImg;
              $Importance = ($record['key_messages'] === '4. Importance of Exclusive Breastfeeding') ? $checkedImg : $uncheckedImg;
              $family = ($record['key_messages'] === '5. Imprtance of family') ? $checkedImg : $uncheckedImg;
              $home = ($record['key_messages'] === '6. Home instruction on Discharge of mother and her') ? $checkedImg : $uncheckedImg;
  
            // Start creating the HTML content
            $html = '<h4 style="text-align:center;">LUTAYAN RHU BIRTHING CENTER</h4>';
            $html .= '<h2 style="text-align:center;">POSTPARTUM MONITORING RECORD</h2>';

            // Patient Information
            $html .= '<h2><strong>Name of Patient:</strong> ' . htmlspecialchars($record['name']) . '  <span>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; Date:  ' . htmlspecialchars($record['date_postpartum']) . '</span></h2>';

            // Monitoring Table
            $html .= '
            <table border="1" cellspacing="0" cellpadding="3">
                <tr>
                    <th colspan="3" border="1">MONITORING AFTER BIRTH</th>
                    <th colspan="4" border="1">Every 5-15 mins for 1st hour</th>
                    <th border="1">2HR</th>
                    <th border="1">3HR</th>
                    <th border="1">4HR</th>
                    <th border="1">8HR</th>
                    <th border="1">12HR</th>
                    <th border="1">16HR</th>
                    <th border="1">20HR</th>
                    <th border="1">24HR</th>
                    <th colspan="2" border="1">Discharge</th>
                </tr>
                <tr>
                    <td colspan="3" border="1"> Date: ' . htmlspecialchars(!empty($monitoringData['date']) ? date('F j, Y', strtotime($monitoringData['date'])) : '') . '</td>

                    <td colspan="3" border="1"> </td>
                    <td colspan="3" border="1"></td>
                    <td colspan="3" border="1"></td>
                 
                   <td colspan="3" border="1"> Date: ' . htmlspecialchars(!empty($monitoringData['monitoring']['date2']) ? date('F j, Y', strtotime($monitoringData['monitoring']['date2'])) : '') . '  </td>

                  
                </tr>
                  
              <tr>
                   <td colspan="3" border="1">Time: ' . htmlspecialchars(!empty($monitoringData['time']) ? date('h:i A', strtotime($monitoringData['time'])) : '') . '</td>';


                   foreach ($monitoringData['monitoring']['every5_15']['times'] as $time) {
                    $html .= '<td border="1">' . (!empty($time) ? htmlspecialchars(date('h:i A', strtotime($time))) : '') . '</td>';
                }
                
                // Ensure blank cells for each missing time interval
                for ($i = count($monitoringData['monitoring']['every5_15']['times']); $i < 15; $i++) {
                    $html .= '<td border="1"></td>';
                }
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['2HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['2HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['3HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['3HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['4HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['4HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['8HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['8HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['12HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['12HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['16HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['16HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['20HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['20HR'])) : '') . '</td>';
            $html .= '<td border="1">' . htmlspecialchars(!empty($monitoringData['monitoring']['24HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['24HR'])) : '') . '</td>';
            $html .= '<td colspan="2">' . htmlspecialchars(!empty($monitoringData['monitoring']['discharge']) ? date('h:i A', strtotime($monitoringData['monitoring']['discharge'])) : '') . '</td>';


            $html .= '</tr>
            
                 <tr>
                    <td colspan="4" border="1">MATERNAL WELL-BEING </td>
                    
                </tr>
                 <tr>
                  <td colspan="4">
                     <img src="' . $maternal . '" width="10" height="10"> 1. CONSCIOUS <br>
                     <img src="' . $maternals . '" width="10" height="10"> 2. PALLOR
                     </td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                 <tr>
                    <td colspan="4" border="1">UTERINE FIRMNESS: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $UTERINE . '" width="10" height="10"> 1. CONTRACTED <br>
                     <img src="' . $UTERINEs . '" width="10" height="10"> 2. RELAX
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                 <tr>
                    <td colspan="4" border="1">RUBRA: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $HEAVY . '" width="10" height="10"> 1. HEAVY <br>
                     <img src="' . $MODERATEs . '" width="10" height="10"> 2. MODERATE<br>
                     <img src="' . $SCANTY . '" width="10" height="10"> 3. SCANTY
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                <tr>
                    <td colspan="4" border="1">PERINEUM/VULVA (PAIN INTENSITY): </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $MILD . '" width="10" height="10"> 1. MILD(1-3) <br>
                     <img src="' . $MODERATE . '" width="10" height="10"> 2. MODERATE(4-6)<br>
                     <img src="' . $STRONG . '" width="10" height="10"> 3. STRONG (7-9) <br>
                     <img src="' . $UNDEARABLE . '" width="10" height="10"> 3. UNDEARABLE (10) 


                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                  <tr>
                    <td colspan="4" border="1">BREAST CONDITION: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $ENGORGED . '" width="10" height="10"> 1. ENGORGED <br>
                     <img src="' . $SORE . '" width="10" height="10"> 2. SORE NIPPLE
                    
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                <tr>
                    <td colspan="4" border="1">FEEDING: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $EXCLUSIVE . '" width="10" height="10"> 1. EXCLUSIVE BREASTFEEDING <br>
                     <img src="' . $SORFEEDINGE . '" width="10" height="10"> 2. MIXED FEEDING
                    
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                  <tr>
                    <td colspan="4" border="1">BLADDER: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $FULL . '" width="10" height="10"> 1. FULL BLADDER <br>
                     <img src="' . $BLADDER . '" width="10" height="10"> 2. EMPTY BLADDER
                    
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
              
                 <tr>
                    <td colspan="4" border="1">BOWEL MOVEMENT: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $With . '" width="10" height="10"> 1. With BM <br>
                     <img src="' . $Wbm . '" width="10" height="10"> 2. W/o BM
                    
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
                 <tr>
                    <td colspan="4" border="1">VAGINAL DISCHARGE(foul smelling): </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $yes . '" width="10" height="10"> Yes <br>
                     <img src="' . $no . '" width="10" height="10">  No
                    
                     </td>
                      <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"> </td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="1" border="1"></td>
                        <td colspan="0" border="1"></td>
                </tr>
              
                <tr>
                    <td colspan="4" border="1">RE-ENFORCE KEY MESSAGES: </td>
                    
                </tr>
                  <tr>
                  <td colspan="4">
                     <img src="' . $Proper . '" width="10" height="10"> 1. Proper Nutrition<br>
                     <img src="' . $Personal . '" width="10" height="10"> 2. Personal hygien <br>
                     <img src="' . $Danger . '" width="10" height="10"> 3.  Danger signs <br>

                     <img src="' . $Importance . '" width="10" height="10"> 4. Importance of Exclusive Breastfeeding <br>

                     <img src="' . $family . '" width="10" height="10"> 5. Imprtance of family <br>
                        <img src="' . $home . '" width="10" height="10"> 6. Home instruction on Discharge of mother and her
                     
                    
                     </td>
                     
                </tr>
            </table>';



            $html .= '<p>Before sending mother and baby home, check the following information to ensure wellness and safety at home:</p>';
            $html .= '<ul>
                        <li>Perform a discharge examination</li>
                        <li>Ask about general feeling, pain, urge of urination and if there are problems</li>
                        <li>Check vital signs, mother\'s breast if filling or engorged, and condition of nipple in preparation for breastfeeding</li>
                        <li>Check abdomen for uterine contraction and signs of bladder distention</li>
                        <li>Check perineum for tearing, sign of swelling if with sutures, and condition of the wound; foul smelling discharge, or any profuse lochia</li>
                        <li>Avoid frozen findings, it can help you make right and timely decisions for the care of the woman.</li>
                      </ul>';
            $html .= '<p>Repeat important health information. Allow mother to reapet home instructions to ensure mother\'s understanding on the information given.</p>';
            $html .= '<p>Make schedule for the \'Return Visit\'.</p>';
            $html .= '<ul>
                      <li> All postpartum women should have atleast (2)postpartum visits. Advice for family planning </li>
                      <li> Recommend schedule for postpartum care.</li>
                       <li> 1st POSTPARTUM CARE: After 24 hours after delivery</li>
                        <li> 2nd POSTPARTUM CARE: After 7 days from discharge</li>
                     
                     
                    </ul>';



            // Output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Close and output PDF document
            $pdf->Output('Postpartum_Record_' . $recordId . '.pdf', 'I');
        } else {
            echo "Record not found!";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}

ob_end_flush();
