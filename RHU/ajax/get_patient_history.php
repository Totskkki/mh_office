
<?php
include '../config/connection.php';

$searchQuery = '%' . $_GET['search_query'] . '%';

// $query = "SELECT 
//             pv.*, 
//             pat.*, 
          
//             u.* ,
//               CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS patient,
//             GROUP_CONCAT(DISTINCT DATE(pv.visit_date) ORDER BY pv.visit_date DESC SEPARATOR ', ') AS visit_dates,
//             GROUP_CONCAT(DISTINCT pv.disease ORDER BY pv.visit_date DESC SEPARATOR ', ') AS diseases,
//             GROUP_CONCAT(DISTINCT DATE(pv.next_visit_date) ORDER BY pv.visit_date DESC SEPARATOR ', ') AS next_visit_dates,
//             GROUP_CONCAT(DISTINCT m.medicine_name SEPARATOR ', ') AS medicine_names,
//             GROUP_CONCAT(DISTINCT pmh.dosage SEPARATOR ', ') AS dosages,
//             GROUP_CONCAT(DISTINCT pmh.schedule_dosage SEPARATOR ', ') AS schedule_dosages,
//             GROUP_CONCAT(DISTINCT pmh.quantity SEPARATOR ', ') AS quantities,
//             GROUP_CONCAT(DISTINCT pmh.duration SEPARATOR ', ') AS durations,
//             GROUP_CONCAT(DISTINCT pmh.time_frame SEPARATOR ', ') AS time_frames
//           FROM 
//             tbl_patient_visits AS pv
//           LEFT JOIN 
//             tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
//           LEFT JOIN 
//             tbl_patients AS pat ON pv.patient_id = pat.patientID
//           LEFT JOIN 
//             tbl_medicine_details AS md ON pmh.medicine_details_id = md.medicine_id
//           LEFT JOIN 
//             tbl_medicines AS m ON md.medicine_id = m.medicineID
//           LEFT JOIN 
//             tbl_users AS u ON u.userID = pv.doctor_id
//           WHERE 
//             pat.patient_name LIKE :searchQuery
//           GROUP BY 
//             pv.patient_id
//           ORDER BY 
//             MAX(pv.visit_date) DESC"; // Order by latest visit date

