<?php
include './config/connection.php';

include './common_service/common_functions.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}

if (isset($_GET['id'])) {
    $patientID = $_GET['id'];
    $query = "SELECT pat.*, fam.*, c.*, p.*, b.*, r.referral_date,e.*,v.cr,
          CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
          FROM tbl_patients AS pat
          LEFT JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
          LEFT JOIN tbl_complaints AS c ON pat.patientID = c.patient_id
          LEFT JOIN tbl_prenatal AS p ON pat.patientID = p.patient_id
          LEFT JOIN tbl_birth_info AS b ON pat.patientID = b.patient_id
          LEFT JOIN tbl_physicalexam AS e ON e.physical_exam_id  = b.physicalExamID
          LEFT JOIN tbl_vitalsigns_monitoring AS v ON v.patient_id = b.patient_id
          LEFT JOIN tbl_referrals_log AS r ON pat.patientID = r.patient_id
          WHERE pat.patientID = :id";


    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $patientID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $patientData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($patientData['referral_date']) && !empty($patientData['referral_date'])) {
            $formattedDate = date('m/d/Y', strtotime($patientData['referral_date']));
        } else {
            $formattedDate = '';
        }
    } else {
        echo "<p>Error executing query: " . htmlspecialchars($stmt->errorInfo()[2]) . "</p>";
        exit;
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <?php include './config/site_css_links.php'; ?>
    <style>
        @media print {
            @page {
                size: 8.5in 13in;
                max-width: 8.5in;
            }
        }

        #print {
            width: 850px;
            height: 1100px;
            overflow: hidden;
            margin: auto;
            border: 2px solid #000;
        }

        .input-bottom-border {
            border: none;
            border-bottom: 1px solid black;
        }

        .input-bottom-border-only {
            border: none;
            border-bottom: 2px solid black;
            padding: 5px;
            width: 30%;

        }

        .input-bottom-border-only:focus {
            border-bottom: 2px solid red;
            outline: none;

        }

        .form-input {
            border: none;
            border-bottom: 1px solid black;
            width: 50%;
        }

        .form-input:focus {
            border-bottom: 2px solid red;
            outline: none;

        }

        .input-group .form-control {
            border: none;
            border-bottom: 1px solid black;
            border-right: 0;
        }

        .input-group .input-group-text {
            border: none;
        }

        .line-through {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            font-style: italic;
        }

        .line-through::before,
        .line-through::after {
            content: '';
            flex: 1;
            border-bottom: 3px dotted #000;
        }

        .line-through span {
            padding: 0 10px;
            background: #fff;
            /* Adjust background to match the container background */
        }
    </style>
     
</head>

