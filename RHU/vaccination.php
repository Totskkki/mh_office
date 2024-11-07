<?php
include './config/connection.php';

include './common_service/common_functions.php';



// if (isset($_POST['complaintID'])) {

//   $id = $_POST['complaintID'];
//   $queryUsers = "SELECT users.*,users.patient_name,users.middle_name.users.last_name, family.*, mem.*, complaints.*
//   FROM tbl_patients AS users 
//   LEFT JOIN tbl_family AS family ON users.family_address = family.famID 
//   LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
//   LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
//   WHERE users.patientID = :id";


//   $stmtpatients = $con->prepare($queryUsers);
//   $stmtpatients->execute([':id' => $id]);
//   $row = $stmtpatients->fetch(PDO::FETCH_ASSOC);


//   echo json_encode($row);
//   exit;
// }
if (isset($_POST['complaintID'])) {

  $id = $_POST['complaintID'];

  $queryUsers = "SELECT com.*, pat.*, fam.*,mem.*,
  CONCAT(pat.`patient_name`, ' ', pat.`middle_name`, ' ', pat.`last_name`, ' ', pat.`suffix`) AS `name`
  FROM tbl_complaints AS com 
   JOIN tbl_patients AS pat ON com.patient_id = pat.patientID
   JOIN tbl_membership_info as mem ON mem.membershipID  = pat.Membership_Info
  JOIN 
  tbl_familyaddress AS fam ON pat.family_address = fam.famID
  WHERE com.complaintID = :id";

  $stmtpatients = $con->prepare($queryUsers);
  $stmtpatients->execute([':id' => $id]);
  $row = $stmtpatients->fetch(PDO::FETCH_ASSOC);

  echo json_encode($row);
  exit;
}





