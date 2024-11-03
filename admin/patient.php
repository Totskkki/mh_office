<?php
include './config/connection.php';

include './common_service/common_functions.php';





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
                  Patient List
                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Patient Records List</h5>
                  </div>
                  <div class="card-body">
                    <div class="row ">
                      &nbsp; &nbsp;&nbsp;<div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                        <div class="input-group">
                          <input style="font-style: italic;" type="text" class="form-control form-control-sm rounded-0" id="search_patient" placeholder=" Search Patient">
                          <div class="input-group-append">
                            <span class="input-group-text"> <i class="icon-search"></i></span>
                          </div>
                        </div>
                        <br><br>
                      </div>
                  
                      <div class="table-responsive">
                        <table id="all_patients" class="table table-striped ">
                        <colgroup>
                  <col width="5%">
                  <col width="20%">
                  <col width="20%">
                  <col width="15%">
                  <col width="10%">
                  <col width="10%">
                  <col width="5%">
                </colgroup>
                          <thead>

                            <tr>
                              <th>#</th>
                              <th>Patient Name</th>
                              <th>Address</th>
                              <th>Date Of Birth</th>
                              <th>Age</th>
                              <th>Civil Status</th>
                              <th class="text-center">Action</th>
                                    <?php  
                        $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.* 
                                 FROM tbl_patients AS users 
                                LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                                LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info  = mem.membershipID
                                ORDER BY users.patientID DESC";


                        $stmtPatient1 = $con->prepare($query);
                        $stmtPatient1->execute();

                      ?>
                                                  </tr>
                          </thead>

                          <tbody>
                            <?php
                            $count = 0;
                            while ($row = $stmtPatient1->fetch(PDO::FETCH_ASSOC)) {
                              $count++;
                              $id = $row['patientID'];
                              try {
                            
                                $query2 = "SELECT COUNT(*) AS total FROM `tbl_complaints` WHERE `patient_id` = :id AND `status` = 'Pending'";
                                $stmtComplaints = $con->prepare($query2);
                                $stmtComplaints->bindParam(':id', $id, PDO::PARAM_INT);
                                $stmtComplaints->execute();
                                $totalComplaints = $stmtComplaints->fetchColumn();
                              } catch (PDOException $ex) {
                                echo $ex->getMessage();
                                echo $ex->getTraceAsString();
                                exit;
                              }
                            ?>

                              <tr>
                                <td><?php echo $count; ?></td>
                            
                                <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
                                <td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
                                <!-- <td><?php echo date('F j, Y', strtotime($row['date_of_birth'])); ?></td> -->
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo $row['age']; ?></td>
                                <td><?php echo $row['civil_status']; ?></td>
                               
                                <td class="text-center">
                                  
                                  <a href="view_patient.php?id=<?php echo $row['patientID']; ?>"class="btn btn-outline-info btn-sm view" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View">
                                                                <i class="icon-eye"></i>
                                                            </a>
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

  <script>
    $(document).ready(function() {
      $("#all_patients").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"B>>rt<"bottom"ip><"clear">',
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [10, 20, 50, 100],
      });

      // Move buttons to the center
      $('#datatable_buttons').append($('.dt-buttons'));

      // Adjust length menu alignment
      $('#length_menu').append($('.dataTables_length'));
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#search_patient").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();

        // Make an AJAX request to fetch filtered patient data
        $.ajax({
          type: "POST",
          url: "ajax/searchpatients.php",
          data: {
            searchTerm: searchTerm
          },
          success: function(response) {
            // Update the table with the received data
            $("#all_patients tbody").html(response);
          },
          error: function(error) {
            console.log("Error: " + error);
          }

        });
      });
    });
  </script>

</body>



</html>