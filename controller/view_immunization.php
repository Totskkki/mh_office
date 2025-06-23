<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';
if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    $query = "SELECT com.*, pat.*, fam.*,i.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as `address`,
              i.vaccine, COUNT(i.vaccine) AS vaccine_count
              FROM tbl_complaints AS com 
              JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
              JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN 
              tbl_immunization_records AS i ON pat.patientID = i.patient_id
              WHERE com.complaintID = :complaintID
              GROUP BY 
              pat.patientID, i.vaccine";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();


    $f = $stmt->fetch(PDO::FETCH_ASSOC);

    $immunizationQuery = "SELECT i.vaccine, COUNT(i.vaccine) AS vaccine_count, i.immunization_date, i.remarks
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


<link rel="shortcut icon" href="../assets/images/favicon.svg" />


<link rel="canonical" href="https://www.bootstrap.gallery/">

<link rel="shortcut icon" href="../assets/images/favicon.svg" />

<!-- *************
			************ CSS Files *************
		************* -->
<!-- Icomoon Font Icons css -->
<link rel="stylesheet" href="../assets/fonts/icomoon/style.css" />
<link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">




<!-- Main CSS -->
<link rel="stylesheet" href="../assets/css/main.min.css" />

<!-- <link rel="stylesheet" href="dist/js/jquery_confirm/jquery-confirm.css"> -->
<!-- Scrollbar CSS -->
<link rel="stylesheet" href="../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

<!-- Toastify CSS -->
<link rel="stylesheet" href="../assets/vendor/toastify/toastify.css" />
<link rel="stylesheet" href="../assets/vendor/daterange/daterange.css" />

<link rel="stylesheet" href="../assets/vendor/dropzone/dropzone.min.css" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="../assets/daterangepicker/daterangepicker.css">

<link rel="stylesheet" href="../assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="../assets/js/jquery-confirm.min.css">





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

            <!-- <a href="../records_vaccination.php" class="btn btn-primary">
                <i class="icon-chevron-left"></i> Back</i>
            </a> -->
            <button onclick="window.history.back()" class="btn btn-primary">Back</button>


            <div class="container">
                <h1>Child Immunization Record</h1>
                <div class="info">

                    <div>
                        <label>Child's name:</label>
                        <input type="text" name="child_name" value="<?php echo $f['name']; ?>">
                    </div>
                    <div>
                        <label>Date of birth:</label>
                        <input type="text" name="dob" value="<?php echo date('F j, Y', strtotime($f['date_of_birth'])); ?>">
                    </div>

                    <div>
                        <label>Address:</label>
                        <input type="text" name="address" value=" <?php echo $f['address']; ?>">
                    </div>
                    <div>
                        <label>Mother's name:</label>
                        <input type="text" name="mother_name" value=" <?php echo $f['mother_name']; ?>">
                    </div>
                    <div>
                        <label>Father's name:</label>
                        <input type="text" name="father_name" value=" <?php echo $f['father_guardian_name']; ?>">
                    </div>
                    <div>
                        <label>Birth height:</label>
                        <input type="text" name="birth_height" value="<?php echo $f['Height']; ?>">
                    </div>
                    <div>
                        <label>Birth weight:</label>
                        <input type="text" name="birth_weight" value="<?php echo $f['weight']; ?>">
                    </div>
                    <div>
                        <label>Sex:</label>
                        <input type="text" name="sex" value="<?php echo $f['gender']; ?>">

                    </div>
                    <div>
                        <label>Barangay:</label>
                        <input type="text" name="barangay" value="<?php echo $f['brgy']; ?>">
                    </div>
                    <div>
                        <label>Family no.:</label>
                        <input type="text" name="family_no" value="<?php echo $f['household_no']; ?>">
                    </div>
                </div>

                <table>
                    <thead>


                        <tr>
                            <th width="30%">Bakuna</th>
                            <th width="20%">Doses</th>
                            <th width="10%">Petsa ng bakuna (MM/DD/YY)</th>
                            <th width="20%">Remarks</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>


                        <tr>
                            <td>
                                <input type="text" value="
                                <?php

                                if ($f['vaccine'] == 'Hepatitis B Vaccine') {
                                    echo 'Hepatitis B Vaccine';
                                } else {
                                }


                                ?>">
                            </td>
                            <td>
                                <?php
                                if ($f['vaccine'] == 'Hepatitis B Vaccine') {
                                    echo htmlspecialchars($f['vaccine_count'] . "At birth");
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                            <td>
                                <input type="text" value="<?php echo htmlspecialchars($f['immunization_date']); ?>">
                            </td>
                            <td>
                                <input type="text" value="<?php echo htmlspecialchars($f['remarks']); ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="text" value="
                                <?php

                                if ($f['vaccine'] == 'Bgc Vaccine') {
                                    echo 'Bgc Vaccine';
                                } else {
                                }


                                ?>">
                            </td>
                            <td>
                                <?php
                                if ($f['vaccine'] == 'Bgc Vaccine') {
                                    echo htmlspecialchars($f['vaccine_count'] . "At birth");
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>
                            <td>
                                <input type="text" value="<?php echo htmlspecialchars($f['immunization_date']); ?>">
                            </td>
                            <td>
                                <input type="text" value="<?php echo htmlspecialchars($f['remarks']); ?>">
                            </td>

                        </tr>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>3</td>
                            <td>
                                <input type="text" name="pentavalent_date1">

                            </td>
                            <td><input type="text" name="pentavalent_remarks"></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>3</td>
                            <td>
                                <input type="text" name="opv_date1">

                            </td>
                            <td><input type="text" name="opv_remarks"></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>2</td>
                            <td>
                                <input type="text" name="ipv_date1">

                            </td>
                            <td><input type="text" name="ipv_remarks"></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>3</td>
                            <td>
                                <input type="text" name="pcv_date1">

                            </td>
                            <td><input type="text" name="pcv_remarks"></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>2</td>
                            <td>
                                <input type="text" name="mmr_date1">

                            </td>
                            <td><input type="text" name="mmr_remarks"></td>
                        </tr>
                    </tbody>

                </table>

            </div>

            <!-- Container ends -->

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

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->




    <!-- <script src="../assets/js/jquery.min.js"></script> -->
    <!-- <script src="../assets/js/bootstrap.bundle.min.js"></script> -->

    <!-- 
<script src="dist/js/jquery_confirm/jquery-confirm.js"></script> -->

    <!-- Custom JS files -->
    <!-- <script src="../assets/js/custom.js"></script> -->


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->


    <!-- <script src="../assets/js/jquery-confirm.min.js"></script>

	<script src="../assets/js/common_javascript_functions.js"></script>
	<script src="../assets/moment/moment.min.js"></script>
	<script src="../assets/daterangepicker/daterangepicker.js"></script>
	<script src="../assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->








</body>



</html>