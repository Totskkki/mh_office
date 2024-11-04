<?php
include './config/connection.php';

include './common_service/common_functions.php';



if (isset($_POST['userID'])) {
    $id = $_POST['userID'];


    $queryUsers = "
        SELECT user.*, personnel.*, position.*, user.userID, personnel.personnel_id, position.position_id
        FROM tbl_users AS user
        LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
        LEFT JOIN tbl_position AS position ON user.position_id = position.position_id
        WHERE user.userID = :id  and user.UserType !='admin'
    ";


    $stmtUsers = $con->prepare($queryUsers);
    $stmtUsers->execute([':id' => $id]);


    $row = $stmtUsers->fetch(PDO::FETCH_ASSOC);


    if ($row) {
        if (!empty($row['profile_picture'])) {
            $row['profile_picture'] = '../user_images/' . $row['profile_picture'];
        } else {
            $row['profile_picture'] = '../user_images/doctor.jpg';
        }


        echo json_encode($row);
    } else {

        echo json_encode(['error' => 'No data found']);
    }
    exit;
}



if (isset($_POST['save_doctor'])) {

    // Retrieve and trim input values
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $uname = trim($_POST['uname']);
    $role = trim($_POST['role']);
    $positionName = trim($_POST['Position']);
    $Specialty = trim($_POST['Specialty']);
    $ProfessionalType = trim($_POST['Professional']);
    $LicenseNo = trim($_POST['LicenseNo']);
    $Address = trim($_POST['Address']);
    $uname = ucwords(strtolower($uname));
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $status = 'Active';
    $finalimage = $_FILES['profile']['name'];

    // Move uploaded file if it exists
    if (!empty($finalimage)) {
        move_uploaded_file($_FILES['profile']['tmp_name'], '../user_images/' . $finalimage);
    }

    // Check if all required fields are filled
    if ($fname != '' && $uname != '' && $contact != '' && $email != '') {

        // Handle password only if the role is "Doctor"
        if ($role === 'Doctor' && isset($_POST['pass'])) {
            $pass = trim($_POST['pass']);
            $bcrypt_password = password_hash($pass, PASSWORD_ARGON2ID); // Hash the password
        } else {
            $bcrypt_password = null; // Set password to null for non-doctor roles
        }

        // Check for duplicate username or email
        $stmtCheck = $con->prepare("SELECT COUNT(*) AS num 
            FROM tbl_users AS u
            JOIN tbl_personnel AS p ON u.personnel_id = p.personnel_id
            WHERE u.user_name = :uname OR p.email = :email OR (p.first_name = :fname AND p.lastname = :lname)
        ");
        $stmtCheck->execute(['uname' => $uname, 'email' => $email, 'fname' => $fname, 'lname' => $lname]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['num'] > 0) {
            $_SESSION['status'] = "Username or Email already used by another user.";
            $_SESSION['status_code'] = "error";
            header('Location:doctor.php');
            exit();
        }

        $con->beginTransaction();
        try {
            // Insert into tbl_personnel
            $stmtPersonnel = $con->prepare("INSERT INTO tbl_personnel (first_name, middlename, lastname, address, contact, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtPersonnel->execute([$fname, $mname, $lname, $Address, $contact, $email]);
            $personnelId = $con->lastInsertId();

            // Insert into tbl_position
            $stmtPosition = $con->prepare("INSERT INTO tbl_position (personnel_id, positionName, Specialty, ProfessionalType, LicenseNo) VALUES (?, ?, ?, ?, ?)");
            $stmtPosition->execute([$personnelId, $positionName, $Specialty, $ProfessionalType, $LicenseNo]);
            $positionId = $con->lastInsertId();

            // Insert into tbl_users
            $stmtUsers = $con->prepare("INSERT INTO `tbl_users` (`user_name`, `password`, `status`, `profile_picture`, `personnel_id`, `position_id`, `UserType`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtUsers->execute([$uname, $bcrypt_password, $status, $finalimage, $personnelId, $positionId, $role]);

            $con->commit();
            $_SESSION['status'] = "User successfully added.";
            $_SESSION['status_code'] = "success";
?>
            <script>
                window.location.href = 'doctor.php';
            </script>
<?php
            exit();
        } catch (Exception $e) {
            $con->rollBack();
            $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['status_code'] = "danger";
            header('Location:doctor.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Please fill all the required fields.";
        $_SESSION['status_code'] = "error";
        header('Location:doctor.php');
        exit();
    }
}



if (isset($_POST['update_doctor'])) {
    // Retrieve user data from the form
    $user_id = trim($_POST['userid']);
    $persid = trim($_POST['persid']);
    $fname = ucwords(strtolower(trim($_POST['fname'])));
    $mname = ucwords(strtolower(trim($_POST['mname'])));
    $uname = trim($_POST['uname']);
    $lname = ucwords(strtolower(trim($_POST['lname'])));
    $role = trim($_POST['role']);
    $Address = trim($_POST['Address']);
    $pass = trim($_POST['pass']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $Position = trim($_POST['Position']);
    $Specialty = trim($_POST['Specialty']);
    $Professional = trim($_POST['Professional']);
    $LicenseNo = trim($_POST['LicenseNo']);
    $status = trim($_POST['status']);
    $passwordChanged = !empty($pass);

    if ($fname != '' && $uname != '' && $contact != '' && $email != '') {
        $con->beginTransaction();
        try {
            $stmtPersonnel = $con->prepare("
                UPDATE tbl_personnel SET first_name = ?, middlename = ?, lastname = ?, address = ?, contact = ?, email = ?
                WHERE personnel_id = (SELECT personnel_id FROM tbl_users WHERE userID = ?)
            ");
            $stmtPersonnel->execute([$fname, $mname, $lname, $Address, $contact, $email, $user_id]);

            $stmtPosition = $con->prepare("
                UPDATE tbl_position SET personnel_id=?, PositionName=?, Specialty=?, ProfessionalType=?, LicenseNo=?
                WHERE position_id = (SELECT position_id FROM tbl_users WHERE userID = ?)
            ");
            $stmtPosition->execute([$persid, $Position, $Specialty, $Professional, $LicenseNo, $user_id]);

            // Update user data
            $updateUserQuery = "UPDATE tbl_users SET user_name = ?, status = ?, UserType = ?";
            $params = [$uname, $status, $role];

            // Check if a new profile picture is uploaded
            if (!empty($_FILES['Profile']['name'])) {
                $finalimage = $_FILES['Profile']['name'];
                $updateUserQuery .= ", profile_picture = ?";
                $params[] = $finalimage;
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

            $con->commit();
            $_SESSION['status'] = "Doctor information successfully updated.";
            $_SESSION['status_code'] = "success";
            header('location: doctor.php');
            exit();
        } catch (Exception $e) {
            $con->rollBack();
            $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['status_code'] = "danger";
            header('location: doctor.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "Please fill all the required fields.";
        $_SESSION['status_code'] = "error";
        header('location: doctor.php');
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
                                Notifications
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->
                        <div class="row">
								<div class="col-12">
									<div class="card mb-4">
										<div class="card-body">
											<!-- Search container start -->
											<div class="search-container d-sm-block d-none">
												<input type="text" class="form-control" id="search" placeholder="Search" />
												<i class="icon-search"></i>
											</div>
											<!-- Search container end -->

											<!-- Contacts Container Start -->
											<div class="notification-container mt-3">
												<div class="notification-list">
													<div class="bg-primary-light px-3 py-2 m-3 mb-1 rounded-2">
														Today
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user1.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Angelica Ramos</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"Great work. Keep on developing great themes"
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">12:20PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user2.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Brenden Wagner</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"Great theme."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">12:30PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user3.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Cedric Kelly</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For dedication and hard work."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">02:45PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user4.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Paul Byrd</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For creativity and outstanding work."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">03:20PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user5.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Sonya Frost</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For quality work and effort."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">03:20PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="bg-primary-light px-3 py-2 m-3 mb-1 rounded-2">
														Yesterday
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user3.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Cedric Kelly</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For dedication and hard work."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">02:45PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user2.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Paul Byrd</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For creativity and outstanding work."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">03:20PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
													<div class="px-3 py-2 d-flex align-items-center gap-3 notify-block">
														<img src="assets/images/user5.png" alt="Contact Avatar" class="img-3x rounded-circle" />
														<div class="flex-1 flex flex-col">
															<h6 class="fw-semibold mb-1">Sonya Frost</h6>
															<p class="mb-1">
																<small class="opacity-50">Appriciated the project.</small>
																"For quality work and effort."
															</p>
															<p class="small mb-1">
																<span class="fw-semibold">03:20PM</span>
																<span class="opacity-50">March 25th, 2022</span>
															</p>
														</div>
													</div>
												</div>
											</div>
											<!-- Contacts Container End -->
										</div>
									</div>
								</div>
							</div>
                        <!-- Row start -->
                       







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



</body>



</html>