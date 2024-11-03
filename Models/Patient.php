<?php
class Patient
{
    private $con;
    private $audit;

    public function __construct($db)
    {
        $this->con = $db;
        $this->audit = new AuditTrail($db);
    }


    public function logAuditTrail($userId, $action, $description, $table, $recordId)
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $query = "INSERT INTO audit_trail (user_id, action, description, affected_table, affected_record_id, ip_address) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->execute([$userId, $action, $description, $table, $recordId, $ipAddress]);
    }
    public function savePatient($data)
    {
        try {
            $this->con->beginTransaction();

            // Insert family address
            $insertFamilyQuery = "INSERT INTO tbl_familyaddress (brgy, purok, city_municipality, province, place_of_birth)
                                  VALUES (:address, :Purok, :city_municipality, :province, :place_of_birth)";
            $stmtFamily = $this->con->prepare($insertFamilyQuery);
            $stmtFamily->execute([
                ':address' => $data['address'],
                ':Purok' => $data['Purok'],
                ':city_municipality' => $data['city_municipality'],
                ':province' => $data['Province'],
                ':place_of_birth' => $data['placeofBirth']
            ]);
            $familyId = $this->con->lastInsertId();

            // Insert membership info
            $philhealth = $data['philhealth'] === "No" ? NULL : $data['Phil_no'];
            $insertMembershipQuery = "INSERT INTO tbl_membership_info (phil_mem, philhealth_no, phil_membership, ps_mem)
                                      VALUES (:Phil_member, :Phil_no, :Phil_membership, :ps_mem)";
            $stmtMembership = $this->con->prepare($insertMembershipQuery);
            $stmtMembership->execute([
                ':Phil_member' => $data['philhealth'],
                ':Phil_no' => $philhealth,
                ':Phil_membership' => $data['Phil_member'],
                ':ps_mem' => $data['MemCat']
            ]);
            $membershipId = $this->con->lastInsertId();

            // Insert patient
            $insertPatientQuery = "INSERT INTO tbl_patients (patient_name, household_no, middle_name, last_name, suffix, father_guardian_name, mother_name, cnic, date_of_birth, age, phone_number, gender, civil_status, blood_type, ed_at, emp_stat, religion, Nationality, family_address, membership_info, userID)
                                   VALUES (:patientName, :household_no, :middle_name, :last_name, :suffix, :m_name, :f_gname, :cnic, :dateBirth, :Age, :phoneNumber, :gender, :civil_status, :Blood, :ed_att, :emp_stat, :religion, :Nationality, :familyId, :membershipId, :userID)";
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
                ':dateBirth' => $data['dateBirth'],
                ':Age' => $data['Age'],
                ':phoneNumber' => $data['phoneNumber'],
                ':gender' => $data['gender'],
                ':civil_status' => $data['status'],
                ':Blood' => $data['Blood'],
                ':ed_att' => $data['ed_att'],
                ':emp_stat' => $data['emp_stat'],
                ':religion' => $data['religion'],
                ':Nationality' => $data['Nationality'],
                ':familyId' => $familyId,
                ':membershipId' => $membershipId,
                ':userID' => $data['user']
            ]);
            $patientId = $this->con->lastInsertId();

            // Insert father and mother into family members
            $this->insertFamilyMember($data['f_gname'], 'Father', $data['memberContact'], $data['memberAddress'], $patientId);
            $this->insertFamilyMember($data['m_name'], 'Mother', $data['memberContact'], $data['memberAddress'], $patientId);

            // Log audit trail
            $this->audit->logAuditTrail($data['user'], 'INSERT', 'Added a new patient', 'patients', $patientId);

            $this->con->commit();
            return ['status' => 'success', 'message' => 'Patient added successfully.'];
        } catch (PDOException $e) {
            $this->con->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function insertFamilyMember($name, $relationship, $contact, $address, $patientId)
    {
        $insertFamilyMemberQuery = "INSERT INTO tbl_family_members (name, relationship, contact, address, patient_id) 
                                    VALUES (:name, :relationship, :contact, :address, :patient_id)";
        $stmt = $this->con->prepare($insertFamilyMemberQuery);
        $stmt->execute([
            ':name' => $name,
            ':relationship' => $relationship,
            ':contact' => $contact,
            ':address' => $address,
            ':patient_id' => $patientId
        ]);
    }
}
