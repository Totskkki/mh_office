<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Prepare a statement to select the patient, complaint, family, and checkup data
    $query = "SELECT a.*, com.*, pat.*, fam.*,mem.*,a.a,a.date,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
              FROM tbl_animal_bite_care AS a 
              JOIN tbl_patients AS pat ON a.patient_id = pat.patientID
              JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
              JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID    
              JOIN tbl_complaints as com on com.complaintID
              WHERE a.animal_biteID  = :complaintID";




    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">




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

<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">




<head>



    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


    <style>
        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .patient-info,
        .ultrasound-info,
        .measurements,
        .equivalent-age,
        .report {
            flex: 1 0 45%;
            margin-bottom: 20px;
        }

        .patient-info h3,
        .ultrasound-info h3,
        .measurements h3,
        .equivalent-age h3,
        .report h3 {
            margin-bottom: 10px;
        }

        .measurements-list,
        .equivalent-age-list {
            margin-top: 10px;
        }

        .patient-info p,
        .ultrasound-info p,
        .measurements p,
        .equivalent-age p,
        .report p {
            margin: 5px 0;
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

            <!-- <a href="../records_animalbite_all.php" class="btn btn-primary ">
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
                                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                                    <h2 class="fw-bold mb-2 card-title" style="margin: 0;">ANIMAL BITE RECORD</h2>
                                                    <h5 class="form-label" style="margin-left:10rem">Registration no.: <?php echo $row['reg_no']; ?> </h5>


                                                </div>


                                                <h5 class="form-label float-end">Date: <?php echo date('F j, Y', strtotime($row['date'])); ?> </h5>
                                                <br>




                                                <hr />
                                                <div class="row">
                                                    <h3 class="from-label"><?php echo $row['patient_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] ?>

                                                    </h3>


                                                    <div class="col-lg-2 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc1">Age</label>
                                                            <br>
                                                            <?php echo $row['age']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc2">Sex</label>
                                                            <br>
                                                            <?php echo $row['gender']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Civil Status</label>
                                                            <br>
                                                            <?php echo $row['civil_status']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc4">Date of Birth</label>
                                                            <br>
                                                            <?php echo $row['date_of_birth']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc4">Philhealth no.</label>
                                                            <br>
                                                            <?php echo $row['philhealth_no']; ?>
                                                        </div>
                                                    </div>



                                                </div>
                                                <hr />
                                                <div class="form-container">
                                                    <div class="ultrasound-info">
                                                        <h3>Pertinent Past Medical History</h3>

                                                        <p><strong></strong> <span>
                                                                <?php
                                                                if (!empty($row['med_history'])) {
                                                                    $med_history = json_decode($row['med_history'], true);

                                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                                        if (is_array($med_history)) {
                                                                            foreach ($med_history as $item) {
                                                                                if (!empty($item)) {
                                                                                    echo ucwords(htmlspecialchars($item)) . ' <br />';
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo 'Decoded JSON is not an array.';
                                                                        }
                                                                    } else {
                                                                        echo 'Error decoding JSON: ' . json_last_error_msg();
                                                                    }
                                                                } else {
                                                                }
                                                                ?>

                                                            </span></p>
                                                        <p><strong>Bleeding:</strong> <?php echo $row['bleeding']; ?></p>
                                                        <p><strong>CPI: Month/year Completed:</strong> <span id="chief_complaint"><?php echo $row['cpi_month'] . ' ' . $row['cpi_year']; ?></span></p>


                                                        <h5>Date of exposure: <?php echo $row['date_bite'] ?></h5>
                                                        <h5>Place of exposure: <?php echo $row['Place'] ?></h5>
                                                        <h5>Type
                                                        </h5>
                                                        <p><?php

                                                            if (!empty($row['Type_bite'])) {
                                                                $med_history = json_decode($row['Type_bite'], true);

                                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                                    if (is_array($med_history)) {
                                                                        foreach ($med_history as $item) {
                                                                            if (!empty($item)) {
                                                                                echo  ucwords(htmlspecialchars($item)) . ' <br />';
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo 'Decoded JSON is not an array.';
                                                                    }
                                                                } else {
                                                                    echo 'Error decoding JSON: ' . json_last_error_msg();
                                                                }
                                                            } else {
                                                            }
                                                            ?></p>
                                                        <h5>Source: <?php echo $row['animal_type'] ?> <span style="margin-left:10rem;">Vaccinated date:
                                                                <?php
                                                                if (!empty($row['source'])) {
                                                                    echo date('F j, Y', strtotime($row['source']));
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>
                                                            </span>
                                                            <span> / <?php echo $row['pet_vaccinated']; ?></span>
                                                        </h5>
                                                        <h5>Status: <?php echo $row['animal_status'] ?></h5>
                                                        <h5>Site of exposure: <?php echo $row['site_exposure'] ?></h5>
                                                        <div class="ultrasound-details">
                                                            <p><strong>Local wound treatment:</strong> <span id="lmp"><?php echo $row['wound'] ?></span></p>
                                                            <p><strong>Washed w. water only:</strong><span id="ga_by_lmp"> <?php echo $row['washed'] ?></span></p>
                                                            <p><strong>Washed w/soup & water:</strong><span id="edc_by_lmp"><?php echo $row['soap'] ?></span> </p>
                                                            <p><strong>Tandok:</strong> <span id="fhr"><?php echo $row['Tandok'] ?></span></p>
                                                            <p><strong>Applied garlic, etc.:</strong> <span><?php echo $row['Applied'] ?></span></p>
                                                            <p><strong>Tetanus Immunization:</strong><span> <?php echo $row['Tetanus'] ?></span>
                                                                <span style="margin-left:10rem;">Date:
                                                                    <?php
                                                                    if (!empty($row['vac_date'])) {
                                                                        echo date('F j, Y', strtotime($row['vac_date']));
                                                                    } else {
                                                                        echo '';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </p>

                                                        </div>
                                                        <h5>Category exposure: <?php echo $row['category_exposure'] ?></h5>
                                                        <h5>A: <?php echo $row['a'] ?></h5>
                                                        <h5>P: <?php echo $row['p'] ?></h5>
                                                    </div>





                                                </div>



                                                <!-- Row start -->



                                                <br style="clear:both;" />
                                                <br />



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




    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- 
<script src="dist/js/jquery_confirm/jquery-confirm.js"></script> -->

    <!-- Custom JS files -->
    <script src="../assets/js/custom.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="../assets/js/jquery-confirm.min.js"></script>

    <script src="../assets/js/common_javascript_functions.js"></script>
    <script src="../assets/moment/moment.min.js"></script>
    <script src="../assets/daterangepicker/daterangepicker.js"></script>
    <script src="../assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>








    <!-- <script type = "text/javascript">
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script> -->







</body>



</html>