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

function getAll($tableName, $orderByColumn, $pdo) {
    $tableName = validate($tableName);
    $orderByColumn = validate($orderByColumn);
    $query = "SELECT * FROM $tableName ORDER BY $orderByColumn DESC";
    $statement = $pdo->query($query);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}



function redirect($page, $message = '') {
    header("Location: $page?message=$message");
    exit;
}
function getMemCat($MemCat = '') {
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

function getGender($selectedGender = '') {
    $genders = array("Male", "Female", "Other");
    $html = '';
    foreach ($genders as $gender) {
        $checked = ($selectedGender == $gender) ? 'checked' : '';
        $html .= '<label class="gender-label">';
        $html .= '<input type="radio" name="gender" required value="' . $gender . '" ' . $checked . '>';
        $html .= $gender;
        $html .= '</label>&nbsp;&nbsp;&nbsp;';
    }
    return $html;
}

function getconsulpurpose($consulpurpose = '')
{
	$data = '<option value="">(Select purpose of visit)</option>';

	$arr = array("Checkup", "Prenatal","Birthing","Vaccination and Immunization","Animal bite and Care");

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


function getstat($stat = '')
{
	$data = '<option value="">Select Status</option>';

	$arr = array("Single", "Married","Separated","Widow");

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

	$arr = array("Active", "Inactive");

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

	$arr = array("BHW", "MHO");

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

	$arr = array("No Formal Education","Elementary", "High School", "College Level","College Graduate");

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

	$arr = array("A+","A-","B+","B-","AB+","AB-","O+","O-");

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

function get4ps($get4ps =''){
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

	$arr = array("Doctor", "Midwife","Nurse");

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

	$arr = array("Bayasong",
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
				 "Tananzang",);

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




function getMedicines($con, $medicineId = 0)
{

	$query = "select * from `tbl_medicines` 
	order by `medicine_name` asc;";

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

function getDoctor($con)
{
	$query = "SELECT `id`, `Name`, `contact`, `email`, `address`, `specialty`, `professional_type`FROM `doctor` order by `Name` asc;";

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
		$data = $data . '<option value="' . $row['id'] . '">' . $row['Name'] . '' . '</option>';
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

	$arr = array("Analgesics",
				"Antibiotics",
				"Antidepressants",
				"Antihypertensives",
				 "Antihistamines",
				 "Antipsychotics",
				 "Anticoagulants",
				 "Antidiabetic drugs",
				 "Bronchodilators",
				 "Immunosuppressants"
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

function insert($tablename, $data, $con) {
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
function update($tableName, $primaryKeyColumn, $id, $data, $pdo) {
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


