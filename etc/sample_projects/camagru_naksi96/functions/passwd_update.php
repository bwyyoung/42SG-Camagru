<?php
// protection from direct access
if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}

session_start();
if (!isset($_POST["newpw"]) || !isset($_POST["oldpw"]) || !isset($_POST["newpw_conf"])) {
	echo "ERROR\n";
	$_SESSION["error"] = "All sections must be filled in";
	header("Location: ../myaccount.php?id=Account_Privacy");
	exit();
}
if ($_POST["newpw"] !== $_POST["newpw_conf"]) {
	echo "ERROR\n";
	$_SESSION["error"] = "Your password does not match";
	header("Location: ../myaccount.php?id=Account_Privacy");
	exit();
}
if (!$_POST["save_acct_pw"] === "Save changes") {	
	echo "ERROR\n";
	$_SESSION["error"] = "Unknown approach!";
	header("Location: ../myaccount.php?id=Account_Privacy");
	exit();
}
if (strlen($_POST["oldpw"]) > 25 || strlen($_POST["oldpw"]) < 3) {
	$_SESSION["error"] = "Password must be between 3 and 25 characters.";
	header("Location: ../myaccount.php?id=Account_Privacy");
	exit();
}
if (!preg_match("#[0-9]+#", $_POST["newpw"]) || !preg_match("#[a-z]+#", $_POST["newpw"])
	|| !preg_match("#[A-Z]+#", $_POST["newpw"]) || !preg_match("#\W+#", $_POST["newpw"])) {
	$_SESSION["error"] = "Password must include at least one letter, CAPS, number, and special character.";
	header("Location: ../myaccount.php?id=Account_Privacy");
	exit();
}

require_once '../config/setup.php';
try {
	$oldpw = hash("whirlpool", $_POST['oldpw']);
	$newpw = hash("whirlpool", $_POST['newpw']);
	$login = $_SESSION['loggued_on_user'];
	// search for user data
	$check_db = "SELECT * FROM users WHERE login LIKE ? AND passwd LIKE ?";
	$sql = $conn->prepare($check_db);
	$sql->execute(array($login, $oldpw));
	if ($sql->fetch()) {
		$replace = $conn->prepare("UPDATE users SET passwd=? WHERE login=? AND passwd=?");
		$replace->execute(Array($newpw, $login, $oldpw));
		$_SESSION["error"] = "Update Complete.";
		header('Location: ../myaccount.php?id=Account_Privacy');
		exit();
	}
	else {
		echo "SESSION ERROR\n";
		$_SESSION["error"] = "Your Old Password does not match!";
		header ('Location: ../myaccount.php?id=Account_Privacy');
		exit();
	}
} catch(PDOException $e) {
echo $sql . "<br>" . $replace . "<br>" . $e->getMessage();
}

?>