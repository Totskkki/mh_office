<?php
include 'config/connection.php';
include 'common_service/common_functions.php';


if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];

	$query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*
        FROM tbl_patients AS users 
        LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
        LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
        LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
        WHERE users.userID = :user_id
        GROUP BY users.patientID ORDER BY users.patientID DESC";

	$stmtUsers = $con->prepare($query);
	$stmtUsers->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$stmtUsers->execute();

	$patients = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
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
								<h2 class="mb-2">Patient List</h2>
								<h6 class="mb-4 fw-light">
									Mga ipormasyon ng pasyente
								</h6>
							</div>
						</div>


						<!-- Row start -->
						<div class="row">
							<div class="col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Patient List</h5>
									</div>


									<div class="card-body">
										<div class="table-responsive">
											<table id="userpatient_list" class="table table-striped">
												<thead>
													<tr>
														<th>#</th>
														<th>Patient Name</th>
														<th>Address</th>
														<th>Date Of Birth</th>
														<th>Age</th>
														<th>Consultation Purpose</th>
														<th>Current/Old Patient</th>
														<th>Status</th>												
														<th class="text-center">Registered Date</th>
													</tr>
												</thead>
												</tbody>
												<?php

												?>
												<tbody>

													<?php
													if (!empty($patients)) {
														$serial = 0;
														foreach ($patients as $row) {
															$serial++;
													?>

															<tr>
																<td><?php echo $serial; ?></td>
																<td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
																<td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
																<td><?php echo $row['date_of_birth']; ?></td>
																<td><?php echo $row['age']; ?></td>
																<td><?php 
																 if (!isset($row['consultation_purpose']) || empty($row['consultation_purpose'])) {
																	echo '<span class="badge bg-warning">Not specified</span>';
																} else {
																	echo $row['consultation_purpose'];
																}
																 ?></td>
																
																<td>
                                                                <?php 
																if (!isset($row['Nature_Visit']) || empty($row['Nature_Visit'])) {
																	echo '<span class="badge bg-warning">Not specified</span>';
																} elseif ($row['Nature_Visit'] == 'New admission') {
																	echo '<span class="">Current</span>';
																} elseif ($row['Nature_Visit'] == 'New consultation/case') {
																	echo '<span class="">Current</span>';
																} else {
																	echo '<span class="">Old Patient/returning</span>';
																}
																?>
																 </td>

																 <td>
                                                                <?php

                                                                if ($row['transferred'] == 'referred') {
                                                                    echo '<span class="badge bg-success">referred</span>';
                                                                } else {
                                                                    echo '<span class="badge bg-success"></span>';
                                                                }
                                                                ?>
                                                            </td>

															  


																<td><?php echo $row['reg_date']; ?></td>


															</tr>
														<?php
														}
													} else {
														
														?>
														<tr>
															<td colspan="8">No patients found.</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- Row end -->

						</div>
						<!-- Row end -->

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



	<script src="assets/js/moment.min.js"></script>

	<!-- Date Range JS -->
	<script src="assets/vendor/daterange/daterange.js"></script>
	<script src="assets/vendor/daterange/custom-daterange.js"></script>

	<script src="assets/js/moment.min.js"></script>



<script>
       $(function() {
      $("#userpatient_list").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#userpatient_list_wrapper .col-md-6:eq(0)');

    });

        
    </script>




</body>



</html>