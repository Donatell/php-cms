<?php

delete_post();

if (isset($_GET['publish'])) {
	set_post_status_post_by_id($_GET['publish'], 'publish');
}

if (isset($_GET['unpublish'])) {
	set_post_status_post_by_id($_GET['unpublish'], 'unpublish');
}

?>

<h1 class="page-header">
	Posts
	<small></small>
</h1>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>Author</th>
		<th>Title</th>
		<th>Date</th>
		<th>Category</th>
		<th>Status</th>
		<th>Image</th>
		<th>Tags</th>
		<th>Comments</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<!--Populate with Posts-->
	<?php find_all_posts() ?>
	</tbody>
</table>