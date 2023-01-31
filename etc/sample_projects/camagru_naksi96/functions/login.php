<?php
// protection from direct access
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

session_start();
require_once '../config/setup.php';

if ($_POST["login"] && $_POST["passwd"])
{
	$login = $_POST["login"];
	$passwd = hash("whirlpool", $_POST["passwd"]);
	try {
		$check_db = "SELECT verified FROM users WHERE login LIKE ? AND passwd LIKE ?";
		$sql = $conn->prepare($check_db);
		$sql->execute(array($login, $passwd));
		if ($val = $sql->fetch()) {
			if ($val['verified']) {
				$_SESSION["loggued_on_user"] = $login;
				echo "OK\n";
				unset($_SESSION["error"]);
				header ("Location: ../");
				exit();
			} else {
				echo "SESSION unverified\n";
				$_SESSION["unknown_user"] = $login;
				header ('Location: ../hold.php');
				exit();
			}
		}
		else {
			echo "SESSION ERROR\n";
			$_SESSION["error"] = "Wrong ID or Password!";
			header ('Location: ../login.php');
			exit();
		}
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
} else
{
    echo "ERROR\n";
    $_SESSION["error"] = "Wrong ID or Password!";
    header ('Location: ../login.php');
    exit();
}
?>