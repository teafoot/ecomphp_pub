<?php
	session_start();

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
		unset($_SESSION['cart'][$id]);
	}

	header('location: cart.php');
?>