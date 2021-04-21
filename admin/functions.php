<?php

// General
function confirm_query($query) {
	global $connection;

	if (!$query) {
		die('QUERY FAILED' .
			mysqli_error($connection));
	}
}

function escape($string) {
	global $connection;

	return mysqli_real_escape_string($connection, trim(strip_tags($string)));
}

//Categories
function insert_category() {

	global $connection;

	if (isset($_POST['add_category'])) {
		$cat_title = escape($_POST['cat_title']);

		if ($cat_title === '' || empty($cat_title)) {
			echo 'This field should not be empty';
		} else {
			$query =
				"INSERT INTO categories (cat_title) VALUE ('$cat_title')";
			$create_category_query =
				mysqli_query($connection, $query);

			confirm_query($create_category_query);
		}
	}
}

function update_category() {
	global $connection;

	if (isset($_POST['update_category'])) {
		$cat_title = escape($_POST['cat_title']);
		$cat_id = escape($_GET['edit']);

		$query =
			"UPDATE categories SET cat_title = '$cat_title' WHERE cat_id = '$cat_id'";
		$update_category_query = mysqli_query($connection, $query);

		confirm_query($update_category_query);

		header('Location: categories.php');
	}
}

function delete_category() {
	global $connection;

	if (isset($_GET['delete'])) {
		$cat_id = escape($_GET['delete']);

		$query =
			"DELETE FROM categories WHERE cat_id = $cat_id";
		$delete_category_query = mysqli_query($connection, $query);

		confirm_query($delete_category_query);

		header('Location: categories.php');
	}
}

function get_all_categories(): mysqli_result|bool {
	global $connection;

	$query = 'SELECT * FROM categories';
	$categories_query =
		mysqli_query($connection, $query);

	confirm_query($categories_query);

	return $categories_query;
}

function get_category_name_by_id($id) {
	global $connection;

	$query = "SELECT * FROM categories WHERE cat_id = $id";
	$category_query =
		mysqli_query($connection, $query);

	confirm_query($category_query);

	$row = mysqli_fetch_assoc($category_query);

	return $row['cat_title'];
}

function find_all_categories() {
	$categories_query = get_all_categories();

	while ($row =
		mysqli_fetch_assoc($categories_query)) {
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		echo "<tr>" .
			"<td>$cat_id</td>" .
			"<td>$cat_title</td>" .
			"<td><a href='categories.php?delete=$cat_id' onClick=\"javascript: return confirm('Are you sure you want to delete?')\">Delete</a><br>" .
			"<a href='categories.php?edit=$cat_id'>Edit</a></td>" .
			"</tr>";
	}

}

function count_categories() {
	global $connection;

	$query = "SELECT COUNT(*) AS total FROM categories";
	$count_categories_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_categories_query)['total'];
}

// Posts
function find_all_posts() {
	global $connection;

	$query = "SELECT * FROM posts";
	$posts_query =
		mysqli_query($connection, $query);

	confirm_query($posts_query);

	while ($row =
		mysqli_fetch_assoc($posts_query)) {
		$post_id = $row['post_id'];
		$post_author = $row['post_author'];
		$post_title = $row['post_title'];
		$post_date = $row['post_date'];
		$post_category_id = $row['post_category_id'];
		$post_status = $row['post_status'];
		$post_image = $row['post_image'];
		$post_tags = $row['post_tags'];
		$post_comment_count = count_comments_by_post_id($post_id);
		$post_view_count = $row['post_view_count'];

		$post_category_name = get_category_name_by_id($post_category_id);

		echo "<tr>";

		?>

		<td><input type='checkbox' class='checkbox' name='checkbox_array[]'
		           value="<?php echo $post_id ?>"
			></td>

		<?php

		echo "<td>$post_id</td>";
		echo "<td>$post_author</td>";
		echo "<td><a href='/post.php?post_id=$post_id'>$post_title</a></td>";
		echo "<td>$post_date</td>";
		echo "<td>$post_category_name</td>";
		echo "<td>$post_status</td>";
		echo "<td><img src='/images/$post_image' alt='' width='100px'></td>";
		echo "<td>$post_tags</td>";
		echo "<td><a href='comments.php?action=view_post_comments&post_id=$post_id'>$post_comment_count</a></td>";
		echo "<td>$post_view_count</td>";
		echo "<td><a href='posts.php?action=view_posts&delete=$post_id' onClick=\"javascript: return confirm('Are you sure you want to delete?')\">Delete</a><br>" .
			"<a href='posts.php?action=edit_post&edit=$post_id'>Edit</a></td>";
		if ($post_status === 'draft') {
			echo "<td><a href='posts.php?action=view_posts&publish=$post_id'>Publish</a><br></td>";
		} else {
			echo "<td><a href='posts.php?action=view_posts&withdraw=$post_id'>Withdraw</a></td>";
		}
		echo "</tr>";
	}
}

