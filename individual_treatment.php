<?php
include './config/connection.php';

include './common_service/common_functions.php';



// if (isset($_POST['save_complaints'])) {
//   $patientid = trim($_POST['hidden_id']);
//   $Complaint = trim($_POST['Complaint']);
//   $remarks = trim($_POST['remarks']);
//   $bp = trim($_POST['bp']);
//   $hr = trim($_POST['hr']);
//   $weight = trim($_POST['weight'] . "kg");
//   $rr = trim($_POST['rr']);
//   $Temp = $_POST['Temp'] . "°C";
//   $Height = trim($_POST['Height']);
//   $Nature_visit = trim($_POST['Nature_visit']);
//   $cp_visit = trim($_POST['cp_visit']);
//   $Refferred = trim($_POST['Refferred']);

//   $query = $con->prepare("SELECT * FROM `tbl_patients` WHERE `patientID` = :id");
//   $query->bindParam(':id', $patientid, PDO::PARAM_INT);
//   $query->execute();
//   $patient = $query->fetch(PDO::FETCH_ASSOC);

//   if (!$patient) {
//       $_SESSION['status'] = "Patient not found.";
//       $_SESSION['status_code'] = "error";
//       header("Location: page_done.php");
//       exit;
//   }

//   if (

//     $bp != '' && $hr != '' && $weight != '' &&  $rr != ''
//   ) 

//   if (($cp_visit == "Prenatal" || $cp_visit == "Maternity") && ($patient['gender'] == "Male")) {
//       $_SESSION['status'] = "Invalid section for male patient.";
//       $_SESSION['status_code'] = "error";

//   }

//   $query = "INSERT INTO `tbl_complaints`(`patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`,`Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `status`) 
//             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
//   $con->beginTransaction();
//   $stmt = $con->prepare($query);
//   $stmt->execute([$patientid, $Complaint, $remarks, $bp, $hr, $weight, $rr, $Temp, $Height, $Nature_visit, $cp_visit, $Refferred]);
//   $con->commit();

//   $_SESSION['status'] = "Patient complaint added successfully.";
//   $_SESSION['status_code'] = "success";
//   header("Location: page_done.php");
//   exit;
// }



if (isset($_POST['save_complaints'])) {
  $patientid = trim($_POST['hidden_id']);
  $Complaint = trim($_POST['Complaint']);
  $remarks = trim($_POST['remarks']);
   $bp_systolic = trim($_POST['bp_systolic']);
    $bp_diastolic = trim($_POST['bp_diastolic']);
    $bp = $bp_systolic . '/' . $bp_diastolic; 
  $hr = trim($_POST['hr']);
  $weight = trim($_POST['weight'] . "kg");
  $rr = trim($_POST['rr']);
  $Temp = $_POST['Temp'] . "°C";
  $Height = trim($_POST['Height'] . "cm");
  $O2SAT = trim($_POST['O2SAT']);
  $PR = trim($_POST['PR']);


  $Nature_visit = trim($_POST['Nature_visit']);
  $cp_visit = trim($_POST['cp_visit']);
  $Refferred = trim($_POST['Refferred']);
  $reason = trim($_POST['reason']);
  
  $action = trim($_POST['action']);
    $instruction = trim($_POST['instruction']);



  $query = $con->prepare("SELECT * FROM `tbl_patients` WHERE `patientID` = :id");
  $query->bindParam(':id', $patientid, PDO::PARAM_INT);
  $query->execute();
  $patient = $query->fetch(PDO::FETCH_ASSOC);

  if (!$patient) {
    $_SESSION['status'] = "Patient not found.";
    $_SESSION['status_code'] = "error";
  } else if (($cp_visit == "Prenatal" || $cp_visit == "Maternity") && ($patient['gender'] == "Male")) {
    $_SESSION['status'] = "Invalid section for male patient.";
    $_SESSION['status_code'] = "error";
  } else {
    $query = "INSERT INTO `tbl_complaints`(`patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`, `Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `reason_ref`, `status`, `pr`, `O2SAT`,`action_taken`,`instruction_to`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 'Pending',?,?,?,?)";
    $con->beginTransaction();
    $stmt = $con->prepare($query);
    $stmt->execute([$patientid, $Complaint, $remarks, $bp, $hr, $weight, $rr, $Temp, $Height, $Nature_visit, $cp_visit, $Refferred, $reason, $PR, $O2SAT,$action,$instruction]);
    $con->commit();
    $_SESSION['status'] = "Patient complaint added successfully.";
    $_SESSION['status_code'] = "success";
    header('Location: page_done.php');
    exit;
  }

  // // Redirect back to the same page to show messages or refresh the form
  // header("Location: individual_treatment.php?id=" . $patientid);
  // exit;
}


