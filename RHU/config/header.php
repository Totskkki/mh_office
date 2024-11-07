<?php

// if (!isset($_SESSION['user_id'])) {



//     header("Location: ../index.php");
//     exit; 
// }

if (isset($_POST['update_rhu'])) {
	// Get form data
	$username = $_POST['Username'];
	$password = $_POST['password'];
	$firstname = $_POST['f_name'];
	$lastname = $_POST['l_name'];
	$email = $_POST['email'];

	$photo = $_FILES['avatar']['name'];
	$hiddenId = $_POST['hidden'];

	// Process profile picture upload
	if (!empty($photo)) {
		move_uploaded_file($_FILES['avatar']['tmp_name'], '../user_images/' . $photo);
		$filename = $photo;
	} else {
		$filename = $user['profile_picture'];
	}


	if (!empty($password)) {

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	} else {

		$hashedPassword = $user['password'];
	}

	// Update user data
	$sql = "UPDATE `tbl_users` AS u
            INNER JOIN `tbl_personnel` AS p ON u.personnel_id = p.personnel_id
            INNER JOIN `tbl_position` AS pos ON pos.personnel_id = pos.position_id
            SET 
            u.`user_name` = :username,
            u.`password` = :password,
            p.`first_name` = :firstname,
            p.`lastname` = :lastname,
			p.`email` = :email,
            u.`profile_picture` = :avatar
            WHERE u.`userID` = :user_id";

	$stmt = $con->prepare($sql);
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $hashedPassword);
	$stmt->bindParam(':firstname', $firstname);
	$stmt->bindParam(':lastname', $lastname);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':avatar', $filename);
	$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

	if ($stmt->execute()) {
		$_SESSION['status'] = "RHU profile updated successfully.";
		$_SESSION['status_code'] = "success";
?>
		<script>
			window.location.href = 'dashboard-mho.php';
		</script>
	<?php
		exit();
	} else {
		$_SESSION['status'] = "Failed to update RHU profile.";
		$_SESSION['status_code'] = "error";
	?>
		<script>
			window.location.href = 'dashboard-mho.php';
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

	<!-- App header actions start -->
	<div class="header-actions">

		<div class="d-md-flex d-none gap-2">

			<br>
			<?php

			try {
				// Fetch total number of pending complaints
				$queryTotal = "SELECT COUNT(*) AS total FROM `tbl_complaints` WHERE `status` = 'Pending'";
				$stmtTotal = $con->prepare($queryTotal);
				$stmtTotal->execute();
				$totalComplaints = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

				// Fetch complaint details categorized
				$queryDetails = "
					SELECT 
						CASE 
							WHEN consultation_purpose LIKE  consultation_purpose LIKE '%maternity%' OR consultation_purpose LIKE '%birthing%' THEN 'Maternity Care'
							WHEN consultation_purpose LIKE '%prenatal%' THEN 'Prenatal'
							WHEN consultation_purpose LIKE '%check%' THEN 'Checkup'
							WHEN consultation_purpose LIKE '%vaccination%' OR consultation_purpose LIKE '%immunization%' THEN 'Vaccination and Immunization'
							WHEN consultation_purpose LIKE '%animal bite%' OR consultation_purpose LIKE '%animal care%' THEN 'Animal Bite and Care'
							ELSE 'Other'
						END AS category,
						COUNT(*) AS count 
					FROM tbl_complaints 
					WHERE status = 'Pending' 
					GROUP BY category
				";
				$stmtDetails = $con->prepare($queryDetails);
				$stmtDetails->execute();
			} catch (PDOException $ex) {
				echo "An error occurred: " . $ex->getMessage();
				exit;
			}
			?>

			<div class="dropdown ms-3 mt-2">

				<a class="dropdown-toggle position-relative action-icon" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

					<?php



					?>
					<i class="icon-bell fs-5 lh-1"></i>
					<span class="count rounded-circle bg-danger"><?php echo $totalComplaints; ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-end dropdown-menu-md shadow-sm">
					<h5 class="fw-semibold px-3 py-2 m-0">Notifications</h5>
					<?php while ($row = $stmtDetails->fetch(PDO::FETCH_ASSOC)) : ?>
						<?php

						$link = '#';
						switch ($row['category']) {
							case 'Maternity Care':
								$image = 'maternitiy.png';
								$description = 'You have new maternity care updates.';
								$link = 'maternity.php';
								break;
							case 'Prenatal':
								$image = 'maternitiy.png';
								$description = 'You have new prenatal care updates.';
								$link = 'prenatal.php';
								break;
							case 'Checkup':
								$image = 'heart.png';
								$description = 'Checkup notifications pending.';
								$link = 'checkup.php';
								break;
							case 'Vaccination and Immunization':
								$image = 'vaccination.png';
								$description = 'Vaccination schedules to review.';
								$link = 'vaccination.php';
								break;
							case 'Animal Bite and Care':
								$image = 'animal.png';
								$description = 'Animal bite & care';
								$link = 'animal_bite.php';
								break;
							default:
								continue 2;
						}
						?>
						<a href="<?php echo $link; ?>" class="dropdown-item">
							<div class="d-flex align-items-start py-2">
								<img src="../user_images/notifications/<?php echo $image; ?>" class="img-fluid me-3 rounded-3" alt="<?php echo htmlspecialchars($row['category']); ?>" style="width: 40px; height: 40px;">
								<div class="m-0">
									<h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($row['category']); ?></h6>
									<p class="mb-1"><?php echo $description; ?></p>
									<p class="small m-0 opacity-50"><b> <?php echo $row['count']; ?></b></p>
								</div>
							</div>
						</a>
					<?php endwhile; ?>
				</div>

			</div>


		</div>
		<div class="dropdown ms-3">

			<a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

				<img src="<?php echo (!empty($user['profile_picture'])) ? '../user_images/' . $user['profile_picture'] : '../user_images/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
				<div class="d-flex flex-column">

					<span><?php echo $user['first_name'] . ' ' . $user['lastname']; ?></span>

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




<div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="profile">
					RHU Profile
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<form method="POST" enctype="multipart/form-data" id="rhuprofile" novalidate>

					<input type="hidden" name="hidden" id="hidden" value="<?php echo $user['userID']; ?>">
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">First Name <span class="text-danger">*</span></label>
						<div class="col-sm-8">

							<input type="text" value="<?php echo $user['first_name']; ?>" id="f_name" name="f_name" class="form-control" value="" required pattern="[a-zA-Z\s\.]+">
							<div class="invalid-feedback">
							First Name is required.
                             </div>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Last Name <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="l_name" name="l_name" class="form-control" value="<?php echo $user['lastname']; ?>" required pattern="[a-zA-Z\s\.]+">
							<div class="invalid-feedback">
						    	Last Name is required.
                             </div>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Email <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
							<div class="invalid-feedback">
							Email is required.
                             </div>
						</div>
					</div>

					<div class="mb-3 row">
						<label for="text" class="col-sm-3 col-form-label text-center">Username <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" id="Username" name="Username" class="form-control" value="<?php echo $user['user_name']; ?>" required>
							<div class="invalid-feedback">
							Username is required.
                             </div>
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
				<button type="submit" id="update_rhu" name="update_rhu" class="btn btn-primary">
					Save
				</button>

			</div>
		</div>

		</form>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {

		var form = document.getElementById('rhuprofile');



		form.addEventListener('submit', function(event) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add('was-validated');
		}, false);

	});
</script>