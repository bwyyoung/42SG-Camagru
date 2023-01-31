<?php
	session_start();
	if (isset($_SESSION['loggued_on_user'])) {
		header('Location: /');
		exit();
	}
?>

<html>
	<head>
		<?php require_once ('template/head_includes.php'); ?>
		<title>Camagru - Login</title>
	</head>
	<script type="text/javascript" src="js/cookies.js"></script>
	<script>
		unsetCookie();
	</script>
	<body>
		<div class="whole_body">
			<?php require_once ('template/menu_bar.php'); ?>
			<div class="login-page">
				<div class="form">
					<form id="test" action="/functions/reset.php" method="POST">
						<div class="login_form">
							Please enter your login and email.<br><br>
							<input id="log" type="text" name="login" value="" required placeholder="Login"><br/>
							<input style="margin-top: 5px;" type="email" name="email" value="" required placeholder="Email"><br/>
							<?php
								if(isset($_SESSION["error"])){
									$error = $_SESSION["error"];
									echo "<span class='error'>$error</span>";
									unset($_SESSION["error"]);
								}
							?>
						<input type="submit" name="submit" value="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer>
			<i class="far fa-copyright"> 2019 doyang</i>
		</footer>
	</body>
</html>