<?php
	session_start();
	ob_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

	include 'inc/header.php';
 	include 'inc/nav.php';

 	if (isset($_POST['order_status_form'])) {
		$id = filter_var($_POST['order_id'], FILTER_SANITIZE_NUMBER_INT);
		$order_status = filter_var($_POST['order_status'], FILTER_SANITIZE_STRING);
		$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

		$sql_order_tracking = "INSERT INTO ordertracking (orderid, status, message) VALUES ($id, '$order_status', '$message')";
		$result_order_tracking = mysqli_query($connection, $sql_order_tracking) or die(mysqli_error($connection));
		if ($result_order_tracking) {
			$sql_order = "UPDATE orders SET orderstatus='$order_status' WHERE id=$id";
			if (mysqli_query($connection, $sql_order)) {
				header('location: orders.php');
			}
		}
	}

?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="page_header text-center">
				<h2>Admin - Process Order</h2>
				<p>Change Status of the Order</p>
			</div>
			<form method="post" action="">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="billing-details">
								<h3 class="uppercase">Process Order</h3>
								<div class="space30"></div>
								<table class="cart-table account-table table table-bordered">
									<thead>
										<tr>
											<th>Order</th>
											<th>Date</th>
											<th>Status</th>
											<th>Payment Mode</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($_GET['id']) && is_numeric($_GET['id'])) {
												$id = $_GET['id'];
											} else {
												header('location: orders.php');
											}

											$sql_order = "SELECT * FROM orders WHERE id=$id";
											$result_order = mysqli_query($connection, $sql_order);

											if (mysqli_num_rows($result_order) == 1) {
												$row_order = mysqli_fetch_assoc($result_order);
										?>
											<tr>
												<td><?php echo $row_order['id']; ?></td>
												<td><?php echo $row_order['timestamp']; ?></td>
												<td><?php echo $row_order['orderstatus']; ?></td>
												<td><?php echo $row_order['paymentmode']; ?></td>
												<td>$<?php echo $row_order['totalprice']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								<div class="space30"></div>
								<input type="hidden" name="order_id" value="<?php echo $id; ?>">
								<label class="">Order Status</label>
								<select name="order_status" class="form-control">
									<option value="">Select Status</option>
									<option value="In Progress">In Progress</option>
									<option value="Dispatched">Dispatched</option>
									<option value="Delivered">Delivered</option>
								</select>	
								<div class="space30"></div>
								<label>Message: </label>
								<textarea class="form-control" name="message" cols="6"></textarea>
								<div class="space30"></div>
								<button type="submit" class="button btn-lg" name="order_status_form">Update Order Status</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>