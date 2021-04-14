<!DOCTYPE html>
<html lang="en">

<?php include 'includes/admin_head.php' ?>

<body>

<div id="wrapper">

	<!-- Navigation -->
	<?php include 'includes/admin_navigation.php'; ?>

	<div id="page-wrapper">

		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Categories
						<small></small>
					</h1>

					<!-- Handle Actions -->
					<?php insert_category(); ?>
					<?php update_category(); ?>
					<?php delete_category(); ?>

					<!-- Add Category Form -->
					<div class="col-xs-6">
						<form action="" method="post">
							<div class="form-group">
								<label for="cat_title">Category Title</label>
								<input class="form-control"
								       type="text"
								       name="cat_title">

							</div>
							<div class="form-group">
								<input class="btn btn-primary"
								       type="submit"
								       name="add_category"
								       value="Add
                                 Category">
							</div>
						</form>

						<?php

						if (isset($_GET['edit'])) {

							echo "<form action='' method='post'>";

							$edited_cat_id = $_GET['edit'];

							$query =
								"SELECT * FROM categories WHERE cat_id = $edited_cat_id";
							$edit_query =
								mysqli_query($connection, $query);

							while ($table_row =
								mysqli_fetch_assoc($edit_query)) {
								$cat_id = $table_row['cat_id'];
								$cat_title = $table_row['cat_title'];
								?>
								<hr>
								<div class="form-group">
									<label for="cat_title">Editing: <?php
										echo $cat_title
										?></label>
									<input class="form-control"
									       type="text"
									       name="cat_title"
									       value="<?php echo $cat_title ?>">

								</div>
								<div class="form-group">
									<input class="btn btn-primary"
									       type="submit"
									       name="update_category"
									       value="Update Category">
								</div>
								<?php
							}

							echo '</form>';
						}

						?>

					</div>

					<!--Categories Table-->
					<div class="col-xs-6">
						<table class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>ID</th>
								<th>Category Title</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>

							<!--Populate with Categories-->
							<?php find_all_categories(); ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- /.row -->

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>