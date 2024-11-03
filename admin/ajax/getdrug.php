<?php 
include '../config/connection.php';
include '../common_service/common_functions.php';
$optionsFromFunction = getdrugs();


$query = "SELECT DISTINCT category FROM tbl_medicines";

try {

    $stmt = $con->prepare($query);
    $stmt->execute();

  
    $optionsFromDatabase = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $optionsFromDatabase .= "<option value='{$row['category']}'>{$row['category']}</option>";
    }

   
    $combinedOptions = $optionsFromFunction . $optionsFromDatabase;

   
    echo $combinedOptions;
} catch (PDOException $e) {
   
    echo "Error fetching categories: " . $e->getMessage();
}

// $query = "SELECT DISTINCT category FROM tbl_medicines";
// $stmt = $pdo->query($query);
// $options = '';

// // Fetch the current category from the request
// $currentCategory = isset($_POST['category']) ? $_POST['category'] : '';

// // Generate HTML options for the dropdown
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $category = $row['category'];
//     $selected = ($category == $currentCategory) ? 'selected="selected"' : '';
//     $options .= "<option value='{$category}' {$selected}>{$category}</option>";
// }


// echo $options;

?>