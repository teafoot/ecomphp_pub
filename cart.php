<?php 
	session_start();
 	require_once 'config/connect.php';

	include 'inc/header.php';
 	include 'inc/nav.php';

 	if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
 		$cart = $_SESSION['cart'];
 	} else {
 		$cart = array();
 	}
?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>Shopping Cart</h2>
						<p>Get the best deals here!</p>
					</div>
					<div class="col-md-12">
						<table class="cart-table table table-bordered">
							<thead>
								<tr>
									<th>Action</th>
									<th>Image</th>
									<th>Product</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$total_price = 0;

									foreach ($cart as $product => $values) {
										$sql_product = "SELECT * FROM products WHERE id=$product";
										$result_product = mysqli_query($connection, $sql_product);
										$row_product = mysqli_fetch_assoc($result_product);
								?>
									<tr>
										<td>
											<a href="cart-delete.php?id=<?php echo $product; ?>" class="remove"><i class="fa fa-times"></i></a>
										</td>
										<td>
											<a href="#"><img src="admin/<?php echo $row_product['thumb']; ?>" alt="" height="90" width="90"></a>					
										</td>
										<td>
											<a href="single.php?id=<?php echo $row_product['id']; ?>"><?php echo substr($row_product['name'], 0, 30); ?></a>					
										</td>
										<td>
											<span class="amount">$<?php echo $row_product['price']; ?></span>					
										</td>
										<td>
											<div class="quantity"><?php echo $values['quantity']; ?></div>
										</td>
										<td>
											<span class="amount">$<?php echo $row_product['price'] * $values['quantity']; ?></span>					
										</td>
									</tr>
								<?php 
										$total_price += $row_product['price'] * $values['quantity'];
									} 
								?>								
								<tr>
									<td colspan="6" class="actions">
										<div class="col-md-6 col-md-offset-6">
											<div class="cart-btn">
												<!-- <button class="button btn-md" type="submit">Update Cart</button> -->
												<a href="checkout.php" class="button btn-md">Checkout</a>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>		
						<div class="cart_totals">
							<div class="col-md-6 push-md-6 no-padding">
								<h4 class="heading">Cart Totals</h4>
								<table class="table table-bordered col-md-6">
									<tbody>
										<tr>
											<th>Cart Subtotal</th>
											<td><span class="amount">$<?php echo $total_price; ?></span></td>
										</tr>
										<tr>
											<th>Shipping and Handling</th>
											<td>Free Shipping</td>
										</tr>
										<tr>
											<th>Order Total</th>
											<td><strong><span class="amount">$<?php echo $total_price; ?></span></strong> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>