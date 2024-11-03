<?php

include './config/connection.php';




if (isset($_POST['submitdocnotes'])) {

    $patientid = trim($_POST['patientid']);
    $dates = $_POST['date'];  // Now it's an array
    $times = $_POST['time'];  // Now it's an array
    $doctors = $_POST['doctor'];  // Now it's an array
    $docnotes = $_POST['docnotes'];  // Now it's an array

    try {
        // Begin transaction
        $con->beginTransaction();

        // Loop through the arrays to insert multiple rows
        for ($i = 0; $i < count($dates); $i++) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $dates[$i]))); // Convert date format
            $time = $times[$i];
            $doctor = $doctors[$i];
            $docnote = $docnotes[$i];

            // Insert into tbl_healthnotes
            $stmt = $con->prepare("INSERT INTO `tbl_healthnotes`(`patient_id`, `userID`, `date`, `time`, `doctorNotes`)
                                   VALUES(:patient_id, :userID, :date, :time, :doctorNotes)");

            $stmt->execute([
                ':patient_id' => $patientid,
                ':userID' => $doctor,
                ':date' => $date,
                ':time' => $time,
                ':doctorNotes' => $docnote
            ]);
        }

        // Commit the transaction after all rows have been inserted
        $con->commit();

        // Set the session message after all rows are inserted
        $_SESSION['status'] = "Doctor's notes added successfully.";
        $_SESSION['status_code'] = "success";


        header('Location: birthing_patients.php?id=' . urlencode($patientid));
        exit();
    } catch (Exception $e) {
        // Rollback transaction in case of an error
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}
if (isset($_POST['save_birth'])) {


    $user = $_SESSION['user_id'];

    $date = $_POST['date'];
    $time = $_POST['time'];
    $chief_complaint = $_POST['chief_complaint'];
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
    $bp1 = $_POST['bp1'];
    $bp2 = $_POST['bp2'];
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
    $itr_no = $_POST['hidden_id'];
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

        $stmt = $con->prepare("INSERT INTO `tbl_birth_info` (`patient_id`, `date`, `time`, `history`, `lmp`, `edc`, `aog`, `G`, `P`, `1`, `2`, `3`, `4`, `bp1`, `bp2`, `pr`, `rr`, `T`, `fhb`, `loc`, `presentation`, `vaginal_discharge`, `midwife`, `physical_exam_id`,`userID`) VALUES (:patient_id, :date, :time, :history, :lmp, :edc, :aog, :G, :P, :1, :2, :3, :4, :bp1, :bp2, :pr, :rr, :T, :fhb, :loc, :presentation, :vaginal_discharge, :midwife, :physical_exam,:userid)");
        $stmt->execute([
            ':patient_id' => $itr_no,
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
            ':bp1' => $bp1,
            ':bp2' => $bp2,
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


        echo "<script> location.replace('records_birthing.php');</script>";
    } catch (Exception $e) {

        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

?>




<!-- 
<style>
        table {
            width: 75%;
            border-collapse: collapse;
            margin: 50px auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Enter Birthing Details</h2>
    <form action="process_birthing_details.php" method="post">
        <table>
            <tr>
                <th><label for="admission">Admission Date:</label></th>
                <td><input type="date" id="admission" name="admission" required></td>
                <th><label for="discharge">Discharge Date:</label></th>
                <td><input type="date" id="discharge" name="discharge" required></td>
                <th><label for="admitting_diagnosis">Admitting Diagnosis:</label></th>
                <td><input type="text" id="admitting_diagnosis" name="admitting_diagnosis" required></td>
            </tr>
            <tr>
                <th><label for="final_diagnosis">Final Diagnosis:</label></th>
                <td><input type="text" id="final_diagnosis" name="final_diagnosis" required></td>
                <th><label for="procedure_done">Procedure Done:</label></th>
                <td><input type="text" id="procedure_done" name="procedure_done" required></td>
                <th><label for="disposition">Disposition:</label></th>
                <td><input type="text" id="disposition" name="disposition" required></td>
            </tr>
            <tr>
                <th><label for="patient_id">Patient ID:</label></th>
                <td><input type="number" id="patient_id" name="patient_id" required></td>
                <th><label for="midwife">Midwife:</label></th>
                <td><input type="text" id="midwife" name="midwife" required></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="6"><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form> -->