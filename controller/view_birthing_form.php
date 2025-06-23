<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

// if (isset($_GET['id'])) {
//     $complaintID = $_GET['id'];

//     // Prepare a statement to select the patient, complaint, family, and checkup data
//     $query = "SELECT com.*, pat.*, fam.*, b.*,p.*,
//               CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
//               CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
//               FROM tbl_complaints AS com 
//               JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
//               JOIN tbl_family AS fam ON pat.family_address = fam.famID
//               LEFT JOIN tbl_birth_info AS b ON b.patient_id = pat.patientID
//               LEFT JOIN tbl_physical_exam AS p ON p.physical_exam_id = b.physical_exam_id 
//               WHERE com.complaintID = :complaintID";

//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
//     $stmt->execute();

//     $f = $stmt->fetch(PDO::FETCH_ASSOC);
// }
// $currentDate = date('Y-m-d');
// $oneYearAgoDate = date('Y-m-d', strtotime('-1 year'));
// if (isset($_GET['id'])) {
//     $complaintID = $_GET['id'];

//     // Prepare a statement to select the patient, complaint, family, and checkup data
//     $query = "SELECT com.*, pat.*, fam.*, b.*, p.*,
//               CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
//               CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) AS `address`
//               FROM tbl_complaints AS com 
//               JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
//               JOIN tbl_family AS fam ON pat.family_address = fam.famID
//               LEFT JOIN tbl_birth_info AS b ON b.patient_id = pat.patientID
//               LEFT JOIN tbl_physical_exam AS p ON p.physical_exam_id = b.physical_exam_id 
//               WHERE com.complaintID = :complaintID
//               AND com.date BETWEEN :oneYearAgoDate AND :currentDate
//               ";

// $stmt = $con->prepare($query);
// $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
// $stmt->bindParam(':oneYearAgoDate', $oneYearAgoDate, PDO::PARAM_STR);
// $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
// $stmt->execute();

//     $birthRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// Database connection code here (not shown)


// if (isset($_GET['id'])) {
//     $complaintID = $_GET['id'];

//     // Prepare a statement to select the patient, complaint, family, and checkup data
// $query = "SELECT com.*, pat.*, fam.*, b.*, p.*,
//           CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
//           CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) AS `address`
//           FROM tbl_complaints AS com 
//           JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
//           JOIN tbl_family AS fam ON pat.family_address = fam.famID
//           LEFT JOIN tbl_birth_info AS b ON b.patient_id = pat.patientID
//           LEFT JOIN tbl_physical_exam AS p ON p.physical_exam_id = b.physical_exam_id 
//           WHERE com.complaintID = :complaintID
//          ";

// $stmt = $con->prepare($query);
// $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);

// $stmt->execute();

//     $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];
    $query = "SELECT com.*, pat.*, fam.*, b.*, p.*,
            CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
            CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) AS `address`
            FROM tbl_complaints AS com 
            JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
            JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
            LEFT JOIN tbl_birth_info AS b ON b.patient_id = pat.patientID
            LEFT JOIN tbl_physical_exam AS p ON p.physical_exam_id = b.physical_exam_id 
            WHERE com.complaintID = :complaintID
            ";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);

    $stmt->execute();

    $f = $stmt->fetch(PDO::FETCH_ASSOC);


    $birthingQuery = "SELECT b.*, p.*
           
            FROM tbl_birth_info AS b
            LEFT JOIN tbl_physical_exam AS p ON p.physical_exam_id = b.physical_exam_id 
            WHERE b.patient_id = :patientID";

    $birthingStmt = $con->prepare($birthingQuery);
    $birthingStmt->bindParam(':patientID', $f['patientID'], PDO::PARAM_INT);
    $birthingStmt->execute();

    $birthingRecords = $birthingStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>




