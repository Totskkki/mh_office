<?php
include './config/connection.php';
if (isset($_GET['id'])) {
    $vaccinationId = $_GET['id'];
?>
    <a href="../animal_bite.php" class="btn btn-primary">Back</a>
    <a href="controller/patient_vaccinecard.php?id=<?php echo $vaccinationId; ?>" class="btn btn-secondary">Generate PDF</a>
<?php
} else {
    echo "Invalid request!";
}
?>
