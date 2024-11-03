<?php
include 'config/connection.php';

include 'common_service/common_functions.php';
include('config/checklogin.php');
check_login();

if (isset($_POST['update_home'])) {
    $hiddenId = $_POST['hiddenId'];
    $sidebartext = trim($_POST['sidetext']);
    $home_img = null;
    $uploadSuccess = false; // Track if the image was uploaded successfully

    // Check if a file was uploaded
    if (isset($_FILES['homeimage']) && $_FILES['homeimage']['error'] == 0) {
        $target_dir = "logo/";
        $home_img = basename($_FILES['homeimage']['name']);
        $target_file = $target_dir . $home_img;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['homeimage']['tmp_name'], $target_file)) {
            echo "The file has been uploaded.";
            $uploadSuccess = true;
        } else {
            echo "Error: There was an issue moving the file to the target directory.";
            $home_img = null;
        }
    } elseif (isset($_FILES['homeimage']) && $_FILES['homeimage']['error'] !== 0) {
        // Additional error cases if needed
        echo "Error: File upload error code " . $_FILES['homeimage']['error'];
    }

    // Database operations
    $checkQuery = "SELECT userpageID FROM tbl_user_page WHERE userID = :id";
    $stmt = $con->prepare($checkQuery);
    $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
    $stmt->execute();
    $userpageRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userpageRow) {
        $updateQuery = "UPDATE tbl_user_page SET sidebar = :sidebartext, home_img = COALESCE(:homeimg, home_img) WHERE userID = :id";
        $stmt = $con->prepare($updateQuery);
        $stmt->bindParam(':sidebartext', $sidebartext);
        $stmt->bindParam(':homeimg', $home_img);
        $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
        $stmt->execute();
        $userpageID = $userpageRow['userpageID'];
    } else {
        $insertQuery = "INSERT INTO tbl_user_page (home_img, sidebar, userID) VALUES (:homeimg, :sidebartext, :userID)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bindParam(':sidebartext', $sidebartext);
        $stmt->bindParam(':homeimg', $home_img);
        $stmt->bindParam(':userID', $hiddenId, PDO::PARAM_INT);
        $stmt->execute();
        $userpageID = $con->lastInsertId();
    }

    // Update userpageID in tbl_users
    $updateUserQuery = "UPDATE tbl_users SET userpageID = :userpageID WHERE userID = :id";
    $stmt = $con->prepare($updateUserQuery);
    $stmt->bindParam(':userpageID', $userpageID, PDO::PARAM_INT);
    $stmt->bindParam(':id', $hiddenId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0 || $uploadSuccess) {
        $_SESSION['status'] = "User page updated successfully.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error updating record.";
        $_SESSION['status_code'] = "error";
    }
    header('Location: profile.php?id=' . urlencode($hiddenId));
    exit();
}


	

	// If user ID is set in GET request
	if (isset($_GET['id'])) {
		$userId = $_GET['id'];

		// Query to fetch user details and associated page details
		$query = "SELECT 
                    user.*, personnel.*, position.*, p.home_img, p.sidebar
                FROM 
                    tbl_users AS user
                    LEFT JOIN 
                    tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
                    LEFT JOIN 
                    tbl_position AS position ON user.position_id = position.position_id
                    LEFT JOIN tbl_user_page AS p ON user.userID = p.userID

                WHERE 
                    user.userID = :id";

		$stmt = $con->prepare($query);
		$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
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
					<a href="home.php">
						<img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
					</a>
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


					<?php


					}

					?>

					<!-- Container starts -->
					<div class="container-fluid">


						<div class="row">
							<div class="col-12 col-xl-12">
								<!-- Breadcrumb start -->
								<ol class="breadcrumb mb-1">
									<li class="breadcrumb-item">
										<a href="home.php">Home</a>

									</li>

									<li class=" breadcrumb-active">

									</li>
								</ol>
								<!-- Breadcrumb end -->
								<h2 class="mb-2">Profile Settings</h2>
								<h6 class="mb-4 fw-light">

								</h6>
							</div>
						</div>



						<div class="row">
							<div class="col-12">
								<div class="card mb-4">
									<div class="card-body">
										<div class="custom-tabs-container">
											<ul class="nav nav-tabs" id="customTab2" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab" aria-controls="oneA" aria-selected="true">Profile Settings</a>
												</li>

											</ul>
											<div class="tab-content h-350">
												<div class="tab-pane fade show active" id="oneA" role="tabpanel">
													<!-- Row start -->
													<div class="row">


														<?php if (isset($row)) : ?>
															<div class="col-sm-4 col-12">

																<form method="POST" enctype="multipart/form-data">

																	<input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $row['userID']; ?>">

																	<div id="update-profile" class="mb-3">

																		<div id="update_pic" class="dropzone sm needsclick dz-clickable">
																			<!-- File input for selecting image -->
																			<input type="file" id="imageInput" name="update_pic" style="display: none;" onchange="displaySelectedImage(this,'selectedImage')" />
																			<!-- Image display area -->
																			<div class="dz-message needsclick">
																				<!-- Button to trigger file input click -->
																				<button type="button" class="dz-button" onclick="document.getElementById('imageInput').click();">

																				</button>
																				<!-- Display selected image -->
																				<?php if (isset($row['profile_picture'])) : ?>
																					<img id="selectedImage" src="user_images/<?php echo $row['profile_picture']; ?>" alt="Selected Image" style="max-width: 100%; max-height: 100%; cursor: pointer;" onclick="document.getElementById('imageInput').click();" />
																				<?php else : ?>
																					<img id="selectedImage" src="#" alt="Selected Image" style="display: none; max-width: 100%; max-height: 100%;" />
																				<?php endif; ?>
																			</div>
																		</div>


																	</div>
															</div>


															<div class="col-sm-8 col-12">
																<div class="row">

																	<div class="col-6">
																		<!-- Form Field Start -->

																		<div class="mb-3">

																			<label for="text" class="form-label">Full Name</label>
																			<input type="text" class="form-control form-control-sm" id="first_name" name="first_name" value="<?php echo ucwords($row['first_name']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Last Name</label>
																			<input type="text" class="form-control form-control-sm" id="last_name" name="last_name" value="<?php echo ucwords($row['lastname']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Contact</label>
																			<input type="text" min="0" class="form-control form-control-sm" id="contact" name="contact" value="<?php echo ($row['contact']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Address</label>
																			<input type="text" class="form-control form-control-sm" value="<?php echo ucwords($row['address']) ?>" id="address" name="address" />

																		</div>

																	</div>
																	<div class="col-6">
																		<!-- Form Field Start -->
																		<div class="mb-3">
																			<label for="text" class="form-label">Middle Name</label>
																			<input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name" value="<?php echo ucwords($row['middlename']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Username</label>
																			<input type="text" class="form-control form-control-sm" id="username" name="username" value="<?php echo ($row['user_name']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Email</label>
																			<input type="email" class="form-control form-control-sm" id="Email" name="Email" value="<?php echo ($row['email']) ?>" />
																		</div>
																		<div class="mb-3">
																			<label for="text" class="form-label">Password</label>
																			<input type="password" class="form-control form-control-sm" id="password" name="password" />
																			<i>Leave if blank if you dont want to update your password</i>
																		</div>
																		<div class="invalid-feedback">Password must be at least 6 characters long.</div>

																	</div>
																</div>
															</div>
													</div>

													<!-- Row end -->

												</div>

											</div>
											<?php ?>


										</div>
										<div class="d-flex gap-2 justify-content-end mb-2">
											<button type="submit" id="update_profile" name="update_profile" class="btn btn-info">
												<i class="fa fa-sync"></i> Update
											</button>
										</div>

										<?php require 'controller/update_profile.php'; ?>
										</form>
									</div>






								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Home Setting</h5>
									</div>

									<div class="card-body">

										<!-- Row start -->
										<form method="POST" enctype="multipart/form-data">
											<div class="row mb-3">
												<label for="text" class="col-sm-3 col-form-label">Sidebar Text</label>
												<div class="col-sm-4">
													<input type="text" class="form-control" id="sidetext" name="sidetext" value="<?php echo htmlspecialchars($row['sidebar'] ?? ''); ?>">
												</div>
											</div>
											<input type="hidden" id="hiddenId" name="hiddenId" value="<?php echo htmlspecialchars($row['userID']); ?>">
											<div class="row mb-3">
												<label for="text" class="col-sm-3 col-form-label">Home Image</label>

												<div class="col-sm-4 col-12">
													<div id="update_pic" class="dropzone sm needsclick dz-clickable">
														<!-- File input for selecting image -->
														<input type="file" id="homeImageInput" name="homeimage" style="display: none;" onchange="displaySelectedImage(this, 'homeImageDisplay')" />
														<!-- Image display area -->
														<div class="dz-message needsclick">
															<!-- Button to trigger file input click -->
															<button type="button" class="dz-button" onclick="document.getElementById('homeImageInput').click();">
																Select Home Image
															</button>
															<!-- Display selected image -->
															<?php if (isset($row['home_img'])) : ?>
																<img id="homeImageDisplay" src="logo/<?php echo htmlspecialchars($row['home_img']); ?>" alt="Selected Image" style="max-width: 100%; max-height: 100%; cursor: pointer;" onclick="document.getElementById('homeImageInput').click();" />
															<?php else : ?>
																<img id="homeImageDisplay" src="#" alt="Selected Image" style="display: none; max-width: 100%; max-height: 100%;" />
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>

											<button type="submit" id="update_home" name="update_home" class="btn btn-info float-end">
												<i class="fa fa-sync"></i> Update
											</button>
										</form>
										<!-- Row end -->
									<?php else : ?>
										<p>No user details found.</p>
									<?php endif; ?>
									</div>
									<!-- body end -->
								</div>
							</div>
						</div>



					</div>






				</div>
			</div>
			<!-- App body ends -->



			<!-- App footer start -->
			<?php include './config/footer.php';


			?>
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

	<script src="assets/inputmask/jquery.inputmask.min.js"></script>

	


	<script>
		$(document).ready(function() {

			$('#contact').inputmask('+639999999999');
		});
	</script>
	<!-- <script>
	
		function displaySelectedImage(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
				
					document.getElementById('selectedImage').src = e.target.result;
					
					document.getElementById('selectedImage').style.display = 'block';
				};
			
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script> -->
	<script>
		function displaySelectedImage(input, imageId) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					var imgElement = document.getElementById(imageId);
					if (imgElement) {
						imgElement.src = e.target.result;
						imgElement.style.display = 'block';

					}
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>



</body>



</html>