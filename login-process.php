<?php
	session_start();
	require_once 'config/connect.php'; 

	if (isset($_POST['login_form'])) {
		if (!empty($_POST['email']) && !empty($_POST['password'])) {
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$password = mysqli_real_escape_string($connection, $_POST['password']);

			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
			$count = mysqli_num_rows($result);
			$row = mysqli_fetch_assoc($result);

			if ($count == 1 && password_verify($password, $row['password'])) {
				$_SESSION['customer_email'] = $email;
				$_SESSION['customer_id'] = $row['id'];
				header("location: checkout.php");
			} else {
				unset($_SESSION['customer_email']);
				header("location: login.php?login_err_msg=2");
			}
		} else {
			header("location: login.php?login_err_msg=1");
		}
	}

?>