function add_post() {
	global $connection;

	if (isset($_POST['submit'])) {
		$title = escape($_POST['title']);
		$category_id = escape($_POST['category_id']);
		$author = escape($_POST['author']);

		if (isset($_POST['publish_now']) &&
			escape($_POST['publish_now']) === 'yes') {
			$status = 'published';
		} else {
			$status = 'draft';
		}

		$image = $_FILES['image']['name'];
		$image_temp = $_FILES['image']['tmp_name'];

		$tags = escape($_POST['tags']);
		$content = $_POST['content'];
		$date = date('d-m-y');

		$query =
			"INSERT INTO posts (post_category_id, post_title, post_status,post_author, post_date, post_image, post_content, post_tags) VALUES ('$category_id', '$title', '$status','$author', '$date', '$image', '$content', '$tags')";
		$add_post_query = mysqli_query($connection, $query);
		confirm_query($add_post_query);

		move_uploaded_file($image_temp, "../images/$image");

		$title = urlencode($title);
		header("Location: posts.php?action=view_posts&created=$title");
	}
}

function update_post($post_id) {
	global $connection;

	if (isset($_POST['submit_update'])) {
		$title = escape($_POST['title']);
		$category_id = escape($_POST['category_id']);
		$author = $_POST['author'];

		if (isset($_POST['publish_now']) &&
			escape($_POST['publish_now']) === 'yes') {
			$status = 'published';
		} else {
			$status = 'draft';
		}

		if (empty($_FILES['image']['name'])) {
			$row = get_post_by_id($post_id);
			$image = $row['post_image'];
		} else {
			$image = $_FILES['image']['name'];
			$image_temp = $_FILES['image']['tmp_name'];
		}

		$tags = escape($_POST['tags']);
		$content = $_POST['content'];

		$query =
			"UPDATE posts SET post_title = '$title', post_category_id = $category_id, post_author = '$author', post_status = '$status', post_tags = '$tags', post_content = '$content', post_image = '$image', post_comment_count = $comment_count WHERE post_id = $post_id";
		$update_post_query = mysqli_query($connection, $query);
		confirm_query($update_post_query);

		if (isset($image_temp)) {
			move_uploaded_file($image_temp, "../images/$image");
		}

		$title = urlencode($title);
		header("Location: posts.php?action=view_posts&edited=$title");
	}
}

function delete_post() {
	global $connection;

	if (isset($_GET['delete'])) {
		$deleted_post_id = escape($_GET['delete']);

		$query = "DELETE FROM posts WHERE post_id = $deleted_post_id";
		$delete_post_query = mysqli_query($connection, $query);
		confirm_query($delete_post_query);

		header('Location: posts.php?action=view_posts');
	}
}

function delete_post_by_id($post_id) {
	global $connection;

	$query = "DELETE FROM posts WHERE post_id = $post_id";
	$delete_post_query = mysqli_query($connection, $query);
	confirm_query($delete_post_query);
}

function get_post_by_id($id): array|null {
	global $connection;

	$id = escape($id);

	if (isset($id)) {
		$edited_post_id = $id;

		$query = "SELECT * FROM posts WHERE post_id = $edited_post_id";
		$edit_post_query =
			mysqli_query($connection, $query);

		confirm_query($edit_post_query);

		return mysqli_fetch_assoc($edit_post_query);
	} else {
		return null;
	}
}

function clone_post_by_id($id) {
	global $connection;

	$id = escape($id);

	$row = get_post_by_id($id);

	$title = $row['post_title'];
	$category_id = $row['post_category_id'];
	$author = $row['post_author'];
	$status = $row['post_status'];
	$image = $row['post_image'];
	$tags = $row['post_tags'];
	$content = $row['post_content'];
	$date = date('d-m-y');

	$query =
		"INSERT INTO posts (post_category_id, post_title, post_status,post_author, post_date, post_image, post_content, post_tags) VALUES ('$category_id', '$title', '$status','$author', '$date', '$image', '$content', '$tags')";
	$clone_post_query = mysqli_query($connection, $query);
	confirm_query($clone_post_query);
}

function set_post_status_post_by_id($id, $status) {
	global $connection;

	$id = escape($id);
	$status = escape($status);

	$query = "UPDATE posts SET post_status = '$status' WHERE post_id = $id";
	$set_post_status_query =
		mysqli_query($connection, $query);

	confirm_query($set_post_status_query);
}

