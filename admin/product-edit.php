<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		header('location: products.php');
	}

	if (isset($_POST['product_edit_form'])) {
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
		} else {
			$product_image_upload_location = '';
		}

		$sql = "UPDATE products SET name='$product_name', description='$product_description', catid='$product_category', price='$product_price'";
		if (isset($product_image_upload_location) && $product_image_upload_location != '') {
			$sql .= ", thumb='$product_image_upload_location'";
		}
		$sql .=  " WHERE id=$id";
		$result = mysqli_query($connection, $sql);
		if ($result) {
			$success_msg .= "Product updated";
		} else {
			$err_msg .= "Failed update product";
		}
	}

	$sql_product = "SELECT * FROM products WHERE id=$id";
	$result_product = mysqli_query($connection, $sql_product);
	$row_product = mysqli_fetch_assoc($result_product);

?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>
	
	<div class="close-btn fa fa-times"></div>

	<section id="content">
		<div class="content-blog">
			<div class="container">
				<?php if (isset($err_msg) && $err_msg != '') { ?>
					<div class="alert alert-danger" role="alert"><?php echo $err_msg; ?></div>
				<?php } ?>
				<?php if (isset($success_msg) && $success_msg != '') { ?>
					<div class="alert alert-success" role="alert"><?php echo $success_msg; ?></div>
				<?php } ?>
				<form method="post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="">Product Name</label>
				    <input type="text" class="form-control" name="product_name" value="<?php echo $row_product['name']; ?>" placeholder="Product Name">
				  </div>
				  <div class="form-group">
				    <label for="">Product Description</label>
				    <textarea class="form-control" name="product_description" rows="3"><?php echo $row_product['description']; ?></textarea>
				  </div>
				  <div class="form-group">
				    <label for="">Product Category</label>
				    <select class="form-control" name="product_category">
						  <option value="">---SELECT CATEGORY---</option>
						  <?php 	
								$sql_category = "SELECT * FROM category";
								$result_category = mysqli_query($connection, $sql_category); 
								while ($row_category = mysqli_fetch_assoc($result_category)) {
							?>
								<option value="<?php echo $row_category['id']; ?>" <?php if ($row_category['id'] == $row_product['catid']) {echo 'selected';} ?>><?php echo $row_category['name']; ?></option>
						<?php } ?>
						</select>
				  </div>
				  <div class="form-group">
				    <label for="">Product Price</label>
				    <input type="text" class="form-control" name="product_price" value="<?php echo $row_product['price']; ?>" placeholder="Product Price">
				  </div>
				  <div class="form-group">
				    <label for="">Product Image</label>
				  	<?php if ($row_product['thumb'] != '') { ?>
				  		<br><img src="<?php echo $row_product['thumb']; ?>" width="100px" height="100px">
				  		<a href="product-image-delete.php?id=<?php echo $row_product['id']; ?>">Delete Image</a>
				  	<?php } else { ?>
					    <input type="file" name="product_image">
					    <p class="help-block">Only jpg/png are allowed.</p>
					  <?php } ?>
				  </div>
				  <button type="submit" class="btn btn-default" name="product_edit_form">Submit</button>
				</form>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>