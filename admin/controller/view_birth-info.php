<?php
include '../config/connection.php';




// LMP DATE, -- Last Menstrual Period
//     EDC DATE, -- Estimated Date of Confinement
//     AOG INT, -- Age of Gestation (in weeks)


if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];



    $query = "SELECT b.*, pat.*, fam.*, mem.*, b.date, p.*, s.*, u.*, per.*, com.*, com.created_at,
    CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS name,
    CONCAT(fam.brgy, ' ', fam.purok, ' ', fam.province) AS address,
    CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS nurse_name
   
  FROM tbl_birth_info AS b 
  JOIN tbl_patients AS pat ON b.patient_id = pat.patientID
  JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
  JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID
  JOIN tbl_physicalexam AS p ON p.physical_exam_id = b.physicalExamID 
  JOIN tbl_systemreview AS s ON s.system_review_id = b.systemReviewID 
  JOIN tbl_users AS u ON u.userID = b.midwife_nurse
  JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id 
  LEFT JOIN tbl_complaints AS com ON com.patient_id = b.patient_id AND com.created_at = b.created_at
  WHERE b.birth_info_id = :birthInfoID";

$stmt = $con->prepare($query);
$stmt->bindParam(':birthInfoID', $complaintID, PDO::PARAM_INT);
$stmt->execute();
$patientData = $stmt->fetch(PDO::FETCH_ASSOC);





   




    if (!empty($patientData['OBSCORE'])) {
        $obscore = json_decode($patientData['OBSCORE'], true); // Decode JSON to associative array
    } else {
        $obscore = [
            'g' => '',
            'p' => '',
            'term' => '',
            'preterm' => '',
            'abortion' => '',
            'living' => ''
        ]; // Default empty values
    }
    if (!empty($patientData['past_med_history'])) {
        $past_med_history = json_decode($patientData['past_med_history'], true);
    } else {
        $past_med_history = [];
    }
    if (!empty($patientData['family_history'])) {
        $famHistory = json_decode($patientData['family_history'], true);
    } else {
        $famHistory = [];
    }

    if (!empty($patientData['ps_history'])) {
        $psHistory = json_decode($patientData['ps_history'], true);
    } else {
        $psHistory = [];
    }
    
    // Set default values for missing keys
    $psHistory = array_merge([
        'multiple' => '', // Default value if 'multiple' is missing
        'alcohol' => '',  // Default value if 'alcohol' is missing
        'smoking' => ''   // Default value if 'smoking' is missing
    ], $psHistory);

    $gyneHistory = [
        'menarche' => '',
        'regular' => '',
        'duration' => '',
        'days' => '',
        'remarks' => '',
        'flow' => [],
        'dysmenorrhea' => '',
        'first_sexual_contact' => ''
    ];

    // Decode the gyne_history JSON data (if it exists and is valid JSON)
    if (!empty($patientData['gyne_history'])) {
        $decodedHistory = json_decode($patientData['gyne_history'], true);

        // Ensure that $decodedHistory is an array before merging
        if (is_array($decodedHistory)) {
            $gyneHistory = array_merge($gyneHistory, $decodedHistory);
        }
    }

    // Initialize present_pregnancy data with defaults
    // Initialize present_pregnancy data with defaults
    $presentPregnancy = [
        'antepartal_care' => [],
        'start_visit' => '',
        'aog' => '',
        'tt' => '',
        'feso4' => '',
        'ogct' => '',
        'illness' => '',
        'tot_visit' => '',
        'others' => ''
    ];

    // Decode present_pregnancy JSON data (if it exists and is valid JSON)
    if (!empty($patientData['present_pregnancy'])) {
        $decodedPregnancy = json_decode($patientData['present_pregnancy'], true);

        // Ensure $decodedPregnancy is an array before merging
        if (is_array($decodedPregnancy)) {
            // Convert antepartal_care to an array if it's a string
            if (isset($decodedPregnancy['antepartal_care']) && !is_array($decodedPregnancy['antepartal_care'])) {
                $decodedPregnancy['antepartal_care'] = [$decodedPregnancy['antepartal_care']];
            }

            $presentPregnancy = array_merge($presentPregnancy, $decodedPregnancy);
        }
    }

    // Initialize obstetrical_history with defaults (empty arrays for each field)
    $obstetricalHistory = [
        'year' => [],
        'place_of_confinement' => [],
        'aog' => [],
        'bw' => [],
        'manner_of_delivery' => [],
        'complication_remarks' => []
    ];

    // Decode obstetrical_history from patient data (if it exists)
    if (!empty($patientData['obstetrical_history'])) {
        $decodedObstetricalHistory = json_decode($patientData['obstetrical_history'], true);

        // Ensure $decodedObstetricalHistory is an array before merging
        if (is_array($decodedObstetricalHistory)) {
            $obstetricalHistory = array_merge($obstetricalHistory, $decodedObstetricalHistory);
        }
    }

    // SYSTEM REVIEW
    if (!empty($patientData['general'])) {
        $general = json_decode($patientData['general'], true);
    } else {
        $general = [];
    }
    if (!empty($patientData['skin'])) {
        $skin = json_decode($patientData['skin'], true);
    } else {
        $skin = [];
    }
    if (!empty($patientData['head'])) {
        $head = json_decode($patientData['head'], true);
    } else {
        $head = [];
    }
    if (!empty($patientData['ears'])) {
        $ears = json_decode($patientData['ears'], true);
    } else {
        $ears = [];
    }
    if (!empty($patientData['eyes'])) {
        $eyes = json_decode($patientData['eyes'], true);
    } else {
        $eyes = [];
    }
    if (!empty($patientData['nose'])) {
        $nose = json_decode($patientData['nose'], true);
    } else {
        $nose = [];
    }
    if (!empty($patientData['throat'])) {
        $throat = json_decode($patientData['throat'], true);
    } else {
        $throat = [];
    }
    if (!empty($patientData['neck'])) {
        $neck = json_decode($patientData['neck'], true);
    } else {
        $neck = [];
    }
    if (!empty($patientData['breast'])) {
        $breast = json_decode($patientData['breast'], true);
    } else {
        $breast = [];
    }
    if (!empty($patientData['respiratory'])) {
        $respiratory = json_decode($patientData['respiratory'], true);
    } else {
        $respiratory = [];
    }
    if (!empty($patientData['cardiovascular'])) {
        $cardiovascular = json_decode($patientData['cardiovascular'], true);
    } else {
        $cardiovascular = [];
    }
    if (!empty($patientData['gastrointestinal'])) {
        $gastrointestinal = json_decode($patientData['gastrointestinal'], true);
    } else {
        $gastrointestinal = [];
    }
    if (!empty($patientData['urinary'])) {
        $urinary = json_decode($patientData['urinary'], true);
    } else {
        $urinary = [];
    }
    if (!empty($patientData['genitalia'])) {
        $genitalia = json_decode($patientData['genitalia'], true);
    } else {
        $genitalia = [];
    }
    if (!empty($patientData['vascular'])) {
        $vascular = json_decode($patientData['vascular'], true);
    } else {
        $vascular = [];
    }
    if (!empty($patientData['musculoskeletal'])) {
        $musculoskeletal = json_decode($patientData['musculoskeletal'], true);
    } else {
        $musculoskeletal = [];
    }
    if (!empty($patientData['neurologic1'])) {
        $neurologic1 = json_decode($patientData['neurologic1'], true);
    } else {
        $neurologic1 = [];
    }
    if (!empty($patientData['hematologic'])) {
        $hematologic = json_decode($patientData['hematologic'], true);
    } else {
        $hematologic = [];
    }
    if (!empty($patientData['endocrine'])) {
        $endocrine = json_decode($patientData['endocrine'], true);
    } else {
        $endocrine = [];
    }
    if (!empty($patientData['neurologic2'])) {
        $neurologic2 = json_decode($patientData['neurologic2'], true);
    } else {
        $neurologic2 = [];
    }

    // PHYSICAL REVIEW

    if (!empty($patientData['SKIN'])) {
        $SKIN = json_decode($patientData['SKIN'], true);
    } else {
        $SKIN = [];
    }

    $predefinedOptions = ['Rashes', 'Nodules', 'Pallor', 'Jaundice', 'Good skin turgor'];

    // Initialize the 'Other' value
    $otherValue = '';
    foreach ($SKIN as $key => $value) {
        // If the value is not part of the predefined options, treat it as 'Other'
        if (!in_array($value, $predefinedOptions)) {
            $otherValue = $value;
            break;
        }
    }

    if (!empty($patientData['heent'])) {
        $heent = json_decode($patientData['heent'], true);
    } else {
        $heent = [];
    }

    // Predefined options for HEENT
    $predefinedHeentOptions = [
        'anicteric sclerea',
        'Pupils briskly reactive to light',
        'Aural Discharge',
        'Intact Tympanic Membrane',
        'Alar Flaring',
        'Nasal Discharge',
        'Tonsillopharyngeal Congestion',
        'Hypertrohpic tonsils',
        'Palpable Mass',
        'Exudates'
    ];

    // Initialize the 'Other' field
    $otherHeent = '';
    foreach ($heent as $key => $value) {
        if (!in_array($value, $predefinedHeentOptions)) {
            $otherHeent = $value; // Set 'Other' value
            break;
        }
    }
    if (!empty($patientData['chest_lungs'])) {
        $chest_lungs = json_decode($patientData['chest_lungs'], true);
    } else {
        $chest_lungs = [];
    }

    // Predefined options for Chest/Lungs
    $predefinedChestOptions = ['symmtrical chest expansion', 'Clear Breath sounds', 'Retractions', 'Crackles', 'Wheezes'];

    // Initialize the 'Other' field
    $otherchest_lungs = '';
    foreach ($chest_lungs as $value) {
        // If the value is not part of the predefined options, treat it as 'Other'
        if (!in_array($value, $predefinedChestOptions)) {
            $otherchest_lungs = $value;
            break;
        }
    }


    if (!empty($patientData['CARDIOVASCULAR'])) {
        $cardiovascular = json_decode($patientData['CARDIOVASCULAR'], true);
    } else {
        $cardiovascular = [];
    }

    // Predefined options for Cardiovascular
    $cardiovascularOptions = ['Adynamic Precordlum', 'Normal rate regular rhythm', 'Heaves/thrills', 'Murmurs'];

    // Initialize the 'Other' field
    $othercardiovascular = '';
    foreach ($cardiovascular as $value) {
        // If the value is not part of the predefined options, treat it as 'Other'
        if (!in_array($value, $cardiovascularOptions)) {
            $othercardiovascular = $value;
            break; // Exit after finding the first "Other" value
        }
    }

    if (!empty($patientData['abdomen'])) {
        $abdomen = json_decode($patientData['abdomen'], true);
    } else {
        $abdomen = [];
    }

    // Predefined options for Cardiovascular
    $abdomenOptions = ['Flat', 'Globular', 'Flabby', 'Muscle Guarding', 'Tenderness', 'Palpable Mass'];

    // Initialize the 'Other' field
    $otherabdomen = '';
    foreach ($abdomen as $value) {
        // If the value is not part of the predefined options, treat it as 'Other'
        if (!in_array($value, $abdomenOptions)) {
            $otherabdomen = $value;
            break;
        }
    }
    if (!empty($patientData['extremities'])) {
        $extremities = json_decode($patientData['extremities'], true);
    } else {
        $extremities = [];
    }

    // Predefined options for Extremities
    $extremitiesOptions = ['Gross deformity', 'Normal gait', 'Full and equal pulses'];

    // Initialize the 'Other' field
    $otherextremities = '';
    foreach ($extremities as $value) {
        // If the value is not part of the predefined options, treat it as 'Other'
        if (!in_array($value, $extremitiesOptions)) {
            $otherextremities = $value;
            break; // Exit after finding the first 'Other' value
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <style>
        @media print {
            @page {
                size: 8.5in 13in;
                max-width: 100%;
            }
        }

        #print {
            width: 100%;
            height: 1200px;
            overflow: hidden;
            margin: auto;
            border: 2px solid #000;
        }

        .review-section {
            page-break-before: always;
            /* Forces a page break before this section */
            margin-top: 20px;
        }

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
            width: 5%;
        }

        .input-bottom-border-only {
            border: none;
            border-bottom: 1px solid black;
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
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
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
            font-size: 15px;
        }
        
    </style>