function increment_post_view_count_by_id($id) {
	global $connection;

	$id = escape($id);

	$query =
		"UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $id";
	$increment_post_view_query = mysqli_query($connection, $query);
	confirm_query($increment_post_view_query);
}

function count_posts() {
	global $connection;

	$query = "SELECT COUNT(*) AS total FROM posts";
	$count_posts_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_posts_query)['total'];
}

function count_posts_with_status($status) {
	global $connection;

	$status = escape($status);

	$query =
		"SELECT COUNT(*) AS total FROM posts WHERE post_status = '$status'";
	$count_posts_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_posts_query)['total'];
}

function count_published_posts_by_category_id($category_id) {
	global $connection;

	$category_id = escape($category_id);

	$query =
		"SELECT COUNT(*) AS total FROM posts WHERE post_status = 'published' AND post_category_id = $category_id";
	$count_posts_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_posts_query)['total'];
}

function count_published_posts_by_author($author) {
	global $connection;

	$author = escape($author);

	$query =
		"SELECT COUNT(*) AS total FROM posts WHERE post_status = 'published' AND post_author = '$author'";
	$count_posts_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_posts_query)['total'];
}

// Comments
function find_all_comments() {
	global $connection;

	$query = "SELECT * FROM comments";
	$comments_query =
		mysqli_query($connection, $query);

	confirm_query($comments_query);

	while ($row =
		mysqli_fetch_assoc($comments_query)) {
		$id = $row['comment_id'];
		$post_id = $row['comment_post_id'];
		$author = $row['comment_author'];
		$email = $row['comment_email'];
		$content = $row['comment_content'];
		$status = $row['comment_status'];
		$date = $row['comment_date'];

		$post_title = get_post_by_id($post_id)['post_title'];

		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td><a href='/post.php?post_id=$post_id'>$post_title</a></td>";
		echo "<td>$author</td>";
		echo "<td>$email</td>";
		echo "<td>$content</td>";
		echo "<td>$status</td>";
		echo "<td>$date</td>";
		echo "<td>";
		echo "<a href='comments.php?action=view_comments&approve=$id'>Approve
		</a><br>";
		echo "<a href='comments.php?action=view_comments&disapprove=$id'>Disapprove</a><br>";
		echo "<a href='comments.php?action=view_comments&delete=$id&post_id=$post_id' onClick=\"javascript: return confirm('Are you sure you want to delete?')\">Delete</a><br>";
		echo "</td>";
		echo "</tr>";
	}
}

function find_all_comments_by_post_id($post_id) {
	global $connection;

	$post_ii = escape($post_id);

	$query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
	$comments_query =
		mysqli_query($connection, $query);
	confirm_query($comments_query);

	while ($row =
		mysqli_fetch_assoc($comments_query)) {
		$id = $row['comment_id'];
		$author = $row['comment_author'];
		$email = $row['comment_email'];
		$content = $row['comment_content'];
		$status = $row['comment_status'];
		$date = $row['comment_date'];

		$post_title = get_post_by_id($post_id)['post_title'];

		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td><a href='/post.php?post_id=$post_id'>$post_title</a></td>";
		echo "<td>$author</td>";
		echo "<td>$email</td>";
		echo "<td>$content</td>";
		echo "<td>$status</td>";
		echo "<td>$date</td>";
		echo "<td>";
		echo "<a href='comments.php?action=view_post_comments&post_id=$post_id&approve=$id'>Approve
		</a><br>";
		echo "<a href='comments.php?action=view_post_comments&post_id=$post_id&disapprove=$id'>Disapprove</a><br>";
		echo "<a href='comments.php?action=view_post_comments&post_id=$post_id&delete=$id&post_id=$post_id' onClick=\"javascript: return confirm('Are you sure you want to delete?')\">Delete</a><br>";
		echo "</td>";
		echo "</tr>";
	}
}

function add_comment() {
	global $connection;

	$post_id = escape($_GET['post_id']);

	$author = mysqli_real_escape_string($connection, $_POST['author']);
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$content = mysqli_real_escape_string($connection, $_POST['content']);

	if (empty($author) || empty($email) || empty($content)) {
		return;
	}

	$comment_query =
		"INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content) VALUES ($post_id, '$author', '$email', '$content')";
	$add_comment_query = mysqli_query($connection, $comment_query);
	confirm_query($add_comment_query);
}

function delete_comment() {
	global $connection;

	$comment_id = escape($_GET['delete']);
	$post_id = escape($_GET['post_id']);

	$query =
		"DELETE FROM comments WHERE comment_id = $comment_id";
	$delete_comment_query = mysqli_query($connection, $query);

	confirm_query($delete_comment_query);
}

