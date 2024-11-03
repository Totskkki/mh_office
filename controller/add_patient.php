<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);



$message = '';
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

    $address = trim($_POST['address']);
    $address = ucwords(strtolower($address));
    $cnic = trim($_POST['cnic']);
    $m_name = trim($_POST['m_name']);
    $f_gname = trim($_POST['f_gname']);

    $dateBirth = trim($_POST['date_of_birth']);
    $dateArr = explode("/", $dateBirth);
    $dateBirth = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

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

    $Age = trim($_POST['Age']);
    $m_name = trim($_POST['m_name']);
    $f_gname = trim($_POST['f_gname']);

    if (
        $patientName != '' && $address != '' &&
        $cnic != '' && $dateBirth != '' && $phoneNumber != '' && $gender != '' &&
        $Purok !== '' && $status !== '' && $Nationality !== '' &&
        $Blood !== '' && $Age !== ''  
        

    ) {
      
        //     $stmtCheck = $con->prepare("
        //     SELECT COUNT(*) AS num 
        //     FROM tbl_patients WHERE patient_name = :patientName AND last_name = :lastname and household_no = :householdno
        // ");
        //     $stmtCheck->execute(['patientName' => $patientName, 'last_name' => $last_name,  'household_no' => $household_no]);
        //     $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
        //     if ($result['num'] > 0) {
        //         $_SESSION['status'] = "Username or Email already used by another user.";
        //         $_SESSION['status_code'] = "error";
        //         header('location: ../add_patient.php');
        //         exit();
        //     }
    

            $duplicateQuery = "SELECT COUNT(*) AS count FROM tbl_patients WHERE patient_name = :patientName AND last_name = :lastname and household_no = :householdno";
            $stmtDuplicate = $con->prepare($duplicateQuery);
            $stmtDuplicate->execute([
                ':patientName' => $patientName,
                ':lastname' => $last_name,
                ':householdno' => $household_no
            ]);
            $duplicateResult = $stmtDuplicate->fetch(PDO::FETCH_ASSOC);
        
            if ($duplicateResult['count'] > 0) {
                $message = 'Duplicate patient name found. Please choose a different name.';
                echo "<script>alert('Duplicate patient name found. Please choose a different name.');</script>";
                exit();
            }

            

            $con->beginTransaction();
            try {

            $insertFamilyQuery = "INSERT INTO tbl_family (brgy, purok, province) VALUES (:address, :Purok, :province)";
            $stmtFamily = $con->prepare($insertFamilyQuery);
            $stmtFamily->execute([
                ':address' => $address,
                ':Purok' => $Purok,
                ':province' => $Province
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

            $insertPatientQuery = "INSERT INTO tbl_patients (patient_name, household_no, middle_name, last_name, suffix, father_guardian_name, mother_name, cnic, date_of_birth, age, phone_number, gender, civil_status, blood_type, ed_at, emp_stat, Nationality, family_address, membership_info, userID)
                VALUES (:patientName, :household_no, :middle_name, :last_name, :suffix, :m_name, :f_gname, :cnic, :dateBirth, :Age, :phoneNumber, :gender, :civil_status, :Blood, :ed_att, :emp_stat, :Nationality, :familyId, :membershipId, :userID)";
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