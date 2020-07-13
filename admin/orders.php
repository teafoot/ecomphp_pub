<?php
	session_start();
	require_once '../config/connect.php'; 

	if (!isset($_SESSION['admin_email'])) {
		header('location: login.php');
	}

?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Customer Name</th>
							<th>Total Price</th>
							<th>Order Status</th>
							<th>Payment Mode</th>
							<th>Order Placed On</th>
							<th>Operations</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "SELECT o.*, um.firstname, um.lastname FROM orders o JOIN usersmeta um WHERE o.uid=um.uid ORDER BY o.id DESC";
							$result = mysqli_query($connection, $sql);
							while ($row = mysqli_fetch_assoc($result)) {
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
								<td>$<?php echo $row['totalprice']; ?></td>
								<td><?php echo $row['orderstatus']; ?></td>
								<td><?php echo $row['paymentmode']; ?></td>
								<td><?php echo $row['timestamp']; ?></td>
								<td><a href="order-process.php?id=<?php echo $row['id']; ?>">Process Order</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>