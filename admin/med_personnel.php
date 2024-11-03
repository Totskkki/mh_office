<?php
include './config/connection.php';

include './common_service/common_functions.php';

if (isset($_POST['save_user'])) {
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $uname = trim($_POST['uname']);
    $lname = trim($_POST['lname']);
    $uname = ucwords(strtolower($uname));
    $pass = trim($_POST['pass']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $Role = trim($_POST['Role']);
    $status = trim($_POST['status']);
    $finalimage = $_FILES['profile']['name'];
    if (!empty($finalimage)) {
        move_uploaded_file($_FILES['profile']['tmp_name'], '../user_images/' . $finalimage);
    }



    if ($fname != '' && $uname != '' && $pass != '' && $contact != '' && $email != '' && $Role != '') {
        // Check if email or username already exists
        $stmtCheck = $con->prepare("SELECT * FROM tbl_users WHERE email = :email OR user_name = :uname OR first_name = :fname");
        $stmtCheck->execute(['email' => $email, 'uname' => $uname, 'fname' => $fname]);
        $rowCount = $stmtCheck->rowCount();
        if ($rowCount > 0) {
            $_SESSION['status'] = "Email or Username already used by another user.";
            $_SESSION['status_code'] = "error";
            header('location: user.php');
            exit();
        }

        // Hash the password
        $bcrypt_password = password_hash($pass, PASSWORD_BCRYPT);

        // Prepare data for insertion
        $data = [
            'first_name' => $fname,
            'middle_name' => $mname,
            'last_name' => $lname,
            'user_name' => $uname,
            'password' => $bcrypt_password,
            'profile_picture' => $finalimage,
            'role' => $Role,
            'contact' => $contact,
            'email' => $email,
            'status' => $status
        ];

        // Call the insert function directly
        $result = insert('tbl_users', $data, $con);
        if ($result) {
            $_SESSION['status'] = "User successfully added.";
            $_SESSION['status_code'] = "success";
            header('location: user.php'); // Redirect after successful addition
            exit();
        } else {
            $_SESSION['status'] = "Something went wrong.";
            $_SESSION['status_code'] = "danger";
            header('location: user.php'); // Redirect if insertion failed
            exit();
        }
    } else {
        $_SESSION['status'] = "Please fill all the required fields.";
        $_SESSION['status_code'] = "error";
        header('location: user.php'); // Redirect if any required field is empty
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
                                    User List

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

                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add_user">
                                                <i class="icon-file-plus"></i> Add
                                            </button>

                                        </div>
                                    </div>

                                    <div class="modal fade" id="add_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="add_user">
                                                        Add Doctor
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form method="POST" enctype="multipart/form-data">

                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Middle Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Last Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Username</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="password" class="col-sm-3 col-form-label text-center">Password</label>
                                                            <div class="col-sm-8">
                                                                <input type="password" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Contact #</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Email</label>
                                                            <div class="col-sm-8">
                                                                <input type="email" class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label for="text" class="col-sm-3 col-form-label text-center">Status</label>
                                                            <div class="col-sm-5">

                                                                <select name="status" class="form-select" required>
                                                                    <?php echo getstatus(); ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row">
                                                            <label for="formFile" class="col-sm-3 col-form-label text-center">Profile Picture</label>
                                                            <div class="col-sm-8 ">
                                                                <input class="form-control" type="file">
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn " data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" id="save_doctor" name="save_doctor" class="btn btn-primary">
                                                        Save
                                                    </button>

                                                </div>
                                            </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="user_list" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Doctor Name</th>
                                                        <th>Address</th>
                                                        <th>Contact info</th>
                                                        <th>Email</th>

                                                        <th>Specialty</th>

                                                        <th>License No.</th>

                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                    <?php

                                                    $queryUsers = "SELECT user.*,personnel.*, position.*
                                                  FROM `tbl_users` AS user
                                                  LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                                                  LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
                                                  WHERE user.UserType IN ('Doctor')
                                                  ORDER BY user.user_name DESC";

                                                    $stmtUsers = $con->prepare($queryUsers);
                                                    $stmtUsers->execute();
                                                    ?>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $serial = 0;
                                                    while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                                                        $serial++;
                                                    ?>


                                                        </tr>
                                                        <td><?php echo $serial; ?></td>
                                                        <td><?php echo $row['first_name'] . ' ' . ucwords($row['middle_name']) . ' ' . ucwords($row['last_name']); ?></td>
                                                        <td><?php echo $row['address']; ?></td>
                                                        <td><?php echo $row['contact']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['Specialty']; ?></td>
                                                        <td><?php echo $row['LicenseNo']; ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-outline-success btn-sm view" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                                <i class="icon-eye"></i>
                                                            </button>
                                                            <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Edit">
                                                                <i class="icon-edit"></i>
                                                            </button>
                                                            <button class="btn btn-outline-primary btn-sm delete" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Delete">
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