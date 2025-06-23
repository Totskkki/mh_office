<?php
function syncAllTables($batchSize = 100) {
    try {
       
        $localDB = new PDO('mysql:host=localhost;port=3306;dbname=mh_office', 'root', ''); 
        $localDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     
        $remoteApiUrl = 'https://lutayanrhu.site/sync_api.php'; 

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

                // Send data to remote server via POST request
                $postData = [
                    'table' => $table,
                    'data' => $dataToSync
                ];

                $ch = curl_init($remoteApiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                
                $response = curl_exec($ch);

                if ($response === false) {
                    echo 'Error syncing data for table ' . $table . ': ' . curl_error($ch);
                    continue;
                }

                curl_close($ch);

                // Handle the response from the remote server (optional)
                $responseDecoded = json_decode($response, true);
                if ($responseDecoded['status'] == 'success') {
                    // Update sync_status to 1 in the local database after a successful sync
                    $updateStmt = $localDB->prepare("UPDATE `$table` SET sync_status = 1 WHERE sync_status = 0");
                    $updateStmt->execute();
                }
            }
        }

        echo "All tables synchronized successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

syncAllTables(100); 

