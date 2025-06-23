<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';
if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    $query = "SELECT com.*, pat.*, fam.*, i.vaccine, COUNT(i.vaccine) AS vaccine_count,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as `address`,
              i.immunization_date, i.remarks
              FROM tbl_complaints AS com 
              JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
              JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_immunization_records AS i ON pat.patientID = i.patient_id
              WHERE com.complaintID = :complaintID
              GROUP BY pat.patientID, i.vaccine, i.immunization_date, i.remarks
              ORDER BY i.immunization_date DESC";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();

    $f = $stmt->fetch(PDO::FETCH_ASSOC);


    $immunizationQuery = "SELECT i.*, i.vaccine, COUNT(i.vaccine) AS vaccine_count, i.immunization_date, i.remarks
                          FROM tbl_immunization_records AS i
                          WHERE i.patient_id = :patientID
                          GROUP BY i.vaccine";

    $immunizationStmt = $con->prepare($immunizationQuery);
    $immunizationStmt->bindParam(':patientID', $f['patientID'], PDO::PARAM_INT);
    $immunizationStmt->execute();

    $immunizationRecords = $immunizationStmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Meta -->



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



<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> -->

<link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">





<head>



    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        body {
            /* font-family: 'Open Sans', sans-serif; */
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        .info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 10px;
        }

        .info div {
            display: flex;
            flex-direction: column;
        }

        .info label {
            margin-bottom: 5px;
            color: #555;
        }

        .info input[type="text"],
        .info input[type="date"] {
            padding: 8px;
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #ffcc00;
            color: #333;
            font-weight: 600;

        }

        table td {
            background-color: #fff;
        }

        table td input[type="date"],
        table td input[type="text"] {
            width: 100%;

            border: none;
            padding: 5px;
            box-sizing: border-box;
        }

        table td input[type="date"] {
            font-family: 'Open Sans', sans-serif;
        }
    </style>



</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">


        <!-- App container starts -->
        <div class="app-container">

        </div>
        <!-- App header ends -->

        <!-- App body starts -->
        <div class="app-body">

            <button onclick="window.history.back()" class="btn btn-primary"><i class="icon-chevron-left"></i>Back</button>



            <div class="container">
                <h1>Adult Immunization Record</h1>
                <div class="info">

                    <div>

                        <label>Name:</label>
                        <input type="text" name="child_name" value="<?php echo $f['name']; ?>" readonly>
                    </div>
                    <div>
                        <label>Date of birth:</label>
                        <input type="text" name="dob" value="<?php echo date('F j, Y', strtotime($f['date_of_birth'])); ?>" readonly>
                    </div>

                    <div>
                        <label>Address:</label>
                        <input type="text" name="address" value=" <?php echo $f['address']; ?>" readonly>
                    </div>

                    <div>
                        <label>Sex:</label>
                        <input type="text" name="sex" value="<?php echo $f['gender']; ?>" readonly>

                    </div>
                    <div>
                        <label>Barangay:</label>
                        <input type="text" name="barangay" value="<?php echo $f['brgy']; ?>" readonly>
                    </div>
                    <div>
                        <label>Family no.:</label>
                        <input type="text" name="family_no" value="<?php echo $f['household_no']; ?>" readonly>
                    </div>
                </div>
                <table class="immunization-table">


                    <thead>
                        <tr>

                            <th>Type of vaccine</th>
                            <th>Date given (y/m/d)</th>
                            <th>Date next dose due (y/m/d)</th>
                            <th>Remarks</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($immunizationRecords as $f) : ?>
                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($f['vaccine']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($f['immunization_date']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($f['immunization_next_date']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($f['remarks']); ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
           
            </div>
        </div>
    </div>





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











</body>



</html>