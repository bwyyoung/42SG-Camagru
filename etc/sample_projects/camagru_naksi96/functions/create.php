<?php
// protection from direct access
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

session_start();
if ($_POST["passwd"] !== $_POST["passwd_conf"]) {
	echo "ERROR\n";
	$_SESSION["error"] = "Your password does not match";
	header("Location: ../create.php");
	exit();
}
if (!$_POST["submit"] === "submit" || !$_POST["login"] || !$_POST["passwd"]) {	
	echo "ERROR\n";
	$_SESSION["error"] = "Please verify login/password";
	header("Location: ../create.php");
	exit();
}
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	echo "ERROR\n";
	$_SESSION["error"] = "Invalid email address!";
	header("Location: ../create.php");
	exit();
}
if (strlen($_POST["login"]) > 25 || strlen($_POST["login"]) < 3) {
	$_SESSION["error"] = "Login id must be between 3 and 25 characters.";
	header("Location: ../create.php");
	exit();
}
if (strlen($_POST["passwd"]) > 25 || strlen($_POST["passwd"]) < 8) {
	$_SESSION["error"] = "Password must be between 8 and 25 characters.";
	header("Location: ../create.php");
	exit();
}
if (!preg_match("#[0-9]+#", $_POST["passwd"]) || !preg_match("#[a-z]+#", $_POST["passwd"])
	|| !preg_match("#[A-Z]+#", $_POST["passwd"]) || !preg_match("#\W+#", $_POST["passwd"])) {
	$_SESSION["error"] = "Password must include at least one letter, CAPS, number, and special character.";
	header("Location: ../create.php");
	exit();
}

require_once '../config/setup.php';
require_once 'email.php';
try {
	// get user input
	$login = $_POST["login"];
	$passwd = hash("whirlpool", $_POST["passwd"]);
	$email = $_POST["email"];
	$notice = (isset($_POST["notice"]) && $_POST["notice"] === 'on') ? 1 : 0;
	$token = hash("md5", rand(0,1000));
	// check for dup
	$check_dup_login = $conn->prepare("SELECT * FROM users WHERE login=?");
	$check_dup_login->execute(array($login));
	$check_dup_email = $conn->prepare("SELECT * FROM users WHERE email=?");
	$check_dup_email->execute(array($email));
	if ($check_dup_login->fetch()) {
		echo "ERROR\n";
		$_SESSION["error"] = "This login is already taken!";
		header("Location: ../create.php");
		exit();
	}
	else if ($check_dup_email->fetch()) {
		echo "ERROR\n";
		$_SESSION["error"] = "This email is already taken!";
		header("Location: ../create.php");
		exit();
	} else { // store in db
		$sql = $conn->prepare("INSERT INTO users (login, passwd, email, notification, token)
								VALUES (:login, :passwd, :email, :notification, :token)");
		$sql->bindParam(':login', $login);
		$sql->bindParam(':passwd', $passwd);
		$sql->bindParam(':email', $email);
		$sql->bindParam(':notification', $notice);
		$sql->bindParam(':token', $token);
		// execute prepared
		$sql->execute();
		email_verify($email, $login, $token);
		echo "<script type=\"text/javascript\">";
		echo "alert('You have successfully created your account! Please verify your email.');";
		echo "window.location = ('../login.php');";
		echo "</script>";
		exit();
	}
} catch(PDOException $e) {
	echo $sql . "<br>" . $check_dup_login . "<br>" . $check_dup_email . "<br>" . $e->getMessage();
}
?>