</head>

<body>

<button onclick="printContent('print')" style="float: right;">Print Content</button>
    
    <button onclick="window.history.back()" class="btn btn-primary" class="btn btn-primary ">Back</button>
    
    <br />
    <br />
    <div id="print" style="max-width:850px;">

        <div style="display: flex; justify-content: center; margin: 10px;">
            <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                <div style="text-align: center; margin-right: 20px;">
                    <img src="../logo/2.png" style="width: 90px; height: 70px;" alt="">
                </div>
                <div style="text-align: center;">
                    <label>LUTAYAN RHU BIRTHING CENTER</label><br>
                    <label>Brgy Tamnag, Lutayan, Sultan Kudarat</label><br>
                    <label>Tel. #: (083)-228-1528</label><br>
                    <label>Telefax No.: (083) 228-1528</label><br>

                </div>

            </div>
        </div>
        <div style="margin:10px;text-align: center; font-size:20px;margin-bottom:25px;">
            <label for="text"><b>LABOR ADMISSION CHART</b></label>
        </div>

        <div style="margin:10px;">
            <label class="form-label">PhilHealth No.:</label>
            <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['philhealth_no']); ?>" readonly>
            <br>
            <br>
            <label class="form-label">Patient Name:</label>
            <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['name']); ?>" readonly>
            <label class="form-label">Case No.:</label>
            <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['case_no']); ?>" readonly>
            <label class="form-label">Date:</label>
            <input class="form-input" type="text" value="<?php echo htmlspecialchars($patientData['date']); ?>" readonly>
        </div>
        <div style="text-align: left; flex: 1;margin:10px;margin-left:2rem;">
            <label class="form-label">LMP: <u><?php  ?></u></label>
            <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['LMP']); ?>">
            <label class="form-label">EDC: <?php ?></label>
            <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['EDC']); ?>">
            <label class="form-label">AOG: <?php ?></label>
            <input class="form-input1" type="text" value="<?php echo htmlspecialchars($patientData['AOG']); ?>">

            <label class="form-label">OB Score: <?php ?> </label>
            <label class="form-label">G <?php ?></label>
            <input class="form-input1" type="text" name="obscore[g]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">

            <label class="form-label">P</label>
            <input class="form-input1" type="text" name="obscore[p]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">

            <label class="form-label">(</label>
            <input class="form-input1" type="text" name="obscore[term]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">

            <label class="form-label">,</label>
            <input class="form-input1" type="text" name="obscore[preterm]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">

            <label class="form-label">,</label>
            <input class="form-input1" type="text" name="obscore[abortion]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">

            <label class="form-label">,</label>
            <input class="form-input1" type="text" name="obscore[living]" value="<?php echo htmlspecialchars($obscore['g']); ?>" style="width: 3%;">
            <label class="form-label">)</label>

            <label class="form-label">BLOOD TYPE: <?php ?></label>
            <input class="form-input1" type="text" style="width: 5%;" value="<?php echo htmlspecialchars($patientData['blood_type']); ?>">


        </div>
        <div style="margin:10px;">
            <label for="text">CHIEF COMPLAINT AND BRIEF HISTORY:</label>
            <input class="form-input" type="text" style="width: 5%;" value="<?php echo htmlspecialchars($patientData['chief_complaint']); ?>">

        </div>

        <div style="margin:10px;">
            <label><b>PAST MEDICAL HISTORY</b></label>
            <div class="checkbox-group mb-3">
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Heart Disease" <?php if (in_array('Heart Disease', $past_med_history)) echo 'checked'; ?>> Heart Disease</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Pulmonary TB" <?php if (in_array('Pulmonary TB', $past_med_history)) echo 'checked'; ?>> Pulmonary TB</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="HIV/AIDS" <?php if (in_array('HIV/AIDS', $past_med_history)) echo 'checked'; ?>> HIV/AIDS</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Syphilis" <?php if (in_array('Syphilis', $past_med_history)) echo 'checked'; ?>> Syphilis</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Gonorrhea" <?php if (in_array('Gonorrhea', $past_med_history)) echo 'checked'; ?>> Gonorrhea</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Other STI" <?php if (in_array('Other STI', $past_med_history)) echo 'checked'; ?>> Other STI</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Hypertension" <?php if (in_array('Hypertension', $past_med_history)) echo 'checked'; ?>> Hypertension</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Hepatitis" <?php if (in_array('Hepatitis', $past_med_history)) echo 'checked'; ?>> Hepatitis</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Asthma" <?php if (in_array('Asthma', $past_med_history)) echo 'checked'; ?>> Asthma</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Cancer" <?php if (in_array('Cancer', $past_med_history)) echo 'checked'; ?>> Cancer</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Torch Infection" <?php if (in_array('Torch Infection', $past_med_history)) echo 'checked'; ?>> Torch Infection</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Renal Disease" <?php if (in_array('Renal Disease', $past_med_history)) echo 'checked'; ?>> Renal Disease</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Thyroid D/O" <?php if (in_array('Thyroid D/O', $past_med_history)) echo 'checked'; ?>> Thyroid D/O</label>
                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="Seizure D/O" <?php if (in_array('Seizure D/O', $past_med_history)) echo 'checked'; ?>> Seizure D/O</label>

                <label> OTHERS
                    <input type="text" name="past_med_history[]" value="<?php echo isset($past_med_history['other']) ? htmlspecialchars($past_med_history['other']) : ''; ?>" class="form-check-label input-bottom-border-only">
                </label>

                <label><input type="checkbox" class="form-check-input" name="past_med_history[]" value="allergies" <?php if (in_array('allergies', $past_med_history)) echo 'checked'; ?>> Allergies</label>
            </div>

            <div style="text-align: left; flex: 1;">
                <label class="form-label">Past Operations: <u><?php  ?></u></label>
                <input class="form-input1" type="text" name="past_operations" value="<?php echo htmlspecialchars($patientData['past_operations']); ?>" style="width: 20%;">
                <label class="form-label">Medication:<?php ?></label>
                <input class="form-input1" type="text" name="Medication" value="<?php echo htmlspecialchars($patientData['medication']); ?>" style="width: 20%;">
                <label class="form-label">Past Admission: <?php ?></label>
                <input class="form-input1" type="text" name="PastAdmission" value="<?php echo htmlspecialchars($patientData['past_admission']); ?>" style="width: 20%;">

            </div>

            <br>

            <div class="section">
                <label><b>FAMILY HISTORY</b></label>
                <div class="checkbox-group">
                    <label><input class="form-check-input" type="checkbox" name="famHistory[]" id="family_heart_disease" value="Heart Disease" <?php if (in_array('Heart Disease', $famHistory)) echo 'checked'; ?>> Heart Disease</label>
                    <label><input class="form-check-input" type="checkbox" name="famHistory[]" id="family_hypertension" value="Hypertension" <?php if (in_array('Hypertension', $famHistory)) echo 'checked'; ?>> Hypertension</label>
                    <label><input class="form-check-input" type="checkbox" name="famHistory[]" id="family_diabetes" value="Diabetes" <?php if (in_array('Diabetes', $famHistory)) echo 'checked'; ?>> Diabetes</label>
                    <label><input class="form-check-input" type="checkbox" id="family_renal_disease" value="Renal Disease" <?php if (in_array('Renal Disease', $famHistory)) echo 'checked'; ?>> Renal Disease</label>
                    <label><input class="form-check-input" type="checkbox" name="famHistory[]" id="family_asthma" value="Asthma" <?php if (in_array('Asthma', $famHistory)) echo 'checked'; ?>> Asthma</label>
                    <label><input class="form-check-input" type="checkbox" id="family_multifetal_pregnancy" value="Multifetal Pregnancy" <?php if (in_array('Multifetal Pregnancy', $famHistory)) echo 'checked'; ?>> Multifetal Pregnancy</label>
                    <label><input class="form-check-input" type="checkbox" name="famHistory[]" id="family_cancer" value="Cancer" <?php if (in_array('Cancer', $famHistory)) echo 'checked'; ?>> Cancer</label>

                    <label> OTHERS
                        <input type="text" name="famHistory[]" id="otherSymptoms" value="<?php echo isset($famHistory['other']) ? htmlspecialchars($famHistory['other']) : ''; ?>" class="form-check-label input-bottom-border-only">
                    </label>
                </div>

            </div>

            <div class="section">
                <label> <b>P/S HISTORY</b></label>
                <div style="text-align: left; flex: 1;">
                    <label class="form-label">Educational Attainment: <u><?php  ?></u></label>
                    <input class="form-input1" type="text" style="width: 15%;" value="<?php echo htmlspecialchars($patientData['ed_at']) ; ?>" readonly>
                    <label class="form-label">Occupation:</label>

                    <input class="form-input1" type="text" style="width: 15%;" value="<?php echo htmlspecialchars($patientData['emp_stat']) ; ?>" readonly>
                    <label class="form-label">Civil Status: </label>
                    <input class="form-input1" type="text" style="width: 15%;" value="<?php echo htmlspecialchars($patientData['civil_status']) ; ?>" readonly>

                </div>
               

                <div class="checkbox-group">
                    <label>Multiple Sex Partners
                        <input class="form-check-input" type="checkbox" name="partner[multiple]" value="Yes" onclick="toggleCheckbox(this)" <?php if ($psHistory['multiple'] === 'Yes') echo 'checked'; ?>> Yes
                        <input class="form-check-input" type="checkbox" name="partner[multiple]" value="No" onclick="toggleCheckbox(this)" <?php if ($psHistory['multiple'] === 'No') echo 'checked'; ?>> No
                    </label>

                    <label>Alcohol Intake
                        <input class="form-check-input" type="checkbox" name="partner[alcohol]" value="Yes" onclick="toggleCheckbox(this)" <?php if ($psHistory['alcohol'] === 'Yes') echo 'checked'; ?>> Yes
                        <input class="form-check-input" type="checkbox" name="partner[alcohol]" value="No" onclick="toggleCheckbox(this)" <?php if ($psHistory['alcohol'] === 'No') echo 'checked'; ?>> No
                    </label>

                    <label>Smoking
                        <input class="form-check-input" type="checkbox" name="partner[smoking]" value="Yes" onclick="toggleCheckbox(this)" <?php if ($psHistory['smoking'] === 'Yes') echo 'checked'; ?>> Yes
                        <input class="form-check-input" type="checkbox" name="partner[smoking]" value="No" onclick="toggleCheckbox(this)" <?php if ($psHistory['smoking'] === 'No') echo 'checked'; ?>> No
                    </label>
                </div>

            </div>

            <div class="section">
                <label><b>GYNE HISTORY</b></label>
                <div style="text-align: left; flex: 1;">
                    <label class="form-label">Menarche:</label>
                    <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[menarche]" value="<?php echo htmlspecialchars($gyneHistory['menarche']); ?>">

                    <label>Regular?
                        <input type="checkbox" class="form-check-input" name="gyne_history[regular]" value="Yes" onclick="toggleCheckbox(this)" <?php if ($gyneHistory['regular'] === 'Yes') echo 'checked'; ?>> Yes
                        <input type="checkbox" class="form-check-input" name="gyne_history[regular]" value="No" onclick="toggleCheckbox(this)" <?php if ($gyneHistory['regular'] === 'No') echo 'checked'; ?>> No
                    </label>

                    <label style="margin-left: 3rem;" class="form-label">Duration:</label>
                    <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[duration]" value="<?php echo htmlspecialchars($gyneHistory['duration']); ?>">

                    <label class="form-label">Days:</label>
                    <input class="form-input1" type="text" style="width: 10%;" name="gyne_history[days]" value="<?php echo htmlspecialchars($gyneHistory['days']); ?>">

                    <label style="margin-left: 3rem;" class="form-label">Remarks:</label>
                    <input class="form-input1" type="text" style="width: 20%;" name="gyne_history[remarks]" value="<?php echo htmlspecialchars($gyneHistory['remarks']); ?>">
                </div>

                <br>

                <label class="form-label">Flow:
                    <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="scanty" onclick="toggleCheckbox(this)" <?php if (in_array('scanty', $gyneHistory['flow'])) echo 'checked'; ?>> Scanty
                    <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="moderate" onclick="toggleCheckbox(this)" <?php if (in_array('moderate', $gyneHistory['flow'])) echo 'checked'; ?>> Moderate
                    <input type="checkbox" class="form-check-input" name="gyne_history[flow][]" value="profuse" onclick="toggleCheckbox(this)" <?php if (in_array('profuse', $gyneHistory['flow'])) echo 'checked'; ?>> Profuse
                </label>

                <label style="margin-left: 3rem;">Dysmenorrhea?
                    <input type="checkbox" class="form-check-input" name="gyne_history[dysmenorrhea]" value="yes" onclick="toggleCheckbox(this)" <?php if ($gyneHistory['dysmenorrhea'] === 'yes') echo 'checked'; ?>> Yes
                    <input type="checkbox" class="form-check-input" name="gyne_history[dysmenorrhea]" value="no" onclick="toggleCheckbox(this)" <?php if ($gyneHistory['dysmenorrhea'] === 'no') echo 'checked'; ?>> No
                </label>

                <label class="form-label" style="margin-left: 3rem;">Age of First Sexual Contact:</label>
                <input class="form-input1" name="gyne_history[first_sexual_contact]" type="text" value="<?php echo htmlspecialchars($gyneHistory['first_sexual_contact']); ?>" style="width: 20%;">
            </div>


            <div class="section">
                <label><b>PRESENT PREGNANCY</b></label>

                <!-- Antepartal Care Checkboxes -->
                <label>Antepartal Care:</label>
                <label>
                    <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care][]" value="OPD" onclick="toggleCheckbox(this)" <?php if (in_array('OPD', $presentPregnancy['antepartal_care'])) echo 'checked'; ?>> OPD
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care][]" value="Health Center" onclick="toggleCheckbox(this)" <?php if (in_array('Health Center', $presentPregnancy['antepartal_care'])) echo 'checked'; ?>> Health Center
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care][]" value="Private MD" onclick="toggleCheckbox(this)" <?php if (in_array('Private MD', $presentPregnancy['antepartal_care'])) echo 'checked'; ?>> Private MD
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" name="present_pregnancy[antepartal_care][]" value="None" onclick="toggleCheckbox(this)" <?php if (in_array('None', $presentPregnancy['antepartal_care'])) echo 'checked'; ?>> None
                </label>

                <!-- Other Input Fields -->
                <label class="form-label" style="margin-left: 3rem;">Start of Visit:</label>
                <input class="form-input1" id="start_visit" name="present_pregnancy[start_visit]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['start_visit']); ?>">

                <label class="form-label">AOG:</label>
                <input class="form-input1" id="aog" name="present_pregnancy[aog]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['aog']); ?>">

                <label class="form-label" style="margin-left: 3rem;">TT:</label>
                <input class="form-input1" id="tt" name="present_pregnancy[tt]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['tt']); ?>">

                <!-- FeSO4 Checkboxes -->
                <label class="mt-2">FeSO4:</label>
                <input type="checkbox" class="form-check-input" name="present_pregnancy[feso4]" value="Yes" onclick="toggleCheckbox(this)" <?php if ($presentPregnancy['feso4'] === 'Yes') echo 'checked'; ?>> Yes
                <input class="form-check-input" type="checkbox" name="present_pregnancy[feso4]" value="No" onclick="toggleCheckbox(this)" <?php if ($presentPregnancy['feso4'] === 'No') echo 'checked'; ?>> No

                <!-- More Fields -->
                <label style="margin-left: 3rem;" class="form-label">50g OGCT:</label>
                <input class="form-input1" name="present_pregnancy[ogct]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['ogct']); ?>">

                <label class="form-label">Illness:</label>
                <input class="form-input1" name="present_pregnancy[illness]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['illness']); ?>">

                <label class="form-label">TOT Visit:</label>
                <input class="form-input1" name="present_pregnancy[tot_visit]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['tot_visit']); ?>">

                <label class="form-label">Others:</label>
                <input class="form-input1" name="present_pregnancy[others]" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($presentPregnancy['others']); ?>">
            </div>


            <div class="table-responsive">
                <label><b>OBSTETRICAL HISTORY</b></label>
                <table class="table table-bordered" border="1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Year</th>
                            <th>Place of Confinement</th>
                            <th>AOG</th>
                            <th>BW</th>
                            <th>Manner of Delivery</th>
                            <th>Complication / Remarks</th>

                        </tr>
                    </thead>
                    <tbody id="obstetrical-history-body">
                        <?php
                        // Check if there are any obstetrical history records
                        if (!empty($decodedObstetricalHistory)) {
                            $rowNumber = 1; // Start with row number 1
                            foreach ($decodedObstetricalHistory as $record) {
                        ?>
                                <tr>
                                    <td><?php echo $rowNumber++; ?></td>
                                    <td><?php echo htmlspecialchars($record['year']); ?></td>
                                    <td><?php echo htmlspecialchars($record['place_of_confinement']); ?></td>
                                    <td><?php echo htmlspecialchars($record['aog']); ?></td>
                                    <td><?php echo htmlspecialchars($record['bw']); ?></td>
                                    <td><?php echo htmlspecialchars($record['manner_of_delivery']); ?></td>
                                    <td><?php echo htmlspecialchars($record['complication_remarks']); ?></td>

                                </tr>
                        <?php
                            }
                        } else {
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <br>

            <div class="review-section">
                <div style="margin:10px;text-align: center; font-size:20px;margin-bottom:25px;">
                    <label style="text-align: center;"><b>REVIEW OF THE SYSTEM</b></label>
                </div>

                <div class="checkbox-container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px;">
                    <!-- Column 1 -->
                    <div class="column">

                        <div class="checkbox-group1">
                            <b>GENERAL:</b>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="weight_loss_gain"
                                    <?php echo in_array('weight_loss_gain', $general) ? 'checked' : ''; ?>>
                                Weight loss/gain
                            </label>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="trouble_sleeping"
                                    <?php echo in_array('trouble_sleeping', $general) ? 'checked' : ''; ?>>
                                Trouble sleeping
                            </label>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="hiv_aids"
                                    <?php echo in_array('hiv_aids', $general) ? 'checked' : ''; ?>>
                                HIV/AIDS
                            </label>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="weakness"
                                    <?php echo in_array('weakness', $general) ? 'checked' : ''; ?>>
                                Weakness
                            </label>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="fever_chills"
                                    <?php echo in_array('fever_chills', $general) ? 'checked' : ''; ?>>
                                Fever/Chills
                            </label>
                            <label>
                                <input type="checkbox" class="form-check-input" name="general[]" value="fatigue"
                                    <?php echo in_array('fatigue', $general) ? 'checked' : ''; ?>>
                                Fatigue
                            </label>
                        </div>
                        <div class="checkbox-group1">
                            <b>SKIN:</b>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="rashes" <?php echo in_array('rashes', $skin) ? 'checked' : ''; ?>> Rashes</label>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="lumps" <?php echo in_array('lumps', $skin) ? 'checked' : ''; ?>> Lumps</label>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="itching" <?php echo in_array('itching', $skin) ? 'checked' : ''; ?>> Itching</label>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="color_changes" <?php echo in_array('color_changes', $skin) ? 'checked' : ''; ?>> Color Changes</label>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="dryness" <?php echo in_array('dryness', $skin) ? 'checked' : ''; ?>> Dryness</label>
                            <label><input type="checkbox" class="form-check-input" name="skin[]" value="hair_nail_changes" <?php echo in_array('hair_nail_changes', $skin) ? 'checked' : ''; ?>> Hair and Nail Changes</label>
                        </div>
                        <div class="checkbox-group1">
                            <b>HEAD:</b>
                            <label><input type="checkbox" class="form-check-input" name="head[]" value="Headache" <?php echo in_array('Headache', $head) ? 'checked' : ''; ?>> Headache</label>
                            <label><input type="checkbox" class="form-check-input" name="head[]" value="Head Injury" <?php echo in_array('Head Injury', $head) ? 'checked' : ''; ?>> Head Injury</label>
                        </div>
                        <div class="checkbox-group1">
                            <b>EARS:</b>
                            <label><input type="checkbox" class="form-check-input" name="ears[]" value="Decrease hearing" <?php echo in_array('Decrease hearing', $ears) ? 'checked' : ''; ?>> Decrease hearing</label>
                            <label><input type="checkbox" class="form-check-input" name="ears[]" value="Tinnitus" <?php echo in_array('Tinnitus', $ears) ? 'checked' : ''; ?>> Tinnitus</label>
                            <label><input type="checkbox" class="form-check-input" name="ears[]" value="Earache" <?php echo in_array('Earache', $ears) ? 'checked' : ''; ?>> Earache</label>
                            <label><input type="checkbox" class="form-check-input" name="ears[]" value="Drainage" <?php echo in_array('Drainage', $ears) ? 'checked' : ''; ?>> Drainage</label>
                        </div>
                        <div class="checkbox-group1">
                            <b>EYES:</b>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Vision" <?php echo in_array('Vision', $eyes) ? 'checked' : ''; ?>> Vision</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Plain"><?php echo in_array('Plain', $eyes) ? 'checked' : ''; ?> Plain</label>


                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="column">
                        <div class="checkbox-group1">
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Blurry/Blurred Vision" <?php echo in_array('Blurry/Blurred Vision', $eyes) ? 'checked' : ''; ?>> Blurry/Blurred Vision</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Flashing Lights" <?php echo in_array('Flashing Lights', $eyes) ? 'checked' : ''; ?>> Flashing Lights</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Specks" <?php echo in_array('Specks', $eyes) ? 'checked' : ''; ?>> Specks</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Glasses/Contacts" <?php echo in_array('Glasses/Contacts', $eyes) ? 'checked' : ''; ?>> Glasses/Contacts</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Redness" <?php echo in_array('Redness', $eyes) ? 'checked' : ''; ?>> Redness</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Cataracts" <?php echo in_array('Cataracts', $eyes) ? 'checked' : ''; ?>> Cataracts</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Last Eye Exam" <?php echo in_array('Last Eye Exam', $eyes) ? 'checked' : ''; ?>> Last Eye Exam</label>
                            <label><input type="checkbox" class="form-check-input" name="eyes[]" value="Glaucoma" <?php echo in_array('Glaucoma', $eyes) ? 'checked' : ''; ?>> Glaucoma </label>

                            <b>NOSE:</b>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Stuffiness" <?php echo in_array('Stuffiness', $nose) ? 'checked' : ''; ?>> Stuffiness</label>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Nosebleed" <?php echo in_array('Nosebleed', $nose) ? 'checked' : ''; ?>> Nosebleed</label>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Discharge" <?php echo in_array('Discharge', $nose) ? 'checked' : ''; ?>> Discharge</label>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Sinus Pain" <?php echo in_array('Sinus Pain', $nose) ? 'checked' : ''; ?>> Sinus Pain</label>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="Itching" <?php echo in_array('Itching', $nose) ? 'checked' : ''; ?>> Itching</label>
                            <label><input type="checkbox" class="form-check-input" name="NOSE[]" value="High Fever" <?php echo in_array('High Fever', $nose) ? 'checked' : ''; ?>> High Fever</label>

                            <b>THROAT:</b>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Teeth" <?php echo in_array('Teeth', $throat) ? 'checked' : ''; ?>> Teeth</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Gums" <?php echo in_array('Gums', $throat) ? 'checked' : ''; ?>> Gums</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Bleeding" <?php echo in_array('Bleeding', $throat) ? 'checked' : ''; ?>> Bleeding</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Dentures" <?php echo in_array('Dentures', $throat) ? 'checked' : ''; ?>> Dentures</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Sore Tongue" <?php echo in_array('Sore Tongue', $throat) ? 'checked' : ''; ?>> Sore Tongue</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Hoarseness" <?php echo in_array('Hoarseness', $throat) ? 'checked' : ''; ?>> Hoarseness</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Thursh" <?php echo in_array('Thursh', $throat) ? 'checked' : ''; ?>> Thursh</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Non Healing Sores" <?php echo in_array('Non Healing Sores', $throat) ? 'checked' : ''; ?>> Non Healing Sores</label>
                            <label><input type="checkbox" class="form-check-input" name="THROAT[]" value="Last Dental Exam" <?php echo in_array('Last Dental Exam', $throat) ? 'checked' : ''; ?>> Last Dental Exam</label>
                        </div>
                    </div>

                    <!-- Column 3 -->
                    <div class="column">
                        <div class="checkbox-group1">
                            <b>NECK:</b>
                            <label><input type="checkbox" class="form-check-input" name="neck[]" value="Lumps" <?php echo in_array('Lumps', $neck) ? 'checked' : ''; ?>> Lumps</label>
                            <label><input type="checkbox" class="form-check-input" name="neck[]" value="Pain" <?php echo in_array('Pain', $neck) ? 'checked' : ''; ?>> Pain</label>
                            <label><input type="checkbox" class="form-check-input" name="neck[]" value="Swollen Glands" <?php echo in_array('Swollen Glands', $neck) ? 'checked' : ''; ?>> Swollen Glands</label>
                            <label><input type="checkbox" class="form-check-input" name="neck[]" value="Stiffness" <?php echo in_array('Stiffness', $neck) ? 'checked' : ''; ?>> Stiffness</label>

                            <b>BREAST:</b>
                            <label><input type="checkbox" class="form-check-input" name="breast[]" value="Lumps" <?php echo in_array('Lumps', $breast) ? 'checked' : ''; ?>> Lumps</label>
                            <label><input type="checkbox" class="form-check-input" name="breast[]" value="Breastfeeding" <?php echo in_array('Breastfeeding', $breast) ? 'checked' : ''; ?>> Breastfeeding</label>
                            <label><input type="checkbox" class="form-check-input" name="breast[]" value="Discharge" <?php echo in_array('Discharge', $breast) ? 'checked' : ''; ?>> Discharge</label>
                            <label><input type="checkbox" class="form-check-input" name="breast[]" value="Pain" <?php echo in_array('Pain', $breast) ? 'checked' : ''; ?>> Pain</label>
                            <b>RESPIRATORY:</b>
                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Cough" <?php echo in_array('Cough', $respiratory) ? 'checked' : ''; ?>> Cough</label>
                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Sputum" <?php echo in_array('Sputum', $respiratory) ? 'checked' : ''; ?>> Sputum</label>
                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Hemoptysis" <?php echo in_array('Hemoptysis', $respiratory) ? 'checked' : ''; ?>> Hemoptysis</label>
                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Dyspnea" <?php echo in_array('Dyspnea', $respiratory) ? 'checked' : ''; ?>> Dyspnea</label>

                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Wheezing" <?php echo in_array('Wheezing', $respiratory) ? 'checked' : ''; ?>> Wheezing</label>
                            <label><input type="checkbox" class="form-check-input" name="repiratory[]" value="Pain Breathing" <?php echo in_array('Pain Breathing', $respiratory) ? 'checked' : ''; ?>> Pain Breathing</label>

                            <b>CARDIOVASCULAR:</b>
                            <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Chest Pain/Discomfort" <?php echo in_array('Chest Pain/Discomfort', $cardiovascular) ? 'checked' : ''; ?>> Chest Pain/Discomfort</label>
                            <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Tightness" <?php echo in_array('Tightness', $cardiovascular) ? 'checked' : ''; ?>> Tightness</label>
                            <label><input type="checkbox" class="form-check-input" name="cardiovascular[]" value="Palpitations" <?php echo in_array('Palpitations', $cardiovascular) ? 'checked' : ''; ?>> Palpitations</label>
                            <b>GASTROINTESTINAL:</b>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Orthopnea" <?php echo in_array('Orthopnea', $gastrointestinal) ? 'checked' : ''; ?>> Orthopnea</label>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Paroxysmal Nocturnal Dyspnea" <?php echo in_array('Paroxysmal Nocturnal Dyspnea', $gastrointestinal) ? 'checked' : ''; ?>> Paroxysmal Nocturnal Dyspnea</label>


                        </div>
                    </div>

                    <!-- Column 4 -->
                    <div class="column">
                        <div class="checkbox-group1">
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Swallowing Difficulties" <?php echo in_array('Swallowing Difficulties', $gastrointestinal) ? 'checked' : ''; ?>> Swallowing Difficulties</label>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Change in Appetite" <?php echo in_array('Change in Appetite', $gastrointestinal) ? 'checked' : ''; ?>> Change in Appetite</label>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Swelling/Edema" <?php echo in_array('Swelling/Edema', $gastrointestinal) ? 'checked' : ''; ?>> Swelling/Edema</label>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Heartburn" <?php echo in_array('Heartburn', $gastrointestinal) ? 'checked' : ''; ?>> Heartburn</label>
                            <label><input type="checkbox" class="form-check-input" name="GASTROINTESTINAL[]" value="Nausea" <?php echo in_array('Nausea', $gastrointestinal) ? 'checked' : ''; ?>> Nausea</label>
                            <b>URINARY:</b>
                            <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Change in bowel Habits" <?php echo in_array('Change in bowel Habits', $urinary) ? 'checked' : ''; ?>> Change in bowel Habits</label>
                            <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Frequency" <?php echo in_array('Frequency', $urinary) ? 'checked' : ''; ?>> Frequency</label>
                            <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Urgency" <?php echo in_array('Urgency', $urinary) ? 'checked' : ''; ?>> Urgency</label>
                            <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Burning/Pain" <?php echo in_array('Burning/Pain', $urinary) ? 'checked' : ''; ?>> Burning/Pain</label>
                            <label><input type="checkbox" class="form-check-input" name="URINARY[]" value="Rectal Bleeding" <?php echo in_array('Rectal Bleeding', $urinary) ? 'checked' : ''; ?>> Rectal Bleeding</label>
                            <b>GENITALIA:</b>
                            <label><input type="checkbox" class="form-check-input" name="GENITALIA[]" value="Pain during intercourse" <?php echo in_array('Pain during intercourse', $genitalia) ? 'checked' : ''; ?>> Pain during intercourse</label>
                            <label><input type="checkbox" class="form-check-input" name="GENITALIA[]" value="Viginal dryness" <?php echo in_array('Viginal dryness', $genitalia) ? 'checked' : ''; ?>> Viginal dryness</label>
                            <b>VASCULAR:</b>
                            <label><input type="checkbox" class="form-check-input" name="VASCULAR[]" value="Calf pain when walking" <?php echo in_array('Calf pain when walking', $vascular) ? 'checked' : ''; ?>> Calf pain when walking</label>
                            <label><input type="checkbox" class="form-check-input" name="VASCULAR[]" value="Leg cramping" <?php echo in_array('Leg cramping', $vascular) ? 'checked' : ''; ?>> Leg cramping</label>
                            <b>MUSCULOSKELETAL:</b>
                            <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Muscle/Joint pain" <?php echo in_array('Muscle/Joint pain', $musculoskeletal) ? 'checked' : ''; ?>> Muscle/Joint pain</label>
                            <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Stiffness" <?php echo in_array('Stiffness', $musculoskeletal) ? 'checked' : ''; ?>> Stiffness</label>
                            <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Back pain" <?php echo in_array('Back pain', $musculoskeletal) ? 'checked' : ''; ?>> Back pain</label>
                            <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Trauma" <?php echo in_array('Trauma', $musculoskeletal) ? 'checked' : ''; ?>> Trauma</label>
                            <label><input type="checkbox" class="form-check-input" name="MUSCULOSKELETAL[]" value="Swelling of Joints" <?php echo in_array('Swelling of Joints', $musculoskeletal) ? 'checked' : ''; ?>> Swelling of Joints</label>

                        </div>
                    </div>

                    <!-- Column 5 -->
                    <div class="column">
                        <div class="checkbox-group1">
                            <b>NEUROLOGIC:</b>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Dizziness" <?php echo in_array('Dizziness', $neurologic1) ? 'checked' : ''; ?>> Dizziness</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Weakness" <?php echo in_array('Weakness', $neurologic1) ? 'checked' : ''; ?>> Weakness</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Tingling" <?php echo in_array('Tingling', $neurologic1) ? 'checked' : ''; ?>> Tingling</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Fainting" <?php echo in_array('Fainting', $neurologic1) ? 'checked' : ''; ?>> Fainting</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Tremor" <?php echo in_array('Tremor', $neurologic1) ? 'checked' : ''; ?>> Tremor</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Seizure" <?php echo in_array('Seizure', $neurologic1) ? 'checked' : ''; ?>> Seizure</label>
                            <label><input type="checkbox" class="form-check-input" name="NEUROLOGIC[]" value="Numbness" <?php echo in_array('Numbness', $neurologic1) ? 'checked' : ''; ?>> Numbness</label>
                            <b>HEMATOLOGIC:</b>
                            <label><input type="checkbox" class="form-check-input" name="HEMATOLOGIC[]" value="Easy Bruising" <?php echo in_array('Easy Bruising', $hematologic) ? 'checked' : ''; ?>> Easy Bruising</label>
                            <label><input type="checkbox" class="form-check-input" name="HEMATOLOGIC[]" value="Easy Bleeding" <?php echo in_array('Easy Bleeding', $hematologic) ? 'checked' : ''; ?>> Easy Bleeding</label>
                            <b>ENDOCRINE:</b>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Heat /Cold Intolerance" <?php echo in_array('Heat /Cold Intolerance', $endocrine) ? 'checked' : ''; ?>> Heat /Cold Intolerance</label>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Sweeting" <?php echo in_array('Sweeting', $endocrine) ? 'checked' : ''; ?>>Sweeting</label>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polydipsia" <?php echo in_array('Polydipsia', $endocrine) ? 'checked' : ''; ?>>Polydipsia</label>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polyuria" <?php echo in_array('Polyuria', $endocrine) ? 'checked' : ''; ?>>Polyuria</label>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Change in Appetite" <?php echo in_array('Change in Appetite', $endocrine) ? 'checked' : ''; ?>>Change in Appetite</label>
                            <label><input type="checkbox" class="form-check-input" name="ENDOCRINE[]" value="Polyphagia" <?php echo in_array('Polyphagia', $endocrine) ? 'checked' : ''; ?>>Polyphagia</label>
                            <b>NEOROLOGIC:</b>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Nerousness" <?php echo in_array('Nerousness', $neurologic2) ? 'checked' : ''; ?>>Nerousness</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Depression" <?php echo in_array('Depression', $neurologic2) ? 'checked' : ''; ?>>Depression</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Itching/Rash" <?php echo in_array('Itching/Rash', $neurologic2) ? 'checked' : ''; ?>>Itching/Rash</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Polyuria" <?php echo in_array('Polyuria', $neurologic2) ? 'checked' : ''; ?>>Polyuria</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Memory loss" <?php echo in_array('Memory loss', $neurologic2) ? 'checked' : ''; ?>>Memory loss</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Hot Flashes" <?php echo in_array('Hot Flashes', $neurologic2) ? 'checked' : ''; ?>>Hot Flashes</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="Stress" <?php echo in_array('Stress', $neurologic2) ? 'checked' : ''; ?>>Stress</label>
                            <label><input type="checkbox" class="form-check-input" name="NEOROLOGIC1[]" value="STD's" <?php echo in_array('STD\'s', $neurologic2) ? 'checked' : ''; ?>>STD's</label>
                        </div>
                        <div class="checkbox-group1">

                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="section">

                <label><b>PHYSICAL EXAMINATION</b></label>


                <div style="text-align: left; flex: 1;margin-left:5rem;">
                    <label class="form-label">BP: </label>
                    <input class="form-input1" type="text" style="width:10%" value="<?php echo htmlspecialchars($patientData['bp']); ?>" disabled>
                    <label class="form-label">PR: </label>
                    <input class="form-input1" type="text" style="width:10%" name="pr" value="<?php echo htmlspecialchars($patientData['pr']); ?>" required>
                    <label class="form-label">T: </label>
                    <input class="form-input1" type="text" style="width:10%" value="<?php echo htmlspecialchars($patientData['temp']); ?>" required>
                    <label class="form-label">WT: </label>
                    <input class="form-input1" type="text" style="width:10%" value="<?php echo htmlspecialchars($patientData['weight']); ?>" required>
                    <label class="form-label">HT: </label>
                    <input class="form-input1" type="text" style="width:10%" value="<?php echo htmlspecialchars($patientData['Height']); ?>" required>
                    <label class="form-label">FHT: </label>
                    <input class="form-input1" type="text" style="width:10%" name="FHT" value="<?php echo htmlspecialchars($patientData['fht']); ?>" required>

                </div>
                <div style="text-align: left; flex: 1;margin-left:5rem;">
                    <label class="form-label">FUNDIC HT: </label>
                    <input class="form-input1" type="text" name="fundig_ht" value="<?php echo htmlspecialchars($patientData['fundic_ht']); ?>" required>

                    <label class="form-label">DILATATION</label>
                    <input class="form-input1" type="text" name="dilatation" value="<?php echo htmlspecialchars($patientData['dilation']); ?>" required>

                    <label class="form-label">EFFACEMENT</label>
                    <input class="form-input1" type="text" name="effacement" value="<?php echo htmlspecialchars($patientData['effacement']); ?>" required>

                    <label class="form-label">BOW</label>
                    <input class="form-input1" type="text" name="bow" value="<?php echo htmlspecialchars($patientData['bow']); ?>" required>

                </div>
                <div style="text-align: left; flex: 1;margin-left:2rem;">
                    <label class="form-label">Leopold's Maneuver: </label>
                    <input class="form-input" style="width: 50%;" type="text" value="<?php echo htmlspecialchars($patientData['maneuver']); ?>" name="maneuver">

                </div>
                <br>
                <div style="text-align: left; flex: 1;margin-left:2rem;">
                    <label class="form-label">SKIN: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" <?php echo in_array('Rashes', $SKIN) ? 'checked' : ''; ?> value="Rashes"> Rashes</label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" <?php echo in_array('Nodules', $SKIN) ? 'checked' : ''; ?> value="Nodules"> Nodules </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" <?php echo in_array('Pallor', $SKIN) ? 'checked' : ''; ?> value="Pallor"> Pallor </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" <?php echo in_array('Jaundice', $SKIN) ? 'checked' : ''; ?> value="Jaundice"> Jaundice </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="SKIN[]" <?php echo in_array('Good skin turgor', $SKIN) ? 'checked' : ''; ?> value="Good skin turgor"> good skin turgor </label>
                    <br>

                    <input class="form-input" style="width: 50%; margin-left: 8rem;" name="SKIN[]" value="<?php echo isset($otherValue) ? $otherValue : ''; ?>" type="text">

                </div>


                <div style="text-align: left; flex: 1; margin-left: 2rem;">
                    <label class="form-label">HEENT:
                        <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" name="heent[]" value="anicteric sclerea" <?php echo in_array('anicteric sclerea', $heent) ? 'checked' : ''; ?>> anicteric sclera
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Pupils briskly reactive to light" <?php echo in_array('Pupils briskly reactive to light', $heent) ? 'checked' : ''; ?>> Pupils briskly reactive to light
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Aural Discharge" <?php echo in_array('Aural Discharge', $heent) ? 'checked' : ''; ?>> Aural Discharge
                    </label>
                    <br>
                    <label class="form-label" style="margin-left: 8rem;">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Intact Tympanic Membrane" <?php echo in_array('Intact Tympanic Membrane', $heent) ? 'checked' : ''; ?>> Intact Tympanic Membrane
                    </label>

                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Alar Flaring" <?php echo in_array('Alar Flaring', $heent) ? 'checked' : ''; ?>> Alar Flaring
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Nasal Discharge" <?php echo in_array('Nasal Discharge', $heent) ? 'checked' : ''; ?>> Nasal Discharge
                    </label>
                    <br>
                    <label class="form-label" style="margin-left: 8rem;">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Tonsillopharyngeal Congestion" <?php echo in_array('Tonsillopharyngeal Congestion', $heent) ? 'checked' : ''; ?>> Tonsillopharyngeal Congestion
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Hypertrohpic tonsils" <?php echo in_array('Hypertrohpic tonsils', $heent) ? 'checked' : ''; ?>> Hypertrohpic tonsils
                    </label>

                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Palpable Mass" <?php echo in_array('Palpable Mass', $heent) ? 'checked' : ''; ?>> Palpable Mass
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="heent[]" value="Exudates" <?php echo in_array('Exudates', $heent) ? 'checked' : ''; ?>> Exudates
                    </label>


                    <input class="form-input" style="width: 40%; margin-left: 8rem;" type="text" name="heent[]" value="<?php echo isset($otherHeent) ? $otherHeent : ''; ?>">

                </div>


                <div style="text-align: left; flex: 1;margin-left:2rem;">
                    <label class="form-label">CHEST/LUNGS: <input style="margin-left: 2rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="symmtrical chest expansion" <?php echo in_array('symmtrical chest expansion', $chest_lungs) ? 'checked' : ''; ?>> symmtrical chest expansion</label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Clear Breath sounds" <?php echo in_array('Clear Breath sounds', $chest_lungs) ? 'checked' : ''; ?>> Clear Breath sounds </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Retractions" <?php echo in_array('Retractions', $chest_lungs) ? 'checked' : ''; ?>> Retractions </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Crackles"><?php echo in_array('Crackles', $chest_lungs) ? 'checked' : ''; ?> Crackles </label><br>

                    <label class="form-label" style="margin-left: 8rem;"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="chest_lungs[]" value="Wheezes" <?php echo in_array('Wheezes', $chest_lungs) ? 'checked' : ''; ?>> Wheezes </label>
                    <input class="form-input" style="width: 50%;margin-left: 1rem;" type="text" name="chest_lungs[]" value="<?php echo isset($otherchest_lungs) ? $otherchest_lungs : ''; ?>">
                </div>

                <div style="text-align: left; flex: 1;margin-left:2rem;">
                    <label class="form-label">CARDIOVASCULAR: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Adynamic Precordlum" <?php echo in_array('Adynamic Precordlum', $cardiovascular) ? 'checked' : ''; ?>> Adynamic Precordlum</label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Normal rate regular rhythm" <?php echo in_array('Normal rate regular rhythm', $cardiovascular) ? 'checked' : ''; ?>> Normal rate regular rhythm </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Heaves/thrills" <?php echo in_array('Heaves/thrills', $cardiovascular) ? 'checked' : ''; ?>> Heaves/thrills </label>
                    <br />
                    <label class="form-label" style="margin-left: 8rem;"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="CARDIOVASCULAR[]" value="Murmurs" <?php echo in_array('Murmurs', $cardiovascular) ? 'checked' : ''; ?>> Murmurs </label>
                    <input class="form-input" style="width: 50%;margin-left: 1rem;" type="text" name="CARDIOVASCULAR[]" value="<?php echo isset($othercardiovascular) ? $othercardiovascular : ''; ?>">
                </div>

                <div style="text-align: left; flex: 1;margin-left:2rem;">
                    <label class="form-label">ABDOMEN: <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Flat" <?php echo in_array('Flat', $abdomen) ? 'checked' : ''; ?>> Flat</label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Globular" <?php echo in_array('Globular', $abdomen) ? 'checked' : ''; ?>> Globular</label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Flabby" <?php echo in_array('Flabby', $abdomen) ? 'checked' : ''; ?>> Flabby </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Muscle Guarding" <?php echo in_array('Muscle Guarding', $abdomen) ? 'checked' : ''; ?>> Muscle Guarding </label>
                    <label class="form-label"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Tenderness" <?php echo in_array('Tenderness', $abdomen) ? 'checked' : ''; ?>> Tenderness </label>
                    <br />
                    <label class="form-label" style="width: 50%;margin-left: 8rem;"> <input type="checkbox" class="form-check-input" id="menarche_regular_yes" name="ABDOMEN[]" value="Palpable Mass" <?php echo in_array('Wheezes', $abdomen) ? 'checked' : ''; ?>> Palpable Mass </label>
                    <input class="form-input" style="width: 50%;margin-left: 1rem;" type="text" name="ABDOMEN[]" value="<?php echo isset($otherabdomen) ? $otherabdomen : ''; ?>">
                </div>

                <div style="text-align: left; flex: 1; margin-left: 2rem;">
                    <label class="form-label">  EXTREMITIES:  <input style="margin-left: 5rem;" type="checkbox" class="form-check-input" name="EXTREMITIES[]" value="Gross deformity" <?php echo in_array('Gross deformity', $extremities) ? 'checked' : ''; ?>> Gross deformity  </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="EXTREMITIES[]" value="Normal gait" <?php echo in_array('Normal gait', $extremities) ? 'checked' : ''; ?>> Normal gait
                    </label>
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="EXTREMITIES[]" value="Full and equal pulses" <?php echo in_array('Full and equal pulses', $extremities) ? 'checked' : ''; ?>> Full and equal pulses
                    </label>
                    <br>

                    <input class="form-input" style="width: 50%; margin-left: 8rem;" name="EXTREMITIES[]" type="text" value="<?php echo isset($otherextremities) ? $otherextremities : ''; ?>" placeholder="Specify other">
                </div>

<br>
<br>
<br>

                <div style="margin:10px;text-align: right; margin-bottom:25px;">
                <input class="form-input" style="width: 25%;margin-left: 8rem;text-align:center"  value="<?php echo htmlspecialchars($patientData['nurse_name'])  ?>"  type="text"><br>
                <label for="text"><b>Midwife/Nurse On Duty</b></label>
            </div>

            </div>

            

        </div>


    </div>



    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

</html>