<?php
include './config/connection.php';

include './common_service/common_functions.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}


$patients = getPatients($con);
$doctors = getDoctor($con);
?>


<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>

  <?php include './config/data_tables_css.php'; ?>
  <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>
  <!-- <style>
    body .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header img {
      width: 100px;
    }

    .content {
      width: 60%;
      margin: auto;
    }

    .content p {
      line-height: 1.6;
    }

    .signature {
      margin-top: 40px;
      text-align: right;
    }

    .center {
      justify-content: center;
    }

    .d-flex {
      display: flex;
    }

    .justify-content-center {
      justify-content: center;
    }

    .text-center {
      text-align: center;
    }
  </style> -->
  <style>
    .form-container {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 10px;
    }

    .justify-content-end {
      justify-content: flex-end;

    }

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

    #patient_details,
    .text-muted {
      display: none;

    }

    #patient_details1,
    .text-muted {
      display: none;

    }

    .highlight {
      background-color: #f0f0f0;
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
                  Medical Certificates
                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Medical Certificates</h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-xxl-12">
                        <div class="card mb-4">
                          <div class="card-body">
                            <div class="custom-tabs-container">
                              <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                    aria-controls="oneA" aria-selected="true">Medical Certificates</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab"
                                    aria-controls="twoA" aria-selected="false">Referrals</a>
                                </li>

                              </ul>
                              <div class="tab-content h-350">
                                <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                  <!-- Row start -->
                                  <div class="border rounded-3 p-5">
                                    <div class="mb-5">
                                      <div class="input-group w-50">
                                        <input type="text" class="form-control" id="search_patient" name="search_patient" placeholder="Search Patients" autofocus />
                                        <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                        <div id="searchResultsContainer" class="search-results-container"></div>
                                      </div>
                                    </div>


                                    <form method="POST" id="certificateForm">
                                      <input type="hidden" name="patientid" id="hidden_id">

                                      <ul class="list-group list-group-unbordered mb-3" id="patient_details" style="width: 40%;"></ul>

                                      <div class="d-flex gap-2 justify-content-end mb-2">
                                        <button type="submit" name="submit" id="submit" class="btn btn-dark print-button" disabled>
                                          <i class="icon-printer"></i> Generate
                                        </button>
                                      </div>
                                    </form>

                                  </div>

                                </div>
                                <div class="tab-pane fade" id="twoA" role="tabpanel">
                                  <div class="card-body">


                                    <div class="border rounded-3 p-5">



                                      <div class="mb-5">
                                        <div class="input-group w-50">
                                          <input type="text" class="form-control" id="search_patient1" name="search_patient" placeholder="Search Patients" autofocus />
                                          <i class="fa fa-search search-icon" aria-hidden="true"></i>
                                          <div id="searchResultsContainer1" class="search-results-container"></div>
                                        </div>

                                      </div>




                                      <form method="Post" id="referralForm">
                                        <input type="hidden" name="patient_id" id="hidden_id1">

                                        <ul class="list-group list-group-unbordered mb-3" id="patient_details1" style="width: 40%;">

                                          <li class="list-group-item bg-primary text-white"><b>Patient Record:</b></li>
                                          <li class="list-group-item">
                                            <b>Name:</b> <span class="float-center text-decoration-none text-dark" id="patient_name"></span>
                                          </li>
                                          <li class="list-group-item">
                                            <b>Gender:</b> <span class="float-center text-decoration-none text-dark" id="patient_gender"></span>
                                          </li>
                                          <li class="list-group-item">
                                            <b>Contact no.:</b> <span class="float-center text-decoration-none text-dark" id="patient_contact"></span>
                                          </li>
                                          <li class="list-group-item">
                                            <b>Status:</b> <span class="float-center text-decoration-none text-dark" id="patient_status"></span>
                                          </li>
                                          <li class="list-group-item">
                                            <b>Age:</b> <span class="float-center text-decoration-none text-dark" id="patient_age"></span>
                                          </li>
                                          <li class="list-group-item">
                                            <b>Address:</b> <span class="float-center text-decoration-none text-dark" id="patient_address"></span>
                                          </li>
                                        </ul>

                                        <div class="d-flex gap-2 justify-content-end mb-2">


                                          <button type="submit" name="submit" id="submit1" class="btn btn-dark print-button1" disabled>
                                            <i class="icon-printer"></i> Print
                                          </button>

                                      </form>
                                    </div>

                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
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


  <script>
    // $(document).ready(function() {
    //   $('#search_patient').select2({
    //     placeholder: 'Search Patients'
    //   });
    //   $('#search_doctor').select2({
    //     placeholder: 'Search Doctor'
    //   });
    // });
  </script>

  <script>
    // function checkSelection() {
    //     var patientSelected = document.getElementById('search_patient').value;
    //     var doctorSelected = document.getElementById('search_doctor').value;
    //     var generateButton = document.getElementById('Generate');
    //     generateButton.disabled = !(patientSelected && doctorSelected);
    // }
  </script>




  <script>
    // Medical Certificate search
    $(document).ready(function() {
  var debouncedSearchMedCert = debounce(performSearchMedCert, 300);
  $('#search_patient').keyup(debouncedSearchMedCert);

  function debounce(func, delay) {
    let debounceTimer;
    return function() {
      const context = this;
      const args = arguments;
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
  }

  function performSearchMedCert() {
    var searchTerm = $('#search_patient').val().toLowerCase().trim();
    if (searchTerm === '') {
      $("#searchResultsContainer").html('');
      $("#searchResultsContainer").hide();
      return;
    }

    $.ajax({
      type: "POST",
      url: "ajax/searchpatients.php", // Search patients for medical cert
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

  // Handle selecting patient for Medical Certificate
  $(document).on("click", "#searchResultsContainer .search-item", function() {
    var patientName = $(this).text();  
    $('#search_patient').val(patientName); 
    $("#searchResultsContainer").empty().hide(); 

    var patientId = $(this).data('patient-id'); 
    console.log('Patient ID:', patientId);  

    $("#hidden_id").val(patientId); 
    console.log('Hidden ID value (after setting):', $("#hidden_id").val());  

    $("#submit").prop('disabled', !patientName);  
    fetchPatientDetailsForCert(patientId);  
});



  $('#certificateForm').on('submit', function(e) {
    e.preventDefault();  // Prevent form from submitting normally

    if ($("#hidden_id").val()) {  // Check if hidden_id (patient ID) is set
        var formData = $(this).serialize();  // Serialize form data

        $.ajax({
            type: "POST",
            url: "ajax/generate_cert.php",
            data: formData,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    window.location.href = 'print_cert.php?id=' + $('#hidden_id').val();  // Redirect to print cert
                } else {
                    showCustomMessage(response.message);  // Show error message from server
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    } else {
        showCustomMessage('Please select a valid patient before submitting.');  // Show error message if no patient is selected
    }
});


  function fetchPatientDetailsForCert(patientId) {
    // Fetch patient details for medical certificates
    $.ajax({
      type: "POST",
      url: "ajax/getpatientdetails1.php",
      data: { patient_id: patientId },
      success: function(response) {
        try {
          var patientDetails = JSON.parse(response);
          if (Array.isArray(patientDetails)) {
            var detailsHtml = '';
            var visitGroups = {};
            var hasNoIllness = true;

            patientDetails.forEach(function(detail) {
              var visitDate = detail.visit_date;
              var doctorName = detail.doctors_name || 'Not Available';
              
              if (detail.disease) { 
                hasNoIllness = false; // Patient has an illness
              }

              if (!visitGroups[visitDate]) {
                visitGroups[visitDate] = {
                  doctor: doctorName,
                  issues: detail.disease,
                  nextVisit: detail.next_visit_date,
                  medicines: []
                };
              }

              if (detail.medicine_name) {
                visitGroups[visitDate].medicines.push({
                  name: detail.medicine_name,
                  dosage: detail.dosage ? detail.dosage : '',
                  schedule_dosage: detail.schedule_dosage ? detail.schedule_dosage : ''
                });
              }
            });

            var isFirst = true;
            for (var visitDate in visitGroups) {
              var group = visitGroups[visitDate];
              detailsHtml += generateVisitHTML(isFirst, visitDate, group);
              isFirst = false;
            }

            // Show details for patients without illness for medical cert
            if (hasNoIllness) {
              detailsHtml += generateNoIllnessHTML();
            }

            $("#patient_details").html(detailsHtml);
            $("#patient_details").show();
            $("#Generate").prop("disabled", false);
          } else {
            console.log("Unexpected response format:", patientDetails);
            clearForm();
          }
        } catch (error) {
          console.error("Error parsing patient details:", error);
          clearForm();
        }
      },
      error: function(error) {
        console.log("Error fetching patient details: " + error);
        clearForm();
      }
    });
  }

  function generateVisitHTML(isFirst, visitDate, group) {
    return `
      <li class="list-group-item ${isFirst ? 'bg-primary' : 'bg-secondary'} text-white">
        <b>${isFirst ? 'Current Record' : 'Previous Records'}:</b>
      </li>
      <li class="list-group-item">
        <b>Visit Date:</b> <span class="float-center text-decoration-none text-dark">${visitDate}</span>
      </li>
      <li class="list-group-item">
        <b>Health Issues:</b> <span class="float-center text-decoration-none text-dark">${group.issues}</span>
      </li>
      <li class="list-group-item">
        <b>Next Visit Date:</b> <span class="float-center text-decoration-none text-dark">${group.nextVisit}</span>
      </li>
      <li class="list-group-item">
        <b>Doctor's Name:</b> <span class="float-center text-decoration-none text-dark">${group.doctor}</span>
      </li>
      <li class="list-group-item">
        <b>Medicines:</b> <ul>
        ${group.medicines.map(med => `<li>${med.name} - ${med.dosage}, ${med.schedule_dosage}</li>`).join('')}
        </ul>
      </li>`;
  }

  function generateNoIllnessHTML() {
    return `
      <li class="list-group-item bg-success text-white">
        <b>No illness found during checkup.</b>
      </li>`;
  }

  function clearForm() {
    $("#hidden_id").val('');
    $("#patient_details").html('');
    $("#Generate").prop("disabled", true);
  }

  function showCustomMessage(message) {
    alert(message);
  }



      function clearForm() {
        $("#hidden_id").val('');
        $("#patient_details").html('');
        $("#Generate").prop("disabled", true);
      }

      function renderPatientDetailsForCert(patientDetails) {
        // Logic to render the patient details in the Medical Certificates section

      }







      // Referrals search (similar logic but separate AJAX calls and event handlers)
      var debouncedSearchReferral = debounce(performSearchReferral, 300);
      $('#search_patient1').on("input", debouncedSearchReferral);

      function performSearchReferral() {
        var searchTerm = $('#search_patient1').val().toLowerCase().trim();
        if (searchTerm === '') {
          $("#searchResultsContainer1").html('');
          $("#searchResultsContainer1").hide();
          return;
        }

        $.ajax({
          type: "POST",
          url: "ajax/searchpatients.php", // Search patients for referral
          data: {
            search: searchTerm
          },
          success: function(response) {
            $("#searchResultsContainer1").html(response);
            $("#searchResultsContainer1").show();
          },
          error: function(error) {
            console.log("Error: " + error);
            $("#searchResultsContainer1").html('');
            $("#searchResultsContainer1").hide();
          }
        });
      }

      $(document).on("click", "#searchResultsContainer1 .search-item", function() {
        var patientName = $(this).text();
        $('#search_patient1').val(patientName);
        $("#searchResultsContainer1").empty().hide();
        $("#submit1").prop('disabled', !patientName);
        var patientId = $(this).data('patient-id');
        $("#hidden_id1").val(patientId);
        fetchPatientDetailsForReferral(patientId);
      });
      $('#referralForm').on('submit', function(e) {
        e.preventDefault();
        if ($("#hidden_id1").val()) {
          var formData = $(this).serialize();

          $.ajax({
            type: "POST",
            url: "ajax/save_referral.php",
            data: formData,
            success: function(response) {
              response = JSON.parse(response);
              console.log(response.message);
              if (response.status === "success") {
                window.location.href = 'print_referral.php?id=' + $('#hidden_id1').val();
              } else {
                showCustomMessage(response.message);
              }
            },
            error: function(xhr, status, error) {
              console.error("Error: " + error);
            }
          });
        } else {
          showCustomMessage('Please select a valid patient before submitting.');
        }
      });

      function fetchPatientDetailsForReferral(patientId) {
        // Fetch patient details for referral
        $.ajax({
          type: "GET",
          url: "ajax/getpatientdetails.php",
          data: {
            patientID: patientId
          },
          success: function(response) {
            var patient = JSON.parse(response);
            // Render patient details for referral
            // renderPatientDetailsForReferral(patient);

            $("#patient_name").text(patient.name);
            $("#patient_gender").text(patient.gender);
            $("#patient_contact").text(patient.phone_number);
            $("#patient_status").text(patient.civil_status);
            $("#patient_age").text(patient.age);
            $("#patient_address").text(patient.familyaddress);
            $("#patient_details1").show();
          },
          error: function(error) {
            console.log("Error: " + error);
          }
        });
      }

      function renderPatientDetailsForReferral(patient) {
        // Logic to render the patient details in the Referrals section
      }
    });
  </script>
</body>



</html>