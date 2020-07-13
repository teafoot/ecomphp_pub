			<div class="menu-wrap">
				<div id="mobnav-btn">Menu <i class="fa fa-bars"></i></div>
				<ul class="sf-menu">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="#">Shop</a>
						<div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
						<ul>
							<?php
								$sql_category = "SELECT * FROM category";
								$result_category = mysqli_query($connection, $sql_category);
								while ($row_category = mysqli_fetch_assoc($result_category)) {
							?>
								<li><a href="index.php?id=<?php echo $row_category['id']; ?>"><?php echo $row_category['name']; ?></a></li>
							<?php } ?>
						</ul>
					</li>
					<?php 
						if (isset($_SESSION['customer_email'])) {
					?>
						<li>
							<a href="#">My Account</a>
							<div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
							<ul>
								<li><a href="my-account.php">My Orders</a></li>
								<li><a href="address-edit.php">Update Billing Address</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					<?php } ?>
					<li>
						<a href="#">Contact</a>
					</li>
				</ul>
				<div class="header-xtra">
					<div class="s-cart">
						<?php 
							if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
								$cart = $_SESSION['cart'];
							} else {
								$cart = array();
							}
						?>
						<div class="sc-ico"><a href="cart.php"><i class="fa fa-shopping-cart"></i></a><em><?php echo count($cart); ?></em></div>
						<div class="cart-info">
							<small>You have <em class="highlight"><?php echo count($cart); ?> item(s)</em> in your shopping bag</small><br><br>
							<?php
								$total_price = 0;

								foreach ($cart as $product => $values) {
									$sql_product = "SELECT * FROM products WHERE id=$product";
									$result_product = mysqli_query($connection, $sql_product);
									$row_product = mysqli_fetch_assoc($result_product);
							?>
								<div class="ci-item">
									<img src="admin/<?php echo $row_product['thumb']; ?>" width="70" alt=""/>
									<div class="ci-item-info">
										<h5><a href="single.php?id=<?php echo $row_product['id']; ?>"><?php echo substr($row_product['name'], 0, 20); ?></a></h5>
										<p>$<?php echo $row_product['price']; ?> x <?php echo $values['quantity']; ?></p>
										<div class="ci-edit">
											<a href="cart-delete.php?id=<?php echo $product; ?>" class="edit fa fa-trash-o" style="color: #000; background-color: #fff;"></a>
										</div>
									</div>
								</div>
							<?php 
									$total_price += $row_product['price'] * $values['quantity'];
								} 
							?>
							<div class="ci-total">Subtotal: $<?php echo $total_price; ?></div>
							<div class="cart-btn">
								<a href="cart.php">View Bag</a>
								<a href="checkout.php">Checkout</a>
							</div>
						</div>
					</div>
					<div class="s-search">
						<div class="ss-ico"><i class="fa fa-search"></i></div>
						<div class="search-block">
							<div class="ssc-inner">
								<form>
									<input type="text" placeholder="Type Search text here...">
									<button type="submit"><i class="fa fa-search"></i></button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>