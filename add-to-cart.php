<?php
	session_start();

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
		
		if (isset($_GET['quantity']) && is_numeric($_GET['quantity'])) {
			$quantity = $_GET['quantity']; 
		} else { 
			$quantity = 1;
		}

		$_SESSION['cart'][$id] = array("quantity" => $quantity);
	}

	header('location: cart.php');
?>