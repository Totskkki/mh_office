<?php

include '../config/connection.php';

if (isset($_POST['Updatelabour'])) {

    $patientID = trim($_POST['patientid']);
    $birthMonitorID = trim($_POST['birthMonitorID']);

    $case_no = trim($_POST['case_no']);
    $parity = trim($_POST['parity']);
    $addmissiondate = trim($_POST['addmissiondate']);
    $admissionTime = trim($_POST['admissionTime']);
    $timeactive = trim($_POST['timeactive']);
    $timeMembranes = trim($_POST['timeMembranes']);
    $timeSecond = trim($_POST['timeSecond']);
    $birth_time = trim($_POST['birthTime']);
    $Oxytocin = trim($_POST['Oxytocin']);
    $placentaComplete = trim($_POST['placentaComplete']);
    $Estimated = trim($_POST['Estimated']);

    $timedelevered = trim($_POST['timedelevered']);
    $Livebirth = trim($_POST['Livebirth']);
    $RESUSCITATION = trim($_POST['RESUSCITATION']);

    $birthweight = trim($_POST['birthweight']);
    $Preterm = trim($_POST['Preterm']);
    $secondbaby = trim($_POST['secondbaby']);
    $newbord = trim($_POST['newbord']);

    // ENTRY EXAMINATION
    $stage_of_labour = trim($_POST['stage_of_labour']);
    $ruptured_membranes = isset($_POST['ruptured_membranes']) ? json_encode($_POST['ruptured_membranes']) : json_encode([]);
    $vaginal_bleeding = isset($_POST['vaginal_bleeding']) ? json_encode($_POST['vaginal_bleeding']) : json_encode([]);
    $strong_contractions = isset($_POST['strong_contractions']) ? json_encode($_POST['strong_contractions']) : json_encode([]);
    $fetal_heart_rate = isset($_POST['fetal_heart_rate']) ? json_encode($_POST['fetal_heart_rate']) : json_encode([]);
    $temperature_axillary = isset($_POST['temperature_axillary']) ? json_encode($_POST['temperature_axillary']) : json_encode([]);
    $pulse = isset($_POST['pulse']) ? json_encode($_POST['pulse']) : json_encode([]);
    $respiratory_rate = isset($_POST['respiratory_rate']) ? json_encode($_POST['respiratory_rate']) : json_encode([]);
    $blood_pressure = isset($_POST['blood_pressure']) ? json_encode($_POST['blood_pressure']) : json_encode([]);
    $urine_voided = isset($_POST['urine_voided']) ? json_encode($_POST['urine_voided']) : json_encode([]);
    $cervical_dilatation = isset($_POST['cervical_dilatation']) ? json_encode($_POST['cervical_dilatation']) : json_encode([]);
    $maternalplan = trim($_POST['maternalplan']);
    $problem = trim($_POST['problem']);
    $time_onset = trim($_POST['time_onset']);
    $treatments = trim($_POST['treatments']);
    $referral_details = trim($_POST['referral_details']);

    try {
        $con->beginTransaction();


        $stmt = $con->prepare("
        UPDATE `tbl_birthing_monitoring`
        SET `case_no` = :case_no,
            `patient_id` = :patient_id,
            `parity` = :parity,
            `admission_date` = :admission_date,
            `admission_time` = :admission_time,
            `time_active` = :time_active,
            `time_membranes` = :time_membranes,
            `time_second` = :time_second,
            `birth_time` = :birth_time,
            `oxytocin` = :oxytocin,
            `placenta_complete` = :placenta_complete,
            `estimated` = :estimated,
            `time_delivered` = :time_delivered,
            `live_birth` = :live_birth,
            `RESUSCITATION` = :RESUSCITATION,
            `birth_weight` = :birth_weight,
            `preterm` = :preterm,
            `second_baby` = :second_baby,
            `newborn` = :newborn,
            `stage_of_labour` = :stage_of_labour,
            `ruptured_membranes` = :ruptured_membranes,
            `vaginal_bleeding` = :vaginal_bleeding,
            `strong_contractions` = :strong_contractions,
            `fetal_heart_rate` = :fetal_heart_rate,
            `temperature_axillary` = :temperature_axillary,
            `pulse` = :pulse,
            `respiratory_rate` = :respiratory_rate,
            `blood_pressure` = :blood_pressure,
            `urine_voided` = :urine_voided,
            `cervical_dilatation` = :cervical_dilatation,
            `maternal_plan` = :maternal_plan,
            `problem` = :problem,
            `time_onset` = :time_onset,
            `treatments` = :treatments,
            `referral_details` = :referral_details
              WHERE `birthMonitorID` = :birthMonitorID");

        // Execute the statement with the appropriate values
        $stmt->execute([

            ':birthMonitorID' => $birthMonitorID,
            ':case_no' => $case_no,
            ':patient_id' => $patientID,
            ':parity' => $parity,
            ':admission_date' => $addmissiondate,
            ':admission_time' => $admissionTime,
            ':time_active' => $timeactive,
            ':time_membranes' => $timeMembranes,
            ':time_second' => $timeSecond,
            ':birth_time' => $birth_time,
            ':oxytocin' => $Oxytocin,
            ':placenta_complete' => $placentaComplete,
            ':estimated' => $Estimated,
            ':time_delivered' => $timedelevered,
            ':live_birth' => $Livebirth,
            ':RESUSCITATION' => $RESUSCITATION,
            ':birth_weight' => $birthweight,
            ':preterm' => $Preterm,
            ':second_baby' => $secondbaby,
            ':newborn' => $newbord,
            ':stage_of_labour' => $stage_of_labour,
            ':ruptured_membranes' => $ruptured_membranes,
            ':vaginal_bleeding' => $vaginal_bleeding,
            ':strong_contractions' => $strong_contractions,
            ':fetal_heart_rate' => $fetal_heart_rate,
            ':temperature_axillary' => $temperature_axillary,
            ':pulse' => $pulse,
            ':respiratory_rate' => $respiratory_rate,
            ':blood_pressure' => $blood_pressure,
            ':urine_voided' => $urine_voided,
            ':cervical_dilatation' => $cervical_dilatation,
            ':maternal_plan' => $maternalplan,
            ':problem' => $problem,
            ':time_onset' => $time_onset,
            ':treatments' => $treatments,
            ':referral_details' => $referral_details,
        ]);

        // Commit the transaction
        $con->commit();

        // Success message and redirection
        $_SESSION['status'] = "Updated successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: ../birthing_patients.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}


?>