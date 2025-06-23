<?php
include './config/connection.php';

include './common_service/common_functions.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');

if (isset($_POST['userID'])) {

    $id = $_POST['userID'];
    $queryUsers = "SELECT user.*, personnel.*, position.*
                       FROM `tbl_users` AS user
                       LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                       LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
                       WHERE user.userID = :id";

    $stmtUsers = $con->prepare($queryUsers);
    $stmtUsers->execute([':id' => $id]);
    $row = $stmtUsers->fetch(PDO::FETCH_ASSOC);


    if ($row && !empty($row['profile_picture']) && file_exists('../user_images/' . $row['profile_picture'])) {
        $row['profile_picture'] = '../user_images/' . $row['profile_picture'];
    } else {
        $row['profile_picture'] = '../user_images/profile.jpg'; // Default image path
    }
    echo json_encode($row);
    exit;
}



// if (isset($_POST['update_user'])) {
//     // Retrieve user data from the form
//     // var_dump($_POST);

//     $user_id = trim($_POST['user_id']);
//     $fname = trim($_POST['name']);
//     $fname = ucwords(strtolower($fname));

//     $mname = trim($_POST['mid']);
//     $mname = trim($_POST['mid']);
//     $mname = ucwords(strtolower($mname));

//     $uname = trim($_POST['u_name']);

//     $lname = trim($_POST['last_name']);
//     $lname = ucwords(strtolower($lname));

//     $Address = trim($_POST['address']);
//     $pass = trim($_POST['passw']);
//     $contact = trim($_POST['contac']);
//     $email = trim($_POST['Email']);
//     $Role = trim($_POST['role']);
//     $status = trim($_POST['Status']);
//     $finalimage = $_FILES['Profile']['name'];
//     $passwordChanged = !empty($pass);

//     $existing_image = trim($_POST['existing_image']);


//     if (!empty($_FILES['Profile']['name']) && $_FILES['Profile']['error'] == UPLOAD_ERR_OK) {
//         $filename = $finalimage;
//     } else {
//         $finalimage = $existing_image;
//     }


//     // Prepare to update user data
//     if ($fname != '' && $uname != '' && $contact != '' && $email != '' && $Role != '') {
//         // Check for duplicate username or email, ignoring the current user


//         $con->beginTransaction();
//         try {
//             // Update personnel data
//             $stmtPersonnel = $con->prepare("
//                 UPDATE tbl_personnel SET first_name = ?, middlename = ?, lastname = ?, address = ?, contact = ?, email = ?
//                 WHERE personnel_id = (SELECT personnel_id FROM tbl_users WHERE userID = ?)
//             ");
//             $stmtPersonnel->execute([$fname, $mname, $lname, $Address, $contact, $email, $user_id]);

//             // Update user data
//             $updateUserQuery = "UPDATE tbl_users SET user_name = ?, status = ?, profile_picture = ?, UserType = ?";
//             $params = [$uname, $status, $finalimage, $Role];


//             if ($passwordChanged) {
//                 $bcrypt_password = password_hash($pass, PASSWORD_BCRYPT);
//                 $updateUserQuery .= ", password = ?";
//                 $params[] = $bcrypt_password;
//             }

//             $updateUserQuery .= " WHERE userID = ?";
//             $params[] = $user_id;

//             $stmtUsers = $con->prepare($updateUserQuery);
//             $stmtUsers->execute($params);

//             $con->commit();
//             $_SESSION['status'] = "User successfully updated.";
//             $_SESSION['status_code'] = "success";
//             header('location: user.php');
//             exit();
//         } catch (Exception $e) {
//             $con->rollBack();
//             $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
//             $_SESSION['status_code'] = "danger";
//             header('location: user.php');
//             exit();
//         }
//     } else {
//         $_SESSION['status'] = "Please fill all the required fields.";
//         $_SESSION['status_code'] = "error";
//         header('location: user.php');
//         exit();
//     }
// }