if (isset($_SESSION['status'])) {
  echo "<script>alert('" . $_SESSION['status'] . "');</script>";

  unset($_SESSION['status']);
}



if (isset($_GET['complaintID'])) {
  $patientId = $_GET['complaintID'];

  try {

    $query = "SELECT 
              pat.*, 
              fam.brgy, 
              fam.purok, 
              fam.province,
              mem.phil_mem, 
              mem.philhealth_no, 
              mem.phil_membership, 
              mem.ps_mem,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`
          FROM 
              `tbl_patients` AS pat
          JOIN 
              `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
          JOIN 
              `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
          WHERE 
              pat.`patientID` = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $patientId, PDO::PARAM_INT);
    $stmt->execute();
    $patient = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details
  } catch (PDOException $ex) {
    echo $ex->getMessage();
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>

  <?php include './config/data_tables_css.php'; ?>
  <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


</head>

<body>
  <!-- Page wrapper start -->
  <div class="page-wrapper">

    <!-- Main container start -->
    <div class="main-container">

      <!-- Sidebar wrapper start -->
      <nav id="sidebar" class="sidebar-wrapper">

        <!-- App brand starts -->
        <div class="app-brand px-3 py-2 d-flex align-items-center">
          
        </div>
        <!-- App brand ends -->

        <!-- Sidebar menu starts -->
        <?php include './config/sidebar.php'; ?>
        <!-- Sidebar menu ends -->

      </nav>
      <!-- Sidebar wrapper end -->

      <!-- App container starts -->
      <div class="app-container">

        <!-- App header starts -->
        <?php include './config/header.php'; ?>
        <!-- App header ends -->


        <!-- App body starts -->
        <div class="app-body">

          <div class="container-fluid">

            <!-- Row start -->
            <div class="row">
              <div class="col-12 col-xl-12">
                <!-- Breadcrumb start -->
                <ol class="breadcrumb mb-1">
                  <li class="breadcrumb-item">
                    <a href="home.php">Home</a>

                  </li>
                  <li class=" breadcrumb-active">
                    / Patient Individual Treatment
                  </li>
                </ol>
                <!-- Breadcrumb end -->
                <h2 class="mb-2">Individual Treatment</h2>
                <h6 class="mb-4 fw-light">
                  Mga impormasyon ng pasyente
                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Patient information</h5>
                  </div>

                  <div class="card-body">
                    <div class="row">
                      <div class="form-group">
                        <h3 class="text-center"></h3>
                      </div>


                    </div>

                    <h3 class="profile-username text-center"></h3>


                    <form method="post" novalidate id="oldpatient">

                      <p class="text-muted text-center"></p>
                      <ul class="list-group list-group-unbordered mb-3">
                        <?php if (isset($patient)) : ?>
                          <input type="hidden" name="hidden_id" value="<?php echo $patient['patientID']; ?>">
                          <li class="list-group-item">
                            <b>Name:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords($patient['name']) ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Gender:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords($patient['gender']) ?></a>
                          </li>

                          <li class="list-group-item">
                            <b>Contact no.:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords($patient['phone_number']) ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Status:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords($patient['civil_status']) ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Age:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords($patient['age']) ?></a>
                          </li>
                          <li class="list-group-item">
                            <b>Address:</b> <a class="float-center text-decoration-none text-dark"><?php echo ucwords('Purok, ' . $patient['purok'] . ', Brgy. ' . $patient['brgy'] . ', ' . $patient['province']) ?></a>
                          </li>


                        <?php else : ?>
                          <p>No patient details found.</p>
                        <?php endif; ?>



                      </ul>

                      <div class="row">
                        <div class="card-header" style="background-color: #ffc107 ;"><strong>Patient Complaint</strong> </div>
                      </div>
                      <br>


                      <div class="row">
                        <form method="post">
                          <div class=" col-12">
                            <div class="mb-3">
                              <label for="text" class="">Chief Complaint</label>
                              <textarea style="resize:none;" name="Complaint" id="Complaint" class="form-control" data-ms-editor="true"></textarea>

                            </div>
                          </div>
                          <div class=" col-12">
                            <div class="mb-3">
                              <label for="text" class="">Remarks</label>
                              <textarea style="resize:none;" name="remarks" id="remarks" class="form-control" data-ms-editor="true"></textarea>

                            </div>
                          </div>
                          <br>
                          <br>

                          <style>
                            .blue-placeholder::placeholder {
                              color: blue;
                              font-size: 20px;
                              font: bold;
                            }


                            .blue-placeholder:hover {
                              cursor: pointer;
                              color: blue;
                            }

                            p {
                              font-size: 12px;
                            }
                          </style>

                       


                          <div class="row">

                             <div class="col-lg-2 col-sm-4 col-12">
                                <div class="mb-3">
                                    <h6 for="bp" class="">Blood Pressure</h6>
                                    <div class="d-flex align-items-center">
                                        <input type="text" style="width: 50%;" class="form-control form-control-sm rounded-0 blue-placeholder me-2" id="bp_systolic" name="bp_systolic" required placeholder="" />
                                        <span class="mx-1">/</span>
                                        <input type="text" style="width: 50%;" class="form-control form-control-sm rounded-0 blue-placeholder" id="bp_diastolic" name="bp_diastolic" required placeholder="" />
                                    </div>
                                    <p class="mt-1">Systolic/Diastolic</p>
                                    <div class="invalid-feedback">
                                        Blood Pressure is required.
                                    </div>
                                </div>
                            </div>
    
    
                        <div class="col-lg-2 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="hr" class="">Heart Rate</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="hr" name="hr" required min="0" max="300" />
                                <p>Beats per Minute</p>
                                <div class="invalid-feedback">
                                    Heart Rate is required and must be between 0 and 300.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="weight" class="">Weight</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="weight" name="weight" required min="0" max="999" />
                                <p>Kilograms</p>
                                <div class="invalid-feedback">
                                    Weight is required and must be between 0 and 999 kg.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="Height" class="">Height</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="Height" name="Height" required min="0" max="500" step="0.01" />
                                <p>Centimeters</p>
                                <div class="invalid-feedback">
                                    Height is required and must be between 0 and 999 cm.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="Temp" class="">Temp</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="Temp" name="Temp" required min="0" max="100" step="0.1" />
                                <p>Celsius</p>
                                <div class="invalid-feedback">
                                    Temperature is required and must be between 0 and 100°C.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="PR" class="">PR</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="PR" name="PR" required min="0" max="300" />
                                <p>bpm</p>
                                <div class="invalid-feedback">
                                    PR is required and must be between 0 and 300 bpm.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="O2SAT" class="">O2SAT</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="O2SAT" name="O2SAT" required min="0" max="100" step="0.1" />
                                <p>%</p>
                                <div class="invalid-feedback">
                                    O2SAT is required and must be between 0 and 100%.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-12">
                            <div class="mb-3">
                                <h6 for="rr" class="">Respiratory rate</h6>
                                <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="rr" name="rr" required min="0" max="100" />
                                <p>Breaths per Minute</p>
                                <div class="invalid-feedback">
                                    Respiratory rate is required and must be between 0 and 100.
                                </div>
                            </div>
                        </div>

                          </div>
                          <div class="col-lg-5 col-12">
                            <div class="mb-3">
                              <label for="visit" class="form-label">Nature of Visit</label>
                              <select id="Nature_visit" name="Nature_visit" class="form-control form-control-sm rounded-0" required="required">
                                <?php echo getnature(); ?>
                              </select>
                            </div>
                          </div>




                          <div class="col-lg-5 col-12">
                            <div class="mb-3">
                              <label for="visit" class="form-label">Type of consultation purpose of visit</label>
                              <select class="form-control form-control-sm rounded-0" id="cp_visit" name="cp_visit" required="required">

                                <?php echo getconsulpurpose(); ?>

                              </select>
                            </div>
                          </div>

                          <div class="col-lg-5 col-12">
                            <div class="mb-3">
                              <label for="text" class="">Refferred by:</label>
                              <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo $user['first_name'] . ' ' . $user['lastname']; ?>" id="Refferred" name="Refferred" readonly />

                            </div>
                          </div>
                          <div class="col-lg-5 col-12">
                            <div class="mb-3">
                              <label for="text" class="">Reason for referral:</label>
                              <input type="text" class="form-control form-control-sm rounded-0"  name="reason"  required/>
                              <!--<div class="invalid-feedback">-->
                              <!--  Reason for referral is required.-->
                              <!--</div>-->
                            </div>
                          </div>

                      <div class="col-lg-5 col-12">
                            <div class="mb-3">
                                <label for="text" class="">Action taken by referred level: <span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control form-control-sm rounded-0" id="action" name="action" required  style="resize: none;"></textarea>
                                <div class="invalid-feedback">
                                    Action taken by referred level is required.
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-5 col-12">
                            <div class="mb-3">
                                <label for="text" class="">Instruction to referred level: <span class="text-danger">*</span></label>
                          <textarea 
                                class="form-control form-control-sm rounded-0" 
                                id="instruction" 
                                name="instruction" 
                                required 
                                style="resize: none;"
                            ></textarea>

                                <div class="invalid-feedback">
                                    Instruction to referred level is required.
                                </div>
                            </div>
                        </div>


                          <br>




                      </div>
                      <div class="row">
                        <div class="">

                          <button type="submit" class="btn btn-info" id="save_complaints" name="save_complaints">Submit</button>
                        </div>
                      </div>
                      <?php
                      // require 'controller/add_patient_complaint.php'; 
                      ?>
                    </form>




                  </div>
                </div>
              </div>



            </div>
            <!-- Row end -->

          </div>
          <!-- Container ends -->

        </div>
        <!-- App body ends -->

        <!-- App footer start -->
        <?php include './config/footer.php'; ?>
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
  <script src="assets/inputmask/jquery.inputmask.min.js"></script>

  <!-- <script src="assets/js/moment.min.js"></script>

  <!-- Date Range JS -->
  <!-- <script src="assets/vendor/daterange/daterange.js"></script>
  <script src="assets/vendor/daterange/custom-daterange.js"></script> -->
//   <script>
//     Inputmask("999 / 999").mask("#bp");
//   </script>
  
  <script>
        document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('oldpatient');



      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);


    });
  </script>
   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const value = parseFloat(this.value);
                    const min = parseFloat(this.min);
                    const max = parseFloat(this.max);
                    const invalidFeedback = this.nextElementSibling;

                    {
                        if (isNaN(value) || value < min || value > max) {
                            invalidFeedback.style.display = 'block';
                            this.classList.add('is-invalid');
                        } else {
                            invalidFeedback.style.display = 'none';
                            this.classList.remove('is-invalid');
                        }
                    }
                });
            });
        });
    </script>
 
  

</body>



</html>