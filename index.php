<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include "includes/head.php" ?>

<body>

<?php

// set page if no "page" get request
if (isset($_GET['page'])) {
	$current_page = $_GET['page'];
	$posts_per_page = 5;
} else {
	header('Location: index.php?page=1');
	exit();
}

// count all posts and page count for pager
$post_count = count_posts_with_status('published');
$page_count = ceil($post_count / $posts_per_page);

// set limits for query
if ($current_page == '1') {
	$from = 0;
} else {
	$from = ($current_page * $posts_per_page) - $posts_per_page;
}

?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

	<div class="row">

		<!-- Blog Entries Column -->
		<div class="col-md-8">

			<h1 class="page-header">
				Feed
				<small></small>
			</h1>

			<?php
			$query =
				"SELECT * FROM posts WHERE post_status = 'published' LIMIT $from, $posts_per_page";
			$posts_query = mysqli_query($connection, $query);

			if (mysqli_num_rows($posts_query) === 0) {
				echo '<h2>No Posts Found</h2>';
			} else {

				while ($row = mysqli_fetch_assoc($posts_query)) {
					$post_id = $row['post_id'];
					$post_title = $row['post_title'];
					$post_author = $row['post_author'];
					$post_date = $row['post_date'];
					$post_image = $row['post_image'];
					$post_content = substr($row['post_content'], 0, 200) .
						'...';                //				$post_tags = $row['post_tags'];
					//				$post_comment_count = $row['post_comment_count'];

					?>

					<!-- Blog Post -->
					<h2>
						<a href="post.php?post_id=<?php echo $post_id ?>"><?php echo
							$post_title ?></a>
					</h2>
					<p class="lead">
						by <a href="author.php?author=<?php echo urlencode
						($post_author) ?>"><?php
							echo
							$post_author ?></a>
					</p>
					<p><span class="glyphicon glyphicon-time"></span>
						<?php echo $post_date ?></p>
					<hr>
					<a href="post.php?post_id=<?php echo $post_id ?>">
						<img class="img-responsive"
						     src="images/<?php echo $post_image ?>"
						     alt="">
					</a>
					<hr>
					<p><?php echo $post_content ?></p>
					<a class="btn btn-primary"
					   href="post.php?post_id=<?php echo $post_id ?>">Read More
						<span class="glyphicon glyphicon-chevron-right"></span></a>

					<hr>
				<?php }
			} ?>

			<!-- Pager -->
			<nav>
				<ul class="pagination">
					<?php

					if ($current_page == '1') {
						echo "<li class='disabled'><span>&laquo;</span></li>";
					} else {
						$previous = $current_page - 1;
						echo "<li><a href='index.php?page=$previous'><span>&laquo;</span></a></li>";
					}

					$next = $current_page + 1;

					for ($i = 1; $i <= $page_count; $i++) {
						if ($i == $current_page) {
							echo "<li class='active'><a href='index.php?page=$i'>$i</a></li>";
						} else {
							echo "<li><a href='index.php?page=$i'>$i</a></li>";
						}
					}

					if ($current_page == $page_count) {
						echo "<li class='disabled'><span>&raquo;</span></li>";
					} else {
						$next = $current_page + 1;
						echo "<li><a href='index.php?page=$next'><span>&raquo;</span></a></li>";
					}

					?>
				</ul>
			</nav>

		</div>

		<!-- Blog Sidebar Widgets Column -->
		<?php include "includes/sidebar.php" ?>

	</div>
	<!-- /.row -->

	<hr>

	<!-- Footer -->
	<?php include "includes/footer.php" ?>

</body>

</html>