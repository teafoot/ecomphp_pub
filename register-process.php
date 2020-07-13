<?php
	session_start();
	require_once 'config/connect.php'; 

	if (isset($_POST['register_form'])) {
		if (!empty($_POST['email']) && !empty($_POST['password1'] && !empty($_POST['password2']))) {
			if ($_POST['password1'] != $_POST['password2']) {
				header("location: login.php?register_err_msg=2");
				exit;
			}

			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$password = password_hash($_POST['password1'], PASSWORD_DEFAULT);

			$sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
			$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));

			if ($result) {
				$_SESSION['customer_email'] = $email;
				$_SESSION['customer_id'] = mysqli_insert_id($connection);
				header("location: checkout.php");
			} else {
				unset($_SESSION['customer_email']);
				header("location: login.php?register_err_msg=3");
			}
		} else {
			header("location: login.php?register_err_msg=1");
		}
	}

?>