<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];

		$sql = "SELECT thumb FROM products WHERE id=$id";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_assoc($result);
		if ($row['thumb'] != '') {
			unlink($row['thumb']);
		}
		$sql_delete = "UPDATE products set thumb='' WHERE id=$id";
		mysqli_query($connection, $sql_delete);
	}

	header("location: product-edit.php?id={$id}");
?>