if (isset($_POST['save_vaccination'])) {

  $user = $_SESSION['user_id'];
  $patient_id = trim($_POST['patient_id']);

  $hidden_id1 = trim($_POST['hidden1']);

  $medicine = implode(',', $_POST['vaccineSelect']);
  $date_ad = $_POST['date_ad'];
  $next_due = $_POST['next_due'];
  $notes = trim($_POST['notes']);



  if ($medicine !== '' && $date_ad !== '' && $next_due !== '' && $notes !== '') {
  }
  $con->beginTransaction();
  $stmt = $con->prepare("INSERT INTO tbl_immunization_records (`patient_id`, `vaccine`, `immunization_date`, `immunization_next_date`, `remarks`,`userID`) 
            VALUES (?,?,?,?,?,?)");

  $stmt->execute([$patient_id, $medicine, $date_ad, $next_due, $notes, $user]);



  $con->commit();

  $stmtUpdate1 = $con->prepare("UPDATE tbl_complaints SET status = 'Done' WHERE patient_id = ? AND  consultation_purpose ='Vaccination and Immunization' and  complaintID = ?");
  $stmtUpdate1->execute([$patient_id, $hidden_id1]);
  $_SESSION['status'] = "Patient Vaccination Submitted succefully.";
  $_SESSION['status_code'] = "success";
  header('location: records_vaccination.php');
  exit();
}
$medicines = getvacimmunize($con);

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
                    <h5 class="card-title">Vaccination and Immunization</h5>
                  </div>
                  <div class="card-body">
                    <div class="col-12">
                      <div class="d-flex gap-2 justify-content-end mb-2">

                        <a href="records_vaccination.php" type="button" class="btn btn-info">
                          View Records
                        </a>
                      </div>
                    </div>


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
                            <th>Status</th>
                            <th class="text-center">Action</th>
                            <?php
                            $query = "SELECT users.*, family.brgy, family.purok, family.province, mem.*, complaints.*
                                  FROM tbl_patients AS users 
                                  LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
                                  LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
                                  LEFT JOIN tbl_complaints AS complaints ON users.patientID = complaints.patient_id
                                  WHERE complaints.status = 'pending' AND complaints.consultation_purpose = 'Vaccination and Immunization'
                                  GROUP BY users.patientID 
                                  ORDER BY users.patientID DESC";
                            $stmtUsers = $con->prepare($query);
                            $stmtUsers->execute();

                            ?>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                          $count = 0;
                          while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                            $count++;
                          ?>
                            <tr>

                              <td><?php echo $count; ?></td>

                              <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
                              <td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
                              <!-- <td><?php echo date('F j, Y', strtotime($row['date_of_birth'])); ?></td> -->
                              <td><?php echo $row['date_of_birth']; ?></td>
                              <td><?php echo $row['age']; ?></td>
                              <td><?php echo $row['consultation_purpose']; ?></td>
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

                                if ($row['status'] == 'Pending') {
                                  echo '<span class="badge bg-danger">pending</span>';
                                } else {
                                }
                                ?>
                              </td>

                              <td class="text-center">

                                <button class="btn btn-outline-info btn-sm consult" data-id="<?php echo $row['complaintID']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="Consult">
                                  <i class="icon-eye"></i> consult
                                </button>
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


  <?php include './modal/vacc.php'; ?>
  <?php include './config/site_js_links.php'; ?>
  <?php include './config/data_tables_js.php'; ?>







  <!-- <script>
   $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
</script> -->

  <script>
    $(document).ready(function() {
      $('#vaccineSelect').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#consultModal')
      });
    });
  </script>


  <script>
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2({
        placeholder: 'Select options',
        allowClear: true
      });
    });

    // If you're using a modal, reinitialize after the modal is shown
    $('#add_user').on('shown.bs.modal', function() {
      $('.js-example-basic-multiple').select2({
        placeholder: 'Select options',
        allowClear: true
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#all_patients").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
        "lengthMenu": [10, 20, 50, 100],
      });
      $('#date_ad, #next_due').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: new Date()
      });
    });
  </script>

  <!-- <script>
    $(document).ready(function() {
      $("#all_patients tbody").on('click', '.consult', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id, 'consult');
        $('#consultModal').modal('show');
      });

      function getRow(id, mode) {
        $.ajax({
          type: 'POST',
          url: 'vaccination.php',
          data: {
            complaintID: id
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);

            let dateOfBirth = new Date(response.date_of_birth);

            let options = {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            };
            let formattedDate = dateOfBirth.toLocaleDateString('en-US', options);
            $('#user').val(response.patientID);
            $('#consultModalTitle').text(
              response.patient_name + ' ' +
              response.middle_name + ' ' +
              response.last_name + ' | Birthday: ' +
              formattedDate + '  ( ' + response.age + ') Sex:' +
              response.gender + ' | Blood Type:' +
              response.blood_type
            );

          }
        });
      }
    });
  </script> -->



  <script>
    $(document).ready(function() {
      $("#all_patients tbody").on('click', '.consult', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id, 'consult');
        console.log("Clicked ID:", id);
        $('#consultModal').modal('show');
      });
    });

    function getRow(id) {
      $.ajax({
        type: 'POST',
        url: 'vaccination.php',
        data: {
          complaintID: id
        },
        dataType: 'json',
        success: function(response) {
       

          let dateOfBirth = new Date(response.date_of_birth);

          let options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          };
          let formattedDate = dateOfBirth.toLocaleDateString('en-US', options);
          $('#user').val(response.patientID);
          $('#complainid').val(response.complaintID);

          $('#consultModalTitle').text(
            response.patient_name + ' ' +
            response.middle_name + ' ' +
            response.last_name + ' | Birthday: ' +
            formattedDate + '  ( ' + response.age + ') Sex:' +
            response.gender + ' | Blood Type:' +
            response.blood_type
          );

        }
      });
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('vaccinations');


      form.addEventListener('submit', function(event) {
        var isValid = true;


        // Check built-in HTML5 form validation
        if (!form.checkValidity() || !isValid) {
          event.preventDefault();
          event.stopPropagation();
          form.classList.add('was-validated');
        } else {
          form.classList.remove('was-validated');
        }
      }, false);

    });
  </script>



</body>



</html>