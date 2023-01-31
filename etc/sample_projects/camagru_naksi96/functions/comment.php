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
	require_once 'email.php';
	if(isset($data->img_id) && $data->img_id && isset($data->login) && $data->login && isset($data->comment) && $data->comment) {
		try {
			$sql = $conn->prepare("INSERT INTO comments (img_id, login, comment)
									VALUES (?, ?, ?)");
			$sql->execute(Array($data->img_id, $data->login, $data->comment));
			$store_count_num = $conn->prepare("SELECT * FROM comments WHERE img_id=?");
			$store_count_num->execute(Array($data->img_id));
			$counter = count($store_count_num->fetchAll());
			$pic_info = $conn->prepare("SELECT * FROM posts WHERE id=?");
			$pic_info->execute(Array($data->img_id));
			if ($get_userlogin = $pic_info->fetch()) {
				$user_info = $conn->prepare("SELECT * FROM users WHERE login=?");
				$user_info->execute(Array($get_userlogin['login']));
				if ($email_info = $user_info->fetch()) {
					if ($email_info['notification'] == 1) {
						email_comment_alert($email_info['email'], $email_info['login'], $data->login);
					}
				} else {
					header('../');
					exit();
				}
			} else {
				header('../');
				exit();
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
	}
	echo $counter;
	}
?>