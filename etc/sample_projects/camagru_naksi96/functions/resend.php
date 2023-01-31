<?php
// protection from direct access
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
session_start();
require_once 'email.php';
require_once '../config/setup.php';
try {
	if (isset($_SESSION['unknown_user'])) {
		$sql = $conn->prepare("SELECT login, email, token FROM users WHERE login=?");
		$sql->execute(Array($_SESSION['unknown_user']));
		if ($val = $sql->fetch()) {
			email_verify($val['email'], $val['login'], $val['token']);
			header("Location: ../hold.php");
			exit();
		} else {
			$_SESSION['error'] = "FAILED TO RESEND VERIFICATION EMAIL BY UNKNOWN REASON.";
			header("Location: ../login.php");
			exit();
		}
	} else {
		$_SESSION['error'] = "FAILED TO RESEND VERIFICATION EMAIL BY UNKNOWN REASON.";
		header("Location: ../login.php");
		exit();
	} 
} catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
}
?>