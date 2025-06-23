<?php
function syncAllTables($batchSize = 100) {
    try {
        // Local database connection
        $localDB = new PDO('mysql:host=localhost;port=3306;dbname=mh_office', 'root', ''); // Local server settings

        // Remote database connection (update the credentials as needed)
        $remoteDB = new PDO('mysql:host=localhost;dbname=u926430213_mh_office', 'u926430213_totski', 'Joven261993@'); // Remote server settings

        // Set error mode to exception for better error handling
        $localDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $remoteDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve the list of tables from the local database
        $tablesQuery = $localDB->query("SHOW TABLES");
        $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $offset = 0;
            $hasDataToSync = true;

            while ($hasDataToSync) {
                // Fetch unsynced data in batches
                $query = $localDB->prepare("SELECT * FROM `$table` WHERE sync_status = 0 LIMIT :batchSize OFFSET :offset");
                $query->bindValue(':batchSize', $batchSize, PDO::PARAM_INT);
                $query->bindValue(':offset', $offset, PDO::PARAM_INT);
                $query->execute();

                $dataToSync = $query->fetchAll(PDO::FETCH_ASSOC);

                // If there's no more data, stop the loop for this table
                if (empty($dataToSync)) {
                    $hasDataToSync = false;
                    continue;
                }

                // Get the primary key column name for the table
                $primaryKeyQuery = $localDB->prepare("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
                $primaryKeyQuery->execute();
                $primaryKeyResult = $primaryKeyQuery->fetch(PDO::FETCH_ASSOC);
                $primaryKey = $primaryKeyResult['Column_name']; // Get the primary key column name

                foreach ($dataToSync as $row) {
                    // Create a dynamic SQL statement for the remote insertion
                    $columns = implode(", ", array_keys($row));
                    $placeholders = implode(", ", array_fill(0, count($row), '?'));

                    // Prepare the insert/update statement for the remote database
                    $stmt = $remoteDB->prepare("REPLACE INTO `$table` ($columns) VALUES ($placeholders)");

                    // Execute the statement and handle any issues
                    $stmt->execute(array_values($row));

                    // Update sync_status to 1 in the local database after a successful sync
                    $updateStmt = $localDB->prepare("UPDATE `$table` SET sync_status = 1 WHERE `$primaryKey` = ?");
                    $updateStmt->execute([$row[$primaryKey]]);
                }

                // Move to the next batch
                $offset += $batchSize;
            }
        }

        echo "All tables synchronized successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Call the function to initiate synchronization
syncAllTables(100); // You can change the batch size as needed
?>
