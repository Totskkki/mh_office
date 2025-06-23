<?php
include './config/connection.php';

include './common_service/common_functions.php';




if (isset($_GET['patientID'])) {
    $patientId = $_GET['patientID'];

    $query = "SELECT   pat.*, fam.*, mem.*, com.*, b.*, d.date_discharged, u.*,per.*,famMem.*, famMem.contact, 
            
                CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) AS address1,
                DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`,
                  m1.name AS mother_name, m1.relationship AS mother_relationship,
              m2.name AS father_name, m2.relationship AS father_relationship
              FROM `tbl_patients` AS pat
              LEFT JOIN `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
              LEFT JOIN `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
              LEFT JOIN `tbl_complaints` AS com ON pat.`patientID` = com.`patient_id`
              LEFT JOIN `tbl_birthing_monitoring` AS b ON b.`patient_id` = pat.`patientID`
              LEFT JOIN `tbl_discharged` AS d ON d.`patientid` = pat.`patientID`
              LEFT JOIN `tbl_birth_info` AS bi ON bi.`patient_id` = pat.`patientID`
               LEFT JOIN tbl_family_members AS m1 ON m1.patient_id = pat.patientID AND m1.relationship = 'mother'
              LEFT JOIN tbl_family_members AS m2 ON m2.patient_id = pat.patientID AND m2.relationship = 'father'

            LEFT JOIN tbl_users AS u on u.userID  = bi.midwife_nurse
             LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id 
               LEFT JOIN tbl_family_members AS famMem ON famMem.patient_id = pat.patientID 
             
     

WHERE     pat.`patientID` = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $patientId, PDO::PARAM_INT);
    $stmt->execute();
    $patientData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details

    if ($patientData) {
        $selectedMembershipID = $patientData['membershipID'];
        $midwifeName = $patientData['first_name'] . ' ' . $patientData['middlename'] . ' ' . $patientData['lastname'];
        // Fetch membership categories
        $categories = fetchMembershipCategories($con);
        $dropdownOptions = generateDropdownOptions($categories, $selectedMembershipID);
    } else {
        // Handle no patient data found
        $_SESSION['status'] = "No patient data found.";
        $_SESSION['status_code'] = "error";
        header('Location: patient.php');
        exit();
    }
}

// Fetch membership categories from the database
function fetchMembershipCategories($con)
{
    $query = "SELECT DISTINCT membershipID, ps_mem FROM tbl_membership_info";
    $stmt = $con->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function generateDropdownOptions($categories, $selectedCategory = '')
{
    $options = '';
    $seen = []; // To track duplicates
    foreach ($categories as $category) {
        if (!in_array($category['ps_mem'], $seen)) {
            $seen[] = $category['ps_mem'];
            $selected = ($category['membershipID'] === $selectedCategory) ? 'selected' : '';
            $options .= '<option value="' . $category['membershipID'] . '" ' . $selected . '>' . $category['ps_mem'] . '</option>';
        }
    }
    return $options;
}





$getstat = getstat($patientData['civil_status']);
$getphilhealthmembership = getphilhealthmembership($patientData['phil_membership']);





if(isset($_POST['saverecord'])){

    $patientid = $_POST['patientid'];  
    $employer = $_POST['employer'];
    $address = $_POST['address'];
    $admissionDate = $_POST['admissionDate'];
    $admissionTime = $_POST['admissionTime'];
    $dischargeDate = $_POST['dischargeDate'];
    $dischargeTime = $_POST['dischargeTime'];
    $typeOfAdmission = $_POST['typeOfAdmission']; 
    $admittingMidwife = $_POST['admittingMidwife'];
    $admittingDiagnosis = $_POST['admittingDiagnosis'];
    $finalDiagnosis = $_POST['finalDiagnosis'];
    $procedureDone = $_POST['procedureDone'];
    $disposition = $_POST['disposition'];
    $datafurnished = $_POST['datafurnished'];
    $datafurnishedaddress = $_POST['datafurnishedaddress'];


    
    try {

        $duplicateCheckStmt = $con->prepare("SELECT * FROM tbl_clinicalrecords WHERE patient_id = :patient_id AND admission_date = :admission_date AND admission_time = :admission_time");
        $duplicateCheckStmt->execute([
            ':patient_id' => $patientid,
            ':admission_date' => $admissionDate,
            ':admission_time' => $admissionTime
        ]);

        // If a record is found, it's a duplicate
        if ($duplicateCheckStmt->rowCount() > 0) {
            $_SESSION['status'] = "Duplicate entry found.";
            $_SESSION['status_code'] = "error";
            header('Location: birthing_patients.php?id=' . urlencode($patientid));
            exit();
        }
        $con->beginTransaction();

        $stmt = $con->prepare("SELECT birth_info_id, birthing_status 
        FROM tbl_birth_info 
        WHERE patient_id = :patientID 
          AND birthing_status = 'ongoing'
        ORDER BY birth_info_id DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patientid);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $birth_info_id = $birthInfo['birth_info_id'];
            $birthing_status = $birthInfo['birthing_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing birthing event found for the patient.");
        }


        

        $stmt = $con->prepare("INSERT INTO `tbl_clinicalrecords`(`patient_id`, `employer`, `empaddress`,`admission_date`, `admission_time`,`dischargeDate`, `dischargeTime`, `type_of_admission`, `admitting_midwife`,`datafurnished`, `datafurnishedaddress`, `admitting_diagnosis`, `final_diagnosis`, `procedure_done`, `disposition`,`birth_info_id`)
                            VALUES(:patient_id,:employer,:address,:admission_date,:admission_time,:dischargeDate,:dischargeTime,:type_of_admission,:admitting_midwife,:datafurnished,:datafurnishedaddress,:admitting_diagnosis,:final_diagnosis,:procedure_done,:disposition,:birth_info_id)");

        $stmt->execute([
            ':patient_id' => $patientid,
            ':employer' => $employer,
            ':address' => $address,
            ':admission_date' => $admissionDate,
            ':admission_time' => $admissionTime,
            ':dischargeDate' => $dischargeDate,
            ':dischargeTime' => $dischargeTime,
            ':type_of_admission' => $typeOfAdmission,
            ':admitting_midwife' => $admittingMidwife,
            ':datafurnished' => $datafurnished,
            ':datafurnishedaddress' => $datafurnishedaddress,
            ':admitting_diagnosis' => $admittingDiagnosis,
            ':final_diagnosis' => $finalDiagnosis,
            ':procedure_done' => $procedureDone,
            ':disposition' => $disposition,
            ':birth_info_id' => $birth_info_id


           

        ]);

        $con->commit();
        $_SESSION['status'] = "Clinical Records added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: birthing_patients.php?id=' . urlencode($patientid));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;

            background-color: #f4f4f4;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .col {
            flex: 1;
            padding: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="time"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .app-brand {
            min-height: 65px;
            overflow: hidden;
            background: #fff;
            margin: 0 0 1rem 0;
        }

        .main-container {
            padding: 0 0 0;
            -webkit-transition: padding-left .1s ease;
            transition: padding-left .1s ease;
        }
    </style>
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->

            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">
                <div class="app-header ">

                    <!-- Toggle buttons start -->

                    <!-- Toggle buttons end -->

                    <!-- App brand sm start -->

                    <!-- App brand sm end -->

                    <!-- Search container start -->

                    <!-- Search container end -->

                    <!-- App header actions start -->
                    <div class="header-actions">


                        <button onclick="window.history.back()" class="btn btn-primary mt-2 mb-2"><i class="icon-chevron-left"></i> Back</button>


                    </div>
                    <!-- App header actions end -->

                </div>
                <!-- App header starts -->

                <!-- App header ends -->



                <!-- App body starts -->
                <div class="app-body">

                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    ?>
                        <?php ?>

                    <?php


                    }

                    ?>
                    <!-- Container starts -->
                    <div class="container-fluid">


                        <div class="container">
                            <h1>CLINICAL COVER SHEET</h1>

                            <form method="POST" novalidate id="clinicalRecordsForm">
                                <?php if (isset($patientData)) : ?>
                                    <div class="row">
                                        <input type="hidden" name="patientid" value="<?php echo htmlspecialchars($patientData['patient_id']); ?>">
                                        <div class="col">
                                            <small> Last Name:</small>
                                            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($patientData['last_name']);  ?>" placeholder="Last Name" readonly>
                                        </div>
                                        <div class="col"> <small> First Name:</small>
                                            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($patientData['patient_name']);  ?>" placeholder="First Name"readonly>
                                        </div>
                                        <div class="col"> <small>Middle Name:</small>
                                            <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($patientData['middle_name']);  ?>" placeholder="Middle Name"readonly>
                                        </div>
                                        <div class="col"> <small> Name Ext.:</small>
                                            <input type="text" id="nameExt" name="nameExt" value="<?php echo htmlspecialchars($patientData['suffix']);  ?>" placeholder="Name Ext." readonly>
                                        </div>

                                        <div class="col">
                                            <small> Case No.:</small>
                                            <input type="text" id="caseNo" value="<?php echo htmlspecialchars($patientData['case_no']);  ?>" name="caseNo" readonly>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="permanentAddress">Permanent Address:</label>
                                            <input type="text" id="permanentAddress" value="<?php echo htmlspecialchars($patientData['address1']);  ?>" name="permanentAddress" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="dob">Date of Birth:</label>
                                            <input type="text" id="dob" value="<?php echo htmlspecialchars($patientData['date_of_birth']);  ?>" name="dob"readonly>
                                        </div>
                                        <div class="col">
                                            <label for="age">Age:</label>
                                            <input type="text" id="age" value="<?php echo htmlspecialchars($patientData['age']);  ?>" name="age"readonly>
                                        </div>
                                        <div class="col">
                                            <label for="sex">Sex:</label>
                                            <input type="text" id="sex" name="sex" value="<?php echo htmlspecialchars($patientData['gender']);  ?>"readonly>
                                        </div>
                                        <div class="col">
                                            <label for="placeOfBirth">Place of Birth:</label>
                                            <input type="text" id="placeOfBirth" name="placeOfBirth" value="<?php echo htmlspecialchars($patientData['place_of_birth']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="nationality">Nationality:</label>
                                            <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($patientData['Nationality']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="occupation">Occupation:</label>
                                            <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($patientData['emp_stat']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="civilStatus">Civil Status:</label >
                                            <select id="civilStatus" name="civilStatus" disabled>
                                                <?php echo $getstat; ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="religion">Religion:</label>
                                            <input type="text" id="religion" name="religion" value="<?php echo htmlspecialchars($patientData['religion']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 15px;">
                                    <div class="col" style="margin-right: 10px;">
                                        <label for="employer" style="display: block; margin-bottom: 5px;">Employer:</label>
                                        <input type="text" id="employer" name="employer" placeholder="First Name   Middle Name   Last Name" style="width: 100%; padding: 8px;">
                                    </div>
                                    <div class="col">
                                        <label for="address" style="display: block; margin-bottom: 5px;">Address:</label>
                                        <input type="text" id="address" name="address" placeholder="Employer Address" style="width: 100%; padding: 8px;">
                                    </div>
                                </div>


                                    <div class="row">
                                        <div class="col">
                                            <label for="fatherName">Name of Father / Guardian:</label>
                                            <input type="text" id="fatherName" name="fatherName" value="<?php echo htmlspecialchars($patientData['father_name']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="fatherAddress">Address:</label>
                                            <input type="text" id="fatherAddress" name="fatherAddress" value="<?php echo htmlspecialchars($patientData['address']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="fatherContact">Telephone/Cell No.:</label>
                                            <input type="text" id="fatherContact" name="fatherContact" value="<?php echo htmlspecialchars($patientData['contact']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="motherName">Name of Mother (Maiden Name):</label>
                                            <input type="text" id="motherName" name="motherName" value="<?php echo htmlspecialchars($patientData['mother_name']); ?>" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="motherAddress">Address:</label>
                                            <input type="text" id="motherAddress" name="motherAddress" value="<?php echo htmlspecialchars($patientData['address']); ?>"readonly>
                                        </div>
                                        <div class="col">
                                            <label for="motherContact">Telephone/Cell No.:</label>
                                            <input type="text" id="motherContact" name="motherContact" value="<?php echo htmlspecialchars($patientData['contact']); ?>"readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">
                                            <label for="admissionDate">Admission Date:</label>
                                            <input type="date" id="admissionDate" name="admissionDate" value="<?php echo htmlspecialchars($patientData['admission_date']); ?>" >
                                        </div>
                                        <div class="col-2">
                                            <label for="admissionTime">Time:</label>
                                            <input type="time" id="admissionTime" name="admissionTime" value="<?php echo htmlspecialchars($patientData['admission_time']); ?>" >
                                        </div>
                                        <div class="col-2">
                                            <label for="dischargeDate">Discharge Date:<span class="text-danger">*</span></label>
                                            <input type="date" id="dischargeDate" name="dischargeDate" value="<?php echo htmlspecialchars($patientData['date_discharged']); ?>" required>
                                            <div class="invalid-feedback">
                                            Discharge Date required.
                                        </div>
                                        </div>
                                        <div class="col-2">
                                            <label for="dischargeTime">Time:<span class="text-danger">*</span></label>
                                            <input type="time" id="dischargeTime" name="dischargeTime" required>
                                            <div class="invalid-feedback">
                                            Time required.
                                        </div>
                                       

                                        </div>
                                        <div class="col-3">
                                            <label for="admittingMidwife">Admitting Midwife/Nurse:</label>
                                            <input type="text" id="admittingMidwife" name="admittingMidwife" value="<?php echo htmlspecialchars($midwifeName); ?>" readonly>
                                      
                                            </div>
                                            
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="typeOfAdmission">Type of Admission:<span class="text-danger">*</span></label>
                                            <select id="typeOfAdmission" name="typeOfAdmission" required>
                                            <option value="">-Select-</option>
                                                <option value="new">New</option>
                                                <option value="old">Old</option>
                                            </select>
                                            <div class="invalid-feedback">
                                            Type of Admission is required.
                                        </div>
                                        </div>
                                        <div class="col">
                                            <label for="philHealthNo">PhilHealth No.:</label>
                                            <input type="text" id="philHealthNo" name="philHealthNo" value="<?php echo htmlspecialchars($patientData['philhealth_no']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="membership">Membership:</label>
                                            <select id="membership" name="membership" disabled>
                                                <?php echo $getphilhealthmembership; ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="membershipCategory">Membership Category:</label>
                                            <select id="membershipCategory" name="membershipCategory" disabled>
                                                <?php echo $dropdownOptions; ?>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="motherName">Data Furnished By:</label>
                                            <input type="text" id="motherName" name="datafurnished"  >
                                        </div>
                                        <div class="col">
                                            <label for="motherAddress">Address:</label>
                                            <input type="text" id="motherAddress" name="datafurnishedaddress" >
                                        </div>
                                        <div class="col">
                                            <label for="motherContact">Relation to patient:</label>
                                            <input type="text" id="motherContact" name="motherContact" value="<?php echo htmlspecialchars($patientData['relationship']); ?>"readonly>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col">
                                            <label for="referredBy">Referred By:</label>
                                            <input type="text" readonly id="referredBy" name="referredBy" value="<?php echo htmlspecialchars($patientData['refferred']); ?>">
                                        </div>
                                        <div class="col">
                                            <label for="admittingMidwife">Admitting Midwife/Nurse:</label>
                                            <input type="text"readonly id="admittingMidwife" name="admittingMidwife" value="<?php echo htmlspecialchars($midwifeName); ?>">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="admittingDiagnosis">Admitting Diagnosis:<span class="text-danger">*</span></label>
                                            <textarea id="admittingDiagnosis" name="admittingDiagnosis" required></textarea>
                                            <div class="invalid-feedback">
                                            Admitting Diagnosis is required.
                                        </div>
                                        </div>
                                        <div class="col">
                                            <label for="finalDiagnosis">Final Diagnosis:<span class="text-danger">*</span></label>
                                            <textarea id="finalDiagnosis" name="finalDiagnosis" required></textarea>
                                            <div class="invalid-feedback">
                                            Final Diagnosis is required.
                                        </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="procedureDone">Procedure Done:<span class="text-danger">*</span></label>
                                            <textarea id="procedureDone" name="procedureDone" required></textarea>
                                            <div class="invalid-feedback">
                                            Procedure Done is required.
                                        </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label for="disposition">Disposition:<span class="text-danger">*</span></label>
                                            <select id="disposition" name="disposition" required>
                                            <option value="">-Select-</option>
                                                <option value="discharged">Discharged</option>
                                                <option value="improved">Improved</option>
                                                <option value="unimproved">Unimproved</option>
                                                <option value="transferred">Transferred</option>
                                                <option value="hama">HAMA</option>
                                                <option value="died">Died</option>
                                                <option value="absconded">Absconded</option>
                                            </select>
                                            <div class="invalid-feedback">
                                            Disposition is required.
                                        </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <p>No patient details found.</p>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col">
                                        <button type="submit"class="btn btn-info " name="saverecord">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- Row start -->

                    </div>
                    <!-- Row end -->





                </div>
                <!-- Container ends -->

            </div>
            <!-- App body ends -->



            <!-- App footer start -->
            <?php include './config/footer.php'; ?>
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



    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>

    <script>
        $(document).ready(function() {
            var requestUrl;

            $('.btn-request').on('click', function(e) {
                e.preventDefault();
                requestUrl = $(this).attr('href');
                $('#confirmationModal').modal('show');
            });

            $('#confirmRequest').on('click', function() {
                window.location.href = requestUrl;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#all_patients").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [5, 10, 20, 50, 100],
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#search_patient").on("input", function() {
                var searchTerm = $(this).val().toLowerCase();

                // Make an AJAX request to fetch filtered patient data
                $.ajax({
                    type: "POST",
                    // url: "ajax/searchpatients.php",
                    data: {
                        searchTerm: searchTerm
                    },
                    success: function(response) {
                        // Update the table with the received data
                        $("#all_patients tbody").html(response);
                    },
                    error: function(error) {
                        console.log("Error: " + error);
                    }

                });
            });
        });
    </script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('clinicalRecordsForm');
            

            // Add validation on form submission
            form.addEventListener('submit', function(event) {
                var isValid = true; // Assume the form is valid


                // Check built-in HTML5 form validation
                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                } else {
                    form.classList.remove('was-validated');
                }
            }, false);
          
        });
    </script>

</body>



</html>