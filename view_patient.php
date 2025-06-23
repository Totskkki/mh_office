<?php
include 'config/connection.php';
include 'common_service/common_functions.php';







if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$query = "SELECT 
    pat.*,fam.*,mem.*,com.*,
    CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, '. ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
    DATE_FORMAT(pat.`date_of_birth`, '%m/%d/%Y') AS `date_of_birth`
FROM 
    `tbl_patients` AS pat
    left JOIN 
    `tbl_familyAddress` AS fam ON pat.`family_address` = fam.`famID`
left JOIN 
    `tbl_membership_info` AS mem ON pat.`membership_info` = mem.`membershipID`
    left  JOIN `tbl_complaints` as com ON pat.`patientID` = com.`patient_id`
WHERE 
    pat.`patientID` = :id";
	$stmt = $con->prepare($query);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$patientData = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch patient details


	$famquery = "SELECT * FROM `tbl_family_members`
     WHERE patient_id  = :id ORDER BY member_id  DESC";
	$stmt = $con->prepare($famquery);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$famqueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$labquery = "SELECT * FROM `tbl_laboratory`
     WHERE patient_id  = :id ORDER BY labid   DESC";
	$stmt = $con->prepare($labquery);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$labqueryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
}




$sqlCheckup = "SELECT * FROM `tbl_checkup`
 
 WHERE `patient_id` = :patient_id ORDER BY `admitted` DESC";
$stmt = $con->prepare($sqlCheckup);
$stmt->bindParam(':patient_id', $id, PDO::PARAM_INT);
$stmt->execute();
$checkups = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sqlbite = "SELECT * FROM `tbl_animal_bite_care`
 
 WHERE `patient_id` = :patient_id ORDER BY `date` DESC";
$stmt = $con->prepare($sqlbite);
$stmt->bindParam(':patient_id', $id, PDO::PARAM_INT);
$stmt->execute();
$animalbites = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sqlbirhting = "SELECT * FROM `tbl_birth_info`
 
 WHERE `patient_id` = :patient_id and birthing_status = 'done' ORDER BY `date` DESC";
$stmt = $con->prepare($sqlbirhting);
$stmt->bindParam(':patient_id', $id, PDO::PARAM_INT);
$stmt->execute();
$birthing = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlPrenatal = "SELECT * FROM `tbl_prenatal`
 WHERE `patient_id` = :patient_id ORDER BY `date` DESC";
