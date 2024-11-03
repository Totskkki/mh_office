<?php
include './config/connection.php';

include './common_service/common_functions.php';
date_default_timezone_set('Asia/Manila');
$message = '';


if (isset($_POST['save_vaccine'])) {
    $patient_id = trim($_POST['patient_id']);
    $medicine = trim($_POST['vaccineSelect']);
    $visit_date = date("Y-m-d", strtotime($_POST['visit_date']));
    $dose_number = trim($_POST['dose_number']);
    $remarks = trim($_POST['remarks']);
    $next_visit_date = date("Y-m-d", strtotime($_POST['next_visit_date']));

    $next_status = 'for vaccination';
    
    $current_date = new DateTime(); // Get today's date
    $visit_date_obj = new DateTime($visit_date);

    // Calculate the difference in days between the current date and the visit date
    $interval = $current_date->diff($visit_date_obj);
    $days_difference = $interval->days;

    // Determine the next status
    if ($days_difference == 0) {
        $next_status = 'for vaccination';
    } elseif ($days_difference > 0) {
        $next_status = 'for vaccination';
    }

    // Start the transaction
    $con->beginTransaction();

    try {



        $stmt = $con->prepare("SELECT animal_biteID , bite_status 
        FROM tbl_animal_bite_care 
        WHERE patient_id = :patientID 
          AND bite_status = 'ongoing'
        ORDER BY animal_biteID  DESC
        LIMIT 1");
        $stmt->bindParam(':patientID', $patient_id);
        $stmt->execute();
        $birthInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($birthInfo) {
            // Ongoing birthing event found
            $animal_biteID = $birthInfo['animal_biteID'];
            $bite_status = $birthInfo['bite_status'];
        } else {
            // No ongoing birthing event found
            // Handle accordingly: you can throw an error or start a new birthing event
            throw new Exception("No ongoing animal bite event found for the patient.");
        }

        // Insert vaccination details
        $query = "INSERT INTO tbl_animal_bite_vaccination 
                  (`vaccination_name`, `vaccination_date`, `next_visit_date`, `dose_number`, `remarks`, `patient_id`, `dose_status`,`bite_status`) 
                  VALUES (?, ?, ?, ?, ?, ?, 1,?)";
        $stmt = $con->prepare($query);
        $stmt->execute([$medicine, $visit_date, $next_visit_date, $dose_number, $remarks, $patient_id,$animal_biteID]);

        $lastInsertId = $con->lastInsertId();

        // Update medicine quantity
        $updateQuery = "UPDATE tbl_medicine_details SET qt = qt - ? WHERE medicine_id = ?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->execute([$dose_number, $medicine]);

        // Check if there are previous records with the status 'done' for the same patient
        $checkQuery = "SELECT COUNT(*) FROM tbl_complaints WHERE patient_id = ? AND status = 'Done'";
        $checkStmt = $con->prepare($checkQuery);
        $checkStmt->execute([$patient_id]);
        $doneCount = $checkStmt->fetchColumn();

        if ($doneCount > 0) {
            // Update only the 'Pending' records to 'for vaccination'
            $updateComplaintsQuery = "UPDATE tbl_complaints 
                                      SET status = ? 
                                      WHERE patient_id = ? 
                                      AND status = 'Pending'";
        } else {
            // If no 'Done' records are found, update records with 'Pending' status
            $updateComplaintsQuery = "UPDATE tbl_complaints 
                                      SET status = ? 
                                      WHERE patient_id = ? 
                                      AND status = 'Pending'";
        }
        
        $updateComplaintsStmt = $con->prepare($updateComplaintsQuery);
        $updateComplaintsStmt->execute([$next_status, $patient_id]);
        // Commit the transaction
        $con->commit();

        $_SESSION['status'] = "Patient successfully vaccinated.";
        $_SESSION['status_code'] = "success";

        header("Location: controller/patient_vaccinecard.php?id=" . $lastInsertId);
        exit();
    } catch (Exception $e) {
        // Rollback on failure
        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Fetch available vaccines
$medicines = getvaccine($con);


?>





<!DOCTYPE html>
<html lang="en">


<head>
    <?php include './config/site_css_links.php'; ?>

    <?php include './config/data_tables_css.php'; ?>
    <title>Patients - Kalilintad Lutayan-Municipal Health Office</title>

    <style>
        .card {
            border: 1px solid #000;
            /* 1px solid border */
            margin: 0 auto;
            /* Center the card horizontally */
        }

        .app-body {
            display: flex;
            justify-content: center;
            align-items: center;
            /* min-height: 100vh; Center vertically in viewport */
        }

        
    </style>



</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->


        <!-- Sidebar wrapper start -->
        <?php include './config/session.php';


        // if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['user_type'] === 'RHU') {
        //     header("location: RHU/dashboard-mho.php");
        //     exit;
        // } 
        ?>
        <!-- Sidebar wrapper end -->

        <!-- App container starts -->
        <div class="app-container">

            <!-- App header starts -->


            <div class="app-header d-flex align-items-center ">
                <!-- <a href="animal_bite.php" class="btn btn-primary">
                    <i class="icon-chevron-left"></i> Back</i>
                </a> -->
                <!-- App header actions start -->
                <div class="header-actions">

                    <div class="d-md-flex d-none gap-2">

                        <br>
                        


                    </div>
                    <div class="dropdown ms-3">
                       

                        <a class="dropdown-toggle d-flex align-items-center" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <img src="<?php echo (!empty($user['profile_picture'])) ? '../user_images/' . $user['profile_picture'] : '../user_images/profile.jpg'; ?>" class="img-3x m-2 ms-0 rounded-5" alt="user image" />
                            <div class="d-flex flex-column">

                                <span><?php echo $user['first_name'] . ' ' . $user['lastname']; ?></span>

                            </div>
                           

                        </a>

                    </div>
                </div>

            </div>
            <!-- App header actions end -->

        </div>
        <!-- App header ends -->



        <!-- App body starts -->
        <div class="app-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-10 col-lg-12 col-md-12 col-sm-12">
                    <a href="animal_bite.php" type="button" class="btn btn-primary"><i class="fs-5 icon-corner-up-left"></i> Home</a>
                        <h2 class="text-center">Animal bite Vaccine</h2>
                        <div class="card mx-auto" style="border: 1px solid #000;">
                            <div class="card-header text-center">
                                <!-- <h5 class="card-title">Patient Information</h5> -->
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-5 col-sm-4 col-12">


                                        <?php if (isset($_GET['patient_name'])) {
                                            $patient_name = urldecode($_GET['patient_name']);
                                            $patient_id = urldecode($_GET['hidden_id']);
                                            echo "<h3> <strong>" . htmlspecialchars($patient_name) . "
                                            
                                            </strong></h3>";
                                        }
                                        ?>

                                    </div>

                                </div>

                                <hr />
                                <!-- Row start -->
                                <form method="POST">

                                    <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
                                    <div class="row">
                                        <style>
                                            
                                        </style>
                                        <div class="col-lg-5 col-sm-2 col-12 mb-3">

                                        <div class="col-lg-12">
                                        <label for="vaccineSelect" class="form-label">Search and Select Vaccine</label>
                                        <select id="vaccineSelect" name="vaccineSelect" class="form-control">
                                            <?php echo $medicines; ?>
                                        </select>
                                    </div>




                                        </div>
                                        <div class="col-lg-5 col-sm-2 col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Date Vaccinated</label>
                                                <div class="input-group date" id="visit_date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#visit_date" name="visit_date" data-toggle="datetimepicker" autocomplete="off" required />
                                                    <div class="input-group-append" data-target="#visit_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-5 col-sm-2 col-12 mb-3">
                                            <label class="form-label"> Dose Quantity</label>
                                            <input type="number" name="dose_number" class="form-control form-control-sm" min="0" required>
                                        </div>
                                        <div class="col-lg-5 col-sm-2 col-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Next Schedule Vaccination</label>
                                                <div class="input-group date" id="next_visit_date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#next_visit_date" name="next_visit_date" data-toggle="datetimepicker" autocomplete="off" required />
                                                    <div class="input-group-append" data-target="#next_visit_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12  col-12 mb-3">
                                                <label class="form-label"> Remarks </label>
                                                <textarea name="remarks" id="" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="submit" id="save_vaccine" name="save_vaccine" class="btn btn-info">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Row end -->
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- App body ends -->



        <!-- App footer start -->
        <?php include './config/footer.php';
        $message = '';
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        ?>
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
    <!-- <script src="assets/select2.js"></script> -->



    <script type="text/javascript">
        $(function() {
            $('#visit_date').datetimepicker({
                format: 'L',
                minDate: new Date()

            });
            $('#next_visit_date').datetimepicker({
                format: 'L',
                minDate: new Date()

            });

        });
    </script>




    <script>
    $(document).ready(function() {
        $('#vaccineSelect').select2()
    });
</script>
   

   
   



</body>



</html>