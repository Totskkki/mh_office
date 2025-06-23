<?php
header("Content-Type: application/json");

// Check if data was sent via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decode the received JSON data
    $inputData = json_decode(file_get_contents("php://input"), true);

    if ($inputData && isset($inputData['table']) && isset($inputData['data'])) {
        $table = $inputData['table'];
        $data = $inputData['data'];

        try {
            // Connect to the remote MySQL database
            $remoteDB = new PDO('mysql:host=localhost;dbname=u926430213_mh_office', 'u926430213_totski', 'Joven261993@');
            $remoteDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach ($data as $row) {
                // Prepare a dynamic SQL query for insertion/update
                $columns = implode(", ", array_keys($row));
                $placeholders = implode(", ", array_fill(0, count($row), '?'));

                // Use REPLACE INTO to update or insert data
                $stmt = $remoteDB->prepare("REPLACE INTO `$table` ($columns) VALUES ($placeholders)");
                $stmt->execute(array_values($row));
            }

            echo json_encode(["status" => "success", "message" => "Data synced successfully"]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
