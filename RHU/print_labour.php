<?php

require_once('tcpdf/tcpdf.php');
include './config/connection.php';
ob_start();

if (isset($_GET['recordID'])) {
    $recordId = $_GET['recordID'];

    try {
        // Prepare and execute the SQL query to fetch the record
        $query = "SELECT b.*, p.*, a.* ,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                   CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
                  FROM tbl_birthing_monitoring b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyAddress a ON a.famID = p.family_address
                  WHERE b.birthMonitorID = :recordId";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the record
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            $pageWidth = 348;  
            $pageHeight = 220; 
            
            // Create a new PDF document with custom page size and landscape orientation
            $pdf = new TCPDF('L', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);


            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Joven Rey Flores');
            $pdf->SetTitle('LABOUR RECORD');
            $pdf->SetSubject('LABOUR Report');

            // Add a page
            $pdf->AddPage();

            // Set font
            $pdf->SetFont('helvetica', '', 9);

            // Image paths
            $checkedImg = 'icons/check.png';  // Replace with actual path
            $uncheckedImg = 'icons/uncheck.png';  // Replace with actual path

          
            // Determine the checkbox states
            $liveBirthImg = ($record['live_birth'] === 'Livebirth') ? $checkedImg : $uncheckedImg;
            $stillbirthImg = ($record['live_birth'] === 'Stillbirth-Fresh') ? $checkedImg : $uncheckedImg;

            $placenta_complete = ($record['placenta_complete'] === 'Yes') ? $checkedImg : $uncheckedImg;
            $placenta_completed = ($record['placenta_complete'] === 'No') ? $checkedImg : $uncheckedImg;

            $preterm = ($record['preterm'] === 'Yes') ? $checkedImg : $uncheckedImg;
            $pretermed = ($record['preterm'] === 'No') ? $checkedImg : $uncheckedImg;


            $rupturedMembranes = json_decode($record['ruptured_membranes'], true);
            $vaginalBleeding = json_decode($record['vaginal_bleeding'], true);
            $strong_contractions = json_decode($record['strong_contractions'], true);
            $fetal_heart_rate = json_decode($record['fetal_heart_rate'], true);
            $temperature_axillary = json_decode($record['temperature_axillary'], true);
            $pulse = json_decode($record['pulse'], true);
            $respiratory_rate = json_decode($record['respiratory_rate'], true);
            $blood_pressure = json_decode($record['blood_pressure'], true);
            $urine_voided = json_decode($record['urine_voided'], true);
            $cervical_dilatation = json_decode($record['cervical_dilatation'], true);



            // Begin content creation
            $html = '
<h4 >USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-weight:bold;margin-left:5rem;">&nbsp;&nbsp;CASE NO.:</span> ' . htmlspecialchars($record['case_no']) . '</h4>
<span style="font-weight:bold;">&nbsp;&nbsp;NAME:</span> ' . htmlspecialchars($record['name']) . ' &nbsp; <strong>AGE:</strong> ' . htmlspecialchars($record['age']) . ' &nbsp; <strong>Parity:</strong> ' . htmlspecialchars($record['parity']) . '
<span style="font-weight:bold;"></span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>ADDRESS:</strong> ' . htmlspecialchars($record['address']) . '<br>



<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>DURING LABOUR</th>
            <th> AT OR AFTER BIRTH - MOTHER</th>
            <th> AT OR AFTER BIRTH -NEWBORN</th>
            <th>PLANNED NEWBORN TREATMENT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ADMISSION DATE: ' . htmlspecialchars($record['admission_date']) . '</td>
            <td>Birth Time: ' . htmlspecialchars(date('h:i A', strtotime($record['birth_time']))) . '</td>
            <td>
                Livebirth: <img src="' . $liveBirthImg . '" width="10" height="10"> &nbsp;
                Stillbirth-Fresh: <img src="' . $stillbirthImg . '" width="10" height="10">
            </td>
            <td>' . htmlspecialchars($record['newborn']) . '</td>
        </tr>
        <tr>
            <td>ADMISSION TIME: ' . htmlspecialchars(date('h:i A', strtotime($record['admission_time']))) . '</td>
            <td>Oxytocin-Time Given: ' . htmlspecialchars(date('h:i A', strtotime($record['oxytocin']))) . '</td>
            <td>RESUSCITATION: Yes <img src="' . ($record['RESUSCITATION'] == 'Yes' ? $checkedImg : $uncheckedImg) . '" width="10" height="10"> No <img src="' . ($record['RESUSCITATION'] == 'No' ? $checkedImg : $uncheckedImg) . '" width="10" height="10"></td>
        </tr>
         <tr>
            <td>TIME ACTIVE LABOUR STARTED:
            ' . htmlspecialchars(date('h:i A', strtotime($record['time_active']))) . '</td>
           <td><label>Placenta Complete:</label>
        Yes: <img src="' . $placenta_complete . '" width="10" height="10"> &nbsp;
                No: <img src="' . $placenta_completed . '" width="10" height="10">
           </td>
    <td><label>Birth Weight:</label>
       ' . htmlspecialchars($record['birth_weight']) . '
    </td>
        </tr>
         <tr>
        <td> TIME MEMBRANES RUPTURED: 
           ' . htmlspecialchars(date('h:i A', strtotime($record['time_membranes']))) . '
        </td>
        <td> <label>Time Delivered:</label>
           ' . htmlspecialchars(date('h:i A', strtotime($record['time_delivered']))) . '
        </td>
        <td><label>AOG: 36 Wks or Preterm:</label>
           Yes: <img src="' . $preterm . '" width="10" height="10"> &nbsp;
                No: <img src="' . $pretermed . '" width="10" height="10">
        </td>

    </tr>

        <tr>
        <td> TIME SECOND STAGE STARTS:
           ' . htmlspecialchars(date('h:i A', strtotime($record['time_second']))) . '
        </td>
        <td> <label>Estimated Blood Loss:</label>
           ' . htmlspecialchars($record['estimated']) . '
        </td>
        <td> <label>Second Baby:</label>
          ' . htmlspecialchars($record['second_baby']) . '
        </td>
    </tr>
        
        <!-- More rows as needed -->
    </tbody>
</table>

<h3>Entry Examination</h3>
<table border="1" cellpadding="4">
    <tr>
        <td>STAGE OF LABOUR</td>
        <td>NOT IN ACTIVE LABOUR <img src="' . ($record['stage_of_labour'] == 'NOT IN ACTIVE LABOUR' ? $checkedImg : $uncheckedImg) . '" width="10" height="10"></td>
        <td>ACTIVE LABOUR <img src="' . ($record['stage_of_labour'] == 'ACTIVE LABOUR' ? $checkedImg : $uncheckedImg) . '" width="10" height="10"></td>
    </tr>
</table>



            <table border="1" cellpadding="4">
    <thead>
        <tr>
            <th rowspan="2">TIME</th>
            <th colspan="14">HOURS SINCE ARRIVAL</th>
            <th colspan="4">PLANNED MATERNAL TREATMENT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="3">HOURS SINCE ARRIVAL</td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td colspan="4">' . htmlspecialchars($record['maternal_plan']) . '</td>
        </tr>
        <tr>
            <td colspan="3">Hours Since Ruptured Membranes</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $rupturedMembranes) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>

            <tr>
            <td colspan="3">Vaginal Bleeding (0 + ++)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $vaginalBleeding) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
             <tr>
            <td colspan="3">Strong Contractions in 10 Minutes</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $strong_contractions) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
              <tr>
            <td colspan="3">Fetal Heart Rate (Beats per Minute)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $fetal_heart_rate) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
              <tr>
            <td colspan="3">T (Axillary)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $temperature_axillary) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
             <tr>
            <td colspan="3">Pulse (Beats/Minute)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $pulse) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
              <tr>
            <td colspan="3">Respiratory Rate (Cycle/Minute)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $respiratory_rate) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
             <tr>
            <td colspan="3">Blood Pressure (Systolic/Diastolic)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $blood_pressure) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
             <tr>
            <td colspan="3">Urine Voided</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $urine_voided) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
            <tr>
            <td colspan="3">Cervical Dilatation (CM)</td>';

            // Loop through each checkbox value
            for ($i = 1; $i <= 12; $i++) {
                // Check if the current checkbox value is in the $rupturedMembranes array
                $imgSrc = in_array($i, $cervical_dilatation) ? $checkedImg : $uncheckedImg;
                $html .= '<td><img src="' . $imgSrc . '" width="10" height="10"></td>';
            }

            $html .= '</tr>
            
            
    

    </tbody>
</table>

<table border="1" cellpadding="4">
    <tr>
        <td>PROBLEM</td>
        <td>TIME ONSET</td>
        <td>TREATMENT OTHER THAN SUPPORT</td>
    </tr>
    <tr>
        <td>' . htmlspecialchars($record['problem']) . '</td>
        <td>' . htmlspecialchars($record['time_onset']) . '</td>
        <td>' . htmlspecialchars($record['treatments']) . '</td>
    </tr>
     <tr>
        <td colspan="3">IF MOTHER REFERRED DURING LABOUR OR DELIVERY, RECORD TIME AND EXPLAIN: &nbsp; &nbsp; ' . htmlspecialchars($record['referral_details']) . '</td>
        
    </tr>
    
</table>
<i class="mt-2" style="text-align: right;">LUTAYAN RHU BIRHTING CENTER</i>



';

            // Output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Close and output PDF document
            $pdf->Output('labour_monitoring_record.pdf', 'I');
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





?>
