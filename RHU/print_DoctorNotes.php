<?php

require_once('tcpdf/tcpdf.php');
include './config/connection.php';
ob_start();

class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Set position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        // Custom footer text
        $this->Cell(0, 10, 'RHU BIRTHING CENTER', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    $query = "SELECT p.*, p.age, v.room,
        CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name, 
        h.date, h.time, h.doctorNotes,
        CONCAT(per.first_name, ' ', per.middlename, ' ', per.lastname) AS doctor_name
        FROM tbl_healthnotes h
        LEFT JOIN tbl_users u ON u.userID = h.userID
        LEFT JOIN tbl_personnel per ON per.personnel_id = u.personnel_id
        LEFT JOIN tbl_patients p ON p.patientID = h.patient_id
        LEFT JOIN tbl_vitalsigns_monitoring v ON p.patientID = v.patient_id
        WHERE h.patient_id = :recordId 
        AND h.doctorNotes != '' 
        AND (h.nureNotes IS NULL OR h.nureNotes = '')
         GROUP BY h.date, h.time, h.doctorNotes";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':recordId', $recordId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all records
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($records) {
        $pageWidth = 216;  // 8.5 inches in mm (portrait width)
        $pageHeight = 348; // 14 inches in mm (portrait height)

        // Create a new PDF document with custom page size and portrait orientation
        $pdf = new MYPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Joven Rey Flores');
        $pdf->SetTitle('Doctor Notes');
        $pdf->SetSubject('Doctor Notes Report');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Create HTML content
        $firstRecord = $records[0]; // Get the first record

        $html = '<h2 style="text-align: center;">Doctor\'s Notes</h2>';

        $html .= '<div style="margin-bottom: 20px;">';
        $html .= '<h4>';
        $html .= '<span>Patient Name: ' . htmlspecialchars($firstRecord['name']) . '</span> ';
        $html .= '<span style="margin-left: 20px;">Age: ' . htmlspecialchars($firstRecord['age']) . '</span> ';
        $html .= '<span style="margin-left: 20px;">Room: ' . htmlspecialchars($firstRecord['room']) . '</span>';
        $html .= '</h4>';
        $html .= '</div>';

        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead>';
        $html .= '<tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th colspan="2">Doctor\'s Notes</th>
                  </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Loop through each record to generate rows
        foreach ($records as $record) {
            $html .= '<tr>
                       <td>' . date('F j, Y', strtotime($record['date'])) . '</td>
                       <td>' . date('h:i A', strtotime($record['time'])) . '</td>
                       <td colspan="2">' . nl2br(htmlspecialchars($record['doctorNotes'])) . '</td>
                     </tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('Doctor_notes.pdf', 'I');
    } else {
        echo "No doctor's notes found for this patient!";
    }
} else {
    echo "Invalid request!";
}

ob_end_flush();
