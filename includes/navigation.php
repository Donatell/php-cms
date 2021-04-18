<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button"
			        class="navbar-toggle"
			        data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">CMS</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php
				$query = "SELECT * FROM categories";
				$categories_query = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_assoc($categories_query)) {
					$cat_title = $row['cat_title'];

					echo "<li><a href='#'>{$cat_title}</a></li>";
				}
				?>
				<li><a href='/admin'>Admin</a></li>

				<?php

				// if user is logged in, is admin and current page is single
				// post page, show "edit post" link in navbar
				if (isset($_SESSION['role']) && $_SESSION['role'] === '1' &&
					isset($_GET['post_id'])) {
					$post_id = $_GET['post_id'];
					echo "<li><a href='/admin/posts.php?action=edit_post&edit=$post_id'>Edit Post</a></li>";
				}

				?>

			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>