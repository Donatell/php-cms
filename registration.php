<?php include "includes/head.php" ?>

<?php

$username_has_error = '';
$username_error_message = '';

$email_has_error = '';
$email_error_message = '';

$password_has_error = '';
$password_error_message = '';

if (isset($_POST['submit'])) {
	register_user();
}

?>

	<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

	<!-- Page Content -->
	<div class="container">

	<section id="login">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-xs-offset-3">
					<div class="form-wrap">
						<h1>Register</h1>
						<form role="form"
						      action="registration.php"
						      method="post"
						      id="login-form"
						      autocomplete="on">
							<div class="form-group <?php echo $username_has_error ?>">
								<label for="username"
								       class="sr-only">username</label>
								<input type="text"
								       name="username"
								       id="username"
								       class="form-control"
								       placeholder="Enter username.."
								       required>
								<?php

								if (!empty($username_has_error)) {
									echo "<span class='help-block'>$username_error_message</span>";
								}

								?>
							</div>
							<div class="form-group <?php echo $email_has_error ?>">
								<label for="email"
								       class="sr-only">Email</label>
								<input type="email"
								       name="email"
								       id="email"
								       class="form-control"
								       placeholder="somebody@example.com"
								       required>
								<?php

								if (!empty($email_has_error)) {
									echo "<span class='help-block'>$email_error_message</span>";
								}

								?>
							</div>
							<div class="form-group">
								<label for="password"
								       class="sr-only">Password</label>
								<input type="password"
								       name="password"
								       id="key"
								       class="form-control"
								       placeholder="Enter password..."
								       required>
							</div>

							<input type="submit"
							       name="submit"
							       id="btn-login"
							       class="btn btn-custom btn-lg btn-block"
							       value="Register">
						</form>

					</div>
				</div> <!-- /.col-xs-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</section>

	<hr>

<?php include "includes/footer.php"; ?>