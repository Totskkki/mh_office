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
              tbl_familyAddress AS fam ON pat.family_address = fam.famID
              WHERE com.complaintID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();


    $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
}



if (isset($_POST['save_birth'])) {


    $user = $_SESSION['user_id'];

    $date = $_POST['date'];
    $time = $_POST['time'];
    $time = date("H:i:s", strtotime($time)); 
    $history = $_POST['history'];
    $lmp = $_POST['lmp'];
    $edc = $_POST['edc'];
    $aog = $_POST['aog'];
    $g = $_POST['g'];
    $p = $_POST['p'];
    $a = $_POST['1'];
    $b = $_POST['2'];
    $c = $_POST['3'];
    $d = $_POST['4'];
    $bp = $_POST['bp'];
    $pr = $_POST['pr'];
    $rr = $_POST['rr'];
    $t = $_POST['t'];
    $head_neck = $_POST['head_neck'];
    $chest = $_POST['chest'];
    $heart = $_POST['heart'];
    $abdomen = $_POST['abdomen'];
    $fhb = $_POST['fhb'];
    $loc = $_POST['loc'];
    $extremities = $_POST['extremities'];
    $vulva = $_POST['vulva'];
    $vagina = $_POST['vagina'];
    $cervix = $_POST['cervix'];
    $uterus = $_POST['uterus'];
    $bow = $_POST['bow'];
    $presentation = $_POST['presentation'];
    $vaginal_discharge = $_POST['vaginal_discharge'];
    $staff = $_POST['staff'];
    $hidden_id = trim($_POST['hidden_id']);
    $hidden_id1 = trim($_POST['hidden_id1']);



    try {

        $con->beginTransaction();


        $stmt = $con->prepare("INSERT INTO `tbl_physical_exam` (`head_neck`, `chest`, `heart`, `abdomen`, `extremities`, `vulva`, `vagina`, `cervix`, `uterus`, `bow`) VALUES ( :head_neck, :chest, :heart, :abdomen, :extremities, :vulva, :vagina, :cervix, :uterus, :bow)");
        $stmt->execute([

            ':head_neck' => $head_neck,
            ':chest' => $chest,
            ':heart' => $heart,
            ':abdomen' => $abdomen,
            ':extremities' => $extremities,
            ':vulva' => $vulva,
            ':vagina' => $vagina,
            ':cervix' => $cervix,
            ':uterus' => $uterus,
            ':bow' => $bow
        ]);

        $physical = $con->lastInsertId();

        $stmt = $con->prepare("INSERT INTO `tbl_birth_info` (`patient_id`, `date`, `time`, `history`, `lmp`, `edc`, `aog`, `G`, `P`, `1`, `2`, `3`, `4`, `bp`, `pr`, `rr`, `T`, `fhb`, `loc`, `presentation`, `vaginal_discharge`, `midwife`, `physical_exam_id`,`userID`) VALUES (:patient_id, :date, :time, :history, :lmp, :edc, :aog, :G, :P, :1, :2, :3, :4, :bp, :pr, :rr, :T, :fhb, :loc, :presentation, :vaginal_discharge, :midwife, :physical_exam,:userid)");
        $stmt->execute([
            ':patient_id' => $hidden_id,
            ':date' => $date,
            ':time' => $time,
            ':history' => $history,
            ':lmp' => $lmp,
            ':edc' => $edc,
            ':aog' => $aog,
            ':G' => $g,
            ':P' => $p,
            ':1' => $a,
            ':2' => $b,
            ':3' => $c,
            ':4' => $d,
            ':bp' => $bp,   
            ':pr' => $pr,
            ':rr' => $rr,
            ':T' => $t,
            ':fhb' => $fhb,
            ':loc' => $loc,
            ':presentation' => $presentation,
            ':vaginal_discharge' => $vaginal_discharge,
            ':midwife' => $staff,
            ':physical_exam' => $physical,
            ':userid' => $user

        ]);

        $con->commit();
        $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints SET status = 'Done' WHERE patient_id = :patientID AND consultation_purpose = 'Birthing' OR consultation_purpose = 'Prenatal' and  complaintID = :complaintID");
        $stmtUpdate1->bindParam(':patientID', $hidden_id);
        $stmtUpdate1->bindParam(':complaintID', $hidden_id1);
        $stmtUpdate1->execute();
        $_SESSION['status'] = "Submitted succefully.";
        $_SESSION['status_code'] = "success";
        header('location: records_birthing.php');
        exit();
    } catch (Exception $e) {

        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

$midwife = getDoctor($con);
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />


    <style>
        .well {
            min-height: 1px;

            margin-bottom: 20px;
            background-color: #fff;
            border: 0px solid #fff;

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
                <a href="maternity.php" class="btn btn-danger">
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

                        <h2 class="text-center"><strong>Birthing Form</strong></h2>

                        <div class="card">
                            <div class="card-header">
                                <?php if (isset($patientData)) : ?>
                                    <h3 class="card-title "> <?php echo htmlspecialchars(ucwords($patientData['name'])); ?></h3>
                            </div>




                            <div class="well">

                                <div class="panel panel-default">

                                    <form method="POST" >


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





                                        <div class="card-body">

                                            <div class="form-inline">
                                                <label>DATE:</label>
                                                <input type="text" name="date" class="form-control datetimepicker-input" id="ddate" data-target="#ddate" data-toggle="datetimepicker" autocomplete="off" required>
                                                <!-- <input type="text"name="date" class="form-control datetimepicker-input" id="ddate" data-target="#ddate"  data-toggle="datetimepicker" autocomplete="off" required /> -->
                                                <label style="margin-left:20px;">TIME:</label>
                                                <input type="text" name="time" class="form-control datetimepicker-input" data-target="#time" id="time" data-toggle="datetimepicker" autocomplete="off" required />
                                                <label style="margin-left:10px;">a.m / p.m.</label>
                                            </div>

                                            <br />
                                            <div class="form-inline">
                                                <label>CHIEF COMPLAINT:</label>
                                                <input type="text" name="chief_complaint" size="60" value="<?php echo htmlspecialchars($patientData['Chief_Complaint']); ?>" class="form-control form-control-sm"  readonly/>
                                            </div>
                                            <br />
                                            <div class="form-group">
                                                <label>HISTORY:</label>
                                                <textarea name="history" class="form-control" style="resize:none;"></textarea>
                                            </div>
                                            <br />
                                            <center><label>OB GYNE HISTORY</label></center>
                                            <hr style="border:1px solid #000;" />
                                            <div class="form-inline" style=" border-right:1px solid #000; height:100%; width:30%; float:left;">
                                                <label>LMP:</label>
                                                <input type="text" name="lmp" class="form-control" />
                                                <br />
                                                <label>EDC:</label>
                                                <input style="margin-left:2px;" type="text" name="edc" class="form-control" />
                                                <br />
                                                <label>AOG:</label>
                                                <input type="text" name="aog" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="width:60%; margin-left:10px; margin-top:30px; float:left;">
                                                <label>OB SCORE:</label>
                                                <label>G:</label>
                                                <input type="text" name="g" size="2" class="form-control" />
                                                <label>P</label>
                                                <input type="text" name="p" size="2" class="form-control" />
                                                <label>(</label>
                                                <input type="text" name="1" size="2" class="form-control" />
                                                <input type="text" name="2" size="2" class="form-control" />
                                                <input type="text" name="3" size="2" class="form-control" />
                                                <input type="text" name="4" size="2" class="form-control" />
                                                <label>)</label>
                                            </div>
                                            <br style="clear:both;" />
                                            <hr style="border:1px solid #000;" />
                                            <center><label>PHYSICAL EXAMINATION</label></center>
                                            <div class="form-inline">
                                                <label>BP:</label>
                                                <input type="text"id="bp" name="bp" class="form-control" />
                                                <!-- <label>/</label>
                                                <input type="text" name="bp2" size="2" class="form-control" /> -->
                                                <label>mmhg PR:</label>
                                                <input type="text" name="pr" size="5" class="form-control" />
                                                <label>bpm RR:</label>
                                                <input type="text" name="rr" size="5" class="form-control" />
                                                <label>cpm T:</label>
                                                <input type="text" name="t" size="4" class="form-control" />
                                                <label>⁰C</label>
                                            </div>
                                            <br />
                                            <div style="float:left; width:25%;" class="form-inline">
                                                <label>HEAD & NECK</label>
                                                <br />
                                                <input type="text" name="head_neck" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>CHEST</label>
                                                <br />
                                                <input type="text" name="chest" class="form-control" />
                                            </div>
                                            <div style="float:left; width:25%;" class="form-inline">
                                                <label>HEART</label>
                                                <br />
                                                <input type="text" name="heart" class="form-control" />
                                            </div>
                                            <br />
                                            <br />
                                            <br />
                                            <br style="clear:both;" />
                                            <div style="float:left; width:25%;" class="form-inline">
                                                <label>ABDOMEN: UTERINE SIZE:</label>
                                                <input type="text" name="abdomen" class="form-control" />
                                                <label>cm FHB:</label>
                                                <input type="text" name="fhb" class="form-control" />
                                                <label>bpm LOC:</label>
                                                <input type="text" name="loc" class="form-control" />
                                            </div>
                                            <div style="float:left; width:25%;" class="form-inline">
                                                <label>EXTREMITIES:</label>
                                                <br />
                                                <input type="text" name="extremities" class="form-control" />
                                            </div>
                                            <br style="clear:both;" />
                                            <hr style="border:1px solid #000;" />
                                            <center><label>INTERNAL EXAMINATION (IE)</label></center>
                                            <br />
                                            <div style="float:left; width:25%;" class="form-inline">
                                                <label>VULVA:</label>
                                                <br />
                                                <input type="text" name="vulva" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>VAGINA:</label>
                                                <br />
                                                <input type="text" name="vagina" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>CERVIX:</label>
                                                <br />
                                                <input type="text" name="cervix" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>UTERUS:</label>
                                                <br />
                                                <input type="text" name="uterus" class="form-control" />
                                            </div>
                                            <br />
                                            <br />
                                            <br />
                                            <br style="clear:both;" />
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>BOW:</label>
                                                <br />
                                                <input type="text" name="bow" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>PRESENTATION:</label>
                                                <br />
                                                <input type="text" name="presentation" class="form-control" />
                                            </div>
                                            <div class="form-inline" style="float:left; width:25%;">
                                                <label>VAGINAL DISCHARGE:</label>
                                                <br />
                                                <input type="text" name="vaginal_discharge" class="form-control" />
                                            </div>
                                            <br style="clear:both;" />
                                            <hr style="border:1px solid #000;" />
                                            <div class="form-inline">
                                                <label>STAFF ON DUTY:</label>
                                                <input type="text" name="staff" class="form-control" />
                                                <!-- <select name="staff" id="staff" class="form-control">
                                                    <?php echo $midwife; ?>
                                                </select> -->

                                            </div>
                                            <br />
                                            <div class="form-inline">
                                                <button class="btn btn-info" name="save_birth"><span class="icon-save"></span> SAVE</button>
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






    </div>
    <!-- Container ends -->

    </div>
    <!-- App body ends -->



    <!-- App footer start -->
    <?php
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

    <?php include "script.php" ?>
  
    <script>
        Inputmask("999 / 999").mask("#bp");
    </script>

    <script>
        $(function() {
            $('#ddate').datetimepicker({
                format: 'YYYY-MM-DD'
            });

        });
        $(function() {
            $('#time').datetimepicker({
                format: 'LT'
            })
        });
    </script>



</body>



</html>