function approve_comment_by_id($id) {
	global $connection;

	$id = escape($id);

	$query =
		"UPDATE comments SET comment_status = 'approved' WHERE comment_id = $id";
	$approve_comment_query = mysqli_query($connection, $query);

	confirm_query($approve_comment_query);
}

function disapprove_comment_by_id($id) {
	global $connection;

	$id = escape($id);

	$query =
		"UPDATE comments SET comment_status = 'disapproved' WHERE comment_id = $id";
	$disapprove_comment_query = mysqli_query($connection, $query);

	confirm_query($disapprove_comment_query);
}

function get_approved_comments_by_post_id($post_id): mysqli_result|bool {
	global $connection;

	$post_id = escape($post_id);

	$query =
		"SELECT * FROM comments WHERE comment_status = 'approved' AND comment_post_id = $post_id";
	$approved_comments_query =
		mysqli_query($connection, $query);

	confirm_query($approved_comments_query);

	return $approved_comments_query;
}

function count_comments() {
	global $connection;

	$query = "SELECT COUNT(*) AS total FROM comments";
	$count_comments_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_comments_query)['total'];
}

function count_comments_by_post_id($post_id) {
	global $connection;

	$post_id = escape($post_id);

	$query =
		"SELECT COUNT(1) AS total FROM comments WHERE comment_post_id = $post_id";
	$count_comments_query = mysqli_query($connection, $query);
	confirm_query($count_comments_query);

	return mysqli_fetch_assoc($count_comments_query)['total'];
}

function count_pending_comments() {
	global $connection;

	$query =
		"SELECT COUNT(*) AS total FROM comments WHERE comment_status = 'pending'";
	$count_comments_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_comments_query)['total'];
}

// Users
function find_all_users() {
	global $connection;

	$query = "SELECT * FROM users";
	$users_query =
		mysqli_query($connection, $query);

	confirm_query($users_query);

	while ($row =
		mysqli_fetch_assoc($users_query)) {
		$id = $row['user_id'];
		$username = $row['username'];
		$firstname = $row['user_first_name'];
		$lastname = $row['user_last_name'];
		$email = $row['user_email'];
		$role = get_role_title_by_id($row['user_role']);

		echo "<tr>";
		echo "<td>$id</td>";
		echo "<td>$username</td>";
		echo "<td>$firstname</td>";
		echo "<td>$lastname</td>";
		echo "<td>$email</td>";
		echo "<td>$role</td>";
		// echo "<td><img src='/images/$post_image' alt='' width='100px'></td>";
		echo "<td><a href='users.php?action=view_users&delete=$id' onClick=\"javascript: return confirm('Are you sure you want to delete?')\">Delete</a><br>" .
			"<a href='users.php?action=edit_user&edit=$id'>Edit</a></td>";
		echo "</tr>";
	}
}

function add_user() {
	global $connection;

	$username = escape($_POST['username']);
	$first_name = escape($_POST['first_name']);
	$last_name = escape($_POST['last_name']);
	$email = escape($_POST['email']);
	$password = $_POST['password'];
	$role = escape($_POST['role']);

	//	$image = $_FILES['image']['name'];
	//	$image_temp = $_FILES['image']['tmp_name'];

	$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

	$query =
		"INSERT INTO users (username, user_password, user_first_name, user_last_name, user_email, user_role) VALUES ('$username', '$password', '$first_name', '$last_name', '$email', $role)";

	$add_user_query = mysqli_query($connection, $query);

	confirm_query($add_user_query);

	//	move_uploaded_file($image_temp, "../images/$image");
	$username = urlencode($username);
	header("Location: users.php?action=view_users&created=$username");
}

function get_user_by_id($user_id) {
	global $connection;

	$user_id = escape($user_id);

	$query = "SELECT * FROM users WHERE user_id = $user_id";
	$get_user_query =
		mysqli_query($connection, $query);
	confirm_query($get_user_query);

	// if user not found, clear session and refresh page
	if (mysqli_num_rows($get_user_query)
		== null) {
		return null;
	} else {
		return mysqli_fetch_assoc($get_user_query);
	}
}

function get_user_by_username($username): array|bool|null {
	global $connection;

	$username = escape($username);

	$query = "SELECT * FROM users WHERE username = '$username'";
	$user_query =
		mysqli_query($connection, $query);

	confirm_query($user_query);

	return mysqli_fetch_assoc($user_query);
}

