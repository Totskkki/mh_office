<?php
include './config/connection.php';

include './common_service/common_functions.php';


?>
<?php
include './config/header.php';
?>


	<body>
		



	</div>


	
		<?php
include './config/footer.php';

$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>


<script>
    $(document).ready(function() {
        showMenuSelected("#mnu_patients", "#mi_patients");

        var message = '<?php echo $message; ?>';

        if (message !== '') {
            showCustomMessage(message);
        }

    });
</script>