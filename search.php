<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include "includes/head.php" ?>

<body>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>


			<?php

			if (isset($_POST['submit'])) {
				$search = $_POST['search'];

				$query = "SELECT * FROM posts WHERE post_tags LIKE '$search'";
				$search_query = mysqli_query($connection, $query);

				if (!$search_query) {
					die('QUERY FAILED' . mysqli_error($connection));
				}

				if (mysqli_num_rows($search_query) === 0) {
					echo "<h1>No Results of '$search'";
				} else {
					while ($row = mysqli_fetch_assoc($search_query)) {
						$post_title = $row['post_title'];
						$post_author = $row['post_author'];
						$post_date = $row['post_date'];
						$post_image = $row['post_image'];
						$post_content = $row['post_content'];
//				$post_tags = $row['post_tags'];
//				$post_comment_count = $row['post_comment_count'];
					}
				}

				?>

                <!-- Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span>
					<?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive"
                     src="images/<?php echo $post_image ?>"
                     alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More
                    <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
			<?php } ?>


            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

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