function count_users() {
	global $connection;

	$query = "SELECT COUNT(*) AS total FROM users";
	$count_users_query = mysqli_query($connection, $query);

	return mysqli_fetch_assoc($count_users_query)['total'];
}

function register_user() {
	global $connection;

	$username = escape($_POST['username']);
	$email = escape($_POST['email']);
	$password = $_POST['password'];

	$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

	$query =
		"INSERT INTO users (username, user_password, user_email) VALUES ('$username', '$password', '$email')";

	$add_user_query = mysqli_query($connection, $query);

	//	if (mysqli_error($connection) ===
	//		"Duplicate entry '$username' for key 'username'") {
	//		$username_has_error = 'has-error';
	//		$username_error_message = 'The username is already taken';
	//		return;
	//	} else {
	//		$username_has_error = 'has-success';
	//	}
	//
	//	if (mysqli_error($connection) ===
	//		"Duplicate entry '$email' for key 'user_email'") {
	//		$email_has_error = 'has-error';
	//		$email_error_message = 'The email is already taken';
	//		return;
	//	} else {
	//		$email_has_error = 'has-success';
	//	}

	confirm_query($add_user_query);
}

// Roles
function get_all_roles(): mysqli_result|bool {
	global $connection;

	$query = 'SELECT * FROM roles';
	$roles_query =
		mysqli_query($connection, $query);

	confirm_query($roles_query);

	return $roles_query;
}

function get_role_title_by_id($id) {
	global $connection;

	$id = escape($id);

	$query = "SELECT * FROM roles WHERE role_id = $id";
	$role_query =
		mysqli_query($connection, $query);

	confirm_query($role_query);

	$row = mysqli_fetch_assoc($role_query);

	return $row['role_title'];
}

function delete_user_by_id($id) {
	global $connection;

	$id = escape($id);

	$query =
		"DELETE FROM users WHERE user_id = $id";
	$delete_user_query = mysqli_query($connection, $query);

	confirm_query($delete_user_query);

	header('Location: users.php?action=view_users');
}

function update_user_by_id($user_id) {
	global $connection;

	$user_id = escape($user_id);

	$username = escape($_POST['username']);
	$first_name = escape($_POST['first_name']);
	$last_name = escape($_POST['last_name']);
	$email = escape($_POST['email']);
	$role = escape($_POST['role']);

	//		if (empty($_FILES['image']['name'])) {
	//			$row = get_post_by_id($post_id);
	//			$image = $row['post_image'];
	//		} else {
	//			$image = $_FILES['image']['name'];
	//			$image_temp = $_FILES['image']['tmp_name'];
	//		}

	$query =
		"UPDATE users SET username = '$username', user_first_name = '$first_name', user_last_name = '$last_name', user_email = '$email', user_role = $role WHERE user_id = $user_id";
	$update_user_query = mysqli_query($connection, $query);
	confirm_query($update_user_query);

	if (isset($_POST['new-password-checkbox']) &&
		escape($_POST['new-password-checkbox']) == 'yes' &&
		isset($_POST['new-password-input'])) {

		$new_password = $_POST['new-password-input'];
		$new_password = password_hash($new_password, PASSWORD_BCRYPT,
			['cost' => 12]);

		$query =
			"UPDATE users SET user_password = '$new_password' WHERE user_id = $user_id";
		$update_password_query = mysqli_query($connection, $query);
		confirm_query($update_password_query);
	}

	//		if (isset($image_temp)) {
	//			move_uploaded_file($image_temp, "../images/$image");
	//		}

	$username = urlencode($username);
	header("Location: users.php?action=view_users&edited=$username");
}

/**
 * Send update query, confirm it and refresh page
 * @param $user_id
 */
function update_user_profile_by_id($user_id) {
	global $connection;

	$username = escape($_POST['username']);
	$first_name = escape($_POST['first_name']);
	$last_name = escape($_POST['last_name']);
	$email = escape($_POST['email']);
	$role = escape($_POST['role']);

	//		if (empty($_FILES['image']['name'])) {
	//			$row = get_post_by_id($post_id);
	//			$image = $row['post_image'];
	//		} else {
	//			$image = $_FILES['image']['name'];
	//			$image_temp = $_FILES['image']['tmp_name'];
	//		}

	$query =
		"UPDATE users SET username = '$username', user_first_name = '$first_name', user_last_name = '$last_name', user_email = '$email', user_role = '$role' WHERE user_id = $user_id";
	$update_profile_query = mysqli_query($connection, $query);
	confirm_query($update_profile_query);

	//		if (isset($image_temp)) {
	//			move_uploaded_file($image_temp, "../images/$image");
	//		}

	header('Location: users.php?action=view_profile');
}