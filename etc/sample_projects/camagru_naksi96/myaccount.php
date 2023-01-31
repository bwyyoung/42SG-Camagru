<?php
	session_start();
	if (!isset($_SESSION["loggued_on_user"])) {
		header ('Location: login.php');
		exit();
	}
?>
<html>
	<head>
		<?php require_once('template/head_includes.php'); ?>
		<title>Camagru - My Account Page</title>
	</head>
	<body>
		<div class="whole_body">
			<?php require_once ('template/menu_bar.php'); ?>
			<div class="row my_acc">
				<div class="sidebar col-sm-4">
					<div class="side_menu und">
						<a href="myaccount.php?id=default">
							<i class="fas fa-user"></i>Account Info</a>
					</div>
					<div class="side_menu und">
						<a href="myaccount.php?id=Account_Privacy">
							<i class="fas fa-lock"></i>Account Privacy</a>
					</div>
					<div class="side_menu und">
						<a href="myaccount.php?id=notification">
							<i class="fas fa-bell"></i>Notification Setting</a>
					</div>
					<div class="side_menu">
						<a href="myaccount.php?id=remove_user">
							<i class="fas fa-user-slash" style="margin-right: 5px"></i>Delete Account</a>
					</div>
				</div>
				<div class="content col-sm-8">
					<?php
						$page_name = basename($_GET['id']);
						require_once("pages/$page_name.php");
					?>
				</div>
			</div>
		</div>
		<footer>
			<i class="far fa-copyright"> 2019 doyang</i>
		</footer>
	</body>
</html>