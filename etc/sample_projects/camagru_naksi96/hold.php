<?php
session_start();
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
					<h2>Congratulations!</h2>
					you have one more step to go : <br>
					Please verify your email! <br><br>
					<form id="test" action="/functions/resend.php" method="POST">
						<div class="login_form">
							<input type="submit" name="submit" value="Resend Verification">
						</div>
					</form>
					<form id="test" action="/">
						<div class="login_form">
							<input type="submit" name="submit" value="To Login Page">
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