<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_POST['product_add_form'])) {
		$success_msg = "";
		$err_msg = "";

		$product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
		$product_description = mysqli_real_escape_string($connection, $_POST['product_description']);
		$product_category = mysqli_real_escape_string($connection, $_POST['product_category']);
		$product_price = mysqli_real_escape_string($connection, $_POST['product_price']);

		if (isset($_FILES['product_image'])) {
			$file_name = $_FILES['product_image']['name'];
			$file_tmp_name = $_FILES['product_image']['tmp_name'];
			$file_type = $_FILES['product_image']['type'];
			$file_size = $_FILES['product_image']['size'];

			$max_file_size = 1000000; // Bytes
			$file_extension = substr($file_name, strpos($file_name, ".") + 1);

			if (isset($file_name) && $file_name != '') {
				if (($file_extension == "jpg" || $file_extension == "jpeg") && $file_type == "image/jpeg" && $file_size <= $max_file_size) {
					$product_image_upload_location = "uploads/" . $file_name;
					if (move_uploaded_file($file_tmp_name, $product_image_upload_location)) {
						$success_msg .= "Image uploaded successfully<br>";
					} else {
						$err_msg .= "Image failed to upload<br>";
					}
				} else {
					$err_msg .= "Only JPG/JPEG files are allowed to be uploaded with less than 1MB of size<br>";
				}
			} else {
				$err_msg .= "Please upload an image<br>";
			}
		}

		if (isset($product_image_upload_location) && $product_image_upload_location != '') {
			$sql = "INSERT INTO products (name, description, catid, price, thumb) VALUES ('$product_name', '$product_description', '$product_category', '$product_price', '$product_image_upload_location')";
		} else {
			$sql = "INSERT INTO products (name, description, catid, price) VALUES ('$product_name', '$product_description', '$product_category', '$product_price')";
		}
		$result = mysqli_query($connection, $sql);
		if ($result) {
			$success_msg .= "Product added<br>";
		} else {
			$err_msg .= "Failed add product<br>";
		}
	}

?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>
	
	<div class="close-btn fa fa-times"></div>

	<section id="content">
		<div class="content-blog">
			<div class="container">
				<?php if (isset($err_msg) && $err_msg != "") { ?>
					<div class="alert alert-danger" role="alert"><?php echo $err_msg; ?></div>
				<?php } ?>
				<?php if (isset($success_msg)  && $success_msg != "") { ?>
					<div class="alert alert-success" role="alert"><?php echo $success_msg; ?></div>
				<?php } ?>
				<form method="post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="">Product Name</label>
				    <input type="text" class="form-control" name="product_name" placeholder="Product Name">
				  </div>
				  <div class="form-group">
				    <label for="">Product Description</label>
				    <textarea class="form-control" name="product_description" rows="3"></textarea>
				  </div>
				  <div class="form-group">
				    <label for="">Product Category</label>
				    <select class="form-control" name="product_category">
						  <option value="">---SELECT CATEGORY---</option>
						  <?php 	
								$sql = "SELECT * FROM category";
								$result = mysqli_query($connection, $sql); 
								while ($row = mysqli_fetch_assoc($result)) {
							?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
							<?php } ?>
						</select>
				  </div>
				  <div class="form-group">
				    <label for="">Product Price</label>
				    <input type="text" class="form-control" name="product_price" placeholder="Product Price">
				  </div>
				  <div class="form-group">
				    <label for="">Product Image</label>
				    <input type="file" name="product_image">
				    <p class="help-block">Only jpg/png are allowed.</p>
				  </div>
				  <button type="submit" class="btn btn-default" name="product_add_form">Submit</button>
				</form>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>