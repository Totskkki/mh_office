<?php
include '../config/connection.php';

include '../common_service/common_functions.php';


if (isset($_GET['id'])) {
    $recordId = $_GET['id'];


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

    

    $monitoringData = json_decode($record['monitoring_data'], true);


    $checkedImg = '../icons/check.png';  // Replace with actual path
    $uncheckedImg = '../icons/uncheck.png';  // Replace with actual path

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


      
  
}

?>



<!DOCTYPE html>
<html lang="en">


<head>


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Meta -->


    <link rel="canonical" href="https://www.bootstrap.gallery/">

    <link rel="shortcut icon" href="../assets/images/favicon.svg" />

    <!-- *************
			************ CSS Files *************
		************* -->
    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="../assets/fonts/icomoon/style.css" />
    <link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">




    <!-- Main CSS -->
    <link rel="stylesheet" href="../../assets/css/main.min.css" />

    <!-- <link rel="stylesheet" href="dist/js/jquery_confirm/jquery-confirm.css"> -->
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="../../assets/vendor/toastify/toastify.css" />
    <link rel="stylesheet" href="../../assets/vendor/daterange/daterange.css" />

    <link rel="stylesheet" href="../../assets/vendor/dropzone/dropzone.min.css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="../../assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">




    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


    <style>
        .container {
            max-width: 70%;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .app-body {
            padding: 2rem 2rem;
            height: 100vh;
            overflow: auto;
            margin: 0 0 10px 0;
        }
    </style>




</head>


<body>


    <div class="page-wrapper">
        <div class="app-container">
            <div class="app-body">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="icon-chevron-left"></i>Back</button>
                <div class="container" id="print">
                   


                       <?php
    // Start creating the HTML content
    $html = '<h4 style="text-align:center;">LUTAYAN RHU BIRTHING CENTER</h4>';
    $html .= '<h2 style="text-align:center;">POSTPARTUM MONITORING RECORD</h2>';

    // Patient Information
    $html .= '<h2><strong>Name of Patient:</strong> ' . htmlspecialchars($record['name']) . '  <span>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; Date:  ' . htmlspecialchars($record['date_postpartum']) . '</span></h2>';

    // Monitoring Table
    $html .= '
    <table border="1" cellspacing="0" cellpadding="3" style="width:100%; border-collapse: collapse;">
        <tr>
            <th colspan="3">MONITORING AFTER BIRTH</th>
            <th colspan="4">Every 5-15 mins for 1st hour</th>
            <th>2HR</th>
            <th>3HR</th>
            <th>4HR</th>
            <th>8HR</th>
            <th>12HR</th>
            <th>16HR</th>
            <th>20HR</th>
            <th>24HR</th>
            <th colspan="2">Discharge</th>
        </tr>
        <tr>
            <td colspan="4">Date: ' . htmlspecialchars(!empty($monitoringData['date']) ? date('F j, Y', strtotime($monitoringData['date'])) : '') . '</td>
            <td colspan="4" align="center"></td>
            <td colspan="4" align="center"></td>
           
            <td colspan="3">Date: ' . htmlspecialchars(!empty($monitoringData['monitoring']['date2']) ? date('F j, Y', strtotime($monitoringData['monitoring']['date2'])) : '') . '</td>
        </tr>
        <tr>
            <td colspan="3">Time: ' . htmlspecialchars(!empty($monitoringData['time']) ? date('h:i A', strtotime($monitoringData['time'])) : '') . '</td>';
    
            // Loop through the monitoring times every 5-15 mins
            foreach ($monitoringData['monitoring']['every5_15']['times'] as $time) {
                $html .= '<td>' . (!empty($time) ? htmlspecialchars(date('h:i A', strtotime($time))) : '') . '</td>';
            }
            
            // Ensure blank cells for each missing time interval (there are 15 cells for the first hour, including the earlier time column)
            for ($i = count($monitoringData['monitoring']['every5_15']['times']); $i < 4; $i++) {
                $html .= '<td></td>';
            }
    
            // Adding subsequent time slots
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['2HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['2HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['3HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['3HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['4HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['4HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['8HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['8HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['12HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['12HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['16HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['16HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['20HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['20HR'])) : '') . '</td>';
            $html .= '<td>' . htmlspecialchars(!empty($monitoringData['monitoring']['24HR']) ? date('h:i A', strtotime($monitoringData['monitoring']['24HR'])) : '') . '</td>';
            $html .= '<td colspan="2">' . htmlspecialchars(!empty($monitoringData['monitoring']['discharge']) ? date('h:i A', strtotime($monitoringData['monitoring']['discharge'])) : '') . '</td>';
    
   
    $html .= '</tr>
    
         <tr>
            <td colspan="4" border="1">MATERNAL WELL-BEING </td>
            
        </tr>
         <tr>
          <td colspan="4">
             <img src="' . $maternal . '" width="15" height="15"> 1. CONSCIOUS <br>
             <img src="' . $maternals . '" width="15" height="15"> 2. PALLOR
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
             <img src="' . $UTERINE . '" width="15" height="15"> 1. CONTRACTED <br>
             <img src="' . $UTERINEs . '" width="15" height="15"> 2. RELAX
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
             <img src="' . $HEAVY . '" width="15" height="15"> 1. HEAVY <br>
             <img src="' . $MODERATEs . '" width="15" height="15"> 2. MODERATE<br>
             <img src="' . $SCANTY . '" width="15" height="15"> 3. SCANTY
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
             <img src="' . $MILD . '" width="15" height="15"> 1. MILD(1-3) <br>
             <img src="' . $MODERATE . '" width="15" height="15"> 2. MODERATE(4-6)<br>
             <img src="' . $STRONG . '" width="15" height="15"> 3. STRONG (7-9) <br>
             <img src="' . $UNDEARABLE . '" width="15" height="15"> 3. UNDEARABLE (10) 


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
             <img src="' . $ENGORGED . '" width="15" height="15"> 1. ENGORGED <br>
             <img src="' . $SORE . '" width="15" height="15"> 2. SORE NIPPLE
            
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
             <img src="' . $EXCLUSIVE . '" width="15" height="15"> 1. EXCLUSIVE BREASTFEEDING <br>
             <img src="' . $SORFEEDINGE . '" width="15" height="15"> 2. MIXED FEEDING
            
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
             <img src="' . $FULL . '" width="15" height="15"> 1. FULL BLADDER <br>
             <img src="' . $BLADDER . '" width="15" height="15"> 2. EMPTY BLADDER
            
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
             <img src="' . $With . '" width="15" height="15"> 1. With BM <br>
             <img src="' . $Wbm . '" width="15" height="15"> 2. W/o BM
            
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
             <img src="' . $yes . '" width="15" height="15"> Yes <br>
             <img src="' . $no . '" width="15" height="15">  No
            
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
             <img src="' . $Proper . '" width="15" height="15"> 1. Proper Nutrition<br>
             <img src="' . $Personal . '" width="15" height="15"> 2. Personal hygien <br>
             <img src="' . $Danger . '" width="15" height="15"> 3.  Danger signs <br>

             <img src="' . $Importance . '" width="15" height="15"> 4. Importance of Exclusive Breastfeeding <br>

             <img src="' . $family . '" width="15" height="15"> 5. Imprtance of family <br>
                <img src="' . $home . '" width="15" height="15"> 6. Home instruction on Discharge of mother and her
             
            
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



            $html .= '</table>';

            // Output the HTML content
            echo $html;

?>



                </div>

            </div>

        </div>




</body>



</html>