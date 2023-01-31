<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}

	session_start();
	if (!$_POST['submit'] === 'Save changes') {
		echo "ERROR\n";
		$_SESSION["error"] = "Unknown approach!";
		header("Location: ../myaccount.php?id=notification");
		exit();
	}
	
	require_once '../config/setup.php';
	try {
		$notification = (isset($_POST['mobile_noti']) && $_POST['mobile_noti'] === 'on') ? 1 : 0;
		$login = $_SESSION['loggued_on_user'];
		$sql = $conn->prepare("UPDATE users SET notification=? WHERE login=?");
		$sql->execute(array($notification, $login));
		header('Location: ../myaccount.php?id=notification');
		exit();
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
?>