$query = "SELECT 
            pv.*, 
            pat.*, 
            u.*,
            CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS patient,
            GROUP_CONCAT(DISTINCT DATE(pv.visit_date) ORDER BY pv.visit_date DESC SEPARATOR ', ') AS visit_dates,
            GROUP_CONCAT(DISTINCT pv.disease ORDER BY pv.visit_date DESC SEPARATOR ', ') AS diseases,
            GROUP_CONCAT(DISTINCT DATE(pv.next_visit_date) ORDER BY pv.visit_date DESC SEPARATOR ', ') AS next_visit_dates,
            (
                SELECT GROUP_CONCAT(m.medicine_name SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                LEFT JOIN tbl_medicine_details AS md ON pmh.medicine_details_id = md.medicine_id
                LEFT JOIN tbl_medicines AS m ON md.medicine_id = m.medicineID
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS medicine_names,
            (
                SELECT GROUP_CONCAT(pmh.dosage SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS dosages,
            (
                SELECT GROUP_CONCAT(pmh.schedule_dosage SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS schedule_dosages,
            (
                SELECT GROUP_CONCAT(pmh.quantity SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS quantities,
            (
                SELECT GROUP_CONCAT(pmh.duration SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS durations,
            (
                SELECT GROUP_CONCAT(pmh.time_frame SEPARATOR ', ') 
                FROM tbl_patient_medication_history AS pmh
                WHERE pmh.patient_visit_id = pv.patient_visitID
            ) AS time_frames
          FROM 
            tbl_patient_visits AS pv
          LEFT JOIN 
            tbl_patients AS pat ON pv.patient_id = pat.patientID
          LEFT JOIN 
            tbl_users AS u ON u.userID = pv.doctor_id
          WHERE 
            pat.patient_name LIKE :searchQuery
          GROUP BY 
            pv.patient_id
          ORDER BY 
            MAX(pv.visit_date) DESC";




try {
  $stmt = $con->prepare($query);
  $stmt->bindParam(':searchQuery', $searchQuery, PDO::PARAM_STR);
  $stmt->execute();

  $data = '';
  $i = 0; 
  if ($stmt->rowCount() > 0) {
      while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $data .= '<tr>';
          $data .= '<td class="px-2 py-1 align-middle text-center">' . ($i + 1) . '</td>';
          $data .= '<td class="px-2 py-1 align-middle text-center">' . htmlspecialchars($r['patient']) . '</td>';
          $data .= '<td class="px-2 py-1 align-middle text-center">' . $r['visit_dates'] . '</td>';
          $data .= '<td class="px-2 py-1 align-middle text-center">' . htmlspecialchars($r['diseases']) . '</td>';
          $data .= '<td class="px-2 py-1 align-middle text-center">' . $r['next_visit_dates'] . '</td>';
          $data .= '<td class="px-2 py-1 align-middle text-center">
                      <button class="btn btn-info view-btn" data-toggle="modal" data-target="#prescriptionModal" 
                      data-name="' . htmlspecialchars($r['medicine_names']) . '" 
                      data-patient="' . htmlspecialchars($r['patient']) . '" 
                      data-quantity="' . htmlspecialchars($r['quantities']) . '" 
                      data-schedule_dosage="' . htmlspecialchars($r['schedule_dosages']) . '" 
                      data-dosage="' . htmlspecialchars($r['dosages']) . '" 
                      data-duration="' . htmlspecialchars($r['durations']) . '" 
                      data-time_frame="' . htmlspecialchars($r['time_frames']) . '">View</button>
                    </td>';
          $data .= '</tr>';
          $i++;
      }
  } else {
      $data = '<tr><td colspan="5" class="px-2 py-1 align-middle text-center">No records found.</td></tr>';
  }
} catch (PDOException $ex) {
  echo $ex->getTraceAsString();
  echo $ex->getMessage();
  exit;
}

echo $data;











// include '../config/connection.php';

// $searchQuery = '%' . $_GET['search_query'] . '%';

// $query = "SELECT 
//             pv.*,  pmh.*, pat.*, m.*,  md.*,u.*,
//             CONCAT(pat.patient_name, ' ', pat.middle_name, ' ', pat.last_name, ' ', pat.suffix) AS patient
//           FROM 
//             tbl_patient_visits AS pv
//           LEFT JOIN 
//             tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
//           LEFT JOIN 
//             tbl_patients AS pat ON pv.patient_id = pat.patientID
//           LEFT JOIN 
//             tbl_medicine_details AS md ON pmh.medicine_details_id = md.medicine_id
//           LEFT JOIN 
//             tbl_medicines AS m ON md.medicine_id = m.medicineID
        
//             LEFT JOIN tbl_users AS u on u.userID  = pv.doctor_id
//           WHERE 
//             pat.patient_name LIKE :searchQuery
//             GROUP BY pat.patientID
//           ORDER BY 
//             pv.patient_visitID desc, pmh.patient_med_historyID desc";

// try {
//     $stmt = $con->prepare($query);
//     $stmt->bindParam(':searchQuery', $searchQuery, PDO::PARAM_STR);
//     $stmt->execute();
//     $data = '';
//   $i = 0;
//   while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $i++;
//     $data = $data . '<tr>';

//     $data = $data . '<td class="px-2 py-1 align-middle text-center">' . $i . '</td>';
//     $data = $data . '<td class="px-2 py-1 align-middle text-center">' . date("M d, Y", strtotime($r['visit_date'])) . '</td>';
//     $data = $data . '<td class="px-2 py-1 align-middle text-center">' . $r['disease'] . '</td>';
//     $data = $data . '<td class="px-2 py-1 align-middle text-center">' . date("M d, Y", strtotime($r['next_visit_date'])) . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle">' . $r['medicine_name'] . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle text-right">' . $r['packing'] . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle text-right">' . $r['quantity'] . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle text-right">' . $r['dosage'] . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle text-right">' . $r['duration'] . '</td>';
//     // $data = $data . '<td class="px-2 py-1 align-middle text-right">' . $r['advice'] . '</td>';
//     $data .= '<td class="px-2 py-1 align-middle text-center"><button class="btn btn-info view-btn" data-toggle="modal" data-target="#prescriptionModal" data-name="
//     ' . htmlspecialchars($r['medicine_name']) . '" data-patient="' . htmlspecialchars($r['patient']) . '" data-quantity="' . htmlspecialchars($r['quantity']) . '" data-schedule_dosage="' . htmlspecialchars($r['schedule_dosage']) . '" data-dosage="' . htmlspecialchars($r['dosage']) . '" data-duration="' . htmlspecialchars($r['duration']). '" data-time_frame="' . htmlspecialchars($r['time_frame'])  . '">View</button></td>';

//     $data .= '</tr>';
    

 
//   }
//   if ($i === 0) {
//     $data = '<tr><td colspan="9" class="px-2 py-1 align-middle text-center">No records found.</td></tr>';
// }
// } catch (PDOException $ex) {
//   echo $ex->getTraceAsString();
//   echo $ex->getMessage();
//   exit;
// }

// echo $data;
