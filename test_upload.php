<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = __DIR__ . '/user_images/';
    $fileName = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFilePath)) {
        die('File upload failed.');
    }
    echo 'File uploaded to: ' . $uploadFilePath;
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_picture">
    <button type="submit">Upload</button>
</form>
