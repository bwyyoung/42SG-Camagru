<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	header("Content-Type: application/json");
	$data = json_decode(stripcslashes(file_get_contents('php://input')));
	require_once '../config/setup.php';
	try {
		if ($data->num_load)
		{
			$load_from = $data->num_load * $data->num_post;
		} else {
			$load_from = (int)$data->num_load;
		}
		$load_amount = (int)$data->num_post;
		$sql = $conn->prepare("SELECT id, img, login, 
							(SELECT count(id) FROM likes AS l WHERE l.img_id=p.id) AS count_likes, 
							(SELECT count(id) FROM comments AS c WHERE c.img_id=p.id) AS count_comments
							FROM posts AS p ORDER BY id DESC LIMIT $load_from, $load_amount");
		$sql->execute();
		if ($posts = $sql->fetchAll()) {
			echo json_encode($posts);
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>