<?php 
	include 'config/connection.php';

  	$gotoPage = $_GET['goto_page'];

    $message = $_GET['message'];
     	echo $message;
  	header("Location:$gotoPage?message=$message");

?>
