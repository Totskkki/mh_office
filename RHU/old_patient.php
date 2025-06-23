<?php
include './config/connection.php';

include './common_service/common_functions.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}


if (isset($_POST['save_complaints'])) {

    $patientid = trim($_POST['hidden_id']);
    $Complaint = trim($_POST['Complaint']);
    $remarks = trim($_POST['remarks']);
    
     $bp_systolic = trim($_POST['bp_systolic']);
    $bp_diastolic = trim($_POST['bp_diastolic']);
    $bp = $bp_systolic . '/' . $bp_diastolic; 
    
    $hr = trim($_POST['hr']);
    $weight = trim($_POST['weight'] . "kg");
    $rr = trim($_POST['rr']);
    $Temp = $_POST['Temp'] . "°C";
    $Height = trim($_POST['Height'] . "cm");
    $PR = trim($_POST['PR']);

    $Nature_visit = trim($_POST['Nature_visit']);
    $cp_visit = trim($_POST['cp_visit']); // consultation purpose
    $Refferred = trim($_POST['Refferred']);
    $reason = trim($_POST['reason']);

    // Check if there's a pending consultation for the same purpose
    $checkQuery = $con->prepare("SELECT * FROM `tbl_complaints` WHERE `patient_id` = :id AND `consultation_purpose` = :cp_visit AND `status` = 'Pending'");
    $checkQuery->bindParam(':id', $patientid, PDO::PARAM_INT);
    $checkQuery->bindParam(':cp_visit', $cp_visit, PDO::PARAM_STR);
    $checkQuery->execute();
    $existingPending = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingPending) {
        $_SESSION['status'] = "This patient already has a pending " . htmlspecialchars(json_encode($cp_visit), ENT_QUOTES) . " consultation.";
        $_SESSION['status_code'] = "error";
        header('location:old_patient.php');
        exit;
    }

    // Retrieve patient details
    // $query = $con->prepare("SELECT * FROM `tbl_patients` WHERE `patientID` = :id");
    // $query->bindParam(':id', $patientid, PDO::PARAM_INT);
    // $query->execute();
    // $patient = $query->fetch(PDO::FETCH_ASSOC);

    // if (!$patient) {
    //     $_SESSION['status'] = "Patient not found.";
    //     $_SESSION['status_code'] = "error";
    //     header('location:old_patient.php');
    //     exit;
    // }

    if (($cp_visit == "Prenatal" || $cp_visit == "Birthing") && ($patient['gender'] == "Male" || $patient['gender'] == "Other")) {
        $_SESSION['status'] = "Invalid section for male patient.";
        $_SESSION['status_code'] = "error";
        header('location:old_patient.php');
        exit;
    }

    // Insert new complaint if checks pass
    $insertQuery = "INSERT INTO `tbl_complaints` (`patient_id`, `Chief_Complaint`, `Remarks`, `bp`, `hr`, `weight`, `rr`, `temp`, `Height`, `Nature_Visit`, `consultation_purpose`, `refferred`, `reason_ref`, `status`, `pr`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->execute([$patientid, $Complaint, $remarks, $bp, $hr, $weight, $rr, $Temp, $Height, $Nature_visit, $cp_visit, $Refferred, $reason, $PR]);

    $_SESSION['status'] = "Patient complaint handled successfully.";
    $_SESSION['status_code'] = "success";
    header('location:old_patient.php');
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        .form-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .justify-content-end {
            justify-content: flex-end;

        }

        .search-container {
            position: relative;
            display: inline-block;

        }

        .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            display: none;
            /* Initially hide the icon */
        }

        .search-item {
            font-size: 20px;

        }

        .search-results-container {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 1000;
            display: none;
            overflow-y: auto;
            max-height: 300px;
            /* Adjust as needed */
        }

        .search-results-container ul {
            list-style: none;
            margin: 0;
            padding: 0;
            font-size: 200px;
        }

        .search-results-container li {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-results-container li:hover {
            background-color: #f5f5f5;
        }

        #patient_details,
        .text-muted {
            display: none;

        }

        .highlight {
            background-color: #f0f0f0;
        }
    </style>

</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- App brand starts -->
                <div class="app-brand px-3 py-2 d-flex align-items-center">

                </div>
                <!-- App brand ends -->

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

                    <div class="container-fluid">

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12 col-xl-12">
                                <!-- Breadcrumb start -->
                                <ol class="breadcrumb mb-1">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Home</a>

                                    </li>
                                    <li class=" breadcrumb-active">
                                        / Patient Individual Treatment
                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2">Individual Treatment</h2>
                                <h6 class="mb-4 fw-light">
                                    Mga impormasyon ng pasyente
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Patient information</h5>
                                         <small class="text-danger">* Maari kang maglagay ng konsultasyon ng pasyente dito</small><br/>
                                         <small class="text-danger">* Halimbawa: Check-up, Prenatal, Birthing, Immunization & vaccination, Animal bite</small>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group">

                                            </div>


                                        </div>

                                        <h3 class="profile-username text-center"></h3>




                                        <div class="row ">
                                            <div class="mb-5">

                                                <div class="input-group w-50">

                                                    <input type="text" class="form-control" id="search_patient" name="search_patient" placeholder="Search Patients" autofocus required />
                                                    <div class="invalid-feedback">
                                                        Patient is required.
                                                    </div>
                                                    <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                                    <div id="searchResultsContainer" class="search-results-container"></div>

                                                </div>

                                            </div>


                                            <br><br>
                                            <br>

                                            <form method="post" novalidate id="oldpatient">

                                                <p class="text-muted text-center"></p>
                                                <ul class="list-group list-group-unbordered mb-3" id="patient_details">


                                                    <li class="list-group-item">

                                                        <b>Name:</b> <span class="float-center text-decoration-none text-dark" id="patient_name"></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Gender:</b> <span class="float-center text-decoration-none text-dark" id="patient_gender"></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Contact no.:</b> <span class="float-center text-decoration-none text-dark" id="patient_contact"></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Status:</b> <span class="float-center text-decoration-none text-dark" id="patient_status"></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Age:</b> <span class="float-center text-decoration-none text-dark" id="patient_age"></span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Address:</b> <span class="float-center text-decoration-none text-dark" id="patient_address"></span>
                                                    </li>
                                                </ul>

                                                <div class="row">
                                                    <div class="card-header" style="background-color: #ffc107 ;"><strong>Patient Complaint</strong> </div>
                                                </div>
                                                <br>

                                                <input type="hidden" name="hidden_id" id="hidden_id">
                                                <div class="row">
                                                    <form method="post">
                                                        <div class=" col-12">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Chief Complaint</label>
                                                                <textarea style="resize:none;" name="Complaint" id="Complaint" class="form-control" data-ms-editor="true"></textarea>

                                                            </div>
                                                        </div>
                                                        <div class=" col-12">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Remarks</label>
                                                                <textarea style="resize:none;" name="remarks" id="remarks" class="form-control" data-ms-editor="true"></textarea>

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>




                                                        <style>
                                                            .blue-placeholder,
                                                            .blue-placeholder::placeholder {
                                                                color: blue;
                                                                font-size: 20px;
                                                                font-weight: bold;
                                                            }

                                                            .blue-placeholder:hover {
                                                                cursor: pointer;
                                                                color: blue;
                                                            }


                                                            p {
                                                                font-size: 12px;
                                                            }
                                                        </style>

                                                        <div class="row" id="RHU">

                                                           <div class="col-lg-2 col-sm-4 col-12">
                                                                    <div class="mb-3">
                                                                        <h6 for="bp" class="">Blood Pressure</h6>
                                                                        <div class="d-flex align-items-center">
                                                                            <input type="text" style="width: 50%;" class="form-control form-control-sm rounded-0 blue-placeholder me-2" id="bp_systolic" name="bp_systolic" required placeholder="" />
                                                                            <span class="mx-1">/</span>
                                                                            <input type="text" style="width: 50%;" class="form-control form-control-sm rounded-0 blue-placeholder" id="bp_diastolic" name="bp_diastolic" required placeholder="" />
                                                                       
                                                                              <div class="invalid-feedback">
                                                                            Blood Pressure is required.
                                                                        </div>
                                                                        </div>
                                                                       
                                                                        <p class="mt-1">Systolic/Diastolic</p>
                                                                       
                                                                    </div>
                                                                </div>


                                                            <div class="col-lg-2 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="hr" class="">Heart Rate</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="hr" name="hr" required min="0" max="300" />
                                                                    <p>Beats per Minute</p>
                                                                    <div class="invalid-feedback">
                                                                        Heart Rate is required and must be between 0 and 300.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="weight" class="">Weight</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="weight" name="weight" required min="0" max="999" />
                                                                    <p>Kilograms</p>
                                                                    <div class="invalid-feedback">
                                                                        Weight is required and must be between 0 and 999 kg.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="Height" class="">Height</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="Height" name="Height" required min="0" max="500" step="0.01" />
                                                                    <p>Centimeters</p>
                                                                    <div class="invalid-feedback">
                                                                        Height is required and must be between 0 and 999 cm.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="Temp" class="">Temp</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="Temp" name="Temp" required min="0" max="100" step="0.1" />
                                                                    <p>Celsius</p>
                                                                    <div class="invalid-feedback">
                                                                        Temperature is required and must be between 0 and 100°C.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="PR" class="">PR</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="PR" name="PR" required min="0" max="300" />
                                                                    <p>bpm</p>
                                                                    <div class="invalid-feedback">
                                                                        PR is required and must be between 0 and 300 bpm.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="col-lg-2 col-sm-4 col-12">
                                                                <div class="mb-3">
                                                                    <h6 for="rr" class="">Respiratory rate</h6>
                                                                    <input type="text" class="form-control form-control-sm rounded-0 blue-placeholder" placeholder="0" id="rr" name="rr" required min="0" max="100" />
                                                                    <p>Breaths per Minute</p>
                                                                    <div class="invalid-feedback">
                                                                        Respiratory rate is required and must be between 0 and 100.
                                                                    </div>
                                                                </div>
                                                               </div>

                                                        </div>


                                                        <div class="col-lg-5 col-sm-4 col-12">
                                                            <div class="mb-3">
                                                                <label for="visit" class="form-label">Nature of Visit <span class="text-danger">*</span></label>
                                                                <select id="Nature_visit" name="Nature_visit" class="form-control form-control-sm rounded-0" required="required">
                                                                    <?php echo getnature('', false); ?>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Nature of Visit is required.
                                                                </div>
                                                            </div>
                                                        </div>






                                                        <div class="col-lg-5 col-12">
                                                            <div class="mb-3">
                                                                <label for="visit" class="form-label">Type of consultation purpose of visit <span class="text-danger">*</span></label>
                                                                <select class="form-control form-control-sm rounded-0" id="cp_visit" name="cp_visit" required="required">

                                                                    <?php echo getconsulpurpose(); ?>

                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Type of consultation is required.
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-5 col-12">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Refferred by:</label>
                                                                <input type="text" class="form-control form-control-sm rounded-0" id="Refferred" name="Refferred" value="<?php echo $user['first_name'] . ' ' . $user['lastname']; ?>" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-12">
                                                            <div class="mb-3">
                                                                <label for="text" class="">Reason for referral: <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control form-control-sm rounded-0" id="reason" name="reason" required />
                                                                <!--<div class="invalid-feedback">-->
                                                                <!--    Reason for referral is required.-->
                                                                <!--</div>-->
                                                            </div>
                                                        </div>



                                                </div>
                                                <div class="row">
                                                    <div class="">

                                                        <button type="submit" class="btn btn-info float-end " id="save_complaints" name="save_complaints">Submit</button>

                                                    </div>
                                                </div>
                                            </form>
                                            <div id="consultationForm" style="display: none;">
                                                <!-- Form fields for new consultation/case -->
                                                <!-- Add your form fields here -->
                                            </div>

                                            <div id="admissionForm" style="display: none;">
                                                <!-- Form fields for new admission -->
                                                <!-- Add your form fields here -->




                                            </div>

                                            <div id="followUpForm" style="display: none;">
                                                <!-- Form fields for follow-up visit -->
                                                <!-- Add your form fields here -->
                                            </div>



                                        </div>
                                    </div>
                                </div>

                            </div>


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



    <!-- Date Range JS -->

    // <script>
    //     Inputmask("999 / 999").mask("#bp");
    // </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('oldpatient');



            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);


        });
    </script>


    <script>
        $(document).ready(function() {
            var debouncedSearch = debounce(performSearch, 300);

            $('#search_patient').on("input", debouncedSearch);

            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            function performSearch() {
                var searchTerm = $('#search_patient').val().toLowerCase().trim();
                if (searchTerm === '') {
                    $("#searchResultsContainer").html('');
                    $("#searchResultsContainer").hide();
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "./ajax/searchpatients.php",
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        $("#searchResultsContainer").html(response);
                        $("#searchResultsContainer").show();
                    },
                    error: function(error) {
                        console.log("Error: " + error);
                        $("#searchResultsContainer").html('');
                        $("#searchResultsContainer").hide();
                    }
                });
            }
            $(document).on("mouseenter", ".search-item", function() {
                $(this).addClass('highlight');
            });

            $(document).on("mouseleave", ".search-item", function() {
                $(this).removeClass('highlight');
            });
            // Click event for search result
            $(document).on("click", ".search-item", function() {
                var patientName = $(this).text();
                $('#search_patient').val(patientName);
                $("#searchResultsContainer").empty();
                $("#searchResultsContainer").hide();
                $("#submit").prop('disabled', !patientName);

                var patientId = $(this).data('patient-id');
                $("#hidden_id").val(patientId);

                fetchPatientDetails(patientId);

                $('#search_patient').focus();
            });

            $('#search_patient').on('input', function() {
                var inputValue = $(this).val().trim();
                if (inputValue) {
                    $('.search-icon').show();
                } else {
                    $('.search-icon').hide();
                }
            });

            function fetchPatientDetails(patientId) {
                if (patientId) {
                    $.ajax({
                        type: "GET",
                        url: "/ajax/getpatientdetails.php",
                        data: {
                            patientID: patientId
                        },
                        success: function(response) {
                            var patient = JSON.parse(response);
                            if (patient.error) {
                                console.log(patient.error);
                                return;
                            }

                            $("#patient_name").text(patient.name);
                            $("#patient_gender").text(patient.gender);
                            $("#patient_contact").text(patient.phone_number);
                            $("#patient_status").text(patient.civil_status);
                            $("#patient_age").text(patient.age);
                            $("#patient_address").text(patient.familyaddress);
                            $("#patient_details").show();
                        },
                        error: function(error) {
                            console.log("Error: " + error);
                        }
                    });
                } else {
                    $("#patient_details").hide().empty();
                }
            }


        });
