<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include "includes/head.php" ?>

<?php
include "./admin/functions.php";

if (isset($_GET['post_id'])) {
	$row = get_post_by_id($_GET['post_id']);

	$id = $row['post_id'];
	$author = $row['post_author'];
	$title = $row['post_title'];
	$date = $row['post_date'];
	$category_id = $row['post_category_id'];
	$status = $row['post_status'];
	$content = $row['post_content'];
	$image = $row['post_image'];
	$tags = $row['post_tags'];
	$comment_count = $row['post_comment_count'];
}
if (isset($_POST['submit_comment'])) {
	add_comment();
}
?>

<body>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

	<div class="row">

		<!-- Blog Post Content Column -->
		<div class="col-lg-8">

			<!-- Blog Post -->

			<!-- Title -->
			<h1><?php echo $title ?></h1>

			<!-- Author -->
			<p class="lead">
				by <a href="#"><?php echo $author ?></a>
			</p>

			<hr>

			<!-- Date/Time -->
			<p><span class="glyphicon glyphicon-time"></span> <?php echo $date
				?></p>

			<hr>

			<!-- Preview Image -->
			<img class="img-responsive"
			     src="images/<?php echo $image ?>"
			     alt="">

			<hr>

			<!-- Post Content -->
			<p class="lead"><?php echo $content ?></p>

			<hr>

			<!-- Blog Comments -->

			<!-- Comments Form -->
			<div class="well">
				<h4>Leave a Comment:</h4>
				<form action="post.php?post_id=<?php echo $_GET['post_id'] ?>"
				      method="post" role="form">
					<div class="form-group">
						<label for="author">Your Name</label>
						<input class="form-control" name="author" required />
					</div>
					<div class="form-group">
						<label for="author">Your E-Mail</label>
						<input class="form-control" name="email" required />
					</div>
					<div class="form-group">
						<label for="author">Your Comment</label>
						<textarea class="form-control" rows="3"
						          name="content" required></textarea>
					</div>
					<button type="submit" name="submit_comment" class="btn
					btn-primary">Submit
					</button>
				</form>
			</div>

			<hr>

			<!-- Posted Comments -->

			<!-- Comment -->
			<?php
			$comments_query =
				get_approved_comments_by_post_id($id);
			while ($row = mysqli_fetch_assoc($comments_query)) {
				$comment_date = $row['comment_date'];
				$comment_content = $row['comment_content'];
				$comment_author = $row['comment_author'];

				?>
				<div class="media">
					<a class="pull-left" href="#">
						<img class="media-object"
						     src="http://placehold.it/64x64"
						     alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading"><?php echo $comment_author ?>
							<small><?php echo $comment_date ?></small>
						</h4>
						<?php echo $comment_content ?>
					</div>
				</div>

			<?php } ?>

			<!-- Comment -->
			<div class="media">
				<a class="pull-left" href="#">
					<img class="media-object"
					     src="http://placehold.it/64x64"
					     alt="">
				</a>
				<div class="media-body">
					<h4 class="media-heading">Start Bootstrap
						<small>August 25, 2014 at 9:30 PM</small>
					</h4>
					Cras sit amet nibh libero, in gravida nulla. Nulla vel metus
					scelerisque ante sollicitudin commodo.
					Cras purus odio, vestibulum in vulputate at, tempus viverra
					turpis. Fusce condimentum nunc ac nisi
					vulputate fringilla. Donec lacinia congue felis in faucibus.
					<!-- Nested Comment -->
					<div class="media">
						<a class="pull-left" href="#">
							<img class="media-object"
							     src="http://placehold.it/64x64"
							     alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">Nested Start Bootstrap
								<small>August 25, 2014 at 9:30 PM</small>
							</h4>
							Cras sit amet nibh libero, in gravida nulla. Nulla
							vel metus scelerisque ante sollicitudin
							commodo. Cras purus odio, vestibulum in vulputate
							at, tempus viverra turpis. Fusce
							condimentum nunc ac nisi vulputate fringilla. Donec
							lacinia congue felis in faucibus.
						</div>
					</div>
					<!-- End Nested Comment -->
				</div>
			</div>

		</div>

		<!-- Blog Sidebar Widgets Column -->
		<?php include "includes/sidebar.php" ?>

	</div>

</div>
<!-- /.row -->

<hr>

<!-- Footer -->
<?php include "includes/footer.php" ?>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>