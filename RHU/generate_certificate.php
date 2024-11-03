<?php

include("../tcpdf/tcpdf.php");
include '../config/connection.php';

// Function to fetch medical certificate details by ID
function getMedicalCertificateDetailsById($certId)
{
    global $con;
    try {
        $certId = (int)$certId; // Ensure $certId is an integer

        if (!($con instanceof PDO)) {
            // Handle the case where $con is not a PDO connection
            return null;
        }

        $query = "SELECT m.*,p.*,d.* ,p.patient_name,m.address
                  FROM med_cert_info m, patients p ,doctor d
                  WHERE m.id = :certId and m.doctor = d.id and m.patient_id = p.id"; 

        $statement = $con->prepare($query);
        $statement->bindValue(':certId', $certId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching medical certificate details: " . $e->getMessage());
        echo "Error fetching medical certificate details: " . $e->getMessage();
        return null;
    }
}



// Fetch medical certificate details
if (isset($_GET['id'])) {
    $certId = $_GET['id'];
    $certDetails = getMedicalCertificateDetailsById($certId);

    if ($certDetails !== null && is_array($certDetails)) {

        // Debugging statements
        echo "Action: " . $_GET['ACTION'] . "<br>";
        echo "Cert Details: ";
        var_dump($certDetails);
        // Create a PDF document


        $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
        $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont('helvetica');
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->AddPage(); //default A4


        $pdf->WriteHTML('
    <style type="text/css">
        body {
            font-size: 12px;
            line-height: 20px;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #000;
        }
        table {
            width: 100%;
            border: 1px solid #ddc;
        }
        .heading {
            
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .hr{
            margin-bottom: 0px;

        }
    </style>
');

        // Add content

        $pdf->WriteHTML('
    <table cellpadding="0" cellspacing="0">
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2" align="right"><b>LUTAYAN RURAL HEALTH UNIT</b></td></tr>
        <tr><td colspan="2" align="right"><b>Brgy. Tamnag, Lutayan, Sultan Kudarat</b></td></tr>
        <tr><td colspan="2" align="right"> <b>Email: lutayan_rhu@yahoo.com.ph</b></td></tr>
        <tr><td colspan="2" align="right"> <b>Telefax No.: (083) 228-1528</b></td>
        </tr>
        <tr>
        <td >
        <img src="./logo/1.png" alt="Logo" style="vertical-align: middle; height: 40px; margin-right: 10px;">
            </td>
        </tr>

        <tr><td colspan="2" >____________________________________________________________________________</td></tr>
        <tr><td colspan="2" align="left"><b>Office of the Municipal Health Officer</b></td></tr>
        <tr><td colspan="2" >____________________________________________________________________________</td></tr>
        <tr><td >&nbsp;</td></tr>
        <tr><td >&nbsp;</td></tr>
          <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
        <td colspan="2" align="center" style="font-size: 20px;"><b>MEDICAL CERTIFICATE</b></td>
      </tr>
      
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2"align="right"><b>Date:<u>' . $certDetails['date_examined']  . ' </u></b></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2"><b>To whom it may concern:</b></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
    

                <tr>
                    <td colspan="2">This is to certify that Mr./Ms./Mrs. <u>' . $certDetails['patient_name'] . '</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Age&nbsp;<u>' . $certDetails['age'] . '</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Sex&nbsp;<u>' . $certDetails['gender'] . '</u></td>
                </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">of&nbsp;&nbsp;<u>' . $certDetails['address'] . '</u> was seen and examined on &nbsp;&nbsp;<u>' . $certDetails['date_examined'] . '</u></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DIAGNOSIS: <u>' . $certDetails['diagnostic'] . '</u></b></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
       
      
        <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<b>Recommendations:&nbsp;&nbsp;<u>' . $certDetails['recom'] . '</u></b></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certification is being issued upon the request of the above-named individual for whatever purpose it may serve (excluding legal matters).</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2" align="right"><b>Respectfully yours,</b></td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td colspan="2" align="right"><b>' . $certDetails['Name'] . '&nbsp;&nbsp;' . $certDetails['specialty'] . '</b></td></tr>
        <tr><td colspan="2" align="right"><b>Municipal Health Officer</b></td></tr>
        <tr><td colspan="2" align="right"><b>License No.: ' . $certDetails['License_no'] . '</b></td></tr>
    </table>
');


        // $file_location = "/home/fbi1glfa0j7p/public_html/examples/generate_pdf/uploads/"; //add your full path of your server
        $file_location = "/xampp/htdocs/MH_Office/uploads/"; //for local xampp server

        $datetime = date('dmY_hms');
        $file_name = "MED_CERT_" . $datetime . ".pdf";

        ob_end_clean();
        if ($_GET['ACTION'] == 'VIEW') {
            $pdf->Output($file_name, 'I'); // I means Inline view
        } elseif ($_GET['ACTION'] == 'DOWNLOAD') {
            $pdf->Output($file_name, 'D'); // D means download
        } elseif ($_GET['ACTION'] == 'UPLOAD') {
            $pdf->Output($file_location . $file_name, 'F'); // F means upload PDF file on some folder

            // Optionally, you can redirect to a page with a success message
            header("Location: congratulation.php?goto_page=medical_certificates.php&message=File uploaded successfully!");
            exit;
        } else {
            // Handle the case where the file upload failed
            header("Location: error.php");
            exit;
        }


        //----- End Code for generate pdf
    } else {
        echo 'Record not found for PDF.';
    }
}
