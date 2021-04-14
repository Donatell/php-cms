<?php add_post() ?>

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
		<label for="category_id">Category</label>
		<select class="form-control" name="category_id">
			<option selected>Choose Category...</option>
			<?php
			$categories_query = get_all_categories();

			while ($row =
				mysqli_fetch_assoc($categories_query)) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];

				echo "<option value='$cat_id'>$cat_title</option>";

			}
			?>
		</select>
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