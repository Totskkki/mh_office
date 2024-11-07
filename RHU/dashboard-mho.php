<?php
// header('Access-Control-Allow-Origin: *');
include 'config/connection.php';
error_reporting(0);
include 'common_service/common_functions.php';
include('config/checklogin.php');
check_login();
date_default_timezone_set('Asia/Manila');




$date = date('Y-m-d');
$year =  date('Y');
$month =  date('m');

$queryToday = "SELECT count(*) as `today` 
  from `tbl_patient_visits` 
  where `visit_date` = '$date' ;";

$querybirth = "SELECT COUNT(*) AS `monthly_count` FROM `tbl_birth_info` WHERE YEAR(`date`) = :year AND MONTH(`date`) = :month;";
$queryprenatal = "SELECT COUNT(*) AS `monthly` FROM `tbl_prenatal` WHERE YEAR(`date`) = :year AND MONTH(`date`) = :month;";
$querycheckup = "SELECT COUNT(*) AS `monthlycheckup` FROM `tbl_checkup` WHERE YEAR(`admitted`) = :year AND MONTH(`admitted`) = :month;";
$queryanimalbite = "SELECT COUNT(*) AS `monthbite` FROM `tbl_animal_bite_care` WHERE YEAR(`date_bite`) = :year AND MONTH(`date_bite`) = :month;";
$queryimmunization = "SELECT COUNT(*) AS `monthimmunization` FROM `tbl_immunization_records` WHERE YEAR(`immunization_date`) = :year AND MONTH(`immunization_date`) = :month;";


$todaysCount = 0;
$currentWeekCount = 0;
$currentMonthBirthCount = 0;
$currentMonthPrenatalCount = 0;
$currentMonthanimalbite = 0;
$currentYearCount = 0;
$currentmonthlycheckup = 0;
$currentimmunization_date = 0;


try {


	$stmtToday = $con->prepare($queryToday);
	$stmtToday->execute();
	$r = $stmtToday->fetch(PDO::FETCH_ASSOC);
	$todaysCount = $r['today'];

	$stmtMonth = $con->prepare($querybirth);
	$stmtMonth->bindParam(':year', $year, PDO::PARAM_INT);
	$stmtMonth->bindParam(':month', $month, PDO::PARAM_INT);
	$stmtMonth->execute();
	$result = $stmtMonth->fetch(PDO::FETCH_ASSOC);
	$currentMonthBirthCount = $result['monthly_count'];


	$stmtMonth1 = $con->prepare($queryprenatal);
	$stmtMonth1->bindParam(':year', $year, PDO::PARAM_INT);
	$stmtMonth1->bindParam(':month', $month, PDO::PARAM_INT);
	$stmtMonth1->execute();
	$result = $stmtMonth1->fetch(PDO::FETCH_ASSOC);
	$currentMonthPrenatalCount = $result['monthly'];

	$stmtMonth2 = $con->prepare($queryanimalbite);
	$stmtMonth2->bindParam(':year', $year, PDO::PARAM_INT);
	$stmtMonth2->bindParam(':month', $month, PDO::PARAM_INT);
	$stmtMonth2->execute();
	$result = $stmtMonth2->fetch(PDO::FETCH_ASSOC);
	$currentMonthanimalbite = $result['monthbite'];

	$stmtMonth3 = $con->prepare($querycheckup);
	$stmtMonth3->bindParam(':year', $year, PDO::PARAM_INT);
	$stmtMonth3->bindParam(':month', $month, PDO::PARAM_INT);
	$stmtMonth3->execute();
	$result = $stmtMonth3->fetch(PDO::FETCH_ASSOC);
	$currentmonthlycheckup = $result['monthlycheckup'];

	$stmtMonth4 = $con->prepare($queryimmunization);
	$stmtMonth4->bindParam(':year', $year, PDO::PARAM_INT);
	$stmtMonth4->bindParam(':month', $month, PDO::PARAM_INT);
	$stmtMonth4->execute();
	$result = $stmtMonth4->fetch(PDO::FETCH_ASSOC);
	$currentimmunization_date = $result['monthimmunization'];
} catch (PDOException $ex) {
	echo $ex->getMessage();
	echo $ex->getTraceAsString();
	exit;
}





