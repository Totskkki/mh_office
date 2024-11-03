<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';



if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];
    // Prepare a statement to select the patient and complaint data
    $query = "SELECT com.*, pat.*, fam.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
              FROM tbl_complaints AS com 
              JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
              JOIN 
              tbl_familyaddress AS fam ON pat.family_address = fam.famID
              WHERE com.complaintID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();


    $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
}




if (isset($_POST['save_prenatal'])) {
   
        $user = $_SESSION['user_id'];

    $date = date("Y-m-d", strtotime($_POST['date']));
    $chief_complain = $_POST['chief_complain'];
    $chief_complain = ucwords(strtolower($chief_complain));

    $attending_physician = $_POST['attending_physician'];
    $attending_physician = ucwords(strtolower($attending_physician));

    $lmp = $_POST['lmp'];
    $ga_by_lmp = $_POST['ga_by_lmp'];
    $edc_by_lmp = $_POST['edc_by_lmp'];
    
    $ga_by_sonar = $_POST['ga_by_sonar'];
    $edc_by_utz = $_POST['edc_by_utz'];
    $fhr = $_POST['fhr'];
    $pregnancy_age = $_POST['pregnancy_age'];
    $biparietal_diameter = $_POST['biparietal_diameter'];
    $biparietal_diameter_eq = $_POST['biparietal_diameter_eq'];
    $head_circumference = $_POST['head_circumference'];
    $head_circumference_eq = $_POST['head_circumference_eq'];
    $abdominal_circumference = $_POST['abdominal_circumference'];
    $abdominal_circumference_eq = $_POST['abdominal_circumference_eq'];
    $femoral_length =  $_POST['femoral_length'];
    $femoral_length_eq =  $_POST['femoral_length_eq'];
    $crown_rump_length = $_POST['crown_rump_length'];
    $crown_rump_length_eq = $_POST['crown_rump_length_eq'];
    $mean_gest_sac_diameter = $_POST['mean_gest_sac_diameter'];
    $mean_gest_sac_diameter_eq = $_POST['mean_gest_sac_diameter_eq'];
    $average_fetal_weight = $_POST['average_fetal_weight'];
    $gestation = $_POST['gestation'];
    $presentation_lie = $_POST['presentation_lie'];
    $amniotic_fluid = $_POST['amniotic_fluid'];
    $placenta_location = $_POST['placenta_location'];
    $previa = $_POST['previa'];
    $placenta_grade = $_POST['placenta_grade'];
    $fetal_activity = $_POST['fetal_activity'];

    $comments = $_POST['comments'];
    $comments = ucwords(strtolower($comments));
    $radiologist = $_POST['radiologist'];
    $radiologist = ucwords(strtolower($radiologist));

    $hidden_id = trim($_POST['hidden_id']);
    $hidden_id1 = trim($_POST['hidden_id1']);

    if (
        $gestation !== '' && $presentation_lie !== '' && $amniotic_fluid !== '' && $placenta_location !== '' && $previa !==
        '' && $placenta_grade !== '' && $fetal_activity !== ''
    ) {
    }

    $con->beginTransaction();

    // $stmt = $con->prepare("INSERT INTO `tbl_prenatal`(`date`, `chief_complaint`, `attending_physician`, `lmp`,
    //  `ga_by_lmp`, `edc_by_lmp`, `fhr`, `ga_by_sonar`, `edc_by_utz`, `pregnancy_age`, `biparietal_diameter`,
    //   `biparietal_eq`, `head_circumference`, `head_circumference_eq`, `abdominal_circumference`,
    //    `abdominal_circumference_eq`, `femoral_length`, `femoral_length_eq`, `crown_rump_length`, 
    //    `crown_rump_length_eq`, `mean_gest_sac_diameter`, `mean_gest_sac_diameter_eq`,
    //     `average_fetal_weight`, `gestation`, `presentation_lie`, `amniotic_fluid`,
    //      `placenta_location`, `previa`, `placenta_grade`, `fetal_activity`, `comments`,
    //       `radiologist`, `patient_id`, `user_id`) VALUES
    //     (:date, :chief_complaint, :attending_physician, :lmp,:ga_by_lmp, :edc_by_lmp, :fhr,:ga_by_sonar, :edc_by_utz, :pregnancy_age, :biparietal_diameter, :biparietal_eq, :head_circumference_eq, :abdominal_circumference_eq, :femoral_length, :femoral_length_eq, :crown_rump_length, :crown_rump_length_eq, :mean_gest_sac_diameter, :average_fetal_weight, :gestation, :presentation_lie, :amniotic_fluid, :placenta_location, :previa, :placenta_grade, :fetal_activity, :comments, :radiologist, :hidden_id, :user)");

    $stmt = $con->prepare("INSERT INTO `tbl_prenatal`(`date`, `chief_complaint`, `attending_physician`, `lmp`, `ga_by_lmp`, `edc_by_lmp`, `fhr`, `ga_by_sonar`, `edc_by_utz`, `pregnancy_age`, `biparietal_diameter`, `biparietal_eq`, `head_circumference`, `head_circumference_eq`, `abdominal_circumference`, `abdominal_circumference_eq`, `femoral_length`, `femoral_length_eq`, `crown_rump_length`, `crown_rump_length_eq`, `mean_gest_sac_diameter`, `mean_gest_sac_diameter_eq`, `average_fetal_weight`, `gestation`, `presentation_lie`, `amniotic_fluid`, `placenta_location`, `previa`, `placenta_grade`, `fetal_activity`, `comments`, `radiologist`, `patient_id`, `user_id`) 
    VALUES (:date, :chief_complaint, :attending_physician, :lmp, :ga_by_lmp, :edc_by_lmp, :fhr, :ga_by_sonar, :edc_by_utz, :pregnancy_age, :biparietal_diameter, :biparietal_eq, :head_circumference, :head_circumference_eq, :abdominal_circumference, :abdominal_circumference_eq, :femoral_length, :femoral_length_eq, :crown_rump_length, :crown_rump_length_eq, :mean_gest_sac_diameter, :mean_gest_sac_diameter_eq, :average_fetal_weight, :gestation, :presentation_lie, :amniotic_fluid, :placenta_location, :previa, :placenta_grade, :fetal_activity, :comments, :radiologist, :patient_id, :user_id)");
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':chief_complaint', $chief_complain);
            $stmt->bindParam(':attending_physician', $attending_physician);
            $stmt->bindParam(':lmp', $lmp);
            $stmt->bindParam(':ga_by_lmp', $ga_by_lmp);
            $stmt->bindParam(':edc_by_lmp', $edc_by_lmp);
            $stmt->bindParam(':fhr', $fhr);
            $stmt->bindParam(':ga_by_sonar', $ga_by_sonar);
            $stmt->bindParam(':edc_by_utz', $edc_by_utz);
            $stmt->bindParam(':pregnancy_age', $pregnancy_age);
            $stmt->bindParam(':biparietal_diameter', $biparietal_diameter);
            $stmt->bindParam(':biparietal_eq', $biparietal_diameter_eq);
            $stmt->bindParam(':head_circumference', $head_circumference);
            $stmt->bindParam(':head_circumference_eq', $head_circumference_eq);
            $stmt->bindParam(':abdominal_circumference', $abdominal_circumference);
            $stmt->bindParam(':abdominal_circumference_eq', $abdominal_circumference_eq);
            $stmt->bindParam(':femoral_length', $femoral_length);
            $stmt->bindParam(':femoral_length_eq', $femoral_length_eq);
            $stmt->bindParam(':crown_rump_length', $crown_rump_length);
            $stmt->bindParam(':crown_rump_length_eq', $crown_rump_length_eq);
            $stmt->bindParam(':mean_gest_sac_diameter', $mean_gest_sac_diameter);
            $stmt->bindParam(':mean_gest_sac_diameter_eq', $mean_gest_sac_diameter_eq);
            $stmt->bindParam(':average_fetal_weight', $average_fetal_weight);
            $stmt->bindParam(':gestation', $gestation);
            $stmt->bindParam(':presentation_lie', $presentation_lie);
            $stmt->bindParam(':amniotic_fluid', $amniotic_fluid);
            $stmt->bindParam(':placenta_location', $placenta_location);
            $stmt->bindParam(':previa', $previa);
            $stmt->bindParam(':placenta_grade', $placenta_grade);
            $stmt->bindParam(':fetal_activity', $fetal_activity);
            $stmt->bindParam(':comments', $comments);
            $stmt->bindParam(':radiologist', $radiologist);
            $stmt->bindParam(':patient_id', $hidden_id);
            $stmt->bindParam(':user_id', $user);



    $stmt->execute();

    $con->commit();
    $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints SET status = 'Done' WHERE patient_id = :patientID AND consultation_purpose = 'Prenatal' or consultation_purpose ='Birthing' and  complaintID = :complaintID");
    $stmtUpdate1->bindParam(':patientID', $hidden_id);
    $stmtUpdate1->bindParam(':complaintID', $hidden_id1);
    $stmtUpdate1->execute();
    $_SESSION['status'] = "Patient check-up submitted succefully.";
    $_SESSION['status_code'] = "success";
    header('location: maternity.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        .input-bottom-border {
            border: none;
            border-bottom: 1px solid black;
        }

        .forms-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
        }

        .card-body {
            flex: 1;
            min-width: 250px;
            margin: 10px;
        }

        .form-check {
            margin-bottom: 1px;
        }

        .gap-3 {
            gap: .1rem !important;
        }


        .input-bottom-border-only {
            border: none;
            border-bottom: 2px solid red;
            padding: 5px;
            width: 100%;

        }

        .input-bottom-border-only:focus {
            border-bottom: 2px solid blue;
            outline: none;

        }

        .card-body>.form-check {
            margin-right: 10px;
            /* Adjust spacing between checkboxes */
        }

        .form-check-input {
            transform: scale(.7);
        }

        .form-check-label {
            font-size: 13px;
        }
    </style>



