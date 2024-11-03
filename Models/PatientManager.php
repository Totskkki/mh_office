<?php

class PatientManager
{
    private $con;
    private $user;

    public function __construct($dbConnection, $user)
    {
        $this->con = $dbConnection;
        $this->user = $user;
    }

    public function savePatient($postData)
    {
        $this->con->beginTransaction();

        try {
            // Extract and sanitize data
            $data = $this->sanitizeData($postData);

            // Insert into family address
            $familyId = $this->insertFamilyAddress($data);

            // Insert into membership info
            $membershipId = $this->insertMembershipInfo($data);

            // Insert into patient
            $patientId = $this->insertPatient($data, $familyId, $membershipId);

            // Insert family members
            $this->insertFamilyMembers($data, $patientId);

            // Log audit trail
            $this->user->logAuditTrail($data['userID'], 'INSERT', 'Added a new patient', 'tbl_patients', $patientId);

            $this->con->commit();

            echo "<script>alert('Patient added successfully. You will be redirected to another page.');</script>";
            echo "<script>window.location.href = 'individual_treatment.php?complaintID=$patientId&famID=$familyId&membershipID=$membershipId&message=Patient added successfully.';</script>";
            exit;
        } catch (PDOException $ex) {
            $this->con->rollback();
            echo $ex->getMessage();
            echo $ex->getTraceAsString();
            exit;
        }
    }

    private function sanitizeData($postData)
    {
        return [
            'patientName' => ucwords(strtolower(trim($postData['patient_name']))),
            'middle_name' => trim($postData['middle_name']),
            'last_name' => trim($postData['last_name']),
            'suffix' => trim($postData['suffix']),
            'household_no' => trim($postData['household_no']),
            'cnic' => trim($postData['cnic']),
            'm_name' => trim($postData['m_name']),
            'f_gname' => trim($postData['f_gname']),
            'date_of_birth' => $this->formatDate(trim($postData['date_of_birth'])),
            'religion' => trim($postData['religion']),
            'placeofBirth' => trim($postData['placeofBirth']),
            'Age' => trim($postData['Age']),
            'phone_number' => trim($postData['phone_number']),
            'gender' => isset($postData['gender']) ? $postData['gender'] : '',
            'Purok' => ucwords(strtolower(trim($postData['Purok']))),
            'address' => ucwords(strtolower(trim($postData['address']))),
            'city_municipality' => trim($postData['city_municipality']),
            'Province' => ucwords(strtolower(trim($postData['Province']))),
            'Nationality' => trim($postData['Nationality']),
            'ed_att' => trim($postData['ed_att']),
            'emp_stat' => trim($postData['emp_stat']),
            'Status' => trim($postData['Status']),
            'Blood' => trim($postData['Blood']),
            'Philhealth' => trim($postData['Philhealth']),
            'Phil_member' => isset($postData['Phil_member']) ? trim($postData['Phil_member']) : '',
            'Phil_no' => isset($postData['Phil_no']) ? trim($postData['Phil_no']) : '',
            'MemCat' => trim($postData['MemCat']),
            'memberAddress' => trim($postData['memberAddress']),
            'memberContact' => trim($postData['memberContact']),
            'userID' => $_SESSION['user_id'],
        ];
    }

    private function formatDate($date)
    {
        $dateArr = explode("/", $date);
        return (count($dateArr) == 3) ? $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1] : '';
    }

    private function insertFamilyAddress($data)
    {
        $insertFamilyQuery = "INSERT INTO tbl_familyaddress (brgy, purok, city_municipality, province, place_of_birth) VALUES (:address, :Purok, :city_municipality, :province, :place_of_birth)";
        $stmtFamily = $this->con->prepare($insertFamilyQuery);
        $stmtFamily->execute([
            ':address' => $data['address'],
            ':Purok' => $data['Purok'],
            ':city_municipality' => $data['city_municipality'],
            ':province' => $data['Province'],
            ':place_of_birth' => $data['placeofBirth'],
        ]);
        return $this->con->lastInsertId();
    }

    private function insertMembershipInfo($data)
    {
        $Phil_no = ($data['Philhealth'] === "No") ? '' : preg_replace('/[^0-9]/', '', $data['Phil_no']);
        $Phil_member = ($data['Philhealth'] === "No") ? '' : $data['Phil_member'];

        $insertMembershipQuery = "INSERT INTO tbl_membership_info (phil_mem, philhealth_no, phil_membership, ps_mem) VALUES (:Phil_member, :Phil_no, :Phil_membership, :ps_mem)";
        $stmtMembership = $this->con->prepare($insertMembershipQuery);
        $stmtMembership->execute([
            ':Phil_member' => $data['Philhealth'],
            ':Phil_no' => $Phil_no,
            ':Phil_membership' => $Phil_member,
            ':ps_mem' => $data['MemCat']
        ]);
        return $this->con->lastInsertId();
    }

    private function insertPatient($data, $familyId, $membershipId)
    {
        $insertPatientQuery = "INSERT INTO tbl_patients (patient_name, household_no, middle_name, last_name, suffix, father_guardian_name, mother_name, cnic, date_of_birth, age, phone_number, gender, civil_status, blood_type, ed_at, emp_stat, religion, Nationality, family_address, membership_info, userID) VALUES (:patientName, :household_no, :middle_name, :last_name, :suffix, :m_name, :f_gname, :cnic, :date_of_birth, :Age, :phone_number, :gender, :civil_status, :Blood, :ed_att, :emp_stat, :religion, :Nationality, :familyId, :membershipId, :userID)";
        $stmtPatient = $this->con->prepare($insertPatientQuery);
        $stmtPatient->execute([
            ':patientName' => $data['patientName'],
            ':household_no' => $data['household_no'],
            ':middle_name' => $data['middle_name'],
            ':last_name' => $data['last_name'],
            ':suffix' => $data['suffix'],
            ':m_name' => $data['m_name'],
            ':f_gname' => $data['f_gname'],
            ':cnic' => $data['cnic'],
            ':date_of_birth' => $data['date_of_birth'],
            ':Age' => $data['Age'],
            ':phone_number' => $data['phone_number'],
            ':gender' => $data['gender'],
            ':civil_status' => $data['Status'],
            ':Blood' => $data['Blood'],
            ':ed_att' => $data['ed_att'],
            ':emp_stat' => $data['emp_stat'],
            ':religion' => $data['religion'],
            ':Nationality' => $data['Nationality'],
            ':familyId' => $familyId,
            ':membershipId' => $membershipId,
            ':userID' => $data['userID']
        ]);
        return $this->con->lastInsertId();
    }

    private function insertFamilyMembers($data, $patientId)
    {
        $insertFamilyMemberQuery = "INSERT INTO tbl_family_members (name, relationship, contact, address, patient_id) VALUES (:name, :relationship, :contact, :address, :patient_id)";
        
        $stmtFatherGuardian = $this->con->prepare($insertFamilyMemberQuery);
        $stmtFatherGuardian->execute([
            ':name' => $data['f_gname'],
            ':relationship' => 'Father',
            ':contact' => $data['memberContact'],
            ':address' => $data['memberAddress'],
            ':patient_id' => $patientId,
        ]);

        $stmtMother = $this->con->prepare($insertFamilyMemberQuery);
        $stmtMother->execute([
            ':name' => $data['m_name'],
            ':relationship' => 'Mother',
            ':contact' => $data['memberContact'],
            ':address' => $data['memberAddress'],
            ':patient_id' => $patientId,
        ]);
    }
}
?>
