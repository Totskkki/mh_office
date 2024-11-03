<?php 

error_reporting(0);

if (isset($_POST['save_meds'])) {
    echo "Form submitted";

    $med_name =  trim($_POST['med_name']);
    $med_name =  ucwords(strtolower($med_name));

    $description =  trim($_POST['description']);
    $description =  ucwords(strtolower($description));

    $Category =  trim($_POST['Category']);
    $Category =  ucwords(strtolower($Category));

    $supplier =  trim($_POST['supplier']);
    $supplier =  ucwords(strtolower($supplier));
    $manufacturer =  trim($_POST['manufacturer']);
    $Brand =  trim($_POST['Brand']);

    $man_date = trim($_POST['man_date']);
    $dateArr = explode("/", $man_date);
    $man_date = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];

    $exp_date = trim($_POST['exp_date']);
    $dateArr = explode("/", $exp_date);
    $exp_date = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];
  


    if ($med_name != '' && $man_date != '' && $exp_date != ''&&  $supplier != '' && $Brand != '' && $Category != '' && $description != '')  {
        $query_check_duplicate = "SELECT COUNT(*) FROM tbl_medicines WHERE medicine_name = '$med_name'";
        $stmt_check_duplicate = $con->prepare($query_check_duplicate);
        $stmt_check_duplicate->execute();

        if ($stmt_check_duplicate->fetchColumn() > 0) {
            $_SESSION['status'] = "Medicine name already used.";
            $_SESSION['status_code'] = "error";
        } else {

            $data = [
                'medicine_name' => $med_name,
                'description' => $description,
                'supplier' => $supplier,
                'category' => $Category,
                'manuf_date' => $man_date,
                'ex_date' => $exp_date,
                'manufacturer' => $manufacturer,
                'brand' => $Brand
            ];

            $result = insert('tbl_medicines', $data, $con);

            if ($result) {
                $_SESSION['status'] = "Medicine successfully added.";
                $_SESSION['status_code'] = "success";
                ?>
        <script>
            window.location.href = 'medicine.php';
        </script>
<?php
        exit();
        
            
            } else {
                $_SESSION['status'] = "Something went wrong while adding medicine.";
                $_SESSION['status_code'] = "error";
                ?>
                <script>
                    window.location.href = 'medicine.php';
                </script>
        <?php
                exit();
            }
        
    }}
}

?>