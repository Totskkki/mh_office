<?php
include '../config/connection.php';

if (isset($_POST['labId'])) {
    $id = $_POST['labId']; // Fetch lab ID from POST request
    try {
        // Ensure your $con connection is valid here
        $query = "SELECT * FROM tbl_laboratory WHERE labid  = :labId";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':labId', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        } else {
            echo json_encode(false); // No records found
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
} else {
    echo json_encode(false); // No lab ID received
    exit;
}

?>