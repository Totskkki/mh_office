<?php
ob_start();
$message = '';

// if (isset($_POST['update_profile'])) {
// 	$displayName = trim($_POST['display_name']);
// 	$userName = trim($_POST['username']);
// 	$password = trim($_POST['password']);
// 	$email = trim($_POST['Email']);
// 	$contact = trim($_POST['contact']);
// 	$hiddenId = $_POST['hidden_id'];

// 	$profilePicture = basename($_FILES["update_pic"]["name"]);
// 	$targetFile =  time() . $profilePicture;
// 	$status = move_uploaded_file($_FILES["update_pic"]["tmp_name"],
// 		'user_images/' . $targetFile
// 	);


// 	$encryptedPassword = md5($password);

// 	if ($displayName != '' && $userName != '' && $password != '' && $status != '') {

// 		$updateUserQuery = "UPDATE `users` set `display_name` = '$displayName' ,`user_name` = '$userName', `password` = 
// 	 '$encryptedPassword' , `profile_picture` = '$targetFile',`contact` = '$contact',`email`='$email'
// 	 where `id` = $hiddenId";
// 	} elseif ($displayName !== '' && $userName !== '' && $password !== '') {

// 		$updateUserQuery = "UPDATE `users` set `display_name` = '$displayName' ,`user_name` = '$userName' , `password` = 
// 	 '$encryptedPassword' ,`contact` = '$contact',`email`='$email'
// 	 where `id` = $hiddenId";
// 	} elseif ($displayName !== '' && $userName !== '' && $status !== '') {

// 		$updateUserQuery = "UPDATE `users` set `display_name` = '$displayName' , `user_name` = '$userName' , `profile_picture` = '$targetFile ' ,`contact` = '$contact',`email`='$email'
// 	  where `id` = $hiddenId";
// 	} else {
// 		//showCustomMessage("please fill");
// 	}

// 	try {
// 		$con->beginTransaction();
// 		$stmtUpdateUser = $con->prepare($updateUserQuery);
// 		$stmtUpdateUser->execute();


// 		$con->commit();
// 		echo "<script>alert('user update successfully');</script>";
// 		$message = "user update successfully";
// 		echo "<script>window.location.href = 'profile.php?id=$hiddenId&message=$message';</script>";

//         exit; 
// 	} catch (PDOException $ex) {
// 		$con->rollback();
// 		echo $ex->getTraceAsString();
// 		echo $ex->getMessage();
// 		exit;
// 	}

// }




if (isset($_POST['update_profile'])) {

    // 	$return = $_GET['update_profile'];

    // }
    // else{
    // 	$return = 'home.php';
    // }

    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $userName = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['Email']);
    $contact = trim($_POST['contact']);
    $hiddenId = $_POST['hidden_id'];

    // Check if a new image file is uploaded
    if (!empty($_FILES["update_pic"]["name"])) {
        // New image file is uploaded
        $profilePicture = basename($_FILES["update_pic"]["name"]);
        $targetFile =  time() . $profilePicture;
        $status = move_uploaded_file(
            $_FILES["update_pic"]["tmp_name"],
            'user_images/' . $targetFile
        );
    } else {

        try {
            $query = "SELECT `profile_picture` FROM `tbl_users` WHERE `id` = :id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $targetFile = $user['profile_picture'];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }
    }


    if (empty($password)) {

        try {
            $query = "SELECT `password` FROM `tbl_users` WHERE `id` = :id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $encryptedPassword = $user['password'];
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }
    } else {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    }


    $updateUserQuery = "UPDATE `tbl_users` SET `first_name` = '$first_name',
        `middle_name`='$middle_name',`last_name`='$last_name',
     `user_name` = '$userName', `password` = '$encryptedPassword', 
     `profile_picture` = '$targetFile', `contact` = '$contact', 
     `email`='$email', `status` = 'Active' WHERE `id` = $hiddenId";

    try {
        $con->beginTransaction();
        $stmtUpdateUser = $con->prepare($updateUserQuery);
        $stmtUpdateUser->execute();
        $con->commit();
        $message = "User updated successfully";
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
