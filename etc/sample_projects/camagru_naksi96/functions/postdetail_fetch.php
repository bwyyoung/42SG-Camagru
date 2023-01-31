<?php
	// protection from direct access
	if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	function get_num_likes($img_id, $conn) {
		try {
			$sql = $conn->prepare("SELECT * from likes WHERE img_id=?");
			$sql->execute(Array($img_id));
			$count = count($sql->fetchAll());
			return $count;
		} catch(PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}

	function check_liked($img_id, $login, $conn) {
		try {
			$sql = $conn->prepare("SELECT * from likes WHERE img_id=? AND login=?");
			$sql->execute(Array($img_id, $login));
			if ($sql->fetch()) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		} catch(PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}
	
	function load_image($img_id, $conn) {
		try {
			$sql = $conn->prepare("SELECT * FROM posts WHERE id=?");
			$sql->execute(Array($img_id));
			if ($val = $sql->fetch()) {
				$rtn['postdate'] = $val['postdate'];
				$rtn['img'] = $val['img'];
				$rtn['login'] = $val['login'];
				return ($rtn);
			}
			else {
				header ('Location: /');
				exit();
			}
		} catch(PDOException $e) {
			echo $sql ."<br>" . $e->getMessage();
		}
	}

	function get_num_comments($img_id, $conn) {
		try {
			$sql = $conn->prepare("SELECT * from comments WHERE img_id=?");
			$sql->execute(Array($img_id));
			$count = count($sql->fetchAll());
			return $count;
		} catch(PDOException $e) {
			echo $sql . "<br>" . $e->getMessage();
		}
	}
?>