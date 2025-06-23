<?php
include './config/connection.php';

include './common_service/common_functions.php';




?>


<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>


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
                  Reports
                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Patient Visits Reports</h3>
                    <div class="d-flex align-items-end justify-content-between">



                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">

                      <?php
                      echo getDateTextBox('From', 'patients_from');

                      echo getDateTextBox('To', 'patients_to');
                      ?>

                      <!-- <div class="col-md-2 ">
                        <label>&nbsp;</label>
                        <button type="button" id="print_visits" class="btn btn-primary ">Generate PDF</button>
                      </div> -->

                      <div class="row">
                        <div class="mb-3">
                          <button type="submit" class="btn btn-info   float-end" id="print_visits">Generate PDF</button>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- /.card-body -->

                  <!-- /.card-footer-->

                  <!-- /.card -->




                  <div class="card card-outline card-primary rounded-0 shadow">
                    <div class="card-header">
                      <h3 class="card-title">Illness Based Report Between </h3>


                    </div>

                    <?php

                    $query = "SELECT DISTINCT disease FROM tbl_patient_visits";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $diseases = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Health issue</label>
                          <!-- <input id="disease" class="form-control " required/> -->
                          <select id="disease" class="form-control" required>
                            <option value="">Select Health Issue</option>
                            <?php foreach ($diseases as $disease) : ?>
                              <option value="<?= $disease['disease'] ?>"><?= $disease['disease'] ?></option>
                            <?php endforeach; ?>
                          </select>
                          <span id="disease-error" style="color: red; display: none;">Health issue is required.</span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label class="form-label">Barangay</label>
                          <select id="barangay" class="form-control">
                            <?php echo getbrgy(); ?>

                          </select>
                          <span id="barangay-error" style="color: red; display: none;">Barangay is required.</span>
                        </div>
                        <?php
                        echo getDateTextBox('From', 'disease_from');

                        echo getDateTextBox('To', 'disease_to');
                        ?>

                        <div class="row">
                          <div class="mb-3">
                            <button type="submit" class="btn btn-info   float-end" id="print_diseases">Generate </button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="card card-outline card-primary rounded-0 shadow">
                    <div class="card-header">
                      <h3 class="card-title">Doctors Reports</h3>


                    </div>

                    <?php
                    $sql = "SELECT user.*, personnel.*, position.*,
                          CONCAT(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) AS `name`
                          FROM `tbl_users` AS user
                          INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
                          INNER JOIN `tbl_position` AS position ON position.position_id = user.position_id
                          WHERE user.`UserType` = 'Doctor'";

                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    $doctor = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Doctor</label>
                          <select id="doctor" class="form-control" required>
                            <option value="">Select Doctor</option>
                            <?php foreach ($doctor as $doctors) : ?>
                              <option value="<?= htmlspecialchars($doctors['name'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($doctors['name'], ENT_QUOTES, 'UTF-8') ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <span id="doctor-error" style="color: red; display: none;">Doctor is required.</span>
                        </div>




                        <?php
                        echo getDateTextBox('From', 'patient_from');

                        echo getDateTextBox('To', 'patient_to');
                        ?>

                        <div class="row">
                          <div class="mb-3">
                            <button type="submit" class="btn btn-info   float-end" id="print_doctor">Generate </button>
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


  <?php include './modal/user_modal.php'; ?>
  <?php include './config/site_js_links.php'; ?>



  <script>
    $(document).ready(function() {
      $('#patients_from, #patients_to, #disease_from, #disease_to').datetimepicker({
        format: 'L',
        maxDate: new Date()
      });
      $('#patient_from, #patient_to').datetimepicker({
        format: 'L',
        maxDate: new Date()
      });


      function validateHealthIssue() {
        var disease = $("#disease").val().trim();
        var barangay = $("#barangay").val().trim();
        if (disease === '') {
          $("#disease-error").show();
          return false;
        } else {
          $("#disease-error").hide();
        }

        if (barangay === '') {
          $("#barangay-error").show();
          return false;
        } else {
          $("#barangay-error").hide();
        }


        return true;
      }


      $("#disease").on('blur', validateHealthIssue);
      $("#barangay").on('blur', validateHealthIssue);

      $("#print_visits").click(function() {
        var from = $("#patients_from").val();
        var to = $("#patients_to").val();

        if (from !== '' && to !== '') {
          var win = window.open("print_patients_visits.php?from=" + from +
            "&to=" + to, "_blank");
          if (win) {
            win.focus();
          } else {
            showCustomMessage('Please allow popups.');
          }
        }
      });
      $("#print_diseases").click(function() {
        var from = $("#disease_from").val();
        var to = $("#disease_to").val();
        var barangay = $("#barangay").val(); // Get selected barangay

        if (validateHealthIssue() && from !== '' && to !== '') {
          var disease = $("#disease").val().trim();
          var win = window.open("print_diseases.php?from=" + from +
            "&to=" + to + "&disease=" + disease + "&barangay=" + barangay, "_blank"); // Include barangay in the URL
          if (win) {
            win.focus();
          } else {
            showCustomMessage('Please allow popups.');
          }
        } else {
          // showCustomMessage('invalid fields.');
        }
      });
      $("#print_doctor").click(function() {
        var from = $("#patient_from").val();
        var to = $("#patient_to").val();
        var doctor = $("#doctor").val();

        if (doctor !== "" && from !== "" && to !== "") {
          var win = window.open(
            "print_doctors.php?from=" + from + "&to=" + to + "&doctor=" + encodeURIComponent(doctor),
            "_blank"
          );
          if (win) {
            win.focus();
          } else {
            alert("Please allow popups.");
          }
        } else {
          alert("Please fill in all fields.");
        }
      });


    });
  </script>








</body>



</html>