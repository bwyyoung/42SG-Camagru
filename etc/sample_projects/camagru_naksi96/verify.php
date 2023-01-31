<?php
	session_start();
	if (isset($_SESSION['loggued_on_user'])) {
		header('Location: /');
	}
	if (isset($_SESSION['unknown_user'])) {
		unset($_SESSION['unknown_user']);
	}
?>
<html>
	<head>
		<?php require_once('template/head_includes.php'); ?>
		<title>Camagru - Create a new account!</title>
	</head>
	<body>
		<div class="whole_body">
		<?php
			require_once 'template/menu_bar.php';
		?>
		<div class="login-page">
			<div class="form">
		<?php
			require_once 'config/setup.php';

			if (isset($_GET['email']) && !empty($_GET['email']) 
				&& isset($_GET['hash']) && !empty($_GET['hash'])
				&& filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
				// prevent query injection
				$email = basename($_GET['email']);
				$hash = basename($_GET['hash']);
				$sql = $conn->prepare("SELECT email, token, verified FROM users WHERE email=? AND token=? AND verified='0'");
				$sql->execute(array($email, $hash));
				$match = $sql->fetch();
				if ($match['email'] === $email) {
					$update = $conn->prepare("UPDATE users SET verified='1' WHERE email=? AND token=? AND verified='0'");
					$update->execute(array($email, $hash));
					echo '<div class="statusmsg">Your account has been activated, you may now login</div>';
				} else{
					// No match -> invalid url or account has already been activated.
					echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
				}
			} else {
				echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
			}
		?>
			</div>
		</div>
		</div>
		<footer>
			<i class="far fa-copyright"> 2019 doyang</i>
		</footer>
	</body>
</html>
