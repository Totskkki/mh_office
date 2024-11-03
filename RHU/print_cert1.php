<?php
include './config/connection.php';

if (isset($_GET['id'])) {
    $patientID = $_GET['id'];

    function getPatientDetails($con, $patient_id) {
        $query = "
        SELECT 
            pv.*, pmh.*, p.*, m.*, md.*, u.*, per.*, po.*, fam.*,
            CONCAT('Purok ', fam.purok, ', ','Barangay ', fam.brgy, ', ','Lutayan', fam.province) AS familyaddress,
            CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS doctors_name
        FROM tbl_patients AS p
        LEFT JOIN tbl_patient_visits AS pv ON pv.patient_id = p.patientID
        LEFT JOIN tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
        LEFT JOIN tbl_familyAddress AS fam ON fam.famID = p.family_address
        LEFT JOIN tbl_medicine_details AS md ON pmh.medicine_details_id = md.medicine_id
        LEFT JOIN tbl_medicines AS m ON md.medicine_id = m.medicineID
        LEFT JOIN tbl_users AS u ON u.userID = pv.doctor_id
        LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id 
        LEFT JOIN tbl_position AS po ON u.position_id = po.position_id 
        WHERE p.patientID = :patientID
        ORDER BY pv.patient_visitID DESC, pmh.patient_med_historyID DESC
        LIMIT 1;
    ";
    
        $stmt = $con->prepare($query);
        $stmt->bindParam(':patientID', $patient_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $patientDetails = getPatientDetails($con, $patientID);

    if ($patientDetails) {
        $patient_name = $patientDetails['patient_name'] . ' ' . $patientDetails['middle_name'] . ' ' . $patientDetails['last_name'];
        $patient_age = $patientDetails['age'];
        $patient_sex = $patientDetails['gender'];
        $patient_add = $patientDetails['familyaddress'];
        $exam_date = date('Y-m-d');
        if (!empty($patientDetails['disease'])) {
            $diagnosis = $patientDetails['disease'];
            $recommendations = $patientDetails['recom'];
        } else {
            // Set default values when no illness/diagnosis is available
            $diagnosis = "<i>This is to certify that the above named person at this clinic and was fund to be Apparantly healthy.</i>";
            $recommendations = "<i>PHYSICALLY FIT TO WORK.</i>";
        }

        $default_doctor_name = "WILJUN O. PANGARINTAO, MD, FPSMS";
        $default_license_no = "106268";

        $doctor_name = !empty($patientDetails['doctors_name']) ? $patientDetails['doctors_name'] : $default_doctor_name;
        $doctor_license = !empty($patientDetails['LicenseNo']) ? $patientDetails['LicenseNo'] : $default_license_no;
    } else {
        echo "No patient details found.";
        exit;
    }
} else {
    echo "No patient ID provided.";
    exit;
}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <?php include './config/site_css_links.php'; ?>

        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                box-sizing: border-box;
            }

            .certificate-container {
                max-width: 800px;
                margin: 0 auto;
                padding: 10px;
                border: 1px solid #000;
            }

            .header {
                text-align: right;

            }



            .content {
                margin-top: 20px;
            }

            .content p {
                margin: 20px 1;
                
            }

            .bold {
                font-weight: bold;
            }

            .underline {
                text-decoration: underline;
                margin-top: 40px;
                text-align: center;
            }

            .footer {
                margin-top: 50px;
                text-align: right;
            }

            .text-right {
                text-align: right;
            }
        </style>

    </head>

    <body>
        <button style="background-color: gray;color:white;" class="btn mt-2 mr-4 float-end" onclick="printContent('print')">Print Content</button>

        <!-- <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" type="button" onclick="window.print();">Print Content</button> -->
        <button onclick="window.history.back()" class="btn btn-primary">Back</button>

        <div class="certificate-container" id="print">
            <div style="display: flex; justify-content: space-between; margin: 10px;">

                <div style="text-align: right; flex: 1;">
                    <label>LUTAYAN RURAL HEALTH UNIT</label><br>
                    <label>Brgy. Tamnag Lutayan, Sultan Kudarat</label><br>
                    <label>Email: lutayan_rhu@yahoo.com.ph</label><br>
                    <label>Telefax No.: (083) 228-1528</label><br>
                </div>
            </div>
            <div class="logo">
                <img src="./logo/1.png" alt="Logo" style="vertical-align: middle; height: 50px; margin-right: 10px;">
            </div>
            <div class="clear-both">
                <hr />
            </div>


            <h4 style="margin-top: 0;margin-bottom:0">Office of the Municipal Health Officer</h4>

            <div class="clear-both">
                <hr />
            </div>
            <div class="content" style="margin-left: 1rem;">
                <h2 class="underline"><strong>MEDICAL CERTIFICATE</strong></h2>
                <p class="text-right">Date: <span class="underline"><?php echo $exam_date; ?></span></p><br>
                <p>To whom it may concern:</p>
                <p style="margin-left: 5rem;">This is to certify that Mr./Ms./Mrs. <span class="bold underline"><?php echo $patient_name; ?></span>&nbsp;&nbsp;&nbsp; Age <span class="underline"><b><?php echo $patient_age; ?></b></span>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;  Sex <span class="underline"><b><?php echo $patient_sex; ?></b></span></p>
                <p>of  <span class="bold underline"><?php echo $patient_add; ?></span> was seen and examined on <span class="underline"><?php echo $exam_date; ?></span></p>
                <p>DIAGNOSIS: <span class="bold underline"><?php echo ucwords($diagnosis) ; ?></span></p>
                <p>Recommendations: <span class="bold underline"><?php echo $recommendations; ?></span></p>
                <p style="margin-left: 5rem;">This certification is being issued upon the request of the above-named individual for whatever </p>
                <p> purpose may serve (excluding legal matters)</p>
            </div>

            <div class="footer">
                <p>Respectfully yours,</p>
                <br><br>
                <label><span class="bold underline"><?php echo $doctor_name; ?></span></label><br>
                <label>Municipal Health Officer</label><br>
                <label>License No.: <?php echo $doctor_license; ?></label>
            </div>
        </div>


    
        <script>
            function openPrintDialog() {
                alert("Please ensure you disable 'Headers and Footers' in the print settings dialog for best results.");
                window.print();
            }

            function printContent(el) {
                var inputElements = document.getElementById(el).querySelectorAll('input');
                inputElements.forEach(function(input) {
                    input.setAttribute('value', input.value);
                });

                var originalContents = document.body.innerHTML;
                var printContents = document.getElementById(el).innerHTML;

                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
    </body>

    </html>

    <?php

?>  