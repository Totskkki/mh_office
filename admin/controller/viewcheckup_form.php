<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Prepare a statement to select the patient, complaint, family, and checkup data
    $query = "SELECT checkup.*, pat.*, fam.*, com.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
              FROM tbl_checkup AS checkup 
              JOIN tbl_patients AS pat ON checkup.patient_id = pat.patientID
              JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_complaints as com on com.patient_id = pat.patientID  AND com.created_at = checkup.created_at
              WHERE checkup.checkupID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();

    $f = $stmt->fetch(PDO::FETCH_ASSOC);
}



?>


<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Meta -->


<link rel="canonical" href="https://www.bootstrap.gallery/">

<link rel="shortcut icon" href="../../assets/images/favicon.svg" />

<!-- *************
			************ CSS Files *************
		************* -->
<!-- Icomoon Font Icons css -->
<link rel="stylesheet" href="../../assets/fonts/icomoon/style.css" />
<link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css">




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




<head>



    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

<style>
     @media print {
            @page {
                size: 8.5in 13in;
                max-width: 8.5in;
            }
        }
        #print {
            width: 850px;
            height: 1100px;
            overflow: hidden;
            margin: auto;
            border: 2px solid #000;
        }
        .input-bottom-border {
            border: none;
            border-bottom: 1px solid black;
        }
</style>



