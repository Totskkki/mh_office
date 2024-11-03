<?php
include './config/connection.php';

include './common_service/common_functions.php';





?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
<style>
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
                    <a href="index.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a>
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

                    <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    ?>
                        <?php ?>

                    <?php


                    }

                    ?>
                    <!-- Container starts -->
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

                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    Laboratory
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addlaboratory">
                                            <i class="icon-add_box"></i> Add
                                        </button>

                                    </div>
                                    <div class="card-body">
                                        <div class="col-12">
                                            <div class="d-flex gap-2 justify-content-end mb-2">

                                                <!-- <a href="records_animalbite.php" type="button"  class="btn btn-outline-success ms-1">
                                        View Records
                                    </a> -->
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="all_patients" class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient Name</th>
                                                        <th>Services</th>
                                                        <th>Result</th>
                                                        <th class="text-center">Action</th>
                                                        <?php
                                                        $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*
                                  FROM tbl_patients AS users 
                                  LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                                  LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                                  LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                                  WHERE complaints.status = 'pending' AND complaints.consultation_purpose = 'Animal bite and Care'
                                  GROUP BY users.patientID 
                                  ORDER BY users.patientID DESC";
                                                        $stmtUsers = $con->prepare($query);
                                                        $stmtUsers->execute();

                                                        ?>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $count = 0;
                                                    while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                                                        $count++;
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $count; ?></td>

                                                            <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
                                                            <td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
                                                            <!-- <td><?php echo date('F j, Y', strtotime($row['date_of_birth'])); ?></td> -->
                                                            <td><?php echo $row['date_of_birth']; ?></td>
                                                            <td><?php echo $row['age']; ?></td>
                                                            <td><?php echo $row['consultation_purpose']; ?></td>
                                                            <td>
                                                                <?php
                                                                if (!isset($row['Nature_Visit']) || empty($row['Nature_Visit'])) {
                                                                    echo '<span class="badge bg-warning">Not specified</span>';
                                                                } elseif ($row['Nature_Visit'] == 'New admission') {
                                                                    echo '<span class="">Current</span>';
                                                                } elseif ($row['Nature_Visit'] == 'New consultation/case') {
                                                                    echo '<span class="">Current</span>';
                                                                } else {
                                                                    echo '<span class="">Old Patient/returning</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php

                                                                if ($row['status'] == 'Pending') {
                                                                    echo '<span class="badge bg-danger">pending</span>';
                                                                } else {
                                                                }
                                                                ?>
                                                            </td>





                                                            <td class="text-center">
                                                                <a href="form_animalbite.php?id=<?php echo $row['complaintID'] ?>" class="btn btn-info btn-sm ">
                                                                    <i class="icon-feather"> consult</i>
                                                                </a>


                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->


                    <div class="modal fade" id="addlaboratory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content ">
                                <div class="modal-header ">
                                    <h5 class="modal-title" id="consultModalTitle">Laboratory Examination</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form method="POST" novalidate>


                                        <input type="hidden" id="user" name="patient_id">
                                        <input type="hidden" id="complainid" name="hidden1">


                                        <div class="mb-3 row">
                                            <label for="text" class="col-sm-3 col-form-label text-center">Search Patients</label>
                                            <div class="col-sm-8">

                                                <input type="text" class="form-control" id="search_patient" name="search_patient" placeholder="Search Patients" autofocus />
                                                <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                                <div id="searchResultsContainer" class="search-results-container"></div>

                                            </div>


                                        </div>



                                        <div class="mb-3 row">
                                            <label for="service" class="col-sm-3 col-form-label text-center">Select Laboratory Service</label>
                                            <div class="col-sm-8">
                                                <select id="service" name="service" class="form-select" required>
                                                    <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
                                                    <option value="Urinalysis">Urinalysis</option>
                                                    <option value="Fecalysis">Stool Examination</option>                                                   
                                                    <option value="Sputum Examination">Sputum Examination</option>
                                                    <option value="Blood Typing">Blood Chemistry</option>                 
                                                    <option value="Platelet Count">Platelet Count</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="text" class="col-sm-3 col-form-label text-center">Date Test</label>
                                            <div class="col-sm-8">


                                                <div class="input-group date" id="datetest" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetest" name="datetest" data-toggle="datetimepicker" autocomplete="off" required />
                                                    <div class="input-group-append" data-target="#datetest" data-toggle="datetimepicker">
                                                        <div class="input-group-text" style="height: 100%;">
                                                            <i class="icon-calendar" style="height: 100%;"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="text" class="col-sm-3 col-form-label text-center">Test Results</label>
                                            <div class="col-sm-8">
                                                <textarea name="notes" id="testresults" cols="30" rows="3" class="form-control" style="resize:none;"></textarea>
                                            </div>
                                        </div>


                                </div>




                                <div class="modal-footer">
                                    <button type="button" class="btn " data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" id="savelab" name="savelab" class="btn btn-info">
                                        Submit
                                    </button>

                                </div>
                            </div>

                            </form>
                        </div>
                    </div>



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
    <script src="assets/moment/moment.min.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#all_patients").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [5, 10, 20, 50, 100],
            });
            $('#datetest').datetimepicker({
                format: 'YYYY-MM-DD',
                maxDate: new Date()
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
                    url: "ajax/searchpatients.php",
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
                        url: "ajax/getpatientdetails.php",
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
    </script>


</body>



</html>