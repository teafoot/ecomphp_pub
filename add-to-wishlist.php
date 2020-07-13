<?php
	session_start();
	
	require_once 'config/connect.php';
	
	if (!isset($_SESSION['customer_email'])) {
		header('location: login.php');
	}

	if (isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])) {
		$user_id = $_SESSION['customer_id'];
 	} else {
 		$user_id = 0;
 	}

	if (isset($_GET['id']) & is_numeric($_GET['id'])) {
		$id = $_GET['id'];
		$sql_wishlist = "INSERT INTO wishlist (pid, uid) VALUES ($id, $user_id)";
		$result_wishlist = mysqli_query($connection, $sql_wishlist);
	}

	header('location: wishlist.php');
	
?>