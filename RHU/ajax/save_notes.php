<?php
include '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitnursenotes'])) {
    $patientid = trim($_POST['patientid']);
    $dates = $_POST['date'];  // Array of dates
    $times = $_POST['time'];  // Array of times
    $nurseid = trim($_POST['nurseid']);
    $docnotes = $_POST['docnotes'];  // Array of notes

    // Begin transaction
    $con->beginTransaction();

    try {
        // Loop through the arrays to insert multiple rows
        for ($i = 0; $i < count($dates); $i++) {
            // Format the date to Y-m-d
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $dates[$i])));
            $time = $times[$i];
            $docnote = $docnotes[$i];

            // Prepare and execute the insert statement
            $stmt = $con->prepare("INSERT INTO `tbl_healthnotes` (`patient_id`, `userID`, `date`, `time`, `nureNotes`)
                                   VALUES (:patient_id, :userID, :date, :time, :nureNotes)");

            $stmt->execute([
                ':patient_id' => $patientid,
                ':userID' => $nurseid,
                ':date' => $date,
                ':time' => $time,
                ':nureNotes' => $docnote
            ]);
        }

        // Commit the transaction
        $con->commit();
        $_SESSION['status'] = "Nurses notes added successfully.";
        $_SESSION['status_code'] = "success";
    } catch (Exception $e) {
        // Rollback in case of error
        $con->rollBack();
        $_SESSION['status'] = "Failed to add nurse's notes: " . $e->getMessage();
        $_SESSION['status_code'] = "error";
    }

    // Redirect after processing
    header('Location: birthing_patients.php?id=' . urlencode($patientid));
    exit();
}

?>