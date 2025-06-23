<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    $query = "SELECT com.*, pat.*, fam.*,mem.*,b.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
              FROM tbl_complaints AS com 
               LEFT JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
              LEFT JOIN tbl_membership_info as mem ON mem.membershipID  = pat.Membership_Info
              LEFT JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_birth_info AS b ON b.patient_id 
              WHERE com.complaintID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();
    


    $patientData = $stmt->fetch(PDO::FETCH_ASSOC);

}




if (isset($_POST['save_bite'])) {

    $user = $_SESSION['user_id'];
    echo $user;
    $hidden_id = trim($_POST['hidden_id']);
    $hidden_id1 = trim($_POST['hidden_id1']);
    $reg_no = trim($_POST['reg_no']);
    $visit_date = date("Y-m-d", strtotime($_POST['visit_date']));
    $past_med = isset($_POST['past_med']) ? json_encode($_POST['past_med']) : '[]';
    $bleeding = $_POST['bleeding'];
    $cpi_month = $_POST['month'];
    $cpi_year = $_POST['year'];
    $exposure_date = date("Y-m-d", strtotime($_POST['exposure_date']));
    echo $exposure_date;
    $Place = trim($_POST['Place']);
    $Type = isset($_POST['Type']) ? json_encode($_POST['Type']) : '[]';
    $source = trim($_POST['source']);
    // $vac_date = date("Y-m-d", strtotime($_POST['vac_date']));
    $vac_date = !empty($_POST['vac_date']) ? $_POST['vac_date'] : null;
    $Vaccinated = trim($_POST['Vaccinated']);
    $status = trim($_POST['status']);
    $site = trim($_POST['site']);
    $wound = trim($_POST['wound']);
    $washed = trim($_POST['Washed']);
    $soap = trim($_POST['soap']);
    $Tandok = trim($_POST['Tandok']);
    $Applied = trim($_POST['Applied']);
    $Tetanus = trim($_POST['Tetanus']);
    // $vaccine_date = date("Y-m-d", strtotime($_POST['vaccine_date']));
    $vaccine_date = !empty($_POST['vaccine_date']) ? $_POST['vaccine_date'] : null;
    $vaccine = trim($_POST['vaccine']);
    $category = trim($_POST['category']);
    $a = trim($_POST['a']);
    $p = trim($_POST['p']);

    $bite_status = 'ongoing';

    $con->beginTransaction();

    try {

        $query = "INSERT INTO tbl_animal_bite_care(`patient_id`, `reg_no`, `date`, `med_history`, `cpi_month`, `cpi_year`,`bleeding`, `animal_type`, `date_bite`, `Place`, `Type_bite`, `source`, `pet_vaccinated`, `animal_status`, `site_exposure`, `wound`, `washed`, `soap`, `Tandok`, `Applied`, `Tetanus`, `vac_date`, `vaccine`, `category_exposure`, `a`,`p`, `userID`,`bite_status`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($query);

        $stmt->execute([
            $hidden_id,
            $reg_no,
            $visit_date,
            $past_med,
            $cpi_month,
            $cpi_year,
            $bleeding,
            $source,
            $exposure_date,
            $Place,
            $Type,
            $vac_date,
            $Vaccinated,
            $status,
            $site,
            $wound,
            $washed,
            $soap,
            $Tandok,
            $Applied,
            $Tetanus,
            $vaccine_date,
            $vaccine,
            $category,
            $a,
            $p,
            $user,
            $bite_status
        ]);


      $immuneId = $con->lastInsertId();
      $stmt = $con->prepare("insert into tbl_patient_visits(`visit_date`, `visit_counts`) VALUES (:visitdate,:visit_counts)");
        $stmt->execute([
              
                ':visitdate' => $visit_date,
                ':visit_counts' => $immuneId,
                
         ]);
        
        

        $con->commit();


        // echo "Data inserted successfully.";

        // $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints SET status = 'Done' WHERE patient_id = ? AND consultation_purpose = 'Animal bite and Care'  and  complaintID = ?");
        // $stmtUpdate1->execute([$hidden_id, $hidden_id1]);

        $patient_name = htmlspecialchars($patientData['name']);
        $patient_id = htmlspecialchars($hidden_id);
        header("Location: form_animalbite_vaccine.php?patient_name=" . urlencode($patient_name) . "&hidden_id=" . urlencode($patient_id));
        exit();
    } catch (Exception $e) {

        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
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

        .form-check-input {
            transform: scale(1);
        }

        .form-input {
            border: none;
            border-bottom: 1px solid black;
            width: 40%;
        }

        .form-input1 {
            border: none;
            border-bottom: 1px solid black;
            width: 10%;
        }

        .form-input:focus {
            border-bottom: 2px solid red;
            outline: none;

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
                <a href="animal_bite.php" class="btn btn-primary">
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

                                <span><?php echo $user['first_name'] . ' ' . $user['lastname']; ?></span>

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
                        <h2>Animal bite & care</h2>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-center">Patient Information</h5>
                            </div>

                            <div class="card-body">
                                <?php if (isset($patientData)) : ?>

                                    <div class="row">

                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5 class="form-label" for="abc">Name: <?php echo htmlspecialchars(ucwords($patientData['name'])); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5 class="form-label" for="abc1">Age: <?php echo htmlspecialchars($patientData['age']); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5 class="form-label" for="abc2">BirthDate: <?php echo htmlspecialchars(date('F j, Y', strtotime($patientData['date_of_birth']))); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5 class="form-label" for="abc4">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></h5>

                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5 class="form-label">Address: <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', ' . $patientData['province']); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5>Status: <?php echo htmlspecialchars(ucwords($patientData['civil_status'])); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5>Contact Number: <?php echo htmlspecialchars($patientData['phone_number']); ?></h5>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-4 col-12">
                                            <div class="mb-1">
                                                <h5>Philhealth No.: <?php echo htmlspecialchars($patientData['philhealth_no']); ?></h5>

                                            </div>
                                        </div>


                                    </div>


                                <?php else : ?>
                                    <p>No patient details found.</p>
                                <?php endif; ?>
                                <hr />

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <label class="form-label">
                                                    VItal Signs:
                                                </label>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2 d-flex flex-column">
                                            <div class="form-check">

                                                <label class="form-check-label" for="symptoms1">BP:</label>
                                                <input type="text" id="bp" name="bp" value="<?php echo $patientData['bp']; ?>" size="4" mr-2" class="input-bottom-border" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex flex-column">
                                            <div class="form-check">

                                                <label class="form-check-label" for="symptoms1">HR:</label>
                                                <input type="text" id="hr" name="hr" value="<?php echo $patientData['hr']; ?>" size="2" mr-2" class="input-bottom-border" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex flex-column">
                                            <div class="form-check">

                                                <label class="form-check-label" for="symptoms1">RR:</label>
                                                <input type="text" id="rr" name="rr" value="<?php echo $patientData['rr']; ?>" size="2" mr-2" class="input-bottom-border" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex flex-column">
                                            <div class="form-check">

                                                <label class="form-check-label" for="symptoms1">TEMP:</label>
                                                <input type="text" id="temp" name="temp" value="<?php echo $patientData['temp']; ?>" size="2" mr-2" class="input-bottom-border" readonly />
                                            </div>
                                        </div>


                                    </div> -->
                                </div>
                                <!-- Row start -->
                                <form method="POST">

                                    <?php

                                    function generateRegistrationNumber()
                                    {

                                        $currentDate = date('Ymd');

                                        global $con;
                                        $countQuery = "SELECT COUNT(*) AS count FROM tbl_animal_bite_care WHERE DATE(date) = CURDATE()";
                                        $countStatement = $con->prepare($countQuery);
                                        $countStatement->execute();
                                        $countResult = $countStatement->fetch(PDO::FETCH_ASSOC);
                                        $count = ($countResult && isset($countResult['count'])) ? intval($countResult['count']) + 1 : 1;


                                        $registrationNumber = $currentDate . str_pad($count, 3, '0', STR_PAD_LEFT);
                                        return $registrationNumber;
                                    }


                                    $newRegistrationNumber = generateRegistrationNumber();
                                    ?>




                                    <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                    <input type="hidden" name="hidden_id1" id="hidden_id1" value="<?php echo htmlspecialchars($patientData['complaintID']); ?>">
                                    <div class="row">

                                        <div class="col-lg-2 col-sm-2 col-12 mb-3">
                                            <label class="form-label">Registration No.: </label>
                                            <input type="text" name="reg_no" class="form-control form-control-sm" value="<?php echo htmlspecialchars($newRegistrationNumber); ?>" required readonly>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Date</label>
                                                <div class="input-group date" id="visit_date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#visit_date" name="visit_date" data-toggle="datetimepicker" autocomplete="off" required />
                                                    <div class="input-group-append" data-target="#visit_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" col-12">
                                            <div class="mb-3">
                                                <label for="text" class="form-label">Pertenint Past Medical History</label>



                                            </div>

                                        </div>

                                        <div class="col-md-2 d-flex flex-column" style="margin-left: 5rem;">
                                            <div class="form-check ">
                                                <input class="form-check-input " type="checkbox" name="past_med[]" id="Immunized" value="Fully Immunized">
                                                <label class="form-check-label mb-1 " for="Immunized">Fully Immunized</label>
                                                <br>
                                                <input class="form-check-input " type="checkbox" name="past_med[]" id="Diabetes" value="Diabetes Mellitus">
                                                <label class="form-check-label mb-1 " for="Diabetes">Diabetes Mellitus</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input " type="checkbox" name="past_med[]" id="Anti" value="Anti-Rabies">
                                                <label class="form-check-label mb-1" for="Anti">Anti- Rabies</label>
                                                <br>
                                                <input class="form-check-input " type="checkbox" name="past_med[]" value="On Meds">
                                                <label class="form-check-label mb-1 " for="past_med">On Meds</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cpi_date" style="float:left;">CPI: Month/year Completed:</label>


                                            <select name="month" class="form-control form-control-sm" id="cpi_month" style="width:15%; float:left;">
                                                <option value="">Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>

                                            </select>

                                            <select class="form-control  form-control-sm" name="year" id="cpi_year" style="width:15%; float:left;">
                                                <option value="">Year</option>
                                                <?php
                                                $currentYear = date('Y');
                                                $startYear = 1990;
                                                for ($year = $currentYear; $year >= $startYear; $year--) {
                                                    echo "<option value=\"$year\">$year</option>";
                                                }
                                                ?>
                                            </select>


                                            <br>
                                            <div style="display: flex; justify-content: space-between; margin: 10px;">
                                                <div class="form-check" style="display: flex; align-items: center;">
                                                    <input class="form-check-input past_med" type="checkbox" name="past_med[]" value="Allergy">
                                                    <label class="form-check-label mb-1" for="Allergy">Allergy</label>
                                                </div>

                                                <div class="form-check" style="display: flex; align-items: center;">
                                                    <input class="form-check-input past_med" type="checkbox" name="past_med[]" value="Food">
                                                    <label class="form-check-label mb-1" for="Food">Food</label>
                                                </div>

                                                <div class="form-check" style="display: flex; align-items: center;">
                                                    <input class="form-check-input past_med" type="checkbox" name="past_med[]" value="Drug">
                                                    <label class="form-check-label mb-1" for="Drug">Drug</label>
                                                </div>
                                            </div>






                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="past_med[]" id="abnormalPupillaryReaction" value="Hypertension">
                                                <label class="form-check-label mb-1" for="Hypertension">Hypertension</label>
                                                <br>
                                                <input class="form-check-input" type="checkbox" name="past_med[]" id="paleConjuctivae" value="On Meds">
                                                <label class="form-check-label mb-1" for="OnMeds">On Meds</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3" style="margin-left:5rem;">
                                            <div class="form">
                                                <label class="form-check-label past_med" for="Otherss">Others</label>
                                                <input type="text" name="past_med[]" value="" class="form-check-label input-bottom-border-only">
                                            </div>
                                        </div>


                                    </div>


                                    <div style="display: flex; justify-content: space-between; margin: 10px;">
                                        <div style="text-align: left; flex: 1; margin-right: 1rem;">
                                            <label class="form-label" style="margin-left:12rem;">Date of Exposure</label>
                                            <input style="margin-left:2rem;" type="date" id="exposure_date" name="exposure_date" class="form-input" required />
                                        </div>

                                        <div style="text-align: left; flex: 1;">
                                            <label class="form-label">Place of exposure:</label>
                                            <input class="form-input mb-3" id="Place" name="Place" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-1 ">
                                            <div class="form-check">
                                                <label class="form-check-label" style="margin-left: 3rem;">
                                                    Type:
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 d-flex flex-column">
                                            <div class="form-check ">
                                                <input class="form-check-input Type" type="checkbox" name="Type[]" id="Bite" value="Bite">
                                                <label class="form-check-label mb-1" for="Bite">Bite</label>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check" style="margin-left:2rem;">
                                                <input class="form-check-input Type" type="checkbox" name="Type[]" id="Non" value="Non-bite">
                                                <label class="form-check-label mb-1" for="Non">None-bite</label>

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label mb-1">Bleeding:</label>
                                                <input class="form-check-label input-bottom-border-only" type="input" id="Bleeding" name="bleeding" style="width:2rem">
                                                <label class="form-check-label mb-1">(-/+)</label>

                                                <label class="form-check-label mb-1">if(+)</label>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Type[]" id="dryMucuousMembrane" value="Spontaneous">
                                                <label class="form-check-label mb-1" for="dryMucuousMembrane">Spontaneous</label>

                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="Type[]" id="dryMucuousMembrane" value="Induced">
                                                <label class="form-check-label mb-1" for="dryMucuousMembrane">Induced</label>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-1 ">
                                            <div class="form-check">
                                                <label class="form-check-label" style="margin-left: 3rem;">
                                                    Source:
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 d-flex flex-column">
                                            <div class="form-check ">
                                                <input class="form-check-input Source" type="checkbox" name="source" value="Dog">
                                                <label class="form-check-label mb-1" for="Dog">Dog</label>
                                                <br>
                                                <input class="form-check-input Source" type="checkbox" name="source" value="Pet">
                                                <label class="form-check-label mb-1" for="Dog">Pet</label>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check" style="margin-left:2rem;">
                                                <input class="form-check-input Source" type="checkbox" name="source" value="Cat">
                                                <label class="form-check-label mb-1" for="Cat">Cat</label>
                                                <br>
                                                <input class="form-check-input Source" type="checkbox" name="source" value="Stray">
                                                <label class="form-check-label mb-1" for="Cat">Stray</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label mb-1">Others:</label>
                                                <input class="Source form-check-label input-bottom-border-only" type="input" name="source" value="" style="width:10rem">
                                                <br>
                                                <label class="form-check-label mb-1">Vaccinated Date:</label>
                                                <input type="date" name="vac_date" class="form-input" id="vac_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check" style="margin-left:2rem;">
                                                <input class="form-check-input Vaccinated" type="checkbox" name="Vaccinated" value="Vaccinated" id="vaccinated">
                                                <label class="form-check-label mb-1" for="vaccinated">Vaccinated</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check" style="margin-left:2rem;">
                                                <input class="form-check-input Vaccinated" type="checkbox" name="Vaccinated" value="Unknown" id="unknown">
                                                <label class="form-check-label mb-1" for="unknown">Unknown</label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-1 ">
                                            <div class="form-check">
                                                <label class="form-check-label" style="margin-left: 3rem;">
                                                    Status:
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 d-flex flex-column">
                                            <div class="form-check ">
                                                <input class="form-check-input status" type="checkbox" name="status" value="Alive">
                                                <label class="form-check-label mb-1" for="Alive">Alive</label>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check" style="margin-left:2rem;">
                                                <input class="status form-check-input " type="checkbox" name="status" value="Died">
                                                <label class="form-check-label mb-1" for="Cat">Died</label>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="status form-check-input " type="checkbox" name="status" value="Killed Intentionally">
                                                <label class="form-check-label mb-1" for="Cat">Killed Intentionally</label>



                                            </div>

                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="form-check" style="margin-left:2rem;">

                                                <input class="status form-check-input " type="checkbox" name="status" value="Lost">
                                                <label class="form-check-label mb-1" for="Lost">Lost</label>

                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; margin: 10px;">


                                        <div style="text-align: left; flex: 1;">
                                            <label for="text" class="form-label">SITE OF EXPOSURE: <span><i>(Please describe and sketch)</i></span>
                                            </label>

                                            <input class="form-input mb-3" name="site" required>
                                        </div>
                                    </div>

                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="wound">Local wound treatment:</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="wound form-check-input" name="wound" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="wound form-check-input" name="wound" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="Washed">Washed w/water only:</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Washed form-check-input" name="Washed" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Washed form-check-input" name="Washed" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="soap">Washed w/soap & water:</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="soap form-check-input" name="soap" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="soap form-check-input" name="soap" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="Tandok">Tandok:</label>
                                        <input style="margin-left:10rem;" type="checkbox" class="Tandok form-check-input" name="Tandok" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Tandok form-check-input" name="Tandok" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="Applied">Applied garlic, etc.:</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Applied form-check-input" name="Applied" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Applied form-check-input" name="Applied" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="Tetanus">Tetanus Immunization:</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Tetanus form-check-input" name="Tetanus" value="yes" />
                                        <label>yes</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="Tetanus form-check-input" name="Tetanus" value="no" />
                                        <label>no</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="text">Date:</label>
                                        <input type="date" name="vaccine_date" class="form-input" style="width: 12%;">
                                        <input style="margin-left:5rem;" type="checkbox" class="vaccine form-check-input" name="vaccine" value="HTIG" />
                                        <label>HTIG</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="vaccine form-check-input" name="vaccine" value="TT" />
                                        <label>TT</label>
                                    </div>
                                    <div style="font-size:16px;" class="mb-2">
                                        <label for="CATEGORY"><strong>CATEGORY EXPOSURE:</strong></label>
                                        <input style="margin-left:5rem;" type="checkbox" class="CATEGORY form-check-input" name="category" value="I" required />
                                        <label>I</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="CATEGORY form-check-input" name="category" value="II" required/>
                                        <label>II</label>
                                        <input style="margin-left:5rem;" type="checkbox" class="CATEGORY form-check-input" name="category" value="III" required/>
                                        <label>III</label>
                                    </div>

                            </div>


                            <div class=" col-12">

                               
                                <div style="text-align: left; flex: 1;">
                                    <label for="CATEGORY"><strong>O:</strong></label>
                                    <label class="form-label">T:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp" value=" <?php echo $patientData['temp']; ?>" readonly>
                                    <label class="form-label">BP:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp" value="<?php echo $patientData['bp']; ?>" readonly>
                                    <label class="form-label">CR:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp" value="<?php echo $patientData['hr']; ?>" readonly>
                                    <label class="form-label">RR:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp"value="<?php echo $patientData['rr']; ?>" readonly>
                                    <label class="form-label">LMP:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp" value="<?php echo $patientData['LMP']; ?>"readonly>
                                    <label class="form-label">AOG:</label>
                                    <input class="form-input1 mb-3" id="temp" name="temp"value="<?php echo $patientData['AOG']; ?>" readonly>
                                </div>
                                <div style="text-align: left; flex: 1;">
                                  
                                    <label class="form-label">A:</label>
                                    <input class="form-input mb-3" id="a" name="a" >
                                    <br>
                                    <label class="form-label">P:</label>
                                    <input class="form-input mb-3" id="p" name="p" >
                                    <br>
                                  
                                </div>
                               
                            </div>




                        </div>
                    </div>


                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-left">

                            <button type="submit" id="save_bite" name="save_bite" class="btn btn-info">
                                Submit
                            </button>


                        </div>
                    </div>

                </div>

                </form>

                <!-- Row end -->

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




    <script type="text/javascript">
        $(function() {
            $('#visit_date').datetimepicker({
                format: 'L',
                maxDate: new Date()
            });



        });
        // Awake & Altered checkbox
    </script>




    <script>
        $(document).ready(function() {
            $(".Type").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Type").not(this).prop("disabled", true);
                } else {
                    $(".Type").prop("disabled", false);
                }
            });
            $(".Source").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Source").not(this).prop("disabled", true);
                } else {
                    $(".Source").prop("disabled", false);
                }
            });
            $(".status").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".status").not(this).prop("disabled", true);
                } else {
                    $(".status").prop("disabled", false);
                }
            });
            // $(".Vaccinated").on("change", function() {
            //     if ($(this).is(":checked")) {
            //         $(".Vaccinated").not(this).prop("disabled", true);
            //     } else {
            //         $(".Vaccinated").prop("disabled", false);
            //     }
            // });
            $(".Vaccinated").on("change", function() {
                if ($(this).val() === "Unknown") {
                    if ($(this).is(":checked")) {
                        $("#vac_date").prop("disabled", true); // Disable the date input
                        $("#vaccinated").prop("disabled", true); // Disable the other checkbox
                    } else {
                        $("#vac_date").prop("disabled", false); // Enable the date input
                        $("#vaccinated").prop("disabled", false); // Enable the other checkbox
                    }
                } else if ($(this).val() === "Vaccinated") {
                    if ($(this).is(":checked")) {
                        $("#unknown").prop("disabled", true); // Disable the other checkbox
                    } else {
                        $("#unknown").prop("disabled", false); // Enable the other checkbox
                    }
                }
            });
            $(".wound").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".wound").not(this).prop("disabled", true);
                } else {
                    $(".wound").prop("disabled", false);
                }
            });
            $(".Washed").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Washed").not(this).prop("disabled", true);
                } else {
                    $(".Washed").prop("disabled", false);
                }
            });
            $(".soap").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".soap").not(this).prop("disabled", true);
                } else {
                    $(".soap").prop("disabled", false);
                }
            });
            $(".Tandok").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Tandok").not(this).prop("disabled", true);
                } else {
                    $(".Tandok").prop("disabled", false);
                }
            });
            $(".Applied").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Applied").not(this).prop("disabled", true);
                } else {
                    $(".Applied").prop("disabled", false);
                }
            });
            $(".Tetanus").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".Tetanus").not(this).prop("disabled", true);
                } else {
                    $(".Tetanus").prop("disabled", false);
                }
            });
            $(".vaccine").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".vaccine").not(this).prop("disabled", true);
                } else {
                    $(".vaccine").prop("disabled", false);
                }
            });
            $(".CATEGORY").on("change", function() {
                if ($(this).is(":checked")) {
                    $(".CATEGORY").not(this).prop("disabled", true);
                } else {
                    $(".CATEGORY").prop("disabled", false);
                }
            });


        });
    </script>

</body>



</html>