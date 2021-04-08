<?php

function insert_category() {

	global $connection;

	if (isset($_POST['add_category'])) {
		$cat_title = $_POST['cat_title'];

		if ($cat_title === '' || empty($cat_title)) {
			echo 'This field should not be empty';
		} else {
			$query =
				"INSERT INTO categories (cat_title) VALUE ('{$cat_title}')";
			$create_category_query =
				mysqli_query($connection, $query);

			if (!$create_category_query) {
				die('QUERY FAILED' .
					mysqli_error($connection));
			}
		}
	}
}

function update_category() {
	global $connection;

	if (isset($_POST['update_category'])) {
		$cat_title = $_POST['cat_title'];
		$cat_id = $_GET['edit'];
		$query =
			"UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = '{$cat_id}'";
		$update_query = mysqli_query($connection, $query);
		header('Location: categories.php');
	}
}

function delete_category() {
	global $connection;

	if (isset($_GET['delete'])) {
		$cat_id = $_GET['delete'];

		$query =
			"DELETE FROM categories WHERE cat_id = {$cat_id}";
		$delete_query =
			mysqli_query($connection, $query);

		header('Location: categories.php');
	}
}

function find_all_categories() {
	global $connection;

	$query = "SELECT * FROM categories";
	$categories_query =
		mysqli_query($connection, $query);

	while ($row =
		mysqli_fetch_assoc($categories_query)) {
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		echo "<tr>" .
			"<td>{$cat_id}</td>" .
			"<td>{$cat_title}</td>" .
			"<td><a href='categories.php?delete={$cat_id}'>Delete</a><br>" .
			"<a href='categories.php?edit={$cat_id}'>Edit</a></td>" .
			"</tr>";
	}

}

function find_all_posts() {
	global $connection;

	$query = "SELECT * FROM posts";
	$posts_query =
		mysqli_query($connection, $query);

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

		echo "<tr>";
		echo "<td>$post_id</td>";
		echo "<td>$post_author</td>";
		echo "<td>$post_title</td>";
		echo "<td>$post_date</td>";
		echo "<td>$post_category_id</td>";
		echo "<td>$post_status</td>";
		echo "<td><img src='/images/{$post_image}' alt='' width='100px'></td>";
		echo "<td>$post_tags</td>";
		echo "<td>$post_comment_count</td>";
		echo "</tr>";
	}
}