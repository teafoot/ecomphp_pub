<?php
	session_start();
	unset($_SESSION['customer_email']);
	unset($_SESSION['customer_id']);
	unset($_SESSION['cart']);
	header('location: login.php');
?>