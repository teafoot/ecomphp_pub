<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_POST['category_add_form'])) {
		$category_name = mysqli_real_escape_string($connection, $_POST['category_name']);
		$sql = "INSERT INTO category (name) VALUES ('$category_name')";
		$result = mysqli_query($connection, $sql);
		if ($result) {
			$success_msg = "Category added";
		} else {
			$err_msg = "Failed add category";
		}
	}

?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<?php if (isset($err_msg)) { ?>
					<div class="alert alert-danger" role="alert"><?php echo $err_msg; ?></div>
				<?php } ?>
				<?php if (isset($success_msg)) { ?>
					<div class="alert alert-success" role="alert"><?php echo $success_msg; ?></div>
				<?php } ?>
				<form method="post">
					<div class="form-group">
						<label>Category Name</label>
						<input class="form-control" type="text" name="category_name" placeholder="Category name">
					</div>
					<button type="submit" name="category_add_form" class="btn btn-default">Submit</button>
				</form>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>