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

// function redirect($page, $message = '') {
//     header("Location: $page?message=$message");
//     exit;
// }

// function getMemCat($MemCat = '')
// {
//     $data = '';

//     $arr = array("NHTS", "4PS", "LGU","Private");

//     $size = sizeof($arr);

//     for ($i = 0; $i < $size; $i++) {
//         $checked = ($MemCat == $arr[$i]) ? 'checked="checked"' : '';
// 		$id = strtolower($arr[$i]); 
//         $data .= '<input type="checkbox" id="MemCat'  . $id .'" name="MemCat" value="' . $arr[$i] . '" ' . $checked . '>' . $arr[$i] . '&nbsp;&nbsp;&nbsp;';
//     }

//     return $data;
// }
function redirect($url, $status)
{
	$_SESSION['status'] = $status;
	header('Location: ' . $url);
	exit(0);
}


function alertmessage()
{
	if (isset($_SESSION['status'])) {
		echo '<div class="alert alert-success">
        <h4>' . $_SESSION['status'] . '</h4>
        </div>';
		unset($_SESSION['status']);
	}
}

function getGender($selectedGender = '') {
    $genders = array("Male", "Female", "Other");
    $html = '';
    foreach ($genders as $gender) {
        $checked = ($selectedGender == $gender) ? 'checked' : '';
        $html .= '<label class="gender-label">';
        $html .= '<input type="radio" name="gender" value="' . $gender . '" ' . $checked . ' required>';
        $html .= $gender;
        $html .= '</label>&nbsp;&nbsp;&nbsp;';
    }
    return $html;
}

function getconsulpurpose($consulpurpose = '')
{
	$data = '<option value="">(Select purpose of visit)</option>';

	$arr = array("Checkup", "Prenatal", "Birthing", "Vaccination and Immunization", "Animal bite and Care");

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
function getnature($nature = '', $isNewPatient = true)
{
	$data = '<option value="">(Select Nature of Visit)</option>';

	$arr = array("New consultation/case", "New admission", "Follow-up visit");

	foreach ($arr as $option) {
		if ($isNewPatient || $option == "Follow-up visit") {
			if ($nature == $option) {
				$data .= '<option selected="selected" value="' . $option . '">' . $option . '</option>';
			} else {
				$data .= '<option value="' . $option . '">' . $option . '</option>';
			}
		}
	}

	return $data;
}


// function getnature($nature = '')
// {
// 	$data = '<option value="">(Select Nature of Visit)</option>';

// 	$arr = array("New consultation/case", "New admission","Follow-up visit");

// 	$i = 0;
// 	$size = sizeof($arr);

// 	for ($i = 0; $i < $size; $i++) {
// 		if ($nature == $arr[$i]) {
// 			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
// 		} else {
// 			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
// 		}
// 	}

// 	return $data;
// }

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
	$data = '<option value=""></option>';

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

// function get4ps($get4ps =''){
// 	$data = '<option value="">Select 4Ps</option>';

// 	$arr = array("Yes", "No");

// 	$i = 0;
// 	$size = sizeof($arr);

// 	for ($i = 0; $i < $size; $i++) {
// 		if ($get4ps == $arr[$i]) {
// 			$data = $data . '<option selected="selected" value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
// 		} else {
// 			$data = $data . '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
// 		}
// 	}

// 	return $data;

// }

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
		"Tamnag",
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
// function getvaccine($con, $selectedMedicineIds = [])
// {
//     $query = "SELECT m.*, d.*,
//               (d.qt - COALESCE((
//                   SELECT SUM(dose_number)
//                   FROM tbl_animal_bite_vaccination
//                   WHERE vaccination_name = m.medicineID
//               ), 0)) AS available_qty
//               FROM `tbl_medicines` AS m
//               LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
//               WHERE m.category = 'Vaccines'
//               ORDER BY m.`medicine_name` ASC";

//     $stmt = $con->prepare($query);
//     try {
//         $stmt->execute();
//     } catch (PDOException $ex) {
//         echo $ex->getMessage();
//         exit;
//     }

//     $data = '<option value="">Select Vaccine</option>';
//     $selectedMedicineIds = (array)$selectedMedicineIds; 

//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $selected = in_array($row['medicineID'], $selectedMedicineIds) ? 'selected="selected"' : '';
//         $data .= '<option ' . $selected . ' value="' . $row['medicineID'] . '">' . $row['medicine_name'] . ' (Available: ' . $row['available_qty'] . ')</option>';
//     }

//     return $data;
// }

function getvacimmunize($con, $medicineId = 0)
{
	$query = "SELECT m.*, d.* 
              FROM `tbl_medicines` AS m
              LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
              WHERE m.`category` = 'Vaccines'
              ORDER BY m.`medicine_name` ASC;";

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
		if ($medicineId == $row['medicine_name']) {
			$data = $data . '<option selected="selected" value="' . $row['medicine_name'] . '">' . $row['medicine_name'] . '</option>';
		} else {
			$data = $data . '<option value="' . $row['medicine_name'] . '">' . $row['medicine_name'] . '</option>';
		}
	}

	return $data;
}


