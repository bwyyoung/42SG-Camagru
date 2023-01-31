<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	session_start();
	if (!isset($_POST['img_id']) || !$_POST['img_id']) {
		header('Location: ../');
		exit();
	}
	if (!isset($_POST['post_login']) || !$_POST['post_login'] || $_POST['post_login'] !== $_SESSION['loggued_on_user']) {
		header('Location: ../');
		exit();
	}
	require_once '../config/setup.php';
	try {
		$file_del = $conn->prepare("SELECT * FROM posts WHERE id=? AND login=?");
		$file_del->execute(Array($_POST['img_id'], $_SESSION['loggued_on_user']));
		$file = $file_del->fetch();
		unlink($file['img']);
		$post_del = $conn->prepare("DELETE FROM posts WHERE id=? AND login=?");
		$post_del->execute(Array($_POST['img_id'], $_SESSION['loggued_on_user']));
		header('Location: ../');
		exit();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>