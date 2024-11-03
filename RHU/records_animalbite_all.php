<?php
include './config/connection.php';
include './common_service/common_functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './config/site_css_links.php'; ?>
    <?php include './config/data_tables_css.php'; ?>
    <title>Patient Records - Kalilintad Lutayan-Municipal Health Office</title>
</head>
<body>
    <div class="page-wrapper">
        <div class="main-container">
            <nav id="sidebar" class="sidebar-wrapper">
                <div class="app-brand px-3 py-2 d-flex align-items-center">
                    <a href="index.html">
                        <img src="assets/images/logo.svg" class="logo" alt="Bootstrap Gallery" />
                    </a>
                </div>
                <?php include './config/sidebar.php'; ?>
            </nav>
            <div class="app-container">
                <?php include './config/header.php'; ?>
                <div class="app-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-xl-12">
                                <ol class="breadcrumb mb-1">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    
                                </ol>
                                <h6 class="mb-4 fw-light">Animal bite records</h6>
                            </div>
                        </div>
                        <?php
                        if (isset($_GET['id'])) {
                            $patientID = $_GET['id'];

                            $query = "SELECT a.*, pat.*, fam.*,
                                             CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS name,
                                             CONCAT(fam.brgy, ' ', fam.purok, ' ', fam.province) AS address
                                      FROM tbl_animal_bite_care AS a
                                      JOIN tbl_patients AS pat ON a.patient_id = pat.patientID
                                      JOIN tbl_familyaddress AS fam ON pat.family_address = fam.famID
                                     
                                      WHERE a.patient_id = :patientID";

                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
                            $stmt->execute();

                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($row) {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <div class="mb-2 d-flex align-items-end justify-content-between">
                                                    <h2 class="card-title">All Records / <?php echo htmlspecialchars($row['name']); ?></h2>
                                                    <a href="records_animalbite.php" class="btn btn-primary float-end">
                                                        <i class="icon-chevron-left"></i> Back
                                                    </a>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered align-middle m-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                               
                                                                <th>Category Exposure</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                           $query = "SELECT * FROM tbl_animal_bite_care 
                                                           WHERE patient_id = :patientID AND bite_status = 'done'
                                                           ORDER BY date DESC"; 
                                                            $stmtRecords = $con->prepare($query);
                                                            $stmtRecords->bindParam(':patientID', $patientID, PDO::PARAM_INT);
                                                            $stmtRecords->execute();

                                                            $records = $stmtRecords->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($records as $record) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($record['date']); ?></td>
                                                                 
                                                                   
                                                                    <td><?php echo 'Category ' . htmlspecialchars($record['category_exposure']); ?></td>
                                                                    
                                                                    <td class="text-center">
                                                                        <a href="controller/view_animalbite.php?id=<?php echo htmlspecialchars($record['animal_biteID']); ?>" class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="View Details" >
                                                                            <i class="icon-eye"></i> View Details
                                                                        </a>
                                                                        <a href="controller/vaccine_card.php?id=<?php echo htmlspecialchars($record['animal_biteID']); ?>" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip-primary" data-bs-title="download">
                                                                            <i class="icon-download"></i>
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
                                <?php
                            } else {
                                echo '<div class="alert alert-warning">No records found for the specified patient ID.</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger">No patient ID provided.</div>';
                        }
                        ?>
                    </div>
                </div>
                <?php include './config/footer.php'; ?>
            </div>
        </div>
    </div>
    <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>
    <script>
        $(document).ready(function() {
            $(".table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "dom": '<"row"<"col-md-6 text-left"l><"col-md-6 text-right"f>>rt<"bottom"ip><"clear">',
                "lengthMenu": [10, 20, 50, 100],
            });
        });
    </script>
</body>
</html>
