<?php
	include '../config/connection.php';



$data = json_decode(file_get_contents("php://input"), true);

$userID = $data['userID'];
$status = $data['status'];


$query = "UPDATE `tbl_medicines` SET `status` = :status WHERE `medicineID` = :medicineID";
$stmt = $con->prepare($query);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':medicineID', $userID);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
}
?>
