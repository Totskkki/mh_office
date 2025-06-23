<?php
include './config/connection.php';

include './common_service/common_functions.php';


// LMP DATE, -- Last Menstrual Period
//     EDC DATE, -- Estimated Date of Confinement
//     AOG INT, -- Age of Gestation (in weeks)


if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    $query = "SELECT com.*, pat.*, fam.*,mem.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
              FROM tbl_complaints AS com 
               JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
               JOIN tbl_membership_info as mem ON mem.membershipID  = pat.Membership_Info
              JOIN 
              tbl_familyAddress AS fam ON pat.family_address = fam.famID
              WHERE com.complaintID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();


    $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
}


if (isset($_POST['savebirth'])) {


    $user = $_SESSION['user_id'];
    $patientID = trim($_POST['patientID']);
    $complaintid = trim($_POST['complaintid']);

    $midwife_nurse = trim($_POST['midwife_nurse']);
    $birthing_status = 'ongoing'; 

    $years = $_POST['year'];
    $places_of_confinement = $_POST['place_of_confinement'];
    $aogs = $_POST['aog'];
    $bws = $_POST['bw'];
    $manners_of_delivery = $_POST['manner_of_delivery'];
    $complications_remarks = $_POST['complication_remarks'];
    $obstetrical_history = [];

    for ($i = 0; $i < count($years); $i++) {
        $obstetrical_history[] = [
            'year' => $years[$i],
            'place_of_confinement' => $places_of_confinement[$i],
            'aog' => $aogs[$i],
            'bw' => $bws[$i],
            'manner_of_delivery' => $manners_of_delivery[$i],
            'complication_remarks' => $complications_remarks[$i]
        ];
    }
    $obstetrical_history_json = json_encode($obstetrical_history);

    $gyneHistory = isset($_POST['gyne_history']) ? json_encode($_POST['gyne_history']) : json_encode([]);
    $partner = isset($_POST['partner']) ? json_encode($_POST['partner']) : json_encode([]);
    $presentPregnancyData = isset($_POST['present_pregnancy']) ? json_encode($_POST['present_pregnancy']) : '';
    $generalData = isset($_POST['general']) ? json_encode($_POST['general']) : json_encode([]);
    $caseno = trim($_POST['caseno']);
    $dateb = trim($_POST['dDate']);
    $LMP = trim($_POST['LMP']);
    $EDC = trim($_POST['EDC']);
    $AOG = trim($_POST['AOG']);
    $obscoreData = isset($_POST['obscore']) ? json_encode($_POST['obscore']) : json_encode([
        'g' => '',
        'p' => '',
        'term' => '',
        'preterm' => '',
        'abortion' => '',
        'living' => ''
    ]);
    $chiefcomplaint = trim($_POST['chiefcomplaint']);
    $past_med_history = isset($_POST['past_med_history']) ? json_encode($_POST['past_med_history']) : json_encode([]);
    $past_operations = trim($_POST['past_operations']);
    $Medication = trim($_POST['Medication']);
    $PastAdmission = trim($_POST['PastAdmission']);
    $famHistory = isset($_POST['famHistory']) ? json_encode($_POST['famHistory']) : json_encode([]);;
    $partnerData = isset($_POST['partner']) ? json_encode($_POST['partner']) : json_encode(['multiple' => 'No', 'alcohol' => 'No', 'smoking' => 'No']);
    $gyneHistoryData = isset($_POST['gyne_history']) ? json_encode($_POST['gyne_history']) : json_encode([
        'menarche' => '',
        'regular' => 'No',
        'duration' => '',
        'days' => '',
        'remarks' => '',
        'flow' => '',
        'dysmenorrhea' => 'No',
        'first_sexual_contact' => ''
    ]);
    $presentPregnancyData = isset($_POST['present_pregnancy']) ? json_encode($_POST['present_pregnancy']) : json_encode([
        'antepartal_care' => '',
        'start_visit' => '',
        'aog' => '',
        'tt' => '',
        'feso4' => 'No',
        'ogct' => '',
        'illness' => '',
        'tot_visit' => '',
        'others' => ''
    ]);

    // physical exam  start   //
    // $pr = trim($_POST['pr']);
    $FHT = trim($_POST['FHT']);
    $fundig_ht = trim($_POST['fundig_ht']);
    $dilatation = trim($_POST['dilatation']);
    $effacement = trim($_POST['effacement']);
    $bow = trim($_POST['bow']);
    $maneuver = trim($_POST['maneuver']);

    $SKINData = isset($_POST['SKIN']) ? json_encode($_POST['SKIN']) : json_encode([]);
    $heent = isset($_POST['heent']) ? json_encode($_POST['heent']) : json_encode([]);
    $chest_lungs = isset($_POST['chest_lungs']) ? json_encode($_POST['chest_lungs']) : json_encode([]);
    $CARDIOVASCULAR = isset($_POST['CARDIOVASCULAR']) ? json_encode($_POST['CARDIOVASCULAR']) : json_encode([]);
    $ABDOMEN = isset($_POST['ABDOMEN']) ? json_encode($_POST['ABDOMEN']) : json_encode([]);
    $EXTREMITIES = isset($_POST['EXTREMITIES']) ? json_encode($_POST['EXTREMITIES']) : json_encode([]);
    // physical exam  end //



    //SYSTEM REVIEW//
    $generalData = isset($_POST['general']) ? json_encode($_POST['general']) : json_encode([]);
    $skinData = isset($_POST['skin']) ? json_encode($_POST['skin']) : json_encode([]);
    $headData = isset($_POST['head']) ? json_encode($_POST['head']) : json_encode([]);
    $earsData = isset($_POST['ears']) ? json_encode($_POST['ears']) : json_encode([]);
    $eyes = isset($_POST['eyes']) ? json_encode($_POST['eyes']) : json_encode([]);
    $NOSE = isset($_POST['NOSE']) ? json_encode($_POST['NOSE']) : json_encode([]);

    $THROAT = isset($_POST['THROAT']) ? json_encode($_POST['THROAT']) : json_encode([]);
    $neck = isset($_POST['neck']) ? json_encode($_POST['neck']) : json_encode([]);
    $breast = isset($_POST['breast']) ? json_encode($_POST['breast']) : json_encode([]);
    $repiratory = isset($_POST['repiratory']) ? json_encode($_POST['repiratory']) : json_encode([]);
    $cardiovascular = isset($_POST['cardiovascular']) ? json_encode($_POST['cardiovascular']) : json_encode([]);
    $GASTROINTESTINAL = isset($_POST['GASTROINTESTINAL']) ? json_encode($_POST['GASTROINTESTINAL']) : json_encode([]);
    $URINARY = isset($_POST['URINARY']) ? json_encode($_POST['URINARY']) : json_encode([]);
    $GENITALIA = isset($_POST['GENITALIA']) ? json_encode($_POST['GENITALIA']) : json_encode([]);
    $MUSCULOSKELETAL = isset($_POST['MUSCULOSKELETAL']) ? json_encode($_POST['MUSCULOSKELETAL']) : json_encode([]);
    $VASCULAR = isset($_POST['VASCULAR']) ? json_encode($_POST['VASCULAR']) : json_encode([]);
    $NEUROLOGIC = isset($_POST['NEUROLOGIC']) ? json_encode($_POST['NEUROLOGIC']) : json_encode([]);
    $HEMATOLOGIC = isset($_POST['HEMATOLOGIC']) ? json_encode($_POST['HEMATOLOGIC']) : json_encode([]);
    $ENDOCRINE = isset($_POST['ENDOCRINE']) ? json_encode($_POST['ENDOCRINE']) : json_encode([]);
    $NEOROLOGIC1 = isset($_POST['NEOROLOGIC1']) ? json_encode($_POST['NEOROLOGIC1']) : json_encode([]);


    try {

        $con->beginTransaction();
        $stmt = $con->prepare("INSERT INTO `tbl_physicalexam`(`fht`, `fundic_ht`, `dilation`, `effacement`, `bow`,`maneuver`, `skin`, `heent`, `chest_lungs`, `cardiovascular`, `abdomen`, `extremities`) 
                                VALUES(:fht,:fundic_ht,:dilation,:effacement,:bow,:maneuver,:skin,:heent,:chest_lungs,:cardiovascular,:abdomen,:extremities)");
        $stmt->execute([

            // ':pr' => $pr,
            ':fht' => $FHT,
            ':fundic_ht' => $fundig_ht,
            ':dilation' => $dilatation,
            ':effacement' => $effacement,
            ':bow' => $bow,
            ':maneuver' => $maneuver,
            ':skin' => $SKINData,
            ':heent' => $heent,
            ':chest_lungs' => $chest_lungs,
            ':cardiovascular' => $CARDIOVASCULAR,
            ':abdomen' => $ABDOMEN,
            ':extremities' => $EXTREMITIES,
        ]);

        $physical = $con->lastInsertId();

        $stmt = $con->prepare("INSERT INTO `tbl_systemreview`(`general`, `SKIN`, `head`, `ears`, `eyes`, `nose`, `throat`, `neck`, `breast`, `respiratory`, `cardiovascular`, `gastrointestinal`, `urinary`,`genitalia`, `vascular`, `musculoskeletal`, `neurologic1`, `hematologic`, `endocrine`, `neurologic2`)
     VALUES(:general,:skin,:head,:ears,:eyes,:nose,:throat,:neck,:breast,:respiratory,:cardiovascular,:gastrointestinal,:urinary,:genitalia,:vascular,:musculoskeletal,:neurologic1,:hematologic,:endocrine,:neurologic2)");
        $stmt->execute([

            ':general' => $generalData,
            ':skin' => $skinData,
            ':head' => $headData,
            ':ears' => $earsData,
            ':eyes' => $eyes,
            ':nose' => $NOSE,
            ':throat' => $THROAT,
            ':neck' => $neck,
            ':breast' => $breast,
            ':respiratory' => $repiratory,
            ':cardiovascular' => $cardiovascular,
            ':gastrointestinal' => $GASTROINTESTINAL,
            ':urinary' => $URINARY,
            ':genitalia' => $GENITALIA,
            ':vascular' => $VASCULAR,
            ':musculoskeletal' => $MUSCULOSKELETAL,
            ':neurologic1' => $NEUROLOGIC,
            ':hematologic' => $HEMATOLOGIC,
            ':endocrine' => $ENDOCRINE,
            ':neurologic2' => $NEOROLOGIC1,


        ]);

        $systemreview = $con->lastInsertId();

        $stmt = $con->prepare("INSERT INTO `tbl_birth_info`(`patient_id`,`case_no`, `date`, `LMP`, `EDC`, `AOG`, `OBSCORE`, `chief_complaint`, `past_med_history`, `past_operations`, `medication`, `past_admission`,
     `family_history`, `ps_history`, `gyne_history`, `present_pregnancy`, `obstetrical_history`, `userID`,`systemReviewID`,`physicalExamID`, `midwife_nurse`,`birthing_status`)
      VALUES(:patient_id,:case_no,:date,:LMP,:EDC,:AOG,:OBSCORE,:chief_complaint,:past_med_history,:past_operations,:medication,:past_admission,
      :family_history,:ps_history,:gyne_history,:present_pregnancy,:obstetrical_history,:userID,:systemReviewID,:physicalExamID,:midwife_nurse,:birthing_status)");
        $stmt->execute([

            ':patient_id' => $patientID,
            ':case_no' => $caseno,
            ':date' => $dateb,
            ':LMP' => $LMP,
            ':EDC' => $EDC,
            ':AOG' => $AOG,
            ':OBSCORE' => $obscoreData,
            ':chief_complaint' => $chiefcomplaint,
            ':past_med_history' => $past_med_history,
            ':past_operations' => $past_operations,
            ':medication' => $Medication,
            ':past_admission' => $PastAdmission,
            ':family_history' => $famHistory,
            ':ps_history' => $partnerData,
            ':gyne_history' => $gyneHistoryData,
            ':present_pregnancy' => $presentPregnancyData,
            ':obstetrical_history' => $obstetrical_history_json,
            ':userID' => $user,
            ':systemReviewID' => $systemreview,
            ':physicalExamID' => $physical,
            ':midwife_nurse' => $midwife_nurse,
            ':birthing_status' => $birthing_status,

        ]);
        
        
        $immuneId = $con->lastInsertId();
  
 
         $stmt = $con->prepare("insert into tbl_patient_visits(`visit_date`, `visit_counts`) VALUES (:visitdate,:visit_counts)");
        $stmt->execute([
              
                ':visitdate' => $dateb,
                ':visit_counts' => $immuneId,
                
         ]);
        
        
        $con->commit();


        $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints 
        SET status = 'Under Monitoring' 
        WHERE patient_id = :patientID 
        AND (consultation_purpose = 'Birthing') 
        AND complaintID = :complaintID");
        $stmtUpdate1->bindParam(':patientID', $patientID);
        $stmtUpdate1->bindParam(':complaintID', $complaintid);
        $stmtUpdate1->execute();
        $_SESSION['status'] = "Submitted succefully.";
        $_SESSION['status_code'] = "success";
        header('location: birthing_monitoring.php');
        exit();

        $_SESSION['status'] = "Submitted succefully.";
        $_SESSION['status_code'] = "success";
        header('location: maternity.php');
        exit();
    } catch (Exception $e) {

        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}




$midwife = getNurseMidwife($con);
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .header,
        .section {
            margin-bottom: 20px;
        }

        .header h2 {
            text-align: center;
        }

        .header img {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
        }

        .field-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .field-group label {
            width: 30%;
        }

        .field-group input,
        .field-group textarea {
            width: 65%;
        }

        .checkbox-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;


        }

        .checkbox-group label {
            width: 30%;
            display: flex;
            align-items: center;
        }

        .checkbox-group input {
            margin-right: 10px;
            transform: scale(.8);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .footer-buttons {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
        }

        .header h4 {
            text-align: center;
        }

        .form-input {
            border: none;
            border-bottom: 1px solid black;
            width: 20%;
        }

        .form-input1 {
            border: none;
            border-bottom: 1px solid black;
            width: 10%;
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




        .text-center {
            text-align: center;
        }

        .checkbox-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 20px;
        }

        .column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .checkbox-group1 {
            display: flex;
            flex-direction: column;
        }

        .checkbox-group1 b {
            margin-bottom: 10px;
        }

        .checkbox-group1 label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
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
                    <!-- <a href="index.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a> -->
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

                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    ?>
                        <?php ?>

                    <?php


                    }

                    ?>
                    <!-- Container starts -->
                    <div class="container-fluid">

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <!-- <h5 class="card-title">Form Layout</h5> -->
                                    </div>


                                    <?php

                                    function generatecaseNumber()
                                    {

                                        $currentDate = date('Ymd');

                                        global $con;
                                        $countQuery = "SELECT COUNT(*) AS count FROM tbl_birth_info WHERE DATE(date) = CURDATE()";
                                        $countStatement = $con->prepare($countQuery);
                                        $countStatement->execute();
                                        $countResult = $countStatement->fetch(PDO::FETCH_ASSOC);
                                        $count = ($countResult && isset($countResult['count'])) ? intval($countResult['count']) + 1 : 1;


                                        $registrationNumber = $currentDate . str_pad($count, 3, '0', STR_PAD_LEFT);
                                        return $registrationNumber;
                                    }


                                    $newcaseNumber = generatecaseNumber();
                                    ?>

                                    <div class="card-body">

                                        <form method="POST" id="birthform" novalidate>
                                            <div class="header">
                                                <img src="logo/2.png" alt="Logo">
                                                <h4>LUTAYAN RHU BIRTHING CENTER</h4>
                                                <h4>Brgy Tamnag, Lutayan, Sultan Kudarat</h4>
                                                <h4 class="mb-5">Tel. #: (083)-228-1528</h4>
                                                <?php if (isset($patientData)) : ?>
                                                    <div class="section">
                                                        <h2 class="mb-5">Labor Admission Chart</h2>
                                                        <div class="row">
                                                            <div style="text-align: left; flex: 1;">
                                                                <label class="form-label">PhilHealth No.:</label>
                                                                <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['philhealth_no'])  ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <br>



                                                        <div style="text-align: left; flex: 1;">
                                                            <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientData['patientID'])  ?>">
                                                            <input type="hidden" name="complaintid" value="<?php echo htmlspecialchars($patientData['complaintID']); ?>">
                                                            <label class="form-label">Patient's Name: <u></u></label>
                                                            <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['name'])  ?>" readonly>
                                                            <label class="form-label">Case No.: </label>
                                                            <input class="form-input" name="caseno" type="text" value="<?php echo htmlspecialchars($newcaseNumber); ?>" readonly>
                                                            <label class="form-label">Date: </label>
                                                            <input class="form-input" name="dDate" id="dDate" type="date" required>
                                                            <div class="invalid-feedback">
                                                                Date is required.
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                            <label class="form-label">LMP: <u><?php  ?></u></label>
                                                            <input class="form-input1" type="text" name="LMP">
                                                            <label class="form-label">EDC: <?php ?></label>
                                                            <input class="form-input1" type="text" name="EDC">
                                                            <label class="form-label">AOG: <?php ?></label>
                                                            <input class="form-input1" type="text" name="AOG">
                                                            <label class="form-label">OB Score: <?php ?> </label>
                                                            <label class="form-label">G <?php ?></label>
                                                            <input class="form-input1" type="text" name="obscore[g]" value="" style="width: 3%;">

                                                            <label class="form-label">P</label>
                                                            <input class="form-input1" type="text" name="obscore[p]" value="" style="width: 3%;">

                                                            <label class="form-label">(</label>
                                                            <input class="form-input1" type="text" name="obscore[term]" value="" style="width: 3%;">

                                                            <label class="form-label">,</label>
                                                            <input class="form-input1" type="text" name="obscore[preterm]" value="" style="width: 3%;">

                                                            <label class="form-label">,</label>
                                                            <input class="form-input1" type="text" name="obscore[abortion]" value="" style="width: 3%;">

                                                            <label class="form-label">,</label>
                                                            <input class="form-input1" type="text" name="obscore[living]" value="" style="width: 3%;">
                                                            <label class="form-label">)</label>

                                                            <label class="form-label">BLOOD TYPE: <?php ?></label>
                                                            <input class="form-input1" type="text"  style="width: 5%;" value="<?php echo htmlspecialchars($patientData['blood_type'])  ?>">


                                                        </div>


                                                    <?php else : ?>
                                                        <p>No patient details found.</p>
                                                    <?php endif; ?>
                                                    <br>

                                                    <div class="section">
                                                        <h3>Chief Complaint and Brief History</h3>
                                                        <textarea class="form-control" name="chiefcomplaint" id="chief_complaint" rows="4" required></textarea>
                                                        <div class="invalid-feedback">
                                                            Chief Complaint and Brief History are required.
                                                        </div>
                                                    </div>

                                                    <div class="section">
                                                        <h3>Past Medical History</h3>
                                                        <div class="checkbox-group mb-3">
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Heart Disease"> Heart Disease</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Pulmonary TB"> Pulmonary TB</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="HIV/AIDS"> HIV/AIDS</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Syphilis"> Syphilis</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Gonorrhea"> Gonorrhea</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Other STI"> Other STI</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Hypertension"> Hypertension</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Hepatitis"> Hepatitis</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Asthma"> Asthma</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Cancer"> Cancer</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Torch Infection"> Torch Infection</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Renal Disease"> Renal Disease</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Thyroid D/O"> Thyroid D/O</label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="Seizure D/O"> Seizure D/O</label>
                                                            <label> OTHERS<input type="text" name="past_med_history[]" value="" class="form-check-label input-bottom-border-only"> </label>
                                                            <label><input type="checkbox" class="form-check-input " name="past_med_history[]" value="allergies" id="allergies"> Allergies</label>
                                                        </div>
                                                        <div style="text-align: left; flex: 1;">
                                                            <label class="form-label">Past Operations: <u><?php  ?></u></label>
                                                            <input class="form-input1" type="text" name="past_operations" value="" style="width: 20%;">
                                                            <label class="form-label">Medication:<?php ?></label>
                                                            <input class="form-input1" type="text" name="Medication" value="" style="width: 20%;">
                                                            <label class="form-label">Past Admission: <?php ?></label>
                                                            <input class="form-input1" type="text" name="PastAdmission" value="" style="width: 20%;">

                                                        </div>

                                                        <br>

                                                        <div class="section">
                                                            <h3>Family History</h3>
                                                            <div class="checkbox-group">
                                                                <label><input class="form-check-input " type="checkbox" name="famHistory[]" id="family_heart_disease" value="Heart Disease"> Heart Disease</label>
                                                                <label><input class="form-check-input " type="checkbox" name="famHistory[]" id="family_hypertension" value="Hypertension"> Hypertension</label>
                                                                <label><input class="form-check-input " type="checkbox" name="famHistory[]" id="family_diabetes" value="Diabetes"> Diabetes</label>
                                                                <label><input class="form-check-input " type="checkbox" id="family_renal_disease" value="Renal Disease"> Renal Disease</label>
                                                                <label><input class="form-check-input " type="checkbox" name="famHistory[]" id="family_asthma" value="Asthma"> Asthma</label>
                                                                <label><input class="form-check-input " type="checkbox" id="family_multifetal_pregnancy" value="Multifetal Pregnancy"> Multifetal Pregnancy</label>
                                                                <label><input class="form-check-input " type="checkbox" name="famHistory[]" id="family_cancer" value="Cancer"> Cancer</label>
                                                                <label> OTHERS<input type="text" name="famHistory[]" id="otherSymptoms" value="" class="form-check-label input-bottom-border-only"> </label>
                                                            </div>
                                                        </div>

                                                        <div class="section">
                                                            <h3>P/S History</h3>
                                                            <div style="text-align: left; flex: 1;">
                                                                <label class="form-label">Educational Attainment: <u><?php  ?></u></label>
                                                                <input class="form-input1" type="text" style="width: 20%;" value="<?php echo htmlspecialchars($patientData['ed_at'])  ?>" readonly>
                                                                <label class="form-label">Occupation:</label>

                                                                <input class="form-input1" type="text" style="width: 20%;" value="<?php echo htmlspecialchars($patientData['emp_stat'])  ?>" readonly>
                                                                <label class="form-label">Civil Status: </label>
                                                                <input class="form-input1" type="text" style="width: 20%;" value="<?php echo htmlspecialchars($patientData['civil_status'])  ?>" readonly>

                                                            </div>


                                                            <div class="checkbox-group">
                                                                <label> Multiple Sex Partners
                                                                    <input class="form-check-input " type="checkbox" name="partner[multiple]" value="Yes" onclick="toggleCheckbox(this)">
                                                                    Yes
                                                                    <input class="form-check-input " type="checkbox" name="partner[multiple]" value="No" onclick="toggleCheckbox(this)">No
                                                                </label>
                                                                <label>Alcohol Intake
                                                                    <input class="form-check-input " type="checkbox" name="partner[alcohol]" value="Yes" onclick="toggleCheckbox(this)">
                                                                    Yes
                                                                    <input class="form-check-input " type="checkbox" name="partner[alcohol]" value="No" onclick="toggleCheckbox(this)">No
                                                                </label>
                                                                <label>Smoking
                                                                    <input class="form-check-input" type="checkbox" name="partner[smoking]" value="Yes" onclick="toggleCheckbox(this)">
                                                                    Yes
                                                                    <input class="form-check-input " type="checkbox" name="partner[smoking]" value="No" onclick="toggleCheckbox(this)">No
                                                                </label>

                                                            </div>
                                                        </div>

                                                        <div class="section">
                                                            <h3>Gyne History</h3>
                                                            <div style="text-align: left; flex: 1;">
                                                                <label class="form-label">Menarche:</label>
                                                                <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[menarche]" >

                                                                <label>Regular?
                                                                    <input type="checkbox" class="form-check-input" name="gyne_history[regular]" value="Yes" onclick="toggleCheckbox(this)"> Yes
                                                                    <input type="checkbox" class="form-check-input" name="gyne_history[regular]" value="No" onclick="toggleCheckbox(this)"> No
                                                                </label>

                                                                <label style="margin-left: 3rem;" class="form-label">Duration:</label>
                                                                <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[duration]" value="" >

                                                                <label class="form-label">Days:</label>
                                                                <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[days]" value="" >

                                                                <label style="margin-left: 3rem;" class="form-label">Remarks:</label>
                                                                <input class="form-input1" type="text" style="width: 20%;" name="gyne_history[remarks]" value="" >
                                                            </div>

                                                            <br>

                                                            <label class="form-label">Flow:
                                                                <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="scanty" onclick="toggleCheckbox(this)"> Scanty
                                                                <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="moderate" onclick="toggleCheckbox(this)"> Moderate
                                                                <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="profuse" onclick="toggleCheckbox(this)"> Profuse
                                                            </label>

                                                            <label style="margin-left: 3rem;">Dysmenorrhea?
                                                                <input type="checkbox" class="form-check-input" name="gyne_history[dysmenorrhea]" value="yes" onclick="toggleCheckbox(this)"> Yes
                                                                <input type="checkbox" class="form-check-input" name="gyne_history[dysmenorrhea]" value="no" onclick="toggleCheckbox(this)"> No
                                                            </label>

                                                            <label class="form-label" style="margin-left: 3rem;">Age of First Sexual Contact:</label>
                                                            <input class="form-input1" name="gyne_history[first_sexual_contact]" type="text" value="" style="width: 20%;" >
                                                        </div>
                                                        <br>

                                                        <div class="section">
                                                            <h3>Present Pregnancy</h3>
                                                            <label>Antepartal Care:</label>
                                                            <label>
                                                                <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care]" value="OPD" onclick="toggleCheckbox(this)"> OPD
                                                            </label>
                                                            <label>
                                                                <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care]" value="Health Center" onclick="toggleCheckbox(this)"> Health Center
                                                            </label>
                                                            <label>
                                                                <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care]" value="Private MD" onclick="toggleCheckbox(this)"> Private MD
                                                            </label>
                                                            <label>
                                                                <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care]" value="None" onclick="toggleCheckbox(this)"> None
                                                            </label>

                                                            <label class="form-label" style="margin-left: 3rem;">Start of Visit:</label>
                                                            <input class="form-input1" id="start_visit" name="present_pregnancy[start_visit]" type="text" style="width: 10%;" >

                                                            <label class="form-label">AOG:</label>
                                                            <input class="form-input1" id="aog" name="present_pregnancy[aog]" type="text" style="width: 10%;" >

                                                            <label class="form-label" style="margin-left: 3rem;">TT:</label>
                                                            <input class="form-input1" id="tt" name="present_pregnancy[tt]" type="text" style="width: 10%;" >

                                                            <div style="text-align: left; flex: 1;">
                                                                <label class="mt-2">FeSO4:</label>
                                                                <input type="checkbox" class="form-check-input" name="present_pregnancy[feso4]" value="Yes" onclick="toggleCheckbox(this)"> Yes
                                                                <input class="form-check-input" type="checkbox" name="present_pregnancy[feso4]" value="No" onclick="toggleCheckbox(this)"> No

                                                                <label style="margin-left: 3rem;" class="form-label">50g OGCT:</label>
                                                                <input class="form-input1" name="present_pregnancy[ogct]" type="text" style="width: 10%;" >

                                                                <label class="form-label">Illness:</label>
                                                                <input class="form-input1" name="present_pregnancy[illness]" type="text" style="width: 10%;" >

                                                                <label class="form-label">TOT Visit:</label>
                                                                <input class="form-input1" name="present_pregnancy[tot_visit]" type="text" style="width: 10%;" >

                                                                <label class="form-label">Others:</label>
                                                                <input class="form-input1" name="present_pregnancy[others]" type="text" style="width: 10%;" >
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="table-responsive">
                                                                    <h3>Obstetrical History</h3>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No.</th>
                                                                                <th>Year</th>
                                                                                <th>Place of Confinement</th>
                                                                                <th>AOG</th>
                                                                                <th>BW</th>
                                                                                <th>Manner of Delivery</th>
                                                                                <th>Complication / Remarks</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="obstetrical-history-body">
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td><input type="text" class="form-control" name="year[]"></td>
                                                                                <td><input type="text" class="form-control" name="place_of_confinement[]"></td>
                                                                                <td><input type="text" class="form-control" name="aog[]"></td>
                                                                                <td><input type="text" class="form-control" name="bw[]"></td>
                                                                                <td><input type="text" class="form-control" name="manner_of_delivery[]"></td>
                                                                                <td><input type="text" class="form-control" name="complication_remarks[]"></td>
                                                                                <td>
                                                                                    <button class="btn btn-info add-row-btn"><i class="fas fa-plus"></i></button>
                                                                                    <button class="btn btn-danger remove-row-btn" style="display: none;"><i class="fas fa-minus"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="section">
                                                        <h3 class="text-center">REVIEW OF THE SYSTEM</h3>
                                                        <div class="checkbox-container">
                                                            <div class="column">
                                                                <div class="checkbox-group1">
                                                                    <b>GENERAL:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="weight_loss_gain"> Weight loss/gain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="trouble_sleeping"> Trouble sleeping</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="hiv_aids"> HIV/AIDS</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="weakness"> Weakness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="fever_chills"> Fever/Chills</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="general[]" value="fatigue"> Fatigue</label>
                                                                </div>

                                                                <div class="checkbox-group1">
                                                                    <b>SKIN:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="rashes"> Rashes</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="lumps"> Lumps</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="itching"> Itching</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="color_changes"> Color Changes</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="dryness"> Dryness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="skin[]" value="hair_nail_changes"> Hair and Nail Changes</label>
                                                                </div>

                                                                <div class="checkbox-group1">
                                                                    <b>HEAD:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="head[]" value="Headache"> Headache</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="head[]" value="Head Injury"> Head Injury</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>EARS:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="ears[]" value=" Decrease hearing"> Decrease hearing</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ears[]" value="Tinnitus"> Tinnitus</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ears[]" value="Earache"> Earache</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ears[]" value="Drainage"> Drainage</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>EYES:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Vision"> Vision</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Plain"> Plain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Blurry/Blurred Vision"> Blurry/Blurred Vision</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Flashing Lights"> Flashing Lights</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Specks"> Specks</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Glasses/Contacts"> Glasses/Contacts</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Redness"> Redness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Cataracts"> Cataracts</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Last Eye Exam"> Last Eye Exam</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Glaucoma"> Glaucoma </label>


                                                                </div>
                                                            </div>
                                                            <div class="column">

                                                                <div class="checkbox-group1">
                                                                    <b>NOSE:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Stuffiness"> Stuffiness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Nosebleed"> Nosebleed</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Discharge"> Discharge</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Sinus Pain"> Sinus Pain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Itching"> Itching</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="High Fever"> High Fever</label>




                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>THROAT:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Teeth"> Teeth</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Gums"> Gums</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Bleeding"> Bleeding</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Dentures"> Dentures</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Sore Tongue"> Sore Tongue</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Hoarseness"> Hoarseness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Thursh"> Thursh</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Non Healing Sores"> Non Healing Sores</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Last Dental Exam"> Last Dental Exam</label>
                                                                </div>

                                                                <div class="checkbox-group1">
                                                                    <b>NECK:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="neck[]" value="Lumps"> Lumps</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="neck[]" value="Pain"> Pain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="neck[]" value="Swollen Glands"> Swollen Glands</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="neck[]" value="Stiffness"> Stiffness</label>





                                                                </div>

                                                                <div class="checkbox-group1">
                                                                    <b>BREAST:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="breast[]" value="Lumps"> Lumps</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="breast[]" value="Breastfeeding"> Breastfeeding</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="breast[]" value="Discharge"> Discharge</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="breast[]" value="Pain"> Pain</label>
                                                                </div>

                                                            </div>
                                                            <div class="column">


                                                                <div class="checkbox-group1">
                                                                    <b>RESPIRATORY:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Cough"> Cough</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Sputum"> Sputum</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Hemoptysis"> Hemoptysis</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Dyspnea"> Dyspnea</label>

                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Wheezing"> Wheezing</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Pain Breathing"> Pain Breathing</label>
                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>CARDIOVASCULAR:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Chest Pain/Discomfort"> Chest Pain/Discomfort</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Tightness"> Tightness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Palpitations"> Palpitations</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>GASTROINTESTINAL:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Orthopnea"> Orthopnea</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Paroxysmal Nocturnal Dyspnea"> Paroxysmal Nocturnal Dyspnea</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Swallowing Difficulties"> Swallowing Difficulties</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Change in Appetite"> Change in Appetite</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Swelling/Edema"> Swelling/Edema</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Heartburn"> Heartburn</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Nausea"> Nausea</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>URINARY:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Change in bowel Habits"> Change in bowel Habits</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Frequency"> Frequency</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Urgency"> Urgency</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Burning/Pain"> Burning/Pain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Rectal Bleeding"> Rectal Bleeding</label>


                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>GENITALIA:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="GENITALIA[]" value="Pain during intercourse"> Pain during intercourse</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="GENITALIA[]" value="Viginal dryness"> Viginal dryness</label>



                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>VASCULAR:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="VASCULAR[]" value="Calf pain when walking"> Calf pain when walking</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="VASCULAR[]" value="Leg cramping"> Leg cramping</label>

                                                                </div>

                                                            </div>
                                                            <div class="column">
                                                                <div class="checkbox-group1">
                                                                    <b>MUSCULOSKELETAL:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Muscle/Joint pain"> Muscle/Joint pain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Stiffness"> Stiffness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Back pain"> Back pain</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Trauma"> Trauma</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Swelling of Joints"> Swelling of Joints</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>NEUROLOGIC:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Dizziness"> Dizziness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Weakness"> Weakness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Tingling"> Tingling</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Fainting"> Fainting</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Tremor"> Tremor</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Seizure"> Seizure</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Numbness"> Numbness</label>
                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>HEMATOLOGIC:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="HEMATOLOGIC[]" value="Easy Bruising"> Easy Bruising</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="HEMATOLOGIC[]" value="Easy Bleeding"> Easy Bleeding</label>

                                                                </div>

                                                                <div class="checkbox-group1">
                                                                    <b>ENDOCRINE:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Heat /Cold Intolerance"> Heat /Cold Intolerance</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Sweeting">Sweeting</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polydipsia">Polydipsia</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polyuria">Polyuria</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Change in Appetite">Change in Appetite</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polyphagia">Polyphagia</label>

                                                                </div>
                                                                <div class="checkbox-group1">
                                                                    <b>NEOROLOGIC:</b>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Nerousness">Nerousness</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Depression">Depression</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Itching/Rash">Itching/Rash</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Polyuria">Polyuria</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Memory loss">Memory loss</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Hot Flashes">Hot Flashes</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Stress">Stress</label>
                                                                    <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="STD's">STD's</label>

                                                                </div>


                                                            </div>

                                                        </div>
                                                        <div class="section">
                                                            <h3 class="mb-3">PHYSICAL EXAMINATION</h3>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">BP: <u><?php  ?></u></label>
                                                                <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['bp']);  ?>">
                                                                <label class="form-label">PR: <?php ?></label>
                                                                <input class="form-input1" type="text" name="pr" value="<?php echo htmlspecialchars($patientData['pr']); ?>" required>
                                                                <label class="form-label">T: <?php ?></label>
                                                                <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['temp']); ?>" required>
                                                                <label class="form-label">WT: <?php ?></label>
                                                                <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['weight']); ?>" required>
                                                                <label class="form-label">HT: <?php ?></label>
                                                                <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['Height']); ?>" required>
                                                                <label class="form-label">FHT: <?php ?></label>
                                                                <input class="form-input1" type="text" name="FHT" required>
                                                                <div class="invalid-feedback">
                                                                    FHT is required.
                                                                </div>



                                                            </div>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">FUNDIC HT: </label>
                                                                <input class="form-input1" type="text" name="fundig_ht" required>
                                                                <div class="invalid-feedback">
                                                                    FUNDIC HT is required.
                                                                </div>
                                                                <label class="form-label">DILATATION</label>
                                                                <input class="form-input1" type="text" name="dilatation" required>
                                                                <div class="invalid-feedback">
                                                                    DILATATION is required.
                                                                </div>
                                                                <label class="form-label">EFFACEMENT</label>
                                                                <input class="form-input1" type="text" name="effacement" required>
                                                                <div class="invalid-feedback">
                                                                    EFFACEMENT is required.
                                                                </div>
                                                                <label class="form-label">BOW</label>
                                                                <input class="form-input1" type="text" name="bow" required>
                                                                <div class="invalid-feedback">
                                                                    BOW is required.
                                                                </div>
                                                            </div>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">Leopold's Maneuver: </label>
                                                                <input class="form-input" style="width: 50%;" type="text" name="maneuver">

                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">SKIN: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" value="Rashes"> Rashes</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" value="Nodules"> Nodules </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" value="Pallor"> Pallor </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" value="Jaundice"> Jaundice </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" value="Good skin turgor"> good skin turgor </label>
                                                                <br>
                                                                <input class="form-input" style="width: 50%;margin-left: 8rem;" name="SKIN[]" value="" type="text">
                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">HEENT: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value=""> anicteric sclerea</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="anicteric sclerea"> Pupils briskly reactive to light </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Aural Discharge"> Aural Discharge </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Intact Tympanic Membrane"> Intact Tympanic Membrane </label>
                                                                <br>
                                                                <label style="margin-left: 8rem;" class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value=" Alar Flaring"> Alar Flaring </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Nasal Discharge"> Nasal Discharge </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Tonsillopharyngeal Congestion"> Tonsillopharyngeal Congestion </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Hypertrohpic tonsils"> Hypertrohpic tonsils </label>
                                                                <br>
                                                                <label style="margin-left: 8rem;" class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Palpable Mass"> Palpable Mass </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="heent[]" value="Exudates"> Exudates </label>

                                                                <input class="form-input" style="width: 40%;" type="text" name="heent[]" value="">
                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">CHEST/LUNGS: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="symmtrical chest expansion"> symmtrical chest expansion</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Clear Breath sounds"> Clear Breath sounds </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Retractions"> Retractions </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Crackles"> Crackles </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Wheezes"> Wheezes </label>
                                                                <br>
                                                                <input class="form-input" style="width: 50%;margin-left: 8rem;" type="text" name="chest_lungs[]" value="">
                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">CARDIOVASCULAR: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Adynamic Precordlum"> Adynamic Precordlum</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Normal rate regular rhythm"> Normal rate regular rhythm </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Heaves/thrills"> Heaves/thrills </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Murmurs"> Murmurs </label>

                                                                <br>
                                                                <input class="form-input" style="width: 50%;margin-left: 8rem;" type="text" name="CARDIOVASCULAR[]">
                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">ABDOMEN: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Flat"> Flat</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Globular"> Globular</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Flabby"> Flabby </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Muscle Guarding"> Muscle Guarding </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Tenderness"> Tenderness </label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Palpable Mass "> Palpable Mass </label>
                                                                <br>
                                                                <input class="form-input" style="width: 50%;margin-left: 8rem;" type="text" name="ABDOMEN[]" value="">
                                                            </div>
                                                            <br>
                                                            <div style="text-align: left; flex: 1;margin-left:5rem;">
                                                                <label class="form-label">EXTREMITIES: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="EXTREMITIES[]" value="Gross deformity"> Gross deformity</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="EXTREMITIES[]" value="Normal gait"> Normal gait</label>
                                                                <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="EXTREMITIES[]" value="Full and equal pulses"> Full and equal pulses </label>

                                                                <br>
                                                                <input class="form-input" style="width: 50%;margin-left: 8rem;" name="EXTREMITIES[]" value="" type="text">
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="row">
                                                        <label style=" text-align: right;" class="form-label ">Midwife/Nurse On Duty</label>
                                                        <div style="flex-grow: 1; text-align: right;">

                                                            <select name="midwife_nurse" class="form-select float-end" style="width: 15%;" required>

                                                                <?php echo $midwife; ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Midwife/Nurse On Duty is required.
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <!-- Row start -->
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <div class="d-flex gap-2 justify-content-end">
                                                                <!-- <button type="button" class="btn btn-outline-secondary">
                                                                        Cancel
                                                                    </button> -->
                                                                <button type="submit" name="savebirth" class="btn btn-info">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Row end -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row end -->

                <!-- Row start -->

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
    <?php include './config/data_tables_js.php'; ?>
   

    <!-- <script>
    // Ensure only one checkbox is checked at a time for "Regular?"
    const menarcheRegularYes = document.getElementById('menarche_regular_yes');
    const menarcheRegularNo = document.getElementById('menarche_regular_no');
    const dysmenorrheaYes = document.getElementById('menarche_regular_yes');
    const dysmenorrheaNo = document.getElementById('menarche_regular_no');

    menarcheRegularYes.addEventListener('change', function() {
        if (this.checked) {
            menarcheRegularNo.checked = false;
        }
    });

    menarcheRegularNo.addEventListener('change', function() {
        if (this.checked) {
            menarcheRegularYes.checked = false;
        }
    });
   </script> -->
 
    
    <script>
        function toggleCheckbox(checkbox) {
            // Get all checkboxes with the same name
            const checkboxes = document.getElementsByName(checkbox.name);

            // Uncheck the other checkbox if this one is checked
            checkboxes.forEach((cb) => {
                if (cb !== checkbox) cb.checked = false;
            });
        }
    </script>

    <script>
        // Get the current date
        var today = new Date();

        // Format the date as YYYY-MM-DD
        var day = ("0" + today.getDate()).slice(-2);
        var month = ("0" + (today.getMonth() + 1)).slice(-2);
        var year = today.getFullYear();
        var maxDate = year + "-" + month + "-" + day;

        // Set the max attribute of the date input
        document.getElementById('dDate').setAttribute('max', maxDate);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('obstetrical-history-body').addEventListener('click', function(event) {
                if (event.target.classList.contains('add-row-btn') || event.target.closest('.add-row-btn')) {
                    // Prevent form submission if the button is inside a form
                    event.preventDefault();

                    // Get the table body
                    var tableBody = document.getElementById('obstetrical-history-body');

                    // Create a new row
                    var newRow = document.createElement('tr');

                    // Create cells with input fields
                    newRow.innerHTML = `
                <td></td>
                <td><input type="text" class="form-control" name="year[]"></td>
                <td><input type="text" class="form-control" name="place_of_confinement[]"></td>
                <td><input type="text" class="form-control" name="aog[]"></td>
                <td><input type="text" class="form-control" name="bw[]"></td>
                <td><input type="text" class="form-control" name="manner_of_delivery[]"></td>
                <td><input type="text" class="form-control" name="complication_remarks[]"></td>
                <td>
                    <button class="btn btn-danger remove-row-btn"><i class="fas fa-minus"></i></button>
                </td>
            `;

                    // Append the new row to the table body
                    tableBody.appendChild(newRow);

                    // Show the remove button on the second row if it's the first addition
                    var rows = tableBody.getElementsByTagName('tr');
                    if (rows.length == 2) {
                        rows[1].querySelector('.remove-row-btn').style.display = 'inline-block';
                    }

                    // Update the row numbers
                    updateRowNumbers();
                } else if (event.target.classList.contains('remove-row-btn') || event.target.closest('.remove-row-btn')) {
                    // Prevent form submission if the button is inside a form
                    event.preventDefault();

                    // Remove the row
                    var row = event.target.closest('tr');
                    row.parentNode.removeChild(row);

                    // Update the row numbers
                    updateRowNumbers();

                    // Hide the remove button on the first row if there is only one row left
                    var rows = document.querySelectorAll('#obstetrical-history-body tr');
                    if (rows.length === 1) {
                        rows[0].querySelector('.remove-row-btn').style.display = 'none';
                    }
                }
            });

            function updateRowNumbers() {
                var tableBody = document.getElementById('obstetrical-history-body');
                var rows = tableBody.getElementsByTagName('tr');
                for (var i = 0; i < rows.length; i++) {
                    rows[i].getElementsByTagName('td')[0].innerText = i + 1;
                }
            }
        });
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('birthform');

        form.addEventListener('submit', function(event) {
            // Check if the form is valid
            if (!form.checkValidity()) {
                event.preventDefault(); // Prevent form submission
                event.stopPropagation(); // Stop further event propagation
            }

            // Add Bootstrap validation class
            form.classList.add('was-validated');
        }, false);
    });
</script>


</body>



</html>