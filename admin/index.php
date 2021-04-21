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
						Dashboard
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
						</li>
						<li class="active">
							<i class="fa fa-file"></i> Blank Page
						</li>
					</ol>
				</div>
			</div>
			<!-- /.row -->

			<!-- /.row -->

			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-file-text fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo count_posts
										() ?></div>
									<div>Posts</div>
								</div>
							</div>
						</div>
						<a href="posts.php?action=view_posts">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-green">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-comments fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo count_comments() ?></div>
									<div>Comments</div>
								</div>
							</div>
						</div>
						<a href="comments.php?action=view_comments">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-yellow">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-user fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo count_users()
										?></div>
									<div> Users</div>
								</div>
							</div>
						</div>
						<a href="users.php?action=view_users">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="panel panel-red">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<i class="fa fa-list fa-5x"></i>
								</div>
								<div class="col-xs-9 text-right">
									<div class='huge'><?php echo count_categories() ?></div>
									<div>Categories</div>
								</div>
							</div>
						</div>
						<a href="categories.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<!-- Column chart -->
			<div id="columnchart_material" style="width: auto; height: 500px;
"></div>

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