$stmt = $con->prepare($sqlPrenatal);
$stmt->bindParam(':patient_id', $id, PDO::PARAM_INT);
$stmt->execute();
$prenatal = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $sqlVaccination = "SELECT i.*, p.* 
                        FROM `tbl_immunization_records` i
                        LEFT JOIN `tbl_patients` p on p.patientID = i.patient_id
                        WHERE i.`patient_id` = :patient_id 
                        GROUP BY i.patient_id
                        ORDER BY i.`immunization_date` DESC";
    
    $stmt = $con->prepare($sqlVaccination);
    $stmt->bindParam(':patient_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $Vaccination = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check the age based on the patient's date of birth
    if (!empty($Vaccination[0]['date_of_birth'])) { 
    	$birthdate = new DateTime($Vaccination[0]['date_of_birth']);
    	$today = new DateTime(); // current date
    	$age = $birthdate->diff($today)->y; // age in years
    } else {
    	$age = 0;
    }
    
    // Determine the immunization record type based on age
    $redirectTo = $age < 2 ? 'controller/child_immunization_record.php' : 'controller/adult_immunization_record.php';

													





?>



<!DOCTYPE html>
<html lang="en">


<head>
	<?php include './config/site_css_links.php'; ?>

	<?php include './config/data_tables_css.php'; ?>
	<title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
	<style>
		.nav-pills .nav-link.active,
		.nav-pills .show>.nav-link {
			color: #ffffff;
			background-color: #2d2d2d;
		}

		a {
			color: #34424F;
		}

		.nav-link {
			display: block;
			padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);
			font-size: var(--bs-nav-link-font-size);
			font-weight: var(--bs-nav-link-font-weight);
			color: #34424F;
			text-decoration: none;
			background: none;
			border: 0;
			transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
		}

		.tab-pane {
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
			align-items: flex-start;
			min-height: 100%;
			/* Ensure it fills the container */
			padding: 15px;
			/* Add padding for readability */
		}
	</style>

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










					<section class="content">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-3">

									<?php if (isset($patientData)) : ?>
										<!-- Profile Image -->
										<div class="card card-primary card-outline">
											<div class="card-body box-profile">
												<div class="text-center">
													<img class="profile-user-img img-fluid img-circle" src="user_images/36147880.jpg" alt="User profile picture" style="width: 30%;height:30%;">
												</div>

												<h3 class="profile-username text-center"><?php echo htmlspecialchars(ucwords($patientData['name'])); ?></h3>

												<p class="text-muted text-center"> Age: <?php echo htmlspecialchars($patientData['age']); ?></p>

												<ul class="list-group list-group-unbordered mb-3">
													<li class="list-group-item">
														<b>Sex: </b> <a class="float-right"><?php echo htmlspecialchars($patientData['gender']); ?></a>
													</li>
													<li class="list-group-item">
														<b>BirthDate: </b> <a class="float-right"> <?php
																									if (!empty($patientData['date_of_birth']) && $patientData['date_of_birth'] != '0000-00-00') {
																										echo htmlspecialchars(date('F j, Y', strtotime($patientData['date_of_birth'])));
																									} else {
																										echo '';
																									}
																									?></a>
													</li>
													<li class="list-group-item">
														<b>Contact Number: </b> <a class="float-right"><?php echo htmlspecialchars($patientData['gender']); ?></a>
													</li>
													<li class="list-group-item">
														<b>Status: </b> <a class="float-right"><?php echo htmlspecialchars($patientData['gender']); ?></a>
													</li>
													<li class="list-group-item">
														<b>Blood Type: </b> <a class="float-right"><?php echo htmlspecialchars($patientData['gender']); ?></a>
													</li>

													<li class="list-group-item">
														<b>Address: </b> <a class="float-right"><?php echo htmlspecialchars('Purok ' . $patientData['purok'] . ', Brgy. ' . $patientData['brgy'] . ', '  . $patientData['city_municipality'] . ', ' . $patientData['province']); ?></a>
													</li>
												</ul>

												<div class="card card-primary">
													<div class="card-header">
														<h3>Records</h3>
													</div>
													<!-- /.card-header -->
													<div class="card-body">


														<ul class="nav nav-pills flex-column" id="Records" role="tablist">

															<li class="nav-item" role="presentation">
																<a class="nav-link active " id="tab-oneA" data-bs-toggle="pill" href="#oneA" role="tab" aria-controls="oneA" aria-selected="false">Check-up</a>
															</li>
															<li class="nav-item" role="presentation">
																<a class="nav-link" id="tab-twoA" data-bs-toggle="pill" href="#twoA" role="tab" aria-controls="twoA" aria-selected="false">Animal-bite & care</a>
															</li>
															<li class="nav-item" role="presentation">
																<a class="nav-link" id="tab-threeA" data-bs-toggle="pill" href="#threeA" role="tab" aria-controls="threeA" aria-selected="false">Immunization & vaccination</a>
															</li>

															<?php
															// Fetch the gender of the patient first
															$query = "SELECT gender FROM tbl_patients WHERE patientID = :id";
															$stmt = $con->prepare($query);
															$stmt->bindParam(':id', $id, PDO::PARAM_INT);
															$stmt->execute();
															$patient = $stmt->fetch(PDO::FETCH_ASSOC);

															// Check if gender is Male
															$isMale = ($patient['gender'] == 'Male' || $patient['gender'] == 'Other');
															?>

															<!-- Prenatal Card -->
															<?php if (!$isMale): ?>
																<!-- Always render the tabs -->
																<li class="nav-item" role="presentation">
																	<a class="nav-link" id="tab-birthing" data-bs-toggle="pill" href="#birthing" role="tab" aria-controls="birthing" aria-selected="false">Birthing</a>
																</li>
																<li class="nav-item" role="presentation">
																	<a class="nav-link" id="tab-Prenatal" data-bs-toggle="pill" href="#Prenatal" role="tab" aria-controls="Prenatal" aria-selected="false">Prenatal</a>
																</li>
															<?php endif; ?>
														</ul>
													</div>

													<!-- /.card-body -->
												</div>


											<?php else : ?>
												<p>No patient details found.</p>
											<?php endif; ?>
											<!-- /.col -->

											<!-- /.col -->
											</div>
											<!-- /.row -->
										</div><!-- /.container-fluid -->

								</div>
								<!-- App container ends -->


								<div class="col-md-6">
									<div class="card">
										<div class="card-body">
											<div class="custom-tabs-container">
												<div class="tab-content ">
													<div class="tab-pane fade show active" id="oneA" role="tabpanel" aria-labelledby="tab-oneA">
														<!-- Check-up content -->
														<div class="row">
															<div class="col-12">
																<h5 class="card-title">Check-up</h5>
																<?php if (!empty($checkups)) { ?>
																	<div class="card">
																		<div class="card-body">
																			<ul class="list-group">
																				<?php foreach ($checkups as $checkup) { ?>
																					<li>
																						<a href="controller/viewcheckup_form.php?id=<?php echo $checkup['checkupID'] ?>" class="btn btn-primary">
																							<?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($checkup['admitted']))); ?>
																						</a>
																					</li>
																				<?php } ?>
																			</ul>
																		</div>
																	</div>
																<?php } else { ?>
																	<p>No check-up records found.</p>
																<?php } ?>
															</div>
														</div>
													</div>
													<div class="tab-pane fade" id="twoA" role="tabpanel" aria-labelledby="tab-twoA">
														<!-- Animal-bite content -->
														<div class="col-12">
															<h5 class="card-title">Animal bite  care</h5>
															<?php if (!empty($animalbites)) { ?>
																<!-- Display birthing records -->
																<div class="card">
																	<div class="card-body">
																		<ul class="list-group">
																			<?php foreach ($animalbites as $animalbite) { ?>
																				<li>

																					<a href="controller/view_animalbite.php?id=<?php echo $animalbite['animal_biteID'] ?>" class="btn btn-primary">
																						<?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($animalbite['date']))); ?>

																					</a>

																				</li>
																			<?php } ?>
																		</ul>
																	</div>
																</div>
															<?php } else { ?>
																<p>No Animal bite records found.</p>
															<?php } ?>
														</div>
													</div>
													
													
													<div class="tab-pane fade" id="threeA" role="tabpanel" aria-labelledby="tab-threeA">
														<!-- Immunization & vaccination content -->
														<div class="col-12">
															<h5 class="card-title">Immunization & vaccination</h5>
															<!-- Card start -->
															<?php if (!empty($Vaccination)) { ?>
																<div class="card">
																	<div class="card-body">
																		<ul class="list-group">
																			<?php foreach ($Vaccination as $Vaccinations) { ?>
																				<li>
																					<a href="<?php echo $redirectTo . '?id=' . $Vaccinations['immunID']; ?>" class="btn btn-primary">
																						<?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($Vaccinations['immunization_date']))); ?>
																					</a>
																				</li>
																			<?php } ?>
																		</ul>
																	</div>
																<?php } else { ?>
																	<p>No Vaccination & Immunization found.</p>
																<?php } ?>
																</div>
																<!-- Card end -->
														</div>
													</div>


													<?php if (!$isMale): ?>
														<!-- Birthing Tab Pane -->
														<div class="tab-pane fade" id="birthing" role="tabpanel" aria-labelledby="tab-birthing">
															<div class="col-12">
																<h5 class="card-title">Birthing</h5>
																<?php if (!empty($birthing)): ?>
																	<!-- Display birthing records -->
																	<div class="card">
																		<div class="card-body">
																			<ul class="list-group">
																				<?php foreach ($birthing as $birth): ?>
																					<li>
																						<a href="controller/view_birth-info.php?id=<?php echo $birth['birth_info_id'] ?>" class="btn btn-primary">
																							<?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($birth['date']))); ?>
																						</a>
																					</li>
																				<?php endforeach; ?>
																			</ul>
																		</div>
																	</div>
																<?php else: ?>
																	<!-- No records message -->
																	<p>No birthing records found.</p>
																<?php endif; ?>
															</div>
														</div>

														<!-- Prenatal Tab Pane -->
														<div class="tab-pane fade" id="Prenatal" role="tabpanel" aria-labelledby="tab-Prenatal">
															<div class="col-12">
																<h5 class="card-title">Prenatal</h5>
																<?php if (!empty($prenatal)): ?>
																	<!-- Display prenatal records -->
																	<div class="card">
																		<div class="card-body">
																			<ul class="list-group">
																				<?php foreach ($prenatal as $pre): ?>
																					<li>
																						<a href="controller/view_prenatal_form.php?id=<?php echo $pre['prenatalID'] ?>" class="btn btn-primary">
																							<?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($pre['date']))); ?>
																						</a>
																					</li>
																				<?php endforeach; ?>
																			</ul>
																		</div>
																	</div>
																<?php else: ?>
																	<!-- No records message -->
																	<p>No prenatal records found.</p>
																<?php endif; ?>
															</div>
														</div>
													<?php endif; ?>


												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

				</div>

				<!-- Page wrapper end -->
				</section>









				<?php include './config/footer.php'; ?>
				<!-- App footer end -->


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