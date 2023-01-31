<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}

	session_start();

	if (!isset($_POST['login']) || !isset($_POST['email'])) {
		$_SESSION["error"] = "email/login must not be blank!";
		header('Location: ../myaccount.php?id=default');
		exit();
	}
	if (!$_POST["save_acct_details"] === "Save changes") {	
		echo "ERROR\n";
		$_SESSION["error"] = "Unknown approach!";
		header("Location: ../myaccount.php?id=default");
		exit();
	}
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		echo "ERROR\n";
		$_SESSION["error"] = "Invalid email address!";
		header("Location: ../myaccount.php?id=default");
		exit();
	}
	if (strlen($_POST["login"]) > 25 || strlen($_POST["login"]) < 3) {
		$_SESSION["error"] = "Login id must be between 3 and 25 characters.";
		header("Location: ../myaccount.php?id=default");
		exit();
	}

	require_once '../config/setup.php';
	try {
		if (!isset($_SESSION['loggued_on_user'])) {
			header ('Location: ../login.php');
			exit();
		} else {
			$email = $_POST['email'];
			$login = $_POST['login'];
			// dup check
			$check_dup_login = $conn->prepare("SELECT * FROM users WHERE login=?");
			$check_dup_login->execute(array($login));
			$check_dup_email = $conn->prepare("SELECT * FROM users WHERE email=?");
			$check_dup_email->execute(array($email));
			// prepare for search
			$search = $conn->prepare("SELECT login, email FROM users WHERE login=?");
			$search->execute(Array($_SESSION['loggued_on_user']));
			if ($var = $check_dup_login->fetch()) {
				if ($var['login'] !== $_SESSION['loggued_on_user']) {
					echo "ERROR\n";
					$_SESSION["error"] = "This login is already taken!";
					header("Location: ../myaccount.php?id=default");
					exit();
				}
			}
			if ($tmp = $check_dup_email->fetch()) {
				if ($tmp['login'] !== $_SESSION['loggued_on_user']) {
					echo "ERROR\n";
					$_SESSION["error"] = "This email is already taken!";
					header("Location: ../myaccount.php?id=default");
					exit();
				}
			}
			if ($checker = $search->fetch()) {
				$replace = $conn->prepare("UPDATE users SET login=?, email=? WHERE login=?");
				$replace->execute(Array($login, $email, $_SESSION['loggued_on_user']));
				$_SESSION['loggued_on_user'] = $login;
				$_SESSION["error"] = "Update Complete.";
				header("Location: ../myaccount.php?id=default");
				exit();
			} else {
				echo "FATAL ERROR";
				unset($_SESSION['loggued_on_user']);
				header("Location: ../login.php");
				exit();
			}
		}
	} catch(PDOException $e) {
		echo $check_dup_login . "<br>" . $check_dup_email . "<br>" . $search . "<br>" . $replace . "<br>" . $e->getMessage();
	}
?>