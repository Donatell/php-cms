<!DOCTYPE html>
<html lang="en">

<?php include 'includes/admin_head.php' ?>

<body>

<div id="wrapper">

	<!-- Navigation -->
	<?php include 'includes/admin_navigation.php'; ?>

	<div id="page-wrapper">

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">

					<!-- Page Heading -->
					<?php

					if (isset($_GET['action'])) {
						$action = $_GET['action'];

						switch ($action) {
							case 'view_comments':
								include 'includes/view_comments.php';
								break;
							case 'view_post_comments':
								include 'includes/view_post_comments.php';
								break;
							default:
								echo 'Routing Error';
								break;
						}
					}

					?>

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

<script src="js/scripts.js"></script>

</body>

</html>