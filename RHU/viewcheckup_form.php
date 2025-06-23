<?php
include '../config/connection.php';

include '../common_service/common_functions.php';


if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Prepare a statement to select the patient, complaint, family, and checkup data
    $query = "SELECT com.*, pat.*, fam.*, checkup.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
              FROM tbl_complaints AS com 
              JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
              JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_checkup AS checkup ON checkup.patient_id = pat.patientID
              WHERE com.complaintID = :complaintID";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();

    $f = $stmt->fetch(PDO::FETCH_ASSOC);
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
    </style>
</head>

<body>

    <!-- <button style="background-color: gray;color:white;" class="btn btn-sm mt-2 mr-4 float-end" onclick="printContent('print')">Print Content</button> -->
    <a href="checkup_record.php" class="btn btn-primary btn-sm mt-2 ml-2"> <i class="icon-chevron-left"></i> Back</a>
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
        
        <div style="border-bottom:1px solid #000; width:100%; max-width:735px; margin-left:15px; padding:10px; ">

        </div>
        <center><label class="form-label">PATIENT DATA</label></center>

        <div style="width:100%; margin-left:5px; max-width:800px; margin-right:5px;">
            <div style="float:left; margin-left:10px; width:35%; border-top:1px solid #000; border-bottom:1px solid #000; padding:10px; height:100%;">
                <label>Name</label>
                <br />
                <label style="margin-left:15px;">
                    <?php
                    if (($f['patient_name'] == "")  && ($f['middle_name'] == "" && ($f['last_name'] == ""))) {
                        echo " ";
                    } else {
                        echo $f['patient_name'] . " " . $f['middle_name'] . " " . $f['last_name'];
                    }
                    ?></label>
            </div>
            <div style="float:left; width:5%; height:100%; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; padding:10px;">
                <label>Age:</label>
                <br />
                <label><?php
                        if ($f['age'] == "") {
                            echo "<br />";
                        } else {
                            echo $f['age'];
                        }
                        ?></label>
            </div>
            <div style="float:left; width:10%; height:100%; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; padding:10px;">
                <label>Sex:</label>
                <br />
                <label>
                    <?php
                    if ($f['gender'] == "") {
                        echo "<br />";
                    } else {
                        echo $f['gender'];
                    }
                    ?></label>
            </div>
            <div style="float:left; width:15%; height:100%; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; padding:10px;">
                <label>Civil Status:</label>
                <br />
                <label>
                    <?php
                    if ($f['civil_status'] == "") {
                        echo "<br />";
                    } else {
                        echo $f['civil_status'];
                    }
                    ?></label>
            </div>
            <div style="float:left; width:27%; height:100%; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; padding:10px;">
                <label>Date of Birth:</label>
                <br />
                <label>
                    <?php
                    if ($f['date_of_birth'] == "") {
                        echo "<br />";
                    } else {
                        echo $f['date_of_birth'];
                    }
                    ?></label>
            </div>
            <br style="clear:both;" />


            <!-- <br style="clear:both;" /> -->
            <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; padding:10px; ">
                <label>Address:</label>

                <label>
                    <?php
                    if ($f['address'] == "") {
                        echo "<br />";
                    } else {
                        echo $f['address'];
                    }
                    ?></label>
            </div>
            <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; padding:10px; ">

                <label>Date and Time Admitted:</label>

                <label>
                    <?php
                    if ($f['admitted'] == "") {
                        echo "<br />";
                    } else {
                        // Convert the date and time from 24-hour to 12-hour format with AM/PM
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $f['admitted']);
                        echo $date->format('Y-m-d h:i A'); 
                    }
                    ?></label>
            </div>
            <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; padding:10px; ">
                <label><b>1. History of Present Illness:</b></label>

                <label>
                    <?php
                    if ($f['history'] == "") {
                        echo "<br />";
                    } else {
                        echo $f['history'];
                    }
                    ?></label>
            </div>
            <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; padding:10px; ">
                <label><b>2.a. Pertinent Past Medical History:</b></label>

                <label><?php echo $f['per_pas_med'] ?></label>
            </div>

        </div>
        <!-- <br style="clear:both;" /> -->
        <div class="col-12" style="margin-left: 10px;">
            <div class="mb-3">
                <label for="text" class="form-label">2.b. OB/GYN History</label>
                <div class="d-flex align-items-center">
                    <label for="g" class="mr-1">G:</label>
                    <input type="text" id="g" name="g" value="" size="2" mr-2" class="input-bottom-border" />

                    <label for="p" class="mr-1">P:</label>
                    <input type="text" id="p" name="p" value="" size="2" mr-2" class="input-bottom-border" />

                    <label class="mr-1">(</label>
                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                    <label>-</label>
                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                    <label>-</label>
                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                    <label>-</label>
                    <input type="text" size="2" mr-1" class="input-bottom-border" />
                    <label>)</label>
                    <label for="g" class="mr-1">LMP:</label>
                    <input type="text" id="g" name="g" value="" size="2" mr-2" class="input-bottom-border" />
                </div>

            </div>
        </div>
        <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; ">

        </div>
        <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; ">
            <label><b>3. Pertinent Signs and Syntoms on Admission</b></label>

            <br>
            <label><?php 
            if (!empty($f['pertinent_signs'])) {           
                $gen_survey = json_decode($f['pertinent_signs']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '<br>';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }
            ?></label> <label></label>
        </div>

        <div style="border-bottom:1px solid #000; width:95%; max-width:740px; margin-left:10px; ">
            <label><b>4. Physical Examination on Admission</b></label>

            <br>
            <label><b>General Survey:</b>&nbsp;&nbsp; <?php echo $f['gen_survey']; ?></label><br>
            <label><b>Vital Signs:</b> &nbsp;&nbsp;<span>BP:<?php echo $f['bp']; ?></span>
            &nbsp;&nbsp;<span>HR:<?php echo $f['hr']; ?></span>
            &nbsp;&nbsp;<span>RR:<?php echo $f['rr']; ?></span>
            &nbsp;&nbsp;<span>TEMP:<?php echo $f['temp']; ?></span>
                      
                    </label><br>
            <label><b>HEENT: </b>&nbsp;&nbsp;<?php  
             if (!empty($f['heent'])) {           
                $gen_survey = json_decode($f['heent']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }
            ?></label><br>
            <label><b>CHEST/LUNGS:</b>&nbsp;&nbsp; <?php 
            if (!empty($f['chest'])) {           
                $gen_survey = json_decode($f['chest']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }
            ?></label><br>
            <label><b>CSV:</b>&nbsp;&nbsp;<?php  
            
            if (!empty($f['CSV'])) {           
                $gen_survey = json_decode($f['CSV']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }?></label><br>
            <label><b>ABDOMEN:</b>&nbsp;&nbsp;<?php  
            if (!empty($f['abdomen'])) {           
                $gen_survey = json_decode($f['abdomen']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }?></label><br>
            <label><b>GU /(IE):</b>&nbsp;&nbsp;<?php 
            if (!empty($f['GU'])) {           
                $gen_survey = json_decode($f['GU']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }?></label><br>
            <label><b>SKIN/EXTREMITIES:</b>&nbsp;&nbsp;<?php 
             if (!empty($f['skin_extremeties'])) {           
                $gen_survey = json_decode($f['skin_extremeties']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            } ?></label><br>
            <label><b>NEURO-EXAM:</b>&nbsp;&nbsp;<?php
             if (!empty($f['neuro_exam'])) {           
                $gen_survey = json_decode($f['neuro_exam']);        
                if (is_array($gen_survey)) {
                    
                    foreach ($gen_survey as $item) {
                        echo htmlspecialchars($item) . '  ';
                    }
                } else {
                    echo 'Error decoding JSON.';
                }
           
            }?></label><br>
            <br>
            <label><b>DISABILITY:</b>&nbsp;&nbsp;<u><?php echo ucwords($f['disability']) ;?></u></label
             </u></label> <span> &nbsp;&nbsp;&nbsp;&nbsp;<label><b>TYPE OF DISABILITY:</b>&nbsp;&nbsp;<?php echo $f['disability_type']; ?></label> <br></span>
        </div>


        <div style="margin: 20px; text-align: right;margin-top: 10rem">
            <label><u><?php echo $f['doctor_order']; ?></u></label><br>
            <label class="form-label">DOCTOR'S ORDER</label><br>

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