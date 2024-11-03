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
                                    Patient List
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Patient Check-up Records</h5>
                                    </div>
                                    <div class="card-body">
                                        <div <div class="col-12">
                                            <div class="d-flex gap-2 justify-content-end mb-2">

                                                <a href="checkup.php" type="button" class="btn btn-primary">
                                                    <i class="icon-chevron-left"></i> Back

                                                </a>
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="all_patients" class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient Name</th>
                                                        <th>Address</th>
                                                        <th>Date Of Birth</th>
                                                        <th>Age</th>
                                                        <th>Consultation Purpose</th>
                                                        <th>Current/Old Patient</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                        <?php
                                                        $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*
                                                                FROM tbl_patients AS users 
                                                                LEFT JOIN tbl_family AS family ON users.family_address = family.famID 
                                                                LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                                                                LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                                                                WHERE complaints.status = 'Done' AND complaints.consultation_purpose = 'Checkup'
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
                                                            <td><?php echo date('F j, Y', strtotime($row['date_of_birth'])); ?></td>
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

                                                                if ($row['status'] == 'Done') {
                                                                    echo '<span class="badge bg-success">Done Check-up</span>';
                                                                } else {
                                                                }
                                                                ?>
                                                            </td>




                                                                <td>
                                                                <a href="consult_checkup.php?id=<?php echo $row['complaintID'] ?>"button class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip"
																	data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary"
																	data-bs-title="View">
																	<i class="icon-eye"></i>
																</a>
                                                                </td>
                                                           


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
            $("#all_patients").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [10, 20, 50, 100],
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

</body>



</html>