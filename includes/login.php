<?php

include 'db.php';
include '../admin/functions.php';

if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	// Look for the user by username
	$row = get_user_by_username($username);

	// If user not found, redirect
	if (is_null($row)) {
		header('Location: ../index.php');
	}

	// extract user data if user exists

	$db_user_id = $row['user_id'];
	$db_username = $row['username'];
	$db_password = $row['user_password'];

	// start session if username and password are valid
	if (password_verify($password, $db_password) &&
		$username === $db_username) {
		session_start();
		$_SESSION['user_id'] = $db_user_id;

		header('Location: ../admin/index.php');

	} else {
		header('Location: ../index.php');
	}

}