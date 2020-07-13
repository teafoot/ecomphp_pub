<?php 
	session_start();

 	require_once 'config/connect.php';

	include 'inc/header.php';
 	include 'inc/nav.php';

 	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
 		$id = $_GET['id'];
 		$sql_product = "SELECT * FROM products WHERE id=$id";
 		$result_product = mysqli_query($connection, $sql_product);
 		$row_product = mysqli_fetch_assoc($result_product);
 	} else {
 		header('location: index.php');
 	}

 	if (isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])) {
		$user_id = $_SESSION['customer_id'];
 	} else {
 		$user_id = 0;
 	}

	if (isset($_POST['product_review_form'])) {
		if (!isset($_SESSION['customer_email'])) {
			header('location: login.php');
		}

		$review = filter_var($_POST['review'], FILTER_SANITIZE_STRING);
		$sql_review = "INSERT INTO reviews (pid, uid, review) VALUES ($id, $user_id, '$review')";
		$result_review = mysqli_query($connection, $sql_review);
		if ($result_review) {
			$message_success = "Review submitted successfully";
		} else {
			$message_fail = "Failed to submit review";
		}
	}
?>

	<div class="close-btn fa fa-times"></div>
	
	<!-- SHOP CONTENT -->
	<section id="content">
		<div class="content-blog">
			<div class="container">
				<div class="row">
					<div class="page_header text-center">
						<h2>Shop</h2>
						<p>Get the best kit for smooth shave</p>
					</div>
					<div class="col-md-10 col-md-offset-1">
						<?php if (isset($message_fail)) { ?>
							<div class="alert alert-danger" role="alert"><?php echo $message_fail; ?></div>
						<?php } ?>
						<?php if (isset($message_success)) { ?>
							<div class="alert alert-success" role="alert"><?php echo $message_success; ?></div>
						<?php } ?>
						<div class="row">
							<div class="col-md-5">
								<div class="gal-wrap">
									<div id="gal-slider" class="flexslider">
										<ul class="slides">
											<li><img src="admin/<?php echo $row_product['thumb']; ?>" class="img-responsive" alt=""/></li>
										</ul>
									</div>
									<ul class="gal-nav">
										<li>
											<div>
												<img src="admin/<?php echo $row_product['thumb']; ?>" class="img-responsive" alt=""/>
											</div>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="col-md-7 product-single">
								<h2 class="product-single-title no-margin"><?php echo $row_product['name']; ?></h2>
								<div class="space10"></div>
								<div class="p-price">$<?php echo $row_product['price']; ?></div>
								<p><?php echo $row_product['description']; ?>.</p>
								<form method="get" action="add-to-cart.php">
									<input type="hidden" name="id" value="<?php echo $row_product['id']; ?>"> 
									<div class="product-quantity">
										<span>Quantity:</span>
										<input type="text" name="quantity" placeholder="1">
									</div>
									<div class="shop-btn-wrap">
										<button type="submit" class="button btn-small">Add to Cart</button>
									</div>
								</form>
								<div class="space20"></div>
								<a href="add-to-wishlist.php?id=<?php echo $id; ?>" class="button btn-small">Add to Wishlist</a>
								<div class="product-meta">
									<span>
										<?php
											$sql_category = "SELECT * from category WHERE id=" . $row_product['catid'];
											$result_category = mysqli_query($connection, $sql_category);
											$row_category = mysqli_fetch_assoc($result_category);
										?>
										Category:	<a href="index.php?id=<?php echo $row_category['id']; ?>"><?php echo $row_category['name']; ?></a>
									</span>
								</div>
							</div>
						</div>
						<div class="clearfix space30"></div>
						<div class="tab-style3">
							<!-- Nav Tabs -->
							<div class="align-center mb-40 mb-xs-30">
								<ul class="nav nav-tabs tpl-minimal-tabs animate">
									<li class="active col-md-6">
										<a aria-expanded="true" href="#mini-one" data-toggle="tab">Overview</a>
									</li>									
									<li class="col-md-6">
										<a aria-expanded="false" href="#mini-three" data-toggle="tab">Reviews</a>
									</li>
								</ul>
							</div>
							<!-- End Nav Tabs -->
							<!-- Tab panes -->
							<div style="height: auto;" class="tab-content tpl-minimal-tabs-cont align-center section-text">
								<div style="" class="tab-pane fade active in" id="mini-one">
									<p><?php echo $row_product['description']; ?></p>
								</div>
								<div style="" class="tab-pane fade" id="mini-three">
									<div class="col-md-12">
										<?php 
											$sql_review_product_count = "SELECT count(*) AS num_reviews FROM reviews WHERE pid=$id";
											$result_review_product_count = mysqli_query($connection, $sql_review_product_count);
											$row_review_product_count = mysqli_fetch_assoc($result_review_product_count);
										?>
										<h4 class="uppercase space35"><?php echo $row_review_product_count['num_reviews']; ?> Review(s) for "<i><?php echo substr($row_product['name'], 0, 20); ?></i>"</h4>
										<ul class="comment-list">
											<?php
												$sql_review = "SELECT * FROM reviews r JOIN usersmeta um WHERE r.uid=um.uid AND r.pid=$id";
												$result_review = mysqli_query($connection, $sql_review);
												while ($row_review = mysqli_fetch_assoc($result_review)) {
											?>
												<li>
													<a class="pull-left" href="#"><img class="comment-avatar" src="images/quote/1.jpg" alt="" height="50" width="50"></a>
													<div class="comment-meta">
														<a href="#"><?php echo $row_review['firstname'] . " " . $row_review['lastname']; ?></a>
														<span>
														<em><?php echo $row_review['timestamp']; ?></em>
														</span>
													</div>													
													<p><?php echo $row_review['review']; ?></p>
												</li>
											<?php } ?>
										</ul>
										<?php
											$sql_review_user_count = "SELECT count(*) AS num_reviews FROM reviews WHERE uid=$user_id AND pid=$id";
											$result_review_user_count = mysqli_query($connection, $sql_review_user_count);
											$row_review_user_count = mysqli_fetch_assoc($result_review_user_count);
											if ($row_review_user_count['num_reviews'] == 0) {
										?>
											<h4 class="uppercase space20">Add a review</h4>
											<form method="post" id="form" class="review-form">
												<?php 
													$sql_user = "SELECT * FROM users u JOIN usersmeta um WHERE u.id=um.uid AND u.id=$user_id";
													$result_user = mysqli_query($connection, $sql_user);
													$row_user = mysqli_fetch_assoc($result_user);
												?>
												<div class="row">
													<div class="col-md-6 space20">
														<label>Name: </label>
														<input name="name" value="<?php echo $row_user['firstname'] . " " . $row_user['lastname']; ?>" class="input-md form-control" placeholder="Name *" maxlength="100" required="" type="text" disabled>
													</div>
													<div class="col-md-6 space20">
														<label>Email: </label>
														<input name="email" value="<?php echo $row_user['email']; ?>" class="input-md form-control" placeholder="Email *" maxlength="100" required="" type="email" disabled>
													</div>
												</div>
												<div class="space20">
													<label>Product Review: </label>
													<textarea name="review" id="text" class="input-md form-control" rows="6" placeholder="Add review.." maxlength="400"></textarea>
												</div>
												<button type="submit" name="product_review_form" class="button btn-small">Submit Review</button>
											</form>
										<?php 
											} else {
										?>
											<h4 class="uppercase space20">You have already reviewed this product</h4>
										<?php } ?>
									</div>
									<div class="clearfix space30"></div>
								</div>
							</div>
						</div>
						<div class="space30"></div>
						<div class="related-products">
							<h4 class="heading">Related Products</h4>
							<hr>
							<div class="row">
								<div id="shop-mason" class="shop-mason-3col">
									<?php
										$sql_product2 = "SELECT * FROM products WHERE id!=$id ORDER BY rand() LIMIT 3";
										$result_product2 = mysqli_query($connection, $sql_product2);
										while ($row_product2 = mysqli_fetch_assoc($result_product2)) {
									?>
										<div class="sm-item isotope-item">
											<div class="product">
												<div class="product-thumb">
													<img src="admin/<?php echo $row_product2['thumb']; ?>" class="img-responsive" alt="">
													<div class="product-overlay">
														<span>
														<a href="single.php?id=<?php echo $row_product2['id']; ?>" class="fa fa-link"></a>
														<a href="add-to-cart.php?id=<?php echo $row_product2['id']; ?>" class="fa fa-shopping-cart"></a>
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
												<h2 class="product-title"><a href="single.php?id=<?php echo $row_product2['id']; ?>"><?php echo $row_product2['name'] ?></a></h2>
												<div class="product-price">$<?php echo $row_product2['price']; ?><span></span></div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php include 'inc/footer.php'; ?>