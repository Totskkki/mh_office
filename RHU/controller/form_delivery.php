<?php
include '../config/connection.php';

include '../common_service/common_functions.php';


if (isset($_GET['id'])) {
    $recordId = $_GET['id'];


    // Prepare and execute the SQL query to fetch the record
    $query = "SELECT b.*, p.*, a.*,bi.*,com.*,u.*,per.*,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                  CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address,
                   CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS physicianName

                  FROM tbl_birthroom b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyaddress a ON a.famID = p.family_address
                  LEFT JOIN tbl_birth_info bi ON bi.patient_id = b.patient_id
                  LEFT JOIN tbl_complaints com on com.patient_id = b.patient_id
          
                  LEFT JOIN tbl_users u ON u.userID = b.physician
                     LEFT JOIN tbl_personnel per ON u.personnel_id = per.personnel_id
                  WHERE b.roomID  = :recordId";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the record
    $record = $stmt->fetch(PDO::FETCH_ASSOC);


    // $method_delivery = json_decode('method_delivery');
    $laborData = json_decode($record['labor'], true);
    $placentaData = json_decode($record['placenta'], true);


    $other = '';
    $otherDetails = '';



    $checked = 'icons/check.png';
    $unchecked = 'icons/uncheck.png';


    $method_delivery = json_decode($record['method_delivery'], true);


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
                    <table>

                        <tr>
                            <th colspan="6" style="text-align: center;"> DELIVERY ROOM RECORD</th>
                        </tr>


                        <tr>

                            <th>NAME: <?php echo htmlspecialchars($record['name']); ?></th>

                            <th>AGE: <?php echo htmlspecialchars($record['age']); ?></th>

                            <th colspan="3">DATE ADMITTED: <?php echo htmlspecialchars($record['dateAdmitted']); ?></th>

                        </tr>
                        <tr>
                            <th>LMP: <?php echo htmlspecialchars($record['LMP']); ?></th>
                            <th>EDC: <?php echo htmlspecialchars($record['EDC']); ?></th>
                            <th>AOG: <?php echo htmlspecialchars($record['AOG']); ?></th>
                            <th>Gravida: <?php echo htmlspecialchars($record['gravida']); ?></th>
                            <th>Para: <?php echo htmlspecialchars($record['para']); ?></th>
                        </tr>
                        <tr>
                            <th>PREMATURE: <?php echo htmlspecialchars($record['premature']); ?></th>
                            <th>ABORTION: <?php echo htmlspecialchars($record['abortion']); ?></th>
                            <th colspan="3">NO. OF LIVING: <?php echo htmlspecialchars($record['noOfLiving']); ?></th>

                        </tr>


                    </table>


                    <label class="mt-3"><strong>LABOR</strong></label>
                    <?php
                    // Initialize the HTML variable
                    $html = '<table border="1">
                            <tr>
                                <th></th>           
                                <th>Time</th>
                                <th>Date</th>
                                <th>Stage Number</th>
                                <th>Duration (Hours)</th>
                                <th>Duration (Minutes)</th>
                            </tr>';

                    // Extract labor types
                    $laborTypes = $laborData['labor']['types'];
                    $isOnset = in_array('Onset', $laborTypes);
                    $isSpontaneous = in_array('Spontaneous', $laborTypes);
                    $isInduced = in_array('Induced', $laborTypes);

                    // Build the row with checkboxes
                    $html .= '
                        <tr>
                            <td><input type="checkbox" class="form-check-input"' . ($isOnset ? 'checked' : '') . ' > Onset
                            <br>
                            <input type="checkbox" class="form-check-input"' . ($isSpontaneous ? 'checked' : '') . ' > Spontaneous
                            <br>
                            <input type="checkbox"class="form-check-input" ' . ($isInduced ? 'checked' : '') . ' > Induced
                            </td>
                            
                            <td>' . htmlspecialchars(date('h:i A', strtotime($laborData['labor']['time']))) . '</td>
                            <td>' . htmlspecialchars($laborData['labor']['date']) . '</td>
                            <td>I</td> 
                            <td>' . htmlspecialchars($laborData['labor']['duration']['hrs']) . '</td>
                            <td>' . htmlspecialchars($laborData['labor']['duration']['mins']) . '</td>
                        </tr>';

                    // Labor stages for other details
                    $laborStages = [
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
                        // Placenta Delivered will not have its own duration displayed
                        'Placenta Delivered' => [
                            // These values are just placeholders to be replaced by total later
                            'time' => $laborData['placenta']['time'],
                            'date' => $laborData['placenta']['date'],
                            'stage' => 'Total Duration',
                            'duration' => ['hrs' => 0, 'mins' => 0] // Use placeholders for display
                        ],
                    ];

                    // Initialize total duration variables
                    $totalHrs = $laborData['labor']['duration']['hrs'] + $laborData['cervix']['duration']['hrs'] + $laborData['baby']['duration']['hrs'];
                    $totalMins = $laborData['labor']['duration']['mins'] + $laborData['cervix']['duration']['mins'] + $laborData['baby']['duration']['mins'];

                    // Calculate minutes and adjust if necessary
                    if ($totalMins >= 60) {
                        $totalHrs += floor($totalMins / 60);
                        $totalMins = $totalMins % 60;
                    }

                    // Loop through other labor stages and add them to the HTML table
                    foreach ($laborStages as $type => $details) {
                        $hrs = ($type === 'Placenta Delivered') ? $totalHrs : $details['duration']['hrs'];
                        $mins = ($type === 'Placenta Delivered') ? $totalMins : $details['duration']['mins'];

                        $html .= '
                           <tr>
                                <td>' . htmlspecialchars($type) . '</td>
                                <td>' . htmlspecialchars(date('h:i A', strtotime($details['time']))) . '</td>
                                <td>' . htmlspecialchars($details['date']) . '</td>
                                <td>' . htmlspecialchars($details['stage']) . '</td>
                                <td>' . htmlspecialchars($hrs) . '</td>
                                <td>' . htmlspecialchars($mins) . '</td>
                            </tr>';
                    }

                    // Close the table
                    $html .= '</table>';

                    // Display the constructed HTML
                    echo $html;

                    ?>


                    <?php

                    $html = ''; // Initialize the $html variable

                    $html .= '<label class="mt-3"><strong>PLACENTA:</strong></label>';
                    $html .= '<table border="1" cellpadding="4">';
                    $html .= '
                        <tr>
                            <th><strong>Expelled</strong></th>
                            <th><strong>Umbilical Cord</strong></th>
                            <th><strong>Estimated Blood Loss</strong></th>
                        </tr>
                        ';

                    // Check if placenta data exists
                    if (isset($placentaData['placenta'])) {
                        // Get expelled data


                        // Get umbilical cord data
                        $umbilicalCord = isset($placentaData['umbilicalCord']) ? $placentaData['umbilicalCord'] : [];

                        $umbilicalCord = [
                            'cm' => $umbilicalCord['cm'] ?? 'N/A',
                            'loops' => $umbilicalCord['loops'] ?? 'N/A',
                            'none' => $umbilicalCord['none'] ?? 'N/A',
                            'other' => $placentaData['other'] ?? 'N/A'
                        ];

                        // Get blood loss data
                        $bloodLoss = isset($placentaData['bloodLoss']) ? $placentaData['bloodLoss'] : [];

                        $antepartum = (int)($bloodLoss['antepartum'] ?? 0);
                        $intrapartum = (int)($bloodLoss['intrapartum'] ?? 0);
                        $postpartum = (int)($bloodLoss['postpartum'] ?? 0);
                        $totalBloodLoss = (int)($bloodLoss['total'] ?? 0);


                        // Default values for other methods of expulsion
                        $isRetainedForMethod = false;
                        $isSpontaneous = false;
                        $isManualExtraction = false;

                        $isExpelledCompletely = $placentaData['placenta']['expelled'];
                        $Expelled = in_array('Expelled Completely', $isExpelledCompletely);
                        $Retained = in_array('Retained for Method of Expulsion', $isExpelledCompletely);
                        $Spontaneous = in_array('Spontaneous', $isExpelledCompletely);
                        $Manual = in_array('Manual Extraction', $isExpelledCompletely);

                        // Loop through the expelled data
                        $html .= '
                        <tr>
                         <td><input type="checkbox" class="form-check-input"' . ($Expelled ? 'checked' : '') . ' > Expelled Completely
                            <br>
                            <input type="checkbox" class="form-check-input"' . ($Retained ? 'checked' : '') . ' > Retained for Method of Expulsion
                            <br>
                            <input type="checkbox"class="form-check-input" ' . ($Spontaneous ? 'checked' : '') . ' > Spontaneous
                            <br>
                            <input type="checkbox"class="form-check-input" ' . ($Manual ? 'checked' : '') . ' > Manual Extraction
                            </td>
                             <td>
                             ' . htmlspecialchars($umbilicalCord['cm']) . ' cm <br>' .
                            htmlspecialchars($umbilicalCord['loops']) . ' <br>' .
                            htmlspecialchars($umbilicalCord['none']) . '<br> ' .
                            htmlspecialchars($umbilicalCord['other']) . '<br>
                            
                            </td>


                           <td>Antepartum: ' . htmlspecialchars($antepartum) . ' CC<br/>' .
                            'Intrapartum: ' . htmlspecialchars($intrapartum) . ' CC<br/>' .
                            'Postpartum: ' . htmlspecialchars($postpartum) . ' CC<br/>' .
                            'Total: ' . htmlspecialchars($totalBloodLoss) . ' CC</td>
                         </tr>';
                    }

                    $html .= '</table><br/>';


                    echo $html;
                    ?>


                    <?php
                    // METHOD OF DELIVERY SECTION
                    $htmlMethod = ''; // Initialize the HTML variable for the delivery section
                    $htmlMethod .= '<label><strong>METHOD OF DELIVERY:</strong></label>';
                    $htmlMethod .= '<table>';
                    $htmlMethod .= '<tr>';

                    // Use a loop to avoid redundancy
                    $deliveryMethods = [
                        'NSVD',
                        'Cesarean',
                        'OF',
                        'LF',
                        'TBE',
                        'PBE',
                        'CCS',
                        'ME',
                        'Other (Specify)',
                    ];

                    $otherDetail = '';
                    foreach ($deliveryMethods as $method) {
                        $isChecked = in_array($method, $method_delivery) ? 'checked' : '';

                        // Check if the method is 'Other (Specify)' to handle it differently
                        if ($method === 'Other (Specify)' && in_array($method, $method_delivery)) {
                            $otherDetail = end($method_delivery);
                        }

                        // Build checkbox and input for 'Other (Specify)'
                        if ($method === 'Other (Specify)') {
                            $htmlMethod .= '<td><strong>' . htmlspecialchars($method) . ':</strong> 
                                    <input type="checkbox" class="form-check-input"  
                                    name="delivery[' . strtolower(str_replace(' ', '_', $method)) . ']" value="" ' . $isChecked . '>
                                    <input type="text" name="other_details" value="' . htmlspecialchars($otherDetail) . '" style="margin-left:8px;" /></td>';
                        } else {
                            // For all other delivery methods
                            $htmlMethod .= '<td><strong>' . htmlspecialchars($method) . ':</strong> 
                                    <input type="checkbox" class="form-check-input"  
                                    name="delivery[' . strtolower(str_replace(' ', '_', $method)) . ']" value="" ' . $isChecked . '></td>';
                        }
                    }

                    $htmlMethod .= '</tr>'; // Close the row
                    $htmlMethod .= '</table><br/>';

                    // INDICATION FOR OPERATIVE DELIVERY SECTION
                    $htmlEpisiotomy = ''; // Initialize the HTML variable for the episiotomy section
                    $htmlEpisiotomy .= '<label><strong>INDICATION FOR OPERATIVE DELIVERY:</strong></label>';

                    $Episiotomy = json_decode($record['Episiotomy'], true);

                    $checked = 'checked';
                    $unchecked = '';
                    $medianChecked = in_array("Median", $Episiotomy) ? $checked : $unchecked;
                    $rightMedLateralChecked = in_array("Right Med. Lateral", $Episiotomy) ? $checked : $unchecked;
                    $leftMedLateralChecked = in_array("Left Med. Lateral", $Episiotomy) ? $checked : $unchecked;
                    $noneChecked = in_array("None", $Episiotomy) ? $checked : $unchecked;
                    $extensionChecked = in_array("Extension", $Episiotomy) ? $checked : $unchecked;

                    $htmlEpisiotomy .= '
                        <table>
                            <tr>
                                <td><strong>Episiotomy:</strong></td>
                                <td><strong>Median:</strong> <input type="checkbox" name="Episiotomy[]" class="form-check-input" value="Median" ' . $medianChecked . '></td>
                                <td><strong>Right Med. Lateral:</strong> <input type="checkbox" class="form-check-input" name="Episiotomy[]" value="Right Med. Lateral" ' . $rightMedLateralChecked . '></td>
                                <td><strong>Left Med. Lateral:</strong> <input type="checkbox" class="form-check-input" name="Episiotomy[]" value="Left Med. Lateral" ' . $leftMedLateralChecked . '></td>
                                <td><strong>None:</strong> <input type="checkbox" class="form-check-input" name="Episiotomy[]" value="None" ' . $noneChecked . '></td>
                                <td><strong>Extension:</strong> <input type="checkbox" class="form-check-input" name="Episiotomy[]" value="Extension" ' . $extensionChecked . '></td>
                            </tr>
                        </table><br/>';

                    // Laceration Section
                    $Laceration = json_decode($record['Laceration'], true);
                    $checked = 'checked';
                    $unchecked = '';
                    $perinialChecked = in_array("Perinial 1 2 3", $Laceration) ? $checked : $unchecked;
                    $vaginalChecked = in_array("Vaginal", $Laceration) ? $checked : $unchecked;
                    $cervicalChecked = in_array("Cervical", $Laceration) ? $checked : $unchecked;
                    $repairedChecked = in_array("Repaired", $Laceration) ? $checked : $unchecked;
                    $notRepairedChecked = in_array("Not Repaired", $Laceration) ? $checked : $unchecked;

                    $htmlLaceration = '
                            <label><strong>Laceration:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>Laceration:</strong></td>
                                    <td><strong>Perinial 1" 2" 3":</strong> <input type="checkbox" class="form-check-input" name="Laceration[]" value="Perinial 1 2 3" ' . $perinialChecked . '></td>
                                    <td><strong>Vaginal:</strong> <input type="checkbox" class="form-check-input" name="Laceration[]" value="Vaginal" ' . $vaginalChecked . '></td>
                                    <td><strong>Cervical:</strong> <input type="checkbox" class="form-check-input" name="Laceration[]" value="Cervical" ' . $cervicalChecked . '></td>
                                    <td><strong>Repaired:</strong> <input type="checkbox" class="form-check-input" name="Laceration[]" value="Repaired" ' . $repairedChecked . '></td>
                                    <td><strong>Not Repaired:</strong> <input type="checkbox" class="form-check-input" name="Laceration[]" value="Not Repaired" ' . $notRepairedChecked . '></td>
                                </tr>
                            </table><br/>
                        ';

                    // Display the Laceration section


                    // Anesthesia Section
                    $Anethesia = json_decode($record['Anethesia'], true);
                    $infiltrationChecked = in_array("Local Infiltration", $Anethesia) ? $checked : $unchecked;
                    $inhalationChecked = in_array("General Inhalation", $Anethesia) ? $checked : $unchecked;
                    $noneChecked = in_array("None", $Anethesia) ? $checked : $unchecked;

                    $htmlAnesthesia = '
                                    <label><strong>Anesthesia:</strong></label>
                                    <table>
                                        <tr>
                                            <td><strong>Anesthesia:</strong></td>
                                            <td><strong>Local Infiltration:</strong> <input type="checkbox" class="form-check-input" name="Anethesia[]" value="Local Infiltration" ' . $infiltrationChecked . '></td>
                                            <td><strong>General Inhalation:</strong> <input type="checkbox" class="form-check-input" name="Anethesia[]" value="General Inhalation" ' . $inhalationChecked . '></td>
                                            <td><strong>None:</strong> <input type="checkbox" class="form-check-input" name="Anethesia[]" value="None" ' . $noneChecked . '></td>
                                        </tr>
                                    </table><br/>
                                ';



                    // Analgesia Section
                    $Analgesia = json_decode($record['Analgesia'], true);
                    $yesChecked = in_array("Yes", $Analgesia) ? $checked : $unchecked;
                    $noneChecked = in_array("None", $Analgesia) ? $checked : $unchecked;

                    $htmlAnalgesia = '
                            <label><strong>Analgesia:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>Analgesia:</strong></td>
                                    <td><strong>Yes:</strong> <input type="checkbox" name="Analgesia[]"class="form-check-input" value="Yes" ' . $yesChecked . '></td>
                                    <td><strong>None:</strong> <input type="checkbox" name="Analgesia[]"class="form-check-input" value="None" ' . $noneChecked . '></td>
                                </tr>
                            </table><br/>
                        ';



                    // Now let's include conditions
                    $condition = json_decode($record['condition'], true);

                    // Prepare checked statuses for conditions
                    $awakeChecked = in_array("Awake", $condition) ? $checked : $unchecked;
                    $reactiveChecked = in_array("Reactive", $condition) ? $checked : $unchecked;
                    $depressedChecked = in_array("Depressed", $condition) ? $checked : $unchecked;

                    // Create the Conditions section with checkboxes
                    $htmlConditions = '
                            <label><strong>Conditions:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>Condition:</strong></td>
                                    <td><strong>Awake:</strong> <input type="checkbox"class="form-check-input" name="condition[]" value="Awake" ' . $awakeChecked . '></td>
                                    <td><strong>Reactive:</strong> <input type="checkbox"class="form-check-input" name="condition[]" value="Reactive" ' . $reactiveChecked . '></td>
                                    <td><strong>Depressed:</strong> <input type="checkbox" class="form-check-input"name="condition[]" value="Depressed" ' . $depressedChecked . '></td>
                                </tr>
                            </table><br/>
                           ';

                    // Decode the urinary bladder data
                    $urinary_bladder = json_decode($record['urinary_bladder'], true);

                    // Prepare checked statuses for urinary bladder checks
                    $catheterChecked  = in_array("W/Catheter", $urinary_bladder) ? $checked : $unchecked;
                    $voidedChecked = in_array("Voided", $urinary_bladder) ? $checked : $unchecked;
                    $urineChecked = in_array("Total Urine Output", $urinary_bladder) ? $checked : $unchecked;

                    // Decode the uterus data
                    $uterus = json_decode($record['uterus'], true);

                    // Prepare checked statuses for uterus checks
                    $contractedChecked  = in_array("Well Contracted", $uterus) ? $checked : $unchecked;
                    $relaxingChecked = in_array("Relaxing", $uterus) ? $checked : $unchecked;

                    // Build the Urinary Bladder section with checkboxes
                    $htmlUrinaryBladder = '
                            <label><strong>URINARY BLADDER:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>W/Catheter:</strong> <input type="checkbox" class="form-check-input" name="urinary_bladder[]" value="W/Catheter" ' . $catheterChecked . '></td>
                                    <td><strong>Voided:</strong> <input type="checkbox" class="form-check-input" name="urinary_bladder[]" value="Voided" ' . $voidedChecked . '></td>
                                    <td><strong>Total Urine Output:</strong> <input type="checkbox" class="form-check-input" name="urinary_bladder[]" value="Total Urine Output" ' . $urineChecked . '></td>
                                </tr>
                            </table><br/>
                        ';

                    // Display the Urinary Bladder section

                    // Build the Vital Signs section
                    $htmlVitalSigns = '
                            <label><strong>VITAL SIGNS:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>BP:</strong> ' . htmlspecialchars($record['bp']) . '</td>
                                    <td><strong>PR:</strong> ' . htmlspecialchars($record['pr']) . '</td>
                                    <td><strong>RR:</strong> ' . htmlspecialchars($record['rr']) . '</td>
                                    <td><strong>T:</strong> ' . htmlspecialchars($record['temp']) . '</td>
                                </tr>
                            </table><br/>
                        ';



                    // Build the Uterus section with checkboxes
                    $htmlUterus = '
                            <label><strong>UTERUS:</strong></label>
                            <table>
                                <tr>
                                    <td><strong>Well Contracted:</strong> <input type="checkbox" class="form-check-input" name="uterus[]" value="Well Contracted" ' . $contractedChecked . '></td>
                                    <td><strong>Relaxing:</strong> <input type="checkbox" class="form-check-input" name="uterus[]" value="Relaxing" ' . $relaxingChecked . '></td>
                                </tr>
                            </table><br/>
                        ';





                    // Display both sections separately
                    echo $htmlMethod;
                    echo $htmlEpisiotomy;
                    echo $htmlLaceration;

                    echo $htmlAnesthesia;
                    echo $htmlAnalgesia;
                    echo $htmlConditions;
                    echo $htmlUrinaryBladder;
                    echo $htmlVitalSigns;
                    echo $htmlUterus;

                    ?>
                    <label> <b>COMPLICATIONS RELATED TO PREGNANCY: </b> <u><?php echo htmlspecialchars($record['pregnancy']); ?></u> </label>
                    <br>
                    <label> <b>COMPLICATIONS NOT RELATED TO PREGNANCY: </b> <u><?php echo htmlspecialchars($record['not_related']); ?></u> </label>
                    <br>
                    <label> <b>COMPLICATIONS OF LABOR: </b> <u><?php echo htmlspecialchars($record['complications']); ?></u> </label>



                    <br>
                    <br>
                    <br>
                    
                        <div class="row text-center">
                            <div class="col">
                                <h4><b>Handled by: <br></b><u><?php echo htmlspecialchars($record['Handled_by']); ?></u></h4>
                            </div>
                            <div class="col">
                                <h4><b>Assisted by: <br></b><u><?php echo htmlspecialchars($record['assisted_by']); ?></u></h4>
                            </div>
                            <div class="col">
                                <h4><b>Physician on duty: <br></b><u><?php echo htmlspecialchars($record['physicianName']); ?></u></h4>
                            </div>
                       
                    </div>








                    <h5 class="float-end mt-5 italic-text"><i>LUTAYAN RHU BIRTHING CENTER</i></h5>



                </div>

            </div>

        </div>




</body>



</html>