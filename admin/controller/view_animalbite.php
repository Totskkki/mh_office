<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
    $complaintID = $_GET['id'];

    // Prepare a statement to select the patient, complaint, family, and checkup data
    $query = "SELECT com.*, pat.*, fam.*,mem.*,bite.*,b.*,bite.date,
              CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
              CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`
              FROM tbl_animal_bite_care AS bite 
              JOIN tbl_patients AS pat ON bite.patient_id = pat.patientID
              JOIN tbl_familyAddress AS fam ON pat.family_address = fam.famID
              LEFT JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID
              LEFT JOIN tbl_complaints as com on com.patient_id = bite.patient_id
              LEFT JOIN tbl_birth_info AS b ON b.patient_id = bite.patient_id
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
            transform: scale(1);
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
                <div style="text-align: left; margin-right: 20px;">
                    <img src="../logo/2.png" style="width: 90px; height: 70px;" alt="">
                </div>
                <div style="text-align: left;">

                    <label>Brgy Tamnag, Lutayan, Sultan Kudarat</label><br>
                    <label>Tel. #: (083)-228-1528</label><br>
                    <label>Telefax No.: (083) 228-1528</label><br>

                </div>
                <h4 class="form-label" style="margin-left:15rem">Registration no.: <?php echo $row['reg_no']; ?> </h4>

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

            $type = json_decode($row['Type_bite'], true);


            if (!is_array($type)) {
                $type = [];
            }

            $TypeBite = ["Bite", "Non-bite", "Spontaneous", "Induced"];
            ?>

            <div style="margin: 10px;">
                <label for="text">Type</label>
                <div class="checkbox-group mb-3" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 20px;">
                    <?php foreach ($TypeBite as $TypeBites): ?>
                        <label style="flex: 1 0 calc(25% - 20px);">
                            <input type="checkbox" class="form-check-input" name="Type[]" value="<?php echo htmlspecialchars($TypeBites); ?>"
                                <?php if (in_array($TypeBites, $type)) echo 'checked'; ?>>
                            <?php echo htmlspecialchars($TypeBites); ?>
                        </label>
                    <?php endforeach; ?>
                </div>






            </div>




        </div>

        <div style="margin:10px; text-align: left; flex: 1;">

            <?php

            $type = json_decode($row['Type_bite'], true);


            if (!is_array($type)) {
                $type = [];
            }

            $TypeBite = ["Bite", "Non-bite", "Spontaneous", "Induced"];
            ?>

            <div style="margin: 10px;">
                <label for="text">Source</label>
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_type'] === 'Dog') ? 'checked' : ''; ?> name="source" value="Dog" id="dog">
                        <label class="form-check-label mb-1" for="dog">Dog</label>
                        <div id="checkDog" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" name="source" <?php echo htmlspecialchars($row['animal_type'] === 'Pet') ? 'checked' : ''; ?> value="Pet" id="pet">
                        <label class="form-check-label mb-1" for="pet">Pet</label>
                        <div id="checkPet" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_type'] === 'Cat') ? 'checked' : ''; ?> name="source" value="Cat" id="cat">
                        <label class="form-check-label mb-1" for="cat">Cat</label>
                        <div id="checkCat" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_type'] === 'Stray') ? 'checked' : ''; ?> name="source" value="Stray" id="stray">
                        <label class="form-check-label mb-1" for="stray">Stray</label>
                        <div id="checkStray" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <label class="form-check-label mb-1">Others:</label>
                        <input class="Source form-check-label input-bottom-border-only" type="input" name="source"
                            value="<?php echo (!in_array($row['animal_type'], ['Dog', 'Pet', 'Cat', 'Stray']) ? htmlspecialchars($row['animal_type']) : ''); ?>"
                            style="width:10rem" id="others">
                        <div id="checkOthers" style="display:none;">&#10004;</div>
                    </div>
                </div>



                <label class="form-check-label mb-1">Vaccinated Date:</label>
                <input type="text" name="vac_date" class="form-input" id="vac_date" value="<?php echo htmlspecialchars($row['source']); ?>">
                <input class="form-check-input Vaccinated" type="checkbox" <?php echo htmlspecialchars($row['pet_vaccinated'] === 'Vaccinated') ? 'checked' : ''; ?> name="Vaccinated" value="Vaccinated" id="vaccinated">
                <label class="form-check-label mb-1" for="vaccinated">Vaccinated</label>
                <input class="form-check-input Vaccinated" type="checkbox" <?php echo htmlspecialchars($row['pet_vaccinated'] === 'Unknown') ? 'checked' : ''; ?> name="Vaccinated" value="Unknown" id="unknown">
                <label class="form-check-label mb-1" for="unknown">Unknown</label>
            </div>


            <div style="margin:10px;">


                <label class="form-label">Status</label>
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_status'] === 'Alive') ? 'checked' : ''; ?> name="source" value="Dog" id="dog">
                        <label class="form-check-label mb-1" for="dog">Alive</label>
                        <div id="checkDog" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" name="source" <?php echo htmlspecialchars($row['animal_status'] === 'Died') ? 'checked' : ''; ?> value="Pet" id="pet">
                        <label class="form-check-label mb-1" for="pet">Died</label>
                        <div id="checkPet" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_status'] === 'Killed Intentionally') ? 'checked' : ''; ?> name="source" value="Cat" id="cat">
                        <label class="form-check-label mb-1" for="cat">Killed Intentionally</label>
                        <div id="checkCat" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['animal_status'] === 'Lost') ? 'checked' : ''; ?> name="source" value="Stray" id="stray">
                        <label class="form-check-label mb-1" for="stray">Lost</label>
                        <div id="checkStray" style="display:none;">&#10004;</div>
                    </div>
                    <div style="width: 20%;">
                        <label class="form-check-label mb-1" for="stray">Bleeding: <input class="form-input Source" type="text" value="<?php echo htmlspecialchars($row['bleeding']) ?>"> (-/+) if(+)</label>



                    </div>

                </div>


            </div>


            <div style="margin:10px;">


                <label class="form-label"> SITE OF EXPOSURE: (Please describe and sketch)</label>
                <input type="text" name="vac_date" style="width: 50%;" class="form-input" id="vac_date" value="<?php echo htmlspecialchars($row['site_exposure']); ?>">



            </div>

            <div style="margin:10px;">
                <label class="form-label"> Local wound treatment: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['wound'] === 'yes') ? 'checked' : ''; ?>>Yes
                    <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['wound'] === 'no') ? 'checked' : ''; ?>>No
                        <br>
                        <label class="form-label">Washed w/water only: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['washed'] === 'yes') ? 'checked' : ''; ?>>Yes
                            <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['washed'] === 'no') ? 'checked' : ''; ?>>No

                                <br>
                                <label class="form-label">Washed w/soap & water: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['soap'] === 'yes') ? 'checked' : ''; ?>>Yes
                                    <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['soap'] === 'no') ? 'checked' : ''; ?>>No

                                        <br>
                                        <label class="form-label">Tandok: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Tandok'] === 'yes') ? 'checked' : ''; ?>>Yes
                                            <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Tandok'] === 'no') ? 'checked' : ''; ?>>No
                                                <br>
                                                <label class="form-label">Applied garlic, etc.: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Applied'] === 'yes') ? 'checked' : ''; ?>>Yes
                                                    <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Applied'] === 'no') ? 'checked' : ''; ?>>No
                                                        <br>
                                                        <label class="form-label">Tetanus Immunization: <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Tetanus'] === 'yes') ? 'checked' : ''; ?>>Yes
                                                            <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['Tetanus'] === 'no') ? 'checked' : ''; ?>>No
                                                                <br>
                                                                <label class="form-label"> Date: <?php echo htmlspecialchars(!empty($row['vac_date']) ? date('F j, Y', strtotime($row['vac_date'])) : ''); ?></label>
                                                                <label style="margin-left: 2rem;" class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['vaccine'] === 'HTIG') ? 'checked' : ''; ?>>HTIG
                                                                    <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['vaccine'] === 'TT') ? 'checked' : ''; ?>>TT

                                                                        <br>
                                                                        <label class="form-label"> <b>CATEGORY EXPOSURE:</b></label>
                                                                        <label style="margin-left: 2rem;" class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['category_exposure'] === 'I') ? 'checked' : ''; ?>>I
                                                                            <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['category_exposure'] === 'II') ? 'checked' : ''; ?>>II
                                                                                <label class="form-label"> <input class="form-check-input Source" type="checkbox" <?php echo htmlspecialchars($row['category_exposure'] === 'III') ? 'checked' : ''; ?>>III


            </div>


            <div style="margin:10px;">
            <label class="form-label"><b>O:</b></label>
            <label class="form-label"><b>T:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['temp']); ?>">
            <label class="form-label"><b>BP:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['bp']); ?>">
            <label class="form-label"><b>CR:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['hr']); ?>">
            <label class="form-label"><b>RR:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['rr']); ?>">
            <label class="form-label"><b>LMP:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['LMP']); ?>">
            <label class="form-label"><b>AOG:</b></label>
            <input type="text" style="width: 10%;" class="form-input" value="<?php echo htmlspecialchars($row['AOG']); ?>">
            </div>

            <div style="margin:10px;">
            <label class="form-label"><b>A:</b></label>
            <input type="text" style="width: 50%;" class="form-input" value="<?php echo htmlspecialchars($row['a']); ?>">
            <br>
           <br>
            <label class="form-label"><b>P:</b></label>
            <input type="text" style="width: 50%;" class="form-input" value="<?php echo htmlspecialchars($row['p']); ?>">

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