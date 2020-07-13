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
							<th>Category Name</th>
							<th>Operations</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$sql = "SELECT * FROM category";
							$result = mysqli_query($connection, $sql);
							while ($row = mysqli_fetch_assoc($result)) {
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><a href="category-edit.php?id=<?php echo $row['id']; ?>">Edit</a> | <a href="category-delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

<?php include 'inc/footer.php'; ?>