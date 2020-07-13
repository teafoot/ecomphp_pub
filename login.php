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
						<h2>Shop - Account</h2>
						<p>Tagline Here</p>
					</div>
					<div class="col-md-12">
						<div class="row shop-login">
							<div class="col-md-6">
								<?php 
									if (isset($_GET['login_err_msg']) && is_numeric($_GET['login_err_msg'])) { 
										$id = $_GET['login_err_msg'];

										switch ($id) {
											case 1:
												$login_err_msg = 'Email/Password cannot be empty';
												break;
											case 2:
												$login_err_msg = 'Invalid login credentials';
												break;
											default:
												$login_err_msg = '';
												break;
										}
								?>
									<div class="alert alert-danger" role="alert"><?php echo $login_err_msg; ?></div>
								<?php } ?>
								<div class="box-content">
									<h3 class="heading text-center">I'm a Returning Customer</h3>
									<div class="clearfix space40"></div>
									<form class="logregform" method="post" action="login-process.php">
										<div class="row">
											<div class="form-group">
												<div class="col-md-12">
													<label>E-mail Address</label>
													<input type="email" name="email" value="" class="form-control">
												</div>
											</div>
										</div>
										<div class="clearfix space20"></div>
										<div class="row">
											<div class="form-group">
												<div class="col-md-12">
													<!-- <a class="pull-right" href="#">(Lost Password?)</a> -->
													<label>Password</label>
													<input type="password" name="password" value="" class="form-control">
												</div>
											</div>
										</div>
										<div class="clearfix space20"></div>
										<div class="row">
											<div class="col-md-6">
												<!-- <span class="remember-box checkbox">
													<label for="rememberme">
														<input type="checkbox" id="rememberme" name="rememberme">Remember Me
													</label>
												</span> -->
											</div>
											<div class="col-md-6">
												<button type="submit" name="login_form" class="button btn-md pull-right">Login</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-6">
								<?php 
									if (isset($_GET['register_err_msg']) && is_numeric($_GET['register_err_msg'])) { 
										$id = $_GET['register_err_msg'];

										switch ($id) {
											case 1:
												$register_err_msg = 'Email/Password cannot be empty';
												break;
											case 2:
												$register_err_msg = 'Passwords do not match';
												break;
											case 3:
												$register_err_msg = 'Error registering account';
												break;
											default:
												$register_err_msg = '';
												break;
										}
								?>
									<div class="alert alert-danger" role="alert"><?php echo $register_err_msg; ?></div>
								<?php } ?>
								<div class="box-content">
									<h3 class="heading text-center">Register An Account</h3>
									<div class="clearfix space40"></div>
									<form class="logregform" method="post" action="register-process.php">
										<div class="row">
											<div class="form-group">
												<div class="col-md-12">
													<label>E-mail Address</label>
													<input type="email" name="email" value="" class="form-control">
												</div>
											</div>
										</div>
										<div class="clearfix space20"></div>
										<div class="row">
											<div class="form-group">
												<div class="col-md-6">
													<label>Password</label>
													<input type="password" name="password1" value="" class="form-control">
												</div>
												<div class="col-md-6">
													<label>Re-enter Password</label>
													<input type="password" name="password2" value="" class="form-control">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="space20"></div>
												<button type="submit" name="register_form" class="button btn-md pull-right">Register</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>