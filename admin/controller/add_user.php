<?php
if (isset($_POST['save_user'])) {

    // var_dump($_POST);
    $fname = trim($_POST['fname']);
    $fname = ucwords(strtolower($fname));

    $mname = trim($_POST['mname']);
    $mname = ucwords(strtolower($mname));

    $uname = trim($_POST['uname']);

    $lname = trim($_POST['lname']);
    $lname = ucwords(strtolower($lname));
   
    $Address = trim($_POST['Address']);
    $Address = ucwords(strtolower($Address));
    $pass = trim($_POST['pass']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $Role = trim($_POST['Role']);
    $status = 'active';
    $finalimage = $_FILES['profile']['name'];
    if (!empty($finalimage)) {
        move_uploaded_file($_FILES['profile']['tmp_name'], '../user_images/' . $finalimage);
    }


    if ($fname != '' && $uname != '' && $pass != '' && $contact != '' && $email != '' && $Role != '') {

        $stmtCheck = $con->prepare("
        SELECT COUNT(*) AS num 
        FROM tbl_users AS u
        JOIN tbl_personnel AS p ON u.personnel_id = p.personnel_id
        WHERE u.user_name = :uname OR p.email = :email or p.first_name = :fname or p.lastname = :lname
    ");
        $stmtCheck->execute(['uname' => $uname, 'email' => $email, 'fname' => $fname, 'lname' => $lname]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['num'] > 0) {
            $_SESSION['status'] = "Username or Email already used by another user.";
            $_SESSION['status_code'] = "error";
            ?>
            <script>
                window.location.href = 'user.php';
            </script>
    <?php
            exit();
        }

        // Hash the password
        $bcrypt_password = password_hash($pass, PASSWORD_BCRYPT);


        $con->beginTransaction();
        try {

            $stmtPersonnel = $con->prepare("INSERT INTO tbl_personnel (first_name, middlename, lastname,contact, email,address) VALUES (?,?, ?, ?, ?, ?)");
            $stmtPersonnel->execute([$fname, $mname, $lname, $contact, $email, $Address]);
            $personnelId = $con->lastInsertId();


            $stmtPosition = $con->prepare("INSERT INTO tbl_position (personnel_id) VALUES (?)");
            $stmtPosition->execute([$personnelId]);
            $positionId = $con->lastInsertId();

            // Insert into tbl_users
            $stmtUsers = $con->prepare("INSERT INTO tbl_users (user_name, password, status, profile_picture, personnel_id, position_id, UserType) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtUsers->execute([$uname, $bcrypt_password, $status, $finalimage, $personnelId, $positionId, $Role]);

            $con->commit();
            $_SESSION['status'] = "User successfully added.";
            $_SESSION['status_code'] = "success";
            ?>
            <script>
                window.location.href = 'user.php';
            </script>
    <?php
            exit();
        } catch (Exception $e) {
            $con->rollBack();
            $_SESSION['status'] = "Something went wrong: " . $e->getMessage();
            $_SESSION['status_code'] = "danger";
            ?>
            <script>
                window.location.href = 'user.php';
            </script>
    <?php
            exit();
        }
    } else {
        $_SESSION['status'] = "Please fill all the required fields.";
        $_SESSION['status_code'] = "error";
        ?>
            <script>
                window.location.href = 'user.php';
            </script>
    <?php
            exit();
    }
}
?>