//   $(document).ready(function() {
//     var debouncedSearch = debounce(performSearch, 300);

//     $('#search_patient').on("input", debouncedSearch);

//     function debounce(func, delay) {
//         let debounceTimer;
//         return function() {
//             const context = this;
//             const args = arguments;
//             clearTimeout(debounceTimer);
//             debounceTimer = setTimeout(() => func.apply(context, args), delay);
//         };
//     }

//     function performSearch() {
//         var searchTerm = $('#search_patient').val().toLowerCase().trim();
//         if (searchTerm === '') {
//             $("#searchResultsContainer").html('');
//             $("#searchResultsContainer").hide();
//             return;
//         }

//         $.ajax({
//             type: "POST",
//             url: "ajax/searchpatients.php",
//             data: {
//                 search: searchTerm
//             },
//             success: function(response) {
//                 $("#searchResultsContainer").html(response);
//                 $("#searchResultsContainer").show();
//             },
//             error: function(error) {
//                 console.log("Error: " + error);
//                 $("#searchResultsContainer").html('');
//                 $("#searchResultsContainer").hide();
//             }
//         });
//     }

//     $(document).on("mouseenter", ".search-item", function() {
//         $(this).addClass('highlight');
//     });

//     $(document).on("mouseleave", ".search-item", function() {
//         $(this).removeClass('highlight');
//     });

