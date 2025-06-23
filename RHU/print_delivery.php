<?php
require_once('tcpdf/tcpdf.php');
include './config/connection.php';
ob_start();

if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    try {
        // Fetch record as usual
        $query = "SELECT b.*, p.*, a.*,bi.*,com.*,u.*,per.*,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                  CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address,
                   CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS physicianName

                  FROM tbl_birthroom b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyAddress a ON a.famID = p.family_address
                  LEFT JOIN tbl_birth_info bi ON bi.patient_id = b.patient_id
                  LEFT JOIN tbl_complaints com on com.patient_id = b.patient_id
          
                  LEFT JOIN tbl_users u ON u.userID = b.physician
                     LEFT JOIN tbl_personnel per ON u.personnel_id = per.personnel_id
                  
                  WHERE b.roomID  = :recordId";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {

            $pageWidth = 348;  // 14 inches in mm (landscape width)
            $pageHeight = 216; // 8.5 inches in mm (landscape height)
            
            // Create a new PDF document with custom page size and landscape orientation
            $pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);
            // Portrait page setup
           
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Joven Rey Flores');
            $pdf->SetTitle('DELIVERY ROOM RECORD');
            $pdf->SetSubject('DELIVERY ROOM Report');
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 9);


            $method_delivery = json_decode('method_delivery');       
            $laborData = json_decode($record['labor'], true); 
            $placentaData = json_decode($record['placenta'], true);
            $method_delivery = json_decode($record['method_delivery'], true);



            // Image paths
            $checkedImg = 'icons/check.png'; 
            $uncheckedImg = 'icons/uncheck.png';  

            // Check each method's presence in the array
            $nsvd = in_array("NSVD", $method_delivery) ? $checkedImg : $uncheckedImg;
            $ltccs = in_array("LTCCS", $method_delivery) ? $checkedImg : $uncheckedImg;
            $tbe = in_array("TBE", $method_delivery) ? $checkedImg : $uncheckedImg;
            $pbe = in_array("PBE", $method_delivery) ? $checkedImg : $uncheckedImg;
            $of = in_array("OF", $method_delivery) ? $checkedImg : $uncheckedImg;
            $lf = in_array("LF", $method_delivery) ? $checkedImg : $uncheckedImg;
            $ccs = in_array("CCS", $method_delivery) ? $checkedImg : $uncheckedImg;
            $me = in_array("ME", $method_delivery) ? $checkedImg : $uncheckedImg;
            //   $other = in_array("Other", $method_delivery) ? $checkedImg : $uncheckedImg;

            $other = '';
            $otherDetails = '';

            // Check if 'Other' is in the array and retrieve any additional text details (e.g., "test")
            if (is_array($method_delivery) && in_array("Other", $method_delivery)) {
                $other = $checkedImg;  // Set checked icon
                // Retrieve the index of "Other" and check if there's a next item for the details
                $otherIndex = array_search("Other", $method_delivery);
                $otherDetails = isset($method_delivery[$otherIndex + 1]) ? $method_delivery[$otherIndex + 1] : '';
            } else {
                $other = $uncheckedImg;  // Set unchecked icon
            }


            $Episiotomy = json_decode($record['Episiotomy'], true);

            $checked = 'icons/check.png'; 
            $unchecked = 'icons/uncheck.png';  
            $median = in_array("Median", $Episiotomy) ? $checked : $unchecked;
            $rightMedLateral = in_array("Right Med. Lateral", $Episiotomy) ? $checked : $unchecked;
            $leftMedLateral = in_array("Left Med. Lateral", $Episiotomy) ? $checked : $unchecked;
            $none = in_array("None", $Episiotomy) ? $checked : $unchecked;
            $extension = in_array("Extension", $Episiotomy) ? $checked : $unchecked;

            $Laceration = json_decode($record['Laceration'], true);

            $Perinial  = in_array("Perinial 1 2 3", $Laceration) ? $checked : $unchecked;
            $Vaginal = in_array("Vaginal", $Laceration) ? $checked : $unchecked;
            $Cervical = in_array("Cervical", $Laceration) ? $checked : $unchecked;
            $Repaired = in_array("Repaired", $Laceration) ? $checked : $unchecked;
            $Not_Repaired = in_array("Not Repaired", $Laceration) ? $checked : $unchecked;

            $Anethesia = json_decode($record['Anethesia'], true);

            $Infiltration  = in_array("Local Infiltration", $Anethesia) ? $checked : $unchecked;
            $Inhalation = in_array("General Inhalation", $Anethesia) ? $checked : $unchecked;
            $None = in_array("None", $Anethesia) ? $checked : $unchecked;

            $Analgesia = json_decode($record['Analgesia'], true);

            $Yes  = in_array("Yes", $Analgesia) ? $checked : $unchecked;     
            $none = in_array("None", $Analgesia) ? $checked : $unchecked;


            $condition = json_decode($record['condition'], true);

            $Awake  = in_array("Awake", $condition) ? $checked : $unchecked;     
            $Reactive = in_array("Reactive", $condition) ? $checked : $unchecked;
            $Depressed = in_array("Depressed", $condition) ? $checked : $unchecked;
          

            
            $urinary_bladder = json_decode($record['urinary_bladder'], true);

            $Catheter  = in_array("W/Catheter", $urinary_bladder) ? $checked : $unchecked;     
            $Voided = in_array("Voided", $urinary_bladder) ? $checked : $unchecked;
            $Urine = in_array("Total Urine Output", $urinary_bladder) ? $checked : $unchecked;
          

              
            $uterus = json_decode($record['uterus'], true);

            $Contracted  = in_array("Well Contracted", $uterus) ? $checked : $unchecked;     
            $Relaxing = in_array("Relaxing", $uterus) ? $checked : $unchecked;
           
          


            // Header with logo and titles (centered)
            $html = '
            <div style="width: 100%; text-align: center;">
                <table cellpadding="5" style="margin: 0 auto;">
                    <tr>
                        <td style="text-align: right; vertical-align: middle; padding-right: 10px;">
                            <img src="../logo/2.png" height="50" width="50" />
                        </td>
                        <td style="text-align: left; vertical-align: middle;">
                            <strong>LUTAYAN RHU BIRTHING CENTER</strong><br/>
                             Brgy. Tamnag, Lutayan, Sultan Kudarat<br/>
                             Tel. #: (083)-228-1528
                        </td>
                    </tr>
                </table>
            </div>
            <h2 style="text-align: center;">DELIVERY ROOM RECORD</h2>
        ';
        
            // Patient information table
            $html .= '
                <table  cellpadding="4">
                    <tr>
                        <td colspan="2"><strong>Patient\'s Name:</strong> ' . $record['name'] . '</td>
                        <td><strong>Age:</strong> ' . $record['age'] . '</td>
                        <td><strong>Date Admitted:</strong> ' . $record['dateAdmitted'] . '</td>
                    </tr>
                    <tr>
                        <td><strong>LMP:</strong> ' . $record['LMP'] . '</td>
                        <td><strong>EDC:</strong> ' . $record['EDC'] . '</td>
                        <td><strong>AOG:</strong> ' . $record['AOG'] . '</td>
                        <td><strong>Gravida:</strong> ' . $record['gravida'] . '</td>
                    </tr>
                    <tr>
                        <td><strong>Para:</strong> ' . $record['para'] . '</td>
                        <td><strong>Full Term:</strong> ' . $record['fullTerm'] . '</td>
                        <td><strong>Premature:</strong> ' . $record['premature'] . '</td>
                        <td><strong>Abortion:</strong> ' . $record['abortion'] . '</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>No. of Living:</strong> ' . $record['noOfLiving'] . '</td>
                        
                    </tr>
                </table><br/>
            ';



            $html .= '
            <h4><strong>LABOR:</strong></h4>
            <table border="1" cellpadding="4">
                <tr>
                    <th ><strong>Type</strong></th>
                    <th><strong>Time</strong></th>
                    <th><strong>Date</strong></th>
                    <th><strong>Stage of Labor</strong></th>
                    <th><strong>Duration of Labor (hrs)</strong></th>
                    <th><strong>Duration of Labor (mins)</strong></th>
                </tr>
        ';

            // Labor stages and their corresponding details
            $laborStages = [
                'Type' => [
                    'time' => $laborData['labor']['time'],
                    'date' => $laborData['labor']['date'],
                    'stage' => 'I',
                    'duration' => $laborData['labor']['duration'],
                    'types' => htmlspecialchars(implode(", ", $laborData['labor']['types']))

                ],
                'Cervix Fully Dilated' => [
                    'time' => $laborData['cervix']['time'],
                    'date' => $laborData['cervix']['date'],
                    'stage' => 'II',
                    'duration' => $laborData['cervix']['duration']
                ],
                'Baby Delivered' => [
                    'time' => $laborData['baby']['time'],
                    'date' => $laborData['baby']['date'],
                    'stage' => 'III',
                    'duration' => $laborData['baby']['duration']
                ],
                'Placenta Delivered' => [
                    'time' => $laborData['placenta']['time'],
                    'date' => $laborData['placenta']['date'],
                    'stage' => 'Total Duration', // Assuming this is the next stage
                    'duration' => $laborData['placenta']['duration']
                ],
            ];




            // Loop through each labor stage and add it to the HTML table
            foreach ($laborStages as $type => $details) {
                if ($type == 'Type') {
                    // Display the labor types in the "Onset" row
                    $html .= '
                  <tr>
                      <td >' . htmlspecialchars($type) . ' ( ' . $details['types'] . ')</td>
                      <td >' . htmlspecialchars(date('h:i A', strtotime($details['time']))) . '</td>
                      <td >' . htmlspecialchars($details['date']) . '</td>
                      <td >' . htmlspecialchars($details['stage']) . '</td>
                      <td >' . htmlspecialchars($details['duration']['hrs']) . '</td>
                      <td >' . htmlspecialchars($details['duration']['mins']) . '</td>
                  </tr>
              ';
                } else {
                    // Display other stages normally
                    $html .= '
                  <tr>
                      <td>' . htmlspecialchars($type) . '</td>
                      <td >' . htmlspecialchars(date('h:i A', strtotime($details['time']))) . '</td>
                      <td>' . htmlspecialchars($details['date']) . '</td>
                      <td>' . htmlspecialchars($details['stage']) . '</td>
                      <td>' . htmlspecialchars($details['duration']['hrs']) . '</td>
                      <td>' . htmlspecialchars($details['duration']['mins']) . '</td>
                  </tr>
              ';
                }
            }


            // Calculate total duration for the footer
            $totalHrs = $laborData['labor']['duration']['hrs'] + $laborData['cervix']['duration']['hrs'] + $laborData['baby']['duration']['hrs'] ;
            $totalMins = $laborData['labor']['duration']['mins'] + $laborData['cervix']['duration']['mins'] + $laborData['baby']['duration']['mins'] ;

            // Adjust minutes to hours if necessary
            if ($totalMins >= 60) {
                $totalHrs += floor($totalMins / 60);
                $totalMins = $totalMins % 60;
            }

            // Add total duration row
            $html .= '
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total Duration:</strong></td>
                <td>' . $totalHrs . '</td>
                <td>' . $totalMins . '</td>
            </tr>
        ';

            $html .= '</table><br/>';


            $html .= '
        <h4><strong>PLACENTA:</strong></h4>
        <table border="1" cellpadding="4">
            <tr>
                <th><strong>Expelled</strong></th>
                <th><strong>Umbilical Cord</strong></th>
                <th><strong>Estimated Blood Loss</strong></th>
            </tr>
        ';

            // Check if placenta data exists
            if (isset($placentaData['placenta'])) {
                // Get expelled data
                $expelled = isset($placentaData['placenta']['expelled']) ? $placentaData['placenta']['expelled'] : [];

                // Get umbilical cord data
                $umbilicalCord = isset($placentaData['umbilicalCord']) ? $placentaData['umbilicalCord'] : [];

                $umbilicalCord = [
                    'cm' => $placentaData['umbilicalCord']['cm'] ?? 'N/A',
                    'loops' => $placentaData['umbilicalCord']['loops'] ?? 'N/A',
                    'none' => $placentaData['umbilicalCord']['none'] ?? 'N/A',
                    'other' => $placentaData['other'] ?? 'N/A' // Assuming 'other' is the input for Other Abnormalities
                ];

                // Get blood loss data
                $bloodLoss = isset($placentaData['bloodLoss']) ? $placentaData['bloodLoss'] : [];

                $antepartum = (int)($bloodLoss['antepartum'] ?? 0);
                $intrapartum = (int)($bloodLoss['intrapartum'] ?? 0);
                $postpartum = (int)($bloodLoss['postpartum'] ?? 0);
                $totalBloodLoss = $antepartum + $intrapartum + $postpartum;

                // Loop through expelled data
                foreach ($expelled as $item) {
                    $html .= '
                    <tr>
                        <td>' . htmlspecialchars($item) . '</td>
                           <td>' . htmlspecialchars($umbilicalCord['cm']) . ' cm, ' .
                        htmlspecialchars($umbilicalCord['loops']) . ' , ' .
                        htmlspecialchars($umbilicalCord['none']) . ' , ' .
                        htmlspecialchars($umbilicalCord['other']) . '
                                </td>
                         <td>Antepartum:' . htmlspecialchars($antepartum) . '  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  CC<br/>' .
                        'Intrapartum: ' . htmlspecialchars($intrapartum) . '&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  CC<br/> ' .
                        'Postpartum: ' . htmlspecialchars($postpartum) . '&nbsp; &nbsp; &nbsp; &nbsp;  CC <br/>' .
                        'Total: ' . htmlspecialchars($totalBloodLoss) . '&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;  CC
                </td>
                    </tr>
                ';
                }
            } else {
                $html .= '
                <tr>
                    <td colspan="3">No placenta data available.</td>
                </tr>
            ';
            }

            $html .= '</table><br/>';


            $html .= '
        <h4><strong>METHOD OF DELIVERY:</strong></h4>
        <table >
            <tr>
                <td><strong>NSVD:</strong> <img src="' . htmlspecialchars($nsvd) .  '" width="10" height="10">  <img src="' . '" alt="NSVD Icon"></td>
                <td><strong>LTCCS:</strong> <img src="' . htmlspecialchars($ltccs) . '" width="10" height="10">  <img src="' . '" alt="LTCCS Icon"></td>
                <td><strong>TBE:</strong> <img src="' . htmlspecialchars($tbe) . '" width="10" height="10">  <img src="' . '" alt="TBE Icon"></td>
                <td><strong>PBE:</strong> <img src="' . htmlspecialchars($pbe) . '" width="10" height="10">  <img src="' . '" alt="PBE Icon"></td>
                <td><strong>OF:</strong> <img src="' . htmlspecialchars($of) . '" width="10" height="10">  <img src="' . '" alt="OF Icon"></td>
                <td><strong>LF:</strong> <img src="' . htmlspecialchars($lf) . '" width="10" height="10">  <img src="' . '" alt="LF Icon"></td>
                <td><strong>CCS:</strong> <img src="' . htmlspecialchars($ccs) . '" width="10" height="10">  <img src="' . '" alt="CCS Icon"></td>
                <td><strong>ME:</strong> <img src="' . htmlspecialchars($me) . '" width="10" height="10">  <img src="' . '" alt="ME Icon"></td>
           <td><strong>Other:</strong> <img src="' . htmlspecialchars($other) .  '" width="10" height="10"> ' .
                ($otherDetails ? ' (' . htmlspecialchars($otherDetails) . ')' : '') . '</td>
            </tr>
        </table><br/>
        ';
            // INDICATION FOR OPERATIVE DELIVERY
            $html .= '
            <h4><strong>INDICATION FOR OPERATIVE DELIVERY:</strong></h4>
            <table>
                <tr>
                   
                       <td><strong>Episiotomy:</strong> </td>
                    <td><strong>Median:</strong> <img src="' . htmlspecialchars($median) . '" width="10" height="10"></td>
                    <td><strong>Right Med. Lateral:</strong> <img src="' . htmlspecialchars($rightMedLateral) . '" width="10" height="10"></td>
                    <td><strong>Left Med. Lateral:</strong> <img src="' . htmlspecialchars($leftMedLateral) . '" width="10" height="10"></td>
                    <td><strong>None:</strong> <img src="' . htmlspecialchars($none) . '" width="10" height="10"></td>
                    <td><strong>Extension:</strong> <img src="' . htmlspecialchars($extension) . '" width="10" height="10"></td>
                </tr>
            </table><br/>
        ';

        $html .= '
       
        <table>
            <tr>
               
                   <td><strong>Laceration:</strong> </td>
                <td><strong>Perinial 1" 2" 3":</strong> <img src="' . htmlspecialchars($Perinial) . '" width="10" height="10"></td>
                <td><strong>Vaginal:</strong> <img src="' . htmlspecialchars($Vaginal) . '" width="10" height="10"></td>
                <td><strong>Cervical:</strong> <img src="' . htmlspecialchars($Cervical) . '" width="10" height="10"></td>
                <td><strong>Repaired:</strong> <img src="' . htmlspecialchars($Repaired) . '" width="10" height="10"></td>
                <td><strong>Not Repaired:</strong> <img src="' . htmlspecialchars($Not_Repaired) . '" width="10" height="10"></td>
            </tr>
        </table><br/>
    ';
    $html .= '
       
    <table>
        <tr>
           
               <td><strong>Anethesia:</strong> </td>
            <td><strong>Local Infiltration:</strong> <img src="' . htmlspecialchars($Infiltration) . '" width="10" height="10"></td>
            <td><strong>General Inhalation</strong> <img src="' . htmlspecialchars($Inhalation) . '" width="10" height="10"></td>
            <td><strong>None</strong> <img src="' . htmlspecialchars($None) . '" width="10" height="10"></td>
           
           
        </tr>
    </table><br/>
