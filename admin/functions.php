<?php

// General
function confirm_query($query) {
	global $connection;

	if (!$query) {
		die('QUERY FAILED' .
			mysqli_error($connection));
	}
}

//Categories
function insert_category() {

	global $connection;

	if (isset($_POST['add_category'])) {
		$cat_title = $_POST['cat_title'];

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
		$cat_title = $_POST['cat_title'];
		$cat_id = $_GET['edit'];
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
		$cat_id = $_GET['delete'];

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
			"<td><a href='categories.php?delete=$cat_id'>Delete</a><br>" .
			"<a href='categories.php?edit=$cat_id'>Edit</a></td>" .
			"</tr>";
	}

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
		$post_comment_count = $row['post_comment_count'];

		$post_category_name = get_category_name_by_id($post_category_id);

		echo "<tr>";
		echo "<td>$post_id</td>";
		echo "<td>$post_author</td>";
		echo "<td>$post_title</td>";
		echo "<td>$post_date</td>";
		echo "<td>$post_category_name</td>";
		echo "<td>$post_status</td>";
		echo "<td><img src='/images/$post_image' alt='' width='100px'></td>";
		echo "<td>$post_tags</td>";
		echo "<td>$post_comment_count</td>";
		echo "<td><a href='posts.php?action=view_posts&delete=$post_id'>Delete</a><br>" .
			"<a href='posts.php?action=edit_post&edit=$post_id'>Edit</a></td>";
		echo "</tr>";
	}
}

function add_post() {
	global $connection;

	if (isset($_POST['submit'])) {
		$title = mysqli_real_escape_string($connection, $_POST['title']);
		$category_id = $_POST['category_id'];
		$author = $_POST['author'];
		$status = $_POST['status'];

		$image = $_FILES['image']['name'];
		$image_temp = $_FILES['image']['tmp_name'];

		$tags = mysqli_real_escape_string($connection, $_POST['tags']);
		$content = mysqli_real_escape_string($connection, $_POST['content']);
		$date = date('d-m-y');
		$comment_count = 0;

		$query =
			"INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count) VALUES ('$category_id', '$title', '$author', '$date', '$image', '$content', '$tags', '$comment_count')";

		$add_post_query = mysqli_query($connection, $query);

		confirm_query($add_post_query);

		move_uploaded_file($image_temp, "../images/$image");

		header('Location: posts.php?action=view_posts');

	}
}

function update_post($post_id) {
	global $connection;

	if (isset($_POST['submit_update'])) {
		$title = mysqli_real_escape_string($connection, $_POST['title']);
		$category_id = $_POST['category_id'];
		$author = $_POST['author'];
		$status = $_POST['status'];

		if (empty($_FILES['image']['name'])) {
			$row = get_post_by_id($post_id);
			$image = $row['post_image'];
		} else {
			$image = $_FILES['image']['name'];
			$image_temp = $_FILES['image']['tmp_name'];
		}

		$tags = mysqli_real_escape_string($connection, $_POST['tags']);
		$content = mysqli_real_escape_string($connection, $_POST['content']);

		$query =
			"UPDATE posts SET post_title = '$title', post_category_id = $category_id, post_author = '$author', post_status = '$status', post_tags = '$tags', post_content = '$content', post_image = '$image' WHERE post_id = $post_id";

		$update_post_query = mysqli_query($connection, $query);

		confirm_query($update_post_query);

		if (isset($image_temp)) {
			move_uploaded_file($image_temp, "../images/$image");
		}

		header('Location: posts.php?action=view_posts');

	}
}

function delete_post() {
	global $connection;

	if (isset($_GET['delete'])) {
		$deleted_post_id = $_GET['delete'];

		$query = "DELETE FROM posts WHERE post_id = $deleted_post_id";
		$delete_post_query = mysqli_query($connection, $query);
		confirm_query($delete_post_query);
	}
}

function get_post_by_id($id): array|null {
	global $connection;

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
		echo "<a href='posts.php?action=view_posts&approve=$post_id'>Approve
		</a><br>";
		echo "<a href='posts.php?action=edit_post&disapprove=$post_id'>Disapprove</a><br>";
		echo "<a href='posts.php?action=edit_post&delete=$post_id'>Delete</a><br>";
		echo "</td>";
		echo "</tr>";
	}
}

function add_comment() {
	global $connection;

	$post_id = $_GET['post_id'];

	$author = mysqli_real_escape_string($connection, $_POST['author']);
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$content = mysqli_real_escape_string($connection, $_POST['content']);

	$query =
		"INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content) VALUES ($post_id, '$author', '$email', '$content')";

	$add_comment_query = mysqli_query($connection, $query);

	confirm_query($add_comment_query);
}