<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Meta -->



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



    <!-- <style>
        body {
            /* font-family: 'Open Sans', sans-serif; */
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            
        }

        

        .time {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .date-btn {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .date-btn:hover {
            background-color: #138496;
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

    </style> -->


    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 20px;
            width: 200px;
            text-align: center;
            cursor: pointer;
        }

        .time {
            font-size: 16px;
            color: #333;
            margin: 0;
        }

        .date-btn {
            background-color: #17a2b8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .date-btn:hover {
            background-color: #138496;
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
            border: 0px solid #ccc;
            border-radius: 5px;
        }

        .horizontal-records {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="app-container">
            <div class="app-body">
                <!-- <a href="../records_birthing.php" class="btn btn-primary">
                    <i class="icon-chevron-left"></i> Back
                </a> -->
                <button onclick="window.history.back()" class="btn btn-primary">Back</button>

                <div class="container">
                    <h1>Birthing Records</h1>
                    <div class="info">
                        <div>
                            <label>Name:</label>
                            <input type="text" name="Name" value="<?php echo $f['name']; ?>" readonly>
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

                    <hr />
                    <div class="horizontal-records">
                        <?php if (!empty($birthingRecords)) { ?>
                            <?php foreach ($birthingRecords as $index => $record) { ?>
                                <div class="card" onclick="showForm(<?php echo $index; ?>)">
                                    <p class="time">
                                        <?php echo date('g:i a', strtotime($record['time'])); ?>
                                    </p>
                                    <button class="date-btn">
                                        <?php echo date('M d', strtotime($record['date'])); ?>
                                    </button>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div>No birth records found.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="recordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body">
                <!-- Form content will be loaded here -->
            </div>
        </div>
    </div>




    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- 
<script src="dist/js/jquery_confirm/jquery-confirm.js"></script> -->

    <!-- Custom JS files -->
    <script src="../assets/js/custom.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="../assets/js/jquery-confirm.min.js"></script>

    <script src="../assets/js/common_javascript_functions.js"></script>
    <script src="../assets/moment/moment.min.js"></script>
    <script src="../assets/daterangepicker/daterangepicker.js"></script>
    <script src="../assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script>
        function showForm(index) {
            var record = <?php echo json_encode($birthingRecords); ?>;
            var recordDetails = record[index];
            var modalBody = document.getElementById('modal-body');
            if (modalBody) {
                modalBody.innerHTML = `
            <br />
            <center><label class="form-label">OB GYNE HISTORY</label><span style="float:right;"> ${recordDetails.date}</span></center>
                <hr style="border:1px solid #000;" />
                <div class="form-inline" style="border-right:1px solid #000; height:100%; width:30%; float:left;">
                    <label>LMP:</label> ${recordDetails.lmp}<br />
                    <label>EDC:</label> ${recordDetails.edc}<br />
                    <label>AOG:</label> ${recordDetails.aog}
                </div>
                <div class="form-inline" style="width:60%; margin-left:10px; margin-top:30px; float:left;">
                    <label>OB SCORE:</label> <label>G:</label> ${recordDetails.G} <label>P</label> ${recordDetails.P} <label>(</label>
                    ${recordDetails['1']}-${recordDetails['2']}-${recordDetails['3']}-${recordDetails['4']}<label>)</label>
                </div>
                <br style="clear:both;" />
                <hr style="border:1px solid #000;" />
                <center><label class="form-label">PHYSICAL EXAMINATION</label></center>
                <br>
                <div class="form-inline"><label>BP:</label> ${recordDetails.bp}<label>mmhg PR:</label> ${recordDetails.pr}<label>bpm RR:</label> ${recordDetails.rr}<label>cpm T:</label> ${recordDetails.T}<label>⁰C</label></div>
                <br />
                <div style="float:left; width:25%;" class="form-inline">
                    <label>HEAD & NECK:</label> ${recordDetails.head_neck}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>CHEST:</label> ${recordDetails.chest}
                </div>
                <div style="float:left; width:25%;" class="form-inline">
                    <label>HEART:</label> ${recordDetails.heart}
                </div>
                <br />
                <br style="clear:both;" />
                <div style="float:left; width:25%;" class="form-inline">
                    <label>ABDOMEN: UTERINE SIZE:</label> ${recordDetails.abdomen}<label>cm FHB:</label> ${recordDetails.fhb}<label>bpm LOC:</label> ${recordDetails.loc}
                </div>
                <div><label>EXTREMITIES:</label> ${recordDetails.extremities}</div>
                <br style="clear:both;" />
                <hr style="border:1px solid #000;" />
                <center><label class="form-label">INTERNAL EXAMINATION (IE)</label></center>
                <br />
                <div style="float:left; width:25%;" class="form-inline">
                    <label>VULVA:</label> ${recordDetails.vulva}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>VAGINA:</label> ${recordDetails.vagina}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>CERVIX:</label> ${recordDetails.cervix}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>UTERUS:</label> ${recordDetails.uterus}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>BOW:</label> ${recordDetails.bow}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>PRESENTATION:</label> ${recordDetails.presentation}
                </div>
                <div class="form-inline" style="float:left; width:25%;">
                    <label>VAGINAL DISCHARGE:</label> ${recordDetails.vaginal_discharge}
                </div>
                <br style="clear:both;" />
                <hr style="border:1px solid #000;" />
                <div class="form-inline">
                    <h4>STAFF ON DUTY: <span>${recordDetails.midwife}</span></h4>
                </div>
            `;
                var modal = document.getElementById('recordModal');
                if (modal) {
                    modal.style.display = 'block';
                } else {
                    console.error("Modal element not found.");
                }
            } else {
                console.error("Modal body element not found.");
            }
        }


        function closeModal() {
            var modal = document.getElementById('recordModal');
            if (modal) {
                modal.style.display = 'none';
            } else {
                console.error("Modal element not found.");
            }
        }


        window.onclick = function(event) {
            var modal = document.getElementById('recordModal');
            if (modal && event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>







    <!-- <script>
        function showForm() {
            var formSection = document.getElementById('form-section');
            formSection.style.display = 'block';
        }
    </script> -->


    <!-- 
    <script>
        function showForm(recordID) {
            var formSection = document.getElementById('form-section-' + recordID);
            var allForms = document.getElementsByClassName('form-section');
            for (var i = 0; i < allForms.length; i++) {
                allForms[i].style.display = 'none';
            }
            formSection.style.display = 'block';
        }

        function hideForm() {
            var allForms = document.getElementsByClassName('form-section');
            for (var i = 0; i < allForms.length; i++) {
                allForms[i].style.display = 'none';
            }
        }
    </script> -->





</body>



</html>