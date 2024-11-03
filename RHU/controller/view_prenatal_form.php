<?php
include '../config/connection.php';

include '../common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';

if (isset($_GET['id'])) {
	$complaintID = $_GET['id'];



	$query = "SELECT a.*, com.*, pat.*, fam.*,mem.*, u.*, per.*,a.date,
	CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`,
	CONCAT(fam.`brgy`, ' ', fam.`purok`, ' ', fam.`province`) as` address`,
	CONCAT(per.`first_name`, ' ', per.`middlename`, ' ', per.`lastname`) AS `personnel_name`
	FROM tbl_prenatal AS a 
	LEFT JOIN tbl_patients AS pat ON a.patient_id = pat.patientID
	LEFT JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
	LEFT JOIN tbl_membership_info AS mem ON pat.Membership_Info = mem.membershipID    
	LEFT JOIN tbl_complaints as com on com.complaintID
	LEFT JOIN tbl_users AS u ON u.userID  = a.attending_physician
	LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id
	WHERE a.prenatalID  = :complaintID";



	$stmt = $con->prepare($query);
	$stmt->bindParam(':complaintID', $complaintID, PDO::PARAM_INT);
	$stmt->execute();

	$f = $stmt->fetch(PDO::FETCH_ASSOC);
	
}




?>


<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Meta -->


<link rel="canonical" href="https://www.bootstrap.gallery/">

<link rel="shortcut icon" href="../../assets/images/favicon.svg" />

<!-- *************
			************ CSS Files *************
		************* -->
<!-- Icomoon Font Icons css -->
<link rel="stylesheet" href="../../assets/fonts/icomoon/style.css" />
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">




<!-- Main CSS -->
<link rel="stylesheet" href="../../assets/css/main.min.css" />

<!-- <link rel="stylesheet" href="dist/js/jquery_confirm/jquery-confirm.css"> -->
<!-- Scrollbar CSS -->
<link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

<!-- Toastify CSS -->
<link rel="stylesheet" href="../../assets/vendor/toastify/toastify.css" />
<link rel="stylesheet" href="../../assets/vendor/daterange/daterange.css" />

<link rel="stylesheet" href="../../assets/vendor/dropzone/dropzone.min.css" />


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="../../assets/daterangepicker/daterangepicker.css">

<link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<link rel="stylesheet" href="../../assets/js/jquery-confirm.min.css">




<head>



	<title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


	<style>
		.form-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
		}

		.patient-info,
		.ultrasound-info,
		.measurements,
		.equivalent-age,
		.report {
			flex: 1 0 45%;
			margin-bottom: 20px;
		}

		.patient-info h3,
		.ultrasound-info h3,
		.measurements h3,
		.equivalent-age h3,
		.report h3 {
			margin-bottom: 10px;
		}

		.measurements-list,
		.equivalent-age-list {
			margin-top: 10px;
		}

		.patient-info p,
		.ultrasound-info p,
		.measurements p,
		.equivalent-age p,
		.report p {
			margin: 5px 0;
		}
	</style>


</head>

<body>
	<!-- Page wrapper start -->
	<div class="page-wrapper">

		<!-- Main container start -->


		<!-- Sidebar wrapper start -->

		<!-- Sidebar wrapper end -->

		<!-- App container starts -->
		<div class="app-container">

			<!-- App header starts -->



			<!-- App header actions end -->

		</div>
		<!-- App header ends -->



		<!-- App body starts -->
		<div class="app-body">

			<!-- <a href="../records_prenatal.php" class="btn btn-primary">
				<i class="icon-chevron-left"></i> Back</i>
			</a> -->
			<button onclick="window.history.back()" class="btn btn-primary">Back</button>

			<div class="container-fluid">


				<div class="row">
					<div class="col-xxl-12">
						<div class="card mb-4">
							<div class="card-body">
								<div class="modal position-static d-block shade-light rounded-3">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class=" p-5">
												<div style="display: flex; align-items: center; justify-content: space-between;">
													<h2 class="fw-bold mb-3 card-title" style="margin: 0;">PRENATAL</h2>
													<!-- <h5 class="form-label" style="margin-left:29rem">Previous</h5>

													<button id="previous-record-btn" class="btn btn-info" style="float: right;"> <i class="icon-chevron-left"></i></button> -->
												</div>

												<hr/>
												<div class="row">
													<h3 class="from-label"><?php echo $f['patient_name'] . ' ' . $f['middle_name'] . ' ' . $f['last_name'] ?>
													 <span class="float-end" id="date">Date: <?php echo date('F j, Y', strtotime($f['date'])); ?></span>
													</h3>


													<div class="col-lg-3 col-sm-4 col-12">
														<div class="mb-3">
															<label class="form-label" for="abc1">Age</label>
															<br>
															<?php echo $f['age']; ?>
														</div>
													</div>
													<div class="col-lg-3 col-sm-4 col-12">
														<div class="mb-3">
															<label class="form-label" for="abc2">Sex</label>
															<br>
															<?php echo $f['gender']; ?>
														</div>
													</div>
													<div class="col-lg-3 col-sm-4 col-12">
														<div class="mb-3">
															<label class="form-label" for="abc3">Civil Status</label>
															<br>
															<?php echo $f['civil_status']; ?>
														</div>
													</div>
													<div class="col-lg-3 col-sm-4 col-12">
														<div class="mb-3">
															<label class="form-label" for="abc4">Date of Birth:</label>
															<br>
															<?php echo $f['date_of_birth']; ?>
														</div>
													</div>



												</div>
												<hr/>
												<div class="form-container">
													<div class="ultrasound-info">
														<h3>Ultrasound Information</h3>
														
														<p><strong>Chief Complaint:</strong> <span id="chief_complaint"><?php echo ucwords($f['chief_complaint']); ?></span></p>
														<p ><strong>Radiologist:</strong ><span id="Radiologist"> <?php echo ucwords($f['radiologist']); ?></span> </p>
														
														<p><strong>Attending Physician:</strong><span id="attending_physician"></span> <?php echo ucwords($f['personnel_name']); ?></p>
														<h4>Evaluation/Interpretation: OBSTETRIC ULTRASOUND</h4>
														<div class="ultrasound-details">
															<p><strong>LMP:</strong> <span id="lmp"><?php echo $f['lmp'] ?></span></p>
															<p><strong>GA by LMP:</strong><span id="ga_by_lmp"> <?php echo $f['ga_by_lmp'] ?></span></p>
															<p><strong>EDC by LMP:</strong><span id="edc_by_lmp"><?php echo $f['edc_by_lmp'] ?></span> </p>
															<p><strong>FHR:</strong> <span id="fhr"><?php echo $f['fhr'] ?></span></p>
															<p><strong>GA by SONAR:</strong> <span id="ga_by_sonar"><?php echo $f['ga_by_sonar'] ?></span></p>
															<p><strong>EDC by UTZ:</strong><span id="edc_by_utz"> <?php echo $f['edc_by_utz'] ?></span></p>
														</div>
													</div>

													<div class="report">
														<h3>OB Description Report</h3>
														<p><strong>Gestation:</strong> <span id="gestation"><?php echo $f['gestation'] ?></span></p>
														<p><strong>Presentation/Lie:</strong> <span id="presentation_lie"><?php echo $f['presentation_lie'] ?></span></p>
														<p><strong>Amniotic Fluid:</strong> <span id="amniotic_fluid"><?php echo $f['amniotic_fluid'] ?></span></p>
														<p><strong>Placenta Location:</strong> <span id="placenta_location"><?php echo $f['placenta_location'] ?></span></p>
														<p><strong>Previa:</strong><span id="previa"> <?php echo $f['previa'] ?></span></p>
														<p><strong>Placenta Grade:</strong> <span id="placenta_grade"><?php echo $f['placenta_grade'] ?></span></p>
														<p><strong>Fetal Activity:</strong> <span id="fetal_activity"><?php echo $f['fetal_activity'] ?></span></p>
														<p><strong>Comments:</strong></p>
														<p id="comments"><?php echo $f['comments'] ?></p>
													</div>

													
													
												</div>



												<!-- Row start -->
												

												<div style="width:30%; float:left;">
													<center><label><b>Parameters</b></label></center>
													<label><strong>Biparietal Diameter</strong></label>
													<br />
													<label><strong> Head Circumference</strong></label>
													<br />
													<label><strong>Abdominal Circumference</strong></label>
													<br />
													<label><strong>Femoral Length</strong></label>
													<br />
													<label><strong>Crown Rump Length</strong></label>
													<br />
													<label><strong>Mean Gest. Sac Diameter</strong></label>
													<br />
													<label><strong>Average Fetal Weight</strong></label>
												</div>
												<div style="width:30%; margin-left:10px; float:left;">
													<center><label><b>Mesurements</b></label></center>
													<center><label id="biparietal_diameter">
															<?php
															if ($f['biparietal_diameter'] == "") {
																echo "<br />";
															} else {
																echo $f['biparietal_diameter'];
															}
															?>
														</label></center>
													<center><label id="head_circumference">
															<?php
															if ($f['head_circumference'] == "") {
																echo "<br />";
															} else {
																echo $f['head_circumference'];
															}
															?>
														</label></center>
													<center><label id="abdominal_circumference">
															<?php
															if ($f['abdominal_circumference'] == "") {
																echo "<br />";
															} else {
																echo $f['abdominal_circumference'];
															}
															?>
														</label></center>
													<center><label id="femoral_length">
															<?php
															if ($f['femoral_length'] == "") {
																echo "<br />";
															} else {
																echo $f['femoral_length'];
															}
															?>
														</label></center>
													<center><label id="crown_rump_length">
															<?php
															if ($f['crown_rump_length'] == "") {
																echo "<br />";
															} else {
																echo $f['crown_rump_length'];
															}
															?>
														</label></center>
													<center><label id="mean_gest_sac_diameter">
															<?php
															if ($f['mean_gest_sac_diameter'] == "") {
																echo "<br />";
															} else {
																echo $f['mean_gest_sac_diameter'];
															}
															?>
														</label></center>
													<center><label id="average_fetal_weight">
															<?php
															if ($f['average_fetal_weight'] == "") {
																echo "<br />";
															} else {
																echo $f['average_fetal_weight'];
															}
															?>
														</label></center>
												</div>
												<div style="width:30%; margin-left:10px; float:left;">
													<center><label><b>Equivalent Age</b></label></center>
													<center><label id="biparietal_eq">
															<?php
															if ($f['biparietal_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['biparietal_eq'];
															}
															?>
														</label></center>
													<center><label id="head_circumference_eq">
															<?php
															if ($f['head_circumference_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['head_circumference_eq'];
															}
															?>
														</label></center>
													<center><label id="abdominal_circumference_eq">
															<?php
															if ($f['abdominal_circumference_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['abdominal_circumference_eq'];
															}
															?>
														</label></center>
													<center><label id="femoral_length_eq">
															<?php
															if ($f['femoral_length_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['femoral_length_eq'];
															}
															?>
														</label></center>
													<center><label id="crown_rump_length_eq">
															<?php
															if ($f['crown_rump_length_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['crown_rump_length_eq'];
															}
															?>
														</label></center>
													<center><label id="mean_gest_sac_diameter_eq">
															<?php
															if ($f['mean_gest_sac_diameter_eq'] == "") {
																echo "<br />";
															} else {
																echo $f['mean_gest_sac_diameter_eq'];
															}
															?>
														</label></center>
												</div>
												<br style="clear:both;" />
												<br />
												


												<!-- Row end -->




											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- Container ends -->

		</div>
		<!-- App body ends -->



		<!-- App footer start -->

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




	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.bundle.min.js"></script>

	<!-- 
<script src="dist/js/jquery_confirm/jquery-confirm.js"></script> -->

	<!-- Custom JS files -->
	<script src="../assets/js/custom.js"></script>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<script src="../assets/js/jquery-confirm.min.js"></script>

	<script src="../assets/js/common_javascript_functions.js"></script>
	<script src="../assets/moment/moment.min.js"></script>
	<script src="../assets/daterangepicker/daterangepicker.js"></script>
	<script src="../assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>








	<!-- <script type = "text/javascript">
    $(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
</script> -->


	<script>
		// document.getElementById('previous-record-btn').addEventListener('click', function() {
		// 	var currentDate = new Date();
		// 	var formattedDate = currentDate.toISOString().split('T')[0];

		// 	var xhr = new XMLHttpRequest();
		// 	xhr.open('GET', '../ajax/prenatal_previous_record.php?date=' + formattedDate, true);
		// 	xhr.onload = function() {
		// 		if (this.status == 200) {
		// 			var data = JSON.parse(this.responseText);
		// 			console.log(data);
		// 			updateFormFields(data);
		// 		}
		// 	};
		// 	xhr.send();
		// });
		document.getElementById('previous-record-btn').addEventListener('click', function() {
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().split('T')[0];

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../ajax/prenatal_previous_record.php?date=' + formattedDate, true);
    xhr.onload = function() {
        if (this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
            updateFormFields(data);
        }
    };
    xhr.send();
});


		function updateFormFields(data) {
			if (data.error) {

				console.error(data.error);
			} else {

				var date = new Date(data.date);
				var formattedDate = date.toLocaleDateString('en-US', {
					month: 'long',
					day: 'numeric',
					year: 'numeric'
				});
				document.getElementById('date').innerText = 'Date: ' + formattedDate;
				document.getElementById('Radiologist').innerHTML = data.radiologist;
				document.getElementById('chief_complaint').innerHTML = data.chief_complaint;
				document.getElementById('attending_physician').innerHTML = data.attending_physician;
				document.getElementById('lmp').innerHTML = data.lmp;
				document.getElementById('ga_by_lmp').innerHTML = data.ga_by_lmp;
				document.getElementById('edc_by_lmp').innerHTML = data.edc_by_lmp;
				document.getElementById('fhr').innerHTML = data.fhr;
				document.getElementById('ga_by_sonar').innerHTML = data.ga_by_sonar;
				document.getElementById('edc_by_utz').innerHTML = data.edc_by_utz;
				document.getElementById('biparietal_diameter').innerHTML = data.biparietal_diameter;
				document.getElementById('head_circumference').innerHTML = data.head_circumference;
				document.getElementById('abdominal_circumference').innerHTML = data.abdominal_circumference;
				document.getElementById('abdominal_circumference_eq').innerHTML = data.abdominal_circumference_eq;
				document.getElementById('femoral_length').innerHTML = data.femoral_length;
				document.getElementById('femoral_length_eq').innerHTML = data.femoral_length_eq;
				document.getElementById('crown_rump_length').innerHTML = data.crown_rump_length;
				document.getElementById('crown_rump_length_eq').innerHTML = data.crown_rump_length_eq;
				document.getElementById('mean_gest_sac_diameter').innerHTML = data.mean_gest_sac_diameter;
				document.getElementById('mean_gest_sac_diameter_eq').innerHTML = data.mean_gest_sac_diameter_eq;
				document.getElementById('average_fetal_weight').innerHTML = data.average_fetal_weight;
				document.getElementById('biparietal_eq').innerHTML = data.biparietal_eq;
				document.getElementById('head_circumference_eq').innerHTML = data.head_circumference_eq;
				document.getElementById('gestation').innerHTML = data.gestation;
				document.getElementById('presentation_lie').innerHTML = data.presentation_lie;
				document.getElementById('amniotic_fluid').innerHTML = data.amniotic_fluid;
				document.getElementById('placenta_location').innerHTML = data.placenta_location;
				document.getElementById('previa').innerHTML = data.previa;
				document.getElementById('placenta_grade').innerHTML = data.placenta_grade;
				document.getElementById('fetal_activity').innerHTML = data.fetal_activity;
				document.getElementById('comments').innerHTML = data.comments;

			}
		}
	</script>





<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>


</body>



</html>