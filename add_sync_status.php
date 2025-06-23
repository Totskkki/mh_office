<?php
try {
    // Establish a connection to the local database
    $localDB = new PDO('mysql:host=localhost;dbname=mh_office', 'root', '');

    // Retrieve the list of tables from the local database
    $tablesQuery = $localDB->query("SHOW TABLES");
    $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

    // Iterate through each table to add the 'sync_status' column if it doesn't exist
    foreach ($tables as $table) {
        // Check if 'sync_status' column exists in the current table
        $columnCheck = $localDB->query("SHOW COLUMNS FROM `$table` LIKE 'sync_status'");
        $columnExists = $columnCheck->fetch(PDO::FETCH_ASSOC);

        // Add the column if it doesn't exist
        if (!$columnExists) {
            $alterQuery = "ALTER TABLE `$table` ADD COLUMN sync_status INT DEFAULT 0";
            $localDB->exec($alterQuery);
            echo "Added 'sync_status' column to table `$table`.\n";
        } else {
            echo "The 'sync_status' column already exists in table `$table`.\n";
        }
    }

    echo "All tables processed.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