<body>
    <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" onclick="printContent('print')">Print Content</button>

    <!-- <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" type="button" onclick="window.print();">Print Content</button> -->
    <!-- <a href="referrals.php" class="btn btn-primary btn-sm mt-2 ml-2"> <i class="icon-chevron-left"></i> Back</a> -->
    <button onclick="window.history.back()" class="btn btn-primary">Back</button>
    <br />
    <br />
    <div id="print" style="max-width:850px;">
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <div style="text-align: left; flex: 1;">
                <img src="logo/1.png" style="width: 200px;height:60px" alt="">

            </div>
            <div style="text-align: right; flex: 1;">
                <label>LUTAYAN RURAL HEALTH UNIT</label><br>
                <label>Brgy. Tamnag Lutayan, Sultan Kudarat</label><br>
                <label>Email: lutayan_rhu@yahoo.com.ph</label><br>
                <label>Telefax No.: (083) 228-1528</label><br>
            </div>
        </div>
    


        <center><label class="form-label mb-3">REFERRAL SLIP</label></center>



        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <div style="text-align: left; flex: 1;">
                <label class="form-label">To:</label>
                <input class="form-input" type="text" required>
            </div>
            <?php if (isset($patientData)) : ?>
                <label class="form-label">Date Referred:</label><br>
                <div style="text-align: right; flex: -9;">
                    <div class="form-group">

                        <div class="input-group date" id="date">
                            <input type="text" value="<?php echo htmlspecialchars($formattedDate); ?>" class="form-control form-control-sm rounded-0" readonly />

                        </div>
                    </div>


                </div>



        </div>
        <br>


        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <label class="form-label">Patient's Name: <u><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></u></label>
            <label class="form-label">Age: <?php echo htmlspecialchars($patientData['age']); ?></label>
            <label class="form-label">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></label>
            <label class="form-label">Weight: <?php echo htmlspecialchars($patientData['weight']); ?></label>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <label class="form-label">Address: <u> <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', ' . $patientData['province']); ?></u></label>
            <label class="form-label" for="abc1">Contact No.: <u><?php echo htmlspecialchars($patientData['phone_number']); ?></u></label>

        </div>
        <div style=" max-width:740px; margin-left:10rem; padding:10px; ">
            <label class="form-label">Chief Complaint: &nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['Chief_Complaint']); ?></u></label>

        </div>
        <div style=" max-width:740px; margin-left:10rem; padding:10px; ">
            <label class="form-label">Vital Signs:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>BP:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['bp']); ?></u> </span>&nbsp;&nbsp;
                <span>CR:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['cr']); ?></u> </span>&nbsp;&nbsp;
                <span>RR:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['rr']); ?></u> </span>&nbsp;&nbsp;
                <span>T:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['temp']); ?></u> </span>&nbsp;&nbsp;
            </label>

        </div>
        <div style=" max-width:740px; margin-left:10rem; padding:10px; ">
            <label class="form-label">OB GYNE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>LMP:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['LMP']); ?></u> </span>&nbsp;&nbsp;
                <span>EDC:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['EDC']); ?></u> </span>&nbsp;&nbsp;
                <span>AOG:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['AOG']); ?></u> </span>&nbsp;&nbsp;
                <span>Fundic Height:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['fundic_ht']); ?></u> </span>&nbsp;&nbsp;
                <br>
                <span style="margin-left: 100px;"></span>
                <span>FHT:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['fht']); ?></u> </span>&nbsp;&nbsp;
                <span>GP:&nbsp;&nbsp;&nbsp;&nbsp;<u></u> </span>&nbsp;&nbsp;
                <span>IE:&nbsp;&nbsp;&nbsp;&nbsp;<u></u> </span>&nbsp;&nbsp;
                <span>BOW:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['bow']); ?></u> </span>&nbsp;&nbsp;
            </label>

        </div>

        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <label class="form-label">Reason for referral: <u><?php echo htmlspecialchars(ucwords($patientData['reason_ref'])); ?></u></label>

        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <div style="text-align: left; flex: 1;">
                <label class="form-label">Action Taken:</label>
                <input class="form-input mb-5" required>
            </div>

        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <div style="text-align: left; flex: 1;">
                <label class="form-label">Referring Staff:</label>
                <input type="text" class="form-check-label input-bottom-border-only">
                <label class="form-label">Designation:</label>
                <input type="text" class="form-check-label input-bottom-border-only">
            </div>

        </div>
        <br>






    <?php else : ?>
        <p>No patient details found.</p>
    <?php endif; ?>
    <!-- <hr style="border: none; height: 0; border-top: 3px dotted #000; margin: 20px 0;" /> -->
    <div class="line-through">
        <span>Cut here</span>
    </div>

    <center><label class="form-label mb-3">REFERRAL SLIP</label></center>

    <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div style="text-align: left; flex: 1;">
            <label class="form-label">Name of Receiving Unit:</label>
            <input class="form-input" type="text" required>
        </div>
        <label class="form-label">Date:</label><br>
        <div style="text-align: right; flex: -9;">
            <div class="form-group">

                <div class="input-group date" id="date">
                    <input type="text" class="form-control form-control-sm rounded-0" />

                </div>
            </div>


        </div>

    </div>
    <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div style="text-align: left; flex: 1;">
            <label class="form-label">Complete Address:</label>
            <input class="form-input " required>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div style="text-align: left; flex: 1;">
            <label class="form-label">Name of Patient:</label>
            <input class="form-input " required>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div style="text-align: left; flex: 1;">
            <label class="form-label">Action Taken:</label>
            <input class="form-input mb-5 " required>
        </div>
    </div>
    <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div style="text-align: left; flex: 1;">
            <label class="form-label">Referring Staff:</label>
            <input type="text" class="form-check-label input-bottom-border-only">
            <label class="form-label">Designation:</label>
            <input type="text" class="form-check-label input-bottom-border-only">
        </div>
    </div>




    </div>
    </div>
    <?php include './config/site_js_links.php'; ?>
    <!-- <script src="assets/moment/moment.min.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
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

    

</html>