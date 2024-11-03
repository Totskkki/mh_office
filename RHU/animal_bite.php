<?php
include './config/connection.php';

include './common_service/common_functions.php';


$medicines = getvaccine($con);


if (isset($_POST['saveNextvaccine'])) {

  // $animalBiteId = isset($_GET['animal_biteID']) ? trim($_GET['animal_biteID']) : null;


  $patient_id = trim($_POST['patient_id']);
  $vaccineid = trim($_POST['hidden2']);
  $complaintID = trim($_POST['hidden1']);
  $medicine = trim($_POST['vaccineSelect']);
  $dose_number = trim($_POST['dose_number']);
  $visit_date = date("Y-m-d", strtotime($_POST['date_ad']));
  $remarks = trim($_POST['remarks']);
  $next_visit_date = date("Y-m-d", strtotime($_POST['next_due']));

  $final_vaccine = isset($_POST['final_vaccine']) ? 1 : 0;

  $con->beginTransaction();

  try {
    // Set previous records to inactive
    $updateQuery = "UPDATE tbl_animal_bite_vaccination SET stat = 1 WHERE patient_id = ? AND stat = 0";
    $updateStmt = $con->prepare($updateQuery);
    $updateStmt->execute([$patient_id]);

    // Fetch the last vaccination record
    $query = "SELECT ab.bite_status, av.dose_status 
                FROM tbl_animal_bite_care ab
                LEFT JOIN tbl_animal_bite_vaccination av 
                ON ab.animal_biteID = av.bite_status
                WHERE ab.patient_id = ? and ab.bite_status = 'ongoing'
                ORDER BY av.vaccination_date DESC 
                LIMIT 1";

    $stmt = $con->prepare($query);
    $stmt->execute([$patient_id]);
    $lastRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    $newDoseStatus = 1;

    if ($lastRecord) {

      if ($lastRecord['bite_status'] === 'done') {

        $newDoseStatus = 1;
      } else {

        $currentDoseStatus = $lastRecord['dose_status'] ?? 0; // Handle null case
        $newDoseStatus = $currentDoseStatus + 1; // Increment
      }
    }


    // Fetch the ongoing bite event
    $stmt = $con->prepare("SELECT animal_biteID, bite_status 
                             FROM tbl_animal_bite_care 
                             WHERE patient_id = :patientID AND bite_status = 'ongoing'
                             ORDER BY animal_biteID DESC
                             LIMIT 1");
    $stmt->bindParam(':patientID', $patient_id);
    $stmt->execute();
    $biteInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($biteInfo) {
      $animal_biteID = $biteInfo['animal_biteID'];
      $bite_status = $biteInfo['bite_status'];
    } else {
      throw new Exception("No ongoing animal bite event found for the patient.");
    }

    // Insert new vaccination record
    $query = "INSERT INTO tbl_animal_bite_vaccination (`vaccination_name`, `vaccination_date`, `next_visit_date`, `dose_number`, `remarks`, `patient_id`, `stat`, `dose_status`, `bite_status`) 
                VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->execute([$medicine, $visit_date, $next_visit_date, $dose_number, $remarks, $patient_id, $newDoseStatus, $animal_biteID]);

    $lastInsertId = $con->lastInsertId();

    // Update medicine quantity
    $updateQuery = "UPDATE tbl_medicine_details SET qt = qt - ? WHERE medicine_id = ?";
    $updateStmt = $con->prepare($updateQuery);
    $updateStmt->execute([$dose_number, $medicine]);

    // Mark final vaccine and update status if applicable
    if ($final_vaccine) {
      $updateQuery = "UPDATE tbl_complaints SET status = ? WHERE patient_id = ? AND consultation_purpose = 'Animal bite and Care' AND complaintID = ?";
      $updateStmt = $con->prepare($updateQuery);
      $updateStmt->execute(['Done', $patient_id, $complaintID]);

      // Mark final dose status for the last vaccination
      $updateVAC = "UPDATE tbl_animal_bite_vaccination SET stat = ? WHERE patient_id = ? AND animal_bite_vacID = ?";
      $updateStmt = $con->prepare($updateVAC);
      $updateStmt->execute([1, $patient_id, $lastInsertId]);

      // Update bite status to 'done' in tbl_animal_bite_care
      $updateBiteCareQuery = "UPDATE tbl_animal_bite_care SET bite_status = 'done' WHERE patient_id = ?";
      $updateBiteCareStmt = $con->prepare($updateBiteCareQuery);
      $updateBiteCareStmt->execute([$patient_id]);
    }

    // Commit the transaction
    $con->commit();

    // Success message and redirect
    $_SESSION['status'] = "Patient successfully vaccinated.";
    $_SESSION['status_code'] = "success";
    header("Location: controller/follow-up-vaccine.php?id=" . $lastInsertId);
    // header("Location: controller/follow-up-vaccine.php?id=" . $lastInsertId . "&animal_biteID=" . $animalBiteID);

    exit();
  } catch (Exception $e) {
    // Rollback the transaction in case of an error
    $con->rollback();
    echo "Error: " . $e->getMessage();
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
                    <h5 class="card-title">Animal bite & Care</h5>
                  </div>
                  <div class="card-body">
                    <div class="col-12">
                      <div class="d-flex gap-2 justify-content-end mb-2">

                        <a href="records_animalbite.php" type="button" class="btn btn-outline-success ms-1">
                          View Records
                        </a>
                      </div>
                    </div>


                    <div class="table-responsive">
                      <table id="all_patients" class="table table-striped">
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
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // Query for complaints
                          $complaintsQuery = "
            SELECT 
                users.*, 
                family.brgy, 
                family.purok, 
                family.province, 
                mem.*, 
                complaints.* 
            FROM 
                tbl_patients AS users 
            LEFT JOIN 
                tbl_familyAddress AS family ON users.family_address = family.famID 
            LEFT JOIN 
                tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID 
            LEFT JOIN 
                tbl_complaints AS complaints ON users.patientID = complaints.patient_id 
            WHERE 
                (complaints.status = 'pending' 
        OR complaints.status = 'for vaccination') 
            AND complaints.consultation_purpose = 'Animal bite and Care'
            ORDER BY 
                users.patientID DESC;
        ";
                          $complaintsStmt = $con->prepare($complaintsQuery);
                          $complaintsStmt->execute();
                          $complaintsResults = $complaintsStmt->fetchAll(PDO::FETCH_ASSOC);

                          // Query for vaccinations
                          $vaccinationQuery = "
            SELECT 
                vac.vaccination_date, 
                vac.next_visit_date, 
                vac.dose_number, 
                vac.remarks, 
                vac.stat as vac_status,
                vac.dose_status, 
                vac.patient_id
            FROM 
                tbl_animal_bite_vaccination AS vac
            WHERE 
                vac.stat = 0 OR vac.stat IS NULL
            ORDER BY 
                vac.vaccination_date ASC;
        ";
                          $vaccinationStmt = $con->prepare($vaccinationQuery);
                          $vaccinationStmt->execute();
                          $vaccinationResults = $vaccinationStmt->fetchAll(PDO::FETCH_ASSOC);

                          // Combine complaints and vaccination data
                          $patients = [];
                          foreach ($complaintsResults as $complaint) {
                            $patientID = $complaint['patientID'];
                            $patients[$patientID] = $complaint;
                          }

                          foreach ($vaccinationResults as $vaccination) {
                            $patientID = $vaccination['patient_id'];
                            if (isset($patients[$patientID])) {
                              // Append vaccination data to the patient's complaint data
                              $patients[$patientID]['vaccination_date'] = $vaccination['vaccination_date'];
                              $patients[$patientID]['next_visit_date'] = $vaccination['next_visit_date'];
                              $patients[$patientID]['dose_status'] = $vaccination['dose_status'];
                              $patients[$patientID]['vac_status'] = $vaccination['vac_status'];
                            }
                          }

                          // Display data in the table
                          $count = 0;
                          foreach ($patients as $row) {
                            $count++;
                            $vaccinationStatus = '';
                            $showModalButton = false;
                            $showConsultButton = true; // Default to show the consult button

                            if (!empty($row['vaccination_date'])) {
                              $vaccinationDate = new DateTime($row['vaccination_date']);
                              $nextVisitDate = new DateTime($row['next_visit_date']);
                              $today = new DateTime();

                              if ($nextVisitDate == $today) {
                                $vaccinationStatus = '<span class="badge bg-warning">Due for Vaccination Today</span>';
                                $showModalButton = true;
                              } elseif ($nextVisitDate > $today) {
                                $vaccinationStatus = '<span class="badge bg-success">Vaccinated, Next Visit: ' . $nextVisitDate->format('Y-m-d') . '</span>';
                                $showModalButton = true;
                              } elseif ($nextVisitDate < $today) {
                                $vaccinationStatus = '<span class="badge bg-warning">Vaccinated, overdue for next visit</span>';
                                $showModalButton = true;
                              }
                            } else {
                              // Check if vaccination is pending in tbl_complaints
                              if (isset($row['status']) && strtolower($row['status']) == 'pending') {
                                $vaccinationStatus = '<span class="badge bg-danger">Pending</span>';
                              } else {
                                $vaccinationStatus = '<span class="badge bg-danger">Not vaccinated</span>';
                              }
                            }

                            // Disable consult button if the status is 'for vaccination'
                            if ($row['status'] === 'for vaccination') {
                              $showConsultButton = false;
                            }
                          ?>
                            <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo ucwords($row['patient_name'] . ' ' . $row['middle_name'] . '. ' . $row['last_name'] . ' ' . $row['suffix']); ?></td>
                              <td><?php echo $row['brgy'] . ' ' . ucwords($row['purok']) . ' ' . ucwords($row['province']); ?></td>
                              <td><?php echo $row['date_of_birth']; ?></td>
                              <td><?php echo $row['age']; ?></td>
                              <td><?php echo $row['consultation_purpose']; ?></td>
                              <td>
                                <?php
                                if (!isset($row['Nature_Visit']) || empty($row['Nature_Visit'])) {
                                  echo '<span class="badge bg-warning">Not specified</span>';
                                } elseif ($row['Nature_Visit'] == 'New admission' || $row['Nature_Visit'] == 'New consultation/case') {
                                  echo '<span class="">Current</span>';
                                } else {
                                  echo '<span class="">Old Patient/returning</span>';
                                }
                                ?>
                              </td>
                              <td><?php echo $vaccinationStatus; ?></td>
                              <td class="text-center">
                                <?php if ($showConsultButton): ?>
                                  <a href="form_animalbite.php?id=<?php echo $row['complaintID'] ?>" class="btn btn-info btn-sm">
                                    <i class="icon-feather">Consult</i>
                                  </a>
                                <?php endif; ?>

                                <?php if ($showModalButton): ?>
                                  <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#consultModal"
                                    data-patient-id="<?php echo $row['patient_id']; ?>"
                                    data-complaint-id="<?php echo $row['complaintID']; ?>"
                                    data-next-visit="<?php echo $row['next_visit_date']; ?>"
                                    data-vaccination-date="<?php echo $row['vaccination_date']; ?>"
                                    data-dose-status="<?php echo isset($row['dose_status']) ? $row['dose_status'] : $newDoseStatus; ?>">
                                    <i class="icon-med"></i> Schedule Vaccination
                                  </button>
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                      </table>



                      <!-- Modal -->
                      <div class="modal fade" id="consultModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content ">
                            <div class="modal-header ">
                              <h5 class="modal-title" id="consultModalTitle">Schedule Vaccination</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form method="POST" novalidate id="formVaccine">
                                <input type="hidden" id="user" name="patient_id">
                                <input type="hidden" id="complainid" name="hidden1">
                                <input type="hidden" id="vaccine" name="hidden2">

                                <div class="mb-3 row">
                                  <label for="text" class="col-sm-3 col-form-label text-center">Search and Select Vaccine</label>
                                  <div class="col-sm-8">
                                    <select id="vaccineSelect" name="vaccineSelect" class="form-control" required>
                                      <?php echo $medicines; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                      Vaccine is required.
                                    </div>
                                  </div>
                                </div>
                                <div class="mb-3 row">
                                  <label class="col-sm-3 col-form-label text-center"> Dose Quantity</label>
                                  <div class="col-sm-8">


                                    <input type="number" name="dose_number" min="1" class="form-control form-control-sm" required>
                                    <div class="invalid-feedback">
                                      Dose Quantity is required.
                                    </div>
                                  </div>

                                </div>

                                <div class="mb-3 row">
                                  <label for="text" class="col-sm-3 col-form-label text-center">Date Administered</label>
                                  <div class="col-sm-8">
                                    <div class="input-group date" id="date_ad" data-target-input="nearest">
                                      <input type="text" class="form-control datetimepicker-input" data-target="#date_ad" name="date_ad" data-toggle="datetimepicker" autocomplete="off" required />
                                      <div class="input-group-append" data-target="#date_ad" data-toggle="datetimepicker">
                                        <div class="input-group-text" style="height: 100%;">
                                          <i class="icon-calendar" style="height: 100%;"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="mb-3 row">
                                  <label for="text" class="col-sm-3 col-form-label text-center">Next Due Visit</label>
                                  <div class="col-sm-8">
                                    <div class="input-group date" id="next_due" data-target-input="nearest">
                                      <input type="text" class="form-control datetimepicker-input" data-target="#next_due" name="next_due" data-toggle="datetimepicker" autocomplete="off" required />
                                      <div class="input-group-append" data-target="#next_due" data-toggle="datetimepicker">
                                        <div class="input-group-text" style="height: 100%;">
                                          <i class="icon-calendar" style="height: 100%;"></i>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="mb-3 row">
                                  <label for="text" class="col-sm-3 col-form-label text-center">Remarks</label>
                                  <div class="col-sm-8">
                                    <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control" style="resize:none;"></textarea>
                                  </div>
                                </div>

                                <div class="mb-3" style="display: none;" id="finalVaccineSection">
                                  <div class="form-check form-switch">
                                    <input type="checkbox" name="final_vaccine" class="form-check-input" id="finalVaccineCheckbox">
                                    <label class="form-check-label" for="finalVaccineCheckbox">Final Vaccine</label>
                                  </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                              <button type="submit" id="saveNextvaccine" name="saveNextvaccine" class="btn btn-info">Submit</button>
                            </div>
                          </div>
                          </form>
                        </div>
                      </div>



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
      $('#vaccineSelect').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#consultModal')
      });
      $('#date_ad, #next_due').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate: new Date()
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
        "lengthMenu": [5, 10, 20, 50, 100],
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $("#search_patient").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();

        // Make an AJAX request to fetch filtered patient data
        $.ajax({
          type: "POST",
          // url: "ajax/searchpatients.php",
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

  <script>
    var consultModal = document.getElementById('consultModal');
    consultModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget; // Button that triggered the modal
      var patientId = button.getAttribute('data-patient-id');
      var complaintId = button.getAttribute('data-complaint-id');
      var vaccineid = button.getAttribute('data-vaccine-id');
      var nextVisit = button.getAttribute('data-next-visit');
      var vaccinationDate = button.getAttribute('data-vaccination-date');
      var doseStatus = parseInt(button.getAttribute('data-dose-status'));

      // Update the modal's content
      var userInput = consultModal.querySelector('#user');
      var complainIdInput = consultModal.querySelector('#complainid');
      var vaccineIdInput = consultModal.querySelector('#vaccine');

      var nextVisitInput = consultModal.querySelector('input[name="next_due"]');
      var dateAdministeredInput = consultModal.querySelector('input[name="date_ad"]');
      var finalVaccineSection = consultModal.querySelector('#finalVaccineSection');

      userInput.value = patientId;
      complainIdInput.value = complaintId;
      vaccineIdInput.value = vaccineid;
      // nextVisitInput.value = nextVisit; // Set the next visit date
      dateAdministeredInput.value = nextVisit; // Set the vaccination date

      // Show the checkbox for "Final Vaccine" if dose status is 2 or more
      if (doseStatus >= 2) {
        finalVaccineSection.style.display = 'block';
      } else {
        finalVaccineSection.style.display = 'none';
      }
    });
  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('formVaccine');


      // Add validation on form submission
      form.addEventListener('submit', function(event) {
        var isValid = true; // Assume the form is valid


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