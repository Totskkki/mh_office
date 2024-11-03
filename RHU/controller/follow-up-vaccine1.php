<?php
require_once('../tcpdf/tcpdf.php');
include '../config/connection.php';
ob_start();


// Check if the vaccination ID is set
if (isset($_GET['id'])) {
    $vaccinationId = $_GET['id'];


    $query = "SELECT av.*, p.*, ad.*, ab.*, av.remarks,
    CONCAT(p.patient_name, ' ', p.middle_name, ' ', p.last_name, ' ', p.suffix) AS name,
    CONCAT(ad.brgy, ' ', ad.city_municipality, ' ', ad.province) AS address
    FROM tbl_animal_bite_vaccination av
    LEFT JOIN tbl_patients p ON p.patientID = av.patient_id
    LEFT JOIN tbl_familyaddress ad ON ad.famID = p.family_address
    LEFT JOIN tbl_animal_bite_care ab ON ab.animal_biteID = av.bite_status  
    WHERE av.patient_id = (
        SELECT patient_id FROM tbl_animal_bite_vaccination 
        WHERE animal_bite_vacID = :vaccination_id
    ) 
    AND (ab.bite_status = 'ongoing' OR ab.bite_status = 'done')
    AND av.animal_bite_vacID IN (
        SELECT MAX(animal_bite_vacID) 
        FROM tbl_animal_bite_vaccination 
        WHERE patient_id = av.patient_id
        GROUP BY dose_status
    )
    ORDER BY av.animal_bite_vacID ASC";




    $stmt = $con->prepare($query);
    $stmt->bindParam(':vaccination_id', $vaccinationId, PDO::PARAM_INT);
    $stmt->execute();

    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($records) {


        $patientId = $records[0]['patient_id'];

        $query2 = "SELECT remarks
                   FROM tbl_animal_bite_vaccination
                   WHERE patient_id = :patient_id
                   ORDER BY animal_bite_vacID DESC
                   LIMIT 1";
        $stmt2 = $con->prepare($query2);
        $stmt2->bindParam(':patient_id', $patientId, PDO::PARAM_INT);
        $stmt2->execute();
        $latestRemarks = $stmt2->fetchColumn();
        $latestRemarks = !empty($latestRemarks) ? $latestRemarks : '';


        // Page dimensions: 127mm x 153mm (portrait orientation)
        $pageWidth = 127;
        $pageHeight = 160;

        // Create a new PDF document with custom page size and portrait orientation
        $pdf = new TCPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Joven Rey Flores');
        // $pdf->SetTitle('ANIMAL BITE VACCINE FORM');

        $status = $records[0]['bite_status'];
        $pdfTitle = ($status == 'done') ? 'Final Animal Bite Vaccine Form' : 'Follow-Up Animal Bite Vaccine Form';
        $pdf->SetTitle($pdfTitle);

        $pdf->SetSubject('ANIMAL BITE VACCINE FORM REPORT');

        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 8);

        $logoPath = '../../logo/animalbite.png';

        if (isset($records[0]['Type_bite']) && !empty($records[0]['Type_bite'])) {
            $typeBiteData = json_decode($records[0]['Type_bite'], true);
        } else {
            $typeBiteData = [];
        }

        $typeToShow = in_array('Bite', $typeBiteData) ? 'Bite' : (in_array('Non-bite', $typeBiteData) ? 'Non-bite' : 'Not Specified');

        // Generate HTML content for the PDF
        $html = '
        <table border="1" cellpadding="4" cellspacing="0">
            <tr>
                <td colspan="2">
                    <img src="' . $logoPath . '" width="200px" height="50px"> 
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Registration No.:</b> ' . $records[0]['reg_no'] . ' &nbsp; &nbsp; &nbsp; <span><b>Date:</b> ' . $records[0]['date'] . '</span></td>
            </tr>
            <tr>
                <td><b>Name:</b> ' . strtoupper($records[0]['name']) . '</td>
                <td><b>Age:</b> ' . $records[0]['age'] . '</td>
            </tr>
            <tr>
                <td><b>Address:</b> ' . strtoupper($records[0]['address']) . '</td>
                <td><b>Sex:</b> ' . $records[0]['gender'] . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>History of Exposure</b></td>
            </tr>
            <tr>
                <td colspan="2">
                    <ul>
                        <li><b>Date:</b> ' . $records[0]['date_bite'] . '</li>
                        <li><b>Place:</b> ' . $records[0]['Place'] . '</li>
                        <li><b>Type:</b> ' . $typeToShow . ' <b>Source:</b> ' . $records[0]['animal_type'] . '</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="2"><b>Category of Exposure:</b> <u>' . $records[0]['category_exposure'] . '</u> &nbsp; <span><b>PEP:</b>______________</span></td>
            </tr>
            <tr>
                <td colspan="2"><b>Washing of Bite Wound:</b> ' . $records[0]['washed'] . '</td>
            </tr>
            <tr>
                <td colspan="2"><b>RIG:</b>____________ </td>
            </tr>
            <tr>
                <td colspan="2"><b>Anti-Rabies Vaccine:</b>_______________<span>Route____________</span></td>
            </tr>';


        // Prepare the HTML for the vaccination records
        $query3 = "SELECT av.* 
FROM tbl_animal_bite_vaccination av 
JOIN tbl_animal_bite_care ab ON ab.animal_biteID = av.bite_status
WHERE av.patient_id = :patient_id 
AND (ab.bite_status = 'ongoing' OR ab.bite_status = 'done') 
ORDER BY av.dose_status ASC";
        $stmt3 = $con->prepare($query3);
        $stmt3->bindParam(':patient_id', $patientId, PDO::PARAM_INT);
        $stmt3->execute();
        $vaccinationRecords = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the HTML for the vaccination records
        $html .= '<tr><td colspan="2"><b>Vaccination Records:</b></td></tr><tr><td colspan="2"><ul>';

        foreach ($vaccinationRecords as $vaccination) {
            switch ($vaccination['dose_status']) {
                case 1:
                    $doseLabel = 'D0';
                    break;
                case 2:
                    $doseLabel = 'D3';
                    break;
                case 3:
                    $doseLabel = 'D7';
                    break;
                case 4:
                    $doseLabel = 'D14(IM)';
                    break;
                case 5:
                    $doseLabel = 'D28/30';
                    break;
                default:
                    // $doseLabel = 'Unknown Dose';
                    // break;
                    continue;
            }

            // Display the vaccination date
            $html .= '<li><b>' . $doseLabel . ':</b> ' . date("Y-m-d", strtotime($vaccination['vaccination_date'])) . '</li>';
        }
        $html .= '</ul></td></tr>';


        $html .= '
            <tr>
                <td colspan="2"><b>Status of animal 14 days after exposure:</b> ' . $records[0]['animal_status'] . '</td>
            </tr>
            <tr>
              <td colspan="2"><b>Remarks:</b> ' . $latestRemarks . '</td>
            </tr>
        </table>';


        $pdf->writeHTML($html, true, false, true, false, '');
        $patientName = strtoupper($records[0]['name']); // Retrieve and format the patient's name
        $vaccinationDate = date('Y-m-d', strtotime($records[0]['vaccination_date'])); // Format the vaccination date

        $filename = '' . str_replace(' ', '_', $patientName) . '_' . $vaccinationDate . '.pdf';
        $pdf->Output($filename, 'I');
    } else {
        echo "No records found!";
    }
} else {
    echo "Invalid request!";
}
ob_end_flush();
