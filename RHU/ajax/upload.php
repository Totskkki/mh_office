<?php
include '../config/connection.php'; // Include your database connection file

// Check if file was uploaded without errors
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'logo/home/';
    $fileName = time() . '_' . basename($_FILES["file"]["name"]);
    $targetFile = $uploadDir . $fileName;

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Insert file path into database
        $query = "INSERT INTO `user_page`(`home_img`, `users_id`) VALUES (?, ?)";
        try {
            $con->beginTransaction();
            $stmt = $con->prepare($query);
            // Bind parameters and execute the query
            $stmt->execute([$targetFile, $_POST['hidden_id']]);
            // Commit the transaction
            $con->commit();
            echo $targetFile; // Return the file path for use in the Summernote editor
        } catch (PDOException $ex) {
            $con->rollback();
            echo 'Error inserting image into database.';
            echo $ex->getMessage();
        }
    } else {
        echo 'Error moving file to destination directory.';
    }
} else {
    echo 'Error uploading file.';
}