//     // Click event for search result
//     $(document).on("click", ".search-item", function() {
//         var name = $(this).text();
//         var patientId = $(this).data('id'); // Get ID from the data attribute
//         var type = $(this).data('type'); // Get type (patient or family_member) from the data attribute

//         $('#search_patient').val(name);
//         $("#searchResultsContainer").empty();
//         $("#searchResultsContainer").hide();
//         $("#submit").prop('disabled', !name);

//         $("#hidden_id").val(patientId); // Store the selected ID in a hidden input

//         // Log which type of patient or member is being fetched
//         console.log("Fetching details for ID: " + patientId + ", Type: " + type);

//         // Call the fetch function, passing the ID and type
//         fetchPatientDetails(patientId, type);

//         $('#search_patient').focus();
//     });

//     function fetchPatientDetails(patientId, type) {
//         if (patientId) {
//             // Log details before making the AJAX request
//             console.log("Preparing AJAX request for patientID: " + patientId + " with type: " + type);

//             $.ajax({
//                 type: "GET",
//                 url: "ajax/getpatientdetails.php",
//                 data: {
//                     patientID: patientId,
//                     type: type // Send type to the server if needed
//                 },
//                 success: function(response) {
//                     var patient = JSON.parse(response);
//                     if (patient.error) {
//                         console.log(patient.error);
//                         return;
//                     }

