<?php
include './config/connection.php';
require_once('tcpdf/tcpdf.php'); // Include TCPDF library

ob_start();
if (isset($_GET['id'])) {
    $patientID = $_GET['id'];

    function getPatientDetails($con, $patient_id)
    {
        $query = "
        SELECT 
            pv.*, pmh.*, p.*, m.*, md.*, u.*, per.*, po.*, fam.*,
            CONCAT('Purok ', fam.purok, ', Brgy. ', fam.brgy,', ', fam.city_municipality,', ', fam.province) AS familyaddress,
            CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS doctors_name
        FROM tbl_patients AS p
        LEFT JOIN tbl_patient_visits AS pv ON pv.patient_id = p.patientID
        LEFT JOIN tbl_patient_medication_history AS pmh ON pv.patient_visitID = pmh.patient_visit_id
        LEFT JOIN tbl_familyAddress AS fam ON fam.famID = p.family_address
        LEFT JOIN tbl_medicine_details AS md ON pmh.medicine_details_id = md.medicine_id
        LEFT JOIN tbl_medicines AS m ON md.medicine_id = m.medicineID
        LEFT JOIN tbl_users AS u ON u.userID = pv.doctor_id
        LEFT JOIN tbl_personnel AS per ON u.personnel_id = per.personnel_id 
        LEFT JOIN tbl_position AS po ON u.position_id = po.position_id 
        WHERE p.patientID = :patientID
        ORDER BY pv.patient_visitID DESC, pmh.patient_med_historyID DESC
        LIMIT 1;
    ";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':patientID', $patient_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $patientDetails = getPatientDetails($con, $patientID);

    if ($patientDetails) {
        $patient_name = $patientDetails['patient_name'] . ' ' . $patientDetails['middle_name'] . ' ' . $patientDetails['last_name'];
        $patient_age = $patientDetails['age'];
        $patient_sex = $patientDetails['gender'];
        $patient_add = $patientDetails['familyaddress'];
        $exam_date = date('Y-m-d');
        if (!empty($patientDetails['disease'])) {
            $diagnosis = $patientDetails['disease'];
            $recommendations = $patientDetails['recom'];
        } else {
            // Set default values when no illness/diagnosis is available
            $diagnosis = "<i>This is to certify that the above-named person at this clinic and was found to be Apparently healthy.</i>";
            $recommendations = "<i>PHYSICALLY FIT TO WORK.</i>";
        }

        $default_doctor_name = "WILJUN O. PANGARINTAO, MD, FPSMS";
        $default_license_no = "106268";

        $doctor_name = !empty($patientDetails['doctors_name']) ? $patientDetails['doctors_name'] : $default_doctor_name;
        $doctor_license = !empty($patientDetails['LicenseNo']) ? $patientDetails['LicenseNo'] : $default_license_no;

        // Generate PDF with TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Lutayan Rural Health Unit');
        $pdf->SetTitle('Medical Certificate');
        $pdf->SetSubject('Medical Certificate for ' . $patient_name);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Path to the logo image
        $logoPath = __DIR__ . '/logo/1.png'; // Absolute path

        // Add content
        $html = '
          <div style="display: flex; justify-content: space-between; margin: 10px;">
                <div style="text-align: right; flex: 1;">
                    <label>LUTAYAN RURAL HEALTH UNIT</label><br>
                    <label>Brgy. Tamnag Lutayan, Sultan Kudarat</label><br>
                    <label>Email: lutayan_rhu@yahoo.com.ph</label><br>
                    <label>Telefax No.: (083) 228-1528</label><br>
                </div>
            </div>
            <div class="logo">
                <img src="' . $logoPath . '" alt="Logo" style="vertical-align: middle; height: 50px; margin-right: 10px;">
            </div>
            <hr >
            <h4 >Office of the Municipal Health Officer</h4>
            <hr />
            <div class="content" style="margin-left: 1rem;">
                <h2 class="underline" style="text-align: center;"><strong>MEDICAL CERTIFICATE</strong></h2>
                <p style="text-align: right;">Date: <span class="underline">' . $exam_date . '</span></p><br>
                <p>To whom it may concern:</p>
                <p style="margin-left: 5rem;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that Mr./Ms./Mrs.  <b>' . $patient_name . '  </b>&nbsp;&nbsp;&nbsp; Age <b>' . $patient_age . '</b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; Sex <b>' . $patient_sex . '</b>
                 of ' . $patient_add . ' was seen and examined on ' . $exam_date . '            
                 </p>
                <p>DIAGNOSIS: <span class="bold underline" style="text-transform: uppercase;"><b><u>' . ucwords($diagnosis) . '</u></b></span></p>
                <p>Recommendations: <span class="bold underline" style="text-transform: uppercase;"><b><u>' . $recommendations . '</u></b></span></p><br />
                <p style="margin-left: 5rem;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certification is being issued upon the request of the above-named individual for whatever purpose may serve (excluding legal matters)</p>
            </div>
            <div class="footer" style="text-align: right;">
                <p>Respectfully yours,</p>
                <br><br>
                <label><span class="bold underline"><b>' . $doctor_name . '</b></span></label><br>
                <label>Municipal Health Officer</label><br>
                <label>License No.: ' . $doctor_license . '</label>
            </div>
        ';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Set filename and save the PDF
        $filename = $patientID . '_' . $exam_date . '.pdf';
        $filePath = __DIR__ . '/certificates/' . $filename; // Absolute path

  
        $pdf->Output($filePath, 'F'); // 'F' for file saving

       
        $query = "
       
           update tbl_certificate_log SET file_path = :filePath WHERE patient_id = :patientID";
     
        $stmt = $con->prepare($query);
        $stmt->bindParam(':patientID', $patientID, PDO::PARAM_INT);
        $stmt->bindParam(':filePath', $filePath, PDO::PARAM_STR);

        if ($stmt->execute()) {
           
            $_SESSION['status'] = "Certificate successfully generated and saved.";
            $_SESSION['status_code'] = "success";
            header('location: med_cert.php');
            exit();
        } else {
           
            $_SESSION['status'] = "Error updating certificate record.";
            $_SESSION['status_code'] = "error";
            header('location: med_cert.php');
        }
    } else {
        echo "No patient details found.";
    }
} else {
    echo "No patient ID provided.";
}
ob_flush();