function getvaccine($con, $medicineId = 0)
{

	// $query = "SELECT m.*,d.*
	// FROM `tbl_medicines` AS m
	// LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
	// where category = 'Vaccines'
	// ORDER BY m.`medicine_name` ASC;";
	$query = "SELECT m.*, d.*,
              (d.qt - COALESCE((
                  SELECT SUM(dose_number)
                  FROM tbl_animal_bite_vaccination
                  WHERE vaccination_name = m.medicineID
              ), 0)) AS available_qty
              FROM `tbl_medicines` AS m
              LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
              WHERE m.category = 'Vaccines'
              ORDER BY m.`medicine_name` ASC";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">Select Vaccine</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($medicineId == $row['medicineID']) {
			$data = $data . '<option selected="selected" value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		} else {
			$data = $data . '<option value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		}
	}

	return $data;
}
function getMedication($con, $medicineId = 0)
{

	$query = "SELECT m.*, d.*,
              (d.qt - COALESCE((
                  SELECT SUM(Dosage)
                  FROM tbl_patient_medication_history
                  WHERE medicine_details_id = m.medicineID
              ), 0)) AS available_qty
              FROM `tbl_medicines` AS m
              LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
			  WHERE m.category not in ('Vaccines')
			  GROUP BY m.`medicine_name`
              ORDER BY m.`medicine_name` ASC
			  ";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="" >Select Medicine</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($medicineId == $row['medicineID']) {
			$data = $data . '<option selected="selected" value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		} else {
			$data = $data . '<option value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		}
	}

	return $data;
}
function getpresMedicines($con, $medicineId = 0)
{

	$query = "SELECT m.*, d.*,
              (d.qt - COALESCE((
                  SELECT SUM(quantity)
                  FROM tbl_patient_medication_history
                  WHERE medicine_details_id = m.medicineID
              ), 0)) AS available_qty
              FROM `tbl_medicines` AS m
              LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
			  WHERE m.category not in ('Vaccines')
			  GROUP BY m.`medicine_name`
              ORDER BY m.`medicine_name` ASC
			  ";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="" >Select Medicine</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if ($medicineId == $row['medicineID']) {
			$data = $data . '<option selected="selected" value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		} else {
			$data = $data . '<option value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		}
	}

	return $data;
}


function getMedicines($con, $medicineId = 0)
{

	$query = "SELECT m.`medicineID`, m.`medicine_name`, m.`description`, m.`supplier`, m.`category`, m.`manuf_date`, m.`ex_date`, m.`manufacturer`, m.`brand`, m.`date_added`, d.`med_detailsID`, d.`packing`, d.`qt` 
	FROM `tbl_medicines` AS m
	LEFT JOIN `tbl_medicine_details` AS d ON m.`medicineID` = d.`medicine_id`
	ORDER BY m.`medicine_name` ASC;";

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
		if ($medicineId == $row['medicineID']) {
			$data = $data . '<option selected="selected" value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		} else {
			$data = $data . '<option value="' . $row['medicineID'] . '">' . $row['medicine_name'] . '</option>';
		}
	}

	return $data;
}


function getNurseMidwife($con)
{


	$query = "SELECT user.*, personnel.*, position.*, user.UserType
              FROM `tbl_users` AS user
              INNER JOIN `tbl_personnel` AS personnel ON user.personnel_id = personnel.personnel_id
              INNER JOIN `tbl_position` AS position ON personnel.personnel_id = position.personnel_id
              WHERE 
			  user.UserType  = 'Nurse' OR user.UserType = 'Midwife' ";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">--Select--</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['userID'] . '">' . $row['first_name'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
	}

	return $data;
}
function getphysician($con)
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
              WHERE 
			  user.UserType  = 'Physician'";

	$stmt = $con->prepare($query);
	try {
		$stmt->execute();
	} catch (PDOException $ex) {
		echo $ex->getTraceAsString();
		echo $ex->getMessage();
		exit;
	}

	$data = '<option value="">--Select--</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['userID'] . '">' . $row['first_name'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
	}

	return $data;
}

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

	$data = '<option value="">Select Doctor/MidWife</option>';

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = $data . '<option value="' . $row['userID'] . '">' . $row['first_name'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . '</option>';
	}

	return $data;
}
function getDoctor1($con)
{
	

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

	$data = '<option value="">-Select Doctor-</option>';

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
	$query = "SELECT users.*, family.*, mem.* 
	FROM tbl_patients AS users 
  LEFT JOIN tbl_familyAddress AS family ON users.patientID = family.famID 
  LEFT JOIN tbl_membership_info AS mem ON users.patientID = mem.membershipID ";

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
		$data = $data . '<option value="' . $row['patientID'] . '">' . $row['patient_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . '</option>';
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


function getusercat($stat = '')
{
	$data = '<option value="">Select User Category</option>';

	$arr = array("MHW", "BHW");

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


function generateSymptomsForm($selectedSymptoms = [])
{
	$symptomsCategories = [
		'Gastrointestinal' => ['Abdomen cram/pain', 'Constipation', 'Diarrhea', 'Vomiting'],
		'Neurological' => ['Headache', 'Seizures', 'Dizziness'],
		'Respiratory' => ['Cough', 'Dyspnea', 'Hemoptysis'],
		'Miscellaneous' => ['Weight loss', 'Fever', 'Sweating', 'Palpitations', 'Skin rashes']
	];

	$output = '<div class="forms-container">';

	foreach ($symptomsCategories as $category => $symptoms) {
		$output .= '<div class="card-body d-grid gap-3">';
		foreach ($symptoms as $symptom) {
			$sanitizedSymptom = htmlspecialchars($symptom);
			$id = strtolower(str_replace([' ', ',', '.'], '', $symptom));
			$checked = in_array($symptom, $selectedSymptoms) ? 'checked="checked"' : '';

			$output .= '<div class="form-check">';
			$output .= '<input class="form-check-input" type="checkbox" id="' . $id . '" name="symptoms[]" value="' . $sanitizedSymptom . '" ' . $checked . '>';
			$output .= '<label class="form-check-label" for="' . $id . '">' . $sanitizedSymptom . '</label>';
			$output .= '</div>';
		}
		$output .= '</div>'; // Close card-body
	}

	$output .= '</div>'; // Close forms-container
	return $output;
}
