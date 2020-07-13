<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		header('location: categories.php');
	}

	if (isset($_POST['category_edit_form'])) {
		$category_name = mysqli_real_escape_string($connection, $_POST['category_name']);
		$sql = "UPDATE category SET name='$category_name' WHERE id=$id";
		$result = mysqli_query($connection, $sql);
		if ($result) {
			$success_msg = "Category updated";
		} else {
			$err_msg = "Failed update category";
		}
	}

	$sql = "SELECT * FROM category WHERE id=$id";
	$result = mysqli_query($connection, $sql);
	$row = mysqli_fetch_assoc($result);
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
						<input class="form-control" type="text" name="category_name" value="<?php echo $row['name']; ?>" placeholder="Category name">
					</div>
					<button type="submit" name="category_edit_form" class="btn btn-default">Submit</button>
				</form>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>