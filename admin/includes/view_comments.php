<?php

if (isset($_GET['delete'])) {
	delete_comment();
	header('Location: comments.php?action=view_comments');
}

if (isset($_GET['approve'])) {
	approve_comment_by_id($_GET['approve']);
	header('Location: comments.php?action=view_comments');
}

if (isset($_GET['disapprove'])) {
	disapprove_comment_by_id($_GET['disapprove']);
	header('Location: comments.php?action=view_comments');
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
	<?php find_all_comments() ?>
	</tbody>
</table>