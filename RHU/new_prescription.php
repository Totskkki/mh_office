<?php
include './config/connection.php';

include './common_service/common_functions.php';


$message = '';


if (isset($_POST['submit'])) {
  

  $patientId = $_POST['selected_patient_id'];
  $doctorId = $_POST['doctor'];
  $visitDate = $_POST['visit_date'];
  $nextVisitDate = $_POST['next_visit_date'];
  $disease = $_POST['disease'];
  $recom = $_POST['recom'];
  $timeframe = $_POST['combinedTimeFrame'];


  $medicineDetailIds = $_POST['medicineDetailIds'];
  $quantities = $_POST['quantities'];
  $dosages = $_POST['dosages'];
  $mg = $_POST['mg_ml'];
  $Duration = $_POST['duration'];
  $advice = $_POST['advice'];
  $schedule_dosage = $_POST['schedule_dosage'];
  $con_type = $_POST['con_type'];



  $visitDateArr = explode("/", $visitDate);
  $visitDate = $visitDateArr[2] . '-' . $visitDateArr[0] . '-' . $visitDateArr[1];

  if ($nextVisitDate != '') {
    $nextVisitDateArr = explode("/", $nextVisitDate);
    $nextVisitDate = $nextVisitDateArr[2] . '-' . $nextVisitDateArr[0] . '-' . $nextVisitDateArr[1];
  }

  try {
    $con->beginTransaction();

    $query = "INSERT INTO `tbl_certificate_log`(`patient_id`, `status`)
    VALUES (?,'pending')";
     $stmtDoc = $con->prepare($query);
     $stmtDoc->execute([$patientId]);
    // Insert visit information
    $queryVisit = "INSERT INTO `tbl_patient_visits`(`visit_date`, `next_visit_date`, `disease`,`recom`, `patient_id`, `doctor_id`)
                     VALUES(?, ?, ?, ?, ?,?)";
    $stmtVisit = $con->prepare($queryVisit);
    $stmtVisit->execute([$visitDate, $nextVisitDate, $disease, $recom, $patientId, $doctorId]);
    $lastInsertId = $con->lastInsertId();


    // Insert medication history
    $size = count($medicineDetailIds);
    for ($i = 0; $i < $size; $i++) {
      $curMedicineDetailId = $medicineDetailIds[$i];
      $curQuantity = $quantities[$i];
      $curDosage = $dosages[$i];
      $curMg = $mg[$i];
      $curDuration = $Duration[$i];
      $curAdvice = $advice[$i];
      $schedule = $schedule_dosage[$i];
      $contype = $con_type[$i];
      $time_frame = $timeframe[$i];


      // Insert medication history
      $queryMedicationHistory = "INSERT INTO `tbl_patient_medication_history`(`patient_visit_id`, `medicine_details_id`,`con_type`, `quantity`, `dosage`,`schedule_dosage`, `mg_ml`, `duration`,`time_frame`, `advice`)
                                     VALUES(?, ?, ?, ?, ?, ?, ?,?,?,?)";
      $stmtDetails = $con->prepare($queryMedicationHistory);
      $stmtDetails->execute([$lastInsertId, $curMedicineDetailId,  $contype, $curQuantity, $curDosage, $schedule, $curMg, $curDuration, $time_frame, $curAdvice]);

      // Update medicine quantity
      // $queryUpdateQuantity = "UPDATE `tbl_medicine_details` SET `qt` = `qt` - ? WHERE `med_detailsID` = ?";
      // $stmtUpdateQuantity = $con->prepare($queryUpdateQuantity);
      // $stmtUpdateQuantity->execute([$quantities, $curMedicineDetailId]);

      $updateQuery = "UPDATE tbl_medicine_details SET qt = qt - ? WHERE medicine_id = ?";
      $updateStmt = $con->prepare($updateQuery);
      $updateStmt->execute([$curQuantity, $curMedicineDetailId]);
    }
   


    $con->commit();

    $_SESSION['status'] = "Patient Medication stored successfully.";
    $_SESSION['status_code'] = "success";

    
  } catch (PDOException $ex) {
    $con->rollback();
    echo $ex->getTraceAsString();
    echo $ex->getMessage();
    exit;
  } catch (Exception $ex) {
    $con->rollback();
    echo $ex->getMessage();
    exit;
  }

  header("location:new_prescription.php");
  exit;

  // header("Location: controller/prescription.php?id=" . $lastInsertId);
  // exit();
}
$doctors = getDoctor($con);
$patients = getPatients($con);
$medicines = getpresMedicines($con);






