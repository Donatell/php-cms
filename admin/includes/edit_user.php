<?php

if (isset($_GET['edit'])) {
	$user_id = $_GET['edit'];

	$row = get_user_by_id($user_id);
	if ($row == null) {
		header('Location: users.php?action=view_users');
		exit();
	}

	$username = $row['username'];
	$first_name = $row['user_first_name'];
	$last_name = $row['user_last_name'];
	$email = $row['user_email'];
	$role = $row['user_role'];
	$password = $row['user_password'];

	if (isset($_POST['submit'])) {
		update_user_by_id($user_id);
	}
}

?>

<h1 class="page-header">
	Edit User
	<small></small>
</h1>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" class="form-control" name="username" value="<?php
		echo $username ?>" />
	</div>

	<div class="form-group">
		<label for="category_id">Role</label>
		<select class="form-control" name="role">
			<?php
			$roles_query = get_all_roles();

			while ($row =
				mysqli_fetch_assoc($roles_query)) {
				$role_id = $row['role_id'];
				$role_title = $row['role_title'];

				if ($role_id === $role) {
					echo "<option selected value='$role_id'>$role_title</option>";
				} else {
					echo "<option value='$role_id'>$role_title</option>";
				}
			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="title">First Name</label>
		<input type="text" class="form-control" name="first_name"
		       value="<?php echo $first_name ?>" />
	</div>

	<div class="form-group">
		<label for="status">Last Name</label>
		<input type="text" class="form-control" name="last_name" value="<?php
		echo $last_name ?>" />
	</div>

	<!--<div class="form-group">-->
	<!--	<label for="image">Post Image</label>-->
	<!--	<input type="file" name="image" />-->
	<!--</div>-->

	<div class="form-group">
		<label for="tags">Email</label>
		<input type="text" class="form-control" name="email" value="<?php
		echo $email ?>" />
	</div>

	<div class="checkbox">
		<label>
			<input id="password-checkbox" type="checkbox"
			       name="new-password-checkbox"
			       value="yes" />Set new password?
		</label>
	</div>

	<div class="form-group hidden" id="password-input">
		<label for="new-password">New Password</label>
		<input type="text" class="form-control" name="new-password-input" />
	</div>

	<div class="form-group">
		<input class="btn btn-primary"
		       type="submit"
		       name="submit"
		       value="Update User">
	</div>
</form>