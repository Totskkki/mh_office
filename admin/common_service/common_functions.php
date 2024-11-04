<?php

// function getGender222()
// {
// 	//do not use this function
// 	exit;
// 	$data = '<option value="">Select Gender</option>';

// 	$data = $data . '<option value="Male">Male</option>';
// 	$data = $data . '<option value="Female">Female</option>';
// 	$data = $data . '<option value="Other">Other</option>';

// 	return $data;
// }

// function getGenderFromDatabase($patientId) {
//     // Include your database connection code here

// 	global $con;

//         $query = "SELECT gender FROM patients WHERE id = :patientId";
//         $stmt = $con->prepare($query);
//         $stmt->bindParam(':patientId', $patientId, PDO::PARAM_INT);
//         $stmt->execute();

//         $result = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($result) {
//             return $result['gender'];
//         } else {
//             return '';  // Return empty string if no gender is found
//         }

// }
function validate($inputData)
{
	return trim($inputData);
}

function getAll($tableName, $orderByColumn, $pdo)
{
	$tableName = validate($tableName);
	$orderByColumn = validate($orderByColumn);
	$query = "SELECT * FROM $tableName ORDER BY $orderByColumn DESC";
	$statement = $pdo->query($query);
	return $statement->fetchAll(PDO::FETCH_ASSOC);
}



function redirect($page, $message = '')
{
	header("Location: $page?message=$message");
	exit;
}


function getMemCat($MemCat = '')
{
	$data = '';

	$arr = array("NHTS", "4PS", "LGU", "Private");
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		$checked = (in_array($arr[$i], (array)$MemCat)) ? 'checked="checked"' : '';
		$id = strtolower($arr[$i]);
		$data .= '<div class="form-check">';
		$data .= '<input class="form-check-input" type="checkbox" id="MemCat' . $id . '" name="MemCat" value="' . $arr[$i] . '" ' . $checked . '>';
		$data .= '<label class="form-check-label" for="MemCat' . $id . '">' . $arr[$i] . '</label>';
		$data .= '</div>';
	}

	return $data;
}

// function getMemCat($MemCat = '')
// {
//     $data = '';

//     $arr = array("NHTS", "4PS", "LGU","Private");

//     $size = sizeof($arr);

//     for ($i = 0; $i < $size; $i++) {
//         $checked = ($MemCat == $arr[$i]) ? 'checked="checked"' : '';
// 		$id = strtolower($arr[$i]); // Create ID based on gender
//         $data .= '<input type="checkbox" id="MemCat'  . $id .'" name="MemCat" value="' . $arr[$i] . '" ' . $checked . '>' . $arr[$i] . '&nbsp;&nbsp;&nbsp;';
//     }

//     return $data;
// }
// function redirect($url, $status)
// {
//     $_SESSION['status'] = $status;
//     header('Location: ' . $url);
//     exit(0);
// }


function alertmessage()
{
	if (isset($_SESSION['status'])) {
		echo '<div class="alert alert-success">
        <h4>' . $_SESSION['status'] . '</h4>
        </div>';
		unset($_SESSION['status']);
	}
}

