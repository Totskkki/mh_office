<?php
include '../config/connection.php';

include '../common_service/common_functions.php';


if (isset($_GET['id'])) {
    $recordId = $_GET['id'];


    // Prepare and execute the SQL query to fetch the record
    $query = "SELECT b.*, p.*, a.* ,
                  CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
                   CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
                  FROM tbl_birthing_monitoring b
                  LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
                  LEFT JOIN tbl_familyaddress a ON a.famID = p.family_address
                  WHERE b.birthMonitorID = :recordId";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the record
    $record = $stmt->fetch(PDO::FETCH_ASSOC);



    $checkedImg = '../icons/check.png';  // Replace with actual path
    $uncheckedImg = '../icons/uncheck.png';  // Replace with actual path


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
            max-width: 80%;
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
                            <th colspan="6"> LABOUR RECORD</th>


                        </tr>
                        <tr>
                            <th>USE THIS RECORD FOR MONITORING DURING LABOUR, DELIVERY AND POSTPARTUM</th>
                            <th colspan="6">CASE NUMBER: <?php echo htmlspecialchars($record['case_no']); ?></th>

                        </tr>



                        <tr>

                            <th>NAME: <?php echo htmlspecialchars($record['name']); ?></th>

                            <th>AGE: <?php echo htmlspecialchars($record['age']); ?></th>

                            <th>PARITY: <?php echo htmlspecialchars($record['parity']); ?></th>

                        </tr>
                        <tr>
                            <th colspan="6">ADDRESS: <?php echo htmlspecialchars($record['address']); ?></th>
                        </tr>


                    </table>





                    <table border="1">

                        <thead>


                            <tr>
                                <th>DURING LABOUR</th>
                                <th>AT OR AFTER BIRTH - MOTHER</th>
                                <th>AT OR AFTER BIRTH - NEWBORN</th>
                                <th>PLANNED NEWBORN TREATMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <label>Admission Date:</label>
                                    <input type="date" id="addmissiondate" value="<?php echo htmlspecialchars($record['admission_date']); ?>" name="addmissiondate" class="form-control">
                                </td>
                                <td><label>Birth Time:</label>
                                    <input type="time" id="birthTime" value="<?php echo htmlspecialchars($record['birth_time']); ?>" name="birthTime" class="form-control">
                                </td>
                                <td>
                                    <label>Livebirth:</label>
                                    <input type="checkbox" name="Livebirth" value="Livebirth" class="form-check-input" id="livebirth" 
                                        <?php echo ($record['live_birth'] === 'Livebirth') ? 'checked' : ''; ?>
                                        onclick="toggleCheckbox(this)">

                                    <label>Stillbirth-Fresh:</label>
                                    <input type="checkbox" name="Livebirth" value="Stillbirth-Fresh" class="form-check-input" id="stillbirth" 
                                        <?php echo ($record['live_birth'] === 'Stillbirth-Fresh') ? 'checked' : ''; ?>
                                        onclick="toggleCheckbox(this)">
                                </td>


                                <td> <textarea id="newbord" name="newbord" class="form-control" style="resize:none;"><?php echo htmlspecialchars($record['newborn']) ?></textarea></td>

                            </tr>
                            <tr>
                                <td><label>Admission Time:</label>
                                    <input type="time" id="admissionTime" value="<?php echo htmlspecialchars($record['admission_time']); ?>" name="admissionTime" class="form-control">
                                </td>
                                <td> <label>Oxytocin-Time Given:</label>
                                    <input type="time" id="Oxytocin" value="<?php echo htmlspecialchars($record['oxytocin']); ?>" name="Oxytocin" class="form-control">
                                </td>
                                <td>
                                    <label>RESUSCITATION:</label><br>
                                    Yes <input type="checkbox" name="RESUSCITATION" value="Yes" class="form-check-input" id="resuscitationYes"
                                        <?php echo ($record['RESUSCITATION'] === 'Yes') ? 'checked' : ''; ?>
                                        onclick="toggleCheckbox(this, 'resuscitationNo')">

                                    No <input type="checkbox" name="RESUSCITATION" value="No" class="form-check-input" id="resuscitationNo"
                                        <?php echo ($record['RESUSCITATION'] === 'No') ? 'checked' : ''; ?>
                                        onclick="toggleCheckbox(this, 'resuscitationYes')">
                                </td>
                            </tr>
                            <tr>
                                <td><label>TIME ACTIVE LABOUR STARTED:</label>
                                    <input type="time" id="timeactive" value="<?php echo htmlspecialchars($record['time_active']); ?>" name="timeactive" class="form-control">
                                </td>
                                <td><label>Placenta Complete:</label><br>
                                    Yes <input type="checkbox" name="placentaComplete" <?php echo ($record['placenta_complete'] === 'Yes') ? 'checked' : ''; ?> value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">

                                    NO <input type="checkbox" name="placentaComplete" <?php echo ($record['placenta_complete'] === 'No') ? 'checked' : ''; ?> value="No" class="form-check-input" onclick="toggleCheckbox(this)">

                                </td>
                                <td><label>Birth Weight:</label>
                                    <input type="text" value="<?php echo htmlspecialchars($record['birth_time']); ?>" id="birthweight" name="birthweight" class="form-control">
                                </td>

                            </tr>
                            <tr>
                                <td> <label>TIME MEMBRANES RUPTURED:</label>
                                    <input type="time" id="timeMembranes" value="<?php echo htmlspecialchars($record['time_membranes']); ?>" name="timeMembranes" class="form-control">
                                </td>
                                <td> <label>Time Delivered:</label>
                                    <input type="time" id="timedelevered" value="<?php echo htmlspecialchars($record['time_delivered']); ?>" name="timedelevered" class="form-control">
                                </td>
                                <td><label>AOG: 36 Wks or Preterm:</label><br>
                                    Yes <input type="checkbox" <?php echo ($record['preterm'] === 'Yes') ? 'checked' : ''; ?> name="Preterm" value="Yes" class="form-check-input" onclick="toggleCheckbox(this)">
                                    No <input type="checkbox" <?php echo ($record['preterm'] === 'No') ? 'checked' : ''; ?> name="Preterm" value="No" class="form-check-input" onclick="toggleCheckbox(this)">
                                </td>

                            </tr>
                            <tr>
                                <td> <label>TIME SECOND STAGE STARTS:</label>
                                    <input type="time" id="timeSecond" value="<?php echo htmlspecialchars($record['time_second']); ?>" name="timeSecond" class="form-control">
                                </td>
                                <td> <label>Estimated Blood Loss:</label>
                                    <input type="text" id="Estimated" value="<?php echo htmlspecialchars($record['estimated']); ?>" name="Estimated" class="form-control">
                                </td>
                                <td> <label>Second Baby:</label>
                                    <input type="text" id="secondbaby" value="<?php echo htmlspecialchars($record['second_baby']); ?>" name="secondbaby" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="14">ENTRY EXAMINATION</th>
                            </tr>
                            <tr>
                                <td>STAGE OF LABOUR</td>
                                <td>NOT IN ACTIVE LABOUR
                                    <input class="form-check-input" <?php echo ($record['stage_of_labour'] === 'NOT IN ACTIVE LABOUR') ? 'checked' : ''; ?> type="checkbox" class="form-check-input" name="stage_of_labour" value="NOT IN ACTIVE LABOUR">
                                </td>
                                <td>ACTIVE LABOUR
                                    <input class="form-check-input" <?php echo ($record['stage_of_labour'] === 'ACTIVE LABOUR') ? 'checked' : ''; ?> type="checkbox" class="form-check-input" name="stage_of_labour" value="ACTIVE LABOUR">
                                </td>
                            </tr>



                        </tbody>
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
                                <?php
                                // Here, you will loop through and generate table cells
                                for ($hour = 1; $hour <= 12; $hour++) {
                                    echo "<td>{$hour}</td>";
                                }
                                ?>
                                <td colspan="4"><?php echo htmlspecialchars($record['referral_details']); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">Hours Since Ruptured Membranes</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($rupturedMembranes)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $rupturedMembranes array
                                        $isChecked = in_array($i, $rupturedMembranes) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="rupturedMembranes[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="rupturedMembranes[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Vaginal Bleeding (0 + ++)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($vaginalBleeding)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $vaginalBleeding array
                                        $isChecked = in_array($i, $vaginalBleeding) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="vaginal_bleeding[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="vaginal_bleeding[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Strong Contractions in 10 Minutes</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($strong_contractions)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $strong_contractions array
                                        $isChecked = in_array($i, $strong_contractions) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="strong_contractions[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="strong_contractions[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Fetal Heart Rate (Beats per Minute)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($fetal_heart_rate)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $fetal_heart_rate array
                                        $isChecked = in_array($i, $fetal_heart_rate) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="fetal_heart_rate[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="fetal_heart_rate[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">T (Axillary)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($temperature_axillary)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $temperature_axillary array
                                        $isChecked = in_array($i, $temperature_axillary) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="temperature_axillary[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="temperature_axillary[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Pulse (Beats/Minute)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($pulse)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $pulse array
                                        $isChecked = in_array($i, $pulse) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="pulse[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="pulse[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>

                            <tr>
                                <td colspan="3">Respiratory Rate (Cycle/Minute)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($respiratory_rate)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $respiratory_rate array
                                        $isChecked = in_array($i, $respiratory_rate) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="respiratory_rate[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="respiratory_rate[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Blood Pressure (Systolic/Diastolic)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($blood_pressure)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $blood_pressure array
                                        $isChecked = in_array($i, $blood_pressure) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="blood_pressure[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="blood_pressure[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3">Urine Voided</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($urine_voided)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $urine_voided array
                                        $isChecked = in_array($i, $urine_voided) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="urine_voided[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="urine_voided[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>

                            <tr>
                                <td colspan="3">Cervical Dilatation (CM)</td>

                                <?php
                                // Check if rupturedMembranes is available and loop through
                                if (isset($cervical_dilatation)) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        // Check if the current checkbox value is in the $cervical_dilatation array
                                        $isChecked = in_array($i, $cervical_dilatation) ? 'checked' : '';
                                        echo '<td>
                <label>
                    <input type="checkbox" name="cervical_dilatation[]" value="' . $i . '" class="form-check-input" ' . $isChecked . '>
                </label>
              </td>';
                                    }
                                } else {
                                    // Fallback in case rupturedMembranes is not set or empty
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<td>
                <label>
                    <input type="checkbox" name="cervical_dilatation[]" value="' . $i . '" class="form-check-input">
                </label>
              </td>';
                                    }
                                }
                                ?>
                            </tr>




                        </tbody>
                    </table>

                    <table>
                        <thead>
                            <tr>
                                <th style="width:30%;">PROBLEM:</th>
                                <th>TIME ONSET:</th>
                                <th>TREATMENT OTHER THAN NORMAL SUPPORTIVE CARE:</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:30%;"><?php echo htmlspecialchars($record['problem']); ?></td>
                                <td><?php echo htmlspecialchars($record['time_onset']); ?></td>
                                <td><?php echo htmlspecialchars($record['treatments']); ?></td>
                            </tr>


                        </tbody>
                        <table>
                            <thead>
                                <tr>
                                    <th>IF MOTHER REFERRED DURING LABOUR OR DELIVERY, RECORD TIME AND EXPLAIN</th>
                                </tr>
                            <tbody>
                                <tr>
                                    <td><?php echo htmlspecialchars($record['referral_details']); ?></td>
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                    </table>

                    <h5 class="float-end mt-5 italic-text"><i>LUTAYAN RHU BIRTHING CENTER</i></h5>



                </div>

            </div>

        </div>




</body>



</html>