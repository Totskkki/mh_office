<?php

include './config/connection.php';
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

date_default_timezone_set('Asia/Manila');

$message = '';
function backupDatabaseTables($dbHost, $dbUsername, $dbPassword, $dbName, $tables = '*')
{
  $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch tables
  if ($tables == '*') {
    $tables = array();
    $result = $conn->query('SHOW TABLES');
    while ($row = $result->fetch_row()) {
      $tables[] = $row[0];
    }
  } else {
    $tables = is_array($tables) ? $tables : explode(',', $tables);
  }

  $return = '';

  foreach ($tables as $table) {
    $result = $conn->query('SELECT * FROM ' . $table);
    $numColumns = $result->field_count;

    $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
    $row2 = $conn->query('SHOW CREATE TABLE ' . $table)->fetch_row();
    $return .= "\n\n" . $row2[1] . ";\n\n";

    for ($i = 0; $i < $numColumns; $i++) {
      while ($row = $result->fetch_row()) {
        $return .= 'INSERT INTO ' . $table . ' VALUES(';
        for ($j = 0; $j < $numColumns; $j++) {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
          $return .= isset($row[$j]) ? '"' . $row[$j] . '"' : '""';
          if ($j < ($numColumns - 1)) {
            $return .= ',';
          }
        }
        $return .= ");\n";
      }
    }
    $return .= "\n\n\n";
  }

  // Create backup file content
  $backupFile = 'db-backup-' . date('YmdHis') . '.sql';

  // Set headers for file download
  header('Content-Type: application/sql');
  header('Content-Disposition: attachment; filename="' . $backupFile . '"');

  // Output the SQL script
  echo $return;

  // Close the connection
  $conn->close();
  exit();
}

// Trigger backup process
if (isset($_POST['backup'])) {
  backupDatabaseTables('localhost', 'root', '', 'mh_office');
}
if (isset($_POST['restore'])) {
  if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] === UPLOAD_ERR_OK) {
    $uploadDirectory = 'uploads/';
    $fileTmpPath = $_FILES['backupFile']['tmp_name'];
    $fileName = basename($_FILES['backupFile']['name']);
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Check if the file is a .sql file
    if (strtolower($fileExtension) === 'sql') {
      // Ensure the uploads directory exists
      if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
      }

      // Move the uploaded file to the uploads directory
      $filePath = $uploadDirectory . $fileName;
      if (move_uploaded_file($fileTmpPath, $filePath)) {
        restoreDatabase($filePath); // Call the restore function
      } else {
        $_SESSION['status'] = "Failed to upload the backup file.";
        $_SESSION['status_code'] = "error";
        header('Location: backup.php');
        exit();
      }
    } else {
      $_SESSION['status'] = "Invalid file type. Only .sql files are allowed.";
      $_SESSION['status_code'] = "error";
      header('Location: backup.php');
      exit();
    }
  } else {
    // Error during file upload
    if ($_FILES['backupFile']['error'] !== UPLOAD_ERR_NO_FILE) {
      $_SESSION['status'] = "Error uploading file. Error Code: " . $_FILES['backupFile']['error'];
    } else {
      $_SESSION['status'] = "No file selected. Please upload a .sql file.";
    }
    $_SESSION['status_code'] = "error";
    header('Location: backup.php');
    exit();
  }
}


function restoreDatabase($filePath)
{
   $dbHost = 'localhost';
  $dbUsername = 'root';
  $dbPassword = '';
  $dbName = 'mh_office';

  $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
  if ($conn->connect_error) {
    $_SESSION['status'] = "Database connection failed: " . $conn->connect_error;
    $_SESSION['status_code'] = "error";
    header('Location: backup.php');
    exit();
  }

  $sql = file_get_contents($filePath);
  if ($sql === false) {
    $_SESSION['status'] = "Failed to read the backup file.";
    $_SESSION['status_code'] = "error";
    header('Location: backup.php');
    exit();
  }

  $conn->query('SET FOREIGN_KEY_CHECKS=0');

  if ($conn->multi_query($sql)) {
    do {
      if ($result = $conn->store_result()) {
        $result->free();
      }
    } while ($conn->more_results() && $conn->next_result());

    $_SESSION['status'] = "Database successfully restored from the backup file: $filePath.";
    $_SESSION['status_code'] = "success";
  } else {
    $_SESSION['status'] = "Error during restoration: " . $conn->error;
    $_SESSION['status_code'] = "error";
  }

  $conn->query('SET FOREIGN_KEY_CHECKS=1');
  $conn->close();

  header('Location: backup.php');
  exit();
}


?>


<!DOCTYPE html>
<html lang="en">


<head>
  <?php include './config/site_css_links.php'; ?>

  <?php include './config/data_tables_css.php'; ?>
  <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

  <style>
    #patient_details,
    .text-muted {
      display: none;

    }

    .blur-effect {
      filter: blur(2px);
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1050;
    }

    .loading-message {
      background: white;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      text-align: center;
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
                    <a href="dashboard.php">Home</a>

                  </li>
                  <li class=" breadcrumb-active">

                  </li>
                </ol>
                <!-- Breadcrumb end -->
                <h2 class="mb-2"></h2>
                <h6 class="mb-4 fw-light">
                  Backup
                </h6>
              </div>
            </div>

            <!-- Row start -->
            <div class="loading-overlay" id="loadingOverlay">
              <div class="loading-message">
                <h2 class="text-control">Please wait for the process to be done...</h2>
                <div class="progress" style="width: 70%; margin: 20px auto;">
                  <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Backup System</h5>
                  </div>
                  <div class="card-body">
                    <!-- Backup Button -->
                    <form method="post">
                      <div class="col-sm-3 offset-sm-4 col-12 mb-4">
                        <button type="submit" id="backup" name="backup" class="form-control btn btn-info">
                          Backup Database
                        </button>
                      </div>
                    </form>

                    <!-- Restore Button with File Upload -->
                    <form method="post" enctype="multipart/form-data">
                      <div class="col-sm-3 offset-sm-4 col-12 mb-3">
                        <div class="form-group mb-3">
                          <label for="backupFile">Select Backup File:</label>
                          <input type="file" name="backupFile" id="backupFile" class="form-control" accept=".sql" required>
                        </div>
                      </div>
                      <div class="col-sm-3 offset-sm-4 col-12 mb-3">
                        <button type="submit" id="restore" name="restore" class="form-control btn btn-success">
                          Restore Database
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>





            <!-- Row end -->




            <!-- Row end -->
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

  <script>
   document.getElementById('restore').addEventListener('click', function(event) {
  const fileInput = document.getElementById('backupFile');
  
  // Check if a file is selected
  if (fileInput.files.length === 0) {
    alert('Please select a backup file before proceeding.');
    event.preventDefault(); // Prevent form submission
    return;
  }

  // Check if the selected file is a .sql file
  const fileName = fileInput.files[0].name;
  const fileExtension = fileName.split('.').pop().toLowerCase();
  if (fileExtension !== 'sql') {
    alert('Invalid file type. Please upload a .sql file.');
    event.preventDefault(); // Prevent form submission
    return;
  }

  // Show the loading overlay if file validation passes
  document.getElementById('loadingOverlay').style.display = 'flex';
  document.querySelector('.card').classList.add('blur-effect');
  animateProgressBar();
});

function animateProgressBar() {
  let progress = 0;
  const interval = setInterval(function() {
    progress += 5;
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('progressBar').setAttribute('aria-valuenow', progress);
    if (progress >= 100) {
      clearInterval(interval);
    }
  }, 200);
}

  </script>



</body>



</html>