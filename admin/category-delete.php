<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
		$sql = "DELETE FROM category WHERE id=$id";
		if (mysqli_query($connection, $sql)) {
			header('location: categories.php');
		}
	} else {
		header('location: categories.php');
	}

?>