<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Prepare a statement to select the patient, complaint, family, and checkup data
    $query = "SELECT com.*, pat.*, fam.*,mem.*,bite.*,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
              FROM tbl_animal_bite_care AS bite 
              JOIN tbl_patients AS pat ON bite.patient_id = pat.patientID
              JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID
              JOIN tbl_complaints as com on com.complaintID 
              WHERE bite.animal_biteID  = :complaintID";



    $stmt = $con->prepare($query);
    $stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <button onclick="window.history.back()" class="btn btn-primary">Back</button>
    <br />
    <br />
    <div id="print" style="max-width:900px;">



        <div style="display: flex; justify-content: center; margin: 10px;">
            <div style="display: inline-flex; justify-content: space-between; align-items: left;">
                <div style="text-align: center; margin-right: 20px;">
                    <img src="../logo/2.png" style="width: 90px; height: 70px;" alt="">
                </div>
                <div style="text-align: left;">

                    <label>Brgy Tamnag, Lutayan, Sultan Kudarat</label><br>
                    <label>Tel. #: (083)-228-1528</label><br>
                    <label>Telefax No.: (083) 228-1528</label><br>

                </div>
                <h5 class="form-label" style="margin-left:10rem">Registration no.: <?php echo $row['reg_no']; ?> </h5>

            </div>
        </div>
        <hr />
        <div style="margin:10px;text-align: left; font-size:20px;margin-bottom:25px;">
            <label for="text"><b>PATIENT HEALTH RECORD</b></label>
        </div>
        <div style="margin:10px;text-align: right; font-size:20px;margin-bottom:25px;">
            <label class="form-label">Date:</label>
            <input class="form-input" type="text" value="<?php echo htmlspecialchars($row['date']); ?>" readonly>
        </div>

        <div style="margin:10px;">


            <label class="form-label">Patient Name:</label>
            <input class="form-input" type="text" style="width: 15%;" value="<?php echo htmlspecialchars($row['name']); ?>" readonly>
            <label class="form-label">Bday</label>
            <input class="form-input" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" readonly>
            <label class="form-label">Age:</label>
            <input class="form-input" style="width: 10%;" type="text" value="<?php echo htmlspecialchars($row['age']); ?>" readonly>
            <label class="form-label">Sex:</label>
            <input class="form-input" type="text" style="width: 5%;" value="<?php echo htmlspecialchars($row['gender']); ?>" readonly>

            <label class="form-label">Weight:</label>
            <input class="form-input" type="text" style="width: 5%;" value="<?php echo htmlspecialchars($row['weight']); ?>" readonly>

            <label class="form-label">Status:</label>
            <input class="form-input" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($row['civil_status']); ?>" readonly>

        </div>

        <div style="margin:10px;">


            <label class="form-label">Address:</label>
            <input class="form-input" type="text" style="width: 30%;" value="<?php echo htmlspecialchars($row['address']); ?>" readonly>
            <label class="form-label">Philhealth No.:</label>
            <input class="form-input" type="text" style="width: 10%;" value="<?php echo htmlspecialchars($row['philhealth_no']); ?>" readonly>
            <label class="form-label">Contact No.:</label>
            <input class="form-input" style="width: 10%;" type="text" value="<?php echo htmlspecialchars($row['phone_number']); ?>" readonly>

        </div>

        <div style="margin:10px; text-align: left; flex: 1;">
            <label for="text"> Pertenint Past Medical History</label><br>
            <div class="checkbox-group mb-3">



                <?php
                // Decode med_history and ensure it's an array
                $med_history = json_decode($row['med_history'], true);

                // Check if med_history is not an array or is null, initialize to an empty array
                if (!is_array($med_history)) {
                    $med_history = []; // Safeguard to ensure we have an array to work with
                }

                $medical_conditions = [
                    "Fully Immunized",
                    "Anti-Rabies",
                    "Diabetes Mellitus",
                    "On Meds",
                    "Allergy",
                    "Food",
                    "Drug",
                    "Hypertension"
                ];
                ?>

                <div style="margin:10px;">
                    <label for="text">Pertinent Past Medical History</label>
                    <div class="checkbox-group mb-3">
                        <?php foreach ($medical_conditions as $condition): ?>
                            <label>
                                <input type="checkbox" class="form-check-input" name="past_med_history[]" value="<?php echo htmlspecialchars($condition); ?>"
                                    <?php if (in_array($condition, $med_history)) echo 'checked'; ?>>
                                <?php echo htmlspecialchars($condition); ?>
                            </label><br>
                        <?php endforeach; ?>
                        <label for="text">CPI: Month/year Completed: <?php echo htmlspecialchars($row['cpi_month']); ?> / <?php echo htmlspecialchars($row['cpi_year']); ?></label>
                       
                    </div>
                    
                    
                    
                </div>

                


            </div>


        </div>
        <div style="margin:10px;">


            <label class="form-label">Date of Exposure</label>
            <input class="form-input" type="text" style="width: 20%;" value="<?php echo htmlspecialchars(!empty($row['date_bite']) ? date('F j, Y', strtotime($row['date_bite'])) : '') ?>" readonly>

            <label class="form-label">Place of exposure </label>
            <input class="form-input" type="text" style="width: 30%;" value="<?php echo htmlspecialchars($row['Place']); ?>" readonly>

        </div>

        <div style="margin:10px; text-align: left; flex: 1;">

       


                <?php
                // Decode Type_bite and ensure it's an array
                $type = json_decode($row['Type_bite'], true);

                // Check if type is not an array or is null, initialize to an empty array
                if (!is_array($type)) {
                    $type = []; // Safeguard to ensure we have an array to work with
                }

                $TypeBite = ["Bite", "Non-bite", "Spontaneous", "Induced"];
                ?>

                <div style="margin: 10px;">
                    <label for="text">Type</label>
                    <div class="checkbox-group mb-3" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 20px;">
                        <?php foreach ($TypeBite as $TypeBites): ?>
                            <label style="flex: 1 0 calc(25% - 20px);"> <!-- Each label will take up about 25% of the width, accounting for gaps -->
                                <input type="checkbox" class="form-check-input" name="Type[]" value="<?php echo htmlspecialchars($TypeBites); ?>"
                                    <?php if (in_array($TypeBites, $type)) echo 'checked'; ?>>
                                <?php echo htmlspecialchars($TypeBites); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <label for="text">Source:</label>
                    
            

            </div>


        </div>






        <div class="row">
            <div class="col-xxl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="modal position-static d-block shade-light rounded-3">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class=" p-5">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <h2 class="fw-bold mb-2 card-title" style="margin: 0;">ANIMAL BITE RECORD</h2>



                                        </div>


                                        <h5 class="form-label float-end">Date: <?php echo date('F j, Y', strtotime($row['date'])); ?> </h5>
                                        <br>




                                        <hr />
                                        <div class="row">
                                            <h3 class="from-label"><?php echo $row['patient_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] ?>

                                            </h3>


                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="abc1">Age</label>
                                                    <br>
                                                    <?php echo $row['age']; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="abc2">Sex</label>
                                                    <br>
                                                    <?php echo $row['gender']; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="abc3">Civil Status</label>
                                                    <br>
                                                    <?php echo $row['civil_status']; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="abc4">Date of Birth</label>
                                                    <br>
                                                    <?php echo $row['date_of_birth']; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-4 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="abc4">Philhealth no.</label>
                                                    <br>
                                                    <?php echo $row['philhealth_no']; ?>
                                                </div>
                                            </div>



                                        </div>
                                        <hr />
                                        <div class="form-container">
                                            <div class="ultrasound-info">
                                                <h3>Pertinent Past Medical History</h3>

                                                <p><strong></strong> <span>
                                                        <?php
                                                        if (!empty($row['med_history'])) {
                                                            $med_history = json_decode($row['med_history'], true);

                                                            if (json_last_error() === JSON_ERROR_NONE) {
                                                                if (is_array($med_history)) {
                                                                    foreach ($med_history as $item) {
                                                                        if (!empty($item)) {
                                                                            echo '=> ' . ucwords(htmlspecialchars($item)) . ' <br />';
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo 'Decoded JSON is not an array.';
                                                                }
                                                            } else {
                                                                echo 'Error decoding JSON: ' . json_last_error_msg();
                                                            }
                                                        } else {
                                                        }
                                                        ?>

                                                    </span></p>
                                                <p><strong>Bleeding:</strong> <?php echo $row['bleeding']; ?></p>
                                                <p><strong>CPI: Month/year Completed:</strong> <span id="chief_complaint"><?php echo $row['cpi_month'] . ' ' . $row['cpi_year']; ?></span></p>


                                                <h5>Date of exposure: <?php echo $row['date_bite'] ?></h5>
                                                <h5>Place of exposure: <?php echo $row['Place'] ?></h5>
                                                <h5>Type
                                                </h5>
                                                <p><?php

                                                    if (!empty($row['Type_bite'])) {
                                                        $med_history = json_decode($row['Type_bite'], true);

                                                        if (json_last_error() === JSON_ERROR_NONE) {
                                                            if (is_array($med_history)) {
                                                                foreach ($med_history as $item) {
                                                                    if (!empty($item)) {
                                                                        echo '=> ' . ucwords(htmlspecialchars($item)) . ' <br />';
                                                                    }
                                                                }
                                                            } else {
                                                                echo 'Decoded JSON is not an array.';
                                                            }
                                                        } else {
                                                            echo 'Error decoding JSON: ' . json_last_error_msg();
                                                        }
                                                    } else {
                                                    }
                                                    ?></p>
                                                <h5>Source: <?php echo $row['animal_type'] ?> <span style="margin-left:10rem;">Vaccinated date: <?php echo date('F j, Y', strtotime($row['source'])); ?></span> <span> / <?php echo $row['pet_vaccinated']; ?></span></h5>
                                                <h5>Status: <?php echo $row['animal_status'] ?></h5>
                                                <h5>Site of exposure: <?php echo $row['site_exposure'] ?></h5>
                                                <div class="ultrasound-details">
                                                    <p><strong>Local wound treatment:</strong> <span id="lmp"><?php echo $row['wound'] ?></span></p>
                                                    <p><strong>Washed w. water only:</strong><span id="ga_by_lmp"> <?php echo $row['washed'] ?></span></p>
                                                    <p><strong>Washed w/soup & water:</strong><span id="edc_by_lmp"><?php echo $row['soap'] ?></span> </p>
                                                    <p><strong>Tandok:</strong> <span id="fhr"><?php echo $row['Tandok'] ?></span></p>
                                                    <p><strong>Applied garlic, etc.:</strong> <span><?php echo $row['Applied'] ?></span></p>
                                                    <p><strong>Tetanus Immunization:</strong><span> <?php echo $row['Tetanus'] ?></span>
                                                        <span style="margin-left:10rem;">Date:
                                                            <?php
                                                            if (!empty($row['vac_date'])) {
                                                                echo date('F j, Y', strtotime($row['vac_date']));
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>
                                                        </span>
                                                    </p>

                                                </div>
                                                <h5>Category exposure: <?php echo $row['category_exposure'] ?></h5>
                                                <h5>Remarks: <?php echo $row['Remarks'] ?></h5>
                                            </div>





                                        </div>



                                        <!-- Row start -->



                                        <br style="clear:both;" />
                                        <br />



                                        <!-- Row end -->
















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