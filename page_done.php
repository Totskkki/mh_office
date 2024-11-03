
<?php
include 'config/connection.php';
?>

<!DOCTYPE html>
<html lang="en">


<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

		<!-- Meta -->
		
		<link rel="canonical" href="https://www.bootstrap.gallery/">
		
		

		<!-- *************
			************ CSS Files *************
		************* -->
		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="assets/fonts/icomoon/style.css" />

		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/main.min.css" />
		<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
		<!-- *************
			************ Vendor Css Files *************
		************ -->
	</head>

	<body class="bg-one">
		<!-- Container start -->
		<div class="container">

		<?php
				if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
				?>
				

				<?php


				}
				
				?>

			<div class="row justify-content-center">
				<div class="col-lg-6 col-12">
					<div class="my-5 d-flex align-items-center flex-column">
						<img src="logo/1.png" class="img-fluid mb-4" alt="Bootstrap Dashboards" />

						<div class="bg-white rounded-5 p-4">
						<div class="text-center">
							<h1 class="display-5 mb-3 text-info text-uppercase">
								<strong>ALL INFORMATION ARE SAVED! </strong>
								
							</h1>
							<h6 class="mb-4 lh-2">
								Thank you for your cooperation, Please click home button bellow
							</h6>
							<a href="home.php" class="btn btn-info rounded-5 px-4 py-3 shadow">
							
							Go back to Home</a>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Container end -->
		<?php include './config/site_js_links.php'; ?>
	</body>



</html>

