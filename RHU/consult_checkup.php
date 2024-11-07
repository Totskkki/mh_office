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


if (isset($_POST['save_checkup'])) {

    // var_dump($_POST);
    $hidden_id = trim($_POST['hidden_id']);
    $hidden_id1 = trim($_POST['hidden_id1']);

    // vital signs
    $bp = trim($_POST['bp']);
    $hr = trim($_POST['hr']);
    $rr = trim($_POST['rr']);
    $temp = trim($_POST['temp']);
    $no_illness = trim($_POST['no_illness']);

    $history_ill = trim($_POST['history_ill']);
    $pertenint_ill = trim($_POST['pertenint_ill']);

    $Awake = trim($_POST['Awake']);

    $heent = isset($_POST['heent']) ? json_encode($_POST['heent']) : '[]';

    $chest = isset($_POST['CHEST']) ? json_encode($_POST['CHEST']) : '[]';
    $CSV = isset($_POST['CSV']) ? json_encode($_POST['CSV']) : '[]';

    $ABDOMEN = isset($_POST['ABDOMEN']) ? json_encode($_POST['ABDOMEN']) : '[]';
    $GU = isset($_POST['GU']) ? json_encode($_POST['GU']) : '[]';
    $skin_extremeties = isset($_POST['SKIN_EXTREMITIES']) ? json_encode($_POST['SKIN_EXTREMITIES']) : '[]';
    $NEURO = isset($_POST['NEURO']) ? json_encode($_POST['NEURO']) : '[]';

    $disability = trim($_POST['disability']);

    $disability_type = trim($_POST['disability_type']);
    $doctor_order = trim($_POST['doc_order']);


    $dateInput = trim($_POST['visit_date']);
    echo "Received Date Input: $dateInput<br>";
    $dateObject = DateTime::createFromFormat('Y-m-d h:i A', $dateInput);

    $date = $dateObject->format('Y-m-d H:i:s');

    $symptoms = isset($_POST['symptoms']) ? json_encode($_POST['symptoms']) : '[]';

    // if($history_ill !== '' && $pertenint_ill !== '' && $Awake !== '' && $disability 
    // !== '' && $doctor_order !== ''){

    try {

        $con->beginTransaction();

        // Update tbl_complaints
        // $stmtUpdate = $con->prepare("UPDATE tbl_complaints SET bp = :bp, hr = :hr, rr = :rr, temp = :temp WHERE patient_id = :patientID");
        $stmtUpdate = $con->prepare("UPDATE tbl_complaints SET bp = :bp, hr = :hr, rr = :rr, temp = :temp WHERE patient_id = :patientID");
        $stmtUpdate->bindParam(':bp', $bp);
        $stmtUpdate->bindParam(':hr', $hr);
        $stmtUpdate->bindParam(':rr', $rr);
        $stmtUpdate->bindParam(':temp', $temp);
        $stmtUpdate->bindParam(':patientID', $hidden_id);
        $stmtUpdate->execute();

        // $stmtUpdate1 = $con->prepare("UPDATE `tbl_complaints` SET `status` = 'Done' WHERE patient_id = '$_GET[patientID]' && `consultation_purpose` = 'Checkup' && `complaintID` = '$_GET[complaintID]' ");
        // $stmtUpdate1->execute();


        // Safely update the status to 'Done'
        $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints SET status = 'Done' WHERE patient_id = :patientID AND consultation_purpose = 'Checkup' AND complaintID = :complaintID");
        $stmtUpdate1->bindParam(':patientID', $hidden_id);
        $stmtUpdate1->bindParam(':complaintID', $hidden_id1);
        $stmtUpdate1->execute();

        $stmt = $con->prepare("INSERT INTO tbl_checkup (admitted,history,per_pas_med,pertinent_signs,gen_survey,heent,chest,CSV,abdomen,GU,skin_extremeties,neuro_exam,disability,disability_type,doctor_order,patient_id,no_illness) 
            VALUES (:admitted,:history,:pertinent_pas_med,:symptoms,:gen_survey,:heent,:chest,:csv,:abdomen,:gu,:skin,:neuro,:disability,:dis_type,:doctors_order,:patient_id,:no_illness)");

        $stmt->bindParam(':admitted', $date);
        $stmt->bindParam(':history', $history_ill);
        $stmt->bindParam(':pertinent_pas_med', $pertenint_ill);
        $stmt->bindParam(':symptoms', $symptoms);
        $stmt->bindParam(':gen_survey',  $Awake);
        $stmt->bindParam(':heent', $heent);
        $stmt->bindParam(':chest', $chest);
        $stmt->bindParam(':csv', $CSV);
        $stmt->bindParam(':abdomen', $ABDOMEN);
        $stmt->bindParam(':gu', $GU);
        $stmt->bindParam(':skin', $skin_extremeties);
        $stmt->bindParam(':neuro', $NEURO);
        $stmt->bindParam(':disability', $disability);
        $stmt->bindParam(':dis_type', $disability_type);
        $stmt->bindParam(':doctors_order', $doctor_order);
        $stmt->bindParam(':patient_id', $hidden_id);
        $stmt->bindParam(':no_illness', $no_illness);


        $stmt->execute();
        $con->commit();

        $_SESSION['status'] = "Patient check-up submitted succefully.";
        $_SESSION['status_code'] = "success";
        header('location: checkup.php');
        exit();
    } catch (PDOException $e) {

        $con->rollBack();
        echo "Error saving data: " . $e->getMessage();
    }
}
// }else{
//     $_SESSION['status'] = "Something went wrong";
//     $_SESSION['status_code'] = "error";
//     header('location: checkup.php');
//     exit();
// }

// }


// $stmt = $con->prepare("SELECT admitted FROM tbl_checkup WHERE checkupID  = :id");
//     $stmt->execute(['id' => 13]);  // Assuming you know the ID
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     $dateFromDb = $result['admitted'] ?? null;


//     $formattedDate = "";
// if ($dateFromDb) {
//     $formattedDate = (new DateTime($dateFromDb))->format('Y-m-d H:i:s');  // Or 'Y-m-d h:i A' for 12-hour format with AM/PM
// }

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

        .form-check-input  {
            transform: scale(.7);
        }
        
        .form-check-label{
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
                <a href="checkup.php" class="btn btn-primary">
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
                        <h2>Patient Check-up</h2>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-center">Patient Information</h5>
                            </div>

                            <div class="card-body">
                                <?php if (isset($patientData)) : ?>
                                    <form method="POST">
                                        <div class="row">
                                            <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo htmlspecialchars($patientData['patientID']); ?>">
                                            <input type="hidden" name="hidden_id1" id="hidden_id1" value="<?php echo htmlspecialchars($patientData['complaintID']); ?>">
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
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">

                                                    <label class="form-check-label" for="symptoms1">BP:</label>
                                                    <input type="text" id="bp" name="bp" value="<?php echo $patientData['bp']; ?>" size="4" mr-2" class="input-bottom-border" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">

                                                    <label class="form-check-label" for="symptoms1">HR:</label>
                                                    <input type="text" id="hr" name="hr" value="<?php echo $patientData['hr']; ?>" size="2" mr-2" class="input-bottom-border" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">

                                                    <label class="form-check-label" for="symptoms1">RR:</label>
                                                    <input type="text" id="rr" name="rr" value="<?php echo $patientData['rr']; ?>" size="2" mr-2" class="input-bottom-border" />
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">

                                                    <label class="form-check-label" for="symptoms1">TEMP:</label>
                                                    <input type="text" id="temp" name="temp" value="<?php echo $patientData['temp']; ?>" size="2" mr-2" class="input-bottom-border" />
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- Row start -->
                                    <div class="row">

                                        <div class=" col-12">
                                            <div class="mb-3">
                                                <label for="text" class="form-label">Chief Complaint</label>
                                                <textarea class="form-control" cols="30" rows="1" readonly><?php echo htmlspecialchars($patientData['Chief_Complaint']); ?> </textarea>


                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-2 col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Date and time:</label>
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
                                                <label for="text" class="form-label">History of Present Ilness:</label>
                                                <textarea id="history_ill" name="history_ill" class="form-control" cols="30" rows="2"></textarea>


                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <div class="mb-3">
                                                <label for="text" class="form-label">Pertenint Past Medical History</label>
                                                <textarea class="form-control" id="pertenint_ill" name="pertenint_ill" cols="30" rows="2"></textarea>


                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-3">
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

                                            </div>
                                        </div>
                                    </div>




                                    <!-- <div class="col-lg-2 col-sm-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label" for="text">Date</label>
                                            <div class="input-group date" id="visit_date" data-target-input="nearest">
                                                <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#visit_date" name="visit_date" data-toggle="datetimepicker" autocomplete="off" />
                                                <div class="input-group-append" data-target="#visit_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->


                                    <div class="row">
                                        <div class="card-header" style="background-color: #808080 ;"><strong>Pertinent Signs and Syntoms on Admission (tick applicable box/es):</strong>
                                        </div>
                                    </div>




                                    <div class="forms-container">

                                        <?php
                                        // echo generateSymptomsForm();
                                        ?>

                                        <div class="card-body d-grid gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="mental" value="Altered mental sensorium">
                                                <label class="form-check-label" for="mental">Altered mental sensorium</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="abdomen" value="Abdomen cram/pain">
                                                <label class="form-check-label" for="abdomen">Abdomen cram/pain</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="rexia" value="Ano rexia">
                                                <label class="form-check-label" for="rexia">Ano rexia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Bleeding" value="Bleeding gums">
                                                <label class="form-check-label" for="Bleeding">Bleeding gums</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Body" value="Body weakness">
                                                <label class=" form-check-label" for="Body">Body weakness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Blurry" value="Blurry vision">
                                                <label class=" form-check-label" for="Blurry">Blurry vision</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Chest" value="Chest pain/discomfort">
                                                <label class=" form-check-label" for="Chest">Chest pain/discomfort</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Constipation" value="Constipation">
                                                <label class=" form-check-label" for="Constipation">Constipation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Cough" value="Cough">
                                                <label class=" form-check-label" for="Cough">Cough</label>
                                            </div>
                                        </div>
                                        <!-- ===========================second form to align in the right side ============================ -->
                                        <div class="card-body d-grid gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input " type="checkbox" name="symptoms[]" id="Diarhea" value="Diarhea">
                                                <label class="form-check-label" for="Diarhea">Diarhea</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Dizziness" value="Dizziness">
                                                <label class="form-check-label" for="Dizziness">Dizziness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Dyphagia" value="Dyphagia">
                                                <label class="form-check-label" for="Dyphagia">Dyphagia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Dyspenia" value="Dyspenia">
                                                <label class="form-check-label" for="Dyspenia">Dyspenia</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Dysuria" value="Dysuria">
                                                <label class="form-check-label" for="Dysuria">Dysuria</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Epistaxis" value="Epistaxis">
                                                <label class="form-check-label" for="Epistaxis">Epistaxis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Fever" value="Fever">
                                                <label class="form-check-label" for="Fever">Fever</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Frequency " value="Frequency urination">
                                                <label class="form-check-label" for="Frequency ">Frequency urination</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Headache" value="Headache">
                                                <label class="form-check-label" for="Headache">Headache</label>
                                            </div>

                                        </div>
                                        <!-- ===========================third form to align in the right side ============================ -->
                                        <div class="card-body d-grid gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input " type="checkbox" name="symptoms[]" id="Hematernesis" value="Hematernesis">
                                                <label class=" form-check-label" for="Hematernesis">Hematernesis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Hematuria" value="Hematuria">
                                                <label class=" form-check-label" for="Hematuria">Hematuria</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Hemoptysis" value="Hemoptysis">
                                                <label class=" form-check-label" for="Hemoptysis">Hemoptysis</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Irritability" value="Irritability">
                                                <label class=" form-check-label" for="Irritability">Irritability</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Jaundice" value="Jaundice">
                                                <label class=" form-check-label" for="Jaundice">Jaundice</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Lower" value="Lower Extremity ederma">
                                                <label class="form-check-label" for="Lower">Lower Extremity ederma</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="yalgia" value="M yalgia">
                                                <label class="form-check-label" for="yalgia">M yalgia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Otophnea" value="Otophnea">
                                                <label class="form-check-label" for="Otophnea">Otophnea</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="Pain" value="Pain">
                                                <label class="form-check-label" for="Pain">Pain,</label>
                                                <input type="text" id="pain" name="Pain" value="" size="2" mr-2" class="input-bottom-border" />
                                                <label class="form-check-label" for="Pain">site</label>

                                            </div>


                                        </div>
                                        <!-- ===========================fourth form to align in the right side ============================ -->
                                        <div class="card-body d-grid gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input " type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label">Palpitations</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Seizures</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">skin rashes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Stool, bloody/black/mucoid</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Sweating</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Urgency</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Vomitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" vname="symptoms[]" id="symptoms">
                                                <label class="form-check-label" for="flexCheckDefault">Weight loss</label>
                                            </div>
                                            <div class="form">
                                                <label for="symptom_others" class="form-check-label">Others</label>
                                                <input type="text" name="symptoms[]" id="symptom_others" value="" class="form-check-label input-bottom-border-only">
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="card-header" style="background-color: #808080 ;"><strong>Physical Examination on Admission(Pertinent Findings per System)</strong>
                                        </div>
                                    </div>

                                   
                                        <div class="row mt-3">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        General Survey:
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check ">
                                                    <input class="form-check-input" type="checkbox" name="Awake" id="Awake" value="Awake and alert">
                                                    <label class="form-check-label" for="Awake">Awake and alert</label>


                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="Awake" id="Altered" value="Altered sensorium">
                                                    <label class="form-check-label" for="Altered">Altered sensorium</label>

                                                </div>
                                            </div>


                                        </div>
                                                      
                                        <div class="row">
                                            <div class="col-md-2 ">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        HEENT:
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check ">
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="essentiallyNormal" value="Essentially normal">
                                                    <label class="form-check-label mb-1" for="essentiallyNormal">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="ictericSclerae" value="Icteric sclerae">
                                                    <label class="form-check-label mb-1" for="ictericSclerae">Icteric sclerae</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="abnormalPupillaryReaction" value="Abnormal pupillary reaction">
                                                    <label class="form-check-label mb-1" for="abnormalPupillaryReaction">Abnormal pupillary reaction</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="paleConjuctivae" value="Pale conjuctivae">
                                                    <label class="form-check-label mb-1" for="paleConjuctivae">Pale conjuctivae</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="cervicalLymphadenopathy" value="Cervical lymphadenopathy">
                                                    <label class="form-check-label mb-1" for="cervicalLymphadenopathy">Cervical lymphadenopathy</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="sunkenEyeballs" value="Sunken eyeballs">
                                                    <label class="form-check-label mb-1" for="sunkenEyeballs">Sunken eyeballs</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="dryMucuousMembrane" value="Dry mucuos membrane">
                                                    <label class="form-check-label mb-1" for="dryMucuousMembrane">Dry mucuos membrane</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="heent[]" id="sunkenFontanelle" value="Sunken fontanelle">
                                                    <label class="form-check-label mb-1" for="sunkenFontanelle">Sunken fontanelle</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label mb-1" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label " for="otherSymptoms">Others</label>
                                                    <input type="text" name="heent[]" id="otherSymptoms" value="" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                    
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        CHEST/LUNGS:
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Essentially" value="Essentially normal">

                                                    <label class="form-check-label mb-1" for="Essentially">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="symptoms1">
                                                    <label class="form-check-label" for="symptoms1">Lump/s over breat(s)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Asymetrical" value="Asymetrical chest expansion">

                                                    <label class="form-check-label mb-1" for="Asymetrical">Asymetrical chest expansion</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Rales" value="Rales/crackles/rhonchi">
                                                    <label class="form-check-label" for="Rales">Rales/crackles/rhonchi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Decreased" value="Decreased breath sounds">

                                                    <label class="form-check-label mb-1" for="Decreased">Decreased breath sounds</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Intercostal" value="Intercostal rib/clavicular retraction">
                                                    <label class="form-check-label" for="Intercostal">Intercostal rib/clavicular retraction</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CHEST[]" id="Wheezes" value="Wheezes">

                                                    <label class="form-check-label mb-1" for="Wheezes">Wheezes</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms">Others</label>
                                                    <input type="text" name="CHEST[]" id="otherSymptoms" value="" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                   

                                    <!-- ===CSV==== -->
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        CSV:
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Essentially" value="Essentially normal">

                                                    <label class="form-check-label mb-1" for="Essentially">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Irregular" value="Irregular rhythm">
                                                    <label class="form-check-label" for="Irregular">Irregular rhythm</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Displaced" value="Displaced apex beat">

                                                    <label class="form-check-label mb-1" for="Displaced">Displaced apex beat</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Muffled" value="Muffled heart sounds">
                                                    <label class="form-check-label" for="Muffled">Muffled heart sounds</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Heaves" value="Heaves and/or thrills">

                                                    <label class="form-check-label mb-1" for="Heaves">Heaves and/or thrills</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Murmur" value="Murmur">
                                                    <label class="form-check-label" for="Murmur">Murmur</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="CSV[]" id="Pericardial" value="Pericardial bulge">

                                                    <label class="form-check-label mb-1" for="Pericardial">Pericardial bulge</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherCSV">Others</label>
                                                    <input type="text" name="CSV[]" id="otherCSV" value="" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                   
                                    <!-- ===ABDOMEN==== -->
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        ABDOMEN:
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="Essentially" value="Essentially normal">

                                                    <label class="form-check-label mb-1" for="Essentially">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="Palpable" value="Palpable mass(es)">
                                                    <label class="form-check-label" for="Palpable">Palpable mass(es)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="Abdominal" value="Abdominal rigidity">

                                                    <label class="form-check-label mb-1" for="Abdominal">Abdominal rigidity</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="symptoms1">
                                                    <label class="form-check-label" for="symptoms1">Tympanitic/dull abdomen</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="symptoms1">

                                                    <label class="form-check-label mb-1" for="symptoms1">Abdomen tenderness</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="symptoms1">
                                                    <label class="form-check-label" for="symptoms1">Uterine contraction</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="ABDOMEN[]" id="symptoms1">

                                                    <label class="form-check-label mb-1" for="symptoms1">Hyperactive bowel sounds</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherABDOMEN">Others</label>
                                                    <input type="text" name="ABDOMEN[]" id="otherABDOMEN" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                 
                                    <!-- ===GU(IE)==== -->
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        GU (IE):
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="GU[]" id="Essentially" value="Essentially normal">

                                                    <label class="form-check-label mb-1" for="Essentially">Essentially normal</label>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="GU[]" id="Blood" value="Blood stained in exam finger">

                                                    <label class="form-check-label mb-1" for="Blood">Blood stained in exam finger</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="GU[]" value="Cervical dilatation" id="Cervical">

                                                    <label class="form-check-label mb-1" for="Cervical">Cervical dilatation</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="GU[]" id="Presence" value="Presence of abnormal">

                                                    <label class="form-check-label mb-1" for="Presence">Presence of abnormal</label>
                                                    <br>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms">Others</label>
                                                    <input type="text" name="GU[]" id="OthersGU" value="" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                   
                                    <!-- ===SKIN/EXTREMITIES==== -->
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        SKIN/EXTREMITIES
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="esnormal" value="Essentially normal">

                                                    <label class="form-check-label mb-1" for="esnormal">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Edema" value="Edema/swelling">
                                                    <label class="form-check-label  mb-1" for="Edema">Edema/swelling</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Rashes" value="Rashes/petechiae">
                                                    <label class="form-check-label " for="Rashes">Rashes/petechiae</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Clubbing" value="Clubbing">

                                                    <label class="form-check-label mb-1" for="Clubbing">Clubbing</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="symptoms1" value="Decreased mobility">
                                                    <label class="form-check-label  mb-1" for="symptoms1">Decreased mobility</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Weak" value="Weak pulses">
                                                    <label class="form-check-label" for="Weak">Weak pulses</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Cold" value="Cold clammy skin">

                                                    <label class="form-check-label mb-1" for="Cold">Cold clammy skin</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Pale" value="Pale nailbeds">
                                                    <label class="form-check-label" for="Pale">Pale nailbeds</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Cyanosis" value="Cyanosis/motted skin">

                                                    <label class="form-check-label mb-1" for="Cyanosis">Cyanosis/motted skin</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="SKIN_EXTREMITIES[]" id="Poor" value="Poor skin turgor">
                                                    <label class="form-check-label" for="Poor">Poor skin turgor</label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms">Others</label>
                                                    <input type="text" name="SKIN_EXTREMITIES[]" value="" id="otherSymptoms" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                  
                                    <!-- ===NEURO-EXAM==== -->
                                   
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        NEURO-EXAM:
                                                    </label>
                                                </div>
                                            </div>




                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="symptoms1">

                                                    <label class="form-check-label mb-1" for="symptoms1">Essentially normal</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="symptoms1">
                                                    <label class="form-check-label  mb-1" for="symptoms1">Abnormal reflex(es)</label>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="Abnormalgait" value="Abnormal gait">

                                                    <label class="form-check-label mb-1" for="Abnormalgait">Abnormal gait</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="alteredmemory" value="Poor/altered memory">
                                                    <label class="form-check-label  mb-1" for="alteredmemory">Poor/altered memory</label>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" value="Abnormal position sense" id="Abnormalpositionsense">

                                                    <label class="form-check-label mb-1" for="Abnormalpositionsense">Abnormal position sense</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="Poormuscle" value="Poor muscle tone/strength">
                                                    <label class="form-check-label  mb-1" for="Poormuscle">Poor muscle tone/strength</label>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="Abnormaldecrease" value="Abnormal/decrease">

                                                    <label class="form-check-label mb-1" for="Abnormaldecrease">Abnormal/decrease</label>
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" name="NEURO[]" id="Poorcoordination" value="Poor coordination">
                                                    <label class="form-check-label  mb-1" for="Poorcoordination">Poor coordination</label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms"></label>

                                                </div>
                                            </div>
                                            <div class="col-md-2 ">
                                                <div class="form">
                                                    <label class="form-check-label" for="otherSymptoms">Others</label>
                                                    <input type="text" name="NEURO[]" id="Others" value="" class="form-check-label input-bottom-border-only">
                                                </div>
                                            </div>
                                        </div>
                                  

                                  
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        DISABILITY:
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex flex-column">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="disability" id="yes" value="yes" required>
                                                    <label class="form-check-label" for="yes">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="disability" id="no" value="no" required>
                                                    <label class="form-check-label" for="no">No</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <div class="">
                                                    <label class="form-label" for="text">TYPE OF DISABLITY:</label>
                                                    <input type="text" name="disability_type" id="disability_type" class="form-check-label input-bottom-border-only">
                                                    
                                                </div>
                                            </div>
                                           
                                        <div class="row">
                                        <div class="col-md-2 mb-2" style="margin-left: 1rem;">
                                    <div style="display: flex; align-items: center;">
                                        <input type="checkbox" class="form-check-input illness" id="noIllness" name="no_illness" value="1"
                                            style="margin-right: 0.5rem; transform: scale(1);">
                                        <label for="noIllness" style="margin: 0;">No illness found during checkup</label>
                                    </div>
                                </div>


                                     
                                         </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-2 float-end mb-5">
                                            <div class="">
                                                <label class="form-label" for="text">DOCTOR'S ORDER</label>
                                                <input type="text" name="doc_order" id="doc_order" class="form-check-label input-bottom-border-only" required>
                                               

                                            </div>
                                        </div>

                                      

                                    </div>
                            </div>


                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">

                                    <button type="submit" id="save_checkup" name="save_checkup" class="btn btn-info">
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
                icons: {
                    time: 'far fa-clock'
                },
                format: 'YYYY-MM-DD hh:mm A'
            });

        });
        // Awake & Altered checkbox
        document.addEventListener('DOMContentLoaded', function() {
            var yesCheckbox = document.getElementById('Awake');
            var noCheckbox = document.getElementById('Altered');

            yesCheckbox.addEventListener('change', function() {
                noCheckbox.disabled = this.checked;
            });

            noCheckbox.addEventListener('change', function() {
                yesCheckbox.disabled = this.checked;
            });
        });

        // disability yes and no checkbox
        document.addEventListener('DOMContentLoaded', function() {
            var yesCheckbox = document.getElementById('yes');
            var noCheckbox = document.getElementById('no');
            var disabilityTypeInput = document.getElementById('disability_type');


            function updateDisabilityType() {
                if (noCheckbox.checked) {
                    disabilityTypeInput.disabled = true;
                    disabilityTypeInput.value = '';
                } else {
                    disabilityTypeInput.disabled = false;
                }
            }


            yesCheckbox.addEventListener('change', function() {
                noCheckbox.disabled = this.checked;
                updateDisabilityType();
            });

            noCheckbox.addEventListener('change', function() {
                yesCheckbox.disabled = this.checked;
                updateDisabilityType();
            });


            updateDisabilityType();
        });
    </script>




</body>



</html>