<?php
// protection from direct access
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

session_start();
if (!isset($_POST["passwd"]) || !isset($_POST["login"])) {
	echo "ERROR\n";
	$_SESSION["error"] = "All sections must be filled in";
	header("Location: ../myaccount.php?id=remove_user");
	exit();
}
if ($_POST['login'] !== $_SESSION['loggued_on_user']) {
	echo "ERROR\n";
	$_SESSION["error"] = "Your login does not match.";
	header("Location: ../myaccount.php?id=remove_user");
	exit();
}

require_once '../config/setup.php';
try {
	$login = $_POST['login'];
	$passwd = hash("whirlpool", $_POST['passwd']);
	$val = $conn->prepare("SELECT * FROM users WHERE login=? AND passwd=?");
	$val->execute(Array($login, $passwd));
	if ($val->fetch()) {
		$sql = $conn->prepare("DELETE FROM users WHERE login=? AND passwd=?");
		$sql->execute(Array($login, $passwd));
		if ($sql->rowCount()) {
			$file_del = $conn->prepare("SELECT * FROM posts WHERE login=?");
			$file_del->execute(Array($login));
			$file = $file_del->fetchAll();
			foreach ($file as $val) {
				unlink($val['img']);
			}
			$delete_post = $conn->prepare("DELETE FROM posts WHERE login=?");
			$delete_post->execute(Array($login));
			$delete_likes = $conn->prepare("DELETE FROM likes WHERE login=?");
			$delete_likes->execute(Array($login));
			$delete_comments = $conn->prepare("DELETE FROM comments WHERE login=?");
			$delete_comments->execute(Array($login));
			unset($_SESSION['error']);
			unset($_SESSION['loggued_on_user']);
			echo "<script type=\"text/javascript\">";
			echo "alert('You have successfully deleted your account.');";
			echo "window.location = ('../login.php');";
			echo "</script>";
			exit();
		} else {
			echo "ERROR\n";
			$_SESSION["error"] = "Failed to delete your account.";
			header("Location: ../myaccount.php?id=remove_user");
			exit();
		}
	} else {
		echo "ERROR\n";
		$_SESSION["error"] = "Your password does not match.";
		header("Location: ../myaccount.php?id=remove_user");
		exit();
	}
} catch(PDOException $e) {
	echo $sql . "<br>" . $val . "<br>" . $e->getMessage();
}
?>