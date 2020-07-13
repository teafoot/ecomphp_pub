<?php
	session_start();

	require_once 'config/connect.php';

	if (!isset($_SESSION['customer_email'])) {
		header('location: login.php');
	}

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
		$sql_wishlist = "DELETE FROM wishlist WHERE id=$id";
		$result_wishlist = mysqli_query($connection, $sql_wishlist);
	}

	header('location: wishlist.php');
?>