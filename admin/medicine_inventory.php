<?php
include './config/connection.php';

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
                                        / Medicine
                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    Medicine Inventory
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">

                                        <div class="d-flex align-items-end justify-content-between">

                                            <h5 class="card-title"> Medicine Inventory</h5>

                                        </div>
                                    </div>

                            <?php
                            
                            try {
                                $query = "SELECT m.*, md.*, DATE_FORMAT(`date_added`, '%b %d, %Y %h:%i %p') as date_added 
                                          FROM `tbl_medicines` AS m
                                          LEFT JOIN
                                          `tbl_medicine_details` AS md ON m.`medicineID` = md.`medicine_id` 
                                          order by status= 1
                                        --   ORDER BY md.qt ASC
                                          ";
                                
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                            } catch (PDOException $ex) {
                                echo $ex->getMessage();
                                echo $ex->getTraceAsString();
                                exit;
                            }
                            
                            ?>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="all_medicines" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>

                                                        <th>Medicine Name</th>
                                                        <th>Quantity</th>                                                      
                                                        <th>Manufacturer</th>
                                                        <th>Brand</th>
                                                        <th>Packing</th>                                                       
                                                        <th>Manufatured Date</th>
                                                        <th>Expiry Date</th>
                                                        <th>Date Added</th>

                                                    </tr>
                                                </thead>
                                                <style>
                                                    p {
                                                        color: blue;
                                                        ;
                                                    }

                                                    .medicine-info {
                                                        white-space: nowrap;
                                                    }

                                                    .medicine-info div {
                                                        margin-left: 20px;

                                                    }


                                                    .info-line {
                                                        display: flex;
                                                        align-items: center;
                                                    }

                                                    .info-label {
                                                        min-width: 100px;
                                                        color: blue;

                                                    }

                                                    .info-value {
                                                        margin-left: 10px;
                                                        color: red;

                                                    }
                                                </style>
                                                <tbody>
                                                    <?php
                                                    $serial = 0;
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $serial++;
                                                        $quantity = $row['qt'];
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $serial; ?></td>
                                                            <td class="medicine-info">
                                                                <b><?php echo $row['medicine_name']; ?></b><br>
                                                                <div class="info-line">
                                                                    <span class="info-label">Manufacturer</span>
                                                                    <span class="info-label2">:</span>
                                                                    <span class="info-value"><?php echo $row['manufacturer']; ?></span>
                                                                </div>
                                                                <div class="info-line">
                                                                    <span class="info-label">Supplier:</span>
                                                                    <span class="info-label2">:</span>
                                                                    <span class="info-value"><?php echo $row['supplier']; ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            <?php 
                                                            // Check the quantity and display appropriate message
                                                            if ($quantity == 0) {
                                                             
                                                                echo '<span class="badge bg-danger">Out of Stock</span>';
                                                            } elseif ($quantity < 20) {
                                                                echo $quantity .' '. '<span class="badge bg-warning"> (Low Stock)</span>';
                                                            } else {
                                                                echo $quantity;
                                                            }
                                                            ?>
                                                        </td>                                                          
                                                            <td><?php echo $row['manufacturer']; ?></td>
                                                            <td><?php echo $row['brand']; ?></td>
                                                            <td><?php echo $row['packing']; ?></td>                                                            
                                                            <td><?php echo $row['manuf_date']; ?></td>
                                                            <td><?php echo $row['ex_date']; ?></td>
                                                            <td><?php echo $row['date_added']; ?></td>



                                                            </td>
                                                        </tr>
                                                    <?php } ?>
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
       $(function() {
      $("#all_medicines").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#all_medicines_wrapper .col-md-6:eq(0)');

    });

        
    </script>


</body>



</html>