<?php
include './config/connection.php';

include './common_service/common_functions.php';



if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "SELECT 
                    user.*,personnel.*,position.*,
                    p.home_img,
                    p.sidebar
                FROM 
                    tbl_users AS user
					INNER JOIN 
                    tbl_personnel AS personnel ON user.personnel_id = personnel.personnel_id
					INNER JOIN 
                    tbl_position AS position ON user.position_id = position.position_id
					INNER JOIN tbl_user_page AS p ON user.userpageID = p.userID 
                WHERE 
                    user.userID = :id";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // var_dump($user);
    // var_dump($user['sidebar']);

}

?>
<meta charset="UTF-8">

<?php if (isset($user)) :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <div class="mb-3">
            <label for="sidebar_text" class="form-label">Sidebar Text</label>
            <input type="text" class="form-control form-control-sm" id="sidebar_text" name="sidebar_text" value="<?php echo trim($user['sidebar']); ?>">


        </div>
    <?php else : ?>
        <p>No user details found.</p>
    <?php endif; ?>
    </body>

    </html>
    <html>