<?php

if (isset($_POST['submit'])) {
	add_user();
}

?>

<h1 class="page-header">
	Add a User
	<small></small>
</h1>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" class="form-control" name="username" />
	</div>

	<div class="form-group">
		<label for="category_id">Role</label>
		<select class="form-control" name="role">
			<option selected>Choose Role...</option>
			<?php
			$roles_query = get_all_roles();

			while ($row =
				mysqli_fetch_assoc($roles_query)) {
				$role_id = $row['role_id'];
				$role_title = $row['role_title'];

				echo "<option value='$role_id'>$role_title</option>";

			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="title">First Name</label>
		<input type="text" class="form-control" name="first_name" />
	</div>

	<div class="form-group">
		<label for="status">Last Name</label>
		<input type="text" class="form-control" name="last_name" />
	</div>

	<!--<div class="form-group">-->
	<!--	<label for="image">Post Image</label>-->
	<!--	<input type="file" name="image" />-->
	<!--</div>-->

	<div class="form-group">
		<label for="tags">Email</label>
		<input type="text" class="form-control" name="email" />
	</div>

	<div class="form-group">
		<label for="tags">Password</label>
		<input type="text" class="form-control" name="password" />
	</div>

	<div class="form-group">
		<input class="btn btn-primary"
		       type="submit"
		       name="submit"
		       value="Create User">
	</div>
</form>