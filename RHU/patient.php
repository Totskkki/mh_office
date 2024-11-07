<?php
use Shuchkin\SimpleXLSX;
include './config/connection.php';
include './common_service/common_functions.php';
require_once '../assets/SimpleXLSX.php'; // Adjust the path as necessary

if (isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    $user = $_SESSION['user_id'];

    if ($file_ext == 'xlsx') {
        if ($xlsx = SimpleXLSX::parse($file)) {
            // Iterate over rows
            foreach ($xlsx->rows() as $row) {
                $household_no = $row[0];
                $patient_name = $row[1];
                $middle_name = $row[2];
                $last_name = $row[3];
                $suffix = !empty($row[4]) ? $row[4] : null; 

                try {
                    $con->beginTransaction();

                  
                    $stmt = $con->prepare("INSERT INTO tbl_patients (household_no, patient_name, middle_name, last_name, suffix,userID)
                        VALUES (:household_no, :patient_name, :middle_name, :last_name, :suffix,:userID)");

              
                    $stmt->execute([
                        ':household_no' => $household_no,
                        ':patient_name' => $patient_name,
                        ':middle_name' => $middle_name,
                        ':last_name' => $last_name,
                        ':suffix' => $suffix,
                        ':userID' => $user,
                    ]);

                    $con->commit();

                } catch (Exception $e) {
                    $con->rollBack();
                    die("Error: " . $e->getMessage());
                }
            }

            // After all rows have been processed
            $_SESSION['status'] = "Data successfully imported.";
            $_SESSION['status_code'] = "success";
            header('Location: patient.php');
            exit();
        } else {
            echo SimpleXLSX::parseError();
        }
    } elseif ($file_ext == 'csv') {
        // Handle CSV file
        if (($handle = fopen($file, 'r')) !== FALSE) {
            fgetcsv($handle); // Skip the header row if it exists

            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $household_no = $row[0];
                $patient_name = $row[1];
                $middle_name = $row[2];
                $last_name = $row[3];
                $suffix = !empty($row[4]) ? $row[4] : null;

                try {
                    $con->beginTransaction();

                    $stmt = $con->prepare("INSERT INTO tbl_patients (household_no, patient_name, middle_name, last_name, suffix,userID)
                        VALUES (:household_no, :patient_name, :middle_name, :last_name, :suffix,:userID)");

                    $stmt->execute([
                        ':household_no' => $household_no,
                        ':patient_name' => $patient_name,
                        ':middle_name' => $middle_name,
                        ':last_name' => $last_name,
                        ':suffix' => $suffix,
                        ':userID' => $user,
                    ]);

                    $con->commit();
                } catch (Exception $e) {
                    $con->rollBack();
                    die("Error: " . $e->getMessage());
                }
            }

            fclose($handle);

            $_SESSION['status'] = "CSV Data successfully imported.";
            $_SESSION['status_code'] = "success";
            header('Location: patient.php');
            exit();
        } else {
           
            $_SESSION['status'] = "Error opening CSV file.";
            $_SESSION['status_code'] = "error";
            header('Location: patient.php');
            exit();
        }
    } else {
       
        $_SESSION['status'] = "Unsupported file type. Please upload XLSX or CSV files.";
        $_SESSION['status_code'] = "error";
        header('Location: patient.php');
        exit();
    }
}elseif (isset($_POST['export'])) {  // Handle export action

  // Fetch data to export
  $query = "SELECT household_no, patient_name, middle_name, last_name, suffix FROM tbl_patients";
  $stmt = $con->prepare($query);
  $stmt->execute();
  $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($patients) {
      // Set the headers to force download the file
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=patients_export.csv');

      // Open the output stream
      $output = fopen('php://output', 'w');

      // Write the headers of the CSV
      fputcsv($output, ['Household No', 'Patient Name', 'Middle Name', 'Last Name', 'Suffix']);

      // Write the rows
      foreach ($patients as $patient) {
          fputcsv($output, $patient);
      }

      // Close the output stream
      fclose($output);

      exit(); 
  } else {
      echo "No data found to export.";
  }
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
                    <h5 class="card-title"></h5>
                    <a href="patient_form.php" button type="button" class="btn btn-info">
                      <i class="icon-add_box"></i> Add Patient
                    </a> 
                    <span class="float-end">

                    <select id="actionSelect" class="form-select text-center" style="color: #ffffff; background-color: #009879; font-size: 15px;">
                      <option value="" disabled selected>Action</option>
                      <option value="import">Import</option>
                      <option value="export">Export</option>
                    </select>
                  </span>
                            </div>
                  
                  <div class="card-body">
                    <!-- <div class="row ">
                     &nbsp;<div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                        <div class="input-group">
                          <input style="font-style: italic;" type="text" class="form-control form-control-sm rounded-0" id="search_patient" placeholder=" Search Patient">
                          <div class="input-group-append">
                            <span class="input-group-text"> <i class="icon-search"></i></span>
                          </div>
                        </div>
                      </div> -->

                    <div class="table-responsive">
                      <table id="all_patients" class="table table-striped ">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Patient Name</th>
                            <th>Address</th>
                            <th>Date Of Birth</th>
                            <th>Age</th>
                            <th>Consultation Purpose</th>
                            <th>Current/Old Patient</th>
                            <th class="text-center">Date Registered</th>


                            <th class="text-center">Action</th>
                            <?php
                          $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*
                          FROM tbl_patients AS users 
                          LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                          LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                          LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                          GROUP BY users.patientID 
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

                              $query2 = "SELECT *, COUNT(*) AS total FROM `tbl_complaints` WHERE `patient_id` = :id AND `status` = 'Pending'";
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
                              <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
                              <td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
                              <!-- <td><?php echo date('F j, Y', strtotime($row['date_of_birth'])); ?></td> -->
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

                              <td><?php echo $row['reg_date']; ?></td>

                              <td class="text-center">
                                <a href="view_patient.php?id=<?php echo $row['patientID']; ?>" class="btn btn-success btn-sm btn-flat">
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

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="fileInput" class="form-label">Select Excel File</label>
            <input type="file" class="form-control" id="fileInput" name="file" accept=".xlsx, .xls">
          </div>
          <button type="submit" class="btn btn-primary">Import</button>
        </form>
      </div>
    </div>
  </div>
</div>

<form id="exportForm" method="post">
  <input type="hidden" name="export" value="1">
</form>



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
        "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
        "lengthMenu": [10, 20, 50, 100],
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#search_patient").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();


        $.ajax({
          type: "POST",
          url: "ajax/searchpatients.php",
          data: {
            searchTerm: searchTerm
          },
          success: function(response) {

            $("#all_patients tbody").html(response);
          },
          error: function(error) {
            console.log("Error: " + error);
          }

        });
      });
    });
  </script>

<script>
document.getElementById('actionSelect').addEventListener('change', function() {
    var selectedAction = this.value;

    if (selectedAction === 'import') {
        // Open the import modal
        var importModal = new bootstrap.Modal(document.getElementById('importModal'));
        importModal.show();
    } else if (selectedAction === 'export') {
        // Trigger the export functionality
        document.getElementById('exportForm').submit(); // Submit the export form
    }
});

</script>


</body>



</html>