<?php
include '../config/connection.php';

include '../common_service/common_functions.php';


if (isset($_GET['id'])) {
    $recordId = $_GET['id'];


    // Prepare and execute the SQL query to fetch the record
    $query = "SELECT b.*,p.*,v.room,
    CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name, 
    CONCAT(a.brgy, ' ', a.purok, ' ', a.province) AS address
  
    FROM tbl_birthing_medication b
    LEFT JOIN tbl_patients p ON p.patientID = b.patient_id
    LEFT JOIN tbl_familyAddress a ON a.famID = p.family_address
    LEFT JOIN tbl_vitalsigns_monitoring v on v.patient_id = b.patient_id
    WHERE b.medicationID  = :recordId";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the record
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        // Prepare and execute the SQL query to fetch all vital signs for the patient
        $MedicationQuery = "SELECT brithMeds.*,m.*,md.*,b.*,brithMeds.orderDate
        FROM tbl_birthing_medication brithMeds
       LEFT JOIN tbl_medicines m on m.medicineID  = brithMeds.medicineID
       LEFT JOIN tbl_medicine_details md on md.med_detailsID  = m.medicineID  
       LEFT JOIN tbl_birth_info b ON b.birth_info_id = brithMeds.birth_info_id
       WHERE brithMeds.patient_id = :patientId
       AND b.birthing_status = 'done'
        ORDER BY brithMeds.medicationID DESC";
     

        $stmtVitals = $con->prepare($MedicationQuery);
        $stmtVitals->bindParam(':patientId', $record['patientID'], PDO::PARAM_INT); 
        $stmtVitals->execute();

        $MedicationsData = $stmtVitals->fetchAll(PDO::FETCH_ASSOC);    
        
      
    } else {
        
        $record = 'No records Found';
    }
}

?>



<!DOCTYPE html>
<html lang="en">


<head>


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
    <link rel="stylesheet" href="../../assets/css/main.min.css" />

    <!-- <link rel="stylesheet" href="dist/js/jquery_confirm/jquery-confirm.css"> -->
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="../../assets/vendor/toastify/toastify.css" />
    <link rel="stylesheet" href="../../assets/vendor/daterange/daterange.css" />

    <link rel="stylesheet" href="../../assets/vendor/dropzone/dropzone.min.css" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="../../assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">




    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


    <style>
        .container {
            max-width: 70%;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .app-body {
            padding: 2rem 2rem;
            height: 100vh;
            overflow: auto;
            margin: 0 0 10px 0;
        }
    </style>




</head>


<body>


    <div class="page-wrapper">
        <div class="app-container">
            <div class="app-body">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="icon-chevron-left"></i>Back</button>
               
                <div class="container" id="print">

                <h4 class="text-center mb-3 "><b>MEDICATION SHEET</b></h4>
                    <div class="row">

                        <div class="col">
                            <h6><b>Name of Patient: </b><u><?php echo htmlspecialchars($record['name']); ?></u></h6>
                        </div>
                        <div class="col">
                            <h6><b>Age: </b><u><?php echo htmlspecialchars($record['age']); ?></u></h6>
                        </div>
                        
                        <div class="col">
                            <h6><b>Room: </b><u><?php echo htmlspecialchars($record['room']); ?></u></h6>
                        </div>

                    </div>


                    <table border="1">
                        <thead>

                            <tr>
                                <th>Date Ordered</th>
                                <th>Medicine & Dosage</th>
                                <th>Frequency</th>
                                <th>Time</th>
                                <th>Date & Signature</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                           
                        <?php foreach ($MedicationsData as $Medications): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($Medications['orderDate']); ?></td>
                                <td><?php echo htmlspecialchars($Medications['medicine_name']); ?> - <?php echo htmlspecialchars($Medications['dosage']); ?> </td>
                                <td><?php echo htmlspecialchars($Medications['Frequency']); ?></td>
                              
                                <td><?php echo htmlspecialchars(!empty($Medications['time']) ? date('h:i A', strtotime($Medications['time'])) : '') ;?></td>
                                <td><?php echo htmlspecialchars($Medications['date_signature']); ?> / <?php echo htmlspecialchars($Medications['signature']); ?></td>
                            
                            </tr>
                        <?php endforeach; ?>
                            
                        </tbody>


                    </table>

                    <table border="1">
                        <thead>
                            <tr>
                                <th>Stat Medication and Procedure</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td > <?php echo htmlspecialchars($Medications['medProcedure']); ?></td>
                            </tr>
                            <tr>
                                <th>Code: R-Refused </th>
                                <th>Specimen Signature</th>
                            
                            </tr>
                            <tr>
                            <td> 
                                DC - Discontinued  <br>
                                H - Hold  <br>
                                Rx - Prescribed <br>
                                NPO - Nothing by Mouth Including Meds.  <br>
                            </td>
                            <td><?php echo htmlspecialchars($Medications['Specimen']); ?></td>
                            </tr>
                            
                        </tbody>
                    </table>


                    <h5 class="float-end mt-5 italic-text"><i>LUTAYAN RHU BIRTHING CENTER</i></h5>






                </div>

            </div>

        </div>




</body>



</html>