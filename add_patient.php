<?php
include 'config/connection.php';

include 'common_service/common_functions.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'path_to_your_error_log_file.log');

$message = '';




function getAffectedRecordName($table, $recordId, $con)
{
    switch ($table) {
        case 'tbl_patients':
            $stmt = $con->prepare("SELECT patient_name, last_name FROM tbl_patients WHERE patientID  = ?");

            $stmt->execute([$recordId]);
            $result = $stmt->fetch();
            if ($result) {
                return trim(($result['patient_name'] ?? '') . ' ' . ($result['last_name'] ?? ''));
            } else {
                return 'Unknown'; // If no record is found
            }

            // case 'tbl_doctors':
            //     $stmt = $con->prepare("SELECT doctor_name FROM tbl_doctors WHERE doctor_id = ?");
            //     $stmt->execute([$recordId]);
            //     $result = $stmt->fetch();
            //     return $result['doctor_name'] ?? 'Unknown';

            // Add other tables as needed
        default:
            return 'Unknown';
    }
}
function logAuditTrail($userId, $action, $description, $table, $recordId, $con)
{
    // Get IP address
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    // Insert into audit trail
    $stmt = $con->prepare("INSERT INTO tbl_audit_trail (user_id, action, description, affected_table, affected_record_id, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $action, $description, $table, $recordId, $ipAddress]);
}



if (isset($_POST['save_Patient'])) {


    $user = $_SESSION['user_id'];
    $patientName = trim($_POST['patient_name']);
    $patientName = ucwords(strtolower($patientName));
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $suffix = trim($_POST['suffix']);
    // $family_no = trim($_POST['family_no']);
    $household_no = trim($_POST['household_no']);



    $cnic = trim($_POST['cnic']);
    
    
      $m_name = trim($_POST['m_name']);
    $relation = trim($_POST['relationship']);

    $dateBirth = trim($_POST['date_of_birth']);
    // $dateOfBirth = date('Y-m-d', strtotime($dateBirth));
    // $dateBirth = date("Y-m-d", strtotime($_POST['date_of_birth']));
    $dateArr = explode("/", $dateBirth);
    // $dateBirth = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

    if ($dateBirth) {
        $dateArr = explode("/", $dateBirth);
        if (count($dateArr) == 3) {
            $dateBirth = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];
        } else {
            $dateBirth = '';
        }
    }


    $religion = trim($_POST['religion']);
    $placeofBirth = trim($_POST['placeofBirth']);
    $Age = trim($_POST['Age']);

    $phoneNumber = trim($_POST['phone_number']);

    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';


    $Purok = trim($_POST['Purok']);
    $Purok = ucwords(strtolower($Purok));
    $address = trim($_POST['address']);
    $address = ucwords(strtolower($address));

    //$city_municipality = trim($_POST['city_municipality']);
    $Province = trim($_POST['Province']);
    $Province = ucwords(strtolower($Province));

    $Nationality = trim($_POST['Nationality']);
    $ed_att = trim($_POST['ed_att']);
    $emp_stat = trim($_POST['emp_stat']);
    $status = trim($_POST['Status']);
    // $Weight = trim($_POST['Weight']);
    $Blood  = trim($_POST['Blood']);

    $philhealth  = trim($_POST['Philhealth']);

    $Phil_member = isset($_POST['Phil_member']) ? trim($_POST['Phil_member']) : '';
    $Phil_no = isset($_POST['Phil_no']) ? trim($_POST['Phil_no']) : '';

    $MemCat = trim($_POST['MemCat']);

    // $m_name = trim($_POST['m_name']);
    // $f_gname = trim($_POST['f_gname']);
    
    $memberContact = trim($_POST['memberContact']);
    $memberAddress = trim($_POST['memberAddress']);





    // Proceed with saving the patient details
    // Your existing code to save patient details goes here
    $con->beginTransaction();
    try {

        $insertFamilyQuery = "INSERT INTO tbl_familyAddress (brgy, purok, province,place_of_birth) VALUES (:address, :Purok,:province,:place_of_birth)";
        $stmtFamily = $con->prepare($insertFamilyQuery);
        $stmtFamily->execute([
            ':address' => $address,
            ':Purok' => $Purok,
            ':province' => $Province,
            ':place_of_birth' => $placeofBirth,

        ]);
        $familyId = $con->lastInsertId();


        if ($philhealth === "No") {
            $Phil_member = '';
            $Phil_no = '';
        } else {
            // Ensure that the input mask characters are removed
            $Phil_no = !empty($Phil_no) ? preg_replace('/[^0-9]/', '', $Phil_no) : NULL; // Remove everything except numbers
            $Phil_member = !empty($Phil_member) ? $Phil_member : NULL;
        }

        $insertMembershipQuery = "INSERT INTO tbl_membership_info (phil_mem, philhealth_no, phil_membership, ps_mem)
                VALUES (:Phil_member, :Phil_no, :Phil_membership, :ps_mem)";
        $stmtMembership = $con->prepare($insertMembershipQuery);
        $stmtMembership->execute([
            ':Phil_member' => $philhealth,
            ':Phil_no' => $Phil_no,
            ':Phil_membership' => $Phil_member,
            ':ps_mem' => $MemCat
        ]);
        $membershipId = $con->lastInsertId();



        $insertPatientQuery = "INSERT INTO tbl_patients (patient_name, household_no, middle_name, last_name, suffix,cnic, date_of_birth, age, phone_number, gender, civil_status, blood_type, ed_at, emp_stat, religion,Nationality, family_address, membership_info, userID)
                VALUES (:patientName, :household_no, :middle_name, :last_name, :suffix, :cnic, :dateBirth, :Age, :phoneNumber, :gender, :civil_status, :Blood, :ed_att, :emp_stat,:religion, :Nationality, :familyId, :membershipId, :userID)";
        $stmtPatient = $con->prepare($insertPatientQuery);
        $stmtPatient->execute([
            ':patientName' => $patientName,
            ':household_no' => $household_no,
            ':middle_name' => $middle_name,
            ':last_name' => $last_name,
            ':suffix' => $suffix,
            ':cnic' => $cnic,
            ':dateBirth' => $dateBirth,
            ':Age' => $Age,
            ':phoneNumber' => $phoneNumber,
            ':gender' => $gender,
            ':civil_status' => $status,
            ':Blood' => $Blood,
            ':ed_att' => $ed_att,
            ':emp_stat' => $emp_stat,
            ':Nationality' => $Nationality,
            ':religion' => $religion,
            ':familyId' => $familyId,
            ':membershipId' => $membershipId,
            ':userID' => $user
        ]);


        $lastInsertId = $con->lastInsertId();


        $insertFatherGuardianQuery = "INSERT INTO tbl_family_members (name, relationship,contact, address, patient_id) 
                            VALUES (:name,:relationship, :contact, :address, :patient_id)";
        $stmtFatherGuardian = $con->prepare($insertFatherGuardianQuery);
        $stmtFatherGuardian->execute([
            ':name' => $m_name,
            ':relationship' => $relation,
            ':contact' => $memberContact,
            ':address' => $memberAddress,
            ':patient_id' => $lastInsertId,
        ]);






        $affectedName = getAffectedRecordName('tbl_patients', $lastInsertId, $con);

        logAuditTrail($user, 'Insert', 'Added patient: ' . $affectedName, 'tbl_patients', $lastInsertId, $con);


        $con->commit();

        echo "<script>alert('Patient added successfully. You will be redirected to another page.');</script>";
        $message = 'Patient added successfully.';
        echo "<script>window.location.href = 'individual_treatment?complaintID=$lastInsertId&famID=$familyId&membershipID=$membershipId&message=$message';</script>";
        exit;
    } catch (PDOException $ex) {

        $con->rollback();
        echo $ex->getMessage();
        echo $ex->getTraceAsString();
        exit;
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
                                        / Add Patient
                                    </li>
                                </ol>
                                <!-- Breadcrumb end -->
                                <h2 class="mb-2">Patient Registration</h2>
                                <h6 class="mb-4 fw-light">
                                    Mga impormasyon ng pasyente
                                </h6>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Patient information</h5>
                                        <br>
                                        <h5 class="form-text" style="color:#EF0000"><i class="icon-info"></i> Fields with (*) are required.</h5>


                                    </div>




                                    <div class="card-body">
                                        <form method="post" id="patient_form" novalidate>

                                            <?php


                                            $lastFamilyNumberQuery = "SELECT household_no FROM tbl_patients ORDER BY patientID DESC LIMIT 1";
                                            $lastFamilyNumberStatement = $con->prepare($lastFamilyNumberQuery);

                                            if ($lastFamilyNumberStatement->execute()) {
                                                $lastFamilyNumberResult = $lastFamilyNumberStatement->fetch(PDO::FETCH_ASSOC);

                                                if ($lastFamilyNumberResult !== false && isset($lastFamilyNumberResult['household_no'])) {
                                                    $lastFamilyNumber = $lastFamilyNumberResult['household_no'];
                                                } else {
                                                    $lastFamilyNumber = '';
                                                }
                                            } else {
                                                $errorInfo = $lastFamilyNumberStatement->errorInfo();
                                                echo "Error executing query: " . $errorInfo[2];
                                                exit;
                                            }


                                            function generateFamilyNumber($lastFamilyNumber)
                                            {
                                                $characters = '0123456789';
                                                $length = 7;

                                                if ($lastFamilyNumber !== '') {

                                                    $lastNumber = intval(preg_replace('/[^0-9]/', '', $lastFamilyNumber));
                                                    $lastNumber++;
                                                    $newNumber = str_pad($lastNumber, $length, '0', STR_PAD_LEFT);
                                                } else {

                                                    $newNumber = '';
                                                    for ($i = 0; $i < $length; $i++) {
                                                        $newNumber .= $characters[rand(0, strlen($characters) - 1)];
                                                    }
                                                }

                                                return $newNumber;
                                            }

                                            $newFamilyNumber = generateFamilyNumber($lastFamilyNumber);


                                            ?>

                                            <div class="row">
                                                <?php
                                                $query = "SELECT patientID FROM tbl_patients ORDER BY patientID DESC LIMIT 1";
                                                $stmt = $con->query($query);
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $cnic = "0000000001";

                                                if ($row !== false) {
                                                    $lastId = $row['patientID'];
                                                    $cnic = str_pad($lastId + 1, 10, '0', STR_PAD_LEFT);
                                                }
                                                ?>

                                                <div class="col-lg-2 col-sm-2 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc">ITR No:</label>
                                                        <input type="text" class="form-control form-control-sm rounded-0" id="cnic" value="<?php echo $cnic ?>" name="cnic" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc1">Family no:</label>
                                                        <input type="number" class="form-control form-control-sm rounded-0" value="<?php echo $newFamilyNumber; ?>" min="0" id="household_no" name="household_no" readonly />
                                                        <span class="badge bg-info"><?php echo 'Current Family No.' ?></span>


                                                    </div>

                                                </div>

                                                <!-- <hr style="width: 57%;" /> -->

                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="patient_name">First Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " id="patient_name" name="patient_name"
                                                                pattern="^[A-Za-z\s\-]{2,}$"
                                                                title="First name should be at least 2 characters and contain only letters." required pattern="[a-zA-ZñÑ\s\.]+"/>
                                                            <div class="invalid-feedback">
                                                                First Name is required and without numbers.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc1">Middle Name</label>
                                                            <input type="text" class="form-control " id="middle_name" name="middle_name" placeholder="Optional" pattern="[a-zA-ZñÑ\s\.]+" />

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last_name">Last Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " id="last_name" name="last_name"
                                                                pattern="^[A-Za-z\s\-]{2,}$"
                                                                title="Last name should be at least 2 characters and contain only letters." required pattern="[a-zA-ZñÑ\s\.]+"/>
                                                            <div class="invalid-feedback">
                                                                Last Name is required and without numbers.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Suffix</label>
                                                            <input type="text" class="form-control " id="suffix" name="suffix" />
                                                            <span>
                                                                <p>(Jr./Sr./III)</p>
                                                            </span>

                                                        </div>
                                                    </div>
                                                 
                                                  <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Purok: <span class="text-danger">*</span></label>

                                                            <textarea class="form-control "  name="Purok" cols="30" rows="1" required></textarea>


                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label " for="abc6">Barangay: <span class="text-danger">*</span></label>

                                                            <select class="form-control "required  name="address">
                                                                <?php echo getbrgy(); ?>
                                                            </select>
                                                        <div class="invalid-feedback">
                                                                Barangay is required.
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Province: <span class="text-danger">*</span></label>
                                                             <input type="text" class="form-control "  name="Province" value="Sultan Kudarat"  readonly/>
                                                        <div class="invalid-feedback">
                                                                Province is required.
                                                            </div>

                                                        </div>

                                                    </div>



                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Place of Birth:<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " name="placeofBirth" required />
                                                            <div class="invalid-feedback">
                                                                Place of Birth is required.
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc7">Date of Birth: <span class="text-danger">*</span></label>

                                                            <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                                                <input type="text" class="form-control  datetimepicker-input" data-target="#date_of_birth" name="date_of_birth" data-toggle="datetimepicker" autocomplete="off" required />
                                                                <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                                    <div class="input-group-text" style="height: 100%;"><i class="fa fa-calendar" style="height: 100%;"></i></div>
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Date of Birth is required.
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Age</label>
                                                            <input type="text" min="0" max="999" class="form-control " id="Age" name="Age" readonly required />
                                                            <div class="invalid-feedback">
                                                                Age is required.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="abc6">Sex: <span class="text-danger">*</span></label>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php echo getGender(); ?>
                                                                    <div class="invalid-feedback">
                                                                    Sex is required.
                                                                </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Phone number: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="phone_number" name="phone_number" required />
                                                            <div class="invalid-feedback">
                                                                Phone number is required and must contain only numbers.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="abc6">Civis Status: <span class="text-danger">*</span></label>
                                                            <select class="form-control " id="Status" name="Status" required>
                                                                <?php
                                                                echo  getstat();
                                                                ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Civis Status is required.
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-1">
                                                            <label class="form-label" for="abc6">Blood Type: <span class="text-danger">*</span></label>
                                                            <select class="form-control " id="Blood" name="Blood" required>
                                                                <?php
                                                                echo  getblood();
                                                                ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Blood Typeis required.
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Nationality Type: <span class="text-danger">*</span></label>
                                                            <select class="form-control " id="Nationality" name="Nationality" required>
                                                                <?php
                                                                echo  getnationality();
                                                                ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Nationality Type is required.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Educational Attainment</label>
                                                            <select class="form-control " id="ed_att" name="ed_att">
                                                                <?php
                                                                echo  geteducation();
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Occupation:</label>
                                                            <input type="text" inputmode="text" class="form-control " id="emp_stat" name="emp_stat" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Religion:</label>
                                                            <select name="religion" id="" class="form-select ">
                                                                <option value="">Select Religion</option>
                                                                <option value="Islam">Islam </option>
                                                                <option value="Roman Catholic">Roman Catholic </option>
                                                                <option value="Iglesia ni Cristo(INC)">Iglesia ni Cristo(INC) </option>
                                                                <option value="Seventh-day Adventist Church">Seventh-day Adventist Church </option>
                                                                <option value="Animism and Indigenous Beliefs">Animism and Indigenous Beliefs </option>
                                                                <option value="ehovah's Witnesses">Jehovah's Witnesses </option>
                                                                <option value="Hinduism">Hinduism </option>
                                                                <option value="Philippine Independent Church (Aglipayan Church)">Philippine Independent Church (Aglipayan Church) </option>
                                                                <option value="Baptists">Baptists </option>
                                                                <option value="Methodists">Methodists </option>
                                                                <option value="Lutherans">Lutherans </option>
                                                                <option value="Kingdom of Jesus Christ, The Name Above Every Name(KOJIC) ">Kingdom of Jesus Christ, The Name Above Every Name(KOJIC) </option>
                                                                <option value="Church of Jesus Christ of Latter-day Saints (LDS)">Church of Jesus Christ of Latter-day Saints (LDS)</option>




                                                            </select>
                                                        </div>
                                                    </div>
                                                     <hr style="width: 100%;" />
                                                      <div class="row">
                                                    <u><i>
                                                            <h3>Emergency Contact</h3>
                                                        </i></u>
                                                        <br/>
                                                </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Contact Name : <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " id="m_name" name="m_name" placeholder="First Name   Middle Name   Last Name" style="width: 100%; padding: 8px;"

                                                                title="Mothers Name  is required and contain only letters." required pattern="[a-zA-ZñÑ\s\.]+"/>
                                                            <div class="invalid-feedback">
                                                                Contact Name is required "
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Relationship to Patient: <span class="text-danger">*</span></label>
                                                            <select name="relationship" class="form-select" required>
                                                                    <option value="">-Select-</option>
                                                                    <option value="Mother">Mother</option>
                                                                    <option value="Father">Father</option>
                                                                    <option value="Son">Son</option>
                                                                    <option value="Daugther">Daugther</option>
                                                                    <option value="Grand Father">Grand Father</option>
                                                                    <option value="Grand Mother">Grand Mother</option>
                                                                    <option value="Sibling">Sibling</option>
                                                                    <option value="Uncle">Uncle</option>
                                                                    <option value="Aunt">Aunt</option>
                                                                    <option value="Guardian">Guardian</option>
                                                                     <option value="Employer">Employer</option>
                                                                       <option value="Husband">Husband</option>
                                                                       <option value="Wife">Wife</option>

                                                                </select>
                                                            <div class="invalid-feedback">
                                                                Relationship to Patient is required "
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Address: <span class="text-danger">*</span></label>
                                                            <textarea name="memberAddress" class="form-control" required></textarea>

                                                            <div class="invalid-feedback">
                                                                Address is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc6">Contact number: <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="memberContact" name="memberContact" required pattern="\d+" title="Please enter only numbers." />
                                                        <div class="invalid-feedback">
                                                            Contact number is required and must contain only numbers.
                                                        </div>
                                                    </div>
                                                </div>
                                              




                                                </div>
                                                <hr style="width: 100%;" />
                                                <div class="row">
                                                    <u><i>
                                                            <h3>Other Information</h3>
                                                        </i></u>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Philhealth Member <span class="text-danger">*</span></label>
                                                            <select class="form-control " id="Philhealth" name="Philhealth" required>
                                                                <?php
                                                                echo getphilhealth();
                                                                ?>

                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Philhealth Member is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Membership: </label>
                                                            <select class="form-control " id="Phil_member" name="Phil_member">
                                                                <?php
                                                                echo getphilhealthmembership();
                                                                ?>

                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Philhealth No.</label>
                                                            <input type="text" class="form-control  " id="Phil_no" name="Phil_no" />

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc6">Membership Category</label>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <?php
                                                                    echo getMemCat();
                                                                    ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-info   float-end" id="save_Patient" name="save_Patient">Submit</button>
                                                    </div>
                                                </div>



                                        </form>






                                    </div>
                                    <!-- Row end -->
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
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

    <script src="./assets/ph-address-selector.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select both input fields
        const inputs = document.querySelectorAll('#memberContact, #phone_number');

        // Add event listeners to both inputs
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value;
                if (/^\d+$/.test(value)) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('patient_form');

    form.addEventListener('submit', function(event) {
        // Prevent default submission if the form is invalid
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        const genderRadios = document.querySelectorAll('input[name="gender"]');
        const invalidFeedback = document.querySelector('.invalid-feedback');

        // Check if any radio button is checked
        const isChecked = Array.from(genderRadios).some(radio => radio.checked);

        if (!isChecked) {
            invalidFeedback.style.display = 'block'; // Show error message
            event.preventDefault(); // Prevent form submission
        } else {
            invalidFeedback.style.display = 'none'; // Hide error message if checked
        }

        form.classList.add('was-validated');
    }, false);

    var region = document.getElementById('region');
    var province = document.getElementById('province');
    var city = document.getElementById('city');
    var barangay = document.getElementById('barangay');

    function validateDropdown(dropdown, hiddenInput, errorMessage) {
        if (dropdown.value === '' || dropdown.value === 'Choose...') {
            hiddenInput.setCustomValidity(errorMessage);
            dropdown.classList.add('is-invalid');
        } else {
            hiddenInput.setCustomValidity("");
            dropdown.classList.remove('is-invalid');
        }
    }

    // Add validation on form submission
    form.addEventListener('submit', function(event) {
        var isValid = true; // Assume the form is valid

        validateDropdown(region, document.getElementById('region-text'), 'Region is required.');
        validateDropdown(province, document.getElementById('province-text'), 'Province is required.');
        validateDropdown(city, document.getElementById('city-text'), 'City / Municipality is required.');
        validateDropdown(barangay, document.getElementById('barangay-text'), 'Barangay is required.');

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

    <!--<script>-->
    <!--    $(document).ready(function() {-->
            <!--// $('#phone_number').inputmask('+639999999999');-->
            <!--// $('#Phil_no').inputmask('99-999999999-9');-->

    <!--        $('#date_of_birth').datetimepicker({-->
    <!--            format: 'L',-->
    <!--            maxDate: new Date()-->
    <!--        });-->


    <!--        function calculateAge(birthdate) {-->
    <!--            var dob = moment(birthdate, 'L');-->
    <!--            if (!dob.isValid()) {-->
    <!--                console.error("Invalid date format:", birthdate);-->
    <!--                return;-->
    <!--            }-->

    <!--            var today = moment();-->
                var age = today.diff(dob, 'years'); // Calculate age using moment.js
    <!--            var months = today.diff(dob, 'months') % 12;-->

    <!--            if (age === 0 && months === 1) {-->
    <!--                return months + " month";-->
    <!--            } else if (age === 1 && months === 0) {-->
    <!--                return age + " year";-->
    <!--            } else if (age === 1 && months > 0) {-->
    <!--                return age + " year and " + months + " months";-->
    <!--            } else if (age === 0) {-->
    <!--                return months + " months";-->
    <!--            } else {-->
    <!--                return age + " years";-->
    <!--            }-->
    <!--        }-->

    <!--        $('#date_of_birth').on('change.datetimepicker', function(e) {-->
    <!--            var dob = $(this).find('input').val();-->
    <!--            var age = calculateAge(dob);-->
    <!--            $('#Age').val(age);-->
    <!--        });-->

    <!--    });-->
    <!--</script>-->

<script>
    $(document).ready(function () {
        $('#phone_number').inputmask('+639999999999');
            $('#date_of_birth').datetimepicker({
                format: 'L',
                maxDate: new Date()
            });
        function calculateAge(birthdate) {
            // Parse the birthdate using moment.js
            var dob = moment(birthdate, 'L');
            if (!dob.isValid()) {
                console.error("Invalid date format:", birthdate);
                return "Invalid date";
            }

            var today = moment();
            var years = today.diff(dob, 'years'); // Calculate age in years
            var months = today.diff(dob, 'months') % 12; // Remaining months

            // Check if the age is less than 1 month
            if (today.diff(dob, 'days') < 30) {
                return "Newborn";
            }

            // Return formatted age string based on conditions
            if (years === 0 && months === 1) {
                return "1 month"; // Singular form for 1 month
            } else if (years === 0 && months > 1) {
                return months + " months" + " old"; // Plural form for months
            } else if (years === 1 && months === 0) {
                return "1 year"; // Singular form for 1 year
            
            } else {
                return years + " year" + (years > 1 ? "s" : ""); // Only years
            }
        }

        // Trigger calculation on date change
        $('#date_of_birth').on('change.datetimepicker', function (e) {
            var dob = $(this).find('input').val(); // Get the selected date
            var age = calculateAge(dob); // Calculate age
            $('#Age').val(age); // Set the calculated age in the target field
        });
    });
</script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var philhealthSelect = document.getElementById("Philhealth");
            var membershipSelect = document.getElementById("Phil_member");
            var philNoInput = document.getElementById("Phil_no");

            // Apply input mask
            // $('#phone_number').inputmask('+639999999999', {
            //     autoUnmask: true
            // });
            // $('#memberContact').inputmask('+639999999999', {
            //     autoUnmask: true
            // });
            $('#Phil_no').inputmask('99-999999999-9', {
                autoUnmask: true
            });


            philhealthSelect.addEventListener("change", function() {
                if (philhealthSelect.value === "No") {
                    membershipSelect.disabled = true;
                    philNoInput.disabled = true;


                    $('#Phil_no').inputmask('remove');
                    membershipSelect.value = "";
                    philNoInput.value = "";
                } else {
                    membershipSelect.disabled = false;
                    philNoInput.disabled = false;

                    // Reapply input mask and clear the value
                    $('#Phil_no').inputmask('99-999999999-9', {
                        autoUnmask: true
                    });
                    membershipSelect.value = "";
                    philNoInput.value = "";
                }
            });

            // Trigger change event on page load to apply initial state
            philhealthSelect.dispatchEvent(new Event("change"));
        });
    </script>
    <script>
       $(document).ready(function () {
         $("#patient_name, #middle_name, #last_name").blur(function () {
        var patientName = $("#patient_name").val().trim();
        var middleName = $("#middle_name").val().trim();
        var lastName = $("#last_name").val().trim();

        if (patientName !== '' && middleName !== '' && lastName !== '') {
            $.ajax({
                url: "ajax/check_patient.php",
                type: 'GET',
                data: {
                    'patient_name': patientName,
                    'middle_name': middleName,
                    'last_name': lastName,
                },
                cache: false,
                async: true,
                success: function (count) {
                    if (parseInt(count) > 0) {
                        showCustomMessage("This patient already exists. Please check the name, middle name, and last name.");
                        $("#save_Patient").attr("disabled", "disabled");
                    } else {
                        $("#save_Patient").removeAttr("disabled");
                    }
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    showCustomMessage(errorMessage);
                }
            });
        }
    });
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="MemCat"]');

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach((otherCheckbox) => {
                            if (otherCheckbox !== this) {
                                otherCheckbox.checked = false;
                            }
                        });
                    }
                });
            });
        });
    </script>



</body>



</html>