if (isset($_POST['update_user'])) {
    // Retrieve user data from the form
    $user_id = trim($_POST['user_id']);
    $fname = trim($_POST['name']);
    $fname = ucwords(strtolower($fname));

    $mname = trim($_POST['mid']);
    $mname = ucwords(strtolower($mname));

    $uname = trim($_POST['u_name']);

    $lname = trim($_POST['last_name']);
    $lname = ucwords(strtolower($lname));

    $Address = trim($_POST['address']);
    $pass = trim($_POST['passw']);
    $contact = trim($_POST['contac']);
    $email = trim($_POST['Email']);
    $Role = trim($_POST['role']);
    $status = trim($_POST['Status']);
    // $finalimage = $_FILES['Profile']['name'];
    $passwordChanged = !empty($pass);

    // $existing_image = trim($_POST['existing_image']);

    // Use the existing image if no new image is uploaded


    // Prepare to update user data
    if ($fname != '' && $uname != '' && $contact != '' && $email != '' && $Role != '') {
        $con->beginTransaction();
        try {
            // Update personnel data
            $stmtPersonnel = $con->prepare("
                UPDATE tbl_personnel SET first_name = ?, middlename = ?, lastname = ?, address = ?, contact = ?, email = ?
                WHERE personnel_id = (SELECT personnel_id FROM tbl_users WHERE userID = ?)
            ");
            $stmtPersonnel->execute([$fname, $mname, $lname, $Address, $contact, $email, $user_id]);

            // Update user data
            // $updateUserQuery = "UPDATE tbl_users SET user_name = ?, status = ?, profile_picture = ?, UserType = ?";
            // $params = [$uname, $status, $finalimage, $Role];

            $updateUserQuery = "UPDATE tbl_users SET user_name = ?, status = ?, UserType = ?";
            $params = [$uname, $status, $Role];

            // if (!empty($_FILES['Profile']['name'])) {
            //     $finalimage = $_FILES['Profile']['name'];
            //     $updateUserQuery .= ", profile_picture = ?";
            //     $params[] = $finalimage;
            // }
            if (!empty($_FILES['Profile']['name'])) {
                $profilePicture = $_FILES['Profile'];
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $fileExtension = strtolower(pathinfo($profilePicture['name'], PATHINFO_EXTENSION));
                $uploadDir = '../user_images/';
                $newFileName = uniqid() . '.' . $fileExtension;

                if (in_array($fileExtension, $allowedExtensions) && $profilePicture['size'] <= 2000000) {
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $uploadPath = $uploadDir . $newFileName;
                    if (move_uploaded_file($profilePicture['tmp_name'], $uploadPath)) {
                        $updateUserQuery .= ", profile_picture = ?";
                        $params[] = $newFileName;
                    } else {
                        throw new Exception("Failed to upload profile picture.");
                    }
                } else {
                    throw new Exception("Invalid file type or size for profile picture.");
                }
            }

            if ($passwordChanged) {
                $bcrypt_password = password_hash($pass, PASSWORD_BCRYPT);
                $updateUserQuery .= ", password = ?";
                $params[] = $bcrypt_password;
            }

            $updateUserQuery .= " WHERE userID = ?";
            $params[] = $user_id;

            $stmtUsers = $con->prepare($updateUserQuery);
            $stmtUsers->execute($params);



            $affectedRecordName = getAffectedRecordName('tbl_users', $user_id, $con);
    
         
            $userId = $_SESSION['admin_id']; 
            $action = "Updated Users";
            $description = "Updated User,  $affectedRecordName";
    
            logAuditTrail($userId, $action, $description, 'tbl_users', $user_id, $con);



            $con->commit();
            $_SESSION['status'] = "User successfully updated.";
            $_SESSION['status_code'] = "success";
            header('location: user.php');
            exit();
        } catch (Exception $e) {
            $con->rollBack();
            $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['status_code'] = "danger";
            header('location: user.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Please fill all the required fields.";
        $_SESSION['status_code'] = "error";
        header('location: user.php');
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



                                    <!-- ======================edit end================ -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="user_list" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Picture</th>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                    <?php


                                                    $queryUsers = "SELECT user.*,personnel.*, position.*
                                                        FROM `tbl_users` AS user
                                                        LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                                                        LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
                                                        WHERE user.UserType IN ('RHU', 'BHW') 
                                                        -- and user.UserType !='admin'
                                                        ORDER BY user.userID DESC";

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
                                                        <tr>

                                                            <td><?php echo $serial; ?></td>
                                                            <td><img src="<?php echo (!empty($row['profile_picture'])) ? '../user_images/' . $row['profile_picture'] : '../user_images/profile.jpg'; ?>" width="30px" height="30px" class="img-thumbnail rounded-circle p-0 border user-img"></td>


                                                            <td><?php echo $row['first_name'] . ' ' . ucwords($row['middlename']) . ' ' . ucwords($row['lastname']); ?></td>

                                                            <td><?php echo $row['user_name']; ?></td>
                                                            <td><?php echo $row['UserType']; ?></td>
                                                            <td>
                                                                <?php

                                                                if ($row['status'] == 'Active') {
                                                                    echo '<span class="badge bg-success">Active</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-warning">Inactive</span>';
                                                                }
                                                                ?>
                                                            </td>


                                                            <!-- <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="statusToggle<?php echo $row['userID']; ?>" <?php echo ($row['status'] == 'active') ? 'checked' : ''; ?> data-user-id="<?php echo $row['userID']; ?>" onchange="toggleUserStatus(this)">
                                                            <label class="form-check-label" for="statusToggle<?php echo $row['userID']; ?>">
                                                                <?php echo ($row['status'] == 'active') ? 'Active' : 'Inactive'; ?>
                                                            </label>
                                                        </div>
                                                    </td> -->


                                                            <td class="text-center">
                                                                <button class="btn btn-outline-success btn-sm view" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                                    <i class="icon-eye"></i>
                                                                </button>

                                                                <button class="btn btn-outline-info btn-sm edit" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Edit">
                                                                    <i class="icon-edit"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm delete" data-id="<?php echo $row['userID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Delete">
                                                                    <i class="icon-trash"></i>
                                                                </button>


                                                            </td>
                                                        </tr>
                                                    <?php  } ?>
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


    <?php include './modal/user_modal.php'; ?>
    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>






    <script>
        $(document).ready(function() {

            $('#contact').inputmask('+639999999999');
            $('#contac').inputmask('+639999999999');
        });
    </script>

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


    <script>
        function previewImage() {
            var file = document.getElementById("Profile").files;
            if (file.length > 0) {
                var fileReader = new FileReader();

                fileReader.onload = function(event) {
                    document.getElementById("profile_img").setAttribute("src", event.target.result);
                };

                fileReader.readAsDataURL(file[0]);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#user_list tbody").on('click', '.edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id, 'edit');
                $('#edit_user').modal('show');
            });

            $("#user_list tbody").on('click', '.view', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id, 'view');
                $('#view_user').modal('show');
            });

            $("#user_list tbody").on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#deleteid').val(id);
                $('#delete').modal('show');
            });
        });

        function getRow(id, mode) {
            $.ajax({
                type: 'POST',
                url: 'user.php',
                data: {
                    userID: id
                },
                dataType: 'json',
                success: function(response) {
                    if (mode === 'edit') {
                        // Populate edit fields
                        $('#user').val(response.userID);
                        $('#name').val(response.first_name);
                        $('#mid').val(response.middlename);
                        $('#last_name').val(response.lastname);
                        $('#u_name').val(response.user_name);
                        $('#contac').val(response.contact);
                        $('#Email').val(response.email);
                        $('#address').val(response.address);
                        $('#role_val').val(response.UserType).html(response.UserType);
                        $('#Status_val').val(response.status).html(response.status);

                        // Set profile image for editing
                        $('#profile_img').attr('src', response.profile_picture);
                    } else if (mode === 'view') {
                        // Populate view fields
                        $('#view_profile_img').attr('src', response.profile_picture);
                        $('#view_name').text(response.first_name + ' ' + response.middlename + ' ' + response.lastname);
                        $('#view_u_name').text(response.user_name);
                        $('#view_contac').text(response.contact);
                        $('#view_Email').text(response.email);
                        $('#view_address').text(response.address);
                        $('#view_role').text(response.UserType);
                        $('#view_status').text(response.status);
                    }
                },
                error: function(xhr, status, error) {
                   
                }
            });
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('addUser');
            var edit = document.getElementById('editUser');


            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            edit.addEventListener('submit', function(event) {
                if (!edit.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                edit.classList.add('was-validated');
            }, false);



        });
    </script>




</body>



</html>