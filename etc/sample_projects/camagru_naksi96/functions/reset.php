<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		echo "ERROR\n";
		$_SESSION["error"] = "Invalid email address!";
		header("Location: ../forgot.php");
		exit();
	}
	session_start();
	require_once '../config/setup.php';
	require_once 'email.php';
	if (isset($_POST["login"]) && isset($_POST["email"]))
	{
		$login = $_POST["login"];
		$email = $_POST["email"];
		$rand_pw = substr(hash("md5", rand(0, 1000)), 0, 9);
		$passwd = hash("whirlpool", $rand_pw);
		try {
			$check_db = "SELECT * FROM users WHERE login LIKE ? AND email LIKE ?";
			$sql = $conn->prepare($check_db);
			$sql->execute(array($login, $email));
			if ($sql->fetch()) {
				$replace = $conn->prepare("UPDATE users SET passwd=? WHERE login=? AND email=?");
				$replace->execute(Array($passwd, $login, $email));
				email_passwd($email, $login, $rand_pw);
				echo "<script type=\"text/javascript\">";
				echo "alert('New password has been sent out to your email. Please check your inbox.');";
				echo "window.location = ('../login.php');";
				echo "</script>";
				exit();
			}
			else {
				echo "SESSION ERROR\n";
				$_SESSION["error"] = "Wrong ID or Password!";
				header ('Location: ../forgot.php');
				exit();
			}
		} catch(PDOException $e) {
			echo $sql . "<br>" . $replace . "<br>" . $e->getMessage();
		}
	} else
	{
		echo "ERROR\n";
		$_SESSION["error"] = "Must fill out both fields!";
		header ('Location: ../forgot.php');
		exit();
	}
?>