';
    $html .= '
      
        <table>
            <tr>
               
                   <td><strong>Analgesia:</strong> </td>
                <td><strong>Yes:</strong> <img src="' . htmlspecialchars($Yes) . '" width="10" height="10"></td>
                <td><strong>None</strong> <img src="' . htmlspecialchars($none) . '" width="10" height="10"></td>
               
               
            </tr>
        </table><br/>
    ';

    $html .= '

          <h4><strong>CONDITION UPON LEAVING THE DELIVERY ROOM:</strong></h4>
    <table>
        <tr>
           
           
            <td><strong>Awake:</strong> <img src="' . htmlspecialchars($Awake) . '" width="10" height="10"></td>
            <td><strong>Reactive</strong> <img src="' . htmlspecialchars($Reactive) . '" width="10" height="10"></td>
            <td><strong>Depressed</strong> <img src="' . htmlspecialchars($Depressed) . '" width="10" height="10"></td>
           
           
        </tr>
    </table><br/>
';
$html .= '

          <h4><strong>URINARY BLADDER:</strong></h4>
    <table>
        <tr>
           
           
            <td><strong>W/Catheter:</strong> <img src="' . htmlspecialchars($Catheter) . '" width="10" height="10"></td>
            <td><strong>Voided</strong> <img src="' . htmlspecialchars($Voided) . '" width="10" height="10"></td>
            <td><strong>Total Urine Output</strong> <img src="' . htmlspecialchars($Urine) . '" width="10" height="10"></td>
           
           
        </tr>
    </table><br/>
