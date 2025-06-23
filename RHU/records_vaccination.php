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
                                    Vaccination and Immunization
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title"> <span> <a href="vaccination.php" type="button" class="btn btn-primary float-end">
                                                    <i class="icon-chevron-left"></i> Back

                                                </a></span></h5>

                                    </div>
                                    <div class="card-body">
                                        <div class="col-12">
                                            <div class="d-flex gap-2 justify-content-end mb-2">


                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="all_patients" class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient Name</th>
                                                        <th>Type of Vaccination/Immunization</th>
                                                        <th>Date Administered</th>
                                                        <th>Next Due Visit</th>
                                                        <th>Notes</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>
                                                        <?php
                                                        try {
                                                    //   $query = "SELECT users.*, complaints.*, users.date_of_birth, family.brgy, family.purok, family.province, mem.*, i.*
                                                    //           FROM tbl_patients AS users 
                                                    //           LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                                                    //           LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                                                    //           LEFT JOIN (
                                                    //               SELECT * FROM tbl_complaints AS c
                                                    //               WHERE c.status = 'Done' 
                                                    //               AND c.consultation_purpose = 'Vaccination and Immunization'
                                                    //               AND c.created_at = (
                                                    //                   SELECT MAX(c2.created_at) 
                                                    //                   FROM tbl_complaints AS c2 
                                                    //                   WHERE c2.patient_id = c.patient_id
                                                    //               )
                                                    //           ) AS complaints ON users.patientID = complaints.patient_id
                                                    //           LEFT JOIN tbl_immunization_records AS i ON users.patientID = i.patient_id
                                                    //           WHERE i.immunID IS NOT NULL
                                                    //           GROUP BY users.patientID, i.immunID
                                                    //           ORDER BY i.immunID DESC";
                                                      $query = "SELECT users.*, complaints.*, i.*
                                                                FROM tbl_patients AS users
                                                                LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                                                                LEFT JOIN tbl_immunization_records AS i ON users.patientID = i.patient_id
                                                                INNER JOIN (
                                                                    SELECT patient_id, MAX(DATE(immunization_date)) AS latest_immunization_date
                                                                    FROM tbl_immunization_records
                                                                    GROUP BY patient_id
                                                                ) AS latest ON i.patient_id = latest.patient_id AND DATE(i.immunization_date) = latest.latest_immunization_date
                                                                WHERE complaints.status = 'Done' AND complaints.consultation_purpose = 'Vaccination and Immunization'
                                                                GROUP BY i.patient_id
                                                                ORDER BY i.immunization_date DESC;
                                                                ";

                                                        $stmtUsers = $con->prepare($query);
                                                        $stmtUsers->execute();

                                                        $stmtUsers = $con->prepare($query);
                                                        $stmtUsers->execute();

                                                    } catch (PDOException $e) {
                                                    
                                                        error_log('Database Error: ' . $e->getMessage());
                                                        
                                                        echo "An error occurred. Please try again later.";
                                                    }

                                                        ?>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $count = 0;
                                                    while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                                                        $count++;
                                                        $dob = new DateTime($row['date_of_birth']);
                                                        $now = new DateTime();
                                                        $age = $now->diff($dob)->y;
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $count; ?></td>

                                                            <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>

                                                            <td class="text-center">
                                                                <?php
                                                                if (!empty($row['date_of_birth'])) {
                                                                    if ($age < 2) {
                                                                        echo "Child Vaccination";
                                                                    } else {
                                                                        echo "Adult Vaccination";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['immunization_date']; ?></td>
                                                            <td>
                                                                <?php echo $row['immunization_next_date']; ?>
                                                            </td>
                                                            <td><?php echo $row['remarks']; ?></td>
                                                            <td>
                                                                <?php

                                                                if ($row['status'] == 'Done') {
                                                                    echo '<span class="badge bg-success">Done</span>';
                                                                } else {
                                                                }
                                                                ?>
                                                            </td>




                                                            <td>
                                                                <?php

                                                                $redirectUrl = $age < 2 ? 'controller/child_immunization_record.php' : 'controller/adult_immunization_record.php';
                                                                ?>
                                                                <a href="<?php echo $redirectUrl . '?id=' . $row['immunID']; ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
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


</body>



</html>