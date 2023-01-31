<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	session_start();
	if (!isset($_SESSION['loggued_on_user'])) {
		header("Location: ../login.php");
		exit();
	}
	if (!isset($_POST['upload']) || !isset($_POST['submit'])) {
		$_SESSION['error'] = "Cannot upload this image";
		header("Location: ../upload.php");
		exit();
	}
	if (!$_POST['upload'] || $_POST['upload'] == "") {
		$_SESSION['error'] = "Nothing to upload!";
		header("Location: ../upload.php");
		exit();
	}
	$img = $_POST['upload'];
	if (!file_exists("../upload/"))
		mkdir ("../upload/");
	$folderPath = "../upload/";
	// actual code
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
	$image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
	$file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
	//print_r($fileName);
	require_once '../config/setup.php';
	try {
		date_default_timezone_set('America/Los_Angeles');
		$login = $_SESSION['loggued_on_user'];
		$date = date('Y-m-d H:i:s', time());
		$sql = $conn->prepare("INSERT INTO posts (login, img, postdate)
								VALUES (?, ?, ?)");
		$sql->execute(Array($login, $file, $date));
		$index = 0;
		while (isset($_SESSION['img_tmp'][$index]) && $_SESSION['img_tmp'][$index]){
			unset($_SESSION['img_tmp'][$index]);
			$index++;
		}
		echo "<script type=\"text/javascript\">";
		echo "alert('Image uploaded successfully!');";
		echo "window.location = ('../');";
		echo "</script>";
		exit();
	} catch(PDOException $e) {
	echo $sql ."<br>" . $e->getMessage();
	}
?>
