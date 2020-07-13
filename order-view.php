<?php 
	session_start();
	
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

?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog content-account">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>My Account</h2>
					</div>
					<div class="col-md-12">
						<h3>Recent Orders</h3>
						<br>
						<table class="cart-table account-table table table-bordered">
							<thead>
								<tr>
									<th>Product</th>
									<th>Quantity</th>
									<th>Price</th>
									<th>&nbsp;</th>
									<th>Total Price</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if (isset($_GET['id']) && is_numeric($_GET['id'])) {
										$id = $_GET['id'];
									} else {
										header('location: my-account.php');
									}

									$sql_order = "SELECT * FROM orders WHERE uid=$user_id AND id=$id";
									$result_order = mysqli_query($connection, $sql_order);
									$row_order = mysqli_fetch_assoc($result_order);

									$sql_order_items = "SELECT * FROM orderitems o JOIN products p WHERE o.orderid=$id AND o.pid=p.id";
									$result_order_items = mysqli_query($connection, $sql_order_items);
									while ($row_order_items = mysqli_fetch_assoc($result_order_items)) {
								?>
									<tr>
										<td><a href="single.php?id=<?php echo $row_order_items['pid']; ?>"><?php echo substr($row_order_items['name'], 0, 20); ?></a></td>
										<td><?php echo $row_order_items['pquantity']; ?></td>
										<td>$<?php echo $row_order_items['productprice']; ?></td>
										<td>&nbsp;</td>
										<td>$<?php echo $row_order_items['pquantity'] * $row_order_items['productprice']; ?></td>
									</tr>
								<?php } ?>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>Order Total</td>
										<td>$<?php echo $row_order['totalprice'] ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>Order Date</td>
										<td><?php echo $row_order['timestamp'] ?></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>Order Status</td>
										<td><?php echo $row_order['orderstatus'] ?></td>
									</tr>
							</tbody>
						</table>		
						<br>
						<br>
						<br>
						<div class="ma-address">
							<h3>My Addresses</h3>
							<p>The following addresses will be used on the checkout page by default.</p>
							<div class="row">
								<div class="col-md-12">
									<h4>My Address <a href="address-edit.php">Edit</a></h4>
									<?php
										$sql_user = "SELECT * FROM users u JOIN usersmeta um WHERE u.id=um.uid AND u.id=$user_id";
										$result_user = mysqli_query($connection, $sql_user);
										if (mysqli_num_rows($result_user) == 1) {
											$row_user = mysqli_fetch_assoc($result_user);
											echo "<p><b>Full Name: </b>" . $row_user['firstname'] . " " . $row_user['lastname'] . "</p>";
											echo "<p><b>Address 1: </b>" . $row_user['address1'] . "</p>";
											echo "<p><b>Address 2: </b>" . $row_user['address2'] . "</p>";
											echo "<p><b>City: </b>" . $row_user['city'] . "</p>";
											echo "<p><b>State: </b>" . $row_user['state'] . "</p>";
											echo "<p><b>Country: </b>" . $row_user['country'] . "</p>";
											echo "<p><b>Company: </b>" . $row_user['company'] . "</p>";
											echo "<p><b>Zipcode: </b>" . $row_user['zip'] . "</p>";
											echo "<p><b>Phone Number: </b>" . $row_user['mobile'] . "</p>";
											echo "<p><b>Email: </b>" . $row_user['email'] . "</p>";
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>