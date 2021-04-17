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
	$db_username = $row['username'];
	$db_password = $row['user_password'];
	$db_email = $row['user_email'];
	$db_first_name = $row['user_first_name'];
	$db_last_name = $row['user_last_name'];
	$db_role = $row['user_role'];

	// start session if username and password are valid
	if ($password === $db_password && $username === $db_username) {
		session_start();
		$_SESSION['username'] = $db_username;
		$_SESSION['first_name'] = $db_first_name;
		$_SESSION['last_name'] = $db_last_name;
		$_SESSION['role'] = $db_role;
	}
	
	header('Location: ../index.php');
}