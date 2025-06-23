<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

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

<link rel="shortcut icon" href="../assets/images/favicon.svg" />

<!-- *************
			************ CSS Files *************
		************* -->
<!-- Icomoon Font Icons css -->
<link rel="stylesheet" href="../../assets/fonts/icomoon/style.css" />
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">




<!-- Main CSS -->
<link rel="stylesheet" href="../../assets/css/main.min.css" />

<!-- <link rel="stylesheet" href="dist/js/jquery_confirm/jquery-confirm.css"> -->
<!-- Scrollbar CSS -->
<link rel="stylesheet" href="../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

<!-- Toastify CSS -->
<link rel="stylesheet" href="../../assets/vendor/toastify/toastify.css" />
<link rel="stylesheet" href="../../assets/vendor/daterange/daterange.css" />

<link rel="stylesheet" href="../../assets/vendor/dropzone/dropzone.min.css" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">

<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">




<head>



    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>





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

            <!-- <a href="../checkup_record.php" class="btn btn-primary">
                <i class="icon-chevron-left"></i> Back</i>
            </a> -->
            <button onclick="window.history.back()" class="btn btn-primary">Back</button>

            <div class="container-fluid">


                <div class="row">
                    <div class="col-xxl-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="modal position-static d-block shade-light rounded-3">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class=" p-5">
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
                                                            <label><b>DISABILITY:</b>&nbsp;&nbsp;<u><?php echo ucwords($f['disability']); ?></u></label </u></label> <span> &nbsp;&nbsp;&nbsp;&nbsp;<label><b>TYPE OF DISABILITY:</b>&nbsp;&nbsp;<?php echo $f['disability_type']; ?></label>




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
                            </div>
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




    <?php include '../config/site_js_links.php'; ?>








</body>



</html>