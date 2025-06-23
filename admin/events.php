<?php
include './config/connection.php';

include './common_service/common_functions.php';

include './config/session.php';



if (isset($_POST['dsID'])) {
    $id = $_POST['dsID'];


    $queryEvents = "SELECT * FROM tbl_announcements WHERE announceID = :id";
    $stmtds = $con->prepare($queryEvents);
    $stmtds->execute([':id' => $id]);


    $row = $stmtds->fetch(PDO::FETCH_ASSOC);


    echo json_encode($row);
    exit;
}

if (isset($_POST['add_Event'])) {


  

    $event_date = $_POST['man_date'];

    $dateArr = explode("/", $event_date);

    if (count($dateArr) == 3) {
        $event_date = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];
    } else {
        // Handle error for incorrect date format
        $event_date = null;
    }

    $title = $_POST['title'];
    $description = $_POST['des'];

    $duplicateCheckQuery = "SELECT COUNT(*) FROM tbl_announcements WHERE title = ?";
    $duplicateCheckStmt = $con->prepare($duplicateCheckQuery);
    $duplicateCheckStmt->execute([$title]);
    $duplicateCount = $duplicateCheckStmt->fetchColumn();

    if ($duplicateCount > 0) {
        $_SESSION['status'] = "The title already exists. Please choose a different title.";
        $_SESSION['status_code'] = "warning";
        header('location: events.php');
        exit();
    }

    $con->beginTransaction();
    try {
        $query = "INSERT INTO tbl_announcements (date, title, details) VALUES (?, ?, ?)";

        $stmt = $con->prepare($query);
        $stmt->execute([$event_date, $title, $description]);

        $record_id = $con->lastInsertId();

 
        $affectedRecordName = getAffectedRecordName('tbl_announcements', $record_id, $con);

     
        $userId = $_SESSION['admin_id']; 
        $action = "Add Events";
        $description = "Added Events  $affectedRecordName";

        logAuditTrail($userId, $action, $description, 'tbl_announcements', $record_id, $con);

        $con->commit();
        $_SESSION['status'] = "Schedule added successfully.";
        $_SESSION['status_code'] = "success";
        header('location: events.php');
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
        header('location: events.php');
        exit();
    }
}
if (isset($_POST['editevent'])) {
    $user_id = $_SESSION['admin_id'];
    $announceID = $_POST['announID'];
    $event_date = $_POST['man_date'];

    $dateArr = explode("/", $event_date);

    if (count($dateArr) == 3) {
        $event_date = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];
    } else {
        // Handle error for incorrect date format
        $event_date = null;
    }

    $title = $_POST['title'];
    $description = $_POST['des'];

    $con->beginTransaction();
    try {
        // Fetch current values for audit logging
        $selectQuery = "SELECT date, title, details FROM tbl_announcements WHERE announceID = :id";
        $selectStmt = $con->prepare($selectQuery);
        $selectStmt->execute([':id' => $announceID]);
       

        // Update the event record
        $updateQuery = "UPDATE tbl_announcements SET date = ?, title = ?, details = ? WHERE announceID = ?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->execute([$event_date, $title, $description, $announceID]);

       

        $affectedRecordName = getAffectedRecordName('tbl_announcements', $announceID, $con);

        // Log the action in the audit trail
        $userId = $_SESSION['admin_id'];
        $action = "Update Events";
        $description = "Updated Events $affectedRecordName";
        logAuditTrail($userId, $action, $description, 'tbl_announcements', $announceID, $con);
  

        $con->commit();
        $_SESSION['status'] = "Event updated successfully.";
        $_SESSION['status_code'] = "success";
        header('location: events.php');
        exit();
    } catch (Exception $e) {
        $con->rollBack();
        $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
        $_SESSION['status_code'] = "danger";
        header('location: events.php');
        exit();
    }
}



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
                                        <a href="dashboard.php">Home</a>

                                    </li>
                                    <li class=" breadcrumb-active">

                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2"></h2>
                                <h6 class="mb-4 fw-light">
                                    Events List
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

                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                                <i class="icon-file-plus"></i> Add
                                            </button>

                                        </div>
                                    </div>

                                    <!-- add start -->
                                    <div class="modal fade" id="addEventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Event</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="addEventForm" method="POST" enctype="multipart/form-data" novalidate>
                                                        <div class="mb-3 row">
                                                            <label for="man_date" class="col-sm-3 col-form-label text-center">Date <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group date" id="man_date" data-target-input="nearest">
                                                                    <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#man_date" name="man_date" data-toggle="datetimepicker" autocomplete="off" required />
                                                                    <div class="input-group-append" data-target="#man_date" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Please select a date.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="title" class="col-sm-3 col-form-label text-center">Title <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="title" name="title" class="form-control" required>
                                                                <div class="invalid-feedback">
                                                                    Title is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="des" class="col-sm-3 col-form-label text-center">Description <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" name="des" id="des" cols="30" rows="3" required></textarea>
                                                                <div class="invalid-feedback">
                                                                    Please input a description.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" id="add_Event" name="add_Event" class="btn btn-info">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- add start -->


                                    <!-- edit start -->
                                    <div class="modal fade" id="edit_events" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="edit_events">Update Event</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editEvent" method="POST" enctype="multipart/form-data" novalidate>
                                                        <div class="mb-3 row">
                                                            <label for="man_date" class="col-sm-3 col-form-label text-center">Date <span class="text-danger">*</span> </label>
                                                            <div class="col-sm-8">
                                                                <div class="input-group date" id="updateEvents" data-target-input="nearest">
                                                                    <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#updateEvents" name="man_date" autocomplete="off" required />
                                                                    <div class="input-group-append" data-target="#updateEvents" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                    <div class="invalid-feedback">
                                                                        Please select a date.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="edittitle" class="col-sm-3 col-form-label text-center">Title <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="edittitle" name="title" class="form-control" required />
                                                                <div class="invalid-feedback">
                                                                    Title is required.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="editdes" class="col-sm-3 col-form-label text-center">Description <span class="text-danger">*</span></label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" name="des" id="editdes" cols="30" rows="5" required></textarea>
                                                                <div class="invalid-feedback">
                                                                    Please input a description.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" id="editevent" name="editevent" class="btn btn-info">Update</button>
                                                        </div>
                                                        <input type="hidden" id="announID" name="announID">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- edit end -->

                                    <!-- delete start -->
                                    <div class="modal fade" id="delete_events" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete_events"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="controller/delete_events.php">
                                                        <input type="hidden" id="deleteid" name="deleteid">

                                                        <h4>Are you sure you want to the doctor schedule?</h4>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Close</button>

                                                            <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete end -->

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="event_list" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-calendar me-2 fs-4"></span>
                                                                Date
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-add_task me-2 fs-4"></span>
                                                                Task
                                                            </div>
                                                        </th>
                                                        
                                                        <th>
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-add_task me-2 fs-4"></span>
                                                                Details
                                                            </div>
                                                        </th>

                                                        <th>
                                                            <div class="d-flex align-items-center">
                                                                <span class="icon-settings me-2 fs-4"></span>
                                                                Action
                                                            </div>
                                                        </th>

                                                    </tr>
                                                    <?php

                                                    $queryEvents = "SELECT * FROM tbl_announcements    
                                                    ORDER BY announceID  DESC";

                                                    $stmtevents = $con->prepare($queryEvents);
                                                    $stmtevents->execute();
                                                    ?>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $serial = 0;
                                                    while ($row = $stmtevents->fetch(PDO::FETCH_ASSOC)) {
                                                        $serial++;
                                                    ?>


                                                        </tr>
                                                        <td><?php echo $serial; ?></td>

                                                        <td><?php echo $row['date']; ?></td>
                                                        <td><?php echo $row['title']; ?></td>
                                                        <td><?php echo $row['details']; ?></td>
                                                        <td>

                                                            <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $row['announceID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Edit">
                                                                <i class="icon-edit"></i>
                                                            </button>
                                                            <button class="btn btn-outline-primary btn-sm delete" data-id="<?php echo $row['announceID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Delete">
                                                                <i class="icon-trash"></i>
                                                            </button>


                                                        </td>
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
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('addEventForm');
            var editForm = document.getElementById('editEvent');


            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);

            editForm.addEventListener('submit', function(event) {
                if (!editForm.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                editForm.classList.add('was-validated');
            }, false);

            $('#man_date,#updateEvents').datetimepicker({
                format: 'L',
                minDate: new Date
            });

        });
    </script>


    <script>
        $(function() {

            $('.edit').click(function(e) {
                e.preventDefault();
                $('#edit_events').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });
            $('.delete').click(function(e) {
                e.preventDefault();
                $('#delete_events').modal('show');
                var id = $(this).data('id');
                $('#deleteid').val(id);
            });

            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'events.php',
                    data: {
                        dsID: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        
                        $('#announID').val(response.announceID);


                        var manufDate = new Date(response.date);
                        var formattedManufDate = (manufDate.getMonth() + 1) + '/' + manufDate.getDate() + '/' + manufDate.getFullYear();
                        $('#updateEvents input').val(formattedManufDate);

                        $('#edittitle').val(response.title);
                        $('#editdes').val(response.details);

                    }
                });
            }
        });
    </script>


    <script>
        $(document).ready(function() {

            $("#event_list").DataTable({
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