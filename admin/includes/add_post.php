<?php

if (isset($_POST['submit'])) {
	$title = $_POST['title'];
	$category_id = $_POST['category_id'];
	$author = $_POST['author'];
	$status = $_POST['status'];

	$image = $_FILES['image']['name'];
	$image_temp = $_FILES['image']['tmp_name'];

	$tags = $_POST['tags'];
	$content = $_POST['content'];
	$date = date('d-m-y');
	$comment_count = 0;

	move_uploaded_file($image_temp, "../images/$image");
}

?>
<h1 class="page-header">
	Add a Post
	<small></small>
</h1>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title" />
	</div>

	<div class="form-group">
		<label for="category">Post Category Id</label>
		<input type="text" class="form-control" name="category_id" />
	</div>

	<div class="form-group">
		<label for="title">Post Author</label>
		<input type="text" class="form-control" name="author" />
	</div>

	<div class="form-group">
		<label for="status">Post Status</label>
		<input type="text" class="form-control" name="status" />
	</div>

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" name="image" />
	</div>

	<div class="form-group">
		<label for="tags">Post Tags</label>
		<input type="text" class="form-control" name="tags" />
	</div>

	<div class="form-group">
		<label for="content">Post Content</label>
		<textarea class="form-control"
		          name="content"
		          id=""
		          rows="10"
		          cols="30"></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary"
		       type="submit"
		       name="submit"
		       value="Publish Post">
	</div>
</form>