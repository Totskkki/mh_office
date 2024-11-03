<?php
include './config/connection.php';
include './common_service/common_functions.php';

$message = '';
if (isset($_POST['saveRecord'])) {
    $patient = trim($_POST['patient']);
    $age = trim($_POST['age']);
    $dexam = trim($_POST['dexam']);
    $doctor = trim($_POST['doctor']);


    $address = trim($_POST['address']);
    $diagnostic = trim($_POST['diagnostic']);
    $remarks = trim($_POST['remarks']);
    $gender = trim($_POST['gender']);

    $patient = ucwords(strtolower($patient));
    $address = ucwords(strtolower($address));

    if ($patient != '' && $age != '' && $dexam != '' && $address != '' && $diagnostic != '' && $remarks != '' && $gender != '') {
        $query = "INSERT INTO `med_cert_info`(`patient_id`, `gender`, `date_examined`, `age`, `address`, `diagnostic`, `recom`,`doctor`)
          VALUES ('$patient','$gender','$dexam','$age','$address','$diagnostic','$remarks','$doctor')";


        try {
            $con->beginTransaction();
            $stmtPatient = $con->prepare($query);
            $stmtPatient->execute();
            $con->commit();
            $message = 'Medical Certificate added successfully.';
        } catch (PDOException $ex) {
            $con->rollback();
            echo $ex->getMessage();
            echo $ex->getTraceAsString();
            exit;
        }
    }
    header("Location:congratulation.php?goto_page=medical_certificates.php&message=$message");
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
    <title>Medicines - Kalilintad Lutayan-Municipal Health Office</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        .input-group input,
        .input-group textarea,
        .input-group select {
            border: none;

            border-radius: 0;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini white-mode layout-fixed layout-navbar-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include './config/header.php';
        include './config/sidebar.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Medical Certificates</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->

                <div class="card card-outline card-primary rounded-0 shadow">
                    <div class="card-header ">
                        <h3 class="card-title ">Create Medical Certificate</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">


                                        <form method="post">


                                            <div class="mb-3">
                                                <div class="row">


                                                    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic  ">
                                                            <label for="text" class="form-label">Select Patient</label>
                                                            <select id="patient" name="patient" class="form-control form-control-sm rounded-0" required="required">
                                                                <?php echo $patients; ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic  ">
                                                            <label for="suffix" class="form-label">Age</label>
                                                            <input type="number" id="age" name="age" value="" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mb-3 ">
                                                        <div class="input-group input-group-dynamic  is-filled">
                                                            <label for="dob" class="form-label">Date Examined</label>
                                                            <input type="date" id="dexam" name="dexam" value="" class="form-control" required="required">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mb-3 ">
                                                        <div class="input-group input-group-dynamic  is-filled">
                                                            <label for="gender" class="form-label">Gender</label>
                                                            <input type="text" id="gender" name="gender" class="form-control form-control-sm rounded-0" readonly>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic is-filled">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea type="text" id="address" name="address" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic is-filled">
                                                            <label for="diagnostic" class="form-label">Doctor's Diagnostic</label>
                                                            <textarea type="text" id="diagnostic" name="diagnostic" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic is-filled">
                                                            <label for="remarks" class="form-label ">Recommendation:</label>
                                                            <textarea type="text" id="remarks" name="remarks" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mb-3">
                                                        <div class="input-group input-group-dynamic is-filled">
                                                            <label>Doctor</label>
                                                            <select id="doctor" name="doctor" class="form-control form-control-sm rounded-0" required="required">
                                                                <?php echo $doctors; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <button type="submit" name="saveRecord" id="saveRecord" class="btn bg-gradient-primary w-100">Save Record</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card card-outline card-primary rounded-0 shadow">
                    <div class="card-header">
                        <h3 class="card-title">Manage Certificates</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row table-responsive">
                            <table id="all_patients" class="table table-striped dataTable table-bordered dtr-inline" role="grid" aria-describedby="all_patients_info">

                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Date Created</th>
                                        <th>Patient Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    try {
                                        $query = "SELECT m.*, p.id AS patient_id, p.patient_name AS name, m.date_examined
                                                        FROM patients p 
                                                        JOIN med_cert_info m ON p.id = m.patient_id";


                                        $stmtPatient1 = $con->prepare($query);
                                        $stmtPatient1->execute();
                                    } catch (PDOException $ex) {
                                        echo $ex->getMessage();
                                        echo $ex->getTraceAsString();
                                        exit;
                                    }
                                    ?>
                                    <?php
                                    $count = 0;
                                    if ($stmtPatient1->rowCount() > 0) {
                                        while ($row = $stmtPatient1->fetch(PDO::FETCH_ASSOC)) {
                                            $count++;
                                    ?>
                                            <tr class="text-center">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row['date_examined']; ?></td>
                                                <td><?php echo $row['name']; ?></td>



                                                <td class="text-center">
                                                    <a href="generate_certificate.php?id=<?php echo $row['id']; ?>&ACTION=VIEW" class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    </a><a href="generate_certificate.php?id=<?php echo $row['id']; ?>&ACTION=DOWNLOAD" class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    </a><a href="generate_certificate.php?id=<?php echo $row['id']; ?>&ACTION=UPLOAD" class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fa fa-upload"></i>
                                                    </a>


                                                    <a href="update_medical_certificates.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fa fa-edit"></i>
                                                    </a>


                                                    <form action="delete_certificate.php" method="post" style="display: inline;" onsubmit="return confirmDelete();">
                                                        <button type="submit" name="delete_certificate" value="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn-flat">
                                                            <i class="fa fa-trash"></i> </a>
                                                        </button>
                                                    </form>
                                                </td>

                                                <script>
                                                    function confirmDelete() {
                                                        return confirm("Are you sure you want to delete this patient?");
                                                    }
                                                </script>



                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h4>NO records found! </h4>
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


                <!-- /.card -->
            </section>

            <?php include './config/footer.php';

            $message = '';
            if (isset($_GET['message'])) {
                $message = $_GET['message'];
            }
            ?>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <?php include './config/site_js_links.php'; ?>
        <?php include './config/data_tables_js.php'; ?>





        <script>
            showMenuSelected("#mnu_reports", "#mi_certificates");

            var message = '<?php echo $message; ?>';

            if (message !== '') {
                showCustomMessage(message);
            }
        </script>





        <script>
            $(document).ready(function() {
                // Function to update gender and address based on selected patient
                function updatePatientInfo() {
                    var selectedPatientId = $("#patient").val();

                    // Make an AJAX request to fetch patient details based on the selected ID
                    $.ajax({
                        type: 'GET',
                        url: 'get_patient_details.php',
                        data: {
                            id: selectedPatientId
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Update gender and address fields
                            $("#gender").val(response.gender);
                            $("#address").val(response.address);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching patient details:', error);
                            console.log(xhr.responseText); // Log the detailed error response
                        }
                    });
                }

                // Attach the updatePatientInfo function to the onchange event of the "patient" select element
                $("#patient").on("change", updatePatientInfo);

                // Trigger the updatePatientInfo function initially to populate the fields with the default selected patient
                updatePatientInfo();


            });
        </script>




</body>

</html>