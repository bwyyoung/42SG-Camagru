<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	session_start();
	header("Content-Type: application/json");
	$data = json_decode(stripcslashes(file_get_contents('php://input')));
	require_once '../config/setup.php';
	
	try {
		$checker = $conn->prepare("SELECT * FROM likes WHERE img_id=? AND login=?");
		$checker->execute(Array($data->img_id, $data->login));
		if ($val = $checker->fetch()) {
			$unlike = $conn->prepare("DELETE FROM likes WHERE img_id=? AND login=?");
			$unlike->execute(Array($data->img_id, $data->login));
		} else {
			$like = $conn->prepare("INSERT INTO likes (img_id, login)
									VALUES (?, ?)");
			$like->execute(Array($data->img_id, $data->login));
		}
		$store_like_num = $conn->prepare("SELECT * FROM likes WHERE img_id=?");
		$store_like_num->execute(Array($data->img_id));
		$counter = count($store_like_num->fetchAll());
	} catch(PDOException $e) {
	echo $e->getMessage();
	}
	echo $counter;
?>