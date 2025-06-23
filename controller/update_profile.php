<?php
ob_start();

if (isset($_POST['update_profile'])) {
	$first_name = trim($_POST['first_name']);
	$middle_name = trim($_POST['middle_name']);
	$last_name = trim($_POST['last_name']);
	$userName = trim($_POST['username']);
	$password = trim($_POST['password']);
	$email = trim($_POST['Email']);
	$contact = trim($_POST['contact']);
	$address = trim($_POST['address']);
	$photo = $_FILES['update_pic']['name'];
	$hiddenId = $_POST['hidden_id'];


	$query = "SELECT `profile_picture` FROM `tbl_users` WHERE `userID` = :id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!empty($photo)) {
		move_uploaded_file($_FILES['update_pic']['tmp_name'], 'user_images/' . $photo);
		$filename = $photo;
	} else {
		$filename = $user['profile_picture'];
	}

	if (empty($password)) {
		
		try {
			$query = "SELECT `password` FROM `tbl_users` WHERE `userID` = $hiddenId";
			$passwordResult = $con->query($query);
			$user = $passwordResult->fetch(PDO::FETCH_ASSOC);
			$encryptedPassword = $user['password'];
		} catch (PDOException $ex) {
			echo $ex->getMessage();
			exit;
		}
	} else {
		
		$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
	}

	
	$updateUserQuery = "UPDATE `tbl_users` AS user
                        INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                        SET personnel.first_name = '$first_name',
						personnel.middlename = '$middle_name',
						personnel.lastname = '$last_name',
                            user.user_name = '$userName',
                            user.password = '$encryptedPassword',
                            user.profile_picture = '$filename',
                            personnel.contact = '$contact',			
                            personnel.email = '$email',
                            personnel.address = '$address',
                            user.status = 'Active'
                        WHERE user.userID = $hiddenId";

	try {
		$con->beginTransaction();
		$con->exec($updateUserQuery);
		$con->commit();
		$_SESSION['status'] = "User updated successfully";
		$_SESSION['status_code'] = "success";
?>
		<script>
			window.location.href = 'profile.php?id=<?php echo $hiddenId; ?>';
		</script>
	<?php
		exit();
	} catch (PDOException $ex) {
		$con->rollback();
		$_SESSION['status'] = "Error: " . $ex->getMessage();
		$_SESSION['status_code'] = "error";
	?>
		<script>
			window.location.href = 'profile.php?id=<?php echo $hiddenId; ?>';
		</script>
<?php
		exit();
	}
}


?>