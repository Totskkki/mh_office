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
                                        <a href="dashboard.php">Home </a>

                                    </li>
                                    <li class=" breadcrumb-active">

                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    User Logs
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">User Logs</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="user_list" class="table table-striped">


                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Status</th>
                                                        <!--<th>User Ip</th>-->
                                                        <th>login time</th>
                                                        <th>logout time</th>


                                                    </tr>

                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $query = "SELECT * FROM tbl_user_log ORDER BY logID DESC ";
                                                    $stmtlogs = $con->query($query);
                                                    $count = $stmtlogs->rowCount();
                                                    $i = 1;
                                                    ?>

                                                    <tr>
                                                        <?php while ($row = $stmtlogs->fetch(PDO::FETCH_ASSOC)) { ?>

                                                            <td><?php echo $i++; ?></td>


                                                            <td><?php echo $row['username']; ?></td>
                                                            <td>
                                                                <?php if ($row['status'] == 1) { ?>
                                                                    <span class="badge bg-success ">
																		Success</span>
                                                                <?php } else { ?>
                                                                    <span class="badge bg-danger ">
                                                                    Failed</span>
                                                                <?php } ?>
                                                            </td>
                                                          
                                                            <td><?php echo $row['login_time']; ?></td>
                                                            <td><?php echo $row['logout']; ?></td>







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
            $("#user_list").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [5, 10, 20, 50, 100],
            });
        });
    </script>


</body>



</html>