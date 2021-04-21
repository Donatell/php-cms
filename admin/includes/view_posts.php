<?php

delete_post();

if (isset($_GET['publish'])) {
	set_post_status_post_by_id($_GET['publish'], 'published');
}

if (isset($_GET['withdraw'])) {
	set_post_status_post_by_id($_GET['withdraw'], 'draft');
}

if (isset($_POST['checkbox_array']) && isset($_POST['bulk_options'])) {
	echo $bulk_option = $_POST['bulk_options'];

	if ($bulk_option === 'published' || $bulk_option === 'draft') {
		foreach ($_POST['checkbox_array'] as $checkbox_value) {
			set_post_status_post_by_id($checkbox_value, $bulk_option);
		}
	} else if ($bulk_option === 'delete') {
		foreach ($_POST['checkbox_array'] as $checkbox_value) {
			delete_post_by_id($checkbox_value);
		}

	} else if ($bulk_option === 'clone') {
		foreach ($_POST['checkbox_array'] as $checkbox_value) {
			clone_post_by_id($checkbox_value);
		}
	}
}

?>

<h1 class="page-header">
	Posts
	<small></small>
</h1>

<?php

if (isset($_GET['created'])) {
	$title = $_GET['created'];
	echo "<div class='alert alert-success' role='alert'>Post \"$title\" has been created</div>";
}

if (isset($_GET['edited'])) {
	$title = $_GET['edited'];
	echo "<div class='alert alert-success' role='alert'>Post \"$title\" has been updated</div>";
}

?>

<form action="./posts.php?action=view_posts" method="post">
	<div class="row" id="bulkOptionsContainer">
		<div class="col-sm-4">
			<select class="form-control" name="bulk_options" id="">
				<option value="">Select Action...</option>
				<option value="published">Publish</option>
				<option value="draft">Withdraw</option>
				<option value="delete">Delete</option>
				<option value="clone">Clone</option>
			</select>
		</div>
		<div class="form-group col-xs-4">
			<input type="submit"
			       class="btn btn-success"
			       name="submit"
			       value="Apply">
			<a class="btn btn-primary" href="./posts.php?action=add_post">Add
			                                                              a
			                                                              New
			                                                              Post
			</a>
		</div>
	</div>

	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th><input id="selectAllBoxes" type="checkbox"></th>
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
			<th>Publication</th>
		</tr>
		</thead>
		<tbody>
		<!--Populate with Posts-->
		<?php find_all_posts() ?>
		</tbody>
	</table>
</form>