?>


<!DOCTYPE html>
<html lang="en">


<head>
	<?php include './config/site_css_links.php'; ?>

	<?php include './config/data_tables_css.php'; ?>
	<title>Patients - Kalilintad Lutayan-Municipal Health Office</title>


	<style>
		.container {
			display: flex;
			max-width: 100%;
			width: 100%;
			margin: 20px;
		}

		#calendar {
			width: 100%;
			margin-right: 20px;
			background-color: #fff;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.event-details {
			width: 30%;
			padding: 20px;
			background-color: #fff;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			height: fit-content;
		}

		.event-details h3 {
			margin-top: 0;
		}

		.event-details ul {
			list-style: none;
			padding: 0;
		}

		.event-details ul li {
			margin: 10px 0;
			display: flex;
			align-items: center;
		}

		.event-details ul li span {
			width: 10px;
			height: 10px;
			border-radius: 50%;
			display: inline-block;
			margin-right: 10px;
		}

		.event-details ul li .blue {
			background-color: #007bff;
		}

		.event-details ul li .red {
			background-color: #dc3545;
		}

		.event-details ul li .yellow {
			background-color: #ffc107;
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
					<!-- <a href="index.html">
						<img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
					</a> -->
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
						<?php ?>

					<?php


					}

					?>
					<!-- Container starts -->
					<div class="container-fluid">

						<!-- Row start -->
						<div class="row">
							<div class="col-12 col-xl-12">
								<!-- Breadcrumb start -->
								<ol class="breadcrumb mb-1">
									<li class="breadcrumb-item">
										<a href="dashboard.php">Home</a>

									</li>
									<li class=" breadcrumb-active">

									</li>
								</ol>
								<!-- Breadcrumb end -->
								<h2 class="mb-2"></h2>
								<h6 class="mb-4 fw-light">
									Municipal Health Center
								</h6>
							</div>
						</div>

						<div class="row">
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-violet">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-face fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $todaysCount; ?></h1>
												<h6>Today's Patients</h6>
											</div>
											<span class="badge bg-violet-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-purple">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-pregnant_woman fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $currentMonthBirthCount; ?></h1>
												<h6>Birthing</h6>
											</div>
											<span class="badge bg-purple-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-purple">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-pregnant_woman fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $currentMonthPrenatalCount; ?></h1>
												<h6>Prenatal</h6>
											</div>
											<span class="badge bg-danger-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-danger">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-pets fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $currentMonthanimalbite; ?></h1>
												<h6>Animal bite & Care</h6>
											</div>
											<span class="badge bg-warning-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 " style="background-color:#24B282;">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-twitch fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $currentmonthlycheckup; ?></h1>
												<h6>Check-up</h6>
											</div>
											<span class="badge bg-violet-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-danger">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-library_add fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<h1><?php echo $currentimmunization_date; ?></h1>
												<h6>Immunization</h6>
											</div>
											<span class="badge bg-purple-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="card mb-4 border-0 bg-warning">
									<div class="card-body text-white">
										<div class="d-flex align-items-center text-center">
											<div class="p-3">
												<i class="icon-local_hospital fs-1 lh-1"></i>
											</div>
											<div class="py-3">
												<?php
												// Define the query to count the total quantity of medicines in the stock
												$query = "SELECT SUM(qt) as total_quantity FROM tbl_medicine_details";
												$stmt = $con->prepare($query);
												$stmt->execute();
												$count = $stmt->fetchColumn();
												?>


												<h1><?php echo $count; ?></h1>
												<h6>Medicine Stock</h6>
											</div>
											<span class="badge bg-danger-light position-absolute top-0 end-0 m-3"></span>
										</div>
									</div>
								</div>
							</div>

						</div>
						<!-- Row end -->




						<div class="row">
							<?php
							// $query = "SELECT `announceID`, `date`, `title`, `details` FROM `tbl_announcements` ORDER BY `date` ASC";
							// $stmt = $con->prepare($query);
							// $stmt->execute();
							// $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

							$query = "SELECT `announceID`, `date`, `title`, `details` FROM `tbl_announcements` ORDER BY `date` ASC";
							$stmt = $con->prepare($query);
							$stmt->execute();
							$events = $stmt->fetchAll(PDO::FETCH_ASSOC);


							$calendarEvents = [];
							foreach ($events as $event) {
								$calendarEvents[] = [
									'title' => htmlspecialchars($event['title']),
									'start' => $event['date'],
									'description' => htmlspecialchars($event['details']),
								];
							}


							$calendarEventsJson = json_encode($calendarEvents);
							?>

							<!-- <div class="col-xxl-4 col-sm-6">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Events</h5>
									</div>
									<div class="card-body">
										<?php if (!empty($events)) { ?>
											<div class="scroll300 os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
												<div class="os-resize-observer-host observed">
													<div class="os-resize-observer" style="left: 0px; right: auto;"></div>
												</div>
												<div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
													<div class="os-resize-observer"></div>
												</div>
												<div class="os-content-glue" style="margin: 0px; width: 301px; height: 299px;"></div>
												<div class="os-padding">
													<div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
														<div class="os-content" style="padding: 0px; height: 100%; width: 100%;">
															<ul class="statistics m-0 p-0">
																<?php foreach ($events as $event) { ?>
																	<li>
																		<span class="stat-icon">
																			<i class="icon-calendar"></i>
																		</span>
																		<?php echo htmlspecialchars($event['title']); ?> - <?php echo date('F Y', strtotime($event['date'])); ?>
																	</li>
																<?php } ?>
															</ul>
														</div>
													</div>
												</div>
												<div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
													<div class="os-scrollbar-track os-scrollbar-track-off">
														<div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
													</div>
												</div>
												<div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
													<div class="os-scrollbar-track os-scrollbar-track-off">
														<div class="os-scrollbar-handle" style="height: 49.3421%; transform: translate(0px, 0px);"></div>
													</div>
												</div>
												<div class="os-scrollbar-corner"></div>
											</div>
										<?php } else { ?>
											<p>No announcements available.</p>
										<?php } ?>
									</div>
								</div>
							</div> -->

							<!-- <div class="col-xl-8 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<div class="d-flex align-items-center justify-content-between">
											<h5 class="card-title m-0">Statistic Reports</h5>
											<form class="form-inline">
												<div class="form-group mb-0">
													<label for="select_year">Select Year:</label>
													<select class="form-control form-control-sm" id="select_year">
														<?php for ($i = 2020; $i <= 2050; $i++) :
															$selected = ($i == $year) ? 'selected' : '';
															echo "<option value='$i' $selected>$i</option>";
														endfor; ?>
													</select>
												</div>
											</form>
										</div>
									</div>
									<div class="card-body">
										<div id="barGraph"></div>
									</div>
								</div>
							</div> -->




						</div>


						<div class="row">
							<div class="container">
								<!-- FullCalendar -->
								<div id="calendar"></div>

								<!-- Event Details Panel -->
								<div class="event-details">
									<h3 id="event-date">Select a date</h3>
									<ul id="event-list">
										<li>No events for this day</li>
									</ul>
								</div>
							</div>
							<div class="col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Documents Tracking</h5>
									</div>
									<div class="card-body">
										<div class="table-responsive">

											<table id="documents" class="table table-striped ">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>Documents</th>
														<th>Status</th>

													</tr>
													<?php
													$query = "SELECT l.*,p.*  FROM tbl_certificate_log l
													  left join tbl_patients p on p.patientID = l.patient_id
													 											 
													  ORDER BY log_id  DESC";
													$stmtdoc = $con->prepare($query);
													$stmtdoc->execute();
													?>
												</thead>

												<tbody>

													<?php
													$count = 0;
													while ($row = $stmtdoc->fetch(PDO::FETCH_ASSOC)) {
														$count++;
														$documentLink = 'certificates/' . basename($row['file_path']);


														if ($row['generated_at']) {

															$documentLink = 'certificates/' . $row['patient_id'] . '_' . date('Y-m-d', strtotime($row['generated_at'])) . '.pdf';
														}
													?>
														<tr>
															<td><?php echo $count; ?></td>
															<td><?php echo htmlspecialchars($row['patient_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?></td>
															<td>
																<?php if (!empty($row['file_path']) && file_exists($documentLink)): ?>
																	<a href="<?php echo htmlspecialchars($documentLink); ?>" target="_blank">View Certificate</a>
																<?php else: ?>
																	No Certificate Available
																<?php endif; ?>
															</td>

															<td>
																<?php

																if ($row['status'] == 'done') {
																	echo '<span class="badge bg-success">Done</span>';
																} else {
																	echo '<span class="badge bg-danger">Pending</span>';
																}
																?>
															</td>
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

						</div>
					</div>


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
	<?php


	?>


	<?php include './config/site_js_links.php'; ?>
	<?php include './config/data_tables_js.php'; ?>
	<!-- Apex Charts -->
	<script src="../assets/vendor/apex/apexcharts.min.js"></script>
	<!-- <script src="assets/vendor/apex/custom/graphs/bar.js"></script> -->

	<!-- FullCalendar JavaScript -->
	<script src='../assets/fullcalendar/main.min.js'></script>



	<!-- <script>
		document.addEventListener("DOMContentLoaded", function() {
			var options = {
				chart: {
					height: 300,
					type: "bar",
					toolbar: {
						show: false,
					},
				},
				dataLabels: {
					enabled: false,
				},
				stroke: {
					curve: "smooth",
					width: 1,
					colors: ["#0a50d8", "#57637B", "#D6DAE3"],
				},
				series: [{
						name: "Birthing",
						data: [10, 40, 15, 40, 20, 35, 20, 10, 31, 43, 56, 29],
					},
					{
						name: "Prenatal",
						data: [2, 8, 25, 7, 20, 20, 51, 35, 42, 20, 33, 67],
					},
				],
				grid: {
					borderColor: "#ccd2da",
					strokeDashArray: 5,
					xaxis: {
						lines: {
							show: true,
						},
					},
					yaxis: {
						lines: {
							show: true,
						},
					},
					padding: {
						top: 0,
						right: 0,
						bottom: 10,
						left: 0,
					},
				},
				xaxis: {
					categories: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec",
					],
				},
				yaxis: {
					labels: {
						show: false,
					},
				},
				colors: ["#eaf1ff", "#e2e5ec", "#eff1f6"],
				markers: {
					size: 0,
					opacity: 0.3,
					colors: ["#eaf1ff", "#e2e5ec", "#eff1f6"],
					strokeColor: "#ffffff",
					strokeWidth: 2,
					hover: {
						size: 7,
					},
				},
			};

			var chart = new ApexCharts(document.querySelector("#barGraph"), options);

			chart.render();
		});
	</script> -->
	<!-- <script>
		document.addEventListener("DOMContentLoaded", function() {
			fetch('ajax/fetch_prenatal_birthing.php')
				.then(response => response.json())
				.then(data => {

					console.log(data);
					var options = {
						chart: {
							height: 300,
							type: 'bar',
							toolbar: {
								show: false
							}
						},
						series: [{
							name: 'Birthing',
							data: data.birthing
						}, {
							name: 'Prenatal',
							data: data.prenatal
						}, {
							name: 'Animal bite',
							data: data.animalBites
						}, {
							name: 'Immunization & Vaccination',
							data: data.immunizations
						}],

						xaxis: {
							categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
						},
						yaxis: {
							labels: {
								show: true,
							},
						},
						plotOptions: {
							bar: {
								horizontal: false,
								columnWidth: '100%',
							},
						},
						dataLabels: {
							enabled: false
						},
						stroke: {
							show: true,
							width: 2,
							colors: ['transparent']
						},
						tooltip: {
							enabled: true
						}

					};



					var chart = new ApexCharts(document.querySelector("#barGraph"), options);
					chart.render();
				});
		});
	</script> -->

	<!-- <script>
		document.addEventListener("DOMContentLoaded", function() {
			var chart;

			function fetchData(year) {
				fetch(`ajax/fetch_prenatal_birthing.php?year=${year}`)
					.then(response => response.json())
					.then(data => {
						var options = {
							chart: {
								height: 300,
								type: 'bar',
								toolbar: {
									show: false
								}
							},
							series: [{
								name: 'Birthing',
								data: data.birthing
							}, {
								name: 'Prenatal',
								data: data.prenatal
							}, {
								name: 'Animal bite',
								data: data.animalBites
							}, {
								name: 'Immunization & Vaccination',
								data: data.immunizations
							}],
							xaxis: {
								categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
							},
							yaxis: {
								labels: {
									show: true,
								},
							},
							plotOptions: {
								bar: {
									horizontal: false,
									columnWidth: '100%',
								},
							},
							dataLabels: {
								enabled: false
							},
							stroke: {
								show: true,
								width: 2,
								colors: ['transparent']
							},
							tooltip: {
								enabled: true
							}
						};


						if (chart) {
							chart.updateOptions(options);
						} else {
							chart = new ApexCharts(document.querySelector("#barGraph"), options);
							chart.render();
						}
					});
			}


			fetchData(new Date().getFullYear());


			document.getElementById('select_year').addEventListener('change', function() {
				var selectedYear = this.value;
				fetchData(selectedYear);
			});
		});
	</script> -->

	<!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($calendarEvents); ?>, // Pass the PHP array as JSON
                eventClick: function (info) {
                    alert(info.event.title + "\n\n" + info.event.extendedProps.description);
                }
            });
            calendar.render();
        });
    </script> -->

	<script>
		$(document).ready(function() {
			$("#documents").DataTable({
				"responsive": true,
				"lengthChange": true,
				"autoWidth": false,
				"dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
				"lengthMenu": [10, 20, 50, 100],
			});
		});
	</script>


	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			// Fetch the PHP-generated JSON for events
			var calendarEvents = <?php echo $calendarEventsJson; ?>;

			// Get today's date
			var today = new Date();
			var todayStr = today.toISOString().split('T')[0]; // 'YYYY-MM-DD'

			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				events: calendarEvents, // Load events from PHP data
				dateClick: function(info) {
					// Disable clicking on past dates
					if (info.dateStr < todayStr) {
						return; // Do nothing if the clicked date is in the past
					}

					var eventListEl = document.getElementById('event-list');
					var eventDateEl = document.getElementById('event-date');

					// Update the right panel with the clicked date
					eventDateEl.textContent = info.dateStr;
					eventListEl.innerHTML = '';

					// Filter events for the clicked date
					var eventsForDay = calendarEvents.filter(event => event.start === info.dateStr);

					if (eventsForDay.length > 0) {
						eventsForDay.forEach(function(event) {
							var listItem = document.createElement('li');
							var colorSpan = document.createElement('span');
							colorSpan.style.backgroundColor = '#007bff'; // Set a default color, you can add logic to change it
							listItem.appendChild(colorSpan);
							listItem.appendChild(document.createTextNode(event.title + ' - ' + event.description));
							eventListEl.appendChild(listItem);
						});
					} else {
						eventListEl.innerHTML = '<li>No events for this day</li>';
					}
				},
				dayCellDidMount: function(info) {
					if (info.date < today) {
						// Disable past dates
						info.el.style.pointerEvents = 'none'; // Disable clicking
						info.el.style.opacity = '0.5'; // Visual indication of disabled state
					}
				}
			});

			calendar.render();
		});
	</script>


</body>



</html>