<?php
include '../config/connection.php';

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    $query = "SELECT users.*, family.*, mem.* 
              FROM tbl_patients AS users 
              LEFT JOIN tbl_familyAddress AS family ON users.family_address = family.famID 
              LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info = mem.membershipID
              WHERE patient_name LIKE :searchTerm 
                 OR last_name LIKE :searchTerm 
                 OR middle_name LIKE :searchTerm";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
    $stmt->execute();

    // Output HTML for the filtered rows
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . $row['patient_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . " " . $row['suffix'] . "</td>";
        echo "<td>" . "Brgy. " . $row['brgy'] . ", Purok " . " " . $row['purok'] . ", South Cotabato" . "</td>";
        echo "<td>" . $row['formatted_birth_date'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";

        echo "<td class='text-center'>";
        echo "<a href='view_patient.php?id=" . $row['patientID'] . "' class='btn btn-info btn-sm'>";
        echo "<i class='icon-eye'></i>";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    }

    // Check if no data is found
    if ($count === 0) {
        echo "<tr>";
        echo "<td colspan='7' style='text-align:center; vertical-align:middle;'>";
        echo "<h5 style='color:gray;'>No data available</h5>";
        echo "</td>";
        echo "</tr>";
    }
}

