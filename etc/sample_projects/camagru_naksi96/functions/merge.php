<?php
	// protection from direct access
	if ($_SERVER['REQUEST_METHOD'] !='POST' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	session_start();
	if (!file_exists("../tmp/"))
		mkdir ("../tmp/");
    $folderPath = "../tmp/";
	$sourceImage = $_POST['source'];
	$img = $_POST['test'];
	$image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
	$destImage = base64_decode($image_parts[1]);
	$fileName = uniqid() . '.png';
	$file = $folderPath . $fileName;
	file_put_contents($file, $destImage);
	$destImage = $file;
	list($srcWidth, $srcHeight) = getimagesize($sourceImage);
	list($destWidth, $destHeight) = getimagesize($destImage);
	$src = imagecreatefrompng($sourceImage);
	$dest = imagecreatefrompng($destImage);

	//$tmppp = $destWidth . "," . $destHeight . "," . $srcHeight . "," .$srcWidth;
	//file_put_contents('tmp.txt', $tmppp);
	$src_xPos = ($destWidth - $srcHeight) / 2;
	$src_yPos = ($destHeight - $srcHeight) / 2;

	$src_cropXPos = 0;
	$src_cropYPos = 0;

	imagecopy($dest, $src, $src_xPos, $src_yPos, $src_cropXPos, $src_cropYPos, $srcWidth, $srcHeight);
	imagepng($dest, $file);
	$type = pathinfo($file, PATHINFO_EXTENSION);
	$tmp = file_get_contents($file);
	$preview = 'data:image/' . $type . ';base64,' . base64_encode($tmp);
	imagedestroy($src);
	imagedestroy($dest);
	$index = 0;
	while (isset($_SESSION['img_tmp'][$index]) && $_SESSION['img_tmp'][$index])
	{
		$index++;
	}
	$_SESSION['img_tmp'][$index] = $preview;
	$return_pos = $_POST['return_id'];
	header("Location: ../upload.php?id=$return_pos");
	unlink($file);
?>