';
$html .= '

          <h4><strong>VITAL SIGNS:</strong></h4>
    <table>
        <tr>
           
           
            <td><strong>BP:</strong> ' . htmlspecialchars($record['bp']) . '</td>
            <td><strong>PR:</strong> ' . htmlspecialchars($record['pr']) . '</td>
            <td><strong>RR:</strong> ' . htmlspecialchars($record['rr']) . '</td>
            <td><strong>T:</strong> ' . htmlspecialchars($record['temp']) . '</td>
           
           
        </tr>
    </table><br/>
';

$html .= '

          <h4><strong>UTERUS:</strong></h4>
    <table>
        <tr>
           
           
            <td><strong>Well Contracted</strong> <img src="' . htmlspecialchars($Contracted) . '" width="10" height="10"></td>
            <td><strong>Relaxing</strong> <img src="' . htmlspecialchars($Relaxing) . '" width="10" height="10"></td>
            
           
           
        </tr>
    </table><br/>
';



$html .= '

    <table>
        <tr>
       
           
            <td><br/><strong>COMPLICATIONS RELATED TO PREGNANCY:</strong> ' . htmlspecialchars($record['pregnancy']) . '<br/>
            <strong>COMPLICATIONS NOT RELATED TO PREGNANCY:</strong> ' . htmlspecialchars($record['not_related']) . '<br/>
<strong>COMPLICATION OF LABOR:</strong> ' . htmlspecialchars($record['complications']) . '
            
            
            </td>
         
            
           
           
        </tr>
    </table><br/>
';
$html .= '
<h4></h4>
    <table>
        <tr>
           
           
            <td><strong>Handled by:</strong> ' . htmlspecialchars($record['Handled_by']) . '</td>
            <td> <strong>Assisted by:</strong> ' . htmlspecialchars($record['assisted_by']) . '</td>
            <td><strong>Physician on duty:</strong> ' . htmlspecialchars($record['physicianName']) . '</td>

            
            
          
         
            
           
           
        </tr>
    </table><br/>
';



            // Output the content to PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Close and output the PDF
            $pdf->Output('Delivery_Room_Record.pdf', 'I');
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
