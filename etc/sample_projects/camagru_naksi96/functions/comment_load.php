<?php
	header("Content-Type: application/json");
	$data = json_decode(stripcslashes(file_get_contents('php://input')));
	require_once '../config/setup.php';
	try {
		$sql = $conn->prepare("SELECT * from comments WHERE img_id=?");
		$sql->execute(Array($data->img_id));
		if ($comments = $sql->fetchAll()){
			echo json_encode($comments);
		}
	} catch(PDOException $e) {
		echo $e->getMessage();
	}
?>