<?php

if (isset($_GET['edit'])) {
	$row = get_post_by_id($_GET['edit']);

	$id = $row['post_id'];
	$author = $row['post_author'];
	$title = $row['post_title'];
	$date = $row['post_date'];
	$category_id = $row['post_category_id'];
	$status = $row['post_status'];
	$content = $row['post_content'];
	$image = $row['post_image'];
	$tags = $row['post_tags'];
	$comment_count = $row['post_comment_count'];

	if (isset($_POST['submit_update'])) {
		update_post($id);
	}
}

?>

<h1 class="page-header">
	Edit Post
	<small></small>
</h1>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Title</label>
		<input value="<?php echo $title ?>" type="text" class="form-control"
		       name="title" />
	</div>

	<div class="form-group">
		<label for="category_id">Category</label>
		<select class="form-control" name="category_id">
			<?php
			$categories_query = get_all_categories();

			while ($row =
				mysqli_fetch_assoc($categories_query)) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];

				if ($cat_id == $category_id) {
					echo "<option selected value='$cat_id'>$cat_title</option>";
				} else {
					echo "<option value='$cat_id'>$cat_title</option>";
				}

			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="title">Author</label>
		<input value="<?php echo $author ?>" type="text" class="form-control"
		       name="author" />
	</div>

	<div class="form-group">
		<label for="status">Status</label>
		<input value="<?php echo $status ?>" type="text" class="form-control"
		       name="status" />
	</div>

	<div class="form-group">
		<label>Current Image</label>
		<img src="../images/<?php echo $image ?>" width="100px" alt="">
	</div>

	<div class="form-group">
		<label for="image">Upload New Image</label>
		<input type="file" name="image" />
	</div>

	<div class="form-group">
		<label for="tags">Tags</label>
		<input value="<?php echo $tags ?>" type="text" class="form-control"
		       name="tags" />
	</div>

	<div class="form-group">
		<label for="content">Content</label>
		<textarea class="form-control"
		          name="content"
		          id=""
		          rows="10"
		          cols="30"><?php echo $content ?></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary"
		       type="submit"
		       name="submit_update"
		       value="Update Post">
	</div>
</form>