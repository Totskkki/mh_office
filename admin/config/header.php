<?php

if (isset($_POST['update_admin'])) {
	// Get form data
	$username = $_POST['Username'];
	$password = $_POST['password'];
	$firstname = $_POST['f_name'];
	$lastname = $_POST['l_name'];
	$photo = $_FILES['avatar']['name'];
	$hiddenId = $_POST['hidden_id'];


	if (!empty($photo)) {
		move_uploaded_file($_FILES['avatar']['tmp_name'], '../user_images/' . $photo);
		$filename = $photo;
	} else {
		$filename = $admin['profile_picture'];
	}


	if (!empty($password)) {

		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	} else {

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
            p.`lastname` = :lastname,
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



// // Get today's day of the week (e.g., "MONDAY")
// $today = strtoupper(date('l'));
// $currentDate = date('Y-m-d');

// // Query to fetch schedules

// $query = "SELECT date_schedule FROM tbl_doctor_schedule WHERE date_schedule >= ? ORDER BY date_schedule LIMIT 10";
// $stmt = $con->prepare($query);
// $stmt->execute([$currentDate]);

// $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($schedules);

?>
<style>
	.app-header {
		padding: 0 2.5rem;
		background: #fff;
	}
</style>

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
			<br><br>
			<div class="dropdown ms-3 mt-2">

				<?php
				try {
					// Fetch the total number of upcoming non-duty schedules
					$today = date('Y-m-d'); // Get today's date
					$queryTotal = "
                    SELECT COUNT(*) AS total 
                    FROM `tbl_doctor_schedule` 
                    WHERE `is_available` = 0 
                    AND `date_schedule` >= :today
                ";
					$stmtTotal = $con->prepare($queryTotal);
					$stmtTotal->execute(['today' => $today]);
					$docscheds = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
				} catch (PDOException $ex) {
					echo "An error occurred: " . $ex->getMessage();
					exit;
				}
				?>
				<a class="dropdown-toggle position-relative action-icon" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="icon-bell fs-5 lh-1"></i>
					<span class="count rounded-circle bg-danger"><?php echo $docscheds; ?></span>
				</a>
				<br>

				<div class="dropdown-menu dropdown-menu-end dropdown-menu-md shadow-sm">
					<h5 class="fw-semibold px-3 py-2 m-0">Notifications</h5>

					<?php
					try {
						// Fetch the details for each non-duty schedule
						$queryDetails = "SELECT s.*, position.*, personnel.*,user.*,
                                        CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS doctorsname
                                        FROM tbl_doctor_schedule AS s
                                        LEFT JOIN tbl_users AS user ON user.userID = s.userID
                                        LEFT JOIN tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                                        LEFT JOIN tbl_position AS position ON user.position_id = position.position_id
										WHERE s.`is_available` = 0
										AND s.`date_schedule` >= :today
										ORDER BY s.`date_schedule` ASC
										LIMIT 10
                    ";
						$stmtDetails = $con->prepare($queryDetails);
						$stmtDetails->execute(['today' => $today]);

						while ($row = $stmtDetails->fetch(PDO::FETCH_ASSOC)) :
							$link = 'doctor_schedule.php?date=' . $row['date_schedule'];
							$formattedDate = date('F j, Y', strtotime($row['date_schedule']));
							$doctorsname = $row['doctorsname'];
							$profilePicture = !empty($row['profile_picture']) ? '../user_images/' . $row['profile_picture'] : '../user_images/doctor.jpg';

					?>
							<a href="<?php echo $link; ?>" class="dropdown-item">
								<div class="d-flex align-items-start py-2">
									<img src="<?php echo $profilePicture; ?>" class="img-fluid me-3 rounded-3" alt="Notification" style="width: 40px; height: 40px;">
									<div class="m-0">
										<h6 class="mb-1 fw-semibold"><?php echo $doctorsname; ?></h6>

										<p class="mb-1 fw-semibold"> <?php echo $formattedDate; ?></p>

										<p class="small m-0 opacity-50"><b><?php echo $row['message']; ?></b></p>
									</div>
								</div>
							</a>
						<?php endwhile; ?>

					<?php
					} catch (PDOException $ex) {
						echo "An error occurred: " . $ex->getMessage();
					}
					?>
				</div>

			</div>
			<div class="dropdown ms-3">
				<a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

					<img src="<?php echo (!empty($admin['profile_picture'])) ? '../user_images/' . $admin['profile_picture'] : '../user_images/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
					<div class="d-flex flex-column">

						<span><?php echo $admin['first_name'] . ' ' . $admin['lastname']; ?></span>

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
							<input type="text" id="l_name" name="l_name" class="form-control" value="<?php echo $admin['lastname']; ?>" required>
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
				<button type="submit" id="update_admin" name="update_admin" class="btn btn-info">
					Update
				</button>

			</div>
		</div>

		</form>
	</div>
</div>
<!-- 
<script>
	function fetchSchedules() {
		fetch('header.php')
			.then(response => response.json())
			.then(data => {
				const scheduleContainer = document.getElementById('scheduleContainer');
				scheduleContainer.innerHTML = ''; // Clear existing content

				data.forEach(schedule => {
					// Format the schedule card
					const scheduleCard = document.createElement('div');
					scheduleCard.classList.add('schedule-card');

					const date = new Date(schedule.date + ' ' + schedule.time);
					const formattedDate = date.toLocaleString();

					scheduleCard.innerHTML = `
                    <h3>Dr. ${schedule.userID}</h3>
                    <p>Date: ${formattedDate}</p>
                    <p>Status: ${schedule.is_available}</p>
                `;

					scheduleContainer.appendChild(scheduleCard);
				});
			})
			.catch(error => console.error('Error fetching schedules:', error));
	}

	// Fetch schedules every minute
	setInterval(fetchSchedules, 60000);
	fetchSchedules(); // Initial call
</script> -->