<?php
include '../config/connection.php';

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // Modify your SQL query to fetch filtered patient data based on the search term

    $query =  "SELECT users.*, family.brgy, family.purok, family.province, mem.* 
    FROM tbl_patients AS users 
   LEFT JOIN tbl_familyaddress AS family ON users.family_address = family.famID 
   LEFT JOIN tbl_membership_info AS mem ON users.Membership_Info  = mem.membershipID

    
          WHERE patient_name LIKE :searchTerm OR last_name LIKE :searchTerm OR middle_name LIKE :searchTerm";
    $stmt = $con->prepare($query);
    $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
    $stmt->execute();

    // Output HTML for the filtered rows
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . $row['patient_name'] . " " . $row['middle_name'] . ". " . $row['last_name'] . " " . $row['suffix'] . "</td>";
        echo "<td>" . "Brgy. " . $row['address'] . ", Purok " . " " . $row['purok'] . ", Tantangan " . ", South Cotabato " . "</td>";
        echo "<td>" . $row['formatted_birth_date'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        
        echo "<td class='text-center'>";
        echo "<a href='view_patient.php?id=" . $row['patientID'] . "' class='btn btn-success btn-sm '>";
        echo " <i class='icon-eye'></i>";
       
 
       
        echo "</td>";
        
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    if ($count === 0) {
        echo "<h4>No data available.</h4>";
    }
}