//                     // Update UI with details depending on type
//                     if (type === 'patient') {
//                         $("#patient_name").text(patient.name || "N/A");
//                         $("#patient_gender").text(patient.gender || "N/A");
//                         $("#patient_contact").text(patient.phone_number || "N/A");
//                         $("#patient_status").text(patient.civil_status || "N/A");
//                         $("#patient_age").text(patient.age || "N/A");
//                         $("#patient_address").text(patient.familyaddress || "N/A");
//                         $("#patient_details").show();
//                     } else if (type === 'family_member') {
//                         $("#patient_name").text(patient.name || "N/A");
//                         $("#patient_contact").text(patient.contact || "N/A");
//                         $("#patient_address").text(patient.familyaddress || "N/A");

//                         $("#patient_details").show();
//                     }
//                 },
//                 error: function(error) {
//                     console.log("Error: " + error);
//                 }
//             });
//         } else {
//             $("#patient_details").hide().empty();
//         }
//     }
// });



    </script>
    
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const value = parseFloat(this.value);
                    const min = parseFloat(this.min);
                    const max = parseFloat(this.max);
                    const invalidFeedback = this.nextElementSibling;

                    {
                        if (isNaN(value) || value < min || value > max) {
                            invalidFeedback.style.display = 'block';
                            this.classList.add('is-invalid');
                        } else {
                            invalidFeedback.style.display = 'none';
                            this.classList.remove('is-invalid');
                        }
                    }
                });
            });
        });
    </script>






</body>



</html>