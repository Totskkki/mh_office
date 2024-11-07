<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');




if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT 
    pat.*,fam.*,mem.*,com.*,
    CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, '. ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
    DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`
FROM 
    `tbl_patients` AS pat
    left JOIN 
    `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
left JOIN 
    `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
    left  JOIN `tbl_complaints` as com ON pat.`patientID` = com.`patient_id`
WHERE 
    pat.`patientID` = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $patientData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details


    $famquery = "SELECT * FROM `tbl_family_members`
     WHERE patient_id  = :id ORDER BY member_id  DESC";
    $stmt = $con->prepare($famquery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $famqueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $labquery = "SELECT * FROM `tbl_laboratory`
     WHERE patient_id  = :id ORDER BY labid   DESC";
    $stmt = $con->prepare($labquery);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $labqueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['saveMembers'])) {
    $patientID = trim($_POST['patientID']);
    $Name = trim($_POST['Name']);
    $Contact = trim($_POST['Contact']);
    $relationship = trim($_POST['relationship']);
    $Address = trim($_POST['Address']);




    try {

        $duplicateCheckStmt = $con->prepare("SELECT * FROM tbl_family_members WHERE name = :name");
        $duplicateCheckStmt->execute([
            ':name' => $Name,

        ]);

        // If a record is found, it's a duplicate
        if ($duplicateCheckStmt->rowCount() > 0) {
            $_SESSION['status'] = "Duplicate name found.";
            $_SESSION['status_code'] = "error";
            header('Location: view_patient.php?id=' . urlencode($patientID));
            exit();
        }
        $con->beginTransaction();

        $stmt = $con->prepare("INSERT INTO `tbl_family_members`(`name`, `relationship`, `contact`, `address`, `patient_id`)
          VALUES(:name,:relationship,:contact,:address,:patient_id) ");

        $stmt->execute([
            'name' => $Name,
            'relationship' => $relationship,
            'contact' => $Contact,
            'address' => $Address,
            'patient_id' => $patientID

        ]);
        $con->commit();

        $_SESSION['status'] = "Family member added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: view_patient.php?id=' . urlencode($patientID));
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        die("Error: " . $e->getMessage());
    }
}

if (isset($_POST['savelaboratory'])) {
    $patientID = trim($_POST['patientID']);
    $service = trim($_POST['service']);
    $datetest = trim($_POST['datetest']);
    $testresults = trim($_POST['testresults']);
    $testimage = $_FILES['testimage']['name'];

    $filename = null;  // Default to null if no image is uploaded

    if (!empty($testimage)) {
        move_uploaded_file($_FILES['testimage']['tmp_name'], './labtest/' . $testimage);
        $filename = $testimage;  
    }else{
        $filename = '';  

    }

    try {
        $con->beginTransaction();

        $stmt = $con->prepare("INSERT INTO `tbl_laboratory`(`services`, `date_test`, `test_result`, `patient_id`,`image`)
            VALUES (:services, :date_test, :test_result, :patient_id, :image)");

        $stmt->execute([
            'services' => $service,
            'date_test' => $datetest,
            'test_result' => $testresults,
            'patient_id' => $patientID,
            'image' => $filename,
        ]);

        $con->commit();

        $_SESSION['status'] = "Laboratory Test added successfully.";
        $_SESSION['status_code'] = "success";
        header('Location: view_patient.php?id=' . urlencode($patientID));
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
        .flex-container {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .flex-item {
            margin-bottom: 10px;
        }

        .double {
            display: flex;
            justify-content: space-between;
            width: 50%;
        }

        .double p {
            width: 50%;
            /* Each paragraph takes half the width of the container */
        }

        .full-width {
            width: 100%;
        }

        span {
            font-weight: bold;
        }

        .flex-item button {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">



            <!-- Sidebar menu starts -->
            <?php include './config/sidebar.php'; ?>
            <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                <?php include './config/header.php'; ?>
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


                        <div class="row">
                            <div class="col-xxl-12">

                                <?php if (isset($patientData)) : ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="card-title "><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></h2>
                                        </div>

                                        <div class="card-body">





                                            <div class="row flex-container">


                                                <div class="flex-item">
                                                    <h2><strong></strong>
                                                        <!-- <span>
                                                            <button type="button" id="" name="" class="btn btn-info float-end">Add lab results</button>
                                                        </span> -->
                                                    </h2>

                                                </div>

                                                <div class="flex-item double">
                                                    <p class="form-label">Age: <?php echo htmlspecialchars($patientData['age']); ?>

                                                    </p>
                                                    <p class="form-label">Sex: <?php echo htmlspecialchars($patientData['gender']); ?></p>
                                                </div>


                                                <div class="flex-item double">
                                                    <p class="form-label">
                                                        BirthDate:
                                                        <?php
                                                        if (!empty($patientData['date_of_birth']) && $patientData['date_of_birth'] != '0000-00-00') {
                                                            echo htmlspecialchars(date('F j, Y', strtotime($patientData['date_of_birth'])));
                                                        } else {
                                                            echo ''; // Display this if the date of birth is not available
                                                        }
                                                        ?>
                                                    </p>
                                                    <p class="form-label">Contact Number: <?php echo htmlspecialchars($patientData['phone_number']); ?></p>
                                                </div>


                                                <div class="flex-item double ">
                                                    <p class="form-label">Status: <?php echo htmlspecialchars(ucwords($patientData['civil_status'])); ?></p>
                                                    <p class="form-label">Blood Type: <?php echo htmlspecialchars(ucwords($patientData['blood_type'])); ?></p>
                                                </div>
                                                <div class="flex-item ">

                                                    <p class="form-label">Address: <?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', '  . $patientData['city_municipality'] . ', ' . $patientData['province']); ?></p>
                                                </div>


                                            </div>




                                            <hr />

                                            <div class="row" id="Familyform">
                                                <div class="col-xl-4 col-sm-6 col-12">
                                                    <div class="card mb-4 rounded-0 shadow">
                                                        <div class="card-header rounded-1 shadow">
                                                            <h5 class="card-title">
                                                                Laboratory
                                                                <a href="#" id="Laboratory" class="btn btn-info  float-end">
                                                                    <i class="icon-plus"></i>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <!-- Check if lab data exists -->
                                                        <?php if (!empty($labqueryData)) { ?>
                                                            <div class="card-body">
                                                                <ul class="list-unstyled mb-0">
                                                                    <?php foreach ($labqueryData as $lab) { ?>
                                                                        <li class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                                            <span>
                                                                                <?php echo htmlspecialchars(date('M d, Y', strtotime($lab['date_test']))); ?>
                                                                            </span>
                                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#Viewlabresult" data-record-id="<?php echo $lab['labid']; ?>">
                                                                                <i class="icon-eye"></i>
                                                                            </button>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <!-- No data available -->
                                                            <div class="card-body text-center text-danger">
                                                                <p class="mt-2">No available data found</p>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="card-footer text-muted">
                                                            <!-- Footer content can go here if needed -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-sm-6 col-12">
                                                    <div class="card mb-4 card-outline rounded-0 shadow">
                                                        <div class="card-header  rounded-1 shadow ">
                                                            <h5 class="card-title">Family Member <span><a href="#" type="button" id="famMember" class="btn btn-info float-end">
                                                                        <i class="icon-plus"></i>

                                                                    </a></span></h5>

                                                        </div>
                                                        <?php if (!empty($famqueryData)) { ?>
                                                            <div class="card-body">
                                                                <p>
                                                                    <?php foreach ($famqueryData as $fam) { ?>
                                                                        <li>


                                                                            <?php echo htmlspecialchars(ucwords($fam['name'])); ?> - <?php echo htmlspecialchars(ucwords($fam['relationship'])); ?>


                                                                            </a>

                                                                        </li>
                                                                    <?php } ?>
                                                                </p>
                                                                <!-- <a href="#" class="btn btn-primary"></a> -->
                                                            </div>
                                                            <div class="card-footer">
                                                                <!-- <span class="badge border border-primary text-primary">2 Hours Ago</span> -->
                                                            </div>
                                                        <?php } else { ?>
                                                            <p class="text-center mt-2 " style="color:red;"> No available data found</p>
                                                        <?php } ?>
                                                    </div>
                                                </div>


                                            </div>

                                            <form method="POST" id="familymember" style="display: none;" novalidate>
                                                <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">
                                                <div class="row">
                                                    <div class="col-12">

                                                        <h3>Add Family Member <span> <button style="margin-left: 2rem;" id="Back" type="button" class="btn btn-primary">
                                                                    <i class="icon-arrow-left"></i> Back</button></span><span class="float-end"></h3>


                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="patient_name">Full Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " name="Name" id="Name" placeholder="First Name   Middle Name   Last Name" style="width: 100%; padding: 8px;"
                                                               
                                                                title="Full Name accept only letters." required pattern="[a-zA-Z\s\.]+" />
                                                            <div class="invalid-feedback">
                                                                Full Name is required and accept only letters..
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="patient_name">Contact: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " id="Contact" name="Contact" required  />
                                                            <div class="invalid-feedback">
                                                                Please provide Contact number.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-4 col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="patient_name">Relationship: <span class="text-danger">*</span></label>
                                                                <select name="relationship" class="form-select" required>
                                                                    <option value="">-Select-</option>
                                                                    <option value="Mother">Mother</option>
                                                                    <option value="Father">Father</option>
                                                                    <option value="Son">Son</option>
                                                                    <option value="Daugther">Daugther</option>
                                                                    <option value="Grand Father">Grand Father</option>
                                                                    <option value="Grand Mother">Grand Mother</option>
                                                                    <option value="Sibling">Sibling</option>
                                                                    <option value="Uncle">Uncle</option>
                                                                    <option value="Aunt">Aunt</option>
                                                                    <option value="Guardian">Guardian</option>

                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Relationship is required.
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-4 col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="patient_name">Address: <span class="text-danger">*</span></label>
                                                                <textarea name="Address" class="form-control" required></textarea>
                                                                <div class="invalid-feedback">
                                                                    Please provide their Address.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex gap-2 justify-content-end">

                                                            <button type="submit" name="saveMembers" class="btn btn-info">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>




                                            <form method="POST" id="laboratoryForm" style="display: none;" novalidate enctype="multipart/form-data">
                                                <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientData['patientID']) ?>">

                                                <div class="row">
                                                    <div class="col-12">
                                                        <h3>Add Laboratory
                                                            <span>
                                                                <button style="margin-left: 2rem;" id="goBack" type="button" class="btn btn-primary">
                                                                    <i class="icon-arrow-left"></i> Back
                                                                </button>
                                                            </span>
                                                            <span class="float-end"></span>
                                                        </h3>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="modal position-static d-block shade-light rounded-3" tabindex="-1" role="dialog" id="modalSheet">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-5">
                                                                        <div class="mb-3 row">
                                                                            <label for="service" class="col-sm-3 col-form-label text-center">Select Laboratory Service <span class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <select id="service" name="service" class="form-select" required>
                                                                                    <option value="">-Select-</option>
                                                                                    <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                                                                                    <option value="Urinalysis">Urinalysis</option>
                                                                                    <option value="Fecalysis">Stool Examination</option>
                                                                                    <option value="Sputum Examination">Sputum Examination</option>
                                                                                    <option value="Blood Typing">Blood Chemistry</option>
                                                                                    <option value="Platelet Count">Platelet Count</option>

                                                                                </select>
                                                                                <div class="invalid-feedback">
                                                                                    Please Laboratory Service
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="mb-3 row">
                                                                            <label for="text" class="col-sm-3 col-form-label text-center">Date Test <span class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">


                                                                                <div class="input-group date" id="datetest" data-target-input="nearest">
                                                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetest" name="datetest" data-toggle="datetimepicker" autocomplete="off" required />
                                                                                    <div class="input-group-append" data-target="#datetest" data-toggle="datetimepicker">
                                                                                        <div class="input-group-text" style="height: 100%;">
                                                                                            <i class="icon-calendar" style="height: 100%;"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="invalid-feedback">
                                                                                        Date is required
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3 row">
                                                                            <label for="text" class="col-sm-3 col-form-label text-center">Test Results <span class="text-danger">*</span></label>
                                                                            <div class="col-sm-8">
                                                                                <textarea name="testresults" cols="30" rows="3" class="form-control" style="resize:none;" required></textarea>
                                                                            </div>
                                                                            <div class="invalid-feedback">
                                                                                Test Results is required
                                                                            </div>
                                                                        </div>

                                                                        <div class="mb-3 row">
                                                                            <label for="text" class="col-sm-3 col-form-label text-center">Upload Image</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="file" name="testimage" cols="30" rows="3" class="form-control" style="resize:none;"></input>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="d-flex gap-2 justify-content-end">
                                                                                    <button type="submit" name="savelaboratory" class="btn btn-info">Submit</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- modal-body -->
                                                                </div> <!-- modal-content -->
                                                            </div> <!-- modal-dialog -->
                                                        </div> <!-- modal -->
                                                    </div> <!-- card-body -->
                                                </div> <!-- row -->
                                            </form>








                                        </div>
                                    </div>
                                    <!-- Row end -->

                                <?php else : ?>
                                    <p>No patient details found.</p>
                                <?php endif; ?>

                            </div>
                        </div>



                    </div>
                    <!-- Container ends -->
                    <!-- Existing Lab Result Modal -->
                    <div class="modal fade" id="Viewlabresult" tabindex="-1" aria-labelledby="referModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Lab Result</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="referPatientId">
                                    <div class="modal position-static d-block shade-light rounded-3" tabindex="-1" role="dialog" id="modalSheet">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-5">
                                                    <!-- Laboratory Service -->
                                                    <div class="mb-3 row">
                                                        <label for="service" class="col-sm-3 col-form-label text-center">Select Laboratory Service</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="serviceDisplay" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Date Test -->
                                                    <div class="mb-3 row">
                                                        <label for="Date" class="col-sm-3 col-form-label text-center">Date Test</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="Date" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Test Results -->
                                                    <div class="mb-3 row">
                                                        <label for="testResult" class="col-sm-3 col-form-label text-center">Test Results</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="testResult" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Clickable Image Preview -->
                                                    <div class="mb-3 row">
                                                        <label for="labImage" class="col-sm-3 col-form-label text-center">Image</label>
                                                        <div class="col-sm-8">
                                                            <a href="#" id="imageLink" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                                <img id="labImage" src="" alt="Lab Test Image" class="img-fluid" style="max-width:100%; max-height:500px; cursor: pointer;">
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div> <!-- modal-body -->
                                            </div> <!-- modal-content -->
                                        </div> <!-- modal-dialog -->
                                    </div> <!-- modal -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Enlarged Image -->
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img id="modalImage" src="" class="img-fluid" alt="Enlarged Image">
                                </div>
                            </div>
                        </div>
                    </div>



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

    <?php include './config/site_js_links.php';

    $message = '';
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }

    ?>


    </script>

    <script>
        // Function to set up the image click event
        function setupImageClickHandler() {
            $('#labImage').on('click', function() {
                const labImageSrc = $(this).attr('src');
                $('#modalImage').attr('src', labImageSrc);
            });
        }

        // Handle modal show event
        $('#Viewlabresult').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var labid = button.data('record-id'); // Get the patient ID

            console.log(labid);

            // Fetch record data
            $.ajax({
                type: 'POST',
                url: 'fetchrow/labtest.php', // Ensure this URL is correct
                data: {
                    labId: labid // Send the patient ID to the server
                },
                dataType: 'json',
                success: function(response) {
                    console.log('AJAX response:', response);

                    if (response) {
                        $('#Laboratory').val(response.services);
                        $('#Date').val(response.date_test);
                        $('#testResult').val(response.test_result);
                        $('#serviceDisplay').val(response.services);

                        if (response.image) {
                            $('#labImage').attr('src', './labtest/' + response.image);
                        } else {
                            $('#labImage').attr('src', ''); // Clear the image if none exists
                        }

                        // Set up the click handler after the image is updated
                        setupImageClickHandler();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('XHR Object:', xhr);
                }
            });
        });
    </script>



    <script>
        document.getElementById('famMember').addEventListener('click', function() {
            document.getElementById('Familyform').style.display = 'none';
            document.getElementById('familymember').style.display = 'block';
        });

        $(document).ready(function() {
            // When the "Click to show graph" button is clicked

            // When the "Back" button is clicked
            $('#Back').click(function() {
                // Hide the graph and show the form
                $('#familymember').hide();
                $('#Familyform').show();
            });
            $('#goBack').click(function() {
                // Hide the graph and show the form
                $('#laboratoryForm').hide();
                $('#Familyform').show();
            });
        });
        document.getElementById('Laboratory').addEventListener('click', function() {
            document.getElementById('Familyform').style.display = 'none';
            document.getElementById('laboratoryForm').style.display = 'block';
        });
        $('#datetest').datetimepicker({
            format: 'YYYY-MM-DD',
            maxDate: new Date()
        });
    </script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('familymember');
            var form1 = document.getElementById('laboratoryForm');
            // var nameInputs = [{
            //         id: 'Name',
            //         errorMessage: 'Invalid first name.'
            //     },

            // ];
            // var namePattern = /^[A-Za-z\s]{2,}$/; // Pattern for valid names (no numbers, at least 2 characters)

            // Loop through each name input and add real-time validation
            // for (var i = 0; i < nameInputs.length; i++) {
            //     (function(input) {
            //         var inputElement = document.getElementById(input.id);

            //         inputElement.addEventListener('input', function() {
            //             if (!namePattern.test(inputElement.value)) {
            //                 inputElement.setCustomValidity(input.errorMessage);
            //                 inputElement.classList.add('is-invalid');
            //             } else {
            //                 inputElement.setCustomValidity("");
            //                 inputElement.classList.remove('is-invalid');
            //             }
            //         });
            //     })(nameInputs[i]);
            // }

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
            form1.addEventListener('submit', function(event) {
                var isValid = true; // Assume the form is valid


                // Check built-in HTML5 form validation
                if (!form1.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form1.classList.add('was-validated');
                } else {
                    form1.classList.remove('was-validated');
                }
            }, false);
        });
    </script>
    <script>
        $(document).ready(function() {
            function calculateAge(birthdate) {
                console.log("Birthdate:", birthdate);

                var parts = birthdate.split('/');
                var dob = new Date(parts[2], parts[1] - 1, parts[0]);
                if (isNaN(dob)) {
                    console.error("Invalid date format:", birthdate);
                    return;
                }
                console.log("Parsed Date:", dob);
                var today = new Date();
                var age = today.getFullYear() - dob.getFullYear();
                var monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                console.log("Calculated Age:", age);
                return age;
            }

            $('#date_of_birth').on('change.datetimepicker', function(e) {
                var dob = $(this).find('input').val();
                $('#Age').val(calculateAge(dob));
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $('#Contact').inputmask('+639999999999');
        });
    </script>

    <script>
        $(document).ready(function() {

            $("#patient_name").blur(function() {

                var message = '<?php echo $message; ?>';

                if (message !== '') {
                    showCustomMessage(message);
                }


                var patientName = $(this).val().trim();
                // var householdNo = $("#household_no").val().trim();
                $(this).val(patientName);

                if (patient_name !== '') {
                    $.ajax({
                        url: "ajax/check_patient.php",
                        type: 'GET',
                        data: {
                            'patient_name': patientName
                            // 'household_no': householdNo
                        },
                        cache: false,
                        async: true,
                        success: function(count, status, xhr) {
                            if (parseInt(count) > 0) {
                                showCustomMessage("This patient name has already been saved. Please choose another name");
                                $("#save_Patient").attr("disabled", "disabled");
                            } else {
                                $("#save_Patient").removeAttr("disabled");
                            }
                        },
                        error: function(jqXhr, textStatus, errorMessage) {
                            showCustomMessage(errorMessage);
                        }
                    });
                }

            });
        });
    </script>



</body>



</html>