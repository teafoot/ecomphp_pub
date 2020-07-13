<?php
	session_start();
	ob_start();
	
 	require_once 'config/connect.php';

 	if (!isset($_SESSION['customer_email'])) {
		header('location: login.php');
	}

	include 'inc/header.php';
 	include 'inc/nav.php';

 	if (isset($_POST['cancel_form'])) {
		$id = filter_var($_POST['order_id'], FILTER_SANITIZE_NUMBER_INT);
		$cancel_msg = filter_var($_POST['cancel_msg'], FILTER_SANITIZE_STRING);

		$sql_order_tracking = "INSERT INTO ordertracking (orderid, status, message) VALUES ($id, 'Cancelled', '$cancel_msg')";
		$result_order_tracking = mysqli_query($connection, $sql_order_tracking) or die(mysqli_error($connection));
		if ($result_order_tracking) {
			$sql_order = "UPDATE orders SET orderstatus='Cancelled' WHERE id=$id";
			if (mysqli_query($connection, $sql_order)) {
				header('location: my-account.php');
			}
		}
 	}

?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="page_header text-center">
				<h2>Shop - Cancel Order</h2>
				<p>Are you sure you want to cancel the order?</p>
			</div>
			<form method="post" action="">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div class="billing-details">
								<h3 class="uppercase">Cancel Order</h3>
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
												header('location: my-account.php');
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
								<label>Reason: </label>
								<textarea class="form-control" name="cancel_msg" cols="6"></textarea>
								<div class="space30"></div>
								<button type="submit" class="button btn-lg" name="cancel_form">Cancel Order</button>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>