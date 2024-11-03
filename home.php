<?php
include './config/connection.php';

include 'common_service/common_functions.php';
include('config/checklogin.php');
check_login();

$oldSessionID = session_id();
// echo "Old Session ID: " . $oldSessionID . "<br>";
$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if ($userType == 'BHW') {
	try {
		$stmt = $con->prepare("SELECT home_img FROM tbl_user_page WHERE userID = :userID");
		$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$homeImage = $result['home_img'] ?? 'default.jpg';
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
		$homeImage = 'default.jpg';
	}
} else {
	$homeImage = 'default.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
	<?php include './config/site_css_links.php'; ?>

	<?php include './config/data_tables_css.php'; ?>
	<title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
	<link href='./assets/fullcalendar/main.min.css' rel='stylesheet' />

	<style>
		.container {
			display: flex;
			max-width: 900px;
			width: 100%;
			margin: 20px;
		}

		#calendar {
			width: 70%;
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
					<a href="index.html">
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
									Barangay Health Center
								</h6>
							</div>
						</div>
						<!-- Row end -->
						<!-- Row start -->
						<div class="row">
							<div class="col-4">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title"></h5>
									</div>
									<div class="card-body">
										<!-- Your code goes here -->



										<img src="logo/<?php echo htmlspecialchars($homeImage); ?>" style="height: 40%; width: 100%" alt="Home Image">


									</div>



								</div>
							</div>
							<?php

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

							<div class="col-8">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title"></h5>
									</div>
									<div class="card-body">
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

									</div>
								</div>

							</div>


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
	<script src='./assets/fullcalendar/main.min.js'></script>

	<!-- <script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');

			// Fetch the PHP-generated JSON for events
			var calendarEvents = <?php echo $calendarEventsJson; ?>;

			// Get the current date
			var today = new Date().toISOString().split('T')[0];

			var calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				events: calendarEvents, // Load events from PHP data
				validRange: {
					start: today // Disable past dates
				},
				dateClick: function(info) {
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
				}
			});

			calendar.render();
		});
	</script> -->



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