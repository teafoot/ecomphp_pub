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
						<h2>My Wishlist</h2>
					</div>
					<div class="col-md-12">
						<h3>Recent Products</h3><br>
						<table class="cart-table account-table table table-bordered">
							<thead>
								<tr>
									<th>Product Name</th>
									<th>Price</th>
									<th>Added On</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sql_wishlist = "SELECT w.id AS wid, w.*, p.id AS pid, p.* FROM wishlist w JOIN products p WHERE w.pid=p.id AND w.uid=$user_id";
									$result_wishlist = mysqli_query($connection, $sql_wishlist);
									while ($row_wishlist = mysqli_fetch_assoc($result_wishlist)) {
								?>
									<tr>
										<td><a href="single.php?id=<?php echo $row_wishlist['pid']; ?>"><?php echo substr($row_wishlist['name'], 0, 20); ?></a></td>
										<td>$<?php echo $row_wishlist['price']; ?></td>
										<td><?php echo $row_wishlist['timestamp']; ?></td>
										<td><a href="wishlist-delete-product.php?id=<?php echo $row_wishlist['wid']; ?>">X</a></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>		
					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>