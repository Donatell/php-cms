<?php

ob_start();

include "../includes/db.php";
include "functions.php";

session_start();

// check if user logged in
if ($_SESSION['user_id'] === null) {
	header('Location: ../../index.php');
	exit();
} else {
	$user_id = $_SESSION['user_id'];
	$row = get_user_by_id($user_id);
	$_SESSION['username'] = $row['username'];
	$_SESSION['first_name'] = $row['user_first_name'];
	$_SESSION['last_name'] = $row['user_last_name'];
	$_SESSION['email'] = $row['user_email'];
	$_SESSION['role'] = $row['user_role'];
	$_SESSION['password'] = $row['user_password'];

	// show dashboard if the user is admin (1), else show profile
	if ($_SESSION['role'] !== '1') {

		// avoid redirection loop
		if ($_SERVER['REQUEST_URI'] !==
			'/admin/users.php?action=view_profile') {
			header('Location: ./users.php?action=view_profile');
		}
	}

}

?>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SB Admin - Bootstrap Admin Template</title>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/sb-admin.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="font-awesome/css/font-awesome.min.css"
	      rel="stylesheet"
	      type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Column chart scripts-->
	<script type="text/javascript"
	        src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', { 'packages': ['bar'] });
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			const data = google.visualization.arrayToDataTable([
				['Date', 'Count'],

				<?php

				$data_element =
					['Published Posts',
					 'Draft Posts',
					 'Categories',
					 'Users',
					 'Pending Comments'];
				$count_element =
					[count_posts_with_status('published'),
					 count_posts_with_status('draft'),
					 count_categories(),
					 count_users(),
					 count_pending_comments()];

				$arr_length = count($data_element);
				for ($i = 0; $i < $arr_length; $i++) {
					echo "['$data_element[$i]', $count_element[$i]], ";
				}

				?>
			]);

			const options = {
				chart: {
					title: 'Company Performance',
					subtitle: 'Sales, Expenses, and Profit: 2014-2017'
				}
			};

			const chart = new google.charts.Bar(
				document.getElementById('columnchart_material'));

			chart.draw(data, google.charts.Bar.convertOptions(options));
		}
	</script>

	<!-- CKEditor 5 -->
	<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
</head>