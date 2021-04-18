<?php

if (isset($_GET['delete'])) {
	delete_user_by_id($_GET['delete']);
}

?>

<h1 class="page-header">
	Users
	<small></small>
</h1>
<?php

if (isset($_GET['created'])) {
	$username = $_GET['created'];
	echo "<div class='alert alert-success' role='alert'>User \"$username\" has been created</div>";
}

if (isset($_GET['edited'])) {
	$username = $_GET['edited'];
	echo "<div class='alert alert-success' role='alert'>User \"$username\" has been updated</div>";
}

?>
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