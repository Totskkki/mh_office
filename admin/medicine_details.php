<?php
include './config/connection.php';

include './common_service/common_functions.php';


if (isset($_POST['med_detailsID'])) {
    $id = $_POST['med_detailsID'];

    $query = "SELECT md.med_detailsID, m.medicineID AS medicine_id, md.packing, md.qt 
              FROM tbl_medicine_details md 
              LEFT JOIN tbl_medicines m ON md.medicine_id = m.medicineID 
              WHERE md.med_detailsID = :id";
    $stmt = $con->prepare($query);
    $stmt->execute(array(':id' => $id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($row);
    exit;
}



if (isset($_POST['submit'])) {

  
    $medicineId = $_POST['medicine'];
    $packing = $_POST['packing'];
    $qt = $_POST['qt'];

    $con->beginTransaction();

    try {
        // Check if the record exists
        $existingQuery = "SELECT * FROM `tbl_medicine_details` WHERE `medicine_id` = :medicineId AND `packing` = :packing";
        $stmtExisting = $con->prepare($existingQuery);
        $stmtExisting->execute([':medicineId' => $medicineId, ':packing' => $packing]);
        $existingDetails = $stmtExisting->fetch(PDO::FETCH_ASSOC);

        if ($existingDetails) {
            // Update the existing record
            $query = "UPDATE `tbl_medicine_details` SET `qt` = `qt` + :qt WHERE `medicine_id` = :medicineId AND `packing` = :packing";
            $action = 'updated';
        } else {
            // Insert a new record
            $query = "INSERT INTO `tbl_medicine_details` (`medicine_id`, `packing`, `qt`) VALUES (:medicineId, :packing, :qt)";
            $action = 'added';
        }

        // Prepare and execute the query
        $stmtDetails = $con->prepare($query);
        $stmtDetails->execute([':medicineId' => $medicineId, ':packing' => $packing, ':qt' => $qt]);

   

        $record_id = $con->lastInsertId();

 
        $affectedRecordName = getAffectedRecordName('tbl_medicine_details', $record_id, $con);

     
        $userId = $_SESSION['admin_id']; 
        $action = "Add Medicine Stock";
        $description = "Added Medicine Stock  $affectedRecordName";
        logAuditTrail($userId, $action, $description, 'tbl_medicine_details', $record_id, $con);



        $con->commit();

        $_SESSION['status'] = "Medicine stock successfully $action.";
        $_SESSION['status_code'] = "success";
    } catch (PDOException $ex) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $ex->getMessage();
        $_SESSION['status_code'] = "error";
    }

    header("location:medicine_details.php");
    exit;
}




if (isset($_POST['updateStock'])) {

    $user_id = $_SESSION['admin_id'];
    $medicine_id = $_POST['medicine'];
    $packing = $_POST['packing'];
    $quantity = $_POST['qt'];
    $med_detailsID = $_POST['medicineStock'];

    $con->beginTransaction();
    try {
        // Fetch current values for audit logging
        $selectQuery = "SELECT medicine_id, packing, qt FROM tbl_medicine_details WHERE med_detailsID = :id";
        $selectStmt = $con->prepare($selectQuery);
        $selectStmt->execute([':id' => $med_detailsID]);
        $oldValues = $selectStmt->fetch(PDO::FETCH_ASSOC);

        // Prepare old and new values for audit log
        $old_value = json_encode($oldValues);
        $new_value = json_encode(['medicine_id' => $medicine_id, 'packing' => $packing, 'qt' => $quantity]);

        // Insert into audit log
        $auditQuery = "INSERT INTO tbl_audit_log (user_id, action, table_name, record_id, old_value, new_value) VALUES (?, 'UPDATE', 'tbl_medicine_details', ?, ?, ?)";
        $auditStmt = $con->prepare($auditQuery);
        $auditStmt->execute([$user_id, $med_detailsID, $old_value, $new_value]);

        // Update record
        $query = "UPDATE tbl_medicine_details 
                  SET packing = :packing, qt = :quantity 
                  WHERE med_detailsID = :med_detailsID";
        $stmt = $con->prepare($query);
        $stmt->execute(array(':packing' => $packing, ':quantity' => $quantity, ':med_detailsID' => $med_detailsID));


        $affectedRecordName = getAffectedRecordName('tbl_medicine_details', $med_detailsID, $con);

        // Log the action in the audit trail
        $userId = $_SESSION['admin_id'];
        $action = "Update Medicine Stock";
        $description = "Updated Medicine Stock $affectedRecordName";
        logAuditTrail($userId, $action, $description, 'tbl_medicine_details', $med_detailsID, $con);

        $con->commit();
        $_SESSION['status'] = "Medicine stock updated successfully.";
        $_SESSION['status_code'] = "success";
        header('location: medicine_details.php');
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
        header('location: medicine_details.php');
        exit();
    }
}






$medicines = getMedicines($con);

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        .dropdown-menu {
            --bs-dropdown-min-width: 18rem;

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
                                        / Medicine
                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    Medicine Stock
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

                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                <i class="icon-plus"></i> Add
                                            </button>

                                        </div>
                                    </div>



                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Add Medicine Stock</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" id="addStock" novalidate>
                                                        <div class="mb-3 row">
                                                            <label for="medicine" class="col-sm-3 col-form-label text-center">Select Medicine <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select id="medicine" name="medicine" class="form-select" required>
                                                                    <?php echo $medicines; ?>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Please select a Medicine.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="packing" class="col-sm-3 col-form-label text-center">Packing <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="packing" class="form-control" required>
                                                                <div class="invalid-feedback">
                                                                    Packing is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="qt" class="col-sm-3 col-form-label text-center">Quantity <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="number" min="0" name="qt" class="form-control" required>
                                                                <div class="invalid-feedback">
                                                                    Please input a valid number.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="submit" class="btn btn-info">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="editStock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Medicine Stock</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" id="UpdatedStock" novalidate>
                                                        <div class="mb-3 row">
                                                            <label for="editmedicine" class="col-sm-3 col-form-label text-center">Select Medicine <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <select id="editmedicine" name="medicine" class="form-select" required>
                                                                    <?php echo $medicines; ?>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Please select a Medicine.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="packing" class="col-sm-3 col-form-label text-center">Packing <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="packing" name="packing" class="form-control" required>
                                                                <div class="invalid-feedback">
                                                                    Packing is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="qt" class="col-sm-3 col-form-label text-center">Quantity <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="number" id="qt" name="qt" min="0" class="form-control" required>
                                                                <div class="invalid-feedback">
                                                                    Please input a valid number.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="medicineStock" id="medicineStock">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="updateStock" class="btn btn-info">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- delete start -->
                                    <!-- <div class="modal fade" id="delete_medStock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete_medStock"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="controller/delete_medDetails.php">
                                                        <input type="hidden" id="deleteid" name="deleteid">

                                                        <h4>Are you sure you want to this Medicine Stock?</h4>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Close</button>

                                                            <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- delete end -->




                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="medicine_details" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Medicine Name</th>
                                                        <th>Packing</th>
                                                        <th>Stock</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    <?php
                                                    $query = "SELECT m.*, md.*
                                                    FROM `tbl_medicines` AS m
                                                    JOIN `tbl_medicine_details` AS md ON m.medicineID = md.medicine_id
                                                    WHERE m.status = 1
                                                    ORDER BY m.medicineID ASC, md.med_detailsID DESC;";
                                                    try {

                                                        $stmtDetails = $con->prepare($query);
                                                        $stmtDetails->execute();
                                                    } catch (PDOException $ex) {

                                                        $message = 'Error: ' . $ex->getMessage();
                                                    }
                                                    ?>
                                                </thead>
                                                <tbody> <?php
                                                        $serial = 0;
                                                        while ($row = $stmtDetails->fetch(PDO::FETCH_ASSOC)) {
                                                            $serial++;
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $serial; ?></td>
                                                            <td><?php echo $row['medicine_name']; ?></td>
                                                            <td><?php echo $row['packing']; ?></td>
                                                            <td><?php echo $row['qt']; ?></td>


                                                            <td class="text-center">
                                                                <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $row['med_detailsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Edit">
                                                                    <i class="icon-edit"></i>
                                                                </button>
                                                                <!-- <button class="btn btn-outline-danger btn-sm delete" data-id="<?php echo $row['med_detailsID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-danger" data-bs-title="Delete">
                                                                    <i class="icon-trash"></i>
                                                                </button> -->


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
    <!-- <script src="assets/library/bootstrap-5/bootstrap.bundle.min.js"></script> -->
    <script src="../assets/library/dselect.js"></script>

    <script>
        var select_box_element = document.querySelector('#medicine,#editmedicine');

        dselect(select_box_element, {
            search: true
        });
    </script>


    <script>
        $(document).ready(function() {
            $("#medicine_details").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [10, 20, 50, 100],
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('form[novalidate]');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');
                    }
                }, false);
            });
        });
    </script>
    <script>
        $(function() {
            $('.edit').click(function(e) {
                e.preventDefault();
                $('#editStock').modal('show');
                var id = $(this).data('id'); // Ensure this data-id corresponds to med_detailsID
                getRow(id);
            });

            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete_medStock').modal('show');
                var id = $(this).data('id');
                $('#deleteid').val(id);
            });

            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'medicine_details.php',
                    data: {
                        med_detailsID: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Response from server:", response);
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#medicineStock').val(response.med_detailsID);
                            $('#editmedicine').val(response.medicine_id).change(); // Use medicine_id here
                            $('#packing').val(response.packing);
                            $('#qt').val(response.qt);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                    }
                });
            }
        });
    </script>






</body>



</html>