<?php


// if (isset($_POST['update_admin'])) {
//     // Get form data
//     $username = $_POST['Username'];
//     $password = $_POST['password'];
//     $firstname = $_POST['f_name'];
//     $lastname = $_POST['l_name'];
//     $photo = $_FILES['avatar']['name'];
//     $hiddenId = $_POST['hidden_id'];
//     $sql = "SELECT user.*, personnel.*, position.*, user.UserType AS UserType 
// 	FROM `tbl_users` AS user
// 				INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
// 				INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
// 				WHERE user.`userID` = :admin_id";
//     $stmt = $con->prepare($sql);
//     $stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);
//     $stmt->execute();
//     $admin = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (password_verify($password, $admin['password'])) {

//         if (!empty($photo)) {

//             if ($photo != $admin['profile_picture']) {
//                 move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'user_images/admin/' . $photo);
//                 $filename = $photo;
//             } else {
//                 $filename = $admin['profile_picture']; 
//             }
//         } else {
//             $filename = $admin['profile_picture']; 
//         }


//         if ($password == $admin['password']) {
//             $password = $admin['password'];
//         } else {
//             $password = password_hash($password, PASSWORD_DEFAULT);
//         }


//         $data = [
//             'username' => $username,
//             'password' => $password,
//             'first_name' => $firstname,
//             'last_name' => $lastname,
//             'avatar' => $filename
//         ];


//         $sql = "UPDATE tbl_users SET 
//                 user_name = '{$data['username']}',
//                 password = '{$data['password']}',
//                 first_name = '{$data['first_name']}',
//                 last_name = '{$data['last_name']}',
//                 avatar = '{$data['avatar']}'
//                 WHERE userID = {$_SESSION['admin_id']}";


//         if ($con->query($sql)) {

//             $_SESSION['status'] = "Admin profile updated successfully.";
//             $_SESSION['status_code'] = "success";

//         } else {

//             $_SESSION['status'] = "Failed to update admin profile.";
//             $_SESSION['status_code'] = "error";
// 	
// 			exit();
//         }
//     } else {

//         $_SESSION['status'] = "Incorrect password.";
//         $_SESSION['status_code'] = "error";
//      

//     }
// }
if (isset($_POST['update_admin'])) {
    // Get form data
    $username = $_POST['Username'];
    $password = $_POST['password'];
    $firstname = $_POST['f_name'];
    $lastname = $_POST['l_name'];
    $photo = $_FILES['avatar']['name'];
    $hiddenId = $_POST['hidden_id'];

    // Process profile picture upload
    if (!empty($photo)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], 'user_images/admin/' . $photo);
        $filename = $photo;
    } else {
        $filename = $admin['profile_picture'];
    }

    // Check if the password field is empty
    if (!empty($password)) {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Keep the existing password
        $hashedPassword = $admin['password'];
    }

    // Update user data
    $sql = "UPDATE `tbl_users` AS u
            INNER JOIN `tbl_personnel` AS p ON u.personnel_id = p.personnel_id
            INNER JOIN `tbl_position` AS pos ON pos.personnel_id = pos.position_id
            SET 
            u.`user_name` = :username,
            u.`password` = :password,
            p.`first_name` = :firstname,
            p.`last_name` = :lastname,
            u.`profile_picture` = :avatar
            WHERE u.`userID` = :admin_id";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':avatar', $filename);
    $stmt->bindParam(':admin_id', $_SESSION['admin_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Admin profile updated successfully.";
        $_SESSION['status_code'] = "success";
        ?>
        <script>
            window.location.href = 'dashboard.php';
        </script>
        <?php
        exit();
    } else {
        $_SESSION['status'] = "Failed to update admin profile.";
        $_SESSION['status_code'] = "error";
        ?>
        <script>
            window.location.href = 'dashboard.php';
        </script>
        <?php
        exit();
    }
}


?>



<div class="app-header d-flex align-items-center">

	<!-- Toggle buttons start -->
	<div class="d-flex">
		<button class="btn btn-outline-success toggle-sidebar" id="toggle-sidebar">
			<i class="icon-menu"></i>
		</button>
		<button class="btn btn-outline-danger pin-sidebar" id="pin-sidebar">
			<i class="icon-menu"></i>
		</button>
	</div>
	<!-- Toggle buttons end -->

	<!-- App brand sm start -->
	<!-- <div class="app-brand-sm d-md-none d-sm-block">
	<a href="home.php">
		<img src="#" >
	</a>
</div> -->
	<!-- App brand sm end -->

	<!-- Search container start -->

	<!-- Search container end -->

	<!-- App header actions start -->
	<div class="header-actions">
		<div class="d-md-flex d-none gap-2">

			<br><br><br>
			<div class="dropdown ms-3">
				<a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

					<img src="<?php echo (!empty($admin['profile_picture'])) ? 'user_images/admin/' . $admin['profile_picture'] : 'user_images/admin/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
					<div class="d-flex flex-column">

						<span><?php echo $admin['first_name'] . ' ' . $admin['last_name']; ?></span>

					</div>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-sm shadow-sm gap-3">
						<a class="dropdown-item d-flex align-items-center py-2" href="#profile" type="button" id="userProfileBtn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#profile">
							<i class="icon-gitlab fs-4 me-3"></i>User Profile
						</a>

						<a class="dropdown-item d-flex align-items-center py-2" href="logout.php"><i class="icon-log-out fs-4 me-3"></i>Logout</a>
					</div>
				</a>

			</div>
		</div>

	</div>
	<!-- App header actions end -->


</div>

<div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="profile">
					Admin Profile
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<form method="POST" enctype="multipart/form-data">

					<input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $admin['userID']; ?>">
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">First Name</label>
						<div class="col-sm-8">

							<input type="text" value="<?php echo $admin['first_name']; ?>" id="f_name" name="f_name" class="form-control" value="" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Last Name</label>
						<div class="col-sm-8">
							<input type="text" id="l_name" name="l_name" class="form-control" value="<?php echo $admin['last_name']; ?>" required>
						</div>
					</div>

					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Username</label>
						<div class="col-sm-8">
							<input type="text" id="Username" name="Username" class="form-control" value="<?php echo $admin['user_name']; ?>" required>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Password</label>
						<div class="col-sm-8">
							<input type="password" id="password" name="password" class="form-control">
						</div>
					</div>

					<div class="mb-3 row">
						<label for="formFile" class="col-sm-3 col-form-label text-center">Profile Picture</label>
						<div class="col-sm-8 ">
							<input class="form-control" id="avatar" name="avatar" type="file">

						</div>
					</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn " data-bs-dismiss="modal">
					Close
				</button>
				<button type="submit" id="update_admin" name="update_admin" class="btn btn-primary">
					Save
				</button>

			</div>
		</div>

		</form>
	</div>
</div>