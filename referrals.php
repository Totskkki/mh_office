<?php

include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');

$message = '';

?>


<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>

  <?php include './config/data_tables_css.php'; ?>
  <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

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
                    <a href="home.php">Home</a>

                  </li>
                  <li class=" breadcrumb-active">

                  </li>
                </ol>
                <!-- Breadcrumb end -->
                <h2 class="mb-2"></h2>
                <h6 class="mb-4 fw-light">
                  Referrals
                </h6>
              </div>
            </div>
            <!-- Row end -->

            <!-- Row start -->
            <!-- Row start -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Referrals</h5>
                  </div>

                  <div class="card-body">

                    <div class="border rounded-3 p-5">
                      <!-- Search start -->


                      <div class="mb-5">
                        <div class="input-group w-50">
                          <input type="text" class="form-control" id="search_patient" name="search_patient" placeholder="Search Patients" autofocus />
                          <i class="fa fa-search search-icon" aria-hidden="true"></i>
                          <div id="searchResultsContainer" class="search-results-container"></div>
                        </div>

                      </div>


                      <!-- Search end -->

                      <!-- Row start -->


                      <form method="Post" id="referralForm">
                        <input type="hidden" name="patient_id" id="hidden_id">

                        <ul class="list-group list-group-unbordered mb-3" id="patient_details" style="width: 40%;">

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

                        <!-- Row end -->
                        <div class="d-flex gap-2 justify-content-end mb-2">


                          <button type="submit" name="submit" id="submit" class="btn btn-dark print-button" disabled>
                            <i class="icon-printer"></i> Print
                          </button>
                      </form>
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



  <?php include './config/site_js_links.php';
  $message = '';
  if (isset($_GET['message'])) {
    $message = $_GET['message'];
  }
  ?>

  <script src="assets/library/dselect.js"></script>



  <script>
    $(document).ready(function() {
      var debouncedSearch = debounce(performSearch, 300);

      $('#search_patient').on("input", debouncedSearch);

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
          return;
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
        $("#submit").prop('disabled', !patientName);

        var patientId = $(this).data('patient-id');
        $("#hidden_id").val(patientId);

        fetchPatientDetails(patientId);

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

      function fetchPatientDetails(patientId) {
        if (patientId) {
          $.ajax({
            type: "GET",
            url: "ajax/getpatientdetails.php",
            data: {
              patientID: patientId
            },
            success: function(response) {
              var patient = JSON.parse(response);
              if (patient.error) {
                console.log(patient.error);
                return;
              }

              $("#patient_name").text(patient.name);
              $("#patient_gender").text(patient.gender);
              $("#patient_contact").text(patient.phone_number);
              $("#patient_status").text(patient.civil_status);
              $("#patient_age").text(patient.age);
              $("#patient_address").text(patient.familyaddress);
              $("#patient_details").show();
            },
            error: function(error) {
              console.log("Error: " + error);
            }
          });
        } else {
          $("#patient_details").hide().empty();
        }
      }

      $('#referralForm').on('submit', function(e) {
        e.preventDefault();
        if ($("#hidden_id").val()) {
          var formData = $(this).serialize();

          $.ajax({
            type: "POST",
            url: "ajax/save_referral.php",
            data: formData,
            success: function(response) {
              response = JSON.parse(response);
              console.log(response.message);
              if (response.status === "success") {
                window.location.href = 'print_referral.php?id=' + $('#hidden_id').val();
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
    });
  </script>



</body>



</html>