</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->


        <!-- Sidebar wrapper start -->

        <!-- Sidebar wrapper end -->

        <!-- App container starts -->
        <div class="app-container">

            <!-- App header starts -->



            <!-- App header actions end -->

        </div>
        <!-- App header ends -->



        <!-- App body starts -->
        <div class="app-body">

            <!-- <a href="../view_patient.php" class="btn btn-primary">
                <i class="icon-chevron-left"></i> Back</i>
            </a> -->
            <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" onclick="printContent('print')">Print Content</button>

            <!-- <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" type="button" onclick="window.print();">Print Content</button> -->
            <!-- <a href="referrals.php" class="btn btn-primary btn-sm mt-2 ml-2"> <i class="icon-chevron-left"></i> Back</a> -->
            <button onclick="window.history.back()" class="btn btn-primary">Back</button>

            <div  id="print" style="max-width:850px;">


                <div class="row">
                    <div class="col-xxl-12">
                        <div class="card mb-4">
                            <div class="card-body">
                             
                                 
                                                      
                            <div style="display: flex; justify-content: space-between; margin: 10px;">
                                <div style="text-align: left; flex: 1;">
                                    <img src="../logo/1.png" style="width: 200px;height:60px" alt="">

                                </div>
                                <div style="text-align: right; flex: 1;">
                                    <label>LUTAYAN RURAL HEALTH UNIT</label><br>
                                    <label>Brgy. Tamnag Lutayan, Sultan Kudarat</label><br>
                                    <label>Email: lutayan_rhu@yahoo.com.ph</label><br>
                                    <label>Telefax No.: (083) 228-1528</label><br>
                                </div>
                            </div>  
                                                <h2 class="fw-bold mb-3">PATIENT CHECK-UP</h2>
                                                <hr>



                                                <!-- Row start -->
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc">Name</label>
                                                            <br>
                                                            <?php echo $f['patient_name'] . ' ' . $f['middle_name'] . ' ' . $f['last_name'] ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc1">Age</label>
                                                            <br>
                                                            <?php echo $f['age']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc2">Sex</label>
                                                            <br>
                                                            <?php echo $f['gender']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Civil Status</label>
                                                            <br>
                                                            <?php echo $f['civil_status']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc4">Date of Birth:</label>
                                                            <br>
                                                            <?php echo $f['date_of_birth']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Address:</label>
                                                            <br>
                                                            <?php echo $f['address']; ?>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Date and Time Admitted:</label>
                                                            <br>
                                                            <?php
                                                            if ($f['admitted'] == "") {
                                                                echo "<br />";
                                                            } else {
                                                                // Convert the date and time from 24-hour to 12-hour format with AM/PM
                                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $f['admitted']);
                                                                echo $date->format('Y-m-d h:i A');
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">History of Present Illness:</label>
                                                            <br>
                                                            <?php echo $f['history']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Pertinent Past Medical History:</label>
                                                            <br>
                                                            <?php echo $f['per_pas_med']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-8 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <h5 class="form-label" for="abc5">Pertinent Signs and Syntoms on Admission:</h5>
                                                            <br>
                                                            <?php
                                                            if (!empty($f['pertinent_signs'])) {
                                                                $gen_survey = json_decode($f['pertinent_signs']);
                                                                if (is_array($gen_survey)) {

                                                                    foreach ($gen_survey as $item) {
                                                                        echo htmlspecialchars($item) . '<br>';
                                                                    }
                                                                } else {
                                                                    echo 'Error decoding JSON.';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                            <!-- <div class="mb-3">
                                                <label for="text" class="form-label">OB/GYN History</label>
                                                <div class="d-flex align-items-center">
                                                    <label for="g" class="mr-1">G:</label>
                                                    <input type="text" id="g" name="g" value="" size="2" mr-2" class="input-bottom-border" />

                                                    <label for="p" class="mr-1">P:</label>
                                                    <input type="text" id="p" name="p" value="" size="2" mr-2" class="input-bottom-border" />

                                                    <label class="mr-1">(</label>
                                                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                                                    <label>-</label>
                                                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                                                    <label>-</label>
                                                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                                                    <label>-</label>
                                                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                                                    <label>)</label>
                                                    <label for="g" class="mr-1">LMP:</label>
                                                    <input type="text" id="g" name="g" value="" size="2" mr-2" class="input-bottom-border" />
                                                </div>

                                            </div> -->
                                        </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <h5 class="form-label" for="abc5">Physical Examination on Admission:</h5>
                                                            <br>
                                                            <label><b>General Survey:</b>&nbsp;&nbsp; <?php echo $f['gen_survey']; ?></label><br>
                                                            <label><b>Vital Signs:</b> &nbsp;&nbsp;<span>BP:<?php echo $f['bp']; ?></span>
                                                                &nbsp;&nbsp;<span>HR:<?php echo $f['hr']; ?></span>
                                                                &nbsp;&nbsp;<span>RR:<?php echo $f['rr']; ?></span>
                                                                &nbsp;&nbsp;<span>TEMP:<?php echo $f['temp']; ?></span>

                                                            </label><br>
                                                            <label><b>HEENT: </b>&nbsp;&nbsp;<?php
                                                                                                if (!empty($f['heent'])) {
                                                                                                    $gen_survey = json_decode($f['heent']);
                                                                                                    if (is_array($gen_survey)) {

                                                                                                        foreach ($gen_survey as $item) {
                                                                                                            echo htmlspecialchars($item) . '  ';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo 'Error decoding JSON.';
                                                                                                    }
                                                                                                }
                                                                                                ?></label><br>
                                                            <label><b>CHEST/LUNGS:</b>&nbsp;&nbsp; <?php
                                                                                                    if (!empty($f['chest'])) {
                                                                                                        $gen_survey = json_decode($f['chest']);
                                                                                                        if (is_array($gen_survey)) {

                                                                                                            foreach ($gen_survey as $item) {
                                                                                                                echo htmlspecialchars($item) . '  ';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Error decoding JSON.';
                                                                                                        }
                                                                                                    }
                                                                                                    ?></label><br>
                                                            <label><b>CSV:</b>&nbsp;&nbsp;<?php

                                                                                            if (!empty($f['CSV'])) {
                                                                                                $gen_survey = json_decode($f['CSV']);
                                                                                                if (is_array($gen_survey)) {

                                                                                                    foreach ($gen_survey as $item) {
                                                                                                        echo htmlspecialchars($item) . '  ';
                                                                                                    }
                                                                                                } else {
                                                                                                    echo 'Error decoding JSON.';
                                                                                                }
                                                                                            } ?></label><br>
                                                            <label><b>ABDOMEN:</b>&nbsp;&nbsp;<?php
                                                                                                if (!empty($f['abdomen'])) {
                                                                                                    $gen_survey = json_decode($f['abdomen']);
                                                                                                    if (is_array($gen_survey)) {

                                                                                                        foreach ($gen_survey as $item) {
                                                                                                            echo htmlspecialchars($item) . '  ';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo 'Error decoding JSON.';
                                                                                                    }
                                                                                                } ?></label><br>
                                                            <label><b>GU /(IE):</b>&nbsp;&nbsp;<?php
                                                                                                if (!empty($f['GU'])) {
                                                                                                    $gen_survey = json_decode($f['GU']);
                                                                                                    if (is_array($gen_survey)) {

                                                                                                        foreach ($gen_survey as $item) {
                                                                                                            echo htmlspecialchars($item) . '  ';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo 'Error decoding JSON.';
                                                                                                    }
                                                                                                } ?></label><br>
                                                            <label><b>SKIN/EXTREMITIES:</b>&nbsp;&nbsp;<?php
                                                                                                        if (!empty($f['skin_extremeties'])) {
                                                                                                            $gen_survey = json_decode($f['skin_extremeties']);
                                                                                                            if (is_array($gen_survey)) {

                                                                                                                foreach ($gen_survey as $item) {
                                                                                                                    echo htmlspecialchars($item) . '  ';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Error decoding JSON.';
                                                                                                            }
                                                                                                        } ?></label><br>
                                                            <label><b>NEURO-EXAM:</b>&nbsp;&nbsp;<?php
                                                                                                    if (!empty($f['neuro_exam'])) {
                                                                                                        $gen_survey = json_decode($f['neuro_exam']);
                                                                                                        if (is_array($gen_survey)) {

                                                                                                            foreach ($gen_survey as $item) {
                                                                                                                echo htmlspecialchars($item) . '  ';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Error decoding JSON.';
                                                                                                        }
                                                                                                    } ?></label><br>
                                                            <br>
                                                            <label><b>DISABILITY:</b>&nbsp;&nbsp;<u><?php echo ucwords($f['disability']); ?></u></label> <span> &nbsp;&nbsp;&nbsp;&nbsp;<label><b>TYPE OF DISABILITY:</b>&nbsp;&nbsp;<?php echo $f['disability_type']; ?></label>




                                                        </div>


                                                    </div>
                                                    <hr>
                                                    <label><u><?php echo $f['doctor_order']; ?></u></label><br>
                                                    <label class="form-label">DOCTOR'S ORDER</label><br>

                                                </div>
                                                <!-- Row end -->




                                         
                                     
                                  
                        </div>
                    </div>
                </div>

            </div>

            <!-- Container ends -->

        </div>
        <!-- App body ends -->



        <!-- App footer start -->

        <!-- App footer end -->

    </div>
    <!-- App container ends -->

    </div>
    <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->



    <script>
        function openPrintDialog() {
            alert("Please ensure you disable 'Headers and Footers' in the print settings dialog for best results.");
            window.print();
        }

        function printContent(el) {
            var inputElements = document.getElementById(el).querySelectorAll('input');
            inputElements.forEach(function(input) {
                input.setAttribute('value', input.value);
            });

            var originalContents = document.body.innerHTML;
            var printContents = document.getElementById(el).innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>








</body>



</html>