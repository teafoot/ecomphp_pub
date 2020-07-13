<?php
	session_start();
	 
 	require_once 'config/connect.php';

	include 'inc/header.php';
 	include 'inc/nav.php';
?>
	
	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>Shop</h2>
						<p>You can order products from here</p>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div id="shop-mason" class="shop-mason-4col">
								<?php
									$sql_product = "SELECT * FROM products";
									if (isset($_GET['id']) && is_numeric($_GET['id'])) {
										$id = $_GET['id'];
										$sql_product .= " WHERE catid=$id";
									}
									$result_product = mysqli_query($connection, $sql_product);
									while ($row_product = mysqli_fetch_assoc($result_product)) {
								?>
									<div class="sm-item isotope-item">
										<div class="product">
											<div class="product-thumb">
												<img src="admin/<?php echo $row_product['thumb']; ?>" class="img-responsive" alt="">
												<div class="product-overlay">
													<span>
														<a href="single.php?id=<?php echo $row_product['id']; ?>" class="fa fa-link"></a>
														<a href="add-to-cart.php?id=<?php echo $row_product['id']; ?>" class="fa fa-shopping-cart"></a>
													</span>					
												</div>
											</div>
											<div class="rating">
												<span class="fa fa-star act"></span>
												<span class="fa fa-star act"></span>
												<span class="fa fa-star act"></span>
												<span class="fa fa-star act"></span>
												<span class="fa fa-star act"></span>
											</div>
											<h2 class="product-title"><a href="single.php?id=<?php echo $row_product['id']; ?>"><?php echo $row_product['name'] ?></a></h2>
											<div class="product-price">$<?php echo $row_product['price']; ?><span></span></div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="clearfix"></div>
						<!-- Pagination -->
						<div class="page_nav">
							<a href=""><i class="fa fa-angle-left"></i></a>
							<a href="" class="active">1</a>
							<a href="">2</a>
							<a href="">3</a>
							<a class="no-active">...</a>
							<a href="">9</a>
							<a href=""><i class="fa fa-angle-right"></i></a>
						</div>
						<!-- End Pagination -->
					</div>
				</div>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>