</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->


        <!-- Sidebar wrapper start -->
        <?php include './config/session.php';


        // if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['user_type'] === 'RHU') {
        //     header("location: RHU/dashboard-mho.php");
        //     exit;
        // } 
        ?>
        <!-- Sidebar wrapper end -->

        <!-- App container starts -->
        <div class="app-container">

            <!-- App header starts -->


            <div class="app-header d-flex align-items-center ">
                <a href="maternity.php" class="btn btn-primary">
                    <i class="icon-chevron-left"></i> Back</i>
                </a>
                <!-- App header actions start -->
                <div class="header-actions">

                    <div class="d-md-flex d-none gap-2">

                        <br>


                    </div>
                    <div class="dropdown ms-3">

                        <a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <img src="<?php echo (!empty($user['profile_picture'])) ? '../user_images/' . $user['profile_picture'] : '../user_images/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
                            <div class="d-flex flex-column">

                                <span><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></span>

                            </div>

                        </a>

                    </div>
                </div>

            </div>
            <!-- App header actions end -->

        </div>
        <!-- App header ends -->



        <!-- App body starts -->
        <div class="app-body">



            <div class="container-fluid">


                <div class="row">
                    <div class="col-xxl-12">

                        <h2 class="text-center"><strong>Prenatal Form</strong></h2>

                        <div class="card">
                            <div class="card-header">
                                <?php if (isset($patientData)) : ?>
                                    <h3 class="card-title "> <?php echo htmlspecialchars(ucwords($patientData['name'])); ?></h3>
                            </div>




                            <div class="well">

                                <div class="panel panel-default">

                                    <form method="POST">


                                        <div class="row">
                                            <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                            <input type="hidden" name="hidden_id1" id="hidden_id1" value="<?php echo htmlspecialchars($patientData['complaintID']); ?>">
                                            <!-- <div class="col-lg-3 col-sm-4 col-12">
                                                <div class="mb-1">
                                                   

                                                </div>
                                            </div> -->

                                            <div class="col-lg-3 col-sm-4 col-12" style="margin-left: 1rem;">
                                                <div class="mb-1">
                                                    <h5 class="form-label" for="Age">Age: <?php echo htmlspecialchars($patientData['age']); ?></h5>

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-4 col-12">
                                                <div class="mb-1">
                                                    <h5 class="form-label" for="Birth">Birth Date: <?php echo htmlspecialchars(date('F j, Y', strtotime($patientData['date_of_birth']))); ?></h5>

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-4 col-12">
                                                <div class="mb-1">
                                                    <h5 class="form-label" for="Sex">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></h5>

                                                </div>
                                            </div>


                                            <div class="col-lg-3 col-sm-4 col-12" style="margin-left: 1rem;">
                                                <div class="mb-1">
                                                    <h5>Status: <?php echo htmlspecialchars(ucwords($patientData['civil_status'])); ?></h5>

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-4 col-12">
                                                <div class="mb-1">
                                                    <h5>Contact Number: <?php echo htmlspecialchars($patientData['phone_number']); ?></h5>

                                                </div>
                                            </div>
                                            <div class="col-lg-12" style="margin-left: 1rem;">
                                                <div class="mb-1">
                                                    <h5 class="form-label">Address: <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', ' . $patientData['province']); ?></h5>

                                                </div>
                                            </div>


                                        </div>


                                    <?php else : ?>
                                        <p>No patient details found.</p>
                                    <?php endif; ?>
                                    <hr />
                                    <div class="card-body">
                                        <div class="col-lg-2  col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Date </label>

                                                <div class="input-group date" id="date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#date" name="date" data-toggle="datetimepicker" autocomplete="off" />
                                                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="chief_complain" class="form-label">Chief Complain</label>

                                            <textarea class="form-control" name="chief_complain" style="resize:none;"></textarea>
                                            <br />
                                            <label for="attending_physician" class="form-label ">Attending Physician</label>
                                            <input class="form-control" type="text" name="attending_physician" required="required" style="width:20%;" />
                                            <br />
                                            <h4><b>Evaluation/Interpretation:</b></h4>
                                            <h3>
                                                <center><b>OBSTETRIC ULTRASOUND</b></center>
                                            </h3>
                                        </div>
                                        <br />

                                        <div class="row">
                                            <div class="col">
                                                <label for="lmp" class="mr-2">LMP:</label>
                                                <input type="text" name="lmp" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                            <div class="col">
                                                <label for="fhr" class="mr-2">FHR:</label>
                                                <input type="text" name="fhr" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="ga_by_lmp" class="mr-2">GA by LMP:</label>
                                                <input type="text" name="ga_by_lmp" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                            <div class="col">
                                                <label for="ga_by_sonar" class="mr-2">GA by SONAR:</label>
                                                <input type="text" name="ga_by_sonar" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="edc_by_lmp" class="mr-2">EDC by LMP:</label>
                                                <input type="text" name="edc_by_lmp" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                            <div class="col">
                                                <label for="edc_by_utz" class="mr-2">EDC by UTZ:</label>
                                                <input type="text" name="edc_by_utz" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                        </div>
                                        <style>
                                            .form-check-input {
                                                margin-left: 5rem;
                                            }
                                        </style>
                                        <div class="row">

                                            <div class="col">
                                                <label for="pregnancy_age" class="mr-2">Pregnancy Age:</label>
                                                <input type="text" class="form-control" name="pregnancy_age" class="form-control mb-2" style="width: 150px; display: inline-block;" />
                                            </div>
                                        </div>
                                        <br />
                                        <div style="width:25%; font-size:16px; float:left;" class="form-inline">
                                            <center><label class="form-label">Parameters</label></center>
                                            <label for="biparietal_diameter" style="margin-top:5px;" class="form-label">Biparietal Diameter</label>
                                            <br />
                                            <label for="Head_circumference" style="margin-top:35px;" class="form-label">Head Circumference</label>
                                            <br />
                                            <label for="abdominal_circumference" style="margin-top:30px;" class="form-label">Abdominal Circumference</label>
                                            <br />
                                            <label for="femoral_length" style="margin-top:30px;" class="form-label">Femoral Length</label>
                                            <br />
                                            <label for="crown_rump_length" style="margin-top:35px;" class="form-label">Crown Rump Length</label>
                                            <br />
                                            <label for="mean_gest_sac_diameter" style="margin-top:30px;" class="form-label">Mean Gest. Sac Diameter</label>
                                            <br />
                                            <label for="average_fetal_weight" style="margin-top:30px;" class="form-label">Average Fetal Weight</label>
                                        </div>
                                        <div style="width:27%; margin-left:8%; float:left;" class="form-inline">
                                            <center><label class="form-label">Measurement</label></center>
                                            <center><input type="text" name="biparietal_diameter" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="head_circumference" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="abdominal_circumference" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="femoral_length" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="crown_rump_length" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="mean_gest_sac_diameter" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="average_fetal_weight" class="form-control" /></center>
                                        </div>
                                        <div style="width:27%; margin-left:8%; float:left;" class="form-inline mb-3">
                                            <center><label class="form-label">Equivalent Age</label></center>
                                            <center><input type="text" name="biparietal_diameter_eq" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="head_circumference_eq" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="abdominal_circumference_eq" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="femoral_length_eq" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="crown_rump_length_eq" class="form-control" /></center>
                                            <br />
                                            <center><input type="text" name="mean_gest_sac_diameter_eq" class="form-control" /></center>
                                        </div>
                                        <br style="clear:both;" />
                                        <br />



                                        <label style="font-size:20px;" class="form-label mb-3">OB Description Report:</label>

                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="gestation">Gestation</label>
                                            <input type="checkbox" class="gestation form-check-input" name="gestation" value="Single" />
                                            <label>Single</label>
                                            <input type="checkbox" class="gestation form-check-input" name="gestation" value="Multiple" />
                                            <label>Multiple</label>
                                        </div>
                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="presentation_lie">Presentation/Lie</label>
                                            <input class=" presentation_lie form-check-input" type="checkbox" name="presentation_lie" value="Cephalic" />
                                            <label>Cephalic<label>
                                                    <input class="presentation_lie form-check-input" type="checkbox" name="presentation_lie" value="Breech" />
                                                    <label>Breech</label>
                                                    <input class="presentation_lie form-check-input" type="checkbox" name="presentation_lie" value="Transverse" />
                                                    <label>Transverse</label>
                                                    <input class="presentation_lie form-check-input" type="checkbox" name="presentation_lie" value="Oblique" />
                                                    <label>Oblique</label>
                                                    <input class="presentation_lie form-check-input" type="checkbox" name="presentation_lie" value="Variable" />
                                                    <label>Variable</label>
                                        </div>
                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="amniotic_fluid">Amniotic FLuid</label>
                                            <input style="margin-left:62px;" class="form-check-input amniotic_fluid" type="checkbox" name="amniotic_fluid" value="Normal" />
                                            <label>Normal<label>
                                                    <input style="margin-left:40px;" class="form-check-input amniotic_fluid" type="checkbox" name="amniotic_fluid" value="Decreased" />
                                                    <label>Decreased</label>
                                                    <input style="margin-left:40px;" class="form-check-input amniotic_fluid" type="checkbox" name="amniotic_fluid" value="Increased" />
                                                    <label>Increased</label>
                                        </div>
                                        <label style=" margin-left:146px; font-size:16px;">AF index:</label>
                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="placenta_location">Placenta Location</label>
                                            <input class="form-check-input placenta_location" type="checkbox" name="placenta_location" value="Fundus" />
                                            <label>Fundus<label>
                                                    <input class="form-check-input placenta_location" type="checkbox" name="placenta_location" value="Anterior" />
                                                    <label>Anterior</label>
                                                    <input class="form-check-input placenta_location" type="checkbox" name="placenta_location" value="Posterior" />
                                                    <label>Posterior</label>
                                                    <input class="form-check-input placenta_location" type="checkbox" name="placenta_location" value="R Lateral" />
                                                    <label>R Lateral</label>
                                                    <input class="form-check-input placenta_location" type="checkbox" name="placenta_location" value="L Lateral" />
                                                    <label>L Lateral</label>

                                        </div>
                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="previa">Previa</label>
                                            <input style="margin-left:129px;" class="form-check-input previa" type="checkbox" name="previa" value="Low Lying" />
                                            <label>Low Lying<label>
                                                    <input style="margin-left:40px;" class="form-check-input previa" type="checkbox" name="previa" value="Marginal" />
                                                    <label>Marginal</label>
                                                    <input style="margin-left:40px;" class="form-check-input previa" type="checkbox" name="previa" value="Complete" />
                                                    <label>Complete</label>
                                                    <input style="margin-left:40px;" class="form-check-input previa" type="checkbox" name="previa" value="Partial" />
                                                    <label>Partial</label>
                                        </div>
                                        <div style="font-size:16px;" class="mb-2">

                                            <label for="placenta_grade">Placenta Grade</label>
                                            <input class="form-check-input placenta_grade" type="checkbox" name="placenta_grade" value="0" />
                                            <label>0<label>
                                                    <input class="form-check-input placenta_grade" type="checkbox" name="placenta_grade" value="1" />
                                                    <label>1</label>
                                                    <input class="form-check-input placenta_grade" type="checkbox" name="placenta_grade" value="2" />
                                                    <label>2</label>
                                                    <input class="form-check-input placenta_grade" type="checkbox" name="placenta_grade" value="3" />
                                                    <label>3</label>
                                        </div>

                                        <div style="font-size:16px;" class="mb-2">
                                            <label for="fetal_activity">Fetal Activity</label>
                                            <input class="form-check-input fetal_activity" type="checkbox" name="fetal_activity" value="limb" />
                                            <label>Limb<label>
                                                    <input class="form-check-input fetal_activity" type="checkbox" name="fetal_activity" value="heart" />
                                                    <label>Heart</label>
                                                    <input class="form-check-input fetal_activity" type="checkbox" name="fetal_activity" value="Breathing" />
                                                    <label>Breathing</label>
                                        </div>
                                        <br />
                                        <div class="form-group mb-3">
                                            <label for="comments" class="form-label">COMMENTS</label>
                                            <textarea class="form-control" name="comments" style="resize:none;"></textarea>

                                        </div>
                                        <div class="form-label mb-2">
                                            <label for="radiologist">Radiologist</label>
                                            <input class="form-control" type="text" name="radiologist" required="required" style="width:20%;" spellcheck="false" data-ms-editor="true">
                                        </div>
                                        <br />
                                        <div class="form-inline">

                                            <button class="btn btn-info" name="save_prenatal"> <span class="fs-3 icon-save_alt"></span> SAVE</button>
                                        </div>
                                    </div>

                                    <?php ?>
                                    </form>
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
    <?php include './config/footer.php';
    $message = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }
    ?>
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




    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>

    <!-- <script src="assets/moment/moment.min.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->


    <script type="text/javascript">
        $(document).ready(function() {

            $(".gestation").on("change", function() {
                if ($(".gestation:checked").length == 1) {
                    $(".gestation").attr("disabled", "disabled");
                    $(".gestation:checked").removeAttr("disabled");
                } else {
                    $(".gestation").removeAttr("disabled");
                }
            });
            $(".presentation_lie").on("change", function() {
                if ($(".presentation_lie:checked").length == 1) {
                    $(".presentation_lie").attr("disabled", "disabled");
                    $(".presentation_lie:checked").removeAttr("disabled");
                } else {
                    $(".presentation_lie").removeAttr("disabled");
                }
            });
            $(".amniotic_fluid").on("change", function() {
                if ($(".amniotic_fluid:checked").length == 1) {
                    $(".amniotic_fluid").attr("disabled", "disabled");
                    $(".amniotic_fluid:checked").removeAttr("disabled");
                } else {
                    $(".amniotic_fluid").removeAttr("disabled");
                }
            });
            $(".placenta_location").on("change", function() {
                if ($(".placenta_location:checked").length == 1) {
                    $(".placenta_location").attr("disabled", "disabled");
                    $(".placenta_location:checked").removeAttr("disabled");
                } else {
                    $(".placenta_location").removeAttr("disabled");
                }
            });
            $(".previa").on("change", function() {
                if ($(".previa:checked").length == 1) {
                    $(".previa").attr("disabled", "disabled");
                    $(".previa:checked").removeAttr("disabled");
                } else {
                    $(".previa").removeAttr("disabled");
                }
            });
            $(".placenta_grade").on("change", function() {
                if ($(".placenta_grade:checked").length == 1) {
                    $(".placenta_grade").attr("disabled", "disabled");
                    $(".placenta_grade:checked").removeAttr("disabled");
                } else {
                    $(".placenta_grade").removeAttr("disabled");
                }
            });
            $(".fetal_activity").on("change", function() {
                if ($(".fetal_activity:checked").length == 1) {
                    $(".fetal_activity").attr("disabled", "disabled");
                    $(".fetal_activity:checked").removeAttr("disabled");
                } else {
                    $(".fetal_activity").removeAttr("disabled");
                }
            });

        });
    </script>
    <script>
        $(function() {
            $('#date').datetimepicker({
                format: 'L'
            });

        });
    </script>



</body>



</html>