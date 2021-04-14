<?php delete_post() ?>

<h1 class="page-header">
	Posts
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
	<!--Populate with Posts-->
	<?php find_all_comments() ?>
	</tbody>
</table>