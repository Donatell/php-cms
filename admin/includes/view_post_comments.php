<?php

// Redirect back to posts if GET has no post id
if (!isset($_GET['post_id'])) {
	header('Location: posts.php?action=view_posts');
	exit();
} else {
	$post_id = $_GET['post_id'];
}

if (isset($_GET['delete'])) {
	delete_comment();
	header("Location: comments.php?action=view_post_comments&post_id=$post_id");
}

if (isset($_GET['approve'])) {
	approve_comment_by_id($_GET['approve']);
	header("Location: comments.php?action=view_post_comments&post_id=$post_id");
}

if (isset($_GET['disapprove'])) {
	disapprove_comment_by_id($_GET['disapprove']);
	header("Location: comments.php?action=view_post_comments&post_id=$post_id");
}

?>

<h1 class="page-header">
	Comments
	<small></small>
</h1>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>Post</th>
		<th>Author</th>
		<th>E-Mail</th>
		<th>Content</th>
		<th>Status</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<!--Populate with Comments-->
	<?php find_all_comments_by_post_id($_GET['post_id']); ?>
	</tbody>
</table>