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
	Users
	<small></small>
</h1>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Role</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<!--Populate with Users-->
	<?php find_all_users() ?>
	</tbody>
</table>