function getGender($selectedGender = '')
{
	$genders = array("Male", "Female", "Other");
	$html = '';
	foreach ($genders as $gender) {
		$checked = ($selectedGender == $gender) ? 'checked' : '';
		$html .= '<label class="gender-label">';
		$html .= '<input type="radio" name="gender" value="' . $gender . '" ' . $checked . '>';
		$html .= $gender;
		$html .= '</label>&nbsp;&nbsp;&nbsp;';
	}
	return $html;
}
function getconsulpurpose($consulpurpose = '')
{
	$data = '<option value="">(Select purpose of visit)</option>';

	$arr = array("General", "Prenatal", "Maternity", "Vaccination and Immunization", "Animal bite and Care");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($consulpurpose == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getnature($nature = '')
{
	$data = '<option value="">(Select Nature of Visit)</option>';

	$arr = array("New consultation/case", "New admission", "Follow-up visit");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($nature == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}

function getstat($stat = '')
{
	$data = '<option value="">Select Status</option>';

	$arr = array("Single", "Married", "Separated", "Widow");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getstatus($stat = '')
{
	$data = '<option value="">Select Status</option>';

	$arr = array("Active", "inactive");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function gethealthProf($stat = '')
{
	$data = '<option value="">Select Role</option>';

	$arr = array("Doctor", "Midwife", "Nurse", "Physician");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getrole($stat = '')
{
	$data = '<option value="">Select Role</option>';

	$arr = array("BHW", "RHU");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getnationality($stat = '')
{
	$data = '<option value="">Select Nationality</option>';

	$arr = array("Filipino", "Asian");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function geteducation($stat = '')
{
	$data = '<option value="">Select Educational Attainment</option>';

	$arr = array("No Formal Education", "Elementary", "High School", "College Level", "College Graduate");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($stat == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getblood($blood = '')
{
	$data = '<option value="">Select Blood Group</option>';

	$arr = array("A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($blood == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getphilhealth($philhealth = '')
{
	$data = '<option value="">Select Philhealth</option>';

	$arr = array("Yes", "No");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($philhealth == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getphilhealthmembership($philhealth = '')
{
	$data = '<option value="">Select Membership</option>';

	$arr = array("Member", "Dependent", "None Member");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($philhealth == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}

function get4ps($get4ps = '')
{
	$data = '<option value="">Select 4Ps</option>';

	$arr = array("Yes", "No");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($get4ps == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}

function getprofType($profType = '')
{
	$data = '<option value="">Select Designation</option>';

	$arr = array("Doctor", "Midwife", "Nurse");

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($profType == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
function getbrgy($brgy = '')
{
	$data = '<option value="">Select Barangay</option>';

	$arr = array(
		"Antong",
		"Bayasong",
		"Blingkong",
		"lut Proper",
		"Maindang",
		"Mamali",
		"Mangudadatu",
		"Manili",
		"Punol",
		"Palavilla",
		"Sampao",
		"Sisiman",
		"Tamnag (Pob.)",
		"Tananzang",
	);

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($brgy == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}




// function getMedicines($con, $medicineId = 0)
// {

// 	$query = "select * from `tbl_medicines` 
// 	order by `medicine_name` ";

// 	$stmt = $con->prepare($query);
// 	try {
// 		$stmt->execute();
// 	} catch (PDOException $ex) {
// 		echo $ex->getTraceAsString();
// 		echo $ex->getMessage();
// 		exit;
// 	}

// 	$data = '<option value="">Select Medicine</option>';

// 	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		if ($medicineId == $row['medicineID']) {
// 			$data = $data . '<option selected="selected" value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
// 		} else {
// 			$data = $data . '<option value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
// 		}
// 	}

// 	return $data;
// }

function getMedicines($con, $medicineId = 0)
{
	$query = "SELECT * FROM `tbl_medicines` where status != 0 ORDER BY `medicine_name` ;";
	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">Select Medicine</option>';
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$selected = ($medicineId == $row['medicineID']) ? ' selected' : '';
		$data .= '<option value="' . $row['medicineID'] . '"' . $selected . '>' . $row['medicine_name'] . '</option>';
	}

	return $data;
}

// function getDoctor($con)
// {
// 	$query = "SELECT `id`, `Name`, `contact`, `email`, `address`, `specialty`, `professional_type`FROM `doctor` order by `Name` asc;";

// 	$stmt = $con->prepare($query);
// 	try {
// 		$stmt->execute();
// 	} catch (PDOException $ex) {
// 		echo $ex->getTraceAsString();
// 		echo $ex->getMessage();
// 		exit;
// 	}

// 	$data = '<option value="">Select Doctor/MidWife</option>';

// 	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		$data = $data . '<option value="' . $row['id'] . '">' . $row['Name'] . '' . '</option>';
// 	}

// 	return $data;
// }

function getDoctor($con)
{
	// $query = "SELECT user.*, personnel.*, position.*, user.UserType
	// FROM `tbl_users` AS user
	// INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
	// INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
	// WHERE user.UserType = 'Doctor'";

	$query = "SELECT user.*, personnel.*, position.*, user.UserType
              FROM `tbl_users` AS user
              INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
              INNER JOIN `tbl_position` AS position ON personnel.personnel_id = position.personnel_id
              WHERE user.UserType = 'Doctor' or user.UserType ='Midwife'";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">Select Doctor</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['userID'] . '">' . $row['first_name'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
	}

	return $data;
}
function getDoctorSchedule($con)
{
	// $query = "SELECT user.*, personnel.*, position.*, user.UserType
	// FROM `tbl_users` AS user
	// INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
	// INNER JOIN `tbl_position` AS position ON position.personnel_id = position.position_id
	// WHERE user.UserType = 'Doctor'";

	$query = "SELECT user.*, personnel.*, position.*, user.UserType
              FROM `tbl_users` AS user
              INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
              INNER JOIN `tbl_position` AS position ON personnel.personnel_id = position.personnel_id
              WHERE user.UserType = 'Doctor'";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">Select Doctor</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['userID'] . '">' . $row['first_name'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
	}

	return $data;
}

// function searchPatients($con, $searchTerm = "") {
// 	// Initialize the WHERE clause with an empty string
// 	$whereClause = "";

// 	// Check if a search term is provided
// 	if (!empty($searchTerm)) {
// 		// Add the condition to the WHERE clause
// 		$whereClause = " WHERE `patient_name` LIKE :searchTerm ";
// 	}

// 	$query = "SELECT `id`, `patient_name`, `phone_number` 
// 			  FROM `patients` 
// 			  $whereClause
// 			  ORDER BY `patient_name` ASC;";

// 	$stmt = $con->prepare($query);

// 	try {
// 		// Bind the parameter if a search term is provided
// 		if (!empty($searchTerm)) {
// 			$stmt->bindParam(":searchTerm", '%' . $searchTerm . '%', PDO::PARAM_STR);
// 		}

// 		$stmt->execute();
// 	} catch (PDOException $ex) {
// 		echo $ex->getTraceAsString();
// 		echo $ex->getMessage();
// 		exit;
// 	}

// 	$data = '<option value="">Select Patient</option>';

// 	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		$data .= '<option value="' . $row['id'] . '">' . $row['patient_name'] . '</option>';
// 	}

// 	return $data;
// }


function getPatients($con)
{
	$query = "select `id`, CONCAT(`patient_name`,' ' , `middle_name` ,'. ', `last_name`,' ',`suffix`) AS `name`
				from `patients` order by `name` asc;";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">Select Patient</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['id'] . '">' . $row['name'] . '' . '</option>';
	}

	return $data;
}

function getDateTextBox($label, $dateId)
{

	$d = '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-10">
                <div class="form-group">
                  <label>' . $label . '</label>
                  <div class="input-group rounded-0 date" 
                  id="" 
                  data-target-input="nearest">
                  <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-toggle="datetimepicker" 
data-target="#' . $dateId . '" name="' . $dateId . '" id="' . $dateId . '" required="required" autocomplete="off"/>
                  <div class="input-group-append rounded-0" 
                  data-target="#' . $dateId . '" 
                  data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>
          </div>';

	return $d;
}


function getdrugs($drugs = '')
{
	$data = '<option value=""></option>';

	$arr = array(
		"Analgesics",
		"Antibiotics",
		"Antidepressants",
		"Antihypertensives",
		"Antihistamines",
		"Antipsychotics",
		"Anticoagulants",
		"Antidiabetic drugs",
		"Bronchodilators",
		"Immunosuppressants",
		"Vaccines"
	);

	$i = 0;
	$size = sizeof($arr);

	for ($i = 0; $i < $size; $i++) {
		if ($drugs == $arr[$i]) {
			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		} else {
			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
		}
	}

	return $data;
}
// =======================INSERT=========================================

function insert($tablename, $data, $con)
{
	$table = validate($tablename);

	$columns = array_keys($data);
	$values = array_values($data);

	$finalColumn = implode(', ', $columns);
	$finalValues = rtrim(str_repeat('?, ', count($values)), ', ');

	$query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
	$stmt = $con->prepare($query);
	$result = $stmt->execute($values);

	return $result;
}
// =======================END INSERT=========================================

// =======================UPDATE START=========================================
function update($tableName, $primaryKeyColumn, $id, $data, $pdo)
{
	$tableName = validate($tableName);
	$primaryKeyColumn = validate($primaryKeyColumn);
	$id = validate($id);

	$updateDataString = "";
	$values = [];
	foreach ($data as $column => $value) {
		$updateDataString .= "$column = ?, ";
		$values[] = $value;
	}
	$updateDataString = rtrim($updateDataString, ', ');
	$values[] = $id;

	$query = "UPDATE $tableName SET $updateDataString WHERE $primaryKeyColumn = ?";
	$stmt = $pdo->prepare($query);
	$result = $stmt->execute($values);

	return $result;
}

// =======================UPDATE END=========================================





function getAffectedRecordName($table, $recordId, $con)
{
	switch ($table) {
		case 'tbl_doctor_schedule':
			$stmt = $con->prepare(" SELECT user.*, personnel.*, position.*, doctor.*,
            concat(personnel.first_name, ' ', personnel.middlename, ' ', personnel.lastname) as doctors_name
			FROM `tbl_users` AS user
			LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
			LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
			LEFT JOIN `tbl_doctor_schedule` AS doctor ON user.userID = doctor.userID
			WHERE doctor.doc_scheduleID = ?");


			$stmt->execute([$recordId]);
			$result = $stmt->fetch();
			if ($result) {
				return trim(($result['doctors_name'] ?? ''));
			} else {
				return 'Unknown'; // If no record is found
			}
		case 'tbl_announcements':
			$stmt = $con->prepare("SELECT `date`, `title`, `details`, `created_at`, `updated_at` FROM `tbl_announcements` WHERE announceID  = ?");


			$stmt->execute([$recordId]);
			$result = $stmt->fetch();
			if ($result) {
				return trim(($result['title'] ?? '') . ' ' . ($result['details'] ?? ''));
			} else {
				return 'Unknown';
			}
		case 'tbl_medicine_details':
			$stmt = $con->prepare("SELECT m.*, md.*
								FROM `tbl_medicines` AS m
								JOIN `tbl_medicine_details` AS md ON m.medicineID = md.medicine_id
								WHERE
								md.med_detailsID=?");


			$stmt->execute([$recordId]);
			$result = $stmt->fetch();
			if ($result) {
				return trim(($result['medicine_name'] ?? '') . ' ' . ($result['packing'] ?? '')  . ' ' . ($result['qt'] ?? ''));
			} else {
				return 'Unknown';
			}

		case 'tbl_medicines':
			$stmt = $con->prepare("SELECT `medicineID`, `medicine_name`, `description`, `supplier`, `category`, `manuf_date`, `ex_date`, `manufacturer`, `brand`, `status`, `date_added` FROM `tbl_medicines`
                                                    WHERE medicineID = ?");


			$stmt->execute([$recordId]);
			$result = $stmt->fetch();
			if ($result) {
				return trim(($result['medicine_name'] ?? ''));
			} else {
				return 'Unknown';
			}
			case 'tbl_users':
			$stmt = $con->prepare("SELECT user.*,personnel.*, position.*
								FROM `tbl_users` AS user
								LEFT JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
								LEFT JOIN `tbl_position` AS position ON user.position_id = position.position_id
								WHERE user.userID= ? ");


			$stmt->execute([$recordId]);
			$result = $stmt->fetch();
			if ($result) {
				return trim(($result['first_name'] ?? '') . ' ' . ($result['middlename'] ?? '')  . ' ' . ($result['lastname'] ?? ''));
			} else {
				return 'Unknown';
			}






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
