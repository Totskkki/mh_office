<?php
include './config/connection.php';

include './common_service/common_functions.php';

if (isset($_GET['id'])) {
    $patientID = $_GET['id'];
    $query = "SELECT pat.*, fam.*, c.*, r.referral_date,p.*,b.*,mem.*,page.*,page.sidebar,c.created_at,
          
          CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
          FROM tbl_patients AS pat
          LEFT JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
           LEFT JOIN tbl_membership_info AS mem ON mem.membershipID  = pat.Membership_Info 
          LEFT JOIN tbl_complaints AS c ON pat.patientID = c.patient_id AND c.created_at 
          LEFT JOIN tbl_prenatal AS p ON pat.patientID = p.patient_id
          LEFT JOIN tbl_birth_info AS b ON pat.patientID = b.patient_id
         
          LEFT JOIN tbl_referrals_log AS r ON pat.patientID = r.patient_id
          LEFT JOIN tbl_users as u on u.userID = pat.userID
          LEFT JOIN tbl_user_page AS page ON page.userpageID = u.userpageID
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
            width: 20%;
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
    <a href="referrals.php" class="btn btn-primary btn-sm mt-2 ml-2"> <i class="icon-chevron-left"></i> Back</a>
    <br />
    <br />
    <div id="print" style="max-width:850px;">
        <div style="display: flex; justify-content: space-between; margin: 10px;">
        <div class="logo left">
                <img src="<?php echo (!empty($patientData['home_img'])) ? './logo/' . $patientData['home_img'] : './logo/2.png'; ?>"  style="width: 140px;height:60px"alt="Left Logo">
            </div>
            <div style="text-align: center; flex: 1;">
                <h3>CLINICAL REFERRAL SLIP</h3>      
                <h3><?php echo htmlspecialchars($patientData['sidebar']); ?></h3><br>
            </div>
            <div class="logo right">
               
                <img src=" <?php echo (!empty($patientData['home_img'])) ? './logo/' . $patientData['home_img'] : './logo/2.png'; ?>"  style="width: 140px;height:60px" alt="Right Logo">
            </div>
        </div>
       
<br>

       

        <?php if (isset($patientData)) : ?>

       
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            
            <h5 class="form-label" for="text">CONTACT NO.: <u><?php echo htmlspecialchars($patientData['phone_number']); ?></u></h5>
            <h5 class="form-label" for="text">PHILHEALTH NO.: <u><?php echo htmlspecialchars($patientData['philhealth_no']); ?></u></h5>

        </div>
     


        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h5 class="form-label">Patient's Name: <u><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></u></h5>
            <h5 class="form-label">Age: <?php echo htmlspecialchars($patientData['age']); ?></h5>
            <h5 class="form-label">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></h5>
            <h5 class="form-label">Date: <?php echo htmlspecialchars($formattedDate); ?></h5>
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h5 class="form-label">Address: PUROK  <u><?php echo htmlspecialchars( $patientData['purok'])?></u>  <?php echo htmlspecialchars('Brgy. ' . $patientData['brgy'] . ' LUTAYAN, ' .strtoupper($patientData['province']) ); ?></h5>
            
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            
            <h5 class="form-label" for="text">REFERRED FROM: <u><?php echo htmlspecialchars('BHS ' .$patientData['sidebar']); ?></u></h5>
            <h5 class="form-label" for="text">REFERRED TO: <u>RHU Health Center</u></h5>

        </div>
        
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h6 class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;
                <span>BP:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['bp']); ?></u> mmhg</span>&nbsp;&nbsp;
                <span>WT:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['weight']); ?></u> </span>&nbsp;&nbsp;
                <span>TEMPT:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['temp']); ?></u> </span>&nbsp;&nbsp;
                <span>RR:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['rr']); ?></u> cpm </span>&nbsp;&nbsp;
                <span>PR:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['pr']); ?></u> bpm </span>&nbsp;&nbsp;
                <span>O2SAT:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['O2SAT']); ?></u> % </span>
                <span>HT:&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo htmlspecialchars($patientData['Height']); ?></u></span>&nbsp;&nbsp;
     
            </h6>

        </div>
        <div style="display: flex;  margin: 10px;">
            
            <h5 class="form-label" for="text">Date of Birth: <u><?php echo htmlspecialchars($patientData['date_of_birth']); ?></u></h5>
            <h5 class="form-label" for="text"style="margin-left:2rem">Place of Birth: <u><?php echo htmlspecialchars($patientData['place_of_birth']); ?></u></h5>




        </div>
        <div style="  margin: 10px;">
            <p><input style="width:90%" type="text" class="form-check-label input-bottom-border-only"></p>
        </div>
        <div style="  margin: 10px;">
            <p><input style="width:90%" type="text" class="form-check-label input-bottom-border-only"></p>
        </div>
        <div style="  margin: 10px;">
            <p><input style="width:90%" type="text" class="form-check-label input-bottom-border-only"></p>
        </div>
        
        <div style="  margin: 10px;">
            <p><input style="width:90%" type="text" class="form-check-label input-bottom-border-only"></p>
        </div>
        
        <div style="display: flex;  margin: 10px;">
            
            <h5 class="form-label" for="text">NOI: <input type="text" style="width:15%"class="form-check-label input-bottom-border-only"><span>POI:<input type="text" style="width:15%"class="form-check-label input-bottom-border-only"></span><span>TOI:<input type="text" style="width:15%"class="form-check-label input-bottom-border-only"></span><span>DOI:<input type="text" style="width:15%"class="form-check-label input-bottom-border-only"></span></h5>
           

        </div>

        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h5 class="form-label">REASON FOR REFERRAL: <u><?php echo htmlspecialchars(ucwords($patientData['reason_ref'])); ?></u></h5>

        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h5 class="form-label">ACTION TAKEN BY REFERRED LEVEL: <u><?php echo htmlspecialchars(ucwords($patientData['action_taken'])); ?></u></h5>
          
            

        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <u><h5 class="form-label">V/S taken and Recorded: <span><?php echo htmlspecialchars(ucwords($patientData['sidebar'])); ?> - <?php echo htmlspecialchars(ucwords($patientData['created_at'])); ?> </span></h5></u>
          
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <h5 class="form-label">INSTRUCTION TO REFERRAL LEVEL: <u><?php echo htmlspecialchars(ucwords($patientData['instruction_to'])); ?></u></h5>
          
            

        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <u><h5 class="form-label">Not included in close contact list: <span> <input style="width:100%" type="text" class="form-check-label input-bottom-border-only"></span></h5></u>
          
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <ul>
                <li class="form-label">Flu like symtoms:</li>
            </ul>
            
          
        </div>
        <div style="display: flex; justify-content: space-between; margin: 10px;">
            <u><h5 class="form-label">Not listed as suspect/probable/confirmed COVID-19 patient <span> <input type="text"style="width:100%" class="form-check-label input-bottom-border-only"></span></h5></u>
          
        </div>
        <br>
        <br>
       
        <div style="display: flex; justify-content: space-between; margin-left: 5rem;">
            <div style="text-align: left; flex: 1;">
                <label class="form-label">Signature:</label>
                <input type="text" class="form-check-label input-bottom-border-only">
                <label class="form-label">Signature:</label>
                <input type="text" class="form-check-label input-bottom-border-only">
            </div>

        </div>
        <div style="display: flex; justify-content: space-between; margin-left: 2rem;">
            <div style="text-align: left; flex: 1; margin-left: 2rem;">
                <label style="margin-left: 8rem;" class="form-label">Referring level</label>
              
                <label style="margin-left: 15rem;" class="form-label">Referring level</label>
                
            </div>

        </div>
        <br>






    <?php else : ?>
        <p>No patient details found.</p>
    <?php endif; ?>

    



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