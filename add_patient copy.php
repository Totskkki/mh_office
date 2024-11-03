<?php
include 'config/connection.php';

include 'common_service/common_functions.php';



$message = '';

$patientName = $middle_name = $last_name  = $suffix =  '';
$address  = $m_name = $f_gname = $dateBirth = $phoneNumber = '';
$gender = $Purok = $Province = $Nationality = $ed_att = $emp_stat = '';
$Blood = $Age = $date_of_birth = $phoneNumber = $civil_status = '';
$Sex = $m_name = $f_gname = '';



$errors = [
    'patient_name' => '',
    'last_name' => '',
    'address' => '',
    'date_of_birth' => '',
    'phone_number' => '',
    'gender' => '',
    'Purok' => '',
    'Province' => '',
    'Purok' => '',
    'civil_status' => '',
    'Nationality' => '',
    'Blood' => '',
    'Age' => '',
    'Sex' => '',
    'mother' => '',
    'father' => '',
    'philhealth' => '',
    'placeBirth'=> '',
];
if (isset($_POST['save_Patient'])) {
    // var_dump($_POST);

    $user = $_SESSION['user_id'];
    $patientName = trim($_POST['patient_name']);
    $patientName = ucwords(strtolower($patientName));
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $suffix = trim($_POST['suffix']);
    // $family_no = trim($_POST['family_no']);
    $household_no = trim($_POST['household_no']);


 
    $placeBirth = trim($_POST['placeBirth']);
    $placeBirth = ucwords(strtolower($placeBirth));

    
    $religion = trim($_POST['religion']);

    $address = trim($_POST['address']);
    $address = ucwords(strtolower($address));
    $cnic = trim($_POST['cnic']);
    $m_name = trim($_POST['m_name']);
    $f_gname = trim($_POST['f_gname']);

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


    $Age = trim($_POST['Age']);

    $phoneNumber = trim($_POST['phone_number']);

    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';


    $Purok = trim($_POST['Purok']);
    $Purok = ucwords(strtolower($Purok));

    $Province = trim($_POST['Province']);
    $Province = ucwords(strtolower($Province));

    $Nationality = trim($_POST['Nationality']);
    $ed_att = trim($_POST['ed_att']);
    $emp_stat = trim($_POST['emp_stat']);
    $status = trim($_POST['Status']);
    // $Weight = trim($_POST['Weight']);
    $Blood  = trim($_POST['Blood']);

    $philhealth  = trim($_POST['Philhealth']);
    // $Phil_member  = trim($_POST['Phil_member']);
    // $Phil_no  = trim($_POST['Phil_no']);
    $Phil_member = isset($_POST['Phil_member']) ? trim($_POST['Phil_member']) : '';
    $Phil_no = isset($_POST['Phil_no']) ? trim($_POST['Phil_no']) : '';
    // $MemCat = isset($_POST['MemCat']) ? $_POST['MemCat'] : '';
    $MemCat = isset($_POST['MemCat']) ? json_encode($_POST['MemCat']) : '[]';


    $m_name = trim($_POST['m_name']);
    $f_gname = trim($_POST['f_gname']);

    if ($patientName == '') {
        $errors['patient_name'] = 'First name is required';
    }
    if ($last_name == '') {
        $errors['last_name'] = 'Last name is required';
    }

    if ($address == '') {
        $errors['address'] = 'Address is required';
    }

    if ($Province == '') {
        $errors['Province'] = 'Province is required';
    }
    if ($Purok == '') {
        $errors['Purok'] = 'Purok is required';
    }

    if ($dateBirth == '') {
        $errors['date_of_birth'] = 'Date of birth is required';
    }
    if ($phoneNumber == '') {
        $errors['phone_number'] = 'Phone number is required';
    }
    if ($gender == '') {
        $errors['gender'] = 'Gender is required';
    }
    if ($Purok == '') {
        $errors['Purok'] = 'Purok is required';
    }
    if ($status == '') {
        $errors['status'] = 'Civil Status is required';
    }
    if ($Nationality == '') {
        $errors['Nationality'] = 'Nationality is required';
    }
    if ($Blood == '') {
        $errors['Blood'] = 'Blood type is required';
    }
    if ($Age == '') {
        $errors['Age'] = 'Age is required';
    }

    if ($m_name == '') {
        $errors['mother'] = 'Mothers name is required';
    }

    if ($f_gname == '') {
        $errors['father'] = 'Father/Guardian is required';
    }

    if ($philhealth == '') {
        $errors['philhealth'] = 'Philhealth is required';
    }


    $hasErrors = false;
    foreach ($errors as $error) {
        if ($error != '') {
            $hasErrors = true;
            break;
        }
    }

    if (!$hasErrors) {
        // Proceed with saving the patient details
        // Your existing code to save patient details goes here
        $con->beginTransaction();
        try {

            $insertFamilyQuery = "INSERT INTO tbl_familyAddress (brgy, purok, province,place_of_birth) VALUES (:address, :Purok, :province,:placeBirth)";
            $stmtFamily = $con->prepare($insertFamilyQuery);
            $stmtFamily->execute([
                ':address' => $address,
                ':Purok' => $Purok,
                ':province' => $Province,
                ':placeBirth' => $placeBirth
            ]);
            $familyId = $con->lastInsertId();


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

            $insertPatientQuery = "INSERT INTO tbl_patients (patient_name, household_no, middle_name, last_name, suffix, father_guardian_name, mother_name, cnic, date_of_birth, age, phone_number, gender, civil_status, blood_type, ed_at, emp_stat,religion Nationality, family_address, membership_info, userID)
                VALUES (:patientName, :household_no, :middle_name, :last_name, :suffix, :m_name, :f_gname, :cnic, :dateBirth, :Age, :phoneNumber, :gender, :civil_status, :Blood, :ed_att, :emp_stat,:religion, :Nationality, :familyId, :membershipId, :userID)";
            $stmtPatient = $con->prepare($insertPatientQuery);
            $stmtPatient->execute([
                ':patientName' => $patientName,
                ':household_no' => $household_no,
                ':middle_name' => $middle_name,
                ':last_name' => $last_name,
                ':suffix' => $suffix,
                ':m_name' => $m_name,
                ':f_gname' => $f_gname,
                ':cnic' => $cnic,
                ':dateBirth' => $dateBirth,
                ':Age' => $Age,
                ':phoneNumber' => $phoneNumber,
                ':gender' => $gender,
                ':civil_status' => $status,
                ':Blood' => $Blood,
                ':ed_att' => $ed_att,
                ':emp_stat' => $emp_stat,
                ':religion' => $religion,
                ':Nationality' => $Nationality,
                ':familyId' => $familyId,
                ':membershipId' => $membershipId,
                ':userID' => $user
            ]);


            $lastInsertId = $con->lastInsertId();


            $con->commit();

            echo "<script>alert('Patient added successfully. You will be redirected to another page.');</script>";
            $message = 'Patient added successfully.';
            echo "<script>window.location.href = 'individual_treatment.php?complaintID=$lastInsertId&famID=$familyId&membershipID=$membershipId&message=$message';</script>";
            exit;
        } catch (PDOException $ex) {

            $con->rollback();
            echo $ex->getMessage();
            echo $ex->getTraceAsString();
            exit;
        }
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
                                        <a href="dashboard.php">Home</a>

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
                                    </div>



                                    <div class="card-body">
                                        <form method="post" id="patient_form" >
                                            <!-- novalidate -->

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
                                                        <input type="text" class="form-control " id="cnic" value="<?php echo $cnic ?>" name="cnic" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc1">Family no:</label>
                                                        <input type="number" class="form-control " value="<?php echo $newFamilyNumber; ?>" min="0" id="household_no" name="household_no" readonly />
                                                        <span class="badge bg-info"><?php echo 'Current Family No.' ?></span>


                                                    </div>

                                                </div>
                                                <hr style="width: 57%;" />

                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc">First Name: <span class="text-danger">*</span></label>

                                                            <input type="text" class="form-control " value="<?php echo htmlspecialchars($patientName); ?>" id="patient_name" name="patient_name" "/>
                                                            <?php if ($errors['patient_name']) { ?>
                                                                <div class="text-danger"><?php echo $errors['patient_name']; ?></div>
                                                            <?php } ?>
                                                            <div class="invalid-feedback">First Name must not contain numbers.</div>
                                                            <!-- required pattern="[a-zA-Z\s]+ -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc1">Middle Name</label>
                                                            <input type="text" class="form-control " id="middle_name" name="middle_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc2">Last Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " value="<?php echo htmlspecialchars($last_name); ?>" id="last_name" name="last_name" />
                                                            <?php if ($errors['last_name']) { ?>
                                                                <div class="text-danger"><?php echo $errors['last_name']; ?></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Suffix</label>
                                                            <input type="text" class="form-control " id="suffix" name="suffix" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Purok: <span class="text-danger">*</span></label>

                                                            <textarea class="form-control " id="Purok" name="Purok" cols="30" rows="1"><?php echo htmlspecialchars($Purok); ?></textarea>
                                                            <?php if ($errors['Purok']) { ?>
                                                                <div class="text-danger"><?php echo $errors['Purok']; ?></div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label " for="abc6">Barangay: <span class="text-danger">*</span></label>

                                                            <select class="form-control " value="<?php echo htmlspecialchars($address); ?>" id="address" name="address">
                                                                <?php echo getbrgy(); ?>
                                                            </select>
                                                            <?php if ($errors['address']) { ?>
                                                                <div class="text-danger"><?php echo $errors['address']; ?></div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc5">Province: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " value="<?php echo htmlspecialchars($Province); ?>" id="Province" name="Province" />

                                                            <?php if ($errors['Province']) { ?>
                                                                <div class="text-danger"><?php echo $errors['Province']; ?></div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="abc3">Place of Birth:<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control " id="placeBirth" name="placeBirth" />
                                                        </div>
                                                    </div>

                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc7">Date of Birth: <span class="text-danger">*</span></label>

                                                        <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                                            <input type="text" class="form-control  datetimepicker-input" value="<?php echo htmlspecialchars($date_of_birth); ?>" data-target="#date_of_birth" name="date_of_birth" data-toggle="datetimepicker" autocomplete="off" />
                                                            <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                                <div class="input-group-text" style="height: 100%;"><i class="fa fa-calendar" style="height: 100%;"></i></div>
                                                            </div>

                                                        </div>
                                                        <?php if ($errors['date_of_birth']) { ?>
                                                            <div class="text-danger"><?php echo $errors['date_of_birth']; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc6">Age</label>
                                                        <input type="text" min="0" max="999" class="form-control " value="<?php echo htmlspecialchars($Age); ?>" id="Age" name="Age" readonly />
                                                        <?php if ($errors['Age']) { ?>
                                                            <div class="text-danger"><?php echo $errors['Age']; ?></div>
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="abc6">Sex: <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <div class="form-check">

                                                                <?php echo getGender(); ?>

                                                            </div>

                                                        </div>
                                                        <?php if ($errors['Sex']) { ?>
                                                            <div class="text-danger"><?php echo $errors['Sex']; ?></div>
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="abc6">Contact number: <span class="text-danger">*</span></label>
                                                        <input type="text" inputmode="text" class="form-control " id="phone_number" value="<?php echo htmlspecialchars($phoneNumber); ?>" name="phone_number" value="+639" />
                                                        <?php if ($errors['phone_number']) { ?>
                                                            <div class="text-danger"><?php echo $errors['phone_number']; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="abc6">Civis Status: <span class="text-danger">*</span></label>
                                                        <select class="form-control " value="<?php echo htmlspecialchars($civil_status); ?>" id="Status" name="Status">
                                                            <?php
                                                            echo  getstat();
                                                            ?>
                                                        </select>

                                                    </div>
                                                    <?php if ($errors['civil_status']) { ?>
                                                        <div class="text-danger"><?php echo $errors['civil_status']; ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="abc6">Blood Type: <span class="text-danger">*</span></label>
                                                        <select class="form-control " id="Blood" name="Blood">
                                                            <?php
                                                            echo  getblood();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc6">Mothers Name : <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control " value="<?php echo htmlspecialchars($m_name); ?>" id="m_name" name="m_name" />
                                                        <?php if ($errors['mother']) { ?>
                                                            <div class="text-danger"><?php echo $errors['mother']; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc6">Fathers Name/Guardian: <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control " value="<?php echo htmlspecialchars($f_gname); ?>" id="f_gname" name="f_gname" />
                                                        <?php if ($errors['father']) { ?>
                                                            <div class="text-danger"><?php echo $errors['father']; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="abc6">Nationality Type: <span class="text-danger">*</span></label>
                                                        <select class="form-control " value="<?php echo htmlspecialchars($Nationality); ?>" id="Nationality" name="Nationality">
                                                            <?php
                                                            echo  getnationality();
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <?php if ($errors['Nationality']) { ?>
                                                        <div class="text-danger"><?php echo $errors['Nationality']; ?></div>
                                                    <?php } ?>
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
                                                        <label class="form-label" for="abc6">Occupation</label>
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
                                                            <option value="Seventh-day Adventist Church">Seventh-day Adventist Church  </option>
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




                                            </div>
                                            <hr style="width: 75%;" />
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
                                                        <select class="form-control " id="Philhealth" value="<?php echo htmlspecialchars($philhealth); ?>" name="Philhealth">
                                                            <?php
                                                            echo getphilhealth();
                                                            ?>

                                                        </select>
                                                        <?php if ($errors['philhealth']) { ?>
                                                            <div class="text-danger"><?php echo $errors['philhealth']; ?></div>
                                                        <?php } ?>
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
                                                    <button type="submit" class="btn btn-success btn-sm  float-end" id="save_Patient" name="save_Patient">Submit</button>
                                                </div>
                                            </div>



                                        </form>




                                    </div>
                                    <!-- Row end -->
                                    <!-- <div class="card-body">
                                        <form id="patient_form" method="post" novalidate>
                                            <?php
                                            // Fetch the last family number from the database
                                            $lastFamilyNumberQuery = "SELECT household_no FROM tbl_patients ORDER BY patientID DESC LIMIT 1";
                                            $lastFamilyNumberStatement = $con->prepare($lastFamilyNumberQuery);

                                            if ($lastFamilyNumberStatement->execute()) {
                                                $lastFamilyNumberResult = $lastFamilyNumberStatement->fetch(PDO::FETCH_ASSOC);
                                                $lastFamilyNumber = $lastFamilyNumberResult['household_no'] ?? '';
                                            } else {
                                                $errorInfo = $lastFamilyNumberStatement->errorInfo();
                                                echo "Error executing query: " . $errorInfo[2];
                                                exit;
                                            }

                                            // Function to generate a new family number
                                            // function generateFamilyNumber($lastFamilyNumber)
                                            // {
                                            //     $characters = '0123456789';
                                            //     $length = 7;

                                            //     if ($lastFamilyNumber !== '') {
                                            //         $lastNumber = intval(preg_replace('/[^0-9]/', '', $lastFamilyNumber));
                                            //         $lastNumber++;
                                            //         $newNumber = str_pad($lastNumber, $length, '0', STR_PAD_LEFT);
                                            //     } else {
                                            //         $newNumber = '';
                                            //         for ($i = 0; $i < $length; $i++) {
                                            //             $newNumber .= $characters[rand(0, strlen($characters) - 1)];
                                            //         }
                                            //     }

                                            //     return $newNumber;
                                            // }

                                            $newFamilyNumber = generateFamilyNumber($lastFamilyNumber);
                                            ?>

                                            <div class="row">
                                                <?php
                                                // Fetch the last patient ID from the database
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
                                                        <label class="form-label" for="cnic">ITR No:</label>
                                                        <input type="text" class="form-control form-control-sm rounded-0" id="cnic" value="<?php echo $cnic ?>" name="cnic" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="household_no">Family no:</label>
                                                        <input type="number" class="form-control form-control-sm rounded-0" value="<?php echo $newFamilyNumber; ?>" min="0" id="household_no" name="household_no" readonly />
                                                        <span class="badge bg-info">Current Family No.</span>
                                                    </div>
                                                </div>
                                                <hr style="width: 57%;" />

                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="patient_name">First Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($patientName); ?>" id="patient_name" name="patient_name" required />
                                                            <div class="invalid-feedback">Please enter the first name.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="middle_name">Middle Name</label>
                                                            <input type="text" class="form-control form-control-sm rounded-0" id="middle_name" name="middle_name" pattern="[a-zA-Z]+" />
                                                            <div class="invalid-feedback">Please enter only letters.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="last_name">Last Name: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($last_name); ?>" id="last_name" name="last_name" required />
                                                            <div class="invalid-feedback">Please enter the last name.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="suffix">Suffix</label>
                                                            <input type="text" class="form-control form-control-sm rounded-0" id="suffix" name="suffix" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="Purok">Purok: <span class="text-danger">*</span></label>
                                                            <textarea class="form-control form-control-sm rounded-0" id="Purok" name="Purok" cols="30" rows="1" required><?php echo htmlspecialchars($Purok); ?></textarea>
                                                            <div class="invalid-feedback">Please enter the Purok.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="address">Barangay: <span class="text-danger">*</span></label>
                                                            <select class="form-control form-control-sm rounded-0" id="address" name="address" required>
                                                                <?php echo getbrgy(); ?>
                                                            </select>
                                                            <div class="invalid-feedback">Please select the Barangay.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-4 col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="Province">Province: <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($Province); ?>" id="Province" name="Province" required />
                                                            <div class="invalid-feedback">Please enter the Province.</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="date_of_birth">Date of Birth: <span class="text-danger">*</span></label>
                                                        <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" value="<?php echo htmlspecialchars($date_of_birth); ?>" data-target="#date_of_birth" name="date_of_birth" data-toggle="datetimepicker" autocomplete="off" required />
                                                            <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter the Date of Birth.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="Age">Age</label>
                                                        <input type="text" min="0" max="999" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($Age); ?>" id="Age" name="Age" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="Sex">Sex: <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <?php echo getGender(); ?>
                                                            </div>
                                                        </div>
                                                        <div class="invalid-feedback">Please select the Gender.</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="phone_number">Contact number: <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm rounded-0" id="phone_number" value="<?php echo htmlspecialchars($phoneNumber); ?>" name="phone_number" required />
                                                        <div class="invalid-feedback">Please enter a valid Contact Number.</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="Status">Civis Status: <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm rounded-0" id="Status" name="Status" required>
                                                            <?php echo getStatus(); ?>
                                                        </select>
                                                        <div class="invalid-feedback">Please select the Civil Status.</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="insurance">Insurance</label>
                                                        <input type="text" class="form-control form-control-sm rounded-0" value="<?php echo htmlspecialchars($insurance); ?>" id="insurance" name="insurance" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div> -->



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


    </script>



    <script src="assets/moment/moment.min.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>


<script>
    // Validation and datetimepicker initialization
$(document).ready(function () {
   
    $('#patient_form').on('submit', function (event) {
        // Add Bootstrap validation styles to the form
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });
});

</script>


    <!-- <script>
        $(document).ready(function() {
            function calculateAge(birthdate) {
                console.log("Birthdate:", birthdate);
          
                var parts = birthdate.split('/');
                var dob = new Date(parts[2], parts[1] - 1, parts[0]); 
                if (isNaN(dob)) {
                    console.error("Invalid date format:", birthdate);
                    return; 
                }
                console.log("Parsed Date:", dob);
                var today = new Date();
                var age = today.getFullYear() - dob.getFullYear();
                var monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                console.log("Calculated Age:", age);
                return age;
            }

            $('#date_of_birth').on('change.datetimepicker', function(e) {
                var dob = $(this).find('input').val();
                $('#Age').val(calculateAge(dob));
            });
        });
    </script> -->

    <!-- <script>
        $(document).ready(function() {
            function calculateAge(birthdate) {
                console.log("Birthdate:", birthdate);

                var parts = birthdate.split('/');
                var dob = new Date(parts[2], parts[1] - 1, parts[0]);
                if (isNaN(dob)) {
                    console.error("Invalid date format:", birthdate);
                    return;
                }
                console.log("Parsed Date:", dob);
                var today = new Date();
                var age = today.getFullYear() - dob.getFullYear();
                var monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                console.log("Calculated Age:", age);
                return age;
            }

            $('#date_of_birth').on('change.datetimepicker', function(e) {
                var dob = $(this).find('input').val();
                $('#Age').val(calculateAge(dob));
            });
        });
    </script> -->
    <!-- <script>
    $(document).ready(function() {
       
        $('#date_of_birth').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        function calculateAge(birthdate) {
            console.log("Birthdate:", birthdate);
            var parts = birthdate.split('/');
            if (parts.length !== 3) {
                console.error("Invalid date format:", birthdate);
                return;
            }
            var dob = new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
            if (isNaN(dob.getTime())) {
                console.error("Invalid date format:", birthdate);
                return;
            }
            console.log("Parsed Date:", dob);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            console.log("Calculated Age:", age);
            return age;
        }

        $('#date_of_birth').on('change.datetimepicker', function(e) {
            // Get the date value from the input
            var dob = $(this).find('input').val();
            console.log("DOB from picker:", dob);
            $('#Age').val(calculateAge(dob));
        });
    });
</script> -->


    <script>
        $(document).ready(function() {
            $('#phone_number').inputmask('+639999999999');
            $('#date_of_birth').datetimepicker({
                format: 'L',
                maxDate: new Date()
            });


            function calculateAge(birthdate) {
                var dob = moment(birthdate, 'L'); // Parse date with moment.js using the 'L' format
                if (!dob.isValid()) {
                    console.error("Invalid date format:", birthdate);
                    return;
                }

                var today = moment();
                var age = today.diff(dob, 'years'); // Calculate age using moment.js
                var months = today.diff(dob, 'months') % 12;

                if (age === 0 && months === 1) {
                    return months + " month";
                } else if (age === 1 && months === 0) {
                    return age + " year";
                } else if (age === 1 && months > 0) {
                    return age + " year and " + months + " months";
                } else if (age === 0) {
                    return months + " months";
                } else {
                    return age + " years";
                }
            }

            $('#date_of_birth').on('change.datetimepicker', function(e) {
                var dob = $(this).find('input').val();
                var age = calculateAge(dob);
                $('#Age').val(age);
            });

        });
        // var dob = new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
        // if (isNaN(dob.getTime())) {
        //     console.error("Invalid date format:", birthdate);
        //     return;
        // }
        // var today = new Date();
        // var age = today.getFullYear() - dob.getFullYear();
        // var monthDiff = today.getMonth() - dob.getMonth();
        // if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        //     age--;
        // }
    </script>


    <!-- <script>
      $(document).ready(function() {
        // Function to calculate age based on date of birth
        function calculateAge(birthdate) {
          var today = new Date();
          var dob = new Date(birthdate);
          var age = today.getFullYear() - dob.getFullYear();
          var monthDiff = today.getMonth() - dob.getMonth();
          if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
          }
          return age;
        }

        // Listen for changes in the date of birth input field
        $('#date_of_birth').on('change.datetimepicker', function(e) {
          var dob = $(this).find('input').val();
          $('#Age').val(calculateAge(dob));
        });
      });
    </script> -->
    <!-- <script>
        $(document).ready(function() {
            $('#date_of_birth').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#phone_number').inputmask('+639999999999');
        });
    </script> -->
    <!-- ==================start Membership trigger============================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to the elements
            var philhealthSelect = document.getElementById("Philhealth");
            var membershipSelect = document.getElementById("Phil_member");
            var philNoInput = document.getElementById("Phil_no");


            philhealthSelect.addEventListener("change", function() {

                if (philhealthSelect.value === "No") {
                    membershipSelect.disabled = true;
                    philNoInput.disabled = true;
                    membershipSelect.value = "";
                    philNoInput.value = "";
                } else {
                    membershipSelect.disabled = false;
                    philNoInput.disabled = false;
                }
            });


            philhealthSelect.dispatchEvent(new Event("change"));
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#patient_name").blur(function() {

                var message = '<?php echo $message; ?>';

                if (message !== '') {
                    showCustomMessage(message);
                }


                var patientName = $(this).val().trim();
                // var householdNo = $("#household_no").val().trim();
                $(this).val(patientName);

                if (patient_name !== '') {
                    $.ajax({
                        url: "ajax/check_patient.php",
                        type: 'GET',
                        data: {
                            'patient_name': patientName

                        },
                        cache: false,
                        async: true,
                        success: function(count, status, xhr) {
                            if (parseInt(count) > 0) {
                                showCustomMessage("This patient name has already been saved. Please choose another name");
                                $("#save_Patient").attr("disabled", "disabled");
                            } else {
                                $("#save_Patient").removeAttr("disabled");
                            }
                        },
                        error: function(jqXhr, textStatus, errorMessage) {
                            showCustomMessage(errorMessage);
                        }
                    });
                }

            });
        });
    </script>

    <!-- 
    <script>
        $(document).ready(function() {

            $("#patient_name").blur(function() {
                var patientName = $(this).val().trim();
                $(this).val(patientName);

                if (patientName !== '') {
                    $.ajax({
                        url: "ajax/check_patientname.php",
                        type: 'GET',
                        data: {
                            'patient_name': patientName
                        },
                        cache: false,
                        async: false,
                        success: function(count, status, xhr) {
                            if (count > 0) {
                                showCustomMessage("This name has already been stored. Please choose another name");
                                $("#save_Patient").attr("disabled", "disabled");
                            } else {
                                $("#save_Patient").removeAttr("disabled");
                            }
                        },
                        error: function(jqXhr, textStatus, errorMessage) {
                            showCustomMessage(errorMessage);
                        }
                    });
                }

            });
        });
    </script> -->
    <!-- <script>
        $(document).ready(function() {
            // Listen for form submission
            $('#patientform').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Serialize form data
                var formData = $(this).serialize();

                // Send form data via AJAX
                $.ajax({
                    type: 'POST',
                    url: 'patient_form.php', // Replace 'your_php_script.php' with your PHP script URL
                    data: formData,
                    success: function(response) {
                        // Handle successful response
                        // Display error messages returned by the server
                        $('#error_messages').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> -->

    <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('patient_form');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        // Custom validation for unique email
       
    });
</script> -->

</body>



</html>