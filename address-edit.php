<?php
	session_start();
	ob_start();
	
 	require_once 'config/connect.php';

 	if (!isset($_SESSION['customer_email'])) {
		header('location: login.php');
	}

	include 'inc/header.php';
 	include 'inc/nav.php';

 	if (isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])) {
		$user_id = $_SESSION['customer_id'];
 	} else {
 		$user_id = 0;
 	}

 	if (isset($_POST['address_form'])) {
		$country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
		$first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
		$last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
		$address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING);
		$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
		$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
		$zip_code = filter_var($_POST['zip_code'], FILTER_SANITIZE_STRING);
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);

		// update usermeta
		$sql_update = "UPDATE usersmeta SET country='$country', firstname='$first_name', lastname='$last_name', company='$company', address1='$address1', address2='$address2', city='$city', state='$state', zip='$zip_code', mobile='$phone' WHERE uid=$user_id";
		mysqli_query($connection, $sql_update) or die(mysqli_error($connection));

		header('location: my-account.php');
 	}

	$sql = "SELECT * FROM usersmeta WHERE uid=$user_id";
	$result = mysqli_query($connection, $sql);
	$row = mysqli_fetch_assoc($result);

?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="page_header text-center">
				<h2>Shop - Update Billing Address</h2>
				<p>Get the best kit for smooth shave</p>
			</div>
			<form method="post" action="">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="billing-details">
								<h3 class="uppercase">Update My Address</h3>
								<div class="space30"></div>
									<label class="">Country </label>
									<select class="form-control" name="country">
										<option value="">Select Country</option>
										<option value="AX">Aland Islands</option>
										<option value="AF">Afghanistan</option>
										<option value="AL">Albania</option>
										<option value="DZ">Algeria</option>
										<option value="AD">Andorra</option>
										<option value="AO">Angola</option>
										<option value="AI">Anguilla</option>
										<option value="AQ">Antarctica</option>
										<option value="AG">Antigua and Barbuda</option>
										<option value="AR">Argentina</option>
										<option value="AM">Armenia</option>
										<option value="AW">Aruba</option>
										<option value="AU">Australia</option>
										<option value="AT">Austria</option>
										<option value="AZ">Azerbaijan</option>
										<option value="BS">Bahamas</option>
										<option value="BH">Bahrain</option>
										<option value="BD">Bangladesh</option>
										<option value="BB">Barbados</option>
									</select>
									<div class="clearfix space20"></div>
									<div class="row">
										<div class="col-md-6">
											<label>First Name </label>
											<input class="form-control" placeholder="" name="first_name" value="<?php if (isset($row['firstname'])) {echo $row['firstname'];} ?>" type="text">
										</div>
										<div class="col-md-6">
											<label>Last Name </label>
											<input class="form-control" placeholder="" name="last_name" value="<?php if (isset($row['lastname'])) {echo $row['lastname'];} ?>" type="text">
										</div>
									</div>
									<div class="clearfix space20"></div>
									<label>Company Name</label>
									<input class="form-control" placeholder="" name="company" value="<?php if (isset($row['company'])) {echo $row['company'];} ?>" type="text">
									<div class="clearfix space20"></div>
									<label>Address </label>
									<input class="form-control" placeholder="Street address" name="address1" value="<?php if (isset($row['address1'])) {echo $row['address1'];} ?>" type="text">
									<div class="clearfix space20"></div>
									<input class="form-control" placeholder="Apartment, suite, unit etc. (optional)" name="address2" value="<?php if (isset($row['address2'])) {echo $row['address2'];} ?>" type="text">
									<div class="clearfix space20"></div>
									<div class="row">
										<div class="col-md-4">
											<label>City</label>
											<input class="form-control" placeholder="City" name="city" value="<?php if (isset($row['city'])) {echo $row['city'];} ?>" type="text">
										</div>
										<div class="col-md-4">
											<label>State</label>
											<input class="form-control" placeholder="State" name="state" value="<?php if (isset($row['state'])) {echo $row['state'];} ?>" type="text">
										</div>
										<div class="col-md-4">
											<label>Zipcode</label>
											<input class="form-control" placeholder="Zipcode" name="zip_code" value="<?php if (isset($row['zip'])) {echo $row['zip'];} ?>" type="text">
										</div>
									</div>
									<div class="clearfix space20"></div>
									<label>Phone </label>
									<input class="form-control" id="billing_phone" placeholder="" name="phone" value="<?php if (isset($row['mobile'])) {echo $row['mobile'];} ?>" type="text">
									<div class="space30"></div>
									<button type="submit" class="button btn-lg" name="address_form">Update Address</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>