?>


<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>

  <?php include './config/data_tables_css.php'; ?>
  <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

  <style>
    .search-container {
      position: relative;
      display: inline-block;

    }

    .search-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      display: none;
      /* Initially hide the icon */
    }

    .search-item {
      font-size: 20px;

    }

    .search-results-container {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background-color: white;
      border: 1px solid #ccc;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
      z-index: 1000;
      display: none;
      overflow-y: auto;
      max-height: 300px;
      /* Adjust as needed */
    }

    .search-results-container ul {
      list-style: none;
      margin: 0;
      padding: 0;
      font-size: 200px;
    }

    .search-results-container li {
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .search-results-container li:hover {
      background-color: #f5f5f5;
    }

    .highlight {
      background-color: #f0f0f0;
    }
  </style>

</head>a

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
                    / Patient Prescription
                  </li>
                </ol>
                <!-- Breadcrumb end -->
                <h2 class="mb-2"></h2>
                <h6 class="mb-4 fw-light">

                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Patient Prescription</h5>
                  </div>
                  <div class="card-body">


                    <form id="medicationForm" method="post" onsubmit="return validateForm()">
                      

                      <input type="hidden" id="selected-patient-id" name="selected_patient_id">
                      <div class="mb-2">
                        <div class="search-container">
                          <input type="text" class="form-control" id="search_patient" name="search_patient" placeholder="Search Patients" autofocus style="width: 500px;" required>
                          <i class="fa fa-search search-icon" aria-hidden="true"></i>
                          <div id="searchResultsContainer" class="search-results-container"></div>
                          <span id="search_patient-error" style="color: red; display: none;">Patient is required.</span>
                        </div>
                      </div>
                      <br>
                      <br>
                      <br>

                      <div class="row">

                        <div class="col-lg-4 col-md-3 col-sm-4 col-xs-10">
                          <div class="form-group">
                            <label class="form-label" for="text">Visit Date</label>
                            <div class="input-group date" id="visit_date" data-target-input="nearest">
                              <input type="text" class="form-control  datetimepicker-input" data-target="#visit_date" name="visit_date" data-toggle="datetimepicker" autocomplete="off"required />
                              <div class="input-group-append" data-target="#visit_date" data-toggle="datetimepicker">
                                <div class="input-group-text" style="height: 100%;">
                                  <i class="fa fa-calendar" style="height: 100%;"></i>
                                </div>
                              </div>
                            </div>
                            <span id="visit_date-error" class="error-message" style="color: red; display: none;">Visit date is required.</span>
                          </div>
                        </div>



                        <div class="col-lg-4 col-md-3 col-sm-4 col-xs-10">
                          <div class="form-group">
                            <label class="form-label" for="text">Next Visit Date</label>
                            <div class="input-group date" id="next_visit_date" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#next_visit_date" name="next_visit_date" data-toggle="datetimepicker" autocomplete="off" required />
                              <div class="input-group-append" data-target="#next_visit_date" data-toggle="datetimepicker">

                                <div class="input-group-text" style="height: 100%;">
                                  <i class="fa fa-calendar" style="height: 100%;"></i>
                                </div>
                              </div>
                            </div>
                            <span id="next_visit_date-error" class="error-message" style="color: red; display: none;">Next visit date is required.</span>
                          </div>
                        </div>

                        <div class="clearfix">&nbsp;</div>



                        <div class="col-lg-3 col-md-8 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Illness</label>
                          <input id="disease" name="disease" class="form-control " />
                          <span id="disease-error" class="error-message" style="color: red; display: none;">Disease is required.</span>
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Doctor</label>
                          <select name="doctor" class="form-select  " required>

                            <?php echo $doctors; ?>
                          </select>
                          <span id="doctor-error" class="error-message" style="color: red; display: none;">Doctor is required.</span>
                        </div>
                        <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Instructions</label>
                          <textarea name="recom" id="recom" rows="2" class="form-control" style="resize: none;" required></textarea>
                          <span id="recom-error" class="error-message" style="color: red; display: none;">Instructions are required.</span>
                        </div>
                        
                      </div>

                      <div class="col-md-12">
                        <hr />
                      </div>
                      <div class="clearfix">&nbsp;</div>

                      <div class="row">

                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Select Medicine</label>
                          <select id="medicine" class="form-select ">
                            <?php echo $medicines; ?>
                          </select>
                          <span id="medicine-error" class="error-message" style="color: red; display: none;">Medicine is required.</span>
                        </div>


                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Strength</label>
                          <input type="text" class="form-control" name="mg" id="mg" placeholder="Enter Strength">
                         <span id="mg-error" class="error-message" style="color: red; display: none;">Medicine strength is required.</span>
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 mb-3">
                          <label class="form-label" for="text">Consumption type</label>
                          <!-- <input id="mg" name="mg" class="form-control form-control-sm rounded-0" /> -->
                          <select name="con_type" id="con_type" class="form-select ">
                            <option value=""></option>
                            <option value="Oral(p/o)">Oral (p/o)</option>
                            <option value="Cream/Lotion/Ointment">Cream/Lotion/Ointment</option>
                            <option value="Drops">Drops</option>
                            <option value="Injection(Subcutaneous/SubQ)">Injection(Subcutaneous/SubQ)</option>
                            <option value="Intramuscular">Intramuscular</option>
                            <option value="Suppository">Suppository</option>
                            <option value="Spray">Spray</option>
                          </select>
                        </div>
                    
                        <div class="col-lg-1 col-md-2 col-sm-6 col-xs-12">
                          <label class="form-label" for="text">Time Frame</label>
                          <input type="text" class="form-control" id="timeframe">

                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                          <div class="form-check">
                            <input class="form-check-input timeframe" type="checkbox" name="time_frame" id="time_frame_day" value="Day">
                            <label class="form-check-label" for="time_frame_day">
                              Day
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input timeframe" type="checkbox" name="time_frame" id="time_frame_month" value="Month">
                            <label class="form-check-label" for="time_frame_month">
                              Month
                            </label>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label class="form-label" for="text">Quantity per dosage</label>

                            <input type="number" min="0" id="quantity" name="quantity" class="form-control " placeholder="Enter Quantity" />
                          </div>
                          <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                            <label class="form-label" for="text">Dose frequency</label>
                            <!-- <input id="Duration" name="Duration" class="form-control form-control-sm rounded-0" /> -->
                            <select name="Duration" id="Duration" class="form-select ">
                              <option value=""></option>
                              <option value="Hourly">Hourly</option>
                              <option value="Daily">Daily</option>
                              <option value="Weekly">Weekly</option>
                              <option value="Monthly">Monthly</option>
                              <option value="Twice a day">Twice a day</option>
                              <option value="Three time a day">Three time a day</option>
                              <option value="Four time a day">Four time a day</option>
                              <option value="Every hour">Every hour</option>
                              <option value="Every 2 hours">Every 2 hours</option>
                              <option value="Every 3 hours">Every 3 hours</option>
                              <option value="Every 4 hours">Every 4 hours</option>

                            </select>
                          </div>
                          <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">
                            <label class="form-label" for="text">Dosage</label>
                            <div class="button-group" style="display: flex; gap: 0;">
                              <button type="button" id="as-needed" name="dosage" value="as needed" class="form-control border border-blue" style="background-color: #4284f5; color: white;">As needed</button>
                              <button type="button" id="schedule-dose" name="dosage" value="schedule dose" class="form-control">Schedule dose</button>

                            </div>
                          </div>
                          <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 mb-3">
                            <label class="form-label" for="text">Dose Schedule</label>
                            <select name="schedule_dosage" id="schedule_dosage" class="form-select">
                              <option value=""></option>
                              <option value="Before Meal">Before Meal</option>
                              <option value="After Meal">After Meal</option>
                              <option value="In the morning">In the morning</option>
                              <option value="In the afternoon">In the afternoon</option>
                              <option value="In the evening">In the evening</option>
                              <option value="At night">At night</option>
                            </select>
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-lg col-12">
                            <div class="mb-3 mt-3">
                              <label class="form-label" for="text">Guidance</label>
                              <textarea style="resize:none;" id="Advice" class="form-control" data-ms-editor="true"></textarea>

                            </div>
                          </div>



                        </div>
                        <div class="row">
                          <div class="">

                            <button type="button" class="btn btn-info btn-sm  " id="add_to_list"><i class="fa fa-plus"></i> Add</button>
                          </div>
                        </div>

                        <div class="clearfix">&nbsp;</div>
                        <div class="row table-responsive">
                          <table id="medication_list" class="table table-striped table-bordered">
                            <colgroup>
                              <!-- <col width="10%">
                                                            <col width="20%">
                                                            <col width="20%">
                                                            <col width="10%">
                                                            <col width="15%">
                                                            <col width="10%">
                                                            <col width="10%">
                                                            <col width="10%">
                                                            <col width="5%"> -->
                            </colgroup>
                            <thead class="bg-primary">
                              <tr>
                                <th>#</th>
                                <th>Medicine Name</th>

                                <th>Strenght</th>
                                <th>Consumption type</th>
                                <th>Time Frame</th>

                                <th>QTY</th>
                                <th>Duration</th>
                                <th>Dosage</th>
                                <th>Dose Schedule</th>

                                <th>Guidance</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            <tbody id="current_medicines_list">

                            </tbody>
                          </table>
                        </div>

                        <div class="clearfix">&nbsp;</div>
                        <!-- <input type="hidden" name="selected-patient-id" id="selected-patient-id" /> -->

                        <div class="row">
                          <div class="col-md-10">&nbsp;</div>
                          <div class="col-md-2">
                            <button type="submit" id="submitBtn" name="submit" class="btn btn-info float-end">Save</button>
                            
                          </div>
                          
                        </div>
                    </form>

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
 

 
  <script>
    $(document).ready(function() {
      var message = '<?php echo $message; ?>';

      if (message !== '') {
        showCustomMessage(message);
      }

      var debouncedSearch = debounce(performSearch, 300);

      $('#search_patient').keyup(debouncedSearch);

      function debounce(func, delay) {
        let debounceTimer;
        return function() {
          const context = this;
          const args = arguments;
          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(() => func.apply(context, args), delay);
        };
      }

      function performSearch() {
        var searchTerm = $('#search_patient').val().toLowerCase().trim();
        if (searchTerm === '') {
          $("#searchResultsContainer").html('');
          $("#searchResultsContainer").hide();
          return; // Exit the function if the search term is empty
        }

        $.ajax({
          type: "POST",
          url: "ajax/searchpatients.php",
          data: {
            search: searchTerm
          },
          success: function(response) {
            $("#searchResultsContainer").html(response);
            $("#searchResultsContainer").show();

          },
          error: function(error) {
            console.log("Error: " + error);
            $("#searchResultsContainer").html('');
            $("#searchResultsContainer").hide();
          }
        });
      }
      $(document).on("mouseenter", ".search-item", function() {
        $(this).addClass('highlight');
      });

      $(document).on("mouseleave", ".search-item", function() {
        $(this).removeClass('highlight');
      });

      // Click event for search result
      $(document).on("click", ".search-item", function() {
        var patientName = $(this).text();
        $('#search_patient').val(patientName);
        $("#searchResultsContainer").empty();
        $("#searchResultsContainer").hide();

        // Log the clicked patient name
        console.log("Clicked on patient: ", patientName);

        var patientId = $(this).data('patient-id'); // Retrieve the patient ID from the data attribute
        $('#selected-patient-id').val(patientId)
        console.log("Selected patient: ", patientId);

        // Set focus on the input field
        $('#search_patient').focus();
      });

      $('#search_patient').on('input', function() {
        var inputValue = $(this).val().trim();
        if (inputValue) {
          $('.search-icon').show();
        } else {
          $('.search-icon').hide();
        }
      });
    });
  </script>
  <script>
    var serial = 1;

    $(document).ready(function() {
      $('#medication_list').find('td').addClass("px-2 py-1 align-middle")
      $('#medication_list').find('th').addClass("p-1 align-middle")
      $('#visit_date, #next_visit_date').datetimepicker({
        format: 'L',
        minDate: new Date()

      });

      $("#medicine").change(function() {
        var medicineId = $(this).val();
        if (medicineId !== '') {
          $.ajax({
            url: "ajax/get_packings.php",
            type: 'GET',
            data: {
              'medicine_id': medicineId
            },
            cache: false,
            success: function(data) {
              $("#packing").html(data);
            },
            error: function(jqXhr, textStatus, errorMessage) {
              showCustomMessage(errorMessage);
            }
          });
        }
      });

      $("#add_to_list").click(function() {
        var medicineId = $("#medicine").val();
        var medicineName = $("#medicine option:selected").text();

        var quantity = $("#quantity").val().trim();
        var dosage = $("button[name='dosage'].active").val();
        var schedule_dosage = $("#schedule_dosage").val().trim();

        var mg = $("#mg").val().trim();
        var con_type = $("#con_type").val().trim();
        var timeframe = $("#timeframe").val().trim();
        var time = $('input[name="time_frame"]:checked').map(function() {
          return this.value;
        }).get().join(', ');
        var duration = $("#Duration").val().trim();
        var advice = $("#Advice").val().trim();

        if (medicineName && quantity && dosage && mg && duration && advice) {
          var combinedTimeFrame = timeframe ? `${timeframe} (${time})` : time;
          var inputs = `
            <input type="hidden" name="medicineDetailIds[]" value="${medicineId}" />
            <input type="hidden" name="mg_ml[]" value="${mg}" />
            <input type="hidden" name="con_type[]" value="${con_type}" />
            <input type="hidden" name="combinedTimeFrame[]" value="${combinedTimeFrame}" />
            
            <input type="hidden" name="quantities[]" value="${quantity}" />
            <input type="hidden" name="dosages[]" value="${dosage}" />
            <input type="hidden" name="schedule_dosage[]" value="${schedule_dosage}" />
            <input type="hidden" name="duration[]" value="${duration}" />
            <input type="hidden" name="advice[]" value="${advice}" />
                    
                   
                `;

          var tr = `
                    <tr>
              <td class="px-2 py-1 align-middle">${serial}</td>
               <td class="px-2 py-1 align-middle">${medicineName}</td>
                <td class="px-2 py-1 align-middle">${mg}</td>
                <td class="px-2 py-1 align-middle">${con_type}</td>
                <td class="px-2 py-1 align-middle">${combinedTimeFrame}</td>
                <td class="px-2 py-1 align-middle">${quantity}</td>
                <td class="px-2 py-1 align-middle">${dosage} ${inputs}</td>
                <td class="px-2 py-1 align-middle">${duration}</td>
                <td class="px-2 py-1 align-middle">${schedule_dosage}</td>
                <td class="px-2 py-1 align-middle">${advice}</td>
                     
                        
                       
                        <td class="px-2 py-1 align-middle text-center"><button type="button" class="btn btn-outline-danger btn-sm rounded-0" onclick="deleteCurrentRow(this);"><i class="fa fa-times"></i></button></td>
                    </tr>
                `;

          $("#current_medicines_list").append(tr);
          serial++;

          $("#medicine")[0].selectedIndex = -1;
          $("#mg").val('');
          $("#con_type").val('');
          $("#quantity").val('');
          $("#timeframe").val('');
          $('input[name="time_frame"]').prop('checked', false);
          $("button[name='dosage']").removeClass("active");
          $("#Duration").val('');
          $("#schedule_dosage").val('');
          $("#Advice").val('');
        } else {
          showCustomMessage('Please fill all fields.');
        }
      });
      $("button[name='dosage']").click(function() {
        $("button[name='dosage']").removeClass("active");
        $(this).addClass("active");
      });
    });

    
    function validateField(fieldId) {
        var field = $("#" + fieldId);
        var errorField = $("#" + fieldId + "-error");
        if (field.val().trim() === '') {
            errorField.show();
            return false;
        } else {
            errorField.hide();
            return true;
        }
    }

 
    function validateForm() {
        var isValid = true;
      
        var fieldsToValidate = [
            "search_patient", "visit_date", "next_visit_date", "disease", "doctor", "recom",
            "medicine", "mg", "con_type", "timeframe", "quantity", "Duration", "time", "Advice"
        ];

      
        fieldsToValidate.forEach(function(fieldId) {
            if (!validateField(fieldId)) {
                isValid = false;
            }
        });

        return isValid;
    }

    // Event listener for form submission
    $("#medicationForm").on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault(); 
          
            alert('Please fill all required fields.');
        }
    });

    // Event listener for the submit button click (optional)
    $("#submitBtn").on('click', function() {
        if (!validateForm()) {
          e.preventDefault(); 
            alert('Please fill all required fields.');
        }
    });

    // Event listener for individual fields blur
    $("#search_patient, #visit_date, #next_visit_date, #disease, #doctor, #recom, #medicine, #mg, #con_type, #timeframe, #quantity, #Duration, #time, #Advice").on('blur', function() {
        validateField($(this).attr('id'));
    });

  </script>




  <script>
  
    function toggleButtons(activeButton, inactiveButton, selectElement) {
      if (inactiveButton.disabled) {
        inactiveButton.disabled = false;
        activeButton.style.backgroundColor = '#4284f5';
        activeButton.style.color = 'white';
        inactiveButton.style.backgroundColor = '';
        inactiveButton.style.color = '';
        selectElement.disabled = false;
      } else {
        inactiveButton.disabled = true;
        activeButton.style.backgroundColor = '#4284f5';
        activeButton.style.color = 'white';
        inactiveButton.style.backgroundColor = '#CCCCCC';
        inactiveButton.style.color = '#666';
        selectElement.disabled = activeButton.id === 'as-needed';
        
      }
    }

    // Event listeners for the buttons
    document.getElementById('as-needed').addEventListener('click', function() {
      var scheduleDosageSelect = document.getElementById('schedule_dosage');
      toggleButtons(this, document.getElementById('schedule-dose'), scheduleDosageSelect);
      // Reset the value of the select element when disabling it
      if (this.disabled) {
        scheduleDosageSelect.selectedIndex = 0;
      }
    });

    document.getElementById('schedule-dose').addEventListener('click', function() {
      toggleButtons(this, document.getElementById('as-needed'), document.getElementById('schedule_dosage'));
    });
    $(".timeframe").on("change", function() {
      if ($(".timeframe:checked").length == 1) {
        $(".timeframe").attr("disabled", "disabled");
        $(".timeframe:checked").removeAttr("disabled");
      } else {
        $(".timeframe").removeAttr("disabled");
      }